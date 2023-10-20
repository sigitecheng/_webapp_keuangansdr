	<?php 
		if(!empty($_GET['hal'])){ $hal=$_GET['hal']*30; }else{ $hal=0; } 
		if(!empty($_GET['kunci'])){ $cari ="where rekening like '".$_GET['kunci']."%' or no_rekening like '".$_GET['kunci']."%' "; }else{ $cari=''; }
	?>
							<button style="margin-left:25px;">
                               <a href="#" style="text-decoration: none;" onclick="tampil('formrekening','','','')" > Tambah rekening </a>
                            </button> </br>	</br>		
                                <table border=1 width="95%" align="center">
                                    <thead>
                                        <tr class="head" >
                                            <th width="5%" style="text-align : center;">NO</th>
                                            <th width="10%" style="text-align : center;">NO rekening</th>
											<th width="20%" style="text-align : center;">Golongan</th>
											<th width="50%" style="text-align : center;">Nama Rekening</th>
											<th width="10%" style="text-align : center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	
									require_once "koneksi.php"; 
									$cariagt = mysqli_query($con,"select * from tb_rekening $cari order by no_rekening asc limit $hal,30") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariagt)<=0)
										{
											echo "
											<tr>
                                            <td align='center' colspan='5'>Data kosong..</td>
											</tr>
											";
										}
										else{ $n=1; include "fungsi/golongan.php";
											while($u = mysqli_fetch_assoc($cariagt))
											{  
											echo"
											<tr "; if($n%2==0){ echo "class='satu'"; }else{ echo "class='dua'"; } echo" >
												<td align=center>".($n+$hal)."</td>
												<td align=center>".$u['no_rekening']."</td>
												<td align=center>"; gol($u['no_rekening']); echo "</td>
												<td align=left>".substr($u['rekening'],0,50)."</td>
												<td align=center>"; ?>
														<a href ='#'onclick="javascript:konfir_hapus('man/m_rekening.php','<?php echo $u['no_rekening']; ?>','tabelrekening','<?php echo $hal; ?>');"><img src='icon/delete.png' width='20' height='20' align='center'/></a>
														<a href ='#'onclick="javascript:tampil('formrekening&id=<?php echo $u['no_rekening']; ?>','','','')"><img src='icon/edit.png' width='20' height='20' align='center'/>edit</a>
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
                        		        $jml = mysqli_query($con,"select ceil(count(*)/30) as jml from tb_rekening $cari"); 
		                                $j_hal= mysqli_fetch_assoc($jml); $jml_hal=$j_hal['jml']; 

		                            if($jml_hal > 1){     
												for ($i=0; $i < $jml_hal; $i++) { 
													?>  <a href="#" onclick="javascript:tampil('tabelrekening','<?php echo $i; ?>','','')"><?php echo $i+1; ?></a> 
										<?php
												}
									}			
								?>	
								</center>	