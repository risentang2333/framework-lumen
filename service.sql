/*
Navicat MySQL Data Transfer

Source Server         : 60.205.200.55
Source Server Version : 50560
Source Host           : 60.205.200.55:6666
Source Database       : service

Target Server Type    : MYSQL
Target Server Version : 50560
File Encoding         : 65001

Date: 2019-04-11 21:30:26
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
INSERT INTO `config_courses` VALUES ('1', '养老护理', '2', 'enable');
INSERT INTO `config_courses` VALUES ('2', '育儿', '0', 'enable');
INSERT INTO `config_courses` VALUES ('3', '月嫂', '0', 'enable');
INSERT INTO `config_courses` VALUES ('4', '中餐', '0', 'enable');
INSERT INTO `config_courses` VALUES ('5', '保洁', '0', 'enable');
INSERT INTO `config_courses` VALUES ('6', '菲佣', '0', 'enable');
INSERT INTO `config_courses` VALUES ('7', '辅食制作', '2', 'enable');

-- ----------------------------
-- Table structure for config_nations
-- ----------------------------
DROP TABLE IF EXISTS `config_nations`;
CREATE TABLE `config_nations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '状态 ''enable''：正常，''disable''：停用',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of config_nations
-- ----------------------------
INSERT INTO `config_nations` VALUES ('1', '满', '0', 'enable');
INSERT INTO `config_nations` VALUES ('2', '汉', '0', 'enable');
INSERT INTO `config_nations` VALUES ('3', '蒙古族', '0', 'enable');
INSERT INTO `config_nations` VALUES ('4', '锡伯族', '0', 'enable');
INSERT INTO `config_nations` VALUES ('5', '回', '0', 'enable');
INSERT INTO `config_nations` VALUES ('6', '其他', '0', 'enable');
INSERT INTO `config_nations` VALUES ('7', '朝鲜族', '0', 'enable');
INSERT INTO `config_nations` VALUES ('8', '鄂伦春', '0', 'enable');
INSERT INTO `config_nations` VALUES ('9', '壮族', '0', 'enable');

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
INSERT INTO `config_service_regions` VALUES ('1', '大东区', '0', 'enable');
INSERT INTO `config_service_regions` VALUES ('2', '沈河区', '0', 'enable');
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
INSERT INTO `managers` VALUES ('1', 'admin', 'f973988be6cba09855f84c34d10e8a62', '超级管理员', 'd661db3429c7fbcda0fd701aec81b7ed', 'c31bb271d4a604d6376af3024345ab53', '1555065342', '2', '0');
INSERT INTO `managers` VALUES ('2', 'tangchao', 'b60510d71c8d17df14ce7b2c548f716e', '唐朝', 'ab2bf59b697db8dc157a8db38e737c57', '900342ae59c518b3379c34dd30017afb', '1555065385', '1', '0');
INSERT INTO `managers` VALUES ('3', 'songxiwen', 'bcc7e1dd92254ef41b2abd8fc453fbb3', '宋希文', '46cec1d6208b3efee66485669cfeccdd', 'a20eee6116f4c95b13ced40e635f1e43', '1555029911', '1', '0');
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
  `working_age` tinyint(1) NOT NULL DEFAULT '0' COMMENT '工龄，动态配置',
  `working_experience` varchar(200) NOT NULL DEFAULT '' COMMENT '工作经验',
  `nation` varchar(20) NOT NULL DEFAULT '' COMMENT '民族',
  `birthplace` varchar(200) NOT NULL DEFAULT '' COMMENT '密码',
  `identify` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '现居住地',
  `education` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学历0：未选择，1：小学，2：初中，3：高中，4：职高，5：中专，6：专科，7：自考成人大专，8：本科，9：本科及以上，10：大专',
  `urgent_phone` varchar(50) NOT NULL DEFAULT '' COMMENT '手机号，作为登录账号',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像图标',
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
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='员工表';

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', '1554566400', '1', '赵明', '47', '13604004568', '暂无', '1', '暂无信息', '1', '没做过', '6', '辽宁', '', '铁西滑翔', '2', '', '', 'icon/1/96f7c91380cf43cec384c9ce009ea601.jpg', '4', '2', '唐朝', '', '1', '33', '1554620686', 'normal', '0');
INSERT INTO `staff` VALUES ('2', '1554566400', '0', '邹丽侠', '48', '15140184216', '', '0', '报名8期养老', '0', '', '0', '', '', '沈阳', '0', '', '', '', '0', '0', '', '', '1', '0', '1554616360', 'normal', '0');
INSERT INTO `staff` VALUES ('3', '1554566400', '0', '于艳玲', '50', '13840141076', '4.7号已上户', '5', '没照顾过老人，新手', '1', '无', '2', '', '', '沈阳沈北新区', '2', '', '', '', '3', '3', '宋希文', '', '1', '1', '1554615951', 'normal', '0');
INSERT INTO `staff` VALUES ('4', '1554566400', '2', '佟路', '45', '13889241978', '', '0', '白班保姆 双休 或者周六单休', '0', '', '3', '', '', '道义正良', '2', '', '', '', '0', '2', '唐朝', '', '1', '2', '1554615614', 'normal', '0');
INSERT INTO `staff` VALUES ('5', '1554566400', '2', '庞维娜', '60', '13889829846', '', '0', '小时工，看宝宝！护理过老人！做饭！收拾房间！', '0', '', '0', '', '', '万科金域华府', '0', '', '', '', '3', '0', '', '', '1', '0', '1554602358', 'normal', '0');
INSERT INTO `staff` VALUES ('6', '1554307200', '2', '郭红', '50', '13897959960', '', '0', '做饭都行，上下午都行', '0', '', '0', '', '', '重工街北一路', '0', '', '', '', '3', '0', '', '', '1', '0', '1554348635', 'normal', '0');
INSERT INTO `staff` VALUES ('7', '1554307200', '0', '孙凤英03', '53', '17640552412', '', '0', '', '0', '', '0', '', '', '北一路', '0', '', '', '', '0', '0', '', '', '1', '0', '1554348517', 'normal', '0');
INSERT INTO `staff` VALUES ('8', '1554307200', '2', '刘艳丽11', '45', '15702432511', '', '0', '10点以后钟点工，家常饭还行', '0', '', '0', '', '', '松山路安居小区', '0', '', '', '', '3', '0', '', '', '1', '0', '1554348515', 'normal', '0');
INSERT INTO `staff` VALUES ('9', '1554307200', '2', '边境', '55', '13147801866', '', '0', '钟点工 做饭好吃 双休', '0', '', '0', '', '', '展览馆，万象城', '0', '', '', '', '3', '0', '', '', '1', '0', '1554347935', 'normal', '0');
INSERT INTO `staff` VALUES ('10', '1554307200', '2', '王玉英1', '57', '18240124318', '', '0', '打扫卫生，一周1次或2次，做饭不好', '0', '', '0', '', '', '荷兰村中海城', '0', '', '', '', '3', '0', '', '', '1', '0', '1554346736', 'normal', '0');
INSERT INTO `staff` VALUES ('11', '1554307200', '2', '张凤荣', '44', '18241053438', '', '1', '报名1期菲佣培训', '0', '', '0', '', '', '沈阳', '0', '', '', '', '0', '0', '', '', '1', '0', '1554343928', 'normal', '0');
INSERT INTO `staff` VALUES ('12', '1554307200', '0', '邹康杰', '54', '15141379018', '', '1', '', '0', '', '0', '', '', '浑南世纪枫景汇', '0', '', '', '', '0', '0', '', '', '1', '0', '1554341662', 'normal', '0');
INSERT INTO `staff` VALUES ('13', '1554307200', '1', '赵玉鸿', '50', '13897944628', '', '1', '', '0', '', '2', '辽宁省沈阳市', '', '苏家屯区白清寨乡白清寨村5组73', '2', '', '', '', '0', '0', '', '', '1', '0', '1526632694', 'normal', '0');
INSERT INTO `staff` VALUES ('14', '1554307200', '2', '郑辉', '51', '15840116759', '', '1', '沈北新区工程学院教师公寓，下午3：00前', '5', '做饭不好吃，只打扫卫生。形象佳', '1', '吉林省东辽县', '', '沈阳市沈北新区工程学院教师公寓', '2', '爱人:15940176319', '', '', '0', '0', '', '', '1', '0', '1522638246', 'normal', '0');
INSERT INTO `staff` VALUES ('15', '1554307200', '1', '郭桂芳', '50', '13998156682', '', '1', '', '14', '', '2', '黑龙江省牡丹江市', '', '皇姑区银山路富丽阳光', '3', '', '', '', '0', '0', '', '', '1', '0', '1522377382', 'normal', '0');
INSERT INTO `staff` VALUES ('16', '1554220800', '0', '王阿姨01', '51', '13238833018', '', '4', '', '0', '', '0', '', '', '铁西', '0', '', '', '', '0', '0', '', '', '1', '0', '1554281153', 'normal', '0');
INSERT INTO `staff` VALUES ('17', '1554220800', '2', '全阿姨', '47', '18842369352', '', '4', '', '0', '', '0', '', '', '苏家屯姚千镇', '0', '', '', '', '0', '0', '', '', '1', '0', '1554280915', 'normal', '0');
INSERT INTO `staff` VALUES ('18', '1554220800', '0', '王淑华01', '51', '13149800076', '', '1', '想找幼儿园的活', '0', '', '0', '', '', '长白', '0', '', '', '', '0', '0', '', '', '1', '0', '1554279905', 'normal', '0');
INSERT INTO `staff` VALUES ('19', '1554220800', '2', '庞秀芳', '48', '15524211532', '', '1', '', '0', '', '0', '', '', '于洪', '0', '', '', '', '0', '0', '', '', '1', '0', '1554276081', 'normal', '0');
INSERT INTO `staff` VALUES ('20', '1554220800', '0', '刘丽颖', '47', '15140067328', '', '1', '', '0', '', '0', '', '', '法库县', '0', '', '', '', '2', '0', '', '', '1', '0', '1554276001', 'normal', '0');
INSERT INTO `staff` VALUES ('21', '1554220800', '0', '张淑艳05', '50', '15524345457', '', '1', '', '0', '', '0', '', '', '于洪区', '0', '', '', '', '0', '0', '', '', '1', '0', '1554275705', 'normal', '0');
INSERT INTO `staff` VALUES ('22', '1554220800', '2', '张丙红', '51', '15840523277', '', '1', '白班保姆', '8', '', '0', '', '', '大东区', '0', '', '', '', '0', '0', '', '', '1', '0', '1554275101', 'normal', '0');
INSERT INTO `staff` VALUES ('23', '1554220800', '2', '李凤华', '54', '15142513478', '', '1', '', '0', '8年多食堂经验，家政活没做过', '2', '', '', '世代龙城', '0', '', '', '', '0', '0', '', '', '1', '0', '1523178241', 'normal', '0');
INSERT INTO `staff` VALUES ('24', '1554220800', '2', '王红霞', '49', '13664156705', '', '1', '白班保洁', '3', '之前一直在龙之梦里做保洁，现在在黎明做保洁', '2', '', '', '沈阳市大东区东胜小区', '2', '', '', '', '0', '0', '', '', '1', '0', '1515401199', 'normal', '0');
INSERT INTO `staff` VALUES ('25', '1554134400', '2', '张敏09', '53', '15542750486', '', '0', '报名8期养老', '0', '', '0', '', '', '鞍山', '0', '', '', '', '3', '0', '', '', '1', '0', '1554280181', 'normal', '0');
INSERT INTO `staff` VALUES ('26', '1554134400', '2', '郭女士', '56', '18524449269', '', '0', '电话号是王女士儿媳的给婆婆郭女士找', '0', '8-1点左右，最好双休，单休周六休', '0', '', '', '云峰北街，兴望小学北校区', '0', '', '', '', '4', '0', '', '', '1', '0', '1554182113', 'normal', '0');
INSERT INTO `staff` VALUES ('27', '1554134400', '2', '王利华', '56', '18642324858', '', '0', '', '0', '住家陪护自理女老人，做饭好吃面食肉菜都会', '0', '', '', '抚顺', '0', '', '', '', '3', '0', '', '', '1', '0', '1554170034', 'normal', '0');
INSERT INTO `staff` VALUES ('28', '1554134400', '2', '付女士', '41', '13555772142', '', '0', '', '0', '不做饭钟点工', '0', '', '', '李官高速口', '0', '', '', '', '3', '0', '', '', '1', '0', '1554169912', 'normal', '0');
INSERT INTO `staff` VALUES ('29', '1554134400', '2', '董艳红', '51', '13166720937', '', '0', '', '0', '做饭好吃面食都好，有育婴师证。找周日钟点工', '0', '', '', '老长客总站', '0', '', '', '', '3', '0', '', '', '1', '0', '1554169736', 'normal', '0');
INSERT INTO `staff` VALUES ('30', '1554134400', '2', '刘艳丽13', '36', '17640096925', '', '0', '', '0', '工作时间8-5点之间，卫生做饭还行', '0', '', '', '七二四职业技术学院', '0', '', '', '', '3', '0', '', '', '1', '0', '1554169572', 'normal', '0');
INSERT INTO `staff` VALUES ('31', '1554134400', '2', '蒋国军', '55', '13591640720', '', '0', '', '0', '打扫卫生，上下午都行', '0', '', '', '东方丽城', '0', '', '', '', '3', '0', '', '', '1', '0', '1554168432', 'normal', '0');
INSERT INTO `staff` VALUES ('32', '1554134400', '2', '郑春艳1', '50', '13042444696', '', '0', '', '0', '会开车，做饭快干净好吃，酱牛肉都会', '0', '', '', '沈北亚太城碧桂园', '0', '', '', '', '3', '0', '', '', '1', '0', '1554168021', 'normal', '0');
INSERT INTO `staff` VALUES ('33', '1554134400', '2', '邵凤菊', '56', '13889838453', '', '0', '', '0', '保姆辅助带女老人的，做饭好吃', '0', '', '', '九一八老长客', '0', '', '', '', '3', '0', '', '', '1', '0', '1554167821', 'normal', '0');
INSERT INTO `staff` VALUES ('34', '1554134400', '2', '张殿清', '55', '18004016085', '', '0', '', '0', '照顾完全自理老人，做饭好吃 面食肉菜都行', '0', '', '', '北三台子217终点站', '0', '', '', '', '3', '0', '', '', '1', '0', '1554167409', 'normal', '0');
INSERT INTO `staff` VALUES ('35', '1554134400', '2', '徐秀文', '56', '13894188029', '', '0', '', '0', '上下午都行。家常饭菜好吃', '0', '', '', '东方丽城', '0', '', '', '', '3', '0', '', '', '1', '0', '1554167090', 'normal', '0');
INSERT INTO `staff` VALUES ('36', '1554134400', '2', '董喜军', '52', '18604103415', '', '0', '', '0', '找住家和养老院的活儿。有一年经验', '0', '', '', '开原', '0', '', '', '', '3', '0', '', '', '1', '0', '1554166539', 'normal', '0');
INSERT INTO `staff` VALUES ('37', '1554048000', '2', '高桂枝', '45', '15002412096', '', '0', '', '0', '', '0', '', '', '皇姑华山路', '0', '', '', '', '4', '0', '', '', '1', '0', '1554095123', 'normal', '0');
INSERT INTO `staff` VALUES ('38', '1554048000', '1', '张敏杰', '51', '13104130438', '', '0', '月嫂育儿嫂都做过', '0', '护工无经验，养老护理第七期学员', '0', '', '', '抚顺望花区', '0', '', '', '', '3', '0', '', '', '1', '0', '1554085963', 'normal', '0');
INSERT INTO `staff` VALUES ('39', '1554048000', '1', '赵素文', '54', '13390439787', '', '0', '', '0', '无经验，养老护理第七期学员', '0', '', '', '抚顺清原', '0', '', '', '', '3', '0', '', '', '1', '0', '1554085849', 'normal', '0');
INSERT INTO `staff` VALUES ('40', '1554048000', '1', '刘亚丽2', '53', '13898132452', '', '0', '', '0', '无经验，养老护理第七期学员', '0', '', '', '苏家屯大沟乡', '0', '', '', '', '3', '0', '', '', '1', '0', '1554085772', 'normal', '0');
INSERT INTO `staff` VALUES ('41', '1554048000', '1', '都秀梅1', '51', '18304049917', '', '0', '', '0', '有经验，养老护理第七期。', '0', '', '', '苏家屯', '0', '', '', '', '3', '0', '', '', '1', '0', '1554085686', 'normal', '0');
INSERT INTO `staff` VALUES ('42', '1554048000', '1', '曹立杰', '47', '18002469498', '', '0', '', '0', '开荒保洁擦玻璃，养老护理第七期，医院护工', '0', '', '', '新民', '0', '', '', '', '3', '0', '', '', '1', '0', '1554084100', 'normal', '0');
INSERT INTO `staff` VALUES ('43', '1554048000', '1', '田洪云1', '50', '13898042866', '', '0', '', '0', '无经验，养老护理第七期学员', '0', '', '', '嫩江街', '0', '', '', '', '3', '0', '', '', '1', '0', '1554083681', 'normal', '0');
INSERT INTO `staff` VALUES ('44', '1554048000', '1', '王艳辉1', '51', '13252826106', '', '0', '', '0', '养老护理第七期', '0', '', '', '黄河北大街', '0', '', '', '', '3', '0', '', '', '1', '0', '1554083507', 'normal', '0');
INSERT INTO `staff` VALUES ('45', '1554048000', '1', '王庆金', '50', '15947357030', '', '0', '', '0', '无经验，夫妻工，养老护理第七期', '0', '', '', '于洪区大通湖街', '0', '', '', '', '3', '0', '', '', '1', '0', '1554083408', 'normal', '0');
INSERT INTO `staff` VALUES ('46', '1554048000', '1', '郭春芳', '53', '15898072035', '', '0', '', '0', '养老护理第七期，住家医院都行', '0', '', '', '开原', '0', '', '', '', '3', '0', '', '', '1', '0', '1554083277', 'normal', '0');
INSERT INTO `staff` VALUES ('47', '1554048000', '1', '刘亚芝1', '50', '15142092381', '', '0', '', '0', '无经验，找夫妻工，之后想从事护工，养老护理第七期', '0', '', '', '于洪区大通湖街', '0', '', '', '', '3', '0', '', '', '1', '0', '1554082907', 'normal', '0');
INSERT INTO `staff` VALUES ('48', '1554048000', '1', '张秋艳', '44', '15041079006', '', '0', '', '0', '医院护工，养老护理第七期', '0', '', '', '昌图县', '0', '', '', '', '3', '0', '', '', '1', '0', '1554082637', 'normal', '0');
INSERT INTO `staff` VALUES ('49', '1554048000', '1', '魏梅', '53', '18804109649', '', '0', '', '0', '养老护理第七期', '0', '', '', '新隆', '0', '', '', '', '3', '0', '', '', '1', '0', '1554082479', 'normal', '0');
INSERT INTO `staff` VALUES ('50', '1554048000', '1', '魏春华', '45', '15566228268', '', '0', '', '0', '无经验，养老护理第七期', '0', '', '', '天山路', '0', '', '', '', '3', '0', '', '', '1', '0', '1554082304', 'normal', '0');
INSERT INTO `staff` VALUES ('51', '1554048000', '0', '王丽艳01', '37', '18640576581', '', '0', '', '0', '学习月嫂中', '2', '沈阳市大东区东北大马路', '', '大东区龙之梦', '3', '', '', '', '0', '0', '', '', '1', '0', '1527305059', 'normal', '0');
INSERT INTO `staff` VALUES ('52', '1554048000', '1', '王元芝', '51', '13042436109', '', '0', '', '10', '养老护理第七期', '2', '辽宁省沈阳市', '', '铁西艳粉', '2', '', '', '', '3', '0', '', '', '1', '0', '1526632689', 'normal', '0');
INSERT INTO `staff` VALUES ('53', '1553788800', '2', '张春梅1', '41', '13614020282', '', '0', '', '0', '3-6点 小时工', '0', '', '', '浑南万科金城蓝湾', '0', '', '', '', '4', '0', '', '', '1', '0', '1553840964', 'normal', '0');
INSERT INTO `staff` VALUES ('54', '1553788800', '2', '赵红菊', '50', '18240426973', '', '0', '', '0', '无经验', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553840701', 'normal', '0');
INSERT INTO `staff` VALUES ('55', '1553788800', '2', '吕燕', '49', '13190049520', '', '0', '', '0', '做饭好吃，12年经验。', '0', '', '', '龙之梦珠林小区', '0', '', '', '', '4', '0', '', '', '1', '0', '1553840268', 'normal', '0');
INSERT INTO `staff` VALUES ('56', '1553788800', '2', '曹翠翠', '37', '13940518850', '', '0', '', '0', '白班 双休', '0', '', '', '皇姑四院永泰小区', '0', '', '', '', '4', '0', '', '', '1', '0', '1553840136', 'normal', '0');
INSERT INTO `staff` VALUES ('57', '1553788800', '2', '曹洪坤', '51', '13066515886', '', '0', '', '0', '上午小时工', '0', '', '', '大东龙之梦大厦', '0', '', '', '', '4', '0', '', '', '1', '0', '1553840064', 'normal', '0');
INSERT INTO `staff` VALUES ('58', '1553788800', '2', '艾红', '54', '13840268229', '', '0', '', '0', '做一顿晚饭', '0', '', '', '昆山中路永泰小区', '0', '', '', '', '4', '0', '', '', '1', '0', '1553839981', 'normal', '0');
INSERT INTO `staff` VALUES ('59', '1553788800', '2', '许庆艳', '50', '13644031044', '', '0', '', '0', '白班小时工', '0', '', '', '于洪和泰新城西区', '0', '', '', '', '4', '0', '', '', '1', '0', '1553839899', 'normal', '0');
INSERT INTO `staff` VALUES ('60', '1553788800', '2', '陈喜爱', '55', '15252932736', '', '0', '', '0', '5点之前 做饭好吃', '0', '', '', '铁西北一路星光家园', '0', '', '', '', '4', '0', '', '', '1', '0', '1553839732', 'normal', '0');
INSERT INTO `staff` VALUES ('61', '1553788800', '2', '何晶1', '31', '17602444571', '', '0', '', '0', '', '0', '', '', '苗山路8号', '0', '', '', '', '3', '0', '', '', '1', '0', '1553838075', 'normal', '0');
INSERT INTO `staff` VALUES ('62', '1553788800', '2', '周弘', '47', '13840558286', '', '0', '', '0', '早八晚五，护老', '0', '', '', '南塔鞋城', '0', '', '', '', '3', '0', '', '', '1', '0', '1553836907', 'normal', '0');
INSERT INTO `staff` VALUES ('63', '1553788800', '2', '李晓严', '53', '13591006047', '', '0', '', '0', '接医院和住家活儿', '0', '', '', '昌图', '0', '', '', '', '3', '0', '', '', '1', '0', '1553836792', 'normal', '0');
INSERT INTO `staff` VALUES ('64', '1553788800', '2', '陆洪亮', '52', '18404209783', '', '0', '', '0', '', '0', '', '', '朝阳 现住滑翔', '0', '', '', '', '3', '0', '', '', '1', '0', '1553836675', 'normal', '0');
INSERT INTO `staff` VALUES ('65', '1553788800', '2', '高文雷', '60', '15545309281', '', '0', '', '0', '', '0', '', '', '黑龙江', '0', '', '', '', '3', '0', '', '', '1', '0', '1553836581', 'normal', '0');
INSERT INTO `staff` VALUES ('66', '1553788800', '2', '于雅娟', '51', '13889249935', '', '0', '', '0', '做饭好吃，大孩子可以，工资要求3000+', '0', '', '', '于洪和泰馨城', '0', '17341002051', '', '', '4', '0', '', '', '1', '0', '1553829814', 'normal', '0');
INSERT INTO `staff` VALUES ('67', '1553788800', '2', '宋亚丽', '47', '15640091241', '', '0', '', '0', '回民', '0', '', '', '大东国瑞城', '0', '', '', '', '4', '0', '', '', '1', '0', '1553829694', 'normal', '0');
INSERT INTO `staff` VALUES ('68', '1553788800', '2', '吴玉霞', '48', '18040025648', '', '0', '', '0', '上午小时工', '0', '', '', '太原街地铁口', '0', '', '', '', '4', '0', '', '', '1', '0', '1553829572', 'normal', '0');
INSERT INTO `staff` VALUES ('69', '1553788800', '2', '徐春哲', '44', '18341637927', '', '0', '', '0', '厨房零活拌菜家常', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553829464', 'normal', '0');
INSERT INTO `staff` VALUES ('70', '1553788800', '2', '艾桂君', '42', '13940022349', '', '0', '', '0', '只打扫卫生，双休 上午，隔天', '0', '', '', '铁西滑翔六小区', '0', '', '', '', '4', '0', '', '', '1', '0', '1553829235', 'normal', '0');
INSERT INTO `staff` VALUES ('71', '1553788800', '2', '赵丽霞11', '50', '13840158570', '', '0', '', '0', '白班钟点工 双休', '0', '', '', '南十二路西', '0', '', '', '', '4', '0', '', '', '1', '0', '1553828006', 'normal', '0');
INSERT INTO `staff` VALUES ('72', '1553788800', '2', '郝艳乔', '60', '18240494731', '', '0', '', '0', '10年经验', '0', '', '', '住家保姆', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827911', 'normal', '0');
INSERT INTO `staff` VALUES ('73', '1553788800', '2', '王永生', '50', '18102432813', '', '0', '', '0', '住家男保姆', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827705', 'normal', '0');
INSERT INTO `staff` VALUES ('74', '1553788800', '2', '胡玉玲', '52', '15041831461', '', '0', '', '0', '', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827634', 'normal', '0');
INSERT INTO `staff` VALUES ('75', '1553788800', '2', '高洪敏', '49', '13130576196', '', '0', '', '0', '', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827573', 'normal', '0');
INSERT INTO `staff` VALUES ('76', '1553788800', '2', '李艳霞1', '48', '13478326280', '', '0', '', '0', '信佛吃素', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827512', 'normal', '0');
INSERT INTO `staff` VALUES ('77', '1553788800', '2', '曲萍', '59', '13998287627', '', '0', '', '0', '单休 做饭好吃', '0', '', '', '铁西兴顺街', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827414', 'normal', '0');
INSERT INTO `staff` VALUES ('78', '1553788800', '2', '闵丽颖', '50', '15140230623', '', '0', '', '0', '中午一顿饭 做饭好吃', '0', '', '', '大东望花', '0', '', '', '', '4', '0', '', '', '1', '0', '1553827306', 'normal', '0');
INSERT INTO `staff` VALUES ('79', '1553788800', '2', '李晶', '55', '13709835331', '', '0', '', '0', '做饭好吃 中晚饭', '0', '', '', '水调歌城', '0', '', '', '', '4', '0', '', '', '1', '0', '1553826384', 'normal', '0');
INSERT INTO `staff` VALUES ('80', '1553788800', '2', '修晓辉', '60', '15840248976', '', '0', '', '0', '陪护老人，', '0', '', '', '康平县 八家子村', '0', '', '', '', '4', '0', '', '', '1', '0', '1553825734', 'normal', '0');
INSERT INTO `staff` VALUES ('81', '1553788800', '2', '王国荣', '50', '13614018930', '', '0', '', '0', '白班5点下班 双休 做饭好吃', '0', '', '', '东陵保利东壮汽贸', '0', '', '', '', '4', '0', '', '', '1', '0', '1553824918', 'normal', '0');
INSERT INTO `staff` VALUES ('82', '1553788800', '2', '辛艳丽', '52', '15942089800', '', '0', '', '0', '10-2点，双休', '0', '', '', '铁西北四路 重工街', '0', '', '', '', '4', '0', '', '', '1', '0', '1553824786', 'normal', '0');
INSERT INTO `staff` VALUES ('83', '1553788800', '2', '付连祥', '50', '15140128435', '', '0', '', '0', '住家男保姆 六，七年经验', '0', '', '', '新民法哈牛', '0', '', '', '', '4', '0', '', '', '1', '0', '1553824652', 'normal', '0');
INSERT INTO `staff` VALUES ('84', '1553788800', '2', '崔淑芳', '53', '15998183998', '', '0', '', '0', '3-6点做饭的', '0', '', '', '兴顺街九路市场', '0', '', '', '', '4', '0', '', '', '1', '0', '1553824259', 'normal', '0');
INSERT INTO `staff` VALUES ('85', '1553788800', '2', '马丽丹', '50', '15804104404', '', '0', '', '0', '有一年经验，找遛狗的活儿，做饭好吃', '0', '', '', '铁西调兵山', '0', '', '', '', '4', '0', '', '', '1', '0', '1553824057', 'normal', '0');
INSERT INTO `staff` VALUES ('86', '1553788800', '2', '杨红艳', '52', '13066613496', '', '0', '', '0', '做饭好吃 护理 白班', '0', '', '', '东陵马官桥保利', '0', '', '', '', '4', '0', '', '', '1', '0', '1553822912', 'normal', '0');
INSERT INTO `staff` VALUES ('87', '1553788800', '2', '黄敬秋', '52', '13998199850', '', '0', '', '0', '家常菜9-4点', '0', '', '', '方家栏逸龙逸城', '0', '', '', '', '4', '0', '', '', '1', '0', '1553822728', 'normal', '0');
INSERT INTO `staff` VALUES ('88', '1553702400', '2', '吕淑红', '54', '18502465505', '', '0', '', '0', '爱做饭', '0', '', '', '大西路房产大厦', '0', '', '', '', '4', '0', '', '', '1', '0', '1553762523', 'normal', '0');
INSERT INTO `staff` VALUES ('89', '1553702400', '2', '李明霞', '49', '13470166528', '', '0', '', '0', '', '0', '', '', '住家', '0', '', '', '', '4', '0', '', '', '1', '0', '1553762419', 'normal', '0');
INSERT INTO `staff` VALUES ('90', '1553702400', '2', '朱丽君', '54', '15214282797', '', '0', '', '0', '有1年经验，家常菜', '0', '', '', '铁岭开原', '0', '', '', '', '4', '0', '', '', '1', '0', '1553762342', 'normal', '0');
INSERT INTO `staff` VALUES ('91', '1553702400', '2', '张薇02', '60', '15041358284', '', '0', '', '0', '', '0', '', '', '康平', '0', '', '', '', '0', '0', '', '', '1', '0', '1553749448', 'normal', '0');
INSERT INTO `staff` VALUES ('92', '1553702400', '2', '王梅', '49', '1323664689', '', '0', '', '0', '做饭', '0', '', '', '于洪广场', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743964', 'normal', '0');
INSERT INTO `staff` VALUES ('93', '1553702400', '2', '郝东升', '26', '13190369460', '', '0', '', '0', '白班上午小时工 双休', '0', '', '', '浑南', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743652', 'normal', '0');
INSERT INTO `staff` VALUES ('94', '1553702400', '2', '赵丹1', '43', '13555896412', '', '0', '', '0', '白班双休 幼儿园干过', '0', '', '', '大东莲花小区', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743566', 'normal', '0');
INSERT INTO `staff` VALUES ('95', '1553702400', '2', '韩凤艳', '45', '18202495519', '', '0', '', '0', '做饭好吃', '0', '', '', '住家保姆', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743386', 'normal', '0');
INSERT INTO `staff` VALUES ('96', '1553702400', '2', '李明222', '50', '15802453665', '', '0', '', '0', '下午1点以后', '0', '', '', '新华广场', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743311', 'normal', '0');
INSERT INTO `staff` VALUES ('97', '1553702400', '2', '宋国霞', '45', '18204086873', '', '0', '', '0', '半年经验', '0', '', '', '于洪马三家子', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743211', 'normal', '0');
INSERT INTO `staff` VALUES ('98', '1553702400', '2', '李胜云', '51', '15841860412', '', '0', '', '0', '带过小孩', '0', '', '', '住家保姆', '0', '', '', '', '4', '0', '', '', '1', '0', '1553743002', 'normal', '0');
INSERT INTO `staff` VALUES ('99', '1553702400', '2', '杨桂华', '54', '13555837686', '', '0', '', '0', '做饭好吃', '0', '', '', '浑南绿色家园', '0', '', '', '', '4', '0', '', '', '1', '0', '1553742919', 'normal', '0');

-- ----------------------------
-- Table structure for staff_certificate_images
-- ----------------------------
DROP TABLE IF EXISTS `staff_certificate_images`;
CREATE TABLE `staff_certificate_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_certificate_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '姓名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_certificate_images
-- ----------------------------
INSERT INTO `staff_certificate_images` VALUES ('1', '1', '货架.jpg', 'certificate/1/0add55a375c58568df4a9446579a8562.jpg');
INSERT INTO `staff_certificate_images` VALUES ('5', '5', '头像.jpg', 'certificate/1/1593df6ca640e22895f1aca6c1feaeb4.jpg');

-- ----------------------------
-- Table structure for staff_certificates
-- ----------------------------
DROP TABLE IF EXISTS `staff_certificates`;
CREATE TABLE `staff_certificates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `paper_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '证件类型id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_certificates
-- ----------------------------
INSERT INTO `staff_certificates` VALUES ('1', '1', '1', '护工证');
INSERT INTO `staff_certificates` VALUES ('5', '1', '1', '护工证');

-- ----------------------------
-- Table structure for staff_courses
-- ----------------------------
DROP TABLE IF EXISTS `staff_courses`;
CREATE TABLE `staff_courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `course_id` int(11) NOT NULL DEFAULT '0' COMMENT '地区id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COMMENT='员工服务地区表';

-- ----------------------------
-- Records of staff_courses
-- ----------------------------
INSERT INTO `staff_courses` VALUES ('2', '7', '6', '菲佣');
INSERT INTO `staff_courses` VALUES ('3', '13', '6', '菲佣');
INSERT INTO `staff_courses` VALUES ('5', '3', '1', '养老护理');

-- ----------------------------
-- Table structure for staff_papers
-- ----------------------------
DROP TABLE IF EXISTS `staff_papers`;
CREATE TABLE `staff_papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `paper_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '证件类型id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_papers
-- ----------------------------

-- ----------------------------
-- Table structure for staff_photos
-- ----------------------------
DROP TABLE IF EXISTS `staff_photos`;
CREATE TABLE `staff_photos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '姓名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_photos
-- ----------------------------
INSERT INTO `staff_photos` VALUES ('3', '1', '头像1.jpg', 'paper/1/a2ff2a3959c55755cce935b37f284087.jpg');
INSERT INTO `staff_photos` VALUES ('4', '1', '头像2.jpg', 'paper/1/7c21949484494ad3dcee4d887bd6a5fc.jpg');

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
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=utf8mb4 COMMENT='员工服务地区表';

-- ----------------------------
-- Records of staff_regions
-- ----------------------------
INSERT INTO `staff_regions` VALUES ('2', '2', '13', '住家');
INSERT INTO `staff_regions` VALUES ('5', '5', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('6', '6', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('7', '7', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('8', '8', '6', '于洪北');
INSERT INTO `staff_regions` VALUES ('9', '9', '3', '和平区');
INSERT INTO `staff_regions` VALUES ('10', '10', '6', '于洪北');
INSERT INTO `staff_regions` VALUES ('11', '11', '13', '住家');
INSERT INTO `staff_regions` VALUES ('12', '12', '10', '浑南新区');
INSERT INTO `staff_regions` VALUES ('13', '13', '12', '苏家屯');
INSERT INTO `staff_regions` VALUES ('14', '14', '7', '沈北新区');
INSERT INTO `staff_regions` VALUES ('15', '15', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('16', '16', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('17', '17', '12', '苏家屯');
INSERT INTO `staff_regions` VALUES ('18', '18', '11', '长白');
INSERT INTO `staff_regions` VALUES ('19', '19', '14', '于洪南');
INSERT INTO `staff_regions` VALUES ('20', '20', '13', '住家');
INSERT INTO `staff_regions` VALUES ('21', '21', '6', '于洪北');
INSERT INTO `staff_regions` VALUES ('22', '22', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('23', '23', '8', '于洪广场');
INSERT INTO `staff_regions` VALUES ('24', '24', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('25', '25', '13', '住家');
INSERT INTO `staff_regions` VALUES ('26', '26', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('27', '27', '13', '住家');
INSERT INTO `staff_regions` VALUES ('28', '28', '6', '于洪北');
INSERT INTO `staff_regions` VALUES ('29', '29', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('30', '30', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('31', '31', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('32', '32', '7', '沈北新区');
INSERT INTO `staff_regions` VALUES ('33', '33', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('34', '34', '13', '住家');
INSERT INTO `staff_regions` VALUES ('35', '35', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('36', '36', '13', '住家');
INSERT INTO `staff_regions` VALUES ('37', '37', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('38', '38', '13', '住家');
INSERT INTO `staff_regions` VALUES ('39', '39', '13', '住家');
INSERT INTO `staff_regions` VALUES ('40', '40', '13', '住家');
INSERT INTO `staff_regions` VALUES ('41', '41', '13', '住家');
INSERT INTO `staff_regions` VALUES ('42', '42', '13', '住家');
INSERT INTO `staff_regions` VALUES ('43', '43', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('44', '44', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('45', '45', '13', '住家');
INSERT INTO `staff_regions` VALUES ('46', '46', '13', '住家');
INSERT INTO `staff_regions` VALUES ('47', '47', '13', '住家');
INSERT INTO `staff_regions` VALUES ('48', '48', '13', '住家');
INSERT INTO `staff_regions` VALUES ('49', '49', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('50', '50', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('51', '51', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('52', '52', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('53', '53', '10', '浑南新区');
INSERT INTO `staff_regions` VALUES ('54', '54', '13', '住家');
INSERT INTO `staff_regions` VALUES ('55', '55', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('56', '56', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('57', '57', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('58', '58', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('59', '59', '8', '于洪广场');
INSERT INTO `staff_regions` VALUES ('60', '60', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('61', '61', '5', '皇姑区');
INSERT INTO `staff_regions` VALUES ('62', '62', '1', '沈河区');
INSERT INTO `staff_regions` VALUES ('63', '63', '13', '住家');
INSERT INTO `staff_regions` VALUES ('64', '64', '13', '住家');
INSERT INTO `staff_regions` VALUES ('65', '65', '13', '住家');
INSERT INTO `staff_regions` VALUES ('66', '66', '13', '住家');
INSERT INTO `staff_regions` VALUES ('67', '67', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('68', '68', '3', '和平区');
INSERT INTO `staff_regions` VALUES ('69', '69', '13', '住家');
INSERT INTO `staff_regions` VALUES ('70', '70', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('71', '71', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('72', '72', '13', '住家');
INSERT INTO `staff_regions` VALUES ('73', '73', '13', '住家');
INSERT INTO `staff_regions` VALUES ('74', '74', '13', '住家');
INSERT INTO `staff_regions` VALUES ('75', '75', '13', '住家');
INSERT INTO `staff_regions` VALUES ('76', '76', '13', '住家');
INSERT INTO `staff_regions` VALUES ('77', '77', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('78', '78', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('79', '79', '14', '于洪南');
INSERT INTO `staff_regions` VALUES ('80', '80', '13', '住家');
INSERT INTO `staff_regions` VALUES ('81', '81', '9', '东陵区');
INSERT INTO `staff_regions` VALUES ('82', '82', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('83', '83', '13', '住家');
INSERT INTO `staff_regions` VALUES ('84', '84', '4', '铁西区');
INSERT INTO `staff_regions` VALUES ('85', '85', '13', '住家');
INSERT INTO `staff_regions` VALUES ('86', '86', '1', '沈河区');
INSERT INTO `staff_regions` VALUES ('87', '87', '1', '沈河区');
INSERT INTO `staff_regions` VALUES ('88', '88', '1', '沈河区');
INSERT INTO `staff_regions` VALUES ('89', '89', '13', '住家');
INSERT INTO `staff_regions` VALUES ('90', '90', '13', '住家');
INSERT INTO `staff_regions` VALUES ('91', '91', '13', '住家');
INSERT INTO `staff_regions` VALUES ('92', '92', '8', '于洪广场');
INSERT INTO `staff_regions` VALUES ('93', '93', '10', '浑南新区');
INSERT INTO `staff_regions` VALUES ('94', '94', '2', '大东区');
INSERT INTO `staff_regions` VALUES ('95', '95', '13', '住家');
INSERT INTO `staff_regions` VALUES ('96', '96', '3', '和平区');
INSERT INTO `staff_regions` VALUES ('97', '97', '13', '住家');
INSERT INTO `staff_regions` VALUES ('98', '98', '13', '住家');
INSERT INTO `staff_regions` VALUES ('99', '99', '10', '浑南新区');
INSERT INTO `staff_regions` VALUES ('102', '4', '7', '沈北新区');
INSERT INTO `staff_regions` VALUES ('105', '3', '7', '沈北新区');

-- ----------------------------
-- Table structure for staff_service_crowds
-- ----------------------------
DROP TABLE IF EXISTS `staff_service_crowds`;
CREATE TABLE `staff_service_crowds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `service_crowd_id` int(11) NOT NULL DEFAULT '0' COMMENT '技能类型id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of staff_service_crowds
-- ----------------------------
INSERT INTO `staff_service_crowds` VALUES ('1', '2', '7', '自理老人');
INSERT INTO `staff_service_crowds` VALUES ('5', '5', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('6', '7', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('7', '11', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('8', '12', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('9', '12', '7', '自理老人');
INSERT INTO `staff_service_crowds` VALUES ('10', '13', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('11', '14', '1', '打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('12', '15', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('13', '16', '7', '自理老人');
INSERT INTO `staff_service_crowds` VALUES ('14', '17', '5', '照顾1-3岁宝宝');
INSERT INTO `staff_service_crowds` VALUES ('15', '19', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('16', '21', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('17', '22', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('18', '23', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('19', '24', '1', '打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('20', '25', '7', '自理老人');
INSERT INTO `staff_service_crowds` VALUES ('21', '26', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('22', '28', '1', '打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('23', '31', '1', '打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('24', '35', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('25', '52', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('26', '70', '1', '打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('27', '91', '7', '自理老人');
INSERT INTO `staff_service_crowds` VALUES ('28', '91', '8', '半自理老人');
INSERT INTO `staff_service_crowds` VALUES ('29', '91', '9', '不自理老人');
INSERT INTO `staff_service_crowds` VALUES ('32', '3', '3', '做饭+打扫卫生');
INSERT INTO `staff_service_crowds` VALUES ('33', '3', '7', '自理老人');

-- ----------------------------
-- Table structure for staff_service_types
-- ----------------------------
DROP TABLE IF EXISTS `staff_service_types`;
CREATE TABLE `staff_service_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `service_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '技能类型id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '服务地区',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=166 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

-- ----------------------------
-- Records of staff_service_types
-- ----------------------------
INSERT INTO `staff_service_types` VALUES ('2', '2', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('4', '4', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('5', '5', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('6', '6', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('7', '7', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('8', '8', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('9', '9', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('10', '10', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('11', '11', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('12', '11', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('13', '12', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('14', '13', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('15', '14', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('16', '15', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('17', '16', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('18', '17', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('19', '18', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('20', '19', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('21', '20', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('22', '21', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('23', '22', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('24', '23', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('25', '24', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('26', '25', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('27', '26', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('28', '27', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('29', '28', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('30', '29', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('31', '30', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('32', '31', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('33', '32', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('34', '33', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('35', '33', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('36', '34', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('37', '35', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('38', '36', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('39', '37', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('40', '38', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('41', '39', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('42', '40', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('43', '41', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('44', '42', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('45', '42', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('46', '43', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('47', '43', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('48', '44', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('49', '44', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('50', '45', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('51', '46', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('52', '47', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('53', '48', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('54', '49', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('55', '49', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('56', '50', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('57', '50', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('58', '51', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('59', '52', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('60', '52', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('61', '53', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('62', '54', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('63', '55', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('64', '56', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('65', '57', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('66', '58', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('67', '59', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('68', '60', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('69', '61', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('70', '62', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('71', '63', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('72', '64', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('73', '65', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('74', '66', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('75', '67', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('76', '68', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('77', '69', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('78', '70', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('79', '71', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('80', '72', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('81', '73', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('82', '74', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('83', '75', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('84', '76', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('85', '77', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('86', '78', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('87', '79', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('88', '80', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('89', '81', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('90', '82', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('91', '83', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('92', '84', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('93', '85', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('94', '86', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('95', '87', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('96', '88', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('97', '89', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('98', '90', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('99', '91', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('100', '92', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('101', '93', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('102', '94', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('103', '95', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('104', '96', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('105', '97', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('106', '98', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('107', '99', '2', '不住家');
INSERT INTO `staff_service_types` VALUES ('108', '3', '1', '住家');
INSERT INTO `staff_service_types` VALUES ('109', '3', '2', '不住家');

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
) ENGINE=InnoDB AUTO_INCREMENT=174 DEFAULT CHARSET=utf8mb4 COMMENT='工人分类表';

-- ----------------------------
-- Records of staff_skills
-- ----------------------------
INSERT INTO `staff_skills` VALUES ('3', '2', '6', '护工');
INSERT INTO `staff_skills` VALUES ('6', '5', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('7', '6', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('8', '7', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('9', '8', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('10', '9', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('11', '10', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('12', '11', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('13', '11', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('14', '12', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('15', '13', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('16', '14', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('17', '15', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('18', '16', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('19', '17', '4', '育儿嫂');
INSERT INTO `staff_skills` VALUES ('20', '18', '4', '育儿嫂');
INSERT INTO `staff_skills` VALUES ('21', '19', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('22', '20', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('23', '21', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('24', '22', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('25', '23', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('26', '24', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('27', '25', '6', '护工');
INSERT INTO `staff_skills` VALUES ('28', '26', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('29', '27', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('30', '28', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('31', '29', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('32', '30', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('33', '31', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('34', '32', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('35', '33', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('36', '34', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('37', '35', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('38', '36', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('39', '36', '6', '护工');
INSERT INTO `staff_skills` VALUES ('40', '37', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('41', '38', '3', '月嫂');
INSERT INTO `staff_skills` VALUES ('42', '38', '4', '育儿嫂');
INSERT INTO `staff_skills` VALUES ('43', '38', '6', '护工');
INSERT INTO `staff_skills` VALUES ('44', '39', '6', '护工');
INSERT INTO `staff_skills` VALUES ('45', '40', '6', '护工');
INSERT INTO `staff_skills` VALUES ('46', '41', '6', '护工');
INSERT INTO `staff_skills` VALUES ('47', '42', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('48', '42', '6', '护工');
INSERT INTO `staff_skills` VALUES ('49', '43', '6', '护工');
INSERT INTO `staff_skills` VALUES ('50', '44', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('51', '44', '6', '护工');
INSERT INTO `staff_skills` VALUES ('52', '45', '6', '护工');
INSERT INTO `staff_skills` VALUES ('53', '46', '6', '护工');
INSERT INTO `staff_skills` VALUES ('54', '47', '6', '护工');
INSERT INTO `staff_skills` VALUES ('55', '48', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('56', '48', '3', '月嫂');
INSERT INTO `staff_skills` VALUES ('57', '48', '6', '护工');
INSERT INTO `staff_skills` VALUES ('58', '49', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('59', '49', '4', '育儿嫂');
INSERT INTO `staff_skills` VALUES ('60', '49', '6', '护工');
INSERT INTO `staff_skills` VALUES ('61', '50', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('62', '50', '6', '护工');
INSERT INTO `staff_skills` VALUES ('63', '51', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('64', '51', '3', '月嫂');
INSERT INTO `staff_skills` VALUES ('65', '52', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('66', '52', '6', '护工');
INSERT INTO `staff_skills` VALUES ('67', '53', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('68', '54', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('69', '55', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('70', '55', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('71', '56', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('72', '57', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('73', '58', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('74', '59', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('75', '60', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('76', '60', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('77', '61', '4', '育儿嫂');
INSERT INTO `staff_skills` VALUES ('78', '62', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('79', '62', '6', '护工');
INSERT INTO `staff_skills` VALUES ('80', '63', '6', '护工');
INSERT INTO `staff_skills` VALUES ('81', '64', '6', '护工');
INSERT INTO `staff_skills` VALUES ('82', '65', '6', '护工');
INSERT INTO `staff_skills` VALUES ('83', '66', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('84', '67', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('85', '68', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('86', '69', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('87', '70', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('88', '71', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('89', '72', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('90', '73', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('91', '74', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('92', '75', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('93', '76', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('94', '77', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('95', '77', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('96', '78', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('97', '79', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('98', '79', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('99', '80', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('100', '81', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('101', '81', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('102', '82', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('103', '83', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('104', '84', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('105', '85', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('106', '86', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('107', '87', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('108', '87', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('109', '88', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('110', '88', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('111', '89', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('112', '90', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('113', '91', '6', '护工');
INSERT INTO `staff_skills` VALUES ('114', '92', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('115', '93', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('116', '94', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('117', '95', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('118', '96', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('119', '97', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('120', '98', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('121', '99', '1', '小时工');
INSERT INTO `staff_skills` VALUES ('125', '4', '2', '保姆');
INSERT INTO `staff_skills` VALUES ('126', '3', '2', '保姆');

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
