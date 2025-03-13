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
<h2 class="text-center mb-4">Thanh toán</h2>
<div id="checkout-error" class="alert alert-danger d-none"></div>
<form id="checkout-form">
    <div class="mb-3">
        <label for="address" class="form-label">Địa chỉ giao hàng</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="mb-3">
        <label for="payment_method" class="form-label">Phương thức thanh toán</label>
        <select class="form-select" id="payment_method" name="payment_method" required>
            <option value="credit_card">Thẻ tín dụng</option>
            <option value="paypal">PayPal</option>
            <option value="cash_on_delivery">Thanh toán khi nhận hàng</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Đặt hàng</button>
</form>
<?php include '../includes/footer.php'; ?>