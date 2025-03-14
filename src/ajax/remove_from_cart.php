<?php
session_start();
include '../includes/db.php';

if (isset($_POST['cart_id'])) {
    $cart_id = $_POST['cart_id'];
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $cart_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Xóa thất bại']);
    }
}
?>