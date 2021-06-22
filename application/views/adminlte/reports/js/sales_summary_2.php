//<script><?php restricted(''); ?>

	
(function($) {

	var selectYear = $('#select-year');
	
	selectYear.on('change', function() {
		getData( $(this).find(":selected").val() );
	});
	
	$('#btn-go').on('click', function() {
		getData( $(selectYear).find(":selected").val() );
	});
	
	var numberRenderer = $.fn.dataTable.render.number( '.', ',', 0, '' ).display;
	
	function getData() {
		var year    = $(selectYear).select2().val();
		var dom = $('#dom2').val();
		var intl = $('#intl2').val();
		var cntTotal = Array();
		year = year ? year : (new Date()).getFullYear();
		var Report_CONTAINER_SELECTOR = '#report-datatable-2';
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

					$('#jan-total-2').html(numberRenderer(cntTotal['jan']));
					$('#feb-total-2').html(numberRenderer(cntTotal['feb']));
					$('#mar-total-2').html(numberRenderer(cntTotal['mar']));
					$('#apr-total-2').html(numberRenderer(cntTotal['apr']));
					$('#may-total-2').html(numberRenderer(cntTotal['may']));
					$('#jun-total-2').html(numberRenderer(cntTotal['jun']));
					$('#jul-total-2').html(numberRenderer(cntTotal['jul']));
					$('#aug-total-2').html(numberRenderer(cntTotal['aug']));
					$('#sep-total-2').html(numberRenderer(cntTotal['sep']));
					$('#oct-total-2').html(numberRenderer(cntTotal['oct']));
					$('#nov-total-2').html(numberRenderer(cntTotal['nov']));
					$('#dec-total-2').html(numberRenderer(cntTotal['dec']));
					$('#cnt-total-2').html(numberRenderer(cntTotal['tot']));
				},
			}
		};

		var Report = InitDatatableEditor( Report_Config );
		
	}
	
	getData();
	
})(jQuery);