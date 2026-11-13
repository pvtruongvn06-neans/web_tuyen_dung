<?php
require_once 'config.php';
if (getRole() !== 'nha_tuyen_dung') { die("Không có quyền!"); }

if (isset($_POST['app_id']) && isset($_POST['trang_thai'])) {
    $up = $conn->prepare("UPDATE HoSoUngTuyen SET trang_thai = ? WHERE id = ?");
    $up->bind_param("si", $_POST['trang_thai'], $_POST['app_id']);
    $up->execute();
}

$job_id = $_GET['job_id'] ?? 0;
$stmt = $conn->prepare("SELECT h.*, u.ho_ten, u.email, u.sdt FROM HoSoUngTuyen h JOIN NguoiDung u ON h.id_ung_vien = u.id WHERE h.id_tin_tuyen_dung = ? ORDER BY h.id DESC");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$apps = $stmt->get_result();

renderHeader("Danh sách ứng viên nộp bài");
?>

<div class="container py-4">
    <a href="employer-dashboard.php" class="btn btn-link text-decoration-none p-0 mb-3"><i class="fa-solid fa-arrow-left me-1"></i> Quay lại danh sách tin</a>
    <h4 class="fw-bold mb-4">Danh sách Ứng viên Nộp Hồ Sơ</h4>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Ứng viên</th>
                        <th>Liên hệ</th>
                        <th>File CV</th>
                        <th>Ngày nộp</th>
                        <th>Trạng thái hiện tại</th>
                        <th class="text-end pe-3">Cập nhật trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($apps->num_rows > 0): ?>
                        <?php while($row = $apps->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-3 fw-semibold"><?= htmlspecialchars($row['ho_ten']) ?></td>
                            <td class="small">
                                <div><i class="fa-solid fa-envelope text-muted me-1"></i><?= htmlspecialchars($row['email']) ?></div>
                                <div><i class="fa-solid fa-phone text-muted me-1"></i><?= htmlspecialchars($row['sdt']) ?></div>
                            </td>
                            <td>
                                <a href="<?= $row['duong_dan_cv'] ?>" target="_blank" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa-solid fa-file-pdf text-danger me-1"></i> Xem CV
                                </a>
                            </td>
                            <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($row['ngay_nop'])) ?></td>
                            <td>
                                <?php if($row['trang_thai'] == 'Da_nop'): ?>
                                    <span class="badge bg-warning text-dark">Đã nhận</span>
                                <?php elseif($row['trang_thai'] == 'Duyet'): ?>
                                    <span class="badge bg-success">Đã duyệt / Mời PV</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Từ chối</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end pe-3">
                                <form method="POST" class="d-inline-flex gap-1">
                                    <input type="hidden" name="app_id" value="<?= $row['id'] ?>">
                                    <select name="trang_thai" class="form-select form-select-sm" style="width: auto;">
                                        <option value="Da_nop" <?= $row['trang_thai']=='Da_nop'?'selected':'' ?>>Đã nhận</option>
                                        <option value="Duyet" <?= $row['trang_thai']=='Duyet'?'selected':'' ?>>Đã duyệt</option>
                                        <option value="Tu_choi" <?= $row['trang_thai']=='Tu_choi'?'selected':'' ?>>Từ chối</option>
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary">Lưu</button>
                                </form>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">Chưa có ứng viên nào ứng tuyển vào vị trí này.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php renderFooter(); ?>