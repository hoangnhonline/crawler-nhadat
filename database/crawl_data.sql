-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 12, 2018 at 10:41 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lkmoigioi_c_be4d`
--

-- --------------------------------------------------------

--
-- Table structure for table `crawl_data`
--

CREATE TABLE `crawl_data` (
  `id` bigint(20) NOT NULL,
  `site_id` tinyint(4) NOT NULL COMMENT '1:muban, 2 cho tot 3 bds',
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `lap` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `crawl_data`
--

INSERT INTO `crawl_data` (`id`, `site_id`, `name`, `phone`, `address`, `url`, `lap`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nguyễn Chương Đạt', '0909278919', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/hem-xe-hoi-bui-dinh-tuy-dt-4x20m-1-lau-5-ty-id43299350', 3, '2018-03-12 15:30:08', '2018-03-12 15:31:14'),
(2, 1, 'phát', '0908660085', '50 HT 31 P.Hiệp Thành Q.12', 'https://muaban.net/nha-hem-ngo-quan-12-l5909-c3202/ban-nha-duong-thong-5-m-le-van-khuong-p-hiep-thanh-q-12-id43333754', 1, '2018-03-12 15:30:08', '2018-03-12 15:30:08'),
(3, 1, 'Anh Thông', '0914441295', '401/28 LÊ VĂN THỌ, GÒ VẤP', 'https://muaban.net/biet-thu-villa-penthouse-quan-go-vap-l5920-c3205/ban-can-villa-pho-chuan-4-sao-401-28-le-van-tho-go-vap-gia-7-25-ty-id42194298', 1, '2018-03-12 15:30:08', '2018-03-12 15:30:08'),
(4, 1, NULL, '01208357266', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/ban-nha-cap-4-hem-nguyen-huu-canh-p22-binh-thanh-so-hong-2-3-ty-id43299205', 1, '2018-03-12 15:30:09', '2018-03-12 15:30:09'),
(5, 1, NULL, '0907774147', NULL, 'https://muaban.net/nha-hem-ngo-quan-8-l5916-c3202/ban-nha-hem-thong-quan-8-gan-cho-truong-dt-3x14m-3-phong-ngu-id43110948', 1, '2018-03-12 15:30:09', '2018-03-12 15:30:09'),
(6, 1, 'Hồng Điệp', '0932967902', NULL, 'https://muaban.net/nha-mat-tien-quan-10-l5907-c3201/ban-nha-goc-2-mt-dien-bien-phu-quan-10-id43281443', 1, '2018-03-12 15:30:09', '2018-03-12 15:30:09'),
(7, 1, 'Chính chủ, 0913943294, 0912252725', '0912252725', NULL, 'https://muaban.net/nha-mat-tien-quan-3-l5911-c3201/ban-gap-nha-doan-duong-dep-nhat-hoang-sa-p7-q3-mt-8-x12m-id42851308', 1, '2018-03-12 15:30:11', '2018-03-12 15:30:11'),
(8, 1, NULL, '0902697994', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-cap-4-dep-duong-duong-quang-ham-p6-go-vap-id43301100', 1, '2018-03-12 15:30:11', '2018-03-12 15:30:11'),
(9, 1, 'Ngọc Hoa', '0987250909', 'Cống Lở Phường 15 Tân Bình', 'https://muaban.net/biet-thu-villa-penthouse-quan-go-vap-l5920-c3205/ban-gap-biet-thu-mini-gia-re-duong-cong-lo-p-15-tan-binh--id43298788', 1, '2018-03-12 15:30:12', '2018-03-12 15:30:12'),
(10, 1, 'Anh Long', '0909456670', NULL, 'https://muaban.net/nha-hem-ngo-quan-phu-nhuan-l5921-c3202/ban-nha-211-132a7-hoang-hoa-tham-phuong-5-phu-nhuan-id43260844', 1, '2018-03-12 15:30:12', '2018-03-12 15:30:12'),
(11, 1, 'Ngộ Tịnh', '0909115529', NULL, 'https://muaban.net/biet-thu-villa-penthouse-quan-tan-binh-l5922-c3205/ban-bt-6-x-19-duong-phan-huy-ich-phuong-15-tan-binh-id43216704', 1, '2018-03-12 15:30:12', '2018-03-12 15:30:12'),
(12, 1, 'Mr Đặng', '0908660031', '16 Đường 14A Cư Xá Ngân Hàng Quận 7', 'https://muaban.net/nha-mat-tien-quan-7-l5915-c3201/chinh-chu-ban-nha-so-16-duong-14a-cu-xa-ngan-hang-7-1x19m-2-lau-ap-mai-id43099163', 1, '2018-03-12 15:30:12', '2018-03-12 15:30:12'),
(13, 1, NULL, '0976562526', NULL, 'https://muaban.net/nha-hem-ngo-quan-9-l5917-c3202/ban-nha-q-9-hem-lo-lu-dt-4x22m-1-3-ty-nha-duong-8-dt-5x22m-5-5-ty-id43260850', 1, '2018-03-12 15:30:13', '2018-03-12 15:30:13'),
(14, 1, 'Đặng Tiến Lộc', '0916027086', '38A, duong Truc, P.13, Q. Binh Thanh', 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/ban-gap-01-can-duy-nhat-khu-vip-5m-x-10-5m-hxh-5m-binh-loi-gia-re-id43343151', 3, '2018-03-12 15:30:13', '2018-03-12 15:30:29'),
(15, 1, 'NGUYỄN VĂN CƯỜNG', '0938286679', NULL, 'https://muaban.net/nha-mat-tien-quan-7-l5915-c3201/ban-nha-duong-so-tan-quy-quan-7-4x18m-tret-3-lau-gia-7-6-ty-id43314776', 3, '2018-03-12 15:30:14', '2018-03-12 15:31:30'),
(16, 1, 'GIA ĐẠI', '0907909499', NULL, 'https://muaban.net/nha-mat-tien-quan-phu-nhuan-l5921-c3201/ban-biet-thu-duong-hoa-mai-p-2-q-pn-id43342911', 1, '2018-03-12 15:30:14', '2018-03-12 15:30:14'),
(17, 1, 'Lê Xuân Hào', '0906306499', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/nha-ban-duong-le-van-tho-phuong-16-q-go-vap-gia-3-1-ty-id42716981', 3, '2018-03-12 15:30:14', '2018-03-12 15:31:30'),
(18, 1, 'A.TÁM', '0934868414', NULL, 'https://muaban.net/nha-mat-tien-quan-binh-thanh-l5919-c3201/ban-nha-2-mat-tien-duong-d2-p-25-q-binh-thanh-dien-tich-4x20m-id43298764', 1, '2018-03-12 15:30:15', '2018-03-12 15:30:15'),
(19, 1, 'Nguyễn Thị Hải', '0908375936', 'Đào Tông Nguyên', 'https://muaban.net/nha-hem-ngo-quan-7-l5915-c3202/hang-hot-cuoi-nam-can-tien-ban-re-nha-hem-1135-huynh-tan-phat-q7--id42820375', 3, '2018-03-12 15:30:16', '2018-03-12 15:31:13'),
(20, 1, 'A.Thanh', '0978567909', NULL, 'https://muaban.net/nha-hem-ngo-quan-tan-phu-l5923-c3202/ban-nha-tro-1-tret-1-lau-4-phong-ngay-ho-boi-tay-thanh-gan-kcn-tb-id43282539', 1, '2018-03-12 15:30:17', '2018-03-12 15:30:17'),
(21, 1, 'thanh bình', '0974788155', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/ban-nha-hem-duong-nguyen-van-dau-quan-binh-thanh-gia-re-id43217850', 1, '2018-03-12 15:30:17', '2018-03-12 15:30:17'),
(22, 1, 'Mr. Trí', '0934572738', 'Phú Định p16 Q8', 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/nha-pho-cao-cap-cho-dan-vp-khu-trung-tam-gan-q5-q1-giay-to-day-du-id41238100', 3, '2018-03-12 15:30:17', '2018-03-12 15:31:22'),
(23, 1, 'diaoctransanh@', '0918755116', NULL, 'https://muaban.net/nha-hem-ngo-quan-phu-nhuan-l5921-c3202/ban-nha-hxh-nguyen-trong-tuyen-phuong-15-q-phu-nhuan-3-2x17-3l-id37466043', 1, '2018-03-12 15:30:18', '2018-03-12 15:30:18'),
(24, 1, NULL, '0914468070', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-11-l5908-c3204/ban-can-ho-chung-cu-tan-phuoc-c-tan-phuoc-plaza-p-7-quan-11-id43300119', 1, '2018-03-12 15:30:18', '2018-03-12 15:30:18'),
(25, 1, 'Lê Việt Thắng', '0949027897', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-8-l5916-c3204/can-ho-ven-song-ngay-cau-nguyen-tri-phuong-chi-tu-1-08-ty-2pn-id43239501', 1, '2018-03-12 15:30:18', '2018-03-12 15:30:18'),
(26, 1, 'tuan', '0938066682', 'Royal city , Hanoi', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-binh-thanh-l5919-c3204/ban-canho-tang26-can12a-landmark-6-smarthome-vinhome-central-park-id37815434', 1, '2018-03-12 15:30:18', '2018-03-12 15:30:18'),
(27, 1, NULL, '0938762123', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-7-l5915-c3204/mo-ban-can-ho-mat-tien-dao-tri-hoang-quoc-viet-quan-7-id43239727', 1, '2018-03-12 15:30:19', '2018-03-12 15:30:19'),
(28, 1, 'Huỳnh Hữu Nghĩa', '0933132333', 'quy dưc binh chanh', 'https://muaban.net/nha-mat-tien-huyen-binh-chanh-l5901-c3201/ban-nha-moi-100-ql-50-cau-ong-thin-noi-that-cao-cap-so-hong-rieng-id39861508', 1, '2018-03-12 15:30:19', '2018-03-12 15:30:19'),
(29, 1, 'seven hiệp', '0909044078', 'Phạm Thế Hiễn', 'https://muaban.net/nha-hem-ngo-quan-4-l5912-c3202/nha-cap-3-quan-4-vi-tri-dep-tien-it-day-du-noi-that-dep-moi-nha-trong-id43197852', 1, '2018-03-12 15:30:19', '2018-03-12 15:30:19'),
(30, 1, 'Nguyễn Văn Kiên', '0902711178', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/nha-nat-cuoi-duong-thong-nhat-dt-4-x19-hem-8m-gia-2-6-ty--id43261547', 2, '2018-03-12 15:30:20', '2018-03-12 15:30:20'),
(31, 1, NULL, '0919299740', 'Hẻm 90 Nguyễn Phúc Chu, Phường 15, Quận Tân Bình', 'https://muaban.net/nha-hem-ngo-quan-tan-binh-l5922-c3202/nha-hem-90-nguyen-phuc-chu-q-tan-binh-duc-1-lau-sh-rieng-id43096580', 1, '2018-03-12 15:30:20', '2018-03-12 15:30:20'),
(32, 1, 'Tuyết', '0933105389', NULL, 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/ban-nha-quan-8-so-hong-mat-tien-4x20m-3-tam-gia-4-3-ty-id43239817', 1, '2018-03-12 15:30:20', '2018-03-12 15:30:20'),
(33, 1, 'Trần thanh Giàu', '0974613633', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-moi-5x14m-duc-4-tam-quang-trung-phuong-8-gia-6-ty-2-id43320432', 3, '2018-03-12 15:30:22', '2018-03-12 15:30:54'),
(34, 1, 'Công Ty Cổ Phần Đầu Tư Bất Động Sản UpGroup', '0901425533', '887 Luỹ Bán Bích, Tân Thành, Tân Phú', 'https://muaban.net/nha-hem-ngo-quan-tan-phu-l5923-c3202/nha-hem-3-16-nguyen-quy-anh-tan-son-nhi-dt-4x12m-no-hau-nha-cuc-dep-id42912402', 3, '2018-03-12 15:30:23', '2018-03-12 15:31:09'),
(35, 1, 'Chính chủ bán', '0938816345', 'gần Hồ Cá Koi Nhật Bản, đường Nguyễn Thị Thử vào 150m', 'https://muaban.net/biet-thu-villa-penthouse-huyen-hoc-mon-l5904-c3205/villa-tuyet-dep-moi-hoan-thien-5x18m-duc-1-lau-gan-ca-koi-nhat-ban-id43221064', 1, '2018-03-12 15:30:23', '2018-03-12 15:30:23'),
(36, 1, NULL, '0968350768', NULL, 'https://muaban.net/nha-mat-tien-quan-binh-tan-l5918-c3201/ban-1000m2-dat-nha-quan-binh-tan-gia-re-id43263595', 1, '2018-03-12 15:30:24', '2018-03-12 15:30:24'),
(37, 1, 'Nhu Y Ly', '0919996236', NULL, 'https://muaban.net/nha-hem-ngo-quan-3-l5911-c3202/can-ban-nha-490-21d-le-van-sy-p14-q-3--id43283665', 1, '2018-03-12 15:30:25', '2018-03-12 15:30:25'),
(38, 1, 'Ngô Yến', '0938501939', NULL, 'https://muaban.net/nha-mat-tien-quan-9-l5917-c3201/ban-nha-1-tret-2-lau-duong-160-la-xuan-oai-nha-moi-vao-o-ngay-id43343159', 1, '2018-03-12 15:30:25', '2018-03-12 15:30:25'),
(39, 1, 'Hoàng Phúc', '0931156794', '61/4/3 Đường Số 2, F Bình Hưng Hòa B, Q Bình Tân', 'https://muaban.net/nha-hem-ngo-quan-binh-tan-l5918-c3202/ba-n-nha-he-m-161-duo-ng-bi-nh-tri-dong-4-x17-3-la-u-4-5-ty--id43321895', 2, '2018-03-12 15:30:25', '2018-03-12 15:30:36'),
(40, 1, 'A. Hùng', '0918063035', NULL, 'https://muaban.net/nha-hem-ngo-quan-7-l5915-c3202/ban-nha-hem-xe-hoi-nguyen-van-linh-phuong-tan-thuan-tay-4x15m-1-lau-id43348057', 2, '2018-03-12 15:30:26', '2018-03-12 15:30:34'),
(41, 1, NULL, '0902333511', '342 Cộng Hòa, Quận Tân Bình', 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-nha-mat-tien-nui-thanh-quan-tan-binh-nha-dep-id43241720', 1, '2018-03-12 15:30:26', '2018-03-12 15:30:26'),
(42, 1, 'gặp chị Ánh', '0916709697', NULL, 'https://muaban.net/nha-mat-tien-quan-binh-thanh-l5919-c3201/ban-nha-mat-tien-206-duong-dinh-bo-linh-binh-thanh-21-ty-id43241081', 1, '2018-03-12 15:30:26', '2018-03-12 15:30:26'),
(43, 1, 'Lê Đức Hậu', '0906848437', NULL, 'https://muaban.net/nha-mat-tien-quan-go-vap-l5920-c3201/mat-tien-nguyen-duy-cung-5-6x28-no-hau-10m-p-12-go-vap-id43219057', 1, '2018-03-12 15:30:27', '2018-03-12 15:30:27'),
(44, 1, 'Tuấn Anh lands', '0936483116', 'Dương quảng hàm, p5,gò vấp', 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/nha-4x11-75m-2l-st-3pn-3wc-hxh-gia-4-ty-duong-quang-ham-p5-id43240912', 4, '2018-03-12 15:30:27', '2018-03-12 15:31:26'),
(45, 1, NULL, '0902197161', 'số cũ 78/14 (số mới 78/28) Cống Lở, Phường 15, Quận Tân Bình', 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-nha-mat-tien-duong-8m-78-14-cong-lo-p-15-tan-binh-7x15m-id43219104', 2, '2018-03-12 15:30:28', '2018-03-12 15:30:43'),
(46, 1, 'A.Tuấn', '01225921554', '1113 Huỳnh Tấn Phát, P.Phú Thuận, Q.7', 'https://muaban.net/nha-hem-ngo-quan-7-l5915-c3202/ban-nha-chinh-chu-hem-1113-huynh-tan-phat-p-phu-thuan-q-7-id43131089', 1, '2018-03-12 15:30:28', '2018-03-12 15:30:28'),
(47, 1, 'A.Khoa', '0907943179', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-gap-nha-mat-tien-tan-xuan-cho-tan-binh-4x14-5m-4-tam-id43345275', 1, '2018-03-12 15:30:28', '2018-03-12 15:30:28'),
(48, 1, 'Anh Dũng', '0944774188', NULL, 'https://muaban.net/biet-thu-villa-penthouse-quan-tan-phu-l5923-c3205/biet-thu-duong-go-dau-hem-xe-hoi-id43281153', 1, '2018-03-12 15:30:29', '2018-03-12 15:30:29'),
(49, 1, 'HUỲNH NGỌC TRỌNG', '0909083436', '62 đường 3B KDC Conic, Xã Phong Phú, Huyện Bình Chánh, Tphcm', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-7-l5915-c3204/chinh-chu-can-ban-nha-can-goc-block-b3-chung-cu-era-town-duc-khai-id43128969', 1, '2018-03-12 15:30:29', '2018-03-12 15:30:29'),
(50, 1, NULL, '0978236858', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-hem-duong-quang-trung-quan-go-vap-4-05x20m-gia-3-55-ty-id43182232', 1, '2018-03-12 15:30:30', '2018-03-12 15:30:30'),
(51, 1, NULL, '0903648836', NULL, 'https://muaban.net/nha-mat-tien-quan-binh-tan-l5918-c3201/ban-hoac-cho-thue-dai-han-nha-mat-tien-dg-bia-truyen-thong-binh-tan-id43218558', 1, '2018-03-12 15:30:30', '2018-03-12 15:30:30'),
(52, 1, 'A.Sản', '0989030756', NULL, 'https://muaban.net/biet-thu-villa-penthouse-quan-12-l5909-c3205/ban-biet-thu-mat-tien-ha-huy-giap-quan-12-id43091127', 2, '2018-03-12 15:30:30', '2018-03-12 15:30:30'),
(53, 1, 'Thuỷ', '0937590440', '45c1 Khu Phố 4, Đường 11, Phường Linh Xuân, Thủ Đức', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-9-l5917-c3204/can-ban-can-ho-thuoc-du-an-the-art-gia-hoa-duong-do-xuan-hop-quan-9--id42978049', 1, '2018-03-12 15:30:31', '2018-03-12 15:30:31'),
(54, 1, NULL, '0932054188', NULL, 'https://muaban.net/nha-hem-ngo-quan-phu-nhuan-l5921-c3202/ban-nha-hem-xe-hoi-6m-huynh-van-banh-phuong-14-quan-phu-nhuan-id43121943', 2, '2018-03-12 15:30:32', '2018-03-12 15:30:33'),
(55, 1, 'Lê Hiếu', '0915253030', '489A/23 Huynh Van Banh P13 Qpn', 'https://muaban.net/nha-hem-ngo-quan-phu-nhuan-l5921-c3202/nha-3lau-hie-n-da-i-da-ng-ca-p-chau-au-hem-xe-hoi-huynh-van-banh-p13-id43164794', 4, '2018-03-12 15:30:33', '2018-03-12 15:31:28'),
(56, 1, 'Anh Bách', '0908866441', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-tan-l5918-c3202/ban-nha-hem-xe-hoi-quan-binh-tan-3x9-gia-1-75-ty-id43114753', 1, '2018-03-12 15:30:33', '2018-03-12 15:30:33'),
(57, 1, 'Quang Nghĩa', '0916276776', NULL, 'https://muaban.net/nha-mat-tien-quan-thu-duc-l5924-c3201/ban-nha-pho-xay-moi-dep-hoan-thien-duc-kien-co-3-tam-shr-gia-3-52-ty-id43147013', 2, '2018-03-12 15:30:34', '2018-03-12 15:31:27'),
(58, 1, 'bothoc@', '0983886605', 'q4', 'https://muaban.net/nha-hem-ngo-quan-8-l5916-c3202/ban-nha-hem-xe-hoi-p2-q8-gan-cho-rach-ong-id43130001', 1, '2018-03-12 15:30:34', '2018-03-12 15:30:34'),
(59, 1, 'TRẦN NGUYỄN TRỌNG NHÂN', '0938638977', '127 MỄ CỐC P15 Q8', 'https://muaban.net/nha-hem-ngo-quan-8-l5916-c3202/co-hoi-so-huu-nha-pho-3-lau-dtsd-100m2-sh-2018-gia-chi-1-ty-590-id43145087', 2, '2018-03-12 15:30:35', '2018-03-12 15:30:35'),
(60, 1, 'A.Vũ', '0909954032', NULL, 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/chinh-thuc-mo-ban-du-an-nha-pho-cao-cap-cao-lo-duong-84-p-4-q-8-id42796268', 2, '2018-03-12 15:30:37', '2018-03-12 15:31:28'),
(61, 1, 'anh Thuận', '0989626327', NULL, 'https://muaban.net/nha-mat-tien-quan-6-l5914-c3201/ban-nha-mat-tien-duong-vo-van-kiet-quan-6-2-lau-so-hong-id43284516', 1, '2018-03-12 15:30:37', '2018-03-12 15:30:37'),
(62, 1, 'DƯƠNG VĂN TIẾN', '0903644746', '28 Đường số 8 KDC Hiệp Bình, Phường Hiệp Bình Phước, Quaän Thủ Đức &#8211; Tp. HCM', 'https://muaban.net/biet-thu-villa-penthouse-quan-thu-duc-l5924-c3205/ban-biet-thu-cao-cap-gia-7-9-ty-id43199523', 1, '2018-03-12 15:30:37', '2018-03-12 15:30:37'),
(63, 1, 'Nhà đất Thanh Trà', '0902207239', NULL, 'https://muaban.net/nha-hem-ngo-quan-12-l5909-c3202/ban-nha-hiep-thanh-19-quan-12-gia-1-15-ty--id43263907', 2, '2018-03-12 15:30:38', '2018-03-12 15:31:19'),
(64, 1, NULL, '0906787424', NULL, 'https://muaban.net/nha-hem-ngo-quan-tan-phu-l5923-c3202/ban-nha-hem-6m-849-16-luy-ban-bich-tan-thanh-tan-phu-id43129787', 1, '2018-03-12 15:30:39', '2018-03-12 15:30:39'),
(65, 1, 'chị Ngọc Hà', '0938444358', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-duong-nguyen-tu-gian-quan-go-vap-gia-2-6-ty-id42795195', 1, '2018-03-12 15:30:40', '2018-03-12 15:30:40'),
(66, 1, 'Khánh lai', '0968183911', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-binh-thanh-l5919-c3204/ban-nhanh-cc-cuu-long-binh-thanh-id43322113', 1, '2018-03-12 15:30:40', '2018-03-12 15:30:40'),
(67, 1, 'Anh Ba', '0934084695', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-phu-l5923-c3201/can-ban-hoac-cho-thue-nha-mt-nguyen-xuan-khoat-8x23m-1-tret-3-lau-id43283746', 1, '2018-03-12 15:30:40', '2018-03-12 15:30:40'),
(68, 1, 'A. Chí', '0936173176', NULL, 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/ban-gap-nha-pho-3-tang-cao-cap-kdc-cao-lo-gan-trung-tam-q5-q1-id42026414', 1, '2018-03-12 15:30:42', '2018-03-12 15:30:42'),
(69, 1, 'Ms Lan', '0907456760', '417 Quang Trung P10, Gò Vấp, Tp. HCM', 'https://muaban.net/nha-mat-tien-quan-go-vap-l5920-c3201/ban-gap-nha-mth-417-quang-trung-p10-go-vap-id43165795', 1, '2018-03-12 15:30:42', '2018-03-12 15:30:42'),
(70, 1, 'cô Thủy', '01664188753', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-2-l5910-c3204/can-ban-can-ho-cao-cap-chung-cu-an-hoa-quan-2-2-ty-id41331386', 1, '2018-03-12 15:30:42', '2018-03-12 15:30:42'),
(71, 1, 'Ba', '0938641139', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-tan-l5918-c3202/chinh-chu-ban-nha-duc-4-tam-1-sec-huong-lo-2-gia-1ty850-id41886487', 1, '2018-03-12 15:30:44', '2018-03-12 15:30:44'),
(72, 1, 'Anh Huy', '0902007171', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-phu-l5923-c3201/chinh-chu-ban-nha-mt-243-khuong-viet-dam-sen-8-x-14m-id41686105', 1, '2018-03-12 15:30:44', '2018-03-12 15:30:44'),
(73, 1, NULL, '0902433886', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-7-l5915-c3204/hung-thinh-land-mo-ban-can-ho-cao-cap-view-song-sg-phu-my-hung-id43148404', 1, '2018-03-12 15:30:44', '2018-03-12 15:30:44'),
(74, 1, 'A. ĐỨC', '0915369499', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-hem-xe-hoi-111-4-pham-van-chieu-phuong-14-go-vap-9-x-16--id43347389', 1, '2018-03-12 15:30:44', '2018-03-12 15:30:44'),
(75, 1, 'Anh Trung', '0919691692', 'hẻm 128', 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/can-ban-gap-nha-dien-bien-phu-phuong-17-quan-binh-thanh-gan-q1-id43303300', 1, '2018-03-12 15:30:47', '2018-03-12 15:30:47'),
(76, 1, 'Chung cư Thái Sơn', '0937067828', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-binh-tan-l5918-c3204/ban-can-ho-chung-cu-tan-tao-1-chung-cu-thai-son-quan-binh-tan-id42235402', 1, '2018-03-12 15:30:47', '2018-03-12 15:30:47'),
(77, 1, 'nguyễn thanh', '0916553878', NULL, 'https://muaban.net/nha-mat-tien-quan-go-vap-l5920-c3201/ban-nha-mt-duong-quang-trung-doi-dien-cho-11x33m--id43039075', 1, '2018-03-12 15:30:47', '2018-03-12 15:30:47'),
(78, 1, 'Tùng', '0937981143', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-tan-l5918-c3202/ban-nha-hem-1-sec-rong-12m-tai-binh-tri-dong-a-huong-lo-2-27m2-id43114498', 1, '2018-03-12 15:30:48', '2018-03-12 15:30:48'),
(79, 1, 'Chung', '0902009503', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-tan-l5918-c3202/nhan-ngay-3-chi-vang-sjc-khi-mua-nha-pho-lien-ke-quan-binh-tan-gia-re-id43114320', 1, '2018-03-12 15:30:48', '2018-03-12 15:30:48'),
(80, 1, 'Chiến', '0908513780', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-tan-l5918-c3202/ban-nha-1-sec-huong-lo-2-binh-tri-dong-a-binh-tan-4-tam-gia-re-id43114204', 1, '2018-03-12 15:30:48', '2018-03-12 15:30:48'),
(81, 1, NULL, '0972469779', NULL, 'https://muaban.net/nha-hem-ngo-quan-12-l5909-c3202/ban-nha-2-can-ke-nhau-phuong-hiep-thanh-quan-12-55m2-can-2-6-ty-can-id43089320', 1, '2018-03-12 15:30:49', '2018-03-12 15:30:49'),
(82, 1, 'Chính chủ', '0937473425', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/chinh-chu-ban-nha-hxh-so-434-76-40-pham-van-chieu-phuong-9-go-vap-id43302688', 1, '2018-03-12 15:30:49', '2018-03-12 15:30:49'),
(83, 1, NULL, '0909098835', NULL, 'https://muaban.net/nha-hem-ngo-quan-8-l5916-c3202/ban-nha-hem-duong-au-duong-lan-phuong-3-quan-8-cach-mat-tien-100m-id42414474', 2, '2018-03-12 15:30:50', '2018-03-12 15:30:50'),
(84, 1, 'Chủ Bán', '01683837475', 'Gần khu du lịch RinRinPark, Cách chợ Đại Hải 500m', 'https://muaban.net/biet-thu-villa-penthouse-huyen-hoc-mon-l5904-c3205/villa-cao-cap-duc-1-lau-duong-nhua-8m-gan-kdl-rinrinpark-sh-rieng-id43221653', 1, '2018-03-12 15:30:50', '2018-03-12 15:30:50'),
(85, 1, 'PHẠM THANH HÙNG', '0909099773', NULL, 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/day-nha-pho-3-tang-cao-lo-ta-quang-buu-sh-rieng-2017-da-hoan-cong-id43068528', 2, '2018-03-12 15:30:51', '2018-03-12 15:31:05'),
(86, 1, 'bích hùng', '0984597205', NULL, 'https://muaban.net/nha-mat-tien-quan-12-l5909-c3201/nha-ban-ph-hiep-thanh-q12-dt-4x12-gia-2345tr-gt-shr-id43349263', 2, '2018-03-12 15:30:51', '2018-03-12 15:30:52'),
(87, 1, 'Chị Thảo', '0939556344', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-binh-thanh-l5919-c3204/can-ban-can-ho-thanh-da-view-q-binh-thanh-dt-131m2-3pn-da-co-so-id43324514', 1, '2018-03-12 15:30:51', '2018-03-12 15:30:51'),
(88, 1, 'A.Phước', '0903072568', NULL, 'https://muaban.net/nha-mat-tien-quan-go-vap-l5920-c3201/ban-nha-2-mat-tien-pham-van-dong-le-loi-p-3-go-vap-id43349274', 1, '2018-03-12 15:30:51', '2018-03-12 15:30:51'),
(89, 1, 'tran loc', '0935974567', NULL, 'https://muaban.net/nha-hem-ngo-quan-tan-phu-l5923-c3202/ban-nha-hxh-cach-duong-au-co-10m-quan-tan-phu-id43324405', 1, '2018-03-12 15:30:52', '2018-03-12 15:30:52'),
(90, 1, 'chị Ngọc Hà', '0901333657', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-gap-nha-moi-xay-quan-go-vap-4x13m-gia-3-25-ty-id43115192', 2, '2018-03-12 15:30:52', '2018-03-12 15:30:56'),
(91, 1, 'Vũ Duy', '0964456958', NULL, 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/nha-pho-lien-ke-3-tang-nam-ngay-eon-cao-lo-noi-phat-trien-bac-nhat-qua-id43125537', 1, '2018-03-12 15:30:54', '2018-03-12 15:30:54'),
(92, 1, 'Chị Loan', '0933330652', NULL, 'https://muaban.net/nha-mat-tien-quan-8-l5916-c3201/ban-day-nha-pho-mat-tien-duong-10m-dien-tich-4x26m-p-16-q-8-id40131821', 1, '2018-03-12 15:30:54', '2018-03-12 15:30:54'),
(93, 1, 'ĐẶNG VĂN HÙNG', '0982379353', '98/13 Nguyễn Phúc Chu', 'https://muaban.net/nha-hem-ngo-quan-tan-binh-l5922-c3202/nha-ban-hem-533-pham-van-bach-p-15-q-tan-binh-id43304896', 1, '2018-03-12 15:30:54', '2018-03-12 15:30:54'),
(94, 1, 'Thanh', '0932003960', '50/7T, XTT 22, Ấp 4, Xã. Xuân Thới Thượng, Huyện. Hóc Môn, Tp. Hồ Chí Minh', 'https://muaban.net/nha-mat-tien-huyen-hoc-mon-l5904-c3201/ket-tien-ban-gap-nha-cach-phan-van-hon-50m-hoc-mon-9x22-1-lau-id43179843', 1, '2018-03-12 15:30:56', '2018-03-12 15:30:56'),
(95, 1, 'Ms Hòa Kun', '0931323118', NULL, 'https://muaban.net/nha-hem-ngo-quan-11-l5908-c3202/can-tien-ban-gap-nha-so-273-1-lac-long-quan-p-3-q-11-id43306880', 1, '2018-03-12 15:30:56', '2018-03-12 15:30:56'),
(96, 1, 'Hữu Hoan', '0902738588', 'hoanhuynh@hungthinhland.com', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-7-l5915-c3204/can-ho-cao-cap-q7-saigon-riverside-54-tien-ich-chu-dau-tu-hung-thinh-id43329667', 1, '2018-03-12 15:30:56', '2018-03-12 15:30:56'),
(97, 1, 'A.Tân', '0914829717', '106 Đề Thám, Q.1', 'https://muaban.net/nha-mat-tien-quan-3-l5911-c3201/ban-nha-mat-tien-vo-thi-sau-23x27m-id43244510', 1, '2018-03-12 15:30:57', '2018-03-12 15:30:57'),
(98, 1, 'Anh Việt', '0983459845', NULL, 'https://muaban.net/nha-mat-tien-quan-10-l5907-c3201/can-ban-gap-nha-mat-tien-duong-3-2-trung-tam-quan-10-id43130536', 1, '2018-03-12 15:30:57', '2018-03-12 15:30:57'),
(99, 1, NULL, '0977235435', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-nha-mt-15m-binh-gia-q-tan-binh-vi-tri-dep-id43306361', 1, '2018-03-12 15:30:58', '2018-03-12 15:30:58'),
(100, 1, 'KMict', '0902864337', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/chinh-chu-xuat-ngoai-ban-168-4-bau-cat-1-p-12-tb-4x23-06m-92-20m2--id43245643', 1, '2018-03-12 15:30:59', '2018-03-12 15:30:59'),
(101, 1, 'chị Vân', '0917850011', NULL, 'https://muaban.net/biet-thu-villa-penthouse-quan-2-l5910-c3205/can-ban-gap-can-nha-biet-thu-vuon-da-hoan-thien-ntcc-tai-q-2-dt-6x20m-id42343106', 1, '2018-03-12 15:30:59', '2018-03-12 15:30:59'),
(102, 1, 'Thủy', '0938072899', NULL, 'https://muaban.net/nha-mat-tien-quan-1-l5906-c3201/ban-nha-duong-tran-khac-chan-p-tan-dinh-quan-1-id43306171', 1, '2018-03-12 15:31:00', '2018-03-12 15:31:00'),
(103, 1, 'Mr.Phạm Hùng Hải', '0903402080', '+ Tầng 4 Tòa nhà 296 Phan Xích Long, P7, Q. Phú Nhuận, Tp Hồ Chí Minh', 'https://muaban.net/nha-mat-tien-quan-9-l5917-c3201/danh-sach-tai-san-chao-ban-khu-vuc-mien-nam-id43305984', 1, '2018-03-12 15:31:00', '2018-03-12 15:31:00'),
(104, 1, 'cô Hà', '0909253639', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/ban-gap-nha-hem-410-le-quang-dinh-q-binh-thanh-id43349665', 1, '2018-03-12 15:31:00', '2018-03-12 15:31:00'),
(105, 1, 'Dương', '0938350213', 'HCM', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-2-l5910-c3204/can-ho-citihome-day-du-tien-ich-quan-2-cach-quan-1-chi-20-phut-id43149847', 1, '2018-03-12 15:31:00', '2018-03-12 15:31:00'),
(106, 1, '-', '0903656363', '295 Tân Kỳ Tân Quý', 'https://muaban.net/nha-mat-tien-quan-tan-phu-l5923-c3201/ban-nha-pho-1t-2l-st-trong-khu-biet-lap-cao-cap-o-ket-hop-vp-cong-ty-id42743960', 1, '2018-03-12 15:31:01', '2018-03-12 15:31:01'),
(107, 1, NULL, '0908312148', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/ban-nha-hem-xe-hoi-71-dien-bien-phu-p15-binh-thanh-id43351997', 1, '2018-03-12 15:31:02', '2018-03-12 15:31:02'),
(108, 1, NULL, '0909585435', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-hoac-cho-thue-nha-mt-hoang-hoa-tham-q-tan-binh-vi-tri-dep-id43305764', 2, '2018-03-12 15:31:02', '2018-03-12 15:31:02'),
(109, 1, 'chị Năng', '0908201464', '92D42 Huỳnh Tấn Phát, P.Phú Thuận, Q.7', 'https://muaban.net/nha-mat-tien-quan-7-l5915-c3201/chinh-chu-ban-nha-huynh-tan-phat-p-phu-thuan-q-7-id43268633', 1, '2018-03-12 15:31:02', '2018-03-12 15:31:02'),
(110, 1, 'Hồ Trung Nghĩa', '0937726338', NULL, 'https://muaban.net/biet-thu-villa-penthouse-quan-8-l5916-c3205/nha-pho-lien-ke-mat-tien-an-duong-vuong-vo-van-kiet-gia-7-9-ty-can-id43249944', 1, '2018-03-12 15:31:04', '2018-03-12 15:31:04'),
(111, 1, 'lưu phan trần vũ', '0981670969', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-8-l5916-c3204/gia-hap-dan-ch-saigonsky-view-4-mt-ta-quang-buu-q8-hcm-id43152849', 1, '2018-03-12 15:31:04', '2018-03-12 15:31:04'),
(112, 1, 'Mỹ Tiên', '0948959493', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-7-l5915-c3204/ban-gap-can-ho-new-saigon-hoang-anh-gia-lai-3-dien-tich-100m2-nha-dep-id41180596', 1, '2018-03-12 15:31:04', '2018-03-12 15:31:04'),
(113, 1, 'A.Hưng', '0903800772', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-tan-binh-l5922-c3204/ban-2-can-ho-cao-cap-du-an-sai-gon-airport-plaza-bach-dang-tan-binh-id43167530', 1, '2018-03-12 15:31:04', '2018-03-12 15:31:04'),
(114, 1, NULL, '0914408271', NULL, 'https://muaban.net/nha-hem-ngo-huyen-binh-chanh-l5901-c3202/ban-nha-gan-cho-binh-chanh-gia-680-trieu-id43115471', 1, '2018-03-12 15:31:05', '2018-03-12 15:31:05'),
(115, 1, 'Trần Hoàng Phong', '0906888996', NULL, 'https://muaban.net/nha-hem-ngo-quan-5-l5913-c3202/can-ban-gap-nha-hem-3m-thuan-kieu-p12-q5-dt-7x34m-tret-1-la-id43149461', 1, '2018-03-12 15:31:05', '2018-03-12 15:31:05'),
(116, 1, NULL, '0946836789', NULL, 'https://muaban.net/nha-mat-tien-quan-phu-nhuan-l5921-c3201/ban-nha-mat-tien-262-nguyen-thuong-hien-phuong-5-phu-nhuan-id43188255', 1, '2018-03-12 15:31:07', '2018-03-12 15:31:07'),
(117, 1, 'Đoàn Dự', '0918804838', '1041 trần xuân soạn', 'https://muaban.net/nha-mat-tien-quan-binh-tan-l5918-c3201/ban-nha-mat-tien-duong-khieu-nang-tinh-p-an-lac-binh-tan-hcm-id43336435', 2, '2018-03-12 15:31:07', '2018-03-12 15:31:08'),
(118, 1, 'Nguyễn Du', '0938234269', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-gap-mt-nguyen-ba-tong-dt-4x16-5m-dt-66-m2-gia-5-6-ty-id43202786', 1, '2018-03-12 15:31:10', '2018-03-12 15:31:10'),
(119, 1, 'A.Linh', '0985797317', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-gap-nha-pham-van-chieu-p-13-go-vap-6-3-ty-id43271229', 1, '2018-03-12 15:31:11', '2018-03-12 15:31:11'),
(120, 1, NULL, '0932118380', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-2-toa-nha-van-phong-mt-phuong-12-va-phuong-2-tan-binh-id43247171', 1, '2018-03-12 15:31:11', '2018-03-12 15:31:11'),
(121, 1, 'Anh: Lương Thanh Thu', '0949814648', '550/3 đường Lê Hồng Phong. P10. Q10, Tp.HCM.', 'https://muaban.net/nha-hem-ngo-quan-10-l5907-c3202/ban-nha-550-3-duong-le-hong-phong-p10-q10-id43050630', 1, '2018-03-12 15:31:11', '2018-03-12 15:31:11'),
(122, 1, 'Hồ Ngọc Dũng', '0908979455', NULL, 'https://muaban.net/nha-hem-ngo-quan-tan-phu-l5923-c3202/ban-nha-hem-8m-thong-137-thoai-ngoc-hau-3-6-x-9m-1-tret-2-lau-id42603591', 1, '2018-03-12 15:31:12', '2018-03-12 15:31:12'),
(123, 1, 'Dương Thị Lan', '0938123475', 'Q8, TP HCM', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-8-l5916-c3204/can-ho-an-phuc-q8-gan-ngay-vo-van-kiet-nhan-nha-o-ngay-id43307299', 1, '2018-03-12 15:31:12', '2018-03-12 15:31:12'),
(124, 1, 'A.Thanh', '0933052157', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-gap-nha-quang-trung-p-10-go-vap-4x14m-2-05-ty-id43288540', 1, '2018-03-12 15:31:12', '2018-03-12 15:31:12'),
(125, 1, 'A nhựt', '0903483834', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-hem-xe-hoi-tran-ba-giao-quan-go-vap-id43350561', 1, '2018-03-12 15:31:13', '2018-03-12 15:31:13'),
(126, 1, 'A Ngọc', '0932885451', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/nha-gia-re-le-quang-dinh-3-5x8-no-hau-4-5-id43350541', 2, '2018-03-12 15:31:13', '2018-03-12 15:31:14'),
(127, 1, 'chính chủ', '0908676880', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-duong-12m-phan-huy-ich-quan-go-vap-khu-o-cao-cap-id43049982', 1, '2018-03-12 15:31:14', '2018-03-12 15:31:14'),
(128, 1, NULL, '0986672679', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-phu-l5923-c3201/ban-gap-mat-tien-gia-re-khuong-viet-quan-tan-phu-dt-13x28m-no-hau-id43350158', 2, '2018-03-12 15:31:14', '2018-03-12 15:31:28'),
(129, 1, 'Nguyễn Cao Cường', '0909848776', NULL, 'https://muaban.net/nha-mat-tien-quan-7-l5915-c3201/can-ban-nhanh-nha-tret-4-lau-mt-huynh-tan-phat-tan-phu-gia-17-9-ty-id43271641', 1, '2018-03-12 15:31:15', '2018-03-12 15:31:15'),
(130, 1, 'Mr Trung', '0939047076', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-phu-l5923-c3201/ban-nha-mt-le-cao-lang-4x20-gia-re-5-35ty-id43353307', 1, '2018-03-12 15:31:15', '2018-03-12 15:31:15'),
(131, 1, 'Chị Thủy', '0902499349', NULL, 'https://muaban.net/nha-mat-tien-quan-tan-binh-l5922-c3201/ban-nha-ngay-goc-vuong-giap-duong-cong-hoa-so-12-duong-a4-phuong-12-id43092159', 1, '2018-03-12 15:31:16', '2018-03-12 15:31:16'),
(132, 1, 'A.Khang', '0918673263', NULL, 'https://muaban.net/nha-hem-ngo-quan-5-l5913-c3202/ban-nha-hem-thong-59-8h-duong-thuan-kieu-phuong-12-quan-5-id43196019', 1, '2018-03-12 15:31:16', '2018-03-12 15:31:16'),
(133, 1, 'Thắng', '0945013540', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-4-8-x-16-5-moi-xay-duong-so-2-phuong-16-go-vap-id43170096', 2, '2018-03-12 15:31:16', '2018-03-12 15:31:20'),
(134, 1, NULL, '0903736558', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-gap-nha-thong-nhat-p-16-go-vap-4x17-5m-3-5-ty-id43114450', 1, '2018-03-12 15:31:17', '2018-03-12 15:31:17'),
(135, 1, 'Nguyen Duy An', '0901595159', NULL, 'https://muaban.net/nha-hem-ngo-quan-binh-thanh-l5919-c3202/ban-nha-hem-thong-8m-tien-kinh-doanh-4-8x20m-xo-viet-nghe-tinh-7-5ty-id43225606', 1, '2018-03-12 15:31:17', '2018-03-12 15:31:17'),
(136, 1, 'Nguyễn hữu Khuyến', '0903309027', '0903309027', 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/nha-pho-sieu-dep-6-5x8m-khu-pho-an-ninh-chinh-dong-gia-4-6-ty--id43221846', 4, '2018-03-12 15:31:17', '2018-03-12 15:31:18'),
(137, 1, 'A. Hiền', '0903915699', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-binh-thanh-l5919-c3204/ban-can-ho-dat-phuong-nam-a503-dien-tich-106-3-m2-2-phong-ngu-id42976993', 1, '2018-03-12 15:31:17', '2018-03-12 15:31:17'),
(138, 1, 'Vũ Bằng', '0919886665', 'sanmuabannhadat.com.vn', 'https://muaban.net/biet-thu-villa-penthouse-quan-10-l5907-c3205/sieu-biet-thu-moi-100-3-mat-tien-5l-thang-may-duong-3-2-id43143936', 2, '2018-03-12 15:31:19', '2018-03-12 15:31:22'),
(139, 1, 'Anh Tuấn', '0935855678', NULL, 'https://muaban.net/nha-hem-ngo-quan-10-l5907-c3202/ban-nha-hem-xe-hoi-duong-cach-mang-thang-8-phuong-13-quan-10-id41870176', 1, '2018-03-12 15:31:19', '2018-03-12 15:31:19'),
(140, 1, 'Phạm Văn Bình', '0968629692', 'đường số 54 phường 16 quận 8', 'https://muaban.net/can-ho-chung-cu-tap-the-quan-8-l5916-c3204/heaven-riverview-nhan-nha-o-ngay-so-hong-vinh-vien-id41716801', 1, '2018-03-12 15:31:21', '2018-03-12 15:31:21'),
(141, 1, 'chính chủ', '0903005478', '448/65/6 Phan Huy Ích, Phường 12, Quận Gò Vấp', 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/ban-nha-so-448-65-6-phan-huy-ich-phuong-12-quan-go-vap-id43093177', 1, '2018-03-12 15:31:23', '2018-03-12 15:31:23'),
(142, 1, 'Nguyễn Hồng Liên', '0915568659', NULL, 'https://muaban.net/nha-mat-tien-quan-3-l5911-c3201/ban-gap-nha-mat-tien-ban-co-quan-3-gia-9-ty-id43064399', 1, '2018-03-12 15:31:24', '2018-03-12 15:31:24'),
(143, 1, 'chị Ngọc Hà', '0903777392', NULL, 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/nha-ban-phuong-8-go-vap-3-5x10m-gia-2-75-ty-id42920619', 1, '2018-03-12 15:31:24', '2018-03-12 15:31:24'),
(144, 1, 'Mr. Toàn', '0906949770', NULL, 'https://muaban.net/nha-mat-tien-quan-binh-thanh-l5919-c3201/mat-tien-nguyen-xi-7-5x25-5m-don-gia-chi-70tr-m2-id43354745', 1, '2018-03-12 15:31:26', '2018-03-12 15:31:26'),
(145, 1, 'Thanh Thuỷ', '0933470292', NULL, 'https://muaban.net/can-ho-chung-cu-tap-the-quan-2-l5910-c3204/tropic-novaland-can-goc-3pn-view-ho-boi-song-sai-gon-id43310769', 1, '2018-03-12 15:31:27', '2018-03-12 15:31:27'),
(146, 1, 'Văn Hùng', '0978121416', '943/15 QUANG TRUNG, P14, GÒ VẤP', 'https://muaban.net/nha-hem-ngo-quan-go-vap-l5920-c3202/nha-943-15-quang-trung-1-truc-2-mat-hem-phuong-14-go-vap-id41257922', 1, '2018-03-12 15:31:28', '2018-03-12 15:31:28'),
(147, 1, NULL, '0902465948', NULL, 'https://muaban.net/nha-mat-tien-quan-7-l5915-c3201/ban-nha-mot-tret-1-lau-3-phong-ngu-hem-3m-p-binh-thuan-q-7-id43227751', 1, '2018-03-12 15:31:29', '2018-03-12 15:31:29'),
(148, 1, 'Minh Hội', '0913147777', 'khu dân cư đại hải', 'https://muaban.net/nha-hem-ngo-huyen-hoc-mon-l5904-c3202/can-ban-gap-nha-2-tam-5-moi-xay-id43189634', 1, '2018-03-12 15:31:29', '2018-03-12 15:31:29'),
(149, 1, 'A.Khoa', '0906922247', NULL, 'https://muaban.net/nha-mat-tien-quan-6-l5914-c3201/ban-nha-101-kinh-duong-vuong-phuong-12-quan-6-vi-tri-dat-dia--id43354561', 1, '2018-03-12 15:31:29', '2018-03-12 15:31:29'),
(150, 1, 'Anh Tài', '0917388379', 'Lê Văn Sỹ, Q.3', 'https://muaban.net/nha-mat-tien-quan-3-l5911-c3201/ban-gap-nha-mt-le-van-sy-4-x-20m-3lau-duong-30m-khu-kd-sam-uat-id42996181', 1, '2018-03-12 15:31:30', '2018-03-12 15:31:30'),
(151, 1, 'A.Cường', '0903846350', NULL, 'https://muaban.net/nha-mat-tien-huyen-cu-chi-l5903-c3201/ban-nha-va-dat-cu-chi-mat-tien-duong-tl15-xa-trung-an-id43021104', 1, '2018-03-12 15:31:31', '2018-03-12 15:31:31'),
(152, 1, NULL, '0902479580', NULL, 'https://muaban.net/nha-hem-ngo-quan-10-l5907-c3202/chinh-chu-ban-gap-nha-hem-xe-tai-7b-8-thanh-thai-p-14-quan-10-id43171065', 1, '2018-03-12 15:31:31', '2018-03-12 15:31:31'),
(153, 1, 'A Thanh', '0902348274', NULL, 'https://muaban.net/nha-hem-ngo-quan-12-l5909-c3202/nha-cao-cap-3-5x12-2-tam-2pn-2wc-ha-huy-giap-nga-tu-ga-duong-8m-bt-id43272152', 1, '2018-03-12 15:31:31', '2018-03-12 15:31:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crawl_data`
--
ALTER TABLE `crawl_data`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crawl_data`
--
ALTER TABLE `crawl_data`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
