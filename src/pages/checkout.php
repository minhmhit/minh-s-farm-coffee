<?php
include '../includes/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT SUM(products.price * cart.quantity) as total 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'] ?? 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($total > 0) {
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $total);
        if ($stmt->execute()) {
            $order_id = $conn->insert_id;
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) 
                                    SELECT ?, cart.product_id, cart.quantity, products.price 
                                    FROM cart 
                                    JOIN products ON cart.product_id = products.id 
                                    WHERE cart.user_id = ?");
            $stmt->bind_param("ii", $order_id, $user_id);
            $stmt->execute();
            $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $success = "Thanh toán thành công! Đơn hàng của bạn đã được ghi nhận.";
        } else {
            $error = "Lỗi: " . $conn->error;
        }
    } else {
        $error = "Giỏ hàng trống, không thể thanh toán.";
    }
}
?>

<?php include '../includes/header.php'; ?>
<h2 class="text-center mb-4">Thanh toán</h2>
<?php if (isset($success)): ?>
    <div class="alert alert-success text-center"><?php echo $success; ?></div>
<?php elseif (isset($error)): ?>
    <div class="alert alert-danger text-center"><?php echo $error; ?></div>
<?php elseif ($total > 0): ?>
    <div class="card shadow">
        <div class="card-body">
            <p class="card-text">Tổng cộng: <strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></p>
            <form method="post" action="">
                <button type="submit" class="btn btn-success w-100">Xác nhận thanh toán</button>
            </form>
        </div>
    </div>
<?php else: ?>
    <p class="text-center">Giỏ hàng trống.</p>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>