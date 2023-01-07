<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Pembelian
		<small>Control panel Add</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Pembelian/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Form Add</li>
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
								<td colspan="2"><input type="text" name="po" id="po" value="<?php echo $po; ?>" readonly class="form-control" style="text-align:center"></td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Date :</td>
								<td>
									<input type="text" name="date" required class="form-control" style="color:black;" value="<?php echo date('Y-m-d'); ?>" readonly>
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">User :</td>
								<td>
									<input type="text" name="user" value="<?php echo $user; ?>" id="user" required class="form-control" placeholder="User" style="color:black;" readonly>
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Suplayer :</td>
								<td>
									<input type="text" name="namasuplayer" id="namasuplayer" class="form-control" style="color:black;" placeholder="Suplayer">
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px" rowspan="2">ID Barang :</td>
								<td>
									<input type="text" class="form-control" name="idbarang" id="idbarang" placeholder="ID Barang">

								</td>
							</tr>
							<tr>
								<td>
									<input type="text" name="t" id="t" placeholder="T" style="width:50px; height: 34px; border: 1px solid #ccc;">
									<input type="text" name="l" id="l" placeholder="L" style="width:50px; height: 34px; border: 1px solid #ccc;">
									<input type="text" name="p" id="p" placeholder="P" style="width:50px; height: 34px; border: 1px solid #ccc;">
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Pcs :</td>
								<td>
									<input type="number" class="form-control" name="pcs" id="pcs" placeholder="PCS">
								</td>
							</tr>
							<tr>
								<td style="background-color:#7FFFD4" width="100px">Harga M3 :</td>
								<td>
									<input type="text" class="form-control" name="hargam3" id="hargam3" placeholder="Harga M3">
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

				<div class="col-md-9">
					<div class="box-body" style="background-color:white; border:1px solid #ccc">
						<form id="formPembelian" action="#" method="POST">
							<input type="hidden" name="po" id="po" value="<?php echo $po; ?>" readonly class="form-control" style="text-align:center">
							<input type="hidden" name="user" value="<?php echo $user; ?>" id="user" required class="form-control" placeholder="User" style="color:black;" readonly>
							<input type="hidden" name="date" id="date" required class="form-control" style="color:black;" value="<?php echo date('Y-m-d'); ?>" readonly>
							<input type="hidden" name="idsuplayer" id="idsuplayer" class="form-control" style="color:black;" value=''>

							<table id="table" class="table table-striped">
								<thead>
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
										<th> Harga Satuan </th>

									</tr>
								</thead>
								<tbody id="tambahbaris">


								</tbody>
								<tfoot>
									<tr>
										<td colspan="4" align="center"><b>Jumlah</b></td>
										<td align="center"> <input type="text" value='0' name="totalpcs" style="width:50px;background-color:#ccc" id="totalpcs" readonly> </td>
										<td align="center"> <input type="text" value='0' name="totalm3" id="totalm3" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>
										<td align="center"> <input type="text" value='0' name="totalsubtotal" id="totalsubtotal" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>
										<td></td>

									</tr>
									<tr style="background-color:#f0f0f0" id="tampilpiutang">
										<td colspan="7" align="right">Piutang</td>
										<td align="center"> <input type="text" name="piutang" id="piutang" value="0" onkeyup="piutang()" style="width:100px;;background-color:#ccc" readonly> </td>
										<td align="center"><input type="text" name="totalsetelahpiutang" id="totalsetelahpiutang" style="width:100px;background-color:#ccc" readonly> </td>
										<td align="left">
											<select name="pilihpiutang" id="pilihpiutang">
												<option value="yes">Sertakan</option>
												<option value="no" selected>Tidak Sertakan</option>
											</select>
										</td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="7" align="right">Bongkar</td>
										<td align="center"> <input type="text" name="bongkar" id="bongkar" class="angka" placeholder="0" onkeyup="fsBongkar()" style="width:100px;"> </td>
										<td align="center"> <input type="text" name="totalsetelahbongkar" id="totalsetelahbongkar" style="width:100px;;background-color:#ccc"> </td>
										<td align="left"> </td>

									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="7" align="right">Transport</td>
										<td align="center"> <input type="text" name="transport" id="transport" class="angka" placeholder="0" onkeyup="fsTransport()" style="width:100px"> </td>
										<td align="center"> <input type="text" name="totalsetelahtransport" id="totalsetelahtransport" style="width:100px;background-color:#ccc" readonly> </td>
										<td align="left"></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="8" align="right">Total Pembayaran</td>
										<td align="center"> <input type="text" name="totalpembayaran" id="totalpembayaran" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="8" align="right">Metode</td>
										<td align="center"> <input type="radio" name="metode" id="metode" value="Dp"> DP <input type="radio" checked name="metode" id="metode" value="Tunai"> Tunai </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="8" align="right">Bayar</td>
										<td align="center"> <input type="text" name="totalbayar" id="totalbayar" class="angka tambahBaris" style="width:100px" onkeyup="fsBayar()"> </td>
										<td></td>
									</tr>
									<tr style="background-color:#f0f0f0">
										<td colspan="8" align="right"><i id='ket'>Sisa</i></td>
										<td align="center"> <input type="text" name="sisa" id="sisa" style="width:100px;;background-color:#ccc" readonly> </td>
										<td></td>
									</tr>
								</tfoot>
							</table>

						</form>

						<div class="col-md-12" style="padding-top:10px">
							<div class="col-md-6" align="left">
								<button type="button" class="btn btn-danger" id="reset"><i class="fa fa-reset">Reset</i></button>
							</div>
							<div class="col-md-6" align="right">
								<button type="button" class="btn btn-warning" id="print1" disabled><i class="fa fa-print"> Print 1</i></button>
								<button type="button" class="btn btn-warning" id="print2" disabled><i class="fa fa-print"> Print 2</i></button>
								<!--<button type="button" class="btn btn-info" id="update" disabled><i class="fa fa-reset">Upadate</i></button>--->
								<button type="button" class="btn btn-success" id="simpan"><i class="fa fa-save">Simpan</i></button>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

	</div>
</div>



<script type="text/javascript">
	$('#namasuplayer').autocomplete({
		source: "<?php echo base_url('admin/Suplayer/getSuplayerAuto'); ?>",
		autoFocus: true,
		minLength: 2,
		select: function(event, ui) {
			$(this).val(ui.item.label);
			$('#idsuplayer').val(ui.item.idsuplayer);
			$("#idbarang").focus();

			cekPiutang(ui.item.idsuplayer) //cekpiutang


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
				$("#namasuplayer").focus();
			} else {
				showHarga(ui.item.t, ui.item.l, ui.item.p, 0, $("#idsuplayer").val());
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

	$("#t").keyup(function() {


		var t = $("#t").val();
		var l = $("#l").val();
		var p = $("#p").val();

		if (event.keyCode === 13) {
			$("#l").focus();
		}

		var idbarang = t.toString() + l.toString() + p.toString();
		$("#idbarang").val(idbarang);


	})


	$("#l").keyup(function() {


		var t = $("#t").val();
		var l = $("#l").val();
		var p = $("#p").val();

		if (event.keyCode === 13) {
			$("#p").focus();
		}

		var idbarang = t.toString() + l.toString() + p.toString();
		$("#idbarang").val(idbarang);


	})


	$("#p").keyup(function() {

		var t = $("#t").val();
		var l = $("#l").val();
		var p = $("#p").val();

		if (event.keyCode === 13) {
			$("#pcs").focus();
		}

		var idbarang = t.toString() + l.toString() + p.toString();
		$("#idbarang").val(idbarang);


	})





	$("#pcs").keyup(function() {

		if (event.keyCode === 13 && $(this).val() != "")

			$("#hargam3").focus();


	})


	$("#hargam3").keyup(function() {

		if (event.keyCode === 13 && $(this).val() != "")
			$("#ket").focus();


	});

	$("#ket").keyup(function() {

		if (event.keyCode === 13)

			tambahBarang()


	})


	function tambahBarang() {

		if ($("#idsuplayer").val() == "") {

			alert("Suplayer Harap Diisi!");
			$("#namasuplayer").focus();

		} else if ($("#idbarang").val() == "") {

			alert("Id Barang Harap Diisi!");
			$("#idbarang").focus();

		} else if ($("#pcs").val() == "") {

			alert("Pcs Harap Diisi!");
			$("#pcs").focus();

		} else if ($("#hargam3").val() == "") {

			alert("Harga M3 Harap Diisi!");
			$("#hargam3").focus();

		} else {

			var idbarang = $("#idbarang").val();
			var t = $("#t").val();
			var l = $("#l").val();
			var p = $("#p").val();
			var pcs = $("#pcs").val();
			var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
			var hargam3 = menghilangkanKoma($("#hargam3").val());
			var subtotal = Math.round(parseFloat(m3) * parseInt(hargam3));
			var ket = $("#ket").val();
			var harga = subtotal / parseInt(pcs);
			harga = Math.round(harga);
			$("#harga").val(formatUang(harga));


			var jumlahBaris = document.getElementById('table').rows.length;
			var no = parseInt(jumlahBaris) - parseInt(8);

			var tr = "<tr>";
			var tr = tr + "<td>" + no + "</td>";
			var tr = tr + "<td><input type=\"hidden\" value='" + idbarang + "' name=\"idbarang[]\" style=\"width:80px\" id=\"idbarang" + no + "\" onkeyup=\"getIdBarang('" + no + "')\" placeholder=\"ID Barang\"> <input type=\"text\" value='" + t + "' name=\"t[]\" style=\"width:50px\" id=\"t" + no + "\" onkeyup=\"hitungT('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + l + "' name=\"l[]\" style=\"width:50px\" id=\"l" + no + "\" onkeyup=\"hitungL('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + p + "' name=\"p[]\" style=\"width:50px\" id=\"p" + no + "\" onkeyup=\"hitungP('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + pcs + "' name=\"pcs[]\" style=\"width:50px\" id=\"pcs" + no + "\" onkeyup=\"hitungPcs('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + m3 + "' name=\"m3[]\" style=\"width:100px; background-color:#ccc\" id=\"m3" + no + "\" readonly></td>";
			var tr = tr + "<td><input type=\"text\" value='" + formatUang(hargam3) + "' name=\"hargam3[]\" style=\"width:100px\" id=\"hargam3" + no + "\" onkeyup=\"hargaM3('" + no + "')\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + subtotal + "' name=\"subtotal[]\" style=\"width:100px; background-color:#ccc\" id=\"subtotal" + no + "\" readonly ></td>";
			var tr = tr + "<td><input type=\"text\" value='" + ket + "' name=\"ket[]\" style=\"width:100px\" id=\"ket" + no + "\"></td>";
			var tr = tr + "<td><input type=\"text\" value='" + formatUang(harga) + "' name=\"harga[]\" style=\"width:100px; background-color:#ccc\" id=\"harga" + no + "\" readonly></td>";
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


			piutang();
			fsBongkar();
			fsTransport();
			fsBayar();

			// reset
			$("#idbarang").val('');
			$("#t").val('');
			$("#l").val('');
			$("#p").val('');
			$("#pcs").val('');
			$("#hargam3").val('');
			$("#ket").val('');
			$("#idbarang").focus();

		}




	}
</script>





<script type="text/javascript">
	$("#date").datepicker({

		"dateFormat": "yy-mm-dd"

	});


	function getIdBarang(angka) {

		cekSuplayer(angka);

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

		var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		if (event.keyCode === 13) {
			$("#l" + angka).focus();
		}
		idbarang(t, l, p, angka);
		hitungUlangHarga(angka);

	}

	function hitungL(angka) {

		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();

		var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		if (event.keyCode === 13) {
			$("#p" + angka).focus();
		}
		idbarang(t, l, p, angka);
		hitungUlangHarga(angka);


	}

	function hitungP(angka) {

		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();

		var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		if (event.keyCode === 13) {
			$("#pcs" + angka).focus();
			$("#pcs" + angka).val('');
		}
		idbarang(t, l, p, angka);
		hitungUlangHarga(angka);


	}

	function idbarang(t, l, p, angka) { //membuat idbarang
		var idbarang = t.toString() + l.toString() + p.toString();
		$("#idbarang" + angka).val(idbarang);
	}




	function hitungUlangHarga(angka) {


		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();
		var idsuplayer = $("#idsuplayer").val()
	
		var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
		$("#m3" + angka).val(m3);

		//menjumlahkan total
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(9);

		var totalpcs = 0;
		var totalm3 = 0;
		for (i = 1; i <= jumlah; i++) {

			var totalpcs = parseInt(totalpcs) + parseInt($("#pcs" + i).val());
			var totalm3 = parseFloat(totalm3) + parseFloat($("#m3" + i).val());

		}
		$("#totalpcs").val(totalpcs);
		$("#totalm3").val(totalm3);

		hargaM3p(angka);
		showHarga(t, l, p, pcs, idsuplayer);




	}

	function hitungPcs(angka) {


		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();
		var idsuplayer = $("#idsuplayer").val()

		var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
		$("#m3" + angka).val(m3);



		if (event.keyCode === 13) {
			$("#hargam3" + angka).focus();

			if (idsuplayer == '') {

				alert('Harap Pilih Custamer Untuk Mngetahui Pembelian Terakhir');
				$("#namasuplayer").focus();
			} else {

				showHarga(t, l, p, pcs, idsuplayer);
			}

		}


		//menjumlahkan total
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(9);

		var totalpcs = 0;
		var totalm3 = 0;
		for (i = 1; i <= jumlah; i++) {

			var totalpcs = parseInt(totalpcs) + parseInt($("#pcs" + i).val());
			var totalm3 = parseFloat(totalm3) + parseFloat($("#m3" + i).val());

		}
		$("#totalpcs").val(totalpcs);
		$("#totalm3").val(totalm3);

		hargaM3p(angka);




	}



	function hargaM3p(angka) { //penjumlahan saat perubahan pcs

		var m3 = $("#m3" + angka).val();
		var hargam3 = menghilangkanKoma($("#hargam3" + angka).val());
		var subtotal = Math.round(parseFloat(m3) * parseInt(hargam3));
		$("#subtotal" + angka).val(subtotal);


		//menentukan harga satuan
		var pcs = $("#pcs" + angka).val();
		var harga = subtotal / parseInt(pcs);
		harga = Math.round(harga);
		$("#harga" + angka).val(formatUang(harga));

		//menjumlahkan subtotal
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(9);

		var totalsubtotal = 0;
		for (i = 1; i <= jumlah; i++) {
			var totalsubtotal = totalsubtotal + parseInt($("#subtotal" + i).val());
		}
		$("#totalsubtotal").val(formatUang(totalsubtotal));


		piutang();
		fsBongkar();
		fsTransport();
		fsBayar();

	}


	function hargaM3(angka) {

		var m3 = $("#m3" + angka).val();
		var hargam3 = menghilangkanKoma($("#hargam3" + angka).val());
		var subtotal = Math.round(parseFloat(m3) * parseInt(hargam3));
		$("#subtotal" + angka).val(subtotal);


		//menentukan harga satuan
		var pcs = $("#pcs" + angka).val();
		var harga = subtotal / parseInt(pcs);
		harga = Math.round(harga);
		$("#harga" + angka).val(formatUang(harga));


		if (hargam3 == 0 | hargam3 == '') {
			$("#hargam3" + angka).val('');
		} else {
			$("#hargam3" + angka).val(formatUang(hargam3));
		}

		//menjumlahkan subtotal
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(9);

		var totalsubtotal = 0;
		for (i = 1; i <= jumlah; i++) {
			var totalsubtotal = totalsubtotal + parseInt($("#subtotal" + i).val());
		}
		$("#totalsubtotal").val(formatUang(totalsubtotal));

		loncat = parseInt(angka) + parseInt(1);
		if (event.keyCode === 13) {

			$("#t" + loncat).focus();

			if (angka == jumlah) { // jika baris terakhir akan menambah baris baru

				tambahBaris();

			}



		}



		piutang();
		fsBongkar();
		fsTransport();
		fsBayar();

	}




	function piutang() {

		var cek = $("#pilihpiutang").val();

		if (cek == 'yes') {
			var piutang = menghilangkanKoma($("#piutang").val());
		}

		if (cek == 'no') {
			var piutang = 0;
		}

		var totalsetelahpiutang = menghilangkanKoma($("#totalsubtotal").val());
		var hitung = parseInt(piutang) + parseInt(totalsetelahpiutang);
		$("#totalsetelahpiutang").val(formatUang(hitung));


	}

	$("#pilihpiutang").change(function() {

		var cek = $(this).val();

		if (cek == 'yes') {
			var piutang = menghilangkanKoma($("#piutang").val());
		}

		if (cek == 'no') {
			var piutang = 0;
		}

		var totalsetelahpiutang = menghilangkanKoma($("#totalsubtotal").val());
		var hitung = parseInt(piutang) + parseInt(totalsetelahpiutang);
		$("#totalsetelahpiutang").val(formatUang(hitung));

		fsBongkar();
		fsTransport();
		fsBayar();

	})

	function fsBongkar() {

		var bongkar = $("#bongkar").val();
		var totalsetelahbongkar = menghilangkanKoma($("#totalsetelahpiutang").val());
		var hitung = parseInt(totalsetelahbongkar) - parseInt(menghilangkanKoma(bongkar));
		$("#totalsetelahbongkar").val(formatUang(hitung));

		fsTransport();
		fsBayar();


	}

	function fsTransport() {

		var transport = $("#transport").val();
		var totalsetelahbongkar = menghilangkanKoma($("#totalsetelahbongkar").val());
		var hitung = parseInt(totalsetelahbongkar) - parseInt(menghilangkanKoma(transport));
		$("#totalsetelahtransport").val(formatUang(hitung));
		$("#totalpembayaran").val(formatUang(hitung));

		fsBayar();

	}

	function fsBayar() {

		var bayar = menghilangkanKoma($("#totalbayar").val());
		var totalsetelahtransport = menghilangkanKoma($("#totalsetelahtransport").val());
		var hitung = parseInt(totalsetelahtransport) - parseInt(bayar);

		var angka = hitung.toString().replace('-', '');
		if (parseInt(bayar) > parseInt(totalsetelahtransport)) {
			$("#ket").html('Kembali');
			alert('Masukan Nilai Sejumlah yang dibayarkan, Tidak boleh melebihi nilai pembayaran!');
			$('#simpan').attr('disabled', 'disabled');
			$('#update').attr('disabled', 'disabled');

		} else {

			$("#ket").html('Sisa');
			$('#simpan').removeAttr('disabled', 'disabled');
			$('#update').removeAttr('disabled', 'disabled');

		}

		$("#sisa").val(formatUang(angka));

	}


	//mask harga
	$('.angka, #hargam3').mask('000,000,000,000,000,000,000', {
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
		var no = parseInt(jumlahBaris) - parseInt(8);

		var tr = "<tr>";
		var tr = tr + "<td>" + no + "</td>";
		var tr = tr + "<td><input type=\"hidden\" name=\"idbarang[]\" style=\"width:80px\" id=\"idbarang" + no + "\" onkeyup=\"getIdBarang('" + no + "')\" placeholder=\"ID Barang\"> <input type=\"text\" name=\"t[]\" style=\"width:50px\" id=\"t" + no + "\" onkeyup=\"hitungT('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"l[]\" style=\"width:50px\" id=\"l" + no + "\" onkeyup=\"hitungL('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"p[]\" style=\"width:50px\" id=\"p" + no + "\" onkeyup=\"hitungP('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"pcs[]\" value=\"0\" style=\"width:50px\" id=\"pcs" + no + "\" onkeyup=\"hitungPcs('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"m3[]\" value=\"0\" style=\"width:100px; background-color:#ccc\" id=\"m3" + no + "\" readonly></td>";
		var tr = tr + "<td><input type=\"text\" name=\"hargam3[]\" style=\"width:100px\" id=\"hargam3" + no + "\" onkeyup=\"hargaM3('" + no + "')\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"subtotal[]\" value=\"0\" style=\"width:100px; background-color:#ccc\" id=\"subtotal" + no + "\" readonly ></td>";
		var tr = tr + "<td><input type=\"text\" name=\"ket[]\" style=\"width:100px\" id=\"ket" + no + "\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"harga[]\" style=\"width:100px; background-color:#ccc\" id=\"harga" + no + "\" readonly></td>";
		var tr = tr + "</tr>";

		$("#tambahbaris").append(tr);

	};





	function cekSuplayer(angka) { //cek suplayer apa sudah di isi apa blm

		if ($("#namasuplayer").val() == '' | $("#idsuplayer").val() == '') {

			alert('Nama Suplayer Harap Di Isi!');
			$("#namasuplayer").focus();
			$("#idbarang" + angka).val('');

		};


	}

	function cekPiutang(idsuplayer) {

		if (idsuplayer != '' | idsuplayer != null) {
			$.ajax({

				url: '<?php echo base_url('admin/Pembelian/cekPiutang'); ?>',
				type: "POST",
				data: {
					idsup: idsuplayer
				},
				dataType: "JSON",

				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {

					if (data.status === true && data.sisahutang != null) {
						$("#piutang").val(formatUang(data.sisahutang));
					} else {
						$("#piutang").val(0);
					}
					if (data.status === false) {
						alert(data.ket);
					}

					$("#info").fadeIn('slow');
					$("#info").html("<div class='alert-success' align='center'> Berhasil Disimpan </div>")
					$("#info").fadeOut('slow');


					//$('#formPembelian')[0].reset();
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
			alert('Nama Suplayer Tidak Terdaftar, Harap Periksa Kembali!');
		}
	}


	function showHarga(tinggi, lebar, panjang, pcsj, idsuplayer) { //list harga pembelian terakhir


		$.ajax({

			url: '<?php echo base_url('admin/Pembelian/showHarga'); ?>', //show penjualan terakhir;
			type: "POST",
			data: {
				t: tinggi,
				l: lebar,
				p: panjang,
				pcs: pcsj,
				idsup: idsuplayer
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
						var tbody = tbody + "<td>" + data.data[i].date + "</td><td>" + formatUang(data.data[i].hargam3) + "</td><td>" + ket + "</td>";
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





	$('#simpan').click(function(e) {
		e.preventDefault();

		if (confirm('Apa Ingin Melakukan Pembelian Barang?')) {

			if ($("#namasuplayer").val() == '' | $("#idsuplayer").val() == '') {
				alert('Harap Pilih Suplayer');
				$("#namasuplayer").focus();
			} else if ($("#date").val() == '') {
				alert('Date Tidak Boleh Kosong');
				$("#date").focus();
			} else if ($("#totalbayar").val() == '') {
				alert('Harap lakukan pembayaran!');
				$("#totalbayar").focus();
			} else {

				$.ajax({

					url: '<?php echo base_url('admin/Pembelian/simpanPembelian'); ?>',
					type: "POST",
					data: $('#formPembelian').serialize(),
					dataType: "JSON",

					beforeSend: function() {
						$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						$(".preloader").show();
					},

					success: function(data) {

						if (data.status === true) {
							alert(data.ket);
							$("#print1").removeAttr('disabled', 'disabled');
							$("#print2").removeAttr('disabled', 'disabled');
							$("#update").removeAttr('disabled', 'disabled');
							//$("#simpan").attr('disabled','disabled');
							$("#namasuplayer").attr('disabled', 'disabled');
						}
						if (data.status === false) {
							alert(data.ket);
						}

						$("#info").fadeIn('slow');
						$("#info").html("<div class='alert-success' align='center'> Berhasil Disimpan </div>")
						$("#info").fadeOut('slow');


						//$('#formPembelian')[0].reset();
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

	$("#reset").click(function(e) {

		e.preventDefault();
		if (confirm('Lakukan Reset Nota Pembelian?')) {


			$.ajax({

				url: "<?php echo base_url('admin/Pembelian/addPembelian'); ?>",
				type: "POST",
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

	$('#update').click(function(e) {
		e.preventDefault();

		if (confirm('Apa Ingin Melakukan Perubahan Pembelian Barang?')) {

			if ($("#namasuplayer").val() == null) {
				alert('Harap Pilih Suplayer');
				$("#namasuplayer").focus();
			} else if ($("#date").val() == '') {
				alert('Date Tidak Boleh Kosong');
				$("#date").focus();
			} else if ($("#totalbayar").val() == '') {
				alert('Harap lakukan pembayaran!');
				$("#totalbayar").focus();
			} else {

				$.ajax({

					url: '<?php echo base_url('admin/Pembelian/updatePembelian'); ?>',
					type: "POST",
					data: $('#formPembelian').serialize(),
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

						//$('#formPembelian')[0].reset();
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

		window.open("<?php echo base_url('admin/Pembelian/printPembelian1/'); ?>" + $("#po").val(), '_blank');

	})

	$('#print2').click(function(e) {
		e.preventDefault();

		window.open("<?php echo base_url('admin/Pembelian/printPembelian2/'); ?>" + $("#po").val(), '_blank');

	})
</script>