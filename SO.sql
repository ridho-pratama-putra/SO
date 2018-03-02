/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : 127.0.0.1:3306
Source Database       : so

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2018-02-18 10:55:31
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for gejala_log
-- ----------------------------
DROP TABLE IF EXISTS `gejala_log`;
CREATE TABLE `gejala_log` (
  `id_log` int(255) DEFAULT NULL,
  `id_gejala` varchar(255) DEFAULT NULL,
  `nama_gejala` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of gejala_log
-- ----------------------------

-- ----------------------------
-- Table structure for log_pengobatan
-- ----------------------------
DROP TABLE IF EXISTS `log_pengobatan`;
CREATE TABLE `log_pengobatan` (
  `id_log` int(255) NOT NULL,
  `id_user` varchar(11) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_log`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of log_pengobatan
-- ----------------------------

-- ----------------------------
-- Table structure for master_gejala
-- ----------------------------
DROP TABLE IF EXISTS `master_gejala`;
CREATE TABLE `master_gejala` (
  `id_gejala` int(255) DEFAULT NULL,
  `nama_gejala` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_gejala
-- ----------------------------

-- ----------------------------
-- Table structure for master_obat
-- ----------------------------
DROP TABLE IF EXISTS `master_obat`;
CREATE TABLE `master_obat` (
  `id_obat` varchar(255) DEFAULT NULL,
  `nama_obat` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `detail_tipe` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of master_obat
-- ----------------------------

-- ----------------------------
-- Table structure for obat_log
-- ----------------------------
DROP TABLE IF EXISTS `obat_log`;
CREATE TABLE `obat_log` (
  `id_log` int(255) DEFAULT NULL,
  `id_obat` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of obat_log
-- ----------------------------

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id_user` int(255) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(255) DEFAULT NULL,
  `nomor_identitas` varchar(255) DEFAULT NULL,
  `akses` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `link_foto` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `nomor_identitas` (`nomor_identitas`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'ridho', '140535606662', 'admin', 'ccd006fad906912bba0af8d3ded13f99d1d392253117af9689b9e7b58f41b3ed', 'a');
