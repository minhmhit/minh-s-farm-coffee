<?php
include '../includes/db.php';
include '../includes/header.php'; 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 


// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Lấy thông tin đơn hàng gần nhất của người dùng (tùy chọn, để hiển thị chi tiết)
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT id, total, address, payment_method, created_at 
                        FROM orders 
                        WHERE user_id = ? 
                        ORDER BY created_at DESC 
                        LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
?>


<div class="row justify-content-center">
    <div class="col-md-6 text-center">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title">Cảm ơn bạn đã đặt hàng!</h2>
                <p class="card-text">Đơn hàng của bạn đã được đặt thành công. Chúng tôi sẽ xử lý và liên hệ với bạn trong thời gian sớm nhất.</p>
                
                <?php if ($order): ?>
                    <h4 class="mt-4">Thông tin đơn hàng</h4>
                    <p><strong>Mã đơn hàng:</strong> #<?php echo $order['id']; ?></p>
                    <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total'], 0, ',', '.'); ?> VND</p>
                    <p><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
                    <p><strong>Phương thức thanh toán:</strong> <?php echo ucfirst($order['payment_method']); ?></p>
                    <p><strong>Thời gian đặt hàng:</strong> <?php echo $order['created_at']; ?></p>
                <?php endif; ?>
                
                <a href="index.php" class="btn btn-primary mt-3">Quay về trang chủ</a>
                <a href="products.php" class="btn btn-secondary mt-3">Tiếp tục mua sắm</a>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/footer.php'; ?>