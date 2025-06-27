<?php
// เปิดแสดง error log
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

// สำหรับ CORS ให้เปิดให้กับ localhost:3000 (React) แบบนี้ก็โอเค
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD']==='OPTIONS'){ http_response_code(200); exit; }

header("Content-Type: application/json");

// ถ้าเป็น OPTIONS request (preflight request) ให้ตอบ 200 แล้วจบเลย
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once 'itemconnect.php';

// ดึงค่า category จาก query string
$category = isset($_GET['category']) ? $_GET['category'] : null;

if ($category) {
    $sql = "SELECT * FROM itemshop WHERE category = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        http_response_code(500);
        echo json_encode(['error' => 'Prepare statement failed']);
        exit();
    }
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM itemshop";
    $result = $conn->query($sql);
    if (!$result) {
        http_response_code(500);
        echo json_encode(['error' => 'Query failed']);
        exit();
    }
}

$products = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // ถ้าคอลัมน์ gallery_json เป็น JSON string ให้ decode เป็น array
        if (isset($row['gallery_json']) && $row['gallery_json'] !== null) {
            $row['gallery'] = json_decode($row['gallery_json'], true);
        } else {
            $row['gallery'] = [];
        }
        $products[] = $row;
    }
}

echo json_encode($products);
?>
