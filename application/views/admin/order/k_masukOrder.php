<section class="content-header">
      <h1>
      Kelola Pesanan
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Masuk</li>
      </ol>
</section>


<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Daftar Pesanan</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
				<div class="box-body">
					<div class="row">
						<?php echo $this->session->flashdata('info');?>
					</div>
					
					<div class="row" style="margin-top:3px">
						<div class="col-md-12">
							<div class="table-responsive">
											<table id="order" class="table">
												<thead>
												<tr>
													<th>No</th>
													<th>Invoice</th>
													<th>Member</th>
													<th>Tanggal Transaksi</th>
													<th>Total Transaksi</th>
													<th>Status</th>
													<th>Opsi</th>
													
													
												</tr>
												</thead>
												
												<tbody>
												<?php
												$no = 1;
												foreach($data as $tp){;?>
												
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $tp->idtransaksi;?></td>
													<td><?php echo $tp->username;?></td>
													<td><?php echo $tp->tgltransaksi;?></td>
													<td><?php echo "Rp. ".number_format($tp->totaltransaksi);?></td>
													<td><?php echo $tp->status;?></td>
													<td><a href="<?php echo base_url('adminDigital/Order/k_terimaOrder/').$tp->idtransaksi;?>" id="terima" class="btn btn-info btn-xs" onclick="return confirm('Apa ingin menerima pesanan?')">Terima</a></td>
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
	
	</div>
</div>





<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body" style="background-color:#B0E0E6" id="bodyModal">
			<div id="item">				
					
				
			</div>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	






<script type="text/javascript">
// Setup datatables


$("#order").DataTable({
	
});

</script>
