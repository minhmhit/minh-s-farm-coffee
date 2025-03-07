<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Lấy danh sách giỏ hàng
$carts = $conn->query("SELECT c.*, u.name as user_name, p.name as product_name FROM cart c JOIN users u ON c.user_id = u.id JOIN products p ON c.product_id = p.id");
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Quản lý Giỏ hàng</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($cart = $carts->fetch_assoc()): ?>
            <tr>
                <td><?php echo $cart['id']; ?></td>
                <td><?php echo $cart['user_name']; ?></td>
                <td><?php echo $cart['product_name']; ?></td>
                <td><?php echo $cart['quantity']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/admin_footer.php'; ?>