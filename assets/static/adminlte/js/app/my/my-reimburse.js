
(function ($, DataTable) {
	if ( ! DataTable.ext.editorFields ) {
		DataTable.ext.editorFields = {};
	}
	
	var Editor = DataTable.Editor;
	var _fieldTypes = DataTable.ext.editorFields;
	
	
})(jQuery, jQuery.fn.dataTable);

$(document).ready(function() {

	debug('my/reimburse.js loaded');

	var Reim;
	var Reim_CONTAINER_SELECTOR    = '#reim-editor';
	
	var ReimDtl;
	var ReimDtl_CONTAINER_SELECTOR = '#reim-dtl-editor';
	
	var numberRenderer = $.fn.dataTable.render.number( '.', ',', 0, 'Rp ' ).display;
	
	/* Reim */
	
	function selectRowReim( e, dt, node, config ) {
	
		if ( ! dt ) return;
		
		destroyDatatable(ReimDtl_CONTAINER_SELECTOR);
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var tkId = rows[0].sip_reimburse_tickets.id;
		
		OpenReimDtlWindow('/my/my_reimburse/get_dtl/' + tkId, tkId);
		$('#change-log').empty().html('Waiting for data');
	}

	function deselectRowReim( e, dt, node, config ) {
		destroyDatatable(ReimDtl_CONTAINER_SELECTOR);
		$('#change-log').empty().html('Waiting for data');
	}
	
	var Reim_Config = {
		CONTAINER_SELECTOR: Reim_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
		
			ajax: { url: "/my/my_reimburse/get", type: 'POST' },
			table: Reim_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Status:',
					name: 'sip_reimburse_tickets.status',
					type: 'radio',
					separator: "|",
					def: 'open',
					options: [
						{ label: '<i class="fa fa-unlock"></i> Open', value: 'open' },
						//{ label: '<i class="fa fa-lock"></i> Closed', value: 'closed' },
					],
					fieldInfo: 'request status, default value is "OPEN" (required)',
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: "/my/my_reimburse/get", type: 'POST' },
			disableButtons: false,
			disableEditButton: true,
			createTitle: 'Create a new Request',
			order: [ [ 2, 'desc' ], [ 1, 'desc' ] ],
			columns: [
				{
					data: 'sip_reimburse_tickets.id',
					title: 'Reference Number',
					sClass: 'exportable dt-body-monospace',
					render: function( data, type, row ) {
						return row.sip_reimburse_tickets.id + row.sip_reimburse_tickets.ref_code;
					}
				/*
				}, {
					data: 'sip_users.first_name',
					title: 'PIC'
				}, {
					data: 'sip_reimburse_tickets.user_id',
					title: 'User ID',
					visible: false,
				*/
				}, {
					data: 'sip_reimburse_tickets.status',
					title: 'Status',
					sClass: 'exportable nowrap',
					render: function ( data, type, row ) {
						if ( type === 'display' ) {
							if ( data == 'open' ) {
								return '<i class="fa fa-fw fa-unlock"></i> '+
									data.charAt(0).toUpperCase() + data.substr(1);
							} else {
								return '<i class="fa fa-fw fa-lock"></i> '+
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
				}
			],
			rowCallback: function ( row, data ) {
				// Set the checked state of the checkbox in the table
				$('input.editor-active', row).prop( 'checked', data.sip_reimburse_tickets.status == 'closed' );
			},
			createdRow: function ( row, data, index ) {
				if ( data.sip_reimburse_tickets.status == 'open' ) {
				} else if ( data.sip_reimburse_tickets.status == 'closed' ) {
					$('td', row).eq(2).addClass('bg-lightgreen');
				}
			}
		}
	};
	
	var Reim = InitDatatableEditor( Reim_Config );
	
	Reim.datatable.on('select', selectRowReim);
	Reim.datatable.on('deselect', deselectRowReim);
	
	
	/* ReimDtl */
	function selectRowReimDtl( e, dt, node, config ) {
	
		if ( ! dt ) return;

		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var tkId = rows[0].sip_reimburse_tickets_dtl.ticket_id;
		var tkDtlId = rows[0].sip_reimburse_tickets_dtl.id;

		//OpenChangeLogWindow('/officeadm/reimburse/get_change_log/' +tkId+'/'+tkDtlId);
	}
	
	function deselectRowReimDtl( e, dt, node, config ) {
		$('#change-log').empty().html('Waiting for data');
	}
	
	function OpenReimDtlWindow(url, tkId) {
		var ReimDtl_Config = {
			CONTAINER_SELECTOR: ReimDtl_CONTAINER_SELECTOR,
			EDITOR_CONFIG: {
				ajax: url,
				table: ReimDtl_CONTAINER_SELECTOR,
				fields: [
					{
						label: "Ticket ID",
						name: "sip_reimburse_tickets_dtl.ticket_id",
						def: tkId,
						type: "hidden",
					}, {
						label: "Date:",
						name: "sip_reimburse_tickets_dtl.date",
						type: "datetime",
						opts: {
							locale: 'id',
						},
						format: "DD-MM-YYYY HH:mm",
						def: function () { return new Date(); },
						fieldInfo: 'input date of transaction (required)',
					}, {
						label: "Notes:",
						name: "sip_reimburse_tickets_dtl.notes",
						type: "textarea",
						fieldInfo: 'input request note (required)',
					}, {
						label: "Type:",
						name: "sip_reimburse_tickets_dtl.type",
						def: 'Reimburse',
						type: 'select2',
						opts: {
							placeholder: "Select Type",
							templateSelection: select2dropdownFormat,
							templateResult: select2dropdownFormat,
							dropdownAutoWidth: true,
						},
						fieldInfo: 'choose a request type (required)',
					}, {
						label: "Quantity",
						name: "sip_reimburse_tickets_dtl.qty",
						type: 'text',
						attr: {
							type: 'number',
							class: 'text-right',
						},
						def: 1,
						fieldInfo: 'input quantity (required)',
					}, {
						label: "Price",
						name: "sip_reimburse_tickets_dtl.amount",
						type: "text",
						attr: {
							class: "currency mask text-right",
						},
						def: 0,
						fieldInfo: 'input unit price (required)',
					}, {
						label: "Receipt:",
						name: "sip_reimburse_receipts[].id",
						type: "uploadMany",
						display: function ( fileId, counter ) {
                            console.log(fileId);
							//return 'Preview not available (ongoing fix)';
							
							//debug(ReimDtl.editor.files());
                            //return;
							//debug(ReimDtl.editor.file( 'sip_reimburse_receipts', fileId ));
							//debug(ReimDtl.editor.file('sip_reimburse_receipts', fileId).img_path);
							if ( ReimDtl.editor.file('sip_reimburse_receipts', fileId).thumbnail_path != undefined ) {
								return '<img class="img-thumbnail" src="/'+ReimDtl.editor.file( 'sip_reimburse_receipts', fileId ).thumbnail_path+'"/>';
							} else {
								return 'Attachment ID#: ' + fileId + ' (preview not available)';
							}
						},
						fieldInfo: 'upload receipt(s) (required)',
						noFileText: 'No receipt uploaded yet'
					}
				]
				
			},
			DATATABLE_CONFIG: {
				ajax: {
					url: url,
					type: 'POST',
					data: function ( d ) {
						d.ticket_id = tkId;
					},
					complete: function() {
						$(".html5lightbox").html5lightbox();
					}
				},
				createTitle: 'Create a new Request item',
				editTitle: 'Edit Request item',
				order: [ [ 1, 'asc' ] ],
				disableButtons: false,
                scroller: false,
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
						sClass: 'dt-body-center dt-body-capitalize nowrap',
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
								return '<i class="fa '+icon+'"></i> '+data;
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
						render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp '),
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
						render: function ( d, t, r ) {
							if( !d.length ) {
								return 'No receipt';
							}
							str_val = '';
							for( i = 0; i < d.length; i++ ) {
								str_val += '<a href="/'+d[i].img_path+'"  class="html5lightbox" title="Receipt for request items #: '+r.sip_reimburse_tickets_dtl.id+'" data-group="receipts-'+r.sip_reimburse_tickets_dtl.id+'" data-thumbnail="/'+d[i].thumbnail_path+'">' +
											//'<i class="fa fa-file-image-o"></i> ' +
											'<img class="img-thumbnail" src="/'+d[i].thumbnail_path+'" class="with-border">' +
										'</a>';
							}
							return str_val;
						}
					}
				],
				initComplete: function () {
					//debug( ReimDtl.datatable.files( 'sip_reimburse_receipts' ) );
				},
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
		
		ReimDtl = InitDatatableEditor( ReimDtl_Config );
		$(".html5lightbox").html5lightbox();
		
		ReimDtl.datatable.on('select', selectRowReimDtl);
		ReimDtl.datatable.on('deselect', deselectRowReimDtl);
		ReimDtl.editor.on('open', function() {
			/*
			//return;
			debug('open');
			//$('.mask').mask('Rp 000.000.000.000.000,-', {reverse: true});
			//$('.currency.mask').mask("#.##0", {reverse: true});
			var a = $('.currency.mask');
			a.inputmask({
				//'customAmount': {
					alias: 'decimal',
					groupSeparator: '.',
					autoGroup: true,
					removeMaskOnSubmit: true,
					//numericInput: true,
					rightAlign: true,
					radixPoint: ',',
					allowPlus: false,
					allowMinus: false,
					max: '49999999',
					autoUnmask: true,
					clearMaskOnLostFocus: true,
				//}
			});
			*/


		});
		ReimDtl.editor.on('preSubmit', function( e, o, a) {
			debug('Pre Submit');
			
			var amt = ReimDtl.editor.field('sip_reimburse_tickets_dtl.amount');
			var amount = parseInt([amt.val().split('.').join('')]);
			
			debug(amount);
			amt.val(amount);
			
			if ( amount <= 0 ) {
				amt.error('Price value must be greater than 0');
			}

			if ( a == 'create' ) {
				//o.data[0].sip_reimburse_tickets_dtl.amount = amount;
			}
			
			var receipts = ReimDtl.editor.field('sip_reimburse_receipts[].id');
			if ( ! receipts.isMultiValue() ) {
				if ( receipts.val().length === 0 ) {
					receipts.error( 'Please upload a receipt' );
				}
			}
			
			if ( this.inError() ) {
				return false;
			}
			
		});
		ReimDtl.editor.on('postSubmit', function() {
			debug('Post Submit');
			deselectRowReimDtl();
		});

		
	}

});
