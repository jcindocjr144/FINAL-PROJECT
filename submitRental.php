<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guest') {
    die("Access denied");
}

$db = new Database();
$conn = $db->getDb();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    if (strtotime($start_date) >= strtotime($end_date)) {
        echo "<script>alert('End date must be after the start date.'); window.history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("SELECT driver_id FROM registrations WHERE id = :car_id AND is_for_rent = 1");
    $stmt->bindParam(':car_id', $car_id);
    $stmt->execute();
    $driver = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$driver) {
        echo "<script>alert('Selected car is not available for rent.'); window.history.back();</script>";
        exit;
    }

    $driver_id = $driver['driver_id'];
    $guest_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("
        INSERT INTO rentals (driver_id, guest_id, car_id, start_date, end_date, status)
        VALUES (:driver_id, :guest_id, :car_id, :start_date, :end_date, 'pending')
    ");
    $stmt->bindParam(':driver_id', $driver_id);
    $stmt->bindParam(':guest_id', $guest_id);
    $stmt->bindParam(':car_id', $car_id);
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);

    if ($stmt->execute()) {
        echo "<script>alert('Rental request submitted successfully!'); window.location.href = 'rentals.php';</script>";
    } else {
        echo "<script>alert('Failed to submit rental request. Please try again.'); window.history.back();</script>";
    }
}
?>
