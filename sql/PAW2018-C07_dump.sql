-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 01 Nov 2018 pada 16.51
-- Versi server: 10.1.31-MariaDB
-- Versi PHP: 7.2.11

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
--

DROP DATABASE IF EXISTS banking;
CREATE DATABASE IF NOT EXISTS banking;
USE banking;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pengguna`
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
-- Struktur dari tabel `jenis_transaksi`
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
-- Struktur dari tabel `pengguna`
--

CREATE TABLE `pengguna` (
  `id` varchar(25) NOT NULL PRIMARY KEY,
  `email` varchar(64) NOT NULL UNIQUE,
  `nama` char(64) NOT NULL,
  `alamat` varchar(254) DEFAULT NULL,
  `nomor_hp` char(15) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id`, `email`, `nama`, `alamat`, `nomor_hp`) VALUES
('AB12C-ABCHD-8ABCD-88CAA', 'admin@admin.com', 'NAMA ADMIN', 'ALAMAT ADMIN', '080000000000'),
('AB12C-ABCHD-8ABCD-88CAB', 'user@user.com', 'NAMA USER', 'ALAMAT USER', '080000000001'),
('AB12C-ABCHD-8ABCD-88CAC', 'user2@user.com', 'NAMA USER DUA', 'ALAMAT USER 2', '080000000002');

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_pengguna`
--

CREATE TABLE `akun_pengguna` (
  `nama_pengguna` varchar(64) NOT NULL PRIMARY KEY,
  `sandi` varchar(64) NOT NULL,
  `jenis_pengguna` char(2) NOT NULL,
  `id_pengguna` char(25) NOT NULL,
  FOREIGN KEY(jenis_pengguna) REFERENCES jenis_pengguna(id) ON UPDATE CASCADE,
  FOREIGN KEY(id_pengguna) REFERENCES pengguna(id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akun_pengguna`
--

INSERT INTO `akun_pengguna` (`nama_pengguna`, `sandi`, `jenis_pengguna`, `id_pengguna`) VALUES
('admin', SHA2('admin', 0), '0', 'AB12C-ABCHD-8ABCD-88CAA'),
('user', SHA2('user', 0), '1', 'AB12C-ABCHD-8ABCD-88CAB'),
('user2', SHA2('user2', 0), '1', 'AB12C-ABCHD-8ABCD-88CAC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekening`
--

CREATE TABLE `rekening` (
  `nomor_rekening` varchar(25) NOT NULL PRIMARY KEY,
  `id_pengguna` varchar(25) NOT NULL,
  FOREIGN KEY(id_pengguna) REFERENCES pengguna(id) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `rekening`
--

INSERT INTO `rekening` (`nomor_rekening`, `id_pengguna`) VALUES
('0002-01-011987-11-1', 'AB12C-ABCHD-8ABCD-88CAB'),
('0002-01-011987-11-2', 'AB12C-ABCHD-8ABCD-88CAC');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
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
('AB12C-ABCHD-8ABCD-88CAA', '2018-11-01 18:00:00', '0', '0002-01-011987-11-1', NULL, '100000.00'),
('AB12C-ABCHD-8ABCD-88CAB', '2018-11-01 18:00:00', '0', '0002-01-011987-11-2', NULL, '100000.00');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
