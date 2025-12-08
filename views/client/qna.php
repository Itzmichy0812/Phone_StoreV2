<?php
// Load settings helper
if (!function_exists('getSetting')) {
    require_once __DIR__ . '/../../helpers/settings_helper.php';
}
require_once 'controllers/QnaController.php';
$qnaController = new QnaController();
$qnaList = $qnaController->getModel()->getAll(); // Fetch all Q&A
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars(getSetting('general.site_name', 'PhoneStore')); ?> - Q&A</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="assets/css/style.css"/>
</head>

<body>

  <?php include 'views/layouts/header.php'; ?>

  <main class="qna-page-section">
    <div class="container-default">

      <h1 class="text-center mb-4">Frequently Asked Questions</h1>

      <div class="qna-list">
        <?php if (!empty($qnaList)): ?>
            <?php foreach ($qnaList as $qna): ?>
                <div class="qna-item">
                    <div class="qna-question-container">
                        <span class="qna-question"><?= htmlspecialchars($qna['question']) ?></span>
                        <span class="qna-toggle-icon">+</span>
                    </div>
                    <div class="qna-answer"><?= nl2br(htmlspecialchars($qna['answer'])) ?></div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No Q&A items available at the moment.</p>
        <?php endif; ?>
      </div>

    </div>
  </main>

  <?php include 'views/layouts/footer.php'; ?>

  <script src="assets/javascript/qna_questionbox.js"></script>

</body>
</html>
