
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Just Barang
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Just Barang</li>
      </ol>
    </section>


 <div class="content">
	

	

	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
					<div style="margin-bottom:10px">
						<button class="btn btn-success" id="tambahJust"><i class="fa fa-plus"> Just Barang</i></button>
					</div>
					
					<div class="table-responsive" id="data">
						
						<table id="dataJust" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>User</th>
								<th>Nama</th>
								<th>Jumlah</th>
								<th>Satuan</th>
								<th>Just</th>
								<th>Jenis</th>
								<th>Keterangan</th>
								
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




<div class="modal fade" id="modalJust" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		 <h4 id="label"></h4>
      </div>
			<div class="modal-body" style="background-color:#B0E0E6">
				<div id="info" style="margin:10px">
				</div>
			
				<form action="" id="formBarang" method="POST">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Nama</span>
						<input type="hidden" name="idbarang" id="idbarang" required class="form-control" placeholder="Nama Barang">
						<input type="text" name="namabarang" id="namabarang" required class="form-control" placeholder="Nama Barang">
						<span class="input-group-btn">
							<button class="btn btn-info" id="cari"><i class="fa fa-search"></i></button>
						</span>
					</div>
						
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Just</span>
						<select name="just" id="just" class="form-control">
							<option value="" disabled selected>--Pilih--</option>
							<option value="in">IN</option>
							<option value="out">OUT</option>
						</select>
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Jumlah</span>
						<input type="number" name="qty" id="qty" required class="form-control" placeholder="Qty">
						<span class="input-group-btn">
							<button class="btn btn-default" disabled>Pcs</button>
						</span>
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Jenis</span>
						<select name="jenis" id="jenis" class="form-control">
							<option value="" disabled selected>--Pilih--</option>
							<option value="penambahan">Penambahan</option>
							<option value="penyamaan">Penyamaan</option>
							<option value="kerugian">Kerugian</option>
						</select>
					</div>
					
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Keterangan</span>
						<input type="text" name="ket" id="ket" required class="form-control" placeholder="Keterangan">
					</div>
				</form>
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-success" id="simpan">Simpan</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	







<div class="modal fade" id="modalDaftar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
			<div class="modal-body" style="background-color:white" id="bodyModal">
							
				
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	














<script type="text/javascript">

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


$("#dataJust").DataTable({
	"processing"	: true,
	"serverSide"	:true,
	"order"			: [1,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('admin/Barang/dtJust');?>',
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
							"data" : "date",
							"sClass": "text-center",
						},
						
						{
							"data" : "username",
							"sClass": "text-left",
						},
						
						{
							"data" : "namabarang",
							"sClass": "text-left",
						},
						
						{
							"data" : "qtyjust",
							"sClass": "text-center",
						},
						
						{
							"data" : "namasatuan",
							"sClass": "text-center",
						},
						
						{
							"data" : "just",
							"sClass": "text-center",
						},
						
						{
							"data" : "jenis",
							"sClass": "text-center",
						},
						
						{
							"data" : "ket",
							"sClass": "text-left",
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


$('#tambahJust').click(function(e){
	
	e.preventDefault();
	$('#modalJust').modal('show');
	$('#formBarang')[0].reset();
			
	
})

$('#cari').click(function(e){
	e.preventDefault();
	
	$.ajax({
					
						url		: '<?php echo base_url('admin/Barang/getDaftar');?>',
						type	: "POST",
						dataType: "html",
						
						beforeSend: function()
								{
									$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
									$(".preloader").show();
								},
						
						success	: function(data){	
									
									$("#bodyModal").html(data);
									$('#modalDaftar').modal('show');
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
			
		
	
})


$('#simpan').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menambahkan Just?'))
	{
		
		if($("#idbarang").val() =='' )
		{
			alert('Harap Pilih Barang');
			$("#namabarang").focus();
		}
		else if($("#just").val() == null )
		{
			alert('Pilih Just');
			$("#just").focus();
		}
		else if($("#qty").val() =='' )
		{
			alert('Masukan Jumlah');
			$("#qty").focus();
		}
		else if($("#jenis").val() == null )
		{
			alert('Pilih Jenis');
			$("#jenis").focus();
		}
		else
		{
		
			$.ajax({
					
					url		: "<?php echo base_url('admin/Barang/tambahJust');?>",
					type	: "POST",
					dataType: "json",
					data 	: $('#formBarang').serialize(),
					success	: function(data){	
								if(data.status == true)
								{
									$("#info").fadeIn('slow');
									$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
									$("#info").fadeOut('slow');
									$('#data').load("<?php echo base_url('admin/Barang/ajax_just');?>");
									$("#formBarang")[0].reset();
									
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
		
	}
			
	
})








</script>