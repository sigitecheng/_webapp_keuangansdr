
<?php 

    require_once "koneksi.php";
    
    if(!empty($_GET['id']))
    {  
        $id = $_GET['id'];
        $cari = mysqli_query($con,"select * from tb_rekening where no_rekening='$id' "); 
                                   $tampil = mysqli_fetch_assoc($cari);
        $id= $tampil['no_rekening'];
        $nama= $tampil['rekening'];
        $edit_id=$_GET['id'];
    }
    else
    {      
        $cari_id = mysqli_query($con,"select coalesce(max(substr(no_rekening,3,3)),0)+1 as kd from tb_rekening where left(no_rekening,2)='11' ") or die('gagal pencarian data !');           
                $tmp = mysqli_fetch_assoc($cari_id); 
                $kd = $tmp['kd'];

            $id = '11'.$kd;  

        $edit_id='';
        $nama= '';
        $us= '';
        $ps= ''; 
    }                 
?>

<label style="padding-left:50px;"><b> <font size="5"> FORM REKENING </font> </b></label></br></br>
<?php if(empty($_GET['id'])){  ?>
<table cellpadding="7" style="margin-left:24px; margin-right:15px; border:1px solid #999; float:left;">
<tr style="margin-left:24px; margin-right:15px; border:1px solid #999;" >
                                        <td style="border:0px solid #999;">    <label>1.AKTIVA</label> </td>
                                        <td style="border:0px solid #999;">    <input onclick="cari_no_rek(this.value);" type="radio" value="11" name="gol" checked="checked" /> TETAP
                                        <br>   <input type="radio" value="12" name="gol" onclick="cari_no_rek(this.value);" /> LANCAR</td>
</tr>
<tr style="margin-left:24px; margin-right:15px; border:1px solid #999;">
                                        <td style="border:0px solid #999;">    <label>2.PASIVA</label> </td>
                                        <td style="border:0px solid #999;">    <input onclick="cari_no_rek(this.value);" type="radio" value="21" name="gol" />JANGKA PENDEK
                                                                               <br><input onclick="cari_no_rek(this.value);" type="radio" value="22" name="gol" />JANGKA PANJANG</td>
</tr>
<tr style="margin-left:24px; margin-right:15px; border:1px solid #999;">
                                        <td style="border:0px solid #999;">    3.EKUITAS</td>
                                        <td style="border:0px solid #999;">    <input onclick="cari_no_rek(this.value);" type="radio" value="31" name="gol" />MODAL
                                                                               <br> <input onclick="cari_no_rek(this.value);" type="radio" value="32" name="gol" />PRIVE</td>
</tr>
<tr style="margin-left:24px; margin-right:15px; border:1px solid #999;">
                                        <td style="border:0px solid #999;">    4.PENDAPATAN</td>
                                        <td style="border:0px solid #999;">     <input onclick="cari_no_rek(this.value);" type="radio" value="41" name="gol" />JASA
                                                                                <br> <input onclick="cari_no_rek(this.value);" type="radio" value="42" name="gol" />BUNGA
                                                                                <br> <input onclick="cari_no_rek(this.value);" type="radio" value="43" name="gol" />PENJUALAN</td>
</tr>
<tr style="margin-left:24px; margin-right:15px; border:1px solid #999;">
                                        <td style="border:0px solid #999;">    5.BEBAN</td>
                                        <td style="border:0px solid #999;">    <input onclick="cari_no_rek(this.value);" type="radio" value="51" name="gol" />BEBAN PRODUKSI
                                                                               <br> <input onclick="cari_no_rek(this.value);" type="radio" value="52" name="gol" />BEBAN BULANAN
                                                                               <br> <input onclick="cari_no_rek(this.value);" type="radio" value="53" name="gol" />BEBAN PENYUSUTAN DAN PENYESUAIAN
                                                                               <br> <input onclick="cari_no_rek(this.value);" type="radio" value="54" name="gol" />BEBAN LAIN</td>

</tr>
</table>
<?php } ?>

<form id="formulir" name='form'>
<table cellpadding="5" style="margin-left:24px; border:0px solid #999;">
<tr >
                                        <td style="border:0px solid #999;">    <label>No Rekening</label> </td>
                                        <td style="border:0px solid #999;">    <input name="id" id="id" value='<?php echo $id; ?>' readonly='readonly'/> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Nama Rekening</label> </td>
                                        <td style="border:0px solid #999;">    <input name="rekening" value='<?php echo $nama; ?>' required='required' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    </td>
                                            <td style="border:0px solid #999;">    <button type="button" onclick="tampil('tabelrekening','','','')" >Kembali</button> 
                                                                                   <button style="margin-left:5px;" type="submit" onclick="val_rekening('<?php echo $edit_id; ?>');" > Simpan </button> 
                                                                               </td>
</tr>
</table>
</form>