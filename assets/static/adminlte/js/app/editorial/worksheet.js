
function OpenWorksheetWindow(url, wsId) {
	debug('OpenWorksheet: ' + url);
	var CONTAINER_SELECTOR = '#workspace-worksheet-editor';
	var Config = {
		CONTAINER_SELECTOR: CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: url, type: 'POST' },
			table: CONTAINER_SELECTOR,
			fields: [
				{
					label: "Workspace:",
					name: "mag_id",
					fieldInfo: 'choose a workspace (required)',
					type: 'select2',
					opts: {
						placeholder: "Select Worksheet",
						dropdownAutoWidth : true,
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
						containerCssClass: 'doc-content',
					},
					def: wsId,
				},
				{
					label: "Position:",
					name: "position",
					fieldInfo: 'choose position (optional)',
					type: 'select2',
					def: function() {
						var recordsTotal = Worksheet.datatable.page.info().recordsTotal;
						return recordsTotal ? recordsTotal + 1 : 1;
					},
					opts: {
						placeholder: 'Select Position',
						dropdownAutowidth: true,
					}
				},
				{
					label: "Count:",
					name: "pages",
					fieldInfo: 'choose page number (optional)',
					type: 'select2',
					def: 1,
					opts: {
						placeholder: 'Select Count',
						dropdownAutowidth: true,
					}
				},
				{
					label: "Worksheet:",
					name: "rubric",
					fieldInfo: 'input worksheet name (required)',
					type: 'textarea',
				},
				{
					label: "Description:",
					name: "content",
					fieldInfo: 'input worksheet description (optional)',
					type: 'textarea',
				},
				{
					label: "Source:",
					name: "source",
					fieldInfo: 'choose worksheet information source (optional)',
					type: 'select2',
					def: 'Coverage',
				},
/*				{
					"label": "Deadline:",
					"name": "due_date"
				},
				{
					"label": "Status:",
					"name": "status"
				},
				{
					"label": "replaced_for:",
					"name": "replaced_for"
				}, */
				{
					label: "Notes:",
					name: "notes",
					fieldInfo: 'input worksheet notes (optional)',
					type: 'textarea',
				},
/*				{
					"label": "f_script:",
					"name": "f_script",
					"type": "checkbox",
					"separator": ",",
					"options": [
						""
					]
				},
				{
					"label": "f_editing:",
					"name": "f_editing",
					"type": "checkbox",
					"separator": ",",
					"options": [
						""
					]
				},
				{
					"label": "f_foto:",
					"name": "f_foto",
					"type": "checkbox",
					"separator": ",",
					"options": [
						""
					]
				},
				{
					"label": "f_layout:",
					"name": "f_layout",
					"type": "checkbox",
					"separator": ",",
					"options": [
						""
					]
				},
				{
					"label": "change_logs:",
					"name": "change_logs"
				} */
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: url, type: 'POST' },
            responsive: false,
			createTitle: 'Create a new Worksheet',
			editTitle: 'Edit Worksheet',
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
						OpenTaskWindow("/editorial/workspace/get_task/" + wsId + "/" + tabId, wsId, tabId);
					}
				}
			],
			columns: [
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

	var Worksheet = InitDatatableEditor( Config );
	Worksheet.datatable.on('select', function(e, dt, node, config) {
		if ( ! dt ) return;
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var wsId = rows[0].mag_id;
		var tabId = rows[0].id;
		OpenTaskWindow("/editorial/workspace/get_task/" + wsId + "/" + tabId, wsId, tabId);
	});
	Worksheet.datatable.on('deselect', function(e, dt, node, config) {
		destroyDatatable('#workspace-task-editor');
	});

}

	
$(document).ready(function() {	
	
	
});







