#
# TABLE STRUCTURE FOR: tbl_inventori
#

DROP TABLE IF EXISTS tbl_inventori;

CREATE TABLE `tbl_inventori` (
  `id_inventori` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` int(11) NOT NULL,
  `nama` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `status` varchar(160) NOT NULL,
  PRIMARY KEY (`id_inventori`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_ion_groups
#

DROP TABLE IF EXISTS tbl_ion_groups;

CREATE TABLE `tbl_ion_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

INSERT INTO tbl_ion_groups (`id`, `name`, `description`) VALUES (1, 'superadmin', 'Super Administrator');
INSERT INTO tbl_ion_groups (`id`, `name`, `description`) VALUES (8, 'kasir', 'Bagian Kasir');
INSERT INTO tbl_ion_groups (`id`, `name`, `description`) VALUES (9, 'gudang', 'Bagian Gudang');
INSERT INTO tbl_ion_groups (`id`, `name`, `description`) VALUES (11, 'owner', 'Master aplikasi owner');


#
# TABLE STRUCTURE FOR: tbl_ion_login_attempts
#

DROP TABLE IF EXISTS tbl_ion_login_attempts;

CREATE TABLE `tbl_ion_login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#
# TABLE STRUCTURE FOR: tbl_ion_login_history
#

DROP TABLE IF EXISTS tbl_ion_login_history;

CREATE TABLE `tbl_ion_login_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `createAt` datetime NOT NULL,
  `updateAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_ion_users
#

DROP TABLE IF EXISTS tbl_ion_users;

CREATE TABLE `tbl_ion_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` blob NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

INSERT INTO tbl_ion_users (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (1, '127.0.0.1', 'administrator', '$2y$08$KF45HsaXiMdPwGd1NLQJoe5vEF.kdE0dIZqBq2Inrc75hnkwVy8S2', '', 'admin@admin.com', '', NULL, NULL, 'HAgx3/pkZEltSBi8', 1268889823, 1468984822, 1, 'Super Administrator', 'Administrator', 'ADMIN', '0');
INSERT INTO tbl_ion_users (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (17, '::1', 'kasir1', '$2y$08$0rIP22GJ7mccCq0LTYkcMOnBQdDtMmY/gxEL9bDmA3B8xNoVFjXLW', 'ekxkU5ePAgE3IrcZ', 'admin@admin.com', NULL, NULL, NULL, 'Ry7ySrlgShkODWZp', 1468046555, 1468924157, 1, 'Kasir Satu', NULL, NULL, NULL);
INSERT INTO tbl_ion_users (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (18, '::1', 'kasir2', '$2y$08$Ec4qLhkniIAvoi8gvng7Ou0Cr4anpcC5h.0od4QT7yV37Wjm7/iX.', 'Hlw76.hIkJbA0Unx', 'admin@admin.com', NULL, NULL, NULL, '1impTn2ov8I87jua', 1468046570, 1468046774, 1, 'Kasir Dua', NULL, NULL, NULL);
INSERT INTO tbl_ion_users (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (21, '::1', 'gudang1', '$2y$08$y3iwLrOI5YPWLj9oDfCJXO93xxGNtMVJSxZPkbju8nT.8ZYtVHR26', 'N7l2sblX0NCzHBoN', 'admin@admin.com', NULL, NULL, NULL, 't890Dc8UmRCz6vUt', 1468230493, 1468317825, 1, 'Gudang Satu', NULL, NULL, NULL);
INSERT INTO tbl_ion_users (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`) VALUES (22, '::1', 'admin', '$2y$08$4zQJdEnkyuMh6PPAWItEI.ejrCAdkeqWPcuDMOjiuOrbltUDM171S', '0MfapkoiZs4FSscy', 'admin@admin.com', NULL, NULL, NULL, 'T7tGU2sZYOMXNxwJ', 1468835568, 1468835579, 1, 'Owner', NULL, NULL, NULL);


#
# TABLE STRUCTURE FOR: tbl_ion_users_groups
#

DROP TABLE IF EXISTS tbl_ion_users_groups;

CREATE TABLE `tbl_ion_users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `tbl_ion_groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `tbl_ion_users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

INSERT INTO tbl_ion_users_groups (`id`, `user_id`, `group_id`) VALUES (1, 1, 1);
INSERT INTO tbl_ion_users_groups (`id`, `user_id`, `group_id`) VALUES (22, 17, 8);
INSERT INTO tbl_ion_users_groups (`id`, `user_id`, `group_id`) VALUES (23, 18, 8);
INSERT INTO tbl_ion_users_groups (`id`, `user_id`, `group_id`) VALUES (26, 21, 9);
INSERT INTO tbl_ion_users_groups (`id`, `user_id`, `group_id`) VALUES (27, 22, 11);


#
# TABLE STRUCTURE FOR: tbl_karyawan
#

DROP TABLE IF EXISTS tbl_karyawan;

CREATE TABLE `tbl_karyawan` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `id_jabatan` int(11) NOT NULL,
  `first_name` varchar(160) NOT NULL,
  `last_name` varchar(160) NOT NULL,
  `jns_klm` enum('L','P','O') NOT NULL,
  `alamat` text NOT NULL,
  `foto` varchar(100) NOT NULL,
  `no_hp` varchar(100) NOT NULL,
  `active` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO tbl_karyawan (`id`, `id_jabatan`, `first_name`, `last_name`, `jns_klm`, `alamat`, `foto`, `no_hp`, `active`) VALUES (1, 0, 'Putri Ayu', 'Fedoraningtyas', 'P', 'Jl. Mugas', '', '08574129201921', '');
INSERT INTO tbl_karyawan (`id`, `id_jabatan`, `first_name`, `last_name`, `jns_klm`, `alamat`, `foto`, `no_hp`, `active`) VALUES (2, 0, 'Fajar Tri', 'Centosanoputra', 'L', 'Jalan Raya', '', '089754123123', '');
INSERT INTO tbl_karyawan (`id`, `id_jabatan`, `first_name`, `last_name`, `jns_klm`, `alamat`, `foto`, `no_hp`, `active`) VALUES (3, 0, 'Bethara Ayu', 'Fedorawati', 'P', 'Jl. Dukuh', '', '089774411992', '');


#
# TABLE STRUCTURE FOR: tbl_karyawan_jabatan
#

DROP TABLE IF EXISTS tbl_karyawan_jabatan;

CREATE TABLE `tbl_karyawan_jabatan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jabatan` varchar(160) NOT NULL,
  `keterangan` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_kategori
#

DROP TABLE IF EXISTS tbl_kategori;

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` varchar(160) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

INSERT INTO tbl_kategori (`id_kategori`, `kategori`, `ket`) VALUES (3, 'Dessert', 'Menu Dessert');
INSERT INTO tbl_kategori (`id_kategori`, `kategori`, `ket`) VALUES (4, 'Western Food', 'Masakan Barat');
INSERT INTO tbl_kategori (`id_kategori`, `kategori`, `ket`) VALUES (5, 'Chinesse Food', 'Masakan China');
INSERT INTO tbl_kategori (`id_kategori`, `kategori`, `ket`) VALUES (6, 'Aneka Es', 'Es');


#
# TABLE STRUCTURE FOR: tbl_m_bahan
#

DROP TABLE IF EXISTS tbl_m_bahan;

CREATE TABLE `tbl_m_bahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `kode` varchar(160) NOT NULL,
  `bahan` text NOT NULL,
  `qty_awal` float NOT NULL,
  `qty` double NOT NULL,
  `qty_pemb` double NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `konversi` double NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (6, '2016-07-18 16:35:15', '2016-07-10 13:45:04', 2, 'da', 'Dada', '0', '0', '0', '', '0', 'Dada Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (7, '2016-07-18 16:35:15', '2016-07-10 13:45:04', 2, 'pa', 'Paha Atas', '0', '0', '0', '', '0', 'Paha Atas Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (8, '2016-07-18 16:35:15', '2016-07-10 13:45:04', 2, 'pb', 'Paha Bawah', '0', '0', '0', '', '0', 'Paha Bawah Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (9, '2016-04-10 00:00:00', '2016-07-09 14:33:00', 2, 'sy', 'Sayap', '0', '0', '0', '', '0', 'Sayap Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (10, '2016-04-10 00:00:00', '2016-07-02 19:32:42', 2, 'flt', 'Fillet', '0', '0', '0', '', '0', 'Fillet Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (11, '2016-04-10 00:00:00', '2016-07-07 14:34:00', 2, 'klt', 'Kulit', '0', '0', '0', '', '0', 'Kult Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (12, '2016-07-09 09:48:18', '2016-07-09 21:09:00', 2, 'tp', 'Tepung Breading', '0', '0', '0', '', '0', 'Tepung Breading Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (13, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'mri', 'Marinasi', '0', '0', '0', '', '0', 'Bubuk Marinasi Ayam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (14, '2016-07-08 03:46:06', '2016-07-09 21:09:00', 2, 'brs', 'Beras', '0', '0', '0', '', '0', 'Beras cap Sarjana');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (15, '2016-04-10 00:00:00', '2016-07-09 21:09:00', 2, 'gl', 'Gula', '0', '0', '0', '', '0', 'Gula Pasir');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (16, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'cb', 'Crispy Burger', '0', '0', '0', '', '0', 'Chicken Crispy Burger');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (17, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'bb', 'Beef burger', '0', '0', '0', '', '0', 'Daging Beef Burger');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (18, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'rb', 'Roti Burger', '0', '0', '0', '', '0', 'Roti Burger');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (19, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'kj', 'Keju Lembar', '0', '0', '0', '', '0', 'Keju Lembar Burger');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (20, '2016-07-18 16:35:15', '2016-07-04 04:26:00', 3, 'msp', 'Mie Spaghetti', '1000', '1000', '0', '', '0', 'Mie Spaghetti La Fonte');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (21, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'mrm', 'Mie Ramen', '0', '0', '0', '', '0', 'Mie Ramen Urai');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (22, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'bsp', 'Bumbu Spaghetti', '0', '0', '0', '', '0', 'Bumbu Spaghetti');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (23, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'btry', 'Bumbu Teriyaki', '0', '0', '0', '', '0', 'Bumbu teriyaki');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (24, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'bstk', 'Bumbu Steak', '0', '0', '0', '', '0', 'Bumbu Steak');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (25, '2016-04-10 00:00:00', '2016-07-02 19:32:42', 3, 'bsup', 'Bumbu Sup', '0', '0', '0', '', '0', 'Bumbu Sup');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (26, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'brm', 'Bumbu Ramen', '0', '0', '0', '', '0', 'Bumbu Ramen');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (27, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'bki', 'Bakso Ikan', '0', '0', '0', '', '0', 'Bakso Ikan');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (28, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'bkp', 'Bakso Pipa', '0', '0', '0', '', '0', 'Bakso Pipa');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (29, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'vl', 'Vanilla Latte', '0', '0', '0', '', '0', 'Vanilla Latte');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (30, '2016-07-08 03:46:07', '2016-07-07 14:34:00', 3, 'milo', 'Milo Coklat', '0', '0', '0', '', '0', 'Milo Coklat');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (31, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'just', 'Buah Strawberry', '0', '0', '0', '', '0', 'Buah Strawberry');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (32, '2016-04-10 00:00:00', '2016-07-02 15:06:54', 3, 'juss', 'Buah Sirsat', '0', '0', '0', '', '0', 'Buah Sirsat');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (33, '2016-04-10 00:00:00', '2016-07-07 14:34:00', 3, 'jusj', 'Buah Jambu Merah', '0', '0', '0', '', '0', 'Buah Jambu Merah');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (34, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'jusa', 'Buah Alpukat', '0', '0', '0', '', '0', 'Buah Alpukat');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (35, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'ssp', 'Susu Putih', '0', '0', '0', '', '0', 'Susu Putih Sachet');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (36, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'ssc', 'Susu Coklat', '0', '0', '0', '', '0', 'Susu Coklat Sachet');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (37, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'oreo', 'Oreo Vanilla', '0', '0', '0', '', '0', 'Oreo Vanilla');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (38, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'bolt', 'Bola Coklat', '0', '0', '0', '', '0', 'Bola Coklat');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (39, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'aqgl', 'Aqua Galon', '0', '0', '0', '', '0', 'Aqua Galon');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (40, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'sbt', 'Es Batu', '0', '0', '0', '', '0', 'Es Batu');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (41, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'cktp', 'Coklat Toping', '0', '0', '0', '', '0', 'Coklat Toping');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (42, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'my', 'Mayonaise', '0', '0', '0', '', '0', 'Mayonaise');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (43, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'cone', 'Cone Ice Cream', '0', '0', '0', '', '0', 'Cone Ice Cream');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (44, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'esc', 'Es Krim Coklat', '0', '0', '0', '', '0', 'Es Krim Coklat');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (45, '2016-04-10 00:00:00', '2016-07-07 09:31:00', 2, 'esv', 'Es Krim Vanilla', '0', '0', '0', '', '0', 'Es Krim Vanilla');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (46, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'ess', 'Es Krim Strawberry', '0', '0', '0', '', '0', 'Es Krim Strawberry');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (47, '2016-04-10 00:00:00', '2016-07-09 14:33:00', 3, 'ff', 'French Fries', '0', '0', '0', '', '0', 'French Fries');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (48, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'corn', 'Corn', '0', '0', '0', '', '0', 'Corn');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (49, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'mix', 'Mix Vegetable', '0', '0', '0', '', '0', 'Mix Vegetable');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (50, '2016-04-10 00:00:00', '2016-07-07 14:32:00', 2, 'jm', 'Jeruk Manis', '0', '0', '0', '', '0', 'Jeruk Manis');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (51, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'jmh', 'Jamur Hioko', '0', '0', '0', '', '0', 'Jamur Hioko');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (52, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'nori', 'Nori', '0', '0', '0', '', '0', 'Nori');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (53, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'trs', 'Terasi', '0', '0', '0', '', '0', 'Terasi');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (54, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bcb', 'Bubuk Cabai', '0', '0', '0', '', '0', 'Bubuk Cabai');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (55, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bmc', 'Bubuk Merica', '0', '0', '0', '', '0', 'Bubuk Merica');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (56, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bpt', 'Bawang Putih', '0', '0', '0', '', '0', 'Bawang Putih');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (57, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bgr', 'Bubuk Garam', '0', '0', '0', '', '0', 'Bubuk Garam');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (58, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bmsg', 'Bubuk MSG', '0', '0', '0', '', '0', 'Bubuk MSG');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (59, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bby', 'Bawang Bombay', '0', '0', '0', '', '0', 'Bawang Bombay');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (60, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'sld', 'Selada', '0', '0', '0', '', '0', 'Selada Keriting');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (61, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'tmn', 'Timun', '0', '0', '0', '', '0', 'Timun');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (62, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'blb', 'Blue Band', '0', '0', '0', '', '0', 'Blue Band');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (63, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'kjpr', 'Keju Parut', '0', '0', '0', '', '0', 'Keju Parut');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (64, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'spbg', 'Spread Burger', '0', '0', '0', '', '0', 'Spread Burger');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (65, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bbq', 'Bubuk Barbeque', '0', '0', '0', '', '0', 'Bubuk Barbeque');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (66, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'bkj', 'Bubuk Keju', '0', '0', '0', '', '0', 'Bubuk Keju');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (67, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'wjn', 'Wijen', '0', '0', '0', '', '0', 'Wijen');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (68, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'pmse', 'Permen Sundae', '0', '0', '0', '', '0', 'Permen Sundae');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (69, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'srpt', 'Sirup Strawberry', '0', '0', '0', '', '0', 'Sirup Strawberry');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (70, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'LPG12', 'LPG 12 Kg', '0', '0', '0', '', '0', 'LPG 12 Kg');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (71, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'LPG3', 'LPG 3 Kg', '0', '0', '0', '', '0', 'LPG 3 Kg');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (72, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'teh', 'Teh ', '0', '0', '0', '', '0', 'Teh');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (73, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'sats', 'Saus Tomat Sachet', '0', '0', '0', '', '0', 'Saus Tomat Sachet');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (74, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'sass', 'Saus Sambal Sachet', '0', '0', '0', '', '0', 'Saus Sambal Sachet');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (75, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'satj', 'Saus Tomat Jerigen', '0', '0', '0', '', '0', 'Saus Tomat Jerigen');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (76, '2016-07-08 03:46:07', '2016-07-07 14:05:00', 2, 'sasj', 'Saus Sambal Jerigen', '0', '0', '0', '', '0', 'Saus Sambal Jerigen');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (77, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 1, 'mypd', 'Minyak Padat', '0', '0', '0', '', '0', 'Minyak Padat Palmia');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (78, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'rlth', 'Roll Thermal', '0', '0', '0', '', '0', 'Roll Thermal');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (79, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'rlpt', 'Roll Printer', '0', '0', '0', '', '0', 'Roll Printer');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (80, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'ptpt', 'Pita Printer', '0', '0', '0', '', '0', 'Pita Printer');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (81, '2016-07-08 03:46:07', '2016-07-09 13:47:00', 3, 'dos', 'Dos Ayam', '0', '0', '0', '', '0', 'Dos Ayam Take Away');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (82, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'fmb', 'Foam Besar', '0', '0', '0', '', '0', 'Foam Besar');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (83, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'fmk', 'Foam Kecil', '0', '0', '0', '', '0', 'Foam Kecil');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (84, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k15k', 'K15 Kuning', '0', '0', '0', '', '0', 'Kresek Ukuran 15 Kuning');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (85, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k15b', 'K15 Biru', '0', '0', '0', '', '0', 'Kresek Ukuran 15 Biru');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (86, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k15m', 'K15 Merah', '0', '0', '0', '', '0', 'Kresek Ukuran 15 Merah');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (87, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k15h', 'K15 Hijau', '0', '0', '0', '', '0', 'Kresek Ukuran 15 Hijau');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (88, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k15p', 'K15 Putih', '0', '0', '0', '', '0', 'Kresek Ukuran 15 Putih');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (89, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k21b', 'K21 Putih', '0', '0', '0', '', '0', 'Kresek Ukuran 21 Putih');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (90, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k28', 'K28 Putih', '0', '0', '0', '', '0', 'Kresek Ukuran 28 Putih');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (91, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'k35', 'K35 Putih', '0', '0', '0', '', '0', 'Kresek Ukuran 35 Putih');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (92, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'pal', 'Plastik Alas', '0', '0', '0', '', '0', 'Plastik Alas');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (93, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'pbb', 'Plastik Bumbu', '0', '0', '0', '', '0', 'Plastik Bumbu 1/4 kg');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (94, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'prm', 'Plastik Ramen', '0', '0', '0', '', '0', 'Plastik Kuah Ramen 1 Kg');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (95, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'psa', 'Plastik Sampah', '0', '0', '0', '', '0', 'Plastik Sampah 60x100');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (96, '2016-07-09 09:48:18', '2016-07-09 13:44:00', 2, 'kns', 'Kertas Nasi', '0', '0', '0', '', '0', 'Kertas Pembungkus Nasi');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (97, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'g10', 'Gelas 10 Oz', '0', '0', '0', '', '0', 'Gelas Ukuran 10 oz');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (98, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'g12', 'Gelas 12 Oz', '0', '0', '0', '', '0', 'Gelas Ukuran 12 Oz');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (99, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'g16', 'Gelas 16 Oz', '0', '0', '0', '', '0', 'Gelas Ukuran 16 Oz');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (100, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'sdm', 'Sendok Makan', '0', '0', '0', '', '0', 'Sendok Makan');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (101, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'sdk', 'Sendok Kecil', '0', '0', '0', '', '0', 'Sendok Kecil');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (102, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'grp', 'Garpu', '0', '0', '0', '', '0', 'Garpu');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (103, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'smpt', 'Sumpit', '0', '0', '0', '', '0', 'Sumpit');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (104, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'sdtk', 'Sedotan Kecil', '0', '0', '0', '', '0', 'Sedotan Kecil');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (105, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 2, 'sdtb', 'Sedotan Besar', '0', '0', '0', '', '0', 'Sedotan Besar');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (106, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 5, 'ts', 'Tissue', '0', '0', '0', '', '0', 'Tissue');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (107, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'sbtg', 'Sabun Tangan', '0', '0', '0', '', '0', 'Sabun Tangan');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (108, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'sbpr', 'Sabun Piring', '0', '0', '0', '', '0', 'Sabun Piring');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (109, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'sblt', 'Sabun Lantai', '0', '0', '0', '', '0', 'Sabun Lantai');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (110, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'sbmj', 'Sabun Meja', '0', '0', '0', '', '0', 'Sabun Meja');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (111, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'sbdt', 'Sabun Deterjen', '0', '0', '0', '', '0', 'Sabun Deterjen');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (112, '2016-04-10 00:00:00', '2016-07-06 11:28:00', 3, 'ades', 'Ades', '0', '0', '0', '', '0', 'Ades');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (113, '2016-04-10 00:00:00', '2016-07-07 09:31:00', 4, 'fn', 'Fanta', '0', '0', '0', '', '0', 'Fanta');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (114, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 4, 'cc', 'Coca Cola', '0', '0', '0', '', '0', 'Coca Cola');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (115, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'fc', 'Frestea Cup', '0', '0', '0', '', '0', 'Frestea Cup 300 ml');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (116, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'pul', 'Pulpy', '0', '0', '0', '', '0', 'Pulpy');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (119, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'tb', 'Teh Botol Kaca Frestea', '0', '0', '0', '', '0', 'Teh Botol Kaca Frestea');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (120, '2016-04-10 00:00:00', '2016-06-30 00:00:00', 3, 'fbt', 'Frestea Botol Plastik', '0', '0', '0', '', '0', 'Frestea Botol Plastik 500 ml');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (121, '2016-07-18 16:42:51', '2016-07-19 22:40:00', 2, '001', 'bahan 1', '1000', '-515', '0', '', '0', '');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (122, '2016-07-18 16:42:51', '2016-07-19 22:40:00', 2, '002', 'bahan 2', '1000', '-515', '0', '', '0', '');
INSERT INTO tbl_m_bahan (`id`, `tgl_simpan`, `tgl_modif`, `id_satuan`, `kode`, `bahan`, `qty_awal`, `qty`, `qty_pemb`, `satuan`, `konversi`, `ket`) VALUES (123, '2016-07-18 16:42:51', '2016-07-19 22:40:00', 2, '003', 'bahan 3', '1000', '-515', '0', '', '0', '-');


#
# TABLE STRUCTURE FOR: tbl_m_satuan
#

DROP TABLE IF EXISTS tbl_m_satuan;

CREATE TABLE `tbl_m_satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(64) NOT NULL,
  `satuan` varchar(64) NOT NULL,
  `value` varchar(50) NOT NULL,
  `ket` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

INSERT INTO tbl_m_satuan (`id`, `kode`, `satuan`, `value`, `ket`) VALUES (1, 'SAT.00001', 'kg', '', 'Kilogram');
INSERT INTO tbl_m_satuan (`id`, `kode`, `satuan`, `value`, `ket`) VALUES (2, 'SAT.00002', 'gram', '', 'Gram');


#
# TABLE STRUCTURE FOR: tbl_m_supplier
#

DROP TABLE IF EXISTS tbl_m_supplier;

CREATE TABLE `tbl_m_supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(160) NOT NULL,
  `nama` varchar(160) NOT NULL,
  `keterangan` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

INSERT INTO tbl_m_supplier (`id`, `kode`, `nama`, `keterangan`) VALUES (3, 'SUPP.0001', 'Supplier', 'asasas');
INSERT INTO tbl_m_supplier (`id`, `kode`, `nama`, `keterangan`) VALUES (4, 'fgdfg', 'gdfgdg', 'gdfgdf');


#
# TABLE STRUCTURE FOR: tbl_meja
#

DROP TABLE IF EXISTS tbl_meja;

CREATE TABLE `tbl_meja` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `no_meja` varchar(10) NOT NULL,
  `foto` varchar(56) NOT NULL,
  `status` int(2) NOT NULL,
  `use_id` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (1, 'Antrian ?1', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (2, 'Antrian  2', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (3, 'Antrian  3', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (4, 'Antrian  4', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (5, 'Antrian 5', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (6, 'Antrian 6', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (7, 'Antrian 7', '', 0, '');
INSERT INTO tbl_meja (`id`, `no_meja`, `foto`, `status`, `use_id`) VALUES (8, 'Antrian 8', '', 0, '');


#
# TABLE STRUCTURE FOR: tbl_menu
#

DROP TABLE IF EXISTS tbl_menu;

CREATE TABLE `tbl_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_kategori` int(11) NOT NULL,
  `kode` varchar(160) NOT NULL,
  `menu` text NOT NULL,
  `qty` int(11) NOT NULL,
  `harga_dasar` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `ket` text NOT NULL,
  `file` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=latin1;

INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (172, 4, 'fc', 'Frestea Cup 350ml', 0, 1541, 2500, 'Frestea Cup 350ml', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (173, 4, 'pul', 'Pulpy', 0, 5500, 7000, 'Pulpy Botol 350ml', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (174, 4, 'fbt', 'Frestea Botol Plastik 500ml', 0, 4666, 6000, 'Frestea Botol Plastik 500ml', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (175, 4, 'vl', 'Vanilla Latte', 0, 2084, 6500, 'Vanilla Latte', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (176, 4, 'msv', 'Milkshake Vanilla', 0, 4504, 8500, 'Milkshake Vanilla', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (177, 4, 'mss', 'Milkshake Strawberry', 0, 4975, 8500, 'Milkshake Strawberry', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (178, 4, 'msc', 'Milkshake Coklat', 0, 4939, 8500, 'Milkshake Coklat', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (179, 4, 'just', 'Jus Strawberry', 0, 2882, 7000, 'Jus Strawberry', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (180, 4, 'juss', 'Jus Sirsat', 0, 4567, 7000, 'Jus Sirsat', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (181, 4, 'jusj', 'Jus Jambu', 0, 2667, 7000, 'Jus Jambu', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (182, 4, 'jusa', 'Jus Alpukat', 0, 4401, 7000, 'Jus Alpukat', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (183, 4, 'ckl', 'Ice Chocolate', 0, 3522, 6500, 'Ice Chocolate', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (184, 4, 'tb', 'Teh Botol', 0, 1666, 4000, 'Teh Botol Kaca Frestea', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (185, 4, 'teh', 'Es Teh', 0, 1437, 2500, 'Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (186, 4, 'jm', 'Es Jeruk Manis', 0, 1605, 4500, 'Es Jeruk Manis', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (187, 3, 'scv', 'Ice Cream Sundae Coklat Vanilla', 0, 5017, 8500, 'Ice Cream Sundae Coklat Vanilla', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (188, 3, 'scs', 'Ice Cream Sundae Coklat Strawberry', 0, 5017, 8500, 'Ice Cream Sundae Coklat Strawberry', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (189, 3, 'svs', 'Ice Cream Sundae Vanilla Strawberry', 0, 5017, 8500, 'Ice Cream Sundae Vanilla Strawberry', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (190, 3, 'cnc', 'Ice Cone Coklat', 0, 2640, 4500, 'Ice Cone Coklat', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (191, 3, 'cnv', 'Ice Cone Vanilla', 0, 2640, 4500, 'Ice Cone Vanilla', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (192, 3, 'cns', 'Ice Cone Strawberry', 0, 2640, 4500, 'Ice Cone Strawberry', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (193, 4, 'fnf', 'Fanta Float', 0, 4093, 8000, 'Fanta Float', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (194, 4, 'ccf', 'Coca Cola Float', 0, 4093, 8000, 'Coca Cola Float', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (195, 4, 'fn', 'Fanta', 0, 2019, 5000, 'Fanta', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (196, 4, 'cc', 'Coca Cola', 0, 2019, 5000, 'Coca Cola', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (197, 4, 'ades', 'Ades', 0, 2123, 3500, 'Air Mineral Ades', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (198, 3, 'try', 'Chicken Teriyaki', 0, 7840, 12000, 'Chicken Teriyaki + Nasi Putih', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (199, 3, 'stk', 'Chicken Steak Mushroom', 0, 8508, 12000, 'Chicken Steak Mushroom', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (200, 3, 'sp', 'Chicken Spaghetti', 0, 3973, 9000, 'Chicken Spaghetti', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (201, 3, 'sup', 'Chicken Sup', 0, 3856, 7500, 'Chicken Sup', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (202, 3, 'rm', 'Seafood Ramen', 0, 9725, 14500, 'Seafood Ramen', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (203, 3, 'np', 'Nasi Putih', 0, 1209, 2500, 'Nasi Putih', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (204, 3, 'klt', 'Kuit + Mayonaise', 0, 4621, 8000, 'Kuit + Mayonaise', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (205, 3, 'fo', 'French Fries Original', 0, 3189, 8000, 'French Fries Original', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (206, 3, 'fk', 'French Fries Keju + Mayonaise', 0, 3931, 9000, 'French Fries Keju + Mayonaise', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (207, 3, 'fb', 'French Fries Barbeque + Mayonaise', 0, 3931, 9000, 'French Fries Barbeque + Mayonaise', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (208, 3, 'cbk', 'Chicken Burger + Keju', 0, 9790, 13500, 'Chicken Burger + Keju', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (209, 3, 'cb', 'Chicken Burger', 0, 8490, 12000, 'Chicken Burger', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (210, 3, 'bbk', 'Beef Burger + Keju', 0, 9998, 14500, 'Beef Burger + Keju', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (211, 3, 'bb', 'Beef Burger', 0, 8698, 13000, 'Beef Burger', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (212, 3, 'gs', 'Geprek Sayap', 0, 5813, 10000, 'Geprek Sayap', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (213, 3, 'gpb', 'Geprek Paha Bawah', 0, 5963, 11000, 'Geprek Paha Bawah', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (214, 3, 'gpa', 'Geprek Paha Atas', 0, 6863, 12500, 'Geprek Paha Atas', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (215, 3, 'gda', 'Geprek Dada', 0, 6863, 12500, 'Geprek Dada', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (216, 3, 'fs', 'Fried Chicken Sayap', 0, 5563, 9000, 'Fried Chicken Sayap', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (217, 3, 'fpb', 'Fried Chicken Paha Bawah', 0, 5713, 10000, 'Fried Chicken Paha Bawah', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (218, 3, 'fpa', 'Fried Chicken Paha Atas', 0, 6613, 11500, 'Fried Chicken Paha Atas', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (219, 3, 'fda', 'Fried Chicken Dada', 0, 6613, 11500, 'Fried Chicken Dada', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (220, 3, 'taf', 'TA Paket Geprek F Sayap', 0, 9141, 14000, 'Take Away Ayam Geprek Sayap + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (221, 3, 'tae', 'TA Paket Geprek E Paha Bawah', 0, 9291, 14000, 'Take Away Ayam Geprek Paha Bawah + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (222, 3, 'tadp', 'TA Paket Geprek D Paha Atas', 0, 10191, 16500, 'Take Away Ayam Geprek Paha Atas + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (223, 3, 'Tadd', 'TA Paket Geprek D Dada', 0, 10191, 16500, 'Take Away Ayam Geprek Dada + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (224, 3, 'tac', 'TA Paket C Sayap', 0, 8890, 13000, 'Take Away Ayam Fried Chicken Sayap + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (225, 3, 'tab', 'TA Paket B Paha Bawah', 0, 7924, 13500, 'Take Away Ayam Fried Chicken Paha Bawah + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (226, 3, 'Taap', 'TA Paket A Paha Atas', 0, 9940, 15500, 'Take Away Ayam Fried Chicken Paha Atas + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (227, 3, 'taad', 'TA Paket A Dada', 0, 9940, 15500, 'Take Away Ayam Fried Chicken Dada + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (228, 3, 'f', 'Paket Geprek F Sayap', 0, 7774, 12500, 'Ayam Geprek Sayap + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (229, 3, 'e', 'Paket Geprek E Paha Bawah', 0, 7924, 13500, 'Ayam Geprek Paha Bawah + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (230, 3, 'dp', 'Paket Geprek D Paha Atas', 0, 8824, 15000, 'Ayam Geprek Paha Atas + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (231, 3, 'dd', 'Paket Geprek D Dada', 0, 8824, 15000, 'Ayam Geprek Dada + Nasi + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (232, 3, 'c', 'Paket C Sayap', 0, 7669, 11500, 'Ayam Fried Chicken Sayap + Nasi Putih + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (233, 3, 'b', 'Paket B Paha Bawah', 0, 7819, 12500, 'Ayam Fried Chicken Paha Bawah + Nasi Putih + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (234, 3, 'ap', 'Paket A Paha Atas', 0, 8719, 14000, 'Ayam Fried Chicken Paha Atas + Nasi Putih + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (235, 3, 'ad', 'Paket A Dada', 0, 8719, 14000, 'Ayam Fried Chicken Dada + Nasi Putih + Es Teh', '');
INSERT INTO tbl_menu (`id`, `id_kategori`, `kode`, `menu`, `qty`, `harga_dasar`, `harga`, `ket`, `file`) VALUES (236, 3, 'MNBR', 'Menu 1', 0, 5000, 15000, '-', '');


#
# TABLE STRUCTURE FOR: tbl_menu_item
#

DROP TABLE IF EXISTS tbl_menu_item;

CREATE TABLE `tbl_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_menu` int(11) NOT NULL,
  `bahan` varchar(160) NOT NULL,
  `stok_awal` double NOT NULL,
  `qty` double NOT NULL,
  `stok_akhir` double NOT NULL,
  `ket` text NOT NULL,
  `id_satuan` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=180 DEFAULT CHARSET=latin1;

INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (13, 172, 'Frestea Cup', '0', '1', '0', '', 3, 115);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (14, 173, 'Pulpy', '0', '1', '0', '', 3, 116);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (15, 174, 'Frestea Botol Plastik', '0', '1', '0', '', 3, 120);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (16, 175, 'Vanilla Latte', '0', '1', '0', '', 3, 29);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (17, 176, 'Es Krim Vanilla', '0', '55', '0', '', 2, 45);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (18, 176, 'Susu Putih', '0', '1', '0', '', 3, 35);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (19, 176, 'Gula', '0', '20', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (20, 176, 'Oreo Vanilla', '0', '1', '0', '', 3, 37);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (21, 177, 'Susu Putih', '0', '1', '0', '', 3, 35);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (22, 177, 'Es Krim Strawberry', '0', '55', '0', '', 2, 46);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (23, 177, 'Buah Strawberry', '0', '0.5', '0', '', 3, 31);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (24, 177, 'Gula', '0', '20', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (25, 178, 'Gula', '0', '20', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (26, 178, 'Susu Coklat', '0', '1', '0', '', 3, 36);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (27, 178, 'Bola Coklat', '0', '1', '0', '', 3, 38);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (28, 178, 'Es Krim Coklat', '0', '55', '0', '', 2, 44);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (29, 179, 'Buah Strawberry', '0', '1', '0', '', 3, 31);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (30, 179, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (31, 180, 'Buah Sirsat', '0', '1', '0', '', 3, 32);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (32, 180, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (33, 181, 'Buah Jambu Merah', '0', '1', '0', '', 3, 33);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (34, 181, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (35, 182, 'Buah Alpukat', '0', '1', '0', '', 3, 34);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (36, 182, 'Gula', '0', '74', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (37, 183, 'Milo Coklat', '0', '1', '0', '', 3, 30);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (38, 183, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (39, 184, 'Teh Botol Kaca Frestea', '0', '1', '0', '', 3, 119);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (40, 185, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (41, 186, 'Gula', '0', '14', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (42, 186, 'Jeruk Manis', '0', '27.3', '0', '', 2, 50);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (43, 187, 'Es Krim Vanilla', '0', '55', '0', '', 2, 45);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (44, 187, 'Es Krim Coklat', '0', '55', '0', '', 2, 44);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (45, 188, 'Es Krim Coklat', '0', '55', '0', '', 2, 44);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (46, 188, 'Es Krim Strawberry', '0', '55', '0', '', 2, 46);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (47, 189, 'Es Krim Strawberry', '0', '55', '0', '', 2, 46);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (48, 189, 'Es Krim Vanilla', '0', '55', '0', '', 2, 45);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (49, 190, 'Es Krim Coklat', '0', '55', '0', '', 2, 44);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (50, 191, 'Es Krim Vanilla', '0', '55', '0', '', 2, 45);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (51, 192, 'Es Krim Strawberry', '0', '55', '0', '', 2, 46);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (52, 193, 'Fanta', '0', '0.2', '0', '', 4, 113);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (53, 193, 'Es Krim Vanilla', '0', '55', '0', '', 2, 45);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (54, 194, 'Coca Cola', '0', '0.2', '0', '', 4, 114);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (55, 194, 'Es Krim Vanilla', '0', '55', '0', '', 2, 45);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (56, 195, 'Fanta', '0', '0.2', '0', '', 4, 113);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (57, 196, 'Coca Cola', '0', '0.2', '0', '', 4, 114);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (58, 197, 'Ades', '0', '1', '0', '', 3, 112);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (59, 198, 'Fillet', '0', '70', '0', '', 2, 10);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (60, 198, 'Bumbu Teriyaki', '0', '1', '0', '', 3, 23);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (61, 198, 'Beras', '0', '83', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (62, 199, 'Fillet', '0', '70', '0', '', 2, 10);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (63, 199, 'Bumbu Steak', '0', '1', '0', '', 3, 24);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (64, 199, 'French Fries', '0', '0.5', '0', '', 3, 47);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (65, 200, 'Mie Spaghetti', '0', '1', '0', '', 3, 20);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (66, 200, 'Mie Spaghetti', '0', '1', '0', '', 3, 20);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (67, 201, 'Bumbu Sup', '0', '1', '0', '', 3, 25);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (68, 201, 'Fillet', '0', '35', '0', '', 2, 10);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (69, 202, 'Mie Ramen', '0', '1', '0', '', 3, 21);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (70, 202, 'Bumbu Ramen', '0', '1', '0', '', 3, 26);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (71, 202, 'Bakso Pipa', '0', '2', '0', '', 3, 28);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (72, 202, 'Bakso Ikan', '0', '2', '0', '', 3, 27);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (73, 203, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (74, 204, 'Kulit', '0', '70', '0', '', 2, 11);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (75, 205, 'French Fries', '0', '1', '0', '', 3, 47);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (76, 206, 'French Fries', '0', '1', '0', '', 3, 47);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (77, 207, 'French Fries', '0', '1', '0', '', 3, 47);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (78, 208, 'Roti Burger', '0', '1', '0', '', 3, 18);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (79, 208, 'Crispy Burger', '0', '1', '0', '', 3, 16);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (80, 208, 'Keju Lembar', '0', '1', '0', '', 3, 19);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (81, 209, 'Roti Burger', '0', '1', '0', '', 3, 18);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (82, 209, 'Crispy Burger', '0', '1', '0', '', 3, 16);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (83, 210, 'Roti Burger', '0', '1', '0', '', 3, 18);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (84, 210, 'Beef burger', '0', '1', '0', '', 3, 17);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (85, 210, 'Keju Lembar', '0', '1', '0', '', 3, 19);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (86, 211, 'Roti Burger', '0', '1', '0', '', 3, 18);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (87, 211, 'Beef burger', '0', '1', '0', '', 3, 17);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (88, 212, 'Sayap', '0', '1', '0', '', 3, 9);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (89, 212, 'Tepung', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (90, 213, 'Paha Bawah', '0', '1', '0', '', 3, 8);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (91, 213, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (92, 214, 'Paha Atas', '0', '1', '0', '', 3, 7);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (93, 214, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (94, 215, 'Dada', '0', '1', '0', '', 3, 6);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (95, 215, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (96, 216, 'Sayap', '0', '1', '0', '', 3, 9);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (97, 216, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (98, 217, 'Paha Bawah', '0', '1', '0', '', 3, 8);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (99, 217, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (100, 218, 'Paha Atas', '0', '1', '0', '', 3, 7);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (101, 218, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (102, 219, 'Dada', '0', '1', '0', '', 3, 6);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (103, 219, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (104, 220, 'Sayap', '0', '1', '0', '', 3, 9);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (105, 220, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (106, 220, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (107, 220, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (108, 221, 'Paha Bawah', '0', '1', '0', '', 3, 8);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (109, 221, 'Tepung Breading', '0', '1', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (110, 221, 'Kertas Nasi', '0', '80', '0', '', 2, 96);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (111, 221, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (112, 222, 'Paha Atas', '0', '1', '0', '', 3, 7);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (113, 222, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (114, 222, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (115, 222, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (116, 222, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (117, 221, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (118, 220, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (119, 223, 'Dada', '0', '1', '0', '', 3, 6);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (120, 223, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (121, 223, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (122, 223, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (123, 223, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (124, 224, 'Sayap', '0', '1', '0', '', 3, 9);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (125, 224, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (126, 224, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (127, 224, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (128, 224, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (129, 225, 'Paha Bawah', '0', '1', '0', '', 3, 8);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (130, 225, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (131, 225, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (132, 225, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (133, 225, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (134, 226, 'Paha Atas', '0', '1', '0', '', 3, 7);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (135, 226, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (136, 226, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (137, 226, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (138, 226, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (139, 227, 'Dada', '0', '1', '0', '', 3, 6);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (140, 227, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (141, 227, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (142, 227, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (143, 227, 'Dos Ayam', '0', '1', '0', '', 3, 81);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (144, 228, 'Sayap', '0', '1', '0', '', 3, 9);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (145, 228, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (146, 228, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (147, 228, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (148, 229, 'Paha Bawah', '0', '1', '0', '', 3, 8);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (149, 229, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (150, 229, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (151, 229, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (152, 230, 'Paha Atas', '0', '1', '0', '', 3, 7);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (153, 230, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (154, 230, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (155, 230, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (156, 231, 'Dada', '0', '1', '0', '', 3, 6);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (157, 231, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (158, 231, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (159, 231, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (160, 232, 'Sayap', '0', '1', '0', '', 3, 9);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (161, 232, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (162, 232, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (163, 232, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (164, 233, 'Paha Bawah', '0', '1', '0', '', 3, 8);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (165, 233, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (166, 233, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (167, 233, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (168, 234, 'Paha Atas', '0', '1', '0', '', 3, 7);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (169, 234, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (170, 234, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (171, 234, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (172, 235, 'Dada', '0', '1', '0', '', 3, 6);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (173, 235, 'Tepung Breading', '0', '37', '0', '', 2, 12);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (174, 235, 'Beras', '0', '80', '0', '', 2, 14);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (175, 235, 'Gula', '0', '37', '0', '', 2, 15);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (176, 235, 'Saus Sambal Jerigen', '0', '1.1', '0', '-', 2, 76);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (177, 236, 'bahan 1', '125', '5', '125', '', 2, 121);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (178, 236, 'bahan 2', '125', '5', '125', '', 2, 122);
INSERT INTO tbl_menu_item (`id`, `id_menu`, `bahan`, `stok_awal`, `qty`, `stok_akhir`, `ket`, `id_satuan`, `id_bahan`) VALUES (179, 236, 'bahan 3', '125', '5', '125', '', 2, 123);


#
# TABLE STRUCTURE FOR: tbl_metode_pemb
#

DROP TABLE IF EXISTS tbl_metode_pemb;

CREATE TABLE `tbl_metode_pemb` (
  `no_nota` varchar(160) NOT NULL,
  `metode` enum('cash','credit','debet','lain') NOT NULL,
  `no_card` varchar(160) NOT NULL,
  `bank` varchar(160) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`no_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00001', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00002', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00003', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00004', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00005', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00006', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00007', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00008', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00009', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00010', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00011', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00012', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00013', 'cash', '0', '', '');
INSERT INTO tbl_metode_pemb (`no_nota`, `metode`, `no_card`, `bank`, `ket`) VALUES ('RESTO.INV.00014', 'cash', '0', '', '');


#
# TABLE STRUCTURE FOR: tbl_orderlist
#

DROP TABLE IF EXISTS tbl_orderlist;

CREATE TABLE `tbl_orderlist` (
  `no_nota` varchar(160) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` datetime NOT NULL,
  `id_meja` int(11) NOT NULL,
  `no_meja` varchar(160) NOT NULL,
  `kode` varchar(160) NOT NULL,
  `nama` varchar(360) NOT NULL,
  `no_hp` varchar(160) NOT NULL,
  `alamat` text NOT NULL,
  `jml_bayar` int(15) NOT NULL,
  `jml_ppn` int(15) NOT NULL,
  `jml_gtotal` int(15) NOT NULL,
  `diskon` int(11) NOT NULL,
  `tot_bayar` int(15) NOT NULL,
  `tot_kembali` int(15) NOT NULL,
  `tot_kurang` int(15) NOT NULL,
  `pelayan` varchar(160) NOT NULL,
  `status_order` enum('pend','complete','confirm','batal','shipment','delivered') NOT NULL,
  `status_payment` enum('unpaid','paid') NOT NULL,
  `status_resto` enum('1','2','3') NOT NULL,
  `status_meja` enum('active','inactive') NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`no_nota`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00001', '2016-07-18 16:43:13', '2016-07-18 16:43:23', 1, 'Antrian ?1', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 30000, 0, 30000, 0, 50000, 20000, 0, '17', 'complete', 'paid', '2', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00002', '2016-07-19 17:29:23', '2016-07-19 17:29:36', 1, 'Antrian ?1', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 15000, 0, 15000, 0, 20000, 5000, 0, '17', 'complete', 'paid', '2', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00003', '2016-07-19 21:53:45', '2016-07-19 21:53:00', 1, 'Antrian ?1', 'PLGN.00005', 'Simon Petrus', '089774411992', 'Jl. Raya Sumarja', 15000, 0, 15000, 0, 15000, 0, 0, '17', 'delivered', 'paid', '1', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00004', '2016-07-19 21:55:59', '2016-07-23 21:55:00', 7, 'Antrian 7', 'PLGN.00001', 'Mike', '6285741220427', 'Jl. Mugas Dlm XI / 1', 300000, 0, 300000, 0, 325000, 25000, 0, '17', 'delivered', 'paid', '1', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00005', '2016-07-19 22:20:31', '2016-07-30 22:20:00', 6, 'Antrian 6', 'PLGN.00006', 'Sertu. Asmidi', '085748392839', 'Asrama TNI, Mabes Cilangkap', 375000, 0, 375000, 0, 400000, 25000, 0, '17', 'delivered', 'paid', '1', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00006', '2016-07-19 22:29:06', '2016-07-30 22:28:00', 7, 'Antrian 7', 'PLGN.00006', 'Sertu. Asmidi', '085748392839', 'Asrama TNI, Mabes Cilangkap', 750000, 0, 750000, 0, 750000, 0, 0, '17', 'delivered', 'paid', '1', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00007', '2016-07-19 22:29:23', '2016-07-19 22:29:29', 2, 'Antrian  2', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 75000, 0, 75000, 0, 100000, 25000, 0, '17', 'complete', 'paid', '2', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00008', '2016-07-19 22:29:58', '2016-07-31 22:29:00', 3, 'Antrian  3', 'PLGN.00005', 'Simon Petrus', '089774411992', 'Jl. Raya Sumarja', 1500000, 0, 1500000, 0, 1600000, 100000, 0, '17', 'delivered', 'paid', '1', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00009', '2016-07-19 22:30:21', '2016-07-19 22:30:33', 4, 'Antrian  4', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 1350000, 0, 1350000, 0, 1350000, 0, 0, '17', 'complete', 'paid', '3', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00010', '2016-07-19 22:30:48', '2016-07-19 22:30:55', 7, 'Antrian 7', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 60000, 0, 60000, 0, 100000, 40000, 0, '17', 'complete', 'paid', '2', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00011', '2016-07-19 22:30:59', '2016-07-19 22:31:07', 8, 'Antrian 8', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 15000, 0, 15000, 0, 20000, 5000, 0, '17', 'complete', 'paid', '3', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00012', '2016-07-19 22:31:12', '2016-07-19 22:31:17', 5, 'Antrian 5', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 15000, 0, 15000, 0, 20000, 5000, 0, '17', 'complete', 'paid', '2', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00013', '2016-07-19 22:31:24', '2016-07-19 22:31:29', 6, 'Antrian 6', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 30000, 0, 30000, 0, 100000, 70000, 0, '17', 'complete', 'paid', '3', 'inactive', '');
INSERT INTO tbl_orderlist (`no_nota`, `tgl_simpan`, `tgl_modif`, `id_meja`, `no_meja`, `kode`, `nama`, `no_hp`, `alamat`, `jml_bayar`, `jml_ppn`, `jml_gtotal`, `diskon`, `tot_bayar`, `tot_kembali`, `tot_kurang`, `pelayan`, `status_order`, `status_payment`, `status_resto`, `status_meja`, `ket`) VALUES ('RESTO.INV.00014', '2016-07-19 22:31:34', '2016-07-19 22:31:40', 1, 'Antrian ?1', 'PLGN.00000', 'Umum', 'Umum', 'Umum', 15000, 0, 15000, 0, 15000, 0, 0, '17', 'complete', 'paid', '2', 'inactive', '');


#
# TABLE STRUCTURE FOR: tbl_orderlist_det
#

DROP TABLE IF EXISTS tbl_orderlist_det;

CREATE TABLE `tbl_orderlist_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_meja` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `no_meja` varchar(160) NOT NULL,
  `no_nota` varchar(160) NOT NULL,
  `menu` varchar(360) NOT NULL,
  `keterangan` varchar(120) NOT NULL,
  `tambahan` enum('yes','no') NOT NULL,
  `harga` int(11) NOT NULL,
  `jml` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (1, '2016-07-18 16:43:23', 1, 236, 'Antrian ?1', 'RESTO.INV.00001', 'Menu 1', '-', 'yes', 15000, 2, 30000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (2, '2016-07-19 17:29:36', 1, 236, 'Antrian ?1', 'RESTO.INV.00002', 'Menu 1', '-', 'yes', 15000, 1, 15000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (3, '2016-07-19 21:53:45', 1, 236, 'Antrian ?1', 'RESTO.INV.00003', 'Menu 1', '-', 'yes', 15000, 1, 15000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (4, '2016-07-19 21:55:59', 7, 236, 'Antrian 7', 'RESTO.INV.00004', 'Menu 1', '-', 'yes', 15000, 20, 300000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (5, '2016-07-19 22:20:31', 6, 236, 'Antrian 6', 'RESTO.INV.00005', 'Menu 1', '-', 'yes', 15000, 25, 375000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (7, '2016-07-19 22:29:06', 7, 236, 'Antrian 7', 'RESTO.INV.00006', 'Menu 1', '-', 'yes', 15000, 50, 750000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (8, '2016-07-19 22:29:29', 2, 236, 'Antrian  2', 'RESTO.INV.00007', 'Menu 1', '', 'yes', 15000, 5, 75000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (9, '2016-07-19 22:29:58', 3, 236, 'Antrian  3', 'RESTO.INV.00008', 'Menu 1', '-', 'yes', 15000, 100, 1500000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (10, '2016-07-19 22:30:33', 4, 236, 'Antrian  4', 'RESTO.INV.00009', 'Menu 1', '-', 'yes', 15000, 90, 1350000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (11, '2016-07-19 22:30:55', 7, 236, 'Antrian 7', 'RESTO.INV.00010', 'Menu 1', '', 'yes', 15000, 4, 60000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (12, '2016-07-19 22:31:07', 8, 236, 'Antrian 8', 'RESTO.INV.00011', 'Menu 1', '', 'yes', 15000, 1, 15000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (13, '2016-07-19 22:31:18', 5, 236, 'Antrian 5', 'RESTO.INV.00012', 'Menu 1', '', 'yes', 15000, 1, 15000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (14, '2016-07-19 22:31:29', 6, 236, 'Antrian 6', 'RESTO.INV.00013', 'Menu 1', '', 'yes', 15000, 2, 30000, '');
INSERT INTO tbl_orderlist_det (`id`, `tgl`, `id_meja`, `id_menu`, `no_meja`, `no_nota`, `menu`, `keterangan`, `tambahan`, `harga`, `jml`, `subtotal`, `status`) VALUES (15, '2016-07-19 22:31:40', 1, 236, 'Antrian ?1', 'RESTO.INV.00014', 'Menu 1', '', 'yes', 15000, 1, 15000, '');


#
# TABLE STRUCTURE FOR: tbl_pelanggan
#

DROP TABLE IF EXISTS tbl_pelanggan;

CREATE TABLE `tbl_pelanggan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(360) COLLATE utf8_unicode_ci NOT NULL,
  `no_hp` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8_unicode_ci NOT NULL,
  `status_pesan` enum('1','2','3') COLLATE utf8_unicode_ci NOT NULL,
  `status_plgn` enum('umum','pelanggan') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `kode` (`kode`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (2, 'PLGN.00001', 'Mike', '6285741220427', 'Jl. Mugas Dlm XI / 1', '1', 'pelanggan');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (3, 'PLGN.00002', 'Test', '6285741220427', 'Test', '1', 'pelanggan');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (1, 'PLGN.00000', 'Umum', 'Umum', 'Umum', '', 'umum');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (7, 'PLGN.00003', 'Jono', '089774411992', 'Jl. Raya Wates', '1', 'pelanggan');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (8, 'PLGN.00004', 'Karsinogen', '03859304340', 'Jl. Raya', '1', 'umum');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (9, 'PLGN.00005', 'Simon Petrus', '089774411992', 'Jl. Raya Sumarja', '1', 'pelanggan');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (10, 'PLGN.00006', 'Sertu. Asmidi', '085748392839', 'Asrama TNI, Mabes Cilangkap', '1', 'pelanggan');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (11, 'PLGN.00007', 'Adi', '6285741220427', 'Jl. raya', '1', 'pelanggan');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (12, 'PLGN.00008', 'Aji', '6285741220427', 'Jl. Mugas Dlm XI / 1', '1', 'umum');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (13, 'PLGN.00009', 'Jitro', '7676767', 'gfgdgdfg', '1', 'umum');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (14, 'PLGN.00010', 'Dani', '6285741220427', 'Jl. Mugas Dlm XI / 1', '1', 'umum');
INSERT INTO tbl_pelanggan (`id`, `kode`, `nama`, `no_hp`, `alamat`, `status_pesan`, `status_plgn`) VALUES (15, 'PLGN.00011', 'Johan', '059690', 'sasa', '1', 'pelanggan');


#
# TABLE STRUCTURE FOR: tbl_pemasukan
#

DROP TABLE IF EXISTS tbl_pemasukan;

CREATE TABLE `tbl_pemasukan` (
  `id_pemasukan` int(5) NOT NULL AUTO_INCREMENT,
  `tgl` datetime NOT NULL,
  `kode` varchar(160) NOT NULL,
  `pemasukan` varchar(160) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `nominal` int(100) NOT NULL,
  PRIMARY KEY (`id_pemasukan`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_pembelian
#

DROP TABLE IF EXISTS tbl_pembelian;

CREATE TABLE `tbl_pembelian` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_supplier` int(11) NOT NULL,
  `tgl_simpan` datetime NOT NULL,
  `tgl_modif` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_nota` varchar(160) NOT NULL,
  `kode` varchar(160) NOT NULL,
  `nama` varchar(160) NOT NULL,
  `jml` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_pembelian_det
#

DROP TABLE IF EXISTS tbl_pembelian_det;

CREATE TABLE `tbl_pembelian_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_satuan` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `no_nota` varchar(160) NOT NULL,
  `kode` varchar(160) NOT NULL,
  `bahan` text NOT NULL,
  `qty` double NOT NULL,
  `harga` int(11) NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `konversi` double NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_pengaturan
#

DROP TABLE IF EXISTS tbl_pengaturan;

CREATE TABLE `tbl_pengaturan` (
  `id_pengaturan` int(3) NOT NULL AUTO_INCREMENT,
  `website` varchar(100) NOT NULL,
  `judul` varchar(500) NOT NULL,
  `deskripsi` varchar(768) NOT NULL,
  `string_plgn` varchar(160) NOT NULL,
  `string_nota` varchar(320) NOT NULL,
  `string_nota_bottom` varchar(160) NOT NULL,
  `string_nota_bottom2` varchar(160) NOT NULL,
  `string_nota_footer` varchar(40) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `email` varchar(360) NOT NULL,
  `pesan` text NOT NULL,
  `tlp` varchar(160) NOT NULL,
  `fax` varchar(160) NOT NULL,
  `logo` longtext NOT NULL,
  `fb` varchar(160) NOT NULL,
  `gplus` varchar(160) NOT NULL,
  `twit` varchar(160) NOT NULL,
  `ppn` int(11) NOT NULL,
  `ymket` varchar(160) NOT NULL,
  `bbket` varchar(160) NOT NULL,
  `print_method` enum('not_set','directly','network') NOT NULL,
  `print_os` varchar(800) NOT NULL,
  `print_driver` varchar(360) NOT NULL,
  `print_name` varchar(800) NOT NULL,
  `print_ip` varchar(160) NOT NULL,
  `print_port` varchar(160) NOT NULL,
  `id_satuan` int(11) NOT NULL,
  PRIMARY KEY (`id_pengaturan`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_pengaturan (`id_pengaturan`, `website`, `judul`, `deskripsi`, `string_plgn`, `string_nota`, `string_nota_bottom`, `string_nota_bottom2`, `string_nota_footer`, `alamat`, `email`, `pesan`, `tlp`, `fax`, `logo`, `fb`, `gplus`, `twit`, `ppn`, `ymket`, `bbket`, `print_method`, `print_os`, `print_driver`, `print_name`, `print_ip`, `print_port`, `id_satuan`) VALUES (1, 'http://localhost/resto/', 'Aplikasi Resto', 'Kami adalah produsen tas dan aksesoris National Geographic terbaik di Indonesia yang berlokasi di Jawa Tengah, Semarang.\n\nKami memberikan jaminan kepuasan barang untuk memastikan konsumen-konsumen kami mendapatkan yang terbaik dari NGSPECIALIST.\n\nHubungi kami di:\n085883086838 (Call, SMS, Whatsapp)\nNGSPECIALIST (Line)\n57374ef4 (BBM)', 'PLGN', 'RESTO.INV', 'Terimakasih ', 'Ditunggu kedatangannya kembali', 'Cashier', 'Jl. Raya ', '', 'Produsen Tas National Geographic Terbaik di Indonesia', '0741-33842', '021-5555555', '', '', '', '', 0, '', '', 'not_set', 'Unknown Windows OS', 'EPSON TM-U220 Receipt', 'EPSON TM-U220 Receipt', '192.168.1.128', '9100', 2);


#
# TABLE STRUCTURE FOR: tbl_pengeluaran
#

DROP TABLE IF EXISTS tbl_pengeluaran;

CREATE TABLE `tbl_pengeluaran` (
  `id_pengeluaran` int(5) NOT NULL AUTO_INCREMENT,
  `tgl` datetime NOT NULL,
  `kode` varchar(160) NOT NULL,
  `pengeluaran` varchar(160) NOT NULL,
  `jumlah` int(100) NOT NULL,
  `nominal` int(100) NOT NULL,
  PRIMARY KEY (`id_pengeluaran`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_printer
#

DROP TABLE IF EXISTS tbl_printer;

CREATE TABLE `tbl_printer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `print_os` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `print_driver` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `print_name` varchar(160) COLLATE utf8_unicode_ci NOT NULL,
  `print_port` int(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO tbl_printer (`id`, `ip`, `print_os`, `print_driver`, `print_name`, `print_port`) VALUES (1, '127.0.0.1', 'windows', 'EPSON TM-U220 Receipt', 'EPSON TM-U220 Receipt', 9100);


#
# TABLE STRUCTURE FOR: tbl_sessions_back
#

DROP TABLE IF EXISTS tbl_sessions_back;

CREATE TABLE `tbl_sessions_back` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO tbl_sessions_back (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('92b3544fd940b867c5396e1e4ac7b330', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 1468985209, 'a:5:{s:8:\"identity\";s:13:\"administrator\";s:8:\"username\";s:13:\"administrator\";s:5:\"email\";s:15:\"admin@admin.com\";s:7:\"user_id\";s:1:\"1\";s:14:\"old_last_login\";s:10:\"1468980848\";}');


#
# TABLE STRUCTURE FOR: tbl_sessions_front
#

DROP TABLE IF EXISTS tbl_sessions_front;

CREATE TABLE `tbl_sessions_front` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO tbl_sessions_front (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES ('2acbdb85747232c0f3ac03fe3bf71ba8', '::1', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.103 Safari/537.36', 1468984822, 'a:5:{s:8:\"identity\";s:13:\"administrator\";s:8:\"username\";s:13:\"administrator\";s:5:\"email\";s:15:\"admin@admin.com\";s:7:\"user_id\";s:1:\"1\";s:14:\"old_last_login\";s:10:\"1468984621\";}');


#
# TABLE STRUCTURE FOR: tbl_set_meja
#

DROP TABLE IF EXISTS tbl_set_meja;

CREATE TABLE `tbl_set_meja` (
  `id_set_meja` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_set_meja`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_track_bahan
#

DROP TABLE IF EXISTS tbl_track_bahan;

CREATE TABLE `tbl_track_bahan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_nota` varchar(160) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bahan` varchar(160) NOT NULL,
  `qty` int(50) NOT NULL,
  `ket` varchar(160) NOT NULL,
  `status_nota` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (1, 'RESTO.INV.00001', 236, 121, '2016-07-19 22:20:31', 'bahan 1', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (2, 'RESTO.INV.00001', 236, 122, '2016-07-19 22:20:31', 'bahan 2', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (3, 'RESTO.INV.00001', 236, 123, '2016-07-19 22:20:31', 'bahan 3', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (4, 'RESTO.INV.00002', 236, 121, '2016-07-19 22:20:31', 'bahan 1', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (5, 'RESTO.INV.00002', 236, 122, '2016-07-19 22:20:31', 'bahan 2', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (6, 'RESTO.INV.00002', 236, 123, '2016-07-19 22:20:31', 'bahan 3', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (7, 'RESTO.INV.00003', 236, 121, '2016-07-19 22:20:31', 'bahan 1', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (8, 'RESTO.INV.00003', 236, 122, '2016-07-19 22:20:31', 'bahan 2', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (9, 'RESTO.INV.00003', 236, 123, '2016-07-19 22:20:31', 'bahan 3', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (10, 'RESTO.INV.00004', 236, 121, '2016-07-19 22:20:31', 'bahan 1', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (11, 'RESTO.INV.00004', 236, 122, '2016-07-19 22:20:31', 'bahan 2', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (12, 'RESTO.INV.00004', 236, 123, '2016-07-19 22:20:31', 'bahan 3', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (13, 'RESTO.INV.00005', 236, 121, '2016-07-19 22:20:31', 'bahan 1', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (14, 'RESTO.INV.00005', 236, 122, '2016-07-19 22:20:31', 'bahan 2', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (15, 'RESTO.INV.00005', 236, 123, '2016-07-19 22:20:31', 'bahan 3', 125, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (19, 'RESTO.INV.00006', 236, 121, '2016-07-19 22:29:06', 'bahan 1', 250, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (20, 'RESTO.INV.00006', 236, 122, '2016-07-19 22:29:06', 'bahan 2', 250, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (21, 'RESTO.INV.00006', 236, 123, '2016-07-19 22:29:06', 'bahan 3', 250, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (22, 'RESTO.INV.00007', 236, 121, '2016-07-19 22:29:29', 'bahan 1', 25, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (23, 'RESTO.INV.00007', 236, 122, '2016-07-19 22:29:29', 'bahan 2', 25, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (24, 'RESTO.INV.00007', 236, 123, '2016-07-19 22:29:29', 'bahan 3', 25, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (25, 'RESTO.INV.00008', 236, 121, '2016-07-19 22:29:58', 'bahan 1', 500, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (26, 'RESTO.INV.00008', 236, 122, '2016-07-19 22:29:58', 'bahan 2', 500, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (27, 'RESTO.INV.00008', 236, 123, '2016-07-19 22:29:58', 'bahan 3', 500, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (28, 'RESTO.INV.00009', 236, 121, '2016-07-19 22:30:33', 'bahan 1', 450, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (29, 'RESTO.INV.00009', 236, 122, '2016-07-19 22:30:33', 'bahan 2', 450, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (30, 'RESTO.INV.00009', 236, 123, '2016-07-19 22:30:33', 'bahan 3', 450, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (31, 'RESTO.INV.00010', 236, 121, '2016-07-19 22:30:55', 'bahan 1', 20, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (32, 'RESTO.INV.00010', 236, 122, '2016-07-19 22:30:55', 'bahan 2', 20, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (33, 'RESTO.INV.00010', 236, 123, '2016-07-19 22:30:55', 'bahan 3', 20, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (34, 'RESTO.INV.00011', 236, 121, '2016-07-19 22:31:07', 'bahan 1', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (35, 'RESTO.INV.00011', 236, 122, '2016-07-19 22:31:07', 'bahan 2', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (36, 'RESTO.INV.00011', 236, 123, '2016-07-19 22:31:07', 'bahan 3', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (37, 'RESTO.INV.00012', 236, 121, '2016-07-19 22:31:17', 'bahan 1', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (38, 'RESTO.INV.00012', 236, 122, '2016-07-19 22:31:17', 'bahan 2', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (39, 'RESTO.INV.00012', 236, 123, '2016-07-19 22:31:18', 'bahan 3', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (40, 'RESTO.INV.00013', 236, 121, '2016-07-19 22:31:29', 'bahan 1', 10, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (41, 'RESTO.INV.00013', 236, 122, '2016-07-19 22:31:29', 'bahan 2', 10, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (42, 'RESTO.INV.00013', 236, 123, '2016-07-19 22:31:29', 'bahan 3', 10, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (43, 'RESTO.INV.00014', 236, 121, '2016-07-19 22:31:40', 'bahan 1', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (44, 'RESTO.INV.00014', 236, 122, '2016-07-19 22:31:40', 'bahan 2', 5, '', 'complete');
INSERT INTO tbl_track_bahan (`id`, `no_nota`, `id_menu`, `id_bahan`, `tgl`, `bahan`, `qty`, `ket`, `status_nota`) VALUES (45, 'RESTO.INV.00014', 236, 123, '2016-07-19 22:31:40', 'bahan 3', 5, '', 'complete');


#
# TABLE STRUCTURE FOR: tbl_trans_opn
#

DROP TABLE IF EXISTS tbl_trans_opn;

CREATE TABLE `tbl_trans_opn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_stok_op` varchar(50) NOT NULL,
  `ket` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO tbl_trans_opn (`id`, `tgl`, `no_stok_op`, `ket`) VALUES (1, '2016-07-18 16:42:51', 'OPBHN.00001', '');


#
# TABLE STRUCTURE FOR: tbl_trans_opn_det
#

DROP TABLE IF EXISTS tbl_trans_opn_det;

CREATE TABLE `tbl_trans_opn_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_stok_op` varchar(50) NOT NULL,
  `bahan` varchar(160) NOT NULL,
  `bahan_sys` varchar(160) NOT NULL,
  `stok_awal` double NOT NULL,
  `stok_awal_sys` double NOT NULL,
  `stok_masuk` double NOT NULL,
  `stok_masuk_sys` double NOT NULL,
  `stok_keluar` double NOT NULL,
  `stok_keluar_sys` double NOT NULL,
  `retur` double NOT NULL,
  `retur_sys` double NOT NULL,
  `rusak` double NOT NULL,
  `rusak_sys` double NOT NULL,
  `total` double NOT NULL,
  `total_sys` double NOT NULL,
  `selisih` double NOT NULL,
  `fisik` double NOT NULL,
  `id_bahan` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

INSERT INTO tbl_trans_opn_det (`id`, `tgl`, `no_stok_op`, `bahan`, `bahan_sys`, `stok_awal`, `stok_awal_sys`, `stok_masuk`, `stok_masuk_sys`, `stok_keluar`, `stok_keluar_sys`, `retur`, `retur_sys`, `rusak`, `rusak_sys`, `total`, `total_sys`, `selisih`, `fisik`, `id_bahan`) VALUES (1, '2016-07-18 16:42:51', 'OPBHN.00001', 'bahan 1', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1000', '0', '1000', '1000', 121);
INSERT INTO tbl_trans_opn_det (`id`, `tgl`, `no_stok_op`, `bahan`, `bahan_sys`, `stok_awal`, `stok_awal_sys`, `stok_masuk`, `stok_masuk_sys`, `stok_keluar`, `stok_keluar_sys`, `retur`, `retur_sys`, `rusak`, `rusak_sys`, `total`, `total_sys`, `selisih`, `fisik`, `id_bahan`) VALUES (2, '2016-07-18 16:42:51', 'OPBHN.00001', 'bahan 2', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1000', '0', '1000', '1000', 122);
INSERT INTO tbl_trans_opn_det (`id`, `tgl`, `no_stok_op`, `bahan`, `bahan_sys`, `stok_awal`, `stok_awal_sys`, `stok_masuk`, `stok_masuk_sys`, `stok_keluar`, `stok_keluar_sys`, `retur`, `retur_sys`, `rusak`, `rusak_sys`, `total`, `total_sys`, `selisih`, `fisik`, `id_bahan`) VALUES (3, '2016-07-18 16:42:51', 'OPBHN.00001', 'bahan 3', '', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1000', '0', '1000', '1000', 123);


#
# TABLE STRUCTURE FOR: tbl_trans_opn_ksr
#

DROP TABLE IF EXISTS tbl_trans_opn_ksr;

CREATE TABLE `tbl_trans_opn_ksr` (
  `no_stok_op` varchar(160) NOT NULL,
  `tgl` datetime NOT NULL,
  `kasir` varchar(160) NOT NULL,
  `id_user` int(11) NOT NULL,
  PRIMARY KEY (`no_stok_op`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_trans_opn_ksr_det
#

DROP TABLE IF EXISTS tbl_trans_opn_ksr_det;

CREATE TABLE `tbl_trans_opn_ksr_det` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `no_stok_op` varchar(160) NOT NULL,
  `id_user` int(11) NOT NULL,
  `kasir` varchar(160) NOT NULL,
  `setor` int(11) NOT NULL,
  `penjualan` int(11) NOT NULL,
  `penjualan_sys` int(11) NOT NULL,
  `selisih` int(32) NOT NULL,
  `fisik` int(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# TABLE STRUCTURE FOR: tbl_util_backup
#

DROP TABLE IF EXISTS tbl_util_backup;

CREATE TABLE `tbl_util_backup` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tgl` timestamp NULL DEFAULT NULL,
  `name` varchar(160) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

INSERT INTO tbl_util_backup (`id`, `tgl`, `name`) VALUES (2, '2016-07-20 09:14:14', 'backup_20160720091414_administrator.zip');


