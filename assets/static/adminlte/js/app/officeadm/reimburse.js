
(function ($, DataTable) {
 
	if ( ! DataTable.ext.editorFields ) {
		DataTable.ext.editorFields = {};
	}
	 
	var Editor = DataTable.Editor;
	var _fieldTypes = DataTable.ext.editorFields;
	 
	_fieldTypes.ReimDtlMgr_status = {
		create: function ( conf ) {
			var that = this;
	 
			conf._enabled = true;
	 
			// Create the elements to use for the input
			conf._input = $(
				'<div id="'+Editor.safeId( conf.id )+'">'+
					'<button class="inputButton btn-process" value="process"><i class="fa fa-fw fa-arrow-circle-o-right"></i> Process</button>'+
					'<button class="inputButton btn-approved" value="approved"><i class="fa fa-fw fa-check-circle-o"></i> Approved</button>'+
					'<button class="inputButton btn-rejected" value="rejected"><i class="fa fa-fw fa-ban"></i> Rejected</button>'+
					'<button class="inputButton btn-canceled" value="canceled"><i class="fa fa-fw fa-times-circle"></i> Canceled</button>'+
					'<button class="inputButton btn-completed" value="completed"><i class="fa fa-fw fa-check-square-o"></i> Completed</button>'+
				'</div>');
	 
			// Use the fact that we are called in the Editor instance's scope to call
			// the API method for setting the value when needed
			$('button.inputButton', conf._input).click( function () {
				if ( conf._enabled ) {
					that.set( conf.name, $(this).attr('value') );
				}
	 
				return false;
			} );
	 
			return conf._input;
		},
	 
		get: function ( conf ) {
			return $('button.selected', conf._input).attr('value');
		},
	 
		set: function ( conf, val ) {
			$('button.selected', conf._input).removeClass( 'selected' );
			$('button.inputButton[value='+val+']', conf._input).addClass('selected');
		},
	 
		enable: function ( conf ) {
			conf._enabled = true;
			$(conf._input).removeClass( 'disabled' );
		},
	 
		disable: function ( conf ) {
			conf._enabled = false;
			$(conf._input).addClass( 'disabled' );
		}
	};
 
})(jQuery, jQuery.fn.dataTable);



$(document).ready(function() {

	debug('officeadm/reimburse.js loaded');

	var ReimMgr;
	var ReimMgr_CONTAINER_SELECTOR    = '#reim-mgr-editor';
	
	var ReimDtlMgr;
	var ReimDtlMgr_CONTAINER_SELECTOR = '#reim-dtl-mgr-editor';
	
	var Receipts;
	var Receipts_CONTAINER_SELECTOR = '#receipts-items';
	
	var numberRenderer = $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ).display;
	
	/* ReimMgr */
	
	function selectRowReimMgr( e, dt, node, config ) {
	
		if ( ! dt ) return;
		
		//destroyDatatable(ReimDtlMgr_CONTAINER_SELECTOR);
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var tkId = rows[0].sip_reimburse_tickets.id;
		
		OpenReimDtlWindow('/officeadm/reimburse/get_dtl/' + tkId);
		$('#change-log').empty().html('Waiting for data');
	}

	function deselectRowReimMgr( e, dt, node, config ) {
		destroyDatatable(ReimDtlMgr_CONTAINER_SELECTOR);
		$('#change-log').empty().html('Waiting for data');
	}
	
	var ReimMgr_Config = {
		CONTAINER_SELECTOR: ReimMgr_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
		
			ajax: { url: "/officeadm/reimburse/get", type: 'POST' },
			table: ReimMgr_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Status:',
					name: 'sip_reimburse_tickets.status',
					type: 'radio',
					separator: "|",
					options: [
						{ label: '<i class="fa fa-unlock"></i> Open', value: 'open' },
						{ label: '<i class="fa fa-lock"></i> Closed', value: 'closed' },
					]
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: "/officeadm/reimburse/get", type: 'POST' },
			disableButtons: true,
			order: [ [ 4, 'desc' ], [ 1, 'desc' ] ],
			columns: [
				{
					/*data: 'sip_reimburse_tickets.id',
					title: 'ID'
				}, {*/
					data: 'sip_reimburse_tickets.id',
					title: 'Reference Number',
					sClass: 'exportable dt-body-monospace',
					render: function( data, type, row ) {
						return row.sip_reimburse_tickets.id + row.sip_reimburse_tickets.ref_code;
					}
				}, {
					data: 'sip_users.first_name',
					title: 'PIC'
				}, {
					data: 'sip_reimburse_tickets.user_id',
					title: 'User ID',
					visible: false,
				}, {
					data: 'sip_reimburse_tickets.status',
					title: 'Status',
					sClass: 'exportable nowrap',
					render: function ( data, type, row ) {
						if ( type === 'display' ) {
							if ( data == 'open' ) {
								return '<input type="checkbox" class="editor-active"> <i class="fa fa-fw fa-unlock"></i> '+
									data.charAt(0).toUpperCase() + data.substr(1);
							} else {
								return '<input type="checkbox" class="editor-active"> <i class="fa fa-fw fa-lock"></i> '+
									data.charAt(0).toUpperCase() + data.substr(1);
							}
						}
						return data;
					},
				}, {
					data: 'sip_reimburse_tickets.create_at',
					title: 'Created',
					sClass: 'exportable',
					render: $.fn.dataTable.render.moment( 'YYYY-MM-DD HH:mm:ss', 'DD-MMM-YYYY', 'id' ),
				/*}, {
					data: 'sip_reimburse_tickets.update_at',
					title: 'Updated',
					sClass: 'exportable'
				*/
				}
			],
			rowCallback: function ( row, data ) {
				// Set the checked state of the checkbox in the table
				$('input.editor-active', row).prop( 'checked', data.sip_reimburse_tickets.status == 'closed' );
			},
			createdRow: function ( row, data, index ) {
				if ( data.sip_reimburse_tickets.status == 'open' ) {
					//$('td', row).eq(3).addClass('bg-orange');
				} else if ( data.sip_reimburse_tickets.status == 'closed' ) {
					$('td', row).eq(3).addClass('bg-lightgreen');
				}
			}
		}
	};

	var ReimMgr = InitDatatableEditor( ReimMgr_Config );
	
	$(ReimMgr_CONTAINER_SELECTOR).on( 'change', 'input.editor-active', function () {
        ReimMgr.editor
            .edit( $(this).closest('tr'), false )
            .set( 'sip_reimburse_tickets.status', $(this).prop( 'checked' ) ? 'closed' : 'open' )
            .submit();
    } );
	
	ReimMgr.datatable.on('select', selectRowReimMgr);
	ReimMgr.datatable.on('deselect', deselectRowReimMgr);
	
	
	/* ReimDtlMgr */
	function selectRowReimDtlMgr( e, dt, node, config ) {
	
		if ( ! dt ) return;

		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var tkId = rows[0].sip_reimburse_tickets_dtl.ticket_id;
		var tkDtlId = rows[0].sip_reimburse_tickets_dtl.id;

		OpenChangeLogWindow('/officeadm/reimburse/get_change_log/' +tkId+'/'+tkDtlId);
	}
	
	function deselectRowReimDtlMgr( e, dt, node, config ) {
		$('#change-log').empty().html('Waiting for data');
	}
	
	function OpenReimDtlWindow(url) {
		var ReimDtlMgr_Config = {
			CONTAINER_SELECTOR: ReimDtlMgr_CONTAINER_SELECTOR,
			EDITOR_CONFIG: {
				ajax: url,
				table: ReimDtlMgr_CONTAINER_SELECTOR,
				fields: [
					{
						label: "Status:",
						name: "sip_reimburse_tickets_dtl.status",
						type: "ReimDtlMgr_status", // Using the custom field type
						def: 'process',
					}
				]
				
			},
			DATATABLE_CONFIG: {
				ajax: {
					url: url,
					type: 'POST',
					complete: function() {
						$(".html5lightbox").html5lightbox();
					}
				},
				scroller: false,
				order: [ [ 1, 'asc' ] ],
				disableButtons: true,
				columns: [
					{
						data: 'sip_reimburse_tickets_dtl.id',
						title: 'ID',
						sClass: 'dt-body-right',
					}, {
						data: 'sip_reimburse_tickets_dtl.date',
						title: 'Date',
						sClass: 'nowrap',
						//render: $.fn.dataTable.render.moment( 'YYYY-MM-DD HH:mm:ss', 'DD-MMM-YYYY', 'id' ),
					}, {
						data: 'sip_reimburse_tickets_dtl.notes',
						title: 'Notes',
					}, {
						data: 'sip_reimburse_tickets_dtl.type',
						title: 'Type',
						sClass: 'dt-body-center dt-body-capitalize',
					}, {
						data: 'sip_reimburse_tickets_dtl.status',
						title: 'Status',
						sClass: 'dt-body-center dt-body-capitalize nowrap dt-body-pointer',
						render: function(data, type, row) {
							if (type === 'display') {
								icon = 'fa-arrow-circle-o-right';
								switch(data) {
									case 'process':
										icon = 'fa-arrow-circle-o-right';
										break;
									case 'approved':
										icon = 'fa-check-circle-o';
										break;
									case 'canceled':
										icon = 'fa-times-circle';
										break;
									case 'rejected':
										icon = 'fa-ban';
										break;
									case 'completed':
										icon = 'fa-check-square-o';
										break;
								}
								return '<i class="fa '+icon+'"></i> '+data+' <i class="fa fa-pencil fa-fw"></i>';
							}
							return data;
						}
					}, {
						data: 'sip_reimburse_tickets_dtl.qty',
						title: 'Qty',
						sClass: 'dt-body-center nowrap dt-body-monospace',
						render: $.fn.dataTable.render.number( '.', ',', 0, '' ),
					}, {
						data: 'sip_reimburse_tickets_dtl.amount',
						title: 'Unit Price',
						sClass: 'dt-body-right nowrap dt-body-monospace',
						render: numberRenderer,
					}, {
						data: function(row, type, set, meta){
							if(row.sip_reimburse_tickets_dtl.status != 'process' &&
							   row.sip_reimburse_tickets_dtl.status != 'approved') return 0;
							return row.sip_reimburse_tickets_dtl.amount * row.sip_reimburse_tickets_dtl.qty;
						},
						title: 'Open Amount',
						sClass: 'dt-body-right nowrap dt-body-monospace',
						render: numberRenderer,
						searchable: false,
						orderable: false,
					}, {
						data: 'sip_reimburse_receipts',
						title: 'Receipts',
						searchable: false,
						orderable: false,
						render: function ( d ) {
							if( !d.length ) {
								return 'No receipt';
							}
							str_val = '';
							for( i = 0; i < d.length; i++ ) {
								str_val += '<a href="/'+d[i].img_path+'"  class="html5lightbox" title="Receipt for request items #: '+d[0].ticket_dtl_id+'" data-group="receipts-'+d[0].ticket_dtl_id+'" data-thumbnail="/'+d[0].thumbnail_path+'">' +
											'<img class="img-thumbnail" src="/'+d[i].thumbnail_path+'" class="with-border">' +
										'</a>';
							}
							return str_val;
						},
					}
				],
				footerCallback: function(row, data, start, end, display) {
					var api = this.api(), data;
					
					var intVal = function ( i ) {
						return typeof i === 'string' ?
							i.replace(/[\Rp,]/g, '')*1 :
							typeof i === 'number' ?
							i : 0;
					};
					
					total = 0;

					if(api.column(8).data()) {
			
						// Total over all pages
						total = api
							.column( 8 )
							.data()
							.reduce( function (a, b) {
								return intVal(a) + intVal(b);
							}, 0 );
					}

					$('#total').html(numberRenderer(total));
					
				},
				createdRow: function ( row, data, index ) {
					if ( data.sip_reimburse_tickets_dtl.status == 'approved' ) {
						$('td', row).eq(5).addClass('bg-lightblue');
					} else if ( data.sip_reimburse_tickets_dtl.status == 'canceled' ) {
						$('td', row).eq(5).addClass('bg-darkred');
					} else if ( data.sip_reimburse_tickets_dtl.status == 'rejected' ) {
						$('td', row).eq(5).addClass('bg-red');	
					} else if ( data.sip_reimburse_tickets_dtl.status == 'completed' ) {
						$('td', row).eq(5).addClass('bg-lightgreen');
					}
				}
			}
		}
		
		ReimDtlMgr = InitDatatableEditor( ReimDtlMgr_Config );
		$(".html5lightbox").html5lightbox();
		
		ReimDtlMgr.datatable.on('select', selectRowReimDtlMgr);
		ReimDtlMgr.datatable.on('deselect', deselectRowReimDtlMgr);
		ReimDtlMgr.editor.on('postSubmit', function() {
			debug('Post Submit');
			deselectRowReimDtlMgr();
		});
		
		
	}
	$(ReimDtlMgr_CONTAINER_SELECTOR).on( 'click', 'tbody td', function (e) {
		if ( $(this).index() == 5 ) {
			ReimDtlMgr.editor.bubble( this );
		}
	} );
	
	
	/* Change Logs */
	function OpenChangeLogWindow(url) {
		var changeLog = $('#change-log');
		changeLog.empty().html('Loading, please wait...');
		$.ajax({
			url: url,
			dataType: 'json',
			success: function(response) {
				var tmpl = $.templates('#change-log-template');
				var html = tmpl.render(response);
				
				changeLog.html(html);
				
				$(".todo-list").sortable({
					placeholder: "sort-highlight",
					handle: ".handle",
					forcePlaceholderSize: true,
					zIndex: 999999
				});
				
			}
		});
	}
	
});
