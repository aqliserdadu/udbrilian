<table id="dataPiutang" class="table dataPiutang table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Nama Suplayer</th>
								<th>Total Hutang</th>
							</tr>
							</thead>
							<tbody>
								<?php $no=1;?>
								<?php foreach($data as $tp){;?>
								<tr>
									<td><?php echo $no++;?></td>
									<td><?php echo $tp->namasuplayer." ".$tp->alamatsuplayer;?></td>
									<td><?php echo number_format($tp->sisahutang);?></td>
								</tr>
								<?php };?>
							</tbody>
</table>

<script>
$(".dataPiutang").DataTable({
	
		
dom: 'Bfrtip',
        buttons: [
            {
                text:'Save To Excel',
				extend: 'excelHtml5',
				footer: true,
                title: 'Daftar Hutang',
			},
			{
				extend: 'print',
				title: 'Daftar Hutang',
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
