/*
 Navicat Premium Data Transfer

 Source Server         : Tencent Cloud DB
 Source Server Type    : MySQL
 Source Server Version : 50741 (5.7.41-log)
 Source Host           : localhost:3306
 Source Schema         : library

 Target Server Type    : MySQL
 Target Server Version : 50741 (5.7.41-log)
 File Encoding         : 65001

 Date: 26/05/2023 22:06:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for avatar
-- ----------------------------
DROP TABLE IF EXISTS `avatar`;
CREATE TABLE `avatar` (
  `id` int(6) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `path` varchar(128) NOT NULL COMMENT '头像路径',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='用户头像表';

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
  `is_back` enum('0','1') DEFAULT '0' COMMENT '是否归还（0未归还，1已归还）',
  `do_backDate` varchar(120) DEFAULT NULL COMMENT '操作归还的日期',
  `mark` text COMMENT '备注',
  PRIMARY KEY (`card_id`,`book_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='图书借阅信息表';

-- ----------------------------
-- Records of book_borrow
-- ----------------------------
BEGIN;
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`, `is_back`, `do_backDate`, `mark`) VALUES (19991011, 10005, '茶花女', 50, 90, 80, '2023-05-16', '2023-08-14', NULL, NULL, 0, '0', NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`, `is_back`, `do_backDate`, `mark`) VALUES (19991011, 10007, '飞鸟集', 52, 90, 0, '2023-05-11', '2023-05-16', NULL, NULL, 0, '0', NULL, '已逾期');
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`, `is_back`, `do_backDate`, `mark`) VALUES (5013104, 10011, '神雕侠侣', 6, 90, 0, '2023-05-25', '2023-08-23', NULL, NULL, 0, '1', '2023-05-25', '');
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`, `is_back`, `do_backDate`, `mark`) VALUES (5013104, 10019, '三生三世十里桃花', 0, 90, 90, '2023-05-25', '2023-08-23', NULL, NULL, 0, '0', NULL, NULL);
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`, `is_back`, `do_backDate`, `mark`) VALUES (2121502106, 10015, '论语', 12, 90, 0, '2023-05-26', '2023-08-24', NULL, NULL, 0, '1', '2023-05-26', '');
INSERT INTO `book_borrow` (`card_id`, `book_id`, `book_name`, `book_price`, `borrow_limitDay`, `left_day`, `borrow_date`, `back_date`, `renew_date`, `renew_backDate`, `renew_num`, `is_back`, `do_backDate`, `mark`) VALUES (2121502106, 10018, '离骚', 6, 90, 0, '2023-05-26', '2023-08-24', NULL, NULL, 0, '1', '2023-05-26', '');
COMMIT;

-- ----------------------------
-- Table structure for book_comment
-- ----------------------------
DROP TABLE IF EXISTS `book_comment`;
CREATE TABLE `book_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '评论id',
  `user_id` int(11) NOT NULL COMMENT '用户id',
  `book_id` int(11) NOT NULL COMMENT '图书id',
  `user_name` varchar(128) NOT NULL COMMENT '用户名',
  `avatar` varchar(128) NOT NULL COMMENT '用户头像',
  `book_name` varchar(128) NOT NULL COMMENT '图书名称',
  `content` text COMMENT '评论内容',
  `star` tinyint(5) DEFAULT '0' COMMENT '点赞次数',
  `createtime` varchar(128) NOT NULL COMMENT '评论时间',
  `approve_content` varchar(128) DEFAULT NULL COMMENT '审核内容',
  `approve_status` enum('0','1','2') DEFAULT '0' COMMENT '审核状态（0待审核，1审核通过，2审核未通过）',
  `approve_time` varchar(128) DEFAULT NULL COMMENT '审核时间',
  PRIMARY KEY (`comment_id`,`user_id`,`book_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='图书评论表';

-- ----------------------------
-- Records of book_comment
-- ----------------------------
BEGIN;
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (1, 19991011, 10005, 'sadmin', '../../skin/images/avatar/IMG_0204.PNG', '茶花女2', '人毫无爱情的时候，只好满足于虚荣，一旦有了爱，虚荣就变得一文不值了。', 15, '2023-05-15', NULL, '0', '');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (2, 19991011, 10001, 'sadmin', '../../skin/images/avatar/IMG_0204.PNG', '茶花女', '你要想如愿爱我，我还不够潦倒。', 58, '2023-05-15', NULL, '0', '');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (3, 9650101, 10003, '小红', '../../skin/images/avatar/IMG_0209.JPG', '万古江河：中国历史文化的转折与开展', '万古江河：中国历史文化的转折与开展，这本书读后给人很大的感触', 6, '2023-05-11', NULL, '0', '');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (4, 2121502101, 10008, '张三', '../../skin/images/avatar/IMG_0206.PNG', '小王子', '小王子说：“看完99次日落就好了”', 101, '2023-05-02', NULL, '0', '');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (5, 5013101, 10007, '杨洋', '../../skin/images/avatar/IMG_0210.PNG', '飞鸟集', '我是一只旷野的鸟，在你的眼里找到了天空。', 39, '2023-04-02', NULL, '0', '');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (6, 2121502102, 10006, '刘建平', '../../skin/images/avatar/IMG_0208.PNG', '新月集', '我在脆弱的独木舟里挣扎着越过绝望之海,却忘了自己也在玩一个游戏。', 68, '2023-04-012', NULL, '0', '');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (7, 19991011, 10010, 'sadmin', '../../skin/images/avatar/IMG_0204.PNG', '放生羊', '放生羊这篇课文引人入胜。', 16, '2023:05:25', NULL, '0', NULL);
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (15, 2121502106, 10002, '小', '../../skin/images/avatar/IMG_0203.PNG', '人间值得', '人间值得', 0, '2023-05-26', '', '1', '2023-05-26 00:26:39');
INSERT INTO `book_comment` (`comment_id`, `user_id`, `book_id`, `user_name`, `avatar`, `book_name`, `content`, `star`, `createtime`, `approve_content`, `approve_status`, `approve_time`) VALUES (14, 5013104, 10001, '张鸿飞', '../../skin/images/avatar/IMG_0205.PNG', '茶花女', '你干嘛，诶唷', 0, '2023-05-25', NULL, '0', NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=1024 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='图书类别信息表';

-- ----------------------------
-- Records of book_kind
-- ----------------------------
BEGIN;
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1001, '政治、法律', '');
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1002, '文学', '');
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
INSERT INTO `book_kind` (`type_id`, `type_name`, `mark`) VALUES (1023, '东方玄幻', '');
COMMIT;

-- ----------------------------
-- Table structure for book_list
-- ----------------------------
DROP TABLE IF EXISTS `book_list`;
CREATE TABLE `book_list` (
  `book_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书编号',
  `ISBN` varchar(60) NOT NULL COMMENT '图书ISBN',
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
  `status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '图书借阅状态（0在库，1已借出）',
  `borrow_num` tinyint(5) DEFAULT '0' COMMENT '图书被借阅次数',
  `click_num` tinyint(5) DEFAULT '0' COMMENT '查看次数，点击次数',
  `create_date` varchar(120) NOT NULL COMMENT '图书入库的时间截',
  `update_date` varchar(120) DEFAULT NULL COMMENT '图书更新信息时的记录时间',
  PRIMARY KEY (`book_id`) USING BTREE,
  UNIQUE KEY `index_bookName_publisher` (`book_name`,`publisher`)
) ENGINE=MyISAM AUTO_INCREMENT=10022 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='馆藏图书的数据表';

-- ----------------------------
-- Records of book_list
-- ----------------------------
BEGIN;
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10001, '1111-1111-2222-3333', '茶花女', '小仲马', '文学', '美国出版社', NULL, 0, 1, '《茶花女》是法国作家亚历山大·小仲马创作的长篇小说，也是其代表作。故事讲述了一个青年人与巴黎上流社会一位交际花曲折凄婉的爱情故事。 [1]作品通过一个妓女的爱情悲剧，揭露了法国七月王朝上流社会的糜烂生活。对贵族资产阶级的虚伪道德提出了血泪控诉。在法国文学史上，这是第一次把妓女作为主角的作品。', '../../upload/bookCover/1684141477_s29506438.jpg', NULL, '综合书库_图书馆301', '0', 6, 80, '2023-05-15', '2023-05-15 17:04:37');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10002, '978-7-03-020426-1	', '人间值得', '[日]中村恒子	', '马克思主义、列宁主义、毛泽东思想、邓小平理论 ', '北京日报出版社', NULL, 46, 1, '宝藏奶奶的人生36条感悟，正面解读工作、家庭、人际关系、孤独、死亡等人生课题，给人直面生活的勇气，愿每个人都能从人间失格直至人间值得！罗丹、三毛、史铁生坚信的生活理念。愿你遍历山河，仍觉人间值得！	', 'https://lib.crayon.vip/upload/bookCover/1684670933_s206577.jpg', NULL, '综合书库	_图书馆301', '0', 2, 22, '2023-05-15 17:04:53', '2023-05-21 20:08:53');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10003, '978-7-03-020426-2	', '万古江河：中国历史文化的转折与开展', '许倬云	', '文学 ', '湖南人民出版社', NULL, 41, 1, '清华校长送给每一位2019级新生的书，极具世界眼光的中国通史 大历史叙述的经典之作。	', 'https://lib.crayon.vip/upload/bookCover/1684670885_book-default.gif', NULL, '综合书库	_图书馆301', '0', 1, 2, '2023-05-15 17:04:53', '2023-05-21 20:08:05');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10004, '978-7-03-020426-3	', '八千里路云和月', '白先勇	', '文学 ', '中国友谊出版公司', NULL, 45, 1, '这是一本小说11111122	', 'https://lib.crayon.vip/upload/bookCover/1684670754_book-default.gif', NULL, '艺术书库_图书馆101	', '0', 7, 58, '2023-05-15 17:04:53', '2023-05-21 20:05:54');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10005, '978-7-03-020426-4	', '茶花女2', ' [法国]小仲马	', '文学 ', '未知', NULL, 50, 0, '未知	', '../../upload/bookCover/1684204623_s29506438.jpg', NULL, '艺术书库_图书馆101	', '1', 1, 19, '2023-05-15 17:04:53', '2023-05-21 20:06:49');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10006, '978-7-03-020426-5	', '新月集', '未知	', '综合性图书	', '新华出版社', NULL, 28, 1, '增加添加时间，也就是上架时间。心潮澎湃，无限幻想，迎风挥击千层浪，少年不败热血！', 'https://lib.crayon.vip/upload/bookCover/1684670981_s206578.jpg', NULL, '经济、军事书库	_图书馆402', '0', 0, 1, '2023-05-15 17:04:53', '2023-05-21 20:09:41');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10007, '978-7-03-020426-6	', '飞鸟集', '泰戈尔', '综合性图书', '未知', NULL, 52, 0, '图书借鉴	', 'https://lib.crayon.vip/upload/bookCover/1684670998_s206573.jpg', NULL, '史地书库	_图书馆302 ', '1', 1, 22, '2023-05-15 17:04:53', '2023-05-21 20:09:58');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10008, '978-7-03-020426-7	', '小王子', '不详', '历史、地理', '中国出版社', NULL, 12, 1, '你好，明天！	', 'https://lib.crayon.vip/upload/bookCover/1684671012_s206571.jpg', NULL, '哲社书库_图书馆203	', '0', 0, 42, '2023-05-15 17:04:53', '2023-05-21 20:10:12');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10009, '978-7-03-020426-8	', '黄鹤楼', '不详', '综合性图书', '中国出版社', NULL, 13, 1, '故人西辞黄鹤楼', 'https://lib.crayon.vip/upload/bookCover/1684670945_book-default.gif', NULL, '综合书库	_图书馆301', '0', 0, 22, '2023-05-15 17:04:53', '2023-05-21 20:09:05');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10010, '978-7-03-020426-9	', '放生羊', '无	', '语言、文字 ', '湖南人民出版社', NULL, 21, 1, '测试	', 'https://lib.crayon.vip/upload/bookCover/1684670853_s237622.jpg', NULL, '艺术书库_图书馆101	', '0', 0, 83, '2023-05-15 17:04:53', '2023-05-21 20:07:33');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10011, '978-7-03-020426-10	', '神雕侠侣', '金庸', '文学', '未知', NULL, 6, 1, 'hffhg	', 'https://lib.crayon.vip/upload/bookCover/1685021184_book-default.gif', NULL, '中小型书库_图书馆102	', '0', 1, 4, '2023-05-15 17:04:53', '2023-05-25 21:26:24');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10012, '978-7-03-020426-6	', '钢铁是怎样炼成的', '老爹	', '综合性图书', '未知', NULL, 52, 1, '图书借鉴	', 'https://lib.crayon.vip/upload/bookCover/1685021216_book-default.gif', NULL, '史地书库	_图书馆302 ', '0', 0, 0, '2023-05-15 17:07:37', '2023-05-25 21:26:56');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10013, '978-7-03-020426-6	', '成龙历险记', '未知', '综合性图书', '未知', NULL, 52, 1, '图书借鉴	', 'https://lib.crayon.vip/upload/bookCover/1685021205_book-default.gif', NULL, '史地书库	_图书馆302 ', '0', 0, 0, '2023-05-15 17:08:39', '2023-05-25 21:26:45');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10014, '978-7-03-020426-6	', '落日余晖', '老爹	', '综合性图书', '未知', NULL, 52, 1, '图书借鉴	', '', NULL, '史地书库	_图书馆302 ', '0', 0, 0, '2023-05-15 17:09:51', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10015, '978-7-03-020426-7	', '论语', '不详', '历史、地理', '中国出版社', NULL, 12, 1, '你好，明天！	', 'https://lib.crayon.vip/upload/bookCover/1685021225_book-default.gif', NULL, '哲社书库_图书馆203	', '0', 1, 1, '2023-05-15 17:09:51', '2023-05-25 21:27:05');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10016, '978-7-03-020426-8	', '诗经', '不详', '综合性图书', '中国出版社', NULL, 13, 1, '故人西辞黄鹤楼', 'https://lib.crayon.vip/upload/bookCover/1685021256_book-default.gif', NULL, '综合书库	_图书馆301', '0', 0, 1, '2023-05-15 17:09:51', '2023-05-25 21:27:36');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10017, '978-7-03-020426-9	', '小雅', '无	', '语言、文字 ', '湖南人民出版社', NULL, 21, 1, '测试	', 'https://lib.crayon.vip/upload/bookCover/1685021272_book-default.gif', NULL, '艺术书库_图书馆101	', '0', 0, 0, '2023-05-15 17:09:51', '2023-05-25 21:27:52');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10018, '978-7-03-020426-10	', '离骚', '金庸', '文学', '未知', NULL, 6, 1, 'hffhg	', 'https://lib.crayon.vip/upload/bookCover/1685021282_book-default.gif', NULL, '中小型书库_图书馆102	', '0', 1, 1, '2023-05-15 17:09:51', '2023-05-25 21:28:02');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10019, '978-7-03-020426-51', '三生三世十里桃花', '小小', '语言、文字', '未知', NULL, 0, 0, 'aa', '../../upload/bookCover/1684142144_s29260063.jpg', NULL, '剔旧书库', '1', 1, 10, '2023-05-15 17:15:26', '2023-05-15 17:15:44');
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10020, '665-23-020112-6', '活着', '未知', '马克思主义、列宁主义、毛泽东思想、邓小平理论', '湖南人民出版社', NULL, 0, 1, '会会这', 'https://lib.crayon.vip/upload/bookCover/1684929498_', NULL, '哲社书库', '0', 0, 0, '2023-05-24 19:58:18', NULL);
INSERT INTO `book_list` (`book_id`, `ISBN`, `book_name`, `author`, `book_type`, `publisher`, `publisher_date`, `price`, `number`, `mark`, `book_cover`, `book_source`, `save_position`, `status`, `borrow_num`, `click_num`, `create_date`, `update_date`) VALUES (10021, '100111', '偷偷藏不住', '未知', '文学', '中国出版社', NULL, 0, 5, '讲述的是乖戾少女桑稚从13岁暗恋腹黑青年段嘉许，最终得偿所愿的故事。', 'https://lib.crayon.vip/upload/bookCover/1685032788_微信图片_20230526003651.png', NULL, '文史书库', '0', 0, 4, '2023-05-26 00:37:17', '2023-05-26 00:39:48');
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
) ENGINE=MyISAM AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8 COMMENT='书库信息表';

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
  `user_id` varchar(20) DEFAULT NULL COMMENT '用户（允许游客）',
  `user_name` varchar(128) DEFAULT NULL COMMENT '提交的用户（允许游客）',
  `content` text NOT NULL COMMENT '反馈内容',
  `sub_time` varchar(128) NOT NULL COMMENT '提交时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户意见或建议反馈表';

-- ----------------------------
-- Records of feedback
-- ----------------------------
BEGIN;
INSERT INTO `feedback` (`id`, `user_id`, `user_name`, `content`, `sub_time`) VALUES (1, '19991011', 'sadmin', '加快开发进度', '2023:05:18 13:19:30');
INSERT INTO `feedback` (`id`, `user_id`, `user_name`, `content`, `sub_time`) VALUES (2, '', '', '游客反馈测试', '2023:05:18 13:19:51');
INSERT INTO `feedback` (`id`, `user_id`, `user_name`, `content`, `sub_time`) VALUES (3, '2121502106', '小', '你真厉害', '2023-05-26 00:23:19');
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
  `mobile` varchar(11) NOT NULL COMMENT '馆员电话',
  `user_type` varchar(128) NOT NULL DEFAULT '图书管理员' COMMENT '身份类别',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态（0正常，1异常）',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '12' COMMENT '可借阅图书的数量，默认12',
  `avatar` varchar(128) DEFAULT NULL COMMENT '用户头像路径',
  `session_id` varchar(128) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `log_ip` varchar(120) DEFAULT NULL COMMENT '登录ip',
  `log_carrier` varchar(120) DEFAULT NULL COMMENT '登录的网络运营商',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间，也是导入时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=100103 DEFAULT CHARSET=utf8 COMMENT='馆员信息表';

-- ----------------------------
-- Records of lib_worker
-- ----------------------------
BEGIN;
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (100101, 'Tsoft112', 'e99a18c428cb38d5f260853678922e03', '男', '19988888888', '图书管理员', '0', 12, NULL, NULL, NULL, NULL, NULL, NULL, '2023-05-24 23:42:00');
INSERT INTO `lib_worker` (`id`, `name`, `password`, `sex`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (100102, '陈仝', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '19963456323', '图书管理员', '0', 12, NULL, NULL, NULL, NULL, NULL, '2023-05-24 23:43:26', NULL);
COMMIT;

-- ----------------------------
-- Table structure for news_notice
-- ----------------------------
DROP TABLE IF EXISTS `news_notice`;
CREATE TABLE `news_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `title` varchar(128) NOT NULL COMMENT '标题',
  `author` varchar(120) DEFAULT NULL COMMENT '发布者（作者，来源）',
  `content` text NOT NULL COMMENT '内容',
  `see_num` int(5) DEFAULT '0' COMMENT '浏览次数',
  `cover_img` varchar(128) DEFAULT NULL COMMENT '配图，封面',
  `type` enum('1','2') NOT NULL DEFAULT '1' COMMENT '类型（1新闻，2公告）',
  `sub_time` varchar(128) NOT NULL COMMENT '发布时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='新闻资讯&通知公告表';

-- ----------------------------
-- Records of news_notice
-- ----------------------------
BEGIN;
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (1, '图书馆开馆通知', '图书管理员', '<h2>图书馆的开馆时间通知</h2><p>工作日</p><p>早上 6:30 - 晚上11:30</p><p>插图：<img src=\"../../upload/article/article_img/1684386176_IMG_0208.PNG\" alt=\"插图\" data-href=\"https://lib.crayon.vip/upload/article/article_img/1684386176_IMG_0208.PNG\" style=\"width: 30%;\"/></p>', 1, 'https://lib.crayon.vip/upload/article/article_cover/1684386008_IMG_0227.JPG', '2', '2023-05-18');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (2, '图书馆介绍', '图书管理员', '<p><br></p><p><strong>理 &nbsp;念</strong></p><p><strong>馆藏智慧，文化天下</strong></p><p><strong>读者至上，资源共享</strong></p><p><br></p><p><br></p><p><strong>图书馆概况</strong></p><p><br></p><p style=\"text-indent: 2em;\"><span style=\"font-size: 15px;\">1.基本数据。保山学院图书馆成立于1978年4月，由原来的保山地区师范学校图书馆并入了部分图书资料的基础上组建起来的，至今已有44年历史。在学校的重视、支持和几代图书馆人的努力下，图书馆经历了两次整体搬迁，不断发展壮大。截至2022年9月，建筑面积达到13000平方米，阅览座位2000余个，纸质馆藏文献110万册，电子资源包括正式数据库21个、试用中外文数据库30余个、电子图书104.4万余册，对外开放的书库8个，现刊阅览室1个。</span></p><p style=\"text-indent: 2em;\"><img src=\"https://mmbiz.qpic.cn/mmbiz_jpg/YExLWV9FGkmn0u4nB8p3SQOpVH2eBuVIcjWnFs1vrvEj0OA9cgvvwN9YwZzOWhhibfdrsfd89LLKEibJsMPNibTAw/640?wx_fmt=jpeg&amp;wxfrom=5&amp;wx_lazy=1&amp;wx_co=1\" alt=\"\" data-href=\"\" style=\"\"></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">2.目标定位及思路。我们的目标定位是：把保山学院图书馆建设成为滇西区域重要的文献信息中心，为高等教育、科学研究和区域经济社会发展提供优质服务的现代化图书馆，辐射南亚、东南亚。发展思路是特色资源、特色服务与特色发展。</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">3.馆徽馆训。与我校校训“厚德、励学、敬业、笃行”相呼应，图书馆馆训为“自强不息，厚德载物”。其中与“自强不息”对应的是：学车胤，囊萤映雪，博闻天下学识；效孙敬，悬梁苦读，成就饱学之士；与“厚德载物”对应的是：仰尼父，诲人不倦，弘仁义礼智信；仿忠武，精忠报国，传忠孝廉耻勇。激励大家在学习与工作中，要像大自然般，刚健有为，奋发图强，永不停息；要像大地般增厚美德，容载万物。</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">馆徽选取兰花和书本为主要元素，标志底部为图书馆的象征“书”，寓意书山有路；顶部为兰花瓣，寓意书如兰花般芬香；馆训“自强不息，厚德载物”嵌入其中。整个图案像一支熊熊燃烧的蜡烛和大海里导航的灯塔，寓意保山学院学生勤奋好学，博览群书，在知识的海洋里尽情遨游，在书山中勇攀高峰，不断进取和创新。此外，书的形状类似弯曲的道路，寓意沧桑的茶马古道，充分彰显了保山悠久的历史和灿烂的文化底蕴。</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">图书馆馆徽以蓝色为基本底色，寓意图书馆是知识的海洋。</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">4.其他理念：</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">①馆藏智慧，文化天下——突出图书馆的重要作用及其文化的教化功能；</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">②读者至上，资源共享——强调读者的崇高地位与文献资源的共享性；</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">③服务高校教学与科学研究，服务区域经济社会发展，服务国家发展战略——彰显图书馆的宗旨与服务本质；</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">④科学规范管理，优质服务为本，立足信息传播，突出品牌特色——突出图书的管理、作用与发展方向；</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">⑤特色资源，特色服务，特色发展——突出图书馆的发展理念与路径；</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">⑥兼收并蓄，海纳百川，人无我有，人有我特——体现图书馆的文献收藏思路；</span></p><p style=\"text-indent: 2em; text-align: justify;\"><span style=\"font-size: 15px;\">⑦服务为本，科研破题——突出图书馆学术性机构的本质，指出科学研究是解决服务瓶颈的重要突破口。</span></p>', 5, 'https://lib.crayon.vip/upload/article/article_cover/1685027991_banner_3.png', '2', '2023-05-25');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (3, '保山学院“第十一届书香校园读书月”活动正式启动', '图书管理员', '<p><a href=\"https://tsg.bsnc.cn/info/1011/2208.htm\" target=\"\" style=\"text-align: left;\">保山学院“第十一届书香校园读书月”活动正式启动</a></p>', 2, 'https://lib.crayon.vip/upload/article/article_cover/1684671157_back_banner.jpg', '1', '2023-05-21');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (4, '图书馆举办考研辅导专题讲座', '图书管理员', '<p><a href=\"https://tsg.bsnc.cn/info/1011/2238.htm\" target=\"\" style=\"text-align: left;\">图书馆举办考研辅导专题讲座</a></p>', 3, 'https://lib.crayon.vip/upload/article/article_cover/1684671204_back_banner1.jpg', '1', '2022-11-21');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (5, '借阅指南', '图书管理员', '<p>借阅指南</p>', 1, 'https://lib.crayon.vip/upload/article/article_cover/1684671275_banner_3.png', '2', '2023-03-25');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (6, '关于图书馆馆员的管理通知', '超级管理员', '<p>关于图书馆馆员的管理通知</p>', 0, 'https://lib.crayon.vip/upload/article/article_cover/1684671303_banner_6.jpg', '2', '2023-03-21');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (7, '4.23全球读书日', '图书管理员', '<p>全球读书日，鼓励全员读书</p>', 0, 'https://lib.crayon.vip/upload/article/article_cover/1684671602_banner_9.png', '1', '2023-04-23');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (8, '自助打印说明', '图书管理员', '<p>关于图书馆的自助打印说明</p>', 0, 'https://lib.crayon.vip/upload/article/article_cover/1684671699_comment_img.jpg', '2', '2023-04-23');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (9, '图书馆举办《中国知网系列数据库新购资源利用》讲座', '图书管理员', '<p><span style=\"color: rgb(51, 51, 51); background-color: rgb(248, 245, 242); font-size: 16px; font-family: 微软雅黑;\">图书馆举办《中国知网系列数据库新购资源利用》讲座</span></p>', 0, 'https://lib.crayon.vip/upload/article/article_cover/1684671781_service_banner.jpg', '1', '2023-05-21');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (10, '奋斗有我 青春有YOUNG‖青年节，为大学生烹制一碗“心灵鸡汤”', '图书管理员', '<h3><span style=\"color: rgb(0, 0, 0); background-color: rgb(255, 255, 255);\">青春孕育无限希望，青年创造美好明天。在强国建设、民族复兴的新征程上，我们迎来又一个“五四”青年节。</span></h3><p style=\"text-align: center;\"><img src=\"../../upload/article/article_img/1684934101_20230511115444_7hemm8cumt.jpg\" alt=\"插图\" data-href=\"https://lib.crayon.vip/upload/article/article_img/1684934101_20230511115444_7hemm8cumt.jpg\" style=\"\"></p><h3 style=\"text-align: center;\">讲座现场</h3><p style=\"text-indent: 2em; text-align: left;\">在谈到大学生自我价值实现时，傅霞表示每个人都是独一无二的，并以“力学之父”“应用数学之父”钱伟长、“文墨精度”诠释大国工匠精神的方文墨为例，鼓励大学生要学会自我关爱、自我提升、自我突破，同时也要学会自助、学会求助、学会助人，以积极的行动去爱国爱民、锤炼品德、勇于创新、实学实干，能够不辜负时代，不枉费光阴，昂首阔步响应时代召唤，勇担时代使命，做走在时代前沿的奋进者、开拓者、奉献者。</p><p style=\"text-indent: 2em; text-align: left;\"><br></p>', 0, 'https://lib.crayon.vip/upload/article/article_cover/1684934151_20230511115444_7hemm8cumt.jpg', '1', '2023-05-05');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (11, '图书馆关于增加自主注册账号的通知', '图书管理员', '<h3>图书馆于2023年5月21日起开放用户自主注册成为本网站会员，注册成功即可使用本系统的服务。</h3>', 0, 'https://lib.crayon.vip/upload/article/article_cover/1685027609_news_banner.jpg', '2', '2023-05-25');
INSERT INTO `news_notice` (`id`, `title`, `author`, `content`, `see_num`, `cover_img`, `type`, `sub_time`) VALUES (12, '开世书万卷 览文人独卓---“畅读”活动', '图书管理员', '<p style=\"text-align: left;\"> “<span style=\"font-size: 15px; font-family: 微软雅黑;\">世界读书日”到来之际，系统</span><span style=\"font-size: 16px; font-family: 宋体;\">于即日起至</span><span style=\"color: rgb(255, 0, 0); font-size: 15px;\">5</span><span style=\"color: rgb(255, 0, 0); font-size: 15px; font-family: 微软雅黑;\">月</span><span style=\"color: rgb(255, 0, 0); font-size: 15px;\">23</span><span style=\"font-size: 16px; font-family: 宋体;\">日面向用户全面推出“畅读”原版外文图书免费借阅活动，以满足广大用户对人文社科外文图书的借阅需求。</span></p><p style=\"text-align: start;\"><span style=\"font-family: 宋体;\">说明：</span></p><p style=\"text-align: start;\">1.<span style=\"font-family: 宋体;\">用户通过系统主页注册。 </span><a href=\"https://lib.crayon.vip/oauth/login\" target=\"_blank\">https://lib.crayon.vip/oauth/login</a> </p><p style=\"text-align: start;\">2.<span style=\"font-family: 宋体;\">已注册的用户先检索图书、期刊目录或一站式检索，然后提交申请。馆员会及时通知您到馆取书。</span></p><p style=\"text-align: start;\">3.<span style=\"font-family: 宋体;\">图书借阅优惠活动包括</span>34<span style=\"font-family: 宋体;\">家高校服务馆馆藏。</span></p><p style=\"text-align: start;\"><span style=\"font-family: 宋体;\">如有疑问欢迎垂询。联系方式：</span></p><p style=\"text-align: start;\"><span style=\"font-family: 宋体;\">电话：18888888888</span></p><p style=\"text-align: start;\">Email<span style=\"font-family: 宋体;\">：</span><a href=\"mailto:ill@nankai.edu.cn\" target=\"\">1837972550@qq.com</a></p><p style=\"text-align: start;\"><br></p><p style=\"text-align: start;\"><br></p><p style=\"text-align: right;\"><span style=\"font-family: 宋体;\">小新图书馆读者服务部</span></p><p style=\"text-align: right;\">2023<span style=\"font-family: 宋体;\">年</span>4<span style=\"font-family: 宋体;\">月</span>28<span style=\"font-family: 宋体;\">日 &nbsp;</span></p><p style=\"text-align: start;\"><br></p>', 26, 'https://lib.crayon.vip/upload/article/article_cover/1685027661_about_banner.jpg', '1', '2023-05-25');
COMMIT;

-- ----------------------------
-- Table structure for other_user
-- ----------------------------
DROP TABLE IF EXISTS `other_user`;
CREATE TABLE `other_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `name` varchar(120) NOT NULL COMMENT '名字',
  `password` varchar(128) NOT NULL DEFAULT '74db87055a48267d8cc4a7b98e6f8ce2' COMMENT '登录密码，默认tsg123',
  `sex` enum('男','女') NOT NULL DEFAULT '男' COMMENT '性别',
  `department` varchar(128) DEFAULT NULL COMMENT '学院（为空，不填）',
  `class` varchar(128) DEFAULT NULL COMMENT '班级（为空，不填）',
  `mobile` varchar(11) NOT NULL COMMENT '联系电话',
  `user_type` varchar(128) NOT NULL COMMENT '身份类别（校外人员，其他，或）',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态（0正常，1异常）',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '3' COMMENT '可借阅图书的数量，默认3',
  `avatar` varchar(128) DEFAULT NULL COMMENT '用户头像路径',
  `session_id` varchar(128) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `log_ip` varchar(120) DEFAULT NULL COMMENT '登录ip',
  `log_carrier` varchar(120) DEFAULT NULL COMMENT '登录使用的网络运营商',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=5013105 DEFAULT CHARSET=utf8 COMMENT='其他用户信息表';

-- ----------------------------
-- Records of other_user
-- ----------------------------
BEGIN;
INSERT INTO `other_user` (`id`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (5013101, '杨洋', '74db87055a48267d8cc4a7b98e6f8ce2', '男', NULL, NULL, '19989099999', '校外人员', '0', 3, '../../skin/images/avatar/IMG_0210.PNG', '9qddgtdv2ajhter4ibjj4fl8eb', '2023-05-21 20:33:29', '223.160.200.107', '北京市 广电网', NULL, NULL);
INSERT INTO `other_user` (`id`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (5013102, '李四', '74db87055a48267d8cc4a7b98e6f8ce2', '男', NULL, NULL, '18387804014', '校外人员', '0', 3, NULL, NULL, NULL, NULL, NULL, '2023-05-21 20:46:15', NULL);
INSERT INTO `other_user` (`id`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (5013103, 'lihua', 'af8f9dffa5d420fbc249141645b962ee', '男', NULL, NULL, '11155451111', '其他', '0', 3, '../../skin/images/avatar/IMG_0209.JPG', '5810gknmna9oee95rvhu60h35f', '2023-05-23 21:07:21', '106.61.71.33', '云南省昆明市 电信', '2023-05-23 21:07:21', NULL);
INSERT INTO `other_user` (`id`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (5013104, '张鸿飞', 'dcc62e31c8030d9488969c5da73d2f16', '男', NULL, NULL, '16608802778', '其他', '0', 3, '../../skin/images/avatar/IMG_0205.PNG', 'fok2j4su0iuadrbt06mh9fp42n', '2023-05-25 23:00:53', '106.58.204.234', '云南省保山市 电信', '2023-05-25 21:55:05', NULL);
COMMIT;

-- ----------------------------
-- Table structure for rights
-- ----------------------------
DROP TABLE IF EXISTS `rights`;
CREATE TABLE `rights` (
  `id` int(11) NOT NULL COMMENT '用户id（借阅卡号）',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `user_type` varchar(50) NOT NULL COMMENT '原身份类型',
  `lib_worker` enum('0','1') NOT NULL COMMENT '馆员档案（0无权限，1有权限）',
  `reader_list` enum('0','1') NOT NULL COMMENT '读者档案（0无权限，1有权限）',
  `reader_kind` enum('0','1') NOT NULL COMMENT '读者类型（0无权限，1有权限）',
  `book_kind` enum('0','1') NOT NULL COMMENT '图书类型（0无权限，1有权限）',
  `book_manager` enum('0','1') NOT NULL COMMENT '图书管理（0无权限，1有权限）',
  `borrowBook` enum('0','1') NOT NULL COMMENT '图书借阅（0无权限，1有权限）',
  `record_search` enum('0','1') NOT NULL COMMENT '借阅记录查询（0无权限，1有权限）',
  `comment_center` enum('0','1') NOT NULL COMMENT '评论中心审批（0无权限，1有权限）',
  `news_notice` enum('0','1') NOT NULL COMMENT '新闻公告发布（0无权限，1有权限）',
  `feedBack` enum('0','1') NOT NULL COMMENT '用户反馈查阅（0无权限，1有权限）',
  `rights_center` enum('0','1') NOT NULL COMMENT '权限分配（0无权限，1有权限）',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限分配表';

-- ----------------------------
-- Records of rights
-- ----------------------------
BEGIN;
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (19991011, 'sadmin', '超级管理员', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (100101, 'Tsoft', '图书管理员', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (2121502101, '张三', '学生', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (9650101, '小红', '教师', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (5013101, '杨洋', '校外人员', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (5013102, '李四', '校外人员', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (2121502102, '刘建平', '学生', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (5013103, 'lihua', '其他', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (2121502105, '小李', '学生', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (100102, '陈仝', '超级管理员', '0', '1', '1', '1', '1', '1', '1', '1', '1', '1', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (5013104, '张鸿飞', '其他', '0', '0', '0', '0', '0', '1', '0', '0', '0', '0', '0');
INSERT INTO `rights` (`id`, `user_name`, `user_type`, `lib_worker`, `reader_list`, `reader_kind`, `book_kind`, `book_manager`, `borrowBook`, `record_search`, `comment_center`, `news_notice`, `feedBack`, `rights_center`) VALUES (2121502106, '小', '学生', '0', '0', '1', '1', '1', '1', '0', '1', '0', '1', '0');
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
  `department` varchar(128) NOT NULL COMMENT '学院',
  `class` varchar(128) NOT NULL COMMENT '班级',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `user_type` varchar(120) NOT NULL DEFAULT '学生' COMMENT '身份类型',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态，0正常，1异常',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '5' COMMENT '可借阅图书数量，默认5',
  `avatar` varchar(128) DEFAULT NULL COMMENT '用户头像路径',
  `session_id` varchar(120) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `log_ip` varchar(120) DEFAULT NULL COMMENT '登录ip',
  `log_carrier` varchar(120) DEFAULT NULL COMMENT '登录的网络运营商',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cardNo`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2121502107 DEFAULT CHARSET=utf8 COMMENT='学生表';

-- ----------------------------
-- Records of student
-- ----------------------------
BEGIN;
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (2121502101, '张三', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '21计算机与科学一班', '19988888888', '学生', '0', 5, '../../skin/images/avatar/IMG_0206.PNG', '41su8avh1i1thga6dmpjfrdkn6', '2023-05-25 22:21:57', '106.61.155.114', '云南省昆明市 电信', NULL, NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (2121502102, '刘建平', '74db87055a48267d8cc4a7b98e6f8ce2', '男', '大数据学院', '21计算机科学与技术一班', '18987319503', '学生', '0', 5, NULL, NULL, NULL, NULL, NULL, '2023-05-21 20:52:06', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (2121502103, 'Tsoft', 'e99a18c428cb38d5f260853678922e03', '女', '未设置', '未设置', '19963456323', '学生', '0', 5, NULL, NULL, NULL, NULL, NULL, '2023-05-23 20:47:34', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (2121502104, '哈哈哈', 'e99a18c428cb38d5f260853678922e03', '女', '未设置', '未设置', '19963456323', '学生', '0', 5, '../../skin/images/avatar/IMG_0208.PNG', '37kvga5ks94tqr57u448csvhfa', '2023-05-23 20:47:46', '106.61.71.33', '云南省昆明市 电信', '2023-05-23 20:47:46', '2023-05-24 23:40:33');
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (2121502105, '小李', 'dc483e80a7a0bd9ef71d8cf973673924', '女', '未设置', '未设置', '13689762156', '学生', '0', 5, '../../skin/images/avatar/IMG_0208.PNG', 'lakfmndea4ro86k4r1ijhsrf6v', '2023-05-24 19:59:57', '106.58.203.255', '云南省保山市 电信', '2023-05-24 19:59:57', NULL);
INSERT INTO `student` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (2121502106, '小', '8f1f897ae60891625efab59421b425b2', '男', '大数据', '计算机', '15925498888', '学生', '0', 5, '../../skin/images/avatar/IMG_0203.PNG', 'himu7kd9nkddh6h4lsjo8kgolu', '2023-05-26 13:29:59', '39.144.147.94', ' 中国移动', '2023-05-26 00:07:15', '2023-05-26 00:18:39');
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
  `log_ip` varchar(120) DEFAULT NULL COMMENT '登录ip',
  `log_carrier` varchar(120) DEFAULT NULL COMMENT '登录的网络运营商',
  `createtime` varchar(120) NOT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改密码时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19991012 DEFAULT CHARSET=utf8 COMMENT='超级管理员表';

-- ----------------------------
-- Records of super_admin
-- ----------------------------
BEGIN;
INSERT INTO `super_admin` (`id`, `username`, `sex`, `password`, `user_type`, `mobile`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (19991011, 'sadmin', '男', '74DB87055A48267D8CC4A7B98E6F8CE2', '超级管理员', '19018731920', '1', 99, '../../skin/images/avatar/IMG_0204.PNG', 'r7clh4433em4g4q77c83bh72ie', '2023-05-26 16:38:03', '106.61.202.248', '云南省昆明市 电信', '2023-05-14', NULL);
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
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='系统消息表';

-- ----------------------------
-- Records of sys_msg
-- ----------------------------
BEGIN;
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (1, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-14 22:29:44成功登录系统，登录IP：39.128.15.44，归属地：云南省昆明市 移通', '0', '2023-05-14 22:29:44');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (2, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-15 16:59:20成功登录系统，登录IP：42.243.21.57，归属地：云南省昆明市 电信', '0', '2023-05-15 16:59:20');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (3, 212150101, '登录提醒', 'Hi！张三，您于2023-05-15 23:08:01成功登录系统，登录IP：39.128.15.44，归属地：云南省昆明市 移通', '0', '2023-05-15 23:08:01');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (4, 212150101, '登录提醒', 'Hi！张三，您于2023-05-16 10:15:43成功登录系统，登录IP：116.249.99.57，归属地：云南省昆明市 电信', '0', '2023-05-16 10:15:43');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (5, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-16 10:29:18成功登录系统，登录IP：116.249.99.57，归属地：云南省昆明市 电信', '0', '2023-05-16 10:29:18');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (6, 19991011, '图书借阅通知', 'sadmin，恭喜您于2023-05-16 11:29:30成功借阅图书《茶花女》，借阅期限90天，请在2023-08-14前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '0', '2023-05-16 11:29:30');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (7, 19991011, '图书借阅通知', 'sadmin，恭喜您于2023-05-16 12:00:13成功借阅图书《飞鸟集》，借阅期限90天，请在2023-08-14前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '0', '2023-05-16 12:00:13');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (8, 19991011, '图书逾期提醒', 'sadmin，您于2023-05-11借阅的图书《飞鸟集》已经逾期，您的借阅卡已被暂停使用，请及时处理（您可以归还图书或联系管理员处理）！', '0', '2023-05-16 12:00:50');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (9, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-18 12:19:25成功登录系统，登录IP：42.243.21.57，归属地：云南省昆明市 电信', '0', '2023-05-18 12:19:25');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (10, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-19 11:27:57成功登录系统，登录IP：112.112.243.95，归属地：云南省昆明市 电信', '0', '2023-05-19 11:27:57');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (11, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-21 20:03:19成功登录系统，登录IP：223.160.200.107，归属地：北京市 广电网', '0', '2023-05-21 20:03:19');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (12, 9650101, '登录提醒', 'Hi！小红，您于2023-05-21 20:27:11成功登录系统，登录IP：223.160.200.107，归属地：北京市 广电网', '0', '2023-05-21 20:27:11');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (13, 5013101, '登录提醒', 'Hi！杨洋，您于2023-05-21 20:33:29成功登录系统，登录IP：223.160.200.107，归属地：北京市 广电网', '0', '2023-05-21 20:33:29');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (14, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-22 10:34:01成功登录系统，登录IP：223.160.201.211，归属地：北京市 广电网', '0', '2023-05-22 10:34:01');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (15, 2121502104, '用户注册', 'Hi！Tsoft，恭喜您于2023-05-23 20:47:46成功注册本系统账号，感谢支持！', '0', '2023-05-23 20:47:46');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (16, 5013103, '用户注册', 'Hi！lihua，恭喜您于2023-05-23 21:07:21成功注册本系统！', '0', '2023-05-23 21:07:21');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (17, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-24 19:49:46成功登录系统，登录IP：106.58.203.255，归属地：云南省保山市 电信', '0', '2023-05-24 19:49:46');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (18, 2121502105, '用户注册', 'Hi！小李，恭喜您于2023-05-24 19:59:57成功注册本系统！', '0', '2023-05-24 19:59:57');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (19, 2121502101, '登录提醒', 'Hi！张三，您于2023-05-25 16:44:10成功登录系统，登录IP：106.61.144.246，归属地：云南省昆明市 电信', '0', '2023-05-25 16:44:10');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (20, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-25 21:24:43成功登录系统，登录IP：106.61.155.114，归属地：云南省昆明市 电信', '0', '2023-05-25 21:24:43');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (21, 5013104, '用户注册', 'Hi！张鸿飞，恭喜您于2023-05-25 21:55:05成功注册本系统！您的账号为5013104，请前往个人中心完善信息！', '1', '2023-05-25 21:55:05');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (22, 5013104, '图书借阅通知', '张鸿飞，恭喜您于2023-05-25 21:57:37成功借阅图书《神雕侠侣》，借阅期限90天，请在2023-08-23前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '1', '2023-05-25 21:57:37');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (23, 5013104, '图书归还通知', '张鸿飞，您于2023-05-25借阅的图书《神雕侠侣》已成功归还！', '1', '2023-05-25 21:57:53');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (24, 5013104, '图书借阅通知', '张鸿飞，恭喜您于2023-05-25 23:03:42成功借阅图书《三生三世十里桃花》，借阅期限90天，请在2023-08-23前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '0', '2023-05-25 23:03:42');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (25, 2121502106, '用户注册', 'Hi！小，恭喜您于2023-05-26 00:07:15成功注册本系统！您的账号为2121502106，请前往个人中心完善信息！', '1', '2023-05-26 00:07:15');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (26, 2121502106, '图书借阅通知', '小，恭喜您于2023-05-26 00:13:03成功借阅图书《论语》，借阅期限90天，请在2023-08-24前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '1', '2023-05-26 00:13:03');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (27, 2121502106, '图书归还通知', '小，您于2023-05-26借阅的图书《论语》已成功归还！', '1', '2023-05-26 00:13:37');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (28, 2121502106, '图书借阅通知', '小，恭喜您于2023-05-26 13:30:53成功借阅图书《离骚》，借阅期限90天，请在2023-08-24前归还或完成续借操作，期间请爱惜图书，祝您阅读愉快！', '0', '2023-05-26 13:30:53');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (29, 2121502106, '图书归还通知', '小，您于2023-05-26借阅的图书《离骚》已成功归还！', '0', '2023-05-26 13:31:02');
INSERT INTO `sys_msg` (`id`, `user_id`, `sender`, `content`, `state`, `createtime`) VALUES (30, 19991011, '登录提醒', 'Hi！sadmin，您于2023-05-26 16:38:03成功登录系统，登录IP：106.61.202.248，归属地：云南省昆明市 电信', '0', '2023-05-26 16:38:03');
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
  `department` varchar(128) NOT NULL COMMENT '院系',
  `class` varchar(128) DEFAULT NULL COMMENT '所管理班级',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `user_type` varchar(120) NOT NULL DEFAULT '教师' COMMENT '身份类型',
  `card_status` enum('0','1') NOT NULL DEFAULT '0' COMMENT '借阅卡状态，0正常，1异常',
  `borrow_limit` tinyint(3) NOT NULL DEFAULT '7' COMMENT '可借阅图书数量，默认7',
  `avatar` varchar(128) DEFAULT NULL COMMENT '头像路径',
  `session_id` varchar(128) DEFAULT NULL COMMENT '登录状态标记',
  `log_time` varchar(128) DEFAULT NULL COMMENT '登录时间',
  `log_ip` varchar(120) DEFAULT NULL COMMENT '登录ip',
  `log_carrier` varchar(120) DEFAULT NULL COMMENT '登录的网络运营商',
  `createtime` varchar(120) DEFAULT NULL COMMENT '创建时间',
  `updatetime` varchar(120) DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`cardNo`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=9650102 DEFAULT CHARSET=utf8 COMMENT='教师表';

-- ----------------------------
-- Records of teacher
-- ----------------------------
BEGIN;
INSERT INTO `teacher` (`cardNo`, `name`, `password`, `sex`, `department`, `class`, `mobile`, `user_type`, `card_status`, `borrow_limit`, `avatar`, `session_id`, `log_time`, `log_ip`, `log_carrier`, `createtime`, `updatetime`) VALUES (9650101, '小红', '74db87055a48267d8cc4a7b98e6f8ce2', '女', '音乐学院', NULL, '19988888888', '教师', '0', 7, '../../skin/images/avatar/IMG_0209.JPG', 'leoeutrmsav87akjd8gc67lnp3', '2023-05-21 20:27:11', '223.160.200.107', '北京市 广电网', NULL, NULL);
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
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1001, '学生', 5);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1002, '教师', 7);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1003, '图书管理员', 12);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1004, '超级管理员', 99);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1005, '校外人员', 3);
INSERT INTO `user_type` (`type_id`, `usertype_name`, `borrow_limit`) VALUES (1006, '其他', 3);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
