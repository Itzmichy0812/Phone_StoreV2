<?php
/**
 * ajax/checkout_handler.php
 * Version 2 - Step by step debugging
 */

// ✅ STEP 1: Bật error để xem (TẠM THỜI)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ✅ STEP 2: Set JSON header
header('Content-Type: application/json');

// ✅ STEP 3: Start session
session_start();

// ✅ STEP 4: Tạo response array
$response = [
    'success' => false,
    'message' => 'Unknown error',
    'debug' => []
];

try {
    // ✅ STEP 5: Log current directory
    $response['debug']['current_dir'] = __DIR__;
    $response['debug']['root_path'] = dirname(__DIR__);
    
    // ✅ STEP 6: Check if config/db.php exists
    $dbPath = dirname(__DIR__) . '/config/db.php';
    if (!file_exists($dbPath)) {
        throw new Exception("File not found: config/db.php at " . $dbPath);
    }
    $response['debug']['db_file'] = 'exists';
    
    // ✅ STEP 7: Load database
    require_once $dbPath;
    $response['debug']['db_loaded'] = true;
    
    // ✅ STEP 8: Connect to database
    $database = new Database();
    $db = $database->connect();
    
    if (!$db) {
        throw new Exception('Database connection returned null');
    }
    $response['debug']['db_connected'] = true;
    
    // ✅ STEP 9: Check if CheckoutController exists
    $controllerPath = dirname(__DIR__) . '/controllers/CheckoutController.php';
    if (!file_exists($controllerPath)) {
        throw new Exception("File not found: CheckoutController.php at " . $controllerPath);
    }
    $response['debug']['controller_file'] = 'exists';
    
    // ✅ STEP 10: Load controller
    require_once $controllerPath;
    $response['debug']['controller_loaded'] = true;
    
    // ✅ STEP 11: Get action from POST
    $action = $_POST['action'] ?? 'none';
    $response['debug']['action'] = $action;
    
    // ✅ STEP 12: Handle place_order
    if ($action === 'place_order') {
        $controller = new CheckoutController($db);
        $result = $controller->placeOrder();
        
        $response = $result; // Replace response with result
    } else {
        $response['success'] = false;
        $response['message'] = 'Invalid action: ' . $action;
    }
    
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    $response['debug']['error'] = $e->getMessage();
    $response['debug']['trace'] = $e->getTraceAsString();
}

// ✅ STEP 13: Output JSON
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
exit;
?>
