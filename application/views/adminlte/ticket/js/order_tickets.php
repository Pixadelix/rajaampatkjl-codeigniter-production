//<script><?php restricted(''); ?>

function OpenTicketSales(orderId) {
	var TICKET_SALES_COLUMNS = [
		{
			data: 'kjl_ticket_sales.order_id',
			title: 'Order ID.',
			visible: false,
		},
		{
			data: 'kjl_ticket_sales.uuid',
			title: 'Ticket Code',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_sales.full_name',
			title: 'Name',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_sales.email',
			title: 'Email',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_sales.phone',
			title: 'Phone',
			sClass: 'exportable',
		},
		{
			data: 'sys_countries.name',
			title: 'Country',
			sClass: 'exportable',
		},
	];
	
	var TicketSales = null;
    
	var TicketSales_CONTAINER_SELECTOR = '#sales-editor';
	var TicketSales_Config = {
		CONTAINER_SELECTOR: TicketSales_CONTAINER_SELECTOR,

		EDITOR_CONFIG: {
			ajax: { url: '/ticket/sale/get/'+orderId, type: 'POST' },
			table: TicketSales_CONTAINER_SELECTOR,
			
			fields: [
				{
					label: 'Name <sup>*</sup>',
					name: 'kjl_ticket_sales.full_name',
					attr: {
						required: true,
					}
				},
			]
		},

		DATATABLE_CONFIG: {
			createTitle: 'New Ticket',
			editTitle: 'Edit Ticket',
			ajax: {
				url: '/ticket/sale/get/'+orderId,
				type: 'POST'
			},
			order: [[ 1, 'desc' ]],
			scroller: false,
			responsive: true,
			columns: TICKET_SALES_COLUMNS,
			canCreate: false,
		},
		
	};
	
	TicketSales = InitDatatableEditor( TicketSales_Config );
}
	
$(document).ready(function() {

	debug('LOAD: <?php echo $path; ?>');
	
});