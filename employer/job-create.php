<?php
require_once 'config.php';
if (getRole() !== 'nha_tuyen_dung') { die("Không có quyền!"); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieu_de  = trim($_POST['tieu_de']);
    $mo_ta    = trim($_POST['mo_ta']);
    $yeu_cau  = trim($_POST['yeu_cau']);
    $dia_diem = trim($_POST['dia_diem']);
    $han_nop  = $_POST['han_nop'];
    $user_id  = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO TinTuyenDung (tieu_de, mo_ta, yeu_cau, dia_diem, han_nop, id_nha_tuyen_dung) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $tieu_de, $mo_ta, $yeu_cau, $dia_diem, $han_nop, $user_id);
    
    if ($stmt->execute()) {
        header("Location: employer-dashboard.php");
        exit;
    }
}

renderHeader("Đăng tin tuyển dụng");
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 rounded-3">
                <h4 class="fw-bold mb-4"><i class="fa-solid fa-pen-to-square text-primary me-2"></i>Đăng Tin Tuyển Dụng Mới</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tiêu đề tuyển dụng:</label>
                        <input type="text" name="tieu_de" class="form-control" placeholder="Ví dụ: Lập trình viên PHP Laravel Backend" required>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Địa điểm làm việc:</label>
                            <input type="text" name="dia_diem" class="form-control" placeholder="Ví dụ: Cần Thơ / Hybrid" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Hạn nộp hồ sơ:</label>
                            <input type="date" name="han_nop" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mô tả công việc:</label>
                        <textarea name="mo_ta" class="form-control" rows="4" placeholder="Nhiệm vụ, công việc hàng ngày..." required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Yêu cầu ứng viên:</label>
                        <textarea name="yeu_cau" class="form-control" rows="4" placeholder="Kỹ năng, kinh nghiệm cần có..." required></textarea>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="employer-dashboard.php" class="btn btn-light px-4">Hủy</a>
                        <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-check me-1"></i> Đăng tin</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php renderFooter(); ?>
