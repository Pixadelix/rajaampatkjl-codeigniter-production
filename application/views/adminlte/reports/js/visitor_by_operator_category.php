//<script><?php restricted(''); ?>

	
(function($) {

	var chart, chartData;
	var selectYear = $('#select-year');
	var selectCountry = $('#select-country');
	var currentYear = new Date().getFullYear();
	for ( y = currentYear; y >= 2016; y-- ) {
		var opt = $('<option></option>')
			.val(y).text(y);
		selectYear.prepend(opt);
	}
	selectYear.on('change', getData );
	//selectCountry.on('change', getData );
	$('#btn-table').on('click', getData );
	$('#btn-chart').on('click', drawChart );
	
	function drawChart() {
		var c = $('#canvas-report-chart');
		var ctx = c.get(0).getContext("2d");
		var container = c.parent();

		var $container = $(container);
		
		if ( chart ) chart.destroy();
		
		c.attr('width', $container.width()); //max width
		c.attr('height', $container.height()); //max height
		function createConfig(gridlines, title) {
            return {
                type: 'bar',
				data: {
					labels: chartData.labels,
					datasets: chartData.datasets,
				},
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: title
                    },
					legend: {
						display: true,
					},
					elements: {
						line: {
							//tension: 0, // disables bezier curves
						}
					},
                    scales: {
                        xAxes: [{
							stacked: true,
                            gridLines: gridlines
                        }],
                        yAxes: [{
							stacked: true,
                            gridLines: gridlines,
                            ticks: {
                                min: 0,
                                //max: 300,
                                //stepSize: 40,
                            }
                        }]
                    }
                }
            };
        }
		
		var config = createConfig( { display: true }, 'Visitor by Operator Category');
		chart = new Chart(ctx, config);
	}
	
	function getData() {
		
		var year    = $(selectYear).select2().val();
		var country = $(selectCountry).select2().val();
			
		var cntTotal = Array();
		year = year ? year : (new Date()).getFullYear();
		
		var Report_CONTAINER_SELECTOR = '#report-datatable';
		var Report_Config = {
			CONTAINER_SELECTOR: Report_CONTAINER_SELECTOR,
			DATATABLE_CONFIG: {
				ajax: {
					url: '/report/get-data/visitor-by-opr-category',
					type: 'POST',
					data: { 'year': year, 'country': country },
				},
				processing: false,
				serverSide: false,
				responsive: false,
				scroller: false,
				ordering: true,
				order: [ [14, 'desc']],
				columns: [
					{ title: "Operator", data: 'name', sClass: 'nowrap' },
					{ title: "Jan", data: 'jan', sClass: "text-right roboto-mono exportable" },
					{ title: "Feb", data: 'feb', sClass: "text-right roboto-mono exportable" },
					{ title: "Mar", data: 'mar', sClass: "text-right roboto-mono exportable" },
					{ title: "Apr", data: 'apr', sClass: "text-right roboto-mono exportable" },
					{ title: "May", data: 'may', sClass: "text-right roboto-mono exportable" },
					{ title: "Jun", data: 'jun', sClass: "text-right roboto-mono exportable" },
					{ title: "Jul", data: 'jul', sClass: "text-right roboto-mono exportable" },
					{ title: "Aug", data: 'aug', sClass: "text-right roboto-mono exportable" },
					{ title: "Sep", data: 'sep', sClass: "text-right roboto-mono exportable" },
					{ title: "Oct", data: 'oct', sClass: "text-right roboto-mono exportable" },
					{ title: "Nov", data: 'nov', sClass: "text-right roboto-mono exportable" },
					{ title: "Dec", data: 'dec', sClass: "text-right roboto-mono exportable" },
					{ title: "Total", data: 'total', sClass: "text-right roboto-mono exportable" },
					{ title: "Year", data: 'year', sClass: "text-center exportable", visible: false, },
					
				],
				footerCallback: function(row, data, start, end, display) {
					
					var api = this.api(), data;

					var intVal = function ( i ) {
						return typeof i === 'string' ?
							i.replace(/[\Rp,]/g, '')*1 :
							typeof i === 'number' ?
							i : 0;
					};
					
					function footerCalcTotal(api, col) {
						if(api.column(col).data()){
							return api.column(col).data().reduce( function(a,b) { return intVal(a)+intVal(b); }, 0 );
						}
					}
					
					cntTotal['jan'] = footerCalcTotal(api, 1);
					cntTotal['feb'] = footerCalcTotal(api, 2);
					cntTotal['mar'] = footerCalcTotal(api, 3);
					cntTotal['apr'] = footerCalcTotal(api, 4);
					cntTotal['may'] = footerCalcTotal(api, 5);
					cntTotal['jun'] = footerCalcTotal(api, 6);
					cntTotal['jul'] = footerCalcTotal(api, 7);
					cntTotal['aug'] = footerCalcTotal(api, 8);
					cntTotal['sep'] = footerCalcTotal(api, 9);
					cntTotal['oct'] = footerCalcTotal(api, 10);
					cntTotal['nov'] = footerCalcTotal(api, 11);
					cntTotal['dec'] = footerCalcTotal(api, 12);
					cntTotal['tot'] = footerCalcTotal(api, 13);

					$('#jan-total').html(cntTotal['jan']);
					$('#feb-total').html(cntTotal['feb']);
					$('#mar-total').html(cntTotal['mar']);
					$('#apr-total').html(cntTotal['apr']);
					$('#may-total').html(cntTotal['may']);
					$('#jun-total').html(cntTotal['jun']);
					$('#jul-total').html(cntTotal['jul']);
					$('#aug-total').html(cntTotal['aug']);
					$('#sep-total').html(cntTotal['sep']);
					$('#oct-total').html(cntTotal['oct']);
					$('#nov-total').html(cntTotal['nov']);
					$('#dec-total').html(cntTotal['dec']);
					$('#cnt-total').html(cntTotal['tot']);
				},
			}
		};
		var Report = InitDatatableEditor( Report_Config );

		$.ajax({
			url: '/report/get-chart-data/visitor-by-opr-category',
			method: 'POST',
			data: { 'year': year, 'country': country },
			dataType: 'json',
			success: function(response) {
				chartData = response;
				drawChart();
			}
		});

		
	}
	
	getData();
	
})(jQuery);