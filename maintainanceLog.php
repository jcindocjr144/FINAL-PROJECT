<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tinkerbellDb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['unit'])) {
    $unit = isset($_POST['unit']) ? $_POST['unit'] : '';
    $plate_no = isset($_POST['plate_no']) ? $_POST['plate_no'] : '';
    $body_no = isset($_POST['body_no']) ? $_POST['body_no'] : '';
    $driver_name = isset($_POST['driver_name']) ? $_POST['driver_name'] : '';
    $maintenance = isset($_POST['maintenance']) ? $_POST['maintenance'] : '';
    $mechanic = isset($_POST['mechanic']) ? $_POST['mechanic'] : '';
    $payment = isset($_POST['payment']) ? $_POST['payment'] : 0;

    $sql = "INSERT INTO maintenanceLogs (unit, plate_no, body_no, driver_name, maintenance, mechanic, payment)
            VALUES ('$unit', '$plate_no', '$body_no', '$driver_name', '$maintenance', '$mechanic', '$payment')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

if (isset($_POST['fetch_driver'])) {
    $driver_name = $_POST['driver_name'];

    $sql = "SELECT unit, body_no, plate_no FROM drivers WHERE CONCAT(first_name, ' ', middle_name, ' ', last_name) = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $driver_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $driver_data = $result->fetch_assoc();
        echo json_encode($driver_data);
    } else {
        echo json_encode(['error' => 'Driver not found']);
    }
    exit();
}

$sql = "SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name FROM drivers";
$drivers_result = $conn->query($sql);

$sql = "SELECT * FROM maintenanceLogs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Log</title>
    <link rel="stylesheet" href="css/log_maintenance.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="shortcut icon" href="images/logo.png">
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
            <div class="log-maintenance text-white ms-5">
                <h3>MAINTENANCE</h3>
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
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover">
                        <thead>
                            <tr class="borderless">
                                <td class="bg-transparent text-white">UNIT</td>
                                <td class="bg-transparent text-white">PLATE NO.</td>
                                <td class="bg-transparent text-white">BODY #</td>
                                <td class="bg-transparent text-white">MAINTENANCE</td>
                                <td class="bg-transparent text-white">DRIVER</td>
                                <td class="bg-transparent text-white">MECHANIC</td>
                                <td class="bg-transparent text-white">PAYMENT</td> <!-- Added Payment Column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result && $result->num_rows > 0): ?>
                                <?php while($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td class="bg-transparent text-white text-center"><?php echo $row['unit']; ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo $row['plate_no']; ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo $row['body_no']; ?></td>
                                        <td class="bg-transparent text-white"><?php echo $row['maintenance']; ?></td>
                                        <td class="bg-transparent text-white"><?php echo $row['driver_name']; ?></td>
                                        <td class="bg-transparent text-white"><?php echo $row['mechanic']; ?></td>
                                        <td class="bg-transparent text-white"><?php echo $row['payment']; ?></td> <!-- Display Payment -->
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center text-white">No records found</td> <!-- Adjusted colspan -->
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade modal-lg" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-transparent border-0">
                    <form method="POST">
                        <div class="modal-body p-0 pt-3">
                            <div class="top mt-4">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <div class="box p-0">
                                    <h1 class="modal-title" id="exampleModalLabel">LOG MAINTENANCE</h1>
                                </div>
                            </div>
                            <div class="logContents">
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
                                            <input type="text" id="plate_no" name="plate_no" class="input" required>
                                        </div>
                                        <div class="col">
                                            <label for="body_no">BODY #</label>
                                            <input type="number" id="body_no" name="body_no" class="input" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="mid">
                                    <div class="row mt-3">
                                        <div class="col-5">
                                            <label for="driver_name">DRIVER</label>
                                            <select id="driver_name" name="driver_name" class="bg-success text-white" required>
                                                <option value="">Select Driver</option>
                                                <?php while ($driver = $drivers_result->fetch_assoc()): ?>
                                                    <option value="<?php echo $driver['full_name']; ?>"><?php echo $driver['full_name']; ?></option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom mt-3">
    <div class="row">
        <div class="col-12 col-md-4 mb-3">
            <label for="maintenance">MAINTENANCE</label>
            <input type="text" id="maintenance" name="maintenance" required class="input w-100">
        </div>
        <div class="col-12 col-md-4 mb-3">
            <label for="mechanic">MECHANIC</label>
            <input type="text" id="mechanic" name="mechanic" required class="input w-100">
        </div>
        <div class="col-12 col-md-4 mb-3">
            <label for="payment">PAYMENT</label>
            <input type="number" id="payment" name="payment" class="input w-100" step="0.01" required>
        </div>
    </div>
</div>

                            <div class="footer p-5 pt-3 d-flex justify-content-end">
                                <button type="submit" class="btn rounded-pill">LOG</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            document.getElementById('date').innerHTML = new Date(Date.now()).toLocaleString().split(',')[0];
        </script>
    </body>
</html>

<?php $conn->close(); ?>
