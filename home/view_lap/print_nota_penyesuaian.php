
<?php


include "../fungsi/terbilang.php";		
if(!empty($_GET['id'])){ $id = $_GET['id']; }else{ $id = ''; }

$content ="
<div style='margin-left:100;'>  
	<strong> <font size='5'> BUKTI PENGELUARAN DANA </font>  </strong>
</div> 
<hr>
<br><br>
<table border=0 width=100% align=left style='border:0px; margin-left:10;'>";

									$debit = 0;
									$kredit =0;
	
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }							
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"select t.*,j.jml,inv.*,b.nama from tb_jp t 
									left join (select i.investor,p.id_notaris,p.tglmulai_kontrak,p.tglakhir_kontrak,p.ket_investasi from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=t.id_notaris
									inner join (select id_jp,sum(debit) as jml from tb_d_jp group by id_jp) j on j.id_jp=t.id_jp 
									left join tb_bendahara b on b.id_bendahara=t.id_bendahara
									where t.id_jp='$id'
") or die('gagal pencarian data !'); 
										
											$u = mysqli_fetch_assoc($cariagt);
											 
											$content .="
											<tr  bgcolor='beige' class='satu' >
												<td align=right width=30%>ID Transaksi </td>
												<td > : ".$u['id_trans']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=right width=30%>Tgl Transaksi </td>
												<td align=left>: ".$u['tgl_trans']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=right width=30%>No Bukti </td>
												<td align=left>: ".$u['no_bukti']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=right width=30%>Keterangan </td>
												<td align=left>: ".$u['ket']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=right width=30%>Diambil dari kas</td>
												<td align=left>: "; if(empty($u['investor'])){ $content .="Perusahaan"; }else{ $content .=$u['investor']; } $content .=" </td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=right width=30%>Jumlah </td>
												<td align=left>: Rp. ".number_format($u['jml'])."</td>
											</tr>
											<tr >
												<td align=center height='30'  style='border:0px;'  > </td>
												<td align=left bgcolor='powderblue' ><strong>".ucfirst(konversi($u['jml']))." </strong>Rupiah</td>
											</tr>
											";
											
                                  $content .=  "</tbody>
</table>";

$content .= " <br><br><br><br> 
			<table border=0 width=100%>
			<tr  >";  $content .=" >
												<td align=center width=33%>Yang Mengeluarkan,</td>
												<td align=center></td>
												<td align=center height=30>Mengetahui,</td>
			</tr>
			<tr  >";  $content .=" >
												<td align=center height=100 valign=bottom><hr></td>
												<td align=center></td>
												<td align=center valign=bottom><hr></td>
			</tr>
			<tr  >";  $content .=" >
												<td align=center height=30>".ucfirst($u['nama'])."</td>
												<td align=center></td>
												<td align=center >...</td>
			</tr>
			</table>";

	$tglnow = date('Y - m - d');
	// Define relative path from this script to mPDF
	$nama_dokumen='lap_buku'; //Beri nama file PDF hasil.
	define('_MPDF_PATH','../fungsi/MPDF60/');
	include(_MPDF_PATH . "mpdf.php");
	$mpdf=new mPDF('c', 'A5'); // Create new mPDF Document
	//Beginning Buffer to save PHP variables and HTML tags
	ob_start(); 
		echo $content;
	$html = ob_get_contents(); //Proses untuk mengambil hasil dari OB..
	ob_end_clean();
	//Here convert the encode for UTF-8, if you prefer the ISO-8859-1 just change for $mpdf->WriteHTML($html);
	$mpdf->WriteHTML(utf8_encode($html));
	$mpdf->Output($nama_dokumen.".pdf" ,'I');
exit;

?>