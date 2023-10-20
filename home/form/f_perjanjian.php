<?php 

    require_once "koneksi.php";
    
    if(!empty($_GET['id']))
    {  
        $id = $_GET['id'];
        $cari = mysqli_query($con,"select * from tb_perjanjian where id_notaris='$id' "); 
                                   $tampil = mysqli_fetch_assoc($cari);
        $id= $tampil['id_notaris'];
        $investor= $tampil['id_investor'];
        $tmk= $tampil['tglmulai_kontrak'];
        $tak= $tampil['tglakhir_kontrak'];
        $jumlah= $tampil['jumlah_investasi'];
        $tgl_perjanjian= $tampil['tgl_perjanjian'];
        $ket= $tampil['ket_investasi'];
        $edit_id= $_GET['id'];
    }
    else
    {      
        $id = '';  
        $edit_id='';
        $investor= '';
        $tmk= '';
        $tak= '';
        $jumlah= '';
        $tgl_perjanjian= '';
        $ket= '';
    }                 
?>

</br></br>
<label style="margin-left:25px;"><b> <font size="5"> FORM PERJANJIAN </font> </b></label></br></br>
<form id="formulir" name='form'>
<table cellpadding="5" style="margin-left:24px; border:0px solid #999;">
<tr >
                                        <td style="border:0px solid #999;">    <label>NO Notaris</label> </td>
                                        <td style="border:0px solid #999;">    <input name="id" id="id" value='<?php echo $id; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Investor</label> </td>
                                        <td style="border:0px solid #999;">    <select name="id_investor">
                                                                                <?php
                                                                                    require_once "koneksi.php"; 
                                                                                    $cariagt = mysqli_query($con,"select * from tb_investor"); 
                                                                                        if(mysqli_num_rows($cariagt)>0)
                                                                                        {
                                                                                           while($u = mysqli_fetch_assoc($cariagt))
                                                                                           { echo  "<option "; if($u['id_investor']==$investor){ echo "selected='selected'"; } echo" value='".$u['id_investor']."'>".$u['investor']."</option>"; } 
                                                                                        }                                                                                       
                                                                                ?>
                                                                               </select> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Tgl Perjanjian</label> </td>
                                        <td style="border:0px solid #999;">    
                                                                                <input type="date" name="tgl_perjanjian" value='<?php echo $tgl_perjanjian; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Jumlah Investasi (Rp.)</label> </td>
                                        <td style="border:0px solid #999;">    <input name="jumlah" value='<?php echo $jumlah; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>TGL mulai Kontrak</label> </td>
                                        <td style="border:0px solid #999;">    <input type="date" name="tmk" value='<?php echo $tmk; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>TGL akhir Kontrak</label> </td>
                                        <td style="border:0px solid #999;">    <input type="date" name="tak" value='<?php echo $tak; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Keterangan Investasi</label> </td>
                                        <td style="border:0px solid #999;">    <textarea name='ket'><?php echo $ket; ?> </textarea> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    </td>
                                        <td style="border:0px solid #999;">    <button type="button" onclick="tampil('tabelperjanjian','','','')" >Kembali</button> <button style="margin-left:5px;" type="submit" onclick="val_perjanjian('<?php echo $edit_id; ?>');" > Simpan </button> </td>
</tr>
</table>
</form>
