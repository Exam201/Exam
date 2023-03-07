<?php
 function connect(){
    $conn = mysqli_connect("localhost","root","","health_advice_group"); //this connects to the database and returns a connection object to the variable $conn
    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }
    return $conn;
 }