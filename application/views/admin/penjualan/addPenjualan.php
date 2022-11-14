<section class="content-header" style="background-color:white; padding-bottom:6px">
	<h1>
		Transaksi
		<small>Control panel Add</small>
	</h1>
	<ol class="breadcrumb">
		<li><a href="<?php echo base_url("admin/Penjualan/index"); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Form Add</li>
	</ol>
</section>




<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box-body" style="background-color:white; border:1px solid #ccc">
				<div class="col-md-12">
					<form id="formPenjualan" action="#" method="POST">	
						<div style="padding:5px; text-align:center; background-color:#7FFFD4; color:black; border:1px solid #fff">
							<input type="text" name="so" id="so" value="<?php echo $so; ?>" readonly class="form-control" style="text-align:center">
						</div>

						
							<div class="col-md-4">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1" style="background-color:#7FFFD4; color:black;"><b>User :</b></span>
									<input type="text" name="user" value="<?php echo $user;?>" id="user" required class="form-control" placeholder="User" style="color:black;" readonly>
								</div> 
							</div>

							<div class="col-md-4"> 
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1" style="background-color:#7FFFD4; color:black;">Date :</span>
									<input type="text" name="date" id="date" required class="form-control" style="color:black;" value="<?php echo date('Y-m-d');?>" readonly>
								</div>
							</div>

							<div class="col-md-4">
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1" style="background-color:#7FFFD4; color:black;">Cusatamer :</span>
									<input type="text" name="namapelanggan" id="namapelanggan" class="form-control" style="color:black;" placeholder="Custamer"> 
									<input type="hidden" name="idpelanggan" id="idpelanggan" class="form-control" style="color:black;" > 
									
								</div>
							</div>

						<div class="row">
							<div class="col-md-10">
								
								<table id="table" class="table table-striped">
										<thead>
											<tr>
												<th>No</th>
												<th></th>
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
											<tr>
												<td>1</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang1" onkeyup="getIdBarang(1)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t1" onkeyup="hitungT('1')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l1" onkeyup="hitungL('1')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p1" onkeyup="hitungP('1')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs1" onkeyup="hitungPcs('1')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga1" onkeyup="harga('1')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal1" >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m31" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal1" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket1"></td>
											</tr>
											<tr>
												<td>2</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang2" onkeyup="getIdBarang(2)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t2" onkeyup="hitungT('2')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l2" onkeyup="hitungL('2')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p2" onkeyup="hitungP('2')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs2" onkeyup="hitungPcs('2')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga2"  onkeyup="harga('2')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal2" >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m32" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal2" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket2"></td>
											</tr>
											<tr>
												<td>3</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang3" onkeyup="getIdBarang(3)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t3" onkeyup="hitungT('3')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l3" onkeyup="hitungL('3')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p3" onkeyup="hitungP('3')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs3" onkeyup="hitungPcs('3')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga3"  onkeyup="harga('3')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal3" >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m33" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal3" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket3"></td>
											</tr>
											<tr>
												<td>4</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang4" onkeyup="getIdBarang(4)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t4" onkeyup="hitungT('4')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l4" onkeyup="hitungL('4')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p4" onkeyup="hitungP('4')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs4" onkeyup="hitungPcs('4')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga4"  onkeyup="harga('4')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal4" >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m34" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal4" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket4"></td>
											</tr>
											<tr>
												<td>5</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang5" onkeyup="getIdBarang(5)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t5" onkeyup="hitungT('5')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l5" onkeyup="hitungL('5')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p5" onkeyup="hitungP('5')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs5" onkeyup="hitungPcs('5')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga5"  onkeyup="harga('5')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal5"  >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m35" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal5" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket5"></td>
											</tr>
											<tr>
												<td>6</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang6" onkeyup="getIdBarang(6)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t6" onkeyup="hitungT('6')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l6" onkeyup="hitungL('6')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p6" onkeyup="hitungP('6')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs6" onkeyup="hitungPcs('6')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga6"  onkeyup="harga('6')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal6"  >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m36" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal6" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket6"></td>
											</tr>
											<tr>
												<td>7</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang7" onkeyup="getIdBarang(7)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t7" onkeyup="hitungT('7')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l7" onkeyup="hitungL('7')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p7" onkeyup="hitungP('7')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs7" onkeyup="hitungPcs('7')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga7"  onkeyup="harga('7')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal7"  >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m37" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal7" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket7"></td>
											</tr>
											<tr>
												<td>8</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang8" onkeyup="getIdBarang(8)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t8" onkeyup="hitungT('8')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l8" onkeyup="hitungL('8')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p8" onkeyup="hitungP('8')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs8" onkeyup="hitungPcs('8')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga8"  onkeyup="harga('8')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal8"  >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m38" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal8" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket8"></td>
											</tr>
											<tr>
												<td>9</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang9" onkeyup="getIdBarang(9)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t9" onkeyup="hitungT('9')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l9" onkeyup="hitungL('9')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p9" onkeyup="hitungP('9')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs9" onkeyup="hitungPcs('9')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga9"  onkeyup="harga('9')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal9"  >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m39" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal9" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket9"></td>
											</tr>
											<tr>
												<td>10</td>
												<td><input type="text" name="idbarang[]" style="width:80px" id="idbarang10" onkeyup="getIdBarang(10)" placeholder="ID Barang"></td>
												<td><input type="text" name="t[]" style="width:50px" id="t10" onkeyup="hitungT('10')"></td>
												<td><input type="text" name="l[]" style="width:50px" id="l10" onkeyup="hitungL('10')"></td>
												<td><input type="text" name="p[]" style="width:50px" id="p10" onkeyup="hitungP('10')"></td>
												<td><input type="text" name="pcs[]" value="0" style="width:50px" id="pcs10" onkeyup="hitungPcs('10')"></td>
												<td>
													<input type="text" name="harga[]" style="width:100px;" id="harga10"  onkeyup="harga('10')">
													<input type="hidden" name="hargamodal[]" style="width:100px;" id="hargamodal10"  >
												</td>
												<td><input type="text" name="m3[]" value="0" style="width:100px; background-color:#ccc" id="m310" readonly></td>
												<td><input type="text" name="subtotal[]" value="0" style="width:100px; background-color:#ccc" id="subtotal10" readonly ></td>
												<td><input type="text" name="ket[]" style="width:100px" id="ket10"></td>
											</tr>
											
											
										</tbody>
										<tfoot>
											<tr>
												<td colspan="5" align="center"><b>Jumlah</b></td>
												<td align="center"> <input type="text" name="totalpcs" style="width:50px;background-color:#ccc" id="totalpcs" readonly> </td>
												<td></td>
												<td align="center"> <input type="text" name="totalm3" id="totalm3" style="width:100px;background-color:#ccc" readonly> </td>
												<td align="center"> <input type="text" name="totalsubtotal" id="totalsubtotal" style="width:100px;background-color:#ccc" readonly> </td>
												<td></td>
												
											</tr>
											<tr style="background-color:#f0f0f0" id="tampilhutang">
												<td colspan="7" align="right">Hutang</td>
												<td align="center"> <input type="text" name="hutang" id="hutang" value="0" onkeyup="hutang()" style="width:100px;;background-color:#ccc" readonly> </td>
												<td align="center"><input type="text" name="totalsetelahhutang" id="totalsetelahhutang" style="width:100px;background-color:#ccc" readonly> </td>
												<td align="left"> 
													<select name="pilihhutang" id="pilihhutang">
														<option value="yes">Sertakan</option>
														<option value="no" selected>Tidak Sertakan</option>
													</select>
												</td>
											</tr>
											<tr style="background-color:#f0f0f0">
												<td colspan="7" align="right">Diskon</td>
												<td align="center"> <input type="text" name="diskon" id="diskon" class="angka" value="0" onkeyup="fsdiskon()" style="width:100px;"> </td>
												<td align="center"> <input type="text" name="totalsetelahdiskon" id="totalsetelahdiskon" style="width:100px;;background-color:#ccc"> </td>
												<td></td>
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
							</div>
							<div class="col-md-2" style="margin-left:-20px">
								<table id="table" class="table table-striped">
									<thead>
										<tr>
											<th>Date</th>
											<th>Harga</th>
											<th>Ket</th>
										</tr>
									</thead>
									<tbody id="showHarga">
										
									</tbody>
								</table>
							</div>
						</div>
					</form>
				</div>
				<div class="col-md-12">
					<div class="col-md-6" align="left">
						<button type="button" class="btn btn-danger" id="reset"><i class="fa fa-reset">Reset</i></button>						
					</div>
					<div class="col-md-6" align="right">
						<button type="button" class="btn btn-warning" id="print1" disabled><i class="fa fa-print"> Print 1</i></button>
						<button type="button" class="btn btn-warning" id="print2" disabled><i class="fa fa-print"> Print 2</i></button>
						<!--- <button type="button" class="btn btn-info" id="update" disabled><i class="fa fa-reset">Upadate</i></button>  -->
						<button type="button" class="btn btn-success" id="simpan"><i class="fa fa-save">Simpan</i></button>
					</div>
				</div>						
			</div>
		</div>
	</div>
</div>







<script type="text/javascript">
	
$("#date").datepicker({

	"dateFormat":"yy-mm-dd"

});


$('#namapelanggan').autocomplete({
                source: "<?php echo base_url('admin/Pelanggan/getPelangganAuto');?>",
				autoFocus:true,
				minLength:2,
                select: function (event, ui) {
					$(this).val(ui.item.label); 
						$('#idpelanggan').val(ui.item.idpelanggan);
						
						cekHutang(ui.item.idpelanggan) //cekhutang
					
					
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
				return $( "<li>" )
				.append( "<div>" + item.label + "<br>" + item.alamat+"</div>" )
				.appendTo( ul );
}

function getIdBarang(angka){
     
	cekPelanggan(angka);
	
	if(event.keyCode === 13){
			
			$.ajax({

								url: '<?php echo base_url('admin/Barang/getIdBarang'); ?>', 
								type: "GET",
								data: {term:$("#idbarang"+angka).val()},
								dataType: "JSON",
								success: function(data) {
									if(data[0].idbarang == ''){
										alert('Kode Barang Tidak Di kenal');
									}else{
										$("#t"+angka).val(data[0].t);
										$("#l"+angka).val(data[0].l);
										$("#p"+angka).val(data[0].p);
										$("#pcs"+angka).focus();
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




function cekHutang(idpelanggan){  //cek hutang
		


		if(idpelanggan != ''){
			$.ajax({

				url: '<?php echo base_url('admin/Penjualan/cekHutang'); ?>',
				type: "POST",
				data: {idcus: idpelanggan },
				dataType: "JSON",

				beforeSend: function() {
					$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
					$(".preloader").show();
				},

				success: function(data) {

					if(data.status === true && data.sisahutang != null){
						$("#hutang").val(formatUang(data.sisahutang));
					}
					else{
						$("#hutang").val(0);
					}
					if(data.status === false){
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
		}else{

			alert('Nama Custamer Tidak Terdaftar, Harap Periksa Kembali!');

		}
}



function hitungT(angka){

	var t = $("#t"+angka).val();
	var l = $("#l"+angka).val();
	var p = $("#p"+angka).val();
	var pcs = $("#pcs"+angka).val();

	var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
	$("#m3"+angka).val(m3);
	

	if(event.keyCode === 13){
		$("#l"+angka).focus();
		
	}
	idbarang(t,l,p,angka);

	
	
}

function hitungL(angka){

	var t = $("#t"+angka).val();
	var l = $("#l"+angka).val();
	var p = $("#p"+angka).val();
	var pcs = $("#pcs"+angka).val();

	var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
	$("#m3"+angka).val(m3);
	
		if(event.keyCode === 13){
			$("#p"+angka).focus();
			
		}
	idbarang(t,l,p,angka);

}

function hitungP(angka){

	var t = $("#t"+angka).val();
	var l = $("#l"+angka).val();
	var p = $("#p"+angka).val();
	var pcs = $("#pcs"+angka).val();

	var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
	$("#m3"+angka).val(m3);
	
	if(event.keyCode === 13){
		$("#pcs"+angka).focus();
		$("#pcs"+angka).val('');
		
	}
	idbarang(t,l,p,angka);
	


}

function idbarang(t,l,p,angka){  //membuat idbarang
	var idbarang = t.toString() + l.toString() + p.toString();
	$("#idbarang"+angka).val(idbarang);
}


function hitungPcs(angka){

	
	var t = $("#t"+angka).val();
	var l = $("#l"+angka).val();
	var p = $("#p"+angka).val();
	var pcs = $("#pcs"+angka).val();
	var idpelanggan = $("#idpelanggan").val();

	var m3 = (parseInt(t) * parseInt(l) * parseInt(p) * parseInt(pcs)) / 1000000;
	$("#m3"+angka).val(m3);
	
	
	var harga = menghilangkanKoma($("#harga"+angka).val());
	var subtotal = parseInt(pcs) * parseInt(harga);
	$("#subtotal"+angka).val(subtotal);

		
	
	cekStok(t,l,p,pcs,angka); //cek stok barang
	
	
	if(idpelanggan == ""){
			alert('Harap Pilih Custamer Untuk Mngetahui Pembelian Terakhir');
			$("#namapelanggan").focus();
	}else{
			showHarga(t,l,p,pcs,idpelanggan); //cek harga pembelian sebelumnya
	}
		
	if(event.keyCode === 13){
		$("#harga"+angka).focus();
	}
	
	
	


	//menjumlahkan total
	jumlahBaris = document.getElementById('table').rows.length;
	jumlah = parseInt(jumlahBaris) - parseInt(8);

	var totalpcs = 0;
	var totalm3 = 0;
	var totalsubtotal =0;
	for(i=1; i <= jumlah; i++)
	{
		
		var totalpcs = parseInt(totalpcs) + parseInt($("#pcs"+i).val());
		var totalm3 = parseFloat(totalm3) + parseFloat($("#m3"+i).val());
		var totalsubtotal = totalsubtotal + parseInt($("#subtotal"+i).val());

	}
	$("#totalpcs").val(totalpcs);
	$("#totalm3").val(totalm3);
	$("#totalsubtotal").val(totalsubtotal);

	hargaP(angka);
	
	



}

function hargaP(angka){ //menjumlahkan apabila ada perubhan pcs

	var pcs = $("#pcs"+angka).val();
	var harga = menghilangkanKoma($("#harga"+angka).val());
	var subtotal = Math.round(parseInt(pcs) * parseInt(harga));
	$("#subtotal"+angka).val(subtotal);


	if(harga == 0 | harga == ''){
		$("#harga"+angka).val('');
	}else{
		$("#harga"+angka).val(formatUang(harga));
	}
	

	//menjumlahkan subtotal
	jumlahBaris = document.getElementById('table').rows.length;
	jumlah = parseInt(jumlahBaris) - parseInt(8);
	
	
	
	var totalsubtotal= 0;
	for(i=1; i<=jumlah; i++)
	{

		var totalsubtotal = totalsubtotal + parseInt($("#subtotal"+i).val()); 
	}
	$("#totalsubtotal").val(formatUang(totalsubtotal));

	

	hutang();
	fsdiskon();
	fsBayar();

}


function harga(angka){

	var pcs = $("#pcs"+angka).val();
	var harga = menghilangkanKoma($("#harga"+angka).val());
	var subtotal = Math.round(parseInt(pcs) * parseInt(harga));
	$("#subtotal"+angka).val(subtotal);


	if(harga == 0 | harga == ''){
		$("#harga"+angka).val('');
	}else{
		$("#harga"+angka).val(formatUang(harga));
	}
	

	//menjumlahkan subtotal
	jumlahBaris = document.getElementById('table').rows.length;
	jumlah = parseInt(jumlahBaris) - parseInt(8);
	
	
	
	var totalsubtotal= 0;
	for(i=1; i<=jumlah; i++)
	{

		var totalsubtotal = totalsubtotal + parseInt($("#subtotal"+i).val()); 
	}
	$("#totalsubtotal").val(formatUang(totalsubtotal));

	//even baris kebawah ketika enter
	loncat = parseInt(angka) + parseInt(1);
	if(event.keyCode === 13){
		
		$("#idbarang"+loncat).focus();

		if(angka == jumlah){  // jika baris terakhir akan menambah baris baru

			tambahBaris();

		}



	}

	

	hutang();
	fsdiskon();
	fsBayar();

}


function hutang()
{

	var cek = $("#pilihhutang").val();

	if(cek == 'yes'){
		var hutang = menghilangkanKoma($("#hutang").val());
	}

	if(cek == 'no'){
		var hutang = 0;
	}

	var totalsetelahhutang = menghilangkanKoma($("#totalsubtotal").val());
	var hitung = parseInt(hutang) + parseInt(totalsetelahhutang);
	$("#totalsetelahhutang").val(formatUang(hitung));


}

$("#pilihhutang").change(function(){

	var cek = $(this).val();

	if(cek == 'yes'){
		var hutang = menghilangkanKoma($("#hutang").val());
	}

	if(cek == 'no'){
		var hutang = 0;
	}

	var totalsetelahhutang = menghilangkanKoma($("#totalsubtotal").val());
	var hitung = parseInt(hutang) + parseInt(totalsetelahhutang);
	$("#totalsetelahhutang").val(formatUang(hitung));

	fsdiskon();
	fsBayar();

})

function fsdiskon()
{

	var diskon = $("#diskon").val();
	var totalsetelahhutang = menghilangkanKoma($("#totalsetelahhutang").val());
	var hitung = parseInt(totalsetelahhutang) - parseInt(menghilangkanKoma(diskon));
	$("#totalsetelahdiskon").val(formatUang(hitung));
	$("#totalpembayaran").val(formatUang(hitung));

	fsBayar();


}


function fsBayar()
{
	
	var bayar = menghilangkanKoma($("#totalbayar").val());
	var totalpembayaran = menghilangkanKoma($("#totalpembayaran").val());
	var hitung = parseInt(totalpembayaran) - parseInt(bayar);

	var angka = hitung.toString().replace('-','');
	if(parseInt(bayar) > parseInt(totalpembayaran))
	{
		$("#ket").html('Kembali')
		alert('Masukan Nilai Sejumlah yang dibayarkan, Tidak boleh melebihi nilai pembayaran!');
		$('#simpan').attr('disabled','disabled');
		$('#update').attr('disabled','disabled');
		
	}else{

		$("#ket").html('Sisa')
		$('#simpan').removeAttr('disabled','disabled');
		$('#update').removeAttr('disabled','disabled');
		
	}

	$("#sisa").val(formatUang(angka));

}

function showHarga(tinggi,lebar,panjang,pcsj,idpelanggan){
	
	
	$.ajax({

					url: '<?php echo base_url('admin/Penjualan/showHarga'); ?>', //show penjualan terakhir;
 					type: "POST",
					data: {t:tinggi,l:lebar,p:panjang,pcs:pcsj,idcust:idpelanggan},
					dataType: "JSON",

					beforeSend: function() {
						$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						$(".preloader").show();
					},

					success: function(data) {
						var tbody = "";
						if(data.status === true){
							
							for(i=0; i < data.data.length; i++)
							{
								if(data.data[i].ket == ''){
									var ket = "Bagus"
								}
								else
								{
									var ket = data.data[i].ket;
								}
								var tbody = tbody + "<tr>";
								var tbody = tbody + "<td>" + data.data[i].date + "</td><td>" + formatUang(data.data[i].hargasatuan) + "</td><td>" + ket + "</td>"; 
								var tbody = tbody + "</tr>";
							}
							
							
							$("#showHarga").html(tbody);
							
						}
						if(data.status === false){
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


function tambahBaris(){

	var jumlahBaris = document.getElementById('table').rows.length;
	var no = parseInt(jumlahBaris) - parseInt(7);

	var tr = "<tr>";
	var tr = tr + "<td>"+ no +"</td>";
	var tr = tr + "<td><input type=\"text\" name=\"idbarang[]\" style=\"width:80px\" id=\"idbarang"+no+"\" onkeyup=\"getIdBarang('"+no+"')\" placeholder=\"ID Barang\"></td>";
	var tr = tr + "<td><input type=\"text\" name=\"t[]\" style=\"width:50px\" id=\"t"+no+"\" onkeyup=\"hitungT('"+no+"')\"></td>";
	var tr = tr + "<td><input type=\"text\" name=\"l[]\" style=\"width:50px\" id=\"l"+no+"\" onkeyup=\"hitungL('"+no+"')\"></td>";
	var tr = tr + "<td><input type=\"text\" name=\"p[]\" style=\"width:50px\" id=\"p"+no+"\" onkeyup=\"hitungP('"+no+"')\"></td>";
	var tr = tr + "<td><input type=\"text\" name=\"pcs[]\" value=\"0\" style=\"width:50px\" id=\"pcs"+no+"\" onkeyup=\"hitungPcs('"+no+"')\"></td>";
	var tr = tr + "<td><input type=\"text\" name=\"harga[]\" style=\"width:100px;\" id=\"harga"+no+"\" onkeyup=\"harga('"+no+"')\" ><input type=\"hidden\" name=\"hargamodal[]\" style=\"width:100px;\" id=\"hargamodal"+no+"\"></td>";
	var tr = tr + "<td><input type=\"text\" name=\"m3[]\" value=\"0\" style=\"width:100px; background-color:#ccc\" id=\"m3"+no+"\" readonly></td>";
	var tr = tr + "<td><input type=\"text\" name=\"subtotal[]\" value=\"0\" style=\"width:100px; background-color:#ccc\" id=\"subtotal"+no+"\" readonly ></td>";
	var tr = tr + "<td><input type=\"text\" name=\"ket[]\" style=\"width:100px\" id=\"ket"+no+"\"></td>";
	var tr = tr + "</tr>";

	$("#tambahbaris").append(tr);

};

function cekStok(tinggi,lebar,panjang,pcsj,no){
	 
	 var idbarang = tinggi.toString() + lebar.toString() + panjang.toString();
	 var pcs = pcsj;
	//menjumlahkan subtotal
	jumlahBaris = document.getElementById('table').rows.length;
	jumlah = parseInt(jumlahBaris) - parseInt(8);
	for(i=1; i<=jumlah; i++)
	{
		if(idbarang == $("#idbarang"+i).val()){
			
			if(no != i){
				pcs = parseInt(pcs) + parseInt($("#pcs"+i).val());
			}
		}
	}
	
	
	
	
	
	$.ajax({

					url: '<?php echo base_url('admin/Penjualan/cekStok'); ?>'+'/'+tinggi+'/'+lebar+'/'+panjang+'/'+pcs,
					type: "POST",
					dataType: "JSON",

					beforeSend: function() {
						$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						//$(".preloader").show();
					},

					success: function(data) {

						$("#hargamodal"+no).val(data.hargamodal);
						if(data.status === false){
							alert(data.ket);
							$("#pcs"+no).val(0);
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


	$('#simpan').click(function(e) {
		e.preventDefault();

		if (confirm('Apa Ingin Melakukan Transaksi?')) {

			if ($("#namapelanggan").val() == "" | $("#idpelanggan").val() == "" ) {
				alert('Harap Pilih Custamer');
				$("#namapelanggan").focus();
			} else if ($("#date").val() == '') {
				alert('Date Tidak Boleh Kosong');
				$("#date").focus();
			} else if ($("#totalbayar").val() == '') {
				alert('Harap lakukan pembayaran!');
				$("#totalbayar").focus();
			}	
			else {

				$.ajax({

					url: '<?php echo base_url('admin/Penjualan/simpanPenjualan'); ?>',
					type: "POST",
					data: $('#formPenjualan').serialize(),
					dataType: "JSON",

					beforeSend: function() {
						$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						$(".preloader").show();
					},

					success: function(data) {

						if(data.status === true){
							alert(data.ket);
							
							$("#print1").removeAttr('disabled','disabled');
							$("#print2").removeAttr('disabled','disabled');
							$("#update").removeAttr('disabled','disabled');
							//$("#simpan").attr('disabled','disabled');
							$("#namapelanggan").attr('readonly','readonly');
							
							
						}
						if(data.status === false){
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

	$("#reset").click(function(e){
		
		e.preventDefault();
		if (confirm('Lakukan Reset Transaksi')) {

			$.ajax({
				url: '<?php echo base_url('admin/Penjualan/getNotaPenjualan'); ?>',
				type: "GET",
				data :{iduser:$('#user').val()},
				dataType: "JSON",
				beforeSend: function() {
						$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif'); ?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
						$(".preloader").show();
					},

				success: function(data) {

						if(data.status === true){
							$('#formPenjualan')[0].reset();
							$("#so").val(data.notaPenjualan)
							$("#showHarga").html('');
						}
						
						$("#print1").attr('disabled','disabled');
						$("#print2").attr('disabled','disabled');
						$("#update").attr('disabled','disabled');
						//$("#simpan").removeAttr('disabled','disabled');
						$("#namapelanggan").removeAttr('readonly','readonly');

						
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
			}
			else {

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

						if(data.status === true){
							alert(data.ket);
						}
						if(data.status === false){
							alert(data.ket);
						}

						$("#info").fadeIn('slow');
						$("#info").html("<div class='alert-success' align='center'> Berhasil Disimpan </div>")
						$("#info").fadeOut('slow');
					//	$("#simpan").attr('disabled','disabled');
						
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

function cekPelanggan(angka){
	
	if($("#namapelanggan").val() == '' | $("#idpelanggan") == ''){
		
		alert('Harap Custamer Di isi!');
		$("#namapelanggan").focus();
		$("#idbarang"+angka).val('');
	}
	
	
}



$('#print1').click(function(e) {
	e.preventDefault();
	
	window.open("<?php echo base_url('admin/Penjualan/printPenjualan1/');?>"+$("#so").val(),'_blank');
				
})

$('#print2').click(function(e) {
	e.preventDefault();
	
	window.open("<?php echo base_url('admin/Penjualan/printPenjualan2/');?>"+$("#so").val(),'_blank');
				
})





</script>