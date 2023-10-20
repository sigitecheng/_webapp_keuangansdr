<?php

	require "../koneksi.php";
	if(!empty($_POST['id'])) $kd = $_POST['id']; 
	if(!empty($_POST['investor'])) $investor = $_POST['investor']; 
	if(!empty($_POST['pj'])) $pj = $_POST['pj'];
	if(!empty($_POST['alamat'])) $alamat = $_POST['alamat']; 
	if(!empty($_POST['no_hp'])) $no_hp = $_POST['no_hp']; 
	if(!empty($_POST['email'])) $email = $_POST['email']; 
	if(!empty($_POST['username'])) $user = $_POST['username']; 
	if(!empty($_POST['password'])) $pass = $_POST['password']; 

	if(!empty($_GET['edit_id']))
	{   
		mysqli_query($con,"update tb_investor set investor='$investor',penanggung_jawab='$pj',alamat='$alamat',no_hp='$no_hp',email='$email',username='$user',password='$pass' where id_investor='$_GET[edit_id]' ") or die('Terjadi kesalahan, Gagal Ubah data.. !');
	}
	else
	if(!empty($_POST['hapus_id']))
	{   
		mysqli_query($con,"delete from tb_investor where id_investor='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');	
	}
	else
	{  
		mysqli_query($con,"insert into tb_investor values('$kd','$investor','$pj','$alamat','$no_hp','$email','$user','$pass') ") or die('Terjadi kesalahan, Gagal input data.. !');
	}  

?>	