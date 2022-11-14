<section class="content-header">
      <h1>
       Akun
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("adminDigital/Akun/index");?>"></i> Akun</a></li>
        <li class="active">Formm Edit</li>
      </ol>
</section>




<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Form Edit Akun</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
			
				<div class="box-body">
					<form action="<?php echo base_url('adminDigital/Akun/updateAkun'); ?>" method="POST" enctype="multipart/form-data">
							<div class="row">
							
							  <div>
								<?php echo $this->session->flashdata('massage');?>
							  </div>
							
								<div class="col-md-12">
								  
									<div class="form-group">
										<label class="control-label">Nama Akun</label>
										<input class="form-control" type="text" name="namaAkun" value="<?php echo $data->namaAkun;?>"  required>
										<input class="form-control" type="hidden" name="id" value="<?php echo $data->id;?>"  required>
									</div>
									
									<div class="form-group">
										<label class="control-label">Whatsapp</label>
										<input class="form-control" type="text" name="wa" id="wa" value="<?php echo $data->wa;?>" required>
									</div>
									
									<div class="form-group">
										<label class="control-label">Email</label>
										<input class="form-control" type="email"value="<?php echo $data->email;?>" name="email" id="email" placeholder="email" required>
									</div>
									
									<div class="form-group">
										<label class="control-label">Alamat</label>
										<input class="form-control" type="text" name="alamat" id="alamat" value="<?php echo $data->alamat;?>" required>
									</div>
									
									
								  <div class="form-group" align="right">
									<input type="submit" value="Simpan" name="save" class="btn btn-success"/>
									<a class="btn btn-default icon-btn" href="<?php echo base_url('adminDigital/Akun');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a>

								  </div>
								</div> 
							
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
