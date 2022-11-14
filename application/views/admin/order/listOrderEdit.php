<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">List Pesan</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
				<div class="box-body">
					<div class="col-md-12" id="listOrder">	
						
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
												<th>Opsi</th>
												
												
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
												<td>
													<a href="<?php echo base_url('adminDigital/Order/hapusListOrder/').$tp->idpenjualan;?>" onclick="return confirm('Apakah anda yakin ingin menghapus ini?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
												</td>
												
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
								
									<form action="<?php echo base_url('adminDigital/Order/updateOrder');?>" method="POST" id="saveOrder">
										
										<input type="hidden" name="invoice" value="<?php echo $invoice;?>"> <!--invoice -->
										<input type="hidden" name="total" value="<?php echo $total;?>">	<!--Total Transaksi -->
										<input type="hidden" name="user" value="<?php echo $this->session->userdata('iduser');?>">	<!--ID User -->
												
										<div class="modal-footer">
											<input type="submit" value="Simpan" name="simpan" class="btn btn-success text-right" onclick="return confirm('Apakah anda ingin menyimpan perubahan Pesanan?')">
										</div>
									</form>
						
								
					</div>
				</div>
			</div>
</div>
	
