<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guest') {
    die("Access denied");
}

$db = new Database();
$conn = $db->getDb();

$userId = $_SESSION['user_id'];

$stmt = $conn->prepare("SELECT * FROM guest WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $userId);
$stmt->execute();
$guestData = $stmt->fetch(PDO::FETCH_ASSOC);

$stmtUser = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmtUser->bindParam(':user_id', $userId);
$stmtUser->execute();
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name'];
    $lastName = $_POST['last_name'];
    $contact = $_POST['contact'];
    $street = $_POST['street'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $updateGuest = $conn->prepare("UPDATE guest SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, contact = :contact, street = :street, barangay = :barangay, city = :city, province = :province, username = :username, password = :password WHERE user_id = :user_id");
    $updateGuest->bindParam(':first_name', $firstName);
    $updateGuest->bindParam(':middle_name', $middleName);
    $updateGuest->bindParam(':last_name', $lastName);
    $updateGuest->bindParam(':contact', $contact);
    $updateGuest->bindParam(':street', $street);
    $updateGuest->bindParam(':barangay', $barangay);
    $updateGuest->bindParam(':city', $city);
    $updateGuest->bindParam(':province', $province);
    $updateGuest->bindParam(':username', $username);
    $updateGuest->bindParam(':password', $password);
    $updateGuest->bindParam(':user_id', $userId);
    $updateGuest->execute();
    

    if (!empty($password)) {
        $updateUser = $conn->prepare("UPDATE users SET username = :username, password = :password WHERE id = :user_id");
        $updateUser->bindParam(':username', $username);
        $updateUser->bindParam(':password', $password);
    } else {
        $updateUser = $conn->prepare("UPDATE users SET username = :username WHERE id = :user_id");
        $updateUser->bindParam(':username', $username);
    }
    $updateUser->bindParam(':user_id', $userId);
    $updateUser->execute();

    header("Location: guestDashboard.php");
    exit();
}
?>