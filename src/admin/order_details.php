<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

$order_id = $_GET['id'];
$order = $conn->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id WHERE o.id = $order_id")->fetch_assoc();
$items = $conn->query("SELECT oi.*, p.name as product_name FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = $order_id");
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Chi tiết Đơn hàng #<?php echo $order_id; ?></h2>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Thông tin đơn hàng</h5>
        <p><strong>Người dùng:</strong> <?php echo $order['user_name']; ?></p>
        <p><strong>Tổng tiền:</strong> <?php echo number_format($order['total'], 0, ',', '.'); ?> VND</p>
        <p><strong>Trạng thái:</strong> <?php echo $order['status']; ?></p>
        <p><strong>Ngày đặt:</strong> <?php echo $order['created_at']; ?></p>
    </div>
</div>

<h5 class="mb-3">Danh sách sản phẩm</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Giá</th>
            <th>Tổng</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($item = $items->fetch_assoc()): ?>
            <tr>
                <td><?php echo $item['id']; ?></td>
                <td><?php echo $item['product_name']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
                <td><?php echo number_format($item['price'], 0, ',', '.'); ?> VND</td>
                <td><?php echo number_format($item['quantity'] * $item['price'], 0, ',', '.'); ?> VND</td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<a href="orders.php" class="btn btn-secondary">Quay lại</a>
<?php include '../includes/admin_footer.php'; ?>