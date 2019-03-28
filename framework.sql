/*
Navicat MySQL Data Transfer

Source Server         : 60.205.200.55
Source Server Version : 50560
Source Host           : 60.205.200.55:6666
Source Database       : framework

Target Server Type    : MYSQL
Target Server Version : 50560
File Encoding         : 65001

Date: 2019-03-29 00:27:54
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for abilities
-- ----------------------------
DROP TABLE IF EXISTS `abilities`;
CREATE TABLE `abilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '能力名',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '启用状态',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：删除',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COMMENT='标签分类';

-- ----------------------------
-- Records of abilities
-- ----------------------------
INSERT INTO `abilities` VALUES ('1', '形象气质类', '0', 'disable', '0', '11');
INSERT INTO `abilities` VALUES ('2', '干净立正', '1', 'disable', '0', '11');
INSERT INTO `abilities` VALUES ('3', '有亲和力', '1', 'disable', '0', '11');
INSERT INTO `abilities` VALUES ('4', '有文化', '1', 'disable', '0', '11');
INSERT INTO `abilities` VALUES ('5', '职业技能类', '0', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('6', '会做饭', '5', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('7', '会打扫', '5', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('8', '做过日常保洁', '5', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('9', '高级技能类', '0', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('10', '专业护工', '9', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('11', '十年以上经验', '9', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('12', '会营养搭配', '9', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('13', '会高级熨烫', '9', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('14', '会早教', '9', 'enable', '0', '0');
INSERT INTO `abilities` VALUES ('15', '新的节能', '0', 'enable', '0', '1');
INSERT INTO `abilities` VALUES ('16', '有亲和力', '0', 'enable', '0', '1');

-- ----------------------------
-- Table structure for areas
-- ----------------------------
DROP TABLE IF EXISTS `areas`;
CREATE TABLE `areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '地区名',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '行政区划代码',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '地区级别',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8mb4 COMMENT='地区表';

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='管理员表';

-- ----------------------------
-- Records of managers
-- ----------------------------
INSERT INTO `managers` VALUES ('1', 'admin', 'f973988be6cba09855f84c34d10e8a62', '超级管理员', 'b99f79ab7d17c3630b8b4c37a6832f0a', '807d31d6078a00e51ff7ecea83ff211d', '1553876853', '1', '0');
INSERT INTO `managers` VALUES ('2', 'tangchao', 'b60510d71c8d17df14ce7b2c548f716e', '唐朝', 'be271831918e056b82d222f2949a401c', '9fcc963c28dfa623e7bea0c2d32588ca', '1553875747', '1', '0');
INSERT INTO `managers` VALUES ('3', 'songxiwen', 'bcc7e1dd92254ef41b2abd8fc453fbb3', '宋希文', 'f763992402b99292f224cbbac3f5a8f0', 'd3d2da95426e8573ca265b5ca3eeb265', '1553860206', '1', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COMMENT='订单合同文件';

-- ----------------------------
-- Records of order_files
-- ----------------------------
INSERT INTO `order_files` VALUES ('1', '3', 'picture.jpeg', 'temp/5dec487a0ef981b51cadd4a83fd30842.jpeg');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COMMENT='订单日志';

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COMMENT='订单匹配人员';

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='订单表';

-- ----------------------------
-- Records of orders
-- ----------------------------
INSERT INTO `orders` VALUES ('1', '2019032884460000001', '1', '超级管理员', '2', '唐朝', '2', '唐朝', '0', '', '8', '宁敬之', '15001279361', '2', '空调清洗', '辽宁省沈阳市铁西区云峰北街勋望小学1年3班', '1551744000', '1551758400', '1', '此订单来自于线下。由于是学校订单，请注意保持安静，请处理人员小心，妥善处理。', 'month', '3', '23.56', '70.68', '2', '3', '44.33', '5', '1553770978', '3');
INSERT INTO `orders` VALUES ('2', '2019032853360000002', '2', '唐朝', '2', '唐朝', '2', '唐朝', '0', '', '11', '王女士', '13899977894', '16', '小儿推拿', '辽宁省沈阳市铁西区某某路某某小区4-4-1', '1553835600', '1556625600', '3', '要长得帅的', 'day', '4', '23.55', '94.20', '2', '3', '33.00', '3', '1553775416', '3');
INSERT INTO `orders` VALUES ('3', '2019032820710000003', '2', '唐朝', '1', '超级管理员', '1', '超级管理员', '0', '', '12', '测试', '13333443434', '11', '开保险柜', '辽宁省沈阳市和平区测试测试', '1552492800', '1555257600', '2', '测试测试', 'day', '3', '500.00', '1500.00', '1', '0', '0.00', '3', '1553775896', '2');
INSERT INTO `orders` VALUES ('4', '2019032868170000004', '2', '唐朝', '1', '超级管理员', '0', '', '0', '', '13', '测试测试', '13333333333', '11', '开保险柜', '辽宁省大连市西岗区测试', '1552492800', '1556035200', '2', '测试', '', '0', '0.00', '0.00', '1', '0', '0.00', '2', '1553783623', '1');
INSERT INTO `orders` VALUES ('5', '2019032977790000005', '2', '唐朝', '2', '唐朝', '0', '', '0', '', '13', '测试', '13333333333', '3', '冰箱清洗', '辽宁省沈阳市市辖区测试测试', '1552579200', '1555344000', '2', '测试', '', '0', '0.00', '0.00', '1', '0', '0.00', '1', '1553788839', '0');

-- ----------------------------
-- Table structure for paper_categories
-- ----------------------------
DROP TABLE IF EXISTS `paper_categories`;
CREATE TABLE `paper_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '工作状态',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：删除',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='证件类型表';

-- ----------------------------
-- Records of paper_categories
-- ----------------------------
INSERT INTO `paper_categories` VALUES ('1', '身份证', 'enable', '0', '3');
INSERT INTO `paper_categories` VALUES ('2', '健康证', 'enable', '0', '0');
INSERT INTO `paper_categories` VALUES ('3', '会计证', 'enable', '0', '0');
INSERT INTO `paper_categories` VALUES ('4', '导游证', 'enable', '0', '0');
INSERT INTO `paper_categories` VALUES ('5', '教师资格证', 'disable', '0', '1');

-- ----------------------------
-- Table structure for permission_role
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `permission_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限角色关联表';

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
INSERT INTO `permission_role` VALUES ('22', '12', '1');
INSERT INTO `permission_role` VALUES ('23', '13', '1');
INSERT INTO `permission_role` VALUES ('24', '14', '1');
INSERT INTO `permission_role` VALUES ('25', '13', '2');
INSERT INTO `permission_role` VALUES ('26', '14', '2');
INSERT INTO `permission_role` VALUES ('27', '11', '3');
INSERT INTO `permission_role` VALUES ('28', '12', '3');
INSERT INTO `permission_role` VALUES ('29', '10', '2');
INSERT INTO `permission_role` VALUES ('30', '10', '3');
INSERT INTO `permission_role` VALUES ('31', '15', '1');
INSERT INTO `permission_role` VALUES ('32', '16', '1');
INSERT INTO `permission_role` VALUES ('33', '17', '1');
INSERT INTO `permission_role` VALUES ('34', '18', '1');
INSERT INTO `permission_role` VALUES ('35', '19', '1');
INSERT INTO `permission_role` VALUES ('36', '20', '1');
INSERT INTO `permission_role` VALUES ('37', '21', '1');
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
INSERT INTO `permission_role` VALUES ('48', '17', '3');
INSERT INTO `permission_role` VALUES ('49', '18', '3');
INSERT INTO `permission_role` VALUES ('50', '19', '3');
INSERT INTO `permission_role` VALUES ('51', '15', '3');
INSERT INTO `permission_role` VALUES ('52', '16', '3');
INSERT INTO `permission_role` VALUES ('53', '20', '3');
INSERT INTO `permission_role` VALUES ('54', '21', '3');
INSERT INTO `permission_role` VALUES ('55', '10', '4');

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
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='权限表';

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
INSERT INTO `permissions` VALUES ('12', '/staff/staffList', '服务人员列表', '服务人员列表', '0', '11', '1', '1', '0');
INSERT INTO `permissions` VALUES ('13', '/sale', '销售管理', '销售管理', '3', '0', '2', '1', '0');
INSERT INTO `permissions` VALUES ('14', '/sale/orderList', '订单列表', '订单列表', '0', '13', '1', '1', '0');
INSERT INTO `permissions` VALUES ('15', '/serviceType/skillList', '技能列表', '技能列表', '1', '11', '1', '1', '0');
INSERT INTO `permissions` VALUES ('16', '/serviceType/skillConfig', '技能配置', '技能配置', '0', '15', '2', '1', '0');
INSERT INTO `permissions` VALUES ('17', '/staff/staffItem', '服务人员配置', '服务人员配置', '0', '12', '2', '1', '0');
INSERT INTO `permissions` VALUES ('18', '/serviceType/paperList', '证书列表', '证书列表', '1', '11', '1', '1', '0');
INSERT INTO `permissions` VALUES ('19', '/serviceType/paperConfig', '证书配置', '证书配置', '2', '18', '2', '1', '0');
INSERT INTO `permissions` VALUES ('20', '/serviceType/abilityList', '能力标签列表', '能力标签列表', '3', '11', '1', '1', '0');
INSERT INTO `permissions` VALUES ('21', '/serviceType/abilityConfig', '能力标签配置', '能力标签配置', '3', '20', '2', '1', '0');
INSERT INTO `permissions` VALUES ('22', '/sale/orderEdit', '订单基本信息', '订单基本信息', '0', '14', '2', '1', '0');
INSERT INTO `permissions` VALUES ('23', '/sale/orderConfig', '订单配置', '订单配置', '1', '14', '2', '1', '0');
INSERT INTO `permissions` VALUES ('24', '/sale/orderAssignList', '订单派发', '订单派发', '1', '13', '1', '1', '0');
INSERT INTO `permissions` VALUES ('25', 'cc', 'cc', 'cc', '0', '0', '2', '1', '1');

-- ----------------------------
-- Table structure for role_manager
-- ----------------------------
DROP TABLE IF EXISTS `role_manager`;
CREATE TABLE `role_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manager_id` int(11) NOT NULL DEFAULT '0',
  `role_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色账号关联表';

-- ----------------------------
-- Records of role_manager
-- ----------------------------
INSERT INTO `role_manager` VALUES ('1', '1', '1');
INSERT INTO `role_manager` VALUES ('13', '2', '2');
INSERT INTO `role_manager` VALUES ('15', '5', '3');
INSERT INTO `role_manager` VALUES ('16', '4', '2');
INSERT INTO `role_manager` VALUES ('23', '2', '1');
INSERT INTO `role_manager` VALUES ('24', '2', '3');
INSERT INTO `role_manager` VALUES ('25', '2', '4');
INSERT INTO `role_manager` VALUES ('26', '3', '1');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='角色表';

-- ----------------------------
-- Records of roles
-- ----------------------------
INSERT INTO `roles` VALUES ('1', '超级管理员', '0', '0');
INSERT INTO `roles` VALUES ('2', '销售业务员', '0', '0');
INSERT INTO `roles` VALUES ('3', '人力资源业务员', '1', '0');
INSERT INTO `roles` VALUES ('4', '销售管理员', '1', '0');
INSERT INTO `roles` VALUES ('5', '人力资源管理员', '1', '1');

-- ----------------------------
-- Table structure for service_categories
-- ----------------------------
DROP TABLE IF EXISTS `service_categories`;
CREATE TABLE `service_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '工作状态',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：删除',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COMMENT='项目分类';

-- ----------------------------
-- Records of service_categories
-- ----------------------------
INSERT INTO `service_categories` VALUES ('1', '家电维修', '0', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('2', '空调清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('3', '冰箱清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('4', '洗衣机清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('5', '热水器清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('6', '燃气灶清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('7', '饮水机清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('8', '微波炉清洗', '1', 'enable', '0', '5');
INSERT INTO `service_categories` VALUES ('9', '房屋维修', '0', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('10', '开换汽车锁', '9', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('11', '开保险柜', '9', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('12', '开换地锁', '9', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('13', '门禁维修', '9', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('14', '健康', '0', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('15', '按摩理疗', '14', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('16', '小儿推拿', '14', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('17', '局部理疗', '14', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('18', '产妇护理', '14', 'enable', '0', '0');
INSERT INTO `service_categories` VALUES ('19', '保健按摩', '14', 'disable', '0', '1');

-- ----------------------------
-- Table structure for service_items
-- ----------------------------
DROP TABLE IF EXISTS `service_items`;
CREATE TABLE `service_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务分类id',
  `service_item_name` varchar(200) NOT NULL DEFAULT '',
  `type` enum('','enable','disable') NOT NULL DEFAULT 'enable' COMMENT '工作状态',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：删除',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='基础服务表';

-- ----------------------------
-- Records of service_items
-- ----------------------------

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '员工编号',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `sex` tinyint(1) NOT NULL DEFAULT '1' COMMENT '性别 0：全部，1：男，2：女',
  `identify` varchar(20) NOT NULL DEFAULT '' COMMENT '身份证号',
  `nation` varchar(20) NOT NULL DEFAULT '' COMMENT '民族',
  `phone` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号，作为登录账号',
  `wechat` varchar(50) NOT NULL DEFAULT '' COMMENT '微信号',
  `password` varchar(64) NOT NULL DEFAULT '' COMMENT '密码',
  `access_token` varchar(64) NOT NULL DEFAULT '' COMMENT '认证令牌',
  `refresh_token` varchar(64) NOT NULL DEFAULT '' COMMENT '刷新token',
  `expire` int(11) NOT NULL DEFAULT '0' COMMENT '过期时间',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '头像图标',
  `age` tinyint(3) NOT NULL DEFAULT '0' COMMENT '年龄',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '现居住地',
  `education` tinyint(1) NOT NULL DEFAULT '0' COMMENT '学历 0：全部，1：博士，2：硕士，3：本科，4：大专，5：中专，6：高中，7：初中，8：小学',
  `bank_card` varchar(30) NOT NULL DEFAULT '' COMMENT '银行卡号',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态，0：正常，1：停用',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  `type` enum('normal','sign') NOT NULL DEFAULT 'normal' COMMENT '状态',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `phone` (`phone`) USING BTREE COMMENT '手机号唯一性约束'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='员工表';

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', '00001', '宋希文', '1', '210111199407250517', '', '15001279361', '', '', '', '', '0', 'icon/1/5c4234a430dd88470c15c72757571e25.jpeg', '25', '沈阳市大东区小北关街43#1-6-1', '0', '6214831249176063', '0', '1553770449', '10', 'sign');
INSERT INTO `staff` VALUES ('2', '00002', '弗兰克', '1', '210222197009171123', '', '15001234567', '', '', '', '', '0', 'icon/1/5ffe47bca3e7402afe915b3247b52468.jpeg', '60', '北京市昌平区物美超市2#1-0-9', '0', '6214831249176063', '0', '1553772643', '2', 'sign');
INSERT INTO `staff` VALUES ('3', '00003', '王女士', '2', '210105199504224911', '汉', '13998989889', '13998836590', '', '', '', '0', 'icon/1/338d1254be5423ca95449454e77dd6aa.jpg', '18', '辽宁省沈阳市长江街黑山路松山南区', '0', '6214831249176063', '0', '1553785906', '0', 'normal');

-- ----------------------------
-- Table structure for staff_labels
-- ----------------------------
DROP TABLE IF EXISTS `staff_labels`;
CREATE TABLE `staff_labels` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `ability_id` int(11) NOT NULL DEFAULT '0' COMMENT '能力id',
  `name` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='员工标签';

-- ----------------------------
-- Records of staff_labels
-- ----------------------------
INSERT INTO `staff_labels` VALUES ('1', '1', '2', '干净立正');
INSERT INTO `staff_labels` VALUES ('2', '1', '11', '十年以上经验');
INSERT INTO `staff_labels` VALUES ('3', '3', '7', '会打扫');
INSERT INTO `staff_labels` VALUES ('4', '2', '6', '会做饭');

-- ----------------------------
-- Table structure for staff_papers
-- ----------------------------
DROP TABLE IF EXISTS `staff_papers`;
CREATE TABLE `staff_papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '员工id',
  `paper_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '证件类型id',
  `paper_category_name` varchar(30) NOT NULL DEFAULT '' COMMENT '姓名',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '姓名',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '图片地址',
  `index` tinyint(1) NOT NULL DEFAULT '0' COMMENT '图片排序索引',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='员工证书';

-- ----------------------------
-- Records of staff_papers
-- ----------------------------
INSERT INTO `staff_papers` VALUES ('1', '1', '2', '健康证', ' CVVVVV.jpeg', 'paper/1/d8bcabfdbc000e160612efc2bb370ddb.jpeg', '0');
INSERT INTO `staff_papers` VALUES ('2', '3', '1', '身份证', '头像.jpg', 'paper/1/1c2c46ab8f4d808e74f7ca6d0dcf9953.jpg', '0');
INSERT INTO `staff_papers` VALUES ('3', '2', '3', '会计证', ' CVVVVV.jpeg', 'paper/1/cc77fdf7168d105c4e6335d2eb7e9be3.jpeg', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COMMENT='员工服务地区表';

-- ----------------------------
-- Records of staff_regions
-- ----------------------------
INSERT INTO `staff_regions` VALUES ('2', '1', '20', '西岗区');
INSERT INTO `staff_regions` VALUES ('3', '3', '5', '沈河区');
INSERT INTO `staff_regions` VALUES ('4', '3', '6', '大东区');
INSERT INTO `staff_regions` VALUES ('5', '2', '4', '和平区');

-- ----------------------------
-- Table structure for staff_skills
-- ----------------------------
DROP TABLE IF EXISTS `staff_skills`;
CREATE TABLE `staff_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_id` int(11) NOT NULL DEFAULT '0' COMMENT '服务人员id',
  `service_category_id` int(11) NOT NULL DEFAULT '0' COMMENT '技能类型id',
  `name` varchar(30) NOT NULL DEFAULT '',
  `level` tinyint(1) NOT NULL DEFAULT '0' COMMENT '星级',
  `service_length` int(5) NOT NULL DEFAULT '0' COMMENT '工龄',
  `experience` int(5) NOT NULL DEFAULT '0' COMMENT '工作经验',
  `job_type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '职业类型 0：全部，1：全职，2：兼职',
  `workable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否可工作 0：全部，1：可工作，2：不能工作',
  `review` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核状态 0：全部，1：未审核， 2：通过，3：不通过',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '审核备注',
  `version` tinyint(1) NOT NULL DEFAULT '0' COMMENT '操作版本号，防止多端错误操作',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COMMENT='工人分类表';

-- ----------------------------
-- Records of staff_skills
-- ----------------------------
INSERT INTO `staff_skills` VALUES ('1', '1', '2', '空调清洗', '0', '0', '0', '1', '1', '1', '', '0');
INSERT INTO `staff_skills` VALUES ('2', '1', '12', '开换地锁', '0', '0', '0', '1', '1', '1', '', '0');
INSERT INTO `staff_skills` VALUES ('3', '3', '11', '开保险柜', '0', '0', '0', '1', '1', '0', '', '0');
INSERT INTO `staff_skills` VALUES ('4', '2', '3', '冰箱清洗', '0', '0', '0', '1', '1', '1', '', '0');

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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='用户表';

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
