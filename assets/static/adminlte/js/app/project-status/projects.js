(function ($, window, undefined) {
	
	var Workspace_Url = '/editorial/workspace/get';

	if ( $WORKSPACE_ID ) {
		Workspace_Url += '/' + $WORKSPACE_ID;
		var Workspace_datatable = OpenWorkspaceWindow(Workspace_Url);
	}

	debug('app/project-status/list.js loaded');
	
	function OpenWorkspaceWindow(url) {
		debug('OpenWorkspace: ' + url);
		var CONTAINER_SELECTOR = '#workspace-datatable';
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
					{
						data: 'sip_workspace.due_date',
						title: 'Deadline',
						sClass: 'editable text-left exportable',
						render: $.fn.dataTable.render.moment( 'YYYY-MM-DD', 'DD-MMM-YYYY', 'id' ),
					}, {
						data: 'sip_workspace.name',
						title: 'Workspace',
						sClass: 'editable exportable',
					}, {
						data: 'sip_workspace.edition',
						title: 'Edition',
						sClass: 'editable exportable',
					}, {
						data: 'sip_workspace.status',
						title: 'Status',
						sClass: 'editable',
						render: function ( data, type, row) {
							var fa = 'fa-archive';
							var st = 'Archived';
							switch ( data ) {
								case '1':
									fa = 'fa-circle-o';
									st = 'Active';
									break;
								case '2':
									fa = 'fa-star-half';
									st = 'Fullscript';
									break;
								case '5':
									fa = 'fa-star-o';
									st = 'Fullbook';
									break;
								case '10':
									fa = 'fa-star-half-o';
									st = 'Published';
									break;
								case '20':
									fa = 'fa-star';
									st = 'Finished';
									break;
								default:
									break;
							}
							return '<i class="fa fa-fw '+fa+'"></i>'+st;
						}
					}, {
						data: 'sip_workspace_progress.progress_task',
						title: 'Progress',
						render: function( data, type, row) {
							//debug(data);
							bg_progress = 'red';
							if (data >= 100) {
								bg_progress = 'green';
							} else if (data > 50) {
								bg_progress = 'purple';
							}
							return '<div class="progress progress-xs active"><div class="progress-bar progress-bar-'+bg_progress+' progress-bar-striped"" style="width: '+ data + '%"></div></div>';
						}
					}
				],
				order: [ [ 1, 'desc' ], [3, 'desc'] ], //Initial order
			},
			
		};

		var table = InitDatatableEditor( Config );
		table.on('select', function(e, dt, node, config) {
			var s = getSelectedRow( e, dt, node, config );
			var rows = s.data();
			var wsId = rows[0].mag_id;
			var tabId = rows[0].id;
			OpenTaskWindow("/editorial/workspace/get_task/" + wsId + "/" + tabId, wsId);
		});
		table.on('deselect', function(e, dt, node, config) {
			destroyDatatable('#workspace-task-editor');
		});

	}
	
	function selectRowProject( e, dt, node, config ) {
		var s = getSelectedRow( e, dt, node, config );
		var rows = s.data();
		var wsId = rows[0].sip_projects.id;
		$('.title-window').html('('+rows[0].sip_projects.name+')');
		
		OpenWorkspaceWindow('/editorial/workspace/get_by_project/' + wsId);
	}
	
	function deselectRowProject( e, dt, node, config ) {
		$('.title-window').empty();
		destroyDatatable('#workspace-datatable');
	}
	
	/* Projects */
	var Projects_CONTAINER_SELECTOR = '#projects-datatable';
	var Projects_Config = {
		CONTAINER_SELECTOR: Projects_CONTAINER_SELECTOR,
		DATATABLE_CONFIG: {
			ajax: { url: '/project_status/get_by_users_projects', type: 'POST' },
			columns: [
				{
					data: 'sip_projects.name',
					title: 'Name',
					sClass: 'exportable',
				},
				{
					data: 'sip_projects.description',
					title: 'Description',
					sClass: 'exportable',
				},
			]
		}
	};
	
	var Projects_datatable = InitDatatableEditor( Projects_Config );
	Projects_datatable.on('select', selectRowProject);
	Projects_datatable.on('deselect', deselectRowProject);
	
})(jQuery, window);