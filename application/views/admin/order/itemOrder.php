	<div class="table-responsive">
										<table id="list" class="table">
											<thead>
											<tr>
												<th>No</th>
												<th>Kode</th>
												<th>Nama Barang</th>
												<th>Harga</th>
												<th>Jml</th>
												<th>Total</th>
												
												
											</tr>
											</thead>
											
											<tbody>
											<?php $no =1 ;?>
											<?php $total =0 ;?>
											<?php $invoice ='';?>
											<?php foreach($data as $tp){;?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tp->idproduk;?></td>
												<td><?php echo $tp->namaproduk;?></td>
												<td><?php echo number_format($tp->harga);?></td>
												<td><?php echo $tp->jumlah." ".$tp->satuan;?></td>
												<td><?php echo number_format($tp->total);?></td>
											
												
												<?php $total = $total + $tp->total;?>
												<?php $invoice = $tp->idtransaksi;?>
												
											</tr>
											<?php  } ;?>
											<tr>
												<td colspan="4"></td>
												<td> <b>Total Harga</b></td>
												<td> <b><?php echo number_format($total);?></b></td>
												
											</tr>
											</tbody>
										</table>
									
										
								
								</div>