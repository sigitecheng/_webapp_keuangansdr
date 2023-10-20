
<?php


include "../fungsi/terbilang.php";		
if(!empty($_GET['id'])){ $id = $_GET['id']; }else{ $id = ''; }

$content ="
<div style='margin-left:120;'>  
	<strong> <font size='5'> BUKTI PEMINDAHAN KAS </font>  </strong>
</div> 
<hr>
<br><br>
<table border=0 width=100% align=left style='border:0px; margin-left:10;'>";

									$debit = 0;
									$kredit =0;
	
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }							
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"select t.*,j.jml,inv.*,b.nama from tb_transaksi t 
									left join (select i.investor,p.id_notaris,p.tglmulai_kontrak,p.tglakhir_kontrak,p.ket_investasi from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=t.id_notaris
									inner join (select id_trans,sum(kredit) as jml from tb_ju group by id_trans) j on j.id_trans=t.id_trans 
									left join tb_bendahara b on b.id_bendahara=t.id_bendahara
									where t.id_trans='$id'
") or die('gagal pencarian data !'); 
										
											$u = mysqli_fetch_assoc($cariagt);
											 
											$content .="
											<tr  bgcolor='beige' class='satu' >
												<td align=left width=40%>ID Transaksi </td>
												<td > : ".$u['id_trans']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=left width=30%>Tgl Transaksi </td>
												<td align=left>: ".$u['tgl_trans']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=left width=30%>No Bukti </td>
												<td align=left>: ".$u['no_bukti']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=left width=30%>Keterangan </td>
												<td align=left>: ".$u['ket']."</td>
											</tr>
											<tr  bgcolor='beige' class='satu' >
												<td align=left width=30%>Pendapatan kepada</td>
												<td align=left>: "; if(empty($u['investor'])){ $content .="Perusahaan"; }else{ $content .=$u['investor']; } $content .=" </td>
											</tr>
											";
											
                                  $content .=  "</tbody>
</table><br>
<table border='0' width=100% align=left style='border:0px; margin-left:10;'>";
				$tot_deb = 0;
				$tot_kred = 0;
				$edit_id = ''; 
				$n=0;

				 $content .= "
					<tr class='dua' >					
					<td align=center bgcolor='darkcyan' height='30'> <b>Keterangan</b> </td>
					<td align=center bgcolor='darkcyan'><b> Debit</b></td>
					<td align=center bgcolor='darkcyan'><b> Kredit</b></td>
					</tr>";

					if(!empty($_GET['id']))
					{	$edit_id = $_GET['id'];
					$cariju = mysqli_query($con,"select * from tb_ju j inner join tb_rekening r on r.no_rekening=j.no_rekening where id_trans='$edit_id' ") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariju)>0)
										{	
										 $n=1;
											while($u = mysqli_fetch_assoc($cariju))
											{ 
 $content .= "
					<tr class='dua'>					
					<td bgcolor='beige' >"; $content .= $u['rekening']; $content .=" </td>
					<td align=center bgcolor='gainsboro' >"; $content .= number_format($u['debit']); $content .=" </td>
					<td align=center bgcolor='gainsboro' >"; $content .= number_format($u['kredit']); $content .=" </td>
					</tr>";

					$tot_deb = $tot_deb+$u['debit'];
					$tot_kred = $tot_kred+$u['kredit'];
					$n++;
											}

										}
					}
					 $content .= "
					<tr class='dua'>					
					<td  > </td>
					<td align=center bgcolor='powderblue'><b>"; $content .= number_format($tot_deb); $content .=" </b></td>
					<td align=center bgcolor='powderblue'><b>"; $content .= number_format($tot_kred); $content .=" </b></td>
					</tr>";

$content .= "</table> <br><br><br><br> 
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