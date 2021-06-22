//<script><?php restricted(''); ?>
	
function getDensityColor(val) {
	var color;

	if ( val > 10000 ) {
		color = '#0f0';
	} else if ( val > 5000 ) {
		color = '#5f5';
	} else if ( val > 1000 ) {
		color = '#afa';
	} else if ( val > 500 ) {
		color = '#cfc';
	} else if ( val > 100 ) {
		color = '#dfd';
	} else {
		color = '#ff0';
	}
	return color;
}
	
(function($) {
		
	var max = 0;
	var steps = 10;
	var salesPerMonth = {};

	function drawSalesPerMonth() {
		var c = $('#salesPerMonth');
		var ctx = c.get(0).getContext("2d");
		var container = c.parent();

		var $container = $(container);
		c.attr('width', $container.width()); //max width
		c.attr('height', $container.height()); //max height
		function createConfig(gridlines, title) {
            return {
                type: 'line',
				data: {
					labels: salesPerMonth.labels,
					datasets: salesPerMonth.datasets,
				},
                sdata: {
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                    datasets: [{
                        label: "My First dataset",
                        backgroundColor: 'red',
                        borderColor: 'red',
                        data: [10, 30, 39, 20, 25, 34, 0],
                        fill: false,
                    }, {
                        label: "My Second dataset",
                        fill: false,
                        backgroundColor: 'blue',
                        borderColor: 'blue',
                        data: [18, 33, 22, 19, 11, 39, 30],
                    }]
                },
                options: {
                    responsive: true,
                    title:{
                        display: true,
                        text: title
                    },
					elements: {
						point: {
							radius: 2,
						},
						line: {
							tension: 0.4, // disables bezier curves
							borderWidth: 1,
						}
					},
                    scales: {
                        xAxes: [{
                            gridLines: gridlines
                        }],
                        yAxes: [{
                            gridLines: gridlines,
                            ticks: {
                                min: 0,
                                //max: salesPerMonth.max + 2000,
                                stepSize: 1000,
                            }
                        }]
                    }
                }
            };
        }
		
		var config = createConfig( { display: true }, 'Ticket Sales per Month');
		new Chart(ctx, config);
	}
	
	var visitorByCountryTotal = 0;
	var getData = function () {
		$.ajax({
			url: '/dashboard/main/getData',
			method: 'GET',
			dataType: 'json',
			success: function (d) {
				salesPerMonth = {
					labels: d.salesPerMonth.labels,
					datasets: d.salesPerMonth.datasets,
					max: d.salesPerMonth.max,
				};

				drawSalesPerMonth();

				for ( i = 0; i < salesPerMonth.datasets.length; i++ ) {
					var values = salesPerMonth.datasets[i].data;
					var container = $('<div></div>').addClass('col-xs-4 text-center').css('border-right', '1px solid #f4f4f4');
					var s = $('<div></div>');
					var k = $('<div></div>').addClass('knob-label').text(salesPerMonth.datasets[i].label);
					container.append(s).append(k);
					$('#sparkline').append(container);
					s.sparkline(values, {
						type: 'line',
						lineColor: '#92c1dc',
						fillColor: '#ebf4f9',
						height: 50,
						width: 80
					});
				}
				
				//visitorsData = d.visitorsData;
				drawMap(d.visitorsData);

			}
		});
	};
	
	$(window).resize(drawSalesPerMonth);
	
	var cntTotal = Array();
	function getVisitorByCountry(year) {
		year = year ? year : (new Date()).getFullYear();
		var Country_CONTAINER_SELECTOR = '#country-datatable';
		var Country_Config = {
			CONTAINER_SELECTOR: Country_CONTAINER_SELECTOR,
			DATATABLE_CONFIG: {
				ajax: {
					url: '/dashboard/main/getVisitorByCountry',
					type: 'POST',
					data: { 'year': year },
				},
				processing: false,
				serverSide: false,
				responsive: false,
				scroller: false,
				ordering: true,
				order: [ [13, 'desc']],
				columns: [
					{ title: "Country", data: 'name', sClass: 'nowrap text-smaller' },
					{ title: "01", data: 'jan', sClass: "text-right roboto-mono" },
					{ title: "02", data: 'feb', sClass: "text-right roboto-mono" },
					{ title: "03", data: 'mar', sClass: "text-right roboto-mono" },
					{ title: "04", data: 'apr', sClass: "text-right roboto-mono" },
					{ title: "05", data: 'may', sClass: "text-right roboto-mono" },
					{ title: "06", data: 'jun', sClass: "text-right roboto-mono" },
					{ title: "07", data: 'jul', sClass: "text-right roboto-mono" },
					{ title: "08", data: 'aug', sClass: "text-right roboto-mono" },
					{ title: "09", data: 'sep', sClass: "text-right roboto-mono" },
					{ title: "10", data: 'oct', sClass: "text-right roboto-mono" },
					{ title: "11", data: 'nov', sClass: "text-right roboto-mono" },
					{ title: "12", data: 'dec', sClass: "text-right roboto-mono" },
					{ title: "Total", data: 'cnt', sClass: "text-right roboto-mono" },
					{ title: "Year", data: 'y', sClass: "text-center", visible: false },
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
		var Country = InitDatatableEditor( Country_Config );
	}
	
	var selectYearVisitorByCountry = $('#select-year-visitor-by-country');
	
	var currentYear = new Date().getFullYear();
	
	for ( y = currentYear; y >= 2016; y-- ) {
		var opt = $('<option></option>')
			.val(y)
			.text(y)
		;
		selectYearVisitorByCountry.prepend(opt);
	}
	
	//$('#btn-year-container').append(buttonYears);
	
	selectYearVisitorByCountry.on('change', function() {
		getVisitorByCountry( $(this).find(":selected").val() );
		//debug($(this).text());
		//getVisitorByCountry($(this).text());
	});
		
	getVisitorByCountry();
	
	//var visitorsData;

    getData();

	//jvectormap data
	var visitorsDatax = {
		"ID": 100,
		"US": 298, //USA
		"SA": 400, //Saudi Arabia
		"CA": 1000, //Canada
		"DE": 500, //Germany
		"FR": 760, //France
		"CN": 300, //China
		"AU": 700, //Australia
		"BR": 600, //Brazil
		"IN": 800, //India
		"GB": 320, //Great Britain
		"RU": 3000 //Russia

	};
	


	//World map by jvectormap
	function drawMap(visitorsData) {
		//debug(visitorsData);
		/*
		$('#world-map').vectorMap({
			map: 'world_mill_en',
			backgroundColor: "transparent",
			regionStyle: {
				initial: {
					fill: '#e4e4e4',
					"fill-opacity": 1,
					stroke: 'none',
					"stroke-width": 0,
					"stroke-opacity": 1
				}
			},
			series: {
				regions: [{
					values: visitorsData,
					scale: ["#92c1dc", "#ebf4f9"],
					normalizeFunction: 'polynomial'
				}]
			},
			onRegionLabelShow: function(e, el, code) {
				if (typeof visitorsData[code] != "undefined")
					el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
			},
			onRegionTipShow: function(e, el, code){
      			el.html(el.html() + ': ' + visitorsData[code] + ' new visitors');
    		}
		});
		*/
		
		//var palette = ['#66C2A5', '#FC8D62', '#8DA00B', '#E78AC3', '#A6D854'];
		var palette = ['#555555', '#885555', '#AA5555', '#DD5555', '#FF5555'];
		generateColors = function(){
        	var colors = {},
            	key;

        	for (key in map.regions) {
          		//colors[key] = palette[Math.floor(Math.random()*palette.length)];
				if (typeof visitorsData[key] != "undefined")
					colors[key] = getDensityColor(visitorsData[key]);
        	}
        	return colors;
      	};
		var map;
		map = new jvm.Map({
			map: 'world_merc',
			backgroundColor: 'transparent',
			container: $('#world-map'),
			regionStyle: {
				initial: {
					fill: '#e4e4e4',
					"fill-opacity": 1,
					stroke: 'none',
					"stroke-width": 0,
					"stroke-opacity": 1
				}
			},
			series: {
				regions: [{
					attribute: 'fill',
					values: visitorsData,
					//scale: ["#92c1dc", "#ebf4f9"],
					normalizeFunction: 'polynomial',
				}]
			},
			onRegionTipShow: function(e, el, code) {
				if (typeof visitorsData[code] != "undefined")
					el.html(el.html() + ': ' + visitorsData[code] + ' total visitors');
			}
		});
		map.series.regions[0].setValues(generateColors());
		$( ".connectedSortable" ).on( "sortupdate", function( event, ui ) {
			map.updateSize();
		} );
		

	}
	

	
	//Sparkline charts
	/*
	var myvalues = [1000, 1200, 920, 927, 931, 1027, 819, 930, 1021];
	$('#sparkline-1').sparkline(myvalues, {
		type: 'line',
		lineColor: '#92c1dc',
		fillColor: "#ebf4f9",
		height: '50',
		width: '80'
	});
	myvalues = [515, 519, 520, 522, 652, 810, 370, 627, 319, 630, 921];
	$('#sparkline-2').sparkline(myvalues, {
		type: 'line',
		lineColor: '#92c1dc',
		fillColor: "#ebf4f9",
		height: '50',
		width: '80'
	});
	myvalues = [15, 19, 20, 22, 33, 27, 31, 27, 19, 30, 21];
	$('#sparkline-3').sparkline(myvalues, {
		type: 'line',
		lineColor: '#92c1dc',
		fillColor: "#ebf4f9",
		height: '50',
		width: '80'
	});
	*/

	$('.daterange').daterangepicker({
		ranges: {
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
		},
		startDate: moment().subtract(29, 'days'),
		endDate: moment()
	}, function(start, end) {
		window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	});
	
	$('.yearrange').daterangepicker({
		ranges: {
			'Today': [moment(), moment()],

		},
		startDate: moment().subtract(29, 'days'),
		endDate: moment()
	}, function(start, end) {
		window.alert("You chose: " + start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
	});
	

})(jQuery);
