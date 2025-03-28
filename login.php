<?php
require_once 'database.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->getDb();

        if (isset($_POST['admin_login'])) {
            $password = isset($_POST['password']) ? trim($_POST['password']) : '';
            $error_message = '';
        
            if (empty($password)) {
                echo "<script>alert('Admin passcode is required!');</script>";
            } else {
                $stmt = $conn->prepare("SELECT * FROM users WHERE role = 'admin' AND password = :password");
                $stmt->bindParam(':password', $password); 
                $stmt->execute();
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        
                if ($admin) {
                    session_start();
                    $_SESSION['user_logged_in'] = true;  
                    $_SESSION['role'] = 'admin';
                    $_SESSION['user_id'] = $admin['id']; 
                    $_SESSION['username'] = $admin['username']; 
                    header('Location: adminDashboard.php');
                    exit();
                } else {
                    echo "<script>
                            alert('Invalid Admin Passcode! Please try again.');
                            window.location.href = 'login.php';
                          </script>";
                }
            }
        
        } elseif (isset($_POST['login'])) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            if (empty($username) || empty($password)) {
                echo "<script>alert('Both username and password are required!');</script>";
            } else {
                $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    session_start();
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    $_SESSION['user_logged_in'] = true; 
                    $_SESSION['role'] = $user['role']; 
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $username; 

                    if ($user['role'] == 'admin') {
                        header('Location: adminDashboard.php');
                    } elseif ($user['role'] == 'driver') {
                        header('Location: driverDashboard.php');
                    } elseif ($user['role'] == 'guest') {
                        header('Location: guestDashboard.php');
                    }
                    exit();
                } else {
                    echo "<script>
                            alert('Invalid Username or Password! Please try again.');
                            window.location.href = 'login.php';
                          </script>";
                }
            }
        }
    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
    }
}
include 'loginhtml.php';
?>
