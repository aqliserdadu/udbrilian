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
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">
					<div class="table-responsive" id="data">

						<table id="dataHutang" class="table table-striped">
							<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>User</th>
									<th>Nama Suplayer</th>
									<th>Rincian Hutang</th>
									<th>Rincian Bayar</th>
									<th>Keterangan</th>
									<th><i class="fa fa-gear"></i></th>
								</tr>
							</thead>
							<tbody>
								<?php $no = 1; ?>
								<?php foreach ($data as $tp) {; ?>
									
									<tr>
										<td><?php echo $no++; ?></td>
										<td><?php echo $tp->date; ?></td>
										<td><?php echo $tp->username; ?></td>
										<td><?php echo $tp->namasuplayer . " " . $tp->alamatsuplayer; ?></td>
										<td><?php echo number_format($tp->totalhutang); ?></td>
										<td><?php echo number_format($tp->bayarhutang); ?></td>
										<td><?php echo $tp->kethutang; ?></td>
										<td><a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php echo $tp->idhutang; ?>')"><i class="fa fa-trash-o"></i></a></td>


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





<script type="text/javascript">
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

		}




	);



	function hapus(id) {

		if (confirm('Apa Anda Yakin Ingin Menghapus? Ini akan berdampak pada Daftar Hutang!')) {

			$.ajax({

				url: '<?php echo base_url('admin/Hutang/hapus'); ?>',
				type: "POST",
				data: {
					idhutang: id
				},
				dataType: "JSON",

				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {
					if (data.status == true) {
						alert(data.ket);

						$("#content").load("<?php echo base_url('admin/Hutang/listPiutang'); ?>");
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