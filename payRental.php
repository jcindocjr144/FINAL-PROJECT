<?php
session_start();
require_once 'Database.php';

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $rental_id = $_POST['rental_id'];
    $amount = $_POST['amount'];

    $stmt = $db->getDb()->prepare("INSERT INTO payments (rental_id, amount, payment_method, payment_date) VALUES (?, ?, 'GCASH', NOW())");
    $stmt->execute([$rental_id, $amount]);

    echo "Payment successful!";
}
?>

<form method="POST">
    <label>Rental ID: <input type="text" name="rental_id" required></label><br>
    <label>Amount: <input type="number" step="0.01" name="amount" required></label><br>
    <button type="submit">Pay with GCASH</button>
</form>
