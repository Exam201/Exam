<?php
 function connect(){
    $conn = mysqli_connect("localhost","root","","health_advice_group");
    if(!$conn){
        die("Connection failed: ".mysqli_connect_error());
    }
    return $conn;
 }