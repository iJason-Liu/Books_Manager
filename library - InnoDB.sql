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

 Date: 13/03/2023 23:50:42
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for access_user
-- ----------------------------
DROP TABLE IF EXISTS `access_user`;
CREATE TABLE `access_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '加密的密码',
  `user_type` varchar(255) NOT NULL COMMENT '角色',
  PRIMARY KEY (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户注册信息记录';

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
-- Table structure for book_comment
-- ----------------------------
DROP TABLE IF EXISTS `book_comment`;
CREATE TABLE `book_comment` (
  `comm_id` int(11) NOT NULL COMMENT '评论id',
  `book_id` int(11) NOT NULL COMMENT '关联的图书编号',
  `content` varchar(255) DEFAULT NULL COMMENT '评论内容'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书的评论管理';

-- ----------------------------
-- Records of book_comment
-- ----------------------------
BEGIN;
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
  `create_date` datetime NOT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '图书入库的时间截',
  `update_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '图书更新信息时的记录时间',
  `save_position` varchar(255) DEFAULT NULL COMMENT '图书存放书库位置',
  `status` bit(1) NOT NULL COMMENT '图书借出状态',
  PRIMARY KEY (`book_id`) USING BTREE,
  KEY `book_name` (`book_name`),
  KEY `save_position` (`save_position`)
) ENGINE=InnoDB AUTO_INCREMENT=10023 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='馆藏图书的数据列表';

-- ----------------------------
-- Records of book_list
-- ----------------------------
BEGIN;
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10007, '《人间值得》', '[日]中村恒子', '励志类', '北京日报出版社', 46, 25, '宝藏奶奶的人生36条感悟，正面解读工作、家庭、人际关系、孤独、死亡等人生课题，给人直面生活的勇气，愿每个人都能从人间失格直至人间值得！罗丹、三毛、史铁生坚信的生活理念。愿你遍历山河，仍觉人间值得！', NULL, '2023-03-02 00:00:00', '2023-03-07 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10008, '《万古江河：中国历史文化的转折与开展》', '许倬云', '著作类', '湖南人民出版社', 41, 56, '清华校长送给每一位2019级新生的书，极具世界眼光的中国通史 大历史叙述的经典之作。', '../upload/bookCover/多云.png', '2023-03-09 11:47:22', '2023-03-09 11:47:22', '图书馆二楼205', b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10009, '《八千里路云和月》', '白先勇', '文学类', '中国友谊出版公司', 45, 15, '阿斯卡很勤快我好困', '../upload/bookCover/test_2.webp', '2023-03-08 00:00:00', '2023-03-08 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10014, '《盗墓笔记》', '南派三叔', '玄幻类', '开远出版社', 180, 28, '以下均为测试数据123456', '../upload/bookCover/test_1.webp', '2023-03-09 21:48:08', '2023-03-09 21:48:08', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10015, '《教父》', '[美] 马里奥·普佐', '文学类', '美国出版社', 20, 18, '测试数据测试数据', '../upload/bookCover/中文测试.webp', '2023-03-08 00:00:00', '2023-03-08 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10016, '《茶花女》', ' [法国]小仲马', '文学类', '未知', 520, 20, '未知', '../upload/bookCover/黑猫.png', '2023-03-08 00:00:00', '2023-03-08 00:00:00', '', b'1');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10018, '《妖神记》', '发飙的蜗牛', '玄幻类', '新华出版社', 28, 100, '增加添加时间，也就是上架时间，\r\n心潮澎湃，无限幻想，迎风挥击千层浪，少年不败热血！', NULL, '2023-03-08 00:00:00', '2023-03-08 00:00:00', '图书馆三楼303', b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10019, '《炼气十万年》', 'Jason', '冒险类', '未知', 35, 23, '为突破炼气万归元闭关三万年，谁曾想炼气9999层都没能突破。正所谓一层为渣，两层为蠢，三层为废。然而万归元炼气9999层，却无敌天下，轰杀一切。无敌一时爽，一直无敌一直爽。作为活了三万年的老祖，唯一的烦恼就是无敌太寂寞。', '../upload/bookCover/富士山.png', '2023-03-08 00:00:00', '2023-03-08 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10020, '《成龙历险记》', '老爹', '冒险类', '未知', 52, 28, '图书借鉴', NULL, '2023-03-07 00:00:00', '2023-03-07 00:00:00', NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10021, '《自传》', '无', '测试', '啊萨克', 12, 1, '啊巴萨叫测试', NULL, '2023-03-10 11:35:32', NULL, NULL, b'0');
INSERT INTO `book_list` (`book_id`, `book_name`, `author`, `book_type`, `publisher`, `price`, `number`, `mark`, `book_cover`, `create_date`, `update_date`, `save_position`, `status`) VALUES (10022, '《紫川》', '无', '安不上', '未知', 1, 1, '测试', NULL, '2023-03-10 11:36:58', NULL, NULL, b'0');
COMMIT;

-- ----------------------------
-- Table structure for book_rank
-- ----------------------------
DROP TABLE IF EXISTS `book_rank`;
CREATE TABLE `book_rank` (
  `book_id` int(11) NOT NULL COMMENT '图书编号',
  `book_name` varchar(255) DEFAULT NULL COMMENT '被引用的图书名称',
  `rank_num` int(11) DEFAULT NULL COMMENT '图书的点击数量',
  PRIMARY KEY (`book_id`) USING BTREE,
  KEY `book_name` (`book_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书的点击量排行榜';

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
  PRIMARY KEY (`stack_id`),
  KEY `stack_position` (`stack_position`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8 COMMENT='书库信息';

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
-- Table structure for book_type
-- ----------------------------
DROP TABLE IF EXISTS `book_type`;
CREATE TABLE `book_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '图书类别id',
  `type_name` varchar(50) NOT NULL COMMENT '类别名称',
  PRIMARY KEY (`type_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1023 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='图书类别信息';

-- ----------------------------
-- Records of book_type
-- ----------------------------
BEGIN;
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1001, '政治、法律');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1002, '文学');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1003, '语言、文字');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1004, '社会科学总论');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1005, '历史、地理');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1006, '哲学、宗教');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1007, '马克思主义、列宁主义、毛泽东思想、邓小平理论');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1008, '医药、卫生');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1009, '经济');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1010, '军事');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1011, '自然科学总论');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1012, '艺术');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1013, '天文学、地球科学');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1014, '农业科学');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1015, '综合性图书');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1016, '环境科学、安全科学');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1017, '航空、航天');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1018, '交通运输');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1019, '工业技术');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1020, '文化、科学、教育、体育');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1021, '数理科学和化学');
INSERT INTO `book_type` (`type_id`, `type_name`) VALUES (1022, '生物科学');
COMMIT;

-- ----------------------------
-- Table structure for book_usage
-- ----------------------------
DROP TABLE IF EXISTS `book_usage`;
CREATE TABLE `book_usage` (
  `card_id` int(11) NOT NULL COMMENT '借阅卡号',
  `book_name` varchar(255) NOT NULL COMMENT '借阅图书名称',
  `barrow_limit` int(2) NOT NULL COMMENT '借书期限',
  `barrow_date` date NOT NULL COMMENT '借书日期',
  `back_date` date DEFAULT NULL COMMENT '还书截止日期',
  PRIMARY KEY (`card_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='图书借阅状态信息';

-- ----------------------------
-- Records of book_usage
-- ----------------------------
BEGIN;
INSERT INTO `book_usage` (`card_id`, `book_name`, `barrow_limit`, `barrow_date`, `back_date`) VALUES (2121502100, '《茶花女》', 7, '2023-03-09', '2023-03-15');
COMMIT;

-- ----------------------------
-- Table structure for lib_worker
-- ----------------------------
DROP TABLE IF EXISTS `lib_worker`;
CREATE TABLE `lib_worker` (
  `worker_id` int(11) NOT NULL COMMENT '馆员id，工号',
  `worker_name` varchar(255) NOT NULL COMMENT '馆员名字',
  `sex` bit(1) DEFAULT NULL COMMENT '性别，0为男，1为女',
  `mobile` int(11) DEFAULT NULL COMMENT '馆员电话',
  `worker_type` varchar(255) NOT NULL COMMENT '身份类别',
  PRIMARY KEY (`worker_id`),
  KEY `worker_name` (`worker_name`,`worker_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='馆员信息表';

-- ----------------------------
-- Records of lib_worker
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student` (
  `stu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '学生id，学号，即借阅卡号',
  `stu_name` varchar(255) NOT NULL COMMENT '学生姓名',
  `stu_sex` varchar(2) NOT NULL COMMENT '性别',
  `stu_department` varchar(255) DEFAULT NULL COMMENT '学院',
  `stu_class` varchar(255) DEFAULT NULL COMMENT '班级',
  `stu_mobile` varchar(11) NOT NULL COMMENT '手机号码',
  PRIMARY KEY (`stu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2121502101 DEFAULT CHARSET=utf8 COMMENT='学生表';

-- ----------------------------
-- Records of student
-- ----------------------------
BEGIN;
INSERT INTO `student` (`stu_id`, `stu_name`, `stu_sex`, `stu_department`, `stu_class`, `stu_mobile`) VALUES (2121502100, '张三', '男', '大数据学院', '21计算机科学与技术一班', '13912346666');
COMMIT;

-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '教职工id，即借阅卡号',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `sex` varchar(2) NOT NULL COMMENT '性别',
  `depatment` varchar(255) DEFAULT NULL COMMENT '院系',
  `class` varchar(255) DEFAULT NULL COMMENT '所管理班级',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2113956201 DEFAULT CHARSET=utf8 COMMENT='教师表';

-- ----------------------------
-- Records of teacher
-- ----------------------------
BEGIN;
INSERT INTO `teacher` (`teacher_id`, `name`, `sex`, `depatment`, `class`, `mobile`) VALUES (2113956200, '李思雨', '女', '艺术学院', '21音乐一班', '19910712541');
COMMIT;

-- ----------------------------
-- Table structure for user_type
-- ----------------------------
DROP TABLE IF EXISTS `user_type`;
CREATE TABLE `user_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '角色id',
  `usertype_name` varchar(255) NOT NULL COMMENT '角色名称',
  PRIMARY KEY (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1005 DEFAULT CHARSET=utf8 COMMENT='角色信息表';

-- ----------------------------
-- Records of user_type
-- ----------------------------
BEGIN;
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (1001, '学生');
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (1002, '教师');
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (1003, '图书管理员');
INSERT INTO `user_type` (`type_id`, `usertype_name`) VALUES (1004, '超级管理员');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
