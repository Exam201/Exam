<?php
if ($_POST['password'] == $_POST['confirmpassword']) {
    include "Library/dbconnect.php";
    $conn = connect();
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) {
        session_unset();
        session_start();
        $_SESSION['username_error'] = true;
        header('location: register.php');
    } else {
        session_unset();
        session_start();
        $query = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", filter_var($_POST['email'], FILTER_SANITIZE_STRING));
        $stmt->execute();
        $result = $stmt->get_result();
        $email = $result->fetch_assoc();
        if ($email) {
            $_SESSION['email_error'] = true;
            header('location: register.php');
        }
        else {
            $profileimage = 'image-uploads/default.png';
            $passwordfilter = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $password = password_hash($passwordfilter, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password, email, admin, profileimage) VALUES (?, ?, ?, 0, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", filter_var($_POST['username'], FILTER_SANITIZE_STRING), $password, filter_var($_POST['email'], FILTER_SANITIZE_STRING), $profileimage);
            $stmt->execute();
            header('location: login.php'); }
        }
    }
  else {
    session_unset();
    session_start();
    $_SESSION['pass_error'] = true;
    header('location: register.php');
}   
?>
