-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 17 Sep 2024 pada 07.55
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sigh`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun_login`
--

CREATE TABLE `akun_login` (
  `id_akun` int NOT NULL,
  `username` char(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','penilai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `akun_login`
--

INSERT INTO `akun_login` (`id_akun`, `username`, `password`, `role`) VALUES
(1, 'user1', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
(2, 'user2', '96b33694c4bb7dbd07391e0be54745fb', 'user'),
(3, 'penilai1', 'password123', 'penilai'),
(4, 'admin', 'admin', 'admin'),
(5, 'kiri', '$2y$10$1HmKpXYrZswe9sYwXn0AUOGLnqXhzfuYov.WtlFHPDO7N.7JSTzuy', 'user'),
(7, 'kanan', '$2y$10$odnrtVW6UQqY7L0mXcrNb.Ex1S9dORf4Cs1hTPAAvpRU4jZLbbrI.', 'penilai'),
(8, 'kocak', 'kocak1', 'user'),
(10, 'kurang', 'kurengkureng', 'user'),
(11, 'murni', 'murni', 'user'),
(12, 'alex', 'alex', 'user'),
(13, 'mitra', '92706ba4fd3022cede6d1610b17a0d2d', 'user'),
(14, 'momsky', '163218e536c13ff2fc9a4d76e34be085', 'user'),
(15, 'penilai', 'hehe', 'penilai'),
(16, 'penilai2', 'penilai2', 'penilai'),
(17, 'hihi', 'e9f5713dec55d727bb35392cec6190ce', 'user'),
(18, 'hehe', 'minim', 'user'),
(19, 'hamdirendi', 'rendirendi', 'penilai'),
(20, 'hamdihamdi', 'randirandi', 'penilai'),
(21, 'huhu', 'f3c2cefc1f3b082a56f52902484ca511', 'user'),
(22, 'randi', 'ec1a08ca25857e260784856b3556804d', 'penilai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `kategori`) VALUES
(1, 'MENGUMUMKAN INFORMASI'),
(2, 'MENYEDIAKAN DOKUMEN INFORMASI');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kuesioner`
--

CREATE TABLE `kuesioner` (
  `id_kuesioner` int NOT NULL,
  `id_kategori` int NOT NULL,
  `id_subkategori1` int NOT NULL,
  `id_subkategori2` int NOT NULL,
  `id_subkategori3` int NOT NULL,
  `id_pertanyaan` int NOT NULL,
  `pertanyaan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `jawaban` varchar(255) NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `dokumen` varchar(255) DEFAULT NULL,
  `id_organisasi` int NOT NULL,
  `unit_eselon1` varchar(255) NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `nip_responden` char(10) NOT NULL,
  `nilai` int DEFAULT '0',
  `catatan` varchar(255) DEFAULT NULL,
  `verifikasi` tinyint(1) DEFAULT NULL,
  `id_penilai` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `organisasi`
--

CREATE TABLE `organisasi` (
  `id_organisasi` int NOT NULL,
  `id_akun` int NOT NULL,
  `unit_eselon1` varchar(255) NOT NULL,
  `nama_organisasi` varchar(255) NOT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `email_badan` varchar(255) DEFAULT NULL,
  `no_telp_fax` varchar(255) DEFAULT NULL,
  `nip_responden` char(10) NOT NULL,
  `nama_responden` varchar(255) NOT NULL,
  `nilai_kategori1` int NOT NULL,
  `nilai_kategori2` int NOT NULL,
  `nilai_kategori3` int NOT NULL,
  `nilai_kategori4` int NOT NULL,
  `nilai_kategori5` int NOT NULL,
  `nilai_kategori6` int NOT NULL,
  `id_penilai` int DEFAULT NULL,
  `status_kuesioner` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `organisasi`
--

INSERT INTO `organisasi` (`id_organisasi`, `id_akun`, `unit_eselon1`, `nama_organisasi`, `alamat`, `email_badan`, `no_telp_fax`, `nip_responden`, `nama_responden`, `nilai_kategori1`, `nilai_kategori2`, `nilai_kategori3`, `nilai_kategori4`, `nilai_kategori5`, `nilai_kategori6`, `id_penilai`, `status_kuesioner`) VALUES
(1, 1, 'Eselon I Unit 1', 'Organisasi A', 'Jl. Sudirman No. 1', 'orgA@domain.com', '021-1234567', '1234567890', 'Responden A', 90, 85, 88, 92, 86, 89, 3, 1),
(2, 2, 'Eselon I Unit 2', 'Organisasi B', 'Jl. Thamrin No. 2', 'orgB@domain.com', '021-7654321', '0987654321', 'Responden B', 87, 82, 91, 84, 88, 90, 3, 1),
(3, 11, 'Bapak Indonesia', '', '', '', '', '', 'Orangan sawah', 0, 0, 0, 0, 0, 0, NULL, 1),
(4, 12, 'ESELON 2', 'BALAI DESA', 'JLWARNA WARNI', 'kocak@gmail.com', '08978544104', '2104712009', 'Swahan', 0, 0, 0, 0, 0, 0, 1, 1),
(5, 13, 'Unit Eselon 2 ', 'Balaik Desa', 'jl warna wwanis', 'alexzarodaeli8@gmail.com', '08978544104', '0987654322', 'Alekciak', 0, 0, 0, 0, 0, 0, 1, 1),
(6, 14, 'Unit Eselon 3', 'Perpustakaan Indonesia', 'jl jokowi 56 ', 'randymomsky@gmail.com', '088877775555', '1234567892', 'Momsky ah ', 0, 0, 0, 0, 0, 0, 4, 1),
(7, 17, 'ESELON 3', 'UNIT KOCAK DARURAT', 'JL HEH', 'als@gmail.com', '089727121899', '2107412002', 'keke', 0, 0, 0, 0, 0, 0, 1, 1),
(8, 18, 'UNIT GAWAT DARURAT', 'BONCOR', 'JL KENAN KIRI', 'AS@GMAIL.COM', '089721218181', '2107412006', 'KIWI', 0, 0, 0, 0, 0, 0, 1, 1),
(9, 21, '', '', '', '', '', '', '', 0, 0, 0, 0, 0, 0, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penilai_user_access`
--

CREATE TABLE `penilai_user_access` (
  `access_id` int NOT NULL,
  `id_penilai` int NOT NULL,
  `id_organisasi` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `penilai_user_access`
--

INSERT INTO `penilai_user_access` (`access_id`, `id_penilai`, `id_organisasi`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 5),
(4, 3, 3),
(5, 3, 6),
(7, 1, 5),
(8, 4, 6),
(13, 3, 2),
(14, 1, 4),
(15, 1, 8),
(16, 1, 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pertanyaan`
--

CREATE TABLE `pertanyaan` (
  `id_pertanyaan` int NOT NULL,
  `pertanyaan` text,
  `id_kategori` int NOT NULL,
  `id_subkategori1` int NOT NULL,
  `id_subkategori2` int NOT NULL,
  `id_subkategori3` int NOT NULL,
  `bobot` int NOT NULL,
  `web` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `pertanyaan`, `id_kategori`, `id_subkategori1`, `id_subkategori2`, `id_subkategori3`, `bobot`, `web`) VALUES
(1, 'Mengumumkan informasi deskripsi tugas dan fungsi dalam website unit organisasi eselon 1 dan atau UPT bersangkutan yang terbaru', 1, 1, 1, 1, 10, NULL),
(2, 'Mengumumkan LHKPN Pejabat Negara yang telah diperiksa, diverifikasi, dan telah dikirimkan oleh Komisi Pemberantasan Korupsi dalam website (bukan dalam bentuk link KPK) yang terdiri dari Pimpinan unit eselon 1 dan pimpinan UPT yang terbaru', 1, 1, 1, 1, 10, NULL),
(3, 'Mengumumkan program-program atau kegiatan Tahun 2024 unit organisasi eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) yang diumumkan di website yang memuat: nama program/kegiatan; penanggungjawab/pelaksana kegiatan dilengkapi nomor telpon; target dan capaian; jadwal pelaksanaan; dan sumber anggaran serta besaran anggaran.', 1, 1, 1, 2, 10, NULL),
(5, 'Mengumumkan program-program atau kegiatan Tahun 2023 unit organisasi eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) yang diumumkan di website yang memuat: nama program/kegiatan; penanggungjawab/pelaksana kegiatan dilengkapi nomor telpon; target dan capaian; jadwal pelaksanaan; dan sumber anggaran serta besaran anggaran. ', 1, 1, 1, 2, 10, NULL),
(6, 'Mengumumkan informasi realisasi kegiatan beserta capain kinerja unit organisasi eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) ', 1, 1, 1, 2, 10, NULL),
(7, 'Mengumumkan pada website KKP  informasi Laporan Keuangan Tahun 2023  yang telah diaudit sesuai PermenKP No.42 Tahun 2023 yang terdiri dari: ', 1, 1, 1, 3, 10, ''),
(8, 'Rencana dan Laporan Realisasi Anggaran (LRA)', 1, 1, 1, 1, 10, 'Alamat link website dan tangkapan layar yang menyajikan informasi terkait materi kuesioner'),
(9, 'Dokumen program-program atau kegiatan Tahun 2024 Unit Organisasi Eselon 1/UPT sesuai dengan tugas dan fungsi  yang sekurang-kurangnya memuat nama program/kegiatan, sumber anggaran, besaran anggaran. ', 2, 2, 2, 4, 1, 'Upload Link dan Soft Copy dalam Googgle Drive (Renja 2024)');

-- --------------------------------------------------------

--
-- Struktur dari tabel `profile_penilai`
--

CREATE TABLE `profile_penilai` (
  `id_penilai` int NOT NULL,
  `id_akun` int NOT NULL,
  `nip` char(10) NOT NULL,
  `nama_penilai` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `profile_penilai`
--

INSERT INTO `profile_penilai` (`id_penilai`, `id_akun`, `nip`, `nama_penilai`) VALUES
(1, 3, '1234567890', 'Nama Penilai'),
(2, 7, '2107412009', 'Agak Lain'),
(3, 15, '2107412007', 'Rina'),
(4, 16, '0987654324', 'Mataram'),
(5, 19, '2170231084', 'Febrianto'),
(6, 20, '2170231079', 'Rendi'),
(7, 22, '2107410020', 'Randy Ganteng Idaman');

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkategori1`
--

CREATE TABLE `subkategori1` (
  `id_subkategori1` int NOT NULL,
  `subkategori1` varchar(255) NOT NULL,
  `id_kategori` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `subkategori1`
--

INSERT INTO `subkategori1` (`id_subkategori1`, `subkategori1`, `id_kategori`) VALUES
(1, 'INFORMASI WAJIB BERKALA', 1),
(2, 'INFORMASI TERSEDIA SETIAP SAAT & PENGADAAN BARANG DAN JASA', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkategori2`
--

CREATE TABLE `subkategori2` (
  `id_subkategori2` int NOT NULL,
  `subkategori2` varchar(255) NOT NULL,
  `id_subkategori1` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `subkategori2`
--

INSERT INTO `subkategori2` (`id_subkategori2`, `subkategori2`, `id_subkategori1`) VALUES
(1, 'INFORMASI TERKAIT TUGAS DAN FUNGSI UTAMA UNIT ORGANISASI ESELON 1 DAN UPT', 1),
(2, 'Menyediakam Dokumen (digital dan atau hardcopy) Informasi Tersedia Setiap Saat', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `subkategori3`
--

CREATE TABLE `subkategori3` (
  `id_subkategori3` int NOT NULL,
  `subkategori3` varchar(255) NOT NULL,
  `id_subkategori2` int NOT NULL,
  `web` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `subkategori3`
--

INSERT INTO `subkategori3` (`id_subkategori3`, `subkategori3`, `id_subkategori2`, `web`) VALUES
(1, 'Informasi tentang profil unit organisasi ', 1, ''),
(2, 'Informasi tentang program dan/atau kegiatan unit organisasi sesuai PermenKP No 42 Tahun 2023.', 1, ''),
(3, 'Informasi Keuangan', 1, 'Web Akuntabilitas kinerja '),
(4, 'Menyediakan Dokumen informasi yang wajib disediakan dan atau diumumkan  Tahun 2024  program dan kegiatan  meliputi:', 2, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_status`
--

CREATE TABLE `user_access_status` (
  `id_access` int NOT NULL,
  `id_akun` int NOT NULL,
  `id_organisasi` int NOT NULL,
  `can_fill` tinyint(1) DEFAULT '1',
  `last_filled` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  `diberikan_pada` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun_login`
--
ALTER TABLE `akun_login`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `kuesioner`
--
ALTER TABLE `kuesioner`
  ADD PRIMARY KEY (`id_kuesioner`),
  ADD KEY `id_pertanyaan` (`id_pertanyaan`),
  ADD KEY `id_organisasi` (`id_organisasi`),
  ADD KEY `fk_id_penilai` (`id_penilai`),
  ADD KEY `fk_kuesioner_id_kategori` (`id_kategori`),
  ADD KEY `fk_kuesioner_id_subkategori1` (`id_subkategori1`),
  ADD KEY `fk_kuesioner_id_subkategori2` (`id_subkategori2`),
  ADD KEY `fk_kuesioner_id_subkategori3` (`id_subkategori3`);

--
-- Indeks untuk tabel `organisasi`
--
ALTER TABLE `organisasi`
  ADD PRIMARY KEY (`id_organisasi`),
  ADD KEY `fk_akun_organisasi` (`id_akun`),
  ADD KEY `fk_id_penilai_organisasi` (`id_penilai`);

--
-- Indeks untuk tabel `penilai_user_access`
--
ALTER TABLE `penilai_user_access`
  ADD PRIMARY KEY (`access_id`),
  ADD KEY `id_penilai` (`id_penilai`),
  ADD KEY `id_organisasi` (`id_organisasi`);

--
-- Indeks untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD PRIMARY KEY (`id_pertanyaan`),
  ADD KEY `id_kategori` (`id_kategori`),
  ADD KEY `fk_id_subkategori1` (`id_subkategori1`),
  ADD KEY `fk_id_subkategori2` (`id_subkategori2`),
  ADD KEY `fk_id_subkategori3` (`id_subkategori3`);

--
-- Indeks untuk tabel `profile_penilai`
--
ALTER TABLE `profile_penilai`
  ADD PRIMARY KEY (`id_penilai`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `fk_akun_penilai` (`id_akun`);

--
-- Indeks untuk tabel `subkategori1`
--
ALTER TABLE `subkategori1`
  ADD PRIMARY KEY (`id_subkategori1`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `subkategori2`
--
ALTER TABLE `subkategori2`
  ADD PRIMARY KEY (`id_subkategori2`),
  ADD KEY `id_subkategori1` (`id_subkategori1`);

--
-- Indeks untuk tabel `subkategori3`
--
ALTER TABLE `subkategori3`
  ADD PRIMARY KEY (`id_subkategori3`),
  ADD KEY `id_subkategori2` (`id_subkategori2`);

--
-- Indeks untuk tabel `user_access_status`
--
ALTER TABLE `user_access_status`
  ADD PRIMARY KEY (`id_access`),
  ADD KEY `id_akun` (`id_akun`),
  ADD KEY `id_organisasi` (`id_organisasi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun_login`
--
ALTER TABLE `akun_login`
  MODIFY `id_akun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `kuesioner`
--
ALTER TABLE `kuesioner`
  MODIFY `id_kuesioner` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id_organisasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `penilai_user_access`
--
ALTER TABLE `penilai_user_access`
  MODIFY `access_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `profile_penilai`
--
ALTER TABLE `profile_penilai`
  MODIFY `id_penilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `subkategori1`
--
ALTER TABLE `subkategori1`
  MODIFY `id_subkategori1` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `subkategori2`
--
ALTER TABLE `subkategori2`
  MODIFY `id_subkategori2` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `subkategori3`
--
ALTER TABLE `subkategori3`
  MODIFY `id_subkategori3` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `user_access_status`
--
ALTER TABLE `user_access_status`
  MODIFY `id_access` int NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kuesioner`
--
ALTER TABLE `kuesioner`
  ADD CONSTRAINT `fk_id_penilai` FOREIGN KEY (`id_penilai`) REFERENCES `profile_penilai` (`id_penilai`),
  ADD CONSTRAINT `fk_kuesioner_id_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`),
  ADD CONSTRAINT `fk_kuesioner_id_subkategori1` FOREIGN KEY (`id_subkategori1`) REFERENCES `subkategori1` (`id_subkategori1`),
  ADD CONSTRAINT `fk_kuesioner_id_subkategori2` FOREIGN KEY (`id_subkategori2`) REFERENCES `subkategori2` (`id_subkategori2`),
  ADD CONSTRAINT `fk_kuesioner_id_subkategori3` FOREIGN KEY (`id_subkategori3`) REFERENCES `subkategori3` (`id_subkategori3`),
  ADD CONSTRAINT `kuesioner_ibfk_1` FOREIGN KEY (`id_pertanyaan`) REFERENCES `pertanyaan` (`id_pertanyaan`);

--
-- Ketidakleluasaan untuk tabel `organisasi`
--
ALTER TABLE `organisasi`
  ADD CONSTRAINT `fk_akun_organisasi` FOREIGN KEY (`id_akun`) REFERENCES `akun_login` (`id_akun`),
  ADD CONSTRAINT `fk_id_penilai_organisasi` FOREIGN KEY (`id_penilai`) REFERENCES `profile_penilai` (`id_penilai`),
  ADD CONSTRAINT `organisasi_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun_login` (`id_akun`);

--
-- Ketidakleluasaan untuk tabel `penilai_user_access`
--
ALTER TABLE `penilai_user_access`
  ADD CONSTRAINT `penilai_user_access_ibfk_1` FOREIGN KEY (`id_penilai`) REFERENCES `profile_penilai` (`id_penilai`),
  ADD CONSTRAINT `penilai_user_access_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id_organisasi`);

--
-- Ketidakleluasaan untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  ADD CONSTRAINT `fk_id_subkategori1` FOREIGN KEY (`id_subkategori1`) REFERENCES `subkategori1` (`id_subkategori1`),
  ADD CONSTRAINT `fk_id_subkategori2` FOREIGN KEY (`id_subkategori2`) REFERENCES `subkategori2` (`id_subkategori2`),
  ADD CONSTRAINT `fk_id_subkategori3` FOREIGN KEY (`id_subkategori3`) REFERENCES `subkategori3` (`id_subkategori3`),
  ADD CONSTRAINT `pertanyaan_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `profile_penilai`
--
ALTER TABLE `profile_penilai`
  ADD CONSTRAINT `fk_akun_penilai` FOREIGN KEY (`id_akun`) REFERENCES `akun_login` (`id_akun`),
  ADD CONSTRAINT `profile_penilai_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun_login` (`id_akun`);

--
-- Ketidakleluasaan untuk tabel `subkategori1`
--
ALTER TABLE `subkategori1`
  ADD CONSTRAINT `subkategori1_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);

--
-- Ketidakleluasaan untuk tabel `subkategori2`
--
ALTER TABLE `subkategori2`
  ADD CONSTRAINT `subkategori2_ibfk_1` FOREIGN KEY (`id_subkategori1`) REFERENCES `subkategori1` (`id_subkategori1`);

--
-- Ketidakleluasaan untuk tabel `subkategori3`
--
ALTER TABLE `subkategori3`
  ADD CONSTRAINT `subkategori3_ibfk_1` FOREIGN KEY (`id_subkategori2`) REFERENCES `subkategori2` (`id_subkategori2`);

--
-- Ketidakleluasaan untuk tabel `user_access_status`
--
ALTER TABLE `user_access_status`
  ADD CONSTRAINT `user_access_status_ibfk_1` FOREIGN KEY (`id_akun`) REFERENCES `akun_login` (`id_akun`),
  ADD CONSTRAINT `user_access_status_ibfk_2` FOREIGN KEY (`id_organisasi`) REFERENCES `organisasi` (`id_organisasi`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
