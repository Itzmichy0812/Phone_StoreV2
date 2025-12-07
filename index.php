<?php
session_start();

require_once 'config/db.php';
$database = new Database();
$db = $database->connect();
if (!$db) {
    die("Database connection failed!");
}
// index.php - Router đơn giản
define('BASE_PATH', __DIR__);


require_once __DIR__ . '/controllers/AuthController.php';
$auth = new AuthController();

// Include page/function restriction
require_once __DIR__ . '/helpers/page_restriction.php';

// 1. Lấy tham số "page" từ URL, mặc định là "home"
$page = isset($_GET['page']) ? $_GET['page'] : 'home';


// 2. Định nghĩa đường dẫn tới folder chứa Views
$controllerFolder = 'controllers/';
$viewFolder = 'views/client/';
$adminFolder = 'views/admin/';

$publicPages = ['login_signup'];

$restrictedPages = ['contact'];

// 4. Force login if NOT a guest
if (!in_array($page, $publicPages)) {
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['is_guest'])) {
        header("Location: index.php?page=login_signup");
        exit();
    }
}

// Only restrict guests from certain pages
if (isset($_SESSION['is_guest']) && $_SESSION['is_guest'] === true) {
    restrictPages($restrictedPages, 'guest');
}

// 3. Điều hướng (Routing)
switch ($page) {
    // --- CLIENT SIDE ---
    case 'login_signup':
        include $viewFolder . 'login_signup.php';
        break;

    case 'home':
        include $viewFolder . 'home.php';
        break;
    
    case 'shop':
        // Gọi Controller thay vì include file trực tiếp
        require_once 'controllers/ShopController.php';
        $controller = new ShopController();
        $controller->index();
        break;

    case 'about':
        include $viewFolder . 'about.php';
        break;

    case 'contact':
        include $viewFolder . 'contact.php';
        break;

    case 'qna':
        include $viewFolder . 'qna.php';
        break;

    case 'cart':
        include $viewFolder . 'cart.php';
        break;
    
    case 'product':
        require_once $controllerFolder . 'ProductController.php';
        $controller = new ProductController();
        $controller->show();
        break;

    case 'checkout':
        require_once 'controllers/CheckoutController.php';
        $controller = new CheckoutController($db);
        $controller->index();
        break;
    
    case 'order_success':
        include 'views/client/order_success.php';
        break;

    case 'logout':
        $auth->logout(); // This will destroy the session and redirect
        break;
    
    case 'post':
        require_once 'controllers/PostController.php'; // Gọi Controller
        $controller = new PostController();
        $controller->index(); // Hàm này sẽ lấy $categories và gọi view
        break;

    case 'post_detail':
        require_once 'controllers/PostController.php';
        $controller = new PostController();
        $controller->detail();
        break;
    
    case 'profile':
        include 'views/client/profile.php';
        break;
    
    // --- ADMIN SIDE ---
    case 'admin_dashboard':
        include 'views/admin/admin_dashboard.php';
        break;
    case 'admin_reviews':
        // Gọi file Controller
        require_once 'controllers/admin/ReviewController.php';
        
        // Khởi tạo Class và chạy hàm index()
        $controller = new ReviewController();
        $controller->index();
        break;
    case 'manage_orders':
        include 'views/admin/manage_orders.php';
        break;
    case 'manage_about_info': 
        include 'views/admin/manage_about_info.php';
        break;   
    case 'manage_contacts':
        include 'views/admin/manage_contacts.php';
        break;
    case 'manage_qna':
        include 'views/admin/manage_qna.php';
        break;
    case 'manage_info':
        include 'views/admin/manage_info.php';
        break;
    case 'manage_profile':
        include 'views/admin/manage_profile.php';
        break;
    case 'manage_posts':
        // Check if user is logged in and is admin
        if (!isset($_SESSION['user_id'])) {
            header("Location: index.php?page=login_signup");
            exit();
        }
        
        // Verify user is admin
        $stmt = $db->prepare("SELECT is_admin FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        if (!$user || $user['is_admin'] != 1) {
            die("<div class='alert alert-danger container mt-5'>Access denied. Admin only.</div>");
        }
        
        include $adminFolder . $page . '.php';
        break;
    
    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header("Location: index.php?page=home");
            exit();
        }
        include $adminFolder . $page . '.php';
    case 'order_details':
         if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
            header("Location: index.php?page=home");
            exit();
        }

    if ($page == 'admin_reviews') {
        include 'controllers/admin/ReviewController.php';
    } else {
        include $adminFolder . $page . '.php';
    }
    break;

    // --- 404 ERROR ---
    default:
        echo "<h1>404 - Page Not Found</h1>";
        break;
}
?>
