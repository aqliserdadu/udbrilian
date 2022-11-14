<div class="table-responsive">
							<table id="tablePenjualan" class="tableList table-striped" style="width:100%">
								<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>User</th>
									<th>Nota</th>
									<th>Nama Custamer</th>
									<th>Total Pembelian</th>
									<th>Metode Bayar</th>
									<th>Total Pembayaran</th>
									<th>Sisa Pembayaran</th>
									<th style="width:50px"></th>
									
								</tr>
								</thead>
								<tbody>
								<?php $no =1;?>
								<?php foreach($data as $tp){;?>
								
								<tr>
										<td><?php echo $no++;?></td>
										<td><?php echo $tp->date;?></td>
										<td><?php echo $tp->username;?></td>
										<td><?php echo $tp->idheader;?></td>
										<td><?php echo $tp->namapelanggan;?></td>
										<td><?php echo "Rp. ".number_format($tp->totalharga);?></td>
										<td><?php echo $tp->metodebayar;?></td>
										<td><?php echo "Rp. ".number_format($tp->bayar);?></td>
										<td><?php echo "Rp. ".number_format($tp->sisa);?></td>
										<td>
											<a href="#" class="btn btn-info btn-xs" onclick="detail('<?php echo $tp->idheader;?>')"><i class="fa fa-book"></i></a>
											<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php echo $tp->idheader;?>')"><i class="fa fa-trash-o"></i></a>
										
										</td>
									</tr>
								<?php };?>
								</tbody>
							</table>
						</div>

<script type="text/javascript">


$('.tableList').DataTable();
</script>
