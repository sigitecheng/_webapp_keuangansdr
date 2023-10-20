<br><br>
<table border=1 width="50%" align="left" style="border:0px; margin-left:10; margin-bottom:20;">
                                    <thead>
                                        <tr class="head" >
                                        	<th width="2%" style="text-align : center;">No</th>
                                            <th width="40%" style="text-align : center;" colspan="2">Akun </th>
											<th width="20%" style="text-align : center;">Debit</th>
											<th width="20%" style="text-align : center;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	

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
											echo "
											<tr>
                                            <td align='center' colspan='5'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0; $b=0; $m=0; $p=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".$n."</td>
												<td align=left colspan=2>"; if($u['Gol']=='4'){ echo "Pendapatan"; $p=$u['kredit']-$u['debit']; }else if($u['Gol']=='3'){ echo "Modal awal"; $m=$u['kredit']-$u['debit']; }else{ echo "Beban"; $b=$u['debit']-$u['kredit']; }
											    echo"</td>
												<td align=right>"; if(!empty($u['debit'])){ echo number_format($u['debit']); $d=$d+$u['debit']; } echo"</td>
												<td align=right>"; if(!empty($u['kredit'])){ echo number_format($u['kredit']); $k=$k+$u['kredit']; } echo"</td>
											</tr>";
											
											$n++;
											
											}
											echo "<tr  >
												<td height=25 align=center colspan=3> <b> Modal + ( Pendapatan  - Beban )</b> </td>
												<td align=center valign=bottom valign=bottom colspan=2 ><h4><br>";  
												echo number_format($m)." + ( ".number_format($p); echo" - ".number_format($b)." )"; $pm=$k-$d; echo "</h4></td>
											</tr>
											<tr style='border:0px;' >
												<td align=center colspan=3><b>Perbahan modal =</b></td>
												<td colspan='2' bgcolor='moccasin' align=center valign=bottom><h3><font color='green'>".number_format($pm)."</font></h3></td>
											</tr>";;
										}
									?>	
                                    </tbody>
</table>

<?php
session_start();
if($_SESSION['level']!='investor')
{
?>

<table border=1 width="70%" align="left" style="border:0px; margin-left:10;">
                                    <thead>
                                        <tr class="head" >
                                        	<th width="2%" style="text-align : center;">No</th>
                                            <th width="5%" style="text-align : center;">No Rek</th>
                                            <th width="10%" style="text-align : center;">Nama Rek</th>
											<th width="5%" style="text-align : center;">AKTIVA</th>
											<th width="5%" style="text-align : center;">PASIVA + MODAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	

									$debit = 0;
									$kredit =0;
	
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }							
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select investor,no_rekening,rekening,id_notaris,investor,sum(debit) as debit,sum(kredit) as kredit 
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
											echo "
											<tr>
                                            <td align='center' colspan='6'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".$n."</td>
												<td align=center>".$u['no_rekening']."</td>
												<td align=left>".$u['rekening']."</td>
												<td align=right>"; if(substr($u['no_rekening'],0,1)=='1' or substr($u['no_rekening'],0,1)=='5'){ echo number_format($u['debit']-$u['kredit']);  } echo"</td>
												<td align=right>"; if(substr($u['no_rekening'],0,1)!='1' and substr($u['no_rekening'],0,1)!='5'){ echo number_format($u['kredit']-$u['debit']);  } echo"</td>
											</tr>";
											$inv = $u['investor'];

											if(substr($u['no_rekening'],0,1)=='2'){ $kredit=$kredit+($u['kredit']-$u['debit']); }
											else {
												$debit = $debit+($u['debit']-$u['kredit']);
											}
											$n++;
											
											}
										
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
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
										}	
									?>		
                                    </tbody>
</table>
</br></br></br></br></br></br></br></br></br>
<?php } ?>
</br></br></br></br></br></br></br></br></br></br></br></br>

<form name='lpengadaan' method="post" action='view_lap/print_neraca.php?not=<?php echo $not; ?>&nama=<?php echo $inv; ?>' target='_blank'>

					<table border='0' style="margin-left:10;">
						<tr style="border:0px;">
							<td style="border:0px;">Format Laporan</td>
							<td style="border:0px;"> :</td>
							<td style="border:0px;">
								<img src = 'icon/word.gif'><input type='radio' name='format' value='1' class='input'>Microsoft Word
								<br>
								<img src = 'icon/excel.gif'><input type='radio' name='format' value='2' class='input'>Microsoft Excel
								<br>
								<img src = 'icon/pdf.png'><input type='radio' name='format' value='3' class='input' checked>PDF
								
							</td>
						</tr>
						<tr style="border:0px;">
							<td style="border:0px;"></td>
							<td style="border:0px;"></td>
							<td style="border:0px;"><br><input class="btn btn-outline btn-success" type='submit' value='View Data' class='button'></td>
						</tr>
						
					</table>

</form>