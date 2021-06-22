//<script><?php restricted(''); ?>


$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var OperatorCategories;
        
    var OperatorCategories_CONTAINER_SELECTOR = '#operator-categories-editor';
    var OperatorCategories_Config = {
        CONTAINER_SELECTOR: OperatorCategories_CONTAINER_SELECTOR,
        EDITOR_CONFIG: {
<?php if ( in_group('admin') ) { ?>
            canRemove: true,
<?php } ?>
            ajax: { url: '/setting/operator-category/get/', type: 'POST' },
            table: OperatorCategories_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Name',
                    name: 'kjl_operator_categories.name',
                }
            ]
        },
        DATATABLE_CONFIG: {
            ajax: { url: '/setting/operator-category/get', type: 'POST' },
            responsive: false,
            order: [[2, 'asc']],
            columns: [
                {
                    data: 'kjl_operator_categories.id',
					title: 'ID',
                    visible: true,
                },
                {
                    data: 'kjl_operator_categories.name',
                    title: 'Name',
                    sClass: 'exportable',
                },
            ]
        },
        
    };
    
    OperatorCategories = InitDatatableEditor( OperatorCategories_Config );

});