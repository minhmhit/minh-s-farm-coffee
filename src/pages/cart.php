<?php
include '../includes/db.php';
 include '../includes/header.php'; 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<h2 class="text-center mb-4">Giỏ hàng của bạn</h2>
<div id="cart-items" class="row">
    <!-- Giỏ hàng sẽ được load bằng AJAX -->
</div>
<a href="checkout.php" class="btn btn-primary mt-3">Thanh toán</a>
<?php include '../includes/indexfooter.php'; ?>