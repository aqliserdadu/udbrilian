<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Laporan Penjualan Barang
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/Pembelian/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Barang</li>
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
						
					</div>	
					<div class="col-md-6">	
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">To</span>
									<input type="text" name="tglK" id="tglK" required class="form-control" placeholder="Date">
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
	
	<div class="row" id="listBarang">
		<div class="col-md-12">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<p> Priode : <?php echo (empty($tglP)? date('Y-m-').'01':$tglP). " s/d ". (empty($tglK)? date('Y-m-d'):$tglK);?></p>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered">
												<thead>
												<tr>
													<th>No</th>
													<th>T</th>
													<th>L</th>
													<th>P</th>
													<th>Qty</th>
													<th>M3</th>
													<th>Modal</th>
													<th>Jual</th>
													<th>Laba</th>
												</tr>
												</thead>
												<tbody>
											<?php 
											$no = 1;
											$jmTotal = 0;
											$jmTotalHarga=0;
											$totalLaba=0;
											$totalModal=0;
											$totalJual=0;
											$totalm3 =0;
											foreach($data as $p){;?>
											<?php $jmTotal = $jmTotal + $p->totalpcs;?>
											<?php $jmTotalHarga = $jmTotalHarga + $p->totalharga;?>
											<?php $totalLaba = $totalLaba + $p->laba;?>
											<?php $totalModal = $totalModal + ($p->hargamodal * $p->totalpcs) ;?>
											<?php $totalm3 = $totalm3 + (($p->t*$p->l*$p->p*$p->totalpcs)/1000000) ;?>
											
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $p->t;?></td>
													<td><?php echo $p->l;?></td>
													<td><?php echo $p->p;?></td>
													<td><?php echo $p->totalpcs;?></td>
													<td><?php echo (($p->t*$p->l*$p->p*$p->totalpcs)/1000000);?></td>
													<td><?php echo number_format($p->hargamodal);?></td>
													<td><?php echo number_format($p->totalharga);?></td>
													<td><?php echo number_format($p->laba);?></td>
												</tr>
											<?php };?>
												</tbody>
												<tfoot>
													<tr style="text-align:center">
														<td></td>
														<td></td>
														<td><b>Total</b></td>
														<td></td>
														<td><b><?php echo $jmTotal;?></b></td>
														<td><b><?php echo $totalm3;?></b></td>
														<td><b><?php echo number_format($totalModal);?></b></td>
														<td><b><?php echo number_format($jmTotalHarga);?></b></td>
														<td><b><?php echo number_format($totalLaba);?></b></td>
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

const date = new Date();

if($("#tglP").val() =="" | $("#tglK").val() ==""){
	var tgl = date.getDate().toString()+"-" +date.getMonth().toString()+"-"+date.getFullYear().toString();
}else{
	var tgl = $('#tglP').val()+' s/d '+$('#tglK').val();
}
	
	
$('.table').DataTable({


	
	
//"scrollY": "500px",
"searching" : false,
"info" : false,
"bPaginate": false,


dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Laporan Penjualan Barang '+tgl,
			},
			{
				extend: 'print',
				title : '',
				messageTop: 'Laporan Penjualan Barang '+tgl,
				footer :true,
				exportOptions: {
                    columns: ':visible'
                }
            },
            'colvis'
        ],
        columnDefs: [ {
            targets: 0,
            visible: true
        } ]




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
					
						url		: '<?php echo base_url('admin/Dashboard/laporanBarang');?>',
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
