
function OpenTaskWindow(url, wsId, tabId) {
	debug('OpenTask: ' + url);
	
	var Task_CONTAINER_SELECTOR = '#workspace-task-editor';
	var Task_Config = {
		CONTAINER_SELECTOR: Task_CONTAINER_SELECTOR,
		
		
		
		EDITOR_CONFIG: {
			ajax: { url: url, type: 'POST' },
			table: Task_CONTAINER_SELECTOR,
            template: '#task-form',
			i18n: {
				create: {
					title:  "Add new Task",
					submit: "Add new"
				},
				edit: {
					title:  "Edit Task",
					submit: "Update Task"
				},
			},
			fields: [
				{
					label: "Workspace:",
					name: "sip_tasks.mag_id",
					fieldInfo: 'choose workspace (required)',
					type: 'select2',
					opts: {
						placeholder: "Select Workspace",
						dropdownAutoWidth : true,
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
						containerCssClass: 'doc-content',
					},
					def: wsId,
				},
				{
					label: "Worksheet:",
					name: "sip_tasks.tab_id",
					fieldInfo: 'choose worksheet (required)',
					type: 'select2',
					opts: {
						placeholder: "Select Worksheet",
						dropdownAutoWidth : true,
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
						containerCssClass: 'doc-content',
					},
					def: tabId,
				},
				{
					label: "Event Date:",
					name: "sip_tasks.event_date",
					fieldInfo: 'input date of event (optional)',
					type: "datetime",
					format: "DD-MM-YYYY HH:mm",
					//def: function () { return new Date(); },
				},
				{
					label: "PIC:",
					name: "sip_tasks.user_id",
					fieldInfo: 'choose PIC for assignment (required)',
					type: 'select2',
					opts: {
						placeholder: "Select PIC",
						dropdownAutoWidth : true,
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
					}
				},
				{
					label: "Assignment:",
					name: "sip_tasks.type",
					fieldInfo: 'choose assignment type (required)',
					type: 'select2',
					def: 'Coverage',
					opts: {
						placeholder: "Select Assignment",
						//allowClear: true,
						dropdownAutoWidth : true,
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
					}
				},
				{
					label: "Event Name:",
					name: "sip_tasks.event_name",
					fieldInfo: 'input event name (optional)',
					type: 'textarea',
				},
				{
					label: "Location:",
					name: "sip_tasks.event_place",
					fieldInfo: 'input event location (optional)',
				},
				{
					label: "Status:",
					name: "sip_tasks.status",
					fieldInfo: 'choose assignment status (optional)',
					type: "select2",
					def: 'standby',
					opts: {
						placeholder: "Select Status",
						dropdownAutoWidth : true,
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
					}
				},
				{
					label: "Deadline:",
					name: "sip_tasks.due_date",
					fieldInfo: 'input deadline (required)',
					type: "datetime",
					format: "DD-MM-YYYY"
				},
				/*{
					label: "start_at:",
					name: "sip_tasks.start_at",
					type: "datetime",
					format: "DD\/MM\/YY HH:mm"
				},
				{
					label: "complete_at:",
					name: "sip_tasks.complete_at",
					type: "datetime",
					format: "DD\/MM\/YY HH:mm"
				}, */
				{
					label: "Notes:",
					name: "sip_tasks.notes",
					fieldInfo: 'input assignment notes (optional)',
					//type: 'textarea',
                    type: 'ckeditor',
                    ospts: {
                        skin: 'lightgray',
                    }
				},
                {
                    label: 'Grab Quota',
                    name: 'sip_tasks.fgrab',
                    type: 'radio',
                    def: 0,
                    options: [
                        { 'label': 'None', value: 0 },
                        { 'label': 'Single trip', value: 1 },
                        { 'label': 'Multi trip', value: 2 },
                    ]
                }
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: url, type: 'POST' },
			createTitle: 'Create a new Task Assignment',
			editTitle: 'Edit an Assignment',
			columns: [
				{
					data: "sip_tasks.id",
				},
				{
					data: "sip_tasks.event_date",
					title: "Date",
					sClass: "editable exportable nowrap",
					render: function( data, type, row ) {
						return formatLocalDate( row.sip_tasks.event_date );
					},
				},
				{
					data: "sip_tasks.user_id",
					title: "PIC",
					sClass: "editable exportable",
					render: function ( data, type, row ) {
						return row.sip_users.first_name;
					}
				},
				/*{
					data: "sip_tasks.mag_id",
					title: "Workspace",
					sClass: "editable exportable",
					visible: false,
					render: function ( data, type, row ) {
						return row.sip_workspace.name;
					}
				},
				{
					data: "sip_tasks.tab_id",
					title: "Worksheet",
					sClass: "editable exportable",
					visible: false,
					//render: function ( data, type, row ) {
						//return row.sip_tabs.rubric;
					//}
				},*/
				{
					data: "sip_tasks.type",
					title: "Assignment",
					sClass: 'editable exportable nowrap',
					render: function ( data, type, row ) {
						return '<i class="fa fa-fw '+row.sip_task_types.icon+'"></i> '+data;
					}
				},
				{
					data: "sip_tasks.event_name",
					title: "Event Name",
					sClass: 'editable exportable',
				},
				{
					data: "sip_tasks.event_place",
					title: "Location",
					sClass: 'editable exportable',
				},
				{
					data: "sip_tasks.notes",
					title: "Notes",
					sClass: "editable exportable doc-content",
				},
				{
					data: "sip_tasks.due_date",
					title: "Deadline",
					sClass: "editable exportable nowrap",
					render: function( data, type, row) {
						return formatLocalDate( row.sip_tasks.due_date );
					},
				},
				{
					data: "sip_tasks.status",
					title: "Status",
					sClass: 'editable exportable nowrap',
					render: function ( data, type, row ) {
						var fa = '';
						var style = '';
						switch (data) {
							case 'standby':
								fa = 'fa-arrow-circle-down';
								style = 'text-standby';
								break;
							case 'ongoing':
								fa = 'fa-arrow-circle-right';
								style = 'text-ongoing';
								break;
							case 'cancel':
								fa = 'fa-times-circle';
								style = 'text-cancel';
								break;
							case 'postpone':
								fa = 'fa-arrow-circle-left';
								style = 'text-postpone';
								break;
							case 'done':
								fa = 'fa-check-circle';
								style = 'text-done';
								break;
							default:
								break;
						}
						return '<span class="'+style+'"><i class="fa fa-fw '+fa+'"></i> '+data+'</span>';
					}
				},
				/*{
					data: "sip_tasks.start_at",
					title: "Start Working Time",
					visible: false,
				},
				{
					data: "sip_tasks.complete_at",
					title: "Completed Time",
					visible: false,
				},*/
				{
					data: "sip_tasks.notes_hist",
					title: "History",
                    visible: false,
					render: function( ) { return null; }
				}, {
                    data: 'sip_tasks.fgrab',
                    title: 'Grab Quota',
                    sClass: 'exportable',
                }
			],
			order: [ [ 1, 'asc' ] ],
		}
	};

	InitDatatableEditor( Task_Config );
	
}
	
	
$(document).ready(function() {	
	
	
});


