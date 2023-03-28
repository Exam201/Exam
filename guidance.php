<?php
session_start();
$nav_hidden = "";
$nav_unhidden = "hidden";
if (isset($_SESSION["userid"])) {
    $nav_hidden = "hidden";
    $nav_unhidden = "";
} //this is used to hide the sign up button if the user is logged in and to hide the logout button if the user is not logged in

include 'Library/dbconnect.php';
$conn = connect(); //this calls the connection function from the dbconnect.php file and returns the connection object to the variable $conn

?>
<doctype html>
<html>
<header>
<title>Guidance</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<style>
body {
  background-image: url("images/dewang-gupta-ESEnXckWlLY-unsplash.jpg");
}
.content_background {
    background-color: #222;
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
}
#text_size{
    font-size: 20px;
}
</style>
</header>
<!-- navbar -->
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <img src="images/placeholder.png" alt="logo" style="width:75px; height:50px; padding-right: 10px;">
    <a class="navbar-brand" href="index.php">Health Advice Group</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link" href="forecast.php">Forecast</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="air_quality.php">Air Quality</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="guidance.php">Guidance</a>
        </li>
        <li class="nav-item" <?php echo "$nav_hidden"; ?> >
          <a class="nav-link" href="register.php">Sign up</a>
        </li>
        <li class="nav-item" <?php echo "$nav_hidden"; ?> >
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item" <?php echo "$nav_unhidden"; ?> >
          <a class="nav-link" href="fitness_tracker.php">Fitness Tracker</a>
        </li>
        <li class="nav-item" <?php echo "$nav_unhidden"; ?> >
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="settings.php">Settings</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- end navbar -->
<!-- main content -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="content_background">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <h1>Weather Guidance</h1>
                        </div>
                        <div class="col-6 col-md-4">
                            <ul class="pagination" style="float:right;">
                                <li class="page-item">
                                  <a class="page-link" href="enviromental_conditions.php">&laquo;</a>
                                </li>
                                <li class="page-item active">
                                  <a class="page-link" href="guidance.php">1</a>
                                </li>
                                <li class="page-item">
                                  <a class="page-link" href="hot_guidance.php">2</a>
                                </li>
                                <li class="page-item">
                                  <a class="page-link" href="cold_guidance.php">3</a>
                                </li>
                                <li class="page-item">
                                  <a class="page-link" href="pollution_guidance.php">4</a>
                                </li>
                                <li class="page-item">
                                  <a class="page-link" href="enviromental_conditions.php">5</a>
                                </li>
                                <li class="page-item">
                                  <a class="page-link" href="hot_guidance.php">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container" id = "text_size">
                <p>Why does weather matter?</p>
                <p>Weather huge impact on our health, and it is important to be aware of the weather conditions and how they can affect our health.</P>
                <p>Weather can cause us to feel unwell, and it can also cause us to be more vulnerable to other illnesses and it can cause us to be more vulnerable to accidents and injuries.</p>
                <p>It is important to be prepared for the weather conditions and to know how to stay safe and healthy in different weather conditions.</p>
                <p>Here you can find information on how to stay safe and healthy in different weather conditions.</p>
                <ol>
                    <li><a href="hot_guidance.php">Hot weather</a></li>
                    <li><a href="cold_guidance.php">Cold weather </a></li>
                    <li><a href="pollution_guidance.php">Pollution</a></li>
                    <li><a href="enviromental_conditions.php">Enviromental health conditons and Seasonal allergies</a></li>
                </ol>
                <p>these can also be accessed from the pagenation at the top of the page.</p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>          
</div>
<!-- end main content -->
</body>
</html>
