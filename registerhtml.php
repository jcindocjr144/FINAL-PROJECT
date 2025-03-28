<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tinkerbell Transport Registration</title>
    <link rel="stylesheet" href="css/create_account.css">
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
    <link rel="shortcut icon" href="images/logo.php">
</head>

<body class="body">
    <div class="navigation">
        <img src="images/TINKERBELL W.png" alt="TINKERBELL TRANSPORT">
    </div>  
    
    
    <div class="containerBox">
        <div class="header">
            <a href="index.php">
                <img src="images/return.png" alt="return">
            </a>

            <div class="log-maintenance text-white ms-5">
                <h3>CREATE ACCOUNT</h3>
            </div>
        </div>

        <form action="register.php" method="POST">
            <div class="contents">
                <div class="account_credentials">
                    <h4>ACCOUNT CREDENTIALS</h4>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <label for="username">USERNAME</label>
                            <input type="text" id="username" name="username" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="password">PASSWORD</label>
                            <input type="password" id="password" name="password" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="confirmpassword">CONFIRM PASSWORD</label>
                            <input type="password" id="confirmpassword" name="confirmpassword" required>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-9">
                        <div class="personal_info">
                            <h4>PERSONAL INFORMATION</h4>
                            <div class="row">
                                <div class="col">
                                    <label for="first_name">FIRST NAME</label>
                                    <input type="text" id="first_name" name="first_name" required>
                                </div>
                                <div class="col">
                                    <label for="middle_name">MIDDLE NAME</label>
                                    <input type="text" id="middle_name" name="middle_name">
                                </div>
                                <div class="col">
                                    <label for="last_name">LAST NAME</label>
                                    <input type="text" id="last_name" name="last_name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="contact_info">
                            <h4>CONTACT</h4>
                            <label for="contact">CONTACT</label>
                            <input type="number" id="contact" name="contact" value="09" maxlength="11" required>
                        </div>
                    </div>
                </div>

                <div class="address mt-4">
                    <h4>ADDRESS</h4>
                    <div class="row">
                        <div class="col">
                            <label for="street">STREET</label>
                            <input type="text" id="street" name="street">
                        </div>
                        <div class="col">
                            <label for="barangay">BARANGAY</label>
                            <input type="text" id="barangay" name="barangay">
                        </div>
                        <div class="col">
                            <label for="city">CITY / MUNICIPALITY</label>
                            <input type="text" id="city" name="city">
                        </div>
                        <div class="col">
                            <label for="province">PROVINCE</label>
                            <input type="text" id="province" name="province">
                        </div>
                    </div>
                </div>

              
                <div class="submit_button d-flex justify-content-end mt-5 mb-2">
                    <button type="submit" id="submit" name="register">CREATE</button>
                </div>
                <p class="text-white text-end">Already have an account? <a href="login.php" class="text-warning">Login here!</a></p>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/register.js"></script>
</body>

</html>
