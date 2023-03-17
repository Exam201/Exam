<?php
session_start();
$username_alert = "hidden";
$username_invalid = "form-control";
if (isset($_SESSION['username_error'])) {
    $username_alert = "";
    $username_invalid = "form-control is-invalid";
    unset($_SESSION['username_error']);
} // this sets the alert to show and the form to invalid if the usererror session is set
$pass_alert = "hidden";
$pass_invalid = "form-control";
if (isset($_SESSION['pass_error'])) {
    $pass_alert = "";
    $pass_invalid = "form-control is-invalid";
    unset($_SESSION['pass_error']);
} // this sets the alert to show and the form to invalid if the passerror session is set
$email_alert = "hidden";
$email_invalid = "form-control";
if (isset($_SESSION['email_error'])) {
    $email_alert = "";
    $email_invalid = "form-control is-invalid";
    unset($_SESSION['email_error']);
} // this sets the alert to show and the form to invalid if the emailerror session is set
?>
<!DOCTYPE html>
<html>
  <style>
    label{
      font-size: 20px;
      font-weight: bold;
    }
    h1 {
      font-weight: bold;
    }
  </style>
<head>
    <title>Register</title>
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
          <a class="nav-link" href="#">Air Quality</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Guidance</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="register.php">Sign up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Settings</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<!-- end navbar -->
<h1 style="margin-top: 1%; text-align: center; display:block">Welcome, please register!</h1>
<form action="register-action.php" method="POST">
    <div class="mb-3">
    <label for="inputUsername" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >Username</label>
    <input type="text" class="<?php echo "$username_invalid" ?>" id="inputUsername" aria-describedby="usernameHelp" name="username" placeholder="Username" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    <div id="Usernamehelp" class="form-text" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >Enter a username!</div>
    <div class='alert alert-danger' role='alert' <?php echo "$username_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Username Already Taken</div>
</div>
  </div>
  <div class="mb-3">
    <label for="inputemail" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >Email address</label>
    <input type="email" class="<?php echo "$email_invalid" ?>" id="inputemail" aria-describedby="emailHelp" name="email" placeholder="Email" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    <div id="emailHelp" class="form-text" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block" >We'll never share your email with anyone else.</div>
    <div class='alert alert-danger' role='alert' <?php echo "$email_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Email already in use</div>
  </div>
  <div class="mb-3">
    <label for="inputpassword" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Password</label>
    <input type="password" class="form-control" id="inputpassword" name="password" placeholder="Password" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
  </div>
  <div class="mb-3">
    <label for="inputpasswordconfirm" class="form-label" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Confirm Password</label>
    <input type="password" class="<?php echo "$pass_invalid" ?>" id="inputpasswordconfirm" name="confirmpassword" placeholder="Password" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%;" required>
    <div class='alert alert-danger' role='alert' <?php echo "$pass_alert" ?> style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">Passwords do not match</div>
  </div>
  <div class="mb-3">
    <input type="submit" class="btn btn-primary" class="form-control" style="margin-top: 1%; margin-left: auto; margin-right: auto; width: 20%; display:block">
</div>
</form>
</body>
</html>
<?php
session_destroy();
?>