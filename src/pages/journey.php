<?php
include '../includes/db.php';
// session_start();
?>

<?php include '../includes/header.php'; 
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
?>
<div class="container my-5 journey-section">
    <h2 class="text-center mb-4">Hành Trình Từ Cây Cà Phê Đến Sản Phẩm</h2>
    <p class="text-center mb-5">Khám phá quy trình từ khi trồng cây cà phê đến khi trở thành ly cà phê thơm ngon trên tay bạn.</p>

    <div class="row">
        <!-- Giai đoạn 1: Trồng cây -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <img src="../assets/images/j1.jpg" class="card-img-top" alt="Trồng cây cà phê">
                <div class="card-body">
                    <h5 class="card-title">1. Trồng Cây Cà Phê</h5>
                    <p class="card-text">Cây cà phê được trồng ở các vùng cao nguyên, nơi có khí hậu và đất đai lý tưởng. Quá trình này mất 3-4 năm để cây trưởng thành và ra quả.</p>
                </div>
            </div>
        </div>

        <!-- Giai đoạn 2: Thu hoạch -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
            <img src="../assets/images/j2.jpg" class="card-img-top" alt="Trồng cây cà phê">

                <div class="card-body">
                    <h5 class="card-title">2. Thu Hoạch Quả Cà Phê</h5>
                    <p class="card-text">Quả cà phê chín đỏ được thu hoạch bằng tay hoặc máy. Mỗi quả chứa hai hạt cà phê – phần quan trọng để chế biến.</p>
                </div>
            </div>
        </div>

        <!-- Giai đoạn 3: Chế biến -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
            <img src="../assets/images/j3.jpg" class="card-img-top" alt="Trồng cây cà phê">

                <div class="card-body">
                    <h5 class="card-title">3. Chế Biến Hạt Cà Phê</h5>
                    <p class="card-text">Hạt cà phê được tách khỏi quả, sau đó phơi khô hoặc rửa sạch để đạt độ ẩm hoàn hảo trước khi rang.</p>
                </div>
            </div>
        </div>

        <!-- Giai đoạn 4: Rang xay -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
            <img src="../assets/images/j4.jpg" class="card-img-top" alt="Trồng cây cà phê">

                <div class="card-body">
                    <h5 class="card-title">4. Rang Xay Cà Phê</h5>
                    <p class="card-text">Hạt cà phê được rang ở nhiệt độ cao để phát triển hương vị đặc trưng, sau đó xay thành bột mịn.</p>
                </div>
            </div>
        </div>

        <!-- Giai đoạn 5: Pha chế -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
            <img src="../assets/images/j5.jpg" class="card-img-top" alt="Trồng cây cà phê">

                <div class="card-body">
                    <h5 class="card-title">5. Pha Chế Cà Phê</h5>
                    <p class="card-text">Cà phê được pha chế theo nhiều phong cách như espresso, pour-over, hay French press, mang đến hương vị đa dạng.</p>
                </div>
            </div>
        </div>

        <!-- Giai đoạn 6: Thưởng thức -->
        <div class="col-md-4 mb-4">
            <div class="card shadow">
                <img src="../assets/images/coffee-enjoying.jpg" class="card-img-top" alt="Thưởng thức cà phê">
                <div class="card-body">
                    <h5 class="card-title">6. Thưởng Thức Cà Phê</h5>
                    <p class="card-text">Ly cà phê thơm ngon cuối cùng đến tay bạn, mang lại trải nghiệm tuyệt vời và đầy năng lượng.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include '../includes/indexfooter.php'; ?>