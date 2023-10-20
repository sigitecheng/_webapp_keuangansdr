<font size="8">
<?php

if(!empty($_GET['t1'])){ $tgl1 = $_GET['t1']; }else{ $tgl1=date(now()); }
if(!empty($_GET['t2'])){ $tgl2 = $_GET['t2']; }else{ $tgl2=date(now()); }		
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }
if(!empty($_GET['nama'])){ $nama = $_GET['nama']; }else{ $nama = ''; }

$content ="
<div style='margin-left:15;'>  
	<strong> <h2> LAPORAN RUGI-LABA </h2>  </strong> 
	Tanggal : <strong>".$tgl1." sampai ".$tgl2."</strong> <br>
	Keterangan Dana : ".$nama." ( ".$not." )  <br>
	Tanggal Cetak : ".date('Y - m - d')." <br>
	<br>
</div>
</hr>
<table border=0 width=98% align=center>
                                    <thead>
                                        <tr class=head bgcolor='olivedrab'>
                                        	<th width=2% style=text-align : center; height=40>No</th>
											<th width=5% style=text-align : center;>Tgl transaksi</th>
                                            <th width=5% style=text-align : center;>Ket. Trans</th>
                                            <th width=5% style=text-align : center;>No Rek</th>
											<th width=5% style=text-align : center;>Rekening</th>
											<th width=10% style=text-align : center;>Debit</th>
											<th width=10% style=text-align : center;>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>";									
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select r.*,investor,tgl_trans as tgl,ket,debit,kredit
from tb_ju j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_transaksi jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_trans=j.id_trans
where tgl_trans between '$tgl1' and '$tgl2' and id_notaris like '%$not%' and (left(j.no_rekening,1)='5' or left(j.no_rekening,1)='4')
") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											$content .="
											<tr>
                                            <td align='center' colspan='7'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											$content .="
											<tr bgcolor='gainsboro' height=30 "; if($n%2==0){ $content .="class='satu'"; }else{ $content .="class='dua'"; } $content .=" >
												<td align=center>".$n."</td>
												<td align=center>".$u['tgl']."</td>
												<td align=left>".$u['ket']."</td>
												<td align=center>".$u['no_rekening']."</td>
												<td align=left>".$u['rekening']."</td>
												<td align=right>"; if(!empty($u['debit'])){ $content .= number_format($u['debit']); $d=$d+$u['debit']; } $content .="</td>
												<td align=right>"; if(!empty($u['kredit'])){ $content .= number_format($u['kredit']); $k=$k+$u['kredit']; } $content .="</td>
											</tr>";
											$n++;
											}
											$content .="
											<tr  >
												<td height=25 align=center colspan=5></td>
												<td bgcolor='powderblue' align=right valign=bottom><h4>";  $content .= number_format($d); $content.="</h4></td>
												<td bgcolor='powderblue' align=right valign=bottom><h4>";  $content .= number_format($k); $content.="</h4></td>
											</tr>
											<tr style='border:0px;' >
												<td style='border:0px;' align=center colspan=5></td>
												<td colspan='2' bgcolor='moccasin' align=center valign=bottom><h2><font color='green'>".number_format($k-$d)."</font></h2></td>
											</tr>";
										}
									$content .="	
                                    </tbody>
</table>";
	
	$tglnow = date('Y - m - d');

	if($_POST['format']=='1') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_rugilaba_$tglnow.doc");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $content;
	}
	elseif($_POST['format']=='2') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_rugilaba_$tglnow.xls");
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
</font>