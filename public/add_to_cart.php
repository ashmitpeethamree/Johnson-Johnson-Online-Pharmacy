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

$user_id     = $_SESSION['user_id'];
$medicine_id = $_POST['medicine_id'] ?? null;
$quantity    = $_POST['quantity'] ?? 1;

// Validation
if (!$medicine_id) {
    die("Invalid medicine ID.");
}

if ($quantity < 1) {
    $quantity = 1;
}

// Insert or update cart (increments quantity if already exists)
$sql = "INSERT INTO cart (user_id, medicine_id, quantity)
        VALUES (?, ?, ?)
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL ERROR: " . $conn->error);
}

$stmt->bind_param("iii", $user_id, $medicine_id, $quantity);

if ($stmt->execute()) {
    echo "ITEM_ADDED";
} else {
    echo "ERROR: " . $stmt->error;
}
?>