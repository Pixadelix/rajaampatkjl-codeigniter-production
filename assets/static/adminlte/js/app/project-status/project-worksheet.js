
function OpenWorksheetWindow(url) {
	debug('OpenWorksheet: ' + url);
	var CONTAINER_SELECTOR = '#workspace-worksheet-editor';
	var Config = {
		CONTAINER_SELECTOR: CONTAINER_SELECTOR,
		
		DATATABLE_CONFIG: {
			ajax: { url: url, type: 'POST' },
			customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-tasks"></i>',
					titleAttr: 'Task',
					enabled: false,
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var wsId = rows[0].mag_id;
						var tabId = rows[0].id;
						OpenTaskWindow("/editorial/workspace/get_task/" + wsId + "/" + tabId);
					}
				}
			],
			columns: [
			/*
				{
					data: 'id',
					title: 'ID',
					visible: false,
				},
				{
					data: "position",
					title: 'Pos.',
					sClass: 'editable exportable text-center',
				},
				{
					data: "pages",
					title: 'Count',
					sClass: 'editable exportable text-center',
				},
			
				{
					data: 'mag_id',
					title: 'Workspace',
					visible: false,
				},
			*/
				{
					data: "rubric",
					title: 'Worksheet',
					sClass: 'editable exportable',
				},
				{
					data: "content",
					title: 'Description',
					sClass: 'editable exportable',
				},
				{
					data: "source",
					title: 'Source',
					sClass: 'editable exportable',
				},
/*				{
					"data": "due_date",
					title: 'Deadline',
				},
				{
					"data": "status",
					title: 'Status',
				},
				{
					"data": "replaced_for",
					title: 'Repalced For',
				}, */
				
				{
					data: "notes",
					title: 'Notes',
					sClass: 'editable exportable',
				},
/*				{
					"data": "f_script",
					title: 'Script',
				},
				{
					"data": "f_editing",
					title: 'Editing',
				},
				{
					"data": "f_foto",
					title: 'Photo',
				},
				{
					"data": "f_layout",
					title: 'Layout',
				}, */
/*				{
					"data": "change_logs",
					title: 'Change Logs',
				} */
			],
			order: [ [ 2, 'asc' ] ], //Initial order
		},
		
	};

	var table = InitDatatableEditor( Config );
	table.datatable.on('select', function(e, dt, node, config) {
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var wsId = rows[0].mag_id;
		var tabId = rows[0].id;
		OpenTaskWindow("/editorial/workspace/get_task/" + wsId + "/" + tabId, wsId);
	});
	table.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#workspace-task-editor');
	});

}

	
$(document).ready(function() {	
	
	
});







