<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Xử lý thêm sản phẩm
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $stmt = $conn->prepare("INSERT INTO products (name, price, image, description) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdss", $name, $price, $image, $description);
    $stmt->execute();
}

// Xử lý xóa sản phẩm
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Lấy danh sách sản phẩm
$products = $conn->query("SELECT * FROM products");
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Quản lý Sản phẩm</h2>

<!-- Form thêm sản phẩm -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Thêm sản phẩm mới</h5>
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="text" class="form-control" id="image" name="image" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Thêm sản phẩm</button>
        </form>
    </div>
</div>

<!-- Danh sách sản phẩm -->
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên</th>
            <th>Giá</th>
            <th>Hình ảnh</th>
            <th>Mô tả</th>
            <th>Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = $products->fetch_assoc()): ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</td>
                <td><img src="../assets/images/<?php echo $product['image']; ?>" width="50"></td>
                <td><?php echo $product['description']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-sm btn-warning">Sửa</a>
                    <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/admin_footer.php'; ?>