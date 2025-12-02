<?php include 'views/layouts/header.php'; ?>

<main class="home-page-scroll">

  <!-- FRAME 1: GREETING -->
  <section class="home-frame home-frame-1" id="home-frame-1">
    <div class="home-frame-overlay">
      <div class="home-frame-inner">
        <div class="home-greeting">
          <p class="home-greeting-subtitle">Shopping Online</p>
          <h1 class="home-greeting-title">Welcome to PhoneStore</h1>
          <p class="home-greeting-text">
            Explore the latest smartphones, accessories and exclusive deals.
            Secure checkout, fast delivery, and support whenever you need.
          </p>
          <a href="index.php?page=shop" class="home-greeting-btn">
            Start shopping
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FRAME 2: INTRODUCTION -->
  <section class="home-frame home-frame-2" id="home-frame-2">
    <div class="home2-overlay">
      <div class="home2-inner">

        <div class="home2-left">
          <div class="home2-phone-wrapper">
            <img
              src="assets/img/HomeBgEle2.png"
              alt="PhoneStore smart shopping"
              class="home2-phone-img"
            >
          </div>
        </div>

        <div class="home2-right">
          <p class="home2-subtitle">landing page</p>
          <h2 class="home2-title">All-in-one place for your next phone</h2>
          <p class="home2-text">
            PhoneStore helps you compare models, prices and specs in seconds.
            From budget-friendly devices to flagship phones, everything is
            organized so you can find the right choice without scrolling
            through endless pages.
          </p>
          <p class="home2-text">
            Track your orders in real time, save your favourites and enjoy
            secure payments designed for online shopping.
          </p>

          <button class="home2-btn" id="home2-learn-more">
            learn more
          </button>
        </div>

      </div>
    </div>
  </section>

  <!-- FRAME 3: PREMIUM PRODUCTS -->
  <section class="home-frame home-frame-3" id="home-frame-3">
    <div class="home3-overlay">
      <div class="home3-inner">
        <div class="home3-left">
          <p class="home3-subtitle">Premium line-up</p>
          <h2 class="home3-title">Newest flagship & high-end phones</h2>
          <p class="home3-text">
            Stay up to date with the latest releases from top brands:
            powerful cameras, stunning displays and all-day battery life.
            Our premium collection is updated constantly based on the
            newest trends from the market.
          </p>
          <p class="home3-text">
            Browse curated picks, compare specs side by side and discover
            the device that fits your style and performance needs.
          </p>

          <button class="home3-btn" id="home3-explore">
            explore
          </button>
        </div>
        <div class="home3-right">
          <!-- phần hình đã được xử lý trong background -->
        </div>
      </div>
    </div>
  </section>

</main>

<?php include 'views/layouts/footer.php'; ?>

<!-- Script cho Home (scroll + animation) -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Nút "learn more" (frame 2) -> scroll xuống frame 3
  const learnMoreBtn = document.getElementById('home2-learn-more');
  const frame3       = document.getElementById('home-frame-3');

  if (learnMoreBtn && frame3) {
    learnMoreBtn.addEventListener('click', () => {
      frame3.scrollIntoView({ behavior: 'smooth' });
    });
  }

  // Nút "explore" (frame 3) -> scroll lên frame 1
  const exploreBtn = document.getElementById('home3-explore');
  const frame1     = document.getElementById('home-frame-1');

  if (exploreBtn && frame1) {
    exploreBtn.addEventListener('click', () => {
      frame1.scrollIntoView({ behavior: 'smooth' });
    });
  }

  // Pop-up ảnh điện thoại frame 2 khi frame 2 vào viewport
  const phoneImg = document.querySelector('.home2-phone-img');
  const frame2   = document.getElementById('home-frame-2');

  if (phoneImg && frame2 && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          phoneImg.classList.add('in-view');
        }
      });
    }, { threshold: 0.4 });

    observer.observe(frame2);
  } else if (phoneImg) {
    // Fallback: nếu browser không hỗ trợ thì cứ hiện luôn
    phoneImg.classList.add('in-view');
  }
});
</script>
