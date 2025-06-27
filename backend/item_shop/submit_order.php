<?php
ini_set('display_errors',1);
ini_set('log_errors',1);
ini_set('error_log', __DIR__.'/error_log.txt');

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if($_SERVER['REQUEST_METHOD']==='OPTIONS'){ http_response_code(200); exit; }

header("Content-Type: application/json");
require_once 'itemconnect.php';

$data = json_decode(file_get_contents('php://input'),true);

/* ---------- ตรวจฟิลด์ที่ต้องมี ---------- */
if(
  empty($data['product_id']) ||
  empty($data['full_name'])  ||
  empty($data['address'])    ||
  empty($data['phone'])
){
  http_response_code(400);
  echo json_encode(['error'=>'ข้อมูลไม่ครบ']);
  exit;
}

/* ---------- เตรียมข้อมูล ---------- */
$product_id = intval($data['product_id']);
$qty        = isset($data['qty']) ? intval($data['qty']) : 1;
$full_name  = $data['full_name'];
$address    = $data['address'];
$phone      = $data['phone'];

/* ---------- ดึงราคา/คำนวณ total ---------- */
$pq = $conn->prepare("SELECT price FROM itemshop WHERE id=?");
$pq->bind_param("i",$product_id);
$pq->execute();
$pq->bind_result($price);
if(!$pq->fetch()){  // ไม่พบสินค้า
  http_response_code(404);
  echo json_encode(['error'=>'ไม่พบสินค้า']);
  exit;
}
$pq->close();

$total = $price * $qty;

/* ---------- บันทึกออเดอร์ ---------- */
$sql = "INSERT INTO orders (product_id, qty, full_name, address, phone, total, status, created_at)
        VALUES (?,?,?,?,?,?, 'pending', NOW())";
$stmt = $conn->prepare($sql);
if(!$stmt){
  http_response_code(500);
  echo json_encode(['error'=>'prepare failed']);
  exit;
}
$stmt->bind_param("iisssd", $product_id, $qty, $full_name, $address, $phone, $total);

if($stmt->execute()){
  echo json_encode([
    'success'  => true,
    'order_id' => $stmt->insert_id,
    'total'    => $total,
    'message'  => 'สั่งซื้อสำเร็จ'
  ]);
}else{
  http_response_code(500);
  echo json_encode(['error'=>'insert failed']);
}
