<?php
session_start();
require_once __DIR__ . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    exit("Method not allowed");
}

$cart_id = intval($_POST['cart_id'] ?? 0);

if ($cart_id > 0) {
    $db = getPDO();
    $stmt = $db->prepare("DELETE FROM cart WHERE cart_id = :cid");
    $stmt->execute([':cid' => $cart_id]);
}

header("Location: ../public/cart.php");
exit;