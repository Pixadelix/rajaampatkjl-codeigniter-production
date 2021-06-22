
(function ($, DataTable) {
    if ( ! DataTable.ext.editorFields ) {
        DataTable.ext.editorFields = {};
    }
    
    var Editor = DataTable.Editor;
    var _fieldTypes = DataTable.ext.editorFields;
    
    _fieldTypes.Users_status = {
        create: function ( conf ) {
            var that = this;
            
            conf._enabled = true;
            
            // Create the elements to use for the input
            conf._input = $(
                '<div id="'+Editor.safeId( conf.id )+'">'+
                    '<button class="inputButton btn-success" value="1"><i class="fa fa-check"></i>Active</button>'+
                    '<button class="inputButton btn-danger" value="0"><i class="fa fa-square"></i>Inactive</button>'+
                '</div>'
            );
            
            // Use the fact that we are called in the Editor instance's scope to call
            // the API method for setting the value when needed
            $('button.inputButton', conf._input).click( function() {
                if ( conf._enabled ) {
                    that.set( conf.name, $(this).attr('value') );
                }
                
                return false;
            })
            
            return conf._input;
        },
        
        get: function ( conf ) {
            return $('button.selected', conf._input).attr('value');
        },
        
        set: function ( conf, val ) {
            $('button.selected', conf._input).removeClass( 'selected' );
            $('button.inputButton[value='+val+']', conf._input).addClass('selected');
        },
        
        enable: function ( conf ) {
            conf._enabled = true;
            $(conf._input).removeClass( 'disabled' );
        },
        
        disable: function ( conf ) {
            conf._enabled = false;
            $(conf._input).addClass( 'disabled' );
        }
    }
})(jQuery, jQuery.fn.dataTable);

(function ($, window, undefined) {
	
	/* User */
    var Users = null;
	var Users_CONTAINER_SELECTOR = '#users-editor';
	var Users_Config = {
		CONTAINER_SELECTOR: Users_CONTAINER_SELECTOR,
		EDITOR_CONFIG: {
			ajax: { url: '/setting/user/get', type: 'POST' },
			table: Users_CONTAINER_SELECTOR,
			canRemove: true,
			fields: [
                { label: 'Username', name: 'sys_users.username' },
				{ label: 'Full Name', name: 'sys_users.first_name' },
				{ label: 'E-mail', name: 'sys_users.email' },
				/*{ label: 'Department', name: 'sys_users.company' },
				{ label: 'Phone', name: 'sys_users.phone' }, */
				{
					label: 'Groups:',
					name: 'sys_groups[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				},
                {
                    label: 'Password',
                    name: 'sys_users.password',
                    type: 'password',
                    def: '',
                    _fieldInfo: '*Biarkan kosong kalau tidak ingin mengubah password.',
                },
                {
                    label: 'Status',
                    name: 'sys_users.active',
                    type: 'select2',
					options: [
						{ label: 'Enabled', value: 1 },
						{ label: 'Disabled', value: 0 },
					],
                    _separator: '|',
                    _options: [
                        { label: '<span class="text-success">Enabled</span>', value: 1 },
                        { label: '<span class="text-danger">Disabled</span>', value: 0 }
                    ],
					def: 1,
                },
                {
                    label: 'Photo',
                    name: 'sys_users.profile_photo',
                    type: 'upload',
                    display: function ( id ) {
                        try {
                            return '<img src="/'+Users.editor.file( 'sys_posts', id ).media_web_path+'"/>';
                        }
                        catch (err) {
                        }
                    },
                    clearText: 'Clear',
                    noImageText: 'No Photo'
                }
			]
		},
		DATATABLE_CONFIG: {
            responsive: false,
			ajax: { url: '/setting/user/get', type: 'POST' },
            orderFixed: [[4, 'asc']],
            srowGroup : {
                dataSrc: 'sys_users.company',
                startRender: function ( rows, group ) {
                    
                    return group ? group : '' + ' ('+rows.count()+')';
                },
                endRender: null,
            },
            scroller: false,
			customButtons: [
				{
					extend: 'selectedSingle',
					text: '<i class="fa fa-key"></i>',
				}
			],
			columns: [
                {
                    data: 'sys_users.username',
                    title: 'Username',
                    sClass: 'editable exportable',
                },
				{
					data: 'sys_users.first_name',
					title: 'Full Name',
					sClass: 'editable exportable',
				},
				{
					data: 'sys_users.email',
					title: 'E-mail',
					sClass: 'editable exportable nowrap',
				},
				{
					data: 'sys_users.company',
					title: 'Department',
					sClass: 'editable exportable',
				},
				{
					data: 'sys_users.phone',
					title: 'Phone',
					sClass: 'editable exportable nowrap',
				},
				{
					data: "sys_groups",
					title: 'Role',
					render: "[, ].description",
					sClass: 'exportable',
                    searchable: false,
                    orderable: false,
				},
				{
					data: 'sys_users.last_login',
					title: 'Last login',
					render: function ( data, type, row ) {
						return timestampToDate( row.sys_users.last_login );
						//return $.fn.dataTable.render.moment( 'X', 'DD/MMM/YY HH:mm', 'id' );
					},
					sClass: 'exportable nowrap',
				},
                {
                    data: 'sys_users.active',
                    title: 'Status',
                    sClass: 'exportable',
                    render: function ( data, type, row ) {
                        if ( type == 'display' ) {
                            if ( data == 1 ) {
                                return '<span class="text-success">Enabled</span>';
                            } else {
                                return '<span class="text-danger">Disabled</span>';
                            }
                        }
                        return data;
                    }
                    
                },
                {
                    data: 'sys_users.profile_photo',
                    render: function ( id ) {
                        //debug(Users.editor.files());
                        try {
                            return id ? '<img src="/'+Users.editor.file( 'sys_posts', id ).media_thumbnail_path+'"/>' : null;
                        }
                        catch (err) {
                        }
                    },
                    Srender: function ( d, t, r ) {
                        debug( r ); return;
                        if( !d.length ) {
								return 'No Photo';
							}
							str_val = '';
							for( i = 0; i < d.length; i++ ) {
								str_val += '<a href="/'+d[i].media_web_path+'"  class="html5lightbox" title="Profile photo #: '+r.sys_users.id+'" data-group="profile-photo-'+r.sys_users.id+'" data-thumbnail="/'+d[i].media_thumbnail_path+'">' +
											//'<i class="fa fa-file-image-o"></i> ' +
											'<img class="img-thumbnail with-border" src="/'+d[i].media_thumbnail_path+'">' +
										'</a>';
							}
							return str_val;
                        }
                    ,
                    defaultContent: 'No Photo',
                    title: 'Profile Photo'
                }
			
			],
            rowCallback: function ( row, data ) {
                // Set the checked state of the checkbox in the table
                $('input.editor-active', row).prop( 'checked', data.active == 1 );
            }
            
		}
	};
	
	Users = InitDatatableEditor( Users_Config );
    
    $(Users_CONTAINER_SELECTOR).on('change', 'input.editor-active', function() {
        Users.editor
            .edit( $(this).closest('tr'), false )
            .set( 'active', $(this).prop( 'checked' ) ? 1 : 0 )
            .submit();
    } );
	
})(jQuery, window);