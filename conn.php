<?php
$servername = "localhost";
$username = "id21338467_root";
$password = "SBH@Vhkw77D7cH7";
$dbname = "id21338467_thesis";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 
?>