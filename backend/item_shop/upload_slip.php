<?php
ini_set('display_errors',1);
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if($_SERVER['REQUEST_METHOD']==='OPTIONS'){ http_response_code(200); exit; }

require 'itemconnect.php';

$order_id = intval($_POST['order_id'] ?? 0);
$file      = $_FILES['slip'] ?? null;

if(!$order_id || !$file){
  http_response_code(400);
  echo json_encode(['error'=>'ข้อมูลไม่ครบ']); exit;
}

/* ---------- ย้ายไฟล์ ---------- */
$ext  = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
$dir  = __DIR__.'/slip_upload/';
if(!is_dir($dir)) mkdir($dir,0755);
$newName = 'slip_'.$order_id.'_'.time().'.'.$ext;
move_uploaded_file($file['tmp_name'],$dir.$newName);

/* ---------- อัปเดตคำสั่งซื้อ ---------- */
$stmt = $conn->prepare(
  "UPDATE orders SET slip_path=?, pay_status='waiting_verify' WHERE id=?"
);
$path = '/slip_upload/'.$newName;     // ไว้เสิร์ฟผ่าน php -S เช่นเดิม
$stmt->bind_param("si",$path,$order_id);
$stmt->execute();

echo json_encode(['success'=>true,'path'=>$path]);
