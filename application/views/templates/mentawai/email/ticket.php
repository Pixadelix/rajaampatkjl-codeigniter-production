<?php

//var_dump($ticket);

$event = $order->event();
$tickets = $order->tickets();

$tax = $order->total_amount * .1;

?>
<html>
  <head>

  </head>
  <body>
<div marginwidth="0" marginheight="0" style="font-family:Arial,sans-serif;background:#f1f1f1;padding:20px 0 0 0">
	<table cellpadding="0" cellspacing="0" width="100%" border="0" align="center" style="padding:25px 0 15px 0">
		<tbody>
			<tr>
				<td width="100%" valign="top">
					<table cellpadding="0" cellspacing="0" width="600" border="0" align="center" bgcolor="f2f2f2">
						<tbody>
							<tr>
								<td valign="top">
									<table cellpadding="0" cellspacing="0" width="600" border="0" align="center">
										<tbody>
											<tr>
												<td valign="top" width="300" style="background-color:#1f0000;padding-top:10px">
													<img src="http://event.mediavista.id/assets/static/img/logo-200x50.png" style="display:block;background-color:#1f0000;color:#010101;padding:10px" alt="" border="0">
												</td>
												<td width="300" valign="right" style="background-color:#1f0000">
													<img src="http://event.mediavista.id/assets/static/img/logo-50x50.png" style="display:block;background-color:#1f0000;color:#010101;float:right" alt="" border="0" height="50" width="50">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<table cellpadding="0" cellspacing="0" width="600" border="0" align="center">
										<tbody>
											<tr>
												<td valign="top" width="500" style="background-color:#ffffff;color:#666666;font-size:15px;font-family:Arial,sans-serif;text-align:left;padding:30px 10px 20px 20px;line-height:20px">
													Dear Customer, <br>Tiket Anda sudah terkonfirmasi !
													<b>!
</b>
												</td>
												<td valign="top" width="100" style="background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:left;padding:30px 20px 20px 10px;line-height:20px">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" width="540" style="padding-top:20px">
									<table cellpadding="0" cellspacing="0" width="540" border="0" align="center">
										<tbody>
											<tr>
												<td align="left" valign="top" width="345" style="background-color:#f2f2f2;color:#222222;font-size:12px;font-family:Arial,sans-serif;text-align:left;padding:10px 20px 40px 0px;line-height:25px">
													<span style="color:#a4a8ac;line-height:23px">
ID PEMESANAN
</span>
												
													<br>
													<b style="font-size:16px"><?php echo strtoupper($order->uuid); // HICE01416Y91P5 ?></b>
												</td>
												<td valign="top" width="115" style="background-color:#f2f2f2;color:#222222;font-size:12px;font-family:Arial,sans-serif;text-align:center;padding:10px 20px 40px 10px;line-height:20px">
													<img src="https://ci6.googleusercontent.com/proxy/Txvcn0MvoOwi3sBJRVJ3ll7rEocIDIlTrTq5K4CTJiBaMhtUo18mBBVYH9DwOV5y-W2wYQMBbTGi2fMLOrPyDYCehB3go8nyTdlkYSO9-erSZNvMQIfvOc0sMozRvsczavUlvL3lUdfSool2C6CM5Q1H1S3oCEGht1_jrkHB2kB2w9Yu-qbfmoExz2ZMNN1jxkNvYgMIBpQ=s0-d-e1-ft#https://in.bookmyshow.com/secure/barcode/?IsImage=Y&amp;strBarcodeType=qrcode&amp;strBarcodeTxt=HICE01416Y91P5&amp;intHeight=100&amp;intWidth=100" style="width:100px;height:100px;float:right">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<table cellpadding="0" cellspacing="0" width="540" border="0" align="center" bgcolor="#1f0000">
										<tbody>
											<tr>
												<td width="15">
												</td>
												<td width="370" valign="top" style="color:#ffffff;font-size:15px;font-family:Arial,sans-serif;text-align:left;padding:25px 10px 25px 15px;line-height:24px;border-right:1px dotted #ffffff">
													<span style="font-size:20px;font-weight:bold"><?php echo ucfirst($event->name); ?> </span>
													<br>
												<?php echo $event->location; // Lokasi event?><br>
												From: <?php echo _ldate_($event->start_date, '%H:%M %Z | %A, %d %B %Y'); // Waktu event?><br>
												To: <?php echo _ldate_($event->end_date, '%H:%M %Z | %A, %d %B %Y'); // Waktu event?>
												</td>
												<td width="140" valign="top" style="color:#ffffff;font-size:15px;font-family:Arial,sans-serif;text-align:center;padding:25px 10px 15px 10px;line-height:20px">
													<img src="https://ci4.googleusercontent.com/proxy/aKRcEiuKi4m70FJQOkUofwxMkwUv5DM4vT-gb8pg3P0dmlrfTbFrfrUV21oAs73hRt9qxrAimgZ2HIu8GLHGKQ=s0-d-e1-ft#http://id.bmscdn.com/emailer/icon/seat.png" alt="" width="29" height="25" border="0">
													<br>
													<b><?php echo money_format('%= (#10.0n', $order->total_amount); // 460000 ?> <br/>
													<?php echo count($tickets); ?> ticket <?php echo count($tickets) > 1 ? '(s)' : ''; ?></b>
													<br>
												</td>
												<td width="15">
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<table cellpadding="0" cellspacing="0" width="538" border="0" align="center" bgcolor="#ffffff" style="border:1px solid #e1e5e8">
										<tbody>
											<tr>
												<td width="538" valign="top">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center" bgcolor="#ffffff" style="padding:0 30px">
														<tbody>
															<tr>
																<td valign="top" style="width:478px;background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:left;padding:10px 10px 10px 0;border-bottom:1px solid #e1e5e8">
																	<span style="font-size:12px">DETAIL PEMESANAN </span>
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td width="538" valign="top">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center">
														<tbody>
															<tr>
																<td style="width:30px">
																</td>
																<td valign="top" style="width:265px;background-color:#ffffff;color:#666666;font-size:15px;font-family:Arial,sans-serif;text-align:left;padding:10px 10px 10px 0;border-bottom:2px dotted #bfbfbf">
																	<span style="font-size:18px;font-weight:bold">JUMLAH TIKET</span>
																	<br>
																	<p>
																		<span style="color:#666666;font-size:12px;padding:0 0 0 0px">Incl. Tax at 10%</span>
																	</p>
																</td>
																<td valign="top" width="213" style="background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:right;padding:10px 0 10px 10px;border-bottom:2px dotted #bfbfbf"><br><br>
																	<p><?php echo money_format('%= (#10.0n', $tax); ?></p>
																</td>
																<td style="width:30px">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td valign="top" width="538">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center">
														<tbody>
															<tr>
																<td style="width:30px">
																</td>
																<td valign="top" style="width:265px;padding:10px 10px 10px 0;background-color:#ffffff;color:#666666;font-size:15px;font-family:Arial,sans-serif;text-align:left;line-height:20px">Quantity</td>
																<td valign="top" width="213" style="background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:right;padding:0 0 0 10px;vertical-align:top">
																	<br><?php echo count($tickets); ?></td>
																<td style="width:30px">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td valign="top" width="538">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center">
														<tbody>
															<tr>
																<td style="width:30px">
																</td>
																<td valign="top" style="width:265px;padding:10px 10px 10px 0;background-color:#ffffff;color:#666666;font-size:15px;font-family:Arial,sans-serif;text-align:left;line-height:20px">
																	(+) Biaya tambahan (Wifii)<br>
																	<span style="color:#666666;font-size:12px;padding:0 0 0 25px">Termasuk pajak servis</span>
																</td>
																<td valign="top" width="213" style="background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:right;padding:0 0 0 10px;vertical-align:top">
																	<br>Rp.0.00</td>
																<td style="width:30px">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td valign="top" width="538">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center">
														<tbody>
															<tr>
																<td style="width:30px">
																</td>
																<td valign="top" style="width:265px;padding:10px 10px 10px 0;background-color:#ffffff;color:#666666;font-size:15px;font-family:Arial,sans-serif;text-align:left;line-height:20px">Biaya tambahan</td>
																<td valign="top" width="213" style="background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:right;padding:0 0 0 10px;vertical-align:top">
																	<br>Rp.0.00</td>
																<td style="width:30px">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td valign="top" width="538">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center">
														<tbody>
															<tr>
																<td style="width:30px">
																</td>
																<td valign="top" style="width:265px;padding:10px 10px 10px 0;background-color:#ffffff;color:#666666;font-size:15px;font-family:Arial,sans-serif;text-align:left;line-height:20px">Diskon</td>
																<td valign="top" width="213" style="background-color:#ffffff;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:right;padding:0 0 0 10px;vertical-align:top">
																	<br>Rp.0.00</td>
																<td style="width:30px">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
											<tr>
												<td valign="top" width="538">
													<table cellpadding="0" cellspacing="0" width="538" border="0" align="center">
														<tbody>
															<tr>
																<td style="width:30px">
																</td>
																<td valign="top" style="width:265px;padding:15px 10px 0px 0;background-color:#ffffff;color:#666666;font-size:10px;font-family:Arial,sans-serif;text-align:left;border-top:2px dotted #bfbfbf">JUMLAH YANG DIBAYAR</td>
																<td valign="top" width="213" style="padding:15px 10px 15px 0;font-size:18px;font-weight:bold;font-family:Arial,sans-serif;text-align:right;background-color:#ffffff;color:#666666;border-top:2px dotted #bfbfbf"><p><?php echo money_format('%= (#10.0n', $order->total_amount+$tax); ?></td>
																<td style="width:30px">
																</td>
															</tr>
														</tbody>
													</table>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" width="540">
									<table cellpadding="0" cellspacing="0" width="540" border="0" align="center">
										<tbody>
											<tr>
												<td valign="top" width="195" style="background-color:#efefef;color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:left;padding:10px 10px 35px 10px;line-height:20px">
													<b>NOMER KONFIRMASI</b>
													<br><?php echo strtoupper($order->payment_id); // 29948855?></td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" width="540" style="background-color:#ffffff">
									<table cellpadding="0" cellspacing="0" width="540" border="0" align="center">
										<tbody>
											<tr>
												<td valign="top" width="540" style="color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:justify;padding:30px 0 10px;line-height:20px">
													<span style="font-size:12px">
														<b>Instruksi penting</b>
													</span>
													<br>
													<br> Tiket yang sudah dipesan tidak dapat dibatalkan, ditukar atau dikembalikan.<br> Pajak layanan dikumpul dan dibayarkan ke pemerintah.<br>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top" width="540" style="background-color:#ffffff">
									<table cellpadding="0" cellspacing="0" width="540" border="0" align="center">
										<tbody>
											<tr>
												<td valign="top" width="540" style="color:#666666;font-size:12px;font-family:Arial,sans-serif;text-align:justify;padding:0px 0 40px;line-height:20px">
													<ul style="padding-left:15px">
														<li style="list-style:none">
															<br>
															<strong style="font-size:16px">Purchase Conditions</strong>
															<br>
														</li>
														<li>Valid ID is required for verification at doors during entry.</li>
														<li>Each customer is entitled to purchase up to a maximum of 6 tickets in a single transaction ONLY.</li>
														<li>Anyone above the age of 3 years old must purchase a ticket</li>
														<li>While purchasing your voucher, please ensure you enter a valid email address and mobile phone number.</li>
														<li>After the payment process, you will receive a confirmation email and voucher (this is NOT a ticket). You will be required to redeem your actual ticket on the day of the event.</li>
														<li>Please note that the voucher is NOT a ticket and will not permit entry.</li>
														<li>Only successful payment will enable delivery of confirmation voucher.</li>
														<li>Once booked, NO cancellation, exchange or refund is permitted under any circumstance.</li>
														<li>The amount paid is only for entry ticket. Accommodation, transportation, Food and Beverage etc are not included in the amount paid.</li>
														<li>You may be refused entry and your voucher will be cancelled if your ticket is purchased from an unauthorized ticket seller or ticket scalper. The promoters take no liability for fake tickets; do not buy your tickets from anywhere than <a href="http://tickets.pixadelix.com" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en&amp;q=http://id.bookmyshow.com&amp;source=gmail&amp;ust=1524719577869000&amp;usg=AFQjCNEkVuppRMW47c-yUreIMTyqhyAnlg">tickets.pixadelix.com</a>.</li>
														<li>Lost or stolen tickets will not be replaced or reissued, even if you have proof of purchase. Your ticket is your responsibility.</li>
														<li style="list-style:none">
															<br>
															<strong style="font-size:16px">Redemption</strong>
															<br>
														</li>
														<li>Customer must produce valid ID (KTP, Drivers License, Passport, and Residence ID) that matches the credentials while booking the tickets online to enable exchange of voucher for tournament wristbands or valid credentials/lanyard.</li>
														<li>For redemption of the voucher for the actual ticket, customers can do this at the venue on the day of the show.</li>
														<li>You must hold your ticket at all times in the venue. Dont lose it!</li>
														<li>Any Guest within the tournament not in possession of a valid wristband or valid credential/lanyard will be removed. There are NO exceptions.</li>
														<li style="list-style:none">
															<br>
															<strong style="font-size:16px">General Announcements</strong>
															<br>
														</li>
														<li>The organizers recommend that ticket holders arrive at the venue well in-advance to ensure smooth entry in-time for the main tournament on the day. All ticket holders may be subject to body/bag checks at all entry points into the tournament arena.</li>
														<li>Customers will be allowed entry into their selected categories only.</li>
														<li>The promoters take no liability for fake tickets, or duplicate vouchers if already redeemed and will not honour such fraudulent behaviour.</li>
														<li>Strictly NO professional photography, video and/or audio recording of any kind is allowed during this performance.</li>
														<li>The Promoter reserves the right to revise tournament competitors, times, venue layout and audience capacity without prior notice.</li>
														<li>Rights of Admission Reserved, the organizers and staff reserve the right to refuse entry and/or expel from the premises guests who are behaving in a disorderly, offensive, or inappropriate manner and no refunds will be given.</li>
														<li>The organizers do not take any responsibility towards loss and/or damage of any personal belongings, regardless of fault or reason.</li>
														<li>By obtaining an admission ticket to the Event and/or entering the Event venue, the Visitor unconditionally consents to the aforementioned recordings being made and to the processing, publication, and use thereof, in the broadest sense, without the organizing company or any of its affiliated companies being liable to pay any compensation to him or her at any time</li>
														<li>The Visitor hereby irrevocably renounces any interest that he or she could have in the aforementioned recordings. Insofar as the Visitor has any copyright, neighboring rights and/or portrait rights to the aforementioned recordings, he or she hereby unreservedly assigns these rights to the organizing company and hereby irrevocably renounces his or her personality rights and/or will not invoke these rights.</li>
														<li>No illegal or illicit substances, drugs are allowed at the venue.</li>
														<li>No unauthorized vending allowed within or around the venue.</li>
														<li>Any outside food or beverages are strictly prohibited inside the venue.</li>
														<li>Latecomers will be allowed entry at a suitable time during the performance at the discretion of floor staff. NO refund/compensation will be given to a latecomer who is allowed entry into the performance hall at any time after the tournament has started.</li>
														<li>No tickets may be used for competitions, promotions or hospitality packages without the prior written consent of the Promoter, and any ticket so used will become voidable and the holder may be refused entry or removed from the Site.</li>
														<li>Other ticketing terms and conditions apply.</li>


														<li style="list-style:none">
															<br>
															<strong style="font-size:16px">Syarat Pembelian</strong>
															<br>
														</li>
														<li>KTP/SIM/Paspor yang masih berlaku untuk verifikasi sebelum memasuki area pertandingan.</li>
														<li>Tiap pembeli hanya boleh membeli maksimum 6 (enam) tiket dalam sekali transaksi.</li>
														<li>Pengunjung berusia di atas 3 tahun harus membeli tiket.</li>
														<li>Saat membeli voucher, pastikan memasukkan e-mail dan nomor telepon selular yang aktif.</li>
														<li>Setelah proses pembelian, Anda akan menerima e-mail konfirmasi dan voucher / e-ticket . Ingat, voucher / e-ticket itu bukan tiket. Anda diharuskan untuk menukarkannya pada hari acara berlangsung.</li>
														<li>Sekali lagi, voucher atau e-ticket bukan tiket dan Anda tidak bisa masuk menggunakan itu sebagai tanda masuk.</li>
														<li>Hanya transaksi yang berhasil yang bisa mendapatkan voucher / e-ticket.</li>
														<li>Setelah tiket dipesan, tidak boleh ada pembatalan, penukaran, atau refund dalam situasi apapun.</li>
														<li>Harga yang dibeli hanya untuk tiket masuk. Akomodasi, transportasi, makanan, minuman, tidak termasuk dalam tiket yang dibeli.</li>
														<li>Anda bisa ditolak masuk dan voucher/e-ticket dibatalkan jika transaksi dilakukan lewat penjual tiket tidak resmi atau calo. Promotor tidak bertanggung jawab atas tiket palsu. Jangan membeli tiket di luar <a href="http://tickets.pixadelix.com" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en&amp;q=http://id.bookmyshow.com&amp;source=gmail&amp;ust=1524719577869000&amp;usg=AFQjCNEkVuppRMW47c-yUreIMTyqhyAnlg">tickets.pixadelix.com</a>.</li>
														<li>Tiket yang hilang atau dicuri tidak bisa ditukar atau diganti, bahkan jika Anda punya bukti pembelian. Saat tiket sudah diterima itu menjadi tanggung jawab Anda.</li>
														<li style="list-style:none">
															<br>
															<strong style="font-size:16px">Penukaran</strong>
															<br>
														</li>
														<li>Pembeli harus menunjukkan ID yang benar (KTP, SIM, Paspor) yang sesuai dengan data yang dimasukkan saat memesan tiket secara online untuk memungkinkan penukaran di hari acara berlangsung. Untuk penukaran voucher atau e-ticket ke tiket asli, pembeli bisa melakukannya di hari acara berlangsung untuk ditukar wristband atau lanyard.</li>
														<li>Anda harus menyimpan tiket setiap waktu di tempat acara berlangsung. Jangan sampai hilang!</li>
														<li>Setiap pengunjung di dalam turnamen yang tidak memiliki gelang event atau keterangan yang benar akan dikeluarkan dari area. Tanpa pengecualian.</li>
														<li style="list-style:none">
															<br>
															<strong style="font-size:16px">Pengumuman Umum</strong>
															<br>
														</li>
														<li>Penyelenggara acara menyarankan agar pemegang tiket datang di tempat acara sebelum waktu yang ditentukan untuk menjamin proses berjalan dengan baik pada hari turnamen berlangsung. Semua pemegang tiket akan diperiksa barang bawaan/tasnya saat memasuki arena turnamen.</li>
														<li>Pembeli tiket hanya boleh masuk di kategori yang dipilih.</li>
														<li>Promotor tidak bertanggung jawab atas tiket palsu, atau voucher / e-ticket duplikat yang sudah ditukarkan.</li>
														<li>Dilarang memotret, merekam video atau audio secara profesional selama acara berlangsung.</li>
														<li>Promotor punya hak untuk merevisi pertandingan, waktu, venue layout, dan kapasitas pengunjung saat turnamen tanpa pemberitahuan sebelumnya.</li>
														<li>Penyelenggara acara dan petugasnya berhak untuk menolak pengunjung atau mengeluarkannya apabila pengunjung melakukan hal yang mengganggu, menyerang, atau tindakan tidak layak lainnya. Tidak ada pengembalian uang jika hal ini terjadi.</li>
														<li>Dengan memiliki tiket masuk ke Turnamen dan / atau memasuki tempat Turnamen, pengunjung menyetujui tanpa syarat yang disebutkan sebelumnya untuk terlibat dalam rekaman yang dibuat dan masuk proses pengolahan, publikasi, dan digunakan untuk penyiaran seluas-luasnya, tanpa penyelenggara atau perusahaan perusahaan afiliasi penyelenggara bertanggung jawab untuk membayar kompensasi kepada Pengunjung yang dilibatkan.</li>
														<li>Pengunjung dengan ini tidak dapat menolak kepentingan apapun yang dimilikinya dalam rekaman tersebut di atas. Jika Pengunjung mempunyai hak cipta, atau hak lain untuk rekaman yang disebutkan di atas, dia dengan ini tanpa syarat memberikan hak ini kepada Penyelenggara dan dengan ini membatalakan segala hak pribadinya dan / atau tidak akan meminta hak-hak tersebut.</li>
														<li>Tidak boleh ada substansi ilegal atau terlarang, seperti narkoba, dibawa masuk ke area acara.</li>
														<li>Tidak boleh ada aktivitas jual beli tanpa persetujuan penyelenggara dilakukan di area acara.</li>
														<li>Dilarang membawa makanan atau minuman dari luar ke area acara.</li>
														<li>Mereka yang terlambat bisa masuk ke area acara saat waktu yang tepat tergantung arahan dari petugas yang ada yang di lapangan. Tidak ada pengembalian dana / kompensasi diberikan bagi mereka yang terlambat yang akhirnya diperbolehkan masuk setelah turnamen dimulai.</li>
														<li>Tidak ada tiket yang boleh digunakan untuk kompetisi, promosi atau paket tertentu tanpa sepengetahuan promotor. Jika terjadi, tiket yang diberikan akan tidak berlaku dan pemengang tiket dilarang masuk ke area.</li>
														<li>Syarat dan ketentuan lain berlaku.</li>
													</ul>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<table cellpadding="0" cellspacing="0" width="600" border="0" align="center" bgcolor="1f0000">
										<tbody>
											<tr>
												<td valign="top" width="260" style="background-color:#1f0000;color:#49ba8e;font-size:12px;font-family:Arial,sans-serif;text-align:left;padding:20px 10px 15px 20px">
													For any further assistance<br>
													<a href="mailto:support@pixadelix.com" style="text-decoration:none;color:#49ba8e;font-weight:bold" target="_blank">support@pixadelix.com</a>
												</td>
												<td style="width:200px;vertical-align:top;background-color:#1f0000;text-align:right;padding:25px 0 15px 0">
													<img src="https://ci4.googleusercontent.com/proxy/PU32r6DGx3NJcG3vKgu0LIX6iSwsZ40kjlvYI_HGzE6Qh9fW3TFNK5HthJ8qIWq9mz2aftOy3Opa_VQ0P-mvQhc=s0-d-e1-ft#http://id.bmscdn.com/emailer/icon/phone.png" alt="helpline phone" width="18" height="20" border="0">
												</td>
												<td>
													<a href="tel:+62211234567890" style="text-decoration:none;color:#49ba8e" target="_blank">021 123 456</a>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>

</body>
</html>