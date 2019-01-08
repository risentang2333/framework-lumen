/*
 Navicat MySQL Data Transfer

 Source Server         : 127.0.0.1
 Source Server Type    : MySQL
 Source Server Version : 50553
 Source Host           : 127.0.0.1:3306
 Source Schema         : framework

 Target Server Type    : MySQL
 Target Server Version : 50553
 File Encoding         : 65001

 Date: 08/01/2019 22:28:28
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) NOT NULL,
  `name` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '服务项目分类表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for items
-- ----------------------------
DROP TABLE IF EXISTS `items`;
CREATE TABLE `items`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `price` float(11, 2) NOT NULL DEFAULT 0.00,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `payment_method` tinyint(1) NOT NULL DEFAULT 0 COMMENT '付款方式',
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '项目状态0：启用，1：禁用',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '服务项目表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for managers
-- ----------------------------
DROP TABLE IF EXISTS `managers`;
CREATE TABLE `managers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `access_token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `refresh_token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT 0,
  `is_administrator` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否为超级管理员 0：否，1:是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '管理员表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of managers
-- ----------------------------
INSERT INTO `managers` VALUES (1, 'admin', 'f973988be6cba09855f84c34d10e8a62', '唐朝', 'b55d246b686515a0d68ea208dd8d8237', '70397e79e0988a9520dce291c89400fc', 1547196263, 1);

-- ----------------------------
-- Table structure for orders
-- ----------------------------
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `worker_id` int(11) NOT NULL DEFAULT 0,
  `code` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `total_amount` float(11, 2) NOT NULL DEFAULT 0.00,
  `pay_amount` float(11, 2) NOT NULL DEFAULT 0.00,
  `prepayment_amount` float(11, 2) NOT NULL DEFAULT 0.00 COMMENT '预支付金额',
  `final_amount` float(11, 2) NOT NULL DEFAULT 0.00 COMMENT '尾款金额',
  `service_address` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `service_start_time` int(11) NOT NULL DEFAULT 0,
  `service_end_time` int(11) NOT NULL DEFAULT 0,
  `created_at` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '订单表' ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of permission_role
-- ----------------------------
INSERT INTO `permission_role` VALUES (1, 1, 1);
INSERT INTO `permission_role` VALUES (2, 2, 1);
INSERT INTO `permission_role` VALUES (3, 3, 1);
INSERT INTO `permission_role` VALUES (4, 4, 1);
INSERT INTO `permission_role` VALUES (5, 5, 1);
INSERT INTO `permission_role` VALUES (6, 6, 1);
INSERT INTO `permission_role` VALUES (7, 7, 1);
INSERT INTO `permission_role` VALUES (8, 8, 1);

-- ----------------------------
-- Table structure for permissions
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `route` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '前端路由',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `description` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `icon` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `sort_order` tinyint(2) NOT NULL DEFAULT 0 COMMENT '排序编号',
  `parent_id` int(11) NOT NULL DEFAULT 0 COMMENT '父级id',
  `is_display` tinyint(1) NOT NULL DEFAULT 0 COMMENT '菜单是否显示，0：不显示，1：显示',
  `is_administrator` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否为超管权限， 0：否，1：是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 9 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of permissions
-- ----------------------------
INSERT INTO `permissions` VALUES (1, 'permission/getManage', '测试', '测试', '', 0, 0, 1, 0);
INSERT INTO `permissions` VALUES (2, 'permission/editManagerRole', '测试2', '测试2', '', 0, 0, 1, 0);
INSERT INTO `permissions` VALUES (3, 'permission/getMenu', '测试3', '测试3', '', 0, 2, 1, 0);
INSERT INTO `permissions` VALUES (4, 'permission/getManagerRole', '测试4', '测试4', '', 3, 3, 1, 0);
INSERT INTO `permissions` VALUES (5, 'permission/getManage', '测试5', '测试5', '', 1, 3, 1, 0);
INSERT INTO `permissions` VALUES (6, 'permission/editManager', '测试6', '测试6', '', 2, 3, 1, 0);
INSERT INTO `permissions` VALUES (7, 'permission/getRolePermission', '测试7', '测试7', '', 0, 2, 1, 0);
INSERT INTO `permissions` VALUES (8, 'permission/deleteManager', '测试8', '测试8', '', 1, 2, 1, 0);

-- ----------------------------
-- Table structure for role_manager
-- ----------------------------
DROP TABLE IF EXISTS `role_manager`;
CREATE TABLE `role_manager`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL DEFAULT 0,
  `role_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of role_manager
-- ----------------------------
INSERT INTO `role_manager` VALUES (4, 1, 1);

-- ----------------------------
-- Table structure for roles
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `is_administrator` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否为超级管理员 0：否，1：是',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES (1, '超级管理员', 1);
INSERT INTO `roles` VALUES (2, '角色2', 0);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT 0 COMMENT '过期时间',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '' COMMENT '头像图标',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '用户表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'tc', '2147483647', '1083cd22ba7ebd98821c00960054b281', '8af4d92f590b36d45d09bc2d443d868b', 1546765323, '');

-- ----------------------------
-- Table structure for workers
-- ----------------------------
DROP TABLE IF EXISTS `workers`;
CREATE TABLE `workers`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `phone` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `password` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `expire` int(11) NOT NULL DEFAULT 0 COMMENT '过期时间',
  `icon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `age` tinyint(3) NOT NULL DEFAULT 0,
  `level` tinyint(3) NOT NULL DEFAULT 0,
  `service_type` tinyint(3) NOT NULL DEFAULT 0 COMMENT '服务类型',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '员工表' ROW_FORMAT = Compact;

-- ----------------------------
-- Records of workers
-- ----------------------------
INSERT INTO `workers` VALUES (1, 'tc', '13998836590', '07e37942f02cb497d3d1483fe53320e0', '', 0, '', 0, 0, 0);

SET FOREIGN_KEY_CHECKS = 1;
