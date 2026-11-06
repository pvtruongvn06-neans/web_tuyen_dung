<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = ''; // Mật khẩu MySQL của bạn nếu có
$db   = 'web_tuyen_dung';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối CSDL thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getRole() {
    return $_SESSION['role'] ?? null;
}
?>