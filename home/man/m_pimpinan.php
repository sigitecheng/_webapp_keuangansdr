<?php

	require "../koneksi.php";
	if(!empty($_POST['id'])) $kd = $_POST['id']; 
	if(!empty($_POST['nama'])) $nm = $_POST['nama']; 
	if(!empty($_POST['username'])) $user = $_POST['username']; 
	if(!empty($_POST['password'])) $pass = $_POST['password']; 

	if(!empty($_GET['edit_id']))
	{   
		mysqli_query($con,"update tb_pimpinan set nama='$nm',username='$user',password='$pass' where id_pimpinan='$_GET[edit_id]' ") or die('Terjadi kesalahan, Gagal Ubah data.. !');
	}
	else
	if(!empty($_POST['hapus_id']))
	{   
		mysqli_query($con,"delete from tb_pimpinan where id_pimpinan='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');	
	}
	else
	{  
		mysqli_query($con,"insert into tb_pimpinan values('$kd','$nm','$user','$pass') ") or die('Terjadi kesalahan, Gagal input data.. !');
	}  

?>	