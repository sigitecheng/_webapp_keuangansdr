-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 11, 2016 at 01:17 PM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sik`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE IF NOT EXISTS `tb_admin` (
  `id_admin` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `nama`, `username`, `password`) VALUES
('AD-0000001', 'Tio Ar', 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_bendahara`
--

CREATE TABLE IF NOT EXISTS `tb_bendahara` (
  `id_bendahara` varchar(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id_bendahara`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_bendahara`
--

INSERT INTO `tb_bendahara` (`id_bendahara`, `nama`, `username`, `password`) VALUES
('BD-0000001', 'candra', 'bendahara', '123'),
('BD-0000002', 'Setyawan tinton', 'tinton', 'tinton');

-- --------------------------------------------------------

--
-- Table structure for table `tb_d_jp`
--

CREATE TABLE IF NOT EXISTS `tb_d_jp` (
  `id_d_jp` int(10) NOT NULL AUTO_INCREMENT,
  `id_jp` varchar(10) NOT NULL,
  `no_rekening` varchar(5) NOT NULL,
  `debit` int(10) NOT NULL,
  `kredit` int(10) NOT NULL,
  PRIMARY KEY (`id_d_jp`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `tb_d_jp`
--

INSERT INTO `tb_d_jp` (`id_d_jp`, `id_jp`, `no_rekening`, `debit`, `kredit`) VALUES
(9, 'TR-0000006', '531', 0, 1000),
(10, 'TR-0000006', '121', 1000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_investor`
--

CREATE TABLE IF NOT EXISTS `tb_investor` (
  `id_investor` varchar(10) NOT NULL,
  `investor` varchar(50) NOT NULL,
  `penanggung_jawab` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_hp` varchar(30) NOT NULL,
  `email` varchar(20) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id_investor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_investor`
--

INSERT INTO `tb_investor` (`id_investor`, `investor`, `penanggung_jawab`, `alamat`, `no_hp`, `email`, `username`, `password`) VALUES
('IV-0000001', 'Ibu ani', 'Ibu ani', 'Jakarta', '098', 'ani@email', 'ani', 'ani'),
('IV-0000002', 'Endang sukmara', 'Endang sukmara', 'Tasikmalaya, cihideung, jawa barat', '09878099878', 'endang@com', 'endg', 'endg'),
('IV-0000003', 'PT Kurnia ', 'Afif ', 'Jl perintis Tasikmalaya', '09878', 'tanitaniku@com', 'tani1', 'tanitani'),
('IV-0000004', 'CV. Jaya abadi', 'Hanifa', 'Rajapolah ', '0987', 'rajajaya@yahoo', 'jaya', 'jaya');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jp`
--

CREATE TABLE IF NOT EXISTS `tb_jp` (
  `id_jp` varchar(10) NOT NULL,
  `tgl` date NOT NULL,
  `id_bendahara` varchar(20) NOT NULL,
  `ket` varchar(100) NOT NULL,
  `id_notaris` varchar(20) NOT NULL,
  PRIMARY KEY (`id_jp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jp`
--

INSERT INTO `tb_jp` (`id_jp`, `tgl`, `id_bendahara`, `ket`, `id_notaris`) VALUES
('TR-0000006', '2016-08-02', '', 'Kas kantor lebih ', 'Perusahaan');

-- --------------------------------------------------------

--
-- Table structure for table `tb_ju`
--

CREATE TABLE IF NOT EXISTS `tb_ju` (
  `id_ju` int(10) NOT NULL AUTO_INCREMENT,
  `id_trans` varchar(10) NOT NULL,
  `no_rekening` varchar(5) NOT NULL,
  `debit` int(10) NOT NULL,
  `kredit` int(10) NOT NULL,
  PRIMARY KEY (`id_ju`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=260 ;

--
-- Dumping data for table `tb_ju`
--

INSERT INTO `tb_ju` (`id_ju`, `id_trans`, `no_rekening`, `debit`, `kredit`) VALUES
(155, 'TR-0000002', '122', 500000, 0),
(156, 'TR-0000002', '311', 0, 500000),
(161, 'TR-0000004', '511', 120000, 0),
(162, 'TR-0000004', '121', 0, 120000),
(171, 'TR-0000003', '411', 0, 250000),
(172, 'TR-0000003', '121', 250000, 0),
(202, 'TR-0000005', '523', 30000, 0),
(203, 'TR-0000005', '121', 0, 30000),
(222, 'TR-0000008', '121', 100000, 0),
(223, 'TR-0000008', '122', 0, 100000),
(224, 'TR-0000009', '411', 0, 5000000),
(225, 'TR-0000009', '121', 3000000, 0),
(226, 'TR-0000009', '124', 2000000, 0),
(240, 'TR-0000012', '121', 1000, 0),
(241, 'TR-0000012', '431', 0, 1000),
(242, 'TR-0000010', '121', 100000, 0),
(243, 'TR-0000010', '431', 0, 100000),
(244, 'TR-0000013', '113', 500000, 0),
(245, 'TR-0000013', '121', 0, 500000),
(258, 'TR-0000011', '542', 100000, 0),
(259, 'TR-0000011', '121', 0, 100000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_perjanjian`
--

CREATE TABLE IF NOT EXISTS `tb_perjanjian` (
  `id_notaris` varchar(10) NOT NULL,
  `id_investor` varchar(10) NOT NULL,
  `tglmulai_kontrak` date NOT NULL,
  `tglakhir_kontrak` date NOT NULL,
  `jumlah_investasi` int(10) NOT NULL,
  `tgl_perjanjian` date NOT NULL,
  `ket_investasi` varchar(100) NOT NULL,
  PRIMARY KEY (`id_notaris`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_perjanjian`
--

INSERT INTO `tb_perjanjian` (`id_notaris`, `id_investor`, `tglmulai_kontrak`, `tglakhir_kontrak`, `jumlah_investasi`, `tgl_perjanjian`, `ket_investasi`) VALUES
('NT0927', 'IV-0000004', '2016-07-01', '2025-07-01', 50000000, '2016-07-23', 'Sengon 3200 pohon  '),
('PV09811A', 'IV-0000001', '2016-07-01', '2019-07-31', 20000000, '2016-06-30', 'Padi 5 Ha    ');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pimpinan`
--

CREATE TABLE IF NOT EXISTS `tb_pimpinan` (
  `id_pimpinan` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id_pimpinan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pimpinan`
--

INSERT INTO `tb_pimpinan` (`id_pimpinan`, `nama`, `username`, `password`) VALUES
('PM-0000001', 'Arief R', 'pimpinan', '123');

-- --------------------------------------------------------

--
-- Table structure for table `tb_rekening`
--

CREATE TABLE IF NOT EXISTS `tb_rekening` (
  `no_rekening` varchar(5) NOT NULL,
  `rekening` varchar(100) NOT NULL,
  PRIMARY KEY (`no_rekening`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_rekening`
--

INSERT INTO `tb_rekening` (`no_rekening`, `rekening`) VALUES
('111', 'Tanah sawah'),
('112', 'Mesin traktor'),
('113', 'Motor kantor'),
('121', 'Kas kantor'),
('122', 'Rek BCA'),
('123', 'Rek Mandiri'),
('124', 'Piutang penjualan'),
('211', 'Beban utang'),
('311', 'Modal investasi'),
('312', 'Modal priadi'),
('321', 'Prive laba'),
('411', 'Pendapatan jasa'),
('421', 'Bunga bank '),
('431', 'Penjualan hasil panen padi'),
('511', 'Bayar buruh harian lepas'),
('512', 'Beban bensin'),
('521', 'Beban listrik'),
('522', 'Beban gaji karyawan'),
('523', 'Beban bayar sampah'),
('531', 'Selisih kas'),
('541', 'Pajak tanah'),
('542', 'beban pajak');

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi`
--

CREATE TABLE IF NOT EXISTS `tb_transaksi` (
  `id_trans` varchar(10) NOT NULL,
  `no_bukti` varchar(30) NOT NULL,
  `tgl_trans` date NOT NULL,
  `ket` varchar(100) NOT NULL,
  `id_bendahara` varchar(20) NOT NULL,
  `id_notaris` varchar(20) NOT NULL,
  `view_admin` binary(1) NOT NULL,
  `view_pimpinan` binary(1) NOT NULL,
  `view_investor` binary(1) NOT NULL,
  PRIMARY KEY (`id_trans`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_trans`, `no_bukti`, `tgl_trans`, `ket`, `id_bendahara`, `id_notaris`, `view_admin`, `view_pimpinan`, `view_investor`) VALUES
('TR-0000002', 'P0989', '2016-07-28', 'Setor modal investasi ke-1', '', 'PV09811A', '0', '0', '0'),
('TR-0000003', '-', '2016-07-30', 'Pendapatan jasa dari bu ani', '', 'Perusahaan', '0', '0', '0'),
('TR-0000004', '-', '2016-07-28', 'Sewa tukang untuk buka lahan, 2 hari', '', 'PV09811A', '0', '0', '0'),
('TR-0000005', '-', '2016-07-30', 'Bayar sampah bulan juli', '', 'Perusahaan', '0', '0', '0'),
('TR-0000006', '-', '2016-07-31', 'Sewa kebun perusahaan 2 hari', '', 'Perusahaan', '0', '0', '0'),
('TR-0000008', '', '2016-08-02', 'Pengambilan untuk stok kas', '', 'Perusahaan', '0', '0', '0'),
('TR-0000009', '289DS890', '2016-08-02', 'Sewa tanah ', '', 'Perusahaan', '0', '0', '0'),
('TR-0000010', 'PS0987', '2016-08-04', 'Panen ke-1', '', 'PV09811A', '0', '0', '0'),
('TR-0000011', 'PSSD7677', '2016-08-05', 'Pajak tanah tahunan', '', 'Perusahaan', '0', '0', '0'),
('TR-0000012', '-', '2016-08-04', 'panen ke-2', '', 'PV09811A', '0', '0', '0'),
('TR-0000013', '', '2016-08-04', 'Motor kantor', '', 'Perusahaan', '0', '0', '0');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
