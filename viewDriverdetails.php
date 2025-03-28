<?php
require_once 'database.php'; 

try {
    $db = new Database();
    $conn = $db->getDb();

    $query = $conn->prepare("SELECT unit, plate_no, body_no, first_name, middle_name, last_name, contact, street, barangay, city, province FROM registrations");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Details</title>
    <link rel="stylesheet" href="css/view_driver_details.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="shortcut icon" href="images/logo.png">
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
                <h3>DRIVER DETAILS</h3>
            </div>
        </div>
        <div class="contents">
            <div class="table-container">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr class="border-1">
                            <td class="bg-transparent text-white">UNIT</td>
                            <td class="bg-transparent text-white">PLATE</td>
                            <td class="bg-transparent text-white">BODY #</td>
                            <td class="bg-transparent text-white">NAME</td>
                            <td class="bg-transparent text-white">PHONE No.</td>
                            <td class="bg-transparent text-white">ADDRESS</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if (isset($result) && count($result) > 0) {
                            foreach ($result as $row) { 
                                // Combine the full name
                                $full_name = htmlspecialchars($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
                                // Combine the address
                                $address = htmlspecialchars($row['street'] . ', ' . $row['barangay'] . ', ' . $row['city'] . ', ' . $row['province']);
                        ?>
                            <tr>
                                <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['unit']); ?></td>
                                <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['plate_no']); ?></td>
                                <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['body_no']); ?></td>
                                <td class="bg-transparent text-white text-center"><?php echo $full_name; ?></td>
                                <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['contact']); ?></td>
                                <td class="bg-transparent text-white text-center"><?php echo $address; ?></td>
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
