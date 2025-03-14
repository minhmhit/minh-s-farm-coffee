<?php
include 'header.php';
include '../includes/db.php';

if (!isset($_GET['id'])) {
    header("Location: user.php");
    exit;
}

$user_id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $address, $phone, $user_id);
    if ($stmt->execute()) {
        header("Location: user.php");
        exit;
    } else {
        $error = "Cập nhật thất bại: " . $stmt->error;
    }
}
?>

<h2 class="text-center mb-4">Sửa thông tin người dùng</h2>
<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>