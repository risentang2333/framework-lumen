/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : framework

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-01-14 10:41:35
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `account` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(40) NOT NULL DEFAULT '',
  `name` varchar(20) NOT NULL DEFAULT '',
  `access_token` varchar(64) NOT NULL DEFAULT '',
  `refresh_token` varchar(64) NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT '0',
  `is_administrator` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为超级管理员 0：否，1:是',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '管理员删除状态0：正常，1：已删除',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- ----------------------------
-- Records of managers
-- ----------------------------
INSERT INTO `managers` VALUES ('1', 'admin', 'f973988be6cba09855f84c34d10e8a62', '超级管理员', '17548331c907aa6a24ed723a3fb8214f', '98cca5549ed6c0e060fc4d2a0f6380e7', '1547432577', '1', '0');

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
INSERT INTO `permissions` VALUES ('3', 'admin/permission/getMenu', '接口-获取菜单', '', '', '0', '0', '0', '0', '1', '0');
INSERT INTO `permissions` VALUES ('4', 'admin/permission/getManagerList', '接口-获取管理员列表', '', '', '0', '0', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('5', 'admin/permission/getManagerRole', '接口-获取管理员角色信息', '', '', '0', '4', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('6', 'admin/permission/editManagerRole', '接口-绑定管理员角色', '', '', '0', '5', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('7', 'admin/permission/getManager', '接口-获取管理员信息', '', '', '0', '5', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('8', 'admin/permission/editManager', '接口-编辑管理员信息', '', '', '0', '4', '0', '1', '1', '0');
INSERT INTO `permissions` VALUES ('9', 'admin/permission/deleteManager', '接口-删除管理员信息', '', '', '0', '0', '0', '1', '1', '0');
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
INSERT INTO `roles` VALUES ('1', '超级管理员', '1', '1');

-- ----------------------------
-- Table structure for role_manager
-- ----------------------------
DROP TABLE IF EXISTS `role_manager`;
CREATE TABLE `role_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色账号关联表';

-- ----------------------------
-- Records of role_manager
-- ----------------------------
INSERT INTO `role_manager` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `phone` varchar(11) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `token` varchar(64) NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `icon` varchar(100) NOT NULL DEFAULT '',
  `age` tinyint(3) NOT NULL DEFAULT '0',
  `level` tinyint(3) NOT NULL DEFAULT '0',
  `service_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '服务类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='员工表';

-- ----------------------------
-- Records of staff
-- ----------------------------

-- ----------------------------
-- Table structure for staff_category
-- ----------------------------
DROP TABLE IF EXISTS `staff_category`;
CREATE TABLE `staff_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='工人分类表';

-- ----------------------------
-- Records of staff_category
-- ----------------------------

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
