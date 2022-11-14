<table id="dataJust" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>User</th>
								<th>Nama</th>
								<th>Jumlah</th>
								<th>Satuan</th>
								<th>Just</th>
								<th>Jenis</th>
								<th>Keterangan</th>
								
							</tr>
							</thead>
							
							<tbody>
							
							</tbody>
</table>


<script type="text/javascript">

$("#dataJust").DataTable({
	"processing"	: true,
	"serverSide"	:true,
	"order"			: [1,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('admin/Barang/dtJust');?>',
						"type" : "POST",
					 },
	"pageLength"	: 10,
	"select"		: true,
	"columns"		:[
						
						{
							"data" : "no",
							"orderable": false,
							"searchable" : false,
							"sClass": "text-center",
						},
						
						{
							"data" : "date",
							"sClass": "text-center",
						},
						
						{
							"data" : "username",
							"sClass": "text-left",
						},
						
						{
							"data" : "namabarang",
							"sClass": "text-left",
						},
						
						{
							"data" : "qtyjust",
							"sClass": "text-center",
						},
						
						{
							"data" : "namasatuan",
							"sClass": "text-center",
						},
						
						{
							"data" : "just",
							"sClass": "text-center",
						},
						{
							"data" : "jenis",
							"sClass": "text-center",
						},
						
						{
							"data" : "ket",
							"sClass": "text-left",
						},
						
						
					 ],
	"rowCallback"	: function(row, data, iDisplayIndex) 
						{
							var info = this.fnPagingInfo();
							var page = info.iPage;
							var length = info.iLength;
							var index = page * length + (iDisplayIndex + 1);
							$('td:eq(0)', row).html(index);
						},
});
</script>