<?php
session_start();
$username_alert = "hidden";
$username_invalid = "form-control";
if (isset($_SESSION['username_login_fail'])) {
    $username_alert = "";
    $username_invalid = "form-control is-invalid";
    unset($_SESSION['username_login_fail']);
} // this sets the alert and invalid classes for the username field if the user has failed to login
$pass_alert = "hidden";
$pass_invalid = "form-control";
if (isset($_SESSION['pass_login_fail'])) {
    $pass_alert = "";
    $pass_invalid = "form-control is-invalid";
    unset($_SESSION['pass_login_fail']);
} // this sets the alert and invalid classes for the password field if the user has failed to login
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign in</title>
    <link rel="stylesheet" href="bootstrap-5.3.0-alpha1-dist/css/bootstrap.css">
    <script scr="bootstrap-5.3.0-alpha1-dist/js/bootstrap.js"></script>
</head>
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
        <li class="nav-item">
          <a class="nav-link" href="register.php">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="settings.php">Settings</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- end navbar -->
<h1 style="margin-top: 1%; text-align: center; display:block">Welcome back, please sign in!</h1>

<form action="login-action.php" method="POST">
    <div class="mb-3">
    <label for="inputUsername1" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >Username</label>
    <input type="text" class="<?php echo "$username_invalid" ?>" id="InputUsername1" aria-describedby="usernameHelp" name="username" placeholder="Username" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    <div id="Usernamehelp" class="form-text" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" ></div>
    <div class='alert alert-danger' role='alert' <?php echo "$username_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Username does not exist</div>
</div>
  </div>
  <div class="mb-3">
    <label for="InputPassword1" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Password</label>
    <input type="password" class="<?php echo "$pass_invalid" ?>" id="InputPassword1" name="password" placeholder="Password" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    <div class='alert alert-danger' role='alert' <?php echo "$pass_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Incorrect Password</div>
    </div>
  <div class="mb-3">
    <input type="submit" class="btn btn-primary" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
</div>
</form>
</body>
</html>