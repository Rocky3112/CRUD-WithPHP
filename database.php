<?php
$servername = "localhost";
$username = "root";
$password = "";
$port = '3307';

// Create connection
$conn = new mysqli("localhost", "root", '',"authsystem",'3307');


// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully";
?>
