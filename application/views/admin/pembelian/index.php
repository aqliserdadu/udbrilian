<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Pembelian
		<small>Control panel List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("adminDigital/Pembelian/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Form Add</li>
	</ol>
</section>

<div class="content">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<form action="#" method="post" id="formCari">
								<div class="col-md-6">


									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">From</span>
										<input type="text" name="tglP" id="tglP" value="<?php echo empty($tglP) ? date('Y-m-d') : $tglP; ?>" required class="form-control date" placeholder="Date">

									</div>

								</div>
								<div class="col-md-6">
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">To</span>
										<input type="text" name="tglK" id="tglK" value="<?php echo empty($tglK) ? date('Y-m-d') : $tglK; ?>" required class="form-control date" placeholder="Date">
										<span class="input-group-btn">
											<button id="cari" class="btn btn-info"><i class="fa fa-search"></i></button>
										</span>
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-12" id="listPembelian" style="margin-top:15px">
							<div class="table-responsive">
								<table id="tablePembelian" class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>User</th>
											<th>Nota Pembelian</th>
											<th>Suplayer</th>
											<th>Total Pembelian</th>
											<th>Metode Bayar</th>
											<th>Total Pembayaran</th>
											<th>Sisa Pembayaran</th>
											<th style="width:50px"></th>

										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										<?php foreach ($data as $tp) {; ?>

											<tr>
												<td><?php echo $no++; ?></td>
												<td><?php echo $tp->date; ?></td>
												<td><?php echo $tp->username; ?></td>
												<td><?php echo $tp->idheader; ?></td>
												<td><?php echo $tp->namasuplayer; ?></td>
												<td><?php echo "Rp. " . number_format($tp->totalharga); ?></td>
												<td><?php echo $tp->metodebayar; ?></td>
												<td><?php echo "Rp. " . number_format($tp->bayar); ?></td>
												<td><?php echo "Rp. " . number_format($tp->sisa); ?></td>
												<td>
													<a href="#" class="btn btn-info btn-xs" onclick="detail('<?php echo $tp->idheader; ?>')"><i class="fa fa-book"></i></a>
													<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php echo $tp->idheader; ?>')"><i class="fa fa-trash-o"></i></a>

												</td>
											</tr>
										<?php }; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>


<script type="text/javascript">
	$('.table').DataTable();


	function detail(notaPembelian) {
		
		$("#formCari").hide();
		$("#listPembelian").load("<?php echo base_url('admin/Pembelian/detailPembelian/'); ?>" + notaPembelian);
	}



	function hapus(idpembelian) {

		if (confirm('Apa Ingin Menghapus? Data Stok Akan Terhapus Juga')) {

			$.ajax({

				url: '<?php echo base_url('admin/Pembelian/hapusPembelian'); ?>',
				type: "POST",
				data: {
					id: idpembelian
				},
				dataType: "JSON",

				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {
					if (data.status == true) {
						alert(data.ket);
						$("#listPembelian").load("<?php echo base_url('admin/Pembelian/listPembelian'); ?>");
					}
					if (data.status == false) {
						alert(data.ket);
					}

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
					$("#info").html("<div class='col-md-12 '><div class='alert-denger' align='center'> Gagal Dihapus </div></div>")
					$("#info").fadeOut('slow');


				},





			})

		}

	}

	$(".date").datepicker({
		dateFormat: "yy-mm-dd"
	})

	$("#cari").click(function(e) {
		e.preventDefault();

		var tglP = $("#tglP").val();
		var tglK = $("#tglK").val();

		if (tglP == '') {
			alert('Tanggal From Tidak Boleh Kosong');
		} else if (tglK == '') {
			alert('Tanggal To Tidak Boleh Kosong');
		} else if (tglP > tglK) {
			alert('Tanggal TO lebih besar dari Form');
		} else {
			$.ajax({

				url: '<?php echo base_url('admin/Pembelian/index'); ?>',
				type: "GET",
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
</script>