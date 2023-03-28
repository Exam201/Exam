<?php
include 'Library/dbconnect.php';
session_start();
$nav_hidden = "";
$nav_unhidden = "hidden";
if (isset($_SESSION["userid"])) {
    $nav_hidden = "hidden";
    $nav_unhidden = "";
    $conn = connect();
    $query = "SELECT * FROM users JOIN user_data ON users.user_id = user_data.user_id WHERE users.user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['userid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $conn->close();
} //this is used to hide the sign up button if the user is logged in and to hide the logout button if the user is not logged in as well as query the database for the user's data
$username_alert = "hidden";
if (isset($_SESSION['username_error'])) {
    $username_alert = "";
    unset($_SESSION['username_error']);
} // this sets the alert to show if the usererror session is set
$pass_alert = "hidden";
if (isset($_SESSION['pass_error'])) {
    $pass_alert = "";
    unset($_SESSION['pass_error']);
} // this sets the alert to show if the passerror session is set
$email_alert = "hidden";
if (isset($_SESSION['email_error'])) {
    $email_alert = "";
    unset($_SESSION['email_error']);
} // this sets the alert to show if the emailerror session is set
?>
<doctype html>
<html>
<header>
<title>Settings</title>
<link rel="Stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
<script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
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
<!-- settings form -->
<h1 style="margin-top: 1%; text-align: center; display:block">Settings</h1>
<form action="account_settings-action.php" method="post" <?php echo "$nav_unhidden"; ?>>
    <div class="mb-3">
    <label for="inputUsername" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >Username</label>
    <input type="text" class="form-control" id="inputUsername" aria-describedby="usernameHelp" name="username" value="<?php echo $user["username"]; ?>" placeholder="<?php echo $user["username"]; ?>" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" disabled="true" required>
    <div class='alert alert-danger' role='alert' <?php echo "$username_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Username Already Taken</div>
</div>
  </div>
  <div class="mb-3">
    <label for="inputemail" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >Email address</label>
    <input type="email" class="form-control" id="inputemail" aria-describedby="emailHelp" name="email" value="<?php echo $user["email"]; ?>" placeholder="<?php echo $user["email"]; ?>" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" disabled="true" required>
    <div id="emailHelp" class="form-text" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >We'll never share your email with anyone else.</div>
    <div class='alert alert-danger' role='alert' <?php echo "$email_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Email already in use</div>
  </div>
  <div class="mb-3">
    <label for="inputpassword" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Password</label>
    <input type="password" class="form-control" id="inputpassword" name="password" placeholder="Password" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" disabled="true" required>
    <div id="passwordHelp" class="form-text" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Please enter your password to confirm its you.</div>
  </div>
    <div class="mb-3">
        <button onclick=undisable_form() type="button" class="btn btn-primary" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Edit Account Details</button>
    </div>
  <div class="mb-3">
    <input type="submit" id="settings_submit" class="btn btn-primary" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" hidden> 
 </div>
</form>
<!-- end settings form -->
<!-- fitness settings form -->
<form action="fitness_settings-action.php" method="post">
    <div class="mb-3">
        <lable class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Height</lable>
        <lable for="input_height_feet" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Feet</lable>
        <input type="number" class="form-control" id="input_height_feet" name="height_feet" value="<?php echo $user["height_feet"]; ?>" placeholder="Feet" max="6" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;"  required>
        <lable for="input_height_inch" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Inch</lable>
        <input type="number" class="form-control" id="input_height_inch" name="height_inch" value="<?php echo $user["height_inch"]; ?>" placeholder="Inch" max="11" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    </div>
    <div class="mb-3">
        <lable for="input_weight" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Weight (kg)</lable>
        <input type="number" class="form-control" id="input_weight" name="weight" value="<?php echo $user["weight"]; ?>" placeholder="Weight" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    </div>
    <div class="mb-3">
        <lable for="input_age" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Age</lable>
    <input type="number" class="form-control" id="input_age" name="age" value="<?php echo $user["age"]; ?>" placeholder="Age" max="110" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    <div class="mb-3">
    <input type="submit" id="settings_submit" class="btn btn-primary" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block"> 
 </div>
</form>
<!-- end fitness settings form -->
</body>
</html>
<script>
    function undisable_form() {
    if (document.getElementById("inputUsername").disabled == true) {
        document.getElementById("inputUsername").removeAttribute("disabled");
        document.getElementById("inputemail").removeAttribute("disabled");
        document.getElementById("inputpassword").removeAttribute("disabled");
        document.getElementById("settings_submit").removeAttribute("hidden");
    }
    else {
        document.getElementById("inputUsername").setAttribute("disabled", "true");
        document.getElementById("inputemail").setAttribute("disabled", "true");
        document.getElementById("inputpassword").setAttribute("disabled", "true");
        document.getElementById("settings_submit").setAttribute("hidden", "true");
    }
}
</script>