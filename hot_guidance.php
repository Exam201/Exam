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
<title>Hot Weather Guidance</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<style>
body {
  background-image: url("images/heather-shevlin-3B_NrzTjajc-unsplash.jpg");
}
.content_background {
    background-color: #222;
    padding: 20px;
    margin: 20px;
    border-radius: 10px;
}
p, li {
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
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Settings</a>
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
                            <h1>Hot Weather Guidance</h1>
                        </div>
                        <div class="col-6 col-md-4">
                            <ul class="pagination" style="float:right;">
                                <li class="page-item">
                                <a class="page-link" href="guidance.php">&laquo;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="guidance.php">1</a>
                                </li>
                                <li class="page-item active">
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
                                <a class="page-link" href="cold_guidance.php">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <p>How does hot weather affect us?</p>
                <p>Hot weather can be dangerous, especially for older people, young children and people with long-term health conditions. It can also be a problem for people who work outdoors.</p>
                <p>Hot weather can lead to heat exhaustion and heatstroke. Heat exhaustion is a milder form of heatstroke. It can cause dizziness, nausea, headaches and fainting. Heatstroke is a serious condition that can lead to organ failure and even death. It can cause confusion, seizures, vomiting and collapse.</p>
                <br>
                <p>How can I protect myself from the heat?</p>
                <p>There are a number of things you can do to protect yourself from the heat. These include:</p>
                <ul>
                    <li>Drink plenty of fluids, especially water. Avoid alcohol and caffeine, which can make you dehydrated.</li>
                    <li>Try to stay in the shade as much as possible.</li>
                    <li>Wear loose, light clothing.</li>
                    <li>Try to avoid going out in the hottest part of the day, between 11am and 3pm.</li>
                    <li>Avoid strenuous exercise in the heat.</li>
                    <li>Keep your home cool. Close curtains and blinds to keep out the sun. Open windows at night to let in cooler air.</li>
                    <li>Check on elderly or vulnerable neighbours and relatives to make sure they are keeping cool.</li>
                </ul>
                <p>What should I do if I think someone is suffering from heat exhaustion or heatstroke?</p>
                <p>If you think someone is suffering from heat exhaustion or heatstroke, call 999 immediately. If you are alone with the person, try to cool them down by moving them to a cool place and giving them water to drink. If they are conscious, give them small sips of water.</p>
                <p>Click on the links below to find out more.</p>
                <ul>
                    <li><a href="https://www.nhs.uk/live-well/seasonal-health/heatwave-how-to-cope-in-hot-weather/">NHS</a></li>
                    <li><a href="https://www.metoffice.gov.uk/weather/warnings-and-advice/seasonal-advice/health-wellbeing/hot-weather-and-its-impacts">Met office</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end main content -->
</body>
</html>
