<?php
require_once 'config1.php';
/*Insert values into database*/
if($_POST['is_submit'] == 'yes'){
$count = count($_POST['c1']);


$coinname = $_POST['coinname1'];
$cointag = $_POST['cointag1'];
$blocktime = $_POST['blocktime1'];
$apilink = $_POST['apilink1'];
$logo1 = $_POST['logo1'];
$website1 = $_POST['website1'];


$query_values = array();

for($i=0; $i<$count; $i++){
	
$c1 = $_POST['c1'][$i];
$c2 = $_POST['c2'][$i];


$query_values[] = " ('$c1','$c2', '$cointag') ";
}

$values = implode(',', $query_values);

$insertSQL = sprintf("INSERT INTO coinlist (Start_block, ROI, Coin_TAG) VALUES $values");

  mysql_select_db($database_connectdb, $connectdb);
  $Result2 = mysql_query($insertSQL, $connectdb);

	if ($Result2) {
		
		$insertSQL3 = sprintf("INSERT INTO Main_Coin_List (Coin_Name, Coin_TAG, Block_Time, API_LINK, logo, website) VALUES ('".$coinname."', '".$cointag."', '".$blocktime."', '".$apilink."', '".$logo1."', '".$website1."')");

  mysql_select_db($database_connectdb, $connectdb);
  $Result3 = mysql_query($insertSQL3, $connectdb);
		
		
	} 
  
	
}



?>