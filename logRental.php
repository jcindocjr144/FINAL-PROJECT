<?php
session_start();

require_once 'database.php';

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new Database();
        $conn = $db->getDb();

        if (isset($_POST['update_rental'])) {
            $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
            $rental = isset($_POST['rental']) ? (float)$_POST['rental'] : 0;
            $maintenance = isset($_POST['maintenance']) ? (float)$_POST['maintenance'] : 0;
            $savings = isset($_POST['savings']) ? (float)$_POST['savings'] : 0;
            $accspay = isset($_POST['accspay']) ? (float)$_POST['accspay'] : 0;
            $days = isset($_POST['days']) ? (int)$_POST['days'] : 0;

            $total = ($rental * $days) + $maintenance + $savings + $accspay;

            $stmt = $conn->prepare("UPDATE rentals SET rental = :rental, maintenance = :maintenance, savings = :savings, accspay = :accspay, days = :days, total = :total WHERE id = :id");
            $stmt->bindParam(':rental', $rental);
            $stmt->bindParam(':maintenance', $maintenance);
            $stmt->bindParam(':savings', $savings);
            $stmt->bindParam(':accspay', $accspay);
            $stmt->bindParam(':days', $days);
            $stmt->bindParam(':total', $total);
            $stmt->bindParam(':id', $id);

            $stmt->execute();
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        } else {
            $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
            $plate_no = isset($_POST['plate_no']) ? $_POST['plate_no'] : '';
            $body_no = isset($_POST['body_no']) ? $_POST['body_no'] : '';
            $driver_name = isset($_POST['driver_name']) ? $_POST['driver_name'] : '';
            $payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : '';
            $days = isset($_POST['days']) ? $_POST['days'] : 0;
            
            $rental = isset($_POST['rental']) ? (float) $_POST['rental'] : 0;
            $maintenance = isset($_POST['maintenance']) ? (float) $_POST['maintenance'] : 0;
            $savings = isset($_POST['savings']) ? (float) $_POST['savings'] : 0;
            $accspay = isset($_POST['accspay']) ? (float) $_POST['accspay'] : 0;

            $total = ($rental * $days) + $maintenance + $savings + $accspay;

            if (empty($unit) || empty($plate_no) || empty($body_no) || empty($driver_name) || empty($payment_method) || empty($days)) {
                echo "<script>alert('All fields are required!');</script>";
            } else {
                $stmt = $conn->prepare("INSERT INTO rentals (unit, plate_no, body_no, driver_name, payment_method, days, rental, maintenance, savings, accspay, total) 
                                        VALUES (:unit, :plate_no, :body_no, :driver_name, :payment_method, :days, :rental, :maintenance, :savings, :accspay, :total)");
                
                $stmt->bindParam(':unit', $unit);
                $stmt->bindParam(':plate_no', $plate_no);
                $stmt->bindParam(':body_no', $body_no);
                $stmt->bindParam(':driver_name', $driver_name);
                $stmt->bindParam(':payment_method', $payment_method);
                $stmt->bindParam(':days', $days);
                $stmt->bindParam(':rental', $rental);
                $stmt->bindParam(':maintenance', $maintenance);
                $stmt->bindParam(':savings', $savings);
                $stmt->bindParam(':accspay', $accspay);
                $stmt->bindParam(':total', $total);

                $stmt->execute();

                $_SESSION['form_submitted'] = true;

                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }

    } catch (PDOException $e) {
        $error_message = 'Database error: ' . $e->getMessage();
        echo "<script>alert('$error_message');</script>";
    }
}

try {
    $db = new Database();
    $conn = $db->getDb();

    $stmt = $conn->prepare("SELECT * FROM rentals");
    $stmt->execute();

    $rental_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Rental</title>
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="css/log_rental.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="body">
    <div class="navigation">
        <img src="images/TINKERBELL W.png" alt="TINKERBELL TRANSPORT">
    </div>
    <div class="containerBox">
        <div class="header">
            <a href="adminDashboard.php">
                <img src="images/return.png" alt="return">
            </a>
            <div class="log-rental text-white ms-5">
                <h3>RENTAL</h3>
            </div>
            <div class="date float-end m-auto me-0">
                <span id="date"></span>
            </div>
            <button type="button" class="float-end ms-5 me-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
        <div class="contents">
            <div class="table-container">
            <table class="table table-sm table-bordered table-hover">
    <thead>
        <tr class="borderless">
            <td class="bg-transparent text-white">UNIT</td>
            <td class="bg-transparent text-white">PLATE no.</td>
            <td class="bg-transparent text-white">BODY #</td>
            <td class="bg-transparent text-white">COLLECTION TOTAL</td>
            <td class="bg-transparent text-white">DAYS</td>
            <td class="bg-transparent text-white">DRIVER NAME</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($rental_data)) {
            foreach ($rental_data as $row) {
                echo "<tr>";
                echo "<td class='bg-transparent text-white text-center'>{$row['unit']}</td>";
                echo "<td class='bg-transparent text-white text-center'>{$row['plate_no']}</td>";
                echo "<td class='bg-transparent text-white text-center'>{$row['body_no']}</td>";
                echo "<td class='bg-transparent text-white text-center'>{$row['total']}</td>";
                echo "<td class='bg-transparent text-white text-center'>{$row['days']}</td>";
                echo "<td class='bg-transparent text-white'>{$row['driver_name']}</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='text-center'>No rental data found.</td></tr>";
        }
        ?>
    </tbody>
</table>
            </div>
        </div>
    </div>

    <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-transparent border-0">
                <div class="modal-body p-0 pt-3">
                    <div class="top mt-4">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        <div class="box p-0">
                            <h1 class="modal-title" id="exampleModalLabel">LOG RENTAL</h1>
                        </div>
                    </div>
                    <div class="logContents">
                        <form method="POST">
                            <div class="top mt-5">
                                <div class="row">
                                    <div class="col">
                                        <input type="radio" id="taxi" name="unit" value="TAXI">
                                        <label for="taxi">TAXI</label>
                                        <input type="radio" id="multicab" name="unit" value="MULTICAB">
                                        <label for="multicab">MULTICAB</label>
                                    </div>
                                    <div class="col">
                                        <label for="plate_no">PLATE NO.</label>
                                        <input type="text" id="plate_no" class="input" name="plate_no" required>
                                    </div>
                                    <div class="col">
                                        <label for="body_no">BODY #</label>
                                        <input type="number" id="body_no" class="input" name="body_no" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mid mt-4">
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <label for="driver_name">DRIVER FULL NAME</label>
                                        <input type="text" id="driver_name" name="driver_name" required>
                                    </div>
                                    <div class="col-3" id="payment_method">
                                        <p>MODE OF PAYMENT</p>
                                        <input type="radio" id="cash" name="payment_method" value="CASH" required>
                                        <label for="cash">CASH</label>
                                        <input type="radio" id="gcash" name="payment_method" value="GCASH" required>
                                        <label for="gcash">GCASH</label>
                                    </div>
                                    <div class="col-3">
                                        <label for="days">NO. OF DAYS</label><br>
                                        <input type="number" id="days" name="days" required>
                                    </div>
                                </div>
                            </div>
                            <div class="bottom mt-4">
                                <div class="row">
                                    <div class="col">
                                        <label for="rental">RENTAL</label>
                                        <input type="number" id="rental" name="rental" onchange="calculateTotal()">
                                    </div>
                                    <div class="col">
                                        <label for="maintenance">MAINT.</label>
                                        <input type="number" id="maintenance" name="maintenance" onchange="calculateTotal()">
                                    </div>
                                    <div class="col">
                                        <label for="savings">SAVINGS</label>
                                        <input type="number" id="savings" name="savings" onchange="calculateTotal()">
                                    </div>
                                    <div class="col">
                                        <label for="accspay">ACCTS. PAY.</label>
                                        <input type="number" id="accspay" name="accspay" onchange="calculateTotal()">
                                    </div>
                                    <div class="col">
                                        <label for="total">TOTAL</label>
                                        <input type="number" id="total" name="total" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="footer p-4 pt-3 mt-4 d-flex justify-content-end">
                                <button type="submit" name="log_rental" class="btn rounded-pill">LOG</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
    <h3>Rental Records</h3>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Unit</th>
            <th>Plate No</th>
            <th>Body No</th>
            <th>Driver Name</th>
            <th>Days</th>
            <th>Rental</th>
            <th>Maintenance</th>
            <th>Savings</th>
            <th>Accs Pay</th>
            <th>Total</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rental_data as $row): ?>
            <tr>
                <td><?= $row['unit'] ?></td>
                <td><?= $row['plate_no'] ?></td>
                <td><?= $row['body_no'] ?></td>
                <td><?= $row['driver_name'] ?></td>
                <td><?= $row['days'] ?></td>
                <td><?= $row['rental'] ?></td>
                <td><?= $row['maintenance'] ?></td>
                <td><?= $row['savings'] ?></td>
                <td><?= $row['accspay'] ?></td>
                <td><?= $row['total'] ?></td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">Edit</button>
                </td>
            </tr>
            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Rental</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                <div class="mb-3">
                                    <label for="rental" class="form-label">Rental</label>
                                    <input type="number" class="form-control" name="rental" value="<?= $row['rental'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="maintenance" class="form-label">Maintenance</label>
                                    <input type="number" class="form-control" name="maintenance" value="<?= $row['maintenance'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="savings" class="form-label">Savings</label>
                                    <input type="number" class="form-control" name="savings" value="<?= $row['savings'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="accspay" class="form-label">Accs Pay</label>
                                    <input type="number" class="form-control" name="accspay" value="<?= $row['accspay'] ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="days" class="form-label">Days</label>
                                    <input type="number" class="form-control" name="days" value="<?= $row['days'] ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update_rental" class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('date').innerHTML = new Date(Date.now()).toLocaleString().split(',')[0];
        function calculateTotal() {
        var rental = parseFloat(document.getElementById('rental').value) || 0;
        var maintenance = parseFloat(document.getElementById('maintenance').value) || 0;
        var savings = parseFloat(document.getElementById('savings').value) || 0;
        var accspay = parseFloat(document.getElementById('accspay').value) || 0;

        var total = rental + maintenance + savings + accspay;

        document.getElementById('total').value = total;
    }
    </script>
</body>

</html>
