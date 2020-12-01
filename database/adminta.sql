/*
Navicat MySQL Data Transfer

Source Server         : Local
Source Server Version : 50621
Source Host           : 127.0.0.1:3306
Source Database       : adminta

Target Server Type    : MYSQL
Target Server Version : 50621
File Encoding         : 65001

Date: 2018-12-20 11:23:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tb_quest
-- ----------------------------
DROP TABLE IF EXISTS `tb_quest`;
CREATE TABLE `tb_quest` (
  `quest_id` int(11) NOT NULL,
  `quest_soal` text,
  `quest_a` varchar(5) DEFAULT NULL,
  `quest_b` varchar(5) DEFAULT NULL,
  `quest_c` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_quest
-- ----------------------------
INSERT INTO `tb_quest` VALUES ('1', 'Spanyol ?', '0', '0', '1');
INSERT INTO `tb_quest` VALUES ('2', 'FCB ?', '1', '0', '0');

-- ----------------------------
-- Table structure for tb_user
-- ----------------------------
DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE `tb_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_nama` varchar(100) DEFAULT NULL,
  `user_alamat` text,
  `user_image` varchar(100) DEFAULT NULL,
  `user_deskripsi` text,
  `user_qrcode` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tb_user
-- ----------------------------
INSERT INTO `tb_user` VALUES ('37', 'Oke', 'Oke', 'iLMU.png', '<p>Oke</p>', 'Oke.png');
