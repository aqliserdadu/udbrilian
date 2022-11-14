<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Akun
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Akun</li>
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
								<div style="margin-bottom:10px">
									<button class="btn btn-success" id="tambahS"><i class="fa fa-plus"> Akun</i></button>
								</div>
								
											<div class="table-responsive" id="list">	
												<table class="table table-striped" id="akun">
													<thead>
													<tr>
														<th> No </th>
														<th> Username</th>
														<th> Gender</th>
														<th> Lavel</th>
														<th> Status</th>
														<th> Opsi </th>
													</tr>
													</thead>
													<?php $no = 1;?>
													<?php foreach($data as $tampil) {?>	
													<tbody>
													<tr>
														<td><?php echo $no++;?></td>
														<td><?php echo ucwords($tampil->username);?></td>
														<td><img src="<?php echo base_url('galery/akun/').$tampil->gender;?>" class="img-circle" alt="User Image" style="width:35px;height:35px"></td>
														<td><?php echo  ucfirst($tampil->level);?></td>
														<?php if($tampil->status == 1){$status='On';}else{$status='Off';}?>
														<td><?php echo $status;?></td>
														<td>
															<a href="#" onclick="edit('<?php echo $tampil->iduser;?>','<?php echo $tampil->username;?>','<?php echo $tampil->gender;?>','<?php echo $tampil->level;?>','<?php echo $tampil->status;?>')" class="btn btn-success btn-xs">Ed Data</a>
															<a href="#" onclick="pass('<?php echo $tampil->iduser;?>','<?php echo $tampil->username;?>')" class="btn btn-info btn btn-xs">Ed Pass</a>
														</td>
													</tr>
													</tbody>
													<?php  }?>	
												</table>
											</div>	
							</div>
						</div>
					</div>

	
	</div>
		
</div>





<div class="modal fade" id="modalData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
						<span class="input-group-addon" id="basic-addon1">Username</span>
						<input type="hidden" name="iduser" id="iduser" required class="form-control" placeholder="">
						<input type="text" name="username" id="username" required class="form-control" placeholder="Username">
					</div>
					
					<div class="input-group" id="bxPass">
						<span class="input-group-addon" id="basic-addon1">Password</span>
						<input type="text" name="password" id="password" required class="form-control" placeholder="Password">
					</div>
						
					
					
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Gender</span>
						<select name="gender" id="gender" class="form-control">
						
						</select>
					</div>
					
					
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Level</span>
						<select name="level" id="level" class="form-control">
						
						</select>
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
			<button type="button" class="btn btn-success" id="updates" style="display:none">Update</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	


<div class="modal fade" id="modalPass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		 <h4>Edit Password</h4>
      </div>
			<div class="modal-body" style="background-color:#B0E0E6" id="bodyModal">
				<div id="infop" style="margin:10px">
				</div>
			
				<form action="" id="formPass" method="POST">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Username</span>
						<input type="hidden" name="iduser" id="iduserPass" required class="form-control" placeholder="">
						<input type="text" name="username" id="usernamePass" required class="form-control" placeholder="Username" readonly>
					</div>
					
					<div class="input-group" id="bxPass">
						<span class="input-group-addon" id="basic-addon1">Password</span>
						<input type="text" name="password" id="password" required class="form-control" placeholder="Password">
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-info" id="updatePass">Update</button>
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						
					</div>
							
				</form>
				
    </div>
  </div>
</div>	
</div>	







<script type="text/javascript">
$("#akun").DataTable({
});
	







$('#tambahS').click(function(e){
	
	e.preventDefault();
	$('#simpans').show();
	$('#updatest').hide();
	$('#bxPass').show();
	$('#modalData').modal('show');
	$('#labelst').html('Tambah Akun');
	$('#formst')[0].reset();
	$("#gender").html("<option disabled selected>---Pilih---</option><option value='userL.png'>Male</option><option value='userP.png'>Female</option>");
	$("#level").html("<option disabled selected>---Pilih---</option><option value='admin'>Admin</option><option value='kasir'>Kasir</option>");
	$("#status").html("<option disabled selected>---Pilih---</option><option value='1'>On</option><option value='0'>Off</option>");
			
	
})



$('#simpans').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menambahkan Akun Baru?'))
	{
		
		if($("#username").val() == '')
		{
			alert("Username Tidak Boleh Kosong");
		}
		else if($("#pass").val() == '')
		{
			alert("Password Tidak Boleh Kosong");
		}
		else if($("#gender").val() == null)
		{
			alert("Harap Pilih Gender");
		}
		else if($("#level").val() == null)
		{
			alert("Harap Pilih Lavel");
		}
		else if($("#status").val() == null)
		{
			alert("Harap Pilih Status");
		}
		else
		{
		
		$.ajax({
				
				url		: "<?php echo base_url('admin/Akun/simpanAkun');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formst').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-success' align='center'> "+ data.ket +" </div></div>")
								$("#infost").fadeOut('slow');
								$('#list').load("<?php echo base_url('admin/Akun/ajax_list');?>");
								
								$('#formst')[0].reset();
							
							
												
							}
							else
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-danger' align='center'> "+ data.ket +" </div></div>")
								$('#listSuplayer').load("<?php echo base_url('admin/Suplayer/ajax_listSuplayer');?>");
								
							}
					
							
						},
				error	: function(data){
							
							$("#infost").fadeIn('slow');
							$("#infost").html("<div class='col-md-12 '><div class='alert-danger' align='center'> "+ data.ket +" </div></div>")
							
						
						},
				
			
			
			
		})
	
		}
	
		
		
	}
			
	
})


function edit(iduser,username,gender,level,status){
			
			
			if(gender == 'userL.png')
			{
				var gn = "<option disabled>---Pilih---</option><option value='userL.png' selected>Male</option><option value='userP.png'>Female</option>"; 
			}
			else
			{
				var gn = "<option disabled>---Pilih---</option><option value='userL.png'>Male</option><option value='userP.png'  selected>Female</option>"; 
			}
			
			if(level == 'admin')
			{
				var le = "<option disabled>---Pilih---</option><option value='admin' selected>Admin</option><option value='kasir'>Kasir</option>"; 
			}
			else
			{
				var le = "<option disabled>---Pilih---</option><option value='admin'>Admin</option><option value='kasir' selected>Kasir</option>"; 
			}
			
			if(status == 1)
			{
				var st = "<option disabled>---Pilih---</option><option value='1' selected>Aktif</option><option value='0'>Off</option>"; 
			}
			else
			{
				var st = "<option disabled>---Pilih---</option><option value='1'>Aktif</option><option value='0'selected>Off</option>"; 
			}
			
			$('#simpans').hide();
			$('#updates').show();
			$('#bxPass').hide();
			$('#labelst').html('Update Suplayer');
			$('#iduser').val(iduser);
			$('#username').val(username);
			$('#gender').html(gn);
			$('#level').html(le);
			$('#status').html(st);
			$('#modalData').modal('show');
			
}



$('#updates').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menyimpan Perubahan?'))
	{
		if($("#username").val() == '')
		{
			alert("Nama Suplayer Tidak Boleh Kosong");
		}
		else if($("#gender").val() == null)
		{
			alert("Harap Pilih Gender");
		}
		else if($("#level").val() == null)
		{
			alert("Harap Pilih Level");
		}
		else if($("#status").val() == null)
		{
			alert("Harap Pilih Status");
		}
		else
		{
		
		$.ajax({
				
				url		: "<?php echo base_url('admin/Akun/updateData');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formst').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infost").fadeIn('slow');
								$("#infost").html("<div class='col-md-12 '><div class='alert-success' align='center'> "+ data.ket +" </div></div>")
								$("#infost").fadeOut('slow');
								$('#list').load("<?php echo base_url('admin/Akun/ajax_list');?>");
								
								$('#formst')[0].reset();
							
							
												
							}
					
							
						},
				error	: function(xhr, textStatus){
									
										var msg ='';
											
												if(xhr.status === 0){
														msg = 'Tidak ada jaringan, Periksa koneksi jaringan';
													}
											else if(xhr.status == 404){
														msg = ' Halaman web tidak ditemukan [404]';
													}
											else if(xhr.status == 505){
														msg = ' Internal Server Error [505]';
													}
											else if(text.status === 'timeout'){
														msg = 'Time Out Error, Ulangi Kembali';
													}
												else{
														msg = ' Uncaughr Error.\n' + xhr.responseText;
													}
											alert(msg);
											
								},
				
			
			
			
				})
		
		}
	
	
		
		
	}
			
	
})

function pass(iduser,username){
			
			
			$("#iduserPass").val(iduser);
			$("#usernamePass").val(username);
			$('#modalPass').modal('show');
			
}


$('#updatePass').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menyimpan Perubahan?'))
	{
		$.ajax({
				
				url		: "<?php echo base_url('admin/Akun/updatePass');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formPass').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#infop").fadeIn('slow');
								$("#infop").html("<div class='col-md-12 '><div class='alert-success' align='center'> "+ data.ket +" </div></div>")
								$('#list').load("<?php echo base_url('admin/Akun/ajax_list');?>");
								
							
												
							}
					
							
						},
				error	: function(xhr, textStatus){
									
										var msg ='';
											
												if(xhr.status === 0){
														msg = 'Tidak ada jaringan, Periksa koneksi jaringan';
													}
											else if(xhr.status == 404){
														msg = ' Halaman web tidak ditemukan [404]';
													}
											else if(xhr.status == 505){
														msg = ' Internal Server Error [505]';
													}
											else if(text.status === 'timeout'){
														msg = 'Time Out Error, Ulangi Kembali';
													}
												else{
														msg = ' Uncaughr Error.\n' + xhr.responseText;
													}
											alert(msg);
											
								},
				
			
			
			
				})
		
	
	
	
		
		
	}
			
	
})






</script>
