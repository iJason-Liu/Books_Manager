/*
 Navicat Premium Data Transfer

 Source Server         : Jason
 Source Server Type    : MySQL
 Source Server Version : 50728 (5.7.28)
 Source Host           : localhost:3306
 Source Schema         : library

 Target Server Type    : MySQL
 Target Server Version : 50728 (5.7.28)
 File Encoding         : 65001

 Date: 09/03/2023 11:28:04
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access_user
-- ----------------------------
DROP TABLE IF EXISTS `access_user`;
CREATE TABLE `access_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(64) COLLATE utf8_unicode_ci NOT NULL COMMENT '加密的密码',
  `user_type` varchar(30) COLLATE utf8_unicode_ci NOT NULL COMMENT '角色',
  PRIMARY KEY (`user_id`) USING BTREE,
  KEY `user_type` (`user_type`)
) ENGINE=MyISAM AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of access_user
-- ----------------------------
BEGIN;
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (101, 'zhangsan', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (102, 'admin', 'e99a18c428cb38d5f260853678922e03', '图书管理员');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (103, 'sadmin', 'dc483e80a7a0bd9ef71d8cf973673924', '超级管理员');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (105, '张鸿飞', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (115, '小小', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (116, 'zhf', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (117, 'lisi', 'e99a18c428cb38d5f260853678922e03', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (118, '李四', 'dc483e80a7a0bd9ef71d8cf973673924', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (119, 'lisii', 'dc483e80a7a0bd9ef71d8cf973673924', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (120, 'test1', 'e80b5017098950fc58aad83c8c14978e', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (121, 'test12', 'f6ee70a48d8d21f0787241f72a23ab0f', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (122, 'test122', 'f6ee70a48d8d21f0787241f72a23ab0f', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (123, 'test122', 'f6ee70a48d8d21f0787241f72a23ab0f', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (124, 'admin', '7fa8282ad93047a4d6fe6111c93b308a', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (125, 'admin', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (126, 'admin1', '47bce5c74f589f4867dbd57e9ca9f808', '学生');
INSERT INTO `access_user` (`user_id`, `user_name`, `password`, `user_type`) VALUES (128, 'xiaohong', 'e10adc3949ba59abbe56e057f20f883e', '教师');
COMMIT;

-- ----------------------------
-- Table structure for book_list
-- ----------------------------
DROP TABLE IF EXISTS `book_list`;
CREATE TABLE `book_list` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书编号',
  `book_name` varchar(30) NOT NULL COMMENT '图书名称',
  `author` varchar(20) NOT NULL COMMENT '图书作者',
  `book_type` varchar(20) NOT NULL COMMENT '图书类别',
  `publisher` varchar(30) NOT NULL COMMENT '图书出版社',
  `price` int(11) NOT NULL COMMENT '图书价格',
  `number` int(11) NOT NULL COMMENT '图书库存数量',
  `mark` varchar(300) NOT NULL COMMENT '图书简介',
  `book_cover` varchar(100) DEFAULT NULL COMMENT '图书封面地址',
  `create_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '图书入库的时间截',
  `update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '图书更新信息时的记录时间',
  `save_position` varchar(255) DEFAULT NULL COMMENT '图书存放书库位置',
  `status` bit(1) NOT NULL COMMENT '图书借出状态',
  PRIMARY KEY (`book_id`) USING BTREE,
  KEY `book_name` (`book_name`)
) ENGINE=MyISAM AUTO_INCREMENT=10023 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of book_list
-- ----------------------------
BEGIN;
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10014, '《盗墓笔记》', '南派三叔', '玄幻类', '开远出版社', 180, 28, '以下均为测试数据123', '../upload/bookCover/test_1.webp', '2023-03-09 10:20:13', '2023-03-09 10:20:13', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10015, '《教父》', '[美] 马里奥·普佐', '文学类', '美国出版社', 20, 18, '测试数据测试数据', '../upload/bookCover/中文测试.webp', '2023-03-08 00:00:00', '2023-03-08 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10009, '《八千里路云和月》', '白先勇', '文学类', '中国友谊出版公司', 45, 15, '阿斯卡很勤快我好困', '../upload/bookCover/test_2.webp', '2023-03-08 00:00:00', '2023-03-08 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10008, '《万古江河：中国历史文化的转折与开展》', '许倬云', '著作类', '湖南人民出版社', 41, 56, '清华校长送给每一位2019级新生的书，极具世界眼光的中国通史 大历史叙述的经典之作。', '../upload/bookCover/多云.png', '2023-03-08 00:00:00', '2023-03-08 00:00:00', '图书馆二楼203', b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10016, '《茶花女》', ' [法国]小仲马', '文学类', '未知', 520, 20, '未知', '../upload/bookCover/黑猫.png', '2023-03-08 00:00:00', '2023-03-08 00:00:00', '', b'1');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10007, '《人间值得》', '[日]中村恒子', '励志类', '北京日报出版社', 46, 25, '宝藏奶奶的人生36条感悟，正面解读工作、家庭、人际关系、孤独、死亡等人生课题，给人直面生活的勇气，愿每个人都能从人间失格直至人间值得！罗丹、三毛、史铁生坚信的生活理念。愿你遍历山河，仍觉人间值得！', NULL, '2023-03-02 00:00:00', '2023-03-07 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10018, '《妖神记》', '发飙的蜗牛', '玄幻类', '新华出版社', 28, 100, '增加添加时间，也就是上架时间，\r\n心潮澎湃，无限幻想，迎风挥击千层浪，少年不败热血！', NULL, '2023-03-08 00:00:00', '2023-03-08 00:00:00', '图书馆三楼303', b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10019, '《炼气十万年》', 'Jason', '冒险类', '未知', 35, 23, '为突破炼气万归元闭关三万年，谁曾想炼气9999层都没能突破。正所谓一层为渣，两层为蠢，三层为废。然而万归元炼气9999层，却无敌天下，轰杀一切。无敌一时爽，一直无敌一直爽。作为活了三万年的老祖，唯一的烦恼就是无敌太寂寞。', '../upload/bookCover/富士山.png', '2023-03-08 00:00:00', '2023-03-08 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10020, '《成龙历险记》', '老爹', '冒险类', '未知', 52, 28, '图书借鉴', NULL, '2023-03-07 00:00:00', '2023-03-07 00:00:00', NULL, b'0');
COMMIT;

-- ----------------------------
-- Table structure for book_rank
-- ----------------------------
DROP TABLE IF EXISTS `book_rank`;
CREATE TABLE `book_rank` (
  `rank_num` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书的点击数量',
  `book_name` varchar(255) DEFAULT NULL COMMENT '被引用的图书名称',
  PRIMARY KEY (`rank_num`),
  KEY `book_name` (`book_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book_rank
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for book_stack
-- ----------------------------
DROP TABLE IF EXISTS `book_stack`;
CREATE TABLE `book_stack` (
  `stack_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '书库id',
  `stack_name` varchar(255) DEFAULT NULL COMMENT '书库名称',
  `stack_position` varchar(255) DEFAULT NULL COMMENT '书库位置',
  PRIMARY KEY (`stack_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of book_stack
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for book_type
-- ----------------------------
DROP TABLE IF EXISTS `book_type`;
CREATE TABLE `book_type` (
  `type_id` int(11) NOT NULL COMMENT '图书类别id',
  `type_name` varchar(50) NOT NULL COMMENT '类别名称',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of book_type
-- ----------------------------
BEGIN;
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1, '冒险类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (2, '文学类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (3, '励志类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (4, '悬疑类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (5, '历史类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (6, '玄幻类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (7, '著作类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (8, '政治类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (9, '经济类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (10, '军事类');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (11, '言情类');
COMMIT;

-- ----------------------------
-- Table structure for lib_worker
-- ----------------------------
DROP TABLE IF EXISTS `lib_worker`;
CREATE TABLE `lib_worker` (
  `worker_id` int(11) NOT NULL COMMENT '馆员id，工号',
  `worker_name` varchar(255) DEFAULT NULL COMMENT '馆员名字',
  `sex` bit(1) DEFAULT NULL COMMENT '性别，0为男，1为女',
  PRIMARY KEY (`worker_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of lib_worker
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `usertype_name` varchar(60) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`type_id`) USING BTREE,
  KEY `usertype_name` (`usertype_name`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of user_type
-- ----------------------------
BEGIN;
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (1, '学生');
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (2, '教师');
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (3, '图书管理员');
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (4, '超级管理员');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
