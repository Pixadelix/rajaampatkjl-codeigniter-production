(function ($, window, undefined) {
	debug('app/setting/clients_projects.js loaded');
	
	/* Clients */
	var Clients_CONTAINER_SELECTOR = '#clients-editor';
	var Clients_Config = {
		CONTAINER_SELECTOR: Clients_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/clients/get', type: 'POST' },
			table: Clients_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Name', name: 'name' },
				{ label: 'Description', name: 'description' },
				{ label: 'Website', name: 'website' },
				{ label: 'Phone', name: 'phone' },
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/setting/clients/get', type: 'POST' },
			columns: [
				{
					data: 'name',
					title: 'Name',
					sClass: 'editable exportable',
				},
				{
					data: 'description',
					title: 'Description',
					sClass: 'editable exportable',
				},
				{
					data: 'website',
					title: 'Website',
					sClass: 'editable exportable',
				},
				{
					data: 'phone',
					title: 'Phone',
					sClass: 'editable exportable',
				},
			]
		}
	};
	
	/* Projects */
	var Projects_CONTAINER_SELECTOR = '#projects-editor';
	var Projects_Config = {
		CONTAINER_SELECTOR: Projects_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/projects/get', type: 'POST' },
			table: Projects_CONTAINER_SELECTOR,
			fields: [
				{ label: 'Name', name: 'sip_projects.name' },
				{ label: 'Description', name: 'sip_projects.description' },
				{ label: 'Client', name: 'sip_projects.client_id', type: 'select2' },
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/setting/projects/get', type: 'POST' },
			columns: [
				{
					data: 'sip_projects.name',
					title: 'Name',
					sClass: 'editable exportable',
				},
				{
					data: 'sip_projects.description',
					title: 'Description',
					sClass: 'editable exportable',
				},
				{
					data: 'sip_projects.client_id',
					title: 'Client',
					sClass: 'editable exportable',
					render: function ( data, type, row ) {
						return row.sip_clients.name;
					}
				},
				

			]
		}
	};
	
	InitDatatableEditor( Clients_Config );
	
	InitDatatableEditor( Projects_Config );
	
})(jQuery, window);