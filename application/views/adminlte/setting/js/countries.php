//<script><?php restricted(''); ?>


$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Countries;
        
    var Countries_CONTAINER_SELECTOR = '#countries-editor';
    var Countries_Config = {
        CONTAINER_SELECTOR: Countries_CONTAINER_SELECTOR,
        EDITOR_CONFIG: {
<?php if ( in_group('admin') ) { ?>
            canRemove: true,
<?php } ?>
            ajax: { url: '/setting/country/get/', type: 'POST' },
            table: Countries_CONTAINER_SELECTOR,
			canRemove: true,
            fields: [
                {
                    label: 'Code',
                    name: 'countries.code',
                },
                {
                    label: 'Name',
                    name: 'sys_countries.name',
                },
            ]
        },
        DATATABLE_CONFIG: {
            ajax: { url: '/setting/country/get', type: 'POST' },
            responsive: false,
            columns: [
                {
                    data: 'sys_countries.id',
					title: 'ID',
                    visible: true,
                },
                {
                    data: 'sys_countries.code',
                    title: 'Code',
                    sClass: 'exportable',
                },
                {
                    data: 'sys_countries.name',
                    title: 'Name',
                    sClass: 'exportable',
                },
            ]
        },
        
    };
    
    Countries = InitDatatableEditor( Countries_Config );

});