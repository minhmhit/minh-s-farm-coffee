<?php
include '../includes/db.php';
include 'header.php';
if(!isset($_SESSION))
{
    session_start();
}

// Kiểm tra đăng nhập admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Xử lý cập nhật trạng thái đơn hàng trước khi xuất HTML
if (isset($_GET['update_status'])) {
    $id = $_GET['update_status'];
    $status = $_GET['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        header("Location: order.php");
        exit;
    } else {
        $error = "Cập nhật trạng thái thất bại: " . $stmt->error;
    }
}


$orders = $conn->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id");
?>

<h2 class="text-center mb-4">Quản lý đơn hàng</h2>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Tổng tiền</th>
            <th>Địa chỉ</th>
            <th>Phương thức</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                <td><?php echo number_format($order['total'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($order['address']); ?></td>
                <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                <td><?php echo htmlspecialchars($order['status']); ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td>
                    <a href="order_detail.php?id=<?php echo $order['id']; ?>" class="btn btn-info btn-sm">Chi tiết</a>
                    <?php if ($order['status'] != 'completed'): ?>
                        <a href="?update_status=<?php echo $order['id']; ?>&status=completed" class="btn btn-success btn-sm">Hoàn thành</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>