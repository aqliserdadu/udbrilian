<table id="tableS" class="table table-striped">
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
							<?php foreach($sup as $s){;?>
							<tr>
								<td><?php echo $n++;?></td>
								<td><?php echo $s->idsuplayer;?></td>
								<td><?php echo $s->namasuplayer;?></td>
								<td><?php echo $s->alamatsuplayer;?></td>
								<td><?php echo $s->wasuplayer;?></td>
								<td><?php echo $s->statussuplayer;?></td>
								<td><a href="#" class="btn btn-info btn-xs" onclick="editSup('<?php echo $s->idsuplayer;?>','<?php echo $s->namasuplayer;?>','<?php echo $s->wasuplayer;?>','<?php echo $s->statussuplayer;?>')"><i class="fa fa-pencil"></i></a></td>
							</tr>
							<?php }?>
							</tbody>
</table>
<script>

$('#tableS').DataTable({
	dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Daftar Suplayer',
			},
			{
				extend: 'print',
				title : 'Daftar SUplayer',
				messageTop: '',
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