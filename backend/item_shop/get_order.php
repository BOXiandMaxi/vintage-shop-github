<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

require_once 'itemconnect.php';

/* ---------- รับ id ---------- */
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if(!$order_id){
  http_response_code(400);
  echo json_encode(['error'=>'no id']);
  exit;
}

/* ---------- ดึงข้อมูลคำสั่งซื้อ + ชื่อสินค้า ---------- */
$sql = "SELECT o.*, p.name AS product_name, p.image_url
        FROM orders o
        JOIN itemshop p ON p.id = o.product_id
        WHERE o.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$res = $stmt->get_result();

if($row = $res->fetch_assoc()){
  echo json_encode($row);
}else{
  http_response_code(404);
  echo json_encode(['error'=>'ไม่พบคำสั่งซื้อ']);
}
