
<?php

$rek = $_GET['rek'];
$thn = $_GET['thn'];		
$not = $_GET['not'];
if(empty($not)){ $not='Semua dana'; }
$nama = $_GET['nama'];

$content ="
<div style='margin-left:15;'>  
	<strong> <font size='5'> LAPORAN BUKU BESAR </font>  </strong> </br>
	Kode Rekening : <strong>".$rek."</strong> <br>
	NO Notaris : ".$not." <br>
	Nama Rekening : ".$nama." <br>
	Tahun Laporan : ".$thn." <br>
	Tanggal Cetak : ".date('Y - m - d')." <br>
	<br>
</div>
</hr>
<table border=0 width=98% align=center>
                                    <thead>
                                        <tr class=head bgcolor='cadetblue' >
                                        	<th width=5% style=text-align : center; height=40>No</th>
                                            <th width=5% style=text-align : center;>Dari</th>
											<th width=8% style=text-align : center;>tgl transaksi</th>
											<th width=15% style=text-align : center;>Ket Dana</th>
											<th width=10% style=text-align : center;>Ket Transaksi</th>
											<th width=10% style=text-align : center;>Debit</th>
											<th width=10% style=text-align : center;>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>";									
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select '' as dari,'' as no_rekening, '' as rekening,'' investor,'' as tgl, 'Saldo Tahun Lalu' as ket,
sum(debit) as debit,sum(kredit)as kredit from
(
select investor,COALESCE(debit,0)as debit,COALESCE(kredit,0)as kredit
from tb_ju j 
left join ( select jp.*,inv.investor from tb_transaksi jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_trans=j.id_trans
where j.no_rekening='$rek' and year(tgl_trans)<'$thn' and id_notaris like '%$not%'
union
select investor,COALESCE(debit,0)as debit,COALESCE(kredit,0)as kredit
from tb_d_jp j 
left join ( select jp.*,inv.investor from tb_jp jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_jp=j.id_jp
where j.no_rekening='$rek' and year(tgl)<'$thn' and id_notaris like '%$not%'
)tmp
UNION ALL
select 'JU' as dari,r.*,investor,tgl_trans as tgl,ket,debit,kredit
from tb_ju j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_transaksi jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_trans=j.id_trans
where j.no_rekening='$rek' and year(tgl_trans)='$thn' and id_notaris like '%$not%'
union
select 'JP' as dari,r.*,investor,tgl,ket,debit,kredit
from tb_d_jp j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_jp jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_jp=j.id_jp
where j.no_rekening='$rek' and year(tgl)='$thn' and id_notaris like '%$not%'
") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											$content .="
											<tr>
                                            <td align='center' colspan='9'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
										while($u = mysqli_fetch_assoc($cariagt))
										{  
											if(empty($u['dari'])){
												if( ((substr($rek,0,1)=='1' or substr($rek,0,1)=='5') and ($u['debit']-$u['kredit'])>0))
													{ $seb_d=abs($u['debit']-$u['kredit']); $seb_k=0; }
												else
													{ $seb_k=abs($u['debit']-$u['kredit']); $seb_d=0; }

												if(((substr($rek,0,1)!='1' and substr($rek,0,1)!='5') and ($u['kredit']-$u['debit'])>0) )
													{ $seb_k= abs($u['debit']-$u['kredit']); $seb_d=0; }
												else
													{ $seb_d=abs($u['kredit']-$u['debit']); $seb_k=0; }

												$d=$d+$seb_d;
												$k=$k+$seb_k;

												$content .= "
												<tr height=25 "; if($n%2==0){ $content .= "class='satu'"; }else{ $content .= "class='dua'"; } $content .=" >
												<td align=center colspan='5'><strong style='margin-right:10;'> Saldo tahun "; $content .= ($thn-1)." </Strong> </td>
												<td align=right>"; $content .= number_format($seb_d); $content .="</td>
												<td align=right>"; $content .= number_format($seb_k); $content .="</td>
												</tr>"; 
											 }	
											 else
											 {	
											$content .="
											<tr bgcolor='gainsboro' height=30 "; if($n%2==0){ $content .="class='satu'"; }else{ $content .="class='dua'"; } $content .=" >
												<td align=center>".$n."</td>
												<td align=center>".$u['dari']."</td>
												<td align=center>".$u['tgl']."</td>
												<td align=left>"; if(empty($u['investor'])){ $content .="Dana Perusahaan"; }else{ $content .= $u['investor']; } $content .="</td>
												<td align=left>".$u['ket']."</td>
												<td align=right>"; if(!empty($u['debit'])){ $content .= number_format($u['debit']); $d=$d+$u['debit']; } $content .="</td>
												<td align=right>"; if(!empty($u['kredit'])){ $content .= number_format($u['kredit']); $k=$k+$u['kredit']; } $content .="</td>
											</tr>";
											$n++;
											}
										}	
											$content .="
											<tr  >
												<td height=25 align=center colspan=5></td>
												<td bgcolor='powderblue' align=right valign=bottom><h4>";  $content .= number_format($d); $content .="</h4></td>
												<td bgcolor='powderblue' align=right valign=bottom><h4>";  $content .= number_format($k); $content .="</h4></td>
											</tr>
											<tr  >
												<td height=25 align=center colspan=5></td>
												<td valign='center' bgcolor='linen' align=center valign=bottom colspan=2><h3><font color='green'> ";  
												if( (substr($rek, 0,1)=='1') or (substr($rek, 0,1)=='5') ){ $content .= number_format($d-$k); }else{ $content .= number_format($k-$d); }
												$content .="</font></h3></td>
											</tr>";
										
									}	
									$content .="	
                                    </tbody>
</table>";
	
	$tglnow = date('Y - m - d');

	if($_POST['format']=='1') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_buku_besar_$tglnow.doc");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $content;
	}
	elseif($_POST['format']=='2') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_buku_besar_$tglnow.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $content;
	}
	elseif($_POST['format']=='3') {
	// Define relative path from this script to mPDF
	$nama_dokumen='lap_buku'; //Beri nama file PDF hasil.
	define('_MPDF_PATH','../fungsi/MPDF60/');
	include(_MPDF_PATH . "mpdf.php");
	$mpdf=new mPDF('c', 'A4-L'); // Create new mPDF Document
	//Beginning Buffer to save PHP variables and HTML tags
	ob_start(); 
		echo $content;
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
	$mpdf->WriteHTML(utf8_encode($html));
	$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;


}
?>