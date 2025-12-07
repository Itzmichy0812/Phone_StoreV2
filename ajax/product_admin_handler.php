<?php
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../controllers/admin/ProductAdminController.php';

$database = new Database();
$db = $database->connect();

$controller = new ProductAdminController($db);
$controller->handleAjax();
