<section class="content-header">
      <h1>
       Akun
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li></i> Akun</a></li>
        <li class="active">Formm Edit</li>
      </ol>
</section>




<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Form Edit Password</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
			
				<div class="box-body">
					<form action="#" id="formPass" method="POST" enctype="multipart/form-data">
							<div class="row">
							
							  <div>
								<?php echo $this->session->flashdata('massage');?>
							  </div>
										
								<div class="col-md-12">
								  
									<div class="form-group">
										<input class="form-control" type="hidden" name="iduser" id="iduser"  required value="<?php echo $this->session->userdata('iduser');?>">
									</div>
									
									<div class="form-group">
										<label class="control-label">Password Baru</label>
										<input class="form-control" type="password" name="password"  required placeholder="Masukan Password Baru">
									</div>
									
									
								  <div class="form-group" align="right">
									<input type="submit" value="Simpan" name="save" class="btn btn-success" id="updatePass">
									<a class="btn btn-default icon-btn" href="<?php echo base_url('dashboard');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a>

								  </div>
								</div> 
							
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
$('#updatePass').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menyimpan Perubahan?'))
	{
		$.ajax({
				
				url		: "<?php echo base_url('admin/Akun/updatePass');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formPass').serialize(),
				
				beforeSend: function()
							{
												$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
												$(".preloader").show();
							},
				success	: function(data){	
							if(data.status == true)
							{
								alert('Password Berhasil Di Update')
							
												
							}
				
						},
						
				complete: function(data){
											$(".preloader").hide();
											
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