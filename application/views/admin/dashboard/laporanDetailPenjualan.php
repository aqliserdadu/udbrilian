

<div class="col-md-12">



							<table id="table" class="table table-striped">
										<thead>
											<tr>
												<th>No</th>
												<th>T</th>
												<th>L</th>
												<th>P</th>
												<th>Qty</th>
												<th>Volume M3</th>
												<th>Modal</th>
												<th>Jual</th>
												<th>Total</th>
												<th>Keterangan</th>
												<th>Laba</th>
					
											</tr>
										</thead>
										<tbody>
										<?php 
										$no = 1;
										$totalpcs =0;
										$totalm3 =0;
										$totalharga =0;
										foreach($data as $tp){;?>
											<tr>
												<?php $totalpcs = $totalpcs + $tp->qty;?>
												<?php $totalm3 = $totalm3 + $tp->m3;?>
												<?php $totalharga = $totalharga + $tp->totalharga;?>
												<td><?php echo $no++ ;?></td>
												<td><?php echo $tp->t;?></td>
												<td><?php echo $tp->l;?></td>
												<td><?php echo $tp->p;?></td>
												<td><?php echo $tp->qty;?></td>
												<td><?php echo $tp->m3;?></td>
												<td><?php echo number_format($tp->hargamodal);?></td>
												<td><?php echo number_format($tp->hargasatuan);?></td>
												<td style="text-align:left"><?php echo number_format($tp->totalharga);?></td>
												<td><?php echo $tp->ket;?></td>
												<td><?php echo number_format(($tp->hargasatuan - $tp->hargamodal) * $tp->qty);?></td>
											
											
											</tr>
										<?php } ;?>					
								</tbody>
								<tfoot>
											<tr>
												<td colspan="4" align="center"><b>Jumlah</b></td>
												<td align="center"> <?php echo $totalpcs;?> </td>
												<td align="center"> <?php echo $totalm3;?> </td>
												<td></td>
												<td></td>
												<td align="left"> <?php echo number_format($totalharga);?> </td>
												<td></td>
												<td></td>
												
											</tr>
											
											<tr style="background-color:#f0f0f0">
												<td colspan="8" align="right">Diskon :</td>
												<td align="left"><?php echo number_format($row->diskon);?></td>
												<td align="left"> </td>
												<td align="left"> </td>
										
											</tr>
											<tr style="background-color:#f0f0f0">
												<td colspan="8" align="right">Total Pembayaran :</td>
												<td align="left"><?php echo number_format($row->totalharga);?></td>
												<td align="left"> </td>
												<td align="left"> </td>
										
											</tr>
											<tr style="background-color:#f0f0f0">
												<td colspan="8" align="right">Bayar :</td>
												<td align="left"><?php echo number_format($row->bayar);?></td>
												<td align="left"> </td>
												<td align="left"> </td>
										
											</tr>
											<tr style="background-color:#f0f0f0">
												<td colspan="8" align="right">
													<?php if($row->metodebayar == 'Dp'){ echo "Sisa :";}else{ echo "Kembali :";};?></td>
												</td>
												<td align="left"><?php echo number_format(str_replace('-','',($row->totalharga - $row->bayar)));?></td>
												<td align="left"> </td>
												<td align="left"> </td>
										
											</tr>
										</tfoot>
							</table>

</div>

<div class="col-md-12" align="right">
						<button type="button" class="btn btn-danger" id="kembali" onclick="kembali()"><i>kembali</i></button>
						<button type="button" class="btn btn-warning" id="print" onclick="print1('<?php echo $row->idheader;?>')"><i class="fa fa-print"> Print 1</i></button>
						<button type="button" class="btn btn-warning" id="print" onclick="print2('<?php echo $row->idheader;?>')"><i class="fa fa-print"> Print 2</i></button>
</div>




<script>

function kembali(){
	
	var tglP = $("#tglP").val();
	var tglK = $("#tglK").val();
	var idpelanggan = $("#idpelanggan").val();
	
	if(tglP == '')
	{
		alert('Tanggal From Tidak Boleh Kosong');
	}
	else if(tglK == '')
	{
		alert('Tanggal To Tidak Boleh Kosong');
	}
	else if(tglP > tglK)
	{
		alert('Tanggal TO lebih besar dari Form');
	}
	else if(idpelanggan == null)
	{
		alert('Harap Pilih Custamer');
	}
	else
	{
				$.ajax({
					
						url		: '<?php echo base_url('admin/Dashboard/ajax_laporanPenjualan');?>',
						type	: "POST",
						data 	: $("#formCari").serialize(),
						dataType: "html",
						
						beforeSend: function()
								{
									$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
									$(".preloader").show();
								},
						
						success	: function(data){	
									
									$("#listPenjualan").html(data);
									
								},
						complete: function(data){
								$(".preloader").hide();
								
								},		
						error	: function(xhr, textStatus){
						
							var msg ='';
								
									if(xhr.status === 0){
											msg = 'Tidak ada jaringan, Periksa koneksi jaringan';
										}
								else if(xhr.status == 404){
											msg = ' Halaman web tidak ditemukan [404]';
										}
								else if(xhr.status == 505){
											msg = ' Internal Server Error [505]';
										}
								else if(text.status === 'timeout'){
											msg = 'Time Out Error, Ulangi Kembali';
										}
									else{
											msg = ' Uncaughr Error.\n' + xhr.responseText;
										}
								alert(msg);
							
							},

					
				
				
				
					})
	
			
		
	}
											

}


function print1(idheader){
	window.open("<?php echo base_url('admin/Penjualan/printPenjualan1/');?>"+idheader,'_blank');
				
}

function print2(idheader){
	
	window.open("<?php echo base_url('admin/Penjualan/printPenjualan2/');?>"+idheader,'_blank');
				


}

</script>