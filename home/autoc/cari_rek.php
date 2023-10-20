<?php
require "../koneksi.php";

//harus selalu gunakan variabel term saat memakai autocomplete,
$term = $_GET['term'];

if($_GET['cari']=='pendapatan'){
	$query = mysqli_query($con,"select * from tb_rekening where 
	(no_rekening like '%".$term."%' or rekening like '%".$term."%' and left(no_rekening,1)='4' ) or 
	(no_rekening like '%".$term."%' or rekening like '%".$term."%' and left(no_rekening,1)='1' ) or 
	(no_rekening like '%".$term."%' or rekening like '%".$term."%' and left(no_rekening,1)='3' ) ");  //'%".$term."%'
}else if($_GET['cari']=='pengeluaran')
{
	$query = mysqli_query($con,"select * from tb_rekening where (no_rekening like '%".$term."%' or rekening like '%".$term."%' and left(no_rekening,1)='5' ) or (no_rekening like '%".$term."%' or rekening like '%".$term."%' and left(no_rekening,1)='1' ) ");  //'%".$term."%'
}else
{
	$query = mysqli_query($con,"select * from tb_rekening r inner join 
										(select no_rekening from tb_ju group by no_rekening union select no_rekening from tb_d_jp group by no_rekening union select no_rekening from tb_rekening where left(no_rekening,2)='53')j on j.no_rekening=r.no_rekening
										where r.no_rekening like '%".$term."%' or r.rekening like '%".$term."%' ");  //'%".$term."%'
}

$json = array();
while($produk = mysqli_fetch_assoc($query)){
$json[] = array(
	'label' => $produk['no_rekening'].' | '.$produk['rekening'], // text sugesti saat user mengetik di input box
	'value' => $produk['rekening'], // nilai yang akan dimasukkan diinputbox saat user memilih salah satu sugesti
	'nama' => $produk['no_rekening']
);

}
header("Content-Type: text/json");
echo json_encode($json); 

?>