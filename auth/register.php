<?php
// 1. Nhúng file functions.php (chứa kết nối $conn, session_start, hàm dùng chung)
require_once __DIR__ . '/../includes/functions.php';

// Nếu đã đăng nhập rồi thì chuyển hướng về trang tương ứng, không cho vào lại trang đăng ký
if (isLoggedIn()) {
    if (getRole() === 'nha_tuyen_dung') {
        header("Location: ../employer/dashboard.php");
    } else {
        header("Location: ../candidate/index.php");
    }
    exit;
}

$message = '';

// 2. Xử lý khi gửi Form Đăng ký
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ho_ten   = trim($_POST['ho_ten']);
    $email    = trim($_POST['email']);
    $mat_khau = password_hash($_POST['mat_khau'], PASSWORD_BCRYPT);
    $vai_tro  = $_POST['vai_tro'];
    $sdt      = trim($_POST['sdt']);

    // Kiểm tra nghiêm ngặt: Phải đúng toàn là số và chiều dài đúng chuẩn 10 ký tự
    if (!preg_match('/^[0-9]+$/', $sdt) || strlen($sdt) !== 10) {
        $message = "Số điện thoại không hợp lệ! Vui lòng nhập đúng chính xác 10 chữ số.";
    } else {
        // Nếu hợp lệ mới tiến hành cho phép lưu vào CSDL
        try {
            $stmt = $conn->prepare("INSERT INTO nguoidung (ho_ten, email, mat_khau, vai_tro, sdt) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $ho_ten, $email, $mat_khau, $vai_tro, $sdt);

            if ($stmt->execute()) {
                header("Location: login.php?msg=registered");
                exit;
            }
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() === 1062) {
                $message = "Email này đã được đăng ký! Vui lòng dùng email khác.";
            } else {
                $message = "Có lỗi xảy ra: " . $e->getMessage();
            }
        }
    }
}

// Thiết lập tiêu đề trang và nhúng Header
$title = "Đăng Ký Tài Khoản - JobPortal";
include_once __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card border-0 shadow-sm p-4 rounded-3">
                <h4 class="fw-bold text-center mb-3">Tạo Tài Khoản Mới</h4>
                
                <?php if($message): ?>
                    <div class="alert alert-danger py-2 small mb-3"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Họ và tên:</label>
                        <input type="text" name="ho_ten" class="form-control" required placeholder="Nguyễn Văn A" value="<?= htmlspecialchars($_POST['ho_ten'] ?? '') ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">Email:</label>
                        <input type="email" name="email" class="form-control" required placeholder="name@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Mật khẩu:</label>
                            <input type="password" name="mat_khau" class="form-control" required placeholder="••••••••">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold">Số điện thoại:</label>
                            <input type="text" name="sdt" class="form-control" required placeholder="0901234567" pattern="[0-9]{10}" title="Số điện thoại phải bao gồm đúng 10 chữ số" value="<?= htmlspecialchars($_POST['sdt'] ?? '') ?>">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-semibold">Bạn là:</label>
                        <select name="vai_tro" class="form-select">
                            <option value="ung_vien" <?= (isset($_POST['vai_tro']) && $_POST['vai_tro'] === 'ung_vien') ? 'selected' : '' ?>>Ứng viên tìm việc</option>
                            <option value="nha_tuyen_dung" <?= (isset($_POST['vai_tro']) && $_POST['vai_tro'] === 'nha_tuyen_dung') ? 'selected' : '' ?>>Nhà tuyển dụng</option>
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

<?php 
// Nhúng Footer
include_once __DIR__ . '/../includes/footer.php'; 
?>