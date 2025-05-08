<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST["email"];
    $password = md5($_POST["password"]);

    $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION["email"] = $user["email"];
        $_SESSION["firstName"] = $user["firstName"];
        $_SESSION["lastName"] = $user["lastName"];
        
        echo json_encode([
            "success" => true,
            "email" => $user["email"],
            "firstName" => $user["firstName"]
        ]);
        // ✅ Redirect ไปหน้า React
        header("Location: http://localhost:3000/");
        exit();
    } else {
        // แสดงข้อความ และปุ่มให้กลับไปหน้า signIn
        echo '<p>Email หรือ Password ไม่ถูกต้อง</p>';
        echo '<a href="http://localhost:8000/index.php#signIn"><button>กลับไปที่หน้าเข้าสู่ระบบ</button></a>';
    }
}
?>
