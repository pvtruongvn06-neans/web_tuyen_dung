<?php
require_once __DIR__ . '/../includes/functions.php';

if (isLoggedIn()) {
    if (getRole() === 'nha_tuyen_dung') {
        header("Location: ../employer/dashboard.php");
    } else {
        header("Location: ../candidate/index.php");
    }
    exit;
}

$message = '';
$alertClass = 'alert-danger';

if (isset($_GET['msg']) && $_GET['msg'] === 'registered') {
    $message = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
    $alertClass = 'alert-success';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $mat_khau = $_POST['mat_khau'];

    $stmt = $conn->prepare("SELECT id, ho_ten, mat_khau, vai_tro FROM nguoidung WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($user = $res->fetch_assoc()) {
        if (password_verify($mat_khau, $user['mat_khau']) || $mat_khau === $user['mat_khau']) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['role']      = $user['vai_tro'];

            if ($user['vai_tro'] === 'nha_tuyen_dung') {
                header("Location: ../employer/dashboard.php");
            } else {
                header("Location: ../candidate/index.php");
            }
            exit;
        }
    }
    $message = "Email hoặc mật khẩu không đúng!";
    $alertClass = 'alert-danger';
}

$title = "Đăng Nhập - Jobio";
include_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-3">
                <h4 class="fw-bold text-center mb-3">Đăng Nhập</h4>
                
                <!-- Thẻ thông báo hỗ trợ hiển thị qua cả PHP lẫn AJAX -->
                <div id="auth-alert" class="alert <?= $message ? $alertClass : 'd-none' ?> py-2 small mb-3">
                    <?= htmlspecialchars($message) ?>
                </div>

                <form id="form-login" method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email:</label>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Mật khẩu:</label>
                        <input type="password" name="mat_khau" class="form-control" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold mb-3">Đăng nhập</button>
                    <div class="text-center small">
                        Chưa có tài khoản? <a href="register.php" class="text-decoration-none">Đăng ký ngay</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once __DIR__ . '/../includes/footer.php'; ?>