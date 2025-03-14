<?php
include 'header.php';
include '../includes/db.php';

$carts = $conn->query("SELECT c.*, u.name as user_name, p.name as product_name FROM cart c JOIN users u ON c.user_id = u.id JOIN products p ON c.product_id = p.id");
?>

<h2 class="text-center mb-4">Quản lý giỏ hàng</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Khách hàng</th>
            <th>Sản phẩm</th>
            <th>Số lượng</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($cart = $carts->fetch_assoc()): ?>
            <tr>
                <td><?php echo $cart['id']; ?></td>
                <td><?php echo htmlspecialchars($cart['user_name']); ?></td>
                <td><?php echo htmlspecialchars($cart['product_name']); ?></td>
                <td><?php echo $cart['quantity']; ?></td>
                <td>
                    <a href="?delete=<?php echo $cart['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: cart.php");
    exit;
}
?>

<?php include 'footer.php'; ?>