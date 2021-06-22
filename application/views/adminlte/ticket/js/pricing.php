//<script><?php restricted(''); ?>

var PRODUCT_EVENTS_COLUMNS = [
	{
		data: 'kjl_product_events.id',
		title: 'ID.',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.code',
		title: 'Code',
		sClass: 'exportable',
		render: function ( d, t, r, m ) {
			if ( 'display' === t ) {
				return '<a href="/booking/'+d+'" target="_blank">'+d+'</a>';
			}
			return d;
		}
	},
	{
		data: 'kjl_product_events.name',
		title: 'Name',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.price',
		title: 'Price',
		sClass: 'exportable text-right roboto-mono',
		render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp ', ',-' ),
	},
	{
		data: 'kjl_product_events.status',
		title: 'Status',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.location',
		title: 'Location',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.quota',
		title: 'Quota',
		sClass: 'exportable roboto-mono text-right',
	},
	{
		data: 'kjl_product_events.start_date',
		title: 'Start',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.end_date',
		title: 'Finish',
		sClass: 'exportable',
	},
	{
		data: "sys_taxes",
		title: 'Taxes',
		render: "[, ].name",
		sClass: 'exportable',
		searchable: false,
		orderable: false,
	},
	{
		data: 'kjl_product_events.template_path',
		title: 'Template',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.seq_name',
		title: 'Sequence Name',
		sClass: 'exportable',
	},
	{
		data: 'kjl_product_events.event_type',
		title: 'Type',
		sClass: 'exportable',
	}
];

$(document).ready(function() {
    

	debug('LOAD: <?php echo $path; ?>');
    
    var ProductEvents;
        
    var ProductEvents_CONTAINER_SELECTOR = '#product-events-editor';
    var ProductEvents_Config = {
        CONTAINER_SELECTOR: ProductEvents_CONTAINER_SELECTOR,

        EDITOR_CONFIG: {
            ajax: { url: '/ticket/pricing/get', type: 'POST' },
            table: ProductEvents_CONTAINER_SELECTOR,
            fields: [
                {
                    label: 'Code <sup>*</sup>',
                    name: 'kjl_product_events.code',
					attr: {
						required: true,
					}
                },
				{
                    label: 'Product Name <sup>*</sup>',
                    name: 'kjl_product_events.name',
					attr: {
						required: true,
					}
                },
				{
                    label: 'Price <sup>*</sup>',
                    name: 'kjl_product_events.price',
					attr: {
						required: true,
					},
                },
				{
                    label: 'Status <sup>*</sup>',
                    name: 'kjl_product_events.status',
					attr: {
						required: true,
					}
                },
				{
                    label: 'Location <sup>*</sup>',
                    name: 'kjl_product_events.location',
					attr: {
						required: true,
					}
                },
				{
                    label: 'Quota <sup>*</sup>',
                    name: 'kjl_product_events.quota',
					attr: {
						required: true,
					}
                },
				{
                    label: 'Start <sup>*</sup>',
                    name: 'kjl_product_events.start_date',
					type: 'datetime',
                },
				{
                    label: 'Finish <sup>*</sup>',
                    name: 'kjl_product_events.end_date',
					type: 'datetime',
                },
				{
					label: 'Taxes',
					name: 'sys_taxes[].id',
					type: 'select2',
					opts: {
						multiple: true,
					}
				},
				{
					label: 'Template <sup>*</sup>',
					name: 'kjl_product_events.template_path',
					attr: {
						required: true,
					}
				},
				{
					label: 'Sequence Name',
					name: 'kjl_product_events.seq_name',
				},
            ]
        },

        DATATABLE_CONFIG: {
			createTitle: 'New Product Event',
			editTitle: 'Edit Product Event',
            ajax: { url: '/ticket/pricing/get', type: 'POST' },
            order: [[ 1, 'desc' ]],
            scroller: true,
			responsive: true,
            columns: PRODUCT_EVENTS_COLUMNS,
        },
        
    };
    
    ProductEvents = InitDatatableEditor( ProductEvents_Config );
	
});
