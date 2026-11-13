<?php
require_once '../config/database.php';

$id = $_GET['id'] ?? 0;
$stmt = $conn->prepare("SELECT t.*, u.ho_ten AS ten_nha_tuyen_dung, u.email FROM TinTuyenDung t JOIN NguoiDung u ON t.id_nha_tuyen_dung = u.id WHERE t.id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$job = $stmt->get_result()->fetch_assoc();

if (!$job) { die("Tin tuyển dụng không tồn tại!"); }

$msg = '';
$msg_type = 'danger';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && getRole() === 'ung_vien') {
    $ung_vien_id = $_SESSION['user_id'];
    
    $check = $conn->prepare("SELECT id FROM HoSoUngTuyen WHERE id_ung_vien = ? AND id_tin_tuyen_dung = ?");
    $check->bind_param("ii", $ung_vien_id, $id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        $msg = "Bạn đã ứng tuyển vào vị trí này rồi!";
        $msg_type = 'warning';
    } else {
        if (isset($_FILES['cv_file']) && $_FILES['cv_file']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['cv_file']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['pdf', 'doc', 'docx'])) {
                $new_name = "CV_" . $ung_vien_id . "_" . time() . "." . $ext;
                $target = "../uploads/cvs/" . $new_name;

                if (move_uploaded_file($_FILES['cv_file']['tmp_name'], $target)) {
                    $ins = $conn->prepare("INSERT INTO HoSoUngTuyen (id_ung_vien, id_tin_tuyen_dung, duong_dan_cv) VALUES (?, ?, ?)");
                    $ins->bind_param("iis", $ung_vien_id, $id, $target);
                    $ins->execute();
                    $msg = "Ứng tuyển thành công! Nhà tuyển dụng sẽ xem xét hồ sơ của bạn.";
                    $msg_type = 'success';
                } else { $msg = "Không thể lưu file!"; }
            } else { $msg = "Định dạng file không hỗ trợ (Chỉ nhận .pdf, .doc, .docx)!"; }
        } else { $msg = "Vui lòng chọn file CV!"; }
    }
}

renderHeader(htmlspecialchars($job['tieu_de']));
?>

<div class="container py-4">
    <a href="index.php" class="btn btn-link text-decoration-none p-0 mb-3"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách</a>

    <div class="row g-4">
        <!-- Chi tiết tin đăng -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 rounded-3 mb-4">
                <h3 class="fw-bold text-primary mb-3"><?= htmlspecialchars($job['tieu_de']) ?></h3>
                <div class="d-flex flex-wrap gap-3 pb-3 border-bottom mb-4 text-muted small">
                    <div><i class="fa-solid fa-building text-primary me-1"></i> <?= htmlspecialchars($job['ten_nha_tuyen_dung']) ?></div>
                    <div><i class="fa-solid fa-location-dot text-danger me-1"></i> <?= htmlspecialchars($job['dia_diem']) ?></div>
                    <div><i class="fa-regular fa-calendar-xmark text-warning me-1"></i> Hạn nộp: <?= date('d/m/Y', strtotime($job['han_nop'])) ?></div>
                </div>

                <h5 class="fw-bold mb-2"><i class="fa-solid fa-list-check me-2 text-primary"></i>Mô tả công việc</h5>
                <p class="text-secondary mb-4"><?= nl2br(htmlspecialchars($job['mo_ta'])) ?></p>

                <h5 class="fw-bold mb-2"><i class="fa-solid fa-user-gear me-2 text-primary"></i>Yêu cầu công việc</h5>
                <p class="text-secondary mb-0"><?= nl2br(htmlspecialchars($job['yeu_cau'])) ?></p>
            </div>
        </div>

        <!-- Khung Ứng tuyển bên phải -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 rounded-3 sticky-top" style="top:90px;">
                <h5 class="fw-bold mb-3"><i class="fa-solid fa-paper-plane me-2 text-success"></i>Nộp hồ sơ ứng tuyển</h5>
                
                <?php if($msg): ?>
                    <div class="alert alert-<?= $msg_type ?> alert-dismissible fade show mb-3" role="alert">
                        <small><?= $msg ?></small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isLoggedIn()): ?>
                    <?php if (getRole() === 'ung_vien'): ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Tải CV của bạn (.pdf, .docx):</label>
                                <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                                <i class="fa-solid fa-upload me-1"></i> Gửi hồ sơ ngay
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-info mb-0 small">
                            <i class="fa-solid fa-circle-info me-1"></i> Bạn đang đăng nhập tài khoản <strong>Nhà tuyển dụng</strong> nên không thể ứng tuyển.
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p class="text-muted small mb-3">Vui lòng đăng nhập tài khoản Ứng viên để tải CV lên hệ thống.</p>
                    <a href="login.php" class="btn btn-primary w-100 fw-semibold">Đăng nhập để ứng tuyển</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php renderFooter(); ?>