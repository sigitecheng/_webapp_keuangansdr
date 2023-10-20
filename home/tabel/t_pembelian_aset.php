	<?php 
		if(!empty($_GET['hal'])){ $hal=$_GET['hal']*30; }else{ $hal=0; } 
		if(!empty($_GET['kunci'])){ $cari ="where i.investor like '".$_GET['kunci']."%' or p.id_notaris like '".$_GET['kunci']."' "; }else{ $cari=''; }
	?>
							<button style="margin-left:25px;">
                               <a href="#" style="text-decoration: none;" onclick="tampil('formpembelianaset','','','')" > Tambah Pembelian Aset </a>
                            </button> </br>	</br>		
                                <table border=1 width="95%" align="center">
                                    <thead>
                                        <tr class="head" >
                                            <th width="2%" style="text-align : center;">NO</th>
                                            <th width="8%" style="text-align : center;">ID Trans</th>
                                            <th width="8%" style="text-align : center;">Tgl Trans</th>
											<th width="15%" style="text-align : center;">Ket.<br> Transaksi</th>
											<th width="10%" style="text-align : center;">Kas yang <br> Digunakan</th>
											<th width="10%" style="text-align : center;">Aset yang <br> Dibeli </th>
											<th width="8%" style="text-align : center;">User</th>
											<th width="8%" style="text-align : center;">Biaya </th>
											<th width="10%" style="text-align : center;">Pilihan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
									<?php 	
									require_once "koneksi.php"; 
									$cariagt = mysqli_query($con,"select t.* ,d.jml ,k.jml ,b.nama,rd.rekening as rd ,rk.rekening as rk from tb_transaksi t
inner join (select id_trans,no_rekening,debit as jml from tb_ju where left(no_rekening,2)='11' and debit > 0 ) d on d.id_trans=t.id_trans 
inner join (select id_trans,no_rekening,kredit as jml from tb_ju where left(no_rekening,2)='12' and kredit > 0 ) k on k.id_trans=t.id_trans
left join tb_rekening rd on rd.no_rekening=d.no_rekening
left join tb_rekening rk on rk.no_rekening=k.no_rekening
									left join tb_bendahara b on b.id_bendahara=t.id_bendahara
									order by id_trans desc limit $hal,30") or die('gagal pencarian data !'); 
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
												<td align=center>".$u['id_trans']."</td>
												<td align=center>".$u['tgl_trans']."</td>
												<td align=center>".$u['ket']."</td>
												<td align=center>".$u['rk']."</td>
												<td align=center>".$u['rd']."</td>
												<td align=center>".$u['nama']."</td>
												<td align=right><div style='margin-right:5%;'>".number_format($u['jml'])."</div></td>
												<td align=center>"; ?>
														<a href ='#'onclick="javascript:konfir_hapus('man/m_pembelian_aset.php','<?php echo $u['id_trans']; ?>','ttranspembelianaset','<?php echo $hal; ?>');"><img src='icon/delete.png' width='20' height='20' align='center'/></a>
														<a href ='#'onclick="javascript:tampil('formpembelianaset&id=<?php echo $u['id_trans']; ?>','','','')"><img src='icon/edit.png' width='20' height='20' align='center'/>edit</a><br>
														<a href ='view_lap/print_nota_pembelian_aset.php?id=<?php echo $u['id_trans']; ?>' target="_blank" style="padding-top:10;" ><img src='icon/nota.ico' width='20' height='20' align='center'/>Nota</a>
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