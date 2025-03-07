<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Xử lý cập nhật trạng thái đơn hàng
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $status, $order_id);
    $stmt->execute();
    header("Location: orders.php");
    exit;
}

// Lấy danh sách đơn hàng
$orders = $conn->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id");
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Quản lý Đơn hàng</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($order = $orders->fetch_assoc()): ?>
            <tr>
                <td><?php echo $order['id']; ?></td>
                <td><?php echo $order['user_name']; ?></td>
                <td><?php echo number_format($order['total'], 0, ',', '.'); ?> VND</td>
                <td><?php echo $order['status']; ?></td>
                <td><?php echo $order['created_at']; ?></td>
                <td>
                    <form method="post" action="" class="d-inline">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" class="form-select d-inline w-auto">
                            <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>Pending</option>
                            <option value="processing" <?php if ($order['status'] == 'processing') echo 'selected'; ?>>Processing</option>
                            <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Shipped</option>
                            <option value="delivered" <?php if ($order['status'] == 'delivered') echo 'selected'; ?>>Delivered</option>
                            <option value="cancelled" <?php if ($order['status'] == 'cancelled') echo 'selected'; ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status" class="btn btn-sm btn-primary">Cập nhật</button>
                    </form>
                    <a href="order_details.php?id=<?php echo $order['id']; ?>" class="btn btn-sm btn-info">Xem chi tiết</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/admin_footer.php'; ?>