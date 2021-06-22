//<script><?php restricted(''); ?>

debug('LOAD: <?php echo $path; ?>');

$(document).ready(function() {
    
	//$('input[name="dates"]').daterangepicker();
	$('#dates').daterangepicker({
    "showDropdowns": true,
    "minYear": 2016,
    "maxYear": 2020,
    "autoApply": true,
		"maxSpan": {
			"days": 31
    },
		"locale": {
			"format": "YYYY/MM/DD",
		},
    ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Last 2 Month': [moment().subtract(2, 'month').startOf('month'), moment().subtract(2, 'month').endOf('month')],
			'Last 3 Month': [moment().subtract(3, 'month').startOf('month'), moment().subtract(3, 'month').endOf('month')],
			'Last 4 Month': [moment().subtract(4, 'month').startOf('month'), moment().subtract(4, 'month').endOf('month')],
			'Last 5 Month': [moment().subtract(5, 'month').startOf('month'), moment().subtract(5, 'month').endOf('month')],
			'Last 6 Month': [moment().subtract(6, 'month').startOf('month'), moment().subtract(6, 'month').endOf('month')],
    },
    "alwaysShowCalendars": true,
    //"startDate": "07/02/2020",
    //"endDate": "07/08/2020",
    "drops": "auto"
		}, function(start, end, label) {
  		//console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
	});


	$('#btn-go').on('click', function() {
		getData();
	});

	function getData() {
		dates = $('#dates').val();
		//console.log(dates);
	
  	var TicketSales;      
    var TicketSales_CONTAINER_SELECTOR = '#ticket-sales-editor';
    var TicketSales_Config = {
			CONTAINER_SELECTOR: TicketSales_CONTAINER_SELECTOR,
			DATATABLE_CONFIG: {
				serverSide: false,
				createTitle: 'New Tourist Registration',
				editTitle: 'Edit Registered Tourist',
				ajax: {
					url: '/report/get-data/sales-detailed',
					type: 'POST',
					data: { dates: dates }
				},
				responsive: true,
				order: [[0, 'asc'], [ 1, 'asc' ]],
				scroller: true,
				select: null,
				columns: [
					{ title: 'Rec.ID', data: 'id', sClass: 'exportable', visible: false },
					{ title: 'Full Name', data: 'full_name', sClass: 'exportable' },
					{ title: 'Sex', data: 'gender', sClass: 'exportable' },
					{ title: 'ID.Type', data: 'id_card_type', sClass: 'exportable' },
					{ title: 'Country', data: 'country', sClass: 'exportable' },
					{ title: 'ID.Number', data: 'id_card_number', sClass: 'exportable' },
					{ title: 'Phone', data: 'phone', sClass: 'exportable' },
					{ title: 'Email', data: 'email', sClass: 'exportable' },
					{ title: 'Valid From', data: 'ticket_start_date', sClass: 'exportable' },
					{ title: 'Expired Date', data: 'ticket_expired_date', sClass: 'exportable' },
					{ title: 'Payment Method', data: 'payment_method', sClass: 'exportable' },
					{ title: 'Payment Amount', data: 'payment_amount', sClass: 'exportable roboto-mono text-right', render: $.fn.dataTable.render.number( '.', ',', 2 ) },
					{ title: 'Entry By', data: 'first_name', sClass: 'exportable' },
					{ title: 'Operator', data: 'operator_name', sClass: 'exportable' },
					{ title: 'Location', data: 'office_name', sClass: 'exportable' },
					{ title: 'Entry Date', data: 'create_at', sClass: 'exportable', visible: 'false' },
				]
			},
    };
    
    TicketSales = InitDatatableEditor( TicketSales_Config );

	}

	getData();
});
