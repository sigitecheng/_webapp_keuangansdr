
<script language="JavaScript" src="./js/jquery.js"></script> 

<?php 
    require_once "koneksi.php";
    
    if(!empty($_GET['id']))
    {  
        $id = $_GET['id'];
        $cari = mysqli_query($con,"select t.*,p.id_investor from tb_transaksi t left join tb_perjanjian p on p.id_notaris=t.id_notaris where t.id_trans='$id' "); 
                                   $tampil = mysqli_fetch_assoc($cari);
        $bukti= $tampil['no_bukti'];
        $ket= $tampil['ket'];
        $notaris= $tampil['id_notaris'];
        $tgl= $tampil['tgl_trans'];
        $inv= $tampil['id_investor'];
        $edit_id= $_GET['id'];

        $index=1;     
        $cari = mysqli_query($con,"select * from tb_ju t left join tb_rekening r on r.no_rekening=t.no_rekening where t.id_trans='$id' "); 
        while( $tampil = mysqli_fetch_assoc($cari))
        { 
        	if($index==1){ $r1 = $tampil['no_rekening']; }
            else 
            { $r2= $tampil['no_rekening']; $qty=$tampil['debit']+$tampil['kredit'];; }
        $index++;        
        }    
    }
    else
    {      
    	$cari_id = mysqli_query($con,"select coalesce(max(right(id_trans,3)),0)+1 as kd from tb_transaksi") or die('gagal pencarian data !');           
                $tmp = mysqli_fetch_assoc($cari_id); 
                $kd = $tmp['kd'];

                $id='0';    
                for($i=1; $i<=6-strlen($kd); $i++)
                { $id = '0'.$id; } 

            $id = 'TR-'.$id.$kd;  

        $edit_id='';
        $bukti= '';
        $ket='';
        $notaris= '';
        $tgl= '';
        $inv='';
        $r1='';
        $r2='';
        $qty=0;
    }                 
?>


<div style="margin-top:-50;">
					<h2 ><center><strong>FORM PEMINDAHAN KAS</strong></center></h2>

<form id="formulir" action="man/m_penyesuaian.php" method="post" >
<table width="90%" cellpadding="2%" style="border:0px;" align="center" >
	<tr >
		<td style="border:0px;"> <label>Id Trans</label></td>
		<td style="border:0px;"> : </td>
		<td style="border:0px;"> <input type='text' name='idp' value="<?php echo $id; ?>" required="required" readonly='readonly' size="16" /></td>
	</tr>
	<tr>
		<td style="border:0px;"> <label>Tgl Trans</label></td>
		<td style="border:0px;"> : </td>
		<td style="border:0px;"> <input type='date' name='tgl' placeholder="Kelas" id="tgl" value="<?php echo date('Y-m-d'); ?>" required="required"></td>
	</tr>
	<tr>
		<td style="border:0px;" valign="top"> <label>Keterangan</label></td>
		<td style="border:0px;" valign="top"> : </td>
		<td style="border:0px;"> <textarea name='ket' placeholder="Keterangan.." id="ket" required="required" cols="52" rows="2" ><?php echo $ket; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td colspan="3" height="30" valign="bottom" style="border:0px;"><strong> Input Rincian Pembelian Aset : </strong></td>
	</tr>
	<tr>
		<td style="border:0px;"> <label> Rekening </label></td>
		<td style="border:0px;">  </td>
		<td >
		<br>
			<br>
			<label style="margin-right:15; color:teal; font-size:14; margin-left:12;"> <b> Diambil Dari Rek</b> </label>:
				<select name="rekening2" onchange="view_sisa_kas_rekening(this.value,'<?php echo $r2; ?>','<?php echo $qty; ?>');" id="rekening2" >
				<option value=""> - Pilih - </option>
                     <?php
                        require_once "koneksi.php"; 
                        $cariagt = mysqli_query($con,"select * from tb_rekening r inner join (select u.no_rekening from tb_ju u group by u.no_rekening )j on j.no_rekening=r.no_rekening 
                        							  where left(r.no_rekening,2)='12' "); 
                        if(mysqli_num_rows($cariagt)>0)
                        {
                            while($u = mysqli_fetch_assoc($cariagt))
                            { 
                            	echo  "<option value='".$u['no_rekening']."'"; echo "> ".$u['rekening']." </option>";
                        	} 
                        }                                                                                       
                    ?>
                    </select>
            <br>    
                    <div style="margin-left:160;"><h1><font color="green"><label id='vsisa'> 0 </label></font></h1>
					<input type="hidden" name="sisa_kas" id="sisa_kas" value="0" /></div>
			 <label style="margin-right:23; color:teal; font-size:14; margin-left:10;"> <b> Dipindahkan Ke  </b></label>:
			 		<select name="rekening1" id="rekening1" >
			 		<option value=""> - Pilih - </option>
                     <?php
                        require_once "koneksi.php"; 
                        $cariagt = mysqli_query($con,"select * from tb_rekening r where left(r.no_rekening,2)='12' "); 
                        if(mysqli_num_rows($cariagt)>0)
                        {
                            while($u = mysqli_fetch_assoc($cariagt))
                            { 
                            	echo  "<option value='".$u['no_rekening']."'"; if($r1==$u['no_rekening']){ echo "selected='selected'"; } echo " > ".$u['rekening']." </option>";
                        	} 
                        }                                                                                       
                    ?>
                    </select>  
			
			
			 <br><br>
			<label style="margin-left:170;" > <b>Rp.</b> </label><input style="margin-left:10; font-size:15; margin-left:10;" type='text' name='qty' id='qty' value="<?php echo $qty; ?>" onkeyup="val_angka(this.id)" > 
                   
		<br><br>	
		</td>
	</tr>
	<tr>
		<td style="border:0px;"></td>
		<td style="border:0px;"></td>
		<td style="border:0px;"> 
		 </td>
	</tr>
	<tr>
		<td style="border:0px;"></td>
		<td style="border:0px;"></td>
		<td style="border:0px;"><br><br>
		</td>
	</tr>
	<tr>
		<td style="border:0px;"> </td>
		<td style="border:0px;"> </td>
		<td style="border:0px;"> 
		<br>
			<input type='button' onclick="val_pemindahan_kas('<?php echo $edit_id; ?>')" name='simpan' id='simpan' value=' Simpan '/>  
			<input type='Reset' name='reset' value=' Reset ' onClick='deleteAllRows()' /> 
			<input type='button' name='back' value=' Kembali ' onClick="tampil('ttranspemindahankas','','','')" /> 
		</td>
	</tr>
</table>
</form>	
</div>