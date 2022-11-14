<style>
table tfoot {
    display: table-row-group;
}
</style>


<div class="col-md-12">	
			<div style="background-color:white; margin-top:-15px">
				<div class="box-body">
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive">
							<table class="table table-striped table-borderd tablePenjualan">
								<thead>
								<tr>
									<th>No</th>
									<th>Date</th>
									<th>User</th>
									<th>Custamer</th>
									<th>Total Barang</th>
									<th>Total M3</th>
									<th>Total Harga</th>
									<th>Laba</th>
									<th><i class="fa fa-gear"></i></th>
									
								</tr>
								</thead>
								<tbody>
								<?php $no =1;?>
								<?php $totalqty=0;?>
								<?php $totalm3=0;?>
								<?php $totalharga=0;?>
								<?php $totallaba=0;?>
								<?php foreach($data as $tp){;?>
								<?php $totalqty = $totalqty + $tp->totalqty;?>
								<?php $totalm3 = $totalm3 + $tp->totalm3;?>
								<?php $totalharga = $totalharga + $tp->totalharga;?>
								<?php $totallaba = $totallaba + $tp->laba;?>
									<tr>
										<td><?php echo $no++;?></td>
										<td><?php echo $tp->date;?></td>
										<td><?php echo $tp->username;?></td>
										<td><?php echo $tp->namapelanggan." ".$tp->alamatpelanggan;?></td>
										<td><?php echo $tp->totalqty;?></td>
										<td><?php echo round($tp->totalm3,5);?></td>
										<td><?php echo number_format($tp->totalharga);?></td>
										<td><?php echo number_format($tp->laba);?></td>
										<td>
											<a href="#" class="btn btn-info btn-xs" onclick="detail('<?php echo $tp->idheader;?>')"><i class="fa fa-book"></i></a>
										<!--	<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php // echo $tp->idheader;?>')"><i class="fa fa-trash-o"></i></a> -->
										</td>
									</tr>
								<?php };?>
								
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td></td>
										<td><b>Total Penjualan</b></td>
										<td></td>
										<td align="center"><b><?php echo $totalqty;?></b></td>
										<td align="center"><b><?php echo $totalm3;?></b></td>
										<td align="center"><b><?php echo number_format($totalharga);?></b></td>
										<td align="center"><b><?php echo number_format($totallaba);?></b></td>
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
	
	

<script type="text/javascript">

$('.tablePenjualan').DataTable({
//"scrollY": "350px",
//"scrollX": "auto",
"searching" : false,
"info" : true,
"bPaginate": false,

dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Laporan Penjualan '+ $('#tglP').val()+' s/d '+$('#tglK').val(),
			},
			{
				extend: 'print',
				title : '',
				messageTop: 'Laporan Penjualan '+ $('#tglP').val()+' s/d '+$('#tglK').val(),
                exportOptions: {
                    columns: ':visible'
                },
				footer:true,
            },
            'colvis'
        ],
        columnDefs: [ {
            targets: 0,
            visible: true
        } ]






});

function detail(notaPembelian){
		$("#listPenjualan").load("<?php echo base_url('admin/Dashboard/laporanDetailPenjualan/');?>"+notaPembelian);
	}
</script>