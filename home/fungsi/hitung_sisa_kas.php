<?php 
if(!empty($_POST['id_per'])){ $per=$_POST['id_per']; }else { $per=''; }
include "../koneksi.php";
$cari_jum = mysqli_query($con,"
select id_notaris,j.no_rekening,sum(debit) as jd, sum(kredit) as jk from tb_ju j 
inner join tb_transaksi t on t.id_trans=j.id_trans
inner join (select rk.no_rekening from tb_rekening rk where left(rk.no_rekening,2)<>'11' ) r on r.no_rekening=j.no_rekening
where t.id_notaris like '%$per%'
group by j.no_rekening, t.id_notaris
union
select id_notaris,j.no_rekening,sum(debit) as jd, sum(kredit) as jk from tb_d_jp j 
inner join tb_jp t on t.id_jp=j.id_jp
inner join (select rk.no_rekening from tb_rekening rk where left(rk.no_rekening,2)<>'11' ) r on r.no_rekening=j.no_rekening
where t.id_notaris like '%$per%'
group by j.no_rekening, t.id_notaris
") or die('gagal pencarian data !');           
	if(mysqli_num_rows($cari_jum)>0){
		$modal=0;
		$beban=0;
		$pendapatan=0;
            while($tmp = mysqli_fetch_assoc($cari_jum))
            { 
            	if(substr($tmp['no_rekening'],0,1)=='3'){ $modal = $modal+($tmp['jk']-$tmp['jd']); }
            	else if(substr($tmp['no_rekening'],0,1)=='4'){ $pendapatan = $pendapatan+($tmp['jk']-$tmp['jd']); }
            	else if(substr($tmp['no_rekening'],0,1)=='5'){ $beban = $beban+($tmp['jd']-$tmp['jk']); }
            	else {}
            } 
              $jml = $modal+($pendapatan-$beban);   // perubahan modal + prive = sisa kas-(kas tetap) 
    }        
    else { $jml=0; }    

    echo $jml;
?>