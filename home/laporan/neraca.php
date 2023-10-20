<?php
session_start();
$id = $_SESSION['id'];
if($_SESSION['level']=='investor'){ $where="and i.id_investor='".$id."'"; }else{ $where=''; }
?>
<script type="text/javascript">		
	function filter_neraca(){  // UNTUK CONTENT
		var not = document.getElementById('not').value;
		var tarik_file = "view_lap/v_neraca.php?&not="+not; 
		$('#viewlap').load(tarik_file);
	}
</script>
<h2 style="margin-left:50;"> LAPORAN NERACA </h2> 
<div style="margin-left:50;">
<form>
Investasi :
											<select name="investor" style="margin-left:3;" id='not' >
											<?php if($_SESSION['level']!='investor'){ ?> 
																				<option value='' selected="selected"> Semua </option>
                                                                                <option value='Perusahaan' selected="selected"> Perusahaan </option>
                                                                                <?php
                                            }                                    
                                                                                    require_once "koneksi.php"; 
                                                                                    $cariagt = mysqli_query($con,"select * from tb_investor i inner join tb_perjanjian p on p.id_investor=i.id_investor
																												  where date(now()) between p.tglmulai_kontrak and p.tglakhir_kontrak ".$where); 
                                                                                        if(mysqli_num_rows($cariagt)>0)
                                                                                        {
                                                                                           while($u = mysqli_fetch_assoc($cariagt))
                                                                                           { 
                                                                                       			echo  "<option value='".$u['id_notaris']."' > ".$u['investor']." -  ( ".$u['ket_investasi']." ) </option>";
                                                                                   			} 
                                                                                        }                                                                                       
                                                                                ?>
                                                                               </select>  

	<input class="btn btn-outline btn-success" type='button' onclick="filter_neraca();" value='Preview' class='button'>
</form>
</div>
	
<div id='viewlap'>
	<?php // include_once "view_lap/v_jurnal.php"; ?>
</div>

								