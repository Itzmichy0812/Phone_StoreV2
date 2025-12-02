<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Admin Dashboard</title>

  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<?php include 'views/layouts/header.php'; ?>

<main class="admin-page">
  <div class="admin-container">

    <h1 class="admin-title">Admin Dashboard</h1>
    <p class="admin-subtitle">
      Quản trị nội dung website PhoneStore: chỉnh thông tin trang và quản lý liên hệ khách hàng.
    </p>

    <div class="admin-card-grid">
      <a href="index.php?page=manage_info" class="admin-card">
        <h2>Quản lý thông tin trang</h2>
        <p>Thay đổi nội dung Trang chủ, Trang liên hệ, địa chỉ, số điện thoại, logo, ảnh nền…</p>
      </a>

      <a href="index.php?page=manage_contacts" class="admin-card">
        <h2>Quản lý liên hệ khách hàng</h2>
        <p>Xem danh sách liên hệ, đánh dấu đã đọc / đã phản hồi, và xoá các liên hệ không cần thiết.</p>
      </a>
      
      <a href="index.php?page=manage_qna" class="admin-card">
        <h2>Q&A page management</h2>
        <p>View, add, delete and edit Q&A</p>
      </a>

      <a href="index.php?page=manage_about_info" class="admin-card">
        <h2>About page management</h2>
        <p>Change page contents like background image, text...</p>
      </a>

  </div>
</main>

</body>
</html>