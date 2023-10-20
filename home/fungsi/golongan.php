<?php
function gol($id){
	$g='';
	$id=substr($id, 0,2);
	if($id=='11'){ $g = 'Harta tetap'; }
	else if($id=='12'){ $g = 'Harta lancar'; }
	else if($id=='21'){ $g = 'Hutang jangka pendek'; }
	else if($id=='22'){ $g = 'Hutang usaha'; }
	else if($id=='31'){ $g = 'Modal'; }
	else if($id=='32'){ $g = 'Prive'; }
	else if($id=='41'){ $g = 'Pendapatan jasa'; }
	else if($id=='42'){ $g = 'Pendapatan bunga'; }
	else if($id=='43'){ $g = 'Pendapatan penjualan'; }
	else if($id=='51'){ $g = 'Beban produksi'; }
	else if($id=='52'){ $g = 'Beban bulanan'; }
	else if($id=='53'){ $g = 'Beban dan penyesuaian'; }
	else if($id=='54'){ $g = 'Beban lain'; }
	echo $g;
}
?>