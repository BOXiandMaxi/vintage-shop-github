<?php
session_start();
include 'connect.php';

if (isset($_POST["register"])) {
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = md5($_POST["password"]);  // เข้ารหัสด้วย md5 ก่อนบันทึก
    
    // เช็กว่ามี email นี้อยู่แล้วไหม
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check_result = $check->get_result();

    if ($check_result->num_rows > 0) {
        echo "Email already exists.";
    } else {
        $sql = "INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $password);

        if ($stmt->execute()) {
            echo "Register successful.";
            // Redirect ไปที่ index.php หลังจากสมัครเสร็จ
            header("Location: http://localhost:8000/index.php#signIn"); // ใช้ URL ของหน้า index.php
            exit();  // หยุดการทำงานหลังจาก redirect
        } else {
            echo "Register failed.";
        }
    }
}
?>
