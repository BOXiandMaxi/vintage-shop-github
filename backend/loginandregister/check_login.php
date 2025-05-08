<?php
// 1. เปิด error log ลงไฟล์ แทนการแสดงผล (ป้องกันส่ง header ไม่ได้)
// ini_set('display_errors', 0); // ไม่โชว์ error บนหน้าจอ
// ini_set('log_errors', 1);
// ini_set('error_log', __DIR__ . '/error_log.txt'); // เขียน log ไปยังไฟล์

// 2. CORS ต้องมาก่อน session_start และก่อน output ใด ๆ
// header("Access-Control-Allow-Origin: http://localhost:3000");
// header("Access-Control-Allow-Credentials: true");
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");

// 3. กำหนด content type เป็น JSON
// header("Content-Type: application/json");

// 4. Preflight (OPTIONS)
// if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//     http_response_code(200);
//     exit();
// }

// 5. เริ่ม session
// error_log("🟢 check_login.php loaded");

// session_start();
// error_log("🟢 session started");

// if (isset($_SESSION["email"])) {
//     error_log("🟢 session found: " . $_SESSION["email"]);
//     echo json_encode([
//         "status" => "ok",
//         "email" => $_SESSION["email"],
//         "firstName" => $_SESSION["firstName"] ?? null,
//     ]);
// } else {
//     error_log("🔴 no session found");
//     echo json_encode(["status" => "error"]);
// }
?>
