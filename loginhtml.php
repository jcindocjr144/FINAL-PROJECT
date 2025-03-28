<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="body">
    <div class="p-3 d-flex align-items-start justify-content-start"> 
        <button class="btn btn-primary mt-3 ms-3">
            <a class="nav-link text-white" href="index.php"><i class="fa fa-backward" aria-hidden="true"></i> BACK</a>
        </button>
        <div class="d-flex ms-auto">
        <button class="btn btn-primary mt-3 ms-3" onclick="admin()">
            <a class="nav-link text-white" href="#">LOG AS ADMIN</a>
        </button>
        <button class="btn btn-primary mt-3 ms-3" onclick="driverguest()">
            <a class="nav-link text-white" href="#">LOG AS USER</a>
        </button>
        </div>
    </div>

    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger text-center"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <!-- Driver/Guest Login -->
    <div class="mt-5" id="driver">
        <div class="login_form">
            <div><img src="images/TINKERBELL G.png" alt="TINKERBELL TRANSPORT"></div>
            <form method="POST" action="login.php">
                <div>
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>
                <div>
                    <p class="forgotpassword">Forgot Password?</p>
                </div>
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <button type="submit" class="login" name="login">Sign in</button>
                </div>
                <p>Don't have an account yet? <a href="register.php"><span class="text-danger">Register here!</span></a></p>
            </form>
        </div>
    </div>
    
    <!-- Admin Login -->
    <div class="mt-5" id="admin" style="display:none;">
        <div class="login_form">
            <div><img src="images/TINKERBELL G.png" alt="TINKERBELL TRANSPORT"></div>
            <form method="POST" action="login.php">
                <div>
                    <input type="password" id="password" name="password" placeholder="PASSCODE" required>
                </div>
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <button type="submit" class="login" name="admin_login">Sign in</button>
                </div>
            </form>
            <?php if (!empty($error_message)): ?>
                <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/login.js"></script>
    <script>
        function admin() {
            document.getElementById("admin").style.display = "block";
            document.getElementById("driver").style.display = "none";
        }

        function driverguest() {
            document.getElementById("driver").style.display = "block";
            document.getElementById("admin").style.display = "none";
        }
    </script>
</body>
</html>
