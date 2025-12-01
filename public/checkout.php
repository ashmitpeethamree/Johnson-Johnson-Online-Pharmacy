<?php
// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// User must be logged in
if (!isset($_SESSION['user_id'])) {
    die("ERROR: User not logged in.");
}

require_once "config.php";

$user_id = $_SESSION['user_id'];

// Fetch cart items
$sql = "SELECT 
            c.cart_id,
            c.medicine_id,
            c.quantity,
            m.name,
            m.price
        FROM cart c
        INNER JOIN medicines m ON c.medicine_id = m.medicine_id
        WHERE c.user_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL ERROR: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Convert to array
$cartItems = [];
while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
}

// If empty cart
if (empty($cartItems)) {
    echo "<h2>Your cart is empty.</h2>";
    exit;
}

// Calculate total
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

// Display cart for checkout
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>

<h2>Your Cart</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Medicine</th>
        <th>Quantity</th>
        <th>Price (Each)</th>
        <th>Total</th>
    </tr>

    <?php foreach ($cartItems as $item): ?>
        <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= $item['quantity'] ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
        </tr>
    <?php endforeach; ?>

</table>

<h3>Total Amount: Rs <?= number_format($total, 2) ?></h3>

<form action="place_order.php" method="POST">
    <button type="submit">Place Order</button>
</form>

</body>
</html>