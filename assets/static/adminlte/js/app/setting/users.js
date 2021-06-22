(function ($, window, undefined) {
	debug('app/setting/users.js loaded');
	
	/* User */
	var Users_CONTAINER_SELECTOR = '#users-editor';
	var Users_Config = {
		CONTAINER_SELECTOR: Users_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/users/get', type: 'POST' },
			table: Users_CONTAINER_SELECTOR,
			fields: [
				{ label: 'First Name', name: 'first_name' },
				{ label: 'Last Name', name: 'last_name' },
				{ label: 'E-mail', name: 'email' },
				{ label: 'Company', name: 'company' },
				{ label: 'Phone', name: 'phone' },
				{
					label: 'Groups:',
					name: 'sip_groups[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				},
				{
					label: 'Projects:',
					name: 'sip_projects[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/setting/users/get', type: 'POST' },
			customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-key"></i>',
				}
			],
			columns: [
				{
					data: 'first_name',
					title: 'First Name',
					sClass: 'editable exportable',
				},
				{
					data: 'last_name',
					title: 'Last Name',
					sClass: 'editable exportable',
				},
				{
					data: 'email',
					title: 'E-mail',
					sClass: 'editable exportable nowrap',
				},
				{
					data: 'company',
					title: 'Company',
					sClass: 'editable exportable',
				},
				{
					data: 'phone',
					title: 'Phone',
					sClass: 'editable exportable nowrap',
				},
				{
					data: "sip_groups",
					title: 'Groups',
					render: "[, ].name",
					sClass: 'exportable',
				},
				{
					data: "sip_projects",
					title: 'Projects',
					render: "[, ].name",
					sClass: 'exportable',
				},
				{
					data: 'last_login',
					title: 'Last login',
					render: function ( data, type, row ) {
						return timestampToDate( row.last_login );
						//return $.fn.dataTable.render.moment( 'X', 'DD/MMM/YY HH:mm', 'id' );
					},
					sClass: 'exportable nowrap',
				}
				
			]
		}
	};
	
	InitDatatableEditor( Users_Config );
	
})(jQuery, window);