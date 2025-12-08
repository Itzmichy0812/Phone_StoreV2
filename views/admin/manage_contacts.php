<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PhoneStore - Manage Contacts</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta10/dist/css/tabler.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>

  <?php include 'views/layouts/header.php'; ?>

  <!-- Admin Layout with Sidebar -->
  <div class="admin-layout">
    <?php include 'views/layouts/admin_sidebar.php'; ?>

    <!-- Main Content Area -->
    <main class="admin-content">
      <div class="content-header">
        <h2><i class="bi bi-envelope"></i> Manage Contacts</h2>
        <p>View and manage contact messages submitted by users.</p>
      </div>

      <div class="content-card">

      <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap" id="contactTable">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Content</th>
              <th>Created At</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
      </div>
    </main>
  </div>

  <!-- View Contact Modal -->
  <div class="modal modal-blur fade" id="viewContactModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title">Contact Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <strong>Subject:</strong>
          <p id="contactSubject"></p>

          <strong>Message:</strong>
          <p id="contactMessage"></p>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta10/dist/js/tabler.min.js"></script>
  <script src="assets/javascript/admin_manage_contacts.js"></script>
</body>
</html>
