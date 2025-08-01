<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Laporan Pembelian
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/Pembelian/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pembelian</li>
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
									<input type="text" name="tglP" id="tglP" required class="form-control" placeholder="Date">
												
						</div>
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">To</span>
									<input type="text" name="tglK" id="tglK" required class="form-control" placeholder="Date">
									
						</div>
						
						
					</div>	
					<div class="col-md-6">	
					
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Username</span>
							<select name="iduser" id="iduser" class="form-control">
								
										<option value=" ">Semua</option>
										<?php foreach($user as $u){;?>
										<option value="<?php echo $u->iduser;?>"><?php echo $u->username;?></option>
										<?php };?>
							</select>
									
							
						</div>
					
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Suplayer</span>
							<input type="hidden" name="idsuplayer" id="idsuplayer" required class="form-control">
							<input type="text" name="namasuplayer" id="namasuplayer" required class="form-control" placeholder="Suplayer">
							
						</div>
						<div class="input-group">
							<span class="input-group-addon" id="basic-addon1">Jenis</span>
							<select name="jenis" class="form-control">
								<option value="rinci">Rinci</option>
								<option value="rekap">Rekap</option>
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
	
	<div class="row" id="listPembelian">
		<div class="col-md-12">	
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
									<th>User</th>
									<th>Suplayer</th>
									<th>Total Barang</th>
									<th>Total M3</th>
									<th>Total Harga</th>
									<th><i class="fa fa-gear"></i></th>
									
								</tr>
								</thead>
								<tbody>
								
								</tbody>
								<tfoot>
									<tr>
										<td colspan="4"><b>Total Pembelian</b></td>
										<td align="center"><b><?php echo "Rp. 0";?></b></td>
										<td align="center"><b><?php echo "Rp. 0";?></b></td>
										<td align="center"><b><?php echo "Rp. 0";?></b></td>
										<td align="center"></td>
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
          defaultDate: "+1d",
          changeMonth: true,
          numberOfMonths: 1,
		  dateFormat:"yy-mm-dd"
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#tglK" ).datepicker({
        defaultDate: "+1d",
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


$('#namasuplayer').autocomplete({
                source: "<?php echo base_url('admin/Suplayer/getSuplayerAuto');?>",
				autoFocus:true,
				minLength:2,
                select: function (event, ui) {
					$(this).val(ui.item.label); 
					
					if(ui.item.idsuplayer == 'Sup001')
					{
						$('#idsuplayer').val(' '); 
					}else{
						$('#idsuplayer').val(ui.item.idsuplayer);
					}
						
					
                }
            }).autocomplete( "instance" )._renderItem = function( ul, item ) {
				return $( "<li>" )
				.append( "<div>" + item.label + "<br>" + item.alamat+"</div>" )
				.appendTo( ul );
}



$("#cari").click(function(e){
	e.preventDefault();
	
	var tglP = $("#tglP").val();
	var tglK = $("#tglK").val();
	var idsuplayer = $("#idsuplayer").val();
	
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
	else if(idsuplayer == null)
	{
		alert('Harap Pilih Suplayer');
	}
	else
	{
				$.ajax({
					
						url		: '<?php echo base_url('admin/Dashboard/ajax_laporanPembelian');?>',
						type	: "POST",
						data 	: $("#formCari").serialize(),
						dataType: "html",
						
						beforeSend: function()
								{
									$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
									$(".preloader").show();
								},
						
						success	: function(data){	
									
									$("#listPembelian").html(data);
									
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
