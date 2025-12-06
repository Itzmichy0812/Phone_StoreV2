<?php
// Load settings helper
if (!function_exists('getSetting')) {
    require_once __DIR__ . '/../../helpers/settings_helper.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars(getSetting('general.site_name', 'PhoneStore')); ?> - Contact</title>

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <?php include 'views/layouts/header.php'; ?>

  <main class="contact-page">

    <!-- HERO IMAGE + BREADCRUMB -->
    <section class="contact-hero">
      <div class="contact-hero-banner"></div>
      <div class="contact-hero-overlay">
        <div class="contact-hero-inner">
          <p class="contact-hero-label">Contact</p>
          <h1 class="contact-hero-title">Contact</h1>
          <nav class="contact-breadcrumb">
            <a href="index.php?page=home">Home</a>
            <span>›</span>
            <span>Contact</span>
          </nav>
        </div>
      </div>
    </section>

    <!-- MAIN CONTACT CONTENT -->
    <section class="contact-main-section">
      <div class="contact-container">

        <header class="contact-main-header text-center">
          <h2><?php echo htmlspecialchars(getSetting('contact.page_title', 'Get In Touch With Us')); ?></h2>
          <p>
            <?php echo htmlspecialchars(getSetting('contact.page_subtitle', 'For more information about our products & services, feel free to drop us an email. Our staff will always be there to help you out. Don\'t hesitate!')); ?>
          </p>
        </header>

        <div class="contact-main-grid">

          <!-- LEFT COLUMN: INFO -->
          <div class="contact-info-column">
            <div class="contact-info-block">
              <div class="contact-info-icon">
                <i class="bi bi-geo-alt-fill"></i>
              </div>
              <div>
                <h3 class="contact-info-title">Address</h3>
                <p class="contact-info-text">
                  <?php echo nl2br(htmlspecialchars(getSetting('contact.address', '123 Street, City'))); ?>
                </p>
              </div>
            </div>

            <div class="contact-info-block">
              <div class="contact-info-icon">
                <i class="bi bi-telephone-fill"></i>
              </div>
              <div>
                <h3 class="contact-info-title">Phone</h3>
                <p class="contact-info-text mb-1">
                  <?php echo htmlspecialchars(getSetting('contact.phone', '+84 123 456 789')); ?>
                </p>
                <p class="contact-info-text mb-1">
                  Email: <?php echo htmlspecialchars(getSetting('contact.email', 'info@phonestore.com')); ?>
                </p>
              </div>
            </div>

            <div class="contact-info-block">
              <div class="contact-info-icon">
                <i class="bi bi-clock-fill"></i>
              </div>
              <div>
                <h3 class="contact-info-title">Working Time</h3>
                <p class="contact-info-text mb-1">
                  <?php echo nl2br(htmlspecialchars(getSetting('contact.working_hours', 'Mon-Fri: 9AM - 6PM'))); ?>
                </p>
              </div>
            </div>
          </div>

          <!-- RIGHT COLUMN: FORM -->
          <div class="contact-form-column">
            <!-- TODO: xử lý submit form ở Controller/Model (lưu DB + gửi mail nếu cần) -->
            <form method="post" action="index.php?page=contact">
              <!-- COMMENT: khi xử lý backend, bạn đọc dữ liệu từ $_POST['name'], ... -->

              <div class="mb-3">
                <label for="contact_name" class="form-label">Your name</label>
                <input
                  type="text"
                  class="form-control contact-input"
                  id="contact_name"
                  name="name"
                  placeholder="Abc"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="contact_email" class="form-label">Email address</label>
                <input
                  type="email"
                  class="form-control contact-input"
                  id="contact_email"
                  name="email"
                  placeholder="abc@def.com"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="contact_subject" class="form-label">Subject</label>
                <input
                  type="text"
                  class="form-control contact-input"
                  id="contact_subject"
                  name="subject"
                  placeholder="This is optional"
                />
              </div>

              <div class="mb-4">
                <label for="contact_message" class="form-label">Message</label>
                <textarea
                  class="form-control contact-input contact-textarea"
                  id="contact_message"
                  name="message"
                  rows="4"
                  placeholder="Hi! I'd like to ask about..."
                  required
                ></textarea>
              </div>

              <button type="submit" class="contact-submit-btn">
                Submit
              </button>

            </form>
          </div>

        </div>
      </div>
    </section>

  </main>

  <?php include 'views/layouts/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
