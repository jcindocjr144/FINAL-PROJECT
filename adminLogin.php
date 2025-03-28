<?php
require_once 'login.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inder&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="body">
   <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
    <div class="form">
        <div class="login_form">
            <div><img src="images/TINKERBELL G.png" alt="TINKERBELL TRANSPORT"></div>
           

           <form method="POST" action="login.php">
    <div>
        <input type="number" id="id" name="id" placeholder="Enter your ID" required>
    </div>
    <div class="d-flex align-items-center justify-content-center mb-2">
        <button type="submit" class="login" name="admin_login">Sign in</button>
    </div>
    <p>Don't have an account yet? <a href="register.php"><span class="text-danger">Register here!</span></a></p>
</form>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <header class="fixed-top p-3 d-flex align-items-start justify-content-start"> 
        <button class="btn btn-primary mt-3 ms-3">
            <a class="nav-link text-white" href="index.php"><i class="fa fa-backward" aria-hidden="true"></i> BACK</a>
        </button>
    </header>
</body>

</html>
