<?php
include '../includes/db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT cart.id, products.name, products.price, cart.quantity 
        FROM cart 
        JOIN products ON cart.product_id = products.id 
        WHERE cart.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$total = 0;
?>

<?php include '../includes/header.php'; ?>
<h2 class="text-center mb-4">Giỏ hàng của bạn</h2>
<?php if ($result->num_rows > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Sản phẩm</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): 
                $subtotal = $row['price'] * $row['quantity'];
                $total += $subtotal;
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</td>
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo number_format($subtotal, 0, ',', '.'); ?> VND</td>
                </tr>
            <?php endwhile; ?>
            <tr>
                <td colspan="3" class="text-end"><strong>Tổng cộng:</strong></td>
                <td><strong><?php echo number_format($total, 0, ',', '.'); ?> VND</strong></td>
            </tr>
        </tbody>
    </table>
    <div class="text-end">
        <a href="checkout.php" class="btn btn-success">Tiến hành thanh toán</a>
    </div>
<?php else: ?>
    <p class="text-center">Giỏ hàng của bạn đang trống.</p>
<?php endif; ?>
<?php include '../includes/footer.php'; ?>