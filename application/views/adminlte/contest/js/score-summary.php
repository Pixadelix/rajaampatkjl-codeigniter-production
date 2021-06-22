//<script><?php restricted(array('contest-scoring', 'contest-score-summary')); ?>

var CONTESTS_COLUMNS = [
	{
		data: 'kjl_product_events.code',
		title: 'Code',
		sClass: 'exportable',
		visible: false,
	},
	{
		data: 'kjl_product_events.name',
		title: 'Contests Name',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.create_at',
		title: 'Date',
		sClass: 'exportable',
	},
];

$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Contests;
        
    var Contests_CONTAINER_SELECTOR = '#contests-editor';
    var Contests_Config = {
        CONTAINER_SELECTOR: Contests_CONTAINER_SELECTOR,

        DATATABLE_CONFIG: {
			editTitle: 'Edit Contests',
            ajax: { url: '/contest/dashboard/get_contests', type: 'POST' },
            order: [[ 1, 'asc' ]],
            scroller: false,
			responsive: false,
            columns: CONTESTS_COLUMNS,
			canCreate: false,
        },
        
    };
    
    Contests = InitDatatableEditor( Contests_Config );
	
	Contests.datatable.on('select', function(e, dt, node, config) {
		if ( ! dt ) return;
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		eventId = rows[0].kjl_product_events.id;
		destroyDatatable('#score-summary-editor');
		OpenScoreSummary(eventId);
		
	});
	Contests.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#score-summary-editor');
	});
	
});

function OpenScoreSummary(event_id) {

	var questionCnt = 0;
	var RESULTS_COLUMNS = [

		{
			data: 'cts_contestants.timestamp',
			title: 'Date',
			sClass: 'exportable',
			visible: false,
		},

		{ data: 'cts_contestants.id', title: 'ID', sClass: 'exportable', visible: false },
		{ data: 'cts_contestants.a01', title: 'Field 1',  sClass: 'exportable' },
		
		{ data: 'cts_results_summary.score_total', title: 'Score Total',  sClass: 'exportable text-center roboto-mono', render: $.fn.dataTable.render.number( '.', ',', 2, '', ' pts' ) },
		{ data: 'cts_results_summary.score', title: 'Score Avg.',  sClass: 'exportable text-center roboto-mono', render: $.fn.dataTable.render.number( '.', ',', 2, '', ' pts' ) },
		
		/*
		{ data: 'cts_results.avgs01', title: 'Score 1',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs02', title: 'Score 2',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs03', title: 'Score 3',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs04', title: 'Score 4',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs05', title: 'Score 5',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs06', title: 'Score 6',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs07', title: 'Score 7',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs08', title: 'Score 8',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs09', title: 'Score 9',   sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs10', title: 'Score 10',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs11', title: 'Score 11',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs12', title: 'Score 12',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs13', title: 'Score 13',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs14', title: 'Score 14',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs15', title: 'Score 15',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs16', title: 'Score 16',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs17', title: 'Score 17',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs18', title: 'Score 18',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs19', title: 'Score 19',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs20', title: 'Score 20',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs21', title: 'Score 21',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs22', title: 'Score 22',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs23', title: 'Score 23',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs24', title: 'Score 24',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs25', title: 'Score 25',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs26', title: 'Score 26',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs27', title: 'Score 27',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs28', title: 'Score 28',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs29', title: 'Score 29',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		{ data: 'cts_results.avgs30', title: 'Score 30',  sClass: 'exportable text-center roboto-mono', visible: true, render: $.fn.dataTable.render.number( '.', ',', 2, '' ) },
		*/
		
	];
	
	var Results;
		
	var Results_CONTAINER_SELECTOR = '#score-summary-editor';
	var Results_Config = {
		CONTAINER_SELECTOR: Results_CONTAINER_SELECTOR,

		DATATABLE_CONFIG: {
			ajax: { url: '/contest/dashboard/get_contestants/'+event_id+'/approved', type: 'POST' },
			order: [[ 4, 'desc' ], [ 3, 'desc' ]],
			scroller: true,
			responsive: false,
			columns: RESULTS_COLUMNS,
		},
		
	};
	
	Results = InitDatatableEditor( Results_Config );
	
	Results.datatable.on('select', function(e, dt, node, config) {
		if ( ! dt ) return;
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		answerId = rows[0].cts_contestants.id;
		destroyDatatable('#score-breakdown-editor');
		OpenScoreBreakdown(answerId);
		
	});
	Results.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#score-breakdown-editor');
	});
	
}

function OpenScoreBreakdown(answer_id) {
	var BREAKDOWN_COLUMNS = [
		{ data: 'sys_users.first_name', title: 'Jury', sClass: 'exportable' },
		{
			data: null,
			title: 'Score',
			sClass: 'exportable text-center roboto-mono',
			render: function (d, t, r, m) {
				if ( 'display' === t ) {
					return (
						parseFloat(r.cts_scores.s01 != null ? r.cts_scores.s01 : 0) +
						parseFloat(r.cts_scores.s02 != null ? r.cts_scores.s02 : 0) +
						parseFloat(r.cts_scores.s03 != null ? r.cts_scores.s03 : 0) +
						parseFloat(r.cts_scores.s04 != null ? r.cts_scores.s04 : 0) +
						parseFloat(r.cts_scores.s05 != null ? r.cts_scores.s05 : 0) +
						parseFloat(r.cts_scores.s06 != null ? r.cts_scores.s06 : 0) +
						parseFloat(r.cts_scores.s07 != null ? r.cts_scores.s07 : 0) +
						parseFloat(r.cts_scores.s08 != null ? r.cts_scores.s08 : 0) +
						parseFloat(r.cts_scores.s09 != null ? r.cts_scores.s09 : 0) +
						
						parseFloat(r.cts_scores.s11 != null ? r.cts_scores.s11 : 0) +
						parseFloat(r.cts_scores.s12 != null ? r.cts_scores.s12 : 0) +
						parseFloat(r.cts_scores.s13 != null ? r.cts_scores.s13 : 0) +
						parseFloat(r.cts_scores.s14 != null ? r.cts_scores.s14 : 0) +
						parseFloat(r.cts_scores.s15 != null ? r.cts_scores.s15 : 0) +
						parseFloat(r.cts_scores.s16 != null ? r.cts_scores.s16 : 0) +
						parseFloat(r.cts_scores.s17 != null ? r.cts_scores.s17 : 0) +
						parseFloat(r.cts_scores.s18 != null ? r.cts_scores.s18 : 0) +
						parseFloat(r.cts_scores.s19 != null ? r.cts_scores.s19 : 0) +
						
						parseFloat(r.cts_scores.s21 != null ? r.cts_scores.s21 : 0) +
						parseFloat(r.cts_scores.s22 != null ? r.cts_scores.s22 : 0) +
						parseFloat(r.cts_scores.s23 != null ? r.cts_scores.s23 : 0) +
						parseFloat(r.cts_scores.s24 != null ? r.cts_scores.s24 : 0) +
						parseFloat(r.cts_scores.s25 != null ? r.cts_scores.s25 : 0) +
						parseFloat(r.cts_scores.s26 != null ? r.cts_scores.s26 : 0) +
						parseFloat(r.cts_scores.s27 != null ? r.cts_scores.s27 : 0) +
						parseFloat(r.cts_scores.s28 != null ? r.cts_scores.s28 : 0) +
						parseFloat(r.cts_scores.s29 != null ? r.cts_scores.s29 : 0) +
						
						parseFloat(r.cts_scores.s31 != null ? r.cts_scores.s31 : 0) +
						parseFloat(r.cts_scores.s32 != null ? r.cts_scores.s32 : 0) +
						parseFloat(r.cts_scores.s33 != null ? r.cts_scores.s33 : 0) +
						parseFloat(r.cts_scores.s34 != null ? r.cts_scores.s34 : 0) +
						parseFloat(r.cts_scores.s35 != null ? r.cts_scores.s35 : 0) +
						parseFloat(r.cts_scores.s36 != null ? r.cts_scores.s36 : 0) +
						parseFloat(r.cts_scores.s37 != null ? r.cts_scores.s37 : 0) +
						parseFloat(r.cts_scores.s38 != null ? r.cts_scores.s38 : 0) +
						parseFloat(r.cts_scores.s39 != null ? r.cts_scores.s39 : 0) +
						
						parseFloat(r.cts_scores.s41 != null ? r.cts_scores.s41 : 0) +
						parseFloat(r.cts_scores.s42 != null ? r.cts_scores.s42 : 0) +
						parseFloat(r.cts_scores.s43 != null ? r.cts_scores.s43 : 0) +
						parseFloat(r.cts_scores.s44 != null ? r.cts_scores.s44 : 0) +
						parseFloat(r.cts_scores.s45 != null ? r.cts_scores.s45 : 0) +
						parseFloat(r.cts_scores.s46 != null ? r.cts_scores.s46 : 0) +
						parseFloat(r.cts_scores.s47 != null ? r.cts_scores.s47 : 0) +
						parseFloat(r.cts_scores.s48 != null ? r.cts_scores.s48 : 0) +
						parseFloat(r.cts_scores.s49 != null ? r.cts_scores.s49 : 0) +
						
						parseFloat(r.cts_scores.s51 != null ? r.cts_scores.s51 : 0) +
						parseFloat(r.cts_scores.s52 != null ? r.cts_scores.s52 : 0) +
						parseFloat(r.cts_scores.s53 != null ? r.cts_scores.s53 : 0) +
						parseFloat(r.cts_scores.s54 != null ? r.cts_scores.s54 : 0) +
						parseFloat(r.cts_scores.s55 != null ? r.cts_scores.s55 : 0) +
						parseFloat(r.cts_scores.s56 != null ? r.cts_scores.s56 : 0) +
						parseFloat(r.cts_scores.s57 != null ? r.cts_scores.s57 : 0) +
						parseFloat(r.cts_scores.s58 != null ? r.cts_scores.s58 : 0) +
						parseFloat(r.cts_scores.s59 != null ? r.cts_scores.s59 : 0) +
						
						parseFloat(r.cts_scores.s61 != null ? r.cts_scores.s61 : 0) +
						parseFloat(r.cts_scores.s62 != null ? r.cts_scores.s62 : 0) +
						parseFloat(r.cts_scores.s63 != null ? r.cts_scores.s63 : 0) +
						parseFloat(r.cts_scores.s64 != null ? r.cts_scores.s64 : 0) +
						parseFloat(r.cts_scores.s65 != null ? r.cts_scores.s65 : 0) +
						parseFloat(r.cts_scores.s66 != null ? r.cts_scores.s66 : 0) +
						parseFloat(r.cts_scores.s67 != null ? r.cts_scores.s67 : 0) +
						parseFloat(r.cts_scores.s68 != null ? r.cts_scores.s68 : 0) +
						parseFloat(r.cts_scores.s69 != null ? r.cts_scores.s69 : 0) +
						
						parseFloat(r.cts_scores.s71 != null ? r.cts_scores.s71 : 0) +
						parseFloat(r.cts_scores.s72 != null ? r.cts_scores.s72 : 0) +
						parseFloat(r.cts_scores.s73 != null ? r.cts_scores.s73 : 0) +
						parseFloat(r.cts_scores.s74 != null ? r.cts_scores.s74 : 0) +
						parseFloat(r.cts_scores.s75 != null ? r.cts_scores.s75 : 0) +
						parseFloat(r.cts_scores.s76 != null ? r.cts_scores.s76 : 0) +
						parseFloat(r.cts_scores.s77 != null ? r.cts_scores.s77 : 0) +
						parseFloat(r.cts_scores.s78 != null ? r.cts_scores.s78 : 0) +
						parseFloat(r.cts_scores.s79 != null ? r.cts_scores.s79 : 0) +
						
						parseFloat(r.cts_scores.s81 != null ? r.cts_scores.s81 : 0) +
						parseFloat(r.cts_scores.s82 != null ? r.cts_scores.s82 : 0) +
						parseFloat(r.cts_scores.s83 != null ? r.cts_scores.s83 : 0) +
						parseFloat(r.cts_scores.s84 != null ? r.cts_scores.s84 : 0) +
						parseFloat(r.cts_scores.s85 != null ? r.cts_scores.s85 : 0) +
						parseFloat(r.cts_scores.s86 != null ? r.cts_scores.s86 : 0) +
						parseFloat(r.cts_scores.s87 != null ? r.cts_scores.s87 : 0) +
						parseFloat(r.cts_scores.s88 != null ? r.cts_scores.s88 : 0) +
						parseFloat(r.cts_scores.s89 != null ? r.cts_scores.s89 : 0) +
						
						parseFloat(r.cts_scores.s91 != null ? r.cts_scores.s91 : 0) +
						parseFloat(r.cts_scores.s92 != null ? r.cts_scores.s92 : 0) +
						parseFloat(r.cts_scores.s93 != null ? r.cts_scores.s93 : 0) +
						parseFloat(r.cts_scores.s94 != null ? r.cts_scores.s94 : 0) +
						parseFloat(r.cts_scores.s95 != null ? r.cts_scores.s95 : 0) +
						parseFloat(r.cts_scores.s96 != null ? r.cts_scores.s96 : 0) +
						parseFloat(r.cts_scores.s97 != null ? r.cts_scores.s97 : 0) +
						parseFloat(r.cts_scores.s98 != null ? r.cts_scores.s98 : 0) +
						parseFloat(r.cts_scores.s99 != null ? r.cts_scores.s99 : 0) +
						
						parseFloat(r.cts_scores.s100 != null ? r.cts_scores.s100 : 0) +

						0
					);
					//return 0;
				}
				return d;
			}
		},

		{ data: 'cts_scores.s01', title: '1',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s02', title: '2',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s03', title: '3',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s04', title: '4',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s05', title: '5',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s06', title: '6',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s07', title: '7',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s08', title: '8',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s09', title: '9',  sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },

		{ data: 'cts_scores.s10', title: '10', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s11', title: '11', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s12', title: '12', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s13', title: '13', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s14', title: '14', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s15', title: '15', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s16', title: '16', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s17', title: '17', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s18', title: '18', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s19', title: '19', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },

		{ data: 'cts_scores.s20', title: '20', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s21', title: '21', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s22', title: '22', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s23', title: '23', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s24', title: '24', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s25', title: '25', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s26', title: '26', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s27', title: '27', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s28', title: '28', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s29', title: '29', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },

		{ data: 'cts_scores.s30', title: '30', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s31', title: '31', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s32', title: '32', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s33', title: '33', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s34', title: '34', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s35', title: '35', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s36', title: '36', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s37', title: '37', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s38', title: '38', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s39', title: '39', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s40', title: '40', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s41', title: '41', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s42', title: '42', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s43', title: '43', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s44', title: '44', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s45', title: '45', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s46', title: '46', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s47', title: '47', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s48', title: '48', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s49', title: '49', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s50', title: '50', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s51', title: '51', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s52', title: '52', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s53', title: '53', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s54', title: '54', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s55', title: '55', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s56', title: '56', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s57', title: '57', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s58', title: '58', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s59', title: '59', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s60', title: '60', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s61', title: '61', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s62', title: '62', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s63', title: '63', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s64', title: '64', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s65', title: '65', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s66', title: '66', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s67', title: '67', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s68', title: '68', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s69', title: '69', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s70', title: '70', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s71', title: '71', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s72', title: '72', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s73', title: '73', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s74', title: '74', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s75', title: '75', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s76', title: '76', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s77', title: '77', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s78', title: '78', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s79', title: '79', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s80', title: '80', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s81', title: '81', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s82', title: '82', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s83', title: '83', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s84', title: '84', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s85', title: '85', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s86', title: '86', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s87', title: '87', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s88', title: '88', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s89', title: '89', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s90', title: '90', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s91', title: '91', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s92', title: '92', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s93', title: '93', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s94', title: '94', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s95', title: '95', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s96', title: '96', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s97', title: '97', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s98', title: '98', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		{ data: 'cts_scores.s99', title: '99', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },
		
		{ data: 'cts_scores.s100', title: '100', sClass: 'exportable text-center roboto-mono', visible: false, render: $.fn.dataTable.render.number( '.', ',', 0, '' ) },

	];
	
	var Breakdowns;
	
	var Breakdowns_CONTAINER_SELECTOR = '#score-breakdown-editor';
	var Breakdowns_Config = {
		CONTAINER_SELECTOR: Breakdowns_CONTAINER_SELECTOR,
		
		DATATABLE_CONFIG: {
			ajax: { url: '/contest/dashboard/get_score_breakdown/'+answer_id, type: 'POST' },
			order: [[ 1, 'asc' ]],
			scroller: true,
			responsive: false,
			columns: BREAKDOWN_COLUMNS,
		}
	}
	
	Breakdowns = InitDatatableEditor( Breakdowns_Config );
	
}