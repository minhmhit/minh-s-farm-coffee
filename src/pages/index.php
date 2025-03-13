<?php
include '../includes/db.php';


$featured_products = $conn->query("SELECT * FROM products WHERE featured = 1 LIMIT 4");
?>

<?php include '../includes/header.php'; 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
?>
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
<div class="row">
    <?php while ($product = $featured_products->fetch_assoc()): ?>
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow">
                <img src="../assets/images/<?php echo $product['image']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['name']; ?></h5>
                    <p class="card-text"><?php echo number_format($product['price'], 0, ',', '.'); ?> VND</p>
                    <button class="btn btn-primary add-to-cart" data-id="<?php echo $product['id']; ?>">Thêm vào giỏ</button>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
<?php include '../includes/indexfooter.php'; ?>