
function OpenTaskWindow(url) {
	debug('OpenTask: ' + url);
	
	var Task_CONTAINER_SELECTOR = '#workspace-task-editor';
	var Task_Config = {
		CONTAINER_SELECTOR: Task_CONTAINER_SELECTOR,

		DATATABLE_CONFIG: {
			ajax: { url: url, type: 'POST' },
			columns: [
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
				/*
				{
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
				},
				*/
				{
					data: "sip_tasks.type",
					title: "Assignment",
					sClass: 'editable exportable nowrap',
					render: function ( data, type, row ) {
						return '<i class="fa fa-fw '+$TASK_TYPE_ICONS[data]+'"></i> '+data;
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
					sClass: "editable exportable",
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
				/*
				{
					data: "sip_tasks.start_at",
					title: "Start Working Time",
					visible: false,
				},
				{
					data: "sip_tasks.complete_at",
					title: "Completed Time",
					visible: false,
				},
				*/
			],
			order: [ [ 1, 'asc' ] ],
		}
	};

	InitDatatableEditor( Task_Config );
	
}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
$(document).ready(function() {	
	
	
});







