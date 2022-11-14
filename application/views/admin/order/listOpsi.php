<tr>
	<td>1</td>
	<td><?php echo $data->idtransaksi;?></td>
	<td><?php echo $data->tgltransaksi;?></td>
	<td><?php echo number_format($data->totaltransaksi);?></td>
	<td><?php echo $data->status;?></td>
	<td>
		<a href="<?php echo base_url('adminDigital/Order/editOrder/').$data->idtransaksi ;?>" class='btn btn-info btn-xs' id='edit' onclick="return confirm('Apakah anda ingin melakukan perubahan pesanan?')">Ubah</a> || 
		<a href="<?php echo base_url('adminDigital/Order/batalOrder/').$data->idtransaksi ;?>" id='cancel' class='btn btn-danger btn-xs' onclick="return confirm('Apakah anda ingin membatalkan pesanan?')">Batal</a>
	</td>
</tr>