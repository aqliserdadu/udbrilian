<table id="tablest" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>ID</th>
								<th>Nama</th>
								<th>Alamat</th>
								<th>Whatsapp</th>
								<th>Status</th>
								<th>Opsi</th>
								
							</tr>
							</thead>
							
							<tbody>
							<?php $n = 1;?>
							<?php foreach($pelanggan as $s){;?>
							<tr>
								<td><?php echo $n++;?></td>
								<td><?php echo $s->idpelanggan;?></td>
								<td><?php echo $s->namapelanggan;?></td>
								<td><?php echo $s->alamatpelanggan;?></td>
								<td><?php echo $s->wapelanggan;?></td>
								<td><?php echo $s->statuspelanggan;?></td>
								<td><a href="#" class="btn btn-info btn-xs" onclick="editSup('<?php echo $s->idpelanggan;?>','<?php echo $s->namapelanggan;?>','<?php echo $s->wapelanggan;?>','<?php echo $s->statuspelanggan;?>')"><i class="fa fa-pencil"></i></a></td>
							</tr>
							<?php }?>
							</tbody>
						</table>
<script>
$('#tablest').DataTable({

});
</script>