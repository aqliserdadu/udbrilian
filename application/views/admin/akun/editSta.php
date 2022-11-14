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
					<h3 class="box-title">Form Edit Password</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
			
				<div class="box-body">
					<form action="<?php echo base_url('admin/Akun/updateSta'); ?>" method="POST" enctype="multipart/form-data">
							<div class="row">
							
							  <div>
								<?php echo $this->session->flashdata('massage');?>
							  </div>
										
								<div class="col-md-12">
								  
									<div class="form-group">
										<input class="form-control" type="hidden" name="id" value="<?php echo $id;?>"  required placeholder="Masukan Password Lama">
									</div>
									
								
									<div class="form-group">
										<label class="control-label col-md-1">Level</label>
										
										<div class="radio-inline" >
											<label class="radio-inline">
												<input class="radio" type="radio" name="level"  value="admin" required> Admin
											</label>
										</div>
										
										<div class="radio-inline" >
											<label class="radio-inline">
												<input class="radio" type="radio" name="level"  value="staf" required> Staf
											</label>
										</div>
										
										<div class="radio-inline" >
											<label class="radio-inline">
												<input class="radio" type="radio" name="level"  value="member" required> Member
											</label>
										</div>
										
									 </div>
									
									
									
									
									<div class="form-group">
										<label class="control-label col-md-1">Status</label>
										
										<div class="radio-inline" >
											<label class="radio-inline">
												<input class="radio" type="radio" name="status"  value="1" required> On
											</label>
										</div>
										
										<div class="radio-inline" >
											<label class="radio-inline">
												<input class="radio" type="radio" name="status"  value="0" required> Off
											</label>
										</div>
										
									 </div>
									
									
									
									
									
									
									
								  <div class="form-group" align="center">
									<input type="submit" value="Simpan" name="save" class="text-right btn btn-success"/>
									<a class="text-right btn btn-default icon-btn" href="<?php echo base_url('admin/Akun');?>"><i class="fa fa-fw fa-lg fa-times-circle"></i>Batal</a>
									</div>
								  </div>
								</div> 
							
							</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
