<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
  
    $id = trim($_POST['id']);
    $username = htmlspecialchars(trim($_POST['username']));
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmpassword']);
    $role = 'admin'; 

    if (empty($id) || empty($username) || empty($password) || empty($confirmPassword)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    try {
        $db = new Database();
        $conn = $db->getDb();

        $query = $conn->prepare("SELECT * FROM users WHERE username = :username OR id = :id");
        $query->bindParam(':username', $username);
        $query->bindParam(':id', $id);
        $query->execute();

        if ($query->rowCount() > 0) {
            echo "<script>alert('Username or ID already exists!'); window.history.back();</script>";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO users (id, username, password, role) 
                VALUES (:id, :username, :password, :role)
            ");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':password', $password); 
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            echo "<script>alert('Admin registration successful!'); window.location.href='login.php';</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
include 'adminRegistrationhtml.php';
?>
