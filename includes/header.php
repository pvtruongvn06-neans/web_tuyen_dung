<?php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? "Cổng Thông Tin Tuyển Dụng") ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .navbar-brand { font-weight: 700; color: #0d6efd !important; }
        .hero-banner { background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%); color: white; padding: 50px 0; border-radius: 0 0 20px 20px; }
        .card-job { border: none; border-radius: 12px; transition: transform 0.2s, shadow 0.2s; }
        .card-job:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important; }
        .badge-custom { padding: 6px 12px; border-radius: 20px; font-weight: 500; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php"><i class="fa-solid fa-briefcase me-2"></i>JobPortal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" href="index.php"><i class="fa-solid fa-house me-1"></i> Trang chủ</a></li>
            </ul>
            <div class="d-flex align-items-center gap-2">
                <?php if (isLoggedIn()): ?>
                    <span class="navbar-text me-2">
                        <i class="fa-regular fa-circle-user text-primary me-1"></i>
                        <strong><?= htmlspecialchars($_SESSION['user_name']) ?></strong> 
                        <span class="badge bg-secondary ms-1"><?= getRole() === 'nha_tuyen_dung' ? 'Nhà tuyển dụng' : 'Ứng viên' ?></span>
                    </span>
                    <?php if (getRole() === 'nha_tuyen_dung'): ?>
                        <a href="employer-dashboard.php" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-layer-group me-1"></i> Quản lý tin</a>
                    <?php else: ?>
                        <a href="my-applications.php" class="btn btn-outline-primary btn-sm"><i class="fa-solid fa-paper-plane me-1"></i> Hồ sơ đã nộp</a>
                    <?php endif; ?>
                    <a href="logout.php" class="btn btn-danger btn-sm"><i class="fa-solid fa-right-from-bracket"></i></a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary btn-sm me-2">Đăng nhập</a>
                    <a href="register.php" class="btn btn-primary btn-sm">Đăng ký</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
<main class="flex-grow-1"></main>