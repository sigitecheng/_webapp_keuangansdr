<?php
	require "../koneksi.php";
	if(!empty($_POST['idp'])) $idp = $_POST['idp']; 
	if(!empty($_POST['tgl'])) $tgl = $_POST['tgl'];  
	if(!empty($_POST['nomor'])) $nomor = $_POST['nomor']; 
	if(!empty($_POST['investor'])) $investor = $_POST['investor'];
	if(!empty($_POST['ket'])) $ket = $_POST['ket'];

	session_start();
	$USER = $_SESSION['id'];

	if(!empty($_GET['edit_id']))
	{   
		$tr = mysqli_query($con,"update tb_jp set tgl='$tgl',ket='$ket',id_bendahara='$USER',id_notaris='$investor' where id_jp='$idp' ") or die('Terjadi kesalahan, Gagal input data.. !');
		if($tr){
			$hpstrans = mysqli_query($con,"delete from tb_d_jp where id_jp='$idp' ");
				if($hpstrans)
				{
					for ($i=1; $i < $nomor; $i++) {
							$rek = $_POST['rekening'.$i];
							$debit = $_POST['jdebit'.$i];
							$kredit = $_POST['jkredit'.$i]; 
							mysqli_query($con,"insert into tb_d_jp values('','$idp','$rek','$debit','$kredit') ");
				}	
			} 
		}	
	}
	else
	if(!empty($_POST['hapus_id']))
	{   
		mysqli_query($con,"delete from tb_jp where id_jp='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');	
		mysqli_query($con,"delete from tb_d_jp where id_jp='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');
	}
	else
	{  
		mysqli_query($con,"insert into tb_jp values('$idp','$tgl','$USER','$ket','$investor') ") or die('Terjadi kesalahan, Gagal input data.. !');
		for ($i=1; $i <= $nomor; $i++) {
				$rek = $_POST['rekening'.$i];
				$debit = $_POST['jdebit'.$i];
				$kredit = $_POST['jkredit'.$i]; 
			mysqli_query($con,"insert into tb_d_jp values('','$idp','$rek','$debit','$kredit') ");
		} 
	}  

?>	