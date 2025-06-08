<?php
// Database connection
$host = "localhost"; // Database host (change if needed)
$db_name = "hisctgco_Travel_Diary"; // Database name
$db_user = "hisctgco_kamol"; // Database username
$db_password = "RvN&OH}WG68a"; // Database password (change if necessary)

$conn = new mysqli($host, $db_user, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
