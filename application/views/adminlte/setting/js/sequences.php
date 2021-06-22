//<script><?php restricted(''); ?>


$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Sequence;
        
    var Sequence_CONTAINER_SELECTOR = '#sequence-editor';
    var Sequence_Config = {
        CONTAINER_SELECTOR: Sequence_CONTAINER_SELECTOR,
        EDITOR_CONFIG: {
<?php if ( in_group('admin') ) { ?>
            canRemove: true,
<?php } ?>
            ajax: { url: '/setting/sequence/get/', type: 'POST' },
            table: Sequence_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Sequence Name',
                    name: 'sys_sequence_data.sequence_name',
                },
                {
                    label: 'Current Value',
                    name: 'sys_sequence_data.sequence_cur_value',
                },
            ]
        },
        DATATABLE_CONFIG: {
            ajax: { url: '/setting/sequence/get', type: 'POST' },
            responsive: false,
            columns: [
                {
                    data: 'sys_sequence_data.sequence_name',
					title: 'Sequence Name',
					sClass: 'exportable',
                },
                {
                    data: 'sys_sequence_data.sequence_cur_value',
                    title: 'Current Value',
                    sClass: 'exportable',
                },
            ]
        },
        
    };
    
    Countries = InitDatatableEditor( Sequence_Config );

});