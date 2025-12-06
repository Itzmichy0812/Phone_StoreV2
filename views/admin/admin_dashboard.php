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
      Manage PhoneStore website content: edit page information and handle customer inquiries.
    </p>

    <div class="admin-card-grid">
      <a href="index.php?page=manage_info" class="admin-card">
        <h2>Manage Site Information</h2>
        <p>Change Home page, Contact page content, address, phone number, logo, background images...</p>
      </a>

      <a href="index.php?page=manage_contacts" class="admin-card">
        <h2>Manage Customer Contacts</h2>
        <p>View contact list, mark as read/responded, and delete unnecessary contacts.</p>
      </a>
      
      <a href="index.php?page=manage_qna" class="admin-card">
        <h2>Q&A page management</h2>
        <p>View, add, delete and edit Q&A</p>
      </a>

      <a href="index.php?page=manage_about_info" class="admin-card">
        <h2>About page management</h2>
        <p>Change page contents like background image, text...</p>
      </a>

      <a href="index.php?page=manage_posts" class="admin-card">
        <h2>Post management</h2>
        <p>Manage posts: create, edit, delete, and organize posts.</p>
      </a>

  </div>
</main>

</body>
</html>