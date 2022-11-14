
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Opsi Barang
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Opsi Barang</li>
      </ol>
    </section>


 <div class="content">
	

	

	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
					<div style="margin-bottom:10px">
						<button class="btn btn-success" id="tambahSt"><i class="fa fa-plus"> Satuan</i></button>
					</div>
					
					<div class="table-responsive" id="listSatuan">
						
						<table id="tablest" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Nama Satuan</th>
								<th>QPsc</th>
								<th>MQPsc</th>
								<th>Action</th>
								
							</tr>
							</thead>
							
							<tbody>
							<?php $n = 1;?>
							<?php foreach($satuan as $st){;?>
							<tr>
								<td><?php echo $n++;?></td>
								<td><?php echo $st->namasatuan;?></td>
								<td><?php echo $st->qsatuan;?></td>
								<td><?php echo $st->minqpcs;?></td>
								<td><a href="#" class="btn btn-info btn-xs" onclick="editSatuan('<?php echo $st->idsatuan;?>','<?php echo $st->namasatuan;?>','<?php echo $st->qsatuan;?>','<?php echo $st->minqpcs;?>')"><i class="fa fa-pencil"></i></a></td>
							</tr>
							<?php }?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	
	

</div>




<div class="modal fade" id="modalst" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		 <h4 id="labelst"></h4>
      </div>
			<div class="modal-body" style="background-color:#B0E0E6" id="bodyModal">
				<div id="infost" style="margin:10px">
				</div>
			
				<form action="" id="formst" method="POST">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Nama Satuan</span>
						<input type="hidden" name="idst" id="idst" required class="form-control" placeholder="Nama Satuan">
						<input type="text" name="namast" id="namast" required class="form-control" placeholder="Nama Satuan">
					</div>
						
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Qsatuan</span>
						<input type="number" name="qsatuan" id="qsatuan" required class="form-control" placeholder="Jumlah Pcs">
					</div>
					
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">MQPsc</span>
						<input type="number" name="mqpcs" id="mqpcs" required class="form-control" placeholder="Jumlah Minimal Stok">
					</div>
					
				</form>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="simpanst" style="display:none">Simpan</button>
			<button type="button" class="btn btn-info" id="updatest" style="display:none">Update</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	






<script type="text/javascript">


$('#tablest').DataTable({

});


$('#tambahSt').click(function(e){
	
	e.preventDefault();
	$('#simpanst').show();
	$('#updatest').hide();
	$('#modalst').modal('show');
	$('#labelst').html('Tambah Satuan');
	$('#formst')[0].reset();
			
	
})



$('#simpanst').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menambahkan Satuan?'))
	{
		
		$.ajax({
				
				url		: "<?php echo base_url('admin/Barang/tambahSatuan');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formst').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
								$("#infost").fadeOut('slow');
								$('#listSatuan').load("<?php echo base_url('admin/Barang/ajax_listsatuan');?>");
								
								$('#formst')[0].reset();
							
							
												
							}
					
							
						},
				error	: function(data){
							
							$("#infost").fadeIn('slow');
							$("#infost").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Data Sudah Tersedia </div></div>")
							$("#infost").fadeOut('slow');
						
						},
				
			
			
			
		})
	
	
	
		
		
	}
			
	
})


function editSatuan(idsatuan,namasatuan,qsatuan,mqpcs){
			
			$('#simpanst').hide();
			$('#updatest').show();
			$('#labelst').html('Update Kategori');
			$('#idst').val(idsatuan);
			$('#namast').val(namasatuan);
			$('#qsatuan').val(qsatuan);
			$('#mqpcs').val(mqpcs);
			$('#modalst').modal('show');
			
}



$('#updatest').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menyimpan Perubahan?'))
	{
		
		$.ajax({
				
				url		: "<?php echo base_url('admin/Barang/updateSatuan');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formst').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-success' align='center'> Perubahan Berhasil Disimpan </div></div>")
								$("#infost").fadeOut('slow');
								$('#listSatuan').load("<?php echo base_url('admin/Barang/ajax_listsatuan');?>");
								
												
							}
					
							
						},
				error	: function(data){
							
							$("#infost").fadeIn('slow');
							$("#infost").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Data Sudah Tersedia </div></div>")
							$("#infost").fadeOut('slow');
						
						},
				
			
			
			
		})
	
	
	
		
		
	}
			
	
})






</script>