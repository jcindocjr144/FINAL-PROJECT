<?php
require_once 'database.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmpassword']);
    $first_name = htmlspecialchars(trim($_POST['first_name']));
    $middle_name = htmlspecialchars(trim($_POST['middle_name']));
    $last_name = htmlspecialchars(trim($_POST['last_name']));
    $contact = htmlspecialchars(trim($_POST['contact']));
    $street = htmlspecialchars(trim($_POST['street']));
    $barangay = htmlspecialchars(trim($_POST['barangay']));
    $city = htmlspecialchars(trim($_POST['city']));
    $province = htmlspecialchars(trim($_POST['province']));

    if (empty($username) || empty($password) || empty($confirmPassword) || empty($first_name) || empty($last_name)) {
        echo "<script>alert('All required fields must be filled!'); window.history.back();</script>";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    try {
        $db = new Database();
        $conn = $db->getDb();

        $query = $conn->prepare("SELECT * FROM guest WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo "<script>alert('Username already exists!'); window.history.back();</script>";
        } else {
            $stmtUsers = $conn->prepare("
                INSERT INTO users (username, password, role) 
                VALUES (:username, :password, :role)
            ");
            $role = 'guest';
            $stmtUsers->bindParam(':username', $username);
            $stmtUsers->bindParam(':password', $password);
            $stmtUsers->bindParam(':role', $role);
            $stmtUsers->execute();

            $user_id = $conn->lastInsertId();

            $stmtGuest = $conn->prepare("
                INSERT INTO guest 
                (user_id, username, password, first_name, middle_name, last_name, contact, street, barangay, city, province) 
                VALUES 
                (:user_id, :username, :password, :first_name, :middle_name, :last_name, :contact, :street, :barangay, :city, :province)
            ");
            $stmtGuest->bindParam(':user_id', $user_id);
            $stmtGuest->bindParam(':username', $username);
            $stmtGuest->bindParam(':password', $password);
            $stmtGuest->bindParam(':first_name', $first_name);
            $stmtGuest->bindParam(':middle_name', $middle_name);
            $stmtGuest->bindParam(':last_name', $last_name);
            $stmtGuest->bindParam(':contact', $contact);
            $stmtGuest->bindParam(':street', $street);
            $stmtGuest->bindParam(':barangay', $barangay);
            $stmtGuest->bindParam(':city', $city);
            $stmtGuest->bindParam(':province', $province);
            $stmtGuest->execute();

            echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

include 'registerhtml.php';
?>
