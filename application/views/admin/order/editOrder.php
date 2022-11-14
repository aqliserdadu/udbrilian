<section class="content-header">
      <h1>
       Pesanan
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url("adminDigital/AdminDigital/index");?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo base_url("adminDigital/Order/addOrder");?>"></i> Pesanan</a></li>
        <li class="active">Ubah Pesanan</li>
      </ol>
</section>


<div class="content">
	<div class="row">
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Ubah Pesanan</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
				<div class="box-body">
					<form action="" method="POST" enctype="multipart/form-data" id="formPesan">
							<div class="row">
							
							  <div>
								<?php echo $this->session->flashdata('massage');?>
							  </div>
							  
							  <div id="info"></div>
							
								<div class="col-md-12" style="margin-top:8px">
									<div class="input-group">
										 <span class="input-group-addon" id="basic-addon1">No Invoice</span>
										 <input type="text" name="invoice" id="invoice" required class="form-control" readonly placeholder="No Invoice" value="<?php echo $invoice;?>">
									</div>
									
									<div class="input-group">
										 <span class="input-group-addon" id="basic-addon1">Nama Barang</span>
										 <input type="hidden" name="idproduk" id="idproduk" required class="form-control" placeholder="Input...">
										 <input type="text" name="namaproduk" id="namaproduk" required class="form-control" placeholder="Nama Barang">
										 <span class="input-group-btn">
											<button class="btn btn-info" id="allproduk">Produk</button>
										</span>
									</div>
									<div class="input-group">
										<span class="input-group-addon" id="basic-addon1">Jumlah</span>
											<input type="number" name="qty" id="jumlah" min="1" required class="form-control" placeholder="Jumlah">
											<input type="hidden" name="satuan" id="satuan" required class="form-control">
										<span class="input-group-btn">
											<label class="btn btn-default" disabled id="label">satuan</label>
										</span>
									</div>
									
									<div class="input-group">
										 <span class="input-group-addon" id="basic-addon1">Total Harga</span>
										 <input type="hidden" name="harga" id="harga" required class="form-control" placeholder="harga">
										 <input type="text" name="total" id="total" required class="form-control" placeholder="Total Harga">
									</div>
									
									<div class="modal-footer">
										<button class="btn btn-success text-right" id="tambah">Tambah</button>
									</div>
								
								</div> 
							
							</div>
					</form>
				</div>
			</div>
		</div>
	
		<div id="listOrder"> <!-- digunakan untuk load yang ada  --->
	<?php if($data){;?> <!-- apabila data tidak ada yang ditampilkan maka ini dihilangkan --->
		<div class="col-md-12">		
			<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">List Order</h3>

					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					</div>
				</div>
			
				<div class="box-body">
					<div>
						<?php echo $this->session->flashdata('list');?>
					</div>
					
					<div class="col-md-12">	
						
								<div class="table-responsive">
										<table id="list" class="table">
											<thead>
											<tr>
												<th>No</th>
												<th>Kode</th>
												<th>Nama Barang</th>
												<th>Harga</th>
												<th>Jml</th>
												<th>Total</th>
												<th>Opsi</th>
												
												
											</tr>
											</thead>
											
											<tbody>
											<?php $no =1 ;?>
											<?php $total =0 ;?>
											<?php $invoice ='';?>
											<?php foreach($data as $tp){;?>
											<tr>
												<td><?php echo $no++;?></td>
												<td><?php echo $tp->idproduk;?></td>
												<td><?php echo $tp->namaproduk;?></td>
												<td><?php echo number_format($tp->harga);?></td>
												<td><?php echo $tp->jumlah." ".$tp->satuan;?></td>
												<td><?php echo number_format($tp->total);?></td>
												<td>
													<a href="<?php echo base_url('adminDigital/Order/hapusListOrder/').$tp->idpenjualan;?>" onclick="return confirm('Apakah anda yakin ingin menghapus ini?')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o "></i></a>
												</td>
												
												<?php $total = $total + $tp->total;?>
												<?php $invoice = $tp->idtransaksi;?>
												
											</tr>
											<?php  } ;?>
											<tr>
												<td colspan="4"></td>
												<td> <b>Total Harga</b></td>
												<td> <b><?php echo number_format($total);?></b></td>
												
												
												
											</tr>
											</tbody>
										</table>
									
										
										
										
								
								</div>
								
								
						
								
					</div>
					
							<form action="<?php echo base_url('adminDigital/Order/updateOrder');?>" method="POST" id="saveOrder">
								
								<input type="hidden" name="invoice" value="<?php echo $invoice;?>"> <!--invoice -->
								<input type="hidden" name="total" value="<?php echo $total;?>">	<!--Total Transaksi -->
								<input type="hidden" name="user" value="<?php echo $this->session->userdata('iduser');?>">	<!--ID User -->
												
								<div class="modal-footer">
									<input type="submit" value="Simpan" name="simpan" class="btn btn-success text-right" onclick="return confirm('Apakah anda ingin menyimpan perubahan order?')">
								</div>
							</form>
				</div>
			</div>
		</div>
	<?php } ;?>
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
							<div class="table-responsive">
										<table id="produk" class="table">
											<thead>
											<tr>
												<th>No</th>
												<th>Kode</th>
												<th>Kt</th>
												<th>Nama Barang</th>
												<th>Harga</th>
												<th>St</th>
												<th>Opsi</th>
												
												
											</tr>
											</thead>
											
											<tbody>
											
											</tbody>
										</table>
									
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


$("#produk").DataTable({
	"processing"	: true,
	"serverSide"	:true,
	"order"			: [1,'asc'],
	"ajax"			:{
						"url" : '<?php echo base_url('adminDigital/Order/dtProduk');?>',
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
							"data" : "idproduk",
							"sClass": "text-left",
						},
						{
							"data" : "kategori",
							"sClass": "text-left",
						},
						{
							"data" : "namaproduk",
							"sClass": "text-left",
						},
						{
							"data" : "hargaproduk", render: $.fn.dataTable.render.number(',','.','','Rp. '),
							"sClass": "text-left",
							"searchable" : false,
						},
						{
							"data" : "satuan",
							"sClass": "text-center",
						},
						
						{
							"data" : "pilih",
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

$('#produk').on('click','.pilihproduk',function(){
			var id=$(this).data('id');
            var nama=$(this).data('nama');
            var harga=$(this).data('harga');
            var satuan=$(this).data('satuan');
            
			
			$('#idproduk').val(id);
			$('#namaproduk').val(nama);
			$('#label').html(satuan);
			$('#harga').val(formatUang(harga));
			$('#jumlah').val(1);
			$('#satuan').val(satuan);
			$('#total').val(formatUang(harga));
			$('#modal').modal('hide');
			
})


$('#allproduk').click(function(e){
	
	e.preventDefault();
	$('#modal').modal('show');
			
	
})

$("#jumlah").on('keyup click',function(){
	
	var jumlah = $(this).val();
	var harga = menghilangkanKoma($("#harga").val());
	
	if(jumlah == '')
	{
		$("#total").val(0);
	}
	else
	{
		var total = parseInt(harga) * parseInt(jumlah);
		
		$("#total").val(formatUang(total));
	}
	
	
})


	

$('#tambah').click(function(e){ //simpan data custamer
	
	e.preventDefault();
	
	$.ajax({
				
				url		: "<?php echo base_url('adminDigital/Order/simpanListOrder');?>",
				type	: "POST",
				dataType: "json",
				data 	: $('#formPesan').serialize(),
				success	: function(data){	
							if(data.status == true)
							{
								$("#info").fadeIn('slow');
								$("#info").html("<div class='col-md-12 '><div class='alert-success' align='center'> Berhasil Di Tambah </div></div>")
								$("#info").fadeOut('slow');
								
								$("#listOrder").load("<?php echo base_url('adminDigital/Order/listOrderEdit/');?>" + data.inv);
							
								$('#idproduk').val('');
								$('#namaproduk').val('');
								$('#label').html('satuan');
								$('#harga').val('');
								$('#jumlah').val('');
								$('#satuan').val('');
								$('#total').val('');
												
							}
							else if(data.status == false)
							{
								$("#info").fadeIn('slow');
								$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal Di Tambah </div></div>")
								$("#info").fadeOut('slow');
							}
							else
							{
								$("#info").fadeIn('slow');
								$("#info").html("<div class='col-md-12 '><div class='alert-danger' align='center'> Gagal!!! Tidak Boleh Kosong </div></div>")
								$("#info").fadeOut('slow');
							}	
							
						},
				error	: function(){
					
						},
				
			
			
			
		})
	
	
	
	
})



function formatUang(a)
{
	var angka = a;
	var reverse = angka.toString().split('').reverse().join(''),
	ribuan = reverse.match(/\d{1,3}/g);
	ribuan = ribuan.join(',').split('').reverse().join('');
	
	return ribuan;
}


	
function menghilangkanKoma(ambil)
{
	

	
	var input = ambil.toString();
	var array = input.split(",");  			//split(",") memisahkan berdasarkan tanda ,
		for(i=0; i < array.length; i++)
		{
			parseInt(array[i]); //hasil array di ubah ke int
		}
	
		return array.join('');
	
	
	
}





</script>
	