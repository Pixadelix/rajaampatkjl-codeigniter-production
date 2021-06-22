//<script><?php restricted(''); ?>

function isEquivalent(a, b) {
    // Create arrays of property names
    var aProps = Object.getOwnPropertyNames(a);
    var bProps = Object.getOwnPropertyNames(b);

    // If number of properties is different,
    // objects are not equivalent
    if (aProps.length != bProps.length) {
        return false;
    }

    for (var i = 0; i < aProps.length; i++) {
        var propName = aProps[i];

        // If values of same property are not equal,
        // objects are not equivalent
        if (a[propName] !== b[propName]) {
            return false;
        }
    }

    // If we made it this far, objects
    // are considered equivalent
    return true;
}

function deepEqual(a, b) {
  if (a === b) return true;

  if (a == null || typeof a != "object" ||
      b == null || typeof b != "object")
    return false;

  var propsInA = 0, propsInB = 0;

  for (var prop in a)
    propsInA += 1;

  for (var prop in b) {
    propsInB += 1;
    if (!(prop in a) || !deepEqual(a[prop], b[prop]))
      return false;
  }

  return propsInA == propsInB;
}

var TICKET_SALES_COLUMNS = [
	{
		data: 'kjl_ticket_sales.id',
		title: 'Rec.ID.',
		visible: false,
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.seq_by_year',
		title: 'Card#',
		visible: false,
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.full_name',
		title: 'Full Name',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.gender',
		title: 'Sex',
		sClass: 'exportable text-center',
		render: function( d, t, r, m ) {
			if ( 'display' === t ) {
				if ( 'Laki-laki' === d || 'Male' === d || 'Man' === d ) {
					return '<i class="fa fa-mars text-aqua"></i>';
				} else if ('Perempuan' === d || 'Female' === d || 'Woman' === d ) {
					return '<i class="fa fa-venus text-pink"></i>';
				}
			}
			return d;
		}
	},
	{
		data: 'kjl_ticket_sales.id_card_type',
		title: 'ID.Type',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.id_card_number',
		title: 'ID Number',
		sClass: 'exportable',
	},
	{
		data: 'sys_countries.name',
		title: 'Country',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.country_id',
		title: 'Country ID',
		visible: false,
	},
	{
		data: 'kjl_ticket_sales.kjl_card_number',
		title: 'Card Number',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.phone',
		title: 'Phone',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.email',
		title: 'Email',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.ticket_start_date',
		title: 'Valid From',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.ticket_expired_date',
		title: 'Expired Date',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.payment_method',
		title: 'Payment Method',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.payment_amount',
		title: 'Payment Amount',
		sClass: 'exportable roboto-mono text-right',
		render: $.fn.dataTable.render.number( '.', ',', 2 ),
	},
	{
		data: 'sys_users.first_name',
		title: 'Entry By',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.create_by',
		title: 'Entry By ID',
		visible: false,
	},
	{
		data: 'kjl_ticket_sales.update_by',
		title: 'Update By ID',
		visible: false,
	},
	{
		data: 'kjl_ticket_sales.update_at',
		title: 'Update at',
		visible: false,
	},
	{
		data: 'kjl_operators.name',
		title: 'Operator',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.operator_id',
		title: 'Operator ID',
		visible: false,
	},
	{
		data: 'kjl_offices.name',
		title: 'Location',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_sales.office_id',
		title: 'Office ID',
		visible: false,
	},
];

var CHANGE_LOG_COLUMNS = Array();
for ( i = 0; i < TICKET_SALES_COLUMNS.length; i++ ) {
	//debug(TICKET_SALES_COLUMNS[i].data);
	var col = TICKET_SALES_COLUMNS[i];
	if ( ! col.data.startsWith('kjl_ticket_sales.') ) {
		continue;
	}
	CHANGE_LOG_COLUMNS.push({
		data: col.data.split('.').pop(),
		title: col.title,
		render: col.render,
		sClass: col.sClass,
	});
}


$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var TicketSales;
        
    var TicketSales_CONTAINER_SELECTOR = '#ticket-sales-editor';
    var TicketSales_Config = {
        CONTAINER_SELECTOR: TicketSales_CONTAINER_SELECTOR,
<?php if ( in_group(array('admin', 'operator', 'manager')) ) { ?>
        EDITOR_CONFIG: {
            ajax: { url: '/ticket/sale/get', type: 'POST' },
            table: TicketSales_CONTAINER_SELECTOR,
            template: '#ticket-sales-form',
<?php if ( in_group('admin', 'manager') ) { ?>
            canRemove: true,
<?php } ?>
            fields: [
				{
					label: 'Pricing Package',
					name: 'kjl_ticket_sales.event_id',
					type: 'select2',
					//def: 1,
					opts: {
						placeholder: 'Please specify Pricing Package',
					}
				},
                {
                    label: 'Sales Office <sup>*</sup>',
                    name: 'kjl_ticket_sales.office_id',
                    type: 'select2',
                    opts: {
                        placeholder: 'Please choose Sales Office',
						tags: true,
						createTag: function ( tag ) {
							return {
								id: tag.term,
								text: tag.term + ' (new)',
								tag: true,
							}
						}
                    },
					attr: {
						required: true,
					}
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'Operator <sup>*</sup>',
                    name: 'kjl_ticket_sales.operator_id',
                    type: 'select2',
                    opts: {
						debug: true,
                        placeholder: 'Plase choose Operator',
						tags: true,
						createTag: function ( tag ) {
							return {
								id: tag.term,
								text: tag.term + ' (new)',
								tag: true,
							}
						}
                    }
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'Card Number <sup>*</sup>',
                    name: 'kjl_ticket_sales.kjl_card_number',
					attr: {
						placeholder: 'Please entry card number',
					},
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
				{
					label: 'Card Valid From <sup>*</sup>',
					name: 'kjl_ticket_sales.ticket_start_date',
					type: 'datetime',
					attr: {
						placeholder: 'Please specify card valid starting date',
					},
				},
				{
					label: 'Card Expiry Date <sup>*</sup>',
					name: 'kjl_ticket_sales.ticket_expired_date',
					type: 'datetime',
					attr: {
						placeholder: 'Please specify card expired date',
					},
				},
				{
					label: 'Payment Method <sup>*</sup>',
					name: 'kjl_ticket_sales.payment_method',
					type: 'select2',
					opts: {
						placeholder: 'Please choose payment method',
						//tags: true,
					},
					options: [
						{ label: 'Cash', value:'Cash' },
						{ label: 'EDC', value: 'EDC' },
						{ label: 'Transfer', value: 'Transfer' },
						{ label: 'Deposit', value: 'Deposit' }
					],
				},
                {
                    label: 'Full Name <sup>*</sup>',
                    name: 'kjl_ticket_sales.full_name',
					attr: {
						placeholder: 'Please entry tourist full name',
					},
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'Sex <sup>*</sup>',
                    name: 'kjl_ticket_sales.gender',
                    type: 'radio',
                    options: [
                        { label: '<i class="fa fa-mars text-aqua"></i> Male', value: 'Laki-laki' },
                        { label: '<i class="fa fa-venus text-pink"></i> Female',  value: 'Perempuan' }
                    ],
                    def: 'Laki-laki',
					attr: {
						placeholder: 'Please select gender',
					},
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'Country <sup>*</sup>',
                    name: 'kjl_ticket_sales.country_id',
                    type: 'select2',
                    opts: {
                        placeholder: 'Please choose Country',
                    },
					attr: {
						placeholder: 'Please select country origin',
					},
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'ID Type <sup>*</sup>',
                    name: 'kjl_ticket_sales.id_card_type',
                    type: 'select2',
                    opts: {
                        placeholder: 'Please choose ID Card Type',
						//tags: true,
                    },
                    options: [
                        { label: 'Passport', value: 'Passport' },
                        { label: 'KTP', value: 'KTP' },
                        { label: 'SIM', value: 'SIM' },
                        { label: 'KITAS', value: 'KITAS' },
                        { label: 'Lain-lain', value: 'Lain-lain' },
                    ],
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'ID Number <sup>*</sup>',
                    name: 'kjl_ticket_sales.id_card_number',
					attr: {
						placeholder: 'Please entry id card number',
					},
                    //fieldInfo: '<i class="fa fa-asterisk"> required</i>',
                },
                {
                    label: 'Phone <sup>*</sup>',
                    name: 'kjl_ticket_sales.phone',
					attr: {
						placeholder: 'Please entry phone number',
					},
                    //fieldInfo: '<i class="fa fa-asterisk text-red"> Required</i>',
                },
                {
                    label: 'E-mail <sup>*</sup>',
                    name: 'kjl_ticket_sales.email',
					attr: {
						placeholder: 'Please entry email address',
					},
                    //fieldInfo: '<i class="fa fa-asterisk text-red"> Required</i>',
                }
            ]
        },
<?php } ?>
        DATATABLE_CONFIG: {
			createTitle: 'New Tourist Registration',
			editTitle: 'Edit Registered Tourist',
            ajax: { url: '/ticket/sale/get', type: 'POST' },
            responsive: false,
            order: [[ 1, 'desc' ]],
            scroller: true,
			select: {
                style: 'multi',
            },
			<?php
			if (strpos(base_url(), '//event') === 0) {
			?>
			print: false,
			copy: false,
			csv: false,
			xls: false,
			pdf: false,
			<?php
			}
			?>
            customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-info-circle fa-fw text-info"></i>',
					className: 'btn',
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						$.confirm({
							icon: 'fa fa-info-circle',
							title: 'Change Log',
							theme: 'material',
							backgroundDismiss: true,
							content: '<div class="box crowded-box"><div class="box-body"><table id="change-log-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%"></div></div>',
							onContentReady: function () {
								var ChangeLog = $('#change-log-editor').DataTable({
									data: JSON.parse(rows[0].kjl_ticket_sales.change_log),
									columns: CHANGE_LOG_COLUMNS,
									order: [[ 15, 'desc']],
								});
								
								ChangeLog.rows().every( function ( rowIdx, tableLoop, rowLoop ) {
									var data = this.data();
									var prev = this.rows(rowIdx-1).data()[0];
									if ( data && prev ) {
										delete data.update_at;
										delete prev.update_at;
										if (!isEquivalent(data, prev) ) {
											$(this.node()).addClass('info');
										}
									}
								} );
							},
							//columnClass: 'large',
							columnClass: 'xlarge',
							containerFluid: true,
							buttons: {
								Close: {
									btnClass: 'btn-primary'
								}
							}
						});
					},
				},
				{
					extend: 'selected',
					text: '<i class="fa fa-file-text fa-fw text-danger"></i>',
					className: 'btn',
					titleAttr: 'Print Receipt',
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var tickets = new Array();
						for ( i = 0; i < rows.count(); i++ ) {
							tickets.push(rows[i].kjl_ticket_sales.id);
						}
						var form = document.createElement("form");
						form.action = '/ticket/receipt/pdf';
						form.method = 'get';
						form.target = '_blank'|| "_self";
						if (tickets) {
							for (var key in tickets) {
								var input = document.createElement("textarea");
								input.name = key;
								input.name = 'id[]';
								input.value = typeof tickets[key] === "object" ? JSON.stringify(tickets[key]) : tickets[key];
								form.appendChild(input);
							}
						}
						form.style.display = 'none';
						document.body.appendChild(form);
						form.submit();
						form.parentNode.removeChild(form);
						form = null;
					}
				},
                {
                    extend: 'selected',
                    text: '<i class="fa fa-credit-card fa-fw text-success"></i>',
					className: 'btn',
                    titleAttr: 'Print Ticket',
                    action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var tickets = new Array();
						for ( i = 0; i < rows.count(); i++ ) {
							tickets.push(rows[i].kjl_ticket_sales.id);
						}
						var form = document.createElement("form");
						form.action = '/ticket/card/pdf';
						form.method = 'post';
						form.target = '_blank'|| "_self";
						if (tickets) {
							for (var key in tickets) {
								var input = document.createElement("textarea");
								input.name = key;
								input.value = typeof tickets[key] === "object" ? JSON.stringify(tickets[key]) : tickets[key];
								form.appendChild(input);
							}
						}
						form.style.display = 'none';
						document.body.appendChild(form);
						form.submit();
						form.parentNode.removeChild(form);
						form = null;
						/*
                        var s = getSelectedRow( e, dt, node, config );
                        var rows = s.data();
                        debug(rows);
                        var w = window.open('/ticket/card/pdf/'+rows[0].kjl_ticket_sales.id);
                        w.print();
						*/
                    },
					
                },

            ],
            columns: TICKET_SALES_COLUMNS,
        },
        
    };
    
    TicketSales = InitDatatableEditor( TicketSales_Config );
	
	TicketSales.datatable.on('select', selectRowTicketSales);
    TicketSales.datatable.on('deselect', deselectRowTicketSales);
	
	function selectRowTicketSales( e, dt, node, config ) {
        if ( ! dt ) return;
        var s = getSelectedRow(e, dt, node, config);
        var rows = s.data();
        var change_log = rows[0].kjl_ticket_sales.change_log;
        
		//$('#change-log-container').html(change_log);
		
		//debug(JSON.parse(change_log));
    }
    
    function deselectRowTicketSales( e, dt, node, config ) {
        //$('#change-log-container').html('');
    }
	
	if ( TicketSales.editor ) {
		TicketSales.editor.on('initCreate', function() {
			TicketSales.editor.enable();
		});
	
		<?php if ( in_group('operator') ) { ?>
		TicketSales.editor.on('initEdit', function() {
			TicketSales.editor.disable();
			//TicketSales.editor.enable('kjl_ticket_sales.kjl_card_number');
		});
		<?php }	?>
	}

});
