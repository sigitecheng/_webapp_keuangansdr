<?php
session_start();
$id = $_SESSION['id'];
if($_SESSION['level']=='investor'){ $where="and i.id_investor='".$id."'"; }else{ $where=''; }
?>
<script type="text/javascript">		
	function filter_rugilaba(){  // UNTUK CONTENT
		var t1 = document.getElementById('t1').value;
		var t2 = document.getElementById('t2').value;
		var not = document.getElementById('not').value;
		var tarik_file = "view_lap/v_rugilaba.php?t1="+t1+"&t2="+t2+"&not="+not; 
		$('#viewlap').load(tarik_file);
	}
</script>
<h2 style="margin-left:50;"> LAPORAN RUGI-LABA </h2> 
<div style="margin-left:50;">
<form>
Mulai : <input type="date" style="margin-left:20; margin-bottom:5;" name='tgl1' id="t1" value='<?php echo date('Y-m-d'); ?>' /><br>
Sampai : <input type="date" style="margin-left:11; margin-bottom:5;" name='tgl2' id="t2" value='<?php echo date('Y-m-d'); ?>' /><br>
Investasi :
											<select name="investor" style="margin-left:3;" id='not' >
											<?php if($_SESSION['level']!='investor'){ ?>
                                                                                <option value='Perusahaan' selected="selected"> Perusahaan </option>
																				<option value='' selected="selected"> Semua </option>
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

	<input class="btn btn-outline btn-success" type='button' onclick="filter_rugilaba();" value='Preview' class='button'>
</form>
</div>
	
<div id='viewlap'>
	<?php // include_once "view_lap/v_jurnal.php"; ?>
</div>

								