<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Stok Barang
		<small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Dashboard/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Stok Barang</li>
	</ol>
</section>


<div class="content">




	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">

					<div class="row">
						<form action="#" method="post" id="formCari">
							<div class="col-md-6">


								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">From</span>
									<input type="text" name="tglP" id="tglP" class="form-control" required placeholder="From Date">
								</div>

							</div>
							<div class="col-md-6">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">To</span>
									<input type="text" name="tglK" id="tglK" class="form-control" required placeholder="To Date">
									<span class="input-group-btn">
										<button id="cari" class="btn btn-info"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						</form>
					</div>

					<p style="margin:10px; font-weight:bold"> Priode : <?php echo date('d M Y', strtotime($tglP)) . " s/d " . date('d M Y', strtotime($tglK)); ?></p>

					<div class="table-responsive" id="dataBarang" style="margin-top:15px">

						<table id="barang" class="table table-striped" style="margin-top:15px">
							<thead>
								<tr>
									<th>No</th>
									<th>ID</th>
									<th style="background-color:#FFFFA7">Qty A</th>
									<th style="background-color:#FFFFA7">M3 A</th>
									<th style="background-color:#FFFFA7">Total A</th>
									<th style="background-color:#99EE99">Qty M</th>
									<th style="background-color:#99EE99">M3 M</th>
									<th style="background-color:#99EE99">Total M</th>
									<th style="background-color:#FFCCCB">Qty K</th>
									<th style="background-color:#FFCCCB">M3 K</th>
									<th style="background-color:#FFCCCB">Total K</th>
									<th>Qty</th>
									<th>M3</th>
									<th>Modal</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$no = 1;
								$totalm3 = 0;
								$totalqty = 0;
								$totalharga = 0;

								$qtyawal = 0;
								$m3awal = 0;
								$totalawal = 0;

								$qtymasuk = 0;
								$m3masuk = 0;
								$totalmasuk = 0;

								$qtykeluar = 0;
								$m3keluar = 0;
								$totalkeluar = 0;

								$qtysisa = 0;
								$m3sisa = 0;
								$hargasisa = 0;
								$totalsisa = 0;


								foreach ($data as $tp) {
								?>
									<?php
									$qtyawal += $tp['qtyawal'];
									$m3awal += $tp['m3awal'];
									$totalawal += $tp['totalawal'];

									$qtymasuk += $tp['qtymasuk'];
									$m3masuk += $tp['m3masuk'];
									$totalmasuk += $tp['totalmasuk'];

									$qtykeluar += $tp['qtykeluar'];
									$m3keluar += $tp['m3keluar'];
									$totalkeluar += $tp['totalkeluar'];

									$qtysisa += $tp['qtysisa'];
									$m3sisa += $tp['m3sisa'];
									$hargasisa += $tp['hargasisa'];
									$totalsisa += $tp['totalsisa']; ?>
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $tp['idbarang']; ?></td>
										<td style="background-color:#FFFFA7"><?php echo $tp['qtyawal']; ?></td>
										<td style="background-color:#FFFFA7"><?php echo $tp['m3awal']; ?></td>
										<td style="background-color:#FFFFA7"><?php echo number_format($tp['totalawal'], 2); ?></td>

										<td style="background-color:#99EE99"><?php echo $tp['qtymasuk']; ?></td>
										<td style="background-color:#99EE99"><?php echo $tp['m3masuk']; ?></td>
										<td style="background-color:#99EE99"><?php echo number_format($tp['totalmasuk'], 2); ?></td>

										<td style="background-color:#FFCCCB"><?php echo $tp['qtykeluar']; ?></td>
										<td style="background-color:#FFCCCB"><?php echo $tp['m3keluar']; ?></td>
										<td style="background-color:#FFCCCB"><?php echo number_format($tp['totalkeluar'], 2); ?></td>

										<td style="background-color:#7FFFD4"><?php echo $tp['qtysisa']; ?></td>
										<td style="background-color:#7FFFD4"><?php echo $tp['m3sisa']; ?></td>
										<td style="background-color:#7FFFD4"><?php echo number_format($tp['hargasisa'], 2); ?></td>
										<td style="background-color:#7FFFD4"><?php echo number_format($tp['totalsisa'], 2); ?></td>

									</tr>
								<?php }; ?>
							</tbody>
							<tfoot>

								<tr style="font-weight:bold">
									<td colspan="2" align="center">Total</td>
									<td align="center" style="background-color:#FFFFA7"><?php echo $qtyawal; ?></td>
									<td align="center" style="background-color:#FFFFA7"><?php echo $m3awal; ?></td>
									<td align="center" style="background-color:#FFFFA7"><?php echo number_format($totalawal, 2); ?></td>

									<td align="center" style="background-color:#99EE99"><?php echo $qtymasuk; ?></td>
									<td align="center" style="background-color:#99EE99"><?php echo $m3masuk; ?></td>
									<td align="center" style="background-color:#99EE99"><?php echo number_format($totalmasuk, 2); ?></td>

									<td align="center" style="background-color:#FFCCCB"><?php echo $qtykeluar; ?></td>
									<td align="center" style="background-color:#FFCCCB"><?php echo $m3keluar; ?></td>
									<td align="center" style="background-color:#FFCCCB"><?php echo number_format($totalkeluar, 2); ?></td>

									<td align="center"><?php echo $qtysisa; ?></td>
									<td align="center"><?php echo $m3sisa; ?></td>
									<td align="center"></td>
									<td align="center"><?php echo number_format($totalsisa, 2); ?></td>
								</tr>

							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>



</div>




<script type="text/javascript">
	const date = new Date();
	var tgl = date.getDate().toString() + "-" + date.getMonth().toString() + "-" + date.getFullYear().toString();



	$("#barang").DataTable({
		"searching": true,
		"info": false,
		"bPaginate": false,

		dom: 'Bfrtip',
		buttons: [{
				text: 'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
				title: 'Laporan Stock Barang ' + tgl,
			},
			{
				extend: 'print',
				title: '',
				messageTop: 'Laporan Stock Barang ' + tgl,
				footer: true,
				exportOptions: {
					columns: ':visible'
				},


			},
			'colvis'
		],
		columnDefs: [{
			visible: false
		}],



	});





	$("#cari").click(function(e) {
		e.preventDefault();

		var tglP = $("#tglP").val();
		var tglK = $("#tglK").val();
		var blnP = tglP.substr(5, 2); //ambil hanya bulan
		var blnK = tglK.substr(5, 2); //ambil hanya bulan
		var idpelanggan = $("#idpelanggan").val();

		if (tglP == null) {
			alert('Tanggal From Tidak Boleh Kosong');
		} else if (tglK == null) {
			alert('Tanggal To Tidak Boleh Kosong');
		} else if (tglP > tglK) {
			alert('Tanggal TO lebih besar dari Form');
		} else if (blnP != blnK) {
			alert('Pengambilan data tidak boleh berbeda bulan');
		} else {
			$.ajax({

				url: '<?php echo base_url('admin/Barang/pergerakanStok'); ?>',
				type: "POST",
				data: $("#formCari").serialize(),
				dataType: "html",

				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {

					$("#content").html(data);

				},
				complete: function(data) {
					$(".preloader").hide();

				},
				error: function(xhr, textStatus) {

					var msg = '';

					if (xhr.status === 0) {
						msg = 'Tidak ada jaringan, Periksa koneksi jaringan';
					} else if (xhr.status == 404) {
						msg = ' Halaman web tidak ditemukan [404]';
					} else if (xhr.status == 505) {
						msg = ' Internal Server Error [505]';
					} else if (text.status === 'timeout') {
						msg = 'Time Out Error, Ulangi Kembali';
					} else {
						msg = ' Uncaughr Error.\n' + xhr.responseText;
					}
					alert(msg);

				},





			})



		}



	})



	$(function() {
		var dateFormat = "yy-mm-dd",
			from = $("#tglP")
			.datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 1,
				dateFormat: "yy-mm-dd"
			})
			.on("change", function() {
				to.datepicker("option", "minDate", getDate(this));
			}),
			to = $("#tglK").datepicker({
				defaultDate: "+1w",
				changeMonth: true,
				numberOfMonths: 1,
				dateFormat: "yy-mm-dd"
			})
			.on("change", function() {
				from.datepicker("option", "maxDate", getDate(this));
			});

		function getDate(element) {
			var date;
			try {
				date = $.datepicker.parseDate(dateFormat, element.value);
			} catch (error) {
				date = null;
			}

			return date;
		}
	});
</script>