//<script><?php restricted(''); ?>

function OpenOrderDtl() {
	var TICKET_ORDERS_DTL_COLUMNS = [
		{
			data: 'kjl_ticket_orders_dtl.order_id',
			title: 'Order ID.',
			visible: false,
		},
		{
			data: 'kjl_ticket_orders_dtl.full_name',
			title: 'Name',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_orders_dtl.email',
			title: 'Email',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_orders_dtl.phone',
			title: 'Phone',
			sClass: 'exportable',
		},
		{
			data: 'sys_countries.name',
			title: 'Country',
			sClass: 'exportable',
		},
	];
	
	var TicketOrdersDtl = null;
    
	var TicketOrdersDtl_CONTAINER_SELECTOR = '#orders-dtl-editor';
	var TicketOrdersDtl_Config = {
		CONTAINER_SELECTOR: TicketOrdersDtl_CONTAINER_SELECTOR,

		EDITOR_CONFIG: {
			ajax: { url: '/ticket/orders/get_dtl', type: 'POST' },
			table: TicketOrdersDtl_CONTAINER_SELECTOR,
			
			fields: [
				{
					label: 'Name <sup>*</sup>',
					name: 'kjl_ticket_orders_dtl.full_name',
					attr: {
						required: true,
					}
				},
			]
		},

		DATATABLE_CONFIG: {
			createTitle: 'New Detail',
			editTitle: 'Edit Detail',
			ajax: {
				url: '/ticket/orders/get_dtl/'+orderId,
				type: 'POST'
			},
			order: [[ 1, 'desc' ]],
			scroller: false,
			responsive: true,
			columns: TICKET_ORDERS_DTL_COLUMNS,
			canCreate: false,
		},
		
	};
	
	TicketOrdersDtl = InitDatatableEditor( TicketOrdersDtl_Config );
}
	
$(document).ready(function() {

	debug('LOAD: <?php echo $path; ?>');
	
});