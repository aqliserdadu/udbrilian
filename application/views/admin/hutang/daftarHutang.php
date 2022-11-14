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
		Daftar Piutang
		<small>Control panel</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Dashboard/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Daftar Piutang</li>
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
								Catat Piutang
							</div>
							<div id="info"></div>
							<form action="" id="formCatatHutang" method="POST">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nama Pelanggan</span>
									<input type="text" name="namapelanggan" id="namapelanggan" class="form-control" style="color:black;" placeholder="Nama Pelanggan">
									<input type="hidden" name="idpelanggan" id="idpelanggan" class="form-control" style="color:black;">

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
							<button type="button" class="btn btn-success" id="simpanCatatHutang">Catat Piutang</button>
						</div>
					</div>
				</div>


				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">
							<div style="padding:5px; text-align:center; background-color:#5bc0de; color:black; border:1px solid #fff">
								Pembayaran Piutang
							</div>
							<div id="infoPem"></div>
							<form action="" id="formPembayaranHutang" method="POST">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nama Pelanggan</span>
									<input type="text" name="namapelanggan" id="namapelangganPem" class="form-control" style="color:black;" placeholder="Nama Pelanggan">
									<input type="hidden" name="idpelanggan" id="idpelangganPem" class="form-control" style="color:black;">

								</div>

								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nilai Piutang</span>
									<input type="text" name="nilaihutang" id="nilaihutangPem" required class="form-control" readonly>
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
							<button type="button" class="btn btn-info" id="simpanPembayaranHutang">Pembayaran Piutang</button>
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
									<th>Nama Pelanggan</th>
									<th>Total Piutang</th>
									<th>Ket</th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php $total = 0; ?>
								<?php foreach ($data as $tp) {; ?>
									<?php $total = $total + $tp->sisahutang; ?>
									<?php $total = $total + $tp->sisahutang; ?>
									<?php $date = date('Y-m-d',strtotime('-14 days',strtotime(date('Y-m-d'))));?>
									<tr <?php echo $date >= $tp->date && $tp->sisahutang > 0 ? "style='background-color:red'":"" ;?>>
										<td><?php echo $no++; ?></td>
										<td><?php echo $tp->date;?></td>
										<td><?php echo $tp->namapelanggan . " " . $tp->alamatpelanggan; ?></td>
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
				title: 'Daftar Piutang',
			},
			{
				extend: 'print',
				title: 'Daftar Piutang',
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




	$('#simpanCatatHutang').click(function(e) {

		e.preventDefault();
		if (confirm('Apa Ingin Mencatat Piutang?')) {

			if ($("#namapelanggan").val() == null) {
				alert('Harap Pilih Nama Pelanggan');
				$("#namapelanggan").focus();
			} else if ($("#nominal").val() == '') {
				alert('Masukan Jumlah Nominal');
				$("#nominal").focus();
			} else {

				$.ajax({

					url: "<?php echo base_url('admin/Hutang/catatHutang'); ?>",
					type: "POST",
					dataType: "json",
					data: $('#formCatatHutang').serialize(),
					success: function(data) {
						if (data.status == true) {

							$('#data').load("<?php echo base_url('admin/hutang/ajax_daftarHutang'); ?>");
							$("#formCatatHutang")[0].reset();
							alert("Piutang Berhasil Disimpan!!!");

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


	$('#namapelangganPem').autocomplete({
		source: "<?php echo base_url('admin/Pelanggan/getPelangganAuto'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$('#idpelangganPem').val(ui.item.idpelanggan);

			cekHutang(ui.item.idpelanggan) //cekhutang


		}
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div>" + item.label + "<br>" + item.alamat + "</div>")
			.appendTo(ul);
	}

	$('#namapelanggan').autocomplete({
		source: "<?php echo base_url('admin/Pelanggan/getPelangganAuto'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$('#idpelanggan').val(ui.item.idpelanggan);
			$("#nominal").focus();

		}
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div>" + item.label + "<br>" + item.alamat + "</div>")
			.appendTo(ul);
	}





	function cekHutang(idpelanggan) { //cek hutang

		$.ajax({

			url: '<?php echo base_url('admin/Hutang/cekHutang'); ?>',
			type: "POST",
			data: {
				idcus: idpelanggan
			},
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				$(".preloader").show();
			},

			success: function(data) {

				if (data.status === true && data.sisahutang != null) {
					$("#nilaihutangPem").val(formatUang(data.sisahutang));
					$("#bayarPem").focus();
					pembayaran();
				} else {
					$("#nilaihutangPem").val(0);
					$("#bayarPem").focus();
					pembayaran();
				}
				if (data.status === false) {
					alert(data.ket);
				}

				$("#info").fadeIn('slow');
				//$("#info").html("<div class='alert-success' align='center'> Berhasil Disimpan </div>")
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
		var nilaihutang = menghilangkanKoma($("#nilaihutangPem").val());
		var hitung = parseInt(nilaihutang) - parseInt(pembayaran);

		var angka = hitung.toString().replace('-', '');
		if (parseInt(pembayaran) >= parseInt(nilaihutang)) {
			$("#st").html('Kembali')

		} else {

			$("#st").html('Sisa')
		}

		$("#sisaPem").val(formatUang(angka));


	}

	$('#simpanPembayaranHutang').click(function(e) {

		e.preventDefault();
		if (confirm('Apa Ingin Melakukan Pembayaran Piutang?')) {

			if ($("#namapelangganPem").val() == "" | $("#idpelangganPem").val() == "") {
				alert('Harap Pilih Nama Pelanggan');
				$("#namapelangganPem").focus();
			} else if ($("#bayarPem").val() == '') {
				alert('Masukan Jumlah Pembayaran');
				$("#bayarPem").focus();
			} else if ($("#bayarPem").val() > $("#nilaihutangPem").val()) {
				alert('Masukan Sesuai Jumlah Nilai Hutang');
				$("#bayarPem").focus();
			} else {

				$.ajax({

					url: "<?php echo base_url('admin/Hutang/catatPembayaranHutang'); ?>",
					type: "POST",
					dataType: "json",
					data: $('#formPembayaranHutang').serialize(),
					success: function(data) {
						if (data.status == true) {
							alert("Pembayaran Piutang Berhasil Di Simpan!!!");
							$('#data').load("<?php echo base_url('admin/hutang/ajax_daftarHutang'); ?>");
							$("#formPembayaranHutang")[0].reset();

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