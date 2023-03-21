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
<title>Seasonal Guidance</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<style>
body {
  background-image: url("images/gerome-bruneau-RPmWEtZLh7U-unsplash.jpg");
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
                            <h1>Enviromental health conditons and Seasonal allergies Guidance</h1>
                        </div>
                        <div class="col-6 col-md-4">
                            <ul class="pagination" style="float:right;">
                                <li class="page-item">
                                <a class="page-link" href="pollution_guidance.php">&laquo;</a>
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
                                <a class="page-link" href="guidance.php">&raquo;</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container" id = "text_size">
                    <p>Seasonal allergies are a common problem for many people. They are caused by an overreaction of the immune system to substances in the environment. These substances are called allergens. Allergens can be found in the air, in food, or on the skin. They can also be inhaled, swallowed, or touched. Allergens can cause a variety of symptoms, including sneezing, runny nose, itchy eyes, and itchy skin. Some people also have asthma attacks when they are exposed to allergens.</p>
                    <p>If you have a seasonal allergy, you may be able to avoid the allergens that cause your symptoms. You can also take medicines to help relieve your symptoms. If you have asthma, you may need to take medicines to prevent asthma attacks.</p>
                    <p>There is lots of allergens that can cause seasonal allergies. The one of the most common allergens is pollen. Pollen is a fine powder that is produced by plants. It is carried by the wind and can cause allergic reactions in people who are sensitive to it.</p>
                    <p>Other common allergens include mold, dust mites, and pet dander.</p>
                    <p>Symptoms of seasonal allergies include:</p>
                    <ul>
                        <li>Runny nose</li>
                        <li>Sneezing</li>
                        <li>Itchy eyes</li>
                        <li>Itchy nose</li>
                        <li>Itchy throat</li>
                        <li>Itchy skin</li>
                        <li>Wheezing</li>
                        <li>Coughing</li>
                        <li>Shortness of breath</li>
                        <li>Swelling of the face, lips, tongue, or throat</li>
                    </ul>
                    <p>If you are aware you have a condition that is affected by the weather or by seasonal allergens, you can take steps to protect yourself. For example, if you have asthma, you can take your medicine before going outside on a hot day. If you have a cold, you can wear a scarf to keep your nose warm.</p>
                    <p>Before going out it is important to check the weather forecast and the air quality in order to make choices that will help you to stay healthy.</p>
                    <p>For more information on how to protect yourself from seasonal allergies, please visit the <a href="https://www.nhs.uk/conditions/allergies/">NHS website</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content -->
</body>
</html>

