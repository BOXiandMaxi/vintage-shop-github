<?php
/* ---------- เปิด error log ---------- */
ini_set('display_errors', 1);
ini_set('log_errors',    1);
ini_set('error_log', __DIR__.'/error_log.txt');

/* ---------- CORS ---------- */
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){ http_response_code(200); exit; }

header("Content-Type: application/json");

/* ---------- เชื่อม DB ---------- */
require_once 'itemconnect.php';

/* ---------- base URL ของ backend เอง ---------- */
/* สร้าง BASE_URL อัตโนมัติ */
$scheme   = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host     = $_SERVER['HTTP_HOST'];
$BASE_URL = $scheme . "://" . $host;

/* … query … */
while ($row = $result->fetch_assoc()) {

  /* เติมให้เป็น URL เต็ม */
  if (!preg_match('#^https?://#', $row['image_url'])) {
      $row['image_url'] = $BASE_URL . $row['image_url'];
  }

  /* ถ้ามีรูปใน gallery_json */
  if (!empty($row['gallery_json'])) {
      $arr = json_decode($row['gallery_json'], true) ?: [];
      foreach ($arr as &$g) {
        if (!preg_match('#^https?://#', $g)) $g = $BASE_URL . $g;
      }
      $row['gallery'] = $arr;
  } else {
      $row['gallery'] = [];
  }

  $products[] = $row;
}
echo json_encode($products);