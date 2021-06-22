//<script><?php restricted(''); ?>

	
(function($) {

	var selectYear = $('#select-year');
	var currentYear = new Date().getFullYear();
	for ( y = currentYear; y >= 2016; y-- ) {
		var opt = $('<option></option>')
			.val(y).text(y);
		selectYear.prepend(opt);
	}
	
	var chartData;
	
	selectYear.on('change', function() {
		getData( $(this).find(":selected").val() );
	});
	
	$('#btn-go').on('click', function() {
		getData( $(selectYear).find(":selected").val() );
	});
	
	var chart;
	
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
                                //stepSize: 1000
								callback: function(value, index, values) {
									return value.toLocaleString("id-ID", {sstyle:"currency", csurrency:"IDR"});
								}
                            }
                        }]
                    },
				}
            };
        }
		
		var config = createConfig( { display: true }, 'Total Sales Summary (Environmental Services + Retribution)');
		chart = new Chart(ctx, config);
	}
	
	Chart.defaults.global.tooltips.callbacks.label = function(tooltipItem, data) {
		return tooltipItem.yLabel.toLocaleString("id-ID");
	};
	
	var numberRenderer = $.fn.dataTable.render.number( '.', ',', 0, '' ).display;
	
	function getData() {
		var year    = $(selectYear).select2().val();
		var dom = $('#dom').val();
		var intl = $('#intl').val();
		var cntTotal = Array();
		year = year ? year : (new Date()).getFullYear();
		var Report_CONTAINER_SELECTOR = '#report-datatable';
		var Report_Config = {
			CONTAINER_SELECTOR: Report_CONTAINER_SELECTOR,
			DATATABLE_CONFIG: {
				ajax: {
					url: '/report/get-data/sales-summary',
					type: 'POST',
					data: { 'year': year, 'dom': dom, 'intl': intl, },
				},
				processing: false,
				serverSide: false,
				responsive: false,
				scroller: false,
				ordering: true,
				order: [ [13, 'desc']],
				columns: [
					{ title: "Category", data: 'visitor_category' },
					{ title: "Jan", data: 'jan', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Feb", data: 'feb', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Mar", data: 'mar', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Apr", data: 'apr', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "May", data: 'may', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Jun", data: 'jun', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Jul", data: 'jul', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Aug", data: 'aug', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Sep", data: 'sep', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Oct", data: 'oct', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Nov", data: 'nov', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Dec", data: 'dec', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Total", data: 'total', sClass: "text-right roboto-mono exportable", render: $.fn.dataTable.render.number( '.', ',', 0, '' ), },
					{ title: "Year", data: 'y', sClass: "text-center exportable", visible: false },
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

					$('#jan-total').html(numberRenderer(cntTotal['jan']));
					$('#feb-total').html(numberRenderer(cntTotal['feb']));
					$('#mar-total').html(numberRenderer(cntTotal['mar']));
					$('#apr-total').html(numberRenderer(cntTotal['apr']));
					$('#may-total').html(numberRenderer(cntTotal['may']));
					$('#jun-total').html(numberRenderer(cntTotal['jun']));
					$('#jul-total').html(numberRenderer(cntTotal['jul']));
					$('#aug-total').html(numberRenderer(cntTotal['aug']));
					$('#sep-total').html(numberRenderer(cntTotal['sep']));
					$('#oct-total').html(numberRenderer(cntTotal['oct']));
					$('#nov-total').html(numberRenderer(cntTotal['nov']));
					$('#dec-total').html(numberRenderer(cntTotal['dec']));
					$('#cnt-total').html(numberRenderer(cntTotal['tot']));
				},
			}
		};

		var Report = InitDatatableEditor( Report_Config );

		var dom2 = $('#dom2').val();
		var intl2 = $('#intl2').val();
		
		$.ajax({
			url: '/report/get-chart-data/sales-summary',
			method: 'POST',
			data: { 'year': year, 'dom': parseFloat(dom)+parseFloat(dom2), 'intl': parseFloat(intl)+parseFloat(intl2) },
			dataType: 'json',
			success: function(response) {
				chartData = response;
				drawChart();
			}
		});
		
	}
	
	getData();
	
})(jQuery);