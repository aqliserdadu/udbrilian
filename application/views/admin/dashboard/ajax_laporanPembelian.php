<style>
table tfoot  {
    display: table-row-group;
}


</style>


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
									<?php if($jenis == 'rinci'){;?>	
									<th>Date</th>
									<?php };?>
									<?php if(empty($user) && $jenis == 'rinci'){;?>	
									<th>User</th>
									<?php };?>
									<th>Suplayer</th>
									<?php if($jenis == 'rekap'){;?>	
									<th>Total Pembelian</th>
									<?php };?>
									<th>Total Barang</th>
									<th>Total M3</th>
									<th>Total Harga</th>
									<?php if($jenis == 'rinci'){;?>	
									<th style="width:50px"><i class="fa fa-gear"></i></th>
									<?php };?>
								</tr>
								</thead>
								<tbody>
								<?php $no =1;?>
								<?php $totalqty =0;?>
								<?php $totalm3 =0;?>
								<?php $totalharga =0;?>
								<?php $totalpembelian=0;?>
								<?php foreach($data as $tp){;?>
								<?php $totalpembelian = $totalpembelian + $tp->jumlah;?>
								<?php $totalqty = $totalqty + $tp->totalqty;?>
								<?php $totalm3 = $totalm3 + $tp->totalm3;?>
								<?php $totalharga = $totalharga + $tp->totalharga;?>
								
									<tr>
										<td><?php echo $no++;?></td>
										<?php if($jenis == 'rinci'){;?>	
										<td><?php echo $tp->date;?></td>
										<?php };?>
										<?php if(empty($user) && $jenis == 'rinci'){;?>	
										<td><?php echo $tp->username;?></td>
										<?};?>
										<td><?php echo $tp->namasuplayer." ".$tp->alamatsuplayer;?></td>
										<?php if($jenis == 'rekap'){;?>	
										<td><?php echo $tp->jumlah;?></td>
										<?php };?>
										<td><?php echo $tp->totalqty;?></td>
										<td><?php echo round($tp->totalm3,5);?></td>
										<td><?php echo number_format($tp->totalharga);?></td>
										<?php if($jenis == 'rinci'){;?>	
										<td>
											<a href="#" class="btn btn-info btn-xs" onclick="detail('<?php echo $tp->idheader;?>')"><i class="fa fa-book"></i></a>
										<!--	<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php // echo $tp->idheader;?>')"><i class="fa fa-trash-o"></i></a> -->
										</td>
										<?php };?>
									</tr>
								<?php };?>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<?php if($jenis == 'rinci'){;?>	
										<td></td>
										<?php };?>
										<?php if(empty($user) && $jenis == 'rinci'){;?>	
										<td></td>
										<?php };?>
										<td><b>Total</b></td>
										<?php if($jenis == 'rekap'){;?>	
										<td align="center"><b><?php echo $totalpembelian;?></b></td>
										<?php };?>
										<td align="center"><b><?php echo $totalqty;?></b></td>
										<td align="center"><b><?php echo $totalm3;?></b></td>
										<td align="center"><b><?php echo number_format($totalharga);?></b></td>
										<?php if($jenis == 'rinci'){;?>	
										<td></td>
										<?php };?>
										
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>
	
<script type="text/javascript">

$('.tablePembelian').DataTable({
"searching" : false,
"info" : false,
"bPaginate": false,
 
 dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: '<?php echo $titlel;?> '+ $('#tglP').val()+' s/d '+$('#tglK').val(),
			},
			{
				extend: 'print',
				title : '',
				footer : true,
				messageTop : '<?php echo $titlel;?> '+ $('#tglP').val()+' s/d '+$('#tglK').val(),
                exportOptions: {
                    columns: ':visible'
                },
				
            },
            'colvis'
        ],
        columnDefs: [ {
            targets: 0,
            visible: true,
        } ]


});



function detail(notaPembelian){
		$("#listPembelian").load("<?php echo base_url('admin/Dashboard/laporanDetailPembelian/');?>"+notaPembelian);
	}
</script>