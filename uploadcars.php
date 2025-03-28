<?php
session_start();
include('Database.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$db = new Database();
$conn = $db->getDb();
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare('SELECT * FROM users WHERE id = ?');
$stmt->bindParam(1, $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

if ($user['role'] !== 'admin' && $user['role'] !== 'customer') {
    echo "You do not have permission to upload a profile picture.";
    exit;
}

if (isset($_FILES['car_image']) && $_FILES['car_image']['error'] == 0) {
    $file_name = $_FILES['car_image']['name'];
    $file_tmp = $_FILES['car_image']['tmp_name'];
    $file_size = $_FILES['car_image']['size'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($file_ext, $allowed_ext)) {
        $new_file_name = uniqid() . '.' . $file_ext;

        $upload_dir = 'uploads/';
        $upload_path = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $stmt = $conn->prepare('UPDATE users SET car_image = ? WHERE id = ?');
            $stmt->bindParam(1, $new_file_name);
            $stmt->bindParam(2, $user_id);
            if ($stmt->execute()) {
                if ($user['role'] === 'admin') {
                    header('Location: admindashboard.php');
                } else if ($user['role'] === 'customer') {
                    header('Location: dashboard.php');
                }
                exit;
            } else {
                echo "Error updating car image in the database.";
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
    }
} else {
    echo "No file uploaded.";
}
?>
