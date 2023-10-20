<table border=1 width="98%" align="center" style="border:0px;">
                                    <thead>
                                        <tr class="head" >
                                            <th width="15%" rowspan="2" style="text-align : center;">Nama Akun</th>
											<th width="7%"  colspan="2" style="text-align : center;">Neraca Saldo</th>
                                            <th width="7%"  colspan="2" style="text-align : center;">AJP</th>
                                            <th width="7%"  colspan="2" style="text-align : center;">NSDS</th>
                                            <th width="7%"  colspan="2" style="text-align : center;">Ikthisar R / L</th>
                                            <th width="7%"  colspan="2" style="text-align : center;">Neraca</th>
                                        </tr>
                                        <tr class="head" >
											<th width="7%" style="text-align : center;">Debit</th>
                                            <th width="7%" style="text-align : center;">Kredit</th>
                                            <th width="7%" style="text-align : center;">Debit</th>
											<th width="7%" style="text-align : center;">Kredit</th>
                                            <th width="7%" style="text-align : center;">Debit</th>
											<th width="7%" style="text-align : center;">Kredit</th>
                                            <th width="7%" style="text-align : center;">Debit</th>
											<th width="7%" style="text-align : center;">Kredit</th>
                                            <th width="7%" style="text-align : center;">Debit</th>
											<th width="7%" style="text-align : center;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
										
$thn = $_GET['thn'];
$not = $_GET['not'];		
//$nama = $_GET['nama'];						
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
											echo "
											<tr>
                                            <td align='center' colspan='9'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; 
											$sd=0; $sk=0; $pd=0; $pk=0; $dd=0; $dk=0; $id=0; $ik=0; $nd=0; $nk=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											if( (abs($u['j_umum'])+abs($u['jpd']+$u['jpk']))>0 ){	
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=left>".$u['rekening']."</td>
												<td align=right>"; if( !empty($u['j_umum']) and (substr($u['no_rekening'], 0,1)=='1' or substr($u['no_rekening'], 0,1)=='5')){ echo number_format($u['j_umum']); $sd=$sd+$u['j_umum']; } echo "</td>
												<td align=right>"; if( !empty($u['j_umum']) and (substr($u['no_rekening'], 0,1)!='1' and substr($u['no_rekening'], 0,1)!='5')){ echo number_format($u['j_umum']); $sk=$sk+$u['j_umum']; } echo "</td>

												<td align=right>"; if(!empty($u['jpd'])){ echo number_format($u['jpd']);  $pd=$pd+$u['jpd']; } echo "</td>
												<td align=right>"; if(!empty($u['jpk'])){ echo number_format($u['jpk']);  $pk=$pk+$u['jpk']; } echo "</td>

												<td align=right>"; 
												if( ( (substr($u['no_rekening'], 0,1)=='1' or substr($u['no_rekening'], 0,1)=='5') and ($u['j_umum']+($u['jpd']-$u['jpk']))>0 ) or 
												    (substr($u['no_rekening'], 0,1)!='1' and substr($u['no_rekening'], 0,1)!='5' and ($u['j_umum']+($u['jpd']-$u['jpk']))<0 ) )
													{ echo number_format(abs($u['j_umum']+($u['jpd']-$u['jpk']))); 
													$dd=$dd+abs($u['j_umum']+($u['jpd']-$u['jpk'])); } echo "</td>
												<td align=right>"; 
												if( ( (substr($u['no_rekening'], 0,1)=='1' or substr($u['no_rekening'], 0,1)=='5') and ($u['j_umum']+($u['jpd']-$u['jpk']))<0 ) or 
												    (substr($u['no_rekening'], 0,1)!='1' and substr($u['no_rekening'], 0,1)!='5' and ($u['j_umum']+($u['jpk']-$u['jpd']))>0 ) )
													{ echo number_format(abs($u['j_umum']+($u['jpk']-$u['jpd']))); 
													$dk=$dk+abs($u['j_umum']+($u['jpk']-$u['jpd'])); } echo "</td>

												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='5' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))>0) or (substr($u['no_rekening'], 0,1)=='4' and 
													($u['j_umum']+($u['jpk']-$u['jpd']))<0) )
													{ echo number_format(abs($u['j_umum']+($u['jpd']-$u['jpk'])));
													$id=$id+abs($u['j_umum']+($u['jpd']-$u['jpk'])); } echo "</td>
												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='5' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))<0) or (substr($u['no_rekening'], 0,1)=='4' and 
													($u['j_umum']+($u['jpk']-$u['jpd']))>0) )
													{ echo number_format(abs($u['j_umum']+($u['jpk']-$u['jpd']))); 
													$ik=$ik+abs($u['j_umum']+($u['jpk']-$u['jpd'])); } echo "</td>

												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='1' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))>0) or ( (substr($u['no_rekening'], 0,1)=='2' or substr($u['no_rekening'], 0,1)=='3' ) and 
													($u['j_umum']+($u['jpk']-$u['jpd']))<0) )
													{ echo number_format(abs($u['j_umum']+($u['jpd']-$u['jpk']))); 
													$nd=$nd+abs($u['j_umum']+($u['jpd']-$u['jpk'])); } echo "</td>
												<td align=right>"; if( (substr($u['no_rekening'], 0,1)=='1' and 
													($u['j_umum']+($u['jpd']-$u['jpk']))<0) or ( (substr($u['no_rekening'], 0,1)=='2' or substr($u['no_rekening'], 0,1)=='3' ) and 
													($u['j_umum']+($u['jpk']-$u['jpd']))>0) )
													{ echo number_format(abs($u['j_umum']+($u['jpk']-$u['jpd']))); 
													$nk=$nk+($u['j_umum']+($u['jpk']-$u['jpd'])); } echo "</td>
											</tr>";

											$n++;
											}
											}
											echo "
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
									?>	
                                    </tbody>
</table>
</br>


<form name='lpengadaan' method="post" action='view_lap/print_neraca_lajur.php?thn=<?php echo $thn; ?>&not=<?php echo $not; ?>&nama=<?php echo 
$nama; ?>' target='_blank'>

					<table border='0'  style="margin-left:10;">
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