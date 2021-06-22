//<script><?php restricted(''); ?>

function getPaymentStatusDesc(status_code, payment_method) {
	//debug(status_code+' - '+payment_method);
	switch ( status_code ) {
		case '200':
			return '200 Success';
		case '201':
			switch ( payment_method ) {
				case 'credit_card':
					return '201 Challenge';
				default:
					return '201 Pending';
			}
		case '202':
			return '202 Denied';
		case '300':
			return '300 Moved';
		// 4xx
		case '400':
			return '400 Validation Error';
		case '401':
			return '401 Access Denied';
		case '402':
			return '402 Insufficient Clearance';
		case '403':
			return '403 Invalid Request';
		case '404':
			return '404 Resource Not Found';
		case '405':
			return '405 Not Allowed';
		case '406':
			return '406 Duplicate Order';
		case '407':
			return '407 Expired';
		case '408':
			return '408 Invalid Data Type';
		case '409':
			return '409 Too Many Request';
		case '410':
			return '410 Merchant Deactivated';
		case '411':
			return '411 Token Missing, Invalid or Timed Out';
		case '412':
			return '412 Merchant Cannot Modify Status Transaction';
		case '413':
			return '413 Malformed Syntax';
		// 5xx
		case '500':
		case '503':
			return '500 Internal Server Error';
		case '501':
			return '501 Unavailable';
		case '502':
			return '502 Internal Server Error: Bank Connection Problem';
		case '504':
			return '504 Internal Server Error: Fraud Detection Unavailable';
		
		default:
			return status_code;
	}
}


var ORDERS_COLUMNS = [
	{
		data: 'kjl_ticket_orders.id',
		title: 'ID.',
		sClass: 'exportable',
		visible: false,
	},
	{
		data: 'kjl_product_events.name',
		title: 'Event',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_orders.uuid',
		title: 'GUID',
		sClass: 'exportable',
		visible: true,
		render: function ( d, t, r ) {
			if ( 'display' === t ) {
				return '<a href="/ticket/verification/'+d+'" target="_blank">'+d+'</a>';
			}
			
			return d;
		}
	},
	{
		data: 'cd_appusers.username',
		title: 'User',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_orders.total_amount',
		title: 'Total Amount',
		sClass: 'exportable roboto-mono text-right',
		render: $.fn.dataTable.render.number( '.', ',', 0 ),
	},
	{
		data: 'kjl_ticket_orders.tax_amount',
		title: 'Tax',
		sClass: 'exportable roboto-mono text-right',
		render: $.fn.dataTable.render.number( '.', ',', 0 ),
	},
	{
		data: 'kjl_ticket_orders.disc_amount',
		title: 'Discount',
		sClass: 'exportable roboto-mono text-right',
		render: $.fn.dataTable.render.number( '.', ',', 0 ),
	},
	{
		data: 'kjl_ticket_orders.open_amount',
		title: 'Open Amount',
		sClass: 'exportable roboto-mono text-right',
		render: $.fn.dataTable.render.number( '.', ',', 0 ),
	},
	{
		data: 'kjl_ticket_orders.payment_amount',
		title: 'Payment Amount',
		sClass: 'exportable roboto-mono text-right',
		render: $.fn.dataTable.render.number( '.', ',', 0 ),
	},
	{
		data: 'kjl_ticket_orders.payment_method',
		title: 'Payment Method',
		sClass: 'exportable',
	},
	/*{
		data: 'kjl_ticket_orders.discount_amount',
		title: 'Discount Amount',
		sClass: 'exportable',
		render: $.fn.dataTable.render.number( '.', ',', 0 ),
	},
	{
		data: 'kjl_ticket_orders.discount_voucher_code',
		title: 'Voucher Code',
		sClass: 'exportable',
	},*/
	{
		data: 'kjl_ticket_orders.order_status',
		title: 'Order Status',
		sClass: 'exportable',
	},
	{
		data: 'kjl_ticket_orders.payment_status',
		title: 'Payment Status',
		sClass: 'exportable',
		render: function ( d, t, r ) {
			if ( 'display' === t ) {
				return getPaymentStatusDesc(d, r.kjl_ticket_orders.payment_method);
			}
			return d;
		}
	},
];

var orderId = null;

$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var TicketOrders;
        
    var TicketOrders_CONTAINER_SELECTOR = '#orders-editor';
    var TicketOrders_Config = {
        CONTAINER_SELECTOR: TicketOrders_CONTAINER_SELECTOR,

        _EDITOR_CONFIG: {
            ajax: { url: '/ticket/orders/get', type: 'POST' },
            table: TicketOrders_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Event <sup>*</sup>',
                    name: 'kjl_ticket_orders.event_id',
					attr: {
						required: true,
					}
                },
            ]
        },

        DATATABLE_CONFIG: {
			createTitle: 'New Order',
			editTitle: 'Edit Order',
            ajax: {
				url: '/ticket/orders/get',
				type: 'POST'
			},
            order: [[ 1, 'desc' ]],
            scroller: false,
			responsive: false,
            columns: ORDERS_COLUMNS,
			select: {
				style: 'single',
			},
			customButtons: [
				{
					extend: 'selected',
					text: '<i class="icon ion-md-cash text-green"></i>',
					className: 'btn',
					titleAttr: 'Check Payments',
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var orders = new Array();
						for ( i = 0; i < rows.count(); i++ ) {
							orders.push(rows[i].kjl_ticket_orders.id);
						}
						$.ajax({
							method: 'POST',
							url: '/ticket/orders/check_payments',
							data: { orders: orders },
							dataType: 'json',
						});
						
					},
				},
				{
					extend: 'selected',
					text: '<i class="fa fa-ticket text-warning"></i>',
					className: 'btn',
					titleAttr: 'Create Tickets',
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var orders = new Array();
						for ( i = 0; i < rows.count(); i++ ) {
							orders.push(rows[i].kjl_ticket_orders.id);
						}
						$.ajax({
							method: 'POST',
							url: '/ticket/orders/create_tickets',
							data: { orders: orders },
							dataType: 'json',
						});
						
					},
				},
			],
			createdRow: function( row, data, dataIndex){
                debug(data[2]);
				if( data[11] ==  '202 Denied'){
                    $(row).addClass('alert-danger');
                }
            }
        },
        
    };
    
    TicketOrders = InitDatatableEditor( TicketOrders_Config );
	TicketOrders.TicketOrdersDtl = null;
	TicketOrders.datatable.on('select', function(e, dt, node, config) {
		if ( ! dt ) return;
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		orderId = rows[0].kjl_ticket_orders.id;
		//destroyDatatable('#orders-dtl-editor');
		//destroyDatatable('#payment-editor');
		//destroyDatatable('#sales-editor');
		OpenOrderPayment(orderId);
		OpenOrderDtl(orderId);
		OpenTicketSales(orderId);
	});
	TicketOrders.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#payment-editor');
		destroyDatatable('#orders-dtl-editor');
		destroyDatatable('#sales-editor');
	});
	
});
