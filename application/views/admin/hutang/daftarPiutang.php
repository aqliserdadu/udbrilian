<style>
	table thead {
		display: table-row-group;
	}

	table tfoot {
		display: table-row-group;
	}
</style>

<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Daftar Hutang
		<small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Dashboard/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Daftar Hutang</li>
	</ol>
</section>


<div class="content">




	<div class="row">

		<div class="col-md-4">
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">
							<div style="padding:5px; text-align:center; background-color:#7FFFD4; color:black; border:1px solid #fff">
								Catat Hutang
							</div>
							<form action="" id="formCatatPiutang" method="POST">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nama Suplayer</span>
									<input type="text" name="namasuplayer" id="namasuplayer" class="form-control" style="color:black;" placeholder="Nama Suplayer">
									<input type="hidden" name="idsuplayer" id="idsuplayer" class="form-control" style="color:black;">

								</div>

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Jumlah Nominal</span>
									<input type="text" name="nominal" id="nominal" required class="angka form-control" placeholder="Nominal">
								</div>


								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Keterangan</span>
									<input type="text" name="ket" id="ket" required class="form-control" placeholder="Keterangan">
								</div>
							</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success" id="simpanCatatPiutang">Catat Hutang</button>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">
							<div style="padding:5px; text-align:center; background-color:#5bc0de; color:black; border:1px solid #fff">
								Pembayaran Hutang
							</div>
							<form action="" id="formCatatPembayaranPiutang" method="POST">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nama Suplayer</span>
									<input type="text" name="namasuplayer" id="namasuplayerPem" class="form-control" style="color:black;" placeholder="Nama Suplayer">
									<input type="hidden" name="idsuplayer" id="idsuplayerPem" class="form-control" style="color:black;">

								</div>

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nilai Hutang</span>
									<input type="text" name="nilaipiutang" id="nilaipiutangPem" required class="form-control" readonly>
								</div>

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Pembayaran</span>
									<input type="text" name="bayar" id="bayarPem" required class="form-control angka" onkeyup="pembayaran()">
								</div>

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1"><i id="st">Sisa</i></span>
									<input type="text" name="sisa" id="sisaPem" required class="form-control" readonly>
								</div>

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Keterangan</span>
									<select name="ket" id="ketPem" class="form-control" required style="text-align:center">
										<option value="">---Pilih Keterangan---</option>
										<option value="Cicilan">Cicilan</option>
										<option value="Pelunasan">Pelunasan</option>
									</select>
								</div>
							</form>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-info" id="simpanPembayaranPiutang">Pembayaran Hutang</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-8">
			<div class="box box-info">
				<div class="box-body">


					<div class="table-responsive" id="data">

						<table id="dataHutang" class="table table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>Nama Suplayer</th>
									<th>Total Hutang</th>
									<th>Ket</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php $total = 0; ?>
								<?php foreach ($data as $tp) {; ?>
									<?php $total = $total + $tp->sisahutang; ?>
									<?php $date = date('Y-m-d',strtotime('-14 days',strtotime(date('Y-m-d'))));?>
									<tr <?php echo $date >= $tp->date && $tp->sisahutang > 0 ? "style='background-color:red'":"" ;?>>
										<td><?php echo $no++; ?></td>
										<td><?php echo $tp->date; ?></td>
										<td><?php echo $tp->namasuplayer . " " . $tp->alamatsuplayer; ?></td>
										<td><?php echo number_format($tp->sisahutang); ?></td>
										<td><?php echo $date >= $tp->date && $tp->sisahutang > 0 ? "Jatuh Tempo":"" ;?></td>
									
									</tr>
								<?php }; ?>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td align="center"><b>Total</b></td>
									<td align="center"><b><?php echo number_format($total); ?></b></td>
									<td></td>
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
	//mask harga
	$('.angka').mask('000,000,000,000,000,000,000', {
		reverse: true,
		translation: {
			'0': {
				pattern: /-|\d/,
				recursive: true
			}
		},
		onChange: function(value, e) {
			e.target.value = value.replace(/^-\./, '-').replace(/^-,/, '-').replace(/(?!^)-/g, '');
		}
	});


	$("#dataHutang").DataTable({


		dom: 'Bfrtip',
		buttons: [{
				text: 'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
				title: 'Daftar Hutang',
			},
			{
				extend: 'print',
				title: 'Daftar Hutang',
				footer: true,
				exportOptions: {
					columns: ':visible'
				}
			},
			'colvis'
		],
		columnDefs: [{
			targets: 0,
			visible: true
		}]




	});



	$('#namasuplayerPem').autocomplete({
		source: "<?php echo base_url('admin/Suplayer/getSuplayerAuto'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$('#idsuplayerPem').val(ui.item.idsuplayer);

			cekPiutang(ui.item.idsuplayer) //cekhutang


		}
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div>" + item.label + "<br>" + item.alamat + "</div>")
			.appendTo(ul);
	}

	$('#namasuplayer').autocomplete({
		source: "<?php echo base_url('admin/Suplayer/getSuplayerAuto'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$('#idsuplayer').val(ui.item.idsuplayer);
			$("#nominal").focus();

		}
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div>" + item.label + "<br>" + item.alamat + "</div>")
			.appendTo(ul);
	}




	$('#simpanCatatPiutang').click(function(e) {

		e.preventDefault();
		if (confirm('Apa Ingin Mencatat Hutang?')) {

			if ($("#namasuplayer").val() == "" | $("#idsuplayer").val() == "") {
				alert('Harap Pilih Nama Suplayer');
				$("#namasuplayer").focus();
			} else if ($("#nominal").val() == '') {
				alert('Masukan Jumlah Nominal');
				$("#nominal").focus();
			} else {

				$.ajax({

					url: "<?php echo base_url('admin/Hutang/catatPiutang'); ?>",
					type: "POST",
					dataType: "json",
					data: $('#formCatatPiutang').serialize(),
					success: function(data) {
						if (data.status == true) {

							$('#data').load("<?php echo base_url('admin/hutang/ajax_daftarPiutang'); ?>");
							$("#formCatatPiutang")[0].reset();
							alert("Catat Hutang Berhasil Disimpan!!!");

						} else {
							$("#info").fadeIn('slow');
							$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak Boleh Kosong </div></div>")
							$("#info").fadeOut('slow');
						}



					},
					error: function(data) {

						$("#info").fadeIn('slow');
						$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal Dalam Menyimpan </div></div>")
						$("#info").fadeOut('slow');

					},




				})



			}

		}


	})



	function cekPiutang(id) { //cek piutang

		$.ajax({

			url: '<?php echo base_url('admin/Hutang/cekPiutang'); ?>',
			type: "POST",
			data: {
				idsup: id
			},
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				$(".preloader").show();
			},

			success: function(data) {

				if (data.status === true && data.sisahutang != null) {
					$("#nilaipiutangPem").val(formatUang(data.sisahutang));
					$("#bayarPem").focus();
					pembayaran();
				} else {
					$("#nilaihutangPem").val(formatUang(data.sisahutang));
					$("#bayarPem").focus();
					pembayaran();
				}
				if (data.status === false) {
					alert(data.ket);
					$("#nilaihutangPem").val(0);
					$("#bayarPem").focus();
					pembayaran();
				}

				$("#info").fadeIn('slow');
				$("#info").html("<div class='alert-success' align='center'> Berhasil Disimpan </div>")
				$("#info").fadeOut('slow');


				//$('#formPenjualan')[0].reset();
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

				$("#info").fadeIn('slow');
				$("#info").html("<div class='alert-denger' align='center'> Gagal Disimpan </div>")
				$("#info").fadeOut('slow');


			},





		})

	}

	function pembayaran() {

		var pembayaran = menghilangkanKoma($("#bayarPem").val());
		var nilaihutang = menghilangkanKoma($("#nilaipiutangPem").val());
		var hitung = parseInt(nilaihutang) - parseInt(pembayaran);

		var angka = hitung.toString().replace('-', '');
		if (parseInt(pembayaran) >= parseInt(nilaihutang)) {
			$("#st").html('Kembali')

		} else {

			$("#st").html('Sisa')
		}

		$("#sisaPem").val(formatUang(angka));


	}

	$('#simpanPembayaranPiutang').click(function(e) {

		e.preventDefault();
		if (confirm('Apa Ingin Melakukan Pembayaran Hutang?')) {

			if ($("#namasuplayerPem").val() == "" | $("#idsuplayerPem").val() == "") {
				alert('Harap Pilih Nama Suplayer');
				$("#namasuplayerPem").focus();
			} else if ($("#bayarPem").val() == '') {
				alert('Masukan Jumlah Pembayaran');
				$("#bayarPem").focus();
			} else {

				$.ajax({

					url: "<?php echo base_url('admin/Hutang/catatPembayaranPiutang'); ?>",
					type: "POST",
					dataType: "json",
					data: $('#formCatatPembayaranPiutang').serialize(),
					success: function(data) {
						if (data.status == true) {

							$('#data').load("<?php echo base_url('admin/hutang/ajax_daftarPiutang'); ?>");
							$("#formCatatPembayaranPiutang")[0].reset();
							alert("Pembayaran Hutang Berhasil Disimpan!!!");

						} else {
							$("#infoPem").fadeIn('slow');
							$("#infoPem").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak Boleh Kosong </div></div>")
							$("#infoPem").fadeOut('slow');
						}



					},
					error: function(data) {

						$("#infoPem").fadeIn('slow');
						$("#infoPem").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal Dalam Menyimpan </div></div>")
						$("#infoPem").fadeOut('slow');

					},




				})



			}

		}


	})
</script>