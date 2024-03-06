-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Mar 2024 pada 13.07
-- Versi server: 10.4.18-MariaDB
-- Versi PHP: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_arsip_2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `admin_nama` varchar(255) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`admin_id`, `admin_nama`, `admin_username`, `admin_password`, `admin_foto`) VALUES
(1, 'Administrator', 'admin', '$2y$10$Y8Y.g8b2XhtwEt1tGwtu9OV6ziMqovjxeLXWT3tiV47oUuvse0xei', '783783061_IMG_20230819_205841.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `arsip`
--

CREATE TABLE `arsip` (
  `arsip_id` int(11) NOT NULL,
  `arsip_waktu_upload` datetime NOT NULL,
  `arsip_petugas` int(11) NOT NULL,
  `arsip_kamar` int(11) NOT NULL,
  `arsip_nama` varchar(255) NOT NULL,
  `arsip_jenis` varchar(255) NOT NULL,
  `arsip_kategori` int(11) NOT NULL,
  `arsip_keterangan` text NOT NULL,
  `arsip_file` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `arsip`
--

INSERT INTO `arsip` (`arsip_id`, `arsip_waktu_upload`, `arsip_petugas`, `arsip_kamar`, `arsip_nama`, `arsip_jenis`, `arsip_kategori`, `arsip_keterangan`, `arsip_file`) VALUES
(14, '2024-01-21 21:01:04', 7, 2, 'Sosialisasi', 'png', 5, 'Sosialisasi untuk Balita', '961834595_line.png'),
(15, '2024-02-27 08:30:04', 13, 1, 'buku tulis', 'pdf', 1, 'buku dalam buku', '20235_Data_Analytics Client Brief.pdf');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bulan`
--

CREATE TABLE `bulan` (
  `bulan_id` int(11) NOT NULL,
  `bulan_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `bulan`
--

INSERT INTO `bulan` (`bulan_id`, `bulan_nama`) VALUES
(1, 'Januari'),
(2, 'Februari'),
(3, 'Maret'),
(4, 'April'),
(5, 'Mei'),
(6, 'Juni'),
(7, 'Juli'),
(8, 'Agustus'),
(9, 'September'),
(10, 'Oktober'),
(11, 'November'),
(12, 'Desember');

-- --------------------------------------------------------

--
-- Struktur dari tabel `indikator_spm`
--

CREATE TABLE `indikator_spm` (
  `indikator_id` int(11) NOT NULL,
  `indikator_nama` varchar(255) NOT NULL,
  `persentase_fix` float NOT NULL,
  `jpelayanan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `indikator_spm`
--

INSERT INTO `indikator_spm` (`indikator_id`, `indikator_nama`, `persentase_fix`, `jpelayanan_id`) VALUES
(1, 'Kunjungan Ibu Hamil K1', 100, 1),
(2, 'Kunjungan Ibu Hamil K4', 100, 1),
(3, 'Ibu Hamil dengan Imunisasi TT2+', 100, 1),
(4, 'Ibu Hamil mendapat Fe3', 100, 1),
(5, 'Ibu Hamil dengan komplikasi yang ditangani', 100, 1),
(6, 'Persalinan ditolong oleh Tenaga Kesehatan', 100, 2),
(7, 'Persalinan di Fasilitas Kesehatan', 100, 2),
(8, 'Jumlah kematian ibu melahirkan', 100, 2),
(9, 'Pertolongan persalinan oleh bidan atau tenaga kesehatan yang memiliki kompetensi kebidanan', 100, 2),
(10, 'Pelayanan Ibu Nifas', 100, 2),
(11, 'Ibu Nifas mendapat Vitamin A', 100, 2),
(12, 'Bayi baru lahir', 100, 3),
(13, 'Bayi baru lahir ditimbang', 100, 3),
(14, 'Berat Badan Bayi lahir rendah (BBLR)', 100, 3),
(15, 'Bayi baru lahir yang mendapat inisiasi menyusui dini (IMD)', 100, 3),
(16, 'Bayi yang diberi ASI Ekskklusif', 100, 3),
(17, 'Bayi mendapat Vitamin A', 100, 3),
(18, 'Balita mendapat Vitamin A', 100, 4),
(19, 'Balita ditimbang (D/S)', 100, 4),
(20, 'Balita berat badan dibawah garis merah (BGM)', 100, 4),
(21, 'Balita Naik BB (N/D)', 100, 4),
(22, 'Balita gizi buruk mendapat perawatan', 100, 4),
(23, 'Pemberian makanan pendamping ASI pada anak usia 6-24 bulan keluarga miskin', 100, 4),
(24, 'Penjaringan kesehatan siswa SD setingkat', 100, 5),
(25, 'SD/MI yang melakukan sikat gigi  masal', 100, 5),
(26, 'SD/MI yang mendapat  pelayanan gigi\r\n', 100, 5),
(27, 'Murid SD/MI di periksa (UKGS)', 100, 5),
(28, 'Murid SD/MI mendapat perawatan UKGS', 100, 5),
(29, 'Jumlah peserta KB aktif', 100, 6),
(30, 'Jumlah wanita yang melakukan pemeriksaan leher rahim dan payudara', 100, 6),
(31, 'IVA Positif', 100, 6),
(32, 'Pelayanan kesehatan lansia (60 tahun)', 100, 7),
(33, 'Lansia yang mendapatkan skrining kesehatan sesuai standar', 100, 7),
(34, 'Jumlah penduduk yang dilakukan pengukuran Tekanan darah (L/P)', 100, 8),
(35, 'Jumlah penduduk yang hipertensi/darah tinggi mendapat pelayanan', 100, 8),
(36, 'Penemuan Kasus Baru', 100, 9),
(37, 'Jumlah penduduk yang menderita diabetes melitus', 100, 9),
(38, 'Penemuan Kasus Baru', 100, 10),
(39, 'Penanganan Kasus', 100, 10),
(40, 'Jumlah ODGJ berat (psikotil) yang mendapat pelayanan keswa promotif preventif sesuai standar', 100, 10),
(41, 'Penemuan pasien baru TB BTA Positif', 100, 11),
(42, 'Jumlah pasien TB (semua tipe) yang dilaporkan', 100, 11),
(43, 'Jumlah pasien baru TB BTA positif sembuh dan pengobatan lengkap', 100, 11),
(44, 'Jumlah pasien TB Paru BTA Positif diobati', 100, 11),
(45, 'Jumlah kasus baru TB BTA+', 100, 11),
(46, 'Jumlah seluruh kasus TB', 100, 11),
(47, 'Proporsi  Kasus Baru TB BTA+', 100, 11),
(48, 'Penemuan Kasus AIDS', 100, 12),
(49, 'Penemuan Kasus Ibu Hamil (HIV)', 100, 12),
(50, 'Jumlah ODHA ibu hamil yang dan memenuhi syarat pengobatan ARV', 100, 12),
(51, 'Jumlah ODHA Bumil patuh minum ARV selama satu tahun', 100, 12),
(52, 'Jumlah kematian karena AIDS', 100, 12),
(53, 'Jumlah orang beresiko terinfeksi HIV yang mendapat pengobatan HIV sesuai standar fasyankes dalam kurun waktu 1 tahun', 100, 12);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_pelayanan`
--

CREATE TABLE `jenis_pelayanan` (
  `jpelayanan_id` int(11) NOT NULL,
  `jpelayanan_nama` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `jenis_pelayanan`
--

INSERT INTO `jenis_pelayanan` (`jpelayanan_id`, `jpelayanan_nama`) VALUES
(1, 'Pelayanan Kesehatan Ibu Hamil'),
(2, 'Pelayanan Kesehatan Ibu Bersalin'),
(3, 'Pelayanan Kesehatan Bayi Baru Lahir'),
(4, 'Pelayanan Kesehatan Balita'),
(5, 'Pelayanan Kesehatan pada Usia Pendidikan Dasar'),
(6, 'Pelayanan Kesehatan pada Usia Produktif'),
(7, 'Pelayanan Kesehatan pada Usia Lanjut'),
(8, 'Pelayanan Kesehatan Penderita Hipertensi'),
(9, 'Pelayanan Kesehatan Penderita Diabetes Melitus'),
(10, 'Pelayanan Kesehatan Orang Dengan Gangguan Jiwa Berat'),
(11, 'Pelayanan Kesehatan orang dengan Tuberkulosis (TB)'),
(12, 'Pelayanan Kesehatan orang dengan Risiko Terinfeksi HIV');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kamar`
--

CREATE TABLE `kamar` (
  `kamar_id` int(11) NOT NULL,
  `kamar_nama` varchar(255) NOT NULL,
  `kamar_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kamar`
--

INSERT INTO `kamar` (`kamar_id`, `kamar_nama`, `kamar_url`) VALUES
(1, 'KIA & KB', 'kiakb'),
(2, 'Gizi', 'gizi'),
(3, 'Promkes', 'promkes'),
(4, 'Kesehatan Lingkungan', 'kesling'),
(5, 'Penyakit Menular', 'penyakitmenular'),
(6, 'Penyakit Tidak Menular', 'penyakittidakmenular'),
(7, 'Imunisasi', 'imunisasi'),
(8, 'Surveilance', 'surveilance'),
(9, 'Kesehatan Tradisional', 'kestra'),
(10, 'Kesehatan Olahraga', 'kesol'),
(11, 'Kesehatan Kerja', 'kesker'),
(12, 'Kesehatan Lansia', 'keslan'),
(13, 'Upaya Kesehatan Sekolah', 'uks'),
(14, 'Kesehatan Gigi', 'gigi'),
(15, 'UKP', 'ukp'),
(16, 'Perkesmas', 'perkesmas'),
(17, 'Kefarmasian', 'kefarmasian'),
(18, 'Laboratorium', 'laboratorium'),
(19, 'Manajemen', 'manajemen'),
(20, 'Keuangan', 'keuangan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int(11) NOT NULL,
  `kategori_nama` varchar(255) NOT NULL,
  `kamar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_nama`, `kamar_id`) VALUES
(1, 'PWS', 1),
(2, 'MTBS', 2),
(3, 'SDIDTK', 2),
(4, 'MTBM', 2),
(5, 'Kesehatan Balita', 2),
(6, 'KIA', 3),
(7, 'KB', 3),
(8, 'Kepatuhan Cuci Tangan', 4),
(9, 'Skrining Anemia', 5),
(10, 'TTD', 5),
(11, 'Laporan Gizkia', 5),
(12, 'LPLPO (LB2)', 6),
(13, 'Narkotik/Psikotropik', 6),
(14, 'Ketersediaan Obat', 6),
(15, 'Persediaan Farmasi', 6),
(16, 'Laporan Penggunaan Rasional/POR', 6),
(17, 'LB1', 7),
(18, 'LB4', 7),
(19, 'UKGS', 8),
(20, 'UKGM', 8),
(21, 'POLI GIGI', 8),
(22, 'PENJARINGAN', 8),
(23, 'RUJUKAN', 8),
(24, 'DIAGNOSA BARU', 8),
(25, 'Laporan Keuangan', 9),
(26, 'UKBM\r\n', 10),
(27, 'PHBS TATANAN RUMAH TANGGA\r\n', 10),
(28, 'PHBS TATANAN FASYANKES\r\n', 10),
(29, 'PHBS TATANAN TEMPAT UMUM\r\n', 10),
(30, 'PHBS TATANAN SEKOLAH\r\n', 10),
(31, 'PHBS TATANAN PERKANTORAN\r\n', 10),
(32, 'LAPORAN BULANAN PROMKES\r\n', 10),
(33, 'KAWASAN TANPA ROKOK\r\n', 10),
(37, 'test2', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `petugas_id` int(11) NOT NULL,
  `petugas_nama` varchar(255) NOT NULL,
  `petugas_username` varchar(255) NOT NULL,
  `petugas_password` varchar(255) NOT NULL,
  `petugas_foto` varchar(255) NOT NULL,
  `kamar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`petugas_id`, `petugas_nama`, `petugas_username`, `petugas_password`, `petugas_foto`, `kamar_id`) VALUES
(7, 'Nano', 'nano', '$2y$10$06IQ2IbqFtdHr9ijkf9hr.xycl8S.cvAbMBG/cOed9pJC5m7oObWq', '1787265699_edward-cisneros-_H6wpor9mjs-unsplash.jpg', 2),
(9, 'Kia KB', 'kiakb', '$2y$10$oktnDxMYpn663WJHrJiIFOmfCVXqK6GPT0IUTJyQO4NVWgXBaY/uK', '', 1),
(10, 'Petugas Imunisasi', 'petugasimun', '$2y$10$TnkkkmlNeRx06KEeQ0gLTOEF0clFVaduG4CSfuJGkhi9jeNnvEo/.', '', 1),
(12, 'Lala', 'petugas', '$2y$10$0i7dIR4O67meix828KqDN.96bxX9ry8A5xBPInh2Iz.kUjyLByIjW', '', 1),
(13, 'imunisasi', 'imunisasi', '$2y$10$.yhRfiNAlH7EmebiagcbgeDSNIDM37T6U5lFTkd3Up5bq.Pl0bZBu', '', 7),
(14, 'kiakb', 'kiakb', '$2y$10$HSG3EJnJ6p.akO7sJXupseJU7hIECiEuzAhMRsth4KTq2Ei/qbi7.', '', 3),
(15, 'promkes', 'promkes', '$2y$10$okfUXmTqZQ6EmtQ7LldaB.3MfY8PNEr2SxDQQcw7mRzg/cJygcf/C', '', 10),
(16, 'gigi', 'gigi', '$2y$10$iyvQvPN4ZbWEqZZtVfqqIO4d2cNvLqPqnpXplOCYXnrouYd.jbUKW', '', 16),
(17, 'kia&kb', 'kia&kb', '$2y$10$8FDvVIy0vR43svGMJ6uSD.Y./bQkSkQqaAgZHsk.jV8.FDdK2LuEG', '', 1),
(18, 'Andi', 'petugas_andi', '$2y$10$p8p/8d0p4HlBgI0BGuQFburCl9ahrM12RLobELqlPAQRvE7HGLf1.', '', 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `program`
--

CREATE TABLE `program` (
  `program_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat`
--

CREATE TABLE `riwayat` (
  `riwayat_id` int(11) NOT NULL,
  `riwayat_waktu` datetime NOT NULL,
  `riwayat_user` int(11) NOT NULL,
  `riwayat_arsip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `riwayat`
--

INSERT INTO `riwayat` (`riwayat_id`, `riwayat_waktu`, `riwayat_user`, `riwayat_arsip`) VALUES
(12, '2024-01-26 23:25:47', 22, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `spm`
--

CREATE TABLE `spm` (
  `spm_id` int(11) NOT NULL,
  `tahun_id` int(11) NOT NULL,
  `bulan_id` int(11) NOT NULL,
  `absolut_tahunan` int(191) NOT NULL,
  `absolut_bulanan` int(191) NOT NULL,
  `persentase` float NOT NULL,
  `indikator_id` int(11) NOT NULL,
  `jpelayanan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `spm`
--

INSERT INTO `spm` (`spm_id`, `tahun_id`, `bulan_id`, `absolut_tahunan`, `absolut_bulanan`, `persentase`, `indikator_id`, `jpelayanan_id`) VALUES
(1, 1, 1, 251, 19, 7.6, 1, 1),
(2, 1, 1, 251, 20, 8, 2, 1),
(3, 1, 1, 251, 16, 6.4, 3, 1),
(4, 1, 2, 251, 10, 8, 1, 1),
(6, 1, 1, 251, 2, 0.8, 5, 1),
(7, 1, 1, 251, 20, 7.9, 4, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tahun`
--

CREATE TABLE `tahun` (
  `tahun_id` int(11) NOT NULL,
  `tahun_angka` int(191) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tahun`
--

INSERT INTO `tahun` (`tahun_id`, `tahun_angka`) VALUES
(1, 2024),
(2, 2025);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_nama` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `verify_token` varchar(191) NOT NULL,
  `verify_status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=no,1=yes',
  `user_foto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `user_nama`, `user_email`, `user_password`, `verify_token`, `verify_status`, `user_foto`) VALUES
(22, 'Nina', 'kimrsng@gmail.com', '$2y$10$atHmxKOx..2/x1ba.0P6z.g1tiqgh.yH7FKUpPfpzACl4NtC6uL0S', '24819f48b4fa37753811d2353e10340390d26e44e389e06764f56e1cf3d72681', 1, NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indeks untuk tabel `arsip`
--
ALTER TABLE `arsip`
  ADD PRIMARY KEY (`arsip_id`);

--
-- Indeks untuk tabel `bulan`
--
ALTER TABLE `bulan`
  ADD PRIMARY KEY (`bulan_id`);

--
-- Indeks untuk tabel `indikator_spm`
--
ALTER TABLE `indikator_spm`
  ADD PRIMARY KEY (`indikator_id`);

--
-- Indeks untuk tabel `jenis_pelayanan`
--
ALTER TABLE `jenis_pelayanan`
  ADD PRIMARY KEY (`jpelayanan_id`);

--
-- Indeks untuk tabel `kamar`
--
ALTER TABLE `kamar`
  ADD PRIMARY KEY (`kamar_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`),
  ADD KEY `kamar_id` (`kamar_id`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`petugas_id`),
  ADD KEY `kamar_id` (`kamar_id`);

--
-- Indeks untuk tabel `program`
--
ALTER TABLE `program`
  ADD PRIMARY KEY (`program_id`);

--
-- Indeks untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  ADD PRIMARY KEY (`riwayat_id`);

--
-- Indeks untuk tabel `spm`
--
ALTER TABLE `spm`
  ADD PRIMARY KEY (`spm_id`);

--
-- Indeks untuk tabel `tahun`
--
ALTER TABLE `tahun`
  ADD PRIMARY KEY (`tahun_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `arsip`
--
ALTER TABLE `arsip`
  MODIFY `arsip_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `bulan`
--
ALTER TABLE `bulan`
  MODIFY `bulan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `indikator_spm`
--
ALTER TABLE `indikator_spm`
  MODIFY `indikator_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `jenis_pelayanan`
--
ALTER TABLE `jenis_pelayanan`
  MODIFY `jpelayanan_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `kamar`
--
ALTER TABLE `kamar`
  MODIFY `kamar_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `petugas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `program`
--
ALTER TABLE `program`
  MODIFY `program_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `riwayat`
--
ALTER TABLE `riwayat`
  MODIFY `riwayat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `spm`
--
ALTER TABLE `spm`
  MODIFY `spm_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tahun`
--
ALTER TABLE `tahun`
  MODIFY `tahun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`kamar_id`) REFERENCES `kamar` (`kamar_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
