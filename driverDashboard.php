<?php
session_start();
require_once 'Database.php';  

$database = new Database();
$conn = $database->getDb();  

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'driver') {
    die("Access denied");
}

$query = "SELECT * FROM rentals WHERE driver_id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);  // Bind the driver_id
$stmt->execute();
$result_rentals = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM rental WHERE driver_id = ?";
$stmt = $conn->prepare($query);
$stmt->bindParam(1, $_SESSION['id'], PDO::PARAM_INT);  // Bind the driver_id
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$db = new Database();
$conn = $db->getDb();
$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT * FROM drivers WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$driver = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM registrations WHERE id = :id");
$stmt->bindParam(':id', $driver['id']);
$stmt->execute();
$registration = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])) {
    $new_username = trim($_POST['username']);
    $new_password = trim($_POST['password']);

    if (!empty($new_username) && !empty($new_password)) {
        $stmt = $conn->prepare("UPDATE drivers SET username = :username, password = :password WHERE username = :current_username");
        $stmt->bindParam(':username', $new_username);
        $stmt->bindParam(':password', $new_password);
        $stmt->bindParam(':current_username', $username);   
        if ($stmt->execute()) {
            $stmt = $conn->prepare("UPDATE users SET username = :username, password = :password WHERE username = :current_username");
            $stmt->bindParam(':username', $new_username);
            $stmt->bindParam(':password', $new_password);
            $stmt->bindParam(':current_username', $username);
            $stmt->execute();
            $stmt = $conn->prepare("UPDATE registrations SET username = :username, password = :password WHERE username = :current_username");
            $stmt->bindParam(':username', $new_username);
            $stmt->bindParam(':password', $new_password);  
            $stmt->bindParam(':current_username', $username);
            $stmt->execute();

            $_SESSION['username'] = $new_username;
            $username = $new_username;
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Failed to update profile.');</script>";
        }
    } else {
        echo "<script>alert('All fields are required.');</script>";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateRentStatus'])) {
    $is_for_rent = isset($_POST['is_for_rent']) ? 1 : 0;

    $stmt = $conn->prepare("UPDATE drivers SET is_for_rent = :is_for_rent WHERE username = :username");
    $stmt->bindParam(':is_for_rent', $is_for_rent);
    $stmt->bindParam(':username', $username);
    if ($stmt->execute()) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to update rent status.');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_image'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["car_image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["car_image"]["tmp_name"], $target_file)) {
        $uploaded_image = basename($_FILES["car_image"]["name"]);
        $stmt = $conn->prepare("UPDATE drivers SET car_image = :car_image WHERE username = :username");
        $stmt->bindParam(':car_image', $uploaded_image);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('Failed to upload image.');</script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateCarUnit'])) {
    $unit = $_POST['unit'];
    $plate_no = $_POST['plate_no'];
    $body_no = $_POST['body_no'];

    $stmt = $conn->prepare("UPDATE registrations SET unit = :unit, plate_no = :plate_no, body_no = :body_no WHERE id = :id");
    $stmt->bindParam(':unit', $unit);
    $stmt->bindParam(':plate_no', $plate_no);
    $stmt->bindParam(':body_no', $body_no);
    $stmt->bindParam(':id', $driver['id']);
    
    if ($stmt->execute()) {
        $stmt = $conn->prepare("UPDATE drivers SET unit = :unit, plate_no = :plate_no, body_no = :body_no WHERE id = :id");
        $stmt->bindParam(':unit', $unit);
        $stmt->bindParam(':plate_no', $plate_no);
        $stmt->bindParam(':body_no', $body_no);
        $stmt->bindParam(':id', $driver['id']);
        
        if ($stmt->execute()) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "<script>alert('Failed to update driver details.');</script>";
        }
    } else {
        echo "<script>alert('Failed to update car unit details.');</script>";
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_image'])) {
    $current_image = $driver['car_image'];
    if ($current_image && file_exists("uploads/" . $current_image)) {
        unlink("uploads/" . $current_image);
        $stmt = $conn->prepare("UPDATE drivers SET car_image = NULL WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } else {
        echo "<script>alert('No image found to delete.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="images/logo.png" type="image/png">
    <style>
        .content-section {
            display: none;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php"><b>Tinkerbell</b> Transport</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-white" href="javascript:void(0);" onclick="showSection('editProfile')">Edit Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="javascript:void(0);" onclick="showSection('carUnits')">Car Units</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="rentals.php">Rentals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-4">Driver Dashboard</h1>

    <div id="editProfile" class="card mb-4 content-section">
        <div class="card-header bg-success text-white">
            <h4>Edit Profile</h4>
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($driver['username']); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" name="updateProfile" class="btn btn-success">Update Profile</button>
            </form>
        </div>
    </div>

    <div id="carUnits" class="card content-section">
        <div class="card-header bg-success text-white p-5">
            <h4>Car Units</h4>
            <div class="card-body">
            <table class="table table-bordered table-hover">
            <thead>
            <tr>
            <th><?php echo htmlspecialchars($registration['unit']); ?></th></tr>
            
            <tr>
            <td>
                            <?php if ($driver['car_image']): ?>
                                <img src="uploads/<?php echo $driver['car_image']; ?>" alt="Car Image" class="img-fluid w-50">

                            <?php else: ?>
                                <span>No image uploaded</span>
                            <?php endif; ?>
                        </td>
                    </tr>
            </table>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Unit</th>
                        <th>Plate no</th>
                        <th>Body no</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo htmlspecialchars($registration['unit']); ?></td>
                        <td><?php echo htmlspecialchars($registration['plate_no']); ?></td>
                        <td><?php echo htmlspecialchars($registration['body_no']); ?></td>
                        
                        <td>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCarModal">Edit</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="modal fade" id="editCarModal" tabindex="-1" aria-labelledby="editCarModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCarModalLabel">Edit Car Unit</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="unit" class="form-label">Unit</label>
                                    <input type="text" class="form-control" id="unit" name="unit" value="<?php echo htmlspecialchars($registration['unit']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="plate_no" class="form-label">Plate no</label>
                                    <input type="text" class="form-control" id="plate_no" name="plate_no" value="<?php echo htmlspecialchars($registration['plate_no']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="body_no" class="form-label">Body no</label>
                                    <input type="text" class="form-control" id="body_no" name="body_no" value="<?php echo htmlspecialchars($registration['body_no']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="car_image" class="form-label">Current Car Image</label><br>
                                    <?php if ($driver['car_image']): ?>
                                        <img src="uploads/<?php echo $driver['car_image']; ?>" alt="Car Image" width="100"><br>
                                    <?php else: ?>
                                        <span>No image uploaded</span><br>
                                    <?php endif; ?>
                                    <button type="submit" name="delete_image" class="btn btn-danger btn-sm mt-2">Delete Image</button>
                                </div>
                                <button type="submit" name="updateCarUnit" class="btn btn-success">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data" class="mt-4">
                <div class="mb-3">
                    <label for="car_image" class="form-label">Upload Car Image</label>
                    <input type="file" class="form-control" id="car_image" name="car_image">
                </div>
                <button type="submit" name="upload_image" class="btn btn-primary">Upload Image</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function showSection(sectionId) {
        var sections = document.querySelectorAll('.content-section');
        sections.forEach(function(section) {
            section.style.display = 'none';
        });
        document.getElementById(sectionId).style.display = 'block';
    }
</script>

</body>
</html>
