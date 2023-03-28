<?php
include "Library/dbconnect.php";
session_start();
$conn = connect();
$query = "SELECT * FROM users WHERE user_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['userid']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
if (password_verify($_POST['password'], $user['password'])) { // if the password and confirm password fields match
    $clean_user = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $clean_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $conn = connect();
    $query = "SELECT * FROM users WHERE username=? AND user_id != ?"; // check if the username is already taken by another user (not the current user)
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si",$clean_user,$_SESSION['userid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) {  // if the username is already taken
        $_SESSION['username_error'] = true;
        header('location: settings.php');
    } else {
        $query = "SELECT * FROM users WHERE email=? AND user_id != ?"; // check if the email is already taken by another user (not the current user)
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $clean_email, $_SESSION['userid']);
        $stmt->execute();
        $result = $stmt->get_result();
        $email = $result->fetch_assoc();
        if ($email) { 
            $_SESSION['email_error'] = true;
            header('location: settings.php');
        }
        else {
            $profileimage = 'image-uploads/default.png';
            $passwordfilter = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
            $password = password_hash($passwordfilter, PASSWORD_DEFAULT);
            $query = "UPDATE users SET username=?, password=?, email=?, profileimage=? WHERE user_id=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssssi", filter_var($_POST['username'], FILTER_SANITIZE_STRING), $password, filter_var($_POST['email'], FILTER_SANITIZE_STRING), $profileimage, $_SESSION['userid']);
            $stmt->execute(); // update the user's information
            header('location: settings.php'); }
        }
    }
    else {
        $_SESSION['pass_error'] = true;
        header('location: settings.php');
    } 
$con -> close();  
?>