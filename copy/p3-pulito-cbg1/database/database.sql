-- --------------------------------------------------------
-- Host:                         localhost
-- Versi server:                 5.6.21 - MySQL Community Server (GPL)
-- OS Server:                    Win32
-- HeidiSQL Versi:               9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_akt_kas
DROP TABLE IF EXISTS `tbl_akt_kas`;
CREATE TABLE IF NOT EXISTS `tbl_akt_kas` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_jenis` int(11) NOT NULL,
  `tgl` datetime NOT NULL,
  `kode` varchar(160) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `nominal` decimal(32,2) NOT NULL,
  `debet` decimal(32,2) NOT NULL,
  `kredit` decimal(32,2) NOT NULL,
  `saldo` decimal(32,2) NOT NULL,
  `tipe` enum('keluar','masuk') NOT NULL,
  `jenis` enum('0','1','2','3') NOT NULL,
  `status_kas` enum('kas','bank') NOT NULL,
  `status_hps` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_akt_kas: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_akt_kas` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_akt_kas` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_akt_kas_jns
DROP TABLE IF EXISTS `tbl_akt_kas_jns`;
CREATE TABLE IF NOT EXISTS `tbl_akt_kas_jns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jenis` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_akt_kas_jns: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_akt_kas_jns` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_akt_kas_jns` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_akt_modal
DROP TABLE IF EXISTS `tbl_akt_modal`;
CREATE TABLE IF NOT EXISTS `tbl_akt_modal` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `tgl_simpan` date NOT NULL,
  `kode` varchar(160) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `nominal` decimal(32,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_akt_modal: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_akt_modal` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_akt_modal` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_ion_groups
DROP TABLE IF EXISTS `tbl_ion_groups`;
CREATE TABLE IF NOT EXISTS `tbl_ion_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_ion_groups: ~4 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_ion_groups` DISABLE KEYS */;
INSERT INTO `tbl_ion_groups` (`id`, `name`, `description`) VALUES
	(1, 'superadmin', 'Super Administrator'),
	(2, 'owner', 'Pemilik Perusahaan'),
	(3, 'admin', 'Administrator'),
	(7, 'kasir', 'Kasir');
/*!40000 ALTER TABLE `tbl_ion_groups` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_ion_login_attempts
DROP TABLE IF EXISTS `tbl_ion_login_attempts`;
CREATE TABLE IF NOT EXISTS `tbl_ion_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_ion_login_attempts: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_ion_login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_ion_login_attempts` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_ion_users
DROP TABLE IF EXISTS `tbl_ion_users`;
CREATE TABLE IF NOT EXISTS `tbl_ion_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_app` int(11) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_ion_users: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_ion_users` DISABLE KEYS */;
INSERT INTO `tbl_ion_users` (`id`, `id_app`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES
	(1, 7, '127.0.0.1', 'superadmin', '$2y$08$/tdmpTs4mo2b123/hi0fJ.SlmT8SuLANmLOLGK/BztmnJHdblt8uS', '', 'admin@admin.com', '', NULL, NULL, '4U1KusXUNEkJsE6w', 1268889823, 1534751643, 1, 'Tester Aplikator', NULL, 'ADMIN', '0'),
	(14, 7, '::1', 'kasir', '$2y$08$5Kp8PON0K19ZeqfLmhofwuFjdfBGf3FmCHO.MM0tLXNqjRKUkeuQe', 'gOlBiktJIDKPy.2/', 'admin@admin.com', NULL, NULL, NULL, '4S/r2hHvAEVbv8js', 1528129163, 1528593836, 1, 'Front Desk', NULL, NULL, NULL);
/*!40000 ALTER TABLE `tbl_ion_users` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_ion_users_groups
DROP TABLE IF EXISTS `tbl_ion_users_groups`;
CREATE TABLE IF NOT EXISTS `tbl_ion_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `tbl_ion_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `tbl_ion_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_ion_users_groups: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_ion_users_groups` DISABLE KEYS */;
INSERT INTO `tbl_ion_users_groups` (`id`, `user_id`, `group_id`) VALUES
	(1, 1, 1),
	(15, 14, 7);
/*!40000 ALTER TABLE `tbl_ion_users_groups` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_kategori
DROP TABLE IF EXISTS `tbl_m_kategori`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `status_temp` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_kategori: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_kategori` DISABLE KEYS */;
INSERT INTO `tbl_m_kategori` (`id`, `id_app`, `tgl_simpan`, `tgl_modif`, `kategori`, `keterangan`, `status_temp`) VALUES
	(4, 7, '2018-07-06 15:00:53', '0000-00-00 00:00:00', 'Pakaian', '-', '0'),
	(6, 7, '2018-07-06 15:17:50', '0000-00-00 00:00:00', 'Bed Cover', '-', '0');
/*!40000 ALTER TABLE `tbl_m_kategori` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_kategori2
DROP TABLE IF EXISTS `tbl_m_kategori2`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_kategori` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `harga` decimal(10,4) NOT NULL,
  `status_temp` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_kategori2_tbl_m_kategori` (`id_kategori`),
  CONSTRAINT `FK_tbl_m_kategori2_tbl_m_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `tbl_m_kategori` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_kategori2: ~3 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_kategori2` DISABLE KEYS */;
INSERT INTO `tbl_m_kategori2` (`id`, `id_app`, `id_kategori`, `tgl_simpan`, `tgl_modif`, `kategori`, `keterangan`, `harga`, `status_temp`) VALUES
	(4, 7, 4, '2018-07-06 15:01:11', '0000-00-00 00:00:00', 'Katun / Cotton', '-', 14500.0000, '0'),
	(5, 7, 4, '2018-07-06 15:26:09', '0000-00-00 00:00:00', 'Linen', '-', 15000.0000, '0'),
	(9, 7, 6, '2018-07-06 15:57:55', '0000-00-00 00:00:00', 'Sutra', '-', 25000.0000, '0');
/*!40000 ALTER TABLE `tbl_m_kategori2` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_kategori2_barang
DROP TABLE IF EXISTS `tbl_m_kategori2_barang`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori2_barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime NOT NULL,
  `id_kategori2` int(11) NOT NULL DEFAULT '0',
  `id_barang` int(11) DEFAULT NULL,
  `jml` int(11) DEFAULT NULL,
  `keterangan` text,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_kategori2_barang_tbl_m_kategori2` (`id_kategori2`),
  CONSTRAINT `FK_tbl_m_kategori2_barang_tbl_m_kategori2` FOREIGN KEY (`id_kategori2`) REFERENCES `tbl_m_kategori2` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_kategori2_barang: ~3 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_kategori2_barang` DISABLE KEYS */;
INSERT INTO `tbl_m_kategori2_barang` (`id`, `id_app`, `tgl_simpan`, `id_kategori2`, `id_barang`, `jml`, `keterangan`) VALUES
	(11, 1, '2018-08-20 14:45:35', 4, 1, 1, NULL),
	(12, 1, '2018-08-20 14:45:46', 5, 1, 1, NULL),
	(13, 1, '2018-08-20 14:45:55', 9, 1, 1, NULL);
/*!40000 ALTER TABLE `tbl_m_kategori2_barang` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_kategori3
DROP TABLE IF EXISTS `tbl_m_kategori3`;
CREATE TABLE IF NOT EXISTS `tbl_m_kategori3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL DEFAULT '0',
  `id_kategori2` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `harga` decimal(10,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_kategori3_tbl_m_kategori2` (`id_kategori2`),
  CONSTRAINT `FK_tbl_m_kategori3_tbl_m_kategori2` FOREIGN KEY (`id_kategori2`) REFERENCES `tbl_m_kategori2` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_kategori3: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_kategori3` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_kategori3` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_lokasi
DROP TABLE IF EXISTS `tbl_m_lokasi`;
CREATE TABLE IF NOT EXISTS `tbl_m_lokasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime DEFAULT NULL,
  `kode` varchar(64) DEFAULT NULL,
  `keterangan` text,
  `tipe` enum('1','2') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_lokasi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_lokasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_lokasi` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_pelanggan
DROP TABLE IF EXISTS `tbl_m_pelanggan`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_grup` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `kode` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `nik` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(360) COLLATE utf8_unicode_ci NOT NULL,
  `no_hp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lokasi` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `status_plgn` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_pelanggan: ~7 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_pelanggan` DISABLE KEYS */;
INSERT INTO `tbl_m_pelanggan` (`id`, `id_app`, `id_grup`, `tgl_simpan`, `kode`, `nik`, `nama`, `no_hp`, `lokasi`, `alamat`, `password`, `status_plgn`) VALUES
	(1, 7, 1, '0000-00-00 00:00:00', '00003', '', 'Umum', 'Umum', '', 'Umum', '', 0),
	(2, 7, 4, '2018-08-13 11:24:32', '00001', '3374071502920002', 'Mikhael Felian Waskito', '6285741220427', '', 'Jl. Mugas Dlm XI / 1', '', 0),
	(3, 7, 2, '0000-00-00 00:00:00', '00017', '453543543534535', 'Test', '6285741220427', '', 'Test', '', 0),
	(4, 7, 3, '0000-00-00 00:00:00', '00004', '12345678900987654321', 'Jono', '089774411992', '', 'Jl. Raya Wates', '', 0),
	(5, 7, 2, '0000-00-00 00:00:00', '00005', '112121212121212', 'Karsinogen', '03859304340', '', 'Jl. Raya', '', 0),
	(6, 7, 2, '0000-00-00 00:00:00', '00006', '123', 'Simon Petrus', '089774411992', '', 'Jl. Raya Sumarja', '', 0),
	(7, 1, 4, '0000-00-00 00:00:00', '00007', '90191919191919191919191', 'Sertu. Asmidi ketjuk', '085748392839', '', 'Asrama TNI, Mabes Cilangkap', '', 0);
/*!40000 ALTER TABLE `tbl_m_pelanggan` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_pelanggan_agt
DROP TABLE IF EXISTS `tbl_m_pelanggan_agt`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_agt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan_grup` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `potongan` decimal(13,2) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_pelanggan_agt: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_pelanggan_agt` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_pelanggan_agt` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_pelanggan_deposit
DROP TABLE IF EXISTS `tbl_m_pelanggan_deposit`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_deposit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_pelanggan` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `jml_deposit` decimal(32,4) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_pelanggan_deposit: ~12 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_pelanggan_deposit` DISABLE KEYS */;
INSERT INTO `tbl_m_pelanggan_deposit` (`id`, `id_app`, `id_pelanggan`, `tgl_simpan`, `tgl_modif`, `jml_deposit`, `keterangan`) VALUES
	(71, 7, 2, '2018-08-13 12:03:24', '2018-08-20 16:15:46', 278084.0000, ''),
	(72, 1, 7, '2018-08-19 07:09:45', '0000-00-00 00:00:00', 50000.0000, ''),
	(73, 7, 2, '2018-08-13 12:03:24', '2018-08-13 12:05:02', 332500.0000, ''),
	(74, 1, 7, '2018-08-19 07:09:45', '0000-00-00 00:00:00', 50000.0000, ''),
	(75, 7, 2, '2018-08-13 12:03:24', '2018-08-13 12:05:02', 332500.0000, ''),
	(76, 1, 7, '2018-08-19 07:09:45', '2018-08-20 16:08:57', 191250.0000, ''),
	(77, 7, 2, '2018-08-13 12:03:24', '2018-08-13 12:05:02', 332500.0000, ''),
	(78, 1, 7, '2018-08-19 07:09:45', '0000-00-00 00:00:00', 50000.0000, ''),
	(79, 7, 2, '2018-08-13 12:03:24', '2018-08-13 12:05:02', 332500.0000, ''),
	(80, 1, 7, '2018-08-19 07:09:45', '2018-08-20 16:08:57', 191250.0000, ''),
	(81, 7, 2, '2018-08-13 12:03:24', '2018-08-13 12:05:02', 332500.0000, ''),
	(82, 1, 7, '2018-08-19 07:09:45', '0000-00-00 00:00:00', 50000.0000, '');
/*!40000 ALTER TABLE `tbl_m_pelanggan_deposit` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_pelanggan_deposit_hist
DROP TABLE IF EXISTS `tbl_m_pelanggan_deposit_hist`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_deposit_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_user` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `jml_deposit` decimal(32,4) NOT NULL,
  `debet` decimal(32,4) NOT NULL,
  `kredit` decimal(32,4) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_pelanggan_deposit_hist: ~19 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_pelanggan_deposit_hist` DISABLE KEYS */;
INSERT INTO `tbl_m_pelanggan_deposit_hist` (`id`, `id_app`, `id_user`, `id_pelanggan`, `tgl_simpan`, `jml_deposit`, `debet`, `kredit`, `keterangan`) VALUES
	(17, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(18, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(19, 7, 1, 7, '2018-08-19 07:16:36', 225000.0000, 0.0000, 175000.0000, 'Deposit sebesar 175.000'),
	(20, 7, 1, 7, '2018-08-19 07:18:42', 168000.0000, 57000.0000, 0.0000, 'Transaksi #00001'),
	(21, 7, 1, 2, '2018-08-19 07:28:04', 482500.0000, 0.0000, 100000.0000, 'Deposit sebesar 100.000'),
	(22, 1, 1, 2, '2018-08-19 07:49:47', 306500.0000, 76000.0000, 0.0000, 'Transaksi #5'),
	(23, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(24, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(25, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(26, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(27, 7, 1, 7, '2018-08-19 07:16:36', 225000.0000, 0.0000, 175000.0000, 'Deposit sebesar 175.000'),
	(28, 7, 1, 7, '2018-08-19 07:18:42', 168000.0000, 57000.0000, 0.0000, 'Transaksi #00001'),
	(29, 7, 1, 2, '2018-08-19 07:28:04', 482500.0000, 0.0000, 100000.0000, 'Deposit sebesar 100.000'),
	(30, 1, 1, 2, '2018-08-19 07:49:47', 306500.0000, 76000.0000, 0.0000, 'Transaksi #5'),
	(31, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(32, 1, 1, 7, '2018-08-19 07:09:45', 50000.0000, 0.0000, 50000.0000, 'Deposit pertama sebesar 50.000'),
	(33, 7, 1, 2, '2018-08-20 16:15:46', 278084.0000, 54416.0000, 0.0000, 'Transaksi #8'),
	(34, 1, 1, 7, '2018-08-20 15:42:24', 225000.0000, 0.0000, 175000.0000, 'Deposit sebesar 175.000'),
	(35, 1, 1, 7, '2018-08-20 16:08:57', 191250.0000, 33750.0000, 0.0000, 'Transaksi #00001'),
	(36, 1, 1, 7, '2018-08-20 15:42:24', 225000.0000, 0.0000, 175000.0000, 'Deposit sebesar 175.000'),
	(37, 1, 1, 7, '2018-08-20 16:08:57', 191250.0000, 33750.0000, 0.0000, 'Transaksi #00001');
/*!40000 ALTER TABLE `tbl_m_pelanggan_deposit_hist` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_pelanggan_grup
DROP TABLE IF EXISTS `tbl_m_pelanggan_grup`;
CREATE TABLE IF NOT EXISTS `tbl_m_pelanggan_grup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `grup` varchar(160) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `pot_nominal` decimal(13,2) NOT NULL DEFAULT '0.00',
  `pot_persen` decimal(13,2) NOT NULL DEFAULT '0.00',
  `keterangan` text COLLATE utf8_unicode_ci NOT NULL,
  `status_deposit` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_pelanggan_grup: ~3 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_pelanggan_grup` DISABLE KEYS */;
INSERT INTO `tbl_m_pelanggan_grup` (`id`, `id_app`, `tgl_simpan`, `tgl_modif`, `grup`, `pot_nominal`, `pot_persen`, `keterangan`, `status_deposit`) VALUES
	(2, 7, '2018-05-21 10:01:00', '0000-00-00 00:00:00', 'BIASA', 0.00, 0.00, '-', '0'),
	(3, 7, '2018-05-21 10:00:00', '0000-00-00 00:00:00', 'GOLD', 0.00, 0.00, '-', '0'),
	(4, 7, '2018-05-21 10:00:00', '0000-00-00 00:00:00', 'PLATINUM', 0.00, 0.00, '-', '1');
/*!40000 ALTER TABLE `tbl_m_pelanggan_grup` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_penjahit
DROP TABLE IF EXISTS `tbl_m_penjahit`;
CREATE TABLE IF NOT EXISTS `tbl_m_penjahit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` date NOT NULL,
  `penjahit` varchar(160) NOT NULL,
  `jml_stok` int(11) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_penjahit: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_penjahit` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_penjahit` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_platform
DROP TABLE IF EXISTS `tbl_m_platform`;
CREATE TABLE IF NOT EXISTS `tbl_m_platform` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `platform` varchar(160) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_kategori` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_platform: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_platform` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_platform` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_produk
DROP TABLE IF EXISTS `tbl_m_produk`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_kategori` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `kode` varchar(64) NOT NULL,
  `produk` varchar(160) NOT NULL,
  `jml` int(10) NOT NULL,
  `harga_beli` decimal(32,2) NOT NULL,
  `harga_jual` decimal(32,2) NOT NULL,
  `keterangan` text NOT NULL,
  `tipe_produk` enum('1','2') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_produk: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_produk` DISABLE KEYS */;
INSERT INTO `tbl_m_produk` (`id`, `id_app`, `id_kategori`, `tgl_simpan`, `tgl_modif`, `kode`, `produk`, `jml`, `harga_beli`, `harga_jual`, `keterangan`, `tipe_produk`) VALUES
	(1, 0, 0, '2018-08-20 14:40:33', '0000-00-00 00:00:00', 'PL18', 'Plastik', 0, 0.00, 0.00, '', '2'),
	(2, 0, 0, '2018-08-20 14:40:46', '0000-00-00 00:00:00', 'PL19', 'Hanger', 0, 0.00, 0.00, '', '2'),
	(3, 0, 0, '2018-08-20 14:41:20', '0000-00-00 00:00:00', 'PL20', 'Kardus', 0, 0.00, 0.00, '', '2');
/*!40000 ALTER TABLE `tbl_m_produk` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_produk_harga
DROP TABLE IF EXISTS `tbl_m_produk_harga`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_harga` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `tgl_simpan` date NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `harga` decimal(32,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_harga_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_harga_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_produk_harga: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_produk_harga` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_produk_harga` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_produk_hist
DROP TABLE IF EXISTS `tbl_m_produk_hist`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_stok` int(11) NOT NULL,
  `id_penjahit` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `keterangan` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_hist_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_produk_hist: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_produk_hist` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_produk_hist` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_produk_stok
DROP TABLE IF EXISTS `tbl_m_produk_stok`;
CREATE TABLE IF NOT EXISTS `tbl_m_produk_stok` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_produk` int(11) NOT NULL,
  `id_penjahit` int(11) NOT NULL,
  `tgl_simpan` date NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_m_produk_stok_tbl_m_produk` (`id_produk`),
  CONSTRAINT `FK_tbl_m_produk_stok_tbl_m_produk` FOREIGN KEY (`id_produk`) REFERENCES `tbl_m_produk` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_produk_stok: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_m_produk_stok` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_m_produk_stok` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_m_promo
DROP TABLE IF EXISTS `tbl_m_promo`;
CREATE TABLE IF NOT EXISTS `tbl_m_promo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL DEFAULT '0',
  `tgl_simpan` datetime NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  `nominal` decimal(10,4) NOT NULL,
  `persen` decimal(10,4) NOT NULL,
  `tipe` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_m_promo: 2 rows
/*!40000 ALTER TABLE `tbl_m_promo` DISABLE KEYS */;
INSERT INTO `tbl_m_promo` (`id`, `id_app`, `tgl_simpan`, `keterangan`, `nominal`, `persen`, `tipe`) VALUES
	(8, 0, '2018-08-18 19:27:00', 'MERDEKA', 0.0000, 5.0000, '1'),
	(9, 0, '2018-08-18 19:27:00', 'Diskon Umum', 0.0000, 10.0000, '1');
/*!40000 ALTER TABLE `tbl_m_promo` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_pengaturan
DROP TABLE IF EXISTS `tbl_pengaturan`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan` (
  `id_pengaturan` int(3) NOT NULL AUTO_INCREMENT,
  `id_app` int(3) NOT NULL DEFAULT '0',
  `website` varchar(100) NOT NULL,
  `judul` varchar(500) NOT NULL,
  `deskripsi` text NOT NULL,
  `deskripsi_pendek` text NOT NULL,
  `notifikasi` varchar(320) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `email` varchar(360) NOT NULL,
  `pesan` text NOT NULL,
  `tlp` varchar(160) NOT NULL,
  `fax` varchar(160) NOT NULL,
  `status_app` enum('pusat','cabang') NOT NULL,
  PRIMARY KEY (`id_pengaturan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_pengaturan: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_pengaturan` DISABLE KEYS */;
INSERT INTO `tbl_pengaturan` (`id_pengaturan`, `id_app`, `website`, `judul`, `deskripsi`, `deskripsi_pendek`, `notifikasi`, `alamat`, `email`, `pesan`, `tlp`, `fax`, `status_app`) VALUES
	(1, 7, '-', 'Pulito', '', '', '', 'Jl. Raya', 'mikhaelfelian@gmail.com', '', '085883086838', '', '');
/*!40000 ALTER TABLE `tbl_pengaturan` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_pengaturan_cabang
DROP TABLE IF EXISTS `tbl_pengaturan_cabang`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_cabang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime DEFAULT NULL,
  `keterangan` varchar(256) DEFAULT NULL,
  `sn` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_pengaturan_cabang: ~7 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_pengaturan_cabang` DISABLE KEYS */;
INSERT INTO `tbl_pengaturan_cabang` (`id`, `tgl_simpan`, `keterangan`, `sn`) VALUES
	(1, '2018-07-30 08:49:21', 'PUSAT', NULL),
	(2, '2018-07-30 08:50:03', 'CAB SUYUDI', NULL),
	(3, '2018-07-30 08:50:05', 'CABANG 2', NULL),
	(4, '2018-07-30 08:50:06', 'CABANG 3', NULL),
	(5, '2018-07-30 08:50:08', 'CABANG 4', NULL),
	(6, '2018-07-30 08:50:09', 'CABANG 5', NULL),
	(7, '2018-07-30 08:50:48', 'CAB S.PARMAN', NULL);
/*!40000 ALTER TABLE `tbl_pengaturan_cabang` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_pengaturan_mail
DROP TABLE IF EXISTS `tbl_pengaturan_mail`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_mail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proto` enum('mail','sendmail','smtp') COLLATE utf8_unicode_ci NOT NULL,
  `host` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `user` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `pass` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `port` int(11) NOT NULL,
  `timeout` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_pengaturan_mail: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_pengaturan_mail` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pengaturan_mail` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_pengaturan_notif
DROP TABLE IF EXISTS `tbl_pengaturan_notif`;
CREATE TABLE IF NOT EXISTS `tbl_pengaturan_notif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_pengaturan_notif: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_pengaturan_notif` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_pengaturan_notif` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_sessions_back
DROP TABLE IF EXISTS `tbl_sessions_back`;
CREATE TABLE IF NOT EXISTS `tbl_sessions_back` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` longblob NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_sessions_back: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_sessions_back` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_sessions_back` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_sessions_front
DROP TABLE IF EXISTS `tbl_sessions_front`;
CREATE TABLE IF NOT EXISTS `tbl_sessions_front` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` longblob NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_sessions_front: ~1 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_sessions_front` DISABLE KEYS */;
INSERT INTO `tbl_sessions_front` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
	('1ea2f88f5da9b49f2099656e0662b0cd', '::1', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/68.0.3440.106 Safari/537.36', 1534757530, _binary 0x613A373A7B733A393A22757365725F64617461223B733A303A22223B733A383A226964656E74697479223B733A31303A22737570657261646D696E223B733A383A22757365726E616D65223B733A31303A22737570657261646D696E223B733A353A22656D61696C223B733A31353A2261646D696E4061646D696E2E636F6D223B733A373A22757365725F6964223B733A313A2231223B733A31343A226F6C645F6C6173745F6C6F67696E223B733A31303A2231353334373335313635223B733A31303A227472616E735F6A75616C223B613A343A7B733A373A226E6F5F6E6F7461223B733A353A223030303032223B733A393A2274676C5F6D6173756B223B733A31303A22323031382D30382D3230223B733A31303A2274676C5F6B656C756172223B733A31303A22323031382D30382D3230223B733A31323A2269645F70656C616E6767616E223B733A313A2231223B7D7D);
/*!40000 ALTER TABLE `tbl_sessions_front` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_trans_jual
DROP TABLE IF EXISTS `tbl_trans_jual`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_app` int(11) NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `id_promo` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `tgl_bayar` date NOT NULL,
  `tgl_masuk` date NOT NULL,
  `tgl_keluar` date NOT NULL,
  `platform` varchar(160) NOT NULL,
  `jml_total` decimal(32,2) NOT NULL,
  `jml_diskon` decimal(32,2) NOT NULL,
  `jml_biaya` decimal(32,2) NOT NULL,
  `jml_gtotal` decimal(32,2) NOT NULL,
  `jml_bayar` decimal(32,2) NOT NULL,
  `jml_kembali` decimal(32,2) NOT NULL,
  `jml_kurang` decimal(32,2) NOT NULL,
  `jml_ongkir` decimal(32,2) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_gudang` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `status_nota` enum('0','1','2','3') NOT NULL,
  `status_bayar` enum('0','1','2') NOT NULL,
  `metode_bayar` enum('0','1','2') NOT NULL,
  `keterangan` text NOT NULL,
  `ck_jasa_lipat` int(1) NOT NULL,
  `ck_jasa_gantung` int(1) NOT NULL,
  `lokasi` varchar(50) NOT NULL,
  `cetak` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `no_nota` (`no_nota`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_trans_jual: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_trans_jual` DISABLE KEYS */;
INSERT INTO `tbl_trans_jual` (`id`, `id_app`, `no_nota`, `id_promo`, `tgl_simpan`, `tgl_modif`, `tgl_bayar`, `tgl_masuk`, `tgl_keluar`, `platform`, `jml_total`, `jml_diskon`, `jml_biaya`, `jml_gtotal`, `jml_bayar`, `jml_kembali`, `jml_kurang`, `jml_ongkir`, `id_user`, `id_gudang`, `id_pelanggan`, `status_nota`, `status_bayar`, `metode_bayar`, `keterangan`, `ck_jasa_lipat`, `ck_jasa_gantung`, `lokasi`, `cetak`) VALUES
	(8, 7, '00001', 8, '2018-08-20 00:00:00', '2018-08-20 16:15:46', '2018-08-20', '2018-08-20', '2018-08-20', '', 47280.00, 2864.00, 10000.00, 54416.00, 54916.00, 0.00, 0.00, 0.00, 1, 0, 2, '0', '1', '1', '', 0, 0, '', 0);
/*!40000 ALTER TABLE `tbl_trans_jual` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_trans_jual_det
DROP TABLE IF EXISTS `tbl_trans_jual_det`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL DEFAULT '0',
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_kategori3` int(11) NOT NULL,
  `id_kategori2` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `produk` varchar(256) NOT NULL,
  `keterangan` text NOT NULL,
  `harga` decimal(32,2) NOT NULL,
  `jml` int(6) NOT NULL,
  `subtotal` decimal(32,2) NOT NULL,
  `status_app` enum('0','1') NOT NULL,
  `status_hrg` int(11) NOT NULL,
  `status_brg` enum('0','1') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_jual_det_tbl_trans_jual` (`id_penjualan`),
  CONSTRAINT `FK_tbl_trans_jual_det_tbl_trans_jual` FOREIGN KEY (`id_penjualan`) REFERENCES `tbl_trans_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_trans_jual_det: ~2 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_trans_jual_det` DISABLE KEYS */;
INSERT INTO `tbl_trans_jual_det` (`id`, `id_penjualan`, `id_app`, `id_kategori3`, `id_kategori2`, `tgl_simpan`, `no_nota`, `produk`, `keterangan`, `harga`, `jml`, `subtotal`, `status_app`, `status_hrg`, `status_brg`) VALUES
	(15, 8, 7, 0, 10, '0000-00-00 00:00:00', '00001', 'SUB TEST KAT', 'TEST KATEGORI SEMENTARA', 15760.00, 3, 47280.00, '0', 0, '0'),
	(16, 8, 7, 0, 0, '0000-00-00 00:00:00', '00001', 'TEST KATEGORI SEMENTARA', '', 0.00, 0, 0.00, '0', 0, '0');
/*!40000 ALTER TABLE `tbl_trans_jual_det` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_trans_jual_hist
DROP TABLE IF EXISTS `tbl_trans_jual_hist`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjahit` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `stok` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_jual_hist_tbl_trans_jual` (`no_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_trans_jual_hist: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_trans_jual_hist` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_trans_jual_hist` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_trans_jual_lokasi
DROP TABLE IF EXISTS `tbl_trans_jual_lokasi`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_lokasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_penjualan` int(11) NOT NULL DEFAULT '0',
  `id_app` int(11) NOT NULL DEFAULT '0',
  `id_lokasi` int(11) DEFAULT NULL,
  `no_nota` varchar(50) DEFAULT NULL,
  `keterangan` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_tbl_trans_jual_lokasi_tbl_trans_jual` (`id_penjualan`),
  CONSTRAINT `FK_tbl_trans_jual_lokasi_tbl_trans_jual` FOREIGN KEY (`id_penjualan`) REFERENCES `tbl_trans_jual` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_trans_jual_lokasi: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_trans_jual_lokasi` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_trans_jual_lokasi` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_trans_jual_plat
DROP TABLE IF EXISTS `tbl_trans_jual_plat`;
CREATE TABLE IF NOT EXISTS `tbl_trans_jual_plat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_platform` int(11) NOT NULL,
  `no_nota` varchar(50) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `no_nota` (`no_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_trans_jual_plat: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_trans_jual_plat` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_trans_jual_plat` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_util_backup
DROP TABLE IF EXISTS `tbl_util_backup`;
CREATE TABLE IF NOT EXISTS `tbl_util_backup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NULL DEFAULT NULL,
  `name` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_util_backup: ~0 rows (lebih kurang)
/*!40000 ALTER TABLE `tbl_util_backup` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_util_backup` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_util_eksport
DROP TABLE IF EXISTS `tbl_util_eksport`;
CREATE TABLE IF NOT EXISTS `tbl_util_eksport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `file` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_util_eksport: 2 rows
/*!40000 ALTER TABLE `tbl_util_eksport` DISABLE KEYS */;
INSERT INTO `tbl_util_eksport` (`id`, `tgl_simpan`, `file`) VALUES
	(2, '2018-08-20 16:16:16', 'pulito_201808201616_CAB_S_PARMAN.json'),
	(3, '2018-08-20 16:21:24', 'pulito_201808201621_CAB_S_PARMAN.json');
/*!40000 ALTER TABLE `tbl_util_eksport` ENABLE KEYS */;

-- membuang struktur untuk table db_p3_pulito_cabang.tbl_util_import
DROP TABLE IF EXISTS `tbl_util_import`;
CREATE TABLE IF NOT EXISTS `tbl_util_import` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` timestamp NULL DEFAULT NULL,
  `file` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Membuang data untuk tabel db_p3_pulito_cabang.tbl_util_import: 3 rows
/*!40000 ALTER TABLE `tbl_util_import` DISABLE KEYS */;
INSERT INTO `tbl_util_import` (`id`, `tgl_simpan`, `file`) VALUES
	(3, '2018-08-20 14:54:32', 'pulito_201808201453_PUSAT.json'),
	(4, '2018-08-20 16:23:42', 'pulito_201808201612_PUSAT.json'),
	(5, '2018-08-20 16:29:22', 'pulito_201808201612_PUSAT.json');
/*!40000 ALTER TABLE `tbl_util_import` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
