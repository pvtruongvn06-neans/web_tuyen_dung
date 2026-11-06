<?php
require_once 'config.php';
if (getRole() !== 'nha_tuyen_dung') { die("Không có quyền truy cập!"); }

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT t.*, (SELECT COUNT(*) FROM HoSoUngTuyen WHERE id_tin_tuyen_dung = t.id) AS so_luong_hoso FROM TinTuyenDung t WHERE t.id_nha_tuyen_dung = ? ORDER BY t.id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$jobs = $stmt->get_result();

renderHeader("Quản lý tin đăng");
?>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Quản lý tin tuyển dụng</h3>
            <p class="text-muted small m-0">Danh sách các vị trí công việc bạn đang đăng tuyển</p>
        </div>
        <a href="employer-job-create.php" class="btn btn-primary"><i class="fa-solid fa-plus me-1"></i> Tạo tin mới</a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Tiêu đề tin đăng</th>
                        <th>Địa điểm</th>
                        <th>Hạn nộp</th>
                        <th class="text-center">Số hồ sơ</th>
                        <th class="text-end pe-3">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($jobs->num_rows > 0): ?>
                        <?php while($row = $jobs->fetch_assoc()): ?>
                        <tr>
                            <td class="ps-3 fw-semibold"><?= htmlspecialchars($row['tieu_de']) ?></td>
                            <td><i class="fa-solid fa-location-dot text-danger me-1"></i><?= htmlspecialchars($row['dia_diem']) ?></td>
                            <td><?= date('d/m/Y', strtotime($row['han_nop'])) ?></td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill"><?= $row['so_luong_hoso'] ?> hồ sơ</span>
                            </td>
                            <td class="text-end pe-3">
                                <a href="employer-applications.php?job_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fa-solid fa-users me-1"></i> Xem ứng viên
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">Bạn chưa đăng tin tuyển dụng nào.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php renderFooter(); ?>
