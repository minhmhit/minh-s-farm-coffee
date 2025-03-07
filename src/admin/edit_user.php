<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: users.php");
    exit;
}

$user_id = $_GET['id'];
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

// Xử lý cập nhật thông tin người dùng
if (isset($_POST['update_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $password, $user_id);
    $stmt->execute();
    header("Location: users.php");
    exit;
}
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Chỉnh sửa Người dùng #<?php echo $user_id; ?></h2>

<div class="card">
    <div class="card-body">
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mật khẩu</label>
                <input type="text" class="form-control" id="password" name="password" value="<?php echo $user['password']; ?>" required>
            </div>
            <button type="submit" name="update_user" class="btn btn-primary">Cập nhật</button>
            <a href="users.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</div>
<?php include '../includes/admin_footer.php'; ?>