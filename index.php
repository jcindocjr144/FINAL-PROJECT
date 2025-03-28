<?php
session_start(); 
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true) {
   
    $user_role = isset($_SESSION['role']) ? $_SESSION['role'] : 'guest'; 
} else {
    $user_role = 'guest';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tinkerbell Transport</title>
  <link rel="stylesheet" href="css/index.css">
  <link rel="shortcut icon" href="images/logo.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-success bg-opacity-75">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)"><b>Tinkerbell</b> transport</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mynavbar">
                <ul class="navbar-nav ms-auto">
                  <li class="nav-item">
                      <a class="nav-link text-white" href="#home" ><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link text-white" href="#about" ><i class="fa fa-users" aria-hidden="true"></i> About us</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link  text-white" href="#services" ><i class="fa fa-car" aria-hidden="true"></i> Services</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link  text-white" href="#contact" ><i class="fa fa-phone" aria-hidden="true"></i> Contact us</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link  text-white" href="javascript:void(0)" onclick="feedback()"><i class="fa fa-commenting" aria-hidden="true"></i> Feedback</a>
                  </li>
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                          <span class="icon">
                              <i class="fa fa-cog text-white" aria-hidden="true"></i>
                          </span>
                          <span class="text text-white">Settings</span>
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                      <?php
                          if (isset($_SESSION['user_logged_in'])) {
                              $user_role = $_SESSION['role']; 

                              if ($user_role == 'admin') {
                                  echo '<li><a class="dropdown-item" href="adminDashboard.php">Dashboard</a></li>';
                              } elseif ($user_role == 'driver') {
                                  echo '<li><a class="dropdown-item" href="driverDashboard.php">Dashboard</a></li>';
                              } elseif ($user_role == 'guest') {
                                  echo '<li><a class="dropdown-item" href="guestDashboard.php">Dashboard</a></li>';
                              }
                          } else {
                              echo '<li><a class="dropdown-item" href="login.php">Login</a></li>';
                              echo '<li><a class="dropdown-item" href="register.php">Register</a></li>';
                          }
                          ?>
                      </ul>
                  </li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="demo" class="carousel slide vh-100" data-bs-ride="carousel" id="home">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/rental1.png" alt="Los Angeles" class="d-block w-100 vh-100">
            </div>
            <div class="carousel-item">
                <img src="images/rental2.png" alt="Chicago" class="d-block w-100 vh-100">
            </div>
            <div class="carousel-item">
                <img src="images/car3.png" alt="New York" class="d-block w-100 vh-100">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

   
    <!-- About -->
    <div id="about" class="bg-warning vh-100 d-flex align-items-center">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-12"> 
                    <div id="dynamic-content" class="text-dark"></div>
                </div>
            </div>
        </div>
    </div>
 <!-- Services -->
 <div id="services" class="bg-success vh-100">
        <h1 class="text-white text-center p-5">SERVICES OFFERED</h1>
        <div class="container py-5">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                        <img src="images/rental1.png" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title text-center">RENT A CAR</h5>
                            <p class="card-text">
                                Explore our wide range of rental cars for your travel needs. Whether it's a quick trip or a long journey, we offer affordable and reliable vehicles to suit your requirements.
                            </p>
                            <a href="login.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card h-100">
                    <img src="images/driver.jpg" class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title text-center">HIRE A DRIVER</h5>
                            <p class="card-text">
                             Hire a driver. </p>
                            <a href="login.php" class="btn btn-primary">Learn More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact -->
    <div id="contact" class="d-flex align-items-center justify-content-center bg-dark">
    <div class="row text-white p-3 mt-5">
            <!-- Contact Information -->
            <div class="col-md-6 mb-3">
                <h5>Contact Us</h5>
                <p class="mb-1"><i class="bi bi-envelope-fill me-2"></i>youtube.com</p>
                <p class="mb-1"><i class="bi bi-telephone-fill me-2"></i>+1 234 567 890</p>
                <p><i class="bi bi-geo-alt-fill me-2"></i>123 Your Address, Your City, Your Country</p>
            </div>

            <!-- Social Media Links -->
            <div class="col-md-6 mb-3 text-white">
                <h5>Follow Us</h5>
                <a href="https://www.facebook.com" class="text-white me-3" target="_blank">
                    <i class="bi bi-facebook fs-4"></i><img src="images/TB-LOGO.png" width="100" alt="">Tinkerbell officials
                </a>
                <a href="https://www.google.com" class="text-white me-3" target="_blank">
                    <i class="bi bi-google fs-4"></i></a>
            </div>
        </div>
        <div class="text-center text-white">
            <p class="mb-0">© 2024 Tinkerbell Transport. All rights reserved.</p>
        </div>
    </div>
  <!-- Feedback Form -->
   <div  style="display:none;">
<div id="feedback" class="min-vh-100 d-flex align-items-center justify-content-center bg-warning">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-lg bg-success text-white w-100" style="max-width: 500px;">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h1 class="h3 font-weight-bold text-white">Feedback</h1>
                            <p class="text-white">Fill up the form below to send us a message.</p>
                        </div>

                        <form action="https://api.web3forms.com/submit" method="POST" id="form">
                            <input type="hidden" name="access_key" value="dd325958-834b-48f8-8128-352972469f91" />
                            <input type="hidden" name="subject" value="Tinkerbell Transport" />
                            <input type="hidden" name="redirect" value="Form submitted successfully!" />
                            <input type="checkbox" name="botcheck" style="display: none;" />

                            <div class="form-group">
                                <label for="fname" class="font-weight-medium p-1">First Name</label>
                                <input type="text" name="first name" id="fname" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="lname" class="font-weight-medium p-1">Last Name</label>
                                <input type="text" name="last name" id="lname" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="email" class="font-weight-medium p-1">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="phone" class="font-weight-medium p-1">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control" required />
                            </div>

                            <div class="form-group">
                                <label for="message" class="font-weight-medium p-1">Your Message</label>
                                <textarea name="message" id="message" rows="4" class="form-control" required></textarea>
                            </div>

                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-dark btn-block">Send Message</button>
                            </div>
                        </form>
                        <p class="text-center text-muted mt-3" id="result"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

    <footer class="fixed-bottom p-3 d-flex align-items-end justify-content-end"> 
        <button class="btn btn-primary mt-3 ms-3">
            <a class="nav-link text-white" href="#"><i class="fa fa-arrow-circle-up" aria-hidden="true"></i> Back to top</a>
        </button>
    </footer>

    <script src="js/index.js">
       </script>    
</body>
</html>
