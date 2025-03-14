<?php
include 'header.php';
include '../includes/db.php';

$top_products = $conn->query("SELECT p.name, SUM(oi.quantity) as total_sold FROM order_items oi JOIN products p ON oi.product_id = p.id GROUP BY p.id ORDER BY total_sold DESC LIMIT 5");
?>

<h2 class="text-center mb-4">Báo cáo</h2>
<h5 class="mb-3">Top 5 sản phẩm bán chạy</h5>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Tên sản phẩm</th>
            <th>Số lượng bán</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($product = $top_products->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo $product['total_sold']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include 'footer.php'; ?>