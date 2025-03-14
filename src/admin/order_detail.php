<?php
include 'header.php';
include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: order.php");
    exit;
}

$order_id = $_GET['id'];
$order = $conn->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = $order_id")->fetch_assoc();
$items = $conn->query("SELECT oi.*, p.name as product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id");
?>

<h2 class="text-center mb-4">Chi tiết đơn hàng #<?php echo $order_id; ?></h2>
<div class="card">
    <div class="card-body">
        <p><strong>Khách hàng:</strong> <?php echo htmlspecialchars($order['user_name']); ?></p>
        <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total'], 0, ',', '.'); ?> VND</p>
        <p><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($order['address']); ?></p>
        <p><strong>Phương thức thanh toán:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
        <p><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
        <p><strong>Ngày đặt:</strong> <?php echo $order['created_at']; ?></p>
        <h5>Sản phẩm trong đơn hàng</h5>
        <table class="table">
            <thead>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $items->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'footer.php'; ?>