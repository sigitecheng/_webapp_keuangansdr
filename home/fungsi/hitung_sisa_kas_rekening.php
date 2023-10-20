<?php 
if(!empty($_POST['no_rek'])){ $no_rek=$_POST['no_rek']; }else { $no_rek=''; }   // PAKENYA NO REKENING SAMA ID NOTARIS

include "../koneksi.php";


$cari_jum = mysqli_query($con,"
select sum(debit)-sum(kredit) as jml from
(
select r.no_rekening,debit,kredit
from tb_ju j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_transaksi jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_trans=j.id_trans
where j.no_rekening='$no_rek' 
union
select r.no_rekening,debit,kredit
from tb_d_jp j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_jp jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_jp=j.id_jp
where j.no_rekening='$no_rek' 
)tampung group by no_rekening
") or die('gagal pencarian data !');           
	if(mysqli_num_rows($cari_jum)>0){
            while($tmp = mysqli_fetch_assoc($cari_jum))
            { 
            	$jml = $tmp['jml'];   
            }    
    }        
    else { $jml=0; }    

    echo $jml;
?>