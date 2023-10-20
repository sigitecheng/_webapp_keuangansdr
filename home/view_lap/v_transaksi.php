<table border=1 width="98%" align="center" style="border:0px;">
                                    <thead>
                                        <tr class="head" >
                                        	<th width="1%" style="text-align : center;">No</th>
											<th width="2%" style="text-align : center;">tgl transaksi</th>
                                            <th width="10%" style="text-align : center;">Ket. Dana</th>
                                            <th width="20%" style="text-align : center;">Ket. Transaksi</th>
											<th width="10%" style="text-align : center;">No Bukti</th>
											<th width="5%" style="text-align : center;">user</th>
											<th width="5%" style="text-align : center;">Jumlah transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	

if(!empty($_GET['t1'])){ $tgl1 = $_GET['t1']; }else{ $tgl1=date('Y-m-d'); }
if(!empty($_GET['t2'])){ $tgl2 = $_GET['t2']; }else{ $tgl2=date('Y-m-d'); }		
if(!empty($_GET['not'])){ $not = $_GET['not']; }else{ $not = ''; }						
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
											echo "
											<tr>
                                            <td align='center' colspan='7'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; $d=0; $k=0;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".$n."</td>
												<td align=center>".$u['tgl_trans']."</td>
												<td align=left>"; 
												if(empty($u['investor'])){ echo "Dana Perusahaan"; $inv = "Semua"; }else{ echo $u['investor']; $inv = $u['investor']; } echo "</td>
												<td align=left>".$u['ket']."</td>
												<td align=left>".$u['no_bukti']."</td>
												<td align=center>".$u['nama']."</td>
												<td align=right>".number_format($u['jml'])."</td>
											</tr>";
											$n++;
											
											}
										}
									?>	
                                    </tbody>
</table>
</br>


<form name='lpengadaan' method="post" action='view_lap/print_transaksi.php?t1=<?php echo $tgl1 ?>&t2=<?php echo $tgl2; ?>&not=<?php echo $not; ?>&nama=<?php echo $inv; ?>' target='_blank'>

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