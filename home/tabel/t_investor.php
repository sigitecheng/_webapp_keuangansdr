	<?php 
		if(!empty($_GET['hal'])){ $hal=$_GET['hal']*30; }else{ $hal=0; } 
		if(!empty($_GET['kunci'])){ $cari ="where investor like '".$_GET['kunci']."%' "; }else{ $cari=''; }
	?>
							<button style="margin-left:25px;">
                               <a href="#" style="text-decoration: none;" onclick="tampil('forminvestor','','','')" > Tambah investor </a>
                            </button> </br>	</br>		
                                <table border=1 width="98%" align="center">
                                    <thead>
                                        <tr class="head" >
                                            <th width="2%" style="text-align : center;">NO</th>
                                            <th width="8%" style="text-align : center;">ID investor</th>
											<th width="10%" style="text-align : center;">Nama <br> Investor</th>
											<th width="10%" style="text-align : center;">Alamat</th>
											<th width="10%" style="text-align : center;">Kontak</th>
											<th width="10%" style="text-align : center;">Email</th>
											<th width="10%" style="text-align : center;">Username</th>
											<th width="10%" style="text-align : center;">Password</th>
											<th width="10%" style="text-align : center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	
									require_once "koneksi.php"; 
									$cariagt = mysqli_query($con,"select * from tb_investor $cari order by id_investor desc limit $hal,30") or die('gagal pencarian data !'); 
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
												<td align=center>".$u['id_investor']."</td>
												<td align=center>".$u['investor']."</td>
												<td align=center>".$u['alamat']."</td>
												<td align=center>".$u['no_hp']."</td>
												<td align=center>".$u['email']."</td>
												<td align=center>".$u['username']."</td>
												<td align=center>".$u['password']."</td>
												<td align=center>"; ?>
														<a href ='#'onclick="javascript:konfir_hapus('man/m_investor.php','<?php echo $u['id_investor']; ?>','tabelinvestor','<?php echo $hal; ?>');"><img src='icon/delete.png' width='20' height='20' align='center'/></a>
														<a href ='#'onclick="javascript:tampil('forminvestor&id=<?php echo $u['id_investor']; ?>','','','')"><img src='icon/edit.png' width='20' height='20' align='center'/>edit</a>
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
                        		        $jml = mysqli_query($con,"select ceil(count(*)/30) as jml from tb_investor $cari"); 
		                                $j_hal= mysqli_fetch_assoc($jml); $jml_hal=$j_hal['jml']; 

		                            if($jml_hal > 1){     
												for ($i=0; $i < $jml_hal; $i++) { 
													?>  <a href="#" onclick="javascript:tampil('tabelinvestor','<?php echo $i; ?>','','')"><?php echo $i+1; ?></a> 
										<?php
												}
									}			
								?>	
								</center>	