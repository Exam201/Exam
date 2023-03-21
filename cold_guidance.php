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
<title>Cold Weather Guidance</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<style>
body {
  background-image: url("images/aaron-burden-5AiWn2U10cw-unsplash.jpg");
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
                            <h1>Cold Weather Guidance</h1>
                        </div>
                        <div class="col-6 col-md-4">
                        <ul class="pagination" style="float:right;">
                                <li class="page-item">
                                <a class="page-link" href="hot_guidance.php">&laquo;</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="guidance.php">1</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="hot_guidance.php">2</a>
                                </li>
                                <li class="page-item active">
                                <a class="page-link" href="cold_guidance.php">3</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="pollution_guidance.php">4</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="enviromental_conditions.php">5</a>
                                </li>
                                <li class="page-item">
                                <a class="page-link" href="pollution_guidance.php">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <p>How does cold weather effect us?</p>
                <p>Cold temperatures have a huge impact on our health, as we get older it becomes harder for our bodies to detect how cold we are, and it takes longer to warm up which can be bad for our health. 
                    For older people in particular, the longer you are exposed to the cold, the higher the chance of heart attacks, strokes, pneumonia, depression, worsening arthritis and there is an increased risk of accidents at home.
                </p>
                <p>How can we stay healthy in the cold?</p>
                <p>There are a few things you can do to help you stay healthy in the cold.</p>
                <ul>
                    <li>Keep warm</li>
                    <li>Keep active</li>
                    <li>Keep in touch</li>
                </ul>
                <p>Keeping warm by using layers of clothing and being active is the first line of defence against cold weather, by keeping warm you mitigate lots of potential risk.</p>
                <p>Keeping active is important for your health and wellbeing. It can help you to stay warm and keep your muscles and joints flexible. It can also help you to feel more positive and less stressed.</p>
                <p>Keeping in touch with friends and family is important because it means if anything happens the likely hood someone notices and can help or get help is higher. It can also can help you to feel less lonely and isolated. </p>
                <p>Where can I find more information?</p>
                <p>There are many places you can find more information about staying healthy in the cold.</p>
                <p>Here is a video from the NHS about staying healthy in the cold.</p>
                <iframe allow="fullscreen;" width="500" height="445"
                    src="https://www.youtube.com/embed/VJibTZQS3Vk">
                </iframe>
                <p>Click on the links below to find out more.</p>
                <ul>
                    <li><a href="https://www.nhs.uk/live-well/seasonal-health/keep-warm-keep-well/">NHS</a></li>
                    <li><a href="https://www.metoffice.gov.uk/weather/warnings-and-advice/seasonal-advice/health-wellbeing/stay-well-in-winter">Met office</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end main content -->
</body>
</html>
