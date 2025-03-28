<?php
require_once 'adminDashboard.php';?>

<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Admin Dashboard</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/admin_dashboard.css">
    <link rel="shortcut icon" href="images/logo.png">
</head>
<body>  <div class="navigation">
        <a href="index.php"><img src="images/TINKERBELL W.png" alt="TINKERBELL TRANSPORT"></a>
        <a href="logout.php">
            <button>
                <img src="images/logout.png" style="width: 30px;" alt="logout">
            </button>
        </a>
    </div>
    <div class="adminDashboard mt-5">
        <div class="buttons">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="logRental option">
                        <a href="logRental.php">
                            <button>
                                <img src="images/paid-articles.png" alt="">
                                <p>LOG RENTAL</p>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="logMaintenance option">
                        <a href="maintainanceLog.php">
                            <button>
                                <img src="images/writing-skill.png" alt="">
                                <p>LOG MAINTENANCE</p>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="viewAudit option">
                        <a href="viewAudit.php">
                            <button>
                                <img src="images/audit.png" alt="">
                                <p>VIEW AUDIT</p>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="manageAccounts option">
                        <a href="manageAccounts.php">
                            <button>
                                <img src="images/MANAGE-users.png" alt="">
                                <p>MANAGE ACCOUNTS</p>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="createAccount option">
                        <a href="submitRegisterhtml.php">
                            <button>
                                <img src="images/ADD-user.png" alt="">
                                <p>CREATE ACCOUNT</p>
                            </button>
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="viewDriverDetails option">
                        <a href="viewDriverdetails.php">
                            <button>
                                <img src="images/user.png" alt="">
                                <p>VIEW DRIVER DETAILS</p>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js'></script>
</body>
</html>
