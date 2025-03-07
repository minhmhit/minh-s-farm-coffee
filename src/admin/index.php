<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Lấy số lượng người dùng
$user_count = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];

// Lấy số lượng sản phẩm
$product_count = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc()['total'];

// Lấy số lượng đơn hàng
$order_count = $conn->query("SELECT COUNT(*) as total FROM orders")->fetch_assoc()['total'];
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Tổng quan Admin</h2>
<div class="row">
    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5 class="card-title">Người dùng</h5>
                <p class="card-text"><?php echo $user_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5 class="card-title">Sản phẩm</h5>
                <p class="card-text"><?php echo $product_count; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow text-center">
            <div class="card-body">
                <h5 class="card-title">Đơn hàng</h5>
                <p class="card-text"><?php echo $order_count; ?></p>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/admin_footer.php'; ?>