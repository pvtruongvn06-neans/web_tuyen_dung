<?php
require_once '../config/database.php';

$search = trim($_GET['search'] ?? '');
$sql = "SELECT t.*, u.ho_ten AS ten_nha_tuyen_dung FROM TinTuyenDung t JOIN NguoiDung u ON t.id_nha_tuyen_dung = u.id";
if ($search !== '') {
    $sql .= " WHERE t.tieu_de LIKE ? OR t.dia_diem LIKE ?";
}
$sql .= " ORDER BY t.id DESC";

$stmt = $conn->prepare($sql);
if ($search !== '') {
    $param = "%$search%";
    $stmt->bind_param("ss", $param, $param);
}
$stmt->execute();
$jobs = $stmt->get_result();

renderHeader("Trang chủ - Tìm kiếm việc làm");
?>
<link rel="stylesheet" href="index.css">
<div class="hero-banner text-center mb-5">
    <div class="container">
        <h1 class="fw-bold mb-3">Tìm Kiếm Cơ Hội Việc Làm Mơ Ước</h1>
        <p class="lead mb-4">Kết nối hàng nghìn ứng viên với các nhà tuyển dụng hàng đầu</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="GET" class="card p-2 shadow-lg border-0">
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-borderless form-control" placeholder="Nhập tên vị trí, kỹ năng hoặc địa điểm..." value="<?= htmlspecialchars($search) ?>">
                        <button class="btn btn-primary px-4 rounded" type="submit">Tìm kiếm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold m-0"><i class="fa-solid fa-fire text-danger me-2"></i>Việc làm mới nhất</h4>
        <span class="text-muted">Tìm thấy <strong><?= $jobs->num_rows ?></strong> việc làm</span>
    </div>

    <div class="row g-4">
        <?php if ($jobs->num_rows > 0): ?>
            <?php while($job = $jobs->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-job h-100 shadow-sm p-3">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex align-items-center mb-3">
                                <!-- Đã thay thế inline style bằng class .company-logo -->
                                <div class="company-logo bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="fa-solid fa-building"></i>
                                </div>
                                <div>
                                    <h6 class="text-muted mb-0 small"><?= htmlspecialchars($job['ten_nha_tuyen_dung']) ?></h6>
                                    <!-- Đã thay thế inline style bằng class .job-title-truncate -->
                                    <h5 class="card-title fw-bold mb-0 text-truncate job-title-truncate">
                                        <a href="job-detail.php?id=<?= $job['id'] ?>" class="text-decoration-none text-dark"><?= htmlspecialchars($job['tieu_de']) ?></a>
                                    </h5>
                                </div>
                            </div>
                            <div class="mb-3">
                                <span class="badge bg-light text-dark border me-1"><i class="fa-solid fa-location-dot me-1 text-danger"></i><?= htmlspecialchars($job['dia_diem']) ?></span>
                                <span class="badge bg-light text-dark border"><i class="fa-solid fa-clock me-1 text-primary"></i>Hạn: <?= date('d/m/Y', strtotime($job['han_nop'])) ?></span>
                            </div>
                            <!-- Đã thay thế inline style bằng class .job-desc-truncate -->
                            <p class="card-text text-muted small flex-grow-1 job-desc-truncate">
                                <?= htmlspecialchars($job['mo_ta']) ?>
                            </p>
                            <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                                <span class="text-success small fw-semibold"><i class="fa-solid fa-circle-check me-1"></i>Đang nhận hồ sơ</span>
                                <a href="job-detail.php?id=<?= $job['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-folder-open fa-3x text-muted mb-3"></i>
                <p class="text-muted">Không tìm thấy tin tuyển dụng nào phù hợp!</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php renderFooter(); ?>