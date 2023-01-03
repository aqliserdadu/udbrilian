<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Stock Opname
		<small>Control panel Add</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Barang/stockOpname"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Form Add</li>
	</ol>
</section>




<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box-body" style="background-color:white; border:1px solid #ccc">
				<div class="row">

					<form id="form" action="#" method="POST">
						<div class="col-md-12">
							<div style="padding:5px; text-align:center; background-color:#7FFFD4; color:black; border:1px solid #fff">
								<input type="text" name="po" id="po" value="<?php echo $po; ?>" readonly class="form-control" style="text-align:center">
							</div>
						</div>


						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1" style="background-color:#7FFFD4; color:black;"><b>User :</b></span>
								<input type="text" name="user" value="<?php echo $user; ?>" id="user" required class="form-control" placeholder="User" style="color:black;" readonly>
							</div>
						</div>

						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1" style="background-color:#7FFFD4; color:black;">Date :</span>
								<input type="text" name="date" id="date" required class="form-control" style="color:black;" value="<?php echo date('Y-m-d'); ?>" readonly>
							</div>
						</div>

						<div class="col-md-4">
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon1" style="background-color:#7FFFD4; color:black;">Keterangan :</span>
								<input type="text" name="namaketerangan" id="namaketerangan" maxlength="20" class="form-control" style="color:black;" placeholder="keterangan">

							</div>
						</div>


						<div class="col-md-12">

							<table id="table" class="table table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th></th>
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
									<tr>
										<td>1</td>
										<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang1" onkeyup="getIdBarang('1')" placeholder="ID Barang"></td>
										<td><input type="text" name="t[]" style="width:50px" id="t1" onkeyup="hitungT('1')"></td>
										<td><input type="text" name="l[]" style="width:50px" id="l1" onkeyup="hitungL('1')"></td>
										<td><input type="text" name="p[]" style="width:50px" id="p1" onkeyup="hitungP('1')"></td>
										<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs1" onkeyup="hitungPcs('1')"></td>
										<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m31" readonly></td>
										<td><input type="text" name="hargam3[]" style="width:100px" id="hargam31" onkeyup="hargaM3('1')"></td>
										<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal1" readonly></td>
										<td><input type="text" name="ket[]" style="width:100px" id="ket1"></td>
										<td><input type="text" name="harga[]" style="width:100px; background-color:#ccc" id="harga1" readonly></td>
									</tr>
									<tr>
										<td>2</td>
										<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang2" onkeyup="getIdBarang('2')" placeholder="ID Barang"></td>
										<td><input type="text" name="t[]" style="width:50px" id="t2" onkeyup="hitungT('2')"></td>
										<td><input type="text" name="l[]" style="width:50px" id="l2" onkeyup="hitungL('2')"></td>
										<td><input type="text" name="p[]" style="width:50px" id="p2" onkeyup="hitungP('2')"></td>
										<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs2" onkeyup="hitungPcs('2')"></td>
										<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m32" readonly></td>
										<td><input type="text" name="hargam3[]" style="width:100px" id="hargam32" onkeyup="hargaM3('2')"></td>
										<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal2" readonly></td>
										<td><input type="text" name="ket[]" style="width:100px" id="ket2"></td>
										<td><input type="text" name="harga[]" style="width:100px; background-color:#ccc" id="harga2" readonly></td>
									</tr>
									<tr>
										<td>3</td>
										<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang3" onkeyup="getIdBarang('3')" placeholder="ID Barang"></td>
										<td><input type="text" name="t[]" style="width:50px" id="t3" onkeyup="hitungT('3')"></td>
										<td><input type="text" name="l[]" style="width:50px" id="l3" onkeyup="hitungL('3')"></td>
										<td><input type="text" name="p[]" style="width:50px" id="p3" onkeyup="hitungP('3')"></td>
										<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs3" onkeyup="hitungPcs('3')"></td>
										<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m33" readonly></td>
										<td><input type="text" name="hargam3[]" style="width:100px" id="hargam33" onkeyup="hargaM3('3')"></td>
										<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal3" readonly></td>
										<td><input type="text" name="ket[]" style="width:100px" id="ket3"></td>
										<td><input type="text" name="harga[]" style="width:100px; background-color:#ccc" id="harga3" readonly></td>
									</tr>
									<tr>
										<td>4</td>
										<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang4" onkeyup="getIdBarang('4')" placeholder="ID Barang"></td>
										<td><input type="text" name="t[]" style="width:50px" id="t4" onkeyup="hitungT('4')"></td>
										<td><input type="text" name="l[]" style="width:50px" id="l4" onkeyup="hitungL('4')"></td>
										<td><input type="text" name="p[]" style="width:50px" id="p4" onkeyup="hitungP('4')"></td>
										<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs4" onkeyup="hitungPcs('4')"></td>
										<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m34" readonly></td>
										<td><input type="text" name="hargam3[]" style="width:100px" id="hargam34" onkeyup="hargaM3('4')"></td>
										<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal4" readonly></td>
										<td><input type="text" name="ket[]" style="width:100px" id="ket4"></td>
										<td><input type="text" name="harga[]" style="width:100px; background-color:#ccc" id="harga4" readonly></td>
									</tr>
									<tr>
										<td>5</td>
										<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang5" onkeyup="getIdBarang('5')" placeholder="ID Barang"></td>
										<td><input type="text" name="t[]" style="width:50px" id="t5" onkeyup="hitungT('5')"></td>
										<td><input type="text" name="l[]" style="width:50px" id="l5" onkeyup="hitungL('5')"></td>
										<td><input type="text" name="p[]" style="width:50px" id="p5" onkeyup="hitungP('5')"></td>
										<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs5" onkeyup="hitungPcs('5')"></td>
										<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m35" readonly></td>
										<td><input type="text" name="hargam3[]" style="width:100px" id="hargam35" onkeyup="hargaM3('5')"></td>
										<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal5" readonly></td>
										<td><input type="text" name="ket[]" style="width:100px" id="ket5"></td>
										<td><input type="text" name="harga[]" style="width:100px; background-color:#ccc" id="harga5" readonly></td>
									</tr>


								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" align="center"><b>Total</b></td>
										<td align="center"> <input type="text" name="totalpcs" style="width:50px;background-color:#ccc" id="totalpcs" readonly> </td>
										<td align="center"> <input type="text" name="totalm3" id="totalm3" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>
										<td align="center"> <input type="text" name="totalsubtotal" id="totalsubtotal" style="width:100px;background-color:#ccc" readonly> </td>
										<td></td>
										<td></td>

								</tfoot>
							</table>
						</div>


					</form>

				</div>
				<div class="col-md-12"  align="right">
						<button type="button" class="btn btn-warning" id="print1" disabled><i class="fa fa-print"> Print 1</i></button>
						<button type="button" class="btn btn-warning" id="print2" disabled><i class="fa fa-print"> Print 2</i></button>
						<!--<button type="button" class="btn btn-info" id="update" disabled><i class="fa fa-reset">Upadate</i></button>--->
						<button type="button" class="btn btn-success" id="simpan"><i class="fa fa-save">Simpan</i></button>
				</div>
			</div>
		</div>
	</div>
</div>







<script type="text/javascript">


	function getIdBarang(angka) {


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
		idbarang(t, l, p, angka)


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
		idbarang(t, l, p, angka)


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
		idbarang(t, l, p, angka)


	}

	function idbarang(t, l, p, angka) { //membuat idbarang
		var idbarang = t.toString() + l.toString() + p.toString();
		$("#idbarang" + angka).val(idbarang);
	}



	function hitungPcs(angka) {


		var t = $("#t" + angka).val();
		var l = $("#l" + angka).val();
		var p = $("#p" + angka).val();
		var pcs = $("#pcs" + angka).val();

		var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
		$("#m3" + angka).val(m3);



		if (event.keyCode === 13) {
			$("#hargam3" + angka).focus();

		}


		//menjumlahkan total
		jumlahBaris = document.getElementById('table').rows.length;
		jumlah = parseInt(jumlahBaris) - parseInt(2);

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
		jumlah = parseInt(jumlahBaris) - parseInt(2);

		var totalsubtotal = 0;
		for (i = 1; i <= jumlah; i++) {
			var totalsubtotal = totalsubtotal + parseInt($("#subtotal" + i).val());
		}
		$("#totalsubtotal").val(formatUang(totalsubtotal));


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
		jumlah = parseInt(jumlahBaris) - parseInt(2);

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



	}






	function tambahBaris() {

		var jumlahBaris = document.getElementById('table').rows.length;
		var no = parseInt(jumlahBaris) - parseInt(1);

		var tr = "<tr>";
		var tr = tr + "<td>" + no + "</td>";
		var tr = tr + "<td><input type=\"text\" name=\"idbarang[]\" style=\"width:80px\" id=\"idbarang" + no + "\" onkeyup=\"getIdBarang('" + no + "')\" placeholder=\"ID Barang\"></td>";
		var tr = tr + "<td><input type=\"text\" name=\"t[]\" style=\"width:50px\" id=\"t" + no + "\" onkeyup=\"hitungT('" + no + "')\"></td>";
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






	$('#simpan').click(function(e) {
		e.preventDefault();

		if (confirm('Apa Ingin Melakukan Stock Opname Barang?')) {

			if ($("#namaketerangan").val() == '') {
				alert('Harap Isi Keterangan');
				$("#namaketerangan").focus();
			} else {

				$.ajax({

					url: '<?php echo base_url('admin/Barang/simpanStockOpname'); ?>',
					type: "POST",
					data: $('#form').serialize(),
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
							$("#namaketerangan").attr('disabled', 'disabled');
						}
						if (data.status === false) {
							alert(data.ket);
						}

						$("#info").fadeIn('slow');
						$("#info").html("<div class='alert-success' align='center'> Berhasil Disimpan </div>")
						$("#info").fadeOut('slow');


						//$('#form')[0].reset();
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

		window.open("<?php echo base_url('admin/Barang/print1/'); ?>" + $("#po").val(), '_blank');

	})

	$('#print2').click(function(e) {
		e.preventDefault();

		window.open("<?php echo base_url('admin/Barang/print2/'); ?>" + $("#po").val(), '_blank');

	})
</script>