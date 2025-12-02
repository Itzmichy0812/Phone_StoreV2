# PhoneStore – Online Phone Shop (PHP + MySQL)

Đây là project web bán điện thoại **PhoneStore** xây dựng bằng **PHP thuần** (MVC đơn giản), **MySQL**, **Bootstrap 5** và JavaScript.

Project gồm các chức năng chính:

- Trang Home.
- Xem danh sách sản phẩm, lọc, thêm vào giỏ hàng.
- Đăng ký / đăng nhập người dùng, phân quyền admin.
- Trang Q&A, About, Contact (gửi form liên hệ).
- Trang quản trị (admin) quản lý sản phẩm / nội dung.

---

## 1. Yêu cầu hệ thống

- **PHP** >= 8.0  
  - Kiểm tra: `php -v`
- **MySQL** (hoặc MariaDB)
- Một web server:
  - PHP built-in server (`php -S`) **hoặc**
  - XAMPP / MAMP / WAMP

> Hướng dẫn bên dưới giả sử tên folder là `Phone_Store_Web_dev`. Nếu bạn đổi tên khác, chỉ cần thay đúng tên folder trong đường dẫn.

---

## 2. Clone / copy project

Đặt toàn bộ folder project vào nơi bạn muốn làm việc, ví dụ:

```bash
~/Projects/Phone_Store_Web_dev
```

## Cấu trúc chính:

Phone_Store_Web_dev/
├── ajax/
├── assets/
│   ├── css/
│   ├── img/
│   └── javascript/
├── config/
│   └── db.php
├── controllers/
├── helpers/
├── models/
├── views/
│   ├── admin/
│   ├── client/
│   └── layouts/   (header.php, footer.php, ...)
├── index.php       (front controller)
├── phone_shop.sql  (file database)
└── README.md

## 3. Tạo database

1. Mở phpMyAdmin (nếu dùng XAMPP) hoặc dùng MySQL client.

2. Tạo database, ví dụ tên:

`CREATE DATABASE phone_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`

3. Import dữ liệu từ file phone_shop.sql:

`phpMyAdmin: chọn DB phone_shop → tab Import → chọn file phone_shop.sql → Go.`

Hoặc MySQL CLI:

`mysql -u root -p phone_shop < /đường/dẫn/tới/phone_shop.sql`

## 4. Cấu hình kết nối database

1. Mở file:

config/db.php


2. Kiểm tra / chỉnh lại các thông tin sau cho đúng với máy bạn:

class Database {
    // Gợi ý: dùng 127.0.0.1 để tránh lỗi socket trên macOS
    private $host = '127.0.0.1';
    private $db_name = 'phone_shop';
    private $username = 'root';
    private $password = '';     // nếu MySQL có mật khẩu thì điền vào đây
    private $port = '3306';     // đổi nếu MySQL chạy port khác (ví dụ 3307)

    ...
}


3. Nếu bạn dùng XAMPP mặc định trên macOS/Windows:

host: 127.0.0.1 hoặc localhost

user: root

password: trống

port: 3306

## 5. Cách chạy project

Có 2 cách phổ biến:

# Cách A – Dùng PHP built-in server (nhanh, gọn)

1. Mở Terminal / Command Prompt.

Đi tới thư mục project:

`cd /đường/dẫn/tới/Phone_Store_Web_dev`


2. Chạy server:

`php -S localhost:8000`


3. Mở trình duyệt và truy cập:

Trang chính:
http://localhost:8000/index.php

Router index.php sẽ tự include các view tương ứng (page=home, page=shop, page=contact, ...).

⚠️ Đảm bảo MySQL đang chạy trước khi mở website.

# Cách B – Dùng XAMPP (Apache + MySQL)

1. Mở XAMPP:

Bật Apache và MySQL.

2. Copy folder project vào thư mục htdocs của XAMPP, ví dụ:

/Applications/XAMPP/htdocs/Phone_Store_Web_dev   (macOS)
C:\xampp\htdocs\Phone_Store_Web_dev              (Windows)


3. Mở trình duyệt:

http://localhost/Phone_Store_Web_dev/index.php
