
<script language="JavaScript" src="./js/jquery.js"></script>

<script>
	
	view_sisa_kas('Perusahaan');

	function addTableRow(jQtable){
		jQtable.each(function(){

			var $table = $(this);	
			var n = parseInt(document.getElementById('nomor').value) + 1;
			var rekening = document.getElementById('rekening').value;
			var id_rekening = document.getElementById('id_rekening').value;
			var qty = document.getElementById('qty').value;

            var debit = 0; 
			var kredit = 0;	

			var gol='';
			if(id_rekening.substr(1,1)=='1'){ gol='style="margin-left:0px;"'; }else{ gol='style="margin-left:5%;"'; }

		if(id_rekening==''){ alert('Silahkan isi nama Rekening dengan Benar.. !'); 
				document.getElementById('rekening').value =  '';
				document.getElementById('rekening').focus(); }
		else
		{

			if (qty<=0) {
				alert('Jumlah tidak boleh kosong atau minus..');
				document.getElementById('qty').focus();
			}
			else {

				if(document.getElementById('debit').checked==true){ debit = qty; }else{ kredit = qty; }
              
				var bku= rekening.split('-');
				var tds = '<tr class="dua" >';
				tds += '<td align=center>'+id_rekening+'<input type="hidden" name="rekening'+n+'" value="'+id_rekening+'" /></td>';
				tds += '<td '+gol+' >'+rekening+'</td>';
				tds += '<td align=center>'+rupiah(parseInt(debit))+'<input type="hidden" name="jdebit'+n+'" id="jdebit'+n+'" value="'+debit+'" /></td>';
				tds += '<td align=center>'+rupiah(parseInt(kredit))+'<input type="hidden" name="jkredit'+n+'" id="jkredit'+n+'" value="'+kredit+'" /></td>';
				tds += '<td align=center onClick="$(this).parent().remove(); minTotal('+debit+','+kredit+')"><a href="#"><img src="icon/remove.png" width="20" height="20" align="center"/></a></td>';
				tds += '</tr>';

    			$(this).append(tds);

				document.getElementById('nomor').value =  n;

				document.getElementById('id_rekening').value =  '';
				document.getElementById('rekening').value =  '';
				document.getElementById('rekening').focus();
				hitDebit(); hitKredit();
			}		
		}
				
		});
	}

	function hitDebit() {
		var no = parseInt(document.getElementById('nomor').value);
		var D = document.getElementById('t_debit').innerHTML;
		var t_D = parseInt(D.split(',').join('')); //parseInt(D.replace(",",""));
		var last_D = parseInt(document.getElementById('jdebit'+no+'').value);
		t_D += last_D;
        document.getElementById('t_debit').innerHTML = rupiah(parseInt(t_D));
	}

	function hitKredit() {
		var no = parseInt(document.getElementById('nomor').value);
		var K = document.getElementById('t_kredit').innerHTML;
		var t_K = parseInt(K.split(',').join('')); //parseInt(K.replace(",",""));
		var last_K = parseInt(document.getElementById('jkredit'+no+'').value);
		t_K += last_K;
        document.getElementById('t_kredit').innerHTML = rupiah(parseInt(t_K));
	}

	function minTotal(debit,kredit) {
		var SD = document.getElementById('t_debit').innerHTML;
		var SK = document.getElementById('t_kredit').innerHTML;
		var sisa_debit = parseInt(SD.split(',').join('')); //parseInt(SD.replace(",",""));
		var sisa_kredit = parseInt(SK.split(',').join('')); //parseInt(SK.replace(",",""));
		sisa_debit -= parseInt(debit);
		sisa_kredit -= parseInt(kredit);
		document.getElementById('t_debit').innerHTML = rupiah(sisa_debit);
		document.getElementById('t_kredit').innerHTML = rupiah(sisa_kredit)	;
	}
	
	function deleteAllRows() {
		$('#myTable tbody').remove();
		document.getElementById('t_debit').innerHTML = 0;
		document.getElementById('t_kredit').innerHTML = 0;
		document.getElementById('labeldebit').innerHTML=""; 
		document.getElementById('labelkredit').innerHTML=""; 
		document.getElementById('debit').checked=true;  
	}

	$(document).ready(function(){
			$("#rekening").autocomplete({
				minLength:2,
				source:'autoc/cari_rek.php?cari=pengeluaran',
				select:function(event, ui){
					$('#id_rekening').val(ui.item.nama);
					var x = ui.item.nama;
					if(x.substr(0,1)=='1' || x.substr(0,1)=='5')
						{ 
						  document.getElementById('labeldebit').innerHTML="<b>(+)</b>"; 
						  document.getElementById('labelkredit').innerHTML="<b>(-)</b>"; 
						  document.getElementById('debit').checked=true;  
						}
					else{
						  document.getElementById('labeldebit').innerHTML="<b>(-)</b>"; 
						  document.getElementById('labelkredit').innerHTML="<b>(+)</b>"; 
						  document.getElementById('kredit').checked=true;	
						}
				}
			});
		});

</script>  


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
    }                 
?>


<div style="margin-top:-50;">
					<h2 ><center><strong>FORM TRANSAKSI PENGELUARAN</strong></center></h2>

<form id="formulir" action="man/m_pendapatan.php" method="post" >
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
		<td style="border:0px;"> <label>Investasi</label> </td>
		<td style="border:0px;"> : </td>
		<td style="border:0px;"> 												<select name="investor" onClick="view_sisa_kas(this.value)">
                                                                                <option value='Perusahaan'> Perusahaan </option>
                                                                                <?php
                                                                                    require_once "koneksi.php"; 
                                                                                    $cariagt = mysqli_query($con,"select * from tb_investor i inner join tb_perjanjian p on p.id_investor=i.id_investor
																												  where date(now()) between p.tglmulai_kontrak and p.tglakhir_kontrak"); 
                                                                                        if(mysqli_num_rows($cariagt)>0)
                                                                                        {
                                                                                           while($u = mysqli_fetch_assoc($cariagt))
                                                                                           { // echo  "<option ";  if($u['id_investor']==$investor){ echo "selected='selected'"; } echo" value='".$u['id_investor']."' > ".$u['investor']." </option>"; 
                                                                                       			echo  "<option value='".$u['id_notaris']."'"; if($inv==$u['id_investor']){ echo "selected='selected'"; } echo "> ".$u['investor']." - '".substr($u['tglmulai_kontrak'],0,4)."-".substr($u['tglakhir_kontrak'],0,4)."',".$u['id_notaris']."  ( ".$u['ket_investasi']." ) </option>";
                                                                                   			} 
                                                                                        }                                                                                       
                                                                                ?>
                                                                               </select> 
		</td>
	</tr>
	<tr>
		<td style="border:0px;" valign="top"> <label>Sisa Kas</label></td>
		<td style="border:0px;" valign="top"> : </td>
		<td style="border:0px;" valign="center"> <h1><font color="green"><label id='vsisa'> 0 </label></font></h1>
												 <input type="hidden" name="sisa_kas" id="sisa_kas" value="0" />
		</td>
	</tr>
	<tr>
		<td style="border:0px;"> <label>No Bukti</label></td>
		<td style="border:0px;"> : </td>
		<td style="border:0px;"> <input type='text' name='no_bukti' value="<?php echo $bukti; ?>" placeholder="nota / no bukti lain.." id="no_bukti" required="required" size="40" /> 
		</td>
	</tr>
	<tr>
		<td style="border:0px;" valign="top"> <label>Keterangan</label></td>
		<td style="border:0px;" valign="top"> : </td>
		<td style="border:0px;"> <textarea name='ket' placeholder="Keterangan.." id="ket" required="required" cols="52" rows="2" ><?php echo $ket; ?></textarea> 
		</td>
	</tr>
	<tr>
		<td colspan="3" height="30" valign="bottom" style="border:0px;"><strong> Input Rincian pengeluaran : </strong></td>
	</tr>
	<tr>
		<td style="border:0px;"> <label> Rekening </label></td>
		<td style="border:0px;"> : </td>
		<td >
		<br>
		<input type="text" id="rekening" name="rekening" size="50" placeholder="Ketikkan no rekening atau nama rekening.." >
		<input type='hidden' id="id_rekening" name="id_rekening" size="10" readonly="true">
			<br><br>
			<input type="radio" name='sisi' id="debit" checked="checked" /> Debit <label id="labeldebit"></label>
			<br>
			<input type="radio" name='sisi' id="kredit" /> Kredit <label id="labelkredit"></label> <br><br>
			<label>Rp.  </label><input type='text' name='qty' id='qty' value="0" onkeyup="val_angka(this.id)" > 
		<br><br>	
		</td>
	</tr>
	<tr>
		<td style="border:0px;"></td>
		<td style="border:0px;"></td>
		<td style="border:0px;"> 
			<input type="button" name="tambah" value=" Tambahkan " id="tambah" onClick="addTableRow($('#myTable')); " /><br>
		 </td>
	</tr>
	<tr>
		<td style="border:0px;"></td>
		<td style="border:0px;"></td>
		<td style="border:0px;"><br><br>
			<table width="100%" border="1" style="border-collapse:collapse" id="myTable">
				<thead>
				<tr align="center" class="head">
					<td width="15%">Kode Rekening</td>
					<td width="35%">Nama Rekening</td>
					<td width="20%">Debit</td>
					<td width="20%">Kredit</td>
					<td>Aksi</td>
				</tr>
				</thead>
				<tfoot>

				<?php
				$tot_deb = 0;
				$tot_kred = 0;
				$edit_id = ''; 
				$n=0;

					if(!empty($_GET['id']))
					{	$edit_id = $_GET['id'];
					$cariju = mysqli_query($con,"select * from tb_ju j inner join tb_rekening r on r.no_rekening=j.no_rekening where id_trans='$edit_id' ") or die('gagal pencarian data !'); 
										if(mysqli_num_rows($cariju)>0)
										{	
										 $n=1;
											while($u = mysqli_fetch_assoc($cariju))
											{ 

				?>
					<tr class="dua">					
					<td align=center><?php echo $u['no_rekening']; ?><input type="hidden" name='rekening<?php echo $n; ?>' value="<?php echo $u['no_rekening']; ?>" /></td>
					<td '+gol+' ><?php echo $u['rekening']; ?></td>
					<td align=center><?php echo number_format($u['debit']); ?><input type="hidden" name="jdebit<?php echo $n; ?>" id="jdebit<?php echo $n; ?>" value="<?php echo $u['debit']; ?>" /></td>
					<td align=center><?php echo number_format($u['kredit']); ?><input type="hidden" name="jkredit<?php echo $n; ?>" id="jkredit<?php echo $n; ?>" value="<?php echo $u['kredit']; ?>" /></td>
					<td align=center onClick="$(this).parent().remove(); minTotal('<?php echo $u['debit']; ?>','<?php echo $u['kredit']; ?>')"><a href="#"><img src='icon/remove.png' width='20' height='20' align='center'/></a></td>
					</tr>
				<?php
					$tot_deb = $tot_deb+$u['debit'];
					$tot_kred = $tot_kred+$u['kredit'];
					$n++;
											}

										}
					}

				?>

				<tr align="center" bgcolor="skyblue" style="font-weight:bold;">
					<td ></td>
					<td ></td>
					<b>
					<td id="t_debit"><?php   if(!empty($_GET['id'])){ echo number_format($tot_deb);  } else { ?> 0 <?php } ?></td></b>
					<td id="t_kredit"><?php  if(!empty($_GET['id'])){ echo number_format($tot_kred); } else { ?> 0 <?php } ?></td>
					<td ></td>
					<input type="hidden" name="nomor" id="nomor" value="<?php echo $n; ?>" />
				</tr>
				</tfoot>
			</table>
		</td>
	</tr>
	<tr>
		<td style="border:0px;"> </td>
		<td style="border:0px;"> </td>
		<td style="border:0px;"> 
		<br>
			<input type='button' onclick="val_pengeluaran('<?php echo $edit_id; ?>')" name='simpan' id='simpan' value=' Simpan '/>  
			<input type='Reset' name='reset' value=' Reset ' onClick='deleteAllRows()' /> 
			<input type='button' name='back' value=' Kembali ' onClick="tampil('ttranspengeluaran','','','')" /> 
		</td>
	</tr>
</table>
</form>	
</div>
