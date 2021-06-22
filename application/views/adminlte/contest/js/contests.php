//<script><?php restricted(array('admin')); ?>

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
	{
		data: 'kjl_product_events.status',
		title: 'Status',
	}
];

$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Contests;
        
    var Contests_CONTAINER_SELECTOR = '#contests-editor';
    var Contests_Config = {
        CONTAINER_SELECTOR: Contests_CONTAINER_SELECTOR,

        EDITOR_CONFIG: {
            ajax: { url: '/contest/dashboard/get_contests', type: 'POST' },
            table: Contests_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Name <sup>*</sup>',
                    name: 'kjl_product_events.name',
					attr: {
						required: true,
					},
                },
				{
					label: 'Status <sup>*</sup>',
					name: 'kjl_product_events.status',
					attr: {
						required: true,
					},
					type: 'select2',
					options: [{ label: 'Open', value: 'open' }, { label: 'Close', value: 'close' }],
				},
            ],
        },

        DATATABLE_CONFIG: {
			editTitle: 'Edit Contests',
            ajax: { url: '/contest/dashboard/get_contests', type: 'POST' },
            order: [[ 1, 'asc' ]],
            scroller: false,
			responsive: false,
            columns: CONTESTS_COLUMNS,
			canCreate: false,
			customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-trash fa-fw text-danger"></i>',
					className: 'btn',
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						debug(rows);
						$.confirm({
							icon: 'fa fa-question',
							title: 'Delete Contest',
							theme: 'supervan red',
							backgroundDismiss: true,
							content: 'Are you sure want to delete contest<br/> <i class="fa fa-quote-left"></i> <strong class="text-red h3">'+rows[0].kjl_product_events.name+'</strong> <i class="fa fa-quote-right"></i> ?',
							containerFluid: true,
							columnClass: 'col-md-12',
							buttons: {
								No: {
									btnClass: 'btn-green',
								},
								Yes: {
									btnClass: 'btn-red',
									action: function() {
										$.ajax({
											url: '/contest/dashboard/delete',
											method: 'POST',
											data: { id: rows[0].kjl_product_events.id },
										})
										.done(function() {
											Contests.datatable.ajax.reload();
										})
										;
									}
								}
							},
						});
					}
				}
			],
        },
        
    };
    
    Contests = InitDatatableEditor( Contests_Config );

	Contests.datatable.on('select', function(e, dt, node, config) {
		if ( ! dt ) return;
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		eventId = rows[0].kjl_product_events.id;
		destroyDatatable('#questions-editor');
		destroyDatatable('#score-summary-editor');
		OpenQuestions(eventId);
		OpenScoreSummary(eventId);
		
	});
	Contests.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#questions-editor');
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

		{ data: 'cts_contestants.a01', title: 'Field 1',  sClass: 'exportable' },
		
		{ data: 'cts_results_summary.score_total', title: 'Score Total',  sClass: 'exportable text-center roboto-mono', render: $.fn.dataTable.render.number( '.', ',', 2, '', ' pts' ) },
		{ data: 'cts_results_summary.score', title: 'Score Avg.',  sClass: 'exportable text-center roboto-mono', render: $.fn.dataTable.render.number( '.', ',', 2, '', ' pts' ) },
	
	];
	
	var Results;
		
	var Results_CONTAINER_SELECTOR = '#score-summary-editor';
	var Results_Config = {
		CONTAINER_SELECTOR: Results_CONTAINER_SELECTOR,

		DATATABLE_CONFIG: {
			ajax: { url: '/contest/dashboard/get_contestants/'+event_id+'/approved', type: 'POST' },
			order: [[ 4, 'desc' ], [ 3, 'desc' ]],
			scroller: true,
			responsive: true,
			columns: RESULTS_COLUMNS,
		},
		
	};
	
	Results = InitDatatableEditor( Results_Config );
	
}