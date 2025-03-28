<?php
session_start();
include('database.php');

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guest') {
    die("Access denied");
}

$db = new Database();
$conn = $db->getDb();

if (!$conn) {
    die("Database connection failed.");
}

$query = "SELECT * FROM rentals WHERE guest_id = :guest_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':guest_id', $_SESSION['guest_id']);
$stmt->execute();
$rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($rentals as $row) {
    echo '<div class="rental">
            <p>Car ID: ' . htmlspecialchars($row['car_id']) . '</p>
            <p>Rental Date: ' . htmlspecialchars($row['rental_date']) . '</p>
            <p>Payment Method: ' . htmlspecialchars($row['payment_method']) . '</p>
            <p>Status: ' . htmlspecialchars($row['status']) . '</p>
          </div>';
}

$stmt = $conn->prepare("SELECT * FROM drivers");
$stmt->execute();
$drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM guest WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$guestData = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtUser = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmtUser->bindParam(':user_id', $_SESSION['user_id']);
$stmtUser->execute();
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $car_id = $_POST['car_id'];
    $driver_id = $_POST['driver_id'];
    $payment_method = $_POST['payment_method'];
    $mode_of_payment = $_POST['mode_of_payment'] ?? null;
    $amount = $_POST['amount'] ?? null;

    if ($payment_method === 'cash') {
        $query = "INSERT INTO rental (car_id, guest_id, driver_id, payment_method, mode_of_payment, amount) 
                  VALUES (:car_id, :guest_id, :driver_id, :payment_method, :mode_of_payment, :amount)";
    } else {
        $query = "INSERT INTO rental (car_id, guest_id, driver_id, payment_method, amount) 
                  VALUES (:car_id, :guest_id, :driver_id, :payment_method, :amount)";
    }

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->bindParam(':guest_id', $_SESSION['guest_id']);
    $stmt->bindParam(':driver_id', $driver_id);
    $stmt->bindParam(':payment_method', $payment_method);
    $stmt->bindParam(':amount', $amount);

    if ($payment_method === 'cash') {
        $stmt->bindParam(':mode_of_payment', $mode_of_payment);
    }

    $stmt->execute();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard</title>
    <link rel="stylesheet" href="css/client.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="images/logo.png">
    <style>
        #availableCars {
            display: none;
        }
        #profile {
            display: none;
        }
    </style>
</head>
<body></body>
<form action="processRental.php" method="POST" class="container mt-4">
    <div class="form-group">
        <label for="car_id">Car ID:</label>
        <select name="car_id" class="form-control" required>
            <?php foreach ($drivers as $driver): ?>
                <option value="<?= htmlspecialchars($driver['id']) ?>"><?= htmlspecialchars($driver['car_id']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="driver_id">Driver:</label>
        <select name="driver_id" class="form-control" required>
            <?php foreach ($drivers as $driver): ?>
                <option value="<?= htmlspecialchars($driver['id']) ?>"><?= htmlspecialchars($driver['first_name']) . ' ' . htmlspecialchars($driver['last_name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="payment_method">Payment Method:</label>
        <select name="payment_method" id="payment_method" class="form-control" required>
            <option value="credit_card">Credit Card</option>
            <option value="gcash">Gcash</option>
            <option value="cash">Cash</option>
        </select>
    </div>

    <div id="cash_fields" class="form-group" style="display: none;">
        <label for="mode_of_payment">Mode of Payment:</label>
        <select name="mode_of_payment" class="form-control" required>
            <option value="full_payment">Full Payment</option>
            <option value="installment">Installment</option>
        </select>

        <label for="amount">Amount:</label>
        <input type="number" name="amount" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100 mt-5">Rent This Car</button>
</form>

<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        var cashFields = document.getElementById('cash_fields');
        if (this.value === 'cash') {
            cashFields.style.display = 'block';
        } else {
            cashFields.style.display = 'none';
        }
    });
</script>
