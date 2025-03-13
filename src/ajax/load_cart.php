<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    echo '<p>Vui lòng đăng nhập để xem giỏ hàng.</p>';
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT c.id, p.name, p.price, p.image, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$total = 0;
while ($item = $result->fetch_assoc()) {
    $subtotal = $item['price'] * $item['quantity'];
    $total += $subtotal;
    echo '<div class="col-md-12 mb-3">';
    echo '<div class="card">';
    echo '<div class="row g-0">';
    echo '<div class="col-md-2">';
    echo '<img src="../assets/images/' . $item['image'] . '" class="img-fluid" alt="' . $item['name'] . '">';
    echo '</div>';
    echo '<div class="col-md-10">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . $item['name'] . '</h5>';
    echo '<p class="card-text">Đơn giá: ' . number_format($item['price'], 0, ',', '.') . ' VND</p>';
    echo '<p class="card-text">Số lượng: <input type="number" class="form-control d-inline w-25 update-quantity" data-id="' . $item['id'] . '" value="' . $item['quantity'] . '" min="1"></p>';
    echo '<p class="card-text">Thành tiền: ' . number_format($subtotal, 0, ',', '.') . ' VND</p>';
    echo '<button class="btn btn-danger remove-from-cart" data-id="' . $item['id'] . '">Xóa</button>';
    echo '</div></div></div></div></div>';
}
echo '<h4 class="text-end">Tổng tiền: ' . number_format($total, 0, ',', '.') . ' VND</h4>';
?>