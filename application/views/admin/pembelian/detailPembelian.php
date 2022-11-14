<div class="col-md-12">



	<table id="table" class="table table-striped">
		<thead>
			<tr>
				<th colspan="9"><?php echo $row->idheader; ?></th>
			</tr>

			<tr>
				<th colspan="9"><?php echo $row->namasuplayer; ?></th>
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
			foreach ($data as $tp) {; ?>
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
			<?php if ($row->pilihhutang == 'yes') {; ?>
				<tr style="background-color:#f0f0f0">
					<td colspan="7" align="right">Piutang :</td>
					<td align="left"><?php echo number_format($row->hutang); ?></td>
					<td align="left"></td>

				</tr>
			<?php }; ?>
			<tr style="background-color:#f0f0f0">
				<td colspan="7" align="right">Bongkar :</td>
				<td align="left"><?php echo number_format($row->bongkar); ?></td>
				<td align="left"></td>

			</tr>
			<tr style="background-color:#f0f0f0">
				<td colspan="7" align="right">Transport :</td>
				<td align="left"><?php echo number_format($row->transport); ?></td>
				<td align="left"></td>

			</tr>
			<tr style="background-color:#f0f0f0">
				<td colspan="7" align="right">Total Pembayaran :</td>
				<?php if ($row->pilihhutang == 'yes') {; ?>
					<td align="left"><?php echo number_format($row->totalharga + $row->hutang); ?></td>
				<?php } else {; ?>
					<td align="left"><?php echo number_format($row->totalharga); ?></td>
				<?php }; ?>
				<td align="left"> </td>

			</tr>
			<tr style="background-color:#f0f0f0">
				<td colspan="7" align="right">Bayar :</td>
				<td align="left"><?php echo number_format($row->bayar); ?></td>
				<td align="left"> </td>

			</tr>
			<tr style="background-color:#f0f0f0">
				<td colspan="7" align="right">
					<?php if (($row->hutang + $row->totalharga) > $row->bayar) {
						echo "Sisa :";
					} else {
						echo "Kembali :";
					}; ?></td>
				</td>
				<td align="left"><?php echo number_format(str_replace('-', '', (($row->hutang + $row->totalharga) - $row->bayar))); ?></td>
				<td align="left"> </td>

			</tr>
		</tfoot>
	</table>

</div>

<div class="col-md-12" align="right">
	<button type="button" class="btn btn-danger" id="kembali" onclick="kembali()"><i>kembali</i></button>
	<button type="button" class="btn btn-warning" id="print1" onclick="print1('<?php echo $row->idheader; ?>')"><i class="fa fa-print"> Print 1</i></button>
	<button type="button" class="btn btn-warning" id="print2" onclick="print2('<?php echo $row->idheader; ?>')"><i class="fa fa-print"> Print 2</i></button>
	<button type="button" class="btn btn-info" id="edit" onclick="edit('<?php echo $row->idheader; ?>')"><i class="fa fa-pencil">Edit</i></button>

</div>




<script>
	function kembali() {

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





		});


	}

	function print1(idheader) {
		window.open("<?php echo base_url('admin/Pembelian/printPembelian1/'); ?>" + idheader, '_blank');

	}

	function print2(idheader) {

		window.open("<?php echo base_url('admin/Pembelian/printPembelian2/'); ?>" + idheader, '_blank');



	}

	function edit(notaPembelian) {

		$.ajax({

			url: "<?php echo base_url('admin/Pembelian/editPembelian'); ?>",
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