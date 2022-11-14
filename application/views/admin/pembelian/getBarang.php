<div class="table-responsive">
										<table id="produkS" class="table table-hover table-striped" style="cursor:pointer">
											<thead>
											<tr>
												<th>No</th>
												<th>Nama Produk</th>
												<th>Harga Beli</th>
												
												
											</tr>
											</thead>
											
											<tbody>
											<?php 
											$no = 1;
											foreach($data as $tp){;?>
												<tr onclick="pilih('<?php echo $tp->idbarang;?>','<?php echo $tp->namabarang;?>','<?php echo $tp->namasatuan;?>','<?php echo $tp->hargabelibarang;?>')">
													<td><?php echo $no++;?></td>
													<td><?php echo $tp->namabarang;?></td>
													<td><?php echo number_format($tp->hargabelibarang)."/".$tp->namasatuan;?></td>
												</tr>
											<?php };?>
											</tbody>
										</table>
									
</div>



<script type="text/javascript">

$("#produkS").DataTable();


function pilih(idProduk,namaProduk,satuan,hargabeli){
	
	$("#idbarang").val(idProduk);
	$("#namabarang").val(namaProduk);
	$("#satuan").val(satuan);
	$("#labelSatuan").html(satuan);
	$("#jumlah").val(1);
	$("#hargabeli").val(formatUang(hargabeli));
	$("#total").val(formatUang(hargabeli));
	$("#modal").modal('hide');
	
	
};


</script>