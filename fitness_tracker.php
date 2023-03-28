<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header('location: login.php');
}
$nav_hidden = "";
$nav_unhidden = "hidden";
if (isset($_SESSION["userid"])) {
    $nav_hidden = "hidden";
    $nav_unhidden = "";
} //this is used to hide the sign up button if the user is logged in and to hide the logout button if the user is not logged in


if (!isset($_SESSION['selected_time'])) {
    $_SESSION['selected_time'] = "false";
}
if (isset($_POST["time_selected"])) {
    $_SESSION['selected_time'] = $_POST["time_selected"];
} //this checks if the user has selected a time and sets it to that time

if (!isset($_SESSION["set_location"])) {
    $_SESSION["set_location"] = "London";
} //this checks if the user has set a location and if not sets it to London

if (isset($_POST['set_location'])) {
    $_SESSION["set_location"] = $_POST['set_location'];
} //this checks if the user has set a new location and sets it to that location

include 'Library/dbconnect.php';
$conn = connect(); //this calls the connection function from the dbconnect.php file and returns the connection object to the variable $conn
$query = "SELECT * FROM user_data JOIN fitness_data ON user_data.user_id = fitness_data.user_id WHERE user_data.user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", ($_SESSION['userid']));
$stmt->execute();
$result = $stmt->get_result();
$fitness_data = $result->fetch_all(MYSQLI_ASSOC); //this is used to get the data from the database and store it in the variable $fitness_data

$today_date = date('Y-m-d'); //this is used to get the current date

if (empty($fitness_data)) {
    $query = "INSERT INTO fitness_data (user_id, date, steps) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $_SESSION['userid'], $today_date);
    $stmt->execute();
    $query = "SELECT * FROM user_data JOIN fitness_data ON user_data.user_id = fitness_data.user_id WHERE user_data.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", ($_SESSION['userid']));
    $stmt->execute();
    $result = $stmt->get_result();
    $fitness_data = $result->fetch_all(MYSQLI_ASSOC);
} //this is used to check if the user has any data in the fitness_data table and if not insert a row with the current date and 0 steps to prevent errors

$today_steps = 0;
$last_week_steps = 0;
$last_month_steps = 0;
$last_year_steps = 0;
$total_steps = 0; //these are used to store the total number of steps for each time period
$last_week_date = date('Y-m-d', strtotime('-1 week')); //this is used to get the date from a week ago
$last_month_date = date('Y-m-d', strtotime('-1 month')); //this is used to get the date from a month ago
$last_year_date = date('Y-m-d', strtotime('-1 year')); //this is used to get the date from a year ago
foreach ($fitness_data as $data) {
    if ($data['date'] == $today_date) {
        $today_steps += $data['steps'];
    }
    if ($data['date'] >= $last_week_date && $data['date'] <= $today_date) {
        $last_week_steps += $data['steps'];
    }
    if ($data['date'] >= $last_month_date && $data['date'] <= $today_date) {
        $last_month_steps += $data['steps'];
    }
    if ($data['date'] >= $last_year_date && $data['date'] <= $today_date) {
        $last_year_steps += $data['steps'];
    }
    $total_steps += $data['steps'];
} //this is used to calculate the total number of steps for each time period and store it in the variable $today_steps, $last_week_steps, $last_month_steps, $last_year_steps, and $total_steps respectively while also including the steps from the current day


$distance_values = [
    "65"=> 1992,
    "64"=> 2018,
    "63"=> 2045,
    "62"=> 2071,
    "61"=> 2101,
    "60"=> 2130,
    "511"=> 2160,
    "510"=> 2191,
    "59"=> 2223,
    "58"=> 2256,
    "57"=> 2289,
    "56"=> 2324,
    "55"=> 2360,
    "54"=> 2397,
    "53"=> 2435,
    "52"=> 2474,
    "51"=> 2514,
    "50"=> 2556,
    "411"=> 2600,
    "410"=> 2645
];


$height = (strval($fitness_data[0]['height_feet']) . (strval($fitness_data[0]['height_inch']))); //this is used to get the height of the user from the database and convert it to a string so it can be used as an index in the array $distance_values
$steps_in_mile = $distance_values[$height];
$today_distance = $today_steps / $steps_in_mile;
$last_week_distance = $last_week_steps / $steps_in_mile;
$last_month_distance = $last_month_steps / $steps_in_mile;
$last_year_distance = $last_year_steps / $steps_in_mile;
$total_distance = $total_steps / $steps_in_mile; //this is used to calculate the distance the user has walked in miles


$today_calories = $today_steps * 0.04;
$last_week_calories = $last_week_steps * 0.04;
$last_month_calories = $last_month_steps * 0.04;
$last_year_calories = $last_year_steps * 0.04;
$total_calories = $total_steps * 0.04; //this is used to calculate the calories the user has burned


$jan = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-01-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-01-31'));
});
$feb = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-02-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-02-28'));
});
$mar = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-03-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-03-31'));
});
$apr = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-04-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-04-30'));
});
$may = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-05-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-05-31'));
});
$jun = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-06-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-06-30'));
});
$jul = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-07-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-07-31'));
});
$aug = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-08-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-08-31'));
});
$sep = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-09-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-09-30'));
});
$oct = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-10-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-10-31'));
});
$nov = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-11-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-11-30'));
});
$dec = array_filter($fitness_data, function ($item) {
    return $item['date'] >= date('Y-m-d', strtotime('2023-12-01')) && $item['date'] <= date('Y-m-d', strtotime('2023-12-31'));
}); //this splits the steps into months starting from the 1st of january of the current year and ending on the 31st of december of the current year

$jan_steps = array_sum(array_column($jan, 'steps'));
$feb_steps = array_sum(array_column($feb, 'steps'));
$mar_steps = array_sum(array_column($mar, 'steps'));
$apr_steps = array_sum(array_column($apr, 'steps'));
$may_steps = array_sum(array_column($may, 'steps'));
$jun_steps = array_sum(array_column($jun, 'steps'));
$jul_steps = array_sum(array_column($jul, 'steps'));
$aug_steps = array_sum(array_column($aug, 'steps'));
$sep_steps = array_sum(array_column($sep, 'steps'));
$oct_steps = array_sum(array_column($oct, 'steps'));
$nov_steps = array_sum(array_column($nov, 'steps'));
$dec_steps = array_sum(array_column($dec, 'steps'));
//this is used to get the total steps for each month

$jan_distance = $jan_steps / $steps_in_mile;
$feb_distance = $feb_steps / $steps_in_mile;
$mar_distance = $mar_steps / $steps_in_mile;
$apr_distance = $apr_steps / $steps_in_mile;
$may_distance = $may_steps / $steps_in_mile;
$jun_distance = $jun_steps / $steps_in_mile;
$jul_distance = $jul_steps / $steps_in_mile;
$aug_distance = $aug_steps / $steps_in_mile;
$sep_distance = $sep_steps / $steps_in_mile;
$oct_distance = $oct_steps / $steps_in_mile;
$nov_distance = $nov_steps / $steps_in_mile;
$dec_distance = $dec_steps / $steps_in_mile;
//this is used to get the total distance for each month

$jan_calories = $jan_steps * 0.04;
$feb_calories = $feb_steps * 0.04;
$mar_calories = $mar_steps * 0.04;
$apr_calories = $apr_steps * 0.04;
$may_calories = $may_steps * 0.04;
$jun_calories = $jun_steps * 0.04;
$jul_calories = $jul_steps * 0.04;
$aug_calories = $aug_steps * 0.04;
$sep_calories = $sep_steps * 0.04;
$oct_calories = $oct_steps * 0.04;
$nov_calories = $nov_steps * 0.04;
$dec_calories = $dec_steps * 0.04;
//this is used to get the total calories for each month


?>
<doctype html>
<html>
<header>
<title>Fitness Tracker</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

var weather_location = "<?php echo "" . $_SESSION["set_location"]?>" //this is used to get the location from the session variable
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

const settings = {
	"async": true,
	"crossDomain": true,
	"url": `http://api.weatherapi.com/v1/forecast.json?key=af5d6949e83c4c10ab6103819230803&q=${weather_location}&days=3&aqi=yes&alerts=yes`,
	"method": "GET"
}; //this is the API call to get the weather data
</script>
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
        <li class="nav-item">
          <a class="nav-link" href="settings.php">Settings</a>
        </li>
        <li class="nav-item" <?php echo "$nav_unhidden"; ?> >
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- end navbar -->
<!-- main content -->
<h1 style="text-align: center;">Fitness Tracker</h1>
<div class="container" style="margin-top: 2%; text-align: center;">
  <div class="row">
    <div class="col-sm">
      <h2>Steps</h2>
      <p>Steps taken today: <?php echo $today_steps; ?></p>
      <p>Steps taken this week: <?php echo $last_week_steps; ?></p>
      <p>Steps taken this month: <?php echo $last_month_steps; ?></p>
      <p>Steps taken this year: <?php echo $last_year_steps; ?></p>
      <p>Steps taken all time: <?php echo $total_steps; ?></p>
    </div>
    <div class="col-sm">
      <h2>Calories</h2>
        <p>Aproximately <?php echo "$today_calories"; ?> calories burned today</p>
        <p>Aproximately <?php echo "$last_week_calories"; ?> calories burned this week</p>
        <p>Aproximately <?php echo "$last_month_calories"; ?> calories burned this month</p>
        <p>Aproximately <?php echo "$last_year_calories"; ?> calories burned this year</p>
        <p>Aproximately <?php echo "$total_calories"; ?> calories burned all time</p>
    </div>
    <div class="col-sm">
      <h2>Distance (in miles)</h2>
      <p>Distance travelled today: <?php echo (round($today_distance, 2)) ?></p>
      <p>Distance travelled this week: <?php echo (round($last_week_distance, 2)) ?></p>
      <p>Distance travelled this month: <?php echo (round($last_month_distance, 2)) ?></p>
      <p>Distance travelled this year: <?php echo (round($last_year_distance, 2)) ?></p>
      <p>Distance travelled all time: <?php echo (round($total_distance, 2)) ?></p>
    </div>
  </div>
</div>
<div style="text-align: center; margin-top: 2%;">
    <h2>Data over the last 12 months</h2>
    <p>Click on the buttons above the chart to change the data displayed</p>
</div>
<div class="container" style="margin-left:5%; margin-right:5%; max-width:90%;">
    <div class="row" style="">
<div class="col-3" style="text-align: left;">
<h2 id="weather_title" style="display:inline-block";>Weather</h2>
    <form class="d-flex" name="time_selection" id="time_selection" action="fitness_tracker.php" method="post">
        <div class="form-group">
            <label for="date_display" class="form-label mt-4">Date</label>
            <input class="form-control" type="text" name="date_display" id="date_display" value="<?php echo date("d-m-Y"); ?>" disabled>
        </div>
        <div class="form-group" style="margin-left:1%">
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
    </div>
</div>

<div class="col-6">
     <div class="chart-container" style="position: relative;">
        <canvas id="line_chart" style="background-color: white; width:100%; margin-left:auto; margin-right:auto;"></canvas>
    </div>
</div>
<div class="col-3">
    <h2 id="air_quality"></h2>
    <table class="table" style="">
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
    </tbody>
    </table>
</div>
</div>
</div>
<div style="margin-top:1%;">
<div id="guidance_alert" class="alert alert-dismissible alert-success">
  <h4 id="guidance_alert_heading" class="alert-heading" style="text-align: center;"></h4>
  <p id="guidance_alert_text" class="mb-0" style="text-align: center;"></p>
</div>
</body>
</html>
<script>
//this is the javascript for the chart on the fitness tracker page

var jan_steps = <?php echo $jan_steps; ?>;
var feb_steps = <?php echo $feb_steps; ?>;
var mar_steps = <?php echo $mar_steps; ?>;
var apr_steps = <?php echo $apr_steps; ?>;
var may_steps = <?php echo $may_steps; ?>;
var jun_steps = <?php echo $jun_steps; ?>;
var jul_steps = <?php echo $jul_steps; ?>;
var aug_steps = <?php echo $aug_steps; ?>;
var sep_steps = <?php echo $sep_steps; ?>;
var oct_steps = <?php echo $oct_steps; ?>;
var nov_steps = <?php echo $nov_steps; ?>;
var dec_steps = <?php echo $dec_steps; ?>;
//this gets the data from the php script and puts it into the javascript

var jan_distance = <?php echo $jan_distance; ?>;
var feb_distance = <?php echo $feb_distance; ?>;
var mar_distance = <?php echo $mar_distance; ?>;
var apr_distance = <?php echo $apr_distance; ?>;
var may_distance = <?php echo $may_distance; ?>;
var jun_distance = <?php echo $jun_distance; ?>;
var jul_distance = <?php echo $jul_distance; ?>;
var aug_distance = <?php echo $aug_distance; ?>;
var sep_distance = <?php echo $sep_distance; ?>;
var oct_distance = <?php echo $oct_distance; ?>;
var nov_distance = <?php echo $nov_distance; ?>;
var dec_distance = <?php echo $dec_distance; ?>;
//this gets the data from the php script and puts it into the javascript

var jan_calories = <?php echo $jan_calories; ?>;
var feb_calories = <?php echo $feb_calories; ?>;
var mar_calories = <?php echo $mar_calories; ?>;
var apr_calories = <?php echo $apr_calories; ?>;
var may_calories = <?php echo $may_calories; ?>;
var jun_calories = <?php echo $jun_calories; ?>;
var jul_calories = <?php echo $jul_calories; ?>;
var aug_calories = <?php echo $aug_calories; ?>;
var sep_calories = <?php echo $sep_calories; ?>;
var oct_calories = <?php echo $oct_calories; ?>;
var nov_calories = <?php echo $nov_calories; ?>;
var dec_calories = <?php echo $dec_calories; ?>;
//this gets the data from the php script and puts it into the javascript

var ctx = document.getElementById('line_chart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Steps',
            data: [jan_steps, feb_steps, mar_steps, apr_steps, may_steps, jun_steps, jul_steps, aug_steps, sep_steps, oct_steps, nov_steps, dec_steps],
            backgroundColor: [
                'rgba(255, 255, 255, 1)',
            ],
            borderColor: [
                'rgba(0, 0, 0, 1)',
            ],
            borderWidth: 1
        },{
            label: 'Miles',
            data: [jan_distance, feb_distance, mar_distance, apr_distance, may_distance, jun_distance, jul_distance, aug_distance, sep_distance, oct_distance, nov_distance, dec_distance],
            backgroundColor: [
               'rgba(255, 255, 255, 1)',
            ],
            borderColor: [
                'rgba(255, 0, 0, 1)',
            ],
            borderWidth: 1

        },{
            label: 'Calories',
            data: [jan_calories, feb_calories, mar_calories, apr_calories, may_calories, jun_calories, jul_calories, aug_calories, sep_calories, oct_calories, nov_calories, dec_calories],
            backgroundColor: [
                'rgba(255, 255, 255, 1)',
            ],
            borderColor: [
                'rgba(0, 0, 255, 1)',
            ],
            borderWidth: 1
        }
            
    ]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

//weather api

document.getElementById('time_select').onchange = function() {
    selected_time = time_select.value;
    document.getElementById("time_selection").submit();
} 
$.ajax(settings).done(function (weather_data) {
var weather_icon= document.getElementById("weather_icon");
weather_icon.src = weather_data.forecast.forecastday[0].hour[selected_time].condition.icon; //this changes the weather icon to match the weather
weather_icon.alt = weather_data.forecast.forecastday[0].hour[selected_time].condition.text; //this changes the weather icon alt text to match the weather
console.log(weather_data);
document.getElementById("weather_description").innerHTML = weather_data.forecast.forecastday[0].hour[selected_time].condition.text; //this changes the weather description to match the weather 
var co3_levels = document.getElementById("co3_levels");
co3_levels.innerHTML = Math.round(weather_data.current.air_quality.co * 10) / 10 + " µg/m³"; //this changes the CO2 levels to match the CO2 levels in the api
var no2_levels = document.getElementById("no2_levels");
no2_levels.innerHTML = Math.round(weather_data.current.air_quality.no2 * 10) / 10 + " µg/m³"; //this changes the Nitrogen Dioxide (NO2) to match the Nitrogen Dioxide (NO2) in the api
var o3_levels = document.getElementById("o3_levels");
o3_levels.innerHTML = Math.round(weather_data.current.air_quality.o3 * 10) / 10 + " µg/m³"; //this changes the Ozone (O3) to match the Ozone (O3) in the api
var pm2_5_levels = document.getElementById("pm2_5_levels");
pm2_5_levels.innerHTML = Math.round(weather_data.current.air_quality.pm2_5 * 10) / 10 + " µg/m³"; //this changes the Fine particulate matter (PM2.5) to match the Fine particulate matter (PM2.5) in the api
var pm10_levels = document.getElementById("pm10_levels");
pm10_levels.innerHTML = Math.round(weather_data.current.air_quality.pm10 * 10) / 10 + " µg/m³"; //this changes the Particulate matter (PM10) to match the Particulate matter (PM10) in the api
var so2_levels = document.getElementById("so2_levels");
so2_levels.innerHTML = Math.round(weather_data.current.air_quality.so2 * 10) / 10 + " µg/m³"; //this changes the Sulphur Dioxide (SO2) to match the Sulphur Dioxide (SO2) in the api

if (weather_data.current.air_quality["gb-defra-index"] <= 3){
    air_quality.style.color = "green";
    air_quality.innerHTML = "The Air Quality is Good";
    guidance_alert.classList.add("alert-success");
    guidance_alert_heading.innerHTML = "Good Air Quality";
    guidance_alert_text.innerHTML = "Air quality is considered satisfactory, and air pollution poses little or no risk, you are safe to go outside and exercise/do daily activities.";

} 
else if (weather_data.current.air_quality["gb-defra-index"] <= 4){
    air_quality.style.color = "yellow";
    air_quality.innerHTML = "The Air Quality is Moderate";
    guidance_alert.classList.add("alert-warning");
    guidance_alert_heading.innerHTML = "Moderate Air Quality";
    guidance_alert_text.innerHTML = "Air quality is acceptable; however, for some pollutants there may be a moderate health concern for a very small number of people who are unusually sensitive to air pollution. You are safe to go outside and exercise/do daily activities.";
}
else if (weather_data.current.air_quality["gb-defra-index"] <= 6){
    air_quality.style.color = "orange";
    air_quality.innerHTML = "The Air Quality is Unhealthy for Sensitive Groups";
    guidance_alert.classList.add("alert-warning");
    guidance_alert_heading.innerHTML = "Unhealthy for Sensitive Groups";
    guidance_alert_text.innerHTML = "Members of sensitive groups may experience health effects. The general public is less likely to be affected. Most people are safe to go outside and exercise/do daily activities.";
}
else if (weather_data.current.air_quality["gb-defra-index"] <= 7){
    air_quality.style.color = "red";
    air_quality.innerHTML = "The Air Quality is Unhealthy";
    guidance_alert.classList.add("alert-danger");
    guidance_alert_heading.innerHTML = "Unhealthy Air Quality";
    guidance_alert_text.innerHTML = "Everyone may begin to experience health effects; members of sensitive groups may experience more serious health effects. Going outside and exercising/do daily activities is not recommended and may put you at risk of health problems.";
}
else if (weather_data.current.air_quality["gb-defra-index"] <= 9){
    air_quality.style.color = "purple";
    air_quality.innerHTML = "The Air Quality is Very Unhealthy";
    guidance_alert.classList.add("alert-danger");
    guidance_alert_heading.innerHTML = "Very Unhealthy Air Quality";
    guidance_alert_text.innerHTML = "Health warnings of emergency conditions. The entire population is more likely to be affected. Do not go out and exposure yourself for long periods of time without protection. If you have to go outside, protect yourself from the air pollution.";
}
else if (weather_data.current.air_quality["gb-defra-index"] <= 10){
    air_quality.style.color = "maroon";
    air_quality.innerHTML = "The Air Quality is Hazardous";
    guidance_alert.classList.add("alert-danger");
    guidance_alert_heading.innerHTML = "Hazardous Air Quality";
    guidance_alert_text.innerHTML = "Health alert: everyone may experience more serious health effects. Do not go outside and exercise/do daily activities. If you have to go outside, protect yourself from the air pollution and minimise your exposure to the air pollution wherever possible.";
}
else {
    air_quality.style.color = "white";
    air_quality.innerHTML = "Unknown";
}

//this changes the air quality to match the air quality in the api
}); //forecastday[0] is the current day.

var Weather_title = document.getElementById("weather_title");
Weather_title.innerHTML = "Short Forecast for " + weather_location; //this changes the heading of the page to match the location of the weather
</script>