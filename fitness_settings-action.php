<?php
include "Library/dbconnect.php";
session_start();
$conn = connect();
$query = "UPDATE user_data SET height_feet=?, height_inch=?, weight=?, age=? WHERE user_id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iiiii", $_POST['height_feet'], $_POST['height_inch'], $_POST['weight'], $_POST['age'], $_SESSION['userid']);
$stmt->execute();
header('location: settings.php');
$conn->close();
?>