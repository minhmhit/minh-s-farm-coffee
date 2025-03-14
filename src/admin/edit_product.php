<?php
include 'header.php';
include '../includes/db.php';

$product = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = $conn->query("SELECT * FROM products WHERE id = $id")->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $category = $_POST['category'];

    if ($product) {
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ?, stock = ?, category = ? WHERE id = ?");
        $stmt->bind_param("ssdsssi", $name, $description, $price, $image, $stock, $category, $id);
    } else {
        $stmt = $conn->prepare("INSERT INTO products (name, description, price, image, stock, category) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsss", $name, $description, $price, $image, $stock, $category);
    }

    if ($stmt->execute()) {
        header("Location: product.php");
        exit;
    } else {
        $error = "Thao tác thất bại: " . $stmt->error;
    }
}
?>

<h2 class="text-center mb-4"><?php echo $product ? 'Sửa sản phẩm' : 'Thêm sản phẩm'; ?></h2>
<div class="card">
    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($product['name'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Mô tả</label>
                <textarea class="form-control" id="description" name="description"><?php echo htmlspecialchars($product['description'] ?? ''); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Giá (VND)</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $product['price'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Hình ảnh</label>
                <input type="text" class="form-control" id="image" name="image" value="<?php echo htmlspecialchars($product['image'] ?? ''); ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Tồn kho</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product['stock'] ?? ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="category" class="form-label">Danh mục</label>
                <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($product['category'] ?? ''); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>