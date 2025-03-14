<?php
include 'header.php';
include '../includes/db.php';

$revenue = $conn->query("SELECT SUM(total) as total FROM orders WHERE status = 'completed'")->fetch_assoc()['total'];
$monthly_revenue = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(total) as total FROM orders WHERE status = 'completed' GROUP BY month ORDER BY month DESC");
?>

<h2 class="text-center mb-4">Doanh thu</h2>
<div class="card mb-4">
    <div class="card-body">
        <h5>Tổng doanh thu: <?php echo number_format($revenue ?? 0, 0, ',', '.'); ?> VND</h5>
    </div>
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tháng</th>
            <th>Doanh thu (VND)</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $monthly_revenue->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['month']; ?></td>
                <td><?php echo number_format($row['total'], 0, ',', '.'); ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>