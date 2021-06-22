
<div class="wrapper" style="font-size: 80%">
	<!-- Main content -->
	<section class="invoice">
		<!-- title row -->
		<h2>AdminLTE, Inc. <small class="pull-right">Date: 2/10/2014</small></h2>

    <table width="100%" border="0" cellpadding="5" cellspacing="10">
		<tr>
			<td border="1">
				From<br/>
				<address><strong>Admin, Inc.</strong><br>
					795 Folsom Ave, Suite 600<br>
					San Francisco, CA 94107<br>
					Phone: (804) 123-5432<br>
					Email: info@almasaeedstudio.com
				</address>
			</td>
			<td border="1">
				To<br/>
				<address>
					<strong>John Doe</strong><br>
					795 Folsom Ave, Suite 600<br>
					San Francisco, CA 94107<br>
					Phone: (555) 539-1037<br>
					Email: john.doe@example.com
				</address>
			</td>
			<td border="1">
				<b>Invoice #007612</b><br>
				<br>
				<b>Order ID:</b> 4F3S8J<br>
				<b>Payment Due:</b> 2/22/2014<br>
				<b>Account:</b> 968-34567
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
      <!-- accepted payments column -->
      <div class="col-xs-6">
        <p class="lead">Payment Methods:</p>
        

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr
          jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
      </div>
      <!-- /.col -->
      <div class="col-xs-6">
        <p class="lead">Amount Due 2/22/2014</p>

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
              <th>Shipping:</th>
              <td>$5.80</td>
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