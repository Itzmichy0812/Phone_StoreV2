<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Manage Site Info</title>

  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<?php include 'views/layouts/header.php'; ?>

<main class="admin-page">
  <div class="admin-container">
    <h1 class="admin-title">Quản lý thông tin trang</h1>
    <p class="admin-subtitle">
      Chỉnh sửa các nội dung hiển thị trên Trang chủ và Trang liên hệ. Hiện tại form chỉ demo front-end.
    </p>

    <form class="admin-form" onsubmit="alert('Demo: dữ liệu chưa được lưu vào CSDL.'); return false;">

      <h2 class="admin-section-title">Thông tin chung</h2>

      <div class="form-row">
        <label for="siteName">Tên website / thương hiệu</label>
        <input type="text" id="siteName" name="siteName" value="PhoneStore">
      </div>
      
      <div class="form-actions">
        <button type="submit" class="btn-primary-save">Lưu thay đổi</button>
      </div>

    </form>

  </div>
</main>

</body>
</html>