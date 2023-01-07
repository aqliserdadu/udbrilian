<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Transaksi
		<small>Control panel Edit</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Penjualan/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Form Edit</li>
	</ol>
</section>




<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-3">
					<div class="box-body" style="background-color:white; border:1px solid #ccc">

						<table>
							<tr>
								<td colspan="2"><input type="text" name="po" id="po" value="<?php echo $row->idheader; ?>" readonly class="form-control" style="text-align:center"></td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Date :</td>
								<td>
									<input type="text" name="date" required class="form-control" style="color:black;" value="<?php echo $row->date; ?>" readonly>
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">User :</td>
								<td>
									<input type="text" name="user" value="<?php echo $row->iduser; ?>" id="user" required class="form-control" placeholder="User" style="color:black;" readonly>
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Custamer :</td>
								<td>
									<input type="text" name="namapelanggan" value="<?php echo $row->namapelanggan; ?>" id="namapelanggan" readonly class="form-control" style="color:black;" placeholder="Custamer">
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">ID Barang :</td>
								<td>
									<input type="text" class="form-control" name="idbarang" id="idbarang" placeholder="ID Barang">
									<input type="hidden" class="form-control" name="t" id="t">
									<input type="hidden" class="form-control" name="l" id="l">
									<input type="hidden" class="form-control" name="p" id="p">
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Stock :</td>
								<td>
									<input type="text" class="form-control" name="ambilstok" id="ambilstok" placeholder="Stock Tersedia" readonly>
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Pcs :</td>
								<td>
									<input type="number" class="form-control" name="pcs" id="pcs" placeholder="PCS">
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Harga modal :</td>
								<td>
									<input type="text" class="form-control" name="hargamodal" id="hargamodal" readonly placeholder="Harga Modal">

								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Harga Satuan :</td>
								<td>
									<input type="text" class="form-control" name="harga" id="harga" placeholder="Harga Satuan">
									<input type="hidden" class="form-control" name="hargamodal" id="hargamodal">
									<input type="hidden" class="form-control" name="subtotal" id="subtotal">

								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Keterangan :</td>
								<td>
									<input type="text" class="form-control" name="ket" id="ket" placeholder="Keterangan">
								</td>
							</tr>
							<tr>
								<td colspan="2" style="background-color:white;"><button class="btn btn-success btn-sm" style="width:100%" onclick="tambahBarang()">Tambah</td>
							</tr>
						</table>
						<hr>
						<table class="table table-striped">
							<thead>
								<tr>
									<th colspan="3"> History </th>
								</tr>
								<tr>
									<th style="background-color:#7FFFD4">Date</th>
									<th style="background-color:#7FFFD4">Harga</th>
									<th style="background-color:#7FFFD4">Ket</th>
								</tr>
							</thead>
							<tbody id="showHarga">

							</tbody>
						</table>

					</div>

				</div>



				<form id="formPenjualan" action="#" method="POST">
					<div class="col-md-9">
						<div class="box-body" style="background-color:white; border:1px solid #ccc">
							<input type="hidden" name="so" id="so" value="<?php echo $row->idheader; ?>" readonly class="form-control" style="text-align:center">
							<input type="hidden" name="user" value="<?php echo $row->iduser; ?>" id="user" required class="form-control" placeholder="User" style="color:black;" readonly>
							<input type="hidden" name="date" readonly id="date" required class="form-control" style="color:black;" value="<?php echo $row->date; ?>">
							<input type="hidden" name="idpelanggan" id="idpelanggan" value="<?php echo $row->idpelanggan; ?>" class="form-control" style="color:black;">



							<table id="table" class="table table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>T</th>
										<th>L</th>
										<th>P</th>
										<th>Pcs</th>
										<th>Harga Satuan </th>
										<th>Volume M3</th>
										<th>Jumlah</th>
										<th>Keterangan</th>

									</tr>
								</thead>
								<tbody id="tambahbaris">
									<?php
									$no = 1;
									$angka = 0;
									$totalpcs = 0;
									$totalm3 = 0;
									$totalharga = 0;
									?>
									<?php foreach ($data as $tp) { ?>
										<?php $angka = $angka + 1; ?>
										<?php $totalpcs = $totalpcs + $tp->qty; ?>
										<?php $totalm3 = $totalm3 + $tp->m3; ?>
										<?php $totalharga = $totalharga + $tp->totalharga; ?>
										<tr>
											<td><?php echo $no++; ?></td>
											<td>
												<input type="hidden" name="idbarang[]" style="width:80px" value="<?php echo $tp->idbarang; ?>" id="idbarang<?php echo $angka; ?>" onkeyup="getIdBarang('<?php echo $angka; ?>')" placeholder="ID Barang">
												<input type="text" name="t[]" style="width:50px" value="<?php echo $tp->t; ?>" id="t<?php echo $angka; ?>" onkeyup="hitungT('<?php echo $angka; ?>')">
											</td>
											<td><input type="text" name="l[]" style="width:50px" value="<?php echo $tp->l; ?>" id="l<?php echo $angka; ?>" onkeyup="hitungL('<?php echo $angka; ?>')"></td>
											<td><input type="text" name="p[]" style="width:50px" value="<?php echo $tp->p; ?>" id="p<?php echo $angka; ?>" onkeyup="hitungP('<?php echo $angka; ?>')"></td>
											<td><input type="text" name="pcs[]" style="width:50px" value="<?php echo $tp->qty; ?>" id="pcs<?php echo $angka; ?>" onkeyup="hitungPcs('<?php echo $angka; ?>')"></td>
											<td>
												<input type="text" name="harga[]" style="width:100px;" value="<?php echo number_format($tp->hargasatuan); ?>" id="harga<?php echo $angka; ?>" class="angka" onkeyup="harga('<?php echo $angka; ?>')">
												<input type="hidden" name="hargamodal[]" style="width:100px;" value="<?php echo number_format($tp->hargamodal); ?>" id="hargamodal<?php echo $angka; ?>" class="angka">
											</td>
											<td><input type="text" name="m3[]" style="width:100px; background-color:#ccc" value="<?php echo $tp->m3; ?>" id="m3<?php echo $angka; ?>" readonly></td>
											<td><input type="text" name="subtotal[]" style="width:100px; background-color:#ccc" value="<?php echo $tp->totalharga; ?>" id="subtotal<?php echo $angka; ?>" readonly></td>
											<td><input type="text" name="ket[]" style="width:100px" value="<?php echo $tp->ket; ?>" id="ket<?php echo $angka; ?>"></td>
										</tr>
									<?php }; ?>
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4" align="center"><b>Jumlah</b></td>
										<td align="center"> <input type="text" name="totalpcs" value="<?php echo $totalpcs; ?>" style="width:50px;background-color:#ccc" id="totalpcs" readonly> </td>
										<td></td>
										<td align="center"> <input type="text" name="totalm3" value="<?php echo $totalm3; ?>" id="totalm3" style="width:100px;background-color:#ccc" readonly> </td>
										<td align="center"> <input type="text" name="totalsubtotal" value="<?php echo number_format($totalharga); ?>" id="totalsubtotal" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>

									</tr>
									<tr style="background-color:#f0f0f0" id="tampilhutang">
										<td colspan="6" align="right">Hutang</td>
										<td align="center"> <input type="text" name="hutang" id="hutang" value="<?php echo number_format($hutang->sisahutang); ?>" onkeyup="hutang()" style="width:100px;;background-color:#ccc" readonly> </td>
										<td align="center"><input type="text" name="totalsetelahhutang" id="totalsetelahhutang" value="<?php echo number_format($row->setelahhutang); ?>" style="width:100px;background-color:#ccc" readonly> </td>
										<td align="left">
											<select name="pilihhutang" id="pilihhutang">
												<option value="yes" <?php if ($row->pilihhutang == 'yes') {
																		echo "selected";
																	}; ?>>Sertakan</option>
												<option value="no" <?php if ($row->pilihhutang == 'no') {
																		echo "selected";
																	}; ?>>Tidak Sertakan</option>
											</select>
										</td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="6" align="right">Diskon</td>
										<td align="center"> <input type="text" name="diskon" id="diskon" class="angka" value="<?php echo number_format($row->diskon); ?>" onkeyup="fsdiskon()" style="width:100px;"> </td>
										<td align="center"> <input type="text" name="totalsetelahdiskon" id="totalsetelahdiskon" value="<?php echo number_format($row->hargasetelahdiskon); ?>" style="width:100px;;background-color:#ccc"> </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="7" align="right">Total Pembayaran</td>
										<td align="center"> <input type="text" name="totalpembayaran" id="totalpembayaran" value="<?php echo number_format($row->hargasetelahdiskon); ?>" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="7" align="right">Metode</td>
										<td align="center"> <input type="radio" name="metode" id="metode" value="Dp"> DP <input type="radio" checked name="metode" id="metode" value="Tunai"> Tunai </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="7" align="right">Bayar</td>
										<td align="center"> <input type="text" name="totalbayar" id="totalbayar" class="angka tambahBaris" style="width:100px" onkeyup="fsBayar()"> </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="7" align="right"><i id='ket'>Sisa</i></td>
										<td align="center"> <input type="text" name="sisa" id="sisa" style="width:100px;;background-color:#ccc" readonly> </td>
										<td></td>
									</tr>
								</tfoot>
							</table>

							<div class="col-md-12" style="padding-top: 10px;" align="right">

								<button type="button" class="btn btn-danger" id="kembali"><i>Kembali</i></button>
								<button type="button" class="btn btn-warning" id="print1"><i class="fa fa-print"> Print 1</i></button>
								<button type="button" class="btn btn-warning" id="print2"><i class="fa fa-print"> Print 2</i></button>
								<button type="button" class="btn btn-info" id="update"><i class="fa fa-reset">Upadate</i></button>
							</div>
						</div>
					</div>
				</form>

			</div>

		</div>
	</div>
</div>
</div>



<script type="text/javascript">
	$('#namapelanggan').autocomplete({
		source: "<?php echo base_url('admin/Pelanggan/getPelangganAuto'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$('#idpelanggan').val(ui.item.idpelanggan);

			cekHutang(ui.item.idpelanggan) //cekhutang
			$("#idbarang").val('');
			$("#idbarang").focus();


		}
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div>" + item.label + "<br>" + item.alamat + "</div>")
			.appendTo(ul);
	}


	$('#idbarang').autocomplete({
		source: "<?php echo base_url('admin/Barang/getIdBarang'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);

			if ($("#idpelanggan").val() == "") {
				alert("Custamer Harap Diisi!");
				$("#namapelanggan").focus();
			} else {
				ambilStok(ui.item.t, ui.item.l, ui.item.p);
				ambilModal(ui.item.t, ui.item.l, ui.item.p);
				showHarga(ui.item.t, ui.item.l, ui.item.p, 0, $("#idpelanggan").val());
				$("#pcs").focus();
				$("#t").val(ui.item.t);
				$("#l").val(ui.item.l);
				$("#p").val(ui.item.p);
			}



		}
	}).autocomplete("instance")._renderItem = function(ul, item) {
		return $("<li>")
			.append("<div>" + item.label + "</div>")
			.appendTo(ul);
	}

	function ambilStok(tinggi, lebar, panjang) {

		$.ajax({

			url: '<?php echo base_url('admin/Penjualan/ambilStok'); ?>' + '/' + tinggi + '/' + lebar + '/' + panjang,
			type: "POST",
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				//$(".preloader").show();
			},

			success: function(data) {

				$("#ambilstok").val(data.stok);


				//$('#formPenjualan')[0].reset();
			},
			complete: function(data) {
				//$(".preloader").hide();

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

	function ambilModal(tinggi, lebar, panjang) {

		$.ajax({

			url: '<?php echo base_url('admin/Penjualan/ambilModal'); ?>' + '/' + tinggi + '/' + lebar + '/' + panjang,
			type: "POST",
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				//$(".preloader").show();
			},

			success: function(data) {

				$("#hargamodal").val(formatUang(data.hargamodal));


				//$('#formPenjualan')[0].reset();
			},
			complete: function(data) {
				//$(".preloader").hide();

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

	$("#pcs").keyup(function() {


		var idbarang = $("#idbarang").val();
		var pcs = $(this).val();
		//menjumlahkan subtotal


		if (pcs == "") {
			$("#pcs").focus();
		} else {

			if (event.keyCode === 13)
				$.ajax({

					url: '<?php echo base_url('admin/Penjualan/cekStokPop'); ?>' + '/' + idbarang + '/' + pcs,
					type: "POST",
					dataType: "JSON",

					beforeSend: function() {
						//$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						//$(".preloader").show();
					},

					success: function(data) {

						if (data.status === false) {

							alert(data.ket);
							$("#pcs").val('');
							$("#pcs").focus();

						} else {
							$("#harga").focus();
							$("#hargamodal").val(formatUang(data.hargamodal));
						}


						//$('#formPenjualan')[0].reset();
					},
					complete: function(data) {
						//$(".preloader").hide();

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



	})

	$("#harga").keyup(function() {



		var pcs = $("#pcs").val();
		var harga = menghilangkanKoma($(this).val());
		var subtotal = parseInt(pcs) * parseInt(harga);

		$("#subtotal").val(subtotal);

		if (event.keyCode === 13)
			$("#ket").focus();


	});

	$("#ket").keyup(function() {

		if (event.keyCode === 13)

			tambahBarang()


	})

	function tambahBarang() {

		if ($("#idpelanggan").val() == "") {

			alert("Custamer Harap Diisi!");
			$("#namapelanggan").focus();

		} else if ($("#idbarang").val() == "") {

			alert("Id Barang Harap Diisi!");
			$("#idbarang").focus();

		} else if ($("#pcs").val() == "") {

			alert("Pcs Harap Diisi!");
			$("#pcs").focus();

		} else if ($("#harga").val() == "") {

			alert("Harga Harap Diisi!");
			$("#harga").focus();

		} else {

			var idbarang = $("#idbarang").val();
			var t = $("#t").val();
			var l = $("#l").val();
			var p = $("#p").val();
			var pcs = $("#pcs").val();
			var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
			var harga = $("#harga").val();
			var hargamodal = $("#hargamodal").val();
			var subtotal = $("#subtotal").val();
			var ket = $("#ket").val();


			//tambah baris

			var jumlahBaris = document.getElementById('table').rows.length;
			var no = parseInt(jumlahBaris) - parseInt(7);

			var tr = "<tr>";
			var tr = tr + "<td>" + no + "</td>";
			var tr = tr + "<td><input type=\"hidden\" value='" + idbarang + "' name=\"idbarang[]\" style=\"width:80px\" id=\"idbarang" + no + "\" onkeyup=\"getIdBarang('" + no + "')\" placeholder=\"ID Barang\"> <input type=\"text\" value='" + t + "' name=\"t[]\" style=\"width:50px\" id=\"t" + no + "\" onkeyup=\"hitungT('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + l + "' name=\"l[]\" style=\"width:50px\" id=\"l" + no + "\" onkeyup=\"hitungL('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + p + "' name=\"p[]\" style=\"width:50px\" id=\"p" + no + "\" onkeyup=\"hitungP('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + pcs + "' name=\"pcs[]\"  style=\"width:50px\" id=\"pcs" + no + "\" onkeyup=\"hitungPcs('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + harga + "' name=\"harga[]\" style=\"width:100px;\" id=\"harga" + no + "\" onkeyup=\"harga('" + no + "')\" ><input type=\"hidden\" value='" + hargamodal + "' name=\"hargamodal[]\" style=\"width:100px;\" id=\"hargamodal" + no + "\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + m3 + "' name=\"m3[]\" style=\"width:100px; background-color:#ccc\" id=\"m3" + no + "\" readonly></td>";
			var tr = tr + "<td><input type=\"text\" value='" + subtotal + "' name=\"subtotal[]\" style=\"width:100px; background-color:#ccc\" id=\"subtotal" + no + "\" readonly ></td>";
			var tr = tr + "<td><input type=\"text\" value='" + ket + "' name=\"ket[]\" style=\"width:100px\" id=\"ket" + no + "\"></td>";
			var tr = tr + "</tr>";

			$("#tambahbaris").append(tr);


			// ambil total sebelumnya
			var totalpcs = menghilangkanKoma($("#totalpcs").val());
			var totalm3 = $("#totalm3").val();
			var totalsubtotal = menghilangkanKoma($("#totalsubtotal").val());

			//jumlah 
			var hasiltotalpcs = parseInt(totalpcs) + parseInt(pcs);
			var hasiltotalm3 = parseFloat(totalm3) + parseFloat(m3);
			var hasiltotalsubtotal = parseInt(totalsubtotal) + parseInt(subtotal);

			$("#totalpcs").val(hasiltotalpcs);
			$("#totalm3").val(hasiltotalm3);
			$("#totalsubtotal").val(formatUang(hasiltotalsubtotal));

			hutang();
			fsdiskon();
			fsBayar();

			// reset
			// reset
			$("#idbarang").val('');
			$("#pcs").val('');
			$("#ambilstok").val('');
			$("#hargamodal").val('');
			$("#harga").val('');
			$("#ket").val('');

			$("#idbarang").focus();

		}




	}
</script>







<script type="text/javascript">
	$("#date").datepicker({

		"dateFormat": "yy-mm-dd"

	});

	$("#kembali").click(function() {


		$.ajax({

			url: '<?php echo base_url('admin/Penjualan/index'); ?>',
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




	})

	function cekHutang(idpelanggan) { //cek hutang



		if (idpelanggan != '') {
			$.ajax({

				url: '<?php echo base_url('admin/Penjualan/cekHutang'); ?>',
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
						$("#hutang").val(formatUang(data.sisahutang));
					} else {
						$("#hutang").val(0);
					}
					if (data.status === false) {
						alert(data.ket);
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
		} else {

			alert('Nama Custamer Tidak Terdaftar, Harap Periksa Kembali!');

		}
	}

	function getIdBarang(angka) {

		cekPelanggan(angka);

		if (event.keyCode === 13) {

			$.ajax({

				url: '<?php echo base_url('admin/Barang/getIdBarang'); ?>',
				type: "GET",
				data: {
					term: $("#idbarang" + angka).val()
				},
				dataType: "JSON",
				success: function(data) {
					if (data[0].idbarang == '') {
						alert('Kode Barang Tidak Di kenal');
					} else {
						$("#t" + angka).val(data[0].t);
						$("#l" + angka).val(data[0].l);
						$("#p" + angka).val(data[0].p);
						$("#pcs" + angka).focus();
					}
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

	}

	function hitungT(angka) {

		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();

		var m3 = (parseFloat(t) * parseFloat(l) * parseFloat(p) * parseFloat(pcs)) / 1000000;
		$("#m3" + angka).val(m3);


		if (event.keyCode === 13) {
			$("#l" + angka).focus();

		}
		idbarang(t, l, p, angka);
		ambilModalLine(t, l, p, angka);
	}

	function hitungL(angka) {

		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();

		var m3 = (parseFloat(t) * parseFloat(l) * parseFloat(p) * parseFloat(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		if (event.keyCode === 13) {
			$("#p" + angka).focus();

		}
		idbarang(t, l, p, angka);
		ambilModalLine(t, l, p, angka);


	}

	function hitungP(angka) {

		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();

		var m3 = (parseFloat(t) * parseFloat(l) * parseFloat(p) * parseFloat(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		if (event.keyCode === 13) {
			$("#pcs" + angka).focus();
			$("#pcs" + angka).val('');
		}

		idbarang(t, l, p, angka);
		ambilModalLine(t, l, p, angka);


	}

	function idbarang(t, l, p, angka) { //membuat idbarang
		var idbarang = t.toString() + l.toString() + p.toString();
		$("#idbarang" + angka).val(idbarang);
	}


	function ambilModalLine(tinggi, lebar, panjang, angka) {

		$.ajax({

			url: '<?php echo base_url('admin/Penjualan/ambilModal'); ?>' + '/' + tinggi + '/' + lebar + '/' + panjang,
			type: "POST",
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				//$(".preloader").show();
			},

			success: function(data) {

				var hargamodal = data.hargamodal;
				if (hargamodal != null || hargamodal != '') {
					$("#hargamodal" + angka).val(formatUang(data.hargamodal));
				} else {
					alert("Periksa Kembali, Barang tidak tersedia!");
				}

				//$('#formPenjualan')[0].reset();
			},
			complete: function(data) {
				//$(".preloader").hide();

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




	function hitungPcs(angka) {


		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();
		var idpelanggan = $("#idpelanggan").val();

		var m3 = (parseFloat(t) * parseFloat(l) * parseFloat(p) * parseFloat(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		var harga = menghilangkanKoma($("#harga" + angka).val());
		var subtotal = parseInt(pcs) * parseInt(harga);
		$("#subtotal" + angka).val(subtotal);

		if (event.keyCode === 13) {
			$("#harga" + angka).focus();

			//cek stok barang
			cekStok(t, l, p, pcs, angka);

			if (idpelanggan == "") {

				alert('Harap Pilih Custamer Untuk Mngetahui Pembelian Terakhir');
				$("#namapelanggan").focus();
			} else {

				showHarga(t, l, p, pcs, idpelanggan);
			}

		}


		//menjumlahkan total
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(8);

		var totalpcs = 0;
		var totalm3 = 0;
		var totalsubtotal = 0;
		for (i = 1; i <= jumlah; i++) {

			var totalpcs = parseInt(totalpcs) + parseInt($("#pcs" + i).val());
			var totalm3 = parseFloat(totalm3) + parseFloat($("#m3" + i).val());
			var totalsubtotal = totalsubtotal + parseInt($("#subtotal" + i).val());

		}
		$("#totalpcs").val(totalpcs);
		$("#totalm3").val(totalm3);
		$("#totalsubtotal").val(totalsubtotal);

		hargaP(angka);




	}

	function hargaP(angka) { //menjumlahkan apabila ada perubhan pcs

		var pcs = $("#pcs" + angka).val();
		var harga = menghilangkanKoma($("#harga" + angka).val());
		var subtotal = Math.round(parseInt(pcs) * parseInt(harga));
		$("#subtotal" + angka).val(subtotal);


		if (harga == 0 | harga == '') {
			$("#harga" + angka).val('');
		} else {
			$("#harga" + angka).val(formatUang(harga));
		}


		//menjumlahkan subtotal
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(8);



		var totalsubtotal = 0;
		for (i = 1; i <= jumlah; i++) {

			var totalsubtotal = totalsubtotal + parseInt($("#subtotal" + i).val());
		}
		$("#totalsubtotal").val(formatUang(totalsubtotal));



		hutang();
		fsdiskon();
		fsBayar();

	}

	function harga(angka) {

		var pcs = $("#pcs" + angka).val();
		var harga = menghilangkanKoma($("#harga" + angka).val());
		var subtotal = Math.round(parseInt(pcs) * parseInt(harga));
		$("#subtotal" + angka).val(subtotal);

		if (harga == 0 | harga == '') {
			$("#harga" + angka).val('');
		} else {
			$("#harga" + angka).val(formatUang(harga));
		}

		//menjumlahkan subtotal
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(8);

		var totalsubtotal = 0;
		for (i = 1; i <= jumlah; i++) {

			var totalsubtotal = totalsubtotal + parseInt($("#subtotal" + i).val());
		}
		$("#totalsubtotal").val(formatUang(totalsubtotal));

		//even baris kebawah ketika enter
		loncat = parseInt(angka) + parseInt(1);
		if (event.keyCode === 13) {

			$("#idbarang" + loncat).focus();

			if (angka == jumlah) { // jika baris terakhir akan menambah baris baru

				tambahBaris();

			}



		}



		hutang();
		fsdiskon();
		fsBayar();

	}

	function hutang() {

		var cek = $("#pilihhutang").val();

		if (cek == 'yes') {
			var hutang = menghilangkanKoma($("#hutang").val());
		}

		if (cek == 'no') {
			var hutang = 0;
		}

		var totalsetelahhutang = menghilangkanKoma($("#totalsubtotal").val());
		var hitung = parseInt(hutang) + parseInt(totalsetelahhutang);
		$("#totalsetelahhutang").val(formatUang(hitung));


	}

	$("#pilihhutang").change(function() {

		var cek = $(this).val();

		if (cek == 'yes') {
			var hutang = menghilangkanKoma($("#hutang").val());
		}

		if (cek == 'no') {
			var hutang = 0;
		}

		var totalsetelahhutang = menghilangkanKoma($("#totalsubtotal").val());
		var hitung = parseInt(hutang) + parseInt(totalsetelahhutang);
		$("#totalsetelahhutang").val(formatUang(hitung));

		fsdiskon();
		fsBayar();

	})

	function fsdiskon() {

		var diskon = $("#diskon").val();
		var totalsetelahhutang = menghilangkanKoma($("#totalsetelahhutang").val());
		var hitung = parseInt(totalsetelahhutang) - parseInt(menghilangkanKoma(diskon));
		$("#totalsetelahdiskon").val(formatUang(hitung));
		$("#totalpembayaran").val(formatUang(hitung));

		fsBayar();


	}

	function fsBayar() {

		var bayar = menghilangkanKoma($("#totalbayar").val());
		var totalpembayaran = menghilangkanKoma($("#totalpembayaran").val());
		var hitung = parseInt(totalpembayaran) - parseInt(bayar);

		var angka = hitung.toString().replace('-', '');
		if (parseInt(bayar) > parseInt(totalpembayaran)) {
			$("#ket").html('Kembali')
			alert('Masukan Nilai Sejumlah yang dibayarkan, Tidak boleh melebihi nilai pembayaran!');
			$('#simpan').attr('disabled', 'disabled');

		} else {

			$("#ket").html('Sisa')
			$('#simpan').removeAttr('disabled', 'disabled');

		}

		$("#sisa").val(formatUang(angka));

	}


	//mask harga
	$('.angka,#harga').mask('000,000,000,000,000,000,000', {
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


	function tambahBaris() {

		var jumlahBaris = document.getElementById('table').rows.length;
		var no = parseInt(jumlahBaris) - parseInt(7);

		var tr = "<tr>";
		var tr = tr + "<td>" + no + "</td>";
		var tr = tr + "<td><input type=\"hidden\" name=\"idbarang[]\" style=\"width:80px\" id=\"idbarang" + no + "\" onkeyup=\"getIdBarang('" + no + "')\" placeholder=\"ID Barang\"> <input type=\"text\" name=\"t[]\" style=\"width:50px\" id=\"t" + no + "\" onkeyup=\"hitungT('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"l[]\" style=\"width:50px\" id=\"l" + no + "\" onkeyup=\"hitungL('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"p[]\" style=\"width:50px\" id=\"p" + no + "\" onkeyup=\"hitungP('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"pcs[]\" value=\"0\" style=\"width:50px\" id=\"pcs" + no + "\" onkeyup=\"hitungPcs('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"harga[]\" style=\"width:100px;\" id=\"harga" + no + "\" onkeyup=\"harga('" + no + "')\" ><input type=\"hidden\" name=\"hargamodal[]\" style=\"width:100px;\" id=\"hargamodal" + no + "\" ></td>";
		var tr = tr + "<td><input type=\"text\" name=\"m3[]\" value=\"0\" style=\"width:100px; background-color:#ccc\" id=\"m3" + no + "\" readonly></td>";
		var tr = tr + "<td><input type=\"text\" name=\"subtotal[]\" value=\"0\" style=\"width:100px; background-color:#ccc\" id=\"subtotal" + no + "\" readonly ></td>";
		var tr = tr + "<td><input type=\"text\" name=\"ket[]\" style=\"width:100px\" id=\"ket" + no + "\"></td>";
		var tr = tr + "</tr>";

		$("#tambahbaris").append(tr);

	};


	function showHarga(tinggi, lebar, panjang, pcsj, idpelanggan) {


		$.ajax({

			url: '<?php echo base_url('admin/Penjualan/showHarga'); ?>', //show penjualan terakhir;
			type: "POST",
			data: {
				t: tinggi,
				l: lebar,
				p: panjang,
				pcs: pcsj,
				idcust: idpelanggan
			},
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				$(".preloader").show();
			},

			success: function(data) {
				var tbody = "";
				if (data.status === true) {

					for (i = 0; i < data.data.length; i++) {
						if (data.data[i].ket == '') {
							var ket = "Bagus"
						} else {
							var ket = data.data[i].ket;
						}
						var tbody = tbody + "<tr>";
						var tbody = tbody + "<td>" + data.data[i].date + "</td><td>" + formatUang(data.data[i].hargasatuan) + "</td><td>" + ket + "</td>";
						var tbody = tbody + "</tr>";
					}


					$("#showHarga").html(tbody);

				}
				if (data.status === false) {
					alert(data.ket);
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


	function cekStok(tinggi, lebar, panjang, pcsj, no) {

		var idbarang = tinggi.toString() + lebar.toString() + panjang.toString();
		var pcs = pcsj;
		//menjumlahkan subtotal
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(8);
		for (i = 1; i <= jumlah; i++) {
			if (idbarang == $("#idbarang" + i).val()) {

				if (no != i) {
					pcs = parseInt(pcs) + parseInt($("#pcs" + i).val());
				}
			}
		}



		$.ajax({

			url: '<?php echo base_url('admin/Penjualan/cekStok'); ?>' + '/' + tinggi + '/' + lebar + '/' + panjang + '/' + pcs,
			type: "POST",
			dataType: "JSON",

			beforeSend: function() {
				$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
				//$(".preloader").show();
			},

			success: function(data) {

				$("#hargamodal" + no).val(data.hargamodal);
				if (data.status === false) {
					alert(data.ket);
					$("#pcs" + no).val(0);
					$("#pcs" + no).focus();
				}


				//$('#formPenjualan')[0].reset();
			},
			complete: function(data) {
				//$(".preloader").hide();

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


	$("#reset").click(function(e) {

		e.preventDefault();
		if (confirm('Lakukan Reset Transaksi')) {

			$.ajax({
				url: '<?php echo base_url('admin/Penjualan/getNotaPenjualan'); ?>',
				type: "GET",
				data: {
					iduser: $('#user').val()
				},
				dataType: "JSON",
				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {

					if (data.status === true) {
						$('#formPenjualan')[0].reset();
						$("#so").val(data.notaPenjualan)
					}

					$("#print1").attr('disabled', 'disabled');
					$("#print2").attr('disabled', 'disabled');
					$("#update").attr('disabled', 'disabled');
					$("#simpan").removeAttr('disabled', 'disabled');
					$("#namapelanggan").removeAttr('readonly', 'readonly');


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
	})

	$('#update').click(function(e) {
		e.preventDefault();

		if (confirm('Apa Ingin Melakukan Perubahan Transaksi?')) {

			if ($("#namapelanggan").val() == null) {
				alert('Harap Pilih Custamer');
				$("#namapelanggan").focus();
			} else if ($("#date").val() == '') {
				alert('Date Tidak Boleh Kosong');
				$("#date").focus();
			} else if ($("#totalbayar").val() == '') {
				alert('Harap lakukan pembayaran!');
				$("#totalbayar").focus();
			} else {

				$.ajax({

					url: '<?php echo base_url('admin/Penjualan/updatePenjualan'); ?>',
					type: "POST",
					data: $('#formPenjualan').serialize(),
					dataType: "JSON",

					beforeSend: function() {
						$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						$(".preloader").show();
					},

					success: function(data) {

						if (data.status === true) {
							alert(data.ket);
						}
						if (data.status === false) {
							alert(data.ket);
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
		}

	})


	$('#print1').click(function(e) {
		e.preventDefault();

		window.open("<?php echo base_url('admin/Penjualan/printPenjualan1/'); ?>" + $("#so").val(), '_blank');

	})

	$('#print2').click(function(e) {
		e.preventDefault();

		window.open("<?php echo base_url('admin/Penjualan/printPenjualan2/'); ?>" + $("#so").val(), '_blank');

	})
</script>