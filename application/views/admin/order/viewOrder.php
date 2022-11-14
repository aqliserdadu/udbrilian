<section class="content-header">
      <h1>
       Pesanan
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("adminDigital/Order/addOrder");?>"></i> Pesanan</a></li>
        <li class="active">Lihat</li>
      </ol>
</section>


<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Daftar Pesanan</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
				<div class="box-body">
					<div class="row">
						<?php echo $this->session->flashdata('success');?>
					</div>
					
					<div class="row" style="margin-top:3px">
						<div class="col-md-12">
							<div class="table-responsive">
											<table id="order" class="table">
												<thead>
												<tr>
													<th>No</th>
													<th>Invoice</th>
													<th>Tanggal Transaksi</th>
													<th>Total Transaksi</th>
													<th>Status</th>
													<th>Proses</th>
													<th>Transaksi</th>
													
													
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
						"url" : '<?php echo base_url('adminDigital/Order/dtOrder');?>',
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
							"data" : "proses",
							"orderable": false,
							"sClass": "text-center",
							'searchable': false,
						},
						{
							"data" : "item",
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

$('#order').on('click','.item',function(){
			var invoice=$(this).data('id');
			
			$('#item').load("<?php echo base_url('adminDigital/Order/itemOrder/');?>" + invoice) ;
			$('#modal').modal('show');
			
})

$('#order').on('click','.proses',function(){
			var invoice=$(this).data('id');
			
			$('#item').load("<?php echo base_url('adminDigital/Order/lihatProsesOrder/');?>" + invoice) ;
			$('#modal').modal('show');
			
})


</script>
