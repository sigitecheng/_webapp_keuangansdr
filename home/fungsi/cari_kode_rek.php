<?php 
if(!empty($_POST['no_gol'])){ $gol=$_POST['no_gol'];
include "../koneksi.php";
$cari_id = mysqli_query($con,"select coalesce(max(substr(no_rekening,3,3)),0)+1 as kd from tb_rekening where left(no_rekening,2)='$gol' ") or die('gagal pencarian data !');           
                $tmp = mysqli_fetch_assoc($cari_id); 
                $kd = $tmp['kd'];
            echo $kd;
}
?>