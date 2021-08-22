<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Credentials: true');

require_once 'controllers/ProductController.php';
require_once 'models/Database.php';
require_once 'models/Product.php';
require_once 'models/Validator.php';
require_once 'config/config.php';


$database = new Database(getDbConfig());
$db = $database->getConnection();

$q = $_GET['q'];
$params = explode('/', $q);
if ($params[0] === 'product') {
    $controller = new ProductController($db);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Не верные данные запроса."), JSON_UNESCAPED_UNICODE);
}

$type = $_SERVER['REQUEST_METHOD'];
switch ($type) {
    case 'GET':
        $controller->getItems();
        break;
    case 'POST':
        $controller->setItem();
        break;
    default:
        http_response_code(404);
        echo json_encode(array("message" => "Не верные данные запроса."), JSON_UNESCAPED_UNICODE);
}




