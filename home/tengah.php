<?php
if(!empty($_GET['view'])){
	$id = $_GET['view'];
	if($id=='tabeladmin') { include "tabel/t_admin.php"; }
	else if($id=='ttranspendapatan') { include "tabel/t_pendapatan.php"; }
	else if($id=='ttranspengeluaran') { include "tabel/t_pengeluaran.php"; }
	else if($id=='ttranspenyesuaian') { include "tabel/t_penyesuaian.php"; }
	else if($id=='ttranspembelianaset') { include "tabel/t_pembelian_aset.php"; }
	else if($id=='ttranspemindahankas') { include "tabel/t_pemindahan_kas.php"; }
	else if($id=='tabelbendahara') { include "tabel/t_bendahara.php"; }
	else if($id=='tabelrekening') { include "tabel/t_rekening.php"; }
	else if($id=='tabelinvestor') { include "tabel/t_investor.php"; }
	else if($id=='tabelperjanjian') { include "tabel/t_perjanjian.php"; }
	else if($id=='tabelpimpinan') { include "tabel/t_pimpinan.php"; }
	else if($id=='formadmin') { include "form/f_admin.php"; }
	else if($id=='forminvestor') { include "form/f_investor.php"; }
	else if($id=='formpendapatan') { include "form/f_pendapatan.php"; }
	else if($id=='formpengeluaran') { include "form/f_pengeluaran.php"; }
	else if($id=='formpenyesuaian') { include "form/f_penyesuaian.php"; }
	else if($id=='formbendahara') { include "form/f_bendahara.php"; }
	else if($id=='formpimpinan') { include "form/f_pimpinan.php"; }
	else if($id=='formperjanjian') { include "form/f_perjanjian.php"; }
	else if($id=='formrekening') { include "form/f_rekening.php"; }
	else if($id=='formpembelianaset') { include "form/f_pembelian_aset.php"; }
	else if($id=='formpemindahankas') { include "form/f_pemindahan_kas.php"; }
	else if($id=='lap_buku_besar') { include "laporan/buku_besar.php"; }
	else if($id=='lap_jurnal') { include "laporan/jurnal.php"; }
	else if($id=='lap_transaksi') { include "laporan/transaksi.php"; }
	else if($id=='lap_neraca') { include "laporan/neraca.php"; }
	else if($id=='lap_neraca_lajur') { include "laporan/neraca_lajur.php"; }
	else if($id=='lap_rugilaba') { include "laporan/rugilaba.php"; }
	else { 
		 // include "tabel/surat_masuk.php"; 
	}
}	
?>