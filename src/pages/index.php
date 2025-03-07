<?php
session_start();
include '../includes/db.php';

$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
    $user_id = $_SESSION['user_id'];
    $product_id = $_POST['product_id'];
    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $user_id, $product_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
        $stmt->bind_param("ii", $user_id, $product_id);
    }
    $stmt->execute();
    header("Location: index.php");
    exit;
}
?>

<?php include '../includes/header.php'; ?>
<!-- Carousel -->
<div id="carouselExample" class="carousel slide mb-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="../assets/images/banner.jpg" class="d-block w-100" alt="Coffee Banner">
            <div class="carousel-caption d-none d-md-block">
                <h5>Hương vị cà phê đích thực</h5>
                <p>Đặt hàng ngay hôm nay!</p>
            </div>
        </div>
    </div>
</div>

<h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
<?php if (isset($_SESSION['user_id'])): ?>
    <p class="text-center">Chào mừng bạn đã đăng nhập! ID người dùng: <?php echo $_SESSION['user_id']; ?></p>
<?php else: ?>
    <p class="text-center">Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.</p>
<?php endif; ?>
<div class="row">
    <?php while($row = $result->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow">
                <img src="../assets/images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                    <p class="card-text"><?php echo number_format($row['price'], 0, ',', '.'); ?> VND</p>
                    <p class="card-text text-muted"><?php echo htmlspecialchars($row['description']); ?></p>
                    <form method="post" action="">
                        <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn btn-primary">Thêm vào giỏ</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php include '../includes/footer.php'; ?>