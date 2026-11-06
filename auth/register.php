<?php
require_once 'config.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten   = trim($_POST['ho_ten']);
    $email    = trim($_POST['email']);
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $vai_tro  = $_POST['vai_tro'];
    $sdt      = trim($_POST['sdt']);

    try {
        $stmt = $conn->prepare("INSERT INTO NguoiDung (ho_ten, email, mat_khau, vai_tro, sdt) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $ho_ten, $email, $mat_khau, $vai_tro, $sdt);

        if ($stmt->execute()) {
            header("Location: login.php?msg=registered");
            exit;
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) { // 1062 là mã lỗi trùng lặp (Duplicate entry)
            $message = "Email này đã được đăng ký! Vui lòng dùng email khác hoặc chuyển sang Đăng nhập.";
        } else {
            $message = "Có lỗi xảy ra: " . $e->getMessage();
        }
    }
}

renderHeader("Đăng ký tài khoản");
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm p-4 rounded-3">
                <h4 class="fw-bold text-center mb-3">Tạo Tài Khoản Mới</h4>
                <?php if($message): ?>
                    <div class="alert alert-danger py-2 small mb-3"><?= $message ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small font-semibold">Họ và tên:</label>
                        <input type="text" name="ho_ten" class="form-control" required placeholder="Nguyễn Văn A">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small font-semibold">Email:</label>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small font-semibold">Mật khẩu:</label>
                            <input type="password" name="mat_khau" class="form-control" required placeholder="••••••••">
                        </div>
                        <div class="col-6">
                            <label class="form-label small font-semibold">Số điện thoại:</label>
                            <input type="text" name="sdt" class="form-control" placeholder="0901234567">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small font-semibold">Bạn là:</label>
                        <select name="vai_tro" class="form-select">
                            <option value="ung_vien">Ứng viên tìm việc</option>
                            <option value="nha_tuyen_dung">Nhà tuyển dụng</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-semibold mb-3">Đăng ký tài khoản</button>
                    <div class="text-center small">
                        Đã có tài khoản? <a href="login.php" class="text-decoration-none">Đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php renderFooter(); ?>