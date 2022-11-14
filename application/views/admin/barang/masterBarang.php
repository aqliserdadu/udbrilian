
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
      Master Barang
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barang</li>
      </ol>
    </section>


 <div class="content">
	

	

	<div class="row">
		<div id="infoD"></div>
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
					<div style="margin-bottom:10px">
						<button class="btn btn-success" id="tambahBarang"><i class="fa fa-plus"> Barang</i></button>
					</div>
					
					<div class="table-responsive" id="dataBarang">
						
						<table id="barang" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Kategori</th>
								<th>Nama</th>
								<th>Harga Beli</th>
								<th>Harga Jual</th>
								<th>Satuan</th>
								<th>Status</th>
								<th>Opsi</th>
								
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
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Nama Barang</span>
							<input type="hidden" name="idmasterbarang" id="idmasterbarang" class="form-control">
							<input type="hidden" name="idbarang" id="idbarang" class="form-control">
							<input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Nama Barang">
							<span class="input-group-btn">
								<button class="btn btn-info" id="cari"><i class="fa fa-search"></i></button>
							</span>
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Kode</span>
							<input type="text" name="kodebarang" id="kodebarang" class="form-control" placeholder="Barcode Barang">
						</div>
						
					
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Satuan</span>
							<select name="satuanbarang" id="satuanbarang" class="form-control">
							
							</select>
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Harga Beli</span>
							<input type="text" name="hargabeli" id="hargabeli" required class="form-control" placeholder="Harga Beli">
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Harga Jual</span>
							<input type="text" name="hargajual" id="hargajual" required class="form-control" placeholder="Harga Jual">
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Status</span>
							<select name="status" id="status" class="form-control">
								
							</select>
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




<div class="modal fade" id="modalDaftar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content" style="background-color:#87CEFA">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			 <h4 id="label">Daftar Barang</h4>
		  </div>
				<div class="modal-body" style="background-color:#B0E0E6" id="getDaftar">
						
						
					
				  
				</div>
		</div>
	</div>	
</div>	






<script type="text/javascript">
// format uang
$("#hargabeli, #hargajual").mask("000,000,000,000,000,000,000,000",       {reverse:true});			

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
									
									$("#getDaftar").html(data);
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
	"order"			: [2,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('admin/Barang/dtBarang');?>',
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
							"data" : "barcodebarang",
							"sClass": "text-left",
						},
						
						{
							"data" : "kategori",
							"sClass": "text-left",
						},
						{
							"data" : "namabarang",
							"sClass": "text-left",
						},
						{
							"data" : "hargabelibarang", render: $.fn.dataTable.render.number(',','.','','Rp. '),
							"sClass": "text-left",
							"searchable" : false,
						},
						{
							"data" : "hargajualbarang", render: $.fn.dataTable.render.number(',','.','','Rp. '),
							"sClass": "text-left",
							"searchable" : false,
						},
						{
							"data" : "namasatuan",
							"sClass": "text-center",
						},
						{
							"data" : "statusbarang",
							"sClass": "text-center",
						},
						
						{
							"data" : "opsi",
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
	$('#satuanbarang').load("<?php echo base_url('admin/Barang/ajax_satuan');?>");
	$('#simpan').show();
	$('#update').hide();
	$('#modal').modal('show');
	$('#label').html('Tambah Barang');
	$("#status").html("<option disabled selected>---Pilih---</option><option value='On'>ON</option><option value='Off'>OFF</option>");
	$('#formBarang')[0].reset();
			
	
})


$('#barang').on('click','.edit',function(){
			
			$('#simpan').hide();
			$('#update').show();
			
			
			var idmasterbarang=$(this).data('idmasterbarang');
			var idbarang=$(this).data('idbarang');
			var namabarang=$(this).data('nama');
            var satuan=$(this).data('satuan').split(" ").join("-"); //ubah menjadi spasi ganti jadi-
            var beli=$(this).data('beli');
            var jual=$(this).data('jual');
            var status=$(this).data('status');
            var barcode=$(this).data('barcode');
			
			if(status == 'On')
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On' selected>ON</option><option value='Off'>OFF</option>"; 
			}
			else if(status == 'Off')
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On'>ON</option><option value='Off' selected>OFF</option>"; 
			}
			else
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On'>ON</option><option value='Off'>OFF</option>"
			}
            
			$('#idmasterbarang').val(idmasterbarang);
			$('#idbarang').val(idbarang);
			$('#namabarang').val(namabarang);
			$('#label').html('Update Barang');
			$('#satuanbarang').load("<?php echo base_url('admin/Barang/ajax_satuan/');?>"+satuan);
			$('#hargabeli').val(formatUang(beli));
			$('#hargajual').val(formatUang(jual));
			$('#status').html(op);
			$('#kodebarang').val(barcode);
			$('#modal').modal('show');
			
})



$('#barang').on('click','.hapus',function(){
			
		var id = $(this).data('idmasterbarang');	
	if(confirm('Apa Ingin Menghapusan Master Barang?'))
	{
		
		
						$.ajax({
								
								url		: "<?php echo base_url('admin/Barang/deleteBarang');?>",
								type	: "POST",
								dataType: "json",
								data 	: {idmasterbarang:id},
								success	: function(data){	
											if(data.status == true)
											{
												$("#infoD").fadeIn('slow');
												$("#infoD").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Berhasil Dihapuskan </div></div>")
												$("#infoD").fadeOut('slow');
												$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtbarang');?>");
												
											
																
											}
										else
											{
												$("#infoD").fadeIn('slow');
												$("#infoD").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak dapat dihapus </div></div>")
												
											}	
											
											
											
										},
								error	: function(data){
											
											$("#infoD").fadeIn('slow');
											$("#infoD").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Perubahan Gagal Diperbaharui </div></div>")
											$("#infoD").fadeOut('slow');
										
										},
								
							
							
							
						})
					
		
	
		
		
	}
			
})






$('#simpan').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Menambahkan Barang?'))
	{
		if($("#idbarang").val() == '')
		{
			alert("Harap Pilih Nama Barang");
		}
		else if($("#namabarang").val() == '')
		{
			alert("Nama Barang Tidak Boleh Kosong");
		}
		else if($("#satuan").val() == '')
		{
			alert("Harap Pilih Satuan Barang");
		}
		else if($("#hargabeli").val() == '')
		{
			alert("Harga Beli Tidak Boleh Kosong");
		}
		else if($("#hargajual").val() == '')
		{
			alert("Harga Jual Tidak Boleh Kosong");
		}
		else if($("#status").val() == null)
		{
			alert("Harap Pilih Status");
		}
		else
		{
		
		
		
						$.ajax({
								
								url		: "<?php echo base_url('admin/Barang/tambahBarang');?>",
								type	: "POST",
								dataType: "json",
								data 	: $('#formBarang').serialize(),
								success	: function(data){	
											if(data.status == true)
											{
												$("#info").fadeIn('slow');
												$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
												$("#info").fadeOut('slow');
												$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtbarang');?>");
												
												$('#formBarang')[0].reset();
											
											
																
											}
										else
											{
												$("#info").fadeIn('slow');
												$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> "+data.data+" </div></div>")
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
			alert("Harap Pilih Nama Barang");
		}
		else if($("#namabarang").val() == '')
		{
			alert("Nama Barang Tidak Boleh Kosong");
		}
		else if($("#satuan").val() == '')
		{
			alert("Harap Pilih Satuan Barang");
		}
		else if($("#hargabeli").val() == '')
		{
			alert("Harga Beli Tidak Boleh Kosong");
		}
		else if($("#hargajual").val() == '')
		{
			alert("Harga Jual Tidak Boleh Kosong");
		}
		else if($("#status").val() == null)
		{
			alert("Harap Pilih Status");
		}
		else
		{
		
						$.ajax({
								
								url		: "<?php echo base_url('admin/Barang/updateBarang');?>",
								type	: "POST",
								dataType: "json",
								data 	: $('#formBarang').serialize(),
								success	: function(data){	
											if(data.status == true)
											{
												$("#info").fadeIn('slow');
												$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Perubahan Berhasil Disimpan </div></div>")
												$("#info").fadeOut('slow');
												$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtbarang');?>");
												
											
																
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