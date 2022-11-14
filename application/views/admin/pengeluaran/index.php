
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
		Pengeluaran
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pengeluaran</li>
      </ol>
    </section>


 <div class="content">
	

	

	<div class="row">
		<div class="col-md-4">
					<div class="box box-info">
						<div class="box-body">
							<div style="padding:5px; text-align:center; background-color:#7FFFD4; color:black; border:1px solid #fff">
								Tambah Pengeluaran
							</div>
							<div id="info"></div>
							<form action="" id="formaddPengeluaran" method="POST">
								<div class="input-group">
									<input type="hidden" name="id" id="id" class="form-control" style="width:100%" required value="<?php echo date('Y-m-d');?>">
								</div>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Date</span>
									<input type="text" name="date" class="form-control date" id="date" style="width:100%" required value="<?php echo date('Y-m-d');?>">
								</div>
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Kategori</span>
									<input type="text" name="kategori" id="kategori" required class="form-control" placeholder="Kategori">
								</div>
								
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nominal</span>
									<input type="text" name="nominal" id="nominal" required class="angka form-control" placeholder="Nominal">
								</div>
								
								
								<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Keterangan</span>
									<input type="text" name="ket" id="ket" required class="form-control" placeholder="Keterangan">
								</div>
							</form>
			
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-info" id="updatePengeluaran" style="display:none">Update</button>
							<button type="button" class="btn btn-success" id="simpanaddPengeluaran">Simpan</button>
						</div>
					</div>
		</div>
		<div class="col-md-8">	
			<div class="box box-info">
				<div class="box-body">
					<div class="row">
						<div class="col-md-12">
							<form action="#" method="post" id="formCari">
									<div class="col-md-6">	
									
										
										<div class="input-group">
													<span class="input-group-addon" id="basic-addon1">From</span>
													<input type="text" name="tglP" id="tglP" value="<?php echo empty($tglP)?date('Y-m-d'):$tglP;?>" required class="form-control date" placeholder="Date">
																
										</div>
										
									</div>	
									<div class="col-md-6">	
										<div class="input-group">
													<span class="input-group-addon" id="basic-addon1">To</span>
													<input type="text" name="tglK" id="tglK" value="<?php echo empty($tglK)?date('Y-m-d'):$tglK;?>" required class="form-control date" placeholder="Date">
													<span class="input-group-btn">
															<button id="cari" class="btn btn-info"><i class="fa fa-search"></i></button>
													</span>
										</div>
									</div>
								</form>
						</div>
						<div class="col-md-12" style="margin-top:15px">
							<div class="table-responsive" id="listPengeluaran">
								
								<table id="dataPengeluaran" class="table table-striped dataPengeluaran">
									<thead>
									<tr>
										<th>No</th>
										<th>Date</th>
										<th>Kategori</th>
										<th>Nominal</th>
										<th>Keterangan</th>
										<th><i class="fa fa-gear"></i></th>
									</tr>
									</thead>
									<tbody>
										<?php $no=1;?>
										<?php $total=0;?>
										<?php foreach($data as $tp){;?>
										<?php $total = $total + $tp->nominal;?>
										<tr>
											<td><?php echo $no++;?></td>
											<td><?php echo $tp->date;?></td>
											<td>
												<?php 
													if($tp->kategori == '' or $tp->kategori == null or $tp->kategori == 'Lain-lain' or $tp->kategori == 'lain')
													{
														echo "Lain-lain";
													}else{
														echo $tp->kategori;
													}
												;?>
											</td>
											<td><?php echo number_format($tp->nominal);?></td>
											<td><?php echo $tp->ket;?></td>
											<td>
												<a href="#" class="btn btn-success btn-xs" onclick="edit('<?php echo $tp->idpengeluaran;?>','<?php echo $tp->date;?>','<?php echo $tp->kategori;?>','<?php echo $tp->nominal;?>','<?php echo $tp->ket;?>')"><i class="fa fa-pencil"></i></a>
												<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php echo $tp->idpengeluaran;?>')"><i class="fa fa-trash-o"></i></a>
											</td>
											
										</tr>
										<?php };?>
									</tbody>
									<tfoot>
										<tr>
											<td colspan="3"><b>Total Pengeluaran</b></td>
											<td align="center"><?php echo number_format($total);?>
											<td></td>
											<td></td>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	

</div>









<script type="text/javascript">


//mask harga
$('.angka').mask('000,000,000,000,000,000,000', {
            reverse: true,
            translation: { 
                '0': {
                    pattern: /-|\d/,
                    recursive: true
                }
            },
onChange: function(value, e) {
    e.target.value = value.replace(/^-\./, '-').replace(/^-,/, '-').replace(/(?!^)-/g, '');
    }
});


$(".dataPengeluaran").DataTable();


$('#addPengeluaran').click(function(e){
	
	e.preventDefault();
	$('#modal').modal('show');
	$('#formaddPengeluaran')[0].reset();
			
	
})


$('#simpanaddPengeluaran').click(function(e){
	
	e.preventDefault();
	if(confirm('Apa Ingin Mencatat Pengeluaran?'))
	{
		
		if($("#date").val() == '' )
		{
			alert('Harap Pilih Date');
			$("#date").focus();
		}
		else if($("#nominal").val() =='' )
		{
			alert('Masukan Jumlah Nominal');
			$("#nominal").focus();
		}
		else if($("#ket").val() =='' )
		{
			alert('Masukan Keterangan');
			$("#ket").focus();
		}
		else
		{
			tglP = $("#tglP").val();
			tglK = $("#tglK").val();
			$.ajax({
					
					url		: "<?php echo base_url('admin/Pengeluaran/simpanPengeluaran');?>",
					type	: "POST",
					dataType: "json",
					data 	: $('#formaddPengeluaran').serialize(),
					success	: function(data){	
								if(data.status == true)
								{
									$("#info").fadeIn('slow');
									$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
									$("#info").fadeOut('slow');
									$('#listPengeluaran').load("<?php echo base_url('admin/Pengeluaran/ajax_listPengeluaran/');?>"+tglP+"/"+tglK);
									$("#formaddPengeluaran")[0].reset();
									
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

$(".date" ).datepicker({
		  dateFormat:"yy-mm-dd"
})


function edit(id,date,kategori,nominal,ket){

$("#id").val(id);
$("#date").val(date);
$("#kategori").val(kategori);		
$("#nominal").val(formatUang(nominal));		
$("#ket").val(ket);		
$("#updatePengeluaran").show();
$("#simpanaddPengeluaran").hide();
		
}

$('#updatePengeluaran').click(function(e){
	e.preventDefault();
	if(confirm('Apa Ingin Merubah Pengeluaran?'))
	{
		
		if($("#date").val() == '' )
		{
			alert('Harap Pilih Date');
			$("#date").focus();
		}
		else if($("#nominal").val() =='' )
		{
			alert('Masukan Jumlah Nominal');
			$("#nominal").focus();
		}
		else if($("#ket").val() =='' )
		{
			alert('Masukan Keterangan');
			$("#ket").focus();
		}
		else
		{
		
			tglP = $("#tglP").val();
			tglK = $("#tglK").val();
			$.ajax({
					
					url		: "<?php echo base_url('admin/Pengeluaran/updatePengeluaran');?>",
					type	: "POST",
					dataType: "json",
					data 	: $('#formaddPengeluaran').serialize(),
					success	: function(data){	
								if(data.status == true)
								{
									$("#info").fadeIn('slow');
									$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
									$("#info").fadeOut('slow');
									$('#listPengeluaran').load("<?php echo base_url('admin/Pengeluaran/ajax_listPengeluaran/');?>"+tglP+"/"+tglK);
									$("#formaddPengeluaran")[0].reset();
									$("#simpanaddPengeluaran").show();
									$("#updatePengeluaran").hide();
									
									
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




$("#cari").click(function(e){
	e.preventDefault();
	
	var tglP = $("#tglP").val();
	var tglK = $("#tglK").val();
	var idpelanggan = $("#idpelanggan").val();
	
	if(tglP == '')
	{
		alert('Tanggal From Tidak Boleh Kosong');
	}
	else if(tglK == '')
	{
		alert('Tanggal To Tidak Boleh Kosong');
	}
	else if(tglP > tglK)
	{
		alert('Tanggal TO lebih besar dari Form');
	}
	else
	{
				$.ajax({
					
						url		: '<?php echo base_url('admin/Pengeluaran/index');?>',
						type	: "POST",
						data 	: $("#formCari").serialize(),
						dataType: "html",
						
						beforeSend: function()
								{
									$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
									$(".preloader").show();
								},
						
						success	: function(data){	
									
									$("#content").html(data);
									
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


function hapus(id){
		
		if(confirm('Apa Anda Yakin Ingin Menghapus Pengeluaran?')){
		
			$.ajax({
							
								url		: '<?php echo base_url('admin/Pengeluaran/hapus');?>',
								type	: "POST",
								data 	: {idpengeluaran:id},
								dataType: "JSON",
								
								beforeSend: function()
										{
											$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
											$(".preloader").show();
										},
								
								success	: function(data){	
											if(data.status == true){	
												alert(data.ket);
												
												$("#content").load("<?php echo base_url('admin/Pengeluaran/index');?>");
											}
											if(data.status == false){	
												alert(data.ket);
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
										
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-denger' align='center'> Gagal Dihapus </div></div>")
										$("#info").fadeOut('slow');
									
									
									},

							
						
						
						
							})
					
		}	
		
	}


	$("#cari").click(function(e){
	e.preventDefault();
	
	var tglP = $("#tglP").val();
	var tglK = $("#tglK").val();
	var idpelanggan = $("#idpelanggan").val();
	
	if(tglP == '')
	{
		alert('Tanggal From Tidak Boleh Kosong');
	}
	else if(tglK == '')
	{
		alert('Tanggal To Tidak Boleh Kosong');
	}
	else if(tglP > tglK)
	{
		alert('Tanggal TO lebih besar dari Form');
	}
	else
	{
				$.ajax({
					
						url		: '<?php echo base_url('admin/Pengeluaran/index');?>',
						type	: "POST",
						data 	: $("#formCari").serialize(),
						dataType: "html",
						
						beforeSend: function()
								{
									$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
									$(".preloader").show();
								},
						
						success	: function(data){	
									
									$("#content").html(data);
									
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