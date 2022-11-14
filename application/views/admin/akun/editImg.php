<style>

a { color : black}
a:hover { color : blue}


img {
	max-width:100%;
	height : auto;
	box-shadow: 0px 0px 10px #aaa;
}

</style>

<section class="content-header">
      <h1>
       Akun
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("adminDigital/Akun/index");?>"></i> Akun</a></li>
        <li class="active">Form Edit Img</li>
      </ol>
</section>




		
<div class="content" >


	<form action="<?php echo base_url('adminDigital/Akun/updateImg');?>" method="POST" enctype="multipart/form-data">
			
		
			
			<div class="row">
				<div class="col-md-12">
					<div class="box box-info">
						<div class="box-body">
							<div class="row">
								<div class="col-md-12">
									
									<div class="col-md-4">
										<div class="form-group">
										
											<img id="preview" src="<?php echo base_url("galery/akun/".$data->img);?>" alt=""/>
											<input type="hidden" value="<?php  echo $data->img;?>" name="imgLama">
											<input type="hidden" value="<?php  echo $data->email;?>" name="email">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											
											<label class="control-label"> Pilih Foto : </label>
											<input type="file" name="img" required onchange="tampilkanPreview(this,'preview')">
											
													<label> Note :</label>
													<p> Lebar Gambar max	: 1024px </p>
													<p> Tinggi Gambar max	: 768px </p>
													<p> Size Gambar max		: 1 Mb </p>
													<p> Type Img		: gif|jpg|png|bmp </p>
												
										</div>
											
										<input type="submit" name="save" value="Simpan" class="btn btn-success"> 
										<a href="<?php echo base_url('adminDigital/Akun');?>" class="btn btn-danger"> Batal </a>
									
									</div>
								
									
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	
	</form> <!--end form -->


</div> 



<!-- jQuery 3 -->
<script src="<?php echo base_url();?>asset/adminDigital/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url();?>asset/adminDigital/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
            
            
            
            function tampilkanPreview(gambar,idpreview){
//                membuat objek gambar
                var gb = gambar.files;
                
//                loop untuk merender gambar
                for (var i = 0; i < gb.length; i++){
//                    bikin variabel
                    var gbPreview = gb[i];
                    var imageType = /image.*/;
                    var preview=document.getElementById(idpreview);            
                    var reader = new FileReader();
                    
                    if (gbPreview.type.match(imageType)) {
//                        jika tipe data sesuai
                        preview.file = gbPreview;
                        reader.onload = (function(element) { 
                            return function(e) { 
                                element.src = e.target.result; 
                            }; 
                        })(preview);
 
    //                    membaca data URL gambar
                        reader.readAsDataURL(gbPreview);
                    }else{
//                        jika tipe data tidak sesuai
                        alert("Type file tidak sesuai. Khusus image.");
                    }
                   
                }    
            }
    
 
 
</script>
