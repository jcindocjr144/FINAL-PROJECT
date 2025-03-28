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
    $unit = htmlspecialchars(trim($_POST['unit']));
    $plate_no = htmlspecialchars(trim($_POST['plate_no']));
    $body_no = htmlspecialchars(trim($_POST['body_no']));

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
        $query = $conn->prepare("SELECT * FROM registrations WHERE username = :username");
        $query->bindParam(':username', $username);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo "<script>alert('Username already exists!'); window.history.back();</script>";
        } else {
            $stmtUsers = $conn->prepare("
                INSERT INTO users (username, password, role) 
                VALUES (:username, :password, :role)
            ");
            $role = 'driver';
            $stmtUsers->bindParam(':username', $username);
            $stmtUsers->bindParam(':password', $password);
            $stmtUsers->bindParam(':role', $role);
            $stmtUsers->execute();

            $user_id = $conn->lastInsertId();

            $stmtDrivers = $conn->prepare("
                INSERT INTO drivers 
                (username, password, first_name, middle_name, last_name, contact, street, barangay, city, province, unit, plate_no, body_no) 
                VALUES 
                (:username, :password, :first_name, :middle_name, :last_name, :contact, :street, :barangay, :city, :province, :unit, :plate_no, :body_no)
            ");
            $stmtDrivers->bindParam(':username', $username);
            $stmtDrivers->bindParam(':password', $password);
            $stmtDrivers->bindParam(':first_name', $first_name);
            $stmtDrivers->bindParam(':middle_name', $middle_name);
            $stmtDrivers->bindParam(':last_name', $last_name);
            $stmtDrivers->bindParam(':contact', $contact);
            $stmtDrivers->bindParam(':street', $street);
            $stmtDrivers->bindParam(':barangay', $barangay);
            $stmtDrivers->bindParam(':city', $city);
            $stmtDrivers->bindParam(':province', $province);
            $stmtDrivers->bindParam(':unit', $unit);
            $stmtDrivers->bindParam(':plate_no', $plate_no);
            $stmtDrivers->bindParam(':body_no', $body_no);
            $stmtDrivers->execute();

            $stmtRegistrations = $conn->prepare("
                INSERT INTO registrations 
                (user_id, username, password, first_name, middle_name, last_name, contact, street, barangay, city, province, unit, plate_no, body_no) 
                VALUES 
                (:user_id, :username, :password, :first_name, :middle_name, :last_name, :contact, :street, :barangay, :city, :province, :unit, :plate_no, :body_no)
            ");
            $stmtRegistrations->bindParam(':user_id', $user_id); // Use the user_id from the users table
            $stmtRegistrations->bindParam(':username', $username);
            $stmtRegistrations->bindParam(':password', $password); 
            $stmtRegistrations->bindParam(':first_name', $first_name);
            $stmtRegistrations->bindParam(':middle_name', $middle_name);
            $stmtRegistrations->bindParam(':last_name', $last_name);
            $stmtRegistrations->bindParam(':contact', $contact);
            $stmtRegistrations->bindParam(':street', $street);
            $stmtRegistrations->bindParam(':barangay', $barangay);
            $stmtRegistrations->bindParam(':city', $city);
            $stmtRegistrations->bindParam(':province', $province);
            $stmtRegistrations->bindParam(':unit', $unit);
            $stmtRegistrations->bindParam(':plate_no', $plate_no);
            $stmtRegistrations->bindParam(':body_no', $body_no);
            $stmtRegistrations->execute();

            echo "<script>alert('Registration successful!'); window.location.href='adminDashboard.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
include 'submitRegisterhtml.php';
?>
