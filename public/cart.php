<?php
// -------------------------------
// DEBUG (optional while testing)
// -------------------------------
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// -------------------------------
// SESSION + DB
// -------------------------------
session_start();
require_once __DIR__ . '/../src/config/db.php';
include 'navbar.php';

// REQUIRE LOGIN
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$db = getPDO();
$user_id = $_SESSION['user_id'];

// FETCH USER CART ITEMS
$stmt = $db->prepare("
    SELECT 
        c.cart_id,
        c.quantity,
        m.medicine_id,
        m.name,
        m.price,
        m.stock
    FROM cart c
    INNER JOIN Medicines m ON c.medicine_id = m.medicine_id
    WHERE c.user_id = :uid
");
$stmt->execute([':uid' => $user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Your Cart</title>

<style>
body { font-family: Arial; padding: 20px; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
.total { font-size: 20px; font-weight: bold; margin-top: 15px; }
.btn { padding: 8px 12px; background: #007bff; color: white; border: none; cursor: pointer; }
.btn-danger { background: #d9534f; }
.btn:disabled { background: #aaa; }
</style>
</head>

<body>

<h2>Your Shopping Cart</h2>

<?php if (empty($items)): ?>
    <p>Your cart is empty.</p>
    <a href="products.php" class="btn">Continue Shopping</a>
<?php else: ?>

<table>
    <tr>
        <th>Medicine</th>
        <th>Price (Rs)</th>
        <th>Quantity</th>
        <th>Total</th>
        <th>Action</th>
    </tr>

    <?php 
    $grand_total = 0;
    foreach ($items as $item): 
        $item_total = $item['price'] * $item['quantity'];
        $grand_total += $item_total;
    ?>
    <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= number_format($item['price'], 2) ?></td>
        <td><?= $item['quantity'] ?></td>
        <td><?= number_format($item_total, 2) ?></td>
        <td>
            <form action="../src/cart_remove.php" method="post" style="display:inline;">
                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                <button class="btn-danger">Remove</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>

</table>

<p class="total">Grand Total: Rs <?= number_format($grand_total, 2) ?></p>

<a href="products.php" class="btn">Continue Shopping</a>
<a href="checkout.php" class="btn">Checkout</a>

<?php endif; ?>

</body>
</html>