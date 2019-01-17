/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : framework

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-01-17 11:03:15
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for areas
-- ----------------------------
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '行政区划代码',
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of areas
-- ----------------------------
INSERT INTO `areas` VALUES ('1', '辽宁省', '210000', '1', '0');
INSERT INTO `areas` VALUES ('2', '沈阳市', '210100', '2', '1');
INSERT INTO `areas` VALUES ('3', '市辖区', '210101', '3', '2');
INSERT INTO `areas` VALUES ('4', '和平区', '210102', '3', '2');
INSERT INTO `areas` VALUES ('5', '沈河区', '210103', '3', '2');
INSERT INTO `areas` VALUES ('6', '大东区', '210104', '3', '2');
INSERT INTO `areas` VALUES ('7', '皇姑区', '210105', '3', '2');
INSERT INTO `areas` VALUES ('8', '铁西区', '210106', '3', '2');
INSERT INTO `areas` VALUES ('9', '苏家屯区', '210111', '3', '2');
INSERT INTO `areas` VALUES ('10', '浑南区', '210112', '3', '2');
INSERT INTO `areas` VALUES ('11', '沈北新区', '210113', '3', '2');
INSERT INTO `areas` VALUES ('12', '于洪区', '210114', '3', '2');
INSERT INTO `areas` VALUES ('13', '辽中区', '210115', '3', '2');
INSERT INTO `areas` VALUES ('14', '康平县', '210123', '3', '2');
INSERT INTO `areas` VALUES ('15', '法库县', '210124', '3', '2');
INSERT INTO `areas` VALUES ('16', '新民市', '210181', '3', '2');
INSERT INTO `areas` VALUES ('17', '大连市', '210200', '2', '1');
INSERT INTO `areas` VALUES ('18', '市辖区', '210201', '3', '17');
INSERT INTO `areas` VALUES ('19', '中山区', '210202', '3', '17');
INSERT INTO `areas` VALUES ('20', '西岗区', '210203', '3', '17');
INSERT INTO `areas` VALUES ('21', '沙河口区', '210204', '3', '17');
INSERT INTO `areas` VALUES ('22', '甘井子区', '210211', '3', '17');
INSERT INTO `areas` VALUES ('23', '旅顺口区', '210212', '3', '17');
INSERT INTO `areas` VALUES ('24', '金州区', '210213', '3', '17');
INSERT INTO `areas` VALUES ('25', '普兰店区', '210214', '3', '17');
INSERT INTO `areas` VALUES ('26', '长海县', '210224', '3', '17');
INSERT INTO `areas` VALUES ('27', '瓦房店市', '210281', '3', '17');
INSERT INTO `areas` VALUES ('28', '庄河市', '210283', '3', '17');
INSERT INTO `areas` VALUES ('29', '鞍山市', '210300', '2', '1');
INSERT INTO `areas` VALUES ('30', '市辖区', '210301', '3', '29');
INSERT INTO `areas` VALUES ('31', '铁东区', '210302', '3', '29');
INSERT INTO `areas` VALUES ('32', '铁西区', '210303', '3', '29');
INSERT INTO `areas` VALUES ('33', '立山区', '210304', '3', '29');
INSERT INTO `areas` VALUES ('34', '千山区', '210311', '3', '29');
INSERT INTO `areas` VALUES ('35', '台安县', '210321', '3', '29');
INSERT INTO `areas` VALUES ('36', '岫岩满族自治县', '210323', '3', '29');
INSERT INTO `areas` VALUES ('37', '海城市', '210381', '3', '29');
INSERT INTO `areas` VALUES ('38', '抚顺市', '210400', '2', '1');
INSERT INTO `areas` VALUES ('39', '市辖区', '210401', '3', '38');
INSERT INTO `areas` VALUES ('40', '新抚区', '210402', '3', '38');
INSERT INTO `areas` VALUES ('41', '东洲区', '210403', '3', '38');
INSERT INTO `areas` VALUES ('42', '望花区', '210404', '3', '38');
INSERT INTO `areas` VALUES ('43', '顺城区', '210411', '3', '38');
INSERT INTO `areas` VALUES ('44', '抚顺县', '210421', '3', '38');
INSERT INTO `areas` VALUES ('45', '新宾满族自治县', '210422', '3', '38');
INSERT INTO `areas` VALUES ('46', '清原满族自治县', '210423', '3', '38');
INSERT INTO `areas` VALUES ('47', '本溪市', '210500', '2', '1');
INSERT INTO `areas` VALUES ('48', '市辖区', '210501', '3', '47');
INSERT INTO `areas` VALUES ('49', '平山区', '210502', '3', '47');
INSERT INTO `areas` VALUES ('50', '溪湖区', '210503', '3', '47');
INSERT INTO `areas` VALUES ('51', '明山区', '210504', '3', '47');
INSERT INTO `areas` VALUES ('52', '南芬区', '210505', '3', '47');
INSERT INTO `areas` VALUES ('53', '本溪满族自治县', '210521', '3', '47');
INSERT INTO `areas` VALUES ('54', '桓仁满族自治县', '210522', '3', '47');
INSERT INTO `areas` VALUES ('55', '丹东市', '210600', '2', '1');
INSERT INTO `areas` VALUES ('56', '市辖区', '210601', '3', '55');
INSERT INTO `areas` VALUES ('57', '元宝区', '210602', '3', '55');
INSERT INTO `areas` VALUES ('58', '振兴区', '210603', '3', '55');
INSERT INTO `areas` VALUES ('59', '振安区', '210604', '3', '55');
INSERT INTO `areas` VALUES ('60', '宽甸满族自治县', '210624', '3', '55');
INSERT INTO `areas` VALUES ('61', '东港市', '210681', '3', '55');
INSERT INTO `areas` VALUES ('62', '凤城市', '210682', '3', '55');
INSERT INTO `areas` VALUES ('63', '锦州市', '210700', '2', '1');
INSERT INTO `areas` VALUES ('64', '市辖区', '210701', '3', '63');
INSERT INTO `areas` VALUES ('65', '古塔区', '210702', '3', '63');
INSERT INTO `areas` VALUES ('66', '凌河区', '210703', '3', '63');
INSERT INTO `areas` VALUES ('67', '太和区', '210711', '3', '63');
INSERT INTO `areas` VALUES ('68', '黑山县', '210726', '3', '63');
INSERT INTO `areas` VALUES ('69', '义县', '210727', '3', '63');
INSERT INTO `areas` VALUES ('70', '凌海市', '210781', '3', '63');
INSERT INTO `areas` VALUES ('71', '北镇市', '210782', '3', '63');
INSERT INTO `areas` VALUES ('72', '营口市', '210800', '2', '1');
INSERT INTO `areas` VALUES ('73', '市辖区', '210801', '3', '72');
INSERT INTO `areas` VALUES ('74', '站前区', '210802', '3', '72');
INSERT INTO `areas` VALUES ('75', '西市区', '210803', '3', '72');
INSERT INTO `areas` VALUES ('76', '鲅鱼圈区', '210804', '3', '72');
INSERT INTO `areas` VALUES ('77', '老边区', '210811', '3', '72');
INSERT INTO `areas` VALUES ('78', '盖州市', '210881', '3', '72');
INSERT INTO `areas` VALUES ('79', '大石桥市', '210882', '3', '72');
INSERT INTO `areas` VALUES ('80', '阜新市', '210900', '2', '1');
INSERT INTO `areas` VALUES ('81', '市辖区', '210901', '3', '80');
INSERT INTO `areas` VALUES ('82', '海州区', '210902', '3', '80');
INSERT INTO `areas` VALUES ('83', '新邱区', '210903', '3', '80');
INSERT INTO `areas` VALUES ('84', '太平区', '210904', '3', '80');
INSERT INTO `areas` VALUES ('85', '清河门区', '210905', '3', '80');
INSERT INTO `areas` VALUES ('86', '细河区', '210911', '3', '80');
INSERT INTO `areas` VALUES ('87', '阜新蒙古族自治县', '210921', '3', '80');
INSERT INTO `areas` VALUES ('88', '彰武县', '210922', '3', '80');
INSERT INTO `areas` VALUES ('89', '辽阳市', '211000', '2', '1');
INSERT INTO `areas` VALUES ('90', '市辖区', '211001', '3', '89');
INSERT INTO `areas` VALUES ('91', '白塔区', '211002', '3', '89');
INSERT INTO `areas` VALUES ('92', '文圣区', '211003', '3', '89');
INSERT INTO `areas` VALUES ('93', '宏伟区', '211004', '3', '89');
INSERT INTO `areas` VALUES ('94', '弓长岭区', '211005', '3', '89');
INSERT INTO `areas` VALUES ('95', '太子河区', '211011', '3', '89');
INSERT INTO `areas` VALUES ('96', '辽阳县', '211021', '3', '89');
INSERT INTO `areas` VALUES ('97', '灯塔市', '211081', '3', '89');
INSERT INTO `areas` VALUES ('98', '盘锦市', '211100', '2', '1');
INSERT INTO `areas` VALUES ('99', '市辖区', '211101', '3', '98');
INSERT INTO `areas` VALUES ('100', '双台子区', '211102', '3', '98');
INSERT INTO `areas` VALUES ('101', '兴隆台区', '211103', '3', '98');
INSERT INTO `areas` VALUES ('102', '大洼区', '211104', '3', '98');
INSERT INTO `areas` VALUES ('103', '盘山县', '211122', '3', '98');
INSERT INTO `areas` VALUES ('104', '铁岭市', '211200', '2', '1');
INSERT INTO `areas` VALUES ('105', '市辖区', '211201', '3', '104');
INSERT INTO `areas` VALUES ('106', '银州区', '211202', '3', '104');
INSERT INTO `areas` VALUES ('107', '清河区', '211204', '3', '104');
INSERT INTO `areas` VALUES ('108', '铁岭县', '211221', '3', '104');
INSERT INTO `areas` VALUES ('109', '西丰县', '211223', '3', '104');
INSERT INTO `areas` VALUES ('110', '昌图县', '211224', '3', '104');
INSERT INTO `areas` VALUES ('111', '调兵山市', '211281', '3', '104');
INSERT INTO `areas` VALUES ('112', '开原市', '211282', '3', '104');
INSERT INTO `areas` VALUES ('113', '朝阳市', '211300', '2', '1');
INSERT INTO `areas` VALUES ('114', '市辖区', '211301', '3', '113');
INSERT INTO `areas` VALUES ('115', '双塔区', '211302', '3', '113');
INSERT INTO `areas` VALUES ('116', '龙城区', '211303', '3', '113');
INSERT INTO `areas` VALUES ('117', '朝阳县', '211321', '3', '113');
INSERT INTO `areas` VALUES ('118', '建平县', '211322', '3', '113');
INSERT INTO `areas` VALUES ('119', '喀喇沁左翼蒙古族自治县', '211324', '3', '113');
INSERT INTO `areas` VALUES ('120', '北票市', '211381', '3', '113');
INSERT INTO `areas` VALUES ('121', '凌源市', '211382', '3', '113');
INSERT INTO `areas` VALUES ('122', '葫芦岛市', '211400', '2', '1');
INSERT INTO `areas` VALUES ('123', '市辖区', '211401', '3', '122');
INSERT INTO `areas` VALUES ('124', '连山区', '211402', '3', '122');
INSERT INTO `areas` VALUES ('125', '龙港区', '211403', '3', '122');
INSERT INTO `areas` VALUES ('126', '南票区', '211404', '3', '122');
INSERT INTO `areas` VALUES ('127', '绥中县', '211421', '3', '122');
INSERT INTO `areas` VALUES ('128', '建昌县', '211422', '3', '122');
INSERT INTO `areas` VALUES ('129', '兴城市', '211481', '3', '122');

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL DEFAULT '',
  `price` float(11,2) NOT NULL DEFAULT '0.00',
  `payment_method` tinyint(1) NOT NULL DEFAULT '0' COMMENT '付款方式',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '项目状态0：启用，1：禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='服务项目表';

-- ----------------------------
-- Records of items
-- ----------------------------

-- ----------------------------
-- Table structure for item_category
-- ----------------------------
DROP TABLE IF EXISTS `item_category`;
CREATE TABLE `item_category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='项目分类';

-- ----------------------------
-- Records of item_category
-- ----------------------------

-- ----------------------------
-- Table structure for managers
-- ----------------------------
DROP TABLE IF EXISTS `managers`;
CREATE TABLE `managers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL DEFAULT '' COMMENT '账号',
  `password` varchar(40) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `access_token` varchar(64) NOT NULL DEFAULT '',
  `refresh_token` varchar(64) NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT '0',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为超级管理员 0：否，1:是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- ----------------------------
-- Records of managers
-- ----------------------------
INSERT INTO `managers` VALUES ('1', 'admin', 'f973988be6cba09855f84c34d10e8a62', '超级管理员', '9b0caaab7f0c960d2f585c422e96a109', '9087d701ce5625521006f2a9c39a6936', '1547455986', '0', '0');
INSERT INTO `managers` VALUES ('2', 'admin2', 'f973988be6cba09855f84c34d10e8a62', '管理员', 'f5c7766a5bd763aab890250dd6e25bdd', 'c9eff2bb4576055da7ba1f346088cda7', '1547775883', '0', '0');

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL DEFAULT '0',
  `code` varchar(20) NOT NULL DEFAULT '',
  `total_amount` float(11,2) NOT NULL DEFAULT '0.00',
  `pay_amount` float(11,2) NOT NULL DEFAULT '0.00',
  `prepayment_amount` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '预支付金额',
  `final_amount` float(11,2) NOT NULL DEFAULT '0.00' COMMENT '尾款金额',
  `service_address` varchar(200) NOT NULL DEFAULT '',
  `service_start_time` int(11) NOT NULL DEFAULT '0',
  `service_end_time` int(11) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单表';

-- ----------------------------
-- Records of orders
-- ----------------------------

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '前端路由',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `description` varchar(20) NOT NULL DEFAULT '',
  `icon` varchar(30) NOT NULL DEFAULT '',
  `sort_order` tinyint(2) NOT NULL DEFAULT '0' COMMENT '排序编号',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `is_api` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为api接口路由',
  `is_display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '菜单是否显示，0：不显示，1：显示',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为超管权限， 0：否，1：是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '权限删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限表';

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES ('1', 'admin/login', '接口-管理员登录', '', '', '0', '0', '0', '0', '0', '1');
INSERT INTO `permissions` VALUES ('2', 'admin/changeToken', '接口-更新token', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('3', 'admin/permission/getMenu', '接口-获取菜单', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('4', 'admin/permission/getManagerList', '接口-获取管理员列表', '', '', '0', '0', '0', '1', '0', '0');
INSERT INTO `permissions` VALUES ('5', 'admin/permission/getManagerRole', '接口-获取管理员角色信息', '', '', '0', '4', '0', '1', '0', '0');
INSERT INTO `permissions` VALUES ('6', 'admin/permission/editManagerRole', '接口-绑定管理员角色', '', '', '0', '5', '0', '1', '0', '0');
INSERT INTO `permissions` VALUES ('7', 'admin/permission/getManager', '接口-获取管理员信息', '', '', '0', '5', '0', '1', '0', '0');
INSERT INTO `permissions` VALUES ('8', 'admin/permission/editManager', '接口-编辑管理员信息', '', '', '0', '4', '0', '1', '0', '0');
INSERT INTO `permissions` VALUES ('9', 'admin/permission/deleteManager', '接口-删除管理员信息', '', '', '0', '0', '0', '1', '0', '0');
INSERT INTO `permissions` VALUES ('10', 'admin/permission/getRoleList', '接口-获取角色列表', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('11', 'admin/permission/getRole', '接口-获取角色信息', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('12', 'admin/permission/editRole', '接口-编辑角色信息', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('13', 'admin/permission/deleteRole', '接口-删除角色', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('14', 'admin/permission/getRolePermission', '接口-获取角色权限信息', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('15', 'admin/permission/editRolePermission', '接口-编辑角色权限信息', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('16', 'admin/permission/getPermissionList', '接口-获取权限列表', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('17', 'admin/permission/addPermission', '接口-获取添加权限数据', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('18', 'admin/permission/getPermission', '接口-获取权限信息', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('19', 'admin/permission/editPermission', '接口-编辑权限', '', '', '0', '0', '0', '0', '0', '0');
INSERT INTO `permissions` VALUES ('20', 'admin/permission/deleteRole', '接口-删除权限', '', '', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限角色关联表';

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES ('1', '1', '1');
INSERT INTO `permission_role` VALUES ('2', '2', '1');
INSERT INTO `permission_role` VALUES ('3', '3', '1');
INSERT INTO `permission_role` VALUES ('4', '4', '1');
INSERT INTO `permission_role` VALUES ('5', '5', '1');
INSERT INTO `permission_role` VALUES ('6', '6', '1');
INSERT INTO `permission_role` VALUES ('7', '7', '1');
INSERT INTO `permission_role` VALUES ('8', '8', '1');
INSERT INTO `permission_role` VALUES ('9', '9', '1');
INSERT INTO `permission_role` VALUES ('10', '10', '1');
INSERT INTO `permission_role` VALUES ('11', '11', '1');
INSERT INTO `permission_role` VALUES ('12', '12', '1');
INSERT INTO `permission_role` VALUES ('13', '13', '1');
INSERT INTO `permission_role` VALUES ('14', '14', '1');
INSERT INTO `permission_role` VALUES ('15', '15', '1');
INSERT INTO `permission_role` VALUES ('16', '16', '1');
INSERT INTO `permission_role` VALUES ('17', '17', '1');
INSERT INTO `permission_role` VALUES ('18', '18', '1');
INSERT INTO `permission_role` VALUES ('19', '19', '1');
INSERT INTO `permission_role` VALUES ('20', '20', '1');

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为超级管理员 0：否，1：是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '角色删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '0', '0');

-- ----------------------------
-- Table structure for role_manager
-- ----------------------------
DROP TABLE IF EXISTS `role_manager`;
CREATE TABLE `role_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色账号关联表';

-- ----------------------------
-- Records of role_manager
-- ----------------------------
INSERT INTO `role_manager` VALUES ('1', '1', '1');
INSERT INTO `role_manager` VALUES ('4', '2', '1');
INSERT INTO `role_manager` VALUES ('5', '2', '2');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号，作为登录账号',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `icon` varchar(100) NOT NULL DEFAULT '' COMMENT '头像图标',
  `age` tinyint(3) NOT NULL DEFAULT '0' COMMENT '年龄',
  `level` tinyint(3) NOT NULL DEFAULT '0' COMMENT '星级',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '现居住地',
  `category` varchar(10) NOT NULL DEFAULT '' COMMENT '工种',
  `access_token` varchar(64) NOT NULL DEFAULT '' COMMENT '认证令牌',
  `refresh_token` varchar(64) NOT NULL DEFAULT '' COMMENT '刷新token',
  `expire` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：删除',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='员工表';

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', '路人甲', '13333333333', '', '', '1', '5', '', '', '', '', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for staff_category
-- ----------------------------
DROP TABLE IF EXISTS `staff_category`;
CREATE TABLE `staff_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COMMENT='工人分类表';

-- ----------------------------
-- Records of staff_category
-- ----------------------------
INSERT INTO `staff_category` VALUES ('1', '家电维修', '0');
INSERT INTO `staff_category` VALUES ('2', '空调清洗', '1');
INSERT INTO `staff_category` VALUES ('3', '冰箱清洗', '1');
INSERT INTO `staff_category` VALUES ('4', '洗衣机清洗', '1');
INSERT INTO `staff_category` VALUES ('5', '热水器清洗', '1');
INSERT INTO `staff_category` VALUES ('6', '燃气灶清洗', '1');
INSERT INTO `staff_category` VALUES ('7', '饮水机清洗', '1');
INSERT INTO `staff_category` VALUES ('8', '微波炉清洗', '1');
INSERT INTO `staff_category` VALUES ('9', '房屋维修', '0');
INSERT INTO `staff_category` VALUES ('10', '开换汽车锁', '9');
INSERT INTO `staff_category` VALUES ('11', '开保险柜', '9');
INSERT INTO `staff_category` VALUES ('12', '开换地锁', '9');
INSERT INTO `staff_category` VALUES ('13', '门禁维修', '9');
INSERT INTO `staff_category` VALUES ('14', '健康', '0');
INSERT INTO `staff_category` VALUES ('15', '按摩理疗', '14');
INSERT INTO `staff_category` VALUES ('16', '小儿推拿', '14');
INSERT INTO `staff_category` VALUES ('17', '局部理疗', '14');
INSERT INTO `staff_category` VALUES ('18', '产妇护理', '14');

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
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户表';

-- ----------------------------
-- Records of users
-- ----------------------------
