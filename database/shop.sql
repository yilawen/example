/*
Navicat MySQL Data Transfer

Source Server         : java
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-12-04 22:36:49
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `adminname` varchar(20) NOT NULL,
  `adminPwd` varchar(20) NOT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'admin');

-- ----------------------------
-- Table structure for item
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `itemid` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` varchar(20) NOT NULL,
  `itemclass` varchar(10) NOT NULL,
  `itemprice` decimal(10,2) NOT NULL,
  `inventory` int(11) NOT NULL,
  `information` varchar(50) DEFAULT NULL,
  `itemimg` varchar(255) DEFAULT NULL,
  `itemflag` enum('hot','recommond','bargains','default') DEFAULT 'default',
  `brand` varchar(20) NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', '黄柠檬', '柠檬', '15.00', '1000', '柠檬味浓 维C宝库 皮薄肉多', 'http://localhost/example/static/images/good/lemon1.jpg', 'default', '尚族果园');
INSERT INTO `item` VALUES ('2', '包邮柠檬绿柠', '柠檬', '20.00', '1000', '新鲜水果 青柠檬 覆保鲜膜', 'http://localhost/example/static/images/good/lemon2.jpg', 'default', '果郡王');
INSERT INTO `item` VALUES ('3', '新奇士柠檬', '柠檬', '15.00', '1000', '酸度适中 富含维C 柠檬酸仓库', 'http://localhost/example/static/images/good/lemon3.jpg', 'default', '果郡王');
INSERT INTO `item` VALUES ('4', '乐高地蕉', '香蕉', '10.00', '1000', '高海拔栽培 生长周期长', 'http://localhost/example/static/images/good/banana1.jpg', 'default', '果郡王');
INSERT INTO `item` VALUES ('5', '软糯香蕉', '香蕉', '10.99', '1000', '香甜软糯 老少皆宜', 'http://localhost/example/static/images/good/banana2.jpg', 'default', '天天果园');
INSERT INTO `item` VALUES ('6', '鲜果香蕉', '香蕉', '20.00', '1000', '甜糯可口 果肉细密', 'http://localhost/example/static/images/good/banana3.jpg', 'default', '佳沛 ');
INSERT INTO `item` VALUES ('7', '三峡红肉橙', '橙子', '20.00', '1000', '香甜多汁 软熟再吃 鲜果季！', 'http://localhost/example/static/images/good/orange1.jpg', 'default', '世外桃源');
INSERT INTO `item` VALUES ('8', '新鲜橙子', '橙子', '10.00', '1000', '精美彩箱 送礼自用皆宜', 'http://localhost/example/static/images/good/orange2.jpg', 'default', '世外桃源');
INSERT INTO `item` VALUES ('9', '绿皮橙子', '橙子', '10.00', '1000', '新鲜水果橙子 5斤 顺丰空运', 'http://localhost/example/static/images/good/orange3.jpg', 'default', '天天果园');
INSERT INTO `item` VALUES ('10', '红心火龙果', '火龙果', '79.00', '1000', '清香软滑 富含花青素', 'http://localhost/example/static/images/good/huolongguo1.jpg', 'default', '红富士');
INSERT INTO `item` VALUES ('11', '红心火龙果5斤', '火龙果', '88.00', '555', '包邮 坏损包赔', '../images/good/huolongguo2.jpg', 'default', '花果山');
INSERT INTO `item` VALUES ('12', '火龙果', '火龙果', '88.00', '1000', '汁多味清甜 富含维生素C ', '../images/good/huolongguo3.jpg', 'default', '红富士');
INSERT INTO `item` VALUES ('13', '猫山王冷冻榴莲果', '榴莲', '258.00', '1000', '店长推荐 2件减10元 原装进口', '../images/good/liulian1.jpg', 'default', '世外桃源');
INSERT INTO `item` VALUES ('14', '金枕头冷冻榴莲', '榴莲', '99.00', '1000', '榴莲果肉 冰爽软绵 口袋即食', '../images/good/liulian2.jpg', 'default', '花果山');
INSERT INTO `item` VALUES ('15', '金枕头榴莲', '榴莲', '139.00', '1000', '香味扑鼻 核小肉多', '../images/good/liulian3.jpg', 'default', '佳沛 ');
INSERT INTO `item` VALUES ('16', '凯特芒果', '芒果', '14.00', '1000', '末期小果 味道巴适得很', '../images/good/mango1.jpg', 'default', '尚族果园');
INSERT INTO `item` VALUES ('17', '大青芒果王 ', '芒果', '45.00', '1000', '本土发货 新鲜现摘', '../images/good/mango2.jpg', 'default', '红富士');
INSERT INTO `item` VALUES ('18', '青皮芒果', '芒果', '55.00', '1000', ' 热带水果 包邮', '../images/good/mango3.jpg', 'default', '天天果园');
INSERT INTO `item` VALUES ('19', '牛油果', '牛油果', '45.00', '1000', '顺丰包邮 送2个发8个', '../images/good/niuyouguo1.jpg', 'default', '世外桃源');
INSERT INTO `item` VALUES ('20', '智利牛油果', '牛油果', '55.00', '1000', '健康辅食 小孩子最爱 皮薄油多', '../images/good/niuyouguo2.jpg', 'default', '佳沛 ');
INSERT INTO `item` VALUES ('21', '巨无霸牛油果', '牛油果', '77.00', '1000', '更大更好吃', '../images/good/niuyouguo3.jpg', 'default', '尚族果园');
INSERT INTO `item` VALUES ('22', '新西兰绿奇异果', '奇异果', '79.00', '1000', '百年佳沛 口感清新', '../images/good/qiyiguo1.jpg', 'default', '佳沛 ');
INSERT INTO `item` VALUES ('23', '阳光金奇异果', '奇异果', '55.00', '1000', '水润香甜 官方品质', '../images/good/qiyiguo2.jpg', 'default', '花果山');
INSERT INTO `item` VALUES ('24', '绿奇异果', '奇异果', '74.00', '1000', '水润香甜 进口现货水果', '../images/good/qiyiguo3.jpg', 'default', '尚族果园uu');
INSERT INTO `item` VALUES ('25', 'ppp', 'oooo', '123.00', '1000', 'fnjsf', '../images/good/banana1.jpg', 'default', 'iiiii');

-- ----------------------------
-- Table structure for iteminhome
-- ----------------------------
DROP TABLE IF EXISTS `iteminhome`;
CREATE TABLE `iteminhome` (
  `itemid` int(11) NOT NULL,
  `flag` varchar(10) NOT NULL,
  PRIMARY KEY (`itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of iteminhome
-- ----------------------------
INSERT INTO `iteminhome` VALUES ('1', 'bargains');
INSERT INTO `iteminhome` VALUES ('2', 'bargains');
INSERT INTO `iteminhome` VALUES ('3', 'bargains');
INSERT INTO `iteminhome` VALUES ('4', 'hot');
INSERT INTO `iteminhome` VALUES ('5', 'recommend');
INSERT INTO `iteminhome` VALUES ('6', 'bargains');
INSERT INTO `iteminhome` VALUES ('7', 'recommend');
INSERT INTO `iteminhome` VALUES ('8', 'hot');
INSERT INTO `iteminhome` VALUES ('9', 'recommend');
INSERT INTO `iteminhome` VALUES ('10', 'recommend');
INSERT INTO `iteminhome` VALUES ('15', 'hot');
INSERT INTO `iteminhome` VALUES ('16', 'hot');
INSERT INTO `iteminhome` VALUES ('17', 'hot');
INSERT INTO `iteminhome` VALUES ('18', 'hot');
INSERT INTO `iteminhome` VALUES ('19', 'hot');
INSERT INTO `iteminhome` VALUES ('20', 'hot');

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `orderid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `totalPrice` decimal(10,2) NOT NULL,
  `orderaddr` varchar(50) NOT NULL,
  `recipient` varchar(20) NOT NULL,
  `orderphone` varchar(20) NOT NULL,
  `addtime` timestamp NOT NULL,
  PRIMARY KEY (`orderid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES ('1', '1', '35.00', '华南农业大学', 'boss', '123456789', '2015-12-27 10:01:21');
INSERT INTO `order` VALUES ('2', '4', '220.00', '华农', 'user123', '123456789', '2015-12-28 09:42:45');

-- ----------------------------
-- Table structure for orderdetail
-- ----------------------------
DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE `orderdetail` (
  `orderid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`orderid`,`itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of orderdetail
-- ----------------------------
INSERT INTO `orderdetail` VALUES ('1', '3', '1');
INSERT INTO `orderdetail` VALUES ('1', '6', '1');
INSERT INTO `orderdetail` VALUES ('2', '2', '11');

-- ----------------------------
-- Table structure for shopcar
-- ----------------------------
DROP TABLE IF EXISTS `shopcar`;
CREATE TABLE `shopcar` (
  `userid` int(11) NOT NULL DEFAULT '0',
  `itemid` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL,
  PRIMARY KEY (`userid`,`itemid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shopcar
-- ----------------------------
INSERT INTO `shopcar` VALUES ('1', '1', '2');
INSERT INTO `shopcar` VALUES ('1', '2', '6');
INSERT INTO `shopcar` VALUES ('1', '6', '5');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `userpwd` varchar(20) NOT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`userid`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'test123', '123123', '12121212', '1');
INSERT INTO `user` VALUES ('2', 'test456', '123456', null, null);
INSERT INTO `user` VALUES ('3', 'lairongsheng', 'sbsbsb', null, null);
INSERT INTO `user` VALUES ('4', 'user123', '123456', '123456789', '华农');
INSERT INTO `user` VALUES ('5', 'test1234', '123456', null, 'awd');
