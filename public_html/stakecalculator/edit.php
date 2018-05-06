<?php
include 'config.php';
$selectedcoin  = $_POST["coin"];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT CoinTag, CoinName FROM coinlist";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $ctag   = $row['CoinTag'];
    $cname  = $row['CoinName'];
}
} else {
 echo "Nothing loaded!";
}
$conn->close();
//--------------------------------------------------------------------

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT StartBlock, StartBlockTime FROM $selectedcoin.'_start'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $stblock  = $row['StartBlock'];
    $stblocktime  = $row['StartBlockTime'];
}
} else {
 echo "Nothing loaded!";
}
$conn->close();
//------------------------------------------------------------------------------------------

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT StartBlock, StartBlockTime FROM $selectedcoin.'_postiers'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $special[]  = $row['Block'];
    $special[]  = $row['Anual'];
    $special[]  = $row['Daily'];
    $special[]  = $row['Start'];
}
} else {
 echo "Nothing loaded!";
}
$conn->close();

//------------------------------------------------------------------------------------------
  // Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);
  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  $sql = "SELECT BeginBlock, EndBlock, BlockTime, Roi FROM $selectedcoin";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      $results[] = $row;
  }
  } else {
   echo "Nothing loaded!";
  }
  $row1 = $results[0];
    $bblock1 = $row1['BeginBlock'];
    $eblock1 = $row1['EndBlock'];
    $btime1 = $row1['BlockTime'];
    $roi1 = $row1['Roi'];

  $row2 = $results[1];
    $bblock2 = $row2['BeginBlock'];
    $eblock2 = $row2['EndBlock'];
    $btime2 = $row2['BlockTime'];
    $roi2 = $row2['Roi'];

  $row3 = $results[2];
    $bblock3 = $row3['BeginBlock'];
    $eblock3 = $row3['EndBlock'];
    $btime3 = $row3['BlockTime'];
    $roi3 = $row3['Roi'];

  $row4 = $results[3];
    $bblock4 = $row4['BeginBlock'];
    $eblock4 = $row4['EndBlock'];
    $btime4 = $row4['BlockTime'];
    $roi4 = $row4['Roi'];

  $row5 = $results[4];
    $bblock5 = $row5['BeginBlock'];
    $eblock5 = $row5['EndBlock'];
    $btime5 = $row5['BlockTime'];
    $roi5 = $row5['Roi'];

  $row6 = $results[5];
    $bblock6 = $row6['BeginBlock'];
    $eblock6 = $row6['EndBlock'];
    $btime6 = $row6['BlockTime'];
    $roi6 = $row6['Roi'];

  $row7 = $results[6];
    $bblock7 = $row7['BeginBlock'];
    $eblock7 = $row7['EndBlock'];
    $btime7 = $row7['BlockTime'];
    $roi7 = $row7['Roi'];

  $row8 = $results[7];
    $bblock8 = $row8['BeginBlock'];
    $eblock8 = $row8['EndBlock'];
    $btime8 = $row8['BlockTime'];
    $roi8 = $row8['Roi'];

  $row9 = $results[8];
    $bblock9 = $row2['BeginBlock'];
    $eblock9 = $row2['EndBlock'];
    $btime9 = $row2['BlockTime'];
    $roi9 = $row2['Roi'];

  $row10 = $results[9];
    $bblock10 = $row10['BeginBlock'];
    $eblock10 = $row10['EndBlock'];
    $btime10 = $row10['BlockTime'];
    $roi10 = $row10['Roi'];

  $row11 = $results[10];
    $bblock11 = $row11['BeginBlock'];
    $eblock11 = $row11['EndBlock'];
    $btime11 = $row11['BlockTime'];
    $roi11 = $row11['Roi'];

  $row12 = $results[11];
    $bblock12 = $row12['BeginBlock'];
    $eblock12 = $row12['EndBlock'];
    $btime12 = $row12['BlockTime'];
    $roi12 = $row12['Roi'];

    $row13 = $special[0];
      $block1 = $row13['Block'];
      $anual1 = $row13['Anual'];
      $daily1 = $row13['Daily'];
      $start1 = $row13['Start'];

    $row14 = $special[1];
      $block2 = $row14['Block'];
      $anual2 = $row14['Anual'];
      $daily2 = $row14['Daily'];
      $start2 = $row14['Start'];

  $conn->close();



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
                         <a class="nav-link" href="admin.php">Admin <span class="sr-only">(current)</span></a>
                       </li>
                     </ul>
                   </div>
           </nav>

									<div class="col-md-12">
										<div class="pane bg-white">
										<form id="alert-form" action="update.php" method="post">

												<h6 style="margin-bottom: 26px;">Coin name</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-6" style="margin-bottom: 10px;">
														<input style="height: calc(2.25rem + 2px);" type="text" name="coinname1" class="form-control" value="<?php echo "$cname";?>" />
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">Coin TAG</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-6" style="margin-bottom: 10px;">
														<input style="height: calc(2.25rem + 2px);" type="text" name="cointag1" class="form-control"  value="<?php echo "$ctag";?>" />
													</div>
												</div>

                        <h6 style="margin-bottom: 26px;">Start block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-6" style="margin-bottom: 10px;">
														<input placeholder="Start block" style="height: calc(2.25rem + 2px);" type="text" name="startblock1" class="form-control"  value="<?php echo "$stblock";?>" /><br>
														<input placeholder="Start block date" style="height: calc(2.25rem + 2px);" type="text" name="startblockdate1" class="form-control"  value="<?php echo "$stblocktime";?>" />
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">1st Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock1" class="form-control"  value="<?php echo "$bblock1";?>" />
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock1" class="form-control"  value="<?php echo "$eblock1";?>" />
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime1" class="form-control"  value="<?php echo "$btime1";?>" />
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi1" class="form-control"  value="<?php echo "$roi1";?>" />
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">2nd Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock2" class="form-control"  value="<?php echo "$bblock2";?>" />
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock2" class="form-control"  value="<?php echo "$eblock2";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime2" class="form-control"  value="<?php echo "$btime2";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi2" class="form-control"  value="<?php echo "$roi2";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">3rd Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock3" class="form-control"  value="<?php echo "$bblock3";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock3" class="form-control"  value="<?php echo "$eblock3";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime3" class="form-control"  value="<?php echo "$btime3";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi3" class="form-control" value="<?php echo "$roi3";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">4th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock4" class="form-control"  value="<?php echo "$bblock4";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock4" class="form-control"  value="<?php echo "$eblock4";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime4" class="form-control"  value="<?php echo "$btime4";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi4" class="form-control"  value="<?php echo "$roi4";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">5th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock5" class="form-control"  value="<?php echo "$bblock5";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock5" class="form-control"  value="<?php echo "$eblock5";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime5" class="form-control"  value="<?php echo "$btime5";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi5" class="form-control"  value="<?php echo "$roi5";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">6th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock6" class="form-control"  value="<?php echo "$bblock6";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock6" class="form-control"  value="<?php echo "$eblock6";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime6" class="form-control"  value="<?php echo "$btime6";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi6" class="form-control"  value="<?php echo "$roi6";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">7th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock7" class="form-control"  value="<?php echo "$bblock7";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock7" class="form-control"  value="<?php echo "$eblock7";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime7" class="form-control"  value="<?php echo "$btime7";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi7" class="form-control"  value="<?php echo "$roi7";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">8th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock8" class="form-control"  value="<?php echo "$bblock8";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock8" class="form-control"  value="<?php echo "$eblock8";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime8" class="form-control"  value="<?php echo "$btime8";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi8" class="form-control"  value="<?php echo "$roi8";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">9th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock9" class="form-control"  value="<?php echo "$bblock9";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock9" class="form-control"  value="<?php echo "$eblock9";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime9" class="form-control"  value="<?php echo "$btime9";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi9" class="form-control"  value="<?php echo "$roi9";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">10th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock10" class="form-control"  value="<?php echo "$bblock10";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock10" class="form-control"  value="<?php echo "$eblock10";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime10" class="form-control"  value="<?php echo "$btime10";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi10" class="form-control"  value="<?php echo "$roi10";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">11th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock11" class="form-control"  value="<?php echo "$bblock11";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock11" class="form-control"  value="<?php echo "$eblock11";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime11" class="form-control"  value="<?php echo "$btime11";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi11" class="form-control"  value="<?php echo "$roi11";?>"/>
													</div>
												</div>

												<h6 style="margin-bottom: 26px;">12th Block</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Begin block " style="height: calc(2.25rem + 2px);" type="text" name="bblock12" class="form-control"  value="<?php echo "$bblock12";?>"/>
														<input placeholder="End block " style="height: calc(2.25rem + 2px);" type="text" name="eblock12" class="form-control"  value="<?php echo "$eblock12";?>"/>
														<input placeholder="Block time" style="height: calc(2.25rem + 2px);" type="text" name="btime12" class="form-control"  value="<?php echo "$btime12";?>"/>
														<input placeholder="ROI % " style="height: calc(2.25rem + 2px);" type="text" name="roi12" class="form-control"  value="<?php echo "$roi12";?>"/>
													</div>
												</div>

                        <h6 style="margin-bottom: 26px;">Proof of Stake Tiers</h6>
												<div class="row" style="margin-top:20px;margin-bottom: 32px">
													<div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Block " style="height: calc(2.25rem + 2px);" type="text" name="stblock1" class="form-control" required value="<?php echo "$block1";?>"/>
														<input placeholder="Anual %" style="height: calc(2.25rem + 2px);" type="text" name="stanual1" class="form-control" required value="<?php echo "$anual1";?>"/>
														<input placeholder="Daily %" style="height: calc(2.25rem + 2px);" type="text" name="stdaily1" class="form-control" required value="<?php echo "$daily1";?>"/>
														<input placeholder="Start" style="height: calc(2.25rem + 2px);" type="text" name="ststart1" class="form-control" required value="<?php echo "$start1";?>"/>
													</div>
                          <div class="col-md-3" style="margin-bottom: 10px;">
														<input placeholder="Block" style="height: calc(2.25rem + 2px);" type="text" name="stblock2" class="form-control" required value="<?php echo "$block2";?>"/>
														<input placeholder="Anual % " style="height: calc(2.25rem + 2px);" type="text" name="stanual2" class="form-control" required value="<?php echo "$anual2";?>"/>
														<input placeholder="Daily %" style="height: calc(2.25rem + 2px);" type="text" name="stdaily2" class="form-control" required value="<?php echo "$daily2";?>"/>
														<input placeholder="Start" style="height: calc(2.25rem + 2px);" type="text" name="ststart2" class="form-control" required value="<?php echo "$start2";?>"/>
													</div>
												</div>

												<button style="display: block;margin: 0 auto; width: 104px;" class="btn btn-sm btn-primary">Save Coin</button>

											</form>

										</div>
									</div>
</body>
