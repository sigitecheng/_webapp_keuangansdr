<?php

	require "../koneksi.php";
	if(!empty($_POST['id'])) $kd = $_POST['id']; 
	if(!empty($_POST['rekening'])) $nm = $_POST['rekening']; 

	if(!empty($_GET['edit_id']))
	{   
		mysqli_query($con,"update tb_rekening set rekening='$nm' where no_rekening='$_GET[edit_id]' ") or die('Terjadi kesalahan, Gagal Ubah data.. !');
	}
	else
	if(!empty($_POST['hapus_id']))
	{   
		mysqli_query($con,"delete from tb_rekening where no_rekening='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');	
	}
	else
	{  
		mysqli_query($con,"insert into tb_rekening values('$kd','$nm') ") or die('Terjadi kesalahan, Gagal input data.. !');
	}  

?>	