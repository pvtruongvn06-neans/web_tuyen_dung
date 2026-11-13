<?php
require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

function respond($status, $message, $data = null) {
    echo json_encode(['status' => $status, 'message' => $message, 'data' => $data], JSON_UNESCAPED_UNICODE);
    exit;
}

$action = $_REQUEST['action'] ?? '';

// --- AJAX ĐĂNG NHẬP NGẦM ---
if ($action === 'login') {
    $email    = trim($_POST['email'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';

    if (empty($email) || empty($mat_khau)) {
        respond(false, 'Vui lòng nhập đầy đủ Email và Mật khẩu!');
    }

    $stmt = $conn->prepare("SELECT id, ho_ten, mat_khau, vai_tro FROM NguoiDung WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($user = $res->fetch_assoc()) {
        if (password_verify($mat_khau, $user['mat_khau']) || $mat_khau === $user['mat_khau']) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['role']      = $user['vai_tro'];

            $redirect = ($user['vai_tro'] === 'nha_tuyen_dung') ? '../employer/dashboard.php' : '../candidate/index.php';
            respond(true, 'Đăng nhập thành công!', ['redirect' => $redirect]);
        }
    }
    respond(false, 'Email hoặc mật khẩu không chính xác!');
}

// --- AJAX ĐĂNG KÝ NGẦM ---
if ($action === 'register') {
    $ho_ten   = trim($_POST['ho_ten'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mat_khau = $_POST['mat_khau'] ?? '';
    $vai_tro  = $_POST['vai_tro'] ?? 'ung_vien';

    if (empty($ho_ten) || empty($email) || empty($mat_khau)) {
        respond(false, 'Vui lòng điền đầy đủ các trường thông tin!');
    }

    // Kiểm tra trùng email
    $check = $conn->prepare("SELECT id FROM NguoiDung WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        respond(false, 'Email này đã được sử dụng!');
    }

    $hashed = password_hash($mat_khau, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO NguoiDung (ho_ten, email, mat_khau, vai_tro) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ho_ten, $email, $hashed, $vai_tro);

    if ($stmt->execute()) {
        respond(true, 'Đăng ký tài khoản thành công!');
    }
    respond(false, 'Đăng ký thất bại, vui lòng thử lại!');
}