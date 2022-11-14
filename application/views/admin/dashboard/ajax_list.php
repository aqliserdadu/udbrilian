<div class="table-responsive">
											<table id="tunai" class="table table-hover table-striped table-bordered" style="overflow:scroll; height:150px">
											<thead>
											<tr>
												<th>No</th>
												<th>Invoice</th>
												<th>Tanggal</th>
												<th>Pelanggan</th>
												<th>Total</th>
											</tr>
											</thead>
											
											<tbody>
											<?php 
											$no = 1;
											foreach($data as $tp){;?>
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $tp->idtransaksi;?></td>
													<td><?php echo $tp->tgltransaksi;?></td>
													<td><?php echo $tp->namapelanggan;?></td>
													<td><?php echo "Rp.".number_format($tp->totaltransaksi);?></td>
												</tr>
											<?php };?>
											</tbody>
										</table>
									
</div>
