<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Q&A</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <link rel="stylesheet" href="assets/css/style.css"/>
</head>

<body>

  <?php include 'views/layouts/header.php'; ?>

  <main class="qna-page-section">
    <div class="container-default">

      <h1 class="text-center mb-4">Frequently Asked Questions</h1>

      <div class="qna-list">

        <!-- SHIPPING / GENERAL -->
        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">What is the delivery time for my order?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            Delivery typically takes 3–5 business days for standard shipping within major cities.
            For remote areas, it may take 5–7 business days. You will receive a tracking link as
            soon as your order is shipped.
          </div>
        </div>

        <!-- PAYMENT OPTIONS -->
        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">What payment methods does PhoneStore accept?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            We currently accept credit/debit cards (Visa, MasterCard), bank transfers and selected
            e-wallets. All payments are processed through secure, encrypted payment gateways.
          </div>
        </div>

        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">Do you offer cash on delivery or installment payments?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            In some areas we support cash on delivery for selected products. Installment plans
            are available through partnered banks or finance services, depending on your card
            type. These options will be shown at checkout if they are available for your order.
          </div>
        </div>

        <!-- RETURNS -->
        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">What is your return policy?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            We offer a 30-day return policy for most phones and accessories as long as the product
            is in like-new condition with full box and accessories. Products with signs of heavy
            use or physical damage may not be eligible for a full refund.
          </div>
        </div>

        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">How do I start a return or exchange?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            You can request a return by logging into your account, going to <strong>My Orders</strong>
            and selecting the order you want to return. Choose the reason, upload photos if needed
            and submit the request. Our support team will review it and send you detailed instructions.
          </div>
        </div>

        <!-- PRIVACY / SECURITY -->
        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">Are my payment details and personal information safe?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            Yes. We use SSL encryption and work only with trusted payment partners. Your card details
            are never stored on PhoneStore’s servers – they are processed directly by the payment gateway.
          </div>
        </div>

        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">What kind of personal data does PhoneStore collect?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            We collect only the information needed to process your orders and improve our services:
            name, shipping address, contact details and order history. You can view and update your
            data at any time in your account settings. For more details, please refer to our Privacy Policy.
          </div>
        </div>

        <!-- OTHER GENERAL QUESTIONS -->
        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">Do I need an account to place an order?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            You can checkout as a guest, but we recommend creating an account so you can track orders,
            save favourite products and view your purchase history more easily.
          </div>
        </div>

        <div class="qna-item">
          <div class="qna-question-container">
            <span class="qna-question">Do the phones come with warranty?</span>
            <span class="qna-toggle-icon">+</span>
          </div>
          <div class="qna-answer">
            Yes. All phones sold on PhoneStore include official manufacturer warranty or authorized
            distributor warranty. The warranty period and conditions will be shown clearly on each
            product page.
          </div>
        </div>

      </div>
    </div>
  </main>

  <?php include 'views/layouts/footer.php'; ?>

  <script src="assets/javascript/qna_questionbox.js"></script>

</body>
</html>
