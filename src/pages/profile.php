<?php
include '../includes/db.php';
 include '../includes/header.php';
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 



// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
// Lấy thông tin người dùng từ cơ sở dữ liệu
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

// Xử lý cập nhật thông tin khi form được submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    
    // Chuẩn bị câu lệnh SQL để cập nhật thông tin
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, address = ?, phone = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $address, $phone, $user_id);
    
    // Thực thi câu lệnh và kiểm tra kết quả
    if ($stmt->execute()) {
        $_SESSION['user_name'] = $name;
        header("Location: profile.php");
        exit;
    } else {
        echo "Lỗi: " . $stmt->error;
    }
}
?>

<h2 class="text-center mb-4">Cập nhật thông tin cá nhân</h2>
<div class="card">
    <div class="card-body">
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
<?php include '../includes/indexfooter.php'; ?>