
<?php if($satuan == null){;?>
<option value="" disabled selected>--Pilih--</option>
<?php };?>


<?php foreach($data as $tp){;?>

<?php if($satuan == $tp->namasatuan){;?>
<option value="<?php echo $tp->idsatuan;?>" selected><?php echo $tp->namasatuan;?></option>
<?php }else{;?>
<option value="<?php echo $tp->idsatuan;?>"><?php echo $tp->namasatuan;?></option>

<?php };?>
<?php };?>