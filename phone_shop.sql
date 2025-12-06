-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3307
-- Thời gian đã tạo: Th12 02, 2025 lúc 07:31 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `phone_shop`
--
CREATE DATABASE IF NOT EXISTS `phone_shop`;
USE `phone_shop`;


-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `status` enum('unread','read','replied') DEFAULT 'unread',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_city` varchar(100) NOT NULL,
  `shipping_district` varchar(100) DEFAULT NULL,
  `shipping_ward` varchar(100) DEFAULT NULL,
  `payment_method` varchar(50) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `shipping_fee` decimal(15,2) DEFAULT 0.00,
  `tax` decimal(15,2) DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `shipping_city`, `shipping_district`, `shipping_ward`, `payment_method`, `subtotal`, `shipping_fee`, `tax`, `total`, `status`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'Tran Hong Quang', 'tranhongquangminh@gmail.com', '0326423291', 'to 34, khu pho 3a, hem 105, duong tran van xa', 'Hồ Chí Minh', '1', 'Bien Hoa city', 'cod', 49980000.00, 0.00, 0.00, 49980000.00, 'pending', '', '2025-12-01 12:00:21', '2025-12-01 12:00:21'),
(2, 'Tran Hong Quang', 'tranhongquangminh@gmail.com', '0326423291', 'to 34, khu pho 3a, hem 105, duong tran van xa', 'Hồ Chí Minh', '1', 'Bien Hoa city', 'cod', 46000000.00, 0.00, 0.00, 46000000.00, 'pending', '', '2025-12-01 12:01:58', '2025-12-01 12:01:58'),
(3, 'Quảng Trần', 'tran@gmail.com', '0326423291', 'tổ 34 khu phố 3A phường Trảng Dài Biên Hòa', 'Hồ Chí Minh', '1', 'Biên Hòa', 'cod', 144990000.00, 0.00, 0.00, 144990000.00, 'pending', '', '2025-12-02 12:42:36', '2025-12-02 12:42:36'),
(4, 'Tran Hong Quang', 'tranhongquangminh@gmail.com', '0326423291', 'to 34, khu pho 3a, hem 105, duong tran van xa', 'Hải Phòng', '1', 'Bien Hoa city', 'cod', 91960000.00, 0.00, 0.00, 91960000.00, 'pending', '', '2025-12-02 16:17:11', '2025-12-02 16:17:11'),
(5, 'Tran Hong Quang', 'tranhongquangminh@gmail.com', '0326423291', 'to 34, khu pho 3a, hem 105, duong tran van xa', 'Cần Thơ', '1', 'Bien Hoa city', 'cod', 186930000.00, 0.00, 0.00, 186930000.00, 'pending', '', '2025-12-02 18:15:15', '2025-12-02 18:15:15');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_price` decimal(15,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `subtotal`) VALUES
(1, 1, 12, 'OnePlus 12', 19990000.00, 1, 19990000.00),
(2, 1, 9, 'iPhone 16 Pro', 29990000.00, 1, 29990000.00),
(3, 2, 1, 'iPhone 15 Pro Max', 23000000.00, 2, 46000000.00),
(4, 3, 9, 'iPhone 16 Pro', 29990000.00, 1, 29990000.00),
(5, 3, 1, 'iPhone 15 Pro Max', 23000000.00, 5, 115000000.00),
(6, 4, 11, 'OPPO Find X7 Pro', 22990000.00, 4, 91960000.00),
(7, 5, 8, 'Samsung Galaxy Z Fold 6', 44990000.00, 1, 44990000.00),
(8, 5, 9, 'iPhone 16 Pro', 29990000.00, 1, 29990000.00),
(9, 5, 11, 'OPPO Find X7 Pro', 22990000.00, 4, 91960000.00),
(10, 5, 12, 'OnePlus 12', 19990000.00, 1, 19990000.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `view_count` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_categories`
--

CREATE TABLE `post_categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `display_order` int(11) DEFAULT 0,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `post_categories`
--

INSERT INTO `post_categories` (`id`, `name`, `slug`, `description`, `color`, `display_order`, `status`, `created_at`) VALUES
(1, 'Technology News', 'tech-news', 'Latest news about technology and smartphones', '#3B82F6', 1, 'active', '2025-12-02 18:00:48'),
(2, 'Product Reviews', 'product-reviews', 'Detailed reviews of smartphone products', '#10B981', 2, 'active', '2025-12-02 18:00:48'),
(3, 'Tutorials', 'tutorials', 'User guides and tips', '#F59E0B', 3, 'active', '2025-12-02 18:00:48'),
(4, 'Product Comparisons', 'comparisons', 'Compare products with each other', '#8B5CF6', 4, 'active', '2025-12-02 18:00:48'),
(5, 'Promotions', 'promotions', 'Information about promotional programs', '#EF4444', 5, 'active', '2025-12-02 18:00:48'),
(6, 'Events', 'events', 'News about product launch events', '#EC4899', 6, 'active', '2025-12-02 18:00:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_comments`
--

CREATE TABLE `post_comments` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `user_type` enum('customer','admin') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `post_reactions`
--

CREATE TABLE `post_reactions` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_type` enum('customer','admin') NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `reaction_type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT 'placeholder.png',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(50) DEFAULT 'Phones',
  `storage` varchar(20) DEFAULT NULL,
  `ram` varchar(20) DEFAULT NULL,
  `stock` int(11) DEFAULT 10,
  `average_rating` decimal(2,1) DEFAULT 0.0 COMMENT 'Average rating (0.0 - 5.0)',
  `review_count` int(11) DEFAULT 0 COMMENT 'Total reviews'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `brand`, `price`, `image`, `description`, `created_at`, `category`, `storage`, `ram`, `stock`, `average_rating`, `review_count`) VALUES
(1, 'iPhone 15 Pro Max', 'Apple', 23000000.00, 'https://tranphumobile.com/wp-content/uploads/2024/11/iphone-15-pro-vs-iphone-15-pro-max-256gb-512gb-1tb-mau-titan-den.jpg', 'Titanium design, A17 Pro chip, 48MP Main camera.', '2025-11-21 09:09:26', 'Phones', '512GB', '8GB', 3, 4.8, 24),
(2, 'Samsung Galaxy S24 Ultra', 'Samsung', 18980000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/s/s/ss-s24-timultra-22.png', 'Galaxy AI, 200MP camera, Titanium frame.', '2025-11-21 09:09:26', 'Phones', '256GB', '12GB', 10, 0.0, 0),
(3, 'Google Pixel 8 Pro', 'Google', 18990000.00, 'https://sonpixel.vn/wp-content/uploads/2024/01/Pixel-8-pro-trang-su.png', 'Google AI, Best camera for photos.', '2025-11-21 09:09:26', 'Phones', '128GB', '12GB', 10, 0.0, 0),
(4, 'Xiaomi 14 Ultra', 'Xiaomi', 10990000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/x/i/xiaomi-14-ultra.jpg', 'Leica optics, Snapdragon 8 Gen 3.', '2025-11-21 09:09:26', 'Phones', '256GB', '12GB', 10, 0.0, 0),
(5, 'AirPods Pro 2', 'Apple', 2490000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/a/i/airpods_pro_2_sep24_pdp_image_position_2__vn-vi.jpg', 'Active Noise Cancellation.', '2025-11-21 09:09:26', 'Audio', NULL, NULL, 10, 0.0, 0),
(6, 'Galaxy Watch 6', 'Samsung', 2990000.00, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/s/m/sm-r930_002_front2_graphite_1.png', 'Health monitoring, Sleep coaching.', '2025-11-21 09:09:26', 'Accessories', NULL, NULL, 10, 0.0, 0),
(7, 'iPhone 17 Pro Max', 'Apple', 37490000.00, 'https://cdn.hoanghamobile.vn/i/preview-h-V2/Uploads/2025/09/10/iphone-17-pro-max-cosmic-orange-pdp-image-position-1-cosmic-orange-color-vn-vi.jpg', 'iPhone 17 Pro Max được ra mắt với thiết kế nguyên khối bằng nhôm siêu nhẹ, kết hợp cùng hai mặt kính cường lực chắc chắn và khả năng chống nước chuẩn IP68, tạo nên vẻ ngoài sang trọng đồng thời đảm bảo độ bền bỉ. ', '2025-11-26 05:05:05', 'Phones', '256GB', '8GB', 10, 0.0, 0),
(8, 'Samsung Galaxy Z Fold 6', 'Samsung', 44990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/s/a/samsung-galaxy-z-fold-6-xanh_5__1.png?_gl=1*1tiyek*_gcl_aw*R0NMLjE3NjQxMzQxNzIuQ2owS0NRaUF4SlhKQmhEX0FSSXNBSF9KR2poWGpjR2lXaTFWOHlUeUgweUN1WWFZRDhyS0E0N0ZEaVFXc3FLRG9DY3E3MW1PN0txd1FSY2FBdlRRRUFMd', 'Màn hình Dynamic AMOLED 2X 7.6 inch, Snapdragon 8 Gen 3, Camera 50MP với AI nâng cấp, pin 4400mAh, hỗ trợ S Pen.', '2025-11-26 05:13:46', 'Phones', '512GB', '12GB', 14, 0.0, 0),
(9, 'iPhone 16 Pro', 'Apple', 29990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/i/p/iphone-16-pro_1.png', 'Chip A18 Pro, camera 48MP với telephoto 5x, màn hình ProMotion 120Hz, titan thiết kế, iOS 18.', '2025-11-26 05:13:46', 'Phones', '256GB', '8GB', 17, 0.0, 0),
(11, 'OPPO Find X7 Pro', 'Oppo', 22990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/o/p/oppo-find-x7_1.png', 'Camera Hasselblad 50MP, chip Dimensity 9300, màn hình AMOLED 6.82 inch 120Hz, pin 5000mAh, sạc 100W.', '2025-11-26 05:13:46', 'Phones', '256GB', '12GB', 10, 0.0, 0),
(12, 'OnePlus 12', 'OnePlus', 19990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/o/n/oneplus-12.jpg', 'Snapdragon 8 Gen 3, màn hình LTPO AMOLED 6.82 inch, camera Hasselblad 50MP, sạc nhanh 100W.', '2025-11-26 05:13:46', 'Phones', '256GB', '12GB', 12, 0.0, 0),
(13, 'Vivo X100 Pro', 'Vivo', 21990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/d/i/dien-thoai-vivo-x100-pro_1_.png', 'Camera Zeiss 50MP với telephoto periscope, chip Dimensity 9300, màn hình AMOLED 6.78 inch cong, pin 5400mAh.', '2025-11-26 05:13:46', 'Phones', '512GB', '16GB', 10, 0.0, 0),
(14, 'Google Pixel 9 Pro', 'Google', 26990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/d/i/dien-thoai-google-pixel-9-pro_1_.png', 'Google Tensor G4, camera AI 50MP với Magic Editor nâng cấp, màn hình LTPO OLED 6.7 inch, Android 15.', '2025-11-26 05:13:46', 'Phones', '256GB', '12GB', 16, 0.0, 0),
(15, 'iPhone 16 Plus', 'Apple', 25990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/i/p/iphone-16-plus-1.png', 'Chip A18, màn hình Super Retina XDR 6.7 inch, camera 48MP Fusion, pin lớn nhất trong dòng iPhone 16.', '2025-11-26 05:13:46', 'Phones', '256GB', '8GB', 22, 0.0, 0),
(17, 'Xiaomi 14T Pro', 'Xiaomi', 14990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/x/i/xiaomi_14t_pro_1_.png', 'Camera Leica 50MP, chip Dimensity 9300+, màn hình AMOLED 6.67 inch 144Hz, sạc nhanh 120W.', '2025-11-26 05:13:46', 'Phones', '256GB', '12GB', 30, 0.0, 0),
(18, 'AirPods Pro 2 (USB-C)', 'Apple', 6490000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/a/i/airpods_pro_2_sep24_pdp_image_position_2__vn-vi.jpg?_gl=1*na33bz*_gcl_aw*R0NMLjE3NjQxMzQxNzIuQ2owS0NRaUF4SlhKQmhEX0FSSXNBSF9KR2poWGpjR2lXaTFWOHlUeUgweUN1WWFZRDhyS0E0N0ZEaVFXc3FLRG9DY3E3MW1PN0txd1F', 'Chip H2 nâng cấp, chống ồn chủ động ANC 2.0, âm thanh không gian, case sạc USB-C, chống nước IP54.', '2025-11-26 05:13:46', 'Audio', NULL, NULL, 50, 0.0, 0),
(19, 'Samsung Galaxy Buds3 Pro', 'Samsung', 4990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/t/a/tai-nghe-samsung-galaxy-buds-3-pro_9_.png', 'Thiết kế dạng thân, ANC thông minh, âm thanh 360 Audio, pin 30 giờ, kết nối đa điểm.', '2025-11-26 05:13:46', 'Audio', NULL, NULL, 40, 0.0, 0),
(20, 'Apple Watch Series 10', 'Apple', 10990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/t/e/text_ng_n_5__9_237.png', 'Chip S10, màn hình LTPO3 OLED lớn hơn, cảm biến sức khỏe nâng cao, pin 36 giờ, watchOS 11.', '2025-11-26 05:13:46', 'Accessories', NULL, NULL, 35, 0.0, 0),
(21, 'Samsung Galaxy Watch7', 'Samsung', 7990000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/s/m/sm-l300_002_front2_cream_240429.png', 'Chip Exynos W1000, theo dõi sức khỏe toàn diện, màn hình Super AMOLED 1.5 inch, pin 2 ngày, One UI Watch 6.', '2025-11-26 05:13:46', 'Accessories', NULL, NULL, 28, 0.0, 0),
(22, 'Xiaomi Smart Band 9 Pro', 'Xiaomi', 1290000.00, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/t/e/text_ng_n_3__6_15.png', 'Màn hình AMOLED 1.74 inch, GPS tích hợp, theo dõi 150+ môn thể thao, pin 14 ngày, chống nước 5ATM.', '2025-11-26 05:13:46', 'Accessories', NULL, NULL, 60, 0.0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `image_url` varchar(500) NOT NULL,
  `is_primary` tinyint(1) DEFAULT 0,
  `display_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `image_url`, `is_primary`, `display_order`, `created_at`) VALUES
(1, 1, 'https://cdn2.cellphones.com.vn/358x/media/catalog/product/i/p/iphone15-pro-max-1tb-titan-den.jpg', 1, 0, '2025-11-26 09:18:34'),
(2, 1, 'https://cdn2.cellphones.com.vn/insecure/rs:fill:0:358/q:90/plain/https://cellphones.com.vn/media/catalog/product/i/p/iphone-15-pro-256gb_1.png', 0, 1, '2025-11-26 09:18:34'),
(3, 1, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/i/p/iphone-15-pro-max_8__4.jpg?_gl=1*183jbsi*_gcl_aw*R0NMLjE3NjQxMzQxNzIuQ2owS0NRaUF4SlhKQmhEX0FSSXNBSF9KR2poWGpjR2lXaTFWOHlUeUgweUN1WWFZRDhyS0E0N0ZEaVFXc3FLRG9DY3E3MW1PN0txd1FSY2FBdlRRRUFMd193Y0I.*_gcl_au*NTUxNjk1NjQxLjE3NjQwOTg5MTE.*_ga*MTgzMTg3ODc2NC4xNzU2MTQzMzMz*_ga_QLK8WFHNK9*czE3NjQxNDY3ODMkbzEzJGcxJHQxNzY0MTQ4NjM3JGo2MCRsMCRoNzEzMzYwNTM0', 0, 2, '2025-11-26 09:18:34'),
(4, 1, 'https://cdn2.cellphones.com.vn/x/media/catalog/product/i/p/iphone-15-pro-max_9__4.jpg', 0, 3, '2025-11-26 09:18:34');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `customer_name` varchar(100) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review_title` varchar(200) DEFAULT NULL,
  `review_text` text DEFAULT NULL,
  `verified_purchase` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `variant_type` enum('storage','color','ram') NOT NULL,
  `variant_name` varchar(50) NOT NULL,
  `variant_value` varchar(50) DEFAULT NULL,
  `price_modifier` decimal(10,2) DEFAULT 0.00,
  `stock` int(11) DEFAULT 0,
  `is_default` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `product_variants`
--

INSERT INTO `product_variants` (`id`, `product_id`, `variant_type`, `variant_name`, `variant_value`, `price_modifier`, `stock`, `is_default`, `created_at`) VALUES
(1, 1, 'storage', '128GB', NULL, 0.00, 15, 0, '2025-11-26 09:21:48'),
(2, 1, 'storage', '256GB', NULL, 3000000.00, 20, 1, '2025-11-26 09:21:48'),
(3, 1, 'storage', '512GB', NULL, 6000000.00, 12, 0, '2025-11-26 09:21:48'),
(4, 1, 'storage', '1TB', NULL, 10000000.00, 5, 0, '2025-11-26 09:21:48'),
(5, 1, 'color', 'Titan Đen', '#2c2c2c', 0.00, 30, 0, '2025-11-26 09:22:46'),
(6, 1, 'color', 'Titan Trắng', '#f5f5f5', 0.00, 25, 0, '2025-11-26 09:22:46'),
(7, 1, 'color', 'Titan Xanh', '#4A90E2', 0.00, 20, 0, '2025-11-26 09:22:46'),
(8, 1, 'color', 'Titan Sa Mạc', '#D4AF37', 0.00, 15, 0, '2025-11-26 09:22:46');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `qna`
--

CREATE TABLE `qna` (
  `id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `is_admin`) VALUES
(1, 'admin', '123456', 'Quản trị viên', 0),
(2, 'quandepzai', '$2y$10$iZeB8zDFh0sicj4KbjHZKOQp0vRlvs.XLIScFmH.ReXODCFsEEHtC', NULL, 0),
(3, 'bebungbu', '$2y$10$P4lCxANyzN2d/.FC1cto/.Er6V4IeHId3pN2rlOGCo5z8QWilMNzS', NULL, 0),
(8, 'hotanddog', '$2y$10$Bkeajd4S/NiH1vq/ZILfpuUDkRelZwTrWIEuHKfNdFw.3YhcpC6cW', NULL, 1),
(8, 'admin3', '$2y$10$vjGnqATBVPvIHlvS7FrTZudMpFyMraBFcHuJywgBQU7dV4Q9weC9W', NULL, 1),
(9, 'Quảng ', '$2y$10$/R7laHwx5yh9G75JpY88peOQPUwqO/3kxoxJgGzf0kUBFqu/svs9S', NULL, 0);


--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `status` (`status`),
  ADD KEY `created_at` (`created_at`);

--
-- Chỉ mục cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `status` (`status`),
  ADD KEY `display_order` (`display_order`);

--
-- Chỉ mục cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`),
  ADD KEY `status` (`status`);

--
-- Chỉ mục cho bảng `post_reactions`
--
ALTER TABLE `post_reactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_reaction` (`post_id`,`user_type`,`user_email`),
  ADD KEY `post_id` (`post_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_images_product_id` (`product_id`);

--
-- Chỉ mục cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_reviews_product_id` (`product_id`),
  ADD KEY `idx_product_reviews_rating` (`rating`);

--
-- Chỉ mục cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_product_variants_product_id` (`product_id`),
  ADD KEY `idx_product_variants_type` (`variant_type`);

--
-- Chỉ mục cho bảng `qna`
--
ALTER TABLE `qna`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_categories`
--
ALTER TABLE `post_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `post_reactions`
--
ALTER TABLE `post_reactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `qna`
--
ALTER TABLE `qna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `posts_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `post_categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `post_comments`
--
ALTER TABLE `post_comments`
  ADD CONSTRAINT `post_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `post_comments_ibfk_2` FOREIGN KEY (`parent_comment_id`) REFERENCES `post_comments` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `post_reactions`
--
ALTER TABLE `post_reactions`
  ADD CONSTRAINT `post_reactions_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `product_variants`
--
ALTER TABLE `product_variants`
  ADD CONSTRAINT `product_variants_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
