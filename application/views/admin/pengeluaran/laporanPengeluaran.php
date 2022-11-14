<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
       Laporan Pengeluaran
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/Pembelian/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Pengeluaran</li>
      </ol>
</section>

<div class="content">

	<div class="row">
		<div class="col-md-12">	
			<div class="box box-info">
				<div class="box-body">
				<div class="row">	
				<form action="#" method="post" id="formCari">
					<div class="col-md-4">	
					
						
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">From</span>
									<input type="text" name="tglP" id="tglP" value="<?php echo empty($tglP)?date('Y-m-')."01":$tglP;?>" required class="form-control" placeholder="Date">
												
						</div>
						
					</div>	
					<div class="col-md-4">	
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">To</span>
									<input type="text" name="tglK" id="tglK" value="<?php echo empty($tglK)?date('Y-m-d'):$tglK;?>" required class="form-control" placeholder="Date">
									
						</div>
					</div>
					<div class="col-md-4">	
						<div class="input-group">
									<span class="input-group-addon" id="basic-addon1">Jenis</span>
									<select name="jenis" id="jenis" class="form-control">
										<option value='rinci' <?php echo ($select == 'rinci')? 'selected':'';?>>Rinci</option>
										<option value='rekap' <?php echo ($select == 'rekap')? 'selected':'';?>>Rekap</option>
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
	
	<div class="row" id="listBarang">
		<div class="col-md-12">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<p> Priode : <?php echo (empty($tglP)? date('Y-m-').'01':$tglP). " s/d ". (empty($tglK)? date('Y-m-d'):$tglK);?></p>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered" style="margin-top:10px">
												<thead>
												<tr>
													<th>No</th>
													<th>Date</th>
													<th>Kategori</th>
													<th>Nominal</th>
													<?php echo ($select == 'rinci')?"<th>Keterangan</th>":'';?>
													
												</tr>
												</thead>
												<tbody>
											<?php 
											$no = 1;
											$total = 0;
											foreach($data as $p){;?>
											<?php $total = $total + $p->nominal;?>
											
												<tr>
													<td><?php echo $no++;?></td>
													<td><?php echo $p->date;?></td>
													<td>
														<?php 
															if($p->kategori == '' or $p->kategori == null or $p->kategori == 'Lain-lain' or $p->kategori == 'lain')
															{
																echo "Lain-lain";
															}else{
																echo $p->kategori;
															}
														;?>
													</td>
													<td><?php echo number_format($p->nominal);?></td>
													<?php echo ($select == 'rinci')? "<td>$p->ket</td>":'';?>
													
												</tr>
											<?php };?>
												</tbody>
												<tfoot>
													<tr style="text-align:center">
														<td></td>
														<td></td>
														<td><b>Total</b></td>
														<td><b><?php echo number_format($total);?></b></td>
														<?php echo ($select == 'rinci')?"<td></td>":'';?>
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

$('.table').DataTable({
"scrollY": "350px",
"searching" : false,
"info" : false,
"bPaginate": false,

	
dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Daftar Pengeluaran',
			},
			{
				extend: 'print',
				title:'Daftar Pengeluaran',
				footer:true,
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
					
						url		: '<?php echo base_url('admin/Pengeluaran/laporanPengeluaran');?>',
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
