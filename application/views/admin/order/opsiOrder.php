<section class="content-header">
      <h1>
       Order
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("adminDigital/Order/addOrder");?>"></i>Add Order</a></li>
        <li><a href="<?php echo base_url("adminDigital/Order/viewOrder");?>"></i>View Order</a></li>
        <li class="active">Opsi Order</li>
      </ol>
</section>



<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
			
				<div class="box-body" style="height:250px">
							<div class="row">
								<?php echo $this->session->flashdata('info');?>
							</div>
							
							<div class="row">
								<div class="col-md-6" style="margin-top:8px">
										<div class="input-group">
										 <span class="input-group-addon" id="basic-addon1">No Invoice</span>
										 <input type="text" id="invoice" required class="form-control" placeholder="Input...">
										  <span class="input-group-btn">
											<button id="cari" class="btn btn-info"><i class="fa fa-search"></i></button>
										  </span>
										</div>
								</div> 
							
							</div>
					
					<div class="row" style="margin-top:10px;">
						<div class="col-md-12">	
									<div class="table-responsive">
										<table id="order" class="table">
											<thead>
											<tr>
												<th>No</th>
												<th>Invoice</th>
												<th>Tanggal Transaksi</th>
												<th>Total Transaksi</th>
												<th>Status</th>
												<th>Opsi</th>
												
												
											</tr>
											</thead>
											
											<tbody id="listOpsi">
											
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




<script type="text/javascript">


$("#cari").click(function(){
	
	var invoice=$('#invoice').val();
	
	if(invoice =='')
	{
		alert('No Invoice Tidak Boleh Kosong');
	}
	else
	{
		$.ajax({
					
					url		: "<?php echo base_url('adminDigital/Order/cariTransaksi');?>",
					type	:"post",
					data	:{data:invoice},
					dataType: "html",
					success	: function(data){
								
							$("#listOpsi").html(data);
								
								
							},
					error	: function(){
						
							},
					
				
				
				
			})
	}		
	
})



function formatUang(a)
{
	var angka = a;
	var reverse = angka.toString().split('').reverse().join(''),
	ribuan = reverse.match(/\d{1,3}/g);
	ribuan = ribuan.join(',').split('').reverse().join('');
	
	return ribuan;
}



</script>
