-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 14 Okt 2024 pada 09.32
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
  `username` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','penilai') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `akun_login`
--

INSERT INTO `akun_login` (`id_akun`, `username`, `password`, `role`) VALUES
(4, 'admin', '1c99c5a7d118311c49b120be2118e44a', 'admin'),
(22, 'randi', 'ec1a08ca25857e260784856b3556804d', 'penilai'),
(26, 'mitra', '1c99c5a7d118311c49b120be2118e44a', 'user'),
(93, 'bpisdkp', '74c2f31aa9b36d1c5f0fd8e6cdb8b09c', 'user'),
(94, 'bpsplpadang', 'ba4cf44f637af346cb58d8e22b21237c', 'user'),
(95, 'bpsplpontianak', '00d1950af2fbb55d757e85ed71189b1c', 'user'),
(96, 'bpsplmakassar', '1d0edce6a23bbcb4b52cee1a437b1868', 'user'),
(97, 'bpspldenpasar', 'da2ffad33e328985f67303672f20b28b', 'user'),
(98, 'bkkpnkupang', 'dd990d7c6c7b649aaed44b6fed77b998', 'user'),
(99, 'lpsplsorong', '46ce1342b266a38e9bdbe3da2c3ff4f5', 'user'),
(100, 'lkkpnpekanbaru', '53e85b1f800c2007cdf0d41258d0d053', 'user'),
(101, 'lpsplserang', '50358f0cfd2394b41fa5e43f5216d407', 'user'),
(102, 'bbpi', '0950ad65cff2dbfc45f632308770be86', 'user'),
(103, 'ppsbelawan', 'ebbdac6c44c315d0f64b44aff9c7dffa', 'user'),
(104, 'ppsbungus', '39607a77c37c8badf9fc75a7ab85caf0', 'user'),
(105, 'ppsnzj', '9e3eab05dd17649cc3a86fbfb7667435', 'user'),
(106, 'ppscilacap', '37a21dafa0f3e114549c94a6e6231364', 'user'),
(107, 'ppskendari', 'a11ca44fc08bcfceaa86e9ae864fba38', 'user'),
(108, 'ppsbitung', '807f4416b2a3e8892b95d7d6398ef2f4', 'user'),
(109, 'ppnsibolga', '67f03a5ed5955ad6cb777cae8a069464', 'user'),
(110, 'ppntanjungpandan', 'e85fe209d7045393469094f31b536304', 'user'),
(111, 'ppnsungailiat', '85d0dc4f7fb1b636af7509cc7a29a42c', 'user'),
(112, 'ppnpalabuhanratu', 'ecebb48bd95f28f310fcd7f8647c71fe', 'user'),
(113, 'ppnkarangantu', 'b04e26176bfb9b4b88d723361f713009', 'user'),
(114, 'ppnpekalongan', 'd4e3bbd2ae35c14a7cf8be40cfea892b', 'user'),
(115, 'ppnkejawanan', '46980b61604bd889f16c35ca4fea63d6', 'user'),
(116, 'ppnprigi', '749240920695e5202b78570c05ef4458', 'user'),
(117, 'ppnbrondong', 'dd767a3f4f45d1bbbc8a9350f5fd5b4b', 'user'),
(118, 'ppnpemangkat', 'bc6f58e2ddf26cc1a9c76991885debad', 'user'),
(119, 'ppnpengambengan', '3185c9059932486e05d2ca1cf0eb01b5', 'user'),
(120, 'ppnkwandang', 'b915b6bae5eb0c75d4325b3d0bbfc419', 'user'),
(121, 'ppnambon', '234710fd55766d8cd27f4a35606da20b', 'user'),
(122, 'ppnternate', '480625ff63a12ae8c581e83c4b9e7434', 'user'),
(123, 'ppntual', '19b040438194107525acfc20c3793aab', 'user'),
(124, 'ppptelukbatang', 'de337eac539140a5c6cbe682b294131d', 'user'),
(125, 'bbpbatsukabumi', '2faa375fe995b102a51b32f9fb1ea135', 'user'),
(126, 'bbpbapjepara', 'd1caebfb28e0a6256cf2c2cf100ab981', 'user'),
(127, 'bbpbllampung', '906c3f11f36402a4dcfe64563c797b45', 'user'),
(128, 'bpbatsg', '16f23682c8655b9c61676abdc6a0ea2b', 'user'),
(129, 'bpbattatelu', '0aafe7710c612ce6301088e83786b862', 'user'),
(130, 'bpbatmandiangin', '5a60b5de33a68b2bf476119fab7b325d', 'user'),
(131, 'bpbapsitubondo', '49dc4524b2c8a05c9133ca7eff8c9874', 'user'),
(132, 'bpbapujungbatee', '6b3d0d2862719663bfcd054512872391', 'user'),
(133, 'bpbaptakalar', 'da9d0d69ee1a0b8415d8a120fcdd4c9c', 'user'),
(134, 'bpblbatam', 'bd8faa9adfd12bf0c185a14b91544934', 'user'),
(135, 'bpbllombok', '55dbddb735acfeabdca1a17489e1c680', 'user'),
(136, 'bpblambon', 'bdecc8e2623cebc9ddaf171ae6a6dc13', 'user'),
(137, 'bluppbkarawang', 'd542c4fe3e12a61e0e1675d5933b17f3', 'user'),
(138, 'bpiu2kkarangasem', '2d5cb7cdb34a2d869c353e769fac1e4b', 'user'),
(139, 'bpkilserang', '9f155711ca57ce567f085818853c8b8d', 'user'),
(239, 'bbp3kp', 'b460e3a034ed2a7745118c386bf6740a', 'user'),
(240, 'pangkalanlampulo', 'a7e09c4b94c2a63e6714306dd008d080', 'user'),
(241, 'pangkalanbatam', 'ad29af44e18ba11aec80fe1953247fec', 'user'),
(242, 'pangkalanjakarta', 'eecc8396bc97c0e655da265f6ee21e95', 'user'),
(243, 'pangkalanbenoa', '908edbd3f623d0be07681dfdf1d3225b', 'user'),
(244, 'pangkalanbitung', '13c6fc7f786ca5f29d0fcc56c7b59a75', 'user'),
(245, 'pangkalantual', 'ec074664f38575df5b0a4c7a959b46b9', 'user'),
(246, 'stasiuncilacap', 'eeb5e826924cedcfd011c13148e96f97', 'user'),
(247, 'stasiunbelawan', '339e515b205d967c74d5db893e6a7fae', 'user'),
(248, 'stasiunkupang', '8959272aeb0bec66e3a89dae0366597c', 'user'),
(249, 'stasiunpontianak', 'ceef2cc37a9ad9d5d8716dbbddcffa6a', 'user'),
(250, 'stasiuntarakan', '4450caf301739f0bfae0a209fcf1cef6', 'user'),
(251, 'stasiuntahuna', 'dff0d73f788d476a2fb0548989818476', 'user'),
(252, 'stasiunambon', '71aa3c3c94d19a2db2b3d7ea4210847e', 'user'),
(253, 'stasiunbiak', '7c97b576c5a906729aa514624e3425bc', 'user'),
(254, 'bbrsekp_ancol', '4a37b866d31704fe25b9620905ba5093', 'user'),
(255, 'bbrppbkp_slipi', '83214799b871269610c76a5f000335dc', 'user'),
(256, 'bbrblpp_gondol', '9f07d610b5f45ae15bc8012e6590ded8', 'user'),
(257, 'bppbap_maros', '90d42daa7c3d9e2674784cb81a53f4ef', 'user'),
(258, 'brpbatpp_sempur', 'c0080350e63df805061caa8ccc7e6a07', 'user'),
(259, 'brppupp_palembang', 'c6beccbf6cece87558759893298d2420', 'user'),
(260, 'brpl_jakarta', 'fb56f3a46f85249cf5dcf44622721f3c', 'user'),
(261, 'brpsdi_jatiluhur', 'da8510875ef832ef2a396b3f1605dce6', 'user'),
(262, 'brpi_sukamandi', '5e97b1fdeeead52a39baee4f288509f9', 'user'),
(263, 'brbih_depok', 'c76d1ed70ee0ceaf9e0363bb5595092a', 'user'),
(264, 'bppa_sukamandi', 'b2783c71dc69b8640bb7ce3790d49d7c', 'user'),
(265, 'bp3_medan', 'ce4a4767af065d168c376478cc2bbd79', 'user'),
(266, 'bp3_tegal', '22458ff1987938afae7c4c674d55af2f', 'user'),
(267, 'bp3_banyuwangi', 'c0bbd118a4c86dbed0e4a80d5bb1ed34', 'user'),
(268, 'bp3_bitung', '79adaabb313c2bdb9a03c96f5b3a2bfb', 'user'),
(269, 'bp3_ambon', '2e31d4dc1cf3dac19b4cfdea6bcfd86b', 'user'),
(270, 'poltekaup_jakarta', '04235ebe7290e8051f9dab44e9859624', 'user'),
(271, 'poltekkp_bitung', '60ee15a0c2c010740b81489456cc49de', 'user'),
(272, 'poltekkp_sidoarjo', 'a5729e3c1d2fc33fe0d1491f16bc5f30', 'user'),
(273, 'poltekkp_sorong', '27adc496654370b63d5dcb9199f5e7d0', 'user'),
(274, 'poltekkp_karawang', '3e04a11133f0e0168438b2064de8cc14', 'user'),
(275, 'poltekkp_kupang', '1deaba23e97d9747eb55462e36c258e7', 'user'),
(276, 'poltekkp_bone', 'f1b1428be08d5587a2c8f5c0f92a7473', 'user'),
(277, 'poltekkp_dumai', '33b8b87ee12cb6e64539f7c75b945c11', 'user'),
(278, 'poltekkp_pangandaran', '1efb0c49426c66e61c80ed9b491471db', 'user'),
(279, 'poltekkp_jembrana', '61b3642bb91fa02c42e7f0e3a81a54d4', 'user'),
(280, 'akkp_wakatobi', '43cb52999fea5ee9502c09fae901d02d', 'user'),
(281, 'supm_ladong', '02abf80a3d41222771c771ed332252b0', 'user'),
(282, 'supm_pariaman', '134ab4c5439c66d4e327021ea3d47a4d', 'user'),
(283, 'supm_kotaagung', '9274fb89fde8c790f3710132f9a98c51', 'user'),
(284, 'supm_tegal', '7c4a32e4e06116c046ea6999bf7d76c8', 'user'),
(285, 'supm_waiheru', '4db6fb661b41c993b75c1e690e63a5d1', 'user'),
(286, 'lrsdkp_bungus', '79e68ceb95e13d39e04a1c31556ee7cb', 'user'),
(287, 'lptk_wakatobi', '8f579aaed48288ace13fcccb6badaae8', 'user'),
(288, 'lrbrl_boalemo', '4b7d13c4c6ca6e444296d403fa8bb21c', 'user'),
(289, 'lrpt_benoa', '78a2d4d81ef39d7172769f422f75baa0', 'user'),
(290, 'lrmphp_bantul', 'c7de1ea16d6a97b9b0a7269588a2cb5f', 'user'),
(291, 'bppmhkp_jkt1', '17e401b0384e75ffdd17e8d8eace033b', 'user'),
(292, 'bppmhkp_makassar', '04ed37750882ab5c531ba77cd39b0d60', 'user'),
(293, 'bppmhkp_medan1', '55473d53c50202e7e25d246c28009be2', 'user'),
(294, 'bppmhkp_jkt2', '4feb2729da7f8a5e1824774b83cf53cf', 'user'),
(295, 'bppmhkp_sby1', '039f5a4fa2550932228fd98443d472d5', 'user'),
(296, 'bppmhkp_sby2', 'ca11b8a894c41090176be33ca7985e57', 'user'),
(297, 'bppmhkp_denpasar', '05730d4d0c60d33a1e07da4e25d34430', 'user'),
(298, 'bppmhkp_balikpapan', '7458df0a7dd963bc5abeeffd612cb511', 'user'),
(299, 'bppmhkp_jayapura', '8a20f4f1f2975fae78a64d554183fa06', 'user'),
(300, 'bppmhkp_manado', '1af636aa1bae06efa22e5fdd7d1c842a', 'user'),
(301, 'bppmhkp_semarang', 'f5f1efe2cc5e89ce01cc4574132a8f70', 'user'),
(302, 'bppmhkp_mataram', '296aaf3a5a15ed6a2c3ad74658f08636', 'user'),
(303, 'bppmhkp_banjarmasin', 'd32812ce30d8f4cad3e1de02c99a2c19', 'user'),
(304, 'bppmhkp_entikong', '7daeea5c8fdfbfd8c2a7cce8f125651d', 'user'),
(305, 'bppmhkp_tanjungpinang', '445308d93da1527588bb6d3a8866526d', 'user'),
(306, 'bppmhkp_tarakan', 'f4c81d658195cd197fea7d1d9d2ec65d', 'user'),
(307, 'bppmhkp_ambon', '4e325df633c1cc253ec135982c06ae6d', 'user'),
(308, 'buspm', 'a7da0afb407a7c655c480483d2c77c2e', 'user'),
(309, 'bppmhkp_palembang', '5cb82db1bc9137ff1fc5a9da7b80e54c', 'user'),
(310, 'bppmhkp_aceh', '45b34cee5207a80fd4b302c736662a59', 'user'),
(311, 'bppmhkp_medan2', '3b4aa7ba35aa29e34ac1d4f8aa58181e', 'user'),
(312, 'bppmhkp_jambi', '48cc5874fe72ea60c3cd99c9266847b4', 'user'),
(313, 'bppmhkp_batam', '0fe16338648e6abf5fcc7339503d8c2b', 'user'),
(314, 'bppmhkp_padang', '524d3634e0dfe41397fc35a44febacf6', 'user'),
(315, 'bppmhkp_pangkalpinang', '40c66ec055b9504a415772cdff3e4b1c', 'user'),
(316, 'bppmhkp_lampung', '0946924b10f34c60bfc3f344aa701d90', 'user'),
(317, 'bppmhkp_pekanbaru', 'ecbd51128ed2dbb30ab883b10c052d39', 'user'),
(318, 'bppmhkp_yogyakarta', '49f65e638f8353ddaedca40a432b239b', 'user'),
(319, 'bppmhkp_pontianak', '99c0d164952f27ba2a3844c6f6bd4316', 'user'),
(320, 'bppmhkp_palangkaraya', '1aaf7950caa0b02c1b255b469d50d934', 'user'),
(321, 'bppmhkp_palu', '52c0f900182e27e12f634123bbe9b74d', 'user'),
(322, 'bppmhkp_gorontalo', '22463428c1dabc2ad653ea70b89321e6', 'user'),
(323, 'bppmhkp_kendari', '0803406b6b13bd54fd5f947b9d57c438', 'user'),
(324, 'bppmhkp_kupang', '993d0ae3bf17117d6c51b6ddfd7bc41d', 'user'),
(325, 'bppmhkp_ternate', '3210fdb7ec7af718f003d177568a9c01', 'user'),
(326, 'bppmhkp_bengkulu', 'f5070be767c80e246964354fd3abab4d', 'user'),
(327, 'bppmhkp_tanjungbalaiasahan', 'd02022b7b5cacdffe49c573af0fd8929', 'user'),
(328, 'bppmhkp_cirebon', 'fc81795590704ec08d3b9f4de0c44de2', 'user'),
(329, 'bppmhkp_bandung', '50c3f6dc0f7556388ba50eec99ed6f12', 'user'),
(330, 'bppmhkp_merak', '8fe51473b368877c5b9918657ccfabe9', 'user'),
(331, 'bppmhkp_luwukbanggai', '83108adf8c1d49f8db89ad7c93608d3b', 'user'),
(332, 'bppmhkp_mamuju', '416ec381066de7145988c63971b8debf', 'user'),
(333, 'bppmhkp_tahuna', 'bd0a59505733d43ca2c51be20b180dd3', 'user'),
(334, 'bppmhkp_baubau', 'e1255d79704f03dad0fc53eed63786a5', 'user'),
(335, 'bppmhkp_bima', 'c0c03e53834d6e6107be8cc1458a8aa6', 'user'),
(336, 'bppmhkp_sorong', 'e69ce556b44d03267e76f4faaa6b1c38', 'user'),
(337, 'bppmhkp_merauke', '080c2d89c1781ccf03ae28fe590c95f4', 'user'),
(344, 'anggiet', '99c36847b81bfa9298f35251161b6fd6', 'penilai'),
(345, 'oci', 'b4f90e114cbaf8d8c8840ea9a0325a31', 'penilai'),
(346, 'ochi', '739729b2c0dc63ab5d11f8628170666b', 'user'),
(347, 'oci123', 'd04d6ccb9c50f0af8789ade5d2b0c7d5', 'user'),
(348, 'ocii', 'b50f978abe1aaf76b61bdc4181df75b0', 'user'),
(349, 'alex', '534b44a19bf18d20b71ecc4eb77c572f', 'user'),
(350, 'yabes', '10b02c90340d67ab70dff6e33f47c9c4', 'user'),
(351, 'qwerty', 'd8578edf8458ce06fbc5bb76a58c5ca4', 'user'),
(352, 'mata', '1c99c5a7d118311c49b120be2118e44a', 'user');

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
(3, 'MENYEDIAKAN DOKUMEN INFORMASI'),
(4, 'SARANA PRASARANA'),
(5, 'KELEMBAGAAN PPID'),
(6, 'DIGITALISASI');

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
  `nilai` float(4,2) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  `verifikasi` tinyint(1) DEFAULT NULL,
  `id_penilai` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `kuesioner`
--

INSERT INTO `kuesioner` (`id_kuesioner`, `id_kategori`, `id_subkategori1`, `id_subkategori2`, `id_subkategori3`, `id_pertanyaan`, `pertanyaan`, `jawaban`, `link`, `dokumen`, `id_organisasi`, `unit_eselon1`, `nama_organisasi`, `nip_responden`, `nilai`, `catatan`, `verifikasi`, `id_penilai`) VALUES
(16, 37, 23, 14, 28, 49, 'dimana aja ya?', 'Ya', 'google.com', 'uploads/17092024_SAQ MONEV KIP_Internal KKP 2024.pdf', 10, 'Sekretariat Jenderal', 'kkp  ja', '1122334411', 1.00, 'sad', 1, 12),
(17, 37, 23, 14, 28, 49, 'dimana aja ya?', 'Tidak', '', '', 13, 'Direktorat Jenderal Pengelolaan Kelautan dan Ruang Laut', 'alex', '1122334411', 0.00, NULL, NULL, 12),
(18, 37, 23, 14, 28, 50, 'gimana klo itu', 'Ya', '', '', 13, 'Direktorat Jenderal Pengelolaan Kelautan dan Ruang Laut', 'alex', '1122334411', 0.00, NULL, NULL, 12),
(19, 1, 1, 1, 1, 1, 'Mengumumkan informasi deskripsi tugas dan fungsi dalam website unit organisasi eselon 1 dan atau UPT bersangkutan yang terbaru', 'Ya', 'safas', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.30, 'fas', 1, 12),
(20, 1, 1, 1, 1, 2, 'Mengumumkan LHKPN Pejabat Negara yang telah diperiksa, diverifikasi, dan telah dikirimkan oleh Komisi Pemberantasan Korupsi dalam website (bukan dalam bentuk link KPK) yang terdiri dari Pimpinan unit eselon 1 dan pimpinan UPT yang terbaru', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.30, 'afs', 1, 12),
(21, 1, 1, 1, 1, 3, 'Mengumumkan informasi jumlah dan prosentase yang wajib LHKSN dalam lingkup unit kerja eselon 1 dan atau UPT yang terbaru (2023)', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.30, 'asf', 1, 12),
(22, 5, 10, 13, 21, 125, 'Menyediakan anggaran rutin kegiatan Layanan keterbukaan informasi', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 1.50, 'fas', 1, 12),
(23, 5, 10, 13, 21, 126, 'Menyediakan anggaran bagi peningkatan kapasitas SDM pengelola PPID', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 2.00, 'fas', 1, 12),
(24, 3, 7, 7, 13, 37, 'Dokumen program-program atau kegiatan Tahun 2024 Unit Organisasi Eselon 1/UPT sesuai dengan tugas dan fungsi  yang sekurang-kurangnya memuat nama program/kegiatan, sumber anggaran, besaran anggaran. ', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.25, 'afs', 1, 12),
(25, 3, 7, 7, 13, 38, 'Dokumen laporan keuangan hasil audit Tahun 2023 lengkap terdiri dari CALK, LRA, Neraca dan Daftar Aset dan Investasi ', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.50, 'asf', 1, 12),
(26, 3, 7, 7, 13, 39, 'Dokumen keuangan tahun 2024 dalam bentuk DIPA dan RKA-KL ', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.50, 'asf', 1, 12),
(27, 3, 7, 7, 13, 42, 'Kerangka Acuan Kerja (KAK);', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.50, 'fas', 1, 12),
(28, 4, 8, 8, 16, 96, 'Informasi Wajib Berkala yang diperbaharui minimal 6 bulan sekali sesuai PermenKP No.42 Tahun 2023, meliputi: <br> a. Informasi tentang profil Kementerian; <br> b. ringkasan Informasi tentang program dan kegiatan sedang dijalankan;  <br> c. ringkasan Informasi tentang kinerja capaian dalam lingkup Unit organisasinya; <br> d. ringkasan laporan keuangan telah diaudit; <br> e. ringkasan laporan akses Informasi Publik; <br> f. Informasi tentang peraturan, keputusan, kebijakan; <br> g. Informasi tentang prosedur memperoleh Informasi Publik; <br> h. Informasi tentang tata cara pengaduan penyalahgunaan wewenang atau pelanggaran yang dilakukan pejabat jajaran di organisasi; <br> i. Informasi tentang pengadaan barang dan jasa sesuai dengan ketentuan peraturan perundangundangan; <br> j. Informasi tentang kepegawaian; dan <br> k. Informasi tentang prosedur peringatan dini dan prosedur evakuasi keadaan darurat di lingkungan unit organisasinya.', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 1.00, 'asf', 1, 12),
(29, 4, 8, 8, 16, 97, 'Informasi Tersedia Setiap Saat sesuai PermenKP No.42 Tahun 2023, meliputi: <br> a. Daftar Informasi Publik; <br> b. Informasi tentang peraturan, keputusan, dan kebijakan Unit organisasinya; <br> c. Informasi tentang organisasi, administrasi, kepegawaian, dan keuangan; <br> d. surat perjanjian dengan pihak ketiga berikut dokumen pendukungnya; <br> e. surat menyurat pimpinan atau pejabat Kementerian dalam rangka pelaksanaan tugas, fungsi, dan wewenangnya; <br> f. persyaratan perizinan, perizinan yang diterbitkan oleh unit organisasinya; <br> g. data perbendaharaan atau inventaris; <br> h. rencana strategis dan rencana kerja unit organisasinya; <br> i. agenda kerja pimpinan satuan kerja; <br> j. Informasi mengenai kegiatan pelayanan Informasi Publik; <br> k. jumlah, jenis, dan gambaran umum pelanggaran; yang ditemukan dalam pengawasan internal serta laporan penindakannya; <br> l. jumlah, jenis, dan gambaran umum pelanggaran yang dilaporkan oleh masyarakat serta laporan penindakannya; <br> m. peraturan perundang-undangan yang telah disahkan beserta kajian akademik; <br> n. Informasi dan kebijakan yang disampaikan pejabat unit organisasinya dalam pertemuan yang terbuka untuk umum; <br> o. Informasi Publik lain yang telah dinyatakan terbuka bagi masyarakat berdasarkan masa berlaku atau uji konsekuensi;<br> p. Informasi tentang standar layanan Informasi.', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.50, 'asf', 1, 12),
(30, 6, 11, 14, 22, 127, 'Mengumumkan Informasi berkaitan ruang lingkup, tugas dan fungsi Unit organisasi Eselon I bagi PPID Pelaksana Pusat, dan Ruang lingkup, tugas dan fungsi internal UPT bagi PPID Pelaksana UPT.', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 1.00, 'asf', 1, 12),
(31, 6, 11, 14, 22, 128, 'Mengumumkan Informasi program dan kegiatan 2024 Unit organisasi  Eselon I dalam Medsos PPID Pelaksana Pusat dan  UPT', 'Tidak', NULL, NULL, 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', NULL, 'SAS', 1, 12),
(32, 6, 11, 14, 22, 129, 'Mengumumkan informasi DIPA atau RKA K/L Tahun Anggaran 2024', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.50, 'ASF', 1, 12),
(33, 6, 11, 14, 22, 130, 'Mengumumkan alur Permintaan Informasi Publik sesuai mekanisme di PPID Pelaksana Pusat maupun UPT.', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.25, 'ASF', 1, 12),
(34, 6, 11, 14, 22, 131, 'Mengumumkan Informasi berkaitan  alasan yang dapat digunakan Pemohon Informasi mengajukan keberatan (Sesuai PermenKP No.42 Tahun 2023). Tidak lengkap menghilangkan nilai nomor ini.', 'Ya', 'http://localhost/Pelikan/upt/kuesioner.php', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', 0.50, 'saf', 1, 12),
(35, 6, 12, 15, 23, 132, 'Pemanfatan aplikasi atau replikasi Inovasi (digital atau non-digital) untuk mewujudkan transparansi dan akuntabilitas di lingkungan Unit Organisasi PPID Pelaksana Pusat maupun UPT', 'Ya', '', '', 1, 'Sekretariat Jenderal', 'asfas', 'asfasf', NULL, 'asf', 1, 12),
(38, 1, 1, 1, 1, 1, 'Mengumumkan informasi deskripsi tugas dan fungsi dalam website unit organisasi eselon 1 dan atau UPT bersangkutan yang terbaru', 'Ya', 'mantap.com', '', 3, 'Direktorat Jenderal Pengelolaan Kelautan dan Ruang Laut', 'SAFAS', 'ASF', 0.15, 'saf', 1, 12);

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
  `jabatan` varchar(255) DEFAULT NULL,
  `nilai_kategori1` float(4,2) DEFAULT NULL,
  `nilai_kategori2` float(4,2) DEFAULT NULL,
  `nilai_kategori3` float(4,2) DEFAULT NULL,
  `nilai_kategori4` float(4,2) DEFAULT NULL,
  `nilai_kategori5` float(4,2) DEFAULT NULL,
  `nilai_kategori6` float(4,2) DEFAULT NULL,
  `id_penilai` int DEFAULT NULL,
  `can_fill_out` tinyint(1) DEFAULT '1',
  `verifikasi` tinyint(1) DEFAULT '1',
  `batas_waktu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `organisasi`
--

INSERT INTO `organisasi` (`id_organisasi`, `id_akun`, `unit_eselon1`, `nama_organisasi`, `alamat`, `email_badan`, `no_telp_fax`, `nip_responden`, `nama_responden`, `jabatan`, `nilai_kategori1`, `nilai_kategori2`, `nilai_kategori3`, `nilai_kategori4`, `nilai_kategori5`, `nilai_kategori6`, `id_penilai`, `can_fill_out`, `verifikasi`, `batas_waktu`) VALUES
(1, 26, 'Direktorat Jenderal Pengelolaan Kelautan dan Ruang Laut', 'asfas', 'asfasf', 'asfasf@gmail.com', 'asfasf', 'asfasf', 'asffas', 'motor', 0.90, NULL, 1.75, 1.50, 3.50, 2.25, 12, 1, 1, '1728885600'),
(3, 352, 'Direktorat Jenderal Pengelolaan Kelautan dan Ruang Laut', 'SAFAS', 'ASF', 'as@gmail.com', 'ASFFFAS', 'ASF', 'ASF', 'AS', 1.05, NULL, 1.75, 1.50, 3.50, 2.25, 12, 0, 1, '1728885600'),
(4, 4, 'Direktorat Jenderal Perikanan Budi Daya', 'MANTAP', 'LASFNASKFASN', 'HEHE@GMAIL.COM', 'ASKLFLASKFAS', '2107412007', 'KJASNFAS', 'KLNASFAS', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '1728885600');

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
(1, 12, 1),
(2, 12, 3);

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
  `bobot` double DEFAULT NULL,
  `web` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `A` float(4,2) DEFAULT NULL,
  `B` float(4,2) DEFAULT NULL,
  `C` float(4,2) DEFAULT NULL,
  `D` float(4,2) DEFAULT NULL,
  `E` float(4,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `pertanyaan`
--

INSERT INTO `pertanyaan` (`id_pertanyaan`, `pertanyaan`, `id_kategori`, `id_subkategori1`, `id_subkategori2`, `id_subkategori3`, `bobot`, `web`, `A`, `B`, `C`, `D`, `E`) VALUES
(1, 'Mengumumkan informasi deskripsi tugas dan fungsi dalam website unit organisasi eselon 1 dan atau UPT bersangkutan yang terbaru', 1, 1, 1, 1, 0.5, 'Alamat link unit organisasi eselon 1/UPT yang memuat deskripsi tugas dan fungsi', 0.50, 0.30, 0.15, 0.00, NULL),
(2, 'Mengumumkan LHKPN Pejabat Negara yang telah diperiksa, diverifikasi, dan telah dikirimkan oleh Komisi Pemberantasan Korupsi dalam website (bukan dalam bentuk link KPK) yang terdiri dari Pimpinan unit eselon 1 dan pimpinan UPT yang terbaru', 1, 1, 1, 1, 0.5, 'LHKPN Tahun terakhir  Pimpinan unit eselon 1 atau pimpinan UPT dan atau pegawai yang wajib LHKPN ', 0.50, 0.30, 0.15, 0.00, NULL),
(3, 'Mengumumkan informasi jumlah dan prosentase yang wajib LHKSN dalam lingkup unit kerja eselon 1 dan atau UPT yang terbaru (2023)', 1, 1, 1, 1, 0.5, 'Link website terkait LHKSN', 0.50, 0.30, 0.15, 0.00, NULL),
(4, 'Mengumumkan<b> program-program atau kegiatan Tahun 2024</b> unit organisasi eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) yang diumumkan di website yang memuat: nama program/kegiatan; penanggungjawab/pelaksana kegiatan dilengkapi target dan capaian; jadwal pelaksanaan; dan sumber anggaran serta besaran anggaran.', 1, 1, 1, 2, 1, 'Alamat link website yang menyajikan informasi terkait program kegiatan yang TELAH DILAKSANAKAN dan SEDANG DILAKSANAKAN', 1.00, 0.75, 0.50, 0.25, 0.00),
(5, 'Mengumumkan<b> program-program atau kegiatan Tahun 2023 </b>unit organisasi eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) yang diumumkan di website yang memuat: nama program/kegiatan; penanggungjawab/pelaksana kegiatan dilengkapi target dan capaian; jadwal pelaksanaan; dan sumber anggaran serta besaran anggaran. ', 1, 1, 1, 2, 0.5, 'Alamat link website yang menyajikan informasi program/kegiatan yang sudah dilaksanakan ', 0.50, 0.30, 0.15, 0.00, NULL),
(6, 'Mengumumkan informasi realisasi kegiatan beserta capain kinerja unit organisasi eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) ', 1, 1, 1, 2, 0.5, 'Alamat link website yang menyajikan informasi program/kegiatan yang SEDANG dilaksanakan tahun 2024. ', 0.50, 0.30, 0.15, 0.00, NULL),
(7, 'Mengumumkan pada website KKP  informasi Laporan Keuangan Tahun 2023  yang telah diaudit sesuai PermenKP No.42 Tahun 2023 yang terdiri dari:<br> <br> ‎- Rencana dan Laporan Realisasi Anggaran (LRA)', 1, 1, 1, 3, 0.5, 'Alamat link website yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(11, '- Neraca', 1, 1, 1, 3, 0.5, 'Alamat link website yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(12, '- Catatan Atas Laporan Keuangan (CALK)', 1, 1, 1, 3, 0.5, 'Alamat link website yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(13, '- Daftar Aset dan Investasi', 1, 1, 1, 3, 0.5, 'Alamat link website yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(14, 'Mengumumkan dalam website KKP terkait  informasi keuangan Tahun 2023 dalam bentuk:<br> <br>- DIPA', 1, 1, 1, 3, 0.5, 'Alamat link website yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(15, '- RKA-KL', 1, 1, 1, 3, 0.5, 'Alamat link website yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(16, 'Informasi realisasi atau penyerapan penggunaan keuangan  Eselon 1 /UPT pada semester 1 Tahun 2024', 1, 1, 1, 3, 0.5, 'Alamat link G.Drive yang menyajikan informasi terkait materi kuesioner', 0.50, 0.30, 0.15, 0.00, NULL),
(17, 'Mengumumkan informasi <b>rencana umum pengadaan</b> sesuai tugas dan fungsi Unit Kerja Eselon 1/UPT  sebagaimana tercantum dalam SIRUP .', 1, 1, 1, 5, 1, 'Alamat link website yang menyajikan informasi terkait materi kuesioner disertai Soft file Daftar Paket (sertakan tautan link)', 1.00, 0.75, 0.50, 0.25, 0.00),
(18, 'Sebutkan dua pengumuman paket tertinggi pengadaan barang dan jasa Tahun 2024 sesuai program atau kegiatan konstruksi atau non-konstruksi sebagaimana tercantum dalam LPSE <b>yang telah selesai tender </b>', 1, 1, 1, 5, NULL, 'Alamat link website yang menyajikan informasi terkait materi kuesioner disertai Soft file Daftar Paket (sertakan tautan link)', NULL, NULL, NULL, NULL, NULL),
(19, 'a. Paket 1', 1, 1, 1, 5, 1, 'Alamat link LPSE yang memuat informasi tender telah selesai', 1.00, 0.75, 0.50, 0.25, 0.00),
(20, 'b. Paket 2', 1, 1, 1, 5, 1, 'Alamat link LPSE yang memuat informasi tender telah selesai', 1.00, 0.75, 0.50, 0.25, 0.00),
(21, 'Sebutkan dua pengumuman paket tertinggi  pengadaan barang dan jasa Tahun 2024 sesuai program atau kegiatan konstruksi atau non-konstruksi tidak termasuk jasa perorangan sebagaimana tercantum dalam LPSE <b>dengan status tahap tender (tender belum selesai), tender ulang atau tender gagal</b>', 1, 1, 1, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(22, 'a. Paket 1', 1, 1, 1, 5, 1, 'Alamat link LPSE yang memuat informasi tahap tender, tender gagal atau tender ulang', 1.00, 0.75, 0.50, 0.25, 0.00),
(23, 'b. Paket 2', 1, 1, 1, 5, 1, 'Alamat link LPSE yang memuat informasi tahap tender, tender gagal atau tender ulang', 1.00, 0.75, 0.50, 0.25, 0.00),
(31, 'Unit Organisasi Eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) menyediakan dan mengumumkan dan menetapkan informasi yang dikuasasi Tahun 2024 dalam Daftar Informasi Publik (DIP) online, sesuai standar Perki 1 Tahun 2021.', 1, 5, 5, 11, 1, 'Link website dokumen dan tautan dropbox atau g-drive DIP terbaru yang telah disahkan/ditanda tangani pejabat berwenang', 1.00, 0.75, 0.50, 0.25, 0.00),
(32, 'Unit Organisasi Eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) telah mencantumkan informasi dikecualikan yang habis jangka waktu pengecualian sebagai informasi terbuka.', 1, 5, 5, 11, 1, 'link web atau G-Drive (menunjukan DIK yang telah selesai masa pemberlakuannya dalam bentuk SK PPID Pelaksana Pusat atau UPT)', 1.00, 0.75, 0.50, 0.25, 0.00),
(36, 'Unit Organisasi Eselon 1 (bagi PPID Pelaksana Pusat) dan unit organisasi UPT (bagi PPID Pelaksana UPT) menyediakan dan mengumumkan Informasi Dikecualikan Tahun 2024 hasil Uji Konsekuensi sesuai Perki 1 Tahun 2021 Tentang SLIP', 1, 6, 6, 12, 1, 'Link Daftar Informasi Yang Dikecuaikan (DIK) hasil Uji Konsekuensi 2024 yang telah disahkan pejabat berwenang', 1.00, 0.75, 0.50, 0.25, 0.00),
(37, 'Dokumen program-program atau kegiatan Tahun 2024 Unit Organisasi Eselon 1/UPT sesuai dengan tugas dan fungsi  yang sekurang-kurangnya memuat nama program/kegiatan, sumber anggaran, besaran anggaran. ', 3, 7, 7, 13, 1, 'Upload Link dan Soft Copy dalam Googgle Drive (Renja 2024)', 1.00, 0.75, 0.50, 0.25, 0.00),
(38, 'Dokumen laporan keuangan hasil audit Tahun 2023 lengkap terdiri dari CALK, LRA, Neraca dan Daftar Aset dan Investasi ', 3, 7, 7, 13, 1, 'Upload Link dan Soft Copy dalam Google Drive', 1.00, 0.75, 0.50, 0.25, 0.00),
(39, 'Dokumen keuangan tahun 2024 dalam bentuk DIPA dan RKA-KL ', 3, 7, 7, 13, 1, 'Upload Link dan Soft Copy dalam Googgle Drive', 1.00, 0.75, 0.50, 0.25, 0.00),
(40, 'Menyediakan dokumen pengadaan barang dan jasa yang telah diumumkan, rencana, selesai tender atau penunjukan langsung dan telah serah terima pekerjaan Tahun 2024, meliputi:', 3, 7, 7, 13, NULL, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada lampirkan surat pernyataan TTD Ses Eselon I/Kepala UPT)', NULL, NULL, NULL, NULL, NULL),
(42, 'Kerangka Acuan Kerja (KAK);', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(43, 'Harga Perkiraan Sendiri (HPS) serta Riwayat HPS;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(44, 'Spesifikasi Teknis;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(45, 'Rancangan Kontrak;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(52, 'Dokumen Persyaratan Penyedia atau Lembar Data Kualifikasi;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(53, 'Dokumen Persyaratan Proses Pemilihan atau Lembar Data Pemilihan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(54, 'Daftar Kuantitas dan Harga;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(55, 'Jadwal pelaksanaan dan data lokasi pekerjaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(56, 'Gambar Rancangan Pekerjaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(57, 'Dokumen Studi Kelayakan dan Dokumen Lingkungan Hidup, termasuk Analisis Mengenai Dampak Lingkungan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(58, 'Dokumen Penawaran Administratif;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(59, 'Surat Penawaran Penyedia;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(60, 'Sertifikat atau Lisensi yang masih berlaku dari Direktorat Jenderal Kekayaan Intelektual Kementerian Hukum dan Hak Asasi Manusia;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(61, 'Berita Acara Pemberian Penjelasan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(62, 'Berita Acara Pengumuman Negosiasi;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(63, 'Berita Acara Sanggah dan Sanggah Banding;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(64, 'Berita Acara Penetapan atau Pengumuman Penyedia;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(65, 'Laporan Hasil Pemilihan Penyedia;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(66, 'Surat Penunjukan Penyedia Barang/Jasa (SPPBJ);', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(67, 'Dokumen Kontrak yang telah ditandatangani beserta Perubahan Kontrak yang tidak mengandung informasi yang dikecualikan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(68, 'Surat Perintah Mulai Kerja;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(69, 'Surat Jaminan Pelaksanaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(70, 'Surat Jaminan Uang Muka;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(71, 'Surat Jaminan Pemeliharaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(72, 'Surat Tagihan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(73, 'Surat Pesanan E-purchasing;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(74, 'Surat Perintah Membayar;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(75, 'Surat Perintah Pencairan Dana;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(76, 'Laporan Pelaksanaan Pekerjaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(77, 'Laporan Penyelesaian Pekerjaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(78, 'Berita Acara Pemeriksaan Hasil Pekerjaan;', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(79, 'Berita Acara Serah Terima atau Final Hand Over', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(80, 'Berita Acara Serah Terima atau Final Hand Over', 3, 7, 7, 13, 0.5, 'Upload Link dan Soft Copy dalam Googgle Drive (Jika tidak ada  (Tidak di persyaratkan)', 0.50, 0.30, 0.15, 0.00, NULL),
(83, 'Memorandum of Understanding (MoU) Tahun 2023 - 2024', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive (Jika tidak ada lampirkan surat pernyataan TTD Ses Eselon I/Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(84, 'Surat Perjanjian Kerjasama/Kemitraan Tahun 2023 - 2024, misal: pengelolaan aset, dll', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive (Jika tidak ada lampirkan surat pernyataan TTD Ses Eselon I/Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(85, 'Surat Perjanjian Swakelola  Tahun 2023 - 2024', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive (Jika tidak ada lampirkan surat pernyataan TTD Ses Eselon I/Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(86, 'Surat Penugasan atau Surat Pembentukan Tim Swakelola Tahun 2023-2024', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive (Jika tidak ada lampirkan surat pernyataan TTD Ses Eselon I/Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(87, 'Menyediakan dokumen Surat menyurat pimpinan atau pejabat  Unit Organisasi Eselon 1/UPT  dalam rangka pelaksanaan tugas, fungsi, dan wewenangnya 2023-2024; (sediakan daftarnya dan ambil sampling 2 dokumen setiap tahunnya)', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive ', 0.50, 0.30, 0.15, 0.00, NULL),
(88, 'Menyediakan dokumen kepegawaian meliputi: Jumlah pegawai, jenis kelamin, sebaran pegawai, dan gambaran umum pelanggaran yang ditemukan dalam pengawasan internal kepegawaian 2023-2024. ', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive dan Website KKP (Bisa dalam bentuk infografis) (Jika tidak ada maka buat surat pernyataan TTD Ses Eselon I dan Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(89, 'Menyediakan dokumen pengaduan masyarakat: jumlah pengaduan, jenis, dan gambaran umum Pengaduan, serta laporan penindakannya 2023-2024.', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive (Bisa dalam bentuk infografis (Jika tidak ada maka buat surat pernyataan TTD Ses Eselon I dan Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(90, 'Menyediakan dokumen pengaduan masyarakat: jumlah pengaduan, jenis, dan gambaran umum Pengaduan, serta laporan penindakannya 2023-2024.', 3, 7, 7, 14, 0.5, 'Daftar-nya disertai Dokumen di Upload Link di G.Drive (Bisa dalam bentuk infografis (Jika tidak ada maka buat surat pernyataan TTD Ses Eselon I dan Kepala UPT)', 0.50, 0.30, 0.15, 0.00, NULL),
(92, 'Jumlah Permintaan Informasi Publik: Waktu yang diperlukan, Jumlah Permintaan yang dikabulkan baik sebagian atau seluruhnya dan permintaan yang ditolak, Alasan penolakan (bila ada).', 3, 7, 7, 15, 0.5, 'upload link website atau G-Drive Dalam bentuk Grafik dan Matriks', 0.50, 0.30, 0.15, 0.00, NULL),
(93, 'Daftar Jumlah Informasi Publik Tersedia Setiap Saat Tahun 2023 - 2024 (baik Digital dan non-Digital) sesuai PermenKP No.42 Tahun 2023. Minimal 20 Dokumen.', 3, 7, 7, 15, 1, 'upload link G.Drive (Daftar-nya dan Dokumen-nya). Ketersediaan jumlah dokumen makin besar jumlahnya makin tinggi nilainya', 1.00, 0.75, 0.50, 0.25, 0.00),
(94, 'Tambahan > 1-5 Dokumen Jumlah Informasi Publik Tersedia Setiap Saat (baik Digital dan non-Digital).', 3, 7, 7, 15, 0.5, 'Upload link dan soft copy dalam gdrive', 0.50, 0.30, 0.15, 0.00, NULL),
(95, 'Tambahan > 5 Dokumen Jumlah Informasi Publik Tersedia Setiap Saat (baik Digital dan non-Digital).', 3, 7, 7, 15, 0.5, 'Upload link dan soft copy dalam gdrive', 0.50, 0.30, 0.15, 0.00, NULL),
(96, 'Informasi Wajib Berkala yang diperbaharui minimal 6 bulan sekali sesuai PermenKP No.42 Tahun 2023, meliputi: <br> a. Informasi tentang profil Kementerian; <br> b. ringkasan Informasi tentang program dan kegiatan sedang dijalankan;  <br> c. ringkasan Informasi tentang kinerja capaian dalam lingkup Unit organisasinya; <br> d. ringkasan laporan keuangan telah diaudit; <br> e. ringkasan laporan akses Informasi Publik; <br> f. Informasi tentang peraturan, keputusan, kebijakan; <br> g. Informasi tentang prosedur memperoleh Informasi Publik; <br> h. Informasi tentang tata cara pengaduan penyalahgunaan wewenang atau pelanggaran yang dilakukan pejabat jajaran di organisasi; <br> i. Informasi tentang pengadaan barang dan jasa sesuai dengan ketentuan peraturan perundangundangan; <br> j. Informasi tentang kepegawaian; dan <br> k. Informasi tentang prosedur peringatan dini dan prosedur evakuasi keadaan darurat di lingkungan unit organisasinya.', 4, 8, 8, 16, 2, 'upload link website KKP yang menyajikan informasi tersedia setiap saat (digital)  lengkap sesuai PermenKP No.42 Tahun 2023 tentang PLIP. ', 2.00, 1.50, 1.00, 0.50, 0.00),
(97, 'Informasi Tersedia Setiap Saat sesuai PermenKP No.42 Tahun 2023, meliputi: <br> a. Daftar Informasi Publik; <br> b. Informasi tentang peraturan, keputusan, dan kebijakan Unit organisasinya; <br> c. Informasi tentang organisasi, administrasi, kepegawaian, dan keuangan; <br> d. surat perjanjian dengan pihak ketiga berikut dokumen pendukungnya; <br> e. surat menyurat pimpinan atau pejabat Kementerian dalam rangka pelaksanaan tugas, fungsi, dan wewenangnya; <br> f. persyaratan perizinan, perizinan yang diterbitkan oleh unit organisasinya; <br> g. data perbendaharaan atau inventaris; <br> h. rencana strategis dan rencana kerja unit organisasinya; <br> i. agenda kerja pimpinan satuan kerja; <br> j. Informasi mengenai kegiatan pelayanan Informasi Publik; <br> k. jumlah, jenis, dan gambaran umum pelanggaran; yang ditemukan dalam pengawasan internal serta laporan penindakannya; <br> l. jumlah, jenis, dan gambaran umum pelanggaran yang dilaporkan oleh masyarakat serta laporan penindakannya; <br> m. peraturan perundang-undangan yang telah disahkan beserta kajian akademik; <br> n. Informasi dan kebijakan yang disampaikan pejabat unit organisasinya dalam pertemuan yang terbuka untuk umum; <br> o. Informasi Publik lain yang telah dinyatakan terbuka bagi masyarakat berdasarkan masa berlaku atau uji konsekuensi;<br> p. Informasi tentang standar layanan Informasi.', 4, 8, 8, 16, 2, 'upload link website KKP yang menyajikan informasi tersedia setiap saat (digital)  lengkap sesuai PermenKP No.42 Tahun 2023 tentang PLIP. ', 2.00, 1.50, 1.00, 0.50, 0.00),
(98, '   	 Informasi Serta Merta, sesuai PermenKP No.42 Tahun 2023, meliputi: <br> a. Informasi bencana alam; <br> b. Informasi jenis ikan invasif yang mengancam keberadaan ikan lokal; <br> c. Informasi daerah wabah penyakit ikan. <br> d. (ditambahkan)', 4, 8, 8, 16, 2, 'upload link website yang menyajikan informasi tersedia setiap saat (digital)  lengkap sesuai PermenKP No.42 Tahun 2023 tentang PLIP. ', 2.00, 1.50, 1.00, 0.50, 0.00),
(99, 'Daftar Informasi Dikecualikan', 4, 8, 8, 16, 2, 'upload link website KKP yang menyajikan informasi wajib (digital) berkala lengkap sesuai Perki 1/2021 tentang SLIP. Ketidaklengkapan mengurangi nilai', 2.00, 1.50, 1.00, 0.50, 0.00),
(100, 'Daftar Informasi Publik online', 4, 8, 8, 16, 2, 'upload link website KKP  yang menyajikan informasi wajib (digital) berkala lengkap sesuai Perki 1/2021 tentang SLIP. Ketidaklengkapan mengurangi nilai', 2.00, 1.50, 1.00, 0.50, 0.00),
(101, 'Permintaan informasi online (bukan mengunduh formulir permohonan)', 4, 8, 8, 16, 1, 'upload link website permohonan secara digital  (ppid.kkp.go.id), tangkapan layar aplikasinya dan dibuatkan surat pernyataan di tanda tangan oleh atasan ppid (apabila tidak ada permohonan)', 1.00, 0.75, 0.50, 0.25, 0.00),
(102, 'Pengajuan keberatan online (bukan mengunduh formulir pengajuan keberatan)', 4, 8, 8, 16, 1, 'upload link website permohonan secara digital  (ppid.kkp.go.id), tangkapan layar aplikasinya dan dibuatkan surat pernyataan di tanda tangan oleh atasan ppid (apabila tidak ada permohonan)', 1.00, 0.75, 0.50, 0.25, 0.00),
(103, 'Menyediakan audio visual yang menayangkan layanan informasi publik/papan informasi elektronik/lainnya', 4, 8, 8, 16, 1, 'upload link website, tangkapan layar di upload di link G-Drive (youtube, instagram, kanal lain) Tv di ruang layanan menyampaikan terkait ppid )', 1.00, 0.75, 0.50, 0.25, 0.00),
(104, 'Ruang Layanan Informasi/PPID ', 4, 9, 9, 17, 4, 'Link G-Drive (Video Ruang layanan informasi/PPID dimulai dari Tampak depan sampai ruang layanan)', 4.00, 3.00, 2.00, 1.00, 0.00),
(105, 'Formulir Permintaan Informasi dan pengajuan keberatan informasi', 4, 9, 9, 17, 1, 'Link G-Drive (Foto Formulir permohonan dan keberatan)', 1.00, 0.75, 0.50, 0.25, 0.00),
(106, 'Sarana Pendukung Lainnya', 4, 9, 9, 17, 1, 'Link G-Drive (foto Standing Banner, komputer dan lainnya)', 1.00, 0.75, 0.50, 0.25, 0.00),
(107, 'Maklumat Pelayanan', 4, 9, 9, 17, 1, 'Link G.Dive (Foto Posisi Maklumat)', 1.00, 0.75, 0.50, 0.25, 0.00),
(108, 'Survey Kepuasaan ', 4, 9, 9, 17, 1, 'Link G.Dive (Dokumen SKM dan Hasil SKM dipublikasi di medsos, diruang ppid, website, apabila tidak ada survey dibuatkan surat pernyataan yang ditandatangan atasan PPID)', 1.00, 0.75, 0.50, 0.25, 0.00),
(109, 'SOP layanan Keterbukaan Informasi Publik pada PPID Pelaksana Pusat, maupun di PPID Pelaksana UPT (meliputi: <br> 1. SOP Permintaan IP Online/Offline; <br> 2. SOP Pendokumentasian informasi publik; <br> 3. SOP Pengajuan Keberatan; <br> 4. SOP Pengujian Konsekuensi; <br> 5. SOP Penetapan dan Pemutakhiran Informasi Publik.', 4, 9, 9, 17, 2, 'Link G-Drive SOP (Non Elektronik) (dipajang kemudian difoto)', 2.00, 1.50, 1.00, 0.50, 0.00),
(110, 'Petugas Layanan Informasi Publik', 4, 9, 9, 17, 2, 'Link G.Dive (Video Petugas saat melayani dan Surat Tugas) ', 2.00, 1.50, 1.00, 0.50, 0.00),
(111, 'Aksesibilitas Tuna Wicara', 4, 9, 10, 18, 2, 'Link G-Drive (video fasilitas-nya)', 2.00, 1.50, 1.00, 0.50, 0.00),
(112, 'Aksesibilitas Tuna Rungu', 4, 9, 10, 18, 2, 'Link G-Drive (video fasilitas-nya)', 2.00, 1.50, 1.00, 0.50, 0.00),
(113, 'Aksesibilitas Tuna Lainnya', 4, 9, 10, 18, 1, 'Link G-Drive (video fasilitas-nya)', 1.00, 0.75, 0.50, 0.25, 0.00),
(114, 'Sesuai PermenKP No.42 Tahun 2023:  Menyediakan dan mengumumkan informasi profil PPID yang meliputi: <br> A.Informasi domisili/alamat lengkap, ruang lingkup kegiatan, maksud dan tujuan, tugas dan fungsi; <br> B. Sumber Anggaran; <br> C. Struktur kelembagaan dan profil singkat pejabat; <br> D. LHKPN yang diverifikasi.', 5, 10, 11, 19, 3, 'Link website sesuai materi yang ditanyakan (Profil, Struktur Kelembagaan, visi Misi, SK Petugas PPID, Maklumat). Ketidaklengkapan menghilangkan nilai Keseluruhan nomor ini.', 3.00, 2.00, 1.00, 0.00, NULL),
(115, 'Menyediakan dan mengumumkan standar pelayanan informasi publik yang terdiri dari:<b>*Ketidaklengkapan akan menghilangkan nilai nomor ini.</b>', 5, 10, 11, 19, NULL, '', NULL, NULL, NULL, NULL, NULL),
(116, 'a. SOP Permintaan Informasi Publik Online/Offline', 5, 10, 11, 19, 1, 'Link website/ Link soft file dalam gdrive', 1.00, 0.75, 0.50, 0.25, 0.00),
(117, 'b. SOP Pengajuan Keberatan', 5, 10, 11, 19, 1, 'Link website/ Link soft file dalam gdrive', 1.00, 0.75, 0.50, 0.25, 0.00),
(118, 'c. SOP Uji Konsekuensi (Daftar Informasi Dikecualikan-DIK)', 5, 10, 11, 19, 1, 'Link website/ Link soft file dalam gdrive', 1.00, 0.75, 0.50, 0.25, 0.00),
(119, 'd. SOP Penetapan dan pemutakhiran Daftar Informasi Publik (DIP)', 5, 10, 11, 19, 1, 'Link website/ Link soft file dalam gdrive', 1.00, 0.75, 0.50, 0.25, 0.00),
(120, 'e. SOP Pendokumentasian informasi publik', 5, 10, 11, 19, 1, 'Link website/ Link soft file dalam gdrive', 1.00, 0.75, 0.50, 0.25, 0.00),
(121, 'Menetapkan kebijakan pembinaan pelayanan informasi publik', 5, 10, 12, 20, 2, 'link G-Drive (dokumen kerja resmi kebijakan pembinaan yang dikeluarkan oleh Pejabat PPID)SK/ Surat Tugas /dan perjanjian kinerja', 2.00, 1.50, 1.00, 0.50, 0.00),
(122, 'Menetapkan penandatanagan komitmen bersama dengan jajaran PPID Pelaksana UPT bagi PPID Pelaksana Pusat, dan Penandatanganan Komitmen Bersama Internal bagi PPID Pelaksana UPT. ', 5, 10, 12, 20, 2, 'Link G-Drive Dokumen Komitmen Bersama. ', 2.00, 1.50, 1.00, 0.50, 0.00),
(123, 'Melakukan Peningkatan kapasitas Petugas layanan Informasi Publik di Unit Organisasi PPID Pelaksana Pusat maupun UPT', 5, 10, 12, 20, 2, 'Link G-Drive Dokumen peningkatan kapasitas. (Bukti sertifikat keikutsertaan 2023 sampai 2024 terkait layanan informasi (misal Pelatihan, bimtek, seminar)', 2.00, 1.50, 1.00, 0.50, 0.00),
(124, 'Melakukan evaluasi dan monitoring atas pelaksanaan pembinaan kebijakan Informasi Publik yang dilakukan oleh PPID Pelaksana (Pusat di Internal Es I nya) ', 5, 10, 12, 20, 2, 'Link G-Drive Surat menyurat dari Atasan PPID yang memuat materi pembinaan/pengawasan /evaluasi/ monitoring kebijakan. (Komitmen pimpinan dapat di tunjukan pada kehadiran di kegiatan (Foto)', 2.00, 1.50, 1.00, 0.50, 0.00),
(125, 'Menyediakan anggaran rutin kegiatan Layanan keterbukaan informasi', 5, 10, 13, 21, 2, 'Menunjukan dokumen anggaran dengan nomenklatur kegiatannya (upload link)', 2.00, 1.50, 1.00, 0.50, 0.00),
(126, 'Menyediakan anggaran bagi peningkatan kapasitas SDM pengelola PPID', 5, 10, 13, 21, 2, 'Menunjukan dokumen anggaran dengan nomenklatur kegiatannya (upload link)', 2.00, 1.50, 1.00, 0.50, 0.00),
(127, 'Mengumumkan Informasi berkaitan ruang lingkup, tugas dan fungsi Unit organisasi Eselon I bagi PPID Pelaksana Pusat, dan Ruang lingkup, tugas dan fungsi internal UPT bagi PPID Pelaksana UPT.', 6, 11, 14, 22, 2, 'Link MEDSOS Unit organisasi PPID Pelaksana Pusat atau UPT dan disertai Capture/SS', 2.00, 1.50, 1.00, 0.50, 0.00),
(128, 'Mengumumkan Informasi program dan kegiatan 2024 Unit organisasi  Eselon I dalam Medsos PPID Pelaksana Pusat dan  UPT', 6, 11, 14, 22, 2, 'Link MEDSOS Unit organisasi PPID Pelaksana Pusat atau UPT dan disertai Capture/SS', 2.00, 1.50, 1.00, 0.50, 0.00),
(129, 'Mengumumkan informasi DIPA atau RKA K/L Tahun Anggaran 2024', 6, 11, 14, 22, 1, 'Link MEDSOS Unit organisasi PPID Pelaksana Pusat atau UPT dan disertai Capture/SS', 1.00, 0.75, 0.50, 0.25, 0.00),
(130, 'Mengumumkan alur Permintaan Informasi Publik sesuai mekanisme di PPID Pelaksana Pusat maupun UPT.', 6, 11, 14, 22, 1, 'Link MEDSOS Unit organisasi PPID Pelaksana Pusat atau UPT dan disertai Capture/SS', 1.00, 0.75, 0.50, 0.25, 0.00),
(131, 'Mengumumkan Informasi berkaitan  alasan yang dapat digunakan Pemohon Informasi mengajukan keberatan (Sesuai PermenKP No.42 Tahun 2023). Tidak lengkap menghilangkan nilai nomor ini.', 6, 11, 14, 22, 1, 'Link MEDSOS Unit organisasi PPID Pelaksana Pusat atau UPT dan disertai Capture/SS', 1.00, 0.75, 0.50, 0.25, 0.00),
(132, 'Pemanfatan aplikasi atau replikasi Inovasi (digital atau non-digital) untuk mewujudkan transparansi dan akuntabilitas di lingkungan Unit Organisasi PPID Pelaksana Pusat maupun UPT', 6, 12, 15, 23, 3, 'link G-Drive (Nama aplikasi dan Ringkasan penjelasan tentang latarbelakang, kegunaan, manfaat, hasil sebelum dan sesudah ada Aplikasi). Sertakan juga link aplikasinya. (non digital : Kampanye, edukasi, program agent perubahan (dokumen dokumen yang terintegrasi )', 3.00, 2.00, 1.00, 0.00, NULL);

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
(12, 344, '1122334455', 'anggiet'),
(13, 345, '2334355522', 'oci');

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
(5, 'DAFTAR INFORMASI PUBLIK', 1),
(6, 'INFORMASI DIKECUALIKAN', 1),
(7, 'INFORMASI TERSEDIA SETIAP SAAT & PENGADAAN BARANG DAN JASA', 3),
(8, 'ELEKTRONIK', 4),
(9, 'NON ELEKTRONIK', 4),
(10, 'PROFIL KELEMBAGAAN PPID', 5),
(11, 'MEDIA SOSIAL', 6),
(12, 'PEMANFAATAN TEKNOLOGI INFORMASI', 6),
(23, 'ini aja', 37),
(24, 'disini', 38);

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
(5, 'INFORMASI TERKAIT DAFTAR INFORMASI PUBLIK SESUAI FUNGSI UTAMA UNIT ORGANISASI ESELON 1 DAN UPT', 5),
(6, 'INFORMASI DIKECUALIKAN  SESUAI FUNGSI UTAMA UNIT ORGANISASI ESELON 1/UPT', 6),
(7, 'Menyediakan Dokumen (digital dan atau hardcopy) Informasi Tersedia Setiap Saat', 7),
(8, 'Menu PPID terintegrasi dengan website utama menyediakan informasi: ', 8),
(9, 'Meja Layanan Informasi', 9),
(10, 'Aksesibilitas bagi Penyandang Disabilitas', 9),
(11, 'Legalitas PPID Pelaksanan (Pusat/UPT)', 10),
(12, 'Kepemimpinan', 10),
(13, 'Dukungan Anggaran', 10),
(14, 'Penyampaian informasi publik melalui media sosial (facebook, instagram, twitter)', 11),
(15, 'Pengembangan Layanan Publik', 12);

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
(5, 'Pengadaan Barang dan Jasa (Melalui Tender atau Penunjukan Langsung)', 1, ''),
(11, 'Informasi Terkait Daftar Informasi Publik Sesuai Fungsi Utama Unit Organisasi Eselon 1 Dan UPT', 5, ''),
(12, 'Informasi Dikecualikan Sesuai Fungsi Utama Unit Organisasi Eselon 1/UPT', 6, ''),
(13, 'Menyediakan Dokumen informasi yang wajib disediakan dan atau diumumkan  Tahun 2024  program dan kegiatan  meliputi:', 7, ''),
(14, 'Menyediakam dokumen Surat-surat perjanjian dengan pihak ketiga berikut dokumen pendukungnya; ', 7, ''),
(15, 'Mengumumkan Data laporan akses Informasi Publik Tahun 2023 (Semester I dan II) dan 2024 (Semester I)  <b>*Buatlah dalam bentuk matriks dan grafik</b>', 7, ''),
(16, 'Menu PPID terintegrasi dengan website utama menyediakan informasi: ', 8, ''),
(17, 'Meja Layanan Informasi', 9, ''),
(18, 'Aksesibilitas bagi Penyandang Disabilitas', 10, ''),
(19, 'Legalitas PPID Pelaksanan (Pusat/UPT)', 11, ''),
(20, 'Kepemimpinan', 12, ''),
(21, 'Dukungan Anggaran', 13, ''),
(22, 'Penyampaian informasi publik melalui media sosial (facebook, instagram, twitter)', 14, ''),
(23, 'Pengembangan Layanan Publik', 15, '');

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
  MODIFY `id_akun` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=353;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kuesioner`
--
ALTER TABLE `kuesioner`
  MODIFY `id_kuesioner` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT untuk tabel `organisasi`
--
ALTER TABLE `organisasi`
  MODIFY `id_organisasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `penilai_user_access`
--
ALTER TABLE `penilai_user_access`
  MODIFY `access_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pertanyaan`
--
ALTER TABLE `pertanyaan`
  MODIFY `id_pertanyaan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT untuk tabel `profile_penilai`
--
ALTER TABLE `profile_penilai`
  MODIFY `id_penilai` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `subkategori1`
--
ALTER TABLE `subkategori1`
  MODIFY `id_subkategori1` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `subkategori2`
--
ALTER TABLE `subkategori2`
  MODIFY `id_subkategori2` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `subkategori3`
--
ALTER TABLE `subkategori3`
  MODIFY `id_subkategori3` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

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
