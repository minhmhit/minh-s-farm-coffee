<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Vui lòng đăng nhập']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $address = $_POST['address'];
    $payment_method = $_POST['payment_method'];

    // Tính tổng tiền
    $sql = "SELECT SUM(p.price * c.quantity) as total 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $total = $stmt->get_result()->fetch_assoc()['total'];

    // Thêm đơn hàng
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total, address, payment_method, status) VALUES (?, ?, ?, ?, 'pending')");
    $stmt->bind_param("idss", $user_id, $total, $address, $payment_method);
    $stmt->execute();
    $order_id = $stmt->insert_id;

    // Thêm chi tiết đơn hàng
    $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
            SELECT ?, c.product_id, c.quantity, p.price 
            FROM cart c 
            JOIN products p ON c.product_id = p.id 
            WHERE c.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();

    // Xóa giỏ hàng
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo json_encode(['status' => 'success', 'message' => 'Đặt hàng thành công']);
}
?>