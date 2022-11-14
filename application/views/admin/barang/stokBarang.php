
	<section class="content-header" style="background-color:white; padding-bottom:6px">
      <h1>
      Stok Barang
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("admin/Dashboard/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Stok Barang</li>
      </ol>
    </section>


 <div class="content">
	

	

	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-body">
					
					<div class="table-responsive" id="dataBarang">
						
						<table id="barang" class="table table-striped" style="margin-top:15px">
							<thead>
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>T</th>
								<th>L</th>
								<th>P</th>
								<th>Stock</th>
								<th>M3</th>
								<th>Nominal</th>
								<th>Total</th>
							</tr>
							</thead>
							<tbody>
							<?php 
							$no = 1;
							$totalm3 =0;
							$totalqty=0;
							$totalharga=0;
							foreach($data as $tp){
								$totalm3 = $totalm3 + (($tp['t']*$tp['l']*$tp['p']*$tp['qty'])/1000000);
								$totalqty = $totalqty + $tp['qty'];
								$totalharga = $totalharga + ($tp['harga'] * $tp['qty']);
							?>
								<tr>
									<td><?php echo $no++ ;?></td>
									<td><?php echo $tp['idbarang'];?></td>
									<td><?php echo $tp['t'];?></td>
									<td><?php echo $tp['l'];?></td>
									<td><?php echo $tp['p'];?></td>
									<td><?php echo $tp['qty'];?></td>
									<td><?php echo round(($tp['t']*$tp['l']*$tp['p']*$tp['qty'])/1000000,5) ;?></td>
									<td><?php echo number_format($tp['harga'],2);?></td>
									<td><?php echo number_format($tp['total'],2);?></td>
									
								</tr>
							<?php };?>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td></td>
									<td align="center"><b>Total</b></td>
									<td></td>
									<td></td>
									<td align="center"><b><?php echo $totalqty;?></b></td>
									<td align="center"><b><?php echo round($totalm3,5) ;?></b></td>
									<td></td>
									<td align="center"><b><?php echo number_format($totalharga,2);?></b></td>
									
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
const date = new Date();
var tgl = date.getDate().toString()+"-" +date.getMonth().toString()+"-"+date.getFullYear().toString();



$("#barang").DataTable({
"searching" : true,
"info" : false,
"bPaginate": false,
 	
 dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Laporan Stock Barang '+tgl,
			},
			{
				extend: 'print',
				title : '',
				messageTop: 'Laporan Stock Barang '+tgl,
				footer :true,
                exportOptions: {
                    columns: ':visible'
                },
				
				
            },
            'colvis'
        ],
        columnDefs: [ {
            visible: false
        } ],

	
	
});



</script>