	<?php 
		if(!empty($_GET['hal'])){ $hal=$_GET['hal']*30; }else{ $hal=0; } 
		if(!empty($_GET['kunci'])){ $cari ="where i.investor like '".$_GET['kunci']."%' or p.id_notaris like '".$_GET['kunci']."' "; }else{ $cari=''; }
	?>
							<button style="margin-left:25px;">
                               <a href="#" style="text-decoration: none;" onclick="tampil('formperjanjian','','','')" > Tambah perjanjian </a>
                            </button> </br>	</br>		
                                <table border=1 width="98%" align="center">
                                    <thead>
                                        <tr class="head" >
                                            <th width="2%" style="text-align : center;">NO</th>
                                            <th width="8%" style="text-align : center;">ID Notaris</th>
											<th width="10%" style="text-align : center;">Investor</th>
											<th width="10%" style="text-align : center;">Tgl Perjanjian</th>
											<th width="10%" style="text-align : center;">Jumlah <br> Investasi</th>
											<th width="10%" style="text-align : center;">Mulai<br> kontrak</th>
											<th width="10%" style="text-align : center;">Akhir<br> kontrak </th>
											<th width="10%" style="text-align : center;">Keterangan</th>
											<th width="10%" style="text-align : center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	
									require_once "koneksi.php"; 
									$cariagt = mysqli_query($con,"select * from tb_perjanjian p inner join tb_investor i on i.id_investor=p.id_investor $cari order by id_notaris desc limit $hal,30") or die('gagal pencarian data !'); 
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
												<td align=center>".$u['id_notaris']."</td>
												<td align=center>".$u['investor']."</td>
												<td align=center>".$u['tgl_perjanjian']."</td>
												<td align=center>".number_format($u['jumlah_investasi'])."</td>
												<td align=center>".$u['tglmulai_kontrak']."</td>
												<td align=center>".$u['tglakhir_kontrak']."</td>
												<td align=center>".$u['ket_investasi']."</td>
												<td align=center>"; ?>
														<a href ='#'onclick="javascript:konfir_hapus('man/m_perjanjian.php','<?php echo $u['id_notaris']; ?>','tabelperjanjian','<?php echo $hal; ?>');"><img src='icon/delete.png' width='20' height='20' align='center'/></a>
														<a href ='#'onclick="javascript:tampil('formperjanjian&id=<?php echo $u['id_notaris']; ?>','','','')"><img src='icon/edit.png' width='20' height='20' align='center'/>edit</a>
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
													?>  <a href="#" onclick="javascript:tampil('tabelperjanjian','<?php echo $i; ?>','','')"><?php echo $i+1; ?></a> 
										<?php
												}
									}			
								?>	
								</center>	