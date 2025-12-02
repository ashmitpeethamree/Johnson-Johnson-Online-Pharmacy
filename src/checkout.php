<?php
require_once __DIR__ . '/common.php';
require_once __DIR__ . '/config.php';

session_start();
include 'navbar.php';

if (!isset($_SESSION['user_id'])) {
    die("Not logged in");
}

$db = getPDO();

$stmt = $db->prepare("SELECT * FROM cart WHERE user_id = :uid");
$stmt->execute([':uid' => $_SESSION['user_id']]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($items)) {
    die("Cart is empty");
}

$total = 0;

foreach ($items as $item) {
    $total += $item['quantity'] * 1; // replace 1 with price if needed
}

$db->beginTransaction();

$order = $db->prepare("
    INSERT INTO orders (user_id, total_price, order_date)
    VALUES (:uid, :total, NOW())
");
$order->execute([
    ':uid' => $_SESSION['user_id'],
    ':total' => $total
]);

$order_id = $db->lastInsertId();

foreach ($items as $item) {
    $oi = $db->prepare("INSERT INTO order_items (order_id, medicine_id, quantity)
                        VALUES (:oid, :mid, :qty)");
    $oi->execute([
        ':oid' => $order_id,
        ':mid' => $item['medicine_id'],
        ':qty' => $item['quantity']
    ]);
}

$clear = $db->prepare("DELETE FROM cart WHERE user_id = :uid");
$clear->execute([':uid' => $_SESSION['user_id']]);

$db->commit();

header("Location: ../public/orders_success.html");
exit;