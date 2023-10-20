<?php
echo "string";
	$user = ($_POST['user']);
	$pass = ($_POST['pass']);
	require_once "koneksi.php";
	$cari = mysqli_query($con,"select * from 
	( select id_admin as id,nama,username,password,'admin' as level from tb_admin 
		union
	  select id_bendahara as id,nama,username,password,'bendahara' as level from tb_bendahara 
		union	
	  select id_investor as id,investor,username,password,'investor' as level  from tb_investor	
	  union	
	    select id_pimpinan as id,nama,username,password,'pimpinan' as level  from tb_pimpinan
	)tabel	
	where username='$user' and password='$pass'
	") or die(mysql_error());
	$htg = mysqli_num_rows($cari);
	if($htg==1)
	{
	$u= mysqli_fetch_assoc($cari);
		session_start(); 
			$_SESSION['id']= $u['id'];
			$_SESSION['nama']= $u['nama'];
			$_SESSION['level']= $u['level'];
			$_SESSION['jb']= $u['jb'];
		 header('location:index.php');
	}else{ 
		 header('location:../index.php?pass=cek');
	}
?>