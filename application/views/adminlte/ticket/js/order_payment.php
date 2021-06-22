//<script><?php restricted(''); ?>

function OpenOrderPayment(orderId) {
	var ORDERS_PAYMENT_COLUMNS = [
		{
			data: 'kjl_ticket_payments.real_order_id',
			title: 'Order ID.',
			visible: false
		},			
		{
			data: 'kjl_ticket_payments.bank',
			title: 'Bank',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.payment_type',
			title: 'Payment Type',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.gross_amount',
			title: 'Gross Amount',
			sClass: 'exportable roboto-mono text-right',
			render: $.fn.dataTable.render.number( '.', ',', 0 ),
		},
		{
			data: 'kjl_ticket_payments.transaction_time',
			title: 'Time',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.transaction_status',
			title: 'Transaction Status',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.status_code',
			title: 'Status Code',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.fraud_status',
			title: 'Fraud Status',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.status_message',
			title: 'Status Message',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.order_id',
			title: 'Order ID.',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.transaction_id',
			title: 'Transaction ID.',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.approval_code',
			title: 'Approval Code',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.update_at',
			title: 'Updated At',
			sClass: 'exportable',
		},
		{
			data: 'kjl_ticket_payments.update_by',
			title: 'Updated By',
			sClass: 'exportable',
		},
	];
	
	var CHANGE_LOG_COLUMNS = Array();
	for ( i = 0; i < ORDERS_PAYMENT_COLUMNS.length; i++ ) {
		//debug(ORDERS_PAYMENT_COLUMNS[i].data);
		var col = ORDERS_PAYMENT_COLUMNS[i];
		if ( ! col.data.startsWith('kjl_ticket_payments.') ) {
			continue;
		}
		CHANGE_LOG_COLUMNS.push({
			data: col.data.split('.').pop(),
			title: col.title,
			render: col.render,
			sClass: col.sClass,
		});
	}
	
	var OrderPayment = null;
    
	var OrderPayment_CONTAINER_SELECTOR = '#payment-editor';
	var OrderPayment_Config = {
		CONTAINER_SELECTOR: OrderPayment_CONTAINER_SELECTOR,

		EDITOR_CONFIG: {
			ajax: { url: '/ticket/orders/get_payment/'+orderId, type: 'POST' },
			table: OrderPayment_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Transaction Status <sup>*</sup>',
					name: 'kjl_ticket_payments.transaction_status',
					attr: {
						required: true,
					}
				},
			]
		},

		DATATABLE_CONFIG: {
			createTitle: 'New Payment',
			editTitle: 'Edit Payment',
			ajax: {
				url: '/ticket/orders/get_payment/'+orderId,
				type: 'POST'
			},
			order: [[ 1, 'desc' ]],
			scroller: false,
			responsive: true,
			columns: ORDERS_PAYMENT_COLUMNS,
			canCreate: false,
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
									data: JSON.parse(rows[0].kjl_ticket_payments.change_log),
									columns: CHANGE_LOG_COLUMNS,
									order: [[ 12, 'desc']],
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
			],
		},
		
	};
	
	OrderPayment = InitDatatableEditor( OrderPayment_Config );
	
	OrderPayment.datatable.on('select', selectRowOrderPayment);
	
	function selectRowOrderPayment( e, dt, node, config ) {
        if ( ! dt ) return;
        var s = getSelectedRow(e, dt, node, config);
        var rows = s.data();
        var change_log = rows[0].kjl_ticket_payments.change_log;
        
		//$('#change-log-container').html(change_log);
		
		//debug(JSON.parse(change_log));
    }
	
}
	
$(document).ready(function() {

	debug('LOAD: <?php echo $path; ?>');
	
});