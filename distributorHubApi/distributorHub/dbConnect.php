<?php
    //simply connects to the database.
    $dbHost = "localhost";
    $dbName = "distributorhub";
    $dbPass = "";
    $dbUserName = "root";

    $conn = mysqli_connect($dbHost,$dbUserName,$dbPass,$dbName);
    if(!$conn){
        die("Failed To Connect: ".mysqli_connect_error());
    }
?>