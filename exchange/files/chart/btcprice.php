<?php

$host = 'localhost';
$username = "root";
$password = "";
$db_name = "test";
$coin = "XMR";

$conn = new mysqli($host, $username, $password, $db_name) or die("Error Connection");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";


$sql = 'SELECT value_ FROM crypto_2 WHERE key_="BTCD"';
$result = $conn->query($sql);


while($row = $result->fetch_assoc()) {
	echo json_encode($row["value_"]);
}

$conn->close();


?>





