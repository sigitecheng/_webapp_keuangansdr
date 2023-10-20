<?php
session_start();
$id = $_SESSION['id'];
if($_SESSION['level']=='investor'){ $where="and i.id_investor='".$id."'"; }else{ $where=''; }
?>
<script type="text/javascript">
		
	function filter_lajur(){  // UNTUK CONTENT
		var thn = document.getElementById('thn').value;
		var not = document.getElementById('not').value;
	//	var nama = $("#not option:selected").text();
	//	alert(nama);
		var tarik_file = "view_lap/v_neraca_lajur.php?thn="+thn+"&not="+not; //+"&nama="+nama; 
		$('#viewlap').load(tarik_file);
	}
</script>
<h2 style="margin-left:50;"> LAPORAN NERACA LAJUR </h2> 
<div style="margin-left:50;">
<form>
	Tahun : 
	<select name="thn" id="thn" style="margin-left: 20;">
	                         <?php
	                                require_once "koneksi.php"; 
	                                $cariagt = mysqli_query($con,"select year(tgl)as thn from tb_jp group by year(tgl) "); 
	                                if(mysqli_num_rows($cariagt)>0)
	                                    {
	                                             while($u = mysqli_fetch_assoc($cariagt))
	                                             { 
	                                                   echo  "<option value='".$u['thn']."' > ".$u['thn']."</option>";
	                                             } 
	                                    }                                                                                       
	                         ?>
	</select> <br>
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
	<input class="btn btn-outline btn-success" type='button' onclick="filter_lajur();" value='Preview' class='button'>
</form>
</div>

<div id='viewlap'>
	
</div>


								