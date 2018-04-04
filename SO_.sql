/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : so

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-03-31 12:33:50
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for catatan_obat
-- ----------------------------
DROP TABLE IF EXISTS `catatan_obat`;
CREATE TABLE `catatan_obat` (
  `id_catatan` int(255) NOT NULL AUTO_INCREMENT,
  `id_obat` int(11) DEFAULT NULL,
  `catatan` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_catatan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of catatan_obat
-- ----------------------------

-- ----------------------------
-- Table structure for gejala_log
-- ----------------------------
DROP TABLE IF EXISTS `gejala_log`;
CREATE TABLE `gejala_log` (
  `id_log_gejala` int(255) NOT NULL AUTO_INCREMENT,
  `id_log` int(11) DEFAULT NULL,
  `id_gejala` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_log_gejala`),
  KEY `id_gejala_log` (`id_log`),
  KEY `id_gejala_gejala` (`id_gejala`),
  CONSTRAINT `id_gejala_gejala` FOREIGN KEY (`id_gejala`) REFERENCES `master_gejala` (`id_gejala`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_gejala_log` FOREIGN KEY (`id_log`) REFERENCES `log_pengobatan` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gejala_log
-- ----------------------------
INSERT INTO `gejala_log` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for karakteristik_obat
-- ----------------------------
DROP TABLE IF EXISTS `karakteristik_obat`;
CREATE TABLE `karakteristik_obat` (
  `id_karakteristik` int(255) NOT NULL AUTO_INCREMENT,
  `id_obat` int(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `id_tipe_master` varchar(255) DEFAULT NULL COMMENT 'untuk mengurangi inner join ;D',
  `detail_tipe` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_karakteristik`),
  KEY `nama_obat` (`id_obat`),
  CONSTRAINT `nama_obat` FOREIGN KEY (`id_obat`) REFERENCES `master_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of karakteristik_obat
-- ----------------------------
INSERT INTO `karakteristik_obat` VALUES ('7', '3', 'indikasi', '3', 'b');
INSERT INTO `karakteristik_obat` VALUES ('8', '4', 'indikasi', '1', 'a');
INSERT INTO `karakteristik_obat` VALUES ('9', '4', 'indikasi', '3', 'b');
INSERT INTO `karakteristik_obat` VALUES ('12', '4', 'kontraindikasi', '1', 'l');
INSERT INTO `karakteristik_obat` VALUES ('13', '4', 'kontraindikasi', '3', 'h');
INSERT INTO `karakteristik_obat` VALUES ('14', '3', 'peringatan', '4', 'k');
INSERT INTO `karakteristik_obat` VALUES ('15', '4', 'peringatan', '5', 'f');
INSERT INTO `karakteristik_obat` VALUES ('18', '3', 'indikasi', '5', 'p');
INSERT INTO `karakteristik_obat` VALUES ('19', '3', 'kontraindikasi', '4', 'k');
INSERT INTO `karakteristik_obat` VALUES ('20', '3', 'kontraindikasi', '2', 'r');
INSERT INTO `karakteristik_obat` VALUES ('21', '3', 'kontraindikasi', '6', 'e');
INSERT INTO `karakteristik_obat` VALUES ('22', '3', 'kontraindikasi', '1', 'l');

-- ----------------------------
-- Table structure for kondisi
-- ----------------------------
DROP TABLE IF EXISTS `kondisi`;
CREATE TABLE `kondisi` (
  `id_kondisi` int(255) NOT NULL AUTO_INCREMENT,
  `id_user` int(255) DEFAULT NULL,
  `id_master_kondisi` int(11) DEFAULT NULL,
  `detail_kondisi` varchar(255) DEFAULT NULL,
  `tanggal_ditambahkan` date DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_kondisi`),
  KEY `id_user_kondisi` (`id_user`),
  KEY `id_master_kondisi` (`id_master_kondisi`),
  KEY `detail_kondisi` (`detail_kondisi`),
  CONSTRAINT `detail_kondisi` FOREIGN KEY (`detail_kondisi`) REFERENCES `master_kondisi` (`detail_kondisi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_master_kondisi` FOREIGN KEY (`id_master_kondisi`) REFERENCES `master_kondisi` (`id_master_kondisi`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_user_kondisi` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of kondisi
-- ----------------------------
INSERT INTO `kondisi` VALUES ('1', '9', '5', 'f', '2018-03-29', '0');
INSERT INTO `kondisi` VALUES ('2', '9', '3', 'h', '2018-03-29', '1');
INSERT INTO `kondisi` VALUES ('3', '9', '4', 'k', '2018-03-29', '1');
INSERT INTO `kondisi` VALUES ('4', '9', '6', 'e', '2018-03-29', '1');
INSERT INTO `kondisi` VALUES ('5', '9', '2', 'r', '2018-03-29', '1');
INSERT INTO `kondisi` VALUES ('6', '9', '1', 'l', '2018-03-29', '0');

-- ----------------------------
-- Table structure for log_pengobatan
-- ----------------------------
DROP TABLE IF EXISTS `log_pengobatan`;
CREATE TABLE `log_pengobatan` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`id_log`),
  KEY `id_user_log` (`id_user`),
  CONSTRAINT `id_user_log` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log_pengobatan
-- ----------------------------
INSERT INTO `log_pengobatan` VALUES ('1', '9', '2018-03-12');
INSERT INTO `log_pengobatan` VALUES ('2', '9', '2018-03-27');

-- ----------------------------
-- Table structure for master_gejala
-- ----------------------------
DROP TABLE IF EXISTS `master_gejala`;
CREATE TABLE `master_gejala` (
  `id_gejala` int(255) NOT NULL AUTO_INCREMENT,
  `detail_gejala` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_gejala`),
  UNIQUE KEY `nama_gejala` (`detail_gejala`) USING BTREE,
  KEY `id_gejala` (`id_gejala`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_gejala
-- ----------------------------
INSERT INTO `master_gejala` VALUES ('1', 'a');
INSERT INTO `master_gejala` VALUES ('3', 'b');
INSERT INTO `master_gejala` VALUES ('5', 'p');

-- ----------------------------
-- Table structure for master_kondisi
-- ----------------------------
DROP TABLE IF EXISTS `master_kondisi`;
CREATE TABLE `master_kondisi` (
  `id_master_kondisi` int(255) NOT NULL AUTO_INCREMENT,
  `detail_kondisi` varchar(255) NOT NULL,
  PRIMARY KEY (`id_master_kondisi`),
  UNIQUE KEY `detail_kondisi_unik` (`detail_kondisi`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_kondisi
-- ----------------------------
INSERT INTO `master_kondisi` VALUES ('6', 'e');
INSERT INTO `master_kondisi` VALUES ('5', 'f');
INSERT INTO `master_kondisi` VALUES ('3', 'h');
INSERT INTO `master_kondisi` VALUES ('4', 'k');
INSERT INTO `master_kondisi` VALUES ('1', 'l');
INSERT INTO `master_kondisi` VALUES ('2', 'r');

-- ----------------------------
-- Table structure for master_obat
-- ----------------------------
DROP TABLE IF EXISTS `master_obat`;
CREATE TABLE `master_obat` (
  `id_obat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_obat` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_obat`),
  UNIQUE KEY `nama_obat` (`nama_obat`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_obat
-- ----------------------------
INSERT INTO `master_obat` VALUES ('3', 'A');
INSERT INTO `master_obat` VALUES ('4', 'B');
INSERT INTO `master_obat` VALUES ('5', 'C');

-- ----------------------------
-- Table structure for obat_log
-- ----------------------------
DROP TABLE IF EXISTS `obat_log`;
CREATE TABLE `obat_log` (
  `id_log_obat` int(11) NOT NULL AUTO_INCREMENT,
  `id_log` int(255) DEFAULT NULL,
  `id_obat` int(255) DEFAULT NULL,
  `hash` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_log_obat`),
  KEY `id_obat_obat` (`id_obat`),
  KEY `id_obat_log` (`id_log`),
  CONSTRAINT `id_obat_log` FOREIGN KEY (`id_log`) REFERENCES `log_pengobatan` (`id_log`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `id_obat_obat` FOREIGN KEY (`id_obat`) REFERENCES `master_obat` (`id_obat`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of obat_log
-- ----------------------------
INSERT INTO `obat_log` VALUES ('1', '1', '3', null);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(255) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) DEFAULT NULL,
  `nomor_identitas` varchar(255) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `akses` varchar(255) DEFAULT NULL,
  `no_hp` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `link_foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nomor_identitas` (`nomor_identitas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'ridho', '140535606662', null, null, 'admin', null, 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'a');
INSERT INTO `user` VALUES ('3', 'abdula', '140535606663', null, 'jalan mawar 45 malang', 'ppk', '085855858914', 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'assets/images/users_photo/40dbd846001087_586632e0df7741.png');
INSERT INTO `user` VALUES ('9', 'pasien1', '140535606669', null, 'jalan mawar 45 malang', 'pasien', '085855858914', 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'assets/images/users_photo/13528862_1039283519487891_4638299120502362364_n1.jpg');
INSERT INTO `user` VALUES ('10', 'user3', '1405356066610', null, 'jalan mawar 45 malang', 'pasien', '085855858914', 'db052c8066385d54dc1aa02c83ea6cf658a465b5e2f63bfffc5c79ac1dbe8447', 'assets/images/users_photo/97fdd8c53c4216cd793b794de5b1e73c1.jpg');

-- ----------------------------
-- Table structure for wm_gejala
-- ----------------------------
DROP TABLE IF EXISTS `wm_gejala`;
CREATE TABLE `wm_gejala` (
  `id_wm` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `id_gejala` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wm_gejala
-- ----------------------------

-- ----------------------------
-- Table structure for wm_kondisi
-- ----------------------------
DROP TABLE IF EXISTS `wm_kondisi`;
CREATE TABLE `wm_kondisi` (
  `id_wm_kondisi` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `id_kondisi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wm_kondisi
-- ----------------------------

-- ----------------------------
-- Table structure for wm_obat
-- ----------------------------
DROP TABLE IF EXISTS `wm_obat`;
CREATE TABLE `wm_obat` (
  `id_wm_obat` varchar(255) DEFAULT NULL,
  `id_user` varchar(255) DEFAULT NULL,
  `id_obat` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wm_obat
-- ----------------------------
