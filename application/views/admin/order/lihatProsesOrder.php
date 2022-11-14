	<div class="table-responsive">
										<table id="list" class="table">
											<thead>
											<tr>
												<th>No</th>
												<th>Kode</th>
												<th>Tanggal</th>
												<th>User</th>
												<th>Status</th>
												<th>Note</th>
												
												
												
											</tr>
											</thead>
											
											<tbody>
											<?php $no =1 ;?>
											<?php $total =0 ;?>
											<?php $invoice ='';?>
											<?php foreach($data as $tp){;?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tp->idtransaksi;?></td>
												<td><?php echo $tp->tglproses;?></td>
												<td><?php echo $tp->username;?></td>
												<td><?php echo $tp->statusproses;?></td>
												<td><?php echo $tp->noteproses;?></td>
												
												
											</tr>
											<?php  } ;?>
											
											</tbody>
										</table>
									
										
								
								</div>