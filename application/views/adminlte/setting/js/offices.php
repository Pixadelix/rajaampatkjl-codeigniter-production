//<script><?php restricted(''); ?>


$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Offices;
        
    var Offices_CONTAINER_SELECTOR = '#offices-editor';
    var Offices_Config = {
        CONTAINER_SELECTOR: Offices_CONTAINER_SELECTOR,
        EDITOR_CONFIG: {
<?php if ( in_group('admin') ) { ?>
            canRemove: true,
<?php } ?>
            ajax: { url: '/setting/office/get/', type: 'POST' },
            table: Offices_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Name',
                    name: 'kjl_offices.name',
                }
            ]
        },
        DATATABLE_CONFIG: {
            ajax: { url: '/setting/office/get', type: 'POST' },
            responsive: false,
            order: [[2, 'asc']],
            columns: [
                {
                    data: 'kjl_offices.id',
					title: 'ID',
                    visible: true,
                },
                {
                    data: 'kjl_offices.name',
                    title: 'Name',
                    sClass: 'exportable',
                },
            ]
        },
        
    };
    
    Offices = InitDatatableEditor( Offices_Config );

});