<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
    <link rel="stylesheet" href="css/manage_accounts.css">
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
                <h3>MANAGE ACCOUNTS</h3>
            </div>
        </div>
        <div class="contents">
            <div class="table-container">
                <table class="table table-bordered table-sm table-hover">
                    <thead>
                        <tr class="borderless">
                            <td class="bg-transparent text-white">UNIT</td>
                            <td class="bg-transparent text-white">PLATE no.</td>
                            <td class="bg-transparent text-white">BODY #</td>
                            <td class="bg-transparent text-white">USERNAME</td>
                            <td class="bg-transparent text-white">PASSWORD</td>
                            <td class="bg-transparent text-white">DRIVER NAME</td>
                            <td class="bg-transparent text-white">ROLE</td>
                            <td class="bg-transparent text-white">ACTION</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        require_once 'database.php'; 

                        $db = new Database();
                        $conn = $db->getDb();
                        $query = $conn->prepare("
    (SELECT 
        unit, 
        plate_no, 
        body_no, 
        username, 
        password, 
        CONCAT(first_name, ' ', middle_name, ' ', last_name) AS driver_name, 
        id,
        'Driver' AS role
    FROM registrations)
    UNION
    (SELECT 
        NULL AS unit, 
        NULL AS plate_no, 
        NULL AS body_no, 
        username, 
        password, 
        CONCAT(first_name, ' ', middle_name, ' ', last_name) AS driver_name, 
        id,
        'Guest' AS role
    FROM guest)
");
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);

                        if (count($result) > 0) {
                            foreach ($result as $row) {
                        ?>
                        <tr>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['unit']); ?></td>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['plate_no']); ?></td>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['body_no']); ?></td>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['username']); ?></td>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['password']); ?></td>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['driver_name']); ?></td>
                            <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['role']); ?></td>
                            <td class="bg-transparent text-white d-flex justify-content-center">
                                <button class="delete-btn" data-id="<?php echo $row['id']; ?>">DELETE <i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="7" class="text-center text-white bg-dark">No records found</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const recordId = this.getAttribute('data-id');
                const confirmation = confirm('Are you sure you want to delete this record?');
                if (confirmation) {
                    window.location.href = 'deleteRecord.php?id=' + recordId;
                }
            });
        });
    </script>
</body>

</html>
