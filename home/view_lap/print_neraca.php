
<?php
		
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }
if(!empty($_GET['nama'])){ $nama = $_GET['nama']; }else{ $nama = ''; }

$content ="
<div style='margin-left:15;'>  
	<strong> <font size='5'> LAPORAN NERACA </font>  </strong><br> 
	Investor : " .$not." <br>
	Tanggal Cetak : ".date('Y - m - d')." <br>
	<br>
</div>
<table border=0 width=50% align=left style='border:0px; margin-left:10; margin-bottom:20;' >
                                    <thead>
                                        <tr class=head bgcolor='cadetblue'>
                                        	<th width=10% style='text-align : center;'>No</th>
                                            <th width=40% style='text-align : center;' colspan=2>Akun </th>
											<th width=20% style='text-align : center;'>Debit</th>
											<th width=20% style='text-align : center;'>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

if(!empty($_GET['t1'])){ $tgl1 = $_GET['t1']; }else{ $tgl1=date('Y-m-d'); }
if(!empty($_GET['t2'])){ $tgl2 = $_GET['t2']; }else{ $tgl2=date('Y-m-d'); }		
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }							
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select Gol,sum(debit) as debit, sum(kredit) as kredit 
from (
select left(j.no_rekening,1) as Gol,sum(debit) as debit, sum(kredit) as kredit
from tb_ju j 
inner join ( select jp.*,inv.investor from tb_transaksi jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris  
) tra on tra.id_trans=j.id_trans and tra.id_notaris like '%$not%'
where (left(j.no_rekening,1)='5' or left(j.no_rekening,1)='4' or left(j.no_rekening,1)='3')
group by left(j.no_rekening,1)
union
select left(j.no_rekening,1) as Gol,sum(debit) as debit, sum(kredit) as kredit
from tb_d_jp j 
inner join ( select jp.*,inv.investor from tb_jp jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris  
) tra on tra.id_jp=j.id_jp and tra.id_notaris like '%$not%'
where (left(j.no_rekening,1)='5' or left(j.no_rekening,1)='4' or left(j.no_rekening,1)='3')
group by left(j.no_rekening,1)
)tmp group by Gol
") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											$content .= "
											<tr>
                                            <td align='center' colspan='5'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											$content .="
											<tr bgcolor='gainsboro' "; if($n%2==0){ $content .= "class='satu'"; }else{ $content .= "class='dua'"; } $content .=" >
												<td align=center>".$n."</td>
												<td align=left colspan=2>"; if($u['Gol']=='4'){ $content .= "Pendapatan"; }else if($u['Gol']=='3'){ $content .= "Modal awal"; }else{ $content .= "Beban"; } $content .="</td>
												<td align=right>"; if(!empty($u['debit'])){ $content .= number_format($u['debit']); $d=$d+$u['debit']; } $content .="</td>
												<td align=right>"; if(!empty($u['kredit'])){ $content .= number_format($u['kredit']); $k=$k+$u['kredit']; } $content .="</td>
											</tr>";
											
											$n++;
											
											}
											$content .= "<tr bgcolor='linen' >
												<td height=25 align=center colspan=3> <b>( Modal + Pendapatan ) - Rugi Laba </b> </td>
												<td align=center valign=bottom valign=bottom colspan=2 ><h4><br>";  $content .= "( ".number_format($k); $content .=" - ".number_format($d)." )"; $pm=$k-$d; $content .= "</h4></td>
											</tr>
											<tr style='border:0px;' bgcolor='linen'>
												<td align=center colspan=3><b>Perbahan modal =</b></td>
												<td colspan='2' bgcolor='moccasin' align=center valign=bottom><h3><font color='green'>".number_format($pm)."</font></h3></td>
											</tr>";;
										}
										
                         $content .= "</tbody>
</table>";
session_start();
if($_SESSION['level']!='investor')
{

$content .= "<table border=0 width=70% align=left style='border:0px; margin-left:10;'>
                                    <thead>
                                        <tr class='head'  bgcolor='cadetblue' >
                                        	<th width=2% style='text-align : center;'>No</th>
                                            <th width=5% style='text-align : center;'>No Rek</th>
                                            <th width=10% style='text-align : center;'>Nama Rek</th>
											<th width=5% style='text-align : center;'>AKTIVA</th>
											<th width=5% style='text-align : center;'>PASIVA + MODAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>";

									$debit = 0;
									$kredit =0;
	
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }							
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select no_rekening,rekening,id_notaris,investor,sum(debit) as debit,sum(kredit) as kredit 
from
(
select r.*,investor,tgl_trans as tgl,ket,debit,kredit,id_notaris
from tb_ju j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_transaksi jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_trans=j.id_trans
where left(j.no_rekening,1)='1' or left(j.no_rekening,1)='2'  
union
select r.*,investor,tgl,ket,debit,kredit,id_notaris
from tb_d_jp j 
left join tb_rekening r on r.no_rekening=j.no_rekening
left join ( select jp.*,inv.investor from tb_jp jp left join (select i.investor,p.id_notaris from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=jp.id_notaris
) tra on tra.id_jp=j.id_jp
where left(j.no_rekening,1)='1' or left(j.no_rekening,1)='2' 
)neraca 
where id_notaris like '%$not%'									
group by no_rekening,rekening
") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											$content .= "
											<tr>
                                            <td align='center' colspan='6'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											$content .="
											<tr bgcolor='gainsboro' "; if($n%2==0){ $content .= "class='satu'"; }else{ $content .= "class='dua'"; } $content .=" >
												<td align=center>".$n."</td>
												<td align=center>".$u['no_rekening']."</td>
												<td align=left>".$u['rekening']."</td>
												<td align=right>"; if(substr($u['no_rekening'],0,1)=='1' or substr($u['no_rekening'],0,1)=='5'){ $content .= number_format($u['debit']-$u['kredit']);  } $content .="</td>
												<td align=right>"; if(substr($u['no_rekening'],0,1)!='1' and substr($u['no_rekening'],0,1)!='5'){ $content .= number_format($u['kredit']-$u['debit']);  } $content .="</td>
											</tr>";

											if(substr($u['no_rekening'],0,1)=='2'){ $kredit=$kredit+($u['kredit']-$u['debit']); }
											else {
												$debit = $debit+($u['debit']-$u['kredit']);
											}
											$n++;
											
											}
										}
											$content .="
											<tr  bgcolor='gainsboro' "; if($n%2==0){ $content .= "class='satu'"; }else{ $content .= "class='dua'"; } $content .=" >
												<td align=center>".$n."</td>
												<td align=center></td>
												<td align=left> <b>Perubahan Modal</b></td>
												<td align=right></td>
												<td align=right>".number_format($pm)."</td>
											</tr> 
											<tr >
												<td align=center colspan=3 height='30'  style='border:0px;'  > </td>
												<td align=center bgcolor='powderblue' ><strong>".number_format($debit)."</strong></td>
												<td align=center bgcolor='powderblue' ><strong>".number_format($kredit+$pm)."</strong></td>
											</tr>";
											
                                  $content .=  "</tbody>
</table>";
}
	
	$tglnow = date('Y - m - d');

	if($_POST['format']=='1') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_neraca_$tglnow.doc");
		header("Pragma: no-cache");
		header("Expires: 0");
		echo $content;
	}
	elseif($_POST['format']=='2') {
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=lap_neraca_$tglnow.xls");
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