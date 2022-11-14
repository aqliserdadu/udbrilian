<section class="content-header">
      <h1>
       Akun
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("admin/Akun/index");?>"></i> Akun</a></li>
        <li class="active">Formm Edit</li>
      </ol>
</section>




<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Form Tambah Akun</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
			
				<div class="box-body">
					<form action="<?php echo base_url('admin/Akun/simpanAkun'); ?>" method="POST" enctype="multipart/form-data">
							<div class="row">
							
							  <div>
								<?php echo $this->session->flashdata('massage');?>
							  </div>
							
								<div class="col-md-12">
								  
									<div class="form-group">
										<label class="control-label">Username</label>
										<input class="form-control" type="text" name="username" placeholder="Nama User"  required>
									</div>
									
									
									<div class="form-group">
										<label class="control-label">Gender</label>
										<select name="gender" class="form-control">
											<option value="" disabled selected>--Pilih---</option>
											<option value="userL.png">Male</option>
											<option value="userP.png">Female</option>
										</select>
									</div>
									
									<div class="form-group">
										<label class="control-label">Password</label>
										<input class="form-control" type="text" name="password" id="password" placeholder="Password" required>
									</div>
									
									<div class="form-group">
										<label class="control-label">Level</label>
										<select name="level" class="form-control" required>
											<option value="" selected disabled>--Pilih Level--</option>
											<option value="admin">Admin</option>
											<option value="staf">Staf</option>
											<option value="member">Member</option>
										</select>
											
									</div>
									
									<div class="form-group">
										<label class="control-label">Status</label>
										<select name="status" class="form-control" required>
											<option value="" selected disabled>--Pilih--</option>
											<option value="1">ON</option>
											<option value="0">OFF</option>
										</select>
											
									</div>
									
									
									
									
								  <div class="form-group" align="right">
									<input type="submit" value="Simpan" name="save" class="btn btn-success" onclick="return confirm('Apa Anda Ingin Menambahkan Akun?')">
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
