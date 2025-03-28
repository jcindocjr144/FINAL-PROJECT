<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'driver') {
    die("Access denied");
}

$db = new Database();
$conn = $db->getDb();
$username = $_SESSION['username'];

$stmt = $conn->prepare("
   SELECT r.*, g.username AS guest_username 
FROM rental r
JOIN guest g ON r.id = g.id
WHERE r.id = (SELECT id FROM drivers WHERE username = :username)

");
$stmt->bindParam(':username', $username);
$stmt->execute();
$rental = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver rental</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<div class="container mt-5">
    <h1 class="text-center">My rental</h1>
    
    <div id="rentTable">
        <div class="container">
            <table class="table table-bordered table-sm table-hover">
                <thead>
                    <tr class="border-1 bg-success">
                        <td class="bg-transparent text-white text-center">Rented By:</td>
                        <td class="bg-transparent text-white text-center">Payment Method</td>
                        <td class="bg-transparent text-white text-center">Mode of Payment</td>
                        <td class="bg-transparent text-white text-center">Amount</td>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    if (isset($rental) && count($rental) > 0) {
                        foreach ($rental as $rental) { 
                    ?>
                        <tr class="border-1">
                            <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($rental['guest_username']); ?></td>
                            <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($rental['payment_method']); ?></td>
                            <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($rental['mode_of_payment']); ?></td>
                            <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($rental['amount']); ?></td>
                        </tr>
                    <?php }
                    } else { ?>
                        <tr>
                            <td colspan="4" class="text-center text-white">No records found</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
