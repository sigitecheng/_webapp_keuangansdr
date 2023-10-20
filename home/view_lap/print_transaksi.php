
<font size="8">
<?php

if(!empty($_GET['t1'])){ $tgl1 = $_GET['t1']; }else{ $tgl1=date(now()); }
if(!empty($_GET['t2'])){ $tgl2 = $_GET['t2']; }else{ $tgl2=date(now()); }		
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }
if(!empty($_GET['nama'])){ $nama = $_GET['nama']; }else{ $nama = ''; }

$content ="
<div style='margin-left:15;'>  
	<strong> <h2> LAPORAN TRANSAKSI </h2>  </strong> 
	Tanggal : <strong>".$tgl1." sampai ".$tgl2."</strong> <br>
	Keterangan Dana : ".$nama." ( ".$not." )  <br>
	Tanggal Cetak : ".date('Y - m - d')." <br>
	<br>
</div>
</hr>
<table border=0 width=98% align=center>
                                    <thead>
                                        <tr class='head' bgcolor='rosybrown' >
                                        	<th width=2% style='text-align : center;'  height='40'>No</th>
											<th width=3% style='text-align : center;'>tgl transaksi</th>
                                            <th width=10% style='text-align : center;'>Ket. Dana</th>
                                            <th width=10% style='text-align : center;'>Ket. Transaksi</th>
											<th width=8% style='text-align : center;'>No Bukti</th>
											<th width=10% style='text-align : center;'>user</th>
											<th width=5% style='text-align : center;'>Jumlah transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>";									
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select t.*,j.jml,inv.*,b.nama from tb_transaksi t 
									left join (select i.investor,p.id_notaris,p.tglmulai_kontrak,p.tglakhir_kontrak,p.ket_investasi from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=t.id_notaris
									inner join (select id_trans,sum(kredit) as jml from tb_ju group by id_trans) j on j.id_trans=t.id_trans 
									left join tb_bendahara b on b.id_bendahara=t.id_bendahara
									where tgl_trans between '$tgl1' and '$tgl2' and t.id_notaris like '%$not%' 
									order by tgl_trans desc 
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
											<tr bgcolor='gainsboro' "; if($n%2==0){ $content .="class='satu'"; }else{ $content .="class='dua'"; } $content .=" >
												<td align=center>".$n."</td>
												<td align=center>".$u['tgl_trans']."</td>
												<td align=left>"; if(empty($u['investor'])){ $content .="Dana Perusahaan"; $inv = "Semua"; }else{ $content .= $u['investor']; $inv = $u['investor']; } $content .="</td>
												<td align=left>".$u['ket']."</td>
												<td align=center>".$u['no_bukti']."</td>
												<td align=center>".$u['nama']."</td>
												<td align=right>".number_format($u['jml'])."</td>
											</tr>";
											$n++;
											}
										}
									$content .="	
                                    </tbody>
</table>";
	
	$tglnow = date('Y - m - d');

	if($_POST['format']=='1') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_transaksi_$tglnow.doc");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $content;
	}
	elseif($_POST['format']=='2') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_transaksi_$tglnow.xls");
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