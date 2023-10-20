<table border=1 width="98%" align="center" style="border:0px;">
                                    <thead>
                                        <tr class="head" >
                                        	<th width="1%" style="text-align : center;">No</th>
                                            <th width="1%" style="text-align : center;">Dari</th>
											<th width="5%" style="text-align : center;">tgl transaksi</th>
                                            <th width="5%" style="text-align : center;">No Rek</th>
                                            <th width="20%" style="text-align : center;">Nama Rek</th>
											<th width="20%" style="text-align : center;">Ket Dana</th>
											<th width="40%" style="text-align : center;">Ket Transaksi</th>
											<th width="10%" style="text-align : center;">Debit</th>
											<th width="10%" style="text-align : center;">Kredit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 
										
$rek = $_GET['rek'];
$thn = $_GET['thn'];		
$not = $_GET['not'];
$nama = '';							
									require_once "../koneksi.php"; 
									$cariagt = mysqli_query($con,"
select '' as dari,'' as no_rekening, '' as rekening,'' as tgl, 'Saldo Tahun Lalu' as ket,
sum(debit) as debit,sum(kredit)as kredit from
(
select COALESCE(debit,0)as debit,COALESCE(kredit,0)as kredit
from tb_ju j 
INNER join tb_transaksi tra on tra.id_trans=j.id_trans
where j.no_rekening='$rek' and year(tra.tgl_trans)<'$thn' and tra.id_notaris like '%$not%'
union
select COALESCE(debit,0)as debit,COALESCE(kredit,0)as kredit
from tb_d_jp j 
INNER join tb_jp tra on tra.id_jp=j.id_jp
where j.no_rekening='$rek' and year(tgl)<'$thn' and tra.id_notaris like '%$not%'
)tmp
UNION ALL
select 'JU' as dari,r.*,tgl_trans as tgl,ket,debit,kredit
from tb_ju j 
left join tb_rekening r on r.no_rekening=j.no_rekening
INNER join tb_transaksi tra on tra.id_trans=j.id_trans
where j.no_rekening='$rek' and year(tgl_trans)='$thn' and tra.id_notaris like '%$not%'
union
select 'JP' as dari,r.*,tgl,ket,debit,kredit
from tb_d_jp j 
left join tb_rekening r on r.no_rekening=j.no_rekening
INNER join tb_jp tra on tra.id_jp=j.id_jp
where j.no_rekening='$rek' and year(tgl)='$thn' and tra.id_notaris like '%$not%'
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

												echo "
												<tr height=25 "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center colspan='7'><strong style='margin-right:10;'> Saldo tahun "; echo ($thn-1)." </Strong> </td>
												<td align=right>"; echo number_format($seb_d); echo"</td>
												<td align=right>"; echo number_format($seb_k); echo"</td>
												</tr>"; 
											 }	
											 else
											 {	
											echo"

											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".$n."</td>
												<td align=center>".$u['dari']."</td>
												<td align=center>".$u['tgl']."</td>
												<td align=center>".$u['no_rekening']."</td>
												<td align=left>".$u['rekening']."</td>
												<td align=left>"; if(empty($u['investor'])){ echo "Dana Perusahaan"; }else{ echo $u['investor']; } echo "</td>
												<td align=left>".$u['ket']."</td>
												<td align=right>"; if(!empty($u['debit'])){ echo number_format($u['debit']); $d=$d+$u['debit']; } echo"</td>
												<td align=right>"; if(!empty($u['kredit'])){ echo number_format($u['kredit']); $k=$k+$u['kredit']; } echo"</td>
											</tr>";
											$n++;
											$nama = $u['rekening'];
											}
										}
											echo "
											<tr  >
												<td style='border:0px;' align=center colspan=7></td>
												<td align=center valign=bottom><h3>";  echo number_format($d); echo"<h3></td>
												<td align=center valign=bottom><h3>";  echo number_format($k); echo"</h3></td>
											</tr>
											<tr style='border:0px;' >
												<td style='border:0px;' align=center colspan=7></td>
												<td align=center valign=bottom colspan=2><h2><font color='green'> ";  
												if( (substr($rek, 0,1)=='1') or (substr($rek, 0,1)=='5') ){ echo number_format($d-$k); }else{ echo number_format($k-$d); }
												echo"</font></h2></td>
											</tr>";
										}
									?>	
                                    </tbody>
</table>
</br>


<form name='lpengadaan' method="post" action='view_lap/print_buku_besar.php?rek=<?php echo $rek ?>&thn=<?php echo $thn; ?>&nama=<?php echo $nama; ?>&not=<?php echo $not; ?>' target='_blank'>

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