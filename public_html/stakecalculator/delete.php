
<?php
include 'config1.php';
 ?>

<?php

$coinTag = $_GET['coinTag'];


$insertSQL = sprintf("DELETE FROM Main_Coin_List WHERE Coin_TAG='".$coinTag."'");

  mysql_select_db($database_connectdb, $connectdb);
  $Result2 = mysql_query($insertSQL, $connectdb);

	if ($Result2) {
		
		header("Location: admin.php");
		
	}




?>