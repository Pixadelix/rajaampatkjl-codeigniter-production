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
            ajax: { url: '/contest/dashboard/get_contests/open', type: 'POST' },
            order: [[ 1, 'asc' ]],
            scroller: false,
			responsive: true,
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
		destroyDatatable('#questions-editor');
		destroyDatatable('#contestants-editor');
		OpenQuestions(eventId);
		OpenContestants(eventId, 'approved', { canEdit: false } );
	});
	Contests.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#questions-editor');
		destroyDatatable('#contestants-editor');
		$("#score").empty().html('Please specify a contestant');
	});
	

	
});


