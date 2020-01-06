/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : localhost:3306
 Source Schema         : fastfood

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 07/01/2020 20:31:27
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for address
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address`  (
  `id_address` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NULL DEFAULT NULL,
  `name_address` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) UNSIGNED ZEROFILL NULL DEFAULT 0,
  PRIMARY KEY (`id_address`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of address
-- ----------------------------
INSERT INTO `address` VALUES (1, 2, '206 / 30D, Đường Trần Bá Giao, Phường 05, Quận Gò Vấp, TP Hồ Chí Minh, Việt Nam', 1);
INSERT INTO `address` VALUES (2, 2, '56, Đường Đông Bắc, Phường Tân Chánh Hiệp, Quận 12, TP Hồ Chí Minh, Việt Nam', 0);
INSERT INTO `address` VALUES (3, 1, '183, Lê Duẩn, Xã Hòa Châu, Huyện Hòa Vang, TP Đà Nẵng, Việt Nam', 1);
INSERT INTO `address` VALUES (4, 2, '112, Võ Oanh, Phường 25, Quận Bình Thạnh, TP Hồ Chí Minh, Việt Nam', 0);
INSERT INTO `address` VALUES (5, 3, '235, Đường Lý Tự Trọng, Phường 06, Quận Tân Bình, TP Hồ Chí Minh, Việt Nam', 1);

-- ----------------------------
-- Table structure for bill
-- ----------------------------
DROP TABLE IF EXISTS `bill`;
CREATE TABLE `bill`  (
  `id_bill` int(20) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NULL DEFAULT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `ship` decimal(10, 0) NULL DEFAULT NULL,
  `totalprice` decimal(10, 0) NULL DEFAULT NULL,
  `created_at` date NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_bill`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bill
-- ----------------------------
INSERT INTO `bill` VALUES (1, 2, 'Customer', '0313271812', '206 / 30D, Đường Trần Bá Giao, Phường 05, Quận Gò Vấp, TP Hồ Chí Minh, Việt Nam', 11000, 101000, '2020-01-05', '2020-01-07 00:09:51', 4);

-- ----------------------------
-- Table structure for bill_detail
-- ----------------------------
DROP TABLE IF EXISTS `bill_detail`;
CREATE TABLE `bill_detail`  (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_bill` int(11) NULL DEFAULT NULL,
  `id_pro` int(11) NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of bill_detail
-- ----------------------------
INSERT INTO `bill_detail` VALUES (1, 1, 2, 1, 31000);
INSERT INTO `bill_detail` VALUES (2, 1, 5, 1, 59000);

-- ----------------------------
-- Table structure for book_party
-- ----------------------------
DROP TABLE IF EXISTS `book_party`;
CREATE TABLE `book_party`  (
  `id_book` int(11) NOT NULL AUTO_INCREMENT,
  `child_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `parent_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `birthday` date NULL DEFAULT NULL,
  `date_organized` date NULL DEFAULT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` tinyint(1) NULL DEFAULT NULL,
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `number` int(11) NULL DEFAULT NULL,
  `required` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_book`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for branch
-- ----------------------------
DROP TABLE IF EXISTS `branch`;
CREATE TABLE `branch`  (
  `id_branch` int(11) NOT NULL AUTO_INCREMENT,
  `local` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `hotline` varchar(15) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_branch`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 19 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of branch
-- ----------------------------
INSERT INTO `branch` VALUES (1, 'Phú Mỹ Hưng: 062 Nguyễn Đức Cảnh, KP Mỹ Khánh 3-H11-2, P.Tân Phong, Q.7, HCM', ' (028) 5412 45');
INSERT INTO `branch` VALUES (2, 'Cộng Hòa: Vinmark Cộng Hòa, 15-17 Cộng Hòa, P4, Q.Tân Bình, HCM', '(028) 3948 3238');
INSERT INTO `branch` VALUES (3, '58/13 Nguyễn Bỉnh Khiêm, P.Dakao, Q.1, HCM (bùng binh Điện Biên Phủ)', '(028) 3820 0598');
INSERT INTO `branch` VALUES (4, 'Bưu điện: 02 Công xã Paris, P.Tân Định, Q.1, HCM (Bưu điện HCM)', '(028) 3825 6986');
INSERT INTO `branch` VALUES (5, 'Thảo Điền: 20 Thảo Điền, KP2, Thảo Điền, Q.2, HCM', '(028) 3519 1029');
INSERT INTO `branch` VALUES (6, 'Lũy Bán Bích: 661/1-661/3 Lũy Bán Bích, P.Phú Thạnh, Q.Tân Phú, HCM', '(028) 35 127 36');
INSERT INTO `branch` VALUES (7, 'D2 Bình Thạnh: 67-69 D2, P.25, Q.Bình Thạnh, HCM', '(08) 3851 0481');
INSERT INTO `branch` VALUES (8, 'Dương Bá Trạc: 222-228 Dương Bá Trạc, P2, Q.8, HCM', '(028) 3827 3970');
INSERT INTO `branch` VALUES (9, 'Grand Hotel: 8 Đồng Khởi, Q.1, HCM (mặt đường Ngô Đức Kế)', '(028) 37752 286');
INSERT INTO `branch` VALUES (10, 'Nguyễn Thị Thập: 332 Nguyễn Thị Thập, P. Tân Quý, Q.7, HCM', '(028) 39623 440');
INSERT INTO `branch` VALUES (11, 'Lê Đại Hành: 397A Lê Đại Hành, P.11, Q.11, HCM', '(028) 3855 0018');
INSERT INTO `branch` VALUES (12, 'Tùng Thiện Vương: 311 Tùng Thiện Vương, P.11, Q.8, HCM', '(028) 3916 1686');
INSERT INTO `branch` VALUES (13, 'Lê Đức Thọ: 121 Lê Đức Thọ, P.17, Q. Gò Vấp, HCM', '(028) 38777 897');
INSERT INTO `branch` VALUES (14, 'Phú Lâm: 500B Nguyễn Văn Luông, P.12, Q6, HCM (vòng xoay Phú Lâm)', '(028) 3620 8277');
INSERT INTO `branch` VALUES (15, 'Hương Lộ 2: 756 Hương Lộ 2, KP 6, P. Bình Trị Đông A, Q. Bình Tân', '(024) 625 44 25');
INSERT INTO `branch` VALUES (16, 'Chung cư D2, Giảng Võ, Q.Ba Đình, Hà Nội', '(024) 3266 9131');
INSERT INTO `branch` VALUES (17, 'AEON Mall Long Biên, 27 Cổ Linh, Q. Long Biên, Hà Nội', '(024) 3200 2842');
INSERT INTO `branch` VALUES (18, '3&3B Lê Thái Tổ, P. Hàng Trống, Q. Hoàn Kiếm, Hà Nội', '(024) 3266 9133');

-- ----------------------------
-- Table structure for cart
-- ----------------------------
DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart`  (
  `id_temp` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NULL DEFAULT NULL,
  `id_pro` int(11) NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_temp`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 13 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of cart
-- ----------------------------
INSERT INTO `cart` VALUES (8, 2, 1, 1);
INSERT INTO `cart` VALUES (9, 1, 1, 1);
INSERT INTO `cart` VALUES (10, 3, 1, 2);
INSERT INTO `cart` VALUES (11, 3, 3, 1);
INSERT INTO `cart` VALUES (12, 2, 3, 2);

-- ----------------------------
-- Table structure for city
-- ----------------------------
DROP TABLE IF EXISTS `city`;
CREATE TABLE `city`  (
  `id_city` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_city`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 80 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of city
-- ----------------------------
INSERT INTO `city` VALUES (1, 'TP Hà Nội', 'Thành phố Trung ương');
INSERT INTO `city` VALUES (48, 'TP Đà Nẵng', 'Thành phố Trung ương');
INSERT INTO `city` VALUES (79, 'TP Hồ Chí Minh', 'Thành phố Trung ương');

-- ----------------------------
-- Table structure for combo_detail
-- ----------------------------
DROP TABLE IF EXISTS `combo_detail`;
CREATE TABLE `combo_detail`  (
  `id_com_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_combo` int(11) NULL DEFAULT NULL,
  `id_pro` int(11) NULL DEFAULT NULL,
  `qty` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_com_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 18 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of combo_detail
-- ----------------------------
INSERT INTO `combo_detail` VALUES (1, 5, 1, 1);
INSERT INTO `combo_detail` VALUES (2, 5, 3, 1);
INSERT INTO `combo_detail` VALUES (3, 5, 4, 1);
INSERT INTO `combo_detail` VALUES (4, 8, 1, 4);
INSERT INTO `combo_detail` VALUES (5, 8, 4, 1);
INSERT INTO `combo_detail` VALUES (6, 23, 10, 1);
INSERT INTO `combo_detail` VALUES (7, 23, 3, 1);
INSERT INTO `combo_detail` VALUES (8, 24, 7, 3);
INSERT INTO `combo_detail` VALUES (9, 24, 14, 1);
INSERT INTO `combo_detail` VALUES (10, 24, 4, 1);
INSERT INTO `combo_detail` VALUES (11, 25, 7, 2);
INSERT INTO `combo_detail` VALUES (12, 25, 12, 1);
INSERT INTO `combo_detail` VALUES (13, 25, 4, 1);
INSERT INTO `combo_detail` VALUES (14, 25, 16, 1);
INSERT INTO `combo_detail` VALUES (15, 26, 1, 2);
INSERT INTO `combo_detail` VALUES (16, 26, 7, 2);
INSERT INTO `combo_detail` VALUES (17, 26, 3, 1);

-- ----------------------------
-- Table structure for district
-- ----------------------------
DROP TABLE IF EXISTS `district`;
CREATE TABLE `district`  (
  `id_district` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_city` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_district`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 788 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of district
-- ----------------------------
INSERT INTO `district` VALUES (1, 'Quận Ba Đình', 'Quận', 1);
INSERT INTO `district` VALUES (2, 'Quận Hoàn Kiếm', 'Quận', 1);
INSERT INTO `district` VALUES (3, 'Quận Tây Hồ', 'Quận', 1);
INSERT INTO `district` VALUES (4, 'Quận Long Biên', 'Quận', 1);
INSERT INTO `district` VALUES (5, 'Quận Cầu Giấy', 'Quận', 1);
INSERT INTO `district` VALUES (6, 'Quận Đống Đa', 'Quận', 1);
INSERT INTO `district` VALUES (7, 'Quận Hai Bà Trưng', 'Quận', 1);
INSERT INTO `district` VALUES (8, 'Quận Hoàng Mai', 'Quận', 1);
INSERT INTO `district` VALUES (9, 'Quận Thanh Xuân', 'Quận', 1);
INSERT INTO `district` VALUES (16, 'Huyện Sóc Sơn', 'Huyện', 1);
INSERT INTO `district` VALUES (17, 'Huyện Đông Anh', 'Huyện', 1);
INSERT INTO `district` VALUES (18, 'Huyện Gia Lâm', 'Huyện', 1);
INSERT INTO `district` VALUES (19, 'Quận Nam Từ Liêm', 'Quận', 1);
INSERT INTO `district` VALUES (20, 'Huyện Thanh Trì', 'Huyện', 1);
INSERT INTO `district` VALUES (21, 'Quận Bắc Từ Liêm', 'Quận', 1);
INSERT INTO `district` VALUES (490, 'Quận Liên Chiểu', 'Quận', 48);
INSERT INTO `district` VALUES (491, 'Quận Thanh Khê', 'Quận', 48);
INSERT INTO `district` VALUES (492, 'Quận Hải Châu', 'Quận', 48);
INSERT INTO `district` VALUES (493, 'Quận Sơn Trà', 'Quận', 48);
INSERT INTO `district` VALUES (494, 'Quận Ngũ Hành Sơn', 'Quận', 48);
INSERT INTO `district` VALUES (495, 'Quận Cẩm Lệ', 'Quận', 48);
INSERT INTO `district` VALUES (497, 'Huyện Hòa Vang', 'Huyện', 48);
INSERT INTO `district` VALUES (498, 'Huyện Hoàng Sa', 'Huyện', 48);
INSERT INTO `district` VALUES (760, 'Quận 1', 'Quận', 79);
INSERT INTO `district` VALUES (761, 'Quận 12', 'Quận', 79);
INSERT INTO `district` VALUES (762, 'Quận Thủ Đức', 'Quận', 79);
INSERT INTO `district` VALUES (763, 'Quận 9', 'Quận', 79);
INSERT INTO `district` VALUES (764, 'Quận Gò Vấp', 'Quận', 79);
INSERT INTO `district` VALUES (765, 'Quận Bình Thạnh', 'Quận', 79);
INSERT INTO `district` VALUES (766, 'Quận Tân Bình', 'Quận', 79);
INSERT INTO `district` VALUES (767, 'Quận Tân Phú', 'Quận', 79);
INSERT INTO `district` VALUES (768, 'Quận Phú Nhuận', 'Quận', 79);
INSERT INTO `district` VALUES (769, 'Quận 2', 'Quận', 79);
INSERT INTO `district` VALUES (770, 'Quận 3', 'Quận', 79);
INSERT INTO `district` VALUES (771, 'Quận 10', 'Quận', 79);
INSERT INTO `district` VALUES (772, 'Quận 11', 'Quận', 79);
INSERT INTO `district` VALUES (773, 'Quận 4', 'Quận', 79);
INSERT INTO `district` VALUES (774, 'Quận 5', 'Quận', 79);
INSERT INTO `district` VALUES (775, 'Quận 6', 'Quận', 79);
INSERT INTO `district` VALUES (776, 'Quận 8', 'Quận', 79);
INSERT INTO `district` VALUES (777, 'Quận Bình Tân', 'Quận', 79);
INSERT INTO `district` VALUES (778, 'Quận 7', 'Quận', 79);
INSERT INTO `district` VALUES (783, 'Huyện Củ Chi', 'Huyện', 79);
INSERT INTO `district` VALUES (784, 'Huyện Hóc Môn', 'Huyện', 79);
INSERT INTO `district` VALUES (785, 'Huyện Bình Chánh', 'Huyện', 79);
INSERT INTO `district` VALUES (786, 'Huyện Nhà Bè', 'Huyện', 79);
INSERT INTO `district` VALUES (787, 'Huyện Cần Giờ', 'Huyện', 79);

-- ----------------------------
-- Table structure for notify
-- ----------------------------
DROP TABLE IF EXISTS `notify`;
CREATE TABLE `notify`  (
  `id_notify` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) NULL DEFAULT NULL,
  `type_receiver` tinyint(1) NULL DEFAULT 0,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `message` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
  `date_send` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_notify`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of notify
-- ----------------------------
INSERT INTO `notify` VALUES (1, NULL, 2, 'Giờ Làm Việc', '<p>Th&ocirc;ng b&aacute;o về giờ giấc l&agrave;m việc c&oacute; sự thay đổi bắt đầu từ ng&agrave;y <strong>08-01-2020</strong>. Giờ l&agrave;m việc buổi s&aacute;ng sẽ bắt đầu v&agrave;o l&uacute;c <strong>08:00h</strong>.</p>\r\n', '2020-01-07');
INSERT INTO `notify` VALUES (2, NULL, 1, 'Khuyến mãi', '<p>Chương tr&igrave;nh khuyến m&atilde;i <strong>9%</strong> đang được diễn ra v&agrave; &aacute;p dụng đối với tất cả c&aacute;c sản phẩm. Chương tr&igrave;nh diễn ra bắt đầu&nbsp;từ ng&agrave;y <strong>05-01-2020</strong> đến hết ng&agrave;y <strong>09-01-2020</strong>.', '2020-01-07');
INSERT INTO `notify` VALUES (3, NULL, 1, 'Thời gian phục vụ', '<p>Th&ocirc;ng b&aacute;o về thời gian hoạt động của cửa h&agrave;ng v&agrave;o dịp tết. Để mọi người đều được đ&oacute;n tết c&ugrave;ng gia đ&igrave;nh, cửa h&agrave;ng ch&uacute;ng t&ocirc;i sẽ nghĩ v&agrave;o ng&agrave;y mồng 1&nbsp;tết tương ứng&nbsp;<strong>DL : 25-01-2019</strong>, c&aacute;c ng&agrave;y sau đ&oacute; đều hoạt động b&igrave;nh thường. Tr&acirc;n trọng !!!</p>\r\n', '2020-01-07');

-- ----------------------------
-- Table structure for notify_staff
-- ----------------------------
DROP TABLE IF EXISTS `notify_staff`;
CREATE TABLE `notify_staff`  (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_notify` int(11) NULL DEFAULT NULL,
  `id_staff` int(11) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of notify_staff
-- ----------------------------
INSERT INTO `notify_staff` VALUES (1, 1, 1, 1);
INSERT INTO `notify_staff` VALUES (2, 1, 2, 0);

-- ----------------------------
-- Table structure for notify_user
-- ----------------------------
DROP TABLE IF EXISTS `notify_user`;
CREATE TABLE `notify_user`  (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_notify` int(11) NULL DEFAULT NULL,
  `id_user` int(11) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of notify_user
-- ----------------------------
INSERT INTO `notify_user` VALUES (1, 2, 1, 0);
INSERT INTO `notify_user` VALUES (2, 2, 2, 1);
INSERT INTO `notify_user` VALUES (3, 2, 3, 0);
INSERT INTO `notify_user` VALUES (4, 3, 1, 0);
INSERT INTO `notify_user` VALUES (5, 3, 2, 0);
INSERT INTO `notify_user` VALUES (6, 3, 3, 0);

-- ----------------------------
-- Table structure for per_detail
-- ----------------------------
DROP TABLE IF EXISTS `per_detail`;
CREATE TABLE `per_detail`  (
  `id_detail` int(11) NOT NULL AUTO_INCREMENT,
  `id_per` int(11) NULL DEFAULT NULL,
  `action_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `action_detail` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `action_status` tinyint(1) NULL DEFAULT NULL,
  PRIMARY KEY (`id_detail`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Table structure for permission
-- ----------------------------
DROP TABLE IF EXISTS `permission`;
CREATE TABLE `permission`  (
  `id_per` int(11) NOT NULL AUTO_INCREMENT,
  `name_per` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_per`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of permission
-- ----------------------------
INSERT INTO `permission` VALUES (1, 'Quản trị viên cấp cao');
INSERT INTO `permission` VALUES (2, 'Quản lý người dùng');
INSERT INTO `permission` VALUES (3, 'Quản lý Sản phẩm');
INSERT INTO `permission` VALUES (4, 'Quản lý đơn hàng');
INSERT INTO `permission` VALUES (5, 'Quản lý khuyến mãi');
INSERT INTO `permission` VALUES (6, 'Quản lý  thông báo');
INSERT INTO `permission` VALUES (7, 'Chưa phân quyền');

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id_pro` int(11) NOT NULL AUTO_INCREMENT,
  `id_type` int(11) NULL DEFAULT 1,
  `name_pro` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `qty` int(2) NULL DEFAULT 0,
  `price` decimal(10, 0) NULL DEFAULT NULL,
  `images` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `descript` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_pro`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, 2, 'Gà chiên giòn', 20, 50000, 'chicken_4.jpg', '2 đùi gà lớn chiên KFC', 1);
INSERT INTO `product` VALUES (2, 3, 'Burger Hotdog', 0, 35000, 'burger_1.jpg', '1 bánh Burger Hotdog kẹp xúc xích', 1);
INSERT INTO `product` VALUES (3, 4, 'Coca Cola', 0, 17000, 'drink_1.jpg', '1 chai Coca Cola ướp lạnh', 1);
INSERT INTO `product` VALUES (4, 5, 'Khoai tây chiên', 10, 10000, 'dish_extra_2.jpg', '1 phần ăn khoai tây chiên', 1);
INSERT INTO `product` VALUES (5, 1, 'Combo Gà chiên giòn', 20, 65000, 'combo.jpg', 'Combo 1 Gà chiên giòn + 1 Coca Cola + 1 Khoai tây chiên', 1);
INSERT INTO `product` VALUES (6, 2, 'Cánh Gà Chiên Giòn', 0, 35000, 'chicken_1.jpg', '2 Cánh gà chiên giòn + 1 phần tương ớt.', 1);
INSERT INTO `product` VALUES (7, 2, '3 Miếng Gà Giòn Không Xương', 0, 55000, 'chicken_3.jpg', '3 miếng gà không xương + 1 chén sốt mayo.', 1);
INSERT INTO `product` VALUES (8, 1, 'Combo Đùi Gà Chiên Giòn', 0, 149000, 'combo_5.jpg', '4 đùi gà gà chiên giòn + 1 phần khoai tây chiên + 1 chén tương.', 1);
INSERT INTO `product` VALUES (9, 3, 'Burger Cá Rán', 0, 57000, 'burger.jpg', '1 burger cá + 1 phần khoai tây chiên (vừa)', 1);
INSERT INTO `product` VALUES (10, 3, 'Burger Phô Mai', 0, 44000, 'burger_2.jpg', '1 bánh burger phô mai vị béo', 1);
INSERT INTO `product` VALUES (11, 3, 'Burger thịt chiên', 0, 55000, 'burger_4.jpg', '1 burger thịt chiên + 1 chén tương', 1);
INSERT INTO `product` VALUES (12, 3, 'Burger thịt gà chiên', 0, 47000, 'burger_5.jpg', '1 burger thịt gà chiên + 1 chén tương', 1);
INSERT INTO `product` VALUES (13, 3, 'Burger gà cajun', 0, 54000, 'burger_8.jpg', '1 Burger gà Cajun + 1 chén tương', 1);
INSERT INTO `product` VALUES (14, 4, 'Sprite', 0, 17000, 'drink_2.jpg', 'Sprite 500 ml', 1);
INSERT INTO `product` VALUES (15, 4, 'Fanta', 0, 17000, 'drink_3.jpg', 'Fanta 500ml', 1);
INSERT INTO `product` VALUES (16, 4, 'Pepsi', 0, 17000, 'drink_4.jpg', '1 pepsi 500ml', 1);
INSERT INTO `product` VALUES (17, 4, 'Sting', 0, 17000, 'drink_5.jpg', '1 Sting 500ml', 1);
INSERT INTO `product` VALUES (18, 4, 'Strongbow', 0, 23000, 'drink_6.jpg', '1 Strongbow 500ml', 1);
INSERT INTO `product` VALUES (19, 5, '3 bánh khoai tây', 0, 20000, 'dish_extra_5.jpg', '3 bánh khoai tây vị mật ong', 1);
INSERT INTO `product` VALUES (20, 5, 'Cơm', 0, 10000, 'dish_extra_1.jpg', '1 chén cơm thêm', 1);
INSERT INTO `product` VALUES (21, 5, '1 chén canh súp', 0, 12000, 'dish_extra_3.jpg', '1 chén canh sup tùy theo ngày', 1);
INSERT INTO `product` VALUES (22, 5, '2 lát bánh mì', 0, 10000, 'dish_extra_6.jpg', '1 lát bánh mỳ ăn kèm', 1);
INSERT INTO `product` VALUES (23, 1, 'Combo Burger cajun', 20, 59000, 'combo_1.jpg', '1 bánh burger + 1 cocacola cho 1 người ăn', 1);
INSERT INTO `product` VALUES (24, 1, 'Combo 3 miếng Gà Rút Xương', 0, 64000, 'combo_2.jpg', '3 miếng gà rút xương + 1 phần khoai tây chiên + 1 sprite (500ml)', 1);
INSERT INTO `product` VALUES (25, 1, 'Combo Gà Burger', 0, 77000, 'combo_3.jpg', '2 miếng gà rút xương + 1 Bánh burger thịt chiên + 1 phần khoai tây chiên + 1 pepsi (500ml)', 1);
INSERT INTO `product` VALUES (26, 1, 'Combo Đùi Gà', 0, 88000, 'combo_4.jpg', '2 Đùi gà chiên + 2 Miếng gà rút xương + 2 cocacola', 1);

-- ----------------------------
-- Table structure for product_type
-- ----------------------------
DROP TABLE IF EXISTS `product_type`;
CREATE TABLE `product_type`  (
  `id_type` int(11) NOT NULL AUTO_INCREMENT,
  `name_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `images` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  PRIMARY KEY (`id_type`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of product_type
-- ----------------------------
INSERT INTO `product_type` VALUES (1, 'Combo', 'combo.jpg', 1);
INSERT INTO `product_type` VALUES (2, 'Gà Rán', 'chicken.jpg', 1);
INSERT INTO `product_type` VALUES (3, 'Burger', 'burger.jpg', 1);
INSERT INTO `product_type` VALUES (4, 'Nước Uống', 'drink.jpg', 1);
INSERT INTO `product_type` VALUES (5, 'Món ăn kèm', 'dish_extra.jpg', 1);

-- ----------------------------
-- Table structure for promotions
-- ----------------------------
DROP TABLE IF EXISTS `promotions`;
CREATE TABLE `promotions`  (
  `id_promo` int(11) NOT NULL AUTO_INCREMENT,
  `name_promo` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type_promo` tinyint(1) NULL DEFAULT NULL,
  `value` decimal(10, 0) NULL DEFAULT 0,
  `date_start` date NULL DEFAULT NULL,
  `date_end` date NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_promo`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of promotions
-- ----------------------------
INSERT INTO `promotions` VALUES (1, 'Mừng năm mới', 2, 9, '2020-01-05', '2020-01-09', 2);

-- ----------------------------
-- Table structure for sale_product
-- ----------------------------
DROP TABLE IF EXISTS `sale_product`;
CREATE TABLE `sale_product`  (
  `id_sale` int(11) NOT NULL AUTO_INCREMENT,
  `id_promo` int(11) NULL DEFAULT NULL,
  `id_pro` int(11) NULL DEFAULT NULL,
  `reduced_price` decimal(10, 0) NULL DEFAULT NULL,
  PRIMARY KEY (`id_sale`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of sale_product
-- ----------------------------
INSERT INTO `sale_product` VALUES (1, 2, 1, 39000);
INSERT INTO `sale_product` VALUES (2, 2, 2, 29000);

-- ----------------------------
-- Table structure for ship
-- ----------------------------
DROP TABLE IF EXISTS `ship`;
CREATE TABLE `ship`  (
  `id_ship` int(11) NOT NULL AUTO_INCREMENT,
  `ship` decimal(10, 0) NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_ship`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ship
-- ----------------------------
INSERT INTO `ship` VALUES (1, 11000, 1);

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff`  (
  `id_staff` int(11) NOT NULL AUTO_INCREMENT,
  `staffname` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NULL DEFAULT 0,
  `created_at` date NULL DEFAULT NULL,
  `updated_at` date NULL DEFAULT NULL,
  PRIMARY KEY (`id_staff`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES (1, 'Admin', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0334548560', NULL, 1, '2019-12-20', '2020-01-07');
INSERT INTO `staff` VALUES (2, 'staff', 'staff@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '0346225423', NULL, 1, '2020-01-07', NULL);

-- ----------------------------
-- Table structure for staff_per
-- ----------------------------
DROP TABLE IF EXISTS `staff_per`;
CREATE TABLE `staff_per`  (
  `id_user_per` int(11) NOT NULL AUTO_INCREMENT,
  `id_per` int(11) NULL DEFAULT NULL,
  `id_staff` int(11) NULL DEFAULT NULL,
  `licensed` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_user_per`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of staff_per
-- ----------------------------
INSERT INTO `staff_per` VALUES (1, 1, 1, 1);
INSERT INTO `staff_per` VALUES (3, 3, 2, 1);
INSERT INTO `staff_per` VALUES (4, 4, 2, 1);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id_user` int(50) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `phone` varchar(11) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` date NULL DEFAULT NULL,
  `updated_at` datetime(0) NULL DEFAULT NULL,
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  PRIMARY KEY (`id_user`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'Hoài Nam', 'hoainam@gmail.com', '0336696741', 'e10adc3949ba59abbe56e057f20f883e', 1, '2019-12-20', NULL, NULL);
INSERT INTO `user` VALUES (2, 'Customer', 'customer@gmail.com', '0313271812', 'e10adc3949ba59abbe56e057f20f883e', 1, '2019-12-21', '2019-12-27 20:49:41', NULL);
INSERT INTO `user` VALUES (3, 'Hoa Lan', 'hoalan@gmail.com', '0324925233', 'e10adc3949ba59abbe56e057f20f883e', 1, '2019-12-25', NULL, NULL);

-- ----------------------------
-- Table structure for ward
-- ----------------------------
DROP TABLE IF EXISTS `ward`;
CREATE TABLE `ward`  (
  `id_ward` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `id_district` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id_ward`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 27683 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of ward
-- ----------------------------
INSERT INTO `ward` VALUES (1, 'Phường Phúc Xá', 'Phường', 1);
INSERT INTO `ward` VALUES (4, 'Phường Trúc Bạch', 'Phường', 1);
INSERT INTO `ward` VALUES (6, 'Phường Vĩnh Phúc', 'Phường', 1);
INSERT INTO `ward` VALUES (7, 'Phường Cống Vị', 'Phường', 1);
INSERT INTO `ward` VALUES (8, 'Phường Liễu Giai', 'Phường', 1);
INSERT INTO `ward` VALUES (10, 'Phường Nguyễn Trung Trực', 'Phường', 1);
INSERT INTO `ward` VALUES (13, 'Phường Quán Thánh', 'Phường', 1);
INSERT INTO `ward` VALUES (16, 'Phường Ngọc Hà', 'Phường', 1);
INSERT INTO `ward` VALUES (19, 'Phường Điện Biên', 'Phường', 1);
INSERT INTO `ward` VALUES (22, 'Phường Đội Cấn', 'Phường', 1);
INSERT INTO `ward` VALUES (25, 'Phường Ngọc Khánh', 'Phường', 1);
INSERT INTO `ward` VALUES (28, 'Phường Kim Mã', 'Phường', 1);
INSERT INTO `ward` VALUES (31, 'Phường Giảng Võ', 'Phường', 1);
INSERT INTO `ward` VALUES (34, 'Phường Thành Công', 'Phường', 1);
INSERT INTO `ward` VALUES (37, 'Phường Phúc Tân', 'Phường', 2);
INSERT INTO `ward` VALUES (40, 'Phường Đồng Xuân', 'Phường', 2);
INSERT INTO `ward` VALUES (43, 'Phường Hàng Mã', 'Phường', 2);
INSERT INTO `ward` VALUES (46, 'Phường Hàng Buồm', 'Phường', 2);
INSERT INTO `ward` VALUES (49, 'Phường Hàng Đào', 'Phường', 2);
INSERT INTO `ward` VALUES (52, 'Phường Hàng Bồ', 'Phường', 2);
INSERT INTO `ward` VALUES (55, 'Phường Cửa Đông', 'Phường', 2);
INSERT INTO `ward` VALUES (58, 'Phường Lý Thái Tổ', 'Phường', 2);
INSERT INTO `ward` VALUES (61, 'Phường Hàng Bạc', 'Phường', 2);
INSERT INTO `ward` VALUES (64, 'Phường Hàng Gai', 'Phường', 2);
INSERT INTO `ward` VALUES (67, 'Phường Chương Dương Độ', 'Phường', 2);
INSERT INTO `ward` VALUES (70, 'Phường Hàng Trống', 'Phường', 2);
INSERT INTO `ward` VALUES (73, 'Phường Cửa Nam', 'Phường', 2);
INSERT INTO `ward` VALUES (76, 'Phường Hàng Bông', 'Phường', 2);
INSERT INTO `ward` VALUES (79, 'Phường Tràng Tiền', 'Phường', 2);
INSERT INTO `ward` VALUES (82, 'Phường Trần Hưng Đạo', 'Phường', 2);
INSERT INTO `ward` VALUES (85, 'Phường Phan Chu Trinh', 'Phường', 2);
INSERT INTO `ward` VALUES (88, 'Phường Hàng Bài', 'Phường', 2);
INSERT INTO `ward` VALUES (91, 'Phường Phú Thượng', 'Phường', 3);
INSERT INTO `ward` VALUES (94, 'Phường Nhật Tân', 'Phường', 3);
INSERT INTO `ward` VALUES (97, 'Phường Tứ Liên', 'Phường', 3);
INSERT INTO `ward` VALUES (100, 'Phường Quảng An', 'Phường', 3);
INSERT INTO `ward` VALUES (103, 'Phường Xuân La', 'Phường', 3);
INSERT INTO `ward` VALUES (106, 'Phường Yên Phụ', 'Phường', 3);
INSERT INTO `ward` VALUES (109, 'Phường Bưởi', 'Phường', 3);
INSERT INTO `ward` VALUES (112, 'Phường Thụy Khuê', 'Phường', 3);
INSERT INTO `ward` VALUES (115, 'Phường Thượng Thanh', 'Phường', 4);
INSERT INTO `ward` VALUES (118, 'Phường Ngọc Thụy', 'Phường', 4);
INSERT INTO `ward` VALUES (121, 'Phường Giang Biên', 'Phường', 4);
INSERT INTO `ward` VALUES (124, 'Phường Đức Giang', 'Phường', 4);
INSERT INTO `ward` VALUES (127, 'Phường Việt Hưng', 'Phường', 4);
INSERT INTO `ward` VALUES (130, 'Phường Gia Thụy', 'Phường', 4);
INSERT INTO `ward` VALUES (133, 'Phường Ngọc Lâm', 'Phường', 4);
INSERT INTO `ward` VALUES (136, 'Phường Phúc Lợi', 'Phường', 4);
INSERT INTO `ward` VALUES (139, 'Phường Bồ Đề', 'Phường', 4);
INSERT INTO `ward` VALUES (142, 'Phường Sài Đồng', 'Phường', 4);
INSERT INTO `ward` VALUES (145, 'Phường Long Biên', 'Phường', 4);
INSERT INTO `ward` VALUES (148, 'Phường Thạch Bàn', 'Phường', 4);
INSERT INTO `ward` VALUES (151, 'Phường Phúc Đồng', 'Phường', 4);
INSERT INTO `ward` VALUES (154, 'Phường Cự Khối', 'Phường', 4);
INSERT INTO `ward` VALUES (157, 'Phường Nghĩa Đô', 'Phường', 5);
INSERT INTO `ward` VALUES (160, 'Phường Nghĩa Tân', 'Phường', 5);
INSERT INTO `ward` VALUES (163, 'Phường Mai Dịch', 'Phường', 5);
INSERT INTO `ward` VALUES (166, 'Phường Dịch Vọng', 'Phường', 5);
INSERT INTO `ward` VALUES (167, 'Phường Dịch Vọng Hậu', 'Phường', 5);
INSERT INTO `ward` VALUES (169, 'Phường Quan Hoa', 'Phường', 5);
INSERT INTO `ward` VALUES (172, 'Phường Yên Hoà', 'Phường', 5);
INSERT INTO `ward` VALUES (175, 'Phường Trung Hoà', 'Phường', 5);
INSERT INTO `ward` VALUES (178, 'Phường Cát Linh', 'Phường', 6);
INSERT INTO `ward` VALUES (181, 'Phường Văn Miếu', 'Phường', 6);
INSERT INTO `ward` VALUES (184, 'Phường Quốc Tử Giám', 'Phường', 6);
INSERT INTO `ward` VALUES (187, 'Phường Láng Thượng', 'Phường', 6);
INSERT INTO `ward` VALUES (190, 'Phường Ô Chợ Dừa', 'Phường', 6);
INSERT INTO `ward` VALUES (193, 'Phường Văn Chương', 'Phường', 6);
INSERT INTO `ward` VALUES (196, 'Phường Hàng Bột', 'Phường', 6);
INSERT INTO `ward` VALUES (199, 'Phường Láng Hạ', 'Phường', 6);
INSERT INTO `ward` VALUES (202, 'Phường Khâm Thiên', 'Phường', 6);
INSERT INTO `ward` VALUES (205, 'Phường Thổ Quan', 'Phường', 6);
INSERT INTO `ward` VALUES (208, 'Phường Nam Đồng', 'Phường', 6);
INSERT INTO `ward` VALUES (211, 'Phường Trung Phụng', 'Phường', 6);
INSERT INTO `ward` VALUES (214, 'Phường Quang Trung', 'Phường', 6);
INSERT INTO `ward` VALUES (217, 'Phường Trung Liệt', 'Phường', 6);
INSERT INTO `ward` VALUES (220, 'Phường Phương Liên', 'Phường', 6);
INSERT INTO `ward` VALUES (223, 'Phường Thịnh Quang', 'Phường', 6);
INSERT INTO `ward` VALUES (226, 'Phường Trung Tự', 'Phường', 6);
INSERT INTO `ward` VALUES (229, 'Phường Kim Liên', 'Phường', 6);
INSERT INTO `ward` VALUES (232, 'Phường Phương Mai', 'Phường', 6);
INSERT INTO `ward` VALUES (235, 'Phường Ngã Tư Sở', 'Phường', 6);
INSERT INTO `ward` VALUES (238, 'Phường Khương Thượng', 'Phường', 6);
INSERT INTO `ward` VALUES (241, 'Phường Nguyễn Du', 'Phường', 7);
INSERT INTO `ward` VALUES (244, 'Phường Bạch Đằng', 'Phường', 7);
INSERT INTO `ward` VALUES (247, 'Phường Phạm Đình Hổ', 'Phường', 7);
INSERT INTO `ward` VALUES (250, 'Phường Bùi Thị Xuân', 'Phường', 7);
INSERT INTO `ward` VALUES (253, 'Phường Ngô Thì Nhậm', 'Phường', 7);
INSERT INTO `ward` VALUES (256, 'Phường Lê Đại Hành', 'Phường', 7);
INSERT INTO `ward` VALUES (259, 'Phường Đồng Nhân', 'Phường', 7);
INSERT INTO `ward` VALUES (262, 'Phường Phố Huế', 'Phường', 7);
INSERT INTO `ward` VALUES (265, 'Phường Đống Mác', 'Phường', 7);
INSERT INTO `ward` VALUES (268, 'Phường Thanh Lương', 'Phường', 7);
INSERT INTO `ward` VALUES (271, 'Phường Thanh Nhàn', 'Phường', 7);
INSERT INTO `ward` VALUES (274, 'Phường Cầu Dền', 'Phường', 7);
INSERT INTO `ward` VALUES (277, 'Phường Bách Khoa', 'Phường', 7);
INSERT INTO `ward` VALUES (280, 'Phường Đồng Tâm', 'Phường', 7);
INSERT INTO `ward` VALUES (283, 'Phường Vĩnh Tuy', 'Phường', 7);
INSERT INTO `ward` VALUES (286, 'Phường Bạch Mai', 'Phường', 7);
INSERT INTO `ward` VALUES (289, 'Phường Quỳnh Mai', 'Phường', 7);
INSERT INTO `ward` VALUES (292, 'Phường Quỳnh Lôi', 'Phường', 7);
INSERT INTO `ward` VALUES (295, 'Phường Minh Khai', 'Phường', 7);
INSERT INTO `ward` VALUES (298, 'Phường Trương Định', 'Phường', 7);
INSERT INTO `ward` VALUES (301, 'Phường Thanh Trì', 'Phường', 8);
INSERT INTO `ward` VALUES (304, 'Phường Vĩnh Hưng', 'Phường', 8);
INSERT INTO `ward` VALUES (307, 'Phường Định Công', 'Phường', 8);
INSERT INTO `ward` VALUES (310, 'Phường Mai Động', 'Phường', 8);
INSERT INTO `ward` VALUES (313, 'Phường Tương Mai', 'Phường', 8);
INSERT INTO `ward` VALUES (316, 'Phường Đại Kim', 'Phường', 8);
INSERT INTO `ward` VALUES (319, 'Phường Tân Mai', 'Phường', 8);
INSERT INTO `ward` VALUES (322, 'Phường Hoàng Văn Thụ', 'Phường', 8);
INSERT INTO `ward` VALUES (325, 'Phường Giáp Bát', 'Phường', 8);
INSERT INTO `ward` VALUES (328, 'Phường Lĩnh Nam', 'Phường', 8);
INSERT INTO `ward` VALUES (331, 'Phường Thịnh Liệt', 'Phường', 8);
INSERT INTO `ward` VALUES (334, 'Phường Trần Phú', 'Phường', 8);
INSERT INTO `ward` VALUES (337, 'Phường Hoàng Liệt', 'Phường', 8);
INSERT INTO `ward` VALUES (340, 'Phường Yên Sở', 'Phường', 8);
INSERT INTO `ward` VALUES (343, 'Phường Nhân Chính', 'Phường', 9);
INSERT INTO `ward` VALUES (346, 'Phường Thượng Đình', 'Phường', 9);
INSERT INTO `ward` VALUES (349, 'Phường Khương Trung', 'Phường', 9);
INSERT INTO `ward` VALUES (352, 'Phường Khương Mai', 'Phường', 9);
INSERT INTO `ward` VALUES (355, 'Phường Thanh Xuân Trung', 'Phường', 9);
INSERT INTO `ward` VALUES (358, 'Phường Phương Liệt', 'Phường', 9);
INSERT INTO `ward` VALUES (361, 'Phường Hạ Đình', 'Phường', 9);
INSERT INTO `ward` VALUES (364, 'Phường Khương Đình', 'Phường', 9);
INSERT INTO `ward` VALUES (367, 'Phường Thanh Xuân Bắc', 'Phường', 9);
INSERT INTO `ward` VALUES (370, 'Phường Thanh Xuân Nam', 'Phường', 9);
INSERT INTO `ward` VALUES (373, 'Phường Kim Giang', 'Phường', 9);
INSERT INTO `ward` VALUES (376, 'Thị trấn Sóc Sơn', 'Thị trấn', 16);
INSERT INTO `ward` VALUES (379, 'Xã Bắc Sơn', 'Xã', 16);
INSERT INTO `ward` VALUES (382, 'Xã Minh Trí', 'Xã', 16);
INSERT INTO `ward` VALUES (385, 'Xã Hồng Kỳ', 'Xã', 16);
INSERT INTO `ward` VALUES (388, 'Xã Nam Sơn', 'Xã', 16);
INSERT INTO `ward` VALUES (391, 'Xã Trung Giã', 'Xã', 16);
INSERT INTO `ward` VALUES (394, 'Xã Tân Hưng', 'Xã', 16);
INSERT INTO `ward` VALUES (397, 'Xã Minh Phú', 'Xã', 16);
INSERT INTO `ward` VALUES (400, 'Xã Phù Linh', 'Xã', 16);
INSERT INTO `ward` VALUES (403, 'Xã Bắc Phú', 'Xã', 16);
INSERT INTO `ward` VALUES (406, 'Xã Tân Minh', 'Xã', 16);
INSERT INTO `ward` VALUES (409, 'Xã Quang Tiến', 'Xã', 16);
INSERT INTO `ward` VALUES (412, 'Xã Hiền Ninh', 'Xã', 16);
INSERT INTO `ward` VALUES (415, 'Xã Tân Dân', 'Xã', 16);
INSERT INTO `ward` VALUES (418, 'Xã Tiên Dược', 'Xã', 16);
INSERT INTO `ward` VALUES (421, 'Xã Việt Long', 'Xã', 16);
INSERT INTO `ward` VALUES (424, 'Xã Xuân Giang', 'Xã', 16);
INSERT INTO `ward` VALUES (427, 'Xã Mai Đình', 'Xã', 16);
INSERT INTO `ward` VALUES (430, 'Xã Đức Hoà', 'Xã', 16);
INSERT INTO `ward` VALUES (433, 'Xã Thanh Xuân', 'Xã', 16);
INSERT INTO `ward` VALUES (436, 'Xã Đông Xuân', 'Xã', 16);
INSERT INTO `ward` VALUES (439, 'Xã Kim Lũ', 'Xã', 16);
INSERT INTO `ward` VALUES (442, 'Xã Phú Cường', 'Xã', 16);
INSERT INTO `ward` VALUES (445, 'Xã Phú Minh', 'Xã', 16);
INSERT INTO `ward` VALUES (448, 'Xã Phù Lỗ', 'Xã', 16);
INSERT INTO `ward` VALUES (451, 'Xã Xuân Thu', 'Xã', 16);
INSERT INTO `ward` VALUES (454, 'Thị trấn Đông Anh', 'Thị trấn', 17);
INSERT INTO `ward` VALUES (457, 'Xã Xuân Nộn', 'Xã', 17);
INSERT INTO `ward` VALUES (460, 'Xã Thuỵ Lâm', 'Xã', 17);
INSERT INTO `ward` VALUES (463, 'Xã Bắc Hồng', 'Xã', 17);
INSERT INTO `ward` VALUES (466, 'Xã Nguyên Khê', 'Xã', 17);
INSERT INTO `ward` VALUES (469, 'Xã Nam Hồng', 'Xã', 17);
INSERT INTO `ward` VALUES (472, 'Xã Tiên Dương', 'Xã', 17);
INSERT INTO `ward` VALUES (475, 'Xã Vân Hà', 'Xã', 17);
INSERT INTO `ward` VALUES (478, 'Xã Uy Nỗ', 'Xã', 17);
INSERT INTO `ward` VALUES (481, 'Xã Vân Nội', 'Xã', 17);
INSERT INTO `ward` VALUES (484, 'Xã Liên Hà', 'Xã', 17);
INSERT INTO `ward` VALUES (487, 'Xã Việt Hùng', 'Xã', 17);
INSERT INTO `ward` VALUES (490, 'Xã Kim Nỗ', 'Xã', 17);
INSERT INTO `ward` VALUES (493, 'Xã Kim Chung', 'Xã', 17);
INSERT INTO `ward` VALUES (496, 'Xã Dục Tú', 'Xã', 17);
INSERT INTO `ward` VALUES (499, 'Xã Đại Mạch', 'Xã', 17);
INSERT INTO `ward` VALUES (502, 'Xã Vĩnh Ngọc', 'Xã', 17);
INSERT INTO `ward` VALUES (505, 'Xã Cổ Loa', 'Xã', 17);
INSERT INTO `ward` VALUES (508, 'Xã Hải Bối', 'Xã', 17);
INSERT INTO `ward` VALUES (511, 'Xã Xuân Canh', 'Xã', 17);
INSERT INTO `ward` VALUES (514, 'Xã Võng La', 'Xã', 17);
INSERT INTO `ward` VALUES (517, 'Xã Tầm Xá', 'Xã', 17);
INSERT INTO `ward` VALUES (520, 'Xã Mai Lâm', 'Xã', 17);
INSERT INTO `ward` VALUES (523, 'Xã Đông Hội', 'Xã', 17);
INSERT INTO `ward` VALUES (526, 'Thị trấn Yên Viên', 'Thị trấn', 18);
INSERT INTO `ward` VALUES (529, 'Xã Yên Thường', 'Xã', 18);
INSERT INTO `ward` VALUES (532, 'Xã Yên Viên', 'Xã', 18);
INSERT INTO `ward` VALUES (535, 'Xã Ninh Hiệp', 'Xã', 18);
INSERT INTO `ward` VALUES (538, 'Xã Đình Xuyên', 'Xã', 18);
INSERT INTO `ward` VALUES (541, 'Xã Dương Hà', 'Xã', 18);
INSERT INTO `ward` VALUES (544, 'Xã Phù Đổng', 'Xã', 18);
INSERT INTO `ward` VALUES (547, 'Xã Trung Mầu', 'Xã', 18);
INSERT INTO `ward` VALUES (550, 'Xã Lệ Chi', 'Xã', 18);
INSERT INTO `ward` VALUES (553, 'Xã Cổ Bi', 'Xã', 18);
INSERT INTO `ward` VALUES (556, 'Xã Đặng Xá', 'Xã', 18);
INSERT INTO `ward` VALUES (559, 'Xã Phú Thị', 'Xã', 18);
INSERT INTO `ward` VALUES (562, 'Xã Kim Sơn', 'Xã', 18);
INSERT INTO `ward` VALUES (565, 'Thị trấn Trâu Quỳ', 'Thị trấn', 18);
INSERT INTO `ward` VALUES (568, 'Xã Dương Quang', 'Xã', 18);
INSERT INTO `ward` VALUES (571, 'Xã Dương Xá', 'Xã', 18);
INSERT INTO `ward` VALUES (574, 'Xã Đông Dư', 'Xã', 18);
INSERT INTO `ward` VALUES (577, 'Xã Đa Tốn', 'Xã', 18);
INSERT INTO `ward` VALUES (580, 'Xã Kiêu Kỵ', 'Xã', 18);
INSERT INTO `ward` VALUES (583, 'Xã Bát Tràng', 'Xã', 18);
INSERT INTO `ward` VALUES (586, 'Xã Kim Lan', 'Xã', 18);
INSERT INTO `ward` VALUES (589, 'Xã Văn Đức', 'Xã', 18);
INSERT INTO `ward` VALUES (592, 'Phường Cầu Diễn', 'Phường', 19);
INSERT INTO `ward` VALUES (595, 'Phường Thượng Cát', 'Phường', 21);
INSERT INTO `ward` VALUES (598, 'Phường Liên Mạc', 'Phường', 21);
INSERT INTO `ward` VALUES (601, 'Phường Đông Ngạc', 'Phường', 21);
INSERT INTO `ward` VALUES (602, 'Phường Đức Thắng', 'Phường', 21);
INSERT INTO `ward` VALUES (604, 'Phường Thụy Phương', 'Phường', 21);
INSERT INTO `ward` VALUES (607, 'Phường Tây Tựu', 'Phường', 21);
INSERT INTO `ward` VALUES (610, 'Phường Xuân Đỉnh', 'Phường', 21);
INSERT INTO `ward` VALUES (611, 'Phường Xuân Tảo', 'Phường', 21);
INSERT INTO `ward` VALUES (613, 'Phường Minh Khai', 'Phường', 21);
INSERT INTO `ward` VALUES (616, 'Phường Cổ Nhuế 1', 'Phường', 21);
INSERT INTO `ward` VALUES (617, 'Phường Cổ Nhuế 2', 'Phường', 21);
INSERT INTO `ward` VALUES (619, 'Phường Phú Diễn', 'Phường', 21);
INSERT INTO `ward` VALUES (620, 'Phường Phúc Diễn', 'Phường', 21);
INSERT INTO `ward` VALUES (622, 'Phường Xuân Phương', 'Phường', 19);
INSERT INTO `ward` VALUES (623, 'Phường Phương Canh', 'Phường', 19);
INSERT INTO `ward` VALUES (625, 'Phường Mỹ Đình 1', 'Phường', 19);
INSERT INTO `ward` VALUES (626, 'Phường Mỹ Đình 2', 'Phường', 19);
INSERT INTO `ward` VALUES (628, 'Phường Tây Mỗ', 'Phường', 19);
INSERT INTO `ward` VALUES (631, 'Phường Mễ Trì', 'Phường', 19);
INSERT INTO `ward` VALUES (632, 'Phường Phú Đô', 'Phường', 19);
INSERT INTO `ward` VALUES (634, 'Phường Đại Mỗ', 'Phường', 19);
INSERT INTO `ward` VALUES (637, 'Phường Trung Văn', 'Phường', 19);
INSERT INTO `ward` VALUES (640, 'Thị trấn Văn Điển', 'Thị trấn', 20);
INSERT INTO `ward` VALUES (643, 'Xã Tân Triều', 'Xã', 20);
INSERT INTO `ward` VALUES (646, 'Xã Thanh Liệt', 'Xã', 20);
INSERT INTO `ward` VALUES (649, 'Xã Tả Thanh Oai', 'Xã', 20);
INSERT INTO `ward` VALUES (652, 'Xã Hữu Hoà', 'Xã', 20);
INSERT INTO `ward` VALUES (655, 'Xã Tam Hiệp', 'Xã', 20);
INSERT INTO `ward` VALUES (658, 'Xã Tứ Hiệp', 'Xã', 20);
INSERT INTO `ward` VALUES (661, 'Xã Yên Mỹ', 'Xã', 20);
INSERT INTO `ward` VALUES (664, 'Xã Vĩnh Quỳnh', 'Xã', 20);
INSERT INTO `ward` VALUES (667, 'Xã Ngũ Hiệp', 'Xã', 20);
INSERT INTO `ward` VALUES (670, 'Xã Duyên Hà', 'Xã', 20);
INSERT INTO `ward` VALUES (673, 'Xã Ngọc Hồi', 'Xã', 20);
INSERT INTO `ward` VALUES (676, 'Xã Vạn Phúc', 'Xã', 20);
INSERT INTO `ward` VALUES (679, 'Xã Đại áng', 'Xã', 20);
INSERT INTO `ward` VALUES (682, 'Xã Liên Ninh', 'Xã', 20);
INSERT INTO `ward` VALUES (685, 'Xã Đông Mỹ', 'Xã', 20);
INSERT INTO `ward` VALUES (20194, 'Phường Hòa Hiệp Bắc', 'Phường', 490);
INSERT INTO `ward` VALUES (20195, 'Phường Hòa Hiệp Nam', 'Phường', 490);
INSERT INTO `ward` VALUES (20197, 'Phường Hòa Khánh Bắc', 'Phường', 490);
INSERT INTO `ward` VALUES (20198, 'Phường Hòa Khánh Nam', 'Phường', 490);
INSERT INTO `ward` VALUES (20200, 'Phường Hòa Minh', 'Phường', 490);
INSERT INTO `ward` VALUES (20203, 'Phường Tam Thuận', 'Phường', 491);
INSERT INTO `ward` VALUES (20206, 'Phường Thanh Khê Tây', 'Phường', 491);
INSERT INTO `ward` VALUES (20207, 'Phường Thanh Khê Đông', 'Phường', 491);
INSERT INTO `ward` VALUES (20209, 'Phường Xuân Hà', 'Phường', 491);
INSERT INTO `ward` VALUES (20212, 'Phường Tân Chính', 'Phường', 491);
INSERT INTO `ward` VALUES (20215, 'Phường Chính Gián', 'Phường', 491);
INSERT INTO `ward` VALUES (20218, 'Phường Vĩnh Trung', 'Phường', 491);
INSERT INTO `ward` VALUES (20221, 'Phường Thạc Gián', 'Phường', 491);
INSERT INTO `ward` VALUES (20224, 'Phường An Khê', 'Phường', 491);
INSERT INTO `ward` VALUES (20225, 'Phường Hòa Khê', 'Phường', 491);
INSERT INTO `ward` VALUES (20227, 'Phường Thanh Bình', 'Phường', 492);
INSERT INTO `ward` VALUES (20230, 'Phường Thuận Phước', 'Phường', 492);
INSERT INTO `ward` VALUES (20233, 'Phường Thạch Thang', 'Phường', 492);
INSERT INTO `ward` VALUES (20236, 'Phường Hải Châu  I', 'Phường', 492);
INSERT INTO `ward` VALUES (20239, 'Phường Hải Châu II', 'Phường', 492);
INSERT INTO `ward` VALUES (20242, 'Phường Phước Ninh', 'Phường', 492);
INSERT INTO `ward` VALUES (20245, 'Phường Hòa Thuận Tây', 'Phường', 492);
INSERT INTO `ward` VALUES (20246, 'Phường Hòa Thuận Đông', 'Phường', 492);
INSERT INTO `ward` VALUES (20248, 'Phường Nam Dương', 'Phường', 492);
INSERT INTO `ward` VALUES (20251, 'Phường Bình Hiên', 'Phường', 492);
INSERT INTO `ward` VALUES (20254, 'Phường Bình Thuận', 'Phường', 492);
INSERT INTO `ward` VALUES (20257, 'Phường Hòa Cường Bắc', 'Phường', 492);
INSERT INTO `ward` VALUES (20258, 'Phường Hòa Cường Nam', 'Phường', 492);
INSERT INTO `ward` VALUES (20260, 'Phường Khuê Trung', 'Phường', 495);
INSERT INTO `ward` VALUES (20263, 'Phường Thọ Quang', 'Phường', 493);
INSERT INTO `ward` VALUES (20266, 'Phường Nại Hiên Đông', 'Phường', 493);
INSERT INTO `ward` VALUES (20269, 'Phường Mân Thái', 'Phường', 493);
INSERT INTO `ward` VALUES (20272, 'Phường An Hải Bắc', 'Phường', 493);
INSERT INTO `ward` VALUES (20275, 'Phường Phước Mỹ', 'Phường', 493);
INSERT INTO `ward` VALUES (20278, 'Phường An Hải Tây', 'Phường', 493);
INSERT INTO `ward` VALUES (20281, 'Phường An Hải Đông', 'Phường', 493);
INSERT INTO `ward` VALUES (20284, 'Phường Mỹ An', 'Phường', 494);
INSERT INTO `ward` VALUES (20285, 'Phường Khuê Mỹ', 'Phường', 494);
INSERT INTO `ward` VALUES (20287, 'Phường Hoà Quý', 'Phường', 494);
INSERT INTO `ward` VALUES (20290, 'Phường Hoà Hải', 'Phường', 494);
INSERT INTO `ward` VALUES (20293, 'Xã Hòa Bắc', 'Xã', 497);
INSERT INTO `ward` VALUES (20296, 'Xã Hòa Liên', 'Xã', 497);
INSERT INTO `ward` VALUES (20299, 'Xã Hòa Ninh', 'Xã', 497);
INSERT INTO `ward` VALUES (20302, 'Xã Hòa Sơn', 'Xã', 497);
INSERT INTO `ward` VALUES (20305, 'Phường Hòa Phát', 'Phường', 495);
INSERT INTO `ward` VALUES (20306, 'Phường Hòa An', 'Phường', 495);
INSERT INTO `ward` VALUES (20308, 'Xã Hòa Nhơn', 'Xã', 497);
INSERT INTO `ward` VALUES (20311, 'Phường Hòa Thọ Tây', 'Phường', 495);
INSERT INTO `ward` VALUES (20312, 'Phường Hòa Thọ Đông', 'Phường', 495);
INSERT INTO `ward` VALUES (20314, 'Phường Hòa Xuân', 'Phường', 495);
INSERT INTO `ward` VALUES (20317, 'Xã Hòa Phú', 'Xã', 497);
INSERT INTO `ward` VALUES (20320, 'Xã Hòa Phong', 'Xã', 497);
INSERT INTO `ward` VALUES (20323, 'Xã Hòa Châu', 'Xã', 497);
INSERT INTO `ward` VALUES (20326, 'Xã Hòa Tiến', 'Xã', 497);
INSERT INTO `ward` VALUES (20329, 'Xã Hòa Phước', 'Xã', 497);
INSERT INTO `ward` VALUES (20332, 'Xã Hòa Khương', 'Xã', 497);
INSERT INTO `ward` VALUES (26734, 'Phường Tân Định', 'Phường', 760);
INSERT INTO `ward` VALUES (26737, 'Phường Đa Kao', 'Phường', 760);
INSERT INTO `ward` VALUES (26740, 'Phường Bến Nghé', 'Phường', 760);
INSERT INTO `ward` VALUES (26743, 'Phường Bến Thành', 'Phường', 760);
INSERT INTO `ward` VALUES (26746, 'Phường Nguyễn Thái Bình', 'Phường', 760);
INSERT INTO `ward` VALUES (26749, 'Phường Phạm Ngũ Lão', 'Phường', 760);
INSERT INTO `ward` VALUES (26752, 'Phường Cầu Ông Lãnh', 'Phường', 760);
INSERT INTO `ward` VALUES (26755, 'Phường Cô Giang', 'Phường', 760);
INSERT INTO `ward` VALUES (26758, 'Phường Nguyễn Cư Trinh', 'Phường', 760);
INSERT INTO `ward` VALUES (26761, 'Phường Cầu Kho', 'Phường', 760);
INSERT INTO `ward` VALUES (26764, 'Phường Thạnh Xuân', 'Phường', 761);
INSERT INTO `ward` VALUES (26767, 'Phường Thạnh Lộc', 'Phường', 761);
INSERT INTO `ward` VALUES (26770, 'Phường Hiệp Thành', 'Phường', 761);
INSERT INTO `ward` VALUES (26773, 'Phường Thới An', 'Phường', 761);
INSERT INTO `ward` VALUES (26776, 'Phường Tân Chánh Hiệp', 'Phường', 761);
INSERT INTO `ward` VALUES (26779, 'Phường An Phú Đông', 'Phường', 761);
INSERT INTO `ward` VALUES (26782, 'Phường Tân Thới Hiệp', 'Phường', 761);
INSERT INTO `ward` VALUES (26785, 'Phường Trung Mỹ Tây', 'Phường', 761);
INSERT INTO `ward` VALUES (26787, 'Phường Tân Hưng Thuận', 'Phường', 761);
INSERT INTO `ward` VALUES (26788, 'Phường Đông Hưng Thuận', 'Phường', 761);
INSERT INTO `ward` VALUES (26791, 'Phường Tân Thới Nhất', 'Phường', 761);
INSERT INTO `ward` VALUES (26794, 'Phường Linh Xuân', 'Phường', 762);
INSERT INTO `ward` VALUES (26797, 'Phường Bình Chiểu', 'Phường', 762);
INSERT INTO `ward` VALUES (26800, 'Phường Linh Trung', 'Phường', 762);
INSERT INTO `ward` VALUES (26803, 'Phường Tam Bình', 'Phường', 762);
INSERT INTO `ward` VALUES (26806, 'Phường Tam Phú', 'Phường', 762);
INSERT INTO `ward` VALUES (26809, 'Phường Hiệp Bình Phước', 'Phường', 762);
INSERT INTO `ward` VALUES (26812, 'Phường Hiệp Bình Chánh', 'Phường', 762);
INSERT INTO `ward` VALUES (26815, 'Phường Linh Chiểu', 'Phường', 762);
INSERT INTO `ward` VALUES (26818, 'Phường Linh Tây', 'Phường', 762);
INSERT INTO `ward` VALUES (26821, 'Phường Linh Đông', 'Phường', 762);
INSERT INTO `ward` VALUES (26824, 'Phường Bình Thọ', 'Phường', 762);
INSERT INTO `ward` VALUES (26827, 'Phường Trường Thọ', 'Phường', 762);
INSERT INTO `ward` VALUES (26830, 'Phường Long Bình', 'Phường', 763);
INSERT INTO `ward` VALUES (26833, 'Phường Long Thạnh Mỹ', 'Phường', 763);
INSERT INTO `ward` VALUES (26836, 'Phường Tân Phú', 'Phường', 763);
INSERT INTO `ward` VALUES (26839, 'Phường Hiệp Phú', 'Phường', 763);
INSERT INTO `ward` VALUES (26842, 'Phường Tăng Nhơn Phú A', 'Phường', 763);
INSERT INTO `ward` VALUES (26845, 'Phường Tăng Nhơn Phú B', 'Phường', 763);
INSERT INTO `ward` VALUES (26848, 'Phường Phước Long B', 'Phường', 763);
INSERT INTO `ward` VALUES (26851, 'Phường Phước Long A', 'Phường', 763);
INSERT INTO `ward` VALUES (26854, 'Phường Trường Thạnh', 'Phường', 763);
INSERT INTO `ward` VALUES (26857, 'Phường Long Phước', 'Phường', 763);
INSERT INTO `ward` VALUES (26860, 'Phường Long Trường', 'Phường', 763);
INSERT INTO `ward` VALUES (26863, 'Phường Phước Bình', 'Phường', 763);
INSERT INTO `ward` VALUES (26866, 'Phường Phú Hữu', 'Phường', 763);
INSERT INTO `ward` VALUES (26869, 'Phường 15', 'Phường', 764);
INSERT INTO `ward` VALUES (26872, 'Phường 13', 'Phường', 764);
INSERT INTO `ward` VALUES (26875, 'Phường 17', 'Phường', 764);
INSERT INTO `ward` VALUES (26876, 'Phường 6', 'Phường', 764);
INSERT INTO `ward` VALUES (26878, 'Phường 16', 'Phường', 764);
INSERT INTO `ward` VALUES (26881, 'Phường 12', 'Phường', 764);
INSERT INTO `ward` VALUES (26882, 'Phường 14', 'Phường', 764);
INSERT INTO `ward` VALUES (26884, 'Phường 10', 'Phường', 764);
INSERT INTO `ward` VALUES (26887, 'Phường 05', 'Phường', 764);
INSERT INTO `ward` VALUES (26890, 'Phường 07', 'Phường', 764);
INSERT INTO `ward` VALUES (26893, 'Phường 04', 'Phường', 764);
INSERT INTO `ward` VALUES (26896, 'Phường 01', 'Phường', 764);
INSERT INTO `ward` VALUES (26897, 'Phường 9', 'Phường', 764);
INSERT INTO `ward` VALUES (26898, 'Phường 8', 'Phường', 764);
INSERT INTO `ward` VALUES (26899, 'Phường 11', 'Phường', 764);
INSERT INTO `ward` VALUES (26902, 'Phường 03', 'Phường', 764);
INSERT INTO `ward` VALUES (26905, 'Phường 13', 'Phường', 765);
INSERT INTO `ward` VALUES (26908, 'Phường 11', 'Phường', 765);
INSERT INTO `ward` VALUES (26911, 'Phường 27', 'Phường', 765);
INSERT INTO `ward` VALUES (26914, 'Phường 26', 'Phường', 765);
INSERT INTO `ward` VALUES (26917, 'Phường 12', 'Phường', 765);
INSERT INTO `ward` VALUES (26920, 'Phường 25', 'Phường', 765);
INSERT INTO `ward` VALUES (26923, 'Phường 05', 'Phường', 765);
INSERT INTO `ward` VALUES (26926, 'Phường 07', 'Phường', 765);
INSERT INTO `ward` VALUES (26929, 'Phường 24', 'Phường', 765);
INSERT INTO `ward` VALUES (26932, 'Phường 06', 'Phường', 765);
INSERT INTO `ward` VALUES (26935, 'Phường 14', 'Phường', 765);
INSERT INTO `ward` VALUES (26938, 'Phường 15', 'Phường', 765);
INSERT INTO `ward` VALUES (26941, 'Phường 02', 'Phường', 765);
INSERT INTO `ward` VALUES (26944, 'Phường 01', 'Phường', 765);
INSERT INTO `ward` VALUES (26947, 'Phường 03', 'Phường', 765);
INSERT INTO `ward` VALUES (26950, 'Phường 17', 'Phường', 765);
INSERT INTO `ward` VALUES (26953, 'Phường 21', 'Phường', 765);
INSERT INTO `ward` VALUES (26956, 'Phường 22', 'Phường', 765);
INSERT INTO `ward` VALUES (26959, 'Phường 19', 'Phường', 765);
INSERT INTO `ward` VALUES (26962, 'Phường 28', 'Phường', 765);
INSERT INTO `ward` VALUES (26965, 'Phường 02', 'Phường', 766);
INSERT INTO `ward` VALUES (26968, 'Phường 04', 'Phường', 766);
INSERT INTO `ward` VALUES (26971, 'Phường 12', 'Phường', 766);
INSERT INTO `ward` VALUES (26974, 'Phường 13', 'Phường', 766);
INSERT INTO `ward` VALUES (26977, 'Phường 01', 'Phường', 766);
INSERT INTO `ward` VALUES (26980, 'Phường 03', 'Phường', 766);
INSERT INTO `ward` VALUES (26983, 'Phường 11', 'Phường', 766);
INSERT INTO `ward` VALUES (26986, 'Phường 07', 'Phường', 766);
INSERT INTO `ward` VALUES (26989, 'Phường 05', 'Phường', 766);
INSERT INTO `ward` VALUES (26992, 'Phường 10', 'Phường', 766);
INSERT INTO `ward` VALUES (26995, 'Phường 06', 'Phường', 766);
INSERT INTO `ward` VALUES (26998, 'Phường 08', 'Phường', 766);
INSERT INTO `ward` VALUES (27001, 'Phường 09', 'Phường', 766);
INSERT INTO `ward` VALUES (27004, 'Phường 14', 'Phường', 766);
INSERT INTO `ward` VALUES (27007, 'Phường 15', 'Phường', 766);
INSERT INTO `ward` VALUES (27010, 'Phường Tân Sơn Nhì', 'Phường', 767);
INSERT INTO `ward` VALUES (27013, 'Phường Tây Thạnh', 'Phường', 767);
INSERT INTO `ward` VALUES (27016, 'Phường Sơn Kỳ', 'Phường', 767);
INSERT INTO `ward` VALUES (27019, 'Phường Tân Quý', 'Phường', 767);
INSERT INTO `ward` VALUES (27022, 'Phường Tân Thành', 'Phường', 767);
INSERT INTO `ward` VALUES (27025, 'Phường Phú Thọ Hòa', 'Phường', 767);
INSERT INTO `ward` VALUES (27028, 'Phường Phú Thạnh', 'Phường', 767);
INSERT INTO `ward` VALUES (27031, 'Phường Phú Trung', 'Phường', 767);
INSERT INTO `ward` VALUES (27034, 'Phường Hòa Thạnh', 'Phường', 767);
INSERT INTO `ward` VALUES (27037, 'Phường Hiệp Tân', 'Phường', 767);
INSERT INTO `ward` VALUES (27040, 'Phường Tân Thới Hòa', 'Phường', 767);
INSERT INTO `ward` VALUES (27043, 'Phường 04', 'Phường', 768);
INSERT INTO `ward` VALUES (27046, 'Phường 05', 'Phường', 768);
INSERT INTO `ward` VALUES (27049, 'Phường 09', 'Phường', 768);
INSERT INTO `ward` VALUES (27052, 'Phường 07', 'Phường', 768);
INSERT INTO `ward` VALUES (27055, 'Phường 03', 'Phường', 768);
INSERT INTO `ward` VALUES (27058, 'Phường 01', 'Phường', 768);
INSERT INTO `ward` VALUES (27061, 'Phường 02', 'Phường', 768);
INSERT INTO `ward` VALUES (27064, 'Phường 08', 'Phường', 768);
INSERT INTO `ward` VALUES (27067, 'Phường 15', 'Phường', 768);
INSERT INTO `ward` VALUES (27070, 'Phường 10', 'Phường', 768);
INSERT INTO `ward` VALUES (27073, 'Phường 11', 'Phường', 768);
INSERT INTO `ward` VALUES (27076, 'Phường 17', 'Phường', 768);
INSERT INTO `ward` VALUES (27079, 'Phường 14', 'Phường', 768);
INSERT INTO `ward` VALUES (27082, 'Phường 12', 'Phường', 768);
INSERT INTO `ward` VALUES (27085, 'Phường 13', 'Phường', 768);
INSERT INTO `ward` VALUES (27088, 'Phường Thảo Điền', 'Phường', 769);
INSERT INTO `ward` VALUES (27091, 'Phường An Phú', 'Phường', 769);
INSERT INTO `ward` VALUES (27094, 'Phường Bình An', 'Phường', 769);
INSERT INTO `ward` VALUES (27097, 'Phường Bình Trưng Đông', 'Phường', 769);
INSERT INTO `ward` VALUES (27100, 'Phường Bình Trưng Tây', 'Phường', 769);
INSERT INTO `ward` VALUES (27103, 'Phường Bình Khánh', 'Phường', 769);
INSERT INTO `ward` VALUES (27106, 'Phường An Khánh', 'Phường', 769);
INSERT INTO `ward` VALUES (27109, 'Phường Cát Lái', 'Phường', 769);
INSERT INTO `ward` VALUES (27112, 'Phường Thạnh Mỹ Lợi', 'Phường', 769);
INSERT INTO `ward` VALUES (27115, 'Phường An Lợi Đông', 'Phường', 769);
INSERT INTO `ward` VALUES (27118, 'Phường Thủ Thiêm', 'Phường', 769);
INSERT INTO `ward` VALUES (27121, 'Phường 08', 'Phường', 770);
INSERT INTO `ward` VALUES (27124, 'Phường 07', 'Phường', 770);
INSERT INTO `ward` VALUES (27127, 'Phường 14', 'Phường', 770);
INSERT INTO `ward` VALUES (27130, 'Phường 12', 'Phường', 770);
INSERT INTO `ward` VALUES (27133, 'Phường 11', 'Phường', 770);
INSERT INTO `ward` VALUES (27136, 'Phường 13', 'Phường', 770);
INSERT INTO `ward` VALUES (27139, 'Phường 06', 'Phường', 770);
INSERT INTO `ward` VALUES (27142, 'Phường 09', 'Phường', 770);
INSERT INTO `ward` VALUES (27145, 'Phường 10', 'Phường', 770);
INSERT INTO `ward` VALUES (27148, 'Phường 04', 'Phường', 770);
INSERT INTO `ward` VALUES (27151, 'Phường 05', 'Phường', 770);
INSERT INTO `ward` VALUES (27154, 'Phường 03', 'Phường', 770);
INSERT INTO `ward` VALUES (27157, 'Phường 02', 'Phường', 770);
INSERT INTO `ward` VALUES (27160, 'Phường 01', 'Phường', 770);
INSERT INTO `ward` VALUES (27163, 'Phường 15', 'Phường', 771);
INSERT INTO `ward` VALUES (27166, 'Phường 13', 'Phường', 771);
INSERT INTO `ward` VALUES (27169, 'Phường 14', 'Phường', 771);
INSERT INTO `ward` VALUES (27172, 'Phường 12', 'Phường', 771);
INSERT INTO `ward` VALUES (27175, 'Phường 11', 'Phường', 771);
INSERT INTO `ward` VALUES (27178, 'Phường 10', 'Phường', 771);
INSERT INTO `ward` VALUES (27181, 'Phường 09', 'Phường', 771);
INSERT INTO `ward` VALUES (27184, 'Phường 01', 'Phường', 771);
INSERT INTO `ward` VALUES (27187, 'Phường 08', 'Phường', 771);
INSERT INTO `ward` VALUES (27190, 'Phường 02', 'Phường', 771);
INSERT INTO `ward` VALUES (27193, 'Phường 04', 'Phường', 771);
INSERT INTO `ward` VALUES (27196, 'Phường 07', 'Phường', 771);
INSERT INTO `ward` VALUES (27199, 'Phường 05', 'Phường', 771);
INSERT INTO `ward` VALUES (27202, 'Phường 06', 'Phường', 771);
INSERT INTO `ward` VALUES (27205, 'Phường 03', 'Phường', 771);
INSERT INTO `ward` VALUES (27208, 'Phường 15', 'Phường', 772);
INSERT INTO `ward` VALUES (27211, 'Phường 05', 'Phường', 772);
INSERT INTO `ward` VALUES (27214, 'Phường 14', 'Phường', 772);
INSERT INTO `ward` VALUES (27217, 'Phường 11', 'Phường', 772);
INSERT INTO `ward` VALUES (27220, 'Phường 03', 'Phường', 772);
INSERT INTO `ward` VALUES (27223, 'Phường 10', 'Phường', 772);
INSERT INTO `ward` VALUES (27226, 'Phường 13', 'Phường', 772);
INSERT INTO `ward` VALUES (27229, 'Phường 08', 'Phường', 772);
INSERT INTO `ward` VALUES (27232, 'Phường 09', 'Phường', 772);
INSERT INTO `ward` VALUES (27235, 'Phường 12', 'Phường', 772);
INSERT INTO `ward` VALUES (27238, 'Phường 07', 'Phường', 772);
INSERT INTO `ward` VALUES (27241, 'Phường 06', 'Phường', 772);
INSERT INTO `ward` VALUES (27244, 'Phường 04', 'Phường', 772);
INSERT INTO `ward` VALUES (27247, 'Phường 01', 'Phường', 772);
INSERT INTO `ward` VALUES (27250, 'Phường 02', 'Phường', 772);
INSERT INTO `ward` VALUES (27253, 'Phường 16', 'Phường', 772);
INSERT INTO `ward` VALUES (27256, 'Phường 12', 'Phường', 773);
INSERT INTO `ward` VALUES (27259, 'Phường 13', 'Phường', 773);
INSERT INTO `ward` VALUES (27262, 'Phường 09', 'Phường', 773);
INSERT INTO `ward` VALUES (27265, 'Phường 06', 'Phường', 773);
INSERT INTO `ward` VALUES (27268, 'Phường 08', 'Phường', 773);
INSERT INTO `ward` VALUES (27271, 'Phường 10', 'Phường', 773);
INSERT INTO `ward` VALUES (27274, 'Phường 05', 'Phường', 773);
INSERT INTO `ward` VALUES (27277, 'Phường 18', 'Phường', 773);
INSERT INTO `ward` VALUES (27280, 'Phường 14', 'Phường', 773);
INSERT INTO `ward` VALUES (27283, 'Phường 04', 'Phường', 773);
INSERT INTO `ward` VALUES (27286, 'Phường 03', 'Phường', 773);
INSERT INTO `ward` VALUES (27289, 'Phường 16', 'Phường', 773);
INSERT INTO `ward` VALUES (27292, 'Phường 02', 'Phường', 773);
INSERT INTO `ward` VALUES (27295, 'Phường 15', 'Phường', 773);
INSERT INTO `ward` VALUES (27298, 'Phường 01', 'Phường', 773);
INSERT INTO `ward` VALUES (27301, 'Phường 04', 'Phường', 774);
INSERT INTO `ward` VALUES (27304, 'Phường 09', 'Phường', 774);
INSERT INTO `ward` VALUES (27307, 'Phường 03', 'Phường', 774);
INSERT INTO `ward` VALUES (27310, 'Phường 12', 'Phường', 774);
INSERT INTO `ward` VALUES (27313, 'Phường 02', 'Phường', 774);
INSERT INTO `ward` VALUES (27316, 'Phường 08', 'Phường', 774);
INSERT INTO `ward` VALUES (27319, 'Phường 15', 'Phường', 774);
INSERT INTO `ward` VALUES (27322, 'Phường 07', 'Phường', 774);
INSERT INTO `ward` VALUES (27325, 'Phường 01', 'Phường', 774);
INSERT INTO `ward` VALUES (27328, 'Phường 11', 'Phường', 774);
INSERT INTO `ward` VALUES (27331, 'Phường 14', 'Phường', 774);
INSERT INTO `ward` VALUES (27334, 'Phường 05', 'Phường', 774);
INSERT INTO `ward` VALUES (27337, 'Phường 06', 'Phường', 774);
INSERT INTO `ward` VALUES (27340, 'Phường 10', 'Phường', 774);
INSERT INTO `ward` VALUES (27343, 'Phường 13', 'Phường', 774);
INSERT INTO `ward` VALUES (27346, 'Phường 14', 'Phường', 775);
INSERT INTO `ward` VALUES (27349, 'Phường 13', 'Phường', 775);
INSERT INTO `ward` VALUES (27352, 'Phường 09', 'Phường', 775);
INSERT INTO `ward` VALUES (27355, 'Phường 06', 'Phường', 775);
INSERT INTO `ward` VALUES (27358, 'Phường 12', 'Phường', 775);
INSERT INTO `ward` VALUES (27361, 'Phường 05', 'Phường', 775);
INSERT INTO `ward` VALUES (27364, 'Phường 11', 'Phường', 775);
INSERT INTO `ward` VALUES (27367, 'Phường 02', 'Phường', 775);
INSERT INTO `ward` VALUES (27370, 'Phường 01', 'Phường', 775);
INSERT INTO `ward` VALUES (27373, 'Phường 04', 'Phường', 775);
INSERT INTO `ward` VALUES (27376, 'Phường 08', 'Phường', 775);
INSERT INTO `ward` VALUES (27379, 'Phường 03', 'Phường', 775);
INSERT INTO `ward` VALUES (27382, 'Phường 07', 'Phường', 775);
INSERT INTO `ward` VALUES (27385, 'Phường 10', 'Phường', 775);
INSERT INTO `ward` VALUES (27388, 'Phường 08', 'Phường', 776);
INSERT INTO `ward` VALUES (27391, 'Phường 02', 'Phường', 776);
INSERT INTO `ward` VALUES (27394, 'Phường 01', 'Phường', 776);
INSERT INTO `ward` VALUES (27397, 'Phường 03', 'Phường', 776);
INSERT INTO `ward` VALUES (27400, 'Phường 11', 'Phường', 776);
INSERT INTO `ward` VALUES (27403, 'Phường 09', 'Phường', 776);
INSERT INTO `ward` VALUES (27406, 'Phường 10', 'Phường', 776);
INSERT INTO `ward` VALUES (27409, 'Phường 04', 'Phường', 776);
INSERT INTO `ward` VALUES (27412, 'Phường 13', 'Phường', 776);
INSERT INTO `ward` VALUES (27415, 'Phường 12', 'Phường', 776);
INSERT INTO `ward` VALUES (27418, 'Phường 05', 'Phường', 776);
INSERT INTO `ward` VALUES (27421, 'Phường 14', 'Phường', 776);
INSERT INTO `ward` VALUES (27424, 'Phường 06', 'Phường', 776);
INSERT INTO `ward` VALUES (27427, 'Phường 15', 'Phường', 776);
INSERT INTO `ward` VALUES (27430, 'Phường 16', 'Phường', 776);
INSERT INTO `ward` VALUES (27433, 'Phường 07', 'Phường', 776);
INSERT INTO `ward` VALUES (27436, 'Phường Bình Hưng Hòa', 'Phường', 777);
INSERT INTO `ward` VALUES (27439, 'Phường Bình Hưng Hoà A', 'Phường', 777);
INSERT INTO `ward` VALUES (27442, 'Phường Bình Hưng Hoà B', 'Phường', 777);
INSERT INTO `ward` VALUES (27445, 'Phường Bình Trị Đông', 'Phường', 777);
INSERT INTO `ward` VALUES (27448, 'Phường Bình Trị Đông A', 'Phường', 777);
INSERT INTO `ward` VALUES (27451, 'Phường Bình Trị Đông B', 'Phường', 777);
INSERT INTO `ward` VALUES (27454, 'Phường Tân Tạo', 'Phường', 777);
INSERT INTO `ward` VALUES (27457, 'Phường Tân Tạo A', 'Phường', 777);
INSERT INTO `ward` VALUES (27460, 'Phường  An Lạc', 'Phường', 777);
INSERT INTO `ward` VALUES (27463, 'Phường An Lạc A', 'Phường', 777);
INSERT INTO `ward` VALUES (27466, 'Phường Tân Thuận Đông', 'Phường', 778);
INSERT INTO `ward` VALUES (27469, 'Phường Tân Thuận Tây', 'Phường', 778);
INSERT INTO `ward` VALUES (27472, 'Phường Tân Kiểng', 'Phường', 778);
INSERT INTO `ward` VALUES (27475, 'Phường Tân Hưng', 'Phường', 778);
INSERT INTO `ward` VALUES (27478, 'Phường Bình Thuận', 'Phường', 778);
INSERT INTO `ward` VALUES (27481, 'Phường Tân Quy', 'Phường', 778);
INSERT INTO `ward` VALUES (27484, 'Phường Phú Thuận', 'Phường', 778);
INSERT INTO `ward` VALUES (27487, 'Phường Tân Phú', 'Phường', 778);
INSERT INTO `ward` VALUES (27490, 'Phường Tân Phong', 'Phường', 778);
INSERT INTO `ward` VALUES (27493, 'Phường Phú Mỹ', 'Phường', 778);
INSERT INTO `ward` VALUES (27496, 'Thị trấn Củ Chi', 'Thị trấn', 783);
INSERT INTO `ward` VALUES (27499, 'Xã Phú Mỹ Hưng', 'Xã', 783);
INSERT INTO `ward` VALUES (27502, 'Xã An Phú', 'Xã', 783);
INSERT INTO `ward` VALUES (27505, 'Xã Trung Lập Thượng', 'Xã', 783);
INSERT INTO `ward` VALUES (27508, 'Xã An Nhơn Tây', 'Xã', 783);
INSERT INTO `ward` VALUES (27511, 'Xã Nhuận Đức', 'Xã', 783);
INSERT INTO `ward` VALUES (27514, 'Xã Phạm Văn Cội', 'Xã', 783);
INSERT INTO `ward` VALUES (27517, 'Xã Phú Hòa Đông', 'Xã', 783);
INSERT INTO `ward` VALUES (27520, 'Xã Trung Lập Hạ', 'Xã', 783);
INSERT INTO `ward` VALUES (27523, 'Xã Trung An', 'Xã', 783);
INSERT INTO `ward` VALUES (27526, 'Xã Phước Thạnh', 'Xã', 783);
INSERT INTO `ward` VALUES (27529, 'Xã Phước Hiệp', 'Xã', 783);
INSERT INTO `ward` VALUES (27532, 'Xã Tân An Hội', 'Xã', 783);
INSERT INTO `ward` VALUES (27535, 'Xã Phước Vĩnh An', 'Xã', 783);
INSERT INTO `ward` VALUES (27538, 'Xã Thái Mỹ', 'Xã', 783);
INSERT INTO `ward` VALUES (27541, 'Xã Tân Thạnh Tây', 'Xã', 783);
INSERT INTO `ward` VALUES (27544, 'Xã Hòa Phú', 'Xã', 783);
INSERT INTO `ward` VALUES (27547, 'Xã Tân Thạnh Đông', 'Xã', 783);
INSERT INTO `ward` VALUES (27550, 'Xã Bình Mỹ', 'Xã', 783);
INSERT INTO `ward` VALUES (27553, 'Xã Tân Phú Trung', 'Xã', 783);
INSERT INTO `ward` VALUES (27556, 'Xã Tân Thông Hội', 'Xã', 783);
INSERT INTO `ward` VALUES (27559, 'Thị trấn Hóc Môn', 'Thị trấn', 784);
INSERT INTO `ward` VALUES (27562, 'Xã Tân Hiệp', 'Xã', 784);
INSERT INTO `ward` VALUES (27565, 'Xã Nhị Bình', 'Xã', 784);
INSERT INTO `ward` VALUES (27568, 'Xã Đông Thạnh', 'Xã', 784);
INSERT INTO `ward` VALUES (27571, 'Xã Tân Thới Nhì', 'Xã', 784);
INSERT INTO `ward` VALUES (27574, 'Xã Thới Tam Thôn', 'Xã', 784);
INSERT INTO `ward` VALUES (27577, 'Xã Xuân Thới Sơn', 'Xã', 784);
INSERT INTO `ward` VALUES (27580, 'Xã Tân Xuân', 'Xã', 784);
INSERT INTO `ward` VALUES (27583, 'Xã Xuân Thới Đông', 'Xã', 784);
INSERT INTO `ward` VALUES (27586, 'Xã Trung Chánh', 'Xã', 784);
INSERT INTO `ward` VALUES (27589, 'Xã Xuân Thới Thượng', 'Xã', 784);
INSERT INTO `ward` VALUES (27592, 'Xã Bà Điểm', 'Xã', 784);
INSERT INTO `ward` VALUES (27595, 'Thị trấn Tân Túc', 'Thị trấn', 785);
INSERT INTO `ward` VALUES (27598, 'Xã Phạm Văn Hai', 'Xã', 785);
INSERT INTO `ward` VALUES (27601, 'Xã Vĩnh Lộc A', 'Xã', 785);
INSERT INTO `ward` VALUES (27604, 'Xã Vĩnh Lộc B', 'Xã', 785);
INSERT INTO `ward` VALUES (27607, 'Xã Bình Lợi', 'Xã', 785);
INSERT INTO `ward` VALUES (27610, 'Xã Lê Minh Xuân', 'Xã', 785);
INSERT INTO `ward` VALUES (27613, 'Xã Tân Nhựt', 'Xã', 785);
INSERT INTO `ward` VALUES (27616, 'Xã Tân Kiên', 'Xã', 785);
INSERT INTO `ward` VALUES (27619, 'Xã Bình Hưng', 'Xã', 785);
INSERT INTO `ward` VALUES (27622, 'Xã Phong Phú', 'Xã', 785);
INSERT INTO `ward` VALUES (27625, 'Xã An Phú Tây', 'Xã', 785);
INSERT INTO `ward` VALUES (27628, 'Xã Hưng Long', 'Xã', 785);
INSERT INTO `ward` VALUES (27631, 'Xã Đa Phước', 'Xã', 785);
INSERT INTO `ward` VALUES (27634, 'Xã Tân Quý Tây', 'Xã', 785);
INSERT INTO `ward` VALUES (27637, 'Xã Bình Chánh', 'Xã', 785);
INSERT INTO `ward` VALUES (27640, 'Xã Quy Đức', 'Xã', 785);
INSERT INTO `ward` VALUES (27643, 'Thị trấn Nhà Bè', 'Thị trấn', 786);
INSERT INTO `ward` VALUES (27646, 'Xã Phước Kiển', 'Xã', 786);
INSERT INTO `ward` VALUES (27649, 'Xã Phước Lộc', 'Xã', 786);
INSERT INTO `ward` VALUES (27652, 'Xã Nhơn Đức', 'Xã', 786);
INSERT INTO `ward` VALUES (27655, 'Xã Phú Xuân', 'Xã', 786);
INSERT INTO `ward` VALUES (27658, 'Xã Long Thới', 'Xã', 786);
INSERT INTO `ward` VALUES (27661, 'Xã Hiệp Phước', 'Xã', 786);
INSERT INTO `ward` VALUES (27664, 'Thị trấn Cần Thạnh', 'Thị trấn', 787);
INSERT INTO `ward` VALUES (27667, 'Xã Bình Khánh', 'Xã', 787);
INSERT INTO `ward` VALUES (27670, 'Xã Tam Thôn Hiệp', 'Xã', 787);
INSERT INTO `ward` VALUES (27673, 'Xã An Thới Đông', 'Xã', 787);
INSERT INTO `ward` VALUES (27676, 'Xã Thạnh An', 'Xã', 787);
INSERT INTO `ward` VALUES (27679, 'Xã Long Hòa', 'Xã', 787);
INSERT INTO `ward` VALUES (27682, 'Xã Lý Nhơn', 'Xã', 787);

SET FOREIGN_KEY_CHECKS = 1;
