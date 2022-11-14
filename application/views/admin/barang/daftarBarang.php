
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Barang
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Daftar Barang</li>
      </ol>
    </section>


 <div class="content">
	

	

	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
					<div style="margin-bottom:10px">
						<button class="btn btn-success" id="tambahBarang"><i class="fa fa-plus"> Tambah Kode Brang</i></button>
					</div>
					
					<div class="table-responsive" id="dataBarang">
						
						<table id="barang" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Kode Barang</th>
								<th>Tinggi</th>
								<th>Lebar</th>
								<th>Panjang</th>
								<th>Action</th>
								
							</tr>
							</thead>
							
							<tbody>
							
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	
	
		
	
	</div>
	
	

</div>




<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		 <h4 id="label"></h4>
      </div>
			<form action="" id="formBarang" method="POST">
				<div class="modal-body" style="background-color:#B0E0E6" id="bodyModal">
					<div id="info" style="margin:10px">
					</div>
						<div class="input-group" style="display:none">
							<span class="input-group-addon" id="basic-addon1">Kode Barang</span>
							<input type="text" name="idbarang" id="idbarang" class="form-control" placeholder="Id Barang">
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Tinggi</span>
							<input type="text" name="t" id="t" required class="form-control" placeholder="Tinggi">
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Lebar</span>
							<input type="text" name="l" id="l" required class="form-control" placeholder="Lebar">
						</div>

						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Panjang</span>
							<input type="text" name="p" id="p" required class="form-control" placeholder="Panjang">
						</div>
					
						
				
			  </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="simpan" style="display:none">Simpan</button>
					<button type="button" class="btn btn-info" id="update" style="display:none">Update</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				
				</div>
		  </form>
    </div>
  </div>
</div>	







<script type="text/javascript">
// format uang
//$("#hargabeli, #hargajual").mask("000,000,000,000,000,000,000,000",       {reverse:true});			




// Setup datatables
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };


$("#barang").DataTable({
	"processing"	: true,
	"serverSide"	:true,
	"order"			: [1,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('admin/Barang/dtDaftar');?>',
						"type" : "POST",
					 },
	"pageLength"	: 10,
	"select"		: true,
	"columns"		:[
						
						{
							"data" : "no",
							"orderable": false,
							"searchable" : false,
							"sClass": "text-center",
						},
						
						{
							"data" : "idbarang",
							"sClass": "text-center",
						},
						
						{
							"data" : "t",
							"sClass": "text-left",
						},
						
						{
							"data" : "l",
							"sClass": "text-left",
						},

						{
							"data" : "p",
							"sClass": "text-left",
						},
						
						{
							"data" : "hapus",
							"orderable": false,
							"sClass": "text-center",
							'searchable': false,
						},
					 ],
	"rowCallback"	: function(row, data, iDisplayIndex) 
						{
							var info = this.fnPagingInfo();
							var page = info.iPage;
							var length = info.iLength;
							var index = page * length + (iDisplayIndex + 1);
							$('td:eq(0)', row).html(index);
						},
});




$('#tambahBarang').click(function(e){
	
	e.preventDefault();
	$('#simpan').show();
	$('#update').hide();
	$('#modal').modal('show');
	$('#label').html('Tambah Kode Barang');
	$('#formBarang')[0].reset();
			
	
})


$('#barang').on('click','.hapus',function(){
	
	var id=$(this).data('id');
   
	if(confirm('Apa Ingin Menghapus Kode Barang?'))
	{    

		$.ajax({
						
						url		: "<?php echo base_url('admin/Barang/hapusDaftar');?>",
						type	: "POST",
						dataType: "json",
						data 	: {'idbarang':id},
						success	: function(data){	
									if(data.status == true)
									{
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Berhasil Di Hapus </div></div>")
										$("#info").fadeOut('slow');
										$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtDaftar');?>");
										
										$('#formBarang')[0].reset();
									
									
														
									}
								else
									{
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak Boleh Kosong </div></div>")
										$("#info").fadeOut('slow');
									}	
									
									
									
								},
						error	: function(data){
									
									$("#info").fadeIn('slow');
									$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal Dalam Menyimpan </div></div>")
									$("#info").fadeOut('slow');
								
								},
						
				
				
				
					})
		


	} 
			
})





$('#simpan').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menambahkan Kode Barang?'))
	{
		if($("#t").val() == '')
		{
			alert("Tinggi Tidak Boleh Kosong");
		}
		else if($("#l").val() == '')
		{
			alert("Lebar Tidak Boleh Kosong");
		}
		else if($("#p").val() == '')
		{
			alert("Pajang Tidak Boleh Kosong");
		}
		else
		{
				$.ajax({
						
							url		: "<?php echo base_url('admin/Barang/tambahDaftar');?>",
							type	: "POST",
							dataType: "json",
							data 	: $('#formBarang').serialize(),
							success	: function(data){	
										if(data.status == true)
										{
											$("#info").fadeIn('slow');
											$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
											$("#info").fadeOut('slow');
											$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtDaftar');?>");
											
											$('#formBarang')[0].reset();
										
										
															
										}
									else
										{
											if(data.ket != ''){
												ket = data.ket;
											}else
											{
												ket = "Gagal!!! Tidak Boleh Kosong"
											}
											$("#info").fadeIn('slow');
											$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'>"+ ket +" </div></div>")
											$("#info").fadeOut('slow');
										}	
										
										
										
									},
							error	: function(data){
										
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal Dalam Menyimpan </div></div>")
										$("#info").fadeOut('slow');
									
									},
							
					
					
					
						})
			
		}
	
		
		
	}
			
	
})




$('#update').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menyimpan Perubahan?'))
	{
		if($("#idbarang").val() == '')
		{
			alert("Id Barang Tidak Boleh Kosong");
		}
		else if($("#t").val() == '')
		{
			alert("Tinggi Tidak Boleh Kosong");
		}
		else if($("#l").val() == '')
		{
			alert("Lebar Tidak Boleh Kosong");
		}
		else if($("#p").val() == '')
		{
			alert("Pajang Tidak Boleh Kosong");
		}
		else
		{
					
					$.ajax({
							
							url		: "<?php echo base_url('admin/Barang/updateDaftar');?>",
							type	: "POST",
							dataType: "json",
							data 	: $('#formBarang').serialize(),
							success	: function(data){	
										if(data.status == true)
										{
											$("#info").fadeIn('slow');
											$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Perubahan Berhasil Disimpan </div></div>")
											$("#info").fadeOut('slow');
											$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtDaftar');?>");
											
										
															
										}
									else
										{
											$("#info").fadeIn('slow');
											$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak Boleh Kosong </div></div>")
											$("#info").fadeOut('slow');
										}	
										
										
										
									},
							error	: function(data){
										
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Perubahan Gagal Diperbaharui </div></div>")
										$("#info").fadeOut('slow');
									
									},
							
						
						
						
					})
				
				
				
		
		}
	}
			
	
})




</script>