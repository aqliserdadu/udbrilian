<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Stock Opname
		<small>Control panel List</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Barang/stockOpname"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Form Add</li>
	</ol>
</section>

<div class="content">

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="row" id="listStock">
						<div align="left" class="col-md-12">
							<button class="btn btn-success" id="tambah">Buat Data Stock Opname</button>
						</div>
						<div class="col-md-12" id="stockOpname" style="margin-top:15px">

							<div class="table-responsive">
								<table id="tableStock" class="table table-striped" style="width:100%">
									<thead>
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>User</th>
											<th>Nota</th>
											<th>Qty</th>
											<th>M3</th>
											<th>Total</th>
											<th>Ket</th>
											<th style="width:50px"></th>

										</tr>
									</thead>
									<tbody>
										<?php $no = 1; ?>
										
										<?php foreach ($data as $t) {; ?>
											<tr>
												<td><?php echo $no++; ?></td>
												<td><?php echo date('d-m-Y', strtotime($t->date)); ?></td>
												<td><?php echo $t->username; ?></td>
												<td><?php echo $t->idheader; ?></td>
												<td><?php echo $t->qty; ?></td>
												<td><?php echo number_format($t->m3, 4); ?></td>
												<td><?php echo number_format($t->totalharga); ?></td>
												<td><?php echo ucwords($t->keterangan); ?></td>
												<td>
													<a href="#" class="btn btn-info btn-xs" onclick="detail('<?php echo $t->idheader; ?>')"><i class="fa fa-book"></i></a>
													<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php echo $t->idheader; ?>')"><i class="fa fa-trash-o"></i></a>

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
	$("#tableStock").DataTable();

	$("#tambah").click(function() {

		$("#content").load("<?php echo base_url('admin/Barang/formStockOpname'); ?>");
	})

	function detail(idheader) {

		$("#listStock").load("<?php echo base_url('admin/Barang/detailStockOpname/'); ?>" + idheader);
	}


	function hapus(idheader) {

		if (confirm('Apa Ingin Menghapus?')) {

			$.ajax({

				url: '<?php echo base_url('admin/Barang/hapusStockOpname'); ?>',
				type: "POST",
				data: {
					id: idheader
				},
				dataType: "JSON",

				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {
					if (data.status == true) {
						alert(data.ket);
						$("#content").load("<?php echo base_url('admin/Barang/stockOpname'); ?>");
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
</script>