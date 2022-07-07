<?php
require_once "database_connect.php";

// Attempt create database query execution
$sql = "CREATE DATABASE professor";
if(mysqli_query($link, $sql)){
    echo "Database created successfully";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}
 
// Close connection
mysqli_close($link);
?>