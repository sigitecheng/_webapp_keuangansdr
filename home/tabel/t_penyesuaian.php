	<?php 
		if(!empty($_GET['hal'])){ $hal=$_GET['hal']*30; }else{ $hal=0; } 
		if(!empty($_GET['kunci'])){ $cari ="where i.investor like '".$_GET['kunci']."%' or p.id_notaris like '".$_GET['kunci']."' "; }else{ $cari=''; }
	?>
							<button style="margin-left:25px;">
                               <a href="#" style="text-decoration: none;" onclick="tampil('formpenyesuaian','','','')" > Tambah Penyesuaian </a>
                            </button> </br>	</br>		
                                <table border=1 width="95%" align="center">
                                    <thead>
                                        <tr class="head" >
                                            <th width="2%" style="text-align : center;">NO</th>
                                            <th width="8%" style="text-align : center;">ID Trans</th>
                                            <th width="8%" style="text-align : center;">Tgl Trans</th>
											<th width="15%" style="text-align : center;">Ket.<br> Transaksi</th>
											<th width="15%" style="text-align : center;">Ket. Pengeluaran</th>
											<th width="10%" style="text-align : center;">User</th>
											<th width="10%" style="text-align : center;">Biaya Keluar</th>
											<th width="10%" style="text-align : center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	
									require_once "koneksi.php"; 
									$cariagt = mysqli_query($con,"select t.*,j.jml,inv.*,b.nama from tb_jp t 
									left join (select i.investor,p.id_notaris,p.tglmulai_kontrak,p.tglakhir_kontrak,p.ket_investasi from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor)inv on inv.id_notaris=t.id_notaris
									inner join (select id_jp,sum(debit) as jml from tb_d_jp group by id_jp) j on j.id_jp=t.id_jp 
									left join tb_bendahara b on b.id_bendahara=t.id_bendahara
									order by id_jp desc limit $hal,30") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											echo "
											<tr>
                                            <td align='center' colspan='9'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1;
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".($n+$hal)."</td>
												<td align=center>".$u['id_jp']."</td>
												<td align=center>".$u['tgl']."</td>
												<td align=center>"; if(empty($u['investor'])){ echo "Dana Perusahaan"; }else{ echo $u['investor'].", (".$u['ket_investasi'].")"; } echo "</td>
												<td align=center>".$u['ket']."</td>
												<td align=center>".$u['nama']."</td>
												<td align=right><div style='margin-right:5%;'>".number_format($u['jml'])."</div></td>
												<td align=center>"; ?>
														<a href ='#'onclick="javascript:konfir_hapus('man/m_penyesuaian.php','<?php echo $u['id_jp']; ?>','ttranspenyesuaian','<?php echo $hal; ?>');"><img src='icon/delete.png' width='20' height='20' align='center'/></a>
														<a href ='#'onclick="javascript:tampil('formpenyesuaian&id=<?php echo $u['id_jp']; ?>','','','')"><img src='icon/edit.png' width='20' height='20' align='center'/>edit</a><br>
														<a href ='view_lap/print_nota_penyesuaian.php?id=<?php echo $u['id_jp']; ?>' target="_blank" style="padding-top:10;" ><img src='icon/nota.ico' width='20' height='20' align='center'/>Nota</a>
										<?php echo "</td>
											</tr>";
											$n++;
											}
										}
									?>	
                                    </tbody>
                                </table><br><br><br>

                                <center> 	
                                <?php
                        		        $jml = mysqli_query($con,"select ceil(count(*)/30) as jml from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor $cari"); 
		                                $j_hal= mysqli_fetch_assoc($jml); $jml_hal=$j_hal['jml']; 

		                            if($jml_hal > 1){     
												for ($i=0; $i < $jml_hal; $i++) { 
													?>  <a href="#" onclick="javascript:tampil('ttranspengeluaran','<?php echo $i; ?>','','')"><?php echo $i+1; ?></a> 
										<?php
												}
									}			
								?>	
								</center>	