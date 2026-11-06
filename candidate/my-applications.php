<?php
require_once 'config.php';
if (getRole() !== 'ung_vien') { die("Không có quyền!"); }

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT h.*, t.tieu_de, u.ho_ten AS ten_cong_ty FROM HoSoUngTuyen h JOIN TinTuyenDung t ON h.id_tin_tuyen_dung = t.id JOIN NguoiDung u ON t.id_nha_tuyen_dung = u.id WHERE h.id_ung_vien = ? ORDER BY h.id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$apps = $stmt->get_result();

renderHeader("Hồ sơ đã nộp");
?>

<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="fa-solid fa-paper-plane text-primary me-2"></i>Lịch Sử Ứng Tuyển Việc Làm</h4>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Vị trí công việc</th>
                        <th>Công ty / Nhà tuyển dụng</th>
                        <th>Ngày ứng tuyển</th>
                        <th>File CV</th>
                        <th class="text-end pe-3">Trạng thái hồ sơ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($apps->num_rows > 0): ?>
                        <?php while($row = $apps->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-3 fw-semibold"><?= htmlspecialchars($row['tieu_de']) ?></td>
                            <td><i class="fa-solid fa-building text-muted me-1"></i><?= htmlspecialchars($row['ten_cong_ty']) ?></td>
                            <td class="small text-muted"><?= date('d/m/Y H:i', strtotime($row['ngay_nop'])) ?></td>
                            <td>
                                <a href="<?= $row['duong_dan_cv'] ?>" target="_blank" class="btn btn-sm btn-light border">
                                    <i class="fa-solid fa-file-pdf text-danger me-1"></i> Xem lại CV
                                </a>
                            </td>
                            <td class="text-end pe-3">
                                <?php if($row['trang_thai'] == 'Da_nop'): ?>
                                    <span class="badge bg-warning text-dark px-3 py-2"><i class="fa-solid fa-spinner me-1"></i>Đang chờ xét duyệt</span>
                                <?php elseif($row['trang_thai'] == 'Duyet'): ?>
                                    <span class="badge bg-success px-3 py-2"><i class="fa-solid fa-circle-check me-1"></i>Hồ sơ được chấp nhận / Mời PV</span>
                                <?php else: ?>
                                    <span class="badge bg-danger px-3 py-2"><i class="fa-solid fa-circle-xmark me-1"></i>Chưa phù hợp</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Bạn chưa ứng tuyển công việc nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php renderFooter(); ?>
