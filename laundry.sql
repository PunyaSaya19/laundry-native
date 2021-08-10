-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 10 Agu 2021 pada 02.11
-- Versi server: 5.6.38
-- Versi PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `z_laundry`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_outlet`
--

CREATE TABLE `tb_outlet` (
  `id_outlet` int(15) NOT NULL,
  `nama_outlet` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_outlet`
--

INSERT INTO `tb_outlet` (`id_outlet`, `nama_outlet`, `alamat`, `telp`) VALUES
(1, 'Cabang 1', 'Jl  ana', '07826282'),
(2, 'Cabang 2', 'Jl. Ajana', '98292'),
(6, 'Cabang 3', 'Jakal\r\n', '08292');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pakaian`
--

CREATE TABLE `tb_pakaian` (
  `id_pakaian` int(15) NOT NULL,
  `id_transaksi` int(15) NOT NULL,
  `jenis_pakaian` varchar(35) NOT NULL,
  `jumlah` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pakaian`
--

INSERT INTO `tb_pakaian` (`id_pakaian`, `id_transaksi`, `jenis_pakaian`, `jumlah`) VALUES
(6, 1, '78', 64),
(9, 2, 'Ja', 64),
(10, 3, 'Iaoa', 3),
(11, 4, 'Kain', 3),
(12, 5, 'Celana', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_paket`
--

CREATE TABLE `tb_paket` (
  `id_paket` int(15) NOT NULL,
  `id_outlet` int(15) NOT NULL,
  `jenis` enum('reguler','kilat') NOT NULL,
  `harga` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_paket`
--

INSERT INTO `tb_paket` (`id_paket`, `id_outlet`, `jenis`, `harga`) VALUES
(6, 2, 'reguler', 2000),
(7, 1, 'reguler', 5000),
(8, 1, 'kilat', 9000),
(9, 2, 'kilat', 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int(15) NOT NULL,
  `nama_pelanggan` varchar(35) NOT NULL,
  `alamat` text NOT NULL,
  `telp` varchar(15) NOT NULL,
  `id_outlet` int(15) NOT NULL,
  `jenis_pelanggan` enum('reguler','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `nama_pelanggan`, `alamat`, `telp`, `id_outlet`, `jenis_pelanggan`) VALUES
(1, 'Budi', 'Jl  ahan', '082629', 1, 'reguler'),
(2, 'Anton', 'Jl. Hana', '072729', 2, 'member'),
(3, 'Susi', 'Jll', '07292', 6, 'reguler');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transaksi`
--

CREATE TABLE `tb_transaksi` (
  `id_transaksi` int(15) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_outlet` int(15) NOT NULL,
  `id_pelanggan` int(15) NOT NULL,
  `id_paket` int(11) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `berat` double NOT NULL,
  `total_bayar` int(20) NOT NULL,
  `status_bayar` enum('belum','lunas') NOT NULL,
  `status_transaksi` enum('proses','selesai','diambil') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_transaksi`
--

INSERT INTO `tb_transaksi` (`id_transaksi`, `id_user`, `id_outlet`, `id_pelanggan`, `id_paket`, `tgl_masuk`, `tgl_selesai`, `berat`, `total_bayar`, `status_bayar`, `status_transaksi`) VALUES
(1, 2, 2, 1, 6, '2021-08-09', '2021-08-09', 2, 4000, 'lunas', 'proses'),
(2, 2, 2, 1, 6, '2021-08-09', '2021-08-09', 1, 2000, 'lunas', 'diambil'),
(3, 2, 2, 2, 6, '2021-08-09', '2021-08-09', 8, 16000, 'lunas', 'diambil'),
(4, 1, 1, 2, 8, '2021-08-09', '2021-08-09', 1, 9000, 'belum', 'proses'),
(5, 1, 1, 3, 7, '2021-08-10', '2021-08-12', 7, 35000, 'belum', 'proses');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_user`
--

CREATE TABLE `tb_user` (
  `id_user` int(11) NOT NULL,
  `nama_user` varchar(35) NOT NULL,
  `username` varchar(35) NOT NULL,
  `password` varchar(35) NOT NULL,
  `id_outlet` int(15) NOT NULL,
  `level` enum('admin','kasir','owner') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_user`
--

INSERT INTO `tb_user` (`id_user`, `nama_user`, `username`, `password`, `id_outlet`, `level`) VALUES
(1, 'administrator', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'admin'),
(2, 'Kasir1', 'kasir', 'c7911af3adbd12a035b289556d96470a', 1, 'kasir'),
(7, 'Owner', 'owner', '72122ce96bfec66e2396d2e25225d70a', 1, 'owner');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_outlet`
--
ALTER TABLE `tb_outlet`
  ADD PRIMARY KEY (`id_outlet`);

--
-- Indeks untuk tabel `tb_pakaian`
--
ALTER TABLE `tb_pakaian`
  ADD PRIMARY KEY (`id_pakaian`),
  ADD KEY `id_transaksi` (`id_transaksi`);

--
-- Indeks untuk tabel `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD PRIMARY KEY (`id_paket`),
  ADD KEY `outletpaket` (`id_outlet`);

--
-- Indeks untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD KEY `pelangganoutlet` (`id_outlet`);

--
-- Indeks untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `transaksipaket` (`id_paket`),
  ADD KEY `transaksioutlet` (`id_outlet`),
  ADD KEY `transaksipelanggan` (`id_pelanggan`),
  ADD KEY `transaksiuser` (`id_user`);

--
-- Indeks untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `usrr` (`id_outlet`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_outlet`
--
ALTER TABLE `tb_outlet`
  MODIFY `id_outlet` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_pakaian`
--
ALTER TABLE `tb_pakaian`
  MODIFY `id_pakaian` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `tb_paket`
--
ALTER TABLE `tb_paket`
  MODIFY `id_paket` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `id_pelanggan` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  MODIFY `id_transaksi` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_pakaian`
--
ALTER TABLE `tb_pakaian`
  ADD CONSTRAINT `tb_pakaian_ibfk_1` FOREIGN KEY (`id_transaksi`) REFERENCES `tb_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD CONSTRAINT `outletpaket` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id_outlet`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD CONSTRAINT `pelangganoutlet` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id_outlet`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_transaksi`
--
ALTER TABLE `tb_transaksi`
  ADD CONSTRAINT `transaksioutlet` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id_outlet`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksipaket` FOREIGN KEY (`id_paket`) REFERENCES `tb_paket` (`id_paket`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksipelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `tb_pelanggan` (`id_pelanggan`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksiuser` FOREIGN KEY (`id_user`) REFERENCES `tb_user` (`id_user`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `usrr` FOREIGN KEY (`id_outlet`) REFERENCES `tb_outlet` (`id_outlet`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
