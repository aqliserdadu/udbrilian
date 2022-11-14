<div class="table-responsive">
										<table id="produkS" class="table table-hover table-striped" style="cursor:pointer">
											<thead>
											<tr>
												<th>No</th>
												<th>Nama Barang</th>
											</tr>
											</thead>
											
											<tbody>
											<?php 
											$no = 1;
											foreach($data as $tp){;?>
												<tr onclick="pilih('<?php echo $tp->id;?>','<?php echo $tp->namabarang;?>')">
													<td><?php echo $no++;?></td>
													<td><?php echo $tp->namabarang;?></td>
												</tr>
											<?php };?>
											</tbody>
										</table>
									
</div>


<script type="text/javascript">

$("#produkS").DataTable({
"searching" : true,
"info" : true,
"bPaginate": false,



});


function pilih(id,namabarang){
	
	$("#idbarang").val(id);
	$("#namabarang").val(namabarang);
	$("#modalDaftar").modal('hide');
	
	
};


</script>