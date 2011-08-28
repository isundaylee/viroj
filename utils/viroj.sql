/*
 Navicat Premium Data Transfer

 Source Server         : Localhost
 Source Server Type    : MySQL
 Source Server Version : 50515
 Source Host           : localhost
 Source Database       : viroj

 Target Server Type    : MySQL
 Target Server Version : 50515
 File Encoding         : utf-8

 Date: 08/27/2011 23:52:24 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `viroj_ac_submits`
-- ----------------------------
DROP TABLE IF EXISTS `viroj_ac_submits`;
CREATE TABLE `viroj_ac_submits` (
  `sid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `viroj_accounts`
-- ----------------------------
DROP TABLE IF EXISTS `viroj_accounts`;
CREATE TABLE `viroj_accounts` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `username` char(200) NOT NULL,
  `password` char(200) NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `viroj_submits`
-- ----------------------------
DROP TABLE IF EXISTS `viroj_submits`;
CREATE TABLE `viroj_submits` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `type` char(10) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for `viroj_tasks`
-- ----------------------------
DROP TABLE IF EXISTS `viroj_tasks`;
CREATE TABLE `viroj_tasks` (
  `tid` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 NOT NULL,
  `title` text CHARACTER SET utf8 NOT NULL,
  `score` double NOT NULL,
  PRIMARY KEY (`tid`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
