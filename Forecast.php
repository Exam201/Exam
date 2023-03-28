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
} //this checks if the user has selected a time and sets it to that time

if (!isset($_SESSION["selected_day"])) {
    $_SESSION["selected_day"] = 0;
    echo "!";
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
            <a class="nav-link" href="settings.php">Settings</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- end navbar -->
  <!-- start of main content -->
  <div>
      <h1 id="page_title" style="text-align: center; "></h1>
      <form class="d-flex" style="margin-left: 80%;" action="forecast.php" method="post"> 
          <input class="form-control me-sm-2" name="set_location" type="search" placeholder="Search Location/Postcode">
          <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button> <!-- this is the search bar for the location of the weather -->
      </form>
      <div id="weather_alert" hidden class="alert alert-dismissible alert-warning">
          <button type="button" class="btn-close" data-bs-dismiss="alert" onclick="close_alert()"></button>
          <h4 style="text-align: center;" class="alert-heading">Warning!</h4>
          <p style="text-align: center;" id="weather_warning" class="mb-0"></p>
      </div>
  </div>
  <div id="weather_spacing">
  <h2 style="text-align: center;">Day</h2>
  <div class="container">
  <div div class="d-flex justify-content-center">
    <ul class="pagination pagination-lg">
      <li class="page-item">
        <form id="form_day_selection_backward" action="forecast.php" method="post">
          <button class="btn btn-primary">&laquo;</button>
          <input class="form-control" name="back_selected_day" type="hidden" value="-1">
        </form>
      </li>
      <li class="page-item active">
        <form id="form_day_selection1" action="forecast.php" method="post">
          <button value="0" class="btn btn-primary">1</button>
          <input class="form-control" name="selected_day" type="hidden" value="0">
        </form>
      </li>
      <li class="page-item">
        <form id="form_day_selection2" action="forecast.php" method="post">
          <button value="1" class="btn btn-primary">2</button>
          <input class="form-control" name="selected_day" type="hidden" value="1">
        </form>
      </li>
      <li class="page-item">
        <form id="form_day_selection3" action="forecast.php" method="post">
          <button value="2" class="btn btn-primary">3</button>
          <input class="form-control" name="selected_day" type="hidden" value="2">
        </form>  
      </li>
      <li class="page-item">
        <form id="form_day_selection_forward" action="forecast.php" method="post">
          <button class="btn btn-primary">&raquo;</button>
          <input class="form-control" name="forward_selected_day" type="hidden" value="1">
        </form>
      </li>
    </ul>
  </form>
  </div>
  <form class="d-flex" name="time_selection" id="time_selection" action="forecast.php" method="post"> 
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
      <div style="margin-top: 4%;">
          <h2 id="weather_description"></h2>
          <img id="weather_icon" src="" alt="" style="width: 150px; height: 150px;">
      </div>
      </div>
      <div class="col">
      <table class="table" style="width: 100%;">
      <tbody>
      <tr>
        <th scope="row">Temperature</th>
        <td id="temperature"></td>
      </tr>
      <tr>
      <th scope="row">Humidity</th>
      <td id="humidity"></td>
      </tr>
      <tr>
      <th scope="row">Wind Speed</th>
      <td id="wind_speed"></td>
      </tr>
      <tr>
      <th scope="row">Maximum Gusts</th>
      <td id="maximum_gusts"></td>
      </tr>
      <th scope="row">Chance of rain</th>
      <td id="rain_chance"></td>
      </tr>
      <tr>
      <th scope="row">Air Quality</th>
      <td id="air_quality"></td>
      </tr>
      </tbody>
      </table>
      </div>
      </div>
    </div>
</body>
</html>

<script>
    var page_title = document.getElementById("page_title");
    page_title.innerHTML = "Forecast for " + weather_location; //this changes the heading of the page to match the location of the weather
$.ajax(settings).done(function (weather_data) {
    var weather_warning = document.getElementById("weather_warning");
    var alert_text = "";
if (weather_data.alerts.alert.length != 0) { // this checks if there is any weather warnings in the api array
    var weather_alert = document.getElementById("weather_alert"); //if there is no warnings this hides the warning box
    weather_alert.hidden = "";
    var weather_spacing = document.getElementById("weather_spacing");
    weather_spacing.style.marginTop = "0px";
    array_length = weather_data.alerts.alert.length;
    for (var i = 0; i < weather_data.alerts.alert.length; i++) {
        if (i == 0) {
            var alert_text = alert_text + weather_data.alerts.alert[i].headline + " for " + weather_location  + "<br>" ; //this changes the string to match the location of the weather and the warning for the first alert
        }
        else if ((weather_data.alerts.alert[i].headline == weather_data.alerts.alert[i].headline) || (weather_data.alerts.alert[i].headline == weather_data.alerts.alert[0].headline)) {
           continue;
        }
        else {
            var alert_text = alert_text + weather_data.alerts.alert[i].headline + " for " + weather_location  + "<br>" ; //this changes the string to match the location of the weather and the warning
        }
        }
    }
    
var weather_icon= document.getElementById("weather_icon");
weather_icon.src = weather_data.forecast.forecastday[selected_day].hour[selected_time].condition.icon; //this changes the weather icon to match the weather
weather_icon.alt = weather_data.forecast.forecastday[selected_day].hour[selected_time].condition.text; //this changes the weather icon alt text to match the weather
weather_warning.innerHTML = alert_text; //this changes the warning to match the warning
var temperature = document.getElementById("temperature");
temperature.innerHTML = weather_data.forecast.forecastday[selected_day].hour[selected_time].temp_c + "°C"; //this changes the temperature to match the temperaturein the api
var humidity = document.getElementById("humidity");
humidity.innerHTML = weather_data.forecast.forecastday[selected_day].hour[selected_time].humidity + "%"; //this changes the humidity to match the humidity in the api
var wind_speed = document.getElementById("wind_speed");
wind_speed.innerHTML = weather_data.forecast.forecastday[selected_day].hour[selected_time].wind_mph + " miles/h"; //this changes the wind speed to match the wind speed in the api
var maximum_gusts = document.getElementById("maximum_gusts");
maximum_gusts.innerHTML = weather_data.forecast.forecastday[selected_day].hour[selected_time].gust_mph + " miles/h"; //this changes the maximum gusts to match the maximum gusts in the api
var air_quality = document.getElementById("air_quality");
var rain_chance = document.getElementById("rain_chance");
rain_chance.innerHTML = weather_data.forecast.forecastday[selected_day].hour[selected_time].chance_of_rain + "%"; //this changes the chance of rain to match the chance of rain in the api
var weather_description = document.getElementById("weather_description");
weather_description.innerHTML = weather_data.forecast.forecastday[selected_day].hour[selected_time].condition.text; //this changes the weather description to match the weather description in the api

if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <+ 3){
    air_quality.style.color = "green";
    air_quality.innerHTML = "Good";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 4){
    air_quality.style.color = "yellow";
    air_quality.innerHTML = "Moderate";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 6){
    air_quality.style.color = "orange";
    air_quality.innerHTML = "Unhealthy for Sensitive Groups";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 7){
    air_quality.style.color = "red";
    air_quality.innerHTML = "Unhealthy";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 9){
    air_quality.style.color = "purple";
    air_quality.innerHTML = "Very Unhealthy";
}
else if (weather_data.forecast.forecastday[selected_day].hour[selected_time].air_quality["gb-defra-index"] <= 10){
    air_quality.style.color = "maroon";
    air_quality.innerHTML = "Hazardous";
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
function close_alert() {
    var weather_alert = document.getElementById("weather_alert");
    weather_alert.hidden = "hidden";
} //this hides the weather alert box
function day_forward() {
    selected_day = parseInt(selected_day);
    if (selected_day == 2) {
        selected_day = 0;
    }
    else {
        selected_day = selected_day + 1;
    }

} //this changes the day forward to match the day forward in the api
</script>