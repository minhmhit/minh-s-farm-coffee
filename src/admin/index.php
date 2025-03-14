<?php
include 'header.php';
include '../includes/db.php';

// Tổng số người dùng
$user_count = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
// Tổng số sản phẩm
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];
// Tổng số đơn hàng
$order_count = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
// Doanh thu tổng cộng
$revenue = $conn->query("SELECT SUM(total) as total FROM orders WHERE status = 'completed'")->fetch_assoc()['total'];
?>

<h2 class="text-center mb-4">Tổng quan</h2>
<div class="row">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Người dùng</h5>
                <p class="card-text"><?php echo $user_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm</h5>
                <p class="card-text"><?php echo $product_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Đơn hàng</h5>
                <p class="card-text"><?php echo $order_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h5 class="card-title">Doanh thu</h5>
                <p class="card-text"><?php echo number_format($revenue ?? 0, 0, ',', '.'); ?> VND</p>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>