<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Coffee Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/your-kit.js"></script> <!-- Thay bằng mã Font Awesome của bạn -->
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="index.php">Admin Coffee</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Tổng quan</a></li>
                        <li class="nav-item"><a class="nav-link" href="user.php">Người dùng</a></li>
                        <li class="nav-item"><a class="nav-link" href="product.php">Sản phẩm</a></li>
                        <li class="nav-item"><a class="nav-link" href="order.php">Đơn hàng</a></li>
                        <li class="nav-item"><a class="nav-link" href="cart.php">Giỏ hàng</a></li>
                        <li class="nav-item"><a class="nav-link" href="revenue.php">Doanh thu</a></li>
                        <li class="nav-item"><a class="nav-link" href="report.php">Báo cáo</a></li>
                        <li class="nav-item"><a class="nav-link" href="login.php?logout=1">Đăng xuất</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="container my-5">