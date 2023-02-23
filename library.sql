/*
 Navicat MySQL Data Transfer

 Source Server         : Jason
 Source Server Type    : MySQL
 Source Server Version : 50726
 Source Host           : localhost:3306
 Source Schema         : library

 Target Server Type    : MySQL
 Target Server Version : 50726
 File Encoding         : 65001

 Date: 06/09/2022 15:46:03
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access_user
-- ----------------------------
DROP TABLE IF EXISTS `access_user`;
CREATE TABLE `access_user`  (
  `userid` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `username` varchar(25) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `password` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '加密的密码',
  `usertype` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT '角色',
  PRIMARY KEY (`userid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 118 CHARACTER SET = utf8 COLLATE = utf8_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of access_user
-- ----------------------------
INSERT INTO `access_user` VALUES (101, 'zhangsan', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` VALUES (102, 'admin', 'e99a18c428cb38d5f260853678922e03', '图书管理员');
INSERT INTO `access_user` VALUES (103, 'sadmin', 'dc483e80a7a0bd9ef71d8cf973673924', '超级管理员');
INSERT INTO `access_user` VALUES (105, '张鸿飞', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` VALUES (115, '小小', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` VALUES (116, 'zhf', 'e10adc3949ba59abbe56e057f20f883e', '学生');
INSERT INTO `access_user` VALUES (117, 'lisi', 'e99a18c428cb38d5f260853678922e03', '学生');

-- ----------------------------
-- Table structure for books
-- ----------------------------
DROP TABLE IF EXISTS `books`;
CREATE TABLE `books`  (
  `book_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书编号',
  `book_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图书名称',
  `price` int(11) NOT NULL COMMENT '图书价格',
  `author` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图书作者',
  `publisher` varchar(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '出版社',
  `book_type` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '图书类别',
  `number` int(11) NOT NULL COMMENT '数量',
  `mark` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '介绍',
  PRIMARY KEY (`book_id`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 10018 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of books
-- ----------------------------
INSERT INTO `books` VALUES (10014, '《盗墓笔记》', 180, '南派三叔', '开远出版社', '玄幻类', 28, '未知');
INSERT INTO `books` VALUES (10015, '《教父》', 20, '[美] 马里奥·普佐', '未知', '文学类', 18, '俺公司康克读书');
INSERT INTO `books` VALUES (10009, '《八千里路云和月》', 45, '白先勇', '中国友谊出版公司', '文学类', 15, '记录一个时代的生命轨迹与赤子魂魄，书写苍茫之上姹紫嫣红开遍的孤独。大江大河，乡愁未竞，美到极致，都有点凄凉！');
INSERT INTO `books` VALUES (10008, '《万古江河：中国历史文化的转折与开展》', 41, '许倬云', '湖南人民出版社', '著作类', 56, '清华校长送给每一位2019级新生的书，极具世界眼光的中国通史 大历史叙述的经典之作。');
INSERT INTO `books` VALUES (10016, '《茶花女》', 520, ' [法国]小仲马', '未知', '文学类', 20, '未知');
INSERT INTO `books` VALUES (10007, '《人间值得》', 46, '[日]中村恒子', '北京日报出版社', '励志类', 25, '宝藏奶奶的人生36条感悟，正面解读工作、家庭、人际关系、孤独、死亡等人生课题，给人直面生活的勇气，愿每个人都能从人间失格直至人间值得！罗丹、三毛、史铁生坚信的生活理念。愿你遍历山河，仍觉人间值得！');

-- ----------------------------
-- Table structure for bookstype
-- ----------------------------
DROP TABLE IF EXISTS `bookstype`;
CREATE TABLE `bookstype`  (
  `type_id` int(11) NOT NULL COMMENT '图书类别id',
  `type_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '类别名称',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of bookstype
-- ----------------------------
INSERT INTO `bookstype` VALUES (1, '冒险类');
INSERT INTO `bookstype` VALUES (2, '文学类');
INSERT INTO `bookstype` VALUES (3, '励志类');
INSERT INTO `bookstype` VALUES (4, '悬疑类');
INSERT INTO `bookstype` VALUES (5, '历史类');
INSERT INTO `bookstype` VALUES (6, '玄幻类');
INSERT INTO `bookstype` VALUES (7, '著作类');
INSERT INTO `bookstype` VALUES (8, '政治类');
INSERT INTO `bookstype` VALUES (9, '经济类');
INSERT INTO `bookstype` VALUES (10, '军事类');

-- ----------------------------
-- Table structure for usertype
-- ----------------------------
DROP TABLE IF EXISTS `usertype`;
CREATE TABLE `usertype`  (
  `typeid` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `usertypename` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`typeid`) USING BTREE
) ENGINE = MyISAM AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usertype
-- ----------------------------
INSERT INTO `usertype` VALUES (1, '学生');
INSERT INTO `usertype` VALUES (2, '教师');
INSERT INTO `usertype` VALUES (3, '图书管理员');
INSERT INTO `usertype` VALUES (4, '超级管理员');

SET FOREIGN_KEY_CHECKS = 1;
