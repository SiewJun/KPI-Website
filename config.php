<?php
$servername = "localhost";
$databasename = "root";
$password = "";
$dbname = "project1";

// Create connection
$conn = mysqli_connect($servername, $databasename, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>