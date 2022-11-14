	<table class="table table-striped" id="akun">
													<thead>
													<tr>
														<th> No </th>
														<th> Username</th>
														<th> Gender</th>
														<th> Lavel</th>
														<th> Status</th>
														<th> Opsi </th>
													</tr>
													</thead>
													<?php $no = 1;?>
													<?php foreach($data as $tampil) {?>	
													<tbody>
													<tr>
														<td><?php echo $no++;?></td>
														<td><?php echo ucwords($tampil->username);?></td>
														<td><img src="<?php echo base_url('galery/akun/').$tampil->gender;?>" class="img-circle" alt="User Image" style="width:35px;height:35px"></td>
														<td><?php echo  ucfirst($tampil->level);?></td>
														<?php if($tampil->status == 1){$status='On';}else{$status='Off';}?>
														<td><?php echo $status;?></td>
														<td>
															<a href="#" onclick="edit('<?php echo $tampil->iduser;?>','<?php echo $tampil->username;?>','<?php echo $tampil->gender;?>','<?php echo $tampil->level;?>','<?php echo $tampil->status;?>')" class="btn btn-success btn-xs">Ed Data</a>
															<a href="#" onclick="pass('<?php echo $tampil->iduser;?>')" class="btn btn-info btn btn-xs">Ed Pass</a>
														</td>
													</tr>
													</tbody>
													<?php  }?>	
												</table>

<script type="text/javascript">
$("#akun").DataTable();
	


</script>