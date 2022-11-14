	<table id="table" class="table table-striped sinkron">
		<thead>
			<tr>
				<th>No</th>
				<th>Bulan</th>
				<th>Total Stok</th>
				<th>M3</th>
				<th>Total Harga</th>
				<th>Status</th>
				<th><i class="fa fa-gear"></i></th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			foreach ($data as $tp) {
			?>
				<tr>
					<td><?php echo $no++; ?></td>
					<td><?php echo date('M Y', strtotime($tp->tanggal)); ?></td>
					<td><?php echo $tp->totalbarang; ?></td>
					<td><?php echo $tp->m3; ?></td>
					<td><?php echo number_format($tp->totalharga); ?></td>
					<td><?php echo ucwords($tp->status); ?></td>
					<td>
						<?php
						if (date('M Y', strtotime($tp->tanggal)) == date('M Y'))
							if ($tp->status == 'verifikasi') {
								echo "<button class='btn btn-info' id='sinkron' onclick=\"sinkron('" . $tp->idheader . "','" . date('Y-m-d', strtotime($tp->tanggal)) . "')\"> Verifikasi </button>";
							} else if ($tp->status == 'gagal') {
								echo "<button class='btn btn-danger' id='prosesSinkron' onclick=\"prosesSinkron('" . $tp->idheader . "','" . date('Y-m-d', strtotime($tp->tanggal)) . "')\"> Sinkron </button>";
							} else if ($tp->status == 'Stock Opname') {

								echo "Data Tidak Dapat Di Sinkron";
							} else {
								echo "<button class='btn btn-success' id='prosesSinkron' onclick=\"prosesSinkronUlang('" . $tp->idheader . "','" . date('Y-m-d', strtotime($tp->tanggal)) . "')\"> Sinkron Ulangi </button>";
							}; ?>
					</td>
				</tr>
			<?php }; ?>
		</tbody>
	</table>


	<script type="text/javascript">
		$(".sinkron").DataTable({

			"searching": false,
			"info": false,
			"bPaginate": true,

		});



		$("#prosesSinkron").click(function() {



			$.ajax({

				url: "<?php echo base_url('admin/Barang/prosesSinkron'); ?>",
				type: "POST",
				dataType: "html",
				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {

					alert(data.ket);
					$(".tableSinkron").html(data);

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


		})

		function sinkron(idheader) {



			$.ajax({

				url: "<?php echo base_url('admin/Barang/verifikasiSinkron/'); ?>" + idheader,
				type: "POST",
				dataType: "html",
				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {

					alert(data.ket);
					$(".tableSinkron").html(data);

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
	</script>