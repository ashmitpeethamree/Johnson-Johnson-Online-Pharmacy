<?php
session_start();
require_once "../src/config/db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include "../src/templates/header.php"; ?>

<h2>My Orders</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>Order ID</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td>Rs <?= $order['total_price'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['order_date'] ?></td>
            <td><a href="order_details.php?id=<?= $order['id'] ?>">View</a></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include "../src/templates/footer.php"; ?>