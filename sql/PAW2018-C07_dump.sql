-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Nov 2018 pada 16.51
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.11
-- Dibuat oleh: Kelompok

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `banking`
-- Pengecekan database jika ada, dan akan dihapus
-- Author: 160411100145 ABDUR ROHMAN
--

DROP DATABASE IF EXISTS banking;
CREATE DATABASE IF NOT EXISTS banking;
USE banking;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_transaksi`
-- Author:  160411100142 MOHAMMAD FAISHOL
--

CREATE TABLE `jenis_transaksi` (
  `id` char(2) NOT NULL PRIMARY KEY,
  `keterangan` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_transaksi`
--

INSERT INTO `jenis_transaksi` (`id`, `keterangan`) VALUES
('0', 'SETORAN AWAL'),
('1', 'TRANSFER');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pengguna`
-- Author: 160411100142 MOHAMMAD FAISHOL
--

CREATE TABLE `jenis_pengguna` (
  `id` char(2) NOT NULL PRIMARY KEY,
  `keterangan` char(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jenis_pengguna`
--

INSERT INTO `jenis_pengguna` (`id`, `keterangan`) VALUES
('0', 'ADMINISTRATOR'),
('1', 'CUSTOMER');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
-- Author: 160411100153 MOCH. AMIR
--

CREATE TABLE `pengguna` (
  `nama_pengguna` varchar(64) NOT NULL PRIMARY KEY,
  `sandi` varchar(64) NOT NULL,
  `jenis_pengguna` char(2) NOT NULL,
  `email` varchar(64) NOT NULL UNIQUE,
  `nama` char(64) NOT NULL,
  `alamat` varchar(254) DEFAULT NULL,
  `nomor_hp` char(25) NOT NULL UNIQUE,
  `aktif` enum('1', '0') NOT NULL,
  FOREIGN KEY(jenis_pengguna) REFERENCES jenis_pengguna(id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`nama_pengguna`, `sandi`, `jenis_pengguna`, `email`, `nama`, `alamat`, `nomor_hp`, `aktif`) VALUES
('admin', SHA2('admin', 0), '0', 'admin@admin.com', 'MOCH. AMIR', 'Jl. Soekarno - Hatta No. 123 Bangkalan', '080000000000', '1'),

('isol', SHA2('isol123', 0), '1', 'mohammadfaishol@gmail.com', 'MOHAMMAD FAISHOL', 'KAMAL - BANGKALAN', '085954972261', '1'),
('rohman', SHA2('rohman123', 0), '1', 'abdurrohman@hotmail.com', 'ABDUR ROHMAN', 'AROSBAYA - BANGKALAN', '085236776762', '1'),
('natiq', SHA2('natiq123', 0), '1', 'natiqhasbi@hotmail.com', 'NATIQ HASBI ALIM', 'KELEYAN - SOCAH - BANGKALAN', '087705698001', '1'),
('amir', SHA2('amir123', 0), '1', 'moch.amir@hotmail.com', 'MOCH. AMIR', 'JADDIH - SOCAH - BANGKALAN', '085230825938', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
-- Author: 160411100145 ABDUR ROHMAN
--

CREATE TABLE `rekening` (
  `nomor_rekening` varchar(25) NOT NULL PRIMARY KEY,
  `nama_pengguna` varchar(64) NOT NULL,
  `aktif` enum('1', '0') NOT NULL,
  FOREIGN KEY(nama_pengguna) REFERENCES pengguna(nama_pengguna) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`nomor_rekening`, `nama_pengguna`, `aktif`) VALUES
('0002-01-011987-11-1', 'isol', '1'),
('0002-01-011987-11-2', 'rohman', '1'),
('0002-01-011987-11-3', 'natiq', '1'),
('0002-01-011987-11-4', 'amir', '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
-- Author: 160411100152 NATIQ HASBI ALIM
--

CREATE TABLE `transaksi` (
  `id` varchar(25) NOT NULL PRIMARY KEY,
  `waktu` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jenis_transaksi` char(2) NOT NULL,
  `rekening_asal` varchar(25) NOT NULL,
  `rekening_tujuan` varchar(25) DEFAULT NULL,
  `nominal` decimal(12,2) NOT NULL,
  FOREIGN KEY(jenis_transaksi) REFERENCES jenis_transaksi(id) ON UPDATE CASCADE,
  FOREIGN KEY(rekening_asal) REFERENCES rekening(nomor_rekening) ON UPDATE CASCADE,
  FOREIGN KEY(rekening_tujuan) REFERENCES rekening(nomor_rekening) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id`, `waktu`, `jenis_transaksi`, `rekening_asal`, `rekening_tujuan`, `nominal`) VALUES
('AB12C-ABCHD-8ABCD-88CAA', '2018-11-01 18:00:00', '0', '0002-01-011987-11-1', NULL, '1000000.00'),
('AB12C-ABCHD-8ABCD-88CAB', '2018-11-01 18:00:00', '0', '0002-01-011987-11-2', NULL, '1000000.00'),
('AB12C-ABCHD-8ABCD-88CAC', '2018-11-01 18:00:00', '0', '0002-01-011987-11-3', NULL, '1000000.00'),
('AB12C-ABCHD-8ABCD-88CAD', '2018-11-01 18:00:00', '0', '0002-01-011987-11-4', NULL, '1000000.00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
