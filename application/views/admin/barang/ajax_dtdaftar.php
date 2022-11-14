<table id="barang" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Kode Barang</th>
								<th>Tinggi</th>
								<th>Lebar</th>
								<th>Panjang</th>
								<th>Action</th>
							</tr>
							</thead>
							
							<tbody>
							
							</tbody>
</table>
						


<script type="text/javascript">





// Setup datatables
$.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings)
      {
          return {
              "iStart": oSettings._iDisplayStart,
              "iEnd": oSettings.fnDisplayEnd(),
              "iLength": oSettings._iDisplayLength,
              "iTotal": oSettings.fnRecordsTotal(),
              "iFilteredTotal": oSettings.fnRecordsDisplay(),
              "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
              "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
          };
      };


$("#barang").DataTable({
	"processing"	: true,
	"serverSide"	:true,
	"order"			: [1,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('admin/Barang/dtDaftar');?>',
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
							"data" : "idbarang",
							"sClass": "text-center",
						},
						
						{
							"data" : "t",
							"sClass": "text-left",
						},
						
						{
							"data" : "l",
							"sClass": "text-left",
						},

						{
							"data" : "p",
							"sClass": "text-left",
						},
						
						{
							"data" : "hapus",
							"orderable": false,
							"sClass": "text-center",
							'searchable': false,
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


$('#barang').on('click','.hapus',function(){
	
	var id=$(this).data('id');
   
	if(confirm('Apa Ingin Menghapus Kode Barang?'))
	{    

		$.ajax({
						
						url		: "<?php echo base_url('admin/Barang/hapusDaftar');?>",
						type	: "POST",
						dataType: "json",
						data 	: {'idbarang':id},
						success	: function(data){	
									if(data.status == true)
									{
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Berhasil Di Hapus </div></div>")
										$("#info").fadeOut('slow');
										$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtDaftar');?>");
										
										$('#formBarang')[0].reset();
									
									
														
									}
								else
									{
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak Boleh Kosong </div></div>")
										$("#info").fadeOut('slow');
									}	
									
									
									
								},
						error	: function(data){
									
									$("#info").fadeIn('slow');
									$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal Dalam Menyimpan </div></div>")
									$("#info").fadeOut('slow');
								
								},
						
				
				
				
					})
		


	} 
			
})




</script>