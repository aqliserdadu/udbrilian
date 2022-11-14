<table id="barang" class="table table-striped">
							<thead>
							<tr>
								<th>No</th>
								<th>Kode</th>
								<th>Kategori</th>
								<th>Nama</th>
								<th>Harga Beli</th>
								<th>Harga Jual</th>
								<th>Satuan</th>
								<th>Status</th>
								<th>Opsi</th>
								
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
	"order"			: [2,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('admin/Barang/dtBarang');?>',
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
							"data" : "barcodebarang",
							"sClass": "text-left",
						},
						
						{
							"data" : "kategori",
							"sClass": "text-left",
						},
						{
							"data" : "namabarang",
							"sClass": "text-left",
						},
						{
							"data" : "hargabelibarang", render: $.fn.dataTable.render.number(',','.','','Rp. '),
							"sClass": "text-left",
							"searchable" : false,
						},
						{
							"data" : "hargajualbarang", render: $.fn.dataTable.render.number(',','.','','Rp. '),
							"sClass": "text-left",
							"searchable" : false,
						},
						{
							"data" : "namasatuan",
							"sClass": "text-center",
						},
						{
							"data" : "statusbarang",
							"sClass": "text-center",
						},
						
						{
							"data" : "opsi",
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




$('#barang').on('click','.edit',function(){
			
			$('#simpan').hide();
			$('#update').show();
			
			
			var idmasterbarang=$(this).data('idmasterbarang');
			var idbarang=$(this).data('idbarang');
			var namabarang=$(this).data('nama');
            var satuan=$(this).data('satuan').split(" ").join("-"); //ubah menjadi spasi ganti jadi-
            var beli=$(this).data('beli');
            var jual=$(this).data('jual');
            var status=$(this).data('status');
            var barcode=$(this).data('barcode');
			
			if(status == 'On')
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On' selected>ON</option><option value='Off'>OFF</option>"; 
			}
			else if(status == 'Off')
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On'>ON</option><option value='Off' selected>OFF</option>"; 
			}
			else
			{
				var op = "<option disabled selected>---Pilih---</option><option value='On'>ON</option><option value='Off'>OFF</option>"
			}
            
			$('#idmasterbarang').val(idmasterbarang);
			$('#idbarang').val(idbarang);
			$('#namabarang').val(namabarang);
			$('#label').html('Update Barang');
			$('#satuanbarang').load("<?php echo base_url('admin/Barang/ajax_satuan/');?>"+satuan);
			$('#hargabeli').val(formatUang(beli));
			$('#hargajual').val(formatUang(jual));
			$('#status').html(op);
			$('#kodebarang').val(barcode);
			$('#modal').modal('show');
			
})





$('#barang').on('click','.hapus',function(){
			
		var id = $(this).data('idmasterbarang');	
	if(confirm('Apa Ingin Menghapusan Master Barang?'))
	{
		
		
						$.ajax({
								
								url		: "<?php echo base_url('admin/Barang/deleteBarang');?>",
								type	: "POST",
								dataType: "json",
								data 	: {idmasterbarang:id},
								success	: function(data){	
											if(data.status == true)
											{
												$("#infoD").fadeIn('slow');
												$("#infoD").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Dihapuskan </div></div>")
												$("#infoD").fadeOut('slow');
												$('#dataBarang').load("<?php echo base_url('admin/Barang/ajax_dtbarang');?>");
												
											
																
											}
										else
											{
												$("#infoD").fadeIn('slow');
												$("#infoD").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak dapat dihapus </div></div>")
											}	
											
											
											
										},
								error	: function(data){
											
											$("#infoD").fadeIn('slow');
											$("#infoD").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Perubahan Gagal Diperbaharui </div></div>")
											$("#infoD").fadeOut('slow');
										
										},
								
							
							
							
						})
					
		
	
		
		
	}
			
})







</script>