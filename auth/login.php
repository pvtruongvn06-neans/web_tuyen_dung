<?php
require_once 'config.php';

$message = '';
if (isset($_GET['msg']) && $_GET['msg'] === 'registered') {
    $message = "Đăng ký tài khoản thành công! Vui lòng đăng nhập.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $mat_khau = $_POST['mat_khau'];

    $stmt = $conn->prepare("SELECT id, ho_ten, mat_khau, vai_tro FROM NguoiDung WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($user = $res->fetch_assoc()) {
        if (password_verify($mat_khau, $user['mat_khau']) || $mat_khau === $user['mat_khau']) {
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['ho_ten'];
            $_SESSION['role']      = $user['vai_tro'];
            header("Location: index.php");
            exit;
        }
    }
    $message = "Email hoặc mật khẩu không đúng!";
}

renderHeader("Đăng nhập");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-3">
                <h4 class="fw-bold text-center mb-3">Đăng Nhập</h4>
                <?php if($message): ?>
                    <div class="alert alert-info py-2 small mb-3"><?= $message ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small font-semibold">Email:</label>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small font-semibold">Mật khẩu:</label>
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

<?php renderFooter(); ?>