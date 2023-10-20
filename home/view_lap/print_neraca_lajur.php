
<?php

$not = $_GET['not'];
$ket = $not;
if(empty($not)){ $ket='Semua dana'; }
$thn = $_GET['thn'];
//$nama = $_GET['nama'];

$content ="
<div style='margin-left:15;'>  
	<strong > <font size='5'> LAPORAN NERACA LAJUR </font> </br> </strong> 
	( ".$thn." )<br>
	Notaris : ".$ket." <br>
	Tanggal Cetak : ".date('Y - m - d')." <br>
	<br>
</div>
</hr>
<table border=0 width=98% align=center>
                                    <thead >
                                        <tr class=head  bgcolor='powderblue'  >
                                            <th width=15% rowspan=2 style=text-align : center;>Nama Akun</th>
											<th width=7%  colspan=2 style=text-align : center;>Neraca Saldo</th>
                                            <th width=7%  colspan=2 style=text-align : center;>AJP</th>
                                            <th width=7%  colspan=2 style=text-align : center;>NSDS</th>
                                            <th width=7%  colspan=2 style=text-align : center;>Ikthisar R / L</th>
                                            <th width=7%  colspan=2 style=text-align : center;>Neraca</th>
                                        </tr>
                                        <tr class=head  bgcolor='powderblue'  >
											<th width=7% style=text-align : center;>Debit</th>
                                            <th width=7% style=text-align : center;>Kredit</th>
                                            <th width=7% style=text-align : center;>Debit</th>
											<th width=7% style=text-align : center;>Kredit</th>
                                            <th width=7% style=text-align : center;>Debit</th>
											<th width=7% style=text-align : center;>Kredit</th>
                                            <th width=7% style=text-align : center;>Debit</th>
											<th width=7% style=text-align : center;>Kredit</th>
                                            <th width=7% style=text-align : center;>Debit</th>
											<th width=7% style=text-align : center;>Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>";									
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select r.*, 
case when (LEFT(r.no_rekening,1)=1 or LEFT(r.no_rekening,1)=5) then COALESCE(ju.debit,0)-COALESCE(ju.kredit,0) else COALESCE(ju.kredit,0)-COALESCE(ju.debit,0) end as j_umum, jp.debit as jpd,jp.kredit as jpk 
from tb_rekening r 
LEFT JOIN (SELECT no_rekening,sum(debit)as debit,sum(kredit) as kredit from tb_ju j
            inner join tb_transaksi t on t.id_trans=j.id_trans and year(tgl_trans)<='$thn' and t.id_notaris like '%$not%'
            GROUP by no_rekening)ju on ju.no_rekening=r.no_rekening
LEFT JOIN (SELECT no_rekening,sum(debit)as debit,sum(kredit) as kredit from tb_d_jp j 
           inner join tb_jp t on t.id_jp=j.id_jp and year(tgl)='$thn' and t.id_notaris like '%$not%'              
           GROUP by no_rekening)jp on jp.no_rekening=r.no_rekening 
") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											$content .="
											<tr>
                                            <td align='center' colspan='9'>Data kosong..</td>
											</tr>
											";
										}
										else { $n=1; 
											$sd=0; $sk=0; $pd=0; $pk=0; $dd=0; $dk=0; $id=0; $ik=0; $nd=0; $nk=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											if( (abs($u['j_umum'])+abs($u['jpd']+$u['jpk']))>0 ){	
											$content .="
											<tr bgcolor='gainsboro' "; if($n%2==0){ $content .= "class='satu'"; }else{ $content .= "class='dua'"; } $content .=" >
												<td align=left>".$u['rekening']."</td>
												<td align=right>"; if( !empty($u['j_umum']) and (substr($u['no_rekening'], 0,1)=='1' or substr($u['no_rekening'], 0,1)=='5')){ $content .= number_format($u['j_umum']); $sd=$sd+$u['j_umum']; } $content .= "</td>
												<td align=right>"; if( !empty($u['j_umum']) and (substr($u['no_rekening'], 0,1)!='1' and substr($u['no_rekening'], 0,1)!='5')){ $content .= number_format($u['j_umum']); $sk=$sk+$u['j_umum']; } $content .= "</td>

												<td align=right>"; if(!empty($u['jpd'])){ $content .= number_format($u['jpd']);  $pd=$pd+$u['jpd']; } $content .= "</td>
												<td align=right>"; if(!empty($u['jpk'])){ $content .= number_format($u['jpk']);  $pk=$pk+$u['jpk']; } $content .= "</td>

												<td align=right>"; 
												if( ( (substr($u['no_rekening'], 0,1)=='1' or substr($u['no_rekening'], 0,1)=='5') and ($u['j_umum']+($u['jpd']-$u['jpk']))>0 ) or 
												    (substr($u['no_rekening'], 0,1)!='1' and substr($u['no_rekening'], 0,1)!='5' and ($u['j_umum']+($u['jpd']-$u['jpk']))<0 ) )
													{ $content .= number_format($u['j_umum']+($u['jpd']-$u['jpk'])); 
													$dd=$dd+abs($u['j_umum']+($u['jpd']-$u['jpk'])); } $content .= "</td>
												<td align=right>"; 
												if( ( (substr($u['no_rekening'], 0,1)=='1' or substr($u['no_rekening'], 0,1)=='5') and ($u['j_umum']+($u['jpd']-$u['jpk']))<0 ) or 
												    (substr($u['no_rekening'], 0,1)!='1' and substr($u['no_rekening'], 0,1)!='5' and ($u['j_umum']+($u['jpk']-$u['jpd']))>0 ) )
													{ $content .= number_format($u['j_umum']+($u['jpk']-$u['jpd'])); 
													$dk=$dk+abs($u['j_umum']+($u['jpk']-$u['jpd'])); } $content .= "</td>

												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='5' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))>0) or (substr($u['no_rekening'], 0,1)=='4' and 
													($u['j_umum']+($u['jpk']-$u['jpd']))<0) )
													{ $content .= number_format($u['j_umum']+($u['jpd']-$u['jpk']));
													$id=$id+abs($u['j_umum']+($u['jpd']-$u['jpk'])); } $content .= "</td>
												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='5' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))<0) or (substr($u['no_rekening'], 0,1)=='4' and 
													($u['j_umum']+($u['jpk']-$u['jpd']))>0) )
													{ $content .= number_format($u['j_umum']+($u['jpk']-$u['jpd'])); 
													$ik=$ik+abs($u['j_umum']+($u['jpk']-$u['jpd'])); } $content .= "</td>

												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='1' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))>0) or ( (substr($u['no_rekening'], 0,1)=='2' or substr($u['no_rekening'], 0,1)=='3' ) and 
													($u['j_umum']+($u['jpk']-$u['jpd']))<0) )
													{ $content .= number_format($u['j_umum']+($u['jpd']-$u['jpk'])); 
													$nd=$nd+abs($u['j_umum']+($u['jpd']-$u['jpk'])); } $content .= "</td>
												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='1' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))<0) or ( (substr($u['no_rekening'], 0,1)=='2' or substr($u['no_rekening'], 0,1)=='3' ) and 
													($u['j_umum']+($u['jpk']-$u['jpd']))>0) )
													{ $content .= number_format($u['j_umum']+($u['jpk']-$u['jpd'])); 
													$nk=$nk+($u['j_umum']+($u['jpk']-$u['jpd'])); } $content .= "</td>
											</tr>";

											$n++;
											}
											}
											$content .= "
											<tr height=30 bgcolor='yellow'>
												<td></td>
												<td align=right><strong>".number_format($sd)."</strong></td>
												<td align=right><strong>".number_format($sk)."</strong></td>
												<td align=right><strong>".number_format($pd)."</strong></td>
												<td align=right><strong>".number_format($pk)."</strong></td>
												<td align=right><strong>".number_format($dd)."</strong></td>
												<td align=right><strong>".number_format($dk)."</strong></td>
												<td align=right><strong>".number_format($id)."</strong></td>
												<td align=right><strong>".number_format($ik)."</strong></td>
												<td align=right><strong>".number_format($nd)."</strong></td>
												<td align=right><strong>".number_format($nk)."</strong></td>
											</tr>	
											<tr height=30 bgcolor='skyblue'>
												<td colspan=7></td>
												<td colspan=2 align=right><strong>".number_format($ik-$id)."</strong></td>
												<td colspan=2 align=right><strong>".number_format($nd-$nk)."</strong></td>
											</tr>	
											";
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