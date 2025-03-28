<?php
session_start();
require_once 'Database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guest') {
    die("Access denied");
}

$db = new Database();
$conn = $db->getDb();

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
    // Collect form data
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

    $updateGuest = $conn->prepare("UPDATE guest SET first_name = :first_name, middle_name = :middle_name, last_name = :last_name, contact = :contact, street = :street, barangay = :barangay, city = :city, province = :province WHERE user_id = :user_id");
    $updateGuest->bindParam(':first_name', $firstName);
    $updateGuest->bindParam(':middle_name', $middleName);
    $updateGuest->bindParam(':last_name', $lastName);
    $updateGuest->bindParam(':contact', $contact);
    $updateGuest->bindParam(':street', $street);
    $updateGuest->bindParam(':barangay', $barangay);
    $updateGuest->bindParam(':city', $city);
    $updateGuest->bindParam(':province', $province);
    $updateGuest->bindParam(':user_id', $_SESSION['user_id']);
    $updateGuest->execute();

    if (!empty($password)) {
        $updateUser = $conn->prepare("UPDATE users SET username = :username, password = :password WHERE id = :user_id");
        $updateUser->bindParam(':username', $username);
        $updateUser->bindParam(':password', $password); // No hashing, use plain password } else {
        $updateUser = $conn->prepare("UPDATE users SET username = :username WHERE id = :user_id");
        $updateUser->bindParam(':username', $username);
    }
    $updateUser->bindParam(':user_id', $_SESSION['user_id']);
    $updateUser->execute();

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
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-success">
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="index.php"><b>Tinkerbell</b> Transport</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                <a class="nav-link text-white" href="#" id="dashboardLink">Dashboard</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-white" href="#" id="profileLink">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" id="rentCarLink">Rent a Car</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container mt-5" id="dashboard">
    <h1 class="text-center mb-4" style="font-family: 'Arial', sans-serif; font-weight: bold; color: #4CAF50;">CLIENT DASHBOARD</h1>
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card shadow-lg" style="border-radius: 15px;">
            <img src="images/rental1.png" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">Rent a Car</h5>
                    <p class="card-text">Browse our wide range of cars available for rent. Choose the best one that fits your needs.</p>
                    <a href="#" class="btn btn-success w-100 exploreCarsLink">Explore Cars</a>
               
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg" style="border-radius: 15px;">
            <img src="images/driver.jpg" class="card-img-top" alt="">
            <div class="card-body">
                    <h5 class="card-title">Available Drivers</h5>
                    <p class="card-text">Meet our professional drivers who will ensure a safe and comfortable ride.</p>
                    <a href="#" class="btn btn-info w-100" id="viewDriversLink">View Drivers</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-lg" style="border-radius: 15px;">
            <img src="images/profile.jpg" class="card-img-top" alt="">
                <div class="card-body">
                    <h5 class="card-title">Your Profile</h5>
                    <p class="card-text">Update your personal information and view your rental history.</p>
                    <a href="#" class="btn btn-warning w-100 exploreProfileLink">Explore Profile</a>
                    </div>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5" id="profile">
    <h1 class="text-center mb-4">My Profile</h1>

    <form action="updateProfile.php" method="POST">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($guestData['first_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="middle_name" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($guestData['middle_name']); ?>">
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($guestData['last_name']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="contact" class="form-label">Contact</label>
            <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($guestData['contact']); ?>">
        </div>
        <div class="mb-3">
            <label for="street" class="form-label">Street</label>
            <input type="text" class="form-control" id="street" name="street" value="<?php echo htmlspecialchars($guestData['street']); ?>">
        </div>
        <div class="mb-3">
            <label for="barangay" class="form-label">Barangay</label>
            <input type="text" class="form-control" id="barangay" name="barangay" value="<?php echo htmlspecialchars($guestData['barangay']); ?>">
        </div>
        <div class="mb-3">
            <label for="city" class="form-label">City</label>
            <input type="text" class="form-control" id="city" name="city" value="<?php echo htmlspecialchars($guestData['city']); ?>">
        </div>
        <div class="mb-3">
            <label for="province" class="form-label">Province</label>
            <input type="text" class="form-control" id="province" name="province" value="<?php echo htmlspecialchars($guestData['province']); ?>">
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
    </form>
</div>
<div class="container mt-5">
    <div class="container mt-5" id="availableCars">
        <h1 class="text-center mb-4">Available Cars for Rent</h1>

        <div class="row">
            <?php
            foreach ($drivers as $driver) {
                echo '<div class="col-md-4 mb-4">
                        <div class="card">
                            <img src="uploads/' . htmlspecialchars($driver['car_image']) . '" class="card-img-top" alt="Car Image">
                            <div class="card-body">
                                <h5 class="card-title">' . htmlspecialchars($driver['unit']) . '</h5>
                                <p class="card-text">
                                    <strong>Plate No:</strong> ' . htmlspecialchars($driver['plate_no']) . '<br>
                                    <strong>Body No:</strong> ' . htmlspecialchars($driver['body_no']) . '
                                </p>
                                <form action="processRental.php" method="POST">
                                    <input type="hidden" name="car_id" value="' . htmlspecialchars($driver['id']) . '">
                                    <input type="hidden" name="driver_id" value="' . htmlspecialchars($driver['id']) . '">
                                    <label for="payment_method">Payment Method:</label>
                                    <select name="payment_method" class="form-control mb-3" required>
                                        <option value="gcash">Gcash</option>
                                        <option value="cash">Cash</option>
                                    </select>
                                    <button type="submit" class="btn btn-success w-100">Rent This Car</button>
                                </form>
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>
</div>

<div id="driversTable" style="display: none;">
    <h2 class="text-center">Drivers List</h2>
    <div class="container">
    <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr class="border-1 bg-success">
                        <td class="bg-transparent text-white text-center">First Name</td>
                        <td class="bg-transparent text-white text-center">Middle Name</td>
                        <td class="bg-transparent text-white text-center">Last Name</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (isset($drivers) && count($drivers) > 0) {
                            foreach ($drivers as $driver) { 
                               
                        ?>
                            <tr class="border-1">
                                <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($driver['first_name']); ?></td>
                                <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($driver['middle_name']); ?></td>
                                <td class="bg-transparent text-dark text-center"><?php echo htmlspecialchars($driver['last_name']); ?></td>
                            </tr>
                        <?php }
                        } else { ?>
                            <tr>
                                <td colspan="6" class="text-center text-white">No records found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="js/guest.js">
</script>

</body>
</html>
