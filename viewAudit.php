<?php
require_once 'database.php';
$db = new Database();
$conn = $db->getDb();

$expenseQuery = $conn->prepare("SELECT name, amount FROM expenses");
$expenseQuery->execute();
$expenseResult = $expenseQuery->fetchAll(PDO::FETCH_ASSOC);

$maintenanceQuery = $conn->prepare("SELECT driver_name, payment FROM maintenanceLogs");
$maintenanceQuery->execute();
$maintenanceResult = $maintenanceQuery->fetchAll(PDO::FETCH_ASSOC);

$rentalQuery = $conn->prepare("SELECT unit, plate_no, body_no, total, days, driver_name FROM rentals");
$rentalQuery->execute();
$rentalResult = $rentalQuery->fetchAll(PDO::FETCH_ASSOC);

$totalRental = 0;
foreach ($rentalResult as $row) {
    $totalRental += $row['total'];
}

$totalExpense = 0;
foreach ($expenseResult as $expense) {
    $totalExpense += $expense['amount'];
}
foreach ($maintenanceResult as $maintenance) {
    $totalExpense += $maintenance['payment'];
}

$totalIncome = $totalRental - $totalExpense;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit</title>
    <link rel="stylesheet" href="css/view_audit.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
                <h3>AUDIT</h3>
            </div>
        </div>
        <div class="contents">
            <div class="row">
                <div class="col">
                    <div class="rental">
                        <h3>RENTAL</h3>
                        <div class="table-container">
                            <table class="table table-bordered table-sm table-hover">
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
                                    foreach ($rentalResult as $row) {
                                    ?>
                                    <tr>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['unit']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['plate_no']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['body_no']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['total']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['days']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($row['driver_name']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="expense">
                        <h3>EXPENSES (Maintenance Logs)</h3>
                        <div class="table-container">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr class="borderless">
                                        <td class="bg-transparent text-white">DRIVER NAME</td>
                                        <td class="bg-transparent text-white">AMOUNT (PAYMENT)</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($maintenanceResult as $maintenance) {
                                    ?>
                                    <tr>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($maintenance['driver_name']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($maintenance['payment']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="expense">
                        <h3>EXPENSES (Other)</h3>
                        <div class="table-container">
                            <table class="table table-sm table-bordered table-hover">
                                <thead>
                                    <tr class="borderless">
                                        <td class="bg-transparent text-white">NAME</td>
                                        <td class="bg-transparent text-white">AMOUNT</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($expenseResult as $expense) {
                                    ?>
                                    <tr>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($expense['name']); ?></td>
                                        <td class="bg-transparent text-white text-center"><?php echo htmlspecialchars($expense['amount']); ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="income m-auto me-0 text-white" style="width: 250px;">
                <h3>INCOME</h3>
                <div class="row light-bg">
                    <div class="col text-end">RENTAL TOTAL</div>
                    <div class="col text-center text-warning"><?php echo number_format($totalRental); ?></div>
                </div>
                <div class="row light-bg">
                    <div class="col text-end">EXPENSE TOTAL</div>
                    <div class="col text-center text-danger fw-bold"><?php echo number_format($totalExpense); ?></div>
                </div>
                <div class="row bg-dark">
                    <div class="col text-end">TOTAL</div>
                    <div class="col text-center"><?php echo number_format($totalIncome); ?></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
