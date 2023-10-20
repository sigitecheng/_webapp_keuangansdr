<?php
	require "../koneksi.php";
	if(!empty($_POST['idp'])) $idp = $_POST['idp']; 
	if(!empty($_POST['tgl'])) $tgl = $_POST['tgl']; 
	if(!empty($_POST['no_bukti'])) $no_bukti = $_POST['no_bukti']; 
	if(!empty($_POST['nomor'])) $nomor = $_POST['nomor']; 
	if(!empty($_POST['investor'])) $investor = $_POST['investor'];
	if(!empty($_POST['ket'])) $ket = $_POST['ket'];

	session_start();
	$USER = $_SESSION['id'];

	if(!empty($_GET['edit_id']))
	{   
		$tr = mysqli_query($con,"update tb_transaksi set no_bukti='$no_bukti',tgl_trans='$tgl',ket='$ket',id_bendahara='$USER',id_notaris='$investor',view_admin='0',view_pimpinan='0',view_investor='0' where id_trans='$idp' ") or die('Terjadi kesalahan, Gagal input data.. !');
		if($tr){
			$hpstrans = mysqli_query($con,"delete from tb_ju where id_trans='$idp' ");
				if($hpstrans)
				{
					for ($i=1; $i <= $nomor; $i++) {
							$rek = $_POST['rekening'.$i];
							$debit = $_POST['jdebit'.$i];
							$kredit = $_POST['jkredit'.$i]; 
							mysqli_query($con,"insert into tb_ju values('','$idp','$rek','$debit','$kredit') ");
				}	
			} 
		}	
	}
	else
	if(!empty($_POST['hapus_id']))
	{   
		mysqli_query($con,"delete from tb_transaksi where id_trans='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');	
		mysqli_query($con,"delete from tb_ju where id_trans='$_POST[hapus_id]' ") or die('Terjadi kesalahan, Gagal Hapus data.. !');
	}
	else
	{  
		mysqli_query($con,"insert into tb_transaksi values('$idp','$no_bukti','$tgl','$ket','$USER','$investor','0','0','0') ") or die('Terjadi kesalahan, Gagal input data.. !');
		for ($i=1; $i <= $nomor; $i++) {
				$rek = $_POST['rekening'.$i];
				$debit = $_POST['jdebit'.$i];
				$kredit = $_POST['jkredit'.$i]; 
			mysqli_query($con,"insert into tb_ju values('','$idp','$rek','$debit','$kredit') ");
		} 
	}  

?>	