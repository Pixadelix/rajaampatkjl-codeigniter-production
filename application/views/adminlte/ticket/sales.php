<style>
#ticket-sales-form {
    display: flex;
    flex-flow: row wrap;
}
 
#ticket-sales-form fieldset {
    flex: 2;
}
 
#ticket-sales-form fieldset.full {
    flex: 3 100%;
}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
		<h1><?php echo isset($PAGE_TITLE) ? $PAGE_TITLE : 'Blank page'; ?> 
		<small>Registered Visitors</small></h1>
		<?php echo isset($bread) ? $bread : null; ?>
	</section>
	<!-- Main content -->
	<section class="content">
		<!-- Default box -->
		<div class="box box-solid box-success crowded-box">
			<div class="box-header with-border">
				<h3 class="box-title">Registered Visitors</h3>
				<div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
			</div>
			<div class="box-body full">
                <table id="ticket-sales-editor" class="table-crowded display table table-condensed table-striped table-hover table-bordered" data-page-length="25" style="width:100%">
					<?php /*<thead>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
							<th></th>
						</tr>
					</tbody>
					<tfoot></tfoot>
					*/?>
                </table>
            </div>
			<div class="box-footer">List of registered visitors.</div>
		</div>
		
    </section>
</div>

<div id="ticket-sales-form">
    <fieldset class="">
		<editor-field name="kjl_ticket_sales.event_id"></editor-field>
        <editor-field name="kjl_ticket_sales.office_id"></editor-field>
        <editor-field name="kjl_ticket_sales.operator_id"></editor-field>
        <editor-field name="kjl_ticket_sales.kjl_card_number"></editor-field>
		<editor-field name="kjl_ticket_sales.ticket_start_date"></editor-field>
		<editor-field name="kjl_ticket_sales.ticket_expired_date"></editor-field>
		<editor-field name="kjl_ticket_sales.payment_method"></editor-field>
		<hr/>
		
        <editor-field name="kjl_ticket_sales.full_name"></editor-field>
        <editor-field name="kjl_ticket_sales.gender"></editor-field>
        <editor-field name="kjl_ticket_sales.country_id"></editor-field>
        <editor-field name="kjl_ticket_sales.id_card_type"></editor-field>
        <editor-field name="kjl_ticket_sales.id_card_number"></editor-field>
        <editor-field name="kjl_ticket_sales.phone"></editor-field>
        <editor-field name="kjl_ticket_sales.email"></editor-field>
    </fieldset>
</div>

		