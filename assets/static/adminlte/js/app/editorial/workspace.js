var Workspace_Url = '/editorial/workspace/get';

if ( $WORKSPACE_ID ) {
	Workspace_Url += '/' + $WORKSPACE_ID;
}

// define workspace configuration instance
var Workspace_Config = null;

function clearAllTables(){
	debug('Clear all tables');
	$('.title-window').empty();

	destroyDatatable('#workspace-worksheet-editor');
	destroyDatatable('#workspace-task-editor');	
	destroyChart(Workspace_Config.CHART_PIE_WORKLOAD_CONFIG);
	destroyChart(Workspace_Config.CHART_COLUMN_WORKLOAD_CONFIG);
	
	destroyChart(Workspace_Config.CHART_PIE_OVERALL_WORKLOAD_CONFIG);
	destroyChart(Workspace_Config.CHART_COLUMN_OVERALL_PROGRESS_CONFIG);
}

/* PROJECT CONFIGURATION */

function selectRowProject( e, dt, node, config ) {
	
	if ( ! dt ) return;
	
	clearAllTables();
	var s = getSelectedRow( e, dt, node, config );
	var rows = s.data();
	var wsId = rows[0].sip_projects.id;
	$('.title-window').html('('+rows[0].sip_projects.name+')');
	
	OpenWorkspaceWindow('/editorial/workspace/get_by_project/' + wsId);
}

function deselectRowProject( e, dt, node, config ) {
	destroyDatatable('#workspace-editor');
	clearAllTables();	
	OpenWorkspaceWindow( Workspace_Url );
}

function OpenProjectWindow() {
	var Projects_CONTAINER_SELECTOR = '#projects-datatable';
	destroyDatatable( Projects_CONTAINER_SELECTOR );
	var Projects_Config = {
		CONTAINER_SELECTOR: Projects_CONTAINER_SELECTOR,
		DATATABLE_CONFIG: {
			ajax: { url: '/project_status/get', type: 'POST' },
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

	var Projects = InitDatatableEditor( Projects_Config );
	Projects.datatable.on('select', selectRowProject);
	Projects.datatable.on('deselect', deselectRowProject);
}



/* WORKSPACE CONFIGURATION */

function selectRowWorkspace( e, dt, node, config ) {
	
	if ( ! dt ) return;
	
	var s = getSelectedRow( e, dt, node, config );
	var rows = s.data();
	var wsId = rows[0].sip_workspace.id;
	var tabId = rows[0].id;
	$('.title-window').html('('+rows[0].sip_workspace.name+' - '+rows[0].sip_workspace.edition+')');
	OpenWorksheetWindow('/editorial/workspace/get_worksheet/' + wsId, wsId);
	OpenTaskWindow("/editorial/workspace/get_task/" + wsId, wsId, tabId);
	
	
	Workspace_Config.CHART_PIE_WORKLOAD_CONFIG.url = '/editorial/workspace/get_workload_chart/' + wsId;
	Workspace_Config.CHART_PIE_WORKLOAD_CONFIG = googleChart( Workspace_Config.CHART_PIE_WORKLOAD_CONFIG );
	
	Workspace_Config.CHART_COLUMN_WORKLOAD_CONFIG.url = '/editorial/workspace/get_column_chart/' + wsId;
	Workspace_Config.CHART_COLUMN_WORKLOAD_CONFIG = googleChart( Workspace_Config.CHART_COLUMN_WORKLOAD_CONFIG );
	
	Workspace_Config.CHART_PIE_OVERALL_WORKLOAD_CONFIG.url = '/editorial/workspace/get_workload_chart/';
	Workspace_Config.CHART_PIE_OVERALL_WORKLOAD_CONFIG = googleChart( Workspace_Config.CHART_PIE_OVERALL_WORKLOAD_CONFIG );
	
	Workspace_Config.CHART_COLUMN_OVERALL_PROGRESS_CONFIG.url = '/editorial/workspace/get_column_chart/';
	Workspace_Config.CHART_COLUMN_OVERALL_PROGRESS_CONFIG = googleChart( Workspace_Config.CHART_COLUMN_OVERALL_PROGRESS_CONFIG );
}

function deselectRowWorkspace( e, dt, node, config ) {
	clearAllTables();
	/*
	$('.title-window').empty();
	destroyDatatable('#workspace-worksheet-editor');
	destroyDatatable('#workspace-task-editor');	
	destroyChart(Workspace_Config.CHART_PIE_WORKLOAD_CONFIG);
	destroyChart(Workspace_Config.CHART_COLUMN_WORKLOAD_CONFIG);
	
	destroyChart(Workspace_Config.CHART_PIE_OVERALL_WORKLOAD_CONFIG);
	destroyChart(Workspace_Config.CHART_COLUMN_OVERALL_PROGRESS_CONFIG);
	*/
}

function OpenWorkspaceWindow(url) {
	debug('OpenWorkspace: ' + url);
	
	var Workspace_CONTAINER_SELECTOR = '#workspace-editor';
	Workspace_Config = {
		CONTAINER_SELECTOR: Workspace_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: url, type: 'POST' },
			table: Workspace_CONTAINER_SELECTOR,
			fields: [
				{
					label: "Workspace:",
					name: "sip_workspace.name",
					fieldInfo: 'input workspace name (required)',
				}, {
					label: "Edition:",
					name: "sip_workspace.edition",
					fieldInfo: 'input workspace edition (required)',
				}, {
					label: "Deadline:",
					name: "sip_workspace.due_date",
					fieldInfo: 'input deadline (required)',
					type: "datetime",
					format: "DD-MM-YYYY",
					def: function() {
						var today = new Date();
						var nextweek = new Date(today.getFullYear(), today.getMonth(), today.getDate()+7);
						return nextweek;
					},
				}, {
					label: "Publish date:",
					name: "sip_workspace.publish",
					fieldInfo: 'input publish date (required)',
					type: "datetime",
					format: "DD-MM-YYYY",
					def: function() {
						var today = new Date();
						var next2week = new Date(today.getFullYear(), today.getMonth(), today.getDate()+14);
						return next2week;
					},
				}, {
					label: "Project:",
					name: "sip_workspace.project_id",
					fieldInfo: 'choose a project (required)',
					type: "select2",
					opts: {
						placeholder: "Select Project",
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
						dropdownAutoWidth: true,
					}
				}, {
					label: "Status:",
					name: "sip_workspace.status",
					fieldInfo: 'choose workspace status (required)',
					type: "select2",
					def: 1,
					opts: {
						placeholder: "Select Status",
						templateSelection: select2dropdownFormat,
						templateResult: select2dropdownFormat,
						dropdownAutoWidth: true,
					}
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: url, type: 'POST' },
			createTitle: 'Create new Workspace',
			editTitle: 'Edit Workspace',
			customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-tasks"></i>',
					titleAttr: 'Task',
					enabled: false,
					action: selectRowWorkspace,
					baction: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var wsId = rows[0].sip_workspace.id;
						var tabId = rows[0].id;
						OpenTaskWindow("/editorial/workspace/get_task/" + wsId, wsId, tabId);
						
						debug(Workspace_Config);
						Workspace_Config.CHART_PIE_WORKLOAD_CONFIG.url = '/editorial/workspace/get_workload_chart/' + wsId;
						Workspace_Config.CHART_PIE_WORKLOAD_CONFIG = googleChart( Workspace_Config.CHART_PIE_WORKLOAD_CONFIG );
			
					}
				}, {
					extend: 'selectedSingle',
					text: '<i class="fa fa-book"></i>',
					titleAttr: 'Worksheet',
					enabled: false,
					action: function ( e, dt, node, config ) {
						var s = getSelectedRow( e, dt, node, config );
						var rows = s.data();
						var wsId = rows[0].sip_workspace.id;
						OpenWorksheetWindow('/editorial/workspace/get_worksheet/' + wsId, wsId);
					}
				}
			],
		
			columns: [
				{
					data: 'sip_workspace.due_date',
					title: 'Deadline',
					sClass: 'editable text-left exportable nowrap',
					srender: function (d, t, r) {
						debug(r.sip_workspace.due_date);
						return r.sip_workspace.due_date;
					},
					srender: $.fn.dataTable.render.moment( 'YYYY-MM-DD', 'DD-MMM-YYYY', 'id' ),
				}, {
					data: 'sip_workspace.name',
					title: 'Workspace',
					sClass: 'editable exportable',
				}, {
					data: 'sip_workspace.edition',
					title: 'Edition',
					sClass: 'editable exportable',
				}, {
					data: 'sip_workspace.project_id',
					title: 'Project',
					sClass: 'editable exportable',
					render: function( data, type, row ) {
						return row.sip_projects.name;
					}
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
					data: 'sip_view_workspace_progress.progress_task',
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
		CHART_PIE_WORKLOAD_CONFIG: {
			CONTAINER_SELECTOR: 'task-workload-chart',
			chart: null,
			opts: {
				title: 'Workload Summary',
				is3D: true,
				//pieHole: 0.4,
				fontName: 'Open Sans',
			}
		},
		CHART_COLUMN_WORKLOAD_CONFIG: {
			CONTAINER_SELECTOR: 'task-progress-chart',
			chart: null,
			opts: {
				title: 'Progress Summary',
				vAxis: {title: 'Activities'},
				hAxis: {title: 'PIC'},
				seriesType: 'bars',
				series: {5: {type: 'line'}, 6: {type: 'line'}},
				is3D: true,
			}
		},
		CHART_PIE_OVERALL_WORKLOAD_CONFIG: {
			CONTAINER_SELECTOR: 'overall-workload-chart',
			chart: null,
			opts: {
				title: 'Overall Workload Summary',
				//is3D: true,
				pieHole: 0.4,
				fontName: 'Open Sans',
			}
		},
		CHART_COLUMN_OVERALL_PROGRESS_CONFIG: {
			CONTAINER_SELECTOR: 'overall-progress-chart',
			chart: null,
			opts: {
				title: 'Overall Progress Summary',
				vAxis: {title: 'Activities'},
				hAxis: {title: 'PIC'},
				seriesType: 'bars',
				series: {5: {type: 'line'}, 6: {type: 'line'}},
				is3D: true,
			}
		}
	};
	
	var Workspace = InitDatatableEditor( Workspace_Config );
	Workspace.datatable.on('select', selectRowWorkspace);
	Workspace.datatable.on('deselect', deselectRowWorkspace);
}



$(document).ready(function() {
	
	$('#btn-load-projects').on('click', OpenProjectWindow);
	
	/*
	var Projects_datatable = InitDatatableEditor( Projects_Config );
	Projects_datatable.on('select', selectRowProject);
	Projects_datatable.on('deselect', deselectRowProject);
	*/
	
	//var Workspace_datatable = InitDatatableEditor( Workspace_Config );
	

	var Workspace_datatable = OpenWorkspaceWindow(Workspace_Url);
	
});
