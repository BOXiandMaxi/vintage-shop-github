<?php
session_start();
header('Access-Control-Allow-Origin: http://localhost:3000');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

include 'connect.php';

// อ่าน JSON จาก React
$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($data['email']) && !empty($data['password'])) {
    $email = $data['email'];
    $password = $data['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION["email"] = $user["email"];
            $_SESSION["firstName"] = $user["firstName"];
            $_SESSION["lastName"] = $user["lastName"];

            echo json_encode([
                "success" => true,
                "email" => $user["email"],
                "firstName" => $user["firstName"],
                "lastName" => $user["lastName"]
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Incorrect password."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "User not found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request"]);
}
?>
