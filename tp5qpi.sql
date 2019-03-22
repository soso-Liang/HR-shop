/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : tp5api

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-03-22 13:59:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tp_admin
-- ----------------------------
DROP TABLE IF EXISTS `tp_admin`;
CREATE TABLE `tp_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `userName` char(16) NOT NULL COMMENT '用户名',
  `password` char(32) NOT NULL COMMENT '密码',
  `email` char(32) NOT NULL COMMENT '用户邮箱',
  `realName` varchar(50) NOT NULL COMMENT '姓名',
  `phone` char(15) NOT NULL COMMENT '用户手机',
  `img` varchar(255) DEFAULT NULL,
  `regTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `regIp` varchar(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `loginTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `loginIp` varchar(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `isEnabled` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  `groupId` mediumint(8) NOT NULL DEFAULT '0' COMMENT '权限组',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`userName`) USING BTREE,
  KEY `status` (`isEnabled`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COMMENT='管理员用户表';

-- ----------------------------
-- Records of tp_admin
-- ----------------------------
INSERT INTO `tp_admin` VALUES ('1', 'admin', '227af9354aef4e7d4050b1043d5be6b7', '123@163.com', '123', '', 'http://api.hardphp.com/uploads/images/20190322/41ef26c97b94a327562671abd56385a6.jpg', '1498276451', '127.0.0.1', '1553234296', '39.149.12.184', '1553234323', '1', '1');

-- ----------------------------
-- Table structure for tp_app
-- ----------------------------
DROP TABLE IF EXISTS `tp_app`;
CREATE TABLE `tp_app` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `appId` char(18) NOT NULL COMMENT '应用id',
  `appSecret` char(32) DEFAULT NULL COMMENT '应用密钥',
  `title` varchar(150) DEFAULT NULL COMMENT '名称',
  `description` varchar(255) NOT NULL COMMENT '备注',
  `regTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  `regIp` varchar(20) NOT NULL DEFAULT '0' COMMENT '注册IP',
  `loginTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `loginIp` varchar(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `isEnabled` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户状态  0 禁用，1正常',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='app应用表';

-- ----------------------------
-- Records of tp_app
-- ----------------------------
INSERT INTO `tp_app` VALUES ('1', 'ty9fd2848a039ab554', 'ec32286d0718118861afdbf6e401ee81', '管理员端', '', '1498276451', '127.0.0.1', '1521305444', '123.149.208.76', '1514962598', '1');
INSERT INTO `tp_app` VALUES ('2', 'ty9fd2848a039abbbb', 'ec32286d0718118861afdbf6e401ee81', '淘宝客端', '', '1498276451', '127.0.0.1', '1521305444', '123.149.208.76', '1514962598', '1');

-- ----------------------------
-- Table structure for tp_auth_group
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_group`;
CREATE TABLE `tp_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` char(100) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用',
  `rules` text NOT NULL COMMENT '用户组拥有的规则id， 多个规则","隔开',
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of tp_auth_group
-- ----------------------------
INSERT INTO `tp_auth_group` VALUES ('1', '超级管理员', '1', '44,45,41,43,42,39,40,1,38,7,2', '1552300913');
INSERT INTO `tp_auth_group` VALUES ('2', '普通管理员', '1', '1,2', '1542787522');

-- ----------------------------
-- Table structure for tp_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `tp_auth_rule`;
CREATE TABLE `tp_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '为1正常，为0禁用',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 正常，0=禁用',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则表达式，为空表示存在就验证',
  `pid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '上级菜单',
  `sorts` mediumint(8) NOT NULL DEFAULT '0' COMMENT '升序',
  `icon` varchar(50) DEFAULT NULL,
  `updateTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `path` varchar(255) NOT NULL COMMENT '路经',
  `component` varchar(255) NOT NULL COMMENT '组件',
  `hidden` tinyint(1) NOT NULL DEFAULT '0' COMMENT '左侧菜单 0==显示,1隐藏',
  `noCache` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=不缓存，0=缓存',
  `alwaysShow` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1= 总显示,0=否 依据子菜单个数',
  `redirect` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of tp_auth_rule
-- ----------------------------
INSERT INTO `tp_auth_rule` VALUES ('1', 'manage', '权限管理', '1', '1', '', '0', '0', 'component', '1547187800', '/manage', 'layout/Layout', '0', '0', '1', '');
INSERT INTO `tp_auth_rule` VALUES ('2', 'manage/admin', '管理员列表', '1', '1', '', '1', '0', 'user', '1541666364', 'admin', 'manage/admin', '0', '0', '0', '');
INSERT INTO `tp_auth_rule` VALUES ('7', 'manage/rules', '权限列表', '1', '1', '', '1', '0', 'lock', '1542353476', 'rules', 'manage/rules', '0', '0', '0', '');
INSERT INTO `tp_auth_rule` VALUES ('38', 'manage/roles', '角色列表', '1', '1', '', '1', '0', 'list', '1542602805', 'roles', 'manage/roles', '0', '1', '1', '');
INSERT INTO `tp_auth_rule` VALUES ('39', 'log', '日志管理', '1', '1', '', '0', '0', 'component', '1542602916', '/log', 'layout/Layout', '0', '0', '1', '');
INSERT INTO `tp_auth_rule` VALUES ('40', 'log/log', '登陆日志', '1', '1', '', '39', '0', 'list', '1552301777', 'log', 'log/log', '0', '1', '1', '');

-- ----------------------------
-- Table structure for tp_login_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_login_log`;
CREATE TABLE `tp_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `userName` char(16) NOT NULL COMMENT '用户名',
  `loginIp` varchar(20) NOT NULL DEFAULT '0' COMMENT '最后登录IP',
  `loginTime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `roles` varchar(50) NOT NULL DEFAULT '0' COMMENT '角色',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员登录';

-- ----------------------------
-- Records of tp_login_log
-- ----------------------------
INSERT INTO `tp_login_log` VALUES ('1', '1', 'admin', '127.0.0.1', '1553234028', '超级管理员');
INSERT INTO `tp_login_log` VALUES ('2', '1', 'admin', '127.0.0.1', '1553234296', '超级管理员');

-- ----------------------------
-- Table structure for tp_user
-- ----------------------------
DROP TABLE IF EXISTS `tp_user`;
CREATE TABLE `tp_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `openId` varchar(150) DEFAULT NULL COMMENT '微信身份标识',
  `password` char(32) DEFAULT NULL COMMENT '32位小写MD5密码',
  `phone` varchar(30) DEFAULT NULL COMMENT '手机号',
  `userName` varchar(30) DEFAULT NULL COMMENT '用户名',
  `realName` varchar(50) DEFAULT NULL COMMENT '姓名',
  `isEnabled` tinyint(1) DEFAULT '1' COMMENT '是否启用',
  `nickName` varchar(20) DEFAULT NULL COMMENT '用户昵称',
  `img` varchar(255) DEFAULT NULL COMMENT '头像URL',
  `sex` tinyint(1) DEFAULT '0' COMMENT '性别标志：0，其他；1，男；2，女',
  `balance` decimal(10,2) DEFAULT '0.00' COMMENT '账户余额',
  `birth` varchar(50) DEFAULT NULL COMMENT '生日',
  `descript` varchar(200) DEFAULT NULL,
  `totalMoney` decimal(10,2) DEFAULT '0.00' COMMENT '账户总金额',
  `pid` int(10) DEFAULT '0',
  `pid2` int(10) DEFAULT '0',
  `androidChannelId` varchar(100) DEFAULT NULL COMMENT '推送Android终端ID',
  `iosChannelId` varchar(100) DEFAULT NULL COMMENT '推送IOS终端ID',
  `regTime` int(10) DEFAULT NULL COMMENT '注册时间',
  `regIp` varchar(20) DEFAULT NULL COMMENT '注册IP',
  `loginIp` varchar(20) DEFAULT NULL COMMENT 'IP',
  `loginTime` int(10) DEFAULT NULL COMMENT '登录时间',
  `updateTime` int(10) DEFAULT NULL COMMENT '时间',
  `isDel` tinyint(1) DEFAULT '0',
  `adzoneId` varchar(50) DEFAULT NULL COMMENT '淘宝客广告位',
  `isCheck` tinyint(1) DEFAULT '0' COMMENT '0=待审核，1=通过，2=拒绝',
  `level` tinyint(2) DEFAULT '7' COMMENT '代理级别',
  PRIMARY KEY (`id`),
  KEY `phone` (`phone`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='主系统用户表。';

-- ----------------------------
-- Records of tp_user
-- ----------------------------
INSERT INTO `tp_user` VALUES ('1', '', 'ee8512502ab075a1ad969238ca83a15d', '', '12312333', '张三', '1', 'hardphp', 'http://api.hardphp.com/uploads/images/20190108/21b4a8aa748142cd506976ef0f7e1bbb.png', '0', '20210.00', '1989-10-10', '我要给你一个拥抱 给你一双温热手掌', '525225.00', '0', '0', '', '', '1515057952', '123.149.214.69', '', '0', '1553167717', '1', '74735600372', '0', '7');

-- ----------------------------
-- Table structure for tp_user_login_log
-- ----------------------------
DROP TABLE IF EXISTS `tp_user_login_log`;
CREATE TABLE `tp_user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) unsigned DEFAULT NULL COMMENT '用户ID',
  `userName` char(16) DEFAULT NULL COMMENT '用户名',
  `loginIp` varchar(20) DEFAULT '0' COMMENT '最后登录IP',
  `loginTime` int(10) unsigned DEFAULT '0' COMMENT '时间',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='会员登录';

-- ----------------------------
-- Records of tp_user_login_log
-- ----------------------------
INSERT INTO `tp_user_login_log` VALUES ('1', '6', null, '121.199.30.7', '1501656638');
INSERT INTO `tp_user_login_log` VALUES ('2', '6', null, '121.199.30.7', '1501833739');
