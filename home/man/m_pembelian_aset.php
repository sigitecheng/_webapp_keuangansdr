<?php
	require "../koneksi.php";
	if(!empty($_POST['idp'])) $idp = $_POST['idp']; 
	if(!empty($_POST['tgl'])) $tgl = $_POST['tgl']; 
	if(!empty($_POST['nomor'])) $nomor = $_POST['nomor']; 
	$investor = "Perusahaan";
	if(!empty($_POST['ket'])) $ket = $_POST['ket'];

	if(!empty($_POST['rekening1'])) $r1 = $_POST['rekening1'];
	if(!empty($_POST['rekening2'])) $r2 = $_POST['rekening2'];

	if(!empty($_POST['qty'])) $qty = $_POST['qty'];

	session_start();
	$USER = $_SESSION['id'];


	if(!empty($_GET['edit_id']))
	{   
		$tr = mysqli_query($con,"update tb_transaksi set no_bukti='$no_bukti',tgl_trans='$tgl',ket='$ket',id_bendahara='$USER',id_notaris='$investor',view_admin='0',view_pimpinan='0',view_investor='0' where id_trans='$idp' ") or die('Terjadi kesalahan, Gagal input data.. !');
		if($tr){
			$hpstrans = mysqli_query($con,"delete from tb_ju where id_trans='$idp' ");
				if($hpstrans)
				{
							mysqli_query($con,"insert into tb_ju values('','$idp','$r1','$qty','0') ");
							mysqli_query($con,"insert into tb_ju values('','$idp','$r2','0','$qty') ");				
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
							mysqli_query($con,"insert into tb_ju values('','$idp','$r1','$qty','0') ");
							mysqli_query($con,"insert into tb_ju values('','$idp','$r2','0','$qty') ");	
	}  

?>	