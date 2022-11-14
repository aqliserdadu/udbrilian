<table id="dataHutang" class="table dataHutang table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Nama Pelanggan</th>
								<th>Total Piutang</th>
							</tr>
							</thead>
							<tbody>
								<?php $no=1;?>
								<?php foreach($data as $tp){;?>
								<tr>
									<td><?php echo $no++;?></td>
									<td><?php echo $tp->namapelanggan." ".$tp->alamatpelanggan;?></td>
									<td><?php echo number_format($tp->sisahutang);?></td>
								</tr>
								<?php };?>
							</tbody>
</table>

<script>

$(".dataHutang").DataTable({
	
	
dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Daftar Piutang',
			},
			{
				extend: 'print',
				title:'Daftar Piutang',
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
</script>
