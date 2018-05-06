<?php
include 'config1.php';

mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin4 = sprintf("SELECT * FROM Main_Coin_List WHERE  Coin_TAG = '".$_POST["coin"]."'");
$rs_userlogin4 = mysql_query($query_rs_userlogin4, $connectdb) or die(mysql_error());
$row_rs_userlogin4 = mysql_fetch_assoc($rs_userlogin4);
$totalRows_rs_userlogin4 = mysql_num_rows($rs_userlogin4);


?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				<link href="https://fonts.googleapis.com/css?family=Muli:400,600,700" rel="stylesheet">
					<title>CryptoMarketCheck | Stake Calculator</title>
					<link rel="shortcut icon" type="image/x-icon" href="http://cryptomarketcheck.com/public/assets/images/favicon.png" />
					<link rel="stylesheet" href="http://cryptomarketcheck.com/public/assets/css/plugins.css?v=1.7" />
					<link rel="stylesheet" href="http://cryptomarketcheck.com/public/assets/js/amstock/style.css" />
					<link rel="stylesheet" href="http://cryptomarketcheck.com/public/assets/js/amstock/plugins/export/export.css" />
					<link rel="stylesheet" href="http://cryptomarketcheck.com/public/styles/default/css/style.css?v=1523383802" />
					<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
					<script src="https://code.highcharts.com/highcharts.js"></script>
					<script src="https://code.highcharts.com/modules/exporting.js"></script>
					<script src="https://code.highcharts.com/modules/export-data.js"></script>

          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

					<link rel="stylesheet" href="chartlist.css" />
					<meta name="keywords" content="" />
					<meta name="description" content="" />

				</head>

				<body class="" style="">
          <nav class="navbar navbar-expand-lg navbar-dark bg-primary ">
              <a class="navbar-brand" href="#">Stake Calculator</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                      <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                      </li>
                    </ul>
                  </div>
          </nav>
		  
		  
		  
		  <div class="jumbotron" style="background-color: #bac1ca;">
<div class="container">
<h3 class="display-3" style="text-align: center;
    margin-bottom: 0px;
    color: #4c4c4c;
	font-weight: 500;">
<img src="<?php echo $row_rs_userlogin4['logo']; ?>" width="128" height="128">
 <?php echo $row_rs_userlogin4['Coin_Name']; ?> <span style="font-size:22px;">[<?php echo $row_rs_userlogin4['Coin_TAG']; ?>]</span>
</h3>
<p style="    text-align: center;">
<br>You can find more information on the <a href="<?php echo $row_rs_userlogin4['website']; ?>" target="_blank"><?php echo $row_rs_userlogin4['Coin_Name']; ?></a></p>
</div>
</div>
		  
		  
		  
					<div class="container">
					<form align="center" id="alert-form" action="index.php" method="post">

						<h5>Select a coin to calculate</h5>
						<select name="coin"  class="select2 form-control">
							<?php
									
									
mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin = sprintf("SELECT Coin_TAG, Coin_Name FROM Main_Coin_List");
$rs_userlogin = mysql_query($query_rs_userlogin, $connectdb) or die(mysql_error());
$row_rs_userlogin = mysql_fetch_assoc($rs_userlogin);
$totalRows_rs_userlogin = mysql_num_rows($rs_userlogin);



										if ($totalRows_rs_userlogin > 0) {
										
										if(mysql_num_rows($rs_userlogin)){ do { 
										
												echo "<option value='".$row_rs_userlogin['Coin_TAG']."'>[".$row_rs_userlogin['Coin_TAG']."] ".$row_rs_userlogin['Coin_Name']."</option>";
										
										 } while ($totalRows_rs_userlogin = mysql_fetch_assoc($rs_userlogin)); } 
										
			
										} else {
											echo "<div style='color: red;'>No coins on the Database!</div>";
										}
									
									 ?>
						</select>

						<br>
						<h5>View</h5>
						<select name="view"  class="select2 form-control">
							<option value='m'>Monthly</option>
							<option value='w'>Weekly</option>
							<option value='d'>Daily</option>
						</select>

						<h6 style="margin-bottom: 26px;">Insert a coin ammount</h6>
						<div class="row" style="margin-top:20px;margin-bottom: 32px">
							<div class="col-md-6" style="margin-bottom: 10px;">
								<input style="height: calc(2.25rem + 2px);" type="text" name="quantity" class="form-control" required/>
							</div>
						</div>

						<button style="display: block;margin: 0 auto; width: 104px;" class="btn btn-sm btn-primary">Calculate</button>
				 </form>
			 </div>

				 <div class="container"><br>




					 <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>





					 <br><h5 align="middle">Proof-of-Staking Tiers</h5>
				 <table id="portfolioTransactionList" class="table table-hover  table-coin table-coin-res">
					 <thead>
						 <th> Block </th>
						 <th> Date </th>
						 <th> Daily %</th>
						 <th> Esitmated Balance </th>
					 </thead>
					 <tbody>

							 <?php
								 // Create connection
								 $conn = new mysqli($servername, $username, $password, $dbname);
								 // Check connection
								 if ($conn->connect_error) {
									 die("Connection failed: " . $conn->connect_error);
								 }

								 $sql = "SELECT Block, Anual, Daily, Start FROM $selectedcoin.'_postiers'";
								 $result = $conn->query($sql);

								 if ($result->num_rows > 0) {
									 // output data of each row
									 while($row = $result->fetch_assoc()) {
										 $block = $row['Block'];
										 $anual = $row['Anual'];
										 $daily = $row['Daily'];
										 $start = $row['Start'];

											 echo "<tr>";
											 echo "<td align='center'>$block</td>";
											 echo "<td align='center'>$anual</td>";
											 echo "<td align='center'>$daily</td>";
											 echo "<td align='center'>$start</td>";
											 echo "</tr>";
										 }
									 }else {
										 echo "No data!";
									 }
								 ?>
							 </tbody>
						 </table>



						<?php if($selectedview =="m"){
							echo "<br><h5 align='middle'>Calculations along the time</h5>
 						 	<div class='container-fluid'>


 								 <table id='portfolioTransactionList' class='table table-hover  table-coin table-coin-res'>
 									 <thead>
 										 <th> Block </th>
 										 <th> Date </th>
 										 <th> Estimated balance </th>
 										 <th> ROI % </th>
 									 </thead>
 									 <tbody>";

 												 // Create connection
 												 $conn = new mysqli($servername, $username, $password, $dbname);
 												 // Check connection
 												 if ($conn->connect_error) {
 													 die("Connection failed: " . $conn->connect_error);
 												 }

 												 $sql = "SELECT BeginBlock,BlockTime, Roi FROM $selectedcoin";
 												 $result = $conn->query($sql);

 												 if ($result->num_rows > 0) {
 													 // output data of each row
 													 while($row = $result->fetch_assoc()) {
 														 $bblock = $row['BeginBlock'];
 														 $mstime = $row['BlockTime'];
 														 $btime  = gmdate("Y-m", $row['BlockTime']);
 														 $currentmonth = gmdate("m", $row['BlockTime']);
 														 $broi   = round($row['Roi'],3);

 														 if($currentmonth==01){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;


 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==02){
 															 //28
 															 for($i=0; $i<=27; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==03){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==04){
 															 //30
 															 for($i=0; $i<=29; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==05){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==06){
 															 //30
 															 for($i=0; $i<=29; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==07){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==08){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==09){
 															 //30
 															 for($i=0; $i<=29; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==10){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if($currentmonth==11){
 															 //30
 															 for($i=0; $i<=29; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }else if ($currentmonth==12){
 															 //31
 															 for($i=0; $i<=30; $i++)
 															 {
 																 //24 hours = 86400000 seconds
 																 $mstime = $mstime+86400000;
 																 $btime = gmdate("Y-m-d",$mstime);
 																 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;

 																 $jfile2write = $jfile2write."
 																	 [
 																		 $mstime,
 																		 $calculatedbalance
 																	 ],";

 															 }
 															 echo "<tr>";
 															 echo "<td align='center'>$bblock</td>";
 															 echo "<td align='center'>$btime</td>";
 															 echo "<td align='center'>$calculatedbalance</td>";
 															 echo "<td align='center'>$broi</td>";
 															 echo "</tr>";
 														 }


 												 }
 												 } else {
 													 echo "<div style='color: red;'>No data on the Database!</div>";
 												 }
 												 $conn->close();
 												 $jfile2write = substr($jfile2write, 0, -1);
 												 $jfile2write = $jfile2write."]";
 												 $jsonfilenamerand=substr(str_shuffle(str_repeat("01234589abchijkxyzACDEFGHIYXZ", 15)), 0, 15);
 												 $currentmstime=round(microtime(true) * 1000);
 												 $jsonfilenamerand = $jsonfilenamerand.$currentmstime.'.json';
 												 file_put_contents('json/'.$jsonfilenamerand, $jfile2write);
 											  	echo "</tbody></p></div>";

								}else if($selectedview=="w"){
									echo "<table id='portfolioTransactionList' class='table table-hover  table-coin table-coin-res'>
										 <thead>
											 <th> Block </th>
											 <th> Date </th>
											 <th> Estimated balance </th>
											 <th> ROI % </th>
										 </thead>
										 <tbody>";

													 // Create connection
													 $conn = new mysqli($servername, $username, $password, $dbname);
													 // Check connection
													 if ($conn->connect_error) {
														 die("Connection failed: " . $conn->connect_error);
													 }

													 $sql = "SELECT BeginBlock,BlockTime, Roi FROM $selectedcoin";
													 $result = $conn->query($sql);

													 if ($result->num_rows > 0) {
														 // output data of each row
														 while($row = $result->fetch_assoc()) {
															 $bblock = $row['BeginBlock'];
															 $mstime = $row['BlockTime'];
															 $btime  = gmdate("Y-m", $row['BlockTime']);
															 $currentmonth = gmdate("m", $row['BlockTime']);
															 $broi   = round($row['Roi'],3);

															 if($currentmonth==01){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }

															 }else if($currentmonth==02){
																 //28
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==03){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";


																 }
															 }else if($currentmonth==04){
																 //30
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==05){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==06){
																 //30
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";


																 }
															 }else if($currentmonth==07){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==08){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==09){
																 //30
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==10){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if($currentmonth==11){
																 //30
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }else if ($currentmonth==12){
																 //31
																 for($i=0; $i<=4; $i++)
																 {
																	 //24 hours = 86400000 seconds
																	 $mstime = $mstime+86400000;
																	 $btime = gmdate("Y-m-d",$mstime);
																	 $pot = $calculatedbalance;
																	 $calculatedbalance = (($calculatedbalance/100)*$broi);
																	 $calculatedbalance=($calculatedbalance*7)+$pot;
																	 echo "<tr>";
																	 echo "<td align='center'>$bblock</td>";
																	 echo "<td align='center'>$btime</td>";
																	 echo "<td align='center'>$calculatedbalance</td>";
																	 echo "<td align='center'>$broi</td>";
																	 echo "</tr>";

																 }
															 }


													 }
													 } else {
														 echo "<div style='color: red;'>No data on the Database!</div>";
													 }
													 $conn->close();
													 echo "</tbody></p></div>";

								}else {
									echo "<table id='portfolioTransactionList' class='table table-hover  table-coin table-coin-res'>
		 							 <thead>
		 								 <th> Block </th>
		 								 <th> Date </th>
		 								 <th> Estimated balance </th>
		 								 <th> ROI % </th>
		 							 </thead>
		 							 <tbody>";


		 										 // Create connection
		 										 $conn = new mysqli($servername, $username, $password, $dbname);
		 										 // Check connection
		 										 if ($conn->connect_error) {
		 											 die("Connection failed: " . $conn->connect_error);
		 										 }

		 										 $sql = "SELECT BeginBlock,BlockTime, Roi FROM $selectedcoin";
		 										 $result = $conn->query($sql);

		 										 if ($result->num_rows > 0) {
		 											 // output data of each row
		 											 while($row = $result->fetch_assoc()) {
		 												 $bblock = $row['BeginBlock'];
		 												 $mstime = $row['BlockTime'];
		 												 $btime  = gmdate("Y-m", $row['BlockTime']);
		 												 $currentmonth = gmdate("m", $row['BlockTime']);
		 												 $broi   = round($row['Roi'],3);

		 												 if($currentmonth==01){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";


		 													 }
		 												 }else if($currentmonth==02){
		 													 //28
		 													 for($i=0; $i<=27; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==03){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==04){
		 													 //30
		 													 for($i=0; $i<=29; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==05){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==06){
		 													 //30
		 													 for($i=0; $i<=29; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==07){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==08){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==09){
		 													 //30
		 													 for($i=0; $i<=29; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==10){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if($currentmonth==11){
		 													 //30
		 													 for($i=0; $i<=29; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }else if ($currentmonth==12){
		 													 //31
		 													 for($i=0; $i<=30; $i++)
		 													 {
		 														 //24 hours = 86400000 seconds
		 														 $mstime = $mstime+86400000;
		 														 $btime = gmdate("Y-m-d",$mstime);
		 														 $calculatedbalance = (($calculatedbalance/100)*$broi)+$calculatedbalance;
		 														 echo "<tr>";
		 														 echo "<td align='center'>$bblock</td>";
		 														 echo "<td align='center'>$btime</td>";
		 														 echo "<td align='center'>$calculatedbalance</td>";
		 														 echo "<td align='center'>$broi</td>";
		 														 echo "</tr>";

		 													 }
		 												 }


		 										 }
		 										 } else {
		 											 echo "<div style='color: red;'>No data on the Database!</div>";
		 										 }
		 										 $conn->close();
		 							 	 			echo "</tbody></p></div>";


								}

								?>


			 </div>
		 </div>

					 <div>
					 <script type="text/javascript">
		 $.getJSON(
			 <?php echo "'json/".$jsonfilenamerand."'"; ?>,
		 function (data) {

			 Highcharts.chart('container', {
				 chart: {
					 zoomType: 'x'
				 },
				 title: {
					 text: 'Calculated stake along the time'
				 },
				 subtitle: {
					 text: document.ontouchstart === undefined ?
							 'Click and drag in the plot area to zoom in' : 'Pinch the chart to zoom in'
				 },
				 xAxis: {
					 type: 'datetime'
				 },
				 yAxis: {
					 title: {
						 text: 'Stake ammount'
					 }
				 },
				 legend: {
					 enabled: false
				 },
				 plotOptions: {
					 area: {
						 fillColor: {
							 linearGradient: {
								 x1: 0,
								 y1: 0,
								 x2: 0,
								 y2: 1
							 },
							 stops: [
								 [0, Highcharts.getOptions().colors[0]],
								 [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
							 ]
						 },
						 marker: {
							 radius: 2
						 },
						 lineWidth: 1,
						 states: {
							 hover: {
								 lineWidth: 1
							 }
						 },
						 threshold: null
					 }
				 },

				 series: [{
					 type: 'area',
					 name: 'Stake ammount',
					 data: data
				 }]
			 });
		 }
	 );
		 </script>

</body>
