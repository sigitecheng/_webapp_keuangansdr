<table border=1 width="98%" align="center" style="border:0px;">
                                    <thead>
                                        <tr class="head" >
                                        	<th width="2%" style="text-align : center;">No</th>
											<th width="5%" style="text-align : center;">tgl transaksi</th>
                                            <th width="5%" style="text-align : center;">No Rek</th>
                                            <th width="10%" style="text-align : center;">Nama Rek</th>
											<th width="10%" style="text-align : center;">Ket Dana</th>
											<th width="10%" style="text-align : center;">Ket Transaksi</th>
											<th width="5%" style="text-align : center;">Debit</th>
											<th width="5%" style="text-align : center;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	

if(!empty($_GET['t1'])){ $tgl1 = $_GET['t1']; }else{ $tgl1=date('Y-m-d'); }
if(!empty($_GET['t2'])){ $tgl2 = $_GET['t2']; }else{ $tgl2=date('Y-m-d'); }		
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }							
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
											echo "
											<tr>
                                            <td align='center' colspan='9'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".$n."</td>
												<td align=center>".$u['tgl']."</td>
												<td align=center>".$u['no_rekening']."</td>
												<td align=left>".$u['rekening']."</td>
												<td align=left>"; if(empty($u['investor'])){ echo "Dana Perusahaan"; $inv = "Semua"; }else{ echo $u['investor']; $inv = $u['investor']; } echo "</td>
												<td align=left>".$u['ket']."</td>
												<td align=right>"; if(!empty($u['debit'])){ echo number_format($u['debit']); $d=$d+$u['debit']; } echo"</td>
												<td align=right>"; if(!empty($u['kredit'])){ echo number_format($u['kredit']); $k=$k+$u['kredit']; } echo"</td>
											</tr>";
											
											$n++;
											
											}
											echo "<tr  >
												<td height=25 align=center colspan=6></td>
												<td bgcolor='powderblue' align=right valign=bottom><h4>";  echo number_format($d); echo "</h4></td>
												<td bgcolor='powderblue' align=right valign=bottom><h4>";  echo number_format($k); echo "</h4></td>
											</tr>
											<tr style='border:0px;' >
												<td style='border:0px;' align=center colspan=6></td>
												<td colspan='2' bgcolor='moccasin' align=center valign=bottom><h2><font color='green'>".number_format($k-$d)."</font></h2></td>
											</tr>";;
										}
									?>	
                                    </tbody>
</table>
</br>


<form name='lpengadaan' method="post" action='view_lap/print_rugilaba.php?t1=<?php echo $tgl1 ?>&t2=<?php echo $tgl2; ?>&not=<?php echo $not; ?>&nama=<?php echo $inv; ?>' target='_blank'>

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