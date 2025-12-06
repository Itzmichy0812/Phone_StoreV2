<?php
// Load settings helper
if (!function_exists('getSetting')) {
    require_once __DIR__ . '/../../helpers/settings_helper.php';
}
?>
<section class="contact-footer-section">
  <div class="contact-container">

    <div class="contact-grid">
      <div>
        <div class="contact-brand-name"><?php echo htmlspecialchars(getSetting('general.site_name', 'PhoneStore')); ?>.</div>
        <p class="contact-address">
          <?php echo nl2br(htmlspecialchars(getSetting('footer.about_text', 'Your trusted partner for quality phones.'))); ?>
        </p>
      </div>

      <div>
        <div class="contact-column-title">Links</div>
        <ul class="contact-link-list">
          <li><a class="contact-link" href="index.php?page=home">Home</a></li>
          
          <li><a class="contact-link" href="index.php?page=shop">Shop</a></li>
          
          <li><a class="contact-link" href="index.php?page=about">About</a></li>
          
          <li><a class="contact-link" href="index.php?page=contact">Contact</a></li>
        </ul>
      </div>

      <div>
        <div class="contact-column-title">Help</div>
        <ul class="contact-link-list">
          <li><a class="contact-link" href="index.php?page=qna">Payment Options</a></li>
          <li><a class="contact-link" href="index.php?page=qna">Returns</a></li>
          <li><a class="contact-link" href="index.php?page=qna">Privacy Policies</a></li>
        </ul>
      </div>

      <div>
        <div class="contact-column-title">Follow Us</div>
        <ul class="contact-link-list">
          <?php if ($fbLink = getSetting('footer.social_facebook')): ?>
          <li><a class="contact-link" href="<?php echo htmlspecialchars($fbLink); ?>" target="_blank">Facebook</a></li>
          <?php endif; ?>
          <?php if ($igLink = getSetting('footer.social_instagram')): ?>
          <li><a class="contact-link" href="<?php echo htmlspecialchars($igLink); ?>" target="_blank">Instagram</a></li>
          <?php endif; ?>
          <?php if ($twLink = getSetting('footer.social_twitter')): ?>
          <li><a class="contact-link" href="<?php echo htmlspecialchars($twLink); ?>" target="_blank">Twitter</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </div>

    <div class="contact-bottom-line">
      <?php echo date('Y'); ?> <?php echo htmlspecialchars(getSetting('general.site_name', 'PhoneStore')); ?>. All rights reserved
    </div>

  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


<script src="assets/javascript/header.js"></script>
<script src="assets/javascript/product_detail.js"></script>
<script src="assets/javascript/cart.js"></script>



