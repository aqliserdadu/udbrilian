<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Laporan Transaksi
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/Pembelian/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Transaksi</li>
      </ol>
</section>

<div class="content">

	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
				<div class="row">	
				<form action="#" method="post" id="formCari">
					<div class="col-md-6">	
					
						
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">From</span>
									<input type="text" name="tglP" id="tglP" required class="form-control" placeholder="yy-mm-dd">
												
						</div>
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">To</span>
									<input type="text" name="tglK" id="tglK" required class="form-control" placeholder="yy-mm-dd">
									
						</div>
						
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Pelanggan</span>
									<input type="hidden" name="idpelanggan" id="idpelanggan" class="form-control" placeholder="Pelanggan">
									<input type="text" name="pelanggan" id="pelanggan" class="form-control" placeholder="Pelanggan">
						</div>
						
						
					</div>	
					<div class="col-md-6">	
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Nama Barang</span>
									<input type="hidden" name="idbarang" id="idbarang" class="form-control" placeholder="Nama Barang">
									<input type="text" name="namabarang" id="namabarang" class="form-control" placeholder="Nama Barang">
								
									
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Metode</span>
							<select name="metode" id="metode" class="form-control">
								<option value="" disabled selected>---Pilih Metode---</option>
								<option value=" ">Semua</option>
								<option value="tempo">Tempo</option>
								<option value="tunai">Tunai</option>
							</select>
						</div>
						
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Status</span>
							<select name="status" id="status" class="form-control">
								<option value="" disabled selected>---Pilih Status---</option>
								<option value=" ">Semua</option>
								<option value="Lunas">Lunas</option>
								<option value="Nunggak">Nunggak</option>
							</select>
							
						</div>
						
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Username</span>
									<select name="iduser" id="iduser" class="form-control">
										<option value=" ">Semua</option>
										<?php foreach($user as $u){;?>
											<option value="<?php echo $u->iduser;?>"><?php echo $u->username;?></option>
										<?php };?>
									</select>
							<span class="input-group-btn">
									<button id="cari" class="btn btn-info"><i class="fa fa-search"></i></button>
							</span>
											
						</div>
					</div>
				</form>
				</div>
					
					
				
				</div>
			</div>
		</div>
	</div>
	
	<div class="row" id="listTransaksi">
		<div class="col-md-7">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-borderd tablePembelian">
								<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>Nama Pelanggan</th>
									<th>Jml Transaksi</th>
									<th>Total Transaksi</th>
									
								</tr>
								</thead>
								<tbody>
								
								</tbody>
								<tfoot>
									<tr>
										<td colspan="3"><b>Total</b></td>
										<td><b>0</b></td>
										<td><b>0</b></td>
										</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	
		<div class="col-md-5">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table  class="table table-striped table-borderd tablePembelian">
								<thead>
								<tr>
									<th>No</th>
									<th>ID Barang</th>
									<th>Nama Barang</th>
									<th>Qty</th>
									
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
	
	</div>
</div>


<script type="text/javascript">

$('.tablePembelian').DataTable({
"scrollY": "300px",
"searching" : false,
"info" : false,
"bPaginate": false,
});

$( function() {
    var dateFormat = "yy-mm-dd",
      from = $( "#tglP" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1,
		  dateFormat:"yy-mm-dd"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#tglK" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1,
		 dateFormat:"yy-mm-dd"
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
 return date;
    }
  } );    



$('#namabarang').autocomplete({
                source: "<?php echo base_url('admin/Dashboard/getBarangAuto');?>",
				autoFocus:true,
				minLength:3,
                select: function (event, ui) {
                    $(this).val(ui.item.label); 
                    $("#idbarang").val(ui.item.idbarang); 
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
				return $( "<li>" )
				.append( "<div>" + item.label +"</div>" )
				.appendTo( ul );
}

$('#pelanggan').autocomplete({
                source: "<?php echo base_url('admin/Pelanggan/getPelangganAuto');?>",
				autoFocus:true,
				minLength:3,
                select: function (event, ui) {
                    $(this).val(ui.item.label); 
                    $("#idpelanggan").val(ui.item.idpelanggan); 
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
				return $( "<li>" )
				.append( "<div>" + item.label +"</div>" )
				.appendTo( ul );
}







$("#cari").click(function(e){
	e.preventDefault();
	
	var tglP = $("#tglP").val();
	var tglK = $("#tglK").val();
	var metode = $("#metode").val();
	var status = $("#status").val();
	
	if($("#pelanggan").val() == '')
	{
		$("#idpelanggan").val('');
	}
	
	if(tglP == '')
	{
		alert('Tidak Boleh Kosong');
	}
	else if(tglK == '')
	{
		alert('Tidak Boleh Kosong');
	}
	else if(tglP > tglK)
	{
		alert('Tanggal TO lebih besar dari Form');
	}
	else if(metode == null)
	{
		alert('Harap Pilih Metode');
	}
	else if(status == null)
	{
		alert('Harap Pilih Status');
	}
	else
	{
				$.ajax({
					
						url		: '<?php echo base_url('admin/Dashboard/ajax_laporanTransaksi');?>',
						type	: "POST",
						data 	: $("#formCari").serialize(),
						dataType: "html",
						
						beforeSend: function()
								{
									$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
									$(".preloader").show();
								},
						
						success	: function(data){	
									
									$("#listTransaksi").html(data);
									
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
