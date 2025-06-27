<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__.'/error_log.txt');

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){ http_response_code(200); exit; }

header("Content-Type: application/json");
require_once 'itemconnect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) { http_response_code(400); echo json_encode(['error'=>'invalid id']); exit; }

$stmt = $conn->prepare("SELECT * FROM itemshop WHERE id = ?");
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows===0){ http_response_code(404); echo json_encode(['error'=>'not found']); exit; }

$row = $res->fetch_assoc();
$row['gallery'] = $row['gallery_json'] ? json_decode($row['gallery_json'],true):[];
echo json_encode($row);
