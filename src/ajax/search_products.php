<?php
include '../includes/db.php';

// Lấy tham số từ AJAX
$search = isset($_POST['search']) ? $_POST['search'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$price = isset($_POST['price']) ? $_POST['price'] : '';

// Xây dựng truy vấn SQL
$sql = "SELECT * FROM products WHERE name LIKE ?";
$params = ["%$search%"];
$types = "s";

if ($category) {
    $sql .= " AND category = ?";
    $params[] = $category;
    $types .= "s";
}
if ($price) {
    if ($price == 'low') {
        $sql .= " AND price < 100000";
    } elseif ($price == 'medium') {
        $sql .= " AND price BETWEEN 100000 AND 500000";
    } elseif ($price == 'high') {
        $sql .= " AND price > 500000";
    }
}

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($product = $result->fetch_assoc()) {
        echo '<div class="col-md-3 mb-4">';
        echo '<div class="card h-100 shadow">';
        echo '<img src="../assets/images/' . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($product['description']) . '</p>';
        echo '<p class="card-text"><strong>' . number_format($product['price'], 0, ',', '.') . ' VND</strong></p>';
        echo '<button class="btn btn-primary add-to-cart" data-id="' . $product['id'] . '">Thêm vào giỏ</button>';
        echo '</div></div></div>';
    }
} else {
    echo '<p class="text-center">Không tìm thấy sản phẩm nào.</p>';
}
?>