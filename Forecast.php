<?php
include 'Library/dbconnect.php';
$conn = connect(); //this calls the connection function from the dbconnect.php file and returns the connection object to the variable $conn
?>
<doctype html>
<html>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
}; //this is the API call to get the weather data

$.ajax(settings).done(function (weatherdata) {
	console.log(weatherdata);
    console.log(weatherdata.current.cloud);
});

</script>
<header>
    <title>Forecast</title>
</header>
<body>
<!-- navbar -->
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
<!-- start of main content -->
<div>
<h1 id="pagetitle" style="text-align: center; "></h1>
<form class="d-flex" style="margin-left: 80%;" action="forecast.php" method="post"> 
    <input class="form-control me-sm-2" type="search" placeholder="Search Location">
    <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button> <!-- this is the search bar for the location of the weather -->
</form>
<script>
    var pagetitle = document.getElementById("pagetitle");
    pagetitle.innerHTML = "Forecast for " + weatherlocation; //this changes the heading of the page to match the location of the weather
</script>