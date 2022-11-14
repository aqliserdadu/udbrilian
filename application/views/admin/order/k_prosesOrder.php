<section class="content-header">
      <h1>
      Kelola Pesanan
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li>Proses</li>
      </ol>
</section>


<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Proses</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
				<div class="box-body">
					<div class="row" id="pesan">
							<?php echo $this->session->flashdata('info');?>
					</div>
					
					<div class="row" style="margin-top:3px">
						<div class="col-md-12">
							<div class="table-responsive">
											<table id="order" class="table">
												<thead>
												<tr>
													<th>No</th>
													<th>Invoice</th>
													<th>Member</th>
													<th>Tanggal Transaksi</th>
													<th>Total Transaksi</th>
													<th>Status</th>
													<th>Proses</th>
													<th>Opsi</th>
													
													
												</tr>
												</thead>
												
												<tbody>
												
												
												</tbody>
											</table>
										
											
							</div>	
						</div>
					</div>
					
				</div>
			</div>
		</div>
	
	</div>
</div>





<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		<h4> Ubah Status </h4>
      </div>
		<form id="" method="POST" action="<?php echo base_url('adminDigital/Order/stProses');?>">
			<div class="modal-body" style="background-color:#B0E0E6" id="bodyModal">
				<div id="proses">
					<input type="hidden" id="invoice" name="invoice">
					<div class="input-group">
											 <span class="input-group-addon" id="basic-addon1">Status</span>
											 <select id="status" name="status" class="form-control">
												<option value="list">List Pesanan</option>
												<option value="cancel">Cancel Pesanan</option>
												<option value="terima">Terima Pesanan</option>
												<option value="di terima staf">Di Terima Staf</option>
												<option value="di terima member">Di Terima Member</option>
												<option value="lunas">Lunas</option>
											 </select>
											
					</div>
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">Catatan</span>
						<input type="text" id="invoice" name="catatan" class="form-control">
					</div>
					
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<input type="submit" name="simpan" value="Simpan" class="btn btn-info" id="simpan" onclick="return confirm('Apa anda yakin, ingin melakukan perubahan?')">
			</div>
		</form>
		
		
    </div>
  </div>
</div>	



<div class="modal fade" id="list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color:#87CEFA">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body" style="background-color:#B0E0E6" id="bodyModal">
			<div id="item">				
					
				
			</div>
		</div>
		<div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			
		  </div>
    </div>
  </div>
</div>	





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


$("#order").DataTable({
	"processing"	: true,
	"serverSide"	:true,
	"order"			: [1,'asc'],
	"ajax"			:{
						"url" : "<?php echo base_url('adminDigital/Order/dt_kproses');?>",
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
							"data" : "idtransaksi",
							"sClass": "text-center",
						},
						{
							"data" : "username",
							"sClass": "text-center",
						},
						{
							"data" : "tgltransaksi",
							"sClass": "text-center",
						},
						{
							"data" : "totaltransaksi", render: $.fn.dataTable.render.number(',','.','','Rp. '),
							"sClass": "text-center",
							"searchable" : false,
						},
						{
							"data" : "status",
							"sClass": "text-center",
						},
						{
							"data" : "list",
							"orderable": false,
							"sClass": "text-center",
							'searchable': false,
						},
						{
							"data" : "proses",
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

$('#order').on('click','.proses',function(){
			var invoice=$(this).data('id');
			$('#invoice').val(invoice)
			$('#modal').modal('show');
			
})


$('#order').on('click','.list',function(){
			var invoice=$(this).data('id');
			
			$('#item').load("<?php echo base_url('adminDigital/Order/lihatProsesOrder/');?>" + invoice) ;
			$('#list').modal('show');
			
			
			
})


</script>
