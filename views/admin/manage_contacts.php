<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Manage Contacts</title>

  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

<?php include 'views/layouts/header.php'; ?>

<main class="admin-page">
  <div class="admin-container">
    <h1 class="admin-title">Quản lý liên hệ khách hàng</h1>
    <p class="admin-subtitle">
      Đây là dữ liệu demo phía front-end. Sau này bạn có thể nối với CSDL để lấy dữ liệu thật.
    </p>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>Email</th>
            <th>Nội dung</th>
            <th>Trạng thái</th>
            <th>Hành động</th>
          </tr>
        </thead>
        <tbody id="contacts-body">
          <tr>
            <td>Nguyễn Văn A</td>
            <td>nguyenvana@example.com</td>
            <td>Em muốn hỏi về giá iPhone 17…</td>
            <td>
              <select class="status-select">
                <option value="unread" selected>Chưa đọc</option>
                <option value="read">Đã đọc</option>
                <option value="replied">Đã phản hồi</option>
              </select>
            </td>
            <td>
              <button class="btn-small btn-delete">Xoá</button>
            </td>
          </tr>
          </tbody>
      </table>
    </div>

  </div>
</main>

<script>
// Script giữ nguyên vì là inline
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click', () => {
    if (confirm('Bạn có chắc muốn xoá liên hệ này?')) {
      const row = btn.closest('tr');
      row.remove();
    }
  });
});
</script>

</body>
</html>