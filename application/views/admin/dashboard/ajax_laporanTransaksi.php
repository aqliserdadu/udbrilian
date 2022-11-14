<div class="col-md-8">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
								<table class="table table-striped table-borderd tableTransksi">
									<thead>
									<tr>
										<th>No</th>
										<th>Date</th>
										<th>Nama Pelanggan</th>
										<th>Jml Transaksi</th>
										<th>Total Transaksi</th>
										
									</tr>
									</thead>
									<tbody>
											<?php $no =1;?>
											<?php $jpelanggan =0;?>
											<?php $jtotal =0;?>
											<?php foreach($data as $t){;?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $t->tgltransaksi;?></td>
												<td><?php echo $t->namapelanggan;?></td>
												<td><?php echo $t->jpelanggan;?></td>
												<td><?php echo "Rp.".number_format($t->totaltransaksi);?></td>
												
												<?php $jpelanggan = $jpelanggan + $t->jpelanggan;?>
												<?php $jtotal = $jtotal + $t->totaltransaksi;?>
											</tr>
											<?php };?>
									</tbody>
									<tfoot>
												<tr>
													<td colspan="2"><b>Total</b></td>
													<td><b><?php echo $jpelanggan;?></b></td>
													<td><b><?php echo "Rp.".number_format($jtotal);?></b></td>
												</tr>
									</tfoot>
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	
		<div class="col-md-4">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table  class="table table-striped table-borderd tableTransksi">
								<thead>
								<tr>
									<th>No</th>
									<th>ID Barang</th>
									<th>Nama Barang</th>
									<th>Qty</th>
									
								</tr>
								</thead>
								<tbody>
										<?php 
										$no = 1;
										$jmTotal = 0;
										foreach($banyak as $p){;?>
										<?php $jmTotal = $jmTotal + $p->totalpcs;?>
										
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $p->idbarangpenjualan;?></td>
												<td><?php echo $p->namabarang;?></td>
												<td><?php echo $p->totalpcs." Pcs";?></td>
											</tr>
										<?php };?>
											</tbody>
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	

<script type="text/javascript">

$('.tableTransksi').DataTable({
"scrollY": "300px",
"searching" : false,
"info" : false,
"bPaginate": false,
});
</script>