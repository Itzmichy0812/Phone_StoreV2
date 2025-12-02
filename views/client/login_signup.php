<?php
require_once __DIR__ . '/../../controllers/AuthController.php';
$auth = new AuthController();

// Handle form submissions
$loginError = '';
$signupError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Login
  if (isset($_POST['login_submit'])) {
      $username = $_POST['login_username']; 
      $password = $_POST['login_password'];

      unset($_SESSION['is_guest']);

      $user = $auth->login($username, $password);

      if ($user) {
          // Redirect based on role
          if ($user['is_admin'] == 1) {
              header("Location: index.php?page=admin_dashboard");
          } else {
              header("Location: index.php?page=home");
          }
          exit();
      } else {
          $loginError = "Invalid username or password.";
      }
  }

  // Guest login
  if (isset($_POST['guest_login'])) {
      unset($_SESSION['user_id']);   // ensure no real user data
      $_SESSION['is_guest'] = true;  // mark guest mode
      header("Location: index.php?page=home");
      exit();
  }


  // Signup
  if (isset($_POST['signup_submit'])) {
      $username = $_POST['signup_username'];
      $password = $_POST['signup_password'];
      $confirmPassword = $_POST['signup_confirm_password'];

      if ($password !== $confirmPassword) {
          $signupError = "Passwords do not match.";
      } else {
          $success = $auth->signup($username, $password);
          if ($success) {
              // Auto-login after signup
              $user = $auth->login($username, $password);
              if ($user) {
                  unset($_SESSION['is_guest']); // Remove guest flag
                  header("Location: index.php?page=home");
                  exit();
              }
          } else {
              $signupError = "This account already exists.";
          }
      }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login / Signup</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;800&display=swap" rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/style.css" />
</head>
<body>
  <div class="main-container">
    <div class="bg-side"></div>

    <div class="form-side">
      <!-- Toggle -->
      <div class="toggle-container text-center">
        <div class="toggle-btn active" id="login-toggle">Log In</div>
        <div class="toggle-btn" id="signup-toggle">Sign Up</div>
      </div>

      <!-- Avatar -->
      <div class="avatar"></div>

      <!-- Rounded form box -->
      <div class="form-box mx-auto">
        <!-- Login Form -->
        <form id="login-form" method="POST">
          <?php if ($loginError) : ?>
            <div class="alert alert-danger"><?= $loginError ?></div>
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="login_username" class="form-control" placeholder="Enter username" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="login_password" class="form-control" placeholder="Enter password" required />
          </div>

          <button type="submit" name="login_submit" class="btn w-100 confirm-btn mt-3">Log In</button>

          <!-- Login as guest doesnt require filling in the form -->
          <button type="submit" name="guest_login" formnovalidate class="btn w-100 btn-outline-secondary mt-2">Login as Guest</button>

        </form>

        <!-- Signup Form -->
        <form id="signup-form" class="d-none" method="POST">
          <?php if ($signupError) : ?>
            <div class="alert alert-danger"><?= $signupError ?></div>
          <?php endif; ?>
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="signup_username" class="form-control" placeholder="Enter username" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="signup_password" class="form-control" placeholder="Enter password" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="signup_confirm_password" class="form-control" placeholder="Confirm password" required />
          </div>

          <button type="submit" name="signup_submit" class="btn w-100 confirm-btn mt-3">Sign Up</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Toggle JS -->
  <script src="../assets/javascript/login_signup.js"></script>
</body>
</html>
