<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Lấy doanh thu theo ngày
$daily_revenue = $conn->query("SELECT DATE(created_at) as date, SUM(total) as total FROM orders WHERE status = 'delivered' GROUP BY DATE(created_at) ORDER BY date DESC");

// Lấy doanh thu theo tháng
$monthly_revenue = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as total FROM orders WHERE status = 'delivered' GROUP BY DATE_FORMAT(created_at, '%Y-%m') ORDER BY month DESC");

// Lấy tổng doanh thu
$total_revenue = $conn->query("SELECT SUM(total) as total FROM orders WHERE status = 'delivered'")->fetch_assoc()['total'];
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Quản lý Doanh thu</h2>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Tổng doanh thu</h5>
        <p class="fs-4"><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</p>
    </div>
</div>

<h5 class="mb-3">Doanh thu theo ngày</h5>
<table class="table table-striped mb-4">
    <thead>
        <tr>
            <th>Ngày</th>
            <th>Doanh thu</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $daily_revenue->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo number_format($row['total'], 0, ',', '.'); ?> VND</td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<h5 class="mb-3">Doanh thu theo tháng</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Doanh thu</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $monthly_revenue->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['month']; ?></td>
                <td><?php echo number_format($row['total'], 0, ',', '.'); ?> VND</td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/admin_footer.php'; ?>