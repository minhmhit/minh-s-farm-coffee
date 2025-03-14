<?php
session_start();
include '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Mật khẩu không đúng']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email không tồn tại']);
    }
}
?>