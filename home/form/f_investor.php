<?php 

    require_once "koneksi.php";
    
    if(!empty($_GET['id']))
    {  
        $id = $_GET['id'];
        $cari = mysqli_query($con,"select * from tb_investor where id_investor='$id' "); 
                                   $tampil = mysqli_fetch_assoc($cari);
        $id= $tampil['id_investor'];
        $investor= $tampil['investor'];
        $pj= $tampil['penanggung_jawab'];
        $alamat= $tampil['alamat'];
        $no_hp= $tampil['no_hp'];
        $email= $tampil['email'];
        $us= $tampil['username'];
        $ps= $tampil['password'];
        $edit_id= $_GET['id'];
    }
    else
    {      
        $cari_id = mysqli_query($con,"select coalesce(max(right(id_investor,3)),0)+1 as kd from tb_investor") or die('gagal pencarian data !');           
                $tmp = mysqli_fetch_assoc($cari_id); 
                $kd = $tmp['kd'];

                $id='0';    
                for($i=1; $i<=6-strlen($kd); $i++)
                { $id = '0'.$id; } 

            $id = 'IV-'.$id.$kd;  

        $edit_id='';
        $investor='';
        $pj= '';
        $alamat= '';
        $no_hp='';
        $email= '';
        $us= '';
        $ps= ''; 
    }                 
?>

</br></br>
<label style="margin-left:25px;"><b> <font size="5"> FORM INVESTOR </font> </b></label></br></br>
<form id="formulir" name='form'>
<table cellpadding="5" style="margin-left:24px; border:0px solid #999;">
<tr >
                                        <td style="border:0px solid #999;">    <label>Kode investor</label> </td>
                                        <td style="border:0px solid #999;">    <input name="id" id="id" value='<?php echo $id; ?>' readonly='readonly'/> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Investor</label> </td>
                                        <td style="border:0px solid #999;">    <input name="investor" value='<?php echo $investor; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Penanggung jawab</label> </td>
                                        <td style="border:0px solid #999;">    <input name="jp" value='<?php echo $pj; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Alamat</label> </td>
                                        <td style="border:0px solid #999;">    <textarea name='alamat'><?php echo $alamat; ?> </textarea>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>No HP</label> </td>
                                        <td style="border:0px solid #999;">    <input name="no_hp" value='<?php echo $no_hp; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Email</label> </td>
                                        <td style="border:0px solid #999;">    <input name="email" value='<?php echo $email; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Username</label> </td>
                                        <td style="border:0px solid #999;">    <input name="username" value='<?php echo $us; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    <label>Password</label> </td>
                                        <td style="border:0px solid #999;">    <input name="password" value='<?php echo $ps; ?>' /> </td>
</tr>
<tr>
                                        <td style="border:0px solid #999;">    </td>
                                        <td style="border:0px solid #999;">    <button type="button" onclick="tampil('tabelinvestor','','','')" >Kembali</button> <button style="margin-left:5px;" type="submit" onclick="val_investor('<?php echo $edit_id; ?>');" > Simpan </button> </td>
</tr>
</table>
</form>
