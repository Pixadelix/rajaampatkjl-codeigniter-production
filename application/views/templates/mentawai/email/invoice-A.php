
<div class="wrapper" style="font-size: 80%">
	<!-- Main content -->
	<section class="invoice">
		<!-- title row -->
		<h2>{event_name}<br/><small class="pull-right">Date: {invoice_date}</small></h2>

    <table width="100%" border="0" cellpadding="5" cellspacing="10">
		<tr>
			<td border="1">
				From<br/>
				<address><strong>{merchant_name}</strong><br>
				</address>
			</td>
			<td border="1">
				To<br/>
				<address>
					<strong>{customer_name}</strong><br>
					Phone: {customer_phone}<br>
					Email: {customer_email}
				</address>
			</td>
			<td border="1">
				<b>Invoice #{invoice_id}</b><br>
				<br>
				<b>Order #</b>{order_uuid}<br>
			</td>
		</tr>
	</table>


	<table border="0" cellpadding="5" cellspacing="2">
		<thead>
			<tr bgcolor="gray" color="white">
				<th>Qty</th>
				<th>Name</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Country</th>
			</tr>
		</thead>
		<tbody>
		{tickets}
			<tr bgcolor="#f0f0f0">
				<td>1</td>
				<td>{full_name}</td>
				<td>{email}</td>
				<td>{phone}</td>
				<td>{ticket_start_date}</td>
			</tr>
		{/tickets}
		</tbody>
	</table>


    <div class="row">
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <div class="table-responsive">
          <table class="table">
            <tr>
              <th style="width:50%">Subtotal:</th>
              <td>$250.30</td>
            </tr>
            <tr>
              <th>Tax (9.3%)</th>
              <td>$10.34</td>
            </tr>
            <tr>
              <th>Total:</th>
              <td>$265.24</td>
            </tr>
          </table>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->


<?php
/*

<h1>Invoice</h1>
<h2>{order_uuid}</h2>

<table border="1" cellspacing="3" cellpadding="4" style="font-size: 8px">
	{tickets}
		<tr>
			<td>{full_name}</td>
			<td>{email}</td>
			<td>{phone}</td>
			<td>{ticket_start_date}</td>
		</tr>
	{/tickets}
</table>
<table border="1" cellspacing="3" cellpadding="4">
    <tr>
        <th>#</th>
        <th align="right">RIGHT align</th>
        <th align="left">LEFT align</th>
        <th>4A</th>
    </tr>
    <tr>
        <td>1</td>
        <td bgcolor="#cccccc" align="center" colspan="2">A1 ex<i>amp</i>le <a href="http://www.tcpdf.org">link</a> column span. One two tree four five six seven eight nine ten.<br />line after br<br /><small>small text</small> normal <sub>subscript</sub> normal <sup>superscript</sup> normal  bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla<ol><li>first<ol><li>sublist</li><li>sublist</li></ol></li><li>second</li></ol><small color="#FF0000" bgcolor="#FFFF00">small small small small small small small small small small small small small small small small small small small small</small></td>
        <td>4B</td>
    </tr>
    <tr>
        <td>'.$subtable.'</td>
        <td bgcolor="#0000FF" color="yellow" align="center">A2 € &euro; &#8364; &amp; è &egrave;<br/>A2 € &euro; &#8364; &amp; è &egrave;</td>
        <td bgcolor="#FFFF00" align="left"><font color="#FF0000">Red</font> Yellow BG</td>
        <td>4C</td>
    </tr>
    <tr>
        <td>1A</td>
        <td rowspan="2" colspan="2" bgcolor="#FFFFCC">2AA<br />2AB<br />2AC</td>
        <td bgcolor="#FF0000">4D</td>
    </tr>
    <tr>
        <td>1B</td>
        <td>4E</td>
    </tr>
    <tr>
        <td>1C</td>
        <td>2C</td>
        <td>3C</td>
        <td>4F</td>
    </tr>
</table>
*/
?>