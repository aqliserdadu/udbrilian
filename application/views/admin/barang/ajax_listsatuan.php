<table id="tableSatuan" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Nama Satuan</th>
								<th>QPcs</th>
								<th>MQPcs</th>
								<th>Action</th>
								
							</tr>
							</thead>
							
							<tbody>
							<?php $no = 1;?>
							<?php foreach($satuan as $st){;?>
							<tr>
								<td><?php echo $no++;?></td>
								<td><?php echo $st->namasatuan;?></td>
								<td><?php echo $st->qsatuan;?></td>
								<td><?php echo $st->minqpcs;?></td>
								<td><a href="#" class="btn btn-info btn-xs" onclick="editSatuan('<?php echo $st->idsatuan;?>','<?php echo $st->namasatuan;?>','<?php echo $st->qsatuan;?>','<?php echo $st->minqpcs;?>')"><i class="fa fa-pencil"></i></a></td>
							</tr>
							<?php }?>
							</tbody>
</table>

<script>

$('#tableSatuan').DataTable({

});
</script>