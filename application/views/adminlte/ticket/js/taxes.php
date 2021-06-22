//<script><?php restricted(''); ?>

var TAXES_COLUMNS = [
	{
		data: 'sys_taxes.id',
		title: 'ID.',
		sClass: 'exportable',
		visible: false,
	},
	{
		data: 'sys_taxes.name',
		title: 'Name',
		sClass: 'exportable',
	},
	{
		data: 'sys_taxes.tax',
		title: 'Value (%)',
		sClass: 'exportable',
	},
];

$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var Taxes;
        
    var Taxes_CONTAINER_SELECTOR = '#taxes-editor';
    var Taxes_Config = {
        CONTAINER_SELECTOR: Taxes_CONTAINER_SELECTOR,

        EDITOR_CONFIG: {
            ajax: { url: '/setting/tax/get', type: 'POST' },
            table: Taxes_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Name <sup>*</sup>',
                    name: 'sys_taxes.name',
					attr: {
						required: true,
					}
                },
				{
                    label: 'Value <sup>*</sup>',
                    name: 'sys_taxes.tax',
					attr: {
						required: true,
					}
                },
            ]
        },

        DATATABLE_CONFIG: {
			createTitle: 'New Tax',
			editTitle: 'Edit Tax',
            ajax: { url: '/setting/tax/get', type: 'POST' },
            order: [[ 2, 'asc' ]],
            scroller: true,
			responsive: false,
            columns: TAXES_COLUMNS,
			disableButtons: false,
        },
        
    };
    
    Taxes = InitDatatableEditor( Taxes_Config );
	
});
