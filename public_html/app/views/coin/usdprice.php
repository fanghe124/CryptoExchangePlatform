<?php

// echo $_REQUEST["coin"];

$host = 'localhost';
$username = "root";
$password = "";
$db_name = "test";
$coin = $_REQUEST["coin"];

$conn = new mysqli($host, $username, $password, $db_name) or die("Error Connection");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";


$sql = "SELECT value_ FROM crypto_1 WHERE key_='$coin'";
$result = $conn->query($sql);

// while($row = $result->fetch_assoc()) {
	// echo json_encode($row["value_"]);
// }

if ($result->num_rows > 0) {
    
    while($row = $result->fetch_assoc()) {
        echo json_encode($row["value_"]);
    }
}else{
	echo json_encode(["no datas"]);
	
};




	




$conn->close();


?>





