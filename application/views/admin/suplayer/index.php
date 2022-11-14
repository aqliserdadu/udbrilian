
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Opsi 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Suplayer</li>
      </ol>
    </section>


 <div class="content">
	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
					<div style="margin-bottom:10px">
						<button class="btn btn-success" id="tambahS"><i class="fa fa-plus"> Suplayer</i></button>
					</div>
					
					<div class="table-responsive" id="listSuplayer">
						
						<table id="tablest" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Whatsapp</th>
								<th>Status</th>
								<th>Opsi</th>
								
							</tr>
							</thead>
							
							<tbody>
							<?php $n = 1;?>
							<?php foreach($sup as $s){;?>
							<tr>
								<td><?php echo $n++;?></td>
								<td><?php echo $s->idsuplayer;?></td>
								<td><?php echo $s->namasuplayer;?></td>
								<td><?php echo $s->alamatsuplayer;?></td>
								<td><?php echo $s->wasuplayer;?></td>
								<td><?php echo $s->statussuplayer;?></td>
								<td><a href="#" class="btn btn-info btn-xs" onclick="editSup('<?php echo $s->idsuplayer;?>','<?php echo $s->namasuplayer;?>','<?php echo $s->wasuplayer;?>','<?php echo $s->statussuplayer;?>')"><i class="fa fa-pencil"></i></a></td>
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




<div class="modal fade" id="modals" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<span class="input-group-addon" id="basic-addon1">Nama</span>
						<input type="hidden" name="idst" id="idst" required class="form-control" placeholder="">
						<input type="text" name="namast" id="namast" required class="form-control" placeholder="Nama Suplayer">
					</div>
						
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Alamat</span>
						<input type="text" name="alamat" id="alamat" required class="form-control" placeholder="Alamat">
					</div>	
						
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">whatsapp</span>
						<input type="text" name="wa" id="wa" required class="form-control" placeholder="whatsapp">
					</div>
					
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Status</span>
						<select name="status" id="status" class="form-control">
						
						</select>
					</div>
					
				</form>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="simpans" style="display:none">Simpan</button>
			<button type="button" class="btn btn-info" id="updatest" style="display:none">Update</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	






<script type="text/javascript">


$('#tablest').DataTable({

});


$('#tambahS').click(function(e){
	
	e.preventDefault();
	$('#simpans').show();
	$('#updatest').hide();
	$('#modals').modal('show');
	$('#labelst').html('Tambah Suplayer');
	$('#formst')[0].reset();
	$("#status").html("<option disabled selected>---Pilih---</option><option value='On'>On</option><option value='Off'>Off</option>");
			
	
})



$('#simpans').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menambahkan Suplayer?'))
	{
		
		if($("#namast").val() == '')
		{
			alert("Nama Suplayer Tidak Boleh Kosong");
		}
		else if($("#status").val() == null)
		{
			alert("Harap Pilih Status");
		}
		else
		{
		
		$.ajax({
				
				url		: "<?php echo base_url('admin/Suplayer/tambahSuplayer');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formst').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
								$("#infost").fadeOut('slow');
								$('#listSuplayer').load("<?php echo base_url('admin/Suplayer/ajax_listSuplayer');?>");
								
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
	
		
		
	}
			
	
})


function editSup(idsuplayer,namasuplayer,wasuplayer,status){
			
			
			if(status == 'On')
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On' selected>On</option><option value='Off'>Off</option>"; 
			}
			else if(status == 'Off')
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On'>On</option><option value='Off' selected>Off</option>"; 
			}
			else
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On'>On</option><option value='Off'>Off</option>"
			}
			
			
			$('#simpans').hide();
			$('#updatest').show();
			$('#labelst').html('Update Suplayer');
			$('#idst').val(idsuplayer);
			$('#namast').val(namasuplayer);
			$('#wa').val(wasuplayer);
			$('#status').html(op);
			$('#modals').modal('show');
			
}



$('#updatest').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menyimpan Perubahan?'))
	{
		if($("#namast").val() == '')
		{
			alert("Nama Suplayer Tidak Boleh Kosong");
		}
		else if($("#status").val() == null)
		{
			alert("Harap Pilih Status");
		}
		else
		{
		
		$.ajax({
				
				url		: "<?php echo base_url('admin/Suplayer/updateSuplayer');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formst').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-success' align='center'> Perubahan Berhasil Disimpan </div></div>")
								$("#infost").fadeOut('slow');
								$('#listSuplayer').load("<?php echo base_url('admin/Suplayer/ajax_listSuplayer');?>");
								
												
							}
					
							
						},
				error	: function(data){
							
							$("#infost").fadeIn('slow');
							$("#infost").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Data Sudah Tersedia </div></div>")
							$("#infost").fadeOut('slow');
						
						},
				
			
			
			
		})
		
		}
	
	
		
		
	}
			
	
})






</script>