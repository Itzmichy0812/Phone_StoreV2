<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Manage Q&A</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta10/dist/css/tabler.min.css" rel="stylesheet"/>

  <link rel="stylesheet" href="assets/css/style.css"/>

</head>
<body>

  <?php include 'views/layouts/header.php'; ?>

  <main class="admin-page">
    <div class="admin-container">

      <h1 class="admin-title">Manage Q&A</h1>
      <p class="admin-subtitle">
        Add, remove, or edit questions and answers shown on the Q&A page. Front-end only demo.
      </p>

      <div class="d-flex justify-content-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#qnaModal" id="addNewBtn">
          Add New Q&A
        </button>
      </div>

      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap" id="qnaTable">
          <thead>
            <tr>
              <th>#</th>
              <th>Question</th>
              <th>Answer</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            </tbody>
        </table>
      </div>

    </div>
  </main>

  <div class="modal modal-blur fade" id="qnaModal" tabindex="-1" aria-hidden="true">
    </div>

  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta10/dist/js/tabler.min.js"></script>

  <script src="assets/javascript/admin_manage_qna.js"></script>

</body>
</html>