/*
 Navicat Premium Data Transfer

 Source Server         : Tencent Cloud DB
 Source Server Type    : MySQL
 Source Server Version : 50741 (5.7.41-log)
 Source Host           : localhost:3306
 Source Schema         : test_db

 Target Server Type    : MySQL
 Target Server Version : 50741 (5.7.41-log)
 File Encoding         : 65001

 Date: 21/04/2023 09:27:04
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access_user
-- ----------------------------
DROP TABLE IF EXISTS `access_user`;
CREATE TABLE `access_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `cardNo` int(11) NOT NULL COMMENT '借阅卡号，对应各自的身份表',
  `user_name` varchar(128) NOT NULL COMMENT '用户名',
  `password` varchar(128) NOT NULL COMMENT '加密的密码',
  `user_type` varchar(120) NOT NULL COMMENT '角色，身份',
  PRIMARY KEY (`user_id`,`cardNo`) USING BTREE,
  UNIQUE KEY `cardNo` (`cardNo`) USING BTREE COMMENT '借阅卡号唯一'
) ENGINE=MyISAM AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户注册信息记录';

-- ----------------------------
-- Records of access_user
-- ----------------------------
BEGIN;
INSERT INTO `access_user` (`user_id`, `cardNo`, `user_name`, `password`, `user_type`) VALUES (102, 1003, 'admin', 'e99a18c428cb38d5f260853678922e03', '图书管理员');
INSERT INTO `access_user` (`user_id`, `cardNo`, `user_name`, `password`, `user_type`) VALUES (103, 19991011, 'sadmin', 'dc483e80a7a0bd9ef71d8cf973673924', '超级管理员');
INSERT INTO `access_user` (`user_id`, `cardNo`, `user_name`, `password`, `user_type`) VALUES (129, 2121502100, '黄思思', '74db87055a48267d8cc4a7b98e6f8ce2', '学生');
INSERT INTO `access_user` (`user_id`, `cardNo`, `user_name`, `password`, `user_type`) VALUES (130, 2113956200, '李思雨', '74db87055a48267d8cc4a7b98e6f8ce2', '教师');
INSERT INTO `access_user` (`user_id`, `cardNo`, `user_name`, `password`, `user_type`) VALUES (131, 2121502154, '刘建平', '74db87055a48267d8cc4a7b98e6f8ce2', '学生');
COMMIT;

-- ----------------------------
-- Table structure for avatar
-- ----------------------------
DROP TABLE IF EXISTS `avatar`;
CREATE TABLE `avatar` (
  `id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `path` varchar(128) NOT NULL COMMENT '头像路径',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='存放头像的表';

-- ----------------------------
-- Records of avatar
-- ----------------------------
BEGIN;
INSERT INTO `avatar` (`id`, `path`) VALUES (1, '../../skin/images/avatar/IMG_0201.png');
INSERT INTO `avatar` (`id`, `path`) VALUES (3, '../../skin/images/avatar/IMG_0203.PNG');
INSERT INTO `avatar` (`id`, `path`) VALUES (4, '../../skin/images/avatar/IMG_0204.PNG');
INSERT INTO `avatar` (`id`, `path`) VALUES (5, '../../skin/images/avatar/IMG_0205.PNG');
INSERT INTO `avatar` (`id`, `path`) VALUES (6, '../../skin/images/avatar/IMG_0206.PNG');
INSERT INTO `avatar` (`id`, `path`) VALUES (7, '../../skin/images/avatar/IMG_0208.PNG');
INSERT INTO `avatar` (`id`, `path`) VALUES (8, '../../skin/images/avatar/IMG_0209.JPG');
INSERT INTO `avatar` (`id`, `path`) VALUES (9, '../../skin/images/avatar/IMG_0212.PNG');
INSERT INTO `avatar` (`id`, `path`) VALUES (10, '../../skin/images/avatar/IMG_0210.PNG');
COMMIT;

-- ----------------------------
-- Table structure for book_borrow
-- ----------------------------
DROP TABLE IF EXISTS `book_borrow`;
CREATE TABLE `book_borrow` (
  `card_id` int(11) NOT NULL COMMENT '借阅卡号',
  `book_id` int(11) NOT NULL COMMENT '图书id',
  `book_name` varchar(128) NOT NULL COMMENT '借阅图书名称',
  `book_price` double NOT NULL DEFAULT '0' COMMENT '图书价格',
  `borrow_limitDay` tinyint(3) NOT NULL DEFAULT '90' COMMENT '借书期限',
  `left_day` tinyint(3) DEFAULT '0' COMMENT '借阅剩余天数',
  `borrow_date` varchar(120) DEFAULT NULL COMMENT '借书日期',
  `back_date` varchar(120) DEFAULT NULL COMMENT '还书截止日期',
  `renew_date` varchar(120) DEFAULT NULL COMMENT '续借日期',
  `renew_backDate` varchar(120) DEFAULT NULL COMMENT '续借后的还书日期',
  `renew_num` tinyint(3) DEFAULT '0' COMMENT '续借次数',
  PRIMARY KEY (`card_id`,`book_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图书借阅状态信息表';

-- ----------------------------
-- Records of book_borrow
-- ----------------------------
BEGIN;
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (100105, 10004, '茶花女', 0, 3, 1, '2023-04-17', '2023-04-20', NULL, NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (100105, 10005, '妖神记', 28, 60, 54, '2023-04-17', '2023-06-12', NULL, NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (100105, 10006, '成龙历险记', 56, 90, 88, '2023-04-17', '2023-07-16', NULL, NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (100105, 10008, '黄鹤楼', 2, 90, 88, '2023-04-17', '2023-07-16', NULL, NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (100105, 10010, '金庸小说', 0, 90, 89, '2023-04-18', '2023-07-17', NULL, NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (19991011, 10001, '人间值得', 46, 90, 96, '2023-04-19', '2023-07-18', '2023-04-20', '2023-07-25', 14);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`) VALUES (2121502112, 10015, '妖神记', 28, 90, 90, '2023-04-19', '2023-07-18', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for book_comment
-- ----------------------------
DROP TABLE IF EXISTS `book_comment`;
CREATE TABLE `book_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `user_name` varchar(128) NOT NULL COMMENT '用户名',
  `book_id` int(11) NOT NULL COMMENT '图书id',
  `book_name` varchar(128) NOT NULL COMMENT '图书名称',
  `content` text COMMENT '评论内容',
  `createtime` varchar(128) NOT NULL COMMENT '评论时间',
  PRIMARY KEY (`comment_id`,`user_id`,`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图书的评论管理';

-- ----------------------------
-- Records of book_comment
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for book_kind
-- ----------------------------
DROP TABLE IF EXISTS `book_kind`;
CREATE TABLE `book_kind` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书类别id',
  `type_name` varchar(50) NOT NULL COMMENT '类别名称',
  `mark` varchar(128) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='图书类别信息';

-- ----------------------------
-- Records of book_kind
-- ----------------------------
BEGIN;
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1001, '政治、法律', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1002, '文学', '备注1');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1003, '语言、文字', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1004, '社会科学总论', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1005, '历史、地理', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1006, '哲学、宗教', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1007, '马克思主义、列宁主义、毛泽东思想、邓小平理论', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1008, '医药、卫生', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1009, '经济', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1010, '军事', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1011, '自然科学总论', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1012, '艺术', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1013, '天文学、地球科学', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1014, '农业科学', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1015, '综合性图书', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1016, '环境科学、安全科学', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1017, '航空、航天', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1018, '交通运输', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1019, '工业技术', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1020, '文化、科学、教育、体育', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1021, '数理科学和化学', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1022, '生物科学', '');
COMMIT;

-- ----------------------------
-- Table structure for book_list
-- ----------------------------
DROP TABLE IF EXISTS `book_list`;
CREATE TABLE `book_list` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书编号',
  `ISBN` varchar(60) NOT NULL COMMENT '图书编号',
  `book_name` varchar(120) NOT NULL COMMENT '图书名称',
  `author` varchar(120) NOT NULL COMMENT '图书作者',
  `book_type` varchar(120) NOT NULL COMMENT '图书类别',
  `publisher` varchar(130) NOT NULL COMMENT '图书出版社',
  `publisher_date` varchar(120) DEFAULT NULL COMMENT '图书出版时间',
  `price` double NOT NULL DEFAULT '0' COMMENT '图书价格',
  `number` int(11) DEFAULT '1' COMMENT '图书库存数量',
  `mark` text COMMENT '图书简介',
  `book_cover` varchar(128) DEFAULT NULL COMMENT '图书封面地址',
  `book_source` varchar(128) DEFAULT NULL COMMENT '图书源文件',
  `save_position` varchar(150) DEFAULT NULL COMMENT '图书存放书库位置',
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '图书借阅状态',
  `borrow_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '图书被借阅次数',
  `create_date` varchar(120) NOT NULL COMMENT '图书入库的时间截',
  `update_date` varchar(120) DEFAULT NULL COMMENT '图书更新信息时的记录时间',
  PRIMARY KEY (`book_id`) USING BTREE,
  UNIQUE KEY `index_name_publisher` (`book_name`,`publisher`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=10035 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='馆藏图书的数据列表';

-- ----------------------------
-- Records of book_list
-- ----------------------------
BEGIN;
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10001, '978-7-03-020426-1	', '人间值得', '[日]中村恒子	', '马克思主义、列宁主义、毛泽东思想、邓小平理论 ', '北京日报出版社	', NULL, 46, 0, '宝藏奶奶的人生36条感悟，正面解读工作、家庭、人际关系、孤独、死亡等人生课题，给人直面生活的勇气，愿每个人都能从人间失格直至人间值得！罗丹、三毛、史铁生坚信的生活理念。愿你遍历山河，仍觉人间值得！	', '../../upload/bookCover/sampling.webp', NULL, '剔旧书库_	图书馆204 ', '1', 1, '2023-03-25 10:51:14', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10002, '978-7-03-020426-2	', '万古江河：中国历史文化的转折与开展', '许倬云	', '自然科学总论 ', '湖南人民出版社	', NULL, 41, 1, '清华校长送给每一位2019级新生的书，极具世界眼光的中国通史 大历史叙述的经典之作。	', '../../upload/bookCover/1680677311_book-default.gif', NULL, '综合书库	_图书馆301', '0', 0, '2023-03-25 10:51:14', '2023-04-05 14:48:31');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10003, '978-7-03-020426-4	', '八千里路云和月', '白先勇	', '文学类	', '中国友谊出版公司	', NULL, 45, 1, '这是一本小说11111122	', '../../upload/bookCover/1680677287_s29260063.jpg', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 10:51:14', '2023-04-05 14:48:07');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10004, '978-7-03-020426-5	', '《茶花女》', ' [法国]小仲马	', '文学类	', '未知	', NULL, 50, 12, '未知哈~', '../upload/bookCover/1680487643_s29506438.jpg', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 10:51:14', '2023-04-03 10:07:23');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10005, '978-7-03-020426-9	', '妖神记', '发飙的蜗牛	', '综合性图书	', '新华出版社	', NULL, 28, 0, '增加添加时间，也就是上架时间。心潮澎湃，无限幻想，迎风挥击千层浪，少年不败热血！', '../upload/bookCover/sampling.webp', NULL, '经济、军事书库	_图书馆402', '1', 1, '2023-03-25 10:51:14', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10006, '978-7-03-020426-7	', '成龙历险记', '老爹	', '综合性图书', '未知	', NULL, 52, 0, '图书借鉴	', '../../upload/bookCover/1680677325_book-default.gif', NULL, '史地书库	_图书馆302 ', '1', 1, '2023-03-25 10:51:14', '2023-04-05 14:48:45');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10007, '978-7-03-020426-3	', '自传', '无	', '历史、地理', '中国出版社', NULL, 12, 0, '你好，明天！	', '../upload/bookCover/sampling.webp', NULL, '哲社书库_图书馆203	', '1', 1, '2023-03-25 10:51:14', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10008, '978-7-03-020426-4	', '黄鹤楼', '不详', '综合性图书', '中国出版社', NULL, 2, 0, '故人西辞黄鹤楼', '', NULL, '综合书库	_图书馆301', '1', 1, '2023-03-25 10:51:14', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10009, '978-7-03-020426-6	', '紫川', '无	', '哲学、宗教', '未知	', NULL, 1, 1, '测试	', '../upload/bookCover/sampling.webp', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 10:51:14', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10010, '978-7-03-020426-9	', '金庸小说', '不详', '文学 ', '未知	', NULL, 6, 0, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '1', 1, '2023-03-25 10:51:14', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10011, '978-7-03-020426-1	', '人间值得', '[日]中村恒子	', '马克思主义、列宁主义、毛泽东思想、邓小平理论 ', '北京日报出版社', NULL, 46, 1, '宝藏奶奶的人生36条感悟，正面解读工作、家庭、人际关系、孤独、死亡等人生课题，给人直面生活的勇气，愿每个人都能从人间失格直至人间值得！罗丹、三毛、史铁生坚信的生活理念。愿你遍历山河，仍觉人间值得！	', '../upload/bookCover/sampling.webp', NULL, '剔旧书库_	图书馆204 ', '0', 0, '2023-03-25 10:57:06', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10012, '978-7-03-020426-2	', '万古江河：中国历史文化的转折与开展', '许倬云	', '自然科学总论 ', '湖南人民出版社', NULL, 41, 1, '清华校长送给每一位2019级新生的书，极具世界眼光的中国通史 大历史叙述的经典之作。	', '../upload/bookCover/sampling.webp', NULL, '综合书库	_图书馆301', '0', 0, '2023-03-25 10:57:06', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10014, '978-7-03-020426-5	', '茶花女', ' [法国]小仲马	', '文学类	', '未知', NULL, 50, 1, '未知	', '../upload/bookCover/1680676762_s29506438.jpg', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 10:57:06', '2023-04-05 14:39:22');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10015, '978-7-03-020426-9	', '妖神记', '发飙的蜗牛	', '综合性图书	', '新华出版社', NULL, 28, 0, '增加添加时间，也就是上架时间。心潮澎湃，无限幻想，迎风挥击千层浪，少年不败热血！', '../upload/bookCover/sampling.webp', NULL, '经济、军事书库	_图书馆402', '1', 1, '2023-03-25 10:57:06', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10016, '978-7-03-020426-7	', '成龙历险记', '老爹	', '综合性图书', '未知', NULL, 52, 1, '图书借鉴	', '../upload/bookCover/sampling.webp', NULL, '史地书库	_图书馆302 ', '0', 0, '2023-03-25 10:57:06', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10017, '978-7-03-020426-6	', '紫川', '无	', '哲学、宗教', '湖南人民出版社', NULL, 1, 1, '测试	', '../upload/bookCover/sampling.webp', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 10:57:06', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10018, '978-7-03-020426-9	', '《金庸小说》', '不详', '文学', '未知', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 10:57:06', '2023-03-29 23:32:21');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10019, '978-7-03-020426-4	', '八千里路云和月', '白先勇	', '文学类	', '中国友谊出版公司', NULL, 45, 1, '这是一本小说11111122	', '../upload/bookCover/sampling.webp', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 11:27:35', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10020, '111111111', '哈哈哈啊哈哈', '无	', '语言、文字 ', '未知', NULL, 2, 1, '三四十岁', '', NULL, '哲社书库	_图书馆203 ', '0', 0, '2023-03-25 11:33:08', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10021, '978-7-03-020426-9	', '金庸小说', '不详', '文学', '未知出版社', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 11:35:38', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10022, '978-7-03-020426-9	', '金庸小说2', '不详', '文学', '未知', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 11:44:20', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10023, '978-7-03-020426-9	', '《金庸小说12》', '不详', '文学', '未知', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 11:45:02', '2023-03-29 23:31:55');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10024, '111111111', '哈哈哈啊12哈哈', '无	', '语言、文字 ', '未知', NULL, 2, 1, '三四十岁', '', NULL, '哲社书库	_图书馆203 ', '0', 0, '2023-03-25 11:45:25', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10025, '978-7-03-020426-9	', '金庸小说5', '不详', '文学', '未知', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 11:45:25', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10026, '111111111', '哈哈哈', '无	', '语言、文字 ', '1', NULL, 2, 1, '三四十岁', '', NULL, '哲社书库	_图书馆203 ', '0', 0, '2023-03-25 12:02:25', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10027, '978-7-03-020426-9	', '金庸小说123', '不详', '文学', '未知', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 12:05:54', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10028, '978-7-03-020426-9	', '金庸小说6', '不详', '文学', '未知', NULL, 6, 1, 'hffhg	', '../upload/bookCover/sampling.webp', NULL, '中小型书库_图书馆102	', '0', 0, '2023-03-25 12:07:11', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10029, '978-7-03-020426-6	', '紫川2', '无	', '哲学、宗教', '湖南人民出版社', NULL, 1, 1, '测试	', '../upload/bookCover/sampling.webp', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 12:09:46', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10030, '978-7-03-020426-6	', '紫川2', '无	', '语言、文字 ', '湖南人民出版社00', NULL, 1, 1, '测试	', '../upload/bookCover/sampling.webp', NULL, '艺术书库_图书馆101	', '0', 0, '2023-03-25 12:18:24', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10031, '111111111', '哈哈哈', '无	', '语言、文字 ', '121', NULL, 2, 1, '三四十岁', '', NULL, '哲社书库	_图书馆203 ', '0', 0, '2023-03-25 12:18:24', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10032, '978-7-03-020426-9', '《大江大河》', '发飙的蜗牛', '哲学、宗教', '未知', NULL, 8, 1, 'kk', '../upload/bookCover/1679719153_', NULL, '文史书库_图书馆303', '0', 0, '2023-03-25 12:39:13', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10033, '978-7-03-020426-5', '《大江大河》', '艾思登', '历史、地理', '未知5', NULL, 9, 1, 'jj', '../upload/bookCover/1679719203_', NULL, '剔旧书库_图书馆204', '0', 0, '2023-03-25 12:40:03', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `create_date`, `update_date`) VALUES (10034, '1234', '鸡公三', '阿三', '生物科学', 'me', NULL, 0, 99, '姬霓太美', '../../upload/bookCover/1680785763_', NULL, '社科书库_图书馆401', '0', 0, '2023-04-06 20:56:03', NULL);
COMMIT;

-- ----------------------------
-- Table structure for book_rank
-- ----------------------------
DROP TABLE IF EXISTS `book_rank`;
CREATE TABLE `book_rank` (
  `book_id` int(11) NOT NULL COMMENT '图书id',
  `book_name` varchar(128) NOT NULL COMMENT '图书名称',
  `click_num` int(11) DEFAULT NULL COMMENT '查看次数',
  `borrow_num` int(11) NOT NULL COMMENT '借阅次数',
  PRIMARY KEY (`book_id`) USING BTREE,
  KEY `book_name` (`book_name`)
) ENGINE=MyISAM AUTO_INCREMENT=101 DEFAULT CHARSET=utf8 COMMENT='图书的点击量排行榜';

-- ----------------------------
-- Records of book_rank
-- ----------------------------
BEGIN;
INSERT INTO `book_rank` (`book_id`, `book_name`, `click_num`, `borrow_num`) VALUES (10001, '《茶花女》', 1, 0);
COMMIT;

-- ----------------------------
-- Table structure for book_stack
-- ----------------------------
DROP TABLE IF EXISTS `book_stack`;
CREATE TABLE `book_stack` (
  `stack_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '书库id',
  `stack_name` varchar(128) DEFAULT NULL COMMENT '书库名称',
  `stack_position` varchar(128) DEFAULT NULL COMMENT '书库位置',
  PRIMARY KEY (`stack_id`),
  KEY `stack_position` (`stack_position`)
) ENGINE=MyISAM AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8 COMMENT='书库信息';

-- ----------------------------
-- Records of book_stack
-- ----------------------------
BEGIN;
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1001, '理工书库', '图书馆103');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1002, '中小型书库', '图书馆102');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1003, '艺术书库', '图书馆101');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1004, '哲社书库', '图书馆203');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1005, '剔旧书库', '图书馆204');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1006, '文史书库', '图书馆303');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1007, '史地书库', '图书馆302');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1008, '综合书库', '图书馆301');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1009, '经济、军事书库', '图书馆402');
INSERT INTO `book_stack` (`stack_id`, `stack_name`, `stack_position`) VALUES (1010, '社科书库', '图书馆401');
COMMIT;

-- ----------------------------
-- Table structure for feedback
-- ----------------------------
DROP TABLE IF EXISTS `feedback`;
CREATE TABLE `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '反馈id',
  `user_id` int(11) DEFAULT NULL COMMENT '用户id',
  `name` varchar(128) DEFAULT NULL COMMENT '提交的用户（允许匿名）',
  `content` text NOT NULL COMMENT '反馈内容',
  `sub_time` varchar(128) NOT NULL COMMENT '提交时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户意见或建议反馈表';

-- ----------------------------
-- Records of feedback
-- ----------------------------
BEGIN;
INSERT INTO `feedback` (`id`, `user_id`, `name`, `content`, `sub_time`) VALUES (1, 0, '', '修改首页', '2023:04:08 14:36:45');
INSERT INTO `feedback` (`id`, `user_id`, `name`, `content`, `sub_time`) VALUES (2, 0, 'Jack', '添加图书馆信息模块', '2023:04:08 17:56:58');
COMMIT;

-- ----------------------------
-- Table structure for lib_worker
-- ----------------------------
DROP TABLE IF EXISTS `lib_worker`;
CREATE TABLE `lib_worker` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '馆员id，工号',
  `name` varchar(120) NOT NULL COMMENT '馆员名字',
  `password` varchar(128) NOT NULL DEFAULT 'e99a18c428cb38d5f260853678922e03' COMMENT '登录密码，默认abc123',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `mobile` varchar(11) DEFAULT NULL COMMENT '馆员电话',
  `user_type` varchar(128) NOT NULL DEFAULT '图书管理员' COMMENT '身份类别',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态（0正常，1异常）',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '12' COMMENT '可借阅图书的数量，默认12',
  `avatar` varchar(128) DEFAULT NULL COMMENT '用户头像路径',
  `session_id` varchar(128) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间，也是导入时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=100120 DEFAULT CHARSET=utf8 COMMENT='馆员信息表';

-- ----------------------------
-- Records of lib_worker
-- ----------------------------
BEGIN;
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100101, '李洋', '8d8984f2e6809ef17a1206f0ca91ff5b', '男', '19963456323', '图书管理员', '0', 12, NULL, '', '', NULL, '2023-04-02 20:22:49');
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100102, '李四', '8d8984f2e6809ef17a1206f0ca91ff5b', '女', '13333336667', '图书管理员', '0', 12, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100103, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '13333336667', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100105, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '13333336667', '图书管理员', '0', 5, '../../skin/images/avatar/IMG_0212.PNG', 'a5otehst827slr9vg40eisbjfa', '2023-04-19 14:55:15', NULL, '2023-04-05 14:53:23');
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100107, '王五', 'e99a18c428cb38d5f260853678922e03', '男', '18966678661', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100108, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '19205121314', '图书管理员', '0', 1, NULL, '', '', NULL, '2023-04-05 14:30:27');
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100109, '小华', 'e99a18c428cb38d5f260853678922e03', '男', '18603937537', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100110, 'Jack', 'e99a18c428cb38d5f260853678922e03', '男', '18603937538', '图书管理员', '0', 12, '../../skin/images/avatar/IMG_0203.png', '9c0i2tcn2p3cc4t15tp9fdvvvb', '2023-04-19 14:54:05', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100111, '小羊', 'e99a18c428cb38d5f260853678922e03', '女', '18603937539', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100112, '赤赤', 'e99a18c428cb38d5f260853678922e03', '男', '18603937540', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100113, '杨晓红', 'e99a18c428cb38d5f260853678922e03', '女', '18603937541', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100114, '李虎', 'e99a18c428cb38d5f260853678922e03', '男', '16647551692', '图书管理员', '0', 0, NULL, '', '', NULL, NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100119, '张鸿飞', '61a59bce2e11a7e9c824dd5d56a98ede', '男', '18888888888', '图书管理员', '0', 12, NULL, '', '', '2023-04-02 22:43:09', NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100117, 'Tsoft', 'dc483e80a7a0bd9ef71d8cf973673924', '男', '18387804014', '图书管理员', '0', 12, NULL, '', '', '2023-04-02 20:25:26', NULL);
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (100118, 'tsoft', '9cbf8a4dcb8e30682b927f352d6559a0', '女', '18387804014', '图书管理员', '0', 12, NULL, '', '', '2023-04-02 20:26:34', NULL);
COMMIT;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `cardNo` int(11) NOT NULL AUTO_INCREMENT COMMENT '学生id，学号，即借阅卡号',
  `name` varchar(120) NOT NULL COMMENT '学生姓名',
  `password` varchar(128) NOT NULL DEFAULT '74db87055a48267d8cc4a7b98e6f8ce2' COMMENT '登录密码，默认tsg123',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `department` varchar(128) DEFAULT NULL COMMENT '学院',
  `class` varchar(128) DEFAULT NULL COMMENT '班级',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `user_type` varchar(120) NOT NULL DEFAULT '学生' COMMENT '身份类型',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态，0正常，1异常',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '3' COMMENT '可借阅图书数量，默认3',
  `avatar` varchar(128) DEFAULT NULL COMMENT '用户头像路径',
  `session_id` varchar(120) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cardNo`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2121502204 DEFAULT CHARSET=utf8 COMMENT='学生表';

-- ----------------------------
-- Records of student
-- ----------------------------
BEGIN;
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502193, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', '2023-04-05 14:56:37', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502192, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', '2023-04-05 14:56:29', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502103, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502104, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502105, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, '../../skin/images/avatar/IMG_0203.PNG', '5h0h76p3esg6gi6j8akbkjfq41', '2023-04-19 10:27:50', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502106, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '13dm5tk8olomrm4t8blscj99e2', '2023-04-11 10:58:02', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502107, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502108, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502109, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502110, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502111, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502112, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, '../../skin/images/avatar/IMG_0206.PNG', '7ictcgmlj98r8m76ou0t4siqt7', '2023-04-19 12:01:33', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502113, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502114, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502115, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502116, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502117, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502118, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502119, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502120, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502121, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502122, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502123, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502124, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502125, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502126, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502127, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502128, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502129, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502130, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502131, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '2023-04-02 20:59:30');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502132, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502133, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502134, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502135, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502136, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502137, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502138, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502139, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502140, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502141, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502142, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502143, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502144, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502145, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502146, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502147, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502148, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502149, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502150, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502151, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502152, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502153, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502154, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502155, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502156, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502157, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502158, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502159, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502160, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502161, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502162, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502163, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502164, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502165, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502166, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502167, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502168, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502169, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502170, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502171, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502172, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502173, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502174, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502175, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502176, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502177, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502178, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502179, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502180, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502181, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502182, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502183, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502184, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502185, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502186, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502187, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502188, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502189, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502190, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '8j5jfui5s0b4f14qfhon4tgk43', '2023:04:10 17:59:57', NULL, '');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502191, 'tsoft', 'd477887b0636e5d87f79cc25c99d7dc9', '女', '马院', '马克思主义二班', '18387804014', '学生', '0', 3, NULL, '', '', '2023-04-02 20:32:21', '2023-04-02 20:39:16');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502194, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502195, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '音乐学院', '计算机科学与技术二班', '19987675652', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502196, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术学院', '计算机科学与技术三班', '18966678661', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502197, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '工程技术学院', '音乐一班', '19205121314', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502198, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '数学学院', '体育一班', '18603937537', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502199, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '人文学院', '体育二班', '18603937538', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502200, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '教育学院', '马克思主义一班', '18603937539', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502201, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502202, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2121502203, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '18603937542', '学生', '0', 3, NULL, '', '', '2023-04-05 14:58:17', NULL);
COMMIT;

-- ----------------------------
-- Table structure for super_admin
-- ----------------------------
DROP TABLE IF EXISTS `super_admin`;
CREATE TABLE `super_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(120) NOT NULL COMMENT '用户名',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `password` varchar(128) NOT NULL COMMENT '密码',
  `user_type` varchar(128) NOT NULL DEFAULT '超级管理员' COMMENT '身份',
  `mobile` varchar(11) NOT NULL COMMENT '电话',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态（0正常，1异常）',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '99' COMMENT '可借阅图书的数量',
  `avatar` varchar(128) DEFAULT NULL COMMENT '头像路径',
  `session_id` varchar(128) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `createtime` varchar(120) NOT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改密码时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=230630522 DEFAULT CHARSET=utf8 COMMENT='超级管理员表';

-- ----------------------------
-- Records of super_admin
-- ----------------------------
BEGIN;
INSERT INTO `super_admin` (`id`, `username`, `sex`, `password`, `user_type`, `mobile`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (19991011, 'sadmin', '男', '74db87055a48267d8cc4a7b98e6f8ce2', '超级管理员', '19018711920', '0', 99, '../../skin/images/avatar/IMG_0212.PNG', 'd50k8n6pslokjm7fm9kmv6tped', '2023-04-20 22:34:31', '2023-03-25', NULL);
COMMIT;

-- ----------------------------
-- Table structure for sys_msg
-- ----------------------------
DROP TABLE IF EXISTS `sys_msg`;
CREATE TABLE `sys_msg` (
  `id` int(5) NOT NULL AUTO_INCREMENT COMMENT '消息id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `sender` varchar(20) NOT NULL DEFAULT '系统消息' COMMENT '发送者',
  `content` text NOT NULL COMMENT '消息内容',
  `state` enum('0','1') NOT NULL COMMENT '是否已读（0未读，1已读）',
  `createtime` varchar(120) NOT NULL COMMENT '消息发送时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 COMMENT='系统消息表';

-- ----------------------------
-- Records of sys_msg
-- ----------------------------
BEGIN;
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (84, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 09:04:09');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (81, 100105, '登录提醒', 'Hi！张三，您于2023-04-19 14:55:15成功登录系统，登录IP：116.249.214.156，归属地：云南省昆明市 电信', '0', '2023-04-19 14:55:15');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (82, 19991011, '登录提醒', 'Hi！sadmin，您于2023-04-19 21:40:41成功登录系统，登录IP：39.128.16.172，归属地：云南省昆明市 移通', '0', '2023-04-19 21:40:41');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (83, 19991011, '登录提醒', 'Hi！sadmin，您于2023-04-20 08:59:35成功登录系统，登录IP：116.249.214.156，归属地：云南省昆明市 电信', '0', '2023-04-20 08:59:35');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (98, 19991011, '登录提醒', 'Hi！sadmin，您于2023-04-20 22:34:31成功登录系统，登录IP：39.128.16.172，归属地：云南省昆明市 移通', '0', '2023-04-20 22:34:31');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (97, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:04');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (12, 2121502106, '系统消息', 'Hello！Jack，您于2023-04-06 01:07:06成功登录系统，登录IP：', '1', '2023-04-06 01:07:06');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (13, 19991011, '系统消息', 'Hello！sadmin，您于2023-04-06 08:26:31成功登录系统，登录IP：106.61.201.249', '1', '2023-04-06 08:26:31');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (96, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:45');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (15, 2121502106, '系统消息', 'Hello！Jack，您于2023-04-06 09:03:54成功登录系统，登录IP：42.243.21.92', '0', '2023-04-06 09:03:54');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (16, 2121502106, '系统消息', 'Hello！Jack，您于2023-04-06 09:04:43成功登录系统，登录IP：42.243.21.92', '0', '2023-04-06 09:04:43');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (17, 2121502190, '系统消息', 'Hello！李虎，您于2023-04-06 13:46:18成功登录系统，登录IP：112.112.243.118', '1', '2023-04-06 13:46:18');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (18, 19991011, '系统消息', 'Hello！sadmin，您于2023-04-06 14:53:56成功登录系统，登录IP：42.243.21.92', '1', '2023-04-06 14:53:56');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (80, 100110, '登录提醒', 'Hi！Jack，您于2023-04-19 14:54:05成功登录系统，登录IP：116.249.214.156，归属地：云南省昆明市 电信', '0', '2023-04-19 14:54:05');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (20, 100119, '系统消息', 'Hello！张鸿飞，您于2023-04-06 20:47:33成功登录系统，登录IP：112.117.181.187', '1', '2023-04-06 20:47:33');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (21, 100119, '系统消息', 'Hello！张鸿飞，您于2023-04-06 20:53:20成功登录系统，登录IP：112.117.181.187', '0', '2023-04-06 20:53:20');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (78, 2121502112, '登录提醒', 'Hi！李四，您于2023-04-19 12:01:33成功登录系统，登录IP：112.112.243.144，归属地：云南省昆明市 电信', '0', '2023-04-19 12:01:33');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (79, 2121502112, '图书借阅通知', '李四，恭喜您于2023-04-19 12:04:47成功借阅《妖神记》，借阅期限90天，请在2023-07-18前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '0', '2023-04-19 12:04:47');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (95, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:57');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (94, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:22');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (93, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:35');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (92, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:23');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (91, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:29');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (90, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:18');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (35, 2121502106, '系统消息', 'Hello！Jack，您于2023:04:08 17:55:06成功登录系统，登录IP：39.128.15.215', '0', '');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (36, 19991011, '系统消息', 'Hello！sadmin，您于2023:04:08 18:10:13成功登录系统，登录IP：39.128.15.215', '1', '');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (37, 2121502190, '系统消息', 'Hello！李虎，您于2023:04:10 17:59:57成功登录系统，登录IP：106.57.238.0', '0', '');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (38, 19991011, '系统消息', 'Hello！sadmin，您于2023:04:10 22:59:08成功登录系统，登录IP：39.128.15.93', '1', '');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (39, 2121502105, '系统消息', 'Hello！Jack，您于2023-04-11 10:58:02成功登录系统，登录IP：116.54.54.168', '0', '2023-04-11 10:58:02');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (40, 19991011, '系统消息', 'Hello！sadmin，您于2023-04-11 12:16:33成功登录系统，登录IP：116.54.54.168', '0', '2023-04-11 12:16:33');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (41, 100110, '系统消息', 'Hello！Jack，您于2023-04-12 23:01:54成功登录系统，登录IP：39.128.16.114', '1', '2023-04-12 23:01:54');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (42, 100110, '系统消息', 'Hello！Jack，您于2023-04-12 23:01:54成功登录系统，登录IP：106.57.169.172', '1', '2023-04-12 23:01:54');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (43, 100110, '系统消息', 'Hello！Jack，您于2023-04-12 23:07:32成功登录系统，登录IP：39.128.16.114', '1', '2023-04-12 23:07:32');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (89, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:36');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (88, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:13');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (87, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:53');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (47, 19991011, '登录提醒', 'Hello！sadmin，您于2023-04-13 21:44:20成功登录系统，登录IP：42.243.21.165，归属地：云南省昆明市 电信', '0', '2023-04-13 21:44:20');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (86, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:51');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (49, 100105, '登录提醒', 'Hello！张三，您于2023-04-17 09:14:11成功登录系统，登录IP：116.249.99.4，归属地：云南省昆明市 电信', '1', '2023-04-17 09:14:11');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (50, 100105, '图书借阅通知', '恭喜您于2023-04-17 23:04:24成功借阅《妖神记》；借阅有效期90天，请在有效期满前3天内完成续借或归还，祝您阅读愉快！', '1', '2023-04-17 23:04:24');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (59, 19991011, '登录提醒', 'Hi！sadmin，您于2023-04-19 09:53:38成功登录系统，登录IP：116.249.214.156，归属地：云南省昆明市 电信', '0', '2023-04-19 09:53:38');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (60, 19991011, '图书借阅通知', '恭喜您于2023-04-19 09:04:31成功借阅《人间值得》，借阅期限90天，请在2023-07-18前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '0', '2023-04-19 09:04:31');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (85, 19991011, '图书续借通知', 'sadmin，您借阅的《人间值得》已续借成功，相关信息已更新，请前往图书续借中心查看！', '0', '2023-04-20 10:04:00');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (76, 100105, '借阅到期提醒', '张三，您于2023-04-17借阅的《茶花女》还有1天期限，请在2023-04-20前归还或完成续借操作，逾期将受到惩罚！', '0', '2023-04-19 10:04:20');
COMMIT;

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `cardNo` int(11) NOT NULL AUTO_INCREMENT COMMENT '教职工id，即借阅卡号',
  `name` varchar(120) NOT NULL COMMENT '姓名',
  `password` varchar(128) NOT NULL DEFAULT '74db87055a48267d8cc4a7b98e6f8ce2' COMMENT '登录密码，默认tsg123',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `department` varchar(128) DEFAULT NULL COMMENT '院系',
  `class` varchar(128) DEFAULT NULL COMMENT '所管理班级',
  `mobile` varchar(11) DEFAULT NULL COMMENT '手机号码',
  `user_type` varchar(120) NOT NULL DEFAULT '教师' COMMENT '身份类型',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态，0正常，1异常',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '7' COMMENT '可借阅图书数量，默认7',
  `avatar` varchar(128) DEFAULT NULL COMMENT '头像路径',
  `session_id` varchar(128) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cardNo`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2113956222 DEFAULT CHARSET=utf8 COMMENT='教师表';

-- ----------------------------
-- Records of teacher
-- ----------------------------
BEGIN;
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956200, '李思雨', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '艺术学院', '21音乐一班和音乐二班', '19910712541', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956201, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '教师', '1', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956203, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术三班', '18966678661', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956204, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '音乐学院', '音乐一班', '19205121314', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956205, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '体育学院', '体育一班', '18603937537', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956206, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '体育学院', '体育二班', '18603937538', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956207, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义一班', '18603937539', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956208, '赤赤', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '艺术设计与珠宝学院', '珠宝设计一班', '18603937540', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956209, '杨晓红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义二班', '18603937541', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956210, '李虎', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '政府管理学院', '行政管理一班', '16647551692', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956211, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术一班', '13333336667', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956212, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术二班', '19987675652', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956213, '王五', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '计算机科学与技术三班', '18966678661', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956214, '李红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '音乐学院', '音乐一班', '19205121314', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956215, '小华', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '体育学院', '体育一班', '18603937537', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956216, 'Jack', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '体育学院', '体育二班', '18603937538', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956217, '小羊', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '马克思主义学院', '马克思主义一班', '18603937539', '教师', '0', 7, NULL, '', '', NULL, '');
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `createtime`, `updatetime`) VALUES (2113956221, 'aa', 'd477887b0636e5d87f79cc25c99d7dc9', '女', '马院', '马克思主义二班', '19963456323', '教师', '0', 7, NULL, '', '', '2023-04-02 20:49:52', '2023-04-02 20:51:06');
COMMIT;

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `usertype_name` varchar(255) NOT NULL COMMENT '角色名称',
  `borrow_limit` tinyint(3) NOT NULL COMMENT '图书借阅数量',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1007 DEFAULT CHARSET=utf8 COMMENT='角色信息表';

-- ----------------------------
-- Records of user_type
-- ----------------------------
BEGIN;
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1001, '学生', 3);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1002, '教师', 7);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1003, '图书管理员', 12);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1004, '超级管理员', 99);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1005, '其他', 2);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1006, '校外人员', 2);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
