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
<title>Pollution Guidance</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<style>
body {
  background-image: url("images/thijs-stoop-A_AQxGz9z5I-unsplash.jpg");
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
                            <h1>Pollution Guidance</h1>
                        </div>
                        <div class="col-6 col-md-4">
                            <ul class="pagination" style="float:right;">
                                <li class="page-item">
                                <a class="page-link" href="cold_guidance.php">&laquo;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="guidance.php">1</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="hot_guidance.php">2</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="cold_guidance.php">3</a>
                                </li>
                                <li class="page-item active">
                                <a class="page-link" href="pollution_guidance.php">4</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="enviromental_conditions.php">5</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="enviromental_conditions.php">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container" id = "text_size">
                  <p>There are many different types of pollution, pollution is the introduction of contaminants into the natural environment that cause adverse change. Pollution can take the form of chemical substances or energy, such as noise, heat or light. Pollutants, the components of pollution, can be either foreign substances/energies or naturally occurring contaminants.</p>
                  <P>Air pollution can be caused by a number of different things all of which can have a negative impact on your health.</P>
                  <p>sulphur dioxide, nitrogen dioxide, carbon monoxide, ozone, particulate matter, are all pollutants that can be found in the air. These pollutants can cause a number of different health problems, such as:</p>
                  <ul>
                      <li>Respiratory problems</li>
                      <li>Heart problems</li>
                      <li>Stroke</li>
                      <li>Chronic bronchitis</li>
                      <li>Emphysema</li>
                      <li>Increased risk of lung cancer</li>
                      <li>Increased risk of heart disease</li>
                      <li>Increased risk of stroke</li>
                      <li>Increased risk of asthma</li>
                      <li>Increased risk of chronic bronchitis</li>
                      <li>Increased risk of emphysema</li>
                      <li>Increased risk of lung cancer</li>
                  </ul>
                  <p>Air pollution can also affact many pre existing health conditions such as asthma and other respirtory conditions.</p>
                  <p>In some cases its hard to avoid air pollution, but it is still important to be aware of the air quality in your area. If you are able to avoid air pollution then you should try to do so. If you are unable to avoid air pollution then you should try to limit your exposure to it as much as possible.</p>
                  <p>Follow guidance from your local government and health authorities to help you stay safe.</p>
                  <p>For more information on air pollution and how it can affect your health, please visit the <a href="https://www.gov.uk/government/publications/health-matters-air-pollution/health-matters-air-pollution">Public Health England Website</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content -->
</body>
</html>
