<?php
include 'header.php';
include '../includes/db.php';

$products = $conn->query("SELECT * FROM products");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, stock, category) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $name, $description, $price, $image, $stock, $category);
    if ($stmt->execute()) {
        header("Location: product.php");
        exit;
    }
}
?>

<h2 class="text-center mb-4">Quản lý sản phẩm</h2>
<a href="edit_product.php" class="btn btn-success mb-3">Thêm sản phẩm</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Tồn kho</th>
            <th>Danh mục</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = $products->fetch_assoc()): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><?php echo number_format($product['price'], 0, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($product['image']); ?></td>
                <td><?php echo $product['stock']; ?></td>
                <td><?php echo htmlspecialchars($product['category']); ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xác nhận xóa?');">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: product.php");
    exit;
}
?>

<?php include 'footer.php'; ?>