<?php
include 'header.php';
include '../includes/db.php';

$users = $conn->query("SELECT * FROM users");
?>

<h2 class="text-center mb-4">Quản lý người dùng</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Số điện thoại</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['address'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($user['phone'] ?? ''); ?></td>
                <td>
                    <a href="edit_user.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: user.php");
    exit;
}
?>

<?php include 'footer.php'; ?>