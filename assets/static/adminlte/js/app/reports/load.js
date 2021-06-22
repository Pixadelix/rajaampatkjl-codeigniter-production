$(document).ready(function() {
	
	
	$('input[name="range_date"]').daterangepicker({
		locale: {
			cancelLabel: 'Clear'
		},
		startDate: moment().startOf('year'),
		endDate: moment().endOf('year'),
	});

	$('input[name="range_date"]').on('apply.daterangepicker', function(ev, picker) {
		$(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
	});

	$('input[name="range_date"]').on('cancel.daterangepicker', function(ev, picker) {
		$(this).val('');
	});
	
	function loadData() {
		LOAD_CONFIG = {
			CONTAINER_SELECTOR: 'load-chart',
			url: '/reports/load/get_chart',
			type: 'POST',
			data: {
				start_date: $('#range-date').data('daterangepicker').startDate.format('YYYY-MM-DD'),
				end_date: $('#range-date').data('daterangepicker').endDate.format('YYYY-MM-DD'),
			},
			chart: null,
			opts: {
				title: 'Load Summary',
				vAxis: {title: 'Activities'},
				hAxis: {title: 'Month'},
				seriesType: 'bars',
				//series: {12: {type: 'line'}, 13: {type: 'line'}},
				is3D: true,
				height: '600px',
			}
		};
		
		
		
		var chart = googleChart( LOAD_CONFIG );
	
	}
	
	$('#load').on('click', loadData);
});

/*
$('#demo').daterangepicker({
    "locale": {
        "format": "MM/DD/YYYY",
        "separator": " - ",
        "applyLabel": "Apply",
        "cancelLabel": "Cancel",
        "fromLabel": "From",
        "toLabel": "To",
        "customRangeLabel": "Custom",
        "weekLabel": "W",
        "daysOfWeek": [
            "Su",
            "Mo",
            "Tu",
            "We",
            "Th",
            "Fr",
            "Sa"
        ],
        "monthNames": [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ],
        "firstDay": 1
    },
    "startDate": "05/24/2017",
    "endDate": "05/30/2017"
}, function(start, end, label) {
  console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
});
*/