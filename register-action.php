<?php
if ($_POST['password'] == $_POST['confirmpassword']) { // if the password and confirm password fields match
    include "Library/dbconnect.php";
    $conn = connect();
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) { // if the username is already in the database
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
        if ($email) { // if the email is already in the database
            $_SESSION['email_error'] = true;
            header('location: register.php');
        }
        else {
            //write code that updates users and user_data tables 
            $profileimage = 'image-uploads/default.png';
            $passwordfilter = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $password = password_hash($passwordfilter, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (username, password, email, admin, profileimage) VALUES (?, ?, ?, 0, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", filter_var($_POST['username'], FILTER_SANITIZE_STRING), $password, filter_var($_POST['email'], FILTER_SANITIZE_STRING), $profileimage);
            $stmt->execute();
            header('location: login.php');
            $query = "SELECT * FROM users WHERE username=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", filter_var($_POST['username'], FILTER_SANITIZE_STRING));
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $user['user_id'];
            $query = "INSERT INTO user_data (height_feet, height_inch, weight, age, user_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiiii", $_POST['height_feet'], $_POST['height_inch'], $_POST['weight'], $_POST['age'], $user['user_id']);
            $stmt->execute();
        }

        }
    }
  else {
    session_unset();
    session_start();
    $_SESSION['pass_error'] = true;
    header('location: register.php');
}   
?>