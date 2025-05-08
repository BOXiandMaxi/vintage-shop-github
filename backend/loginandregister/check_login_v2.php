<?php
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

session_start();

if (isset($_SESSION["email"])) {
    echo json_encode([
        "status" => "ok",
        "email" => $_SESSION["email"],
        "firstName" => $_SESSION["firstName"] ?? null,
    ]);
} else {
    echo json_encode(["status" => "error"]);
}
?>
