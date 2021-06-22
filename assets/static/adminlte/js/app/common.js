String.prototype.capitalize = function(){
    return this.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
};

$TASK_TYPE_ICONS = new Array();
$TASK_TYPE_ICONS['Common'            ] = 'vidCommon'; //'fa-desktop';'fa-desktop';
$TASK_TYPE_ICONS['Coverage'          ] = 'vidCoverage'; //'fa-video-camera'; //'fa-building';'fa-building';
$TASK_TYPE_ICONS['Interview'         ] = 'vidInterview'; //'fa-microphone'; //'fa-phone';'fa-phone';
$TASK_TYPE_ICONS['Writing'           ] = 'vidWriting'; //'fa-pencil';'fa-pencil';
$TASK_TYPE_ICONS['Photo'             ] = 'vidPhoto'; //'fa-camera';'fa-camera';
$TASK_TYPE_ICONS['Editing'           ] = 'vidEditing'; //'fa-edit';'fa-edit';
$TASK_TYPE_ICONS['Design'            ] = 'vidDesign'; //'fa-image';'fa-image';
$TASK_TYPE_ICONS['Others'            ] = 'vidOthers'; //'fa-check';'fa-check';
$TASK_TYPE_ICONS['Meeting'           ] = 'vidMeeting'; //'fa-briefcase';'fa-briefcase';
$TASK_TYPE_ICONS['Marketing'         ] = 'vidMarketing'; //'fa-bullhorn'; //'fa-dollar';'fa-dollar';
$TASK_TYPE_ICONS['Presentation'      ] = 'vidPresentation'; //'fa-film';'fa-film';
$TASK_TYPE_ICONS['Contact Report'    ] = 'vidContact-Report'; //'fa-hand-o-right';'fa-hand-o-right';
$TASK_TYPE_ICONS['Follow Up'         ] = 'vidFollow-Up'; //'fa-hand-o-up';'fa-hand-o-up';
$TASK_TYPE_ICONS['BAST'              ] = 'vidBAST'; //'fa-angle-double-right';'fa-angle-double-right';
$TASK_TYPE_ICONS['QC'                ] = 'vidQC'; //'fa-arrow-right';'fa-arrow-right';
$TASK_TYPE_ICONS['Final QC'          ] = 'vidFinal-QC'; //'fa-arrows-alt';'fa-arrows-alt';
$TASK_TYPE_ICONS['Deliver'           ] = 'vidDeliver'; //'fa-truck';'fa-truck';
$TASK_TYPE_ICONS['Production'        ] = 'vidProduction'; //'fa-trophy';'fa-trophy';

function getSelectedRow(e, dt, node, config) {
	var selected = dt.rows( { selected: true } );
	return selected;	
}

function destroyDatatable(_) {
	if ( $.fn.dataTable.isDataTable( _ ) ) {
		debug('Destroying: ' + _ );
		/*
		$(_ + ' tbody tr').each(function() {
			$(this).empty().remove();
		});
		*/
		
		$(_ + ' tbody').remove();
		
		__datatable = $( _ ).DataTable();
		__datatable.clear().draw();
		__datatable.destroy();
	}

	//$(_).empty();
	//$(_ + ' tbody').empty();
	
	
}

function destroyChart(_) {
	if ( _ && _.chart != null ) {
		debug('Destroying:' + _.CONTAINER_SELECTOR);
		$('#'+_.CONTAINER_SELECTOR).empty();
		//_.chart.destroy();
		
	}
}

function formatLocalDate( data, fmt = 'D-MMM-YY HH:mm' ) {
	
	if( data ) {
		//debug('formatLocalDate: ' + data);
		return (moment(data, 'DD-MM-YYYY HH:mm').format(fmt, 'id'));
	} else
		return data;
}

function timestampToDate( data ) {
	
	if( data ) {
		//debug('timestampToDate: ' + data);
		return (moment.unix(data).format("DD/MM/YYYY HH:mm:ss", 'id'));
	} else
		return data;
}

function select2dropdownFormat( data, container ) {
	return $('<span>'+data.text+'</span>');
}

var InitDatatableEditor;
var PieChart;
var BarChart;
var html5lightbox_options = {
	stamp: false,
	watermark: "/assets/static/img/logo-200x50.png",
	watermarklink: "//www.mediavista.id",
};

(function ($, window, undefined) {
	
	var __editorDOM = "" +
		"<'row'<'col-sm-9'B><'col-sm-3 custom-buttons'>><'clear'>" +
		"<'row'<'col-sm-4'l><'col-sm-8'f>><rt><'row'<'col-sm-5'i><'col-sm-7'p>>";
		
	var __editorDOM__noButtons = "" +
		"<'row'<'col-sm-4'l><'col-sm-8'f>><rt><'row'<'col-sm-5'i><'col-sm-7'p>>";
		
	var __exportOptions = { columns: [':visible.exportable' ] };
		
	InitDatatableEditor = function ( oConfig ) {
		
		var canEdit = oConfig.EDITOR_CONFIG ? true : false;
		
		var __editor = null;
		if( canEdit ) {
			
			oConfig.EDITOR_CONFIG.formOptions = { main: { focus: null } };
			__editor = new $.fn.dataTable.Editor( oConfig.EDITOR_CONFIG );
		
			/* Activate inline editing */
			$( oConfig.CONTAINER_SELECTOR ).on( 'click', 'tbody td.editable', function (e) {
				__editor.inline( this, {
					submitOnBlur: false,
					buttons: { label: '<i class="fa fa-save"></i>', fn: function () { this.submit(); }, className: 'square tn-sm' },
				});
			});
		}
		
		/* Destroy existing datatable */
		destroyDatatable( oConfig.CONTAINER_SELECTOR );

		//$.fn.dataTable.ext.classes.sPageButton = 'btn-pagination';
		
		/* Set General datatable configuration options */
		(function(cfg) {
			cfg.processing = true;
			cfg.serverSide = cfg.serverSide === false ? cfg.serverSide : true;
			cfg.extensions = 'Responsive';
			cfg.responsive = oConfig.DATATABLE_CONFIG.responsive === false ? false : true;
			cfg.sorting = true;
			cfg.dom = cfg.disableButtons ? __editorDOM__noButtons : __editorDOM;
			cfg.pagingType = 'full_numbers'; // numbers, simple, simple_numbers, full, full_numbers, first_last_numbers
			cfg.lengthMenu = [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ];
			cfg.language = {
				paginate : {
					first: '<i class="fa fa-fast-backward"></i>',
					previous: '<i class="fa fa-step-backward"></i>',
					next: '<i class="fa fa-step-forward"></i>',
					last: '<i class="fa fa-fast-forward"></i>',
				}
			};
            cfg.mark = true;
			
			cfg.select = cfg.select ? cfg.select : {
				style: 'os',
				selector: 'td:first-child',
				blurable: false,
				sClass: 'row-selector'
			};

			/* Defined default buttons */
			if(cfg.disableButtons){
				cfg.buttons = new Array();
			} else {
				cfg.buttons = new Array();
				
				cfg.buttons.push({ text: '<i class="fa fa-refresh"></i>', className: 'reload', titleAttr: 'Reload', action: function ( e, dt, node, config ) { dt.ajax.reload(); } });
				
				if ( canEdit ) {
                    
                    if (cfg.canCreate !== false) {
					   cfg.buttons.push({ extend: 'create', text: '<i class="fa fa-plus"></i>', className: 'create', titleAttr: 'Create', editor: __editor, formTitle: cfg.createTitle ? cfg.createTitle : null });
                    }
					
					if ( oConfig.EDITOR_CONFIG.canRemove ) {
						cfg.buttons.push({ extend: 'remove', text: '<i class="fa fa-minus"></i>', className: 'remove', titleAttr: 'Remove', editor: __editor, formTitle: cfg.removeTitle ? cfg.removeTitle : null });
					}
					
					if ( !cfg.disableEditButton ) {
						cfg.buttons.push({ extend: 'edit', text: '<i class="fa fa-edit"></i>', className: 'edit', titleAttr: 'Edit', editor: __editor, formTitle: cfg.editTitle ? cfg.editTitle : null });
					}
				}
				
				if(cfg.print!=false) cfg.buttons.push({ extend: 'print', text: '<i class="fa fa-print"></i>', className: 'printButton', titleAttr: 'Print', exportOptions: __exportOptions });
				if(cfg.copy!=false) cfg.buttons.push({ extend: 'copyHtml5', text: '<i class="fa fa-copy"></i>', className: 'copyButton', titleAttr: 'Copy', exportOptions: __exportOptions });
				if(cfg.csv==true) cfg.buttons.push({ extend: 'csv', text:'<i class="fa fa-file-csv"></i>', className: 'csvButton', titleAttr: 'CSV', exportOptions: __exportOptions });
				if(cfg.xls!=false) cfg.buttons.push({ extend: 'excelHtml5', text: '<i class="fa fa-file-excel-o"></i>', className: 'excelButton', titleAttr: 'Excel', exportOptions: __exportOptions });
				if(cfg.pdf!=false){
					var oButtonPDFConfig = {
						text: '<i class="fa fa-file-pdf-o"></i>',
						extend: 'pdfHtml5',
						className: 'pdfButton',
						titleAttr: 'PDF',
						_download: 'open',
						exportOptions: __exportOptions,
						_customize: function(doc) {
							var colCount = new Array();
							for(i=0; i<doc.content[1].table.body[0].length; i++) {
								colCount.push('*');
							}
							doc.content[1].table.widths = colCount;
						},
						orientation: 'landscape',
                		pageSize: 'A4',
					};
					cfg.buttons.push(oButtonPDFConfig);
				}
				cfg.buttons.push({ extend: 'colvis', text: '<i class="fa fa-columns"></i>', className: 'colvisButton', titleAttr: 'Columns' });
			}
			
			/* Set default ordering to 2nd column (2nd column array index is [1]) */
			cfg.ordering = cfg.ordering === false ? false : true;
			if ( cfg.ordering && !cfg.order ) {
				cfg.order = [ [ 1, 'asc' ] ]
			}
			cfg.searching = true;
			cfg.paging = true;
			/* Apply row check-box selector in 1st column */
			if ( cfg.serverSide ) {
				cfg.columns.unshift( { data: null, defaultContent: '', orderable: false, searchable: false, className: 'select-checkbox' } );
			}
			
			if ( cfg.scroller !== false ) {
				cfg.scrollY = 300;
				cfg.deferRender = true;
				cfg.scroller = true;
			}
			
		}(oConfig.DATATABLE_CONFIG));
		
		__datatable = $( oConfig.CONTAINER_SELECTOR ).DataTable( oConfig.DATATABLE_CONFIG );
		
		if($.fn.html5lightbox){
			$(".html5lightbox").html5lightbox();
		}
		
		/* Apply custom button (if available) to datatable */
		(function(cfg) {
			if (cfg.customButtons ) {
				var __customButtons = new $.fn.dataTable.Buttons( __datatable, { buttons: cfg.customButtons } );
				__datatable.buttons( 1, null ).container().appendTo( $('.custom-buttons', __datatable.table().container() ) );
			}
		}(oConfig.DATATABLE_CONFIG));
		
		return { editor: __editor, datatable: __datatable };
	}
	
})(jQuery, window);


if (typeof google !== 'undefined') {
	// Load the Visualization API and the piechart package.
	google.charts.load('current', {'packages':['corechart']});
}

// Set a callback to run when the Google Visualization API is loaded.
//google.charts.setOnLoadCallback(drawChart);
      
function drawChart() {
	
	var jsonData = $.ajax({
		url: "/editorial/workspace/get_workload_chart/38",
		dataType: "json",
		async: true,
		success: function(response) {
			debug(response);
			var data = new google.visualization.DataTable(response);
			
			var options = {
				title: 'Workload Activities',
				is3D: true,
			};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('task-workload-chart'));
			chart.draw(data, options);
			
			
		}
	});	
}

function googleChart(_) {
	debug('googleChart:'+_.url);
	return;
	//debug(document.getElementById(_.CONTAINER_SELECTOR));
	$.ajax({
		url: _.url,
		dataType: 'json',
		type: _.type ? _.type : null,
		data: _.data ? _.data : null,
		async: true,
		success: function(response) {
			debug(response);
			
			var data = new google.visualization.DataTable(response);
			
			if ( _.opts.is3D || _.opts.pieHole ) {
				_.chart = new google.visualization.PieChart(document.getElementById(_.CONTAINER_SELECTOR));
				_.chart.draw(data, _.opts);
			}
			
			if ( _.opts.seriesType == 'bars' ) {
				_.chart = new google.visualization.ComboChart(document.getElementById(_.CONTAINER_SELECTOR));
				_.chart.draw(data, _.opts);
			}
		},
		error: function(response) {
			debug('googleChart error');
			debug(response);
		}
	});
	
	return _;
}







