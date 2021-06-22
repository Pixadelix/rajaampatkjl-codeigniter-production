//<script><?php restricted(''); ?>


$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Operators;
        
    var Operators_CONTAINER_SELECTOR = '#operators-editor';
    var Operators_Config = {
        CONTAINER_SELECTOR: Operators_CONTAINER_SELECTOR,
        EDITOR_CONFIG: {
<?php if ( in_group('admin') ) { ?>
            canRemove: true,
<?php } ?>
            ajax: { url: '/setting/operator/get/', type: 'POST' },
            table: Operators_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Name',
                    name: 'kjl_operators.name',
                },
                {
                    label: 'Category',
                    name: 'kjl_operators.category_id',
                    type: 'select2',
                    opts: {
                        placeholder: 'Please choose Operator category',
                    }
                },
            ]
        },
        DATATABLE_CONFIG: {
            ajax: { url: '/setting/operator/get', type: 'POST' },
            responsive: false,
            columns: [
                {
                    data: 'kjl_operators.id',
					title: 'ID',
                    visible: true,
                },
                {
                    data: 'kjl_operators.name',
                    title: 'Name',
                    sClass: 'exportable',
                },
                {
                    data: 'kjl_operator_categories.name',
                    title: 'Category',
                    sClass: 'exportable',
                },
            ]
        },
        
    };
    
    Operators = InitDatatableEditor( Operators_Config );

});