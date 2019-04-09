/*
Navicat MySQL Data Transfer

Source Server         : 60.205.200.55
Source Server Version : 50560
Source Host           : 60.205.200.55:6666
Source Database       : service

Target Server Type    : MYSQL
Target Server Version : 50560
File Encoding         : 65001

Date: 2019-04-09 23:43:35
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for config_authentications
-- ----------------------------
DROP TABLE IF EXISTS `config_authentications`;
CREATE TABLE `config_authentications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_authentications
-- ----------------------------
INSERT INTO `config_authentications` VALUES ('1', '认证通过（已培训）', 'enable', '0');
INSERT INTO `config_authentications` VALUES ('2', '未完成认证（未听课）', 'enable', '0');

-- ----------------------------
-- Table structure for config_courses
-- ----------------------------
DROP TABLE IF EXISTS `config_courses`;
CREATE TABLE `config_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_courses
-- ----------------------------
INSERT INTO `config_courses` VALUES ('1', '养老护理', '0', 'enable');
INSERT INTO `config_courses` VALUES ('2', '育儿', '0', 'enable');
INSERT INTO `config_courses` VALUES ('3', '月嫂', '0', 'enable');
INSERT INTO `config_courses` VALUES ('4', '中餐', '0', 'enable');
INSERT INTO `config_courses` VALUES ('5', '保洁', '0', 'enable');
INSERT INTO `config_courses` VALUES ('6', '菲佣', '0', 'enable');
INSERT INTO `config_courses` VALUES ('7', '辅食制作', '0', 'enable');

-- ----------------------------
-- Table structure for config_paper_categories
-- ----------------------------
DROP TABLE IF EXISTS `config_paper_categories`;
CREATE TABLE `config_paper_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COMMENT='证件类型表';

-- ----------------------------
-- Records of config_paper_categories
-- ----------------------------
INSERT INTO `config_paper_categories` VALUES ('1', '护工证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('2', '厨师证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('3', '幼师', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('4', '教师', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('5', '面点师证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('6', '初级家政服务员', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('7', '高级家政服务员', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('8', '中级家政服务员', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('9', '月嫂证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('10', '母婴护理员', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('11', '母婴护理师', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('12', '育儿嫂证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('13', '初级育婴员', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('14', '中级育婴师', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('15', '高级育婴师', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('16', '高级催乳师证书', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('17', '高级母婴护理师', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('18', '按摩师证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('19', '驾驶证', '0', 'enable');
INSERT INTO `config_paper_categories` VALUES ('20', '营养师证', '0', 'enable');

-- ----------------------------
-- Table structure for config_service_categories
-- ----------------------------
DROP TABLE IF EXISTS `config_service_categories`;
CREATE TABLE `config_service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='项目分类';

-- ----------------------------
-- Records of config_service_categories
-- ----------------------------
INSERT INTO `config_service_categories` VALUES ('1', '小时工', '0', 'enable');
INSERT INTO `config_service_categories` VALUES ('2', '保姆', '0', 'enable');
INSERT INTO `config_service_categories` VALUES ('3', '月嫂', '0', 'enable');
INSERT INTO `config_service_categories` VALUES ('4', '育儿嫂', '0', 'enable');
INSERT INTO `config_service_categories` VALUES ('5', '育婴师', '0', 'enable');
INSERT INTO `config_service_categories` VALUES ('6', '护工', '0', 'enable');

-- ----------------------------
-- Table structure for config_service_crowds
-- ----------------------------
DROP TABLE IF EXISTS `config_service_crowds`;
CREATE TABLE `config_service_crowds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_service_crowds
-- ----------------------------
INSERT INTO `config_service_crowds` VALUES ('1', '打扫卫生', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('2', '只做饭', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('3', '做饭+打扫卫生', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('4', '照顾0-1岁宝宝', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('5', '照顾1-3岁宝宝', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('6', '接孩子', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('7', '自理老人', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('8', '半自理老人', '0', 'enable');
INSERT INTO `config_service_crowds` VALUES ('9', '不自理老人', '0', 'enable');

-- ----------------------------
-- Table structure for config_service_regions
-- ----------------------------
DROP TABLE IF EXISTS `config_service_regions`;
CREATE TABLE `config_service_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_service_regions
-- ----------------------------
INSERT INTO `config_service_regions` VALUES ('1', '沈河区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('2', '大东区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('3', '和平区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('4', '铁西区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('5', '皇姑区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('6', '于洪北', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('7', '沈北新区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('8', '于洪广场', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('9', '东陵区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('10', '浑南新区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('11', '长白', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('12', '苏家屯', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('13', '住家', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('14', '于洪南', '0', 'enable');

-- ----------------------------
-- Table structure for config_service_types
-- ----------------------------
DROP TABLE IF EXISTS `config_service_types`;
CREATE TABLE `config_service_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_service_types
-- ----------------------------
INSERT INTO `config_service_types` VALUES ('1', '住家', '0', 'enable');
INSERT INTO `config_service_types` VALUES ('2', '不住家', '0', 'enable');

-- ----------------------------
-- Table structure for config_sources
-- ----------------------------
DROP TABLE IF EXISTS `config_sources`;
CREATE TABLE `config_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_sources
-- ----------------------------
INSERT INTO `config_sources` VALUES ('1', '转介绍', '0', 'enable');
INSERT INTO `config_sources` VALUES ('2', '网络', '0', 'enable');
INSERT INTO `config_sources` VALUES ('3', '员工', '0', 'enable');
INSERT INTO `config_sources` VALUES ('4', '合作家政-笑笑家政', '0', 'enable');

-- ----------------------------
-- Table structure for config_working_ages
-- ----------------------------
DROP TABLE IF EXISTS `config_working_ages`;
CREATE TABLE `config_working_ages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_working_ages
-- ----------------------------
INSERT INTO `config_working_ages` VALUES ('1', '0-1年', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('2', '1-3年', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('3', '3-5年', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('4', '5-10年', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('5', '10年以上', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('6', '0', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('7', '0.5', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('8', '1', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('9', '1.5', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('10', '2', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('11', '2.5', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('12', '3', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('13', '4', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('14', '5', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('15', '6', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('16', '7', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('17', '8', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('18', '9', '0', 'enable');
INSERT INTO `config_working_ages` VALUES ('19', '10', '0', 'enable');

-- ----------------------------
-- Table structure for config_working_status
-- ----------------------------
DROP TABLE IF EXISTS `config_working_status`;
CREATE TABLE `config_working_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_working_status
-- ----------------------------
INSERT INTO `config_working_status` VALUES ('1', '可接单', '0', 'enable');
INSERT INTO `config_working_status` VALUES ('2', '暂不接单', '0', 'enable');
INSERT INTO `config_working_status` VALUES ('3', '更改行业', '0', 'enable');
INSERT INTO `config_working_status` VALUES ('4', '已上户（非365）', '0', 'enable');
INSERT INTO `config_working_status` VALUES ('5', '已上户', '0', 'enable');

-- ----------------------------
-- Table structure for managers
-- ----------------------------
DROP TABLE IF EXISTS `managers`;
CREATE TABLE `managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(40) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员名',
  `access_token` varchar(64) NOT NULL DEFAULT '' COMMENT '验证令牌',
  `refresh_token` varchar(64) NOT NULL DEFAULT '' COMMENT '刷新令牌',
  `expire` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否为超级管理员0：全部， 1：否，2:是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `account` (`account`) USING BTREE COMMENT '唯一性约束'
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- ----------------------------
-- Records of managers
-- ----------------------------
INSERT INTO `managers` VALUES ('1', 'admin', 'f973988be6cba09855f84c34d10e8a62', '超级管理员', '5a399b62615c8e5dfab3322619155eb9', 'd1b1a63715d1a40c0429ac8d0da1f15d', '1554810394', '2', '0');
INSERT INTO `managers` VALUES ('2', 'tangchao', 'b60510d71c8d17df14ce7b2c548f716e', '唐朝', '323744f9d31a098d3e3fe893f7ed3f5a', '961dc96a3f91846eec95d2b5192caa93', '1554902157', '1', '0');
INSERT INTO `managers` VALUES ('3', 'songxiwen', 'bcc7e1dd92254ef41b2abd8fc453fbb3', '宋希文', 'd75524a9c78ced1ab5438b67d77c0760', 'c87eed5be45954d07566e9e82c4da2f5', '1554903304', '1', '0');
INSERT INTO `managers` VALUES ('4', 'ceshi', 'ffbe652d18da6fa42f2f346c68ecf1d3', '测试', 'bd820fb910768ddc1a5e2104c2d02533', 'dad984d7cfbea13b947f438fee2a20df', '1553877173', '1', '1');
INSERT INTO `managers` VALUES ('5', 'test1', '46f4feb11b79f842a13080ae542de180', '测试账户', 'c4a0221c7364b6adb4a503b447b2e6db', 'f7908664ab9f6743302161f8502fee24', '1554810428', '1', '0');

-- ----------------------------
-- Table structure for order_files
-- ----------------------------
DROP TABLE IF EXISTS `order_files`;
CREATE TABLE `order_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '文件名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='订单合同文件';

-- ----------------------------
-- Records of order_files
-- ----------------------------
INSERT INTO `order_files` VALUES ('1', '3', 'picture.jpeg', 'temp/5dec487a0ef981b51cadd4a83fd30842.jpeg');
INSERT INTO `order_files` VALUES ('2', '5', '列表.jpg', 'order/1/d767588d304c265fe1bb5473965321b2.jpg');
INSERT INTO `order_files` VALUES ('3', '5', '轮播1.jpg', 'order/1/1f1e6a5dbfd892fbaebe8c1bc46a1ae1.jpg');
INSERT INTO `order_files` VALUES ('4', '5', '轮播2.jpg', 'order/1/1c130fa38d50413ad4f248fae1fe0fbc.jpg');

-- ----------------------------
-- Table structure for order_logs
-- ----------------------------
DROP TABLE IF EXISTS `order_logs`;
CREATE TABLE `order_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `manager_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员名',
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `staff_name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务人员姓名',
  `message` varchar(200) NOT NULL DEFAULT '' COMMENT '日志信息',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `type` enum('','sign','normal','assign','other') NOT NULL DEFAULT '' COMMENT '日志分类',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='订单日志';

-- ----------------------------
-- Records of order_logs
-- ----------------------------
INSERT INTO `order_logs` VALUES ('1', '1', '3', '宋希文', '0', '无', '管理员派单，原持有者：1|超级管理员=>现持有者：2|唐朝', '1553773913', 'assign');
INSERT INTO `order_logs` VALUES ('2', '1', '2', '唐朝', '1', '宋希文', '因为这位服务人员不能掌握雇主的全部需求，切不能长期住家。', '1553773976', 'sign');
INSERT INTO `order_logs` VALUES ('3', '1', '1', '超级管理员', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：1|超级管理员', '1553774295', 'assign');
INSERT INTO `order_logs` VALUES ('4', '1', '2', '唐朝', '2', '弗兰克', '订单已签约，操作者：2|唐朝', '1553774379', 'sign');
INSERT INTO `order_logs` VALUES ('5', '1', '1', '超级管理员', '0', '无', '管理员派单，原持有者：1|超级管理员=>现持有者：1|超级管理员', '1553775089', 'assign');
INSERT INTO `order_logs` VALUES ('6', '1', '1', '超级管理员', '0', '无', '管理员派单，原持有者：1|超级管理员=>现持有者：2|唐朝', '1553775131', 'assign');
INSERT INTO `order_logs` VALUES ('7', '2', '2', '唐朝', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：3|宋希文', '1553775431', 'assign');
INSERT INTO `order_logs` VALUES ('8', '2', '2', '唐朝', '0', '无', '管理员派单，原持有者：3|宋希文=>现持有者：2|唐朝', '1553775447', 'assign');
INSERT INTO `order_logs` VALUES ('9', '2', '2', '唐朝', '1', '宋希文', '订单已签约，操作者：2|唐朝', '1553775719', 'sign');
INSERT INTO `order_logs` VALUES ('10', '3', '1', '超级管理员', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：1|超级管理员', '1553776089', 'assign');
INSERT INTO `order_logs` VALUES ('11', '1', '2', '唐朝', '0', '无', '非常好', '1553782960', 'normal');
INSERT INTO `order_logs` VALUES ('12', '3', '1', '超级管理员', '2', '弗兰克', '订单已签约，操作者：1|超级管理员', '1553785438', 'sign');
INSERT INTO `order_logs` VALUES ('13', '4', '1', '超级管理员', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：1|超级管理员', '1553787584', 'assign');
INSERT INTO `order_logs` VALUES ('14', '5', '2', '唐朝', '1', '宋希文', '订单已签约，操作者：2|唐朝', '1553820235', 'sign');
INSERT INTO `order_logs` VALUES ('15', '5', '3', '宋希文', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：3|宋希文', '1553821879', 'assign');
INSERT INTO `order_logs` VALUES ('16', '1', '5', '测试账户1', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：5|测试账户1', '1553826408', 'assign');
INSERT INTO `order_logs` VALUES ('17', '5', '5', '测试账户1', '0', '无', '管理员派单，原持有者：3|宋希文=>现持有者：5|测试账户1', '1553826429', 'assign');
INSERT INTO `order_logs` VALUES ('18', '6', '5', '测试账户-冯蜀笑', '0', '无', '管理员派单，原持有者：5|测试账户-冯蜀笑=>现持有者：3|宋希文', '1553830018', 'assign');
INSERT INTO `order_logs` VALUES ('19', '6', '5', '测试账户-冯蜀笑', '0', '无', '管理员派单，原持有者：3|宋希文=>现持有者：3|宋希文', '1553830026', 'assign');
INSERT INTO `order_logs` VALUES ('20', '5', '2', '唐朝', '0', '无', '管理员派单，原持有者：5|测试账户1=>现持有者：2|唐朝', '1553857620', 'assign');
INSERT INTO `order_logs` VALUES ('21', '3', '3', '宋希文', '0', '无', '管理员派单，原持有者：1|超级管理员=>现持有者：3|宋希文', '1553858961', 'assign');
INSERT INTO `order_logs` VALUES ('22', '5', '3', '宋希文', '0', '无', '管理员派单，原持有者：2|唐朝=>现持有者：3|宋希文', '1553859828', 'assign');
INSERT INTO `order_logs` VALUES ('23', '4', '2', '唐朝', '0', '无', '管理员派单，原持有者：1|超级管理员=>现持有者：2|唐朝', '1553861503', 'assign');

-- ----------------------------
-- Table structure for order_staff
-- ----------------------------
DROP TABLE IF EXISTS `order_staff`;
CREATE TABLE `order_staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '订单id',
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `staff_code` varchar(10) NOT NULL DEFAULT '' COMMENT '员工编号',
  `staff_name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务人员名',
  `type` enum('','unsign','sign','refuse') NOT NULL DEFAULT 'unsign' COMMENT '签约状态，未签约，已签约，已拒绝',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COMMENT='订单匹配人员';

-- ----------------------------
-- Records of order_staff
-- ----------------------------
INSERT INTO `order_staff` VALUES ('1', '1', '1', '', '宋希文', 'unsign');
INSERT INTO `order_staff` VALUES ('2', '1', '1', '', '宋希文', 'refuse');
INSERT INTO `order_staff` VALUES ('3', '1', '2', '', '弗兰克', 'sign');
INSERT INTO `order_staff` VALUES ('4', '1', '1', '', '宋希文', 'unsign');
INSERT INTO `order_staff` VALUES ('5', '2', '1', '', '宋希文', 'sign');
INSERT INTO `order_staff` VALUES ('9', '3', '2', '', '弗兰克', 'sign');
INSERT INTO `order_staff` VALUES ('11', '4', '2', '00002', '弗兰克', 'unsign');
INSERT INTO `order_staff` VALUES ('12', '5', '1', '00001', '宋希文', 'sign');
INSERT INTO `order_staff` VALUES ('13', '6', '1', '00001', '宋希文', 'unsign');
INSERT INTO `order_staff` VALUES ('14', '7', '1', '00001', '宋希文', 'unsign');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '订单号',
  `create_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建人id',
  `create_manager_name` varchar(20) NOT NULL DEFAULT '' COMMENT '创建人姓名',
  `hold_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '持有人id',
  `hold_manager_name` varchar(20) NOT NULL DEFAULT '' COMMENT '持有人姓名',
  `sign_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '签约人id',
  `sign_manager_name` varchar(20) NOT NULL DEFAULT '' COMMENT '签约人姓名',
  `maintain_manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '维护人id',
  `maintain_manager_name` varchar(20) NOT NULL DEFAULT '' COMMENT '维护人姓名',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_name` varchar(20) NOT NULL DEFAULT '' COMMENT '用户姓名',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '用户手机号',
  `service_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务内容id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '服务项目名',
  `service_address` varchar(200) NOT NULL DEFAULT '' COMMENT '服务地址',
  `service_start_time` int(11) NOT NULL DEFAULT '0' COMMENT '服务开始时间',
  `service_end_time` int(11) NOT NULL DEFAULT '0' COMMENT '服务结束时间',
  `source` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单来源 0：全部，1：线下，2：线上，3：渠道',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '审核备注',
  `unit` enum('','time','hour','day','month') NOT NULL DEFAULT '' COMMENT '服务周期单位',
  `service_count` int(11) NOT NULL DEFAULT '0' COMMENT '服务次数',
  `unit_price` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '单价',
  `total_price` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '总价',
  `pay_wage` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否支付工资 0：全部，1：不支付，2：支付',
  `wage_count` tinyint(1) NOT NULL DEFAULT '0' COMMENT '发工资次数',
  `wage_price` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '工资金额',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '订单类型 0：全部 ，1：待匹配，2：已匹配，3：已签约，4：已取消，5：订单完成',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `code` (`code`) USING BTREE COMMENT '订单号唯一性约束'
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单表';

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '2019032884460000001', '1', '超级管理员', '5', '测试账户1', '2', '唐朝', '0', '', '8', '宁敬之', '15001279361', '2', '空调清洗', '辽宁省沈阳市铁西区云峰北街勋望小学1年3班', '1551744000', '1551758400', '1', '此订单来自于线下。由于是学校订单，请注意保持安静，请处理人员小心，妥善处理。', 'month', '3', '23.56', '70.68', '2', '3', '44.33', '5', '1553770978', '4');
INSERT INTO `orders` VALUES ('2', '2019032853360000002', '2', '唐朝', '2', '唐朝', '2', '唐朝', '0', '', '11', '王女士', '13899977894', '16', '小儿推拿', '辽宁省沈阳市铁西区某某路某某小区4-4-1', '1553835600', '1556625600', '3', '要长得帅的', 'day', '4', '23.55', '94.20', '2', '3', '33.00', '3', '1553775416', '3');
INSERT INTO `orders` VALUES ('3', '2019032820710000003', '2', '唐朝', '3', '宋希文', '1', '超级管理员', '0', '', '12', '测试', '13333443434', '11', '开保险柜', '辽宁省沈阳市和平区测试测试', '1552492800', '1555257600', '2', '测试测试', 'day', '3', '500.00', '1500.00', '1', '0', '0.00', '3', '1553775896', '3');
INSERT INTO `orders` VALUES ('4', '2019032868170000004', '2', '唐朝', '2', '唐朝', '0', '', '0', '', '13', '测试测试', '13333333333', '11', '开保险柜', '辽宁省大连市西岗区测试', '1552492800', '1556035200', '2', '测试', '', '0', '0.00', '0.00', '1', '0', '0.00', '2', '1553783623', '2');
INSERT INTO `orders` VALUES ('5', '2019032977790000005', '2', '唐朝', '3', '宋希文', '2', '唐朝', '0', '', '13', '测试', '13333333333', '3', '冰箱清洗', '辽宁省沈阳市市辖区测试测试', '1552579200', '1555344000', '2', '测试', 'day', '4', '445.00', '1780.00', '2', '2', '333.00', '3', '1553788839', '5');
INSERT INTO `orders` VALUES ('6', '2019032906130000006', '5', '测试账户-冯蜀笑', '3', '宋希文', '0', '', '0', '', '14', '张', '13002466170', '2', '空调清洗', '辽宁省沈阳市和平区东北大学', '1551715200', '1551715200', '2', '', '', '0', '0.00', '0.00', '1', '0', '0.00', '2', '1553829786', '2');
INSERT INTO `orders` VALUES ('7', '2019032903850000007', '5', '测试账户-冯蜀笑', '5', '测试账户-冯蜀笑', '0', '', '0', '', '15', '王', '13002466177', '2', '空调清洗', '辽宁省鞍山市铁西区千山', '1553788920', '1553789040', '2', '', '', '0', '0.00', '0.00', '1', '0', '0.00', '2', '1553830246', '0');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限角色关联表';

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '2', '1');
INSERT INTO `permission_role` VALUES ('2', '3', '1');
INSERT INTO `permission_role` VALUES ('3', '4', '1');
INSERT INTO `permission_role` VALUES ('4', '6', '1');
INSERT INTO `permission_role` VALUES ('5', '5', '1');
INSERT INTO `permission_role` VALUES ('6', '1', '1');
INSERT INTO `permission_role` VALUES ('7', '7', '1');
INSERT INTO `permission_role` VALUES ('8', '8', '1');
INSERT INTO `permission_role` VALUES ('9', '9', '1');
INSERT INTO `permission_role` VALUES ('19', '10', '1');
INSERT INTO `permission_role` VALUES ('21', '11', '1');
INSERT INTO `permission_role` VALUES ('23', '13', '1');
INSERT INTO `permission_role` VALUES ('24', '14', '1');
INSERT INTO `permission_role` VALUES ('25', '13', '2');
INSERT INTO `permission_role` VALUES ('26', '14', '2');
INSERT INTO `permission_role` VALUES ('27', '11', '3');
INSERT INTO `permission_role` VALUES ('29', '10', '2');
INSERT INTO `permission_role` VALUES ('30', '10', '3');
INSERT INTO `permission_role` VALUES ('38', '22', '1');
INSERT INTO `permission_role` VALUES ('39', '23', '1');
INSERT INTO `permission_role` VALUES ('40', '24', '1');
INSERT INTO `permission_role` VALUES ('41', '13', '4');
INSERT INTO `permission_role` VALUES ('42', '14', '4');
INSERT INTO `permission_role` VALUES ('43', '22', '4');
INSERT INTO `permission_role` VALUES ('44', '23', '4');
INSERT INTO `permission_role` VALUES ('45', '24', '4');
INSERT INTO `permission_role` VALUES ('46', '22', '2');
INSERT INTO `permission_role` VALUES ('47', '23', '2');
INSERT INTO `permission_role` VALUES ('55', '10', '4');
INSERT INTO `permission_role` VALUES ('62', '10', '7');
INSERT INTO `permission_role` VALUES ('63', '11', '7');
INSERT INTO `permission_role` VALUES ('72', '28', '1');
INSERT INTO `permission_role` VALUES ('73', '29', '1');
INSERT INTO `permission_role` VALUES ('74', '30', '1');
INSERT INTO `permission_role` VALUES ('75', '31', '1');
INSERT INTO `permission_role` VALUES ('76', '32', '1');
INSERT INTO `permission_role` VALUES ('77', '33', '1');

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `router` varchar(100) NOT NULL DEFAULT '' COMMENT '前端路由',
  `title` varchar(20) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `description` varchar(20) NOT NULL DEFAULT '',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序编号',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `is_display` tinyint(1) NOT NULL DEFAULT '1' COMMENT '菜单是否显示，0：全部，1：显示，2：不显示',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否为超管权限 0：全部，1：否，2：是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权限删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限表';

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', '/auth/roleConfig', '角色权限配置', '角色的配置', '0', '5', '2', '1', '0');
INSERT INTO `permissions` VALUES ('2', '/auth', '权限管理', '权限管理，不能点击', '1', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('3', '/auth/accountList', '账户列表', '账户列表', '0', '2', '1', '1', '0');
INSERT INTO `permissions` VALUES ('4', '/auth/accountEdit', '账户配置', '账户配置，不展示', '0', '3', '2', '1', '0');
INSERT INTO `permissions` VALUES ('5', '/auth/roleList', '角色列表', '角色列表', '1', '2', '1', '1', '0');
INSERT INTO `permissions` VALUES ('6', '/auth/accountConfig', '角色配置', '角色配置', '1', '3', '2', '1', '0');
INSERT INTO `permissions` VALUES ('7', '/auth/roleEdit', '角色编辑', '角色编辑', '1', '5', '2', '1', '0');
INSERT INTO `permissions` VALUES ('8', '/auth/authList', '权限配置', '权限配置', '2', '2', '1', '1', '0');
INSERT INTO `permissions` VALUES ('9', '/auth/authConfig', '权限信息配置', '权限信息配置', '0', '8', '2', '1', '0');
INSERT INTO `permissions` VALUES ('10', '/homePage', '首页', '首页', '0', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('11', '/staff', '服务人员管理', '服务人员管理', '2', '0', '2', '1', '0');
INSERT INTO `permissions` VALUES ('12', '/staff/staffList', '服务人员列表', '服务人员列表', '0', '11', '1', '1', '1');
INSERT INTO `permissions` VALUES ('13', '/sale', '销售管理', '销售管理', '3', '0', '2', '1', '0');
INSERT INTO `permissions` VALUES ('14', '/sale/orderList', '订单列表', '订单列表', '0', '13', '1', '1', '0');
INSERT INTO `permissions` VALUES ('15', '/serviceType/skillList', '技能列表', '技能列表', '1', '11', '1', '1', '1');
INSERT INTO `permissions` VALUES ('16', '/serviceType/skillConfig', '技能配置', '技能配置', '0', '15', '2', '1', '1');
INSERT INTO `permissions` VALUES ('17', '/staff/staffItem', '服务人员配置', '服务人员配置', '0', '12', '2', '1', '1');
INSERT INTO `permissions` VALUES ('18', '/serviceType/paperList', '证书列表', '证书列表', '1', '11', '1', '1', '1');
INSERT INTO `permissions` VALUES ('19', '/serviceType/paperConfig', '证书配置', '证书配置', '2', '18', '2', '1', '1');
INSERT INTO `permissions` VALUES ('20', '/serviceType/abilityList', '能力标签列表', '能力标签列表', '3', '11', '1', '1', '1');
INSERT INTO `permissions` VALUES ('21', '/serviceType/abilityConfig', '能力标签配置', '能力标签配置', '3', '20', '2', '1', '1');
INSERT INTO `permissions` VALUES ('22', '/sale/orderEdit', '订单基本信息', '订单基本信息', '0', '14', '2', '1', '0');
INSERT INTO `permissions` VALUES ('23', '/sale/orderConfig', '订单配置', '订单配置', '1', '14', '2', '1', '0');
INSERT INTO `permissions` VALUES ('24', '/sale/orderAssignList', '订单派发', '订单派发', '1', '13', '1', '1', '0');
INSERT INTO `permissions` VALUES ('25', 'cc', 'cc', 'cc', '0', '0', '2', '1', '1');
INSERT INTO `permissions` VALUES ('26', 'cc', 'cc', 'cc', '0', '0', '2', '1', '1');
INSERT INTO `permissions` VALUES ('27', 'cc', 'cc', 'cc', '0', '0', '2', '1', '1');
INSERT INTO `permissions` VALUES ('28', '/worker/workerList', '服务人员列表', '服务人员列表', '1', '11', '1', '1', '0');
INSERT INTO `permissions` VALUES ('29', '/worker/workerItem', '服务人员配置', '服务人员配置', '0', '28', '2', '1', '0');
INSERT INTO `permissions` VALUES ('30', '/worker/workFormConfig', '服务人员字段配置', '服务人员字段配置', '2', '11', '1', '1', '0');
INSERT INTO `permissions` VALUES ('31', '/employee', '人力资源管理', '人力资源管理', '2', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('32', '/employee/employeeList', '公司员工列表', '公司员工列表', '0', '31', '1', '1', '0');
INSERT INTO `permissions` VALUES ('33', '/employee/employeeItem', '编辑公司员工', '编辑公司员工', '0', '32', '2', '1', '0');

-- ----------------------------
-- Table structure for role_manager
-- ----------------------------
DROP TABLE IF EXISTS `role_manager`;
CREATE TABLE `role_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色账号关联表';

-- ----------------------------
-- Records of role_manager
-- ----------------------------
INSERT INTO `role_manager` VALUES ('1', '1', '1');
INSERT INTO `role_manager` VALUES ('13', '2', '2');
INSERT INTO `role_manager` VALUES ('15', '5', '3');
INSERT INTO `role_manager` VALUES ('23', '2', '1');
INSERT INTO `role_manager` VALUES ('24', '2', '3');
INSERT INTO `role_manager` VALUES ('25', '2', '4');
INSERT INTO `role_manager` VALUES ('26', '3', '1');
INSERT INTO `role_manager` VALUES ('27', '3', '2');
INSERT INTO `role_manager` VALUES ('28', '3', '3');
INSERT INTO `role_manager` VALUES ('29', '3', '4');
INSERT INTO `role_manager` VALUES ('33', '5', '2');
INSERT INTO `role_manager` VALUES ('34', '5', '4');
INSERT INTO `role_manager` VALUES ('35', '5', '7');
INSERT INTO `role_manager` VALUES ('36', '2', '7');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否为超级管理员 0：全部，1：否，2：是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '角色删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '0', '0');
INSERT INTO `roles` VALUES ('2', '销售业务员', '0', '0');
INSERT INTO `roles` VALUES ('3', '人力资源业务员', '1', '0');
INSERT INTO `roles` VALUES ('4', '销售管理员', '1', '0');
INSERT INTO `roles` VALUES ('5', '人力资源管理员', '1', '1');
INSERT INTO `roles` VALUES ('6', 'ccc', '1', '1');
INSERT INTO `roles` VALUES ('7', '人力资源管理员', '1', '0');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `register_at` int(11) NOT NULL DEFAULT '0' COMMENT '登记时间',
  `authentication` tinyint(1) NOT NULL DEFAULT '0' COMMENT '认证状态，动态配置',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `age` tinyint(3) NOT NULL DEFAULT '0' COMMENT '年龄',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号，作为登录账号',
  `return_msg` varchar(200) NOT NULL DEFAULT '' COMMENT '回访信息',
  `working_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '接单状态',
  `remarks` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `service_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '服务类型，动态配置',
  `working_age` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工龄，动态配置',
  `working_experience` varchar(200) NOT NULL DEFAULT '' COMMENT '工作经验',
  `nation` varchar(20) NOT NULL DEFAULT '' COMMENT '民族',
  `birthplace` varchar(200) NOT NULL DEFAULT '' COMMENT '密码',
  `identify` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '现居住地',
  `education` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学历 0：全部，1：博士，2：硕士，3：本科，4：大专，5：中专，6：高中，7：初中，8：小学',
  `urgent_phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号，作为登录账号',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像图标',
  `course` tinyint(1) NOT NULL DEFAULT '0' COMMENT '培训课程',
  `source` tinyint(1) NOT NULL DEFAULT '0' COMMENT '信息来源,可配置',
  `manager_id` int(11) NOT NULL DEFAULT '0' COMMENT '管理员id',
  `manager_name` varchar(20) NOT NULL DEFAULT '' COMMENT '管理员名',
  `code` varchar(20) NOT NULL DEFAULT '' COMMENT '员工编号',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别 0：全部，1：男，2：女',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `type` enum('normal','sign') NOT NULL DEFAULT 'normal' COMMENT '签约状态',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '服务人员状态 0：正常，1：停用',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE COMMENT '手机号唯一性约束'
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='员工表';

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', '1554731991', '0', '宋希文', '25', '15001279361', '', '0', '', '0', '0', '', '', '', '210111199407250517', '沈阳市大东区小北关街43#1-6-1', '0', '', '6214831249176063', 'icon/1/5c4234a430dd88470c15c72757571e25.jpeg', '0', '0', '0', '', '00001', '1', '12', '1554731991', 'sign', '0');
INSERT INTO `staff` VALUES ('2', '0', '0', '弗兰克', '60', '15001234567', '', '0', '', '0', '0', '', '', '', '210222197009171123', '北京市昌平区物美超市2#1-0-9', '0', '', '6214831249176063', 'icon/1/5ffe47bca3e7402afe915b3247b52468.jpeg', '0', '0', '0', '', '00002', '1', '2', '1553772643', 'sign', '0');
INSERT INTO `staff` VALUES ('3', '0', '0', '王女士', '18', '13998989889', '', '0', '', '0', '0', '', '汉', '', '210105199504224911', '辽宁省沈阳市长江街黑山路松山南区', '0', '', '6214831249176063', 'icon/1/338d1254be5423ca95449454e77dd6aa.jpg', '0', '0', '0', '', '00003', '2', '0', '1553785906', 'normal', '0');
INSERT INTO `staff` VALUES ('4', '2', '0', '测试', '20', '13998836590', '', '0', '', '0', '0', '', '0', '', '', '', '0', '', '', '', '0', '0', '2', '唐朝', '00004', '1', '0', '1554819968', 'normal', '0');
INSERT INTO `staff` VALUES ('10', '2', '1', '宋希文', '45', '15001278888', '暂无', '2', '暂无', '1', '2', '暂无', '11', '', '210111199407250517', '辽宁沈阳', '2', '', '6214831249176063', 'icon/1/7f192715ea717a5bc1a03cca2a8069cf.jpeg', '3', '3', '3', '宋希文', '00010', '1', '0', '1554824138', 'normal', '0');

-- ----------------------------
-- Table structure for staff_labels
-- ----------------------------
DROP TABLE IF EXISTS `staff_labels`;
CREATE TABLE `staff_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `service_crowd_id` int(11) NOT NULL DEFAULT '0' COMMENT '技能类型id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of staff_labels
-- ----------------------------

-- ----------------------------
-- Table structure for staff_paper_images
-- ----------------------------
DROP TABLE IF EXISTS `staff_paper_images`;
CREATE TABLE `staff_paper_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_paper_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '姓名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_paper_images
-- ----------------------------
INSERT INTO `staff_paper_images` VALUES ('1', '1', ' CVVVVV.jpeg', 'paper/1/d8bcabfdbc000e160612efc2bb370ddb.jpeg');
INSERT INTO `staff_paper_images` VALUES ('2', '3', '头像.jpg', 'paper/1/1c2c46ab8f4d808e74f7ca6d0dcf9953.jpg');
INSERT INTO `staff_paper_images` VALUES ('3', '2', ' CVVVVV.jpeg', 'paper/1/cc77fdf7168d105c4e6335d2eb7e9be3.jpeg');
INSERT INTO `staff_paper_images` VALUES ('6', '6', 'picture.jpeg', 'paper/1/5bb81f1824e9c9f82300d6a3dee2609c.jpeg');

-- ----------------------------
-- Table structure for staff_papers
-- ----------------------------
DROP TABLE IF EXISTS `staff_papers`;
CREATE TABLE `staff_papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `paper_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '证件类型id',
  `paper_category_name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_papers
-- ----------------------------
INSERT INTO `staff_papers` VALUES ('1', '1', '2', '健康证');
INSERT INTO `staff_papers` VALUES ('2', '3', '1', '身份证');
INSERT INTO `staff_papers` VALUES ('3', '2', '3', '会计证');
INSERT INTO `staff_papers` VALUES ('6', '10', '6', '初级家政服务员');

-- ----------------------------
-- Table structure for staff_regions
-- ----------------------------
DROP TABLE IF EXISTS `staff_regions`;
CREATE TABLE `staff_regions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `region_id` int(11) NOT NULL DEFAULT '0' COMMENT '地区id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='员工服务地区表';

-- ----------------------------
-- Records of staff_regions
-- ----------------------------
INSERT INTO `staff_regions` VALUES ('2', '1', '20', '西岗区');
INSERT INTO `staff_regions` VALUES ('3', '3', '5', '沈河区');
INSERT INTO `staff_regions` VALUES ('4', '3', '6', '大东区');
INSERT INTO `staff_regions` VALUES ('5', '2', '4', '和平区');
INSERT INTO `staff_regions` VALUES ('12', '10', '1', '沈河区');
INSERT INTO `staff_regions` VALUES ('13', '10', '2', '大东区');

-- ----------------------------
-- Table structure for staff_skills
-- ----------------------------
DROP TABLE IF EXISTS `staff_skills`;
CREATE TABLE `staff_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `service_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '技能类型id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COMMENT='工人分类表';

-- ----------------------------
-- Records of staff_skills
-- ----------------------------
INSERT INTO `staff_skills` VALUES ('1', '1', '2', '');
INSERT INTO `staff_skills` VALUES ('2', '1', '12', '');
INSERT INTO `staff_skills` VALUES ('3', '3', '11', '');
INSERT INTO `staff_skills` VALUES ('4', '2', '3', '');
INSERT INTO `staff_skills` VALUES ('5', '10', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('6', '10', '2', '保姆');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(11) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `token` varchar(64) NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '头像图标',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：删除',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE COMMENT '手机唯一性索引'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户表';

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '唐朝', '13998836590', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('3', '唐朝2', '13998836591', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('4', '宋', '123111111', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('5', 'wwww', 'wwww', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('6', 'oooo', 'oooo', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('7', '测试', '13499950294', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('8', '王二', '15001279361', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('9', '唐朝', '13344455366', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('10', '测试测', '13995559494', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('11', '王女士', '13899977894', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('12', '测试', '13333443434', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('13', '测试测试', '13333333333', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('14', '张', '13002466170', '', '', '0', '', '0');
INSERT INTO `users` VALUES ('15', '王', '13002466177', '', '', '0', '', '0');
