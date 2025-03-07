<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

// Xử lý lọc báo cáo
$start_date = isset($_POST['start_date']) ? $_POST['start_date'] : date('Y-m-01');
$end_date = isset($_POST['end_date']) ? $_POST['end_date'] : date('Y-m-d');
$report = $conn->query("SELECT o.*, u.name as user_name FROM orders o JOIN users u ON o.user_id = u.id WHERE o.created_at BETWEEN '$start_date' AND '$end_date' AND o.status = 'delivered'");
$total_revenue = $conn->query("SELECT SUM(total) as total FROM orders WHERE created_at BETWEEN '$start_date' AND '$end_date' AND status = 'delivered'")->fetch_assoc()['total'];
?>

<?php include '../includes/admin_header.php'; ?>
<h2 class="text-center mb-4">Lập Báo cáo Doanh thu</h2>

<!-- Form lọc báo cáo -->
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Lọc theo thời gian</h5>
        <form method="post" action="">
            <div class="row">
                <div class="col-md-5">
                    <label for="start_date" class="form-label">Từ ngày</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $start_date; ?>" required>
                </div>
                <div class="col-md-5">
                    <label for="end_date" class="form-label">Đến ngày</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $end_date; ?>" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Lọc</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Tổng doanh thu</h5>
        <p class="fs-4"><?php echo number_format($total_revenue, 0, ',', '.'); ?> VND</p>
    </div>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người dùng</th>
            <th>Tổng tiền</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $report->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_name']; ?></td>
                <td><?php echo number_format($row['total'], 0, ',', '.'); ?> VND</td>
                <td><?php echo $row['status']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
<?php include '../includes/admin_footer.php'; ?>