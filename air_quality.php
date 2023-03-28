<?php
session_start();
include 'Library/dbconnect.php';
$conn = connect(); //this calls the connection function from the dbconnect.php file and returns the connection object to the variable $conn

$nav_hidden = "";
$nav_unhidden = "hidden";
if (isset($_SESSION["userid"])) {
    $nav_hidden = "hidden";
    $nav_unhidden = "";
} //this is used to hide the sign up button if the user is logged in and to hide the logout button if the user is not logged in

if (!isset($_SESSION["set_location"])) {
    $_SESSION["set_location"] = "London";
} //this checks if the user has set a location and if not sets it to London

if (isset($_POST['set_location'])) {
    $_SESSION["set_location"] = $_POST['set_location'];
} //this checks if the user has set a new location and sets it to that location


if (!isset($_SESSION['selected_time'])) {
    $_SESSION['selected_time'] = "false";
}
if (isset($_POST["time_selected"])) {
    $_SESSION['selected_time'] = $_POST["time_selected"];
}

if (!isset($_SESSION["selected_day"])) {
    $_SESSION["selected_day"] = 0;
} //this checks if the user has set a day else sets it to 0 (current day)

if (isset($_POST['selected_day'])) {
    $_SESSION["selected_day"] = intval($_POST['selected_day']);
}
if (isset($_POST['forward_selected_day'])) {
    if ($_SESSION["selected_day"] == 2) {
        $_SESSION["selected_day"] = 0;
    } else {
        $_SESSION["selected_day"] = $_SESSION["selected_day"] + 1;
    }
}
if (isset($_POST['back_selected_day'])) {
    if ($_SESSION["selected_day"] == 0) {
        $_SESSION["selected_day"] = 2;
    } else {
        $_SESSION["selected_day"] = $_SESSION["selected_day"] - 1;
    }
}
?>
<doctype html>
<html>
<header>
    <title>Forecast</title>
    <link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
    <script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-core.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.0.1/js/anychart-pie.min.js"></script>
</header>
<script>
var weather_location = "<?php echo "" . $_SESSION["set_location"]?>"

const settings = {
	"async": true,
	"crossDomain": true,
	"url": `http://api.weatherapi.com/v1/forecast.json?key=af5d6949e83c4c10ab6103819230803&q=${weather_location}&days=3&aqi=yes&alerts=yes`,
	"method": "GET"
}; //this is the API call to get the weather data


var selected_time = "<?php echo "" . $_SESSION['selected_time']?>"
if (selected_time == "false") 
{
    const current_day = new Date();
    let hour = current_day.getHours()
    var selected_time = hour
}
else
{
    var selected_time = selected_time 
} //this checks if the user has selected a time and if not sets it to the current time

var selected_day = "<?php echo "" . $_SESSION['selected_day']?>" //this gets the selected day from the session variable

$.ajax(settings).done(function (weather_data) {
    console.log(weather_data);
});
// this is the javascript to create the chart taken from the source in my log 
anychart.onDocumentReady(function() {
  $.ajax(settings).done(function (weather_data) {
// set the data
    var chart_data = [
        {x: "Carbon Monoxide (CO)", value: weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.co},
        {x: "Nitrogen Dioxide (NO2)", value: weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.no2},
        {x: "Ozone (O3)", value: weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.o3},
        {x: "Fine particulate matter (PM2.5)", value: weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.pm2_5},
        {x: "Particulate Matter (PM10)", value: weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.pm10},
        {x: "Sulfer Dioxide (SO2)", value: weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.so2}
    ];
    // create the chart
    var chart = anychart.pie();

    // set the chart title
    chart.title("Amount of Air Pollution in micrograms per cubic meter of air (µg/m³)");

    // add the data
    chart.data(chart_data);

    // display the chart in the container
    chart.container('chart_container');
    chart.draw();

  });
});
</script>
<style>
    .table {
        margin: 0 auto;
        width: 50%;
        font-size: 20px;
    }
</style>
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
<!-- start of main content -->
<div>
    <h1 id="pagetitle" style="text-align: center; "></h1>
    <form class="d-flex" style="margin-left: 80%;" action="air_quality.php" method="post"> 
        <input class="form-control me-sm-2" name="set_location" type="search" placeholder="Search Location/Postcode">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button> <!-- this is the search bar for the location of the weather -->
    </form>
</div>
<div id="weather_spacing">
<h2 style="text-align: center;">Day</h2>
<div class="container">
<div div class="d-flex justify-content-center">
  <ul class="pagination pagination-lg">
    <li class="page-item">
    <form id="form_day_selection_backward" action="air_quality.php" method="post">
    <button class="btn btn-primary">&laquo;</button>
    <input class="form-control" name="back_selected_day" type="hidden" value="-1">
    </form>
    </li>
    <li class="page-item active">
    <form id="form_day_selection1" action="air_quality.php" method="post">
    <button value="0" class="btn btn-primary">1</button>
    <input class="form-control" name="selected_day" type="hidden" value="0">
    </form>
    </li>
    <li class="page-item">
    <form id="form_day_selection2" action="air_quality.php" method="post">
      <button value="1" class="btn btn-primary">2</button>
      <input class="form-control" name="selected_day" type="hidden" value="1">
    </form>
    </li>
    <li class="page-item">
    <form id="form_day_selection3" action="air_quality.php" method="post">
      <button value="2" class="btn btn-primary">3</button>
      <input class="form-control" name="selected_day" type="hidden" value="2">
    </form>  
    </li>
    <li class="page-item">
    <form id="form_day_selection_forward" action="air_quality.php" method="post">
    <button class="btn btn-primary">&raquo;</button>
    <input class="form-control" name="forward_selected_day" type="hidden" value="1">
    </form>
    </li>
  </ul>
</form> <!-- this is the day selection for the weather -->
</div>
<form class="d-flex" name="time_selection" id="time_selection" action="air_quality.php" method="post"> 
    <div class="form-group">
      <label for="date_display" class="form-label mt-4">Date</label>
      <input class="form-control" type="text" name="date_display" id="date_display" value="<?php echo (date("Y-m-d", strtotime("+" . $_SESSION["selected_day"] . " days"))); ?>" disabled>
    </div>
    <div class="form-group">
      <label for="time_select" class="form-label mt-4">Time</label>
      <select class="form-select" name="time_selected" id="time_select">
        <!-- this is the time selection for the weather -->
        <option value="0" <?php if($_SESSION['selected_time'] == "0"){ echo "selected='selected'"; }?> >00:00</option>
        <option value="1" <?php if($_SESSION['selected_time'] == "1"){ echo "selected='selected'"; }?> >01:00</option>
        <option value="2" <?php if($_SESSION['selected_time'] == "2"){ echo "selected='selected'"; }?> >02:00</option>
        <option value="3" <?php if($_SESSION['selected_time'] == "3"){ echo "selected='selected'"; }?> >03:00</option>
        <option value="4" <?php if($_SESSION['selected_time'] == "4"){ echo "selected='selected'"; }?> >04:00</option>
        <option value="5" <?php if($_SESSION['selected_time'] == "5"){ echo "selected='selected'"; }?> >05:00</option>
        <option value="6" <?php if($_SESSION['selected_time'] == "6"){ echo "selected='selected'"; }?> >06:00</option>
        <option value="7" <?php if($_SESSION['selected_time'] == "7"){ echo "selected='selected'"; }?> >07:00</option>
        <option value="8" <?php if($_SESSION['selected_time'] == "8"){ echo "selected='selected'"; }?> >08:00</option>
        <option value="9" <?php if($_SESSION['selected_time'] == "9"){ echo "selected='selected'"; }?> >09:00</option>
        <option value="10" <?php if($_SESSION['selected_time'] == "10"){ echo "selected='selected'"; }?> >10:00</option>
        <option value="11" <?php if($_SESSION['selected_time'] == "11"){ echo "selected='selected'"; }?> >11:00</option>
        <option value="12" <?php if($_SESSION['selected_time'] == "12"){ echo "selected='selected'"; }?> >12:00</option>
        <option value="13" <?php if($_SESSION['selected_time'] == "13"){ echo "selected='selected'"; }?> >13:00</option>
        <option value="14" <?php if($_SESSION['selected_time'] == "14"){ echo "selected='selected'"; }?> >14:00</option>
        <option value="15" <?php if($_SESSION['selected_time'] == "15"){ echo "selected='selected'"; }?> >15:00</option>
        <option value="16" <?php if($_SESSION['selected_time'] == "16"){ echo "selected='selected'"; }?> >16:00</option>
        <option value="17" <?php if($_SESSION['selected_time'] == "17"){ echo "selected='selected'"; }?> >17:00</option>
        <option value="18" <?php if($_SESSION['selected_time'] == "18"){ echo "selected='selected'"; }?> >18:00</option>
        <option value="19" <?php if($_SESSION['selected_time'] == "19"){ echo "selected='selected'"; }?> >19:00</option>
        <option value="20" <?php if($_SESSION['selected_time'] == "20"){ echo "selected='selected'"; }?> >20:00</option>
        <option value="21" <?php if($_SESSION['selected_time'] == "21"){ echo "selected='selected'"; }?> >21:00</option>
        <option value="22" <?php if($_SESSION['selected_time'] == "22"){ echo "selected='selected'"; }?> >22:00</option>
        <option value="23" <?php if($_SESSION['selected_time'] == "23"){ echo "selected='selected'"; }?> >23:00</option> 
        <!-- this is the time selection for the weather -->
      </select>
    </div>
    </form>
  <div class="row">
    <div class="col">
    <div>
        <h2 id="air_quality"></h2>
        <div id="chart_container"></div>
    </div>
    </div>
    <div class="col">
    <table class="table" style="width: 100%; margin-top: 7%;">
    <thead>
    <tr>
    <th scope="col">Pollutant</th>
    <th scope="col">Amount µg/m³</th>
    </tr>
    <tbody>
    <tr>
    <th scope="row">Carbon Monoxide (CO)</th>
    <td id="co3_levels"></td>
    </tr>
    <tr>
    <th scope="row">Nitrogen Dioxide (NO2)</th>
    <td id="no2_levels"></td>
    </tr>
    <th scope="row">Ozone (O3)</th>
    <td id="o3_levels"></td>
    </tr>
    <tr>
    <th scope="row">Fine particulate matter (PM2.5)</th>
    <td id="pm2_5_levels"></td>
    </tr>
    <tr>
    <th scope="row">Particulate matter (PM10)</th>
    <td id="pm10_levels"></td>
    </tr>
    <tr>
    <th scope="row">Sulphur Dioxide (SO2)</th>
    <td id="so2_levels"></td>
    </tr>
    </tbody> <!-- this is the table of air quality data -->
    </table>
    </div>
    </div>
  </div>
</div>
<div style="margin-top: 5%;">
<div id="guidance_alert" class="alert alert-dismissible alert-success">
  <h4 id="guidance_alert_heading" class="alert-heading" style="text-align: center;"></h4>
  <p id="guidance_alert_text" class="mb-0" style="text-align: center;"></p>
</div> <!-- this is the guidance alert -->
</div>

<script>
var pagetitle = document.getElementById("pagetitle");
pagetitle.innerHTML = "Air Quality for " + weather_location; //this changes the heading of the page to match the location of the air quality
$.ajax(settings).done(function (weather_data) {
var co3_levels = document.getElementById("co3_levels");
co3_levels.innerHTML = Math.round(weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.co * 10) / 10 + " µg/m³"; //this changes the CO2 levels to match the CO2 levels in the api
var no2_levels = document.getElementById("no2_levels");
no2_levels.innerHTML = Math.round(weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.no2 * 10) / 10 + " µg/m³"; //this changes the Nitrogen Dioxide (NO2) to match the Nitrogen Dioxide (NO2) in the api
var o3_levels = document.getElementById("o3_levels");
o3_levels.innerHTML = Math.round(weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.o3 * 10) / 10 + " µg/m³"; //this changes the Ozone (O3) to match the Ozone (O3) in the api
var pm2_5_levels = document.getElementById("pm2_5_levels");
pm2_5_levels.innerHTML = Math.round(weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.pm2_5 * 10) / 10 + " µg/m³"; //this changes the Fine particulate matter (PM2.5) to match the Fine particulate matter (PM2.5) in the api
var pm10_levels = document.getElementById("pm10_levels");
pm10_levels.innerHTML = Math.round(weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.pm10 * 10) / 10 + " µg/m³"; //this changes the Particulate matter (PM10) to match the Particulate matter (PM10) in the api
var so2_levels = document.getElementById("so2_levels");
so2_levels.innerHTML = Math.round(weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality.so2 * 10) / 10 + " µg/m³"; //this changes the Sulphur Dioxide (SO2) to match the Sulphur Dioxide (SO2) in the api



var air_quality = document.getElementById("air_quality");
var guidance_alert = document.getElementById("guidance_alert");
var guidance_alert_heading = document.getElementById("guidance_alert_heading");
var guidance_alert_text = document.getElementById("guidance_alert_text");
if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 3){
    air_quality.style.color = "green";
    air_quality.innerHTML = "The Air Quality is Good";
    guidance_alert.classList.add("alert-success");
    guidance_alert_heading.innerHTML = "Good Air Quality";
    guidance_alert_text.innerHTML = "Air quality is considered satisfactory, and air pollution poses little or no risk, you are safe to go outside and exercise/do daily activities.";

}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 4){
    air_quality.style.color = "yellow";
    air_quality.innerHTML = "The Air Quality is Moderate";
    guidance_alert.classList.add("alert-warning");
    guidance_alert_heading.innerHTML = "Moderate Air Quality";
    guidance_alert_text.innerHTML = "Air quality is acceptable; however, for some pollutants there may be a moderate health concern for a very small number of people who are unusually sensitive to air pollution. You are safe to go outside and exercise/do daily activities.";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 6){
    air_quality.style.color = "orange";
    air_quality.innerHTML = "The Air Quality is Unhealthy for Sensitive Groups";
    guidance_alert.classList.add("alert-warning");
    guidance_alert_heading.innerHTML = "Unhealthy for Sensitive Groups";
    guidance_alert_text.innerHTML = "Members of sensitive groups may experience health effects. The general public is less likely to be affected. Most people are safe to go outside and exercise/do daily activities.";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 7){
    air_quality.style.color = "red";
    air_quality.innerHTML = "The Air Quality is Unhealthy";
    guidance_alert.classList.add("alert-danger");
    guidance_alert_heading.innerHTML = "Unhealthy Air Quality";
    guidance_alert_text.innerHTML = "Everyone may begin to experience health effects; members of sensitive groups may experience more serious health effects. Going outside and exercising/do daily activities is not recommended and may put you at risk of health problems.";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 9){
    air_quality.style.color = "purple";
    air_quality.innerHTML = "The Air Quality is Very Unhealthy";
    guidance_alert.classList.add("alert-danger");
    guidance_alert_heading.innerHTML = "Very Unhealthy Air Quality";
    guidance_alert_text.innerHTML = "Health warnings of emergency conditions. The entire population is more likely to be affected. Do not go out and exposure yourself for long periods of time without protection. If you have to go outside, protect yourself from the air pollution.";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 10){
    air_quality.style.color = "maroon";
    air_quality.innerHTML = "The Air Quality is Hazardous";
    guidance_alert.classList.add("alert-danger");
    guidance_alert_heading.innerHTML = "Hazardous Air Quality";
    guidance_alert_text.innerHTML = "Health alert: everyone may experience more serious health effects. Do not go outside and exercise/do daily activities. If you have to go outside, protect yourself from the air pollution and minimise your exposure to the air pollution wherever possible.";
}
else {
    air_quality.style.color = "white";
    air_quality.innerHTML = "Unknown";
} //this changes the air quality to match the air quality in the api
});
document.getElementById('time_select').onchange = function() {
    selected_time = time_select.value;
    document.getElementById("time_selection").submit();
} //this changes the time selected to match the time selected in the api
</script>