<?php 
require_once 'Database.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {     
    if (isset($_POST['username']) && isset($_POST['password'])) {         
        $username = htmlspecialchars($_POST['username']);         
        $password = $_POST['password'];          

        $db = new Database();         
        $conn = $db->getDb();          

        try {             
            $query = $conn->prepare("SELECT * FROM users WHERE username = :username");             
            $query->bindParam(':username', $username);             
            $query->execute();             
            $user = $query->fetch(PDO::FETCH_ASSOC);              

            if ($user) {                 
                if ($password === $user['password']) {                     
                    session_start();                     
                    $_SESSION['user_id'] = $user['id'];                     
                    $_SESSION['username'] = $user['username'];                     
                    $_SESSION['role'] = $user['role'];  // Store the user's role in session

                    // Redirect based on user role
                    if ($_SESSION['role'] == 'admin') {
                        header('Location: adminDashboard.php');
                    } elseif ($_SESSION['role'] == 'client') {
                        header('Location: clientDashboard.php');
                    } elseif ($_SESSION['role'] == 'guest') {
                        header('Location: guestDashboard.php');
                    } else {
                        echo "Unknown role!";
                    }
                    exit;                  
                } else {                     
                    echo "Invalid password!";                 
                }             
            } else {                 
                echo "Username not found!";              
            }         
        } catch (PDOException $e) {             
            echo "Error: " . $e->getMessage();         
        }     
    } else {         
        echo "Please provide both username and password.";     
    } 
} 

include 'loginhtml.php'; 
?>
