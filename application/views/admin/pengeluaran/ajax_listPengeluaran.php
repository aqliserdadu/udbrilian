<style>
table tfoot {
    display: table-row-group;
}
</style>


	<table id="dataPengeluaran" class="table table-striped dataPengeluaran">
							<thead>
							<tr>
								<th>No</th>
								<th>Date</th>
								<th>Kategori</th>
								<th>Nominal</th>
								<th>Keterangan</th>
								<th><i class="fa fa-gear"></i></th>
							</tr>
							</thead>
							<tbody>
								<?php $no=1;?>
								<?php $total=0;?>
								<?php foreach($data as $tp){;?>
								<?php $total = $total + $tp->nominal;?>
								<tr>
									<td><?php echo $no++;?></td>
									<td><?php echo $tp->date;?></td>
									<td>
										<?php 
											if($tp->kategori == '' or $tp->kategori == null or $tp->kategori == 'Lain-lain' or $tp->kategori == 'lain')
											{
												echo "Lain-lain";
											}else{
												echo $tp->kategori;
											}
										;?>
									</td>
									<td><?php echo number_format($tp->nominal);?></td>
									<td><?php echo $tp->ket;?></td>
									<td>
												<a href="#" class="btn btn-success btn-xs" onclick="edit('<?php echo $tp->idpengeluaran;?>','<?php echo $tp->date;?>','<?php echo $tp->kategori;?>','<?php echo $tp->nominal;?>','<?php echo $tp->ket;?>')"><i class="fa fa-pencil"></i></a>
												<a href="#" class="btn btn-danger btn-xs" onclick="hapus('<?php echo $tp->idpengeluaran;?>')"><i class="fa fa-trash-o"></i></a>
									</td>
								</tr>
								<?php };?>
							</tbody>
							<tfoot>
								<tr>
									<td></td>
									<td><b>Total Pengeluaran</b></td>
									<td></td>
									<td></td>
									<td align="center"><?php echo number_format($total);?>
									<td></td>
								</tr>
							</tfoot>
	</table>

<script>
$(".dataPengeluaran").DataTable();



function hapus(id){
		
		if(confirm('Apa Anda Yakin Ingin Menghapus Pengeluaran?')){
		
			$.ajax({
							
								url		: '<?php echo base_url('admin/Pengeluaran/hapus');?>',
								type	: "POST",
								data 	: {idpengeluaran:id},
								dataType: "JSON",
								
								beforeSend: function()
										{
											$("#loading").html("<img src='<?php echo base_url('asset/images/loading.gif');?>'> <p style='text-align:center;margin-top: -130px;'>Harap Tunggu</p>");
											$(".preloader").show();
										},
								
								success	: function(data){	
											if(data.status == true){	
												alert(data.ket);
												
												$("#content").load("<?php echo base_url('admin/Pengeluaran/index');?>");
											}
											if(data.status == false){	
												alert(data.ket);
											}

										},
								complete: function(data){
										$(".preloader").hide();
										
										},		
								error	: function(xhr, textStatus){
								
									var msg ='';
										
											if(xhr.status === 0){
													msg = 'Tidak ada jaringan, Periksa koneksi jaringan';
												}
										else if(xhr.status == 404){
													msg = ' Halaman web tidak ditemukan [404]';
												}
										else if(xhr.status == 505){
													msg = ' Internal Server Error [505]';
												}
										else if(text.status === 'timeout'){
													msg = 'Time Out Error, Ulangi Kembali';
												}
											else{
													msg = ' Uncaughr Error.\n' + xhr.responseText;
												}
										alert(msg);
										
										$("#info").fadeIn('slow');
										$("#info").html("<div class='col-md-12 '><div class='alert-denger' align='center'> Gagal Dihapus </div></div>")
										$("#info").fadeOut('slow');
									
									
									},

							
						
						
						
							})
					
		}	
		
	}

</script>