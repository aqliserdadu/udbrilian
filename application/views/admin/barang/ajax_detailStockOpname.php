<div class="col-md-12">



	<table id="table" class="table table-striped">
		<thead>
			<tr>
				<th colspan="9"><?php echo $header->idheader; ?></th>
			</tr>

			<tr>
				<th colspan="9"><?php echo $header->keterangan; ?></th>
			</tr>
			<tr>
				<th>No</th>
				<th>T</th>
				<th>L</th>
				<th>P</th>
				<th>Jml Pcs</th>
				<th>Volume M3</th>
				<th>Harga M3</th>
				<th>Jumlah</th>
				<th>Keterangan</th>

			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$totalpcs = 0;
			$totalm3 = 0;
			$totalharga = 0;
			foreach ($detail_header as $tp) {; ?>
				<tr>
					<?php $totalpcs = $totalpcs + $tp->qty; ?>
					<?php $totalm3 = $totalm3 + $tp->m3; ?>
					<?php $totalharga = $totalharga + $tp->totalharga; ?>
					<td><?php echo $no++; ?></td>
					<td><?php echo $tp->t; ?></td>
					<td><?php echo $tp->l; ?></td>
					<td><?php echo $tp->p; ?></td>
					<td><?php echo $tp->qty; ?></td>
					<td><?php echo $tp->m3; ?></td>
					<td><?php echo number_format($tp->hargam3); ?></td>
					<td style="text-align:left"><?php echo number_format($tp->totalharga); ?></td>
					<td><?php echo $tp->ket; ?></td>


				</tr>
			<?php }; ?>
		</tbody>
		<tfoot>
			<tr>
				<td colspan="4" align="center"><b>Jumlah</b></td>
				<td align="center"> <?php echo $totalpcs; ?> </td>
				<td align="center"> <?php echo $totalm3; ?> </td>
				<td></td>
				<td align="left"> <?php echo number_format($totalharga); ?> </td>
				<td></td>

			</tr>
		</tfoot>
	</table>

</div>

<div class="col-md-12" align="right">
	<button type="button" class="btn btn-danger" id="kembali" onclick="kembali()"><i>kembali</i></button>
	<button type="button" class="btn btn-warning" id="print1" onclick="print1('<?php echo $header->idheader; ?>')"><i class="fa fa-print"> Print 1</i></button>
	<button type="button" class="btn btn-warning" id="print2" onclick="print2('<?php echo $header->idheader; ?>')"><i class="fa fa-print"> Print 2</i></button>
	<button type="button" class="btn btn-info" id="edit" onclick="edit('<?php echo $header->idheader; ?>')"><i class="fa fa-pencil">Edit</i></button>

</div>




<script>
	function kembali() {

		$.ajax({

			url: '<?php echo base_url('admin/Barang/StockOpname'); ?>',
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





		});


	}

	function print1(idheader) {
		window.open("<?php echo base_url('admin/Barang/print1/'); ?>" + idheader, '_blank');

	}

	function print2(idheader) {

		window.open("<?php echo base_url('admin/Barang/print2/'); ?>" + idheader, '_blank');



	}

	function edit(notaPembelian) {

		$.ajax({

			url: "<?php echo base_url('admin/Barang/editStockOpname'); ?>",
			type: "POST",
			data: {
				idheader: notaPembelian
			},
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
</script>