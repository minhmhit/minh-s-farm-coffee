<?php
include '../includes/db.php';

?>

<?php include '../includes/header.php'; 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
?>
<h2 class="text-center mb-4">Danh sách sản phẩm</h2>
<div class="row mb-4">
    <div class="col-md-6">
        <input type="text" id="search" class="form-control" placeholder="Tìm kiếm sản phẩm...">
    </div>
    <div class="col-md-3">
        <select id="category" class="form-select">
            <option value="">Tất cả danh mục</option>
            <option value="Cà phê">Cà phê</option>
            <option value="Trà">Trà</option>
        </select>
    </div>
    <div class="col-md-3">
        <select id="price" class="form-select">
            <option value="">Mức giá</option>
            <option value="low">Dưới 100,000 VND</option>
            <option value="medium">100,000 - 500,000 VND</option>
            <option value="high">Trên 500,000 VND</option>
        </select>
    </div>
</div>
<div id="product-list" class="row">
    <!-- Sản phẩm sẽ được load bằng AJAX -->
</div>
<?php include '../includes/indexfooter.php'; ?>