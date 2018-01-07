/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2016-07-01 17:43:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Mysql Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`(`uid` SERIAL PRIMARY KEY,`username` varchar(50) NOT NULL,`password` varchar(50) NOT NULL,
	PRIMARY KEY (`uid`),UNIQUE KEY `username` (`username`))ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

INSERT INTO `users` VALUES ('1', 'sgsadvance', 'dc0e1aba0de3e75c5098866e701ea46a');

-- ----------------------------
-- PostgreSQL Records of users SERIAL PRIMARY KEY
-- ----------------------------
INSERT INTO users VALUES ('1', 'sgsadvance', 'dc0e1aba0de3e75c5098866e701ea46a');

CREATE TABLE users("uid" SERIAL PRIMARY KEY,"username" varchar(50) NOT NULL,"password" varchar(50) NOT NULL);
MD5 hash for sgsadvance is : dc0e1aba0de3e75c5098866e701ea46a

-- for SGS INSERT INTO users VALUES ('sgsadvance', '4bc8028fad044f9398d0c6f5c56e1887');