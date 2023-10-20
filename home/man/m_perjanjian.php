<?php

	require "../koneksi.php";
	if(!empty($_POST['id'])) $kd = $_POST['id']; 
	if(!empty($_POST['id_investor'])) $id_investor = $_POST['id_investor']; 
	if(!empty($_POST['tmk'])) $tmk = $_POST['tmk']; 
	if(!empty($_POST['tak'])) $tak = $_POST['tak']; 
	if(!empty($_POST['tgl_perjanjian'])) $tgl_perjanjian = $_POST['tgl_perjanjian']; 
	if(!empty($_POST['ket'])) $ket = $_POST['ket']; 
	if(!empty($_POST['jumlah'])) $jumlah = $_POST['jumlah']; 

	if(!empty($_GET['edit_id']))
	{   
		mysqli_query($con,"update tb_perjanjian set id_investor='$id_investor',tglmulai_kontrak='$tmk',tglakhir_kontrak='$tak',jumlah_investasi='$jumlah',tgl_perjanjian='$tgl_perjanjian',ket_investasi='$ket' where id_notaris='$_GET[edit_id]' ") or die('Terjadi kesalahan, Gagal Ubah data.. !');
	}
	else
	if(!empty($_POST['hapus_id']))
	{   
		mysqli_query($con,"delete from tb_perjanjian where id_notaris='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');	
	}
	else
	{  
		mysqli_query($con,"insert into tb_perjanjian values('$kd','$id_investor','$tglmulai_kontrak','$tglakhir_kontrak','$jumlah','$tgl_perjanjian','$ket') ") or die('Terjadi kesalahan, Gagal input data.. !');
	}  

?>	