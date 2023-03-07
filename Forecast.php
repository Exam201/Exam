<?php
include 'Library/dbconnect.php';
$conn = connect(); //this calls the connection function from the dbconnect.php file and returns the connection object to the variable $conn
?>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- navbar -->
<script>
var weatherlocation = "London";
const settings = {
	"async": true,
	"crossDomain": true,
	"url": `https://weatherapi-com.p.rapidapi.com/forecast.json?q=${weatherlocation}&days=3`,
	"method": "GET",
	"headers": {
		"X-RapidAPI-Key": "79171e5d24msh41c8d90c88ee23fp1efeb4jsnea0811d2e874",
		"X-RapidAPI-Host": "weatherapi-com.p.rapidapi.com"
	}
};

$.ajax(settings).done(function (weatherdata) {
	console.log(weatherdata);
    console.log(weatherdata.current.cloud);
});


</script>
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
          <a class="nav-link" href="Forecast.php">Forecast</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Air Quality</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Guidance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Settings</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- end navbar -->