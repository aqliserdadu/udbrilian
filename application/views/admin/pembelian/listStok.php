
	<section class="content-header">
      <h1>
      Stok Produk
        <small>Control panel</small>
      </h1>
       <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/showStok");?>"></i>Stok Produk</a></li>
        <li><a href="#"></i>List Stok</a></li>
      </ol>
    </section>


 <div class="content">
	
	<div class="row">
		
			<?php echo $this->session->flashdata('massage');?>
				
	</div>
	

	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
					<div class="table-responsive">
						<table id="list" class="table">
							<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>User</th>
								<th>Kode</th>
								<th>Kategori</th>
								<th>Nama</th>
								<th>Qty</th>
								<th>Satuan</th>
								<th>Action</th>
								
							</tr>
							</thead>
							
							<tbody>
							<?php $no =1 ;?>
							<?php foreach($data as $tp){;?>
							<tr>
								<td><?php echo $no++;?></td>
								<td><?php echo $tp->date;?></td>
								<td><?php echo $tp->username;?></td>
								<td><?php echo $tp->idproduk;?></td>
								<td><?php echo $tp->kategori;?></td>
								<td><?php echo $tp->namaproduk;?></td>
								<td><?php echo $tp->qty;?></td>
								<td><?php echo $tp->satuan;?></td>
								<td>
									<a href="<?php echo base_url('adminDigital/AdminDigital/hapusList/');?><?php echo $tp->idlist;?>" onclick="return confirm('Apakah anda yakin ingin menghapus ini?, Menghapus Dapat Mengurangi Jumalah Stok')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
								</td>
							</tr>
							<?php } ;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	
		
	

</div>


<script type="text/javascript">
$("#list").DataTable();

</script>