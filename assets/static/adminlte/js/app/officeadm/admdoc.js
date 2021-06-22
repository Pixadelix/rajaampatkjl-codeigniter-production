$(document).ready(function() {

	/* AdminDocumentType */
	var AdminDocumentType_CONTAINER_SELECTOR = '#admin-document-type-editor';
	var AdminDocumentType_Config = {
		CONTAINER_SELECTOR: AdminDocumentType_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/officeadm/document/get_doctype', type: 'POST' },
			table: AdminDocumentType_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Code:',
					name: 'type',
					fieldInfo: 'input document type code (required)',
				},
				{
					label: 'Desc:',
					name: 'desc',
					fieldInfo: 'input document type description (optional)',
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/officeadm/document/get_doctype', type: 'POST' },
			columns: [
				{
					data: 'type',
					title: 'Code',
					sClass: 'editable exportable',
				}, {
					data: 'desc',
					title: 'Description',
					sClass: 'editable exportable',
				}
			]
		}
	};

	/* AdminDocumentGroup */
	var AdminDocumentGroup_CONTAINER_SELECTOR = '#admin-document-group-editor';
	var AdminDocumentGroup_Config = {
		CONTAINER_SELECTOR: AdminDocumentGroup_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/officeadm/document/get_docgroup', type: 'POST' },
			table: AdminDocumentGroup_CONTAINER_SELECTOR,
			fields: [
				{
					label: 'Group:',
					name: 'group',
					fieldInfo: 'input document group (required)',
				},
				{
					label: 'Desc:',
					name: 'desc',
					fieldInfo: 'input document group description (optional)',
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: '/officeadm/document/get_docgroup', type: 'POST' },
			columns: [
				{
					data: 'group',
					title: 'Group',
					sClass: 'editable exportable',
				}, {
					data: 'desc',
					title: 'Description',
					sClass: 'editable exportable',
				}
			]
		}
	};

	/* AdminDocument */
	var AdminDocument_CONTAINER_SELECTOR = '#admin-document-editor';
	var AdminDocument_Config = {
		CONTAINER_SELECTOR: AdminDocument_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
		
			ajax: { url: "/officeadm/document/get", type: 'POST' },
			table: AdminDocument_CONTAINER_SELECTOR,
			fields: [
				{
					label: "Type:",
					name: "type",
					type: "select2",
					def: "INV",
					fieldInfo: 'choose document type (required)',
				}, {
					label: "Group:",
					name: "group",
					type: "select2",
					def: "MV.TMS",
					fieldInfo: 'choose document group (required)',
				}, {
					label: "Ref. Date:",
					name: "refdate",
					type: "datetime",
					format: "DD\/MM\/YY",
					def: function () { return new Date(); },
					fieldInfo: 'input reference date (required)',
				}, {
					label: 'Notes:',
					name: 'notes',
					fieldInfo: 'input document notes (required)',
				}, {
					label: "Content:",
					name: "content",
					type: "ckeditor",
					fieldInfo: 'input document content (optional)',
				}
			]
		},
		DATATABLE_CONFIG: {
			ajax: { url: "/officeadm/document/get", type: 'POST' },
			order: [ [ 1, 'desc' ] ],
            responsive: false,
			columns: [
				{
					data: 'id',
					title: 'ID',
                    visible: false,
                }, {
					data: null,
					title: 'Ref. Code',
					sClass: 'exportable monospace',
					render: function ( data, type, row ) {
						var _day = row.refdate ? row.refdate.substr(0, 2) : '';
						var _mon = row.refdate ? row.refdate.substr(3, 2) : '';
						var _yea = row.refdate ? row.refdate.substr(6, 2) : '';
						
						return row.id+'/'+row.type+'/'+row.group+'/'+_mon+_yea;
					},
					orderable: false,
					searchable: false,
				}, {
					data: 'refdate',
					title: 'Date',
					sClass: 'exportable'
				}, {
					data: 'type',
					title: 'Type',
					sClass: 'exportable'
				}, {
					data: 'group',
					title: 'Group',
					sClass: 'exportable',
				}, {
					data: 'notes',
					title: 'Notes',
					sClass: 'editable exportable',
				
				}, {
					data: "content",
					title: 'Content',
					sClass: 'exportable doc-content',
                    visible: false,
				}
			]
		}
	};


	
	
	InitDatatableEditor( AdminDocument_Config );
	
	InitDatatableEditor( AdminDocumentType_Config );
	
	InitDatatableEditor( AdminDocumentGroup_Config );
	
});