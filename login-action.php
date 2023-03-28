<?php
    include "Library/dbconnect.php";
    $conn = connect();
    $query = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", filter_var($_POST['username'], FILTER_SANITIZE_STRING));
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    if ($user) {
        if (password_verify($_POST['password'], $user['password'])) { // password_verify() is a PHP function that checks if a password matches a hash
            session_unset();
            session_start();
            $_SESSION['userid'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['admin'] = $user['admin'];
            $_SESSION['profileimage'] = $user['profileimage']; // set the session variables to the user's information from the database (so we can use them in other pages)
            header('location: index.php');
        }
        else {
            session_unset();
            session_start();
            $_SESSION['pass_login_fail'] = true;
            header('location: login.php');
        }
    }
    else {
        session_unset();
        session_start();
        $_SESSION['username_login_fail'] = true;
        header('location: login.php');
    }
?>
