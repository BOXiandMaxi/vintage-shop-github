<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){ http_response_code(200); exit; }

header("Content-Type: application/json");

require 'itemconnect.php';

$data = json_decode(file_get_contents('php://input'), true);
if (!$data) { echo json_encode(['ok'=>false,'msg'=>'no data']); exit; }

$product_id = (int)$data['product_id'];
$qty        = (int)($data['qty'] ?? 1);
$name       = trim($data['full_name'] ?? '');
$addr       = trim($data['address'] ?? '');
$phone      = trim($data['phone'] ?? '');

$stmt = $conn->prepare(
  "INSERT INTO orders (product_id,qty,full_name,address,phone)
   VALUES (?,?,?,?,?)"
);
$stmt->bind_param("iisss",$product_id,$qty,$name,$addr,$phone);
$ok = $stmt->execute();

echo json_encode(['ok'=>$ok , 'order_id'=>$conn->insert_id]);
