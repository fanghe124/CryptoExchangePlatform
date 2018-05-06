<?php
include 'config1.php';


$coinselect = $_GET["coin"];

mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin4 = sprintf("SELECT * FROM Main_Coin_List WHERE Coin_TAG = '".strtoupper($coinselect)."'");
$rs_userlogin4 = mysql_query($query_rs_userlogin4, $connectdb) or die(mysql_error());
$row_rs_userlogin4 = mysql_fetch_assoc($rs_userlogin4);
$totalRows_rs_userlogin4 = mysql_num_rows($rs_userlogin4);

?>

<?php
$contentcoins = file_get_contents($row_rs_userlogin4['API_LINK']);

$resultcoinsblock = json_decode($contentcoins);


?>


<?php 

	mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin456 = sprintf("SELECT * FROM coinlist WHERE Coin_TAG = '".$row_rs_userlogin4['Coin_TAG']."'");
$rs_userlogin456 = mysql_query($query_rs_userlogin456, $connectdb) or die(mysql_error());
$row_rs_userlogin456 = mysql_fetch_assoc($rs_userlogin456);
$totalRows_rs_userlogin456 = mysql_num_rows($rs_userlogin456);


$blockvaluescheckarray = array();


	if(mysql_num_rows($rs_userlogin456)){ do { 


array_push($blockvaluescheckarray, array("blockstart" => $row_rs_userlogin456['Start_block'], "endblock" => $row_rs_userlogin456['End_block'], "roi" => $row_rs_userlogin456['ROI']));



 } while ($row_rs_userlogin456 = mysql_fetch_assoc($rs_userlogin456)); } 


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
					
					<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>

          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

					<link rel="stylesheet" href="chartlist.css" />
					<meta name="keywords" content="" />
					<meta name="description" content="" />
					
					
					<style>
					
					@media (min-width: 576px){
.container2 {
    max-width: 540px;
}

}

				@media (min-width: 768px){
.container2 {
    max-width: 720px;
}
}


		@media (min-width: 992px){
.container2 {
    max-width: 960px;
}
					}
					
					
					@media (min-width: 1200px){
.container2 {
    max-width: 1140px;
}
					}
					
			
					
					
	



					
					</style>

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
		  
		  
		  
		  <div class="jumbotron" style="    background-color: #d6d6d6;
    position: relative;
    padding: 2rem 2rem;">
		  
		  <a href="index.php" style="position:  absolute;
    top: 15px;
    left: 20px;"><img src="http://icons.iconarchive.com/icons/iconsmind/outline/512/Back-2-2-icon.png" style="
    width: 40px;
    
"> </a>
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

<div class="container2" style="    margin: 0 auto;">

		  <div class="row">
		  
		  <div class="col-md-8">
					<div class="container" style="    margin-bottom: 50px;">
					<form align="center" id="alert-form" action="coin.php?coin=<?php echo $row_rs_userlogin4['Coin_TAG']; ?>" method="post">

						<h5 style="display:none;">Select a coin to calculate</h5>
						<select style="display:none;" name="coin"  class="select2 form-control">
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

						<h3 style="
    text-align:  left;
    margin-bottom: 15px;
    font-size: 1.5rem;
">Calculate</h3>
						<div class="row">		
					
							<div class="col-sm-8" style="">
					

								<input style="    height: calc(2.25rem + 2px);
    text-align: center;
    font-size: 18px !important;" type="text" name="quantity" class="form-control" placeholder="Enter your balance" />
						</div>
						
						
						<div class="col-sm-4" style="">
						<select name="view" style="margin-bottom: 32px;
    font-size: 18px !important;" class="select2 form-control">
							<option value='m'>Monthly</option>
							<option value='w'>Weekly</option>
							<option value='d'>Daily</option>
						</select>
</div>
						<div class="col-sm-6" style="
    width: 100%;
  
">

	<button style="    display: block;
    margin: 0 auto;
    padding: 6px;
    font-size: 16px;
    font-weight: 500;
    background-color: #428bca;
    border: 1px solid #507494;
    width: 100%;" class="btn btn-sm btn-primary">Calculate</button>
	</div>
		</div>		 
				 
				 </form>
			 </div>

				 <div class="container"><br>



					 
					 <canvas id="line-chart" width="800" height="450"></canvas>
					 
					 <script type="text/javascript">
		new Chart(document.getElementById("line-chart"), {
  type: 'line',
  data: {
    labels: [<?php for( $i2= 1 ; $i2 <= 365 ; $i2++ )
{

if($i2 == 1){
	
echo '"'.$i2.' Day",';

} else if ($i2 == 365){
	
echo '"'.$i2.' Days"';

}else {
	
	echo '"'.$i2.' Days",';
	
}

}	?>],
    datasets: [{ 
        data: [<?php
		
		$startblockdaily1 = $resultcoinsblock;
$daysneed1 = 0;
$valuemoredaycoin1 = 1000;
		
		for( $i3= 1 ; $i3 <= 365 ; $i3++ ){

$calcamountblockperday2 = 86400/$row_rs_userlogin4['Block_Time'];
											$startblockdaily1 += $calcamountblockperday2;
										$daysneed1 += 1;
										$blockperecetnroi = 0;
										
									
foreach($blockvaluescheckarray as $blockinfoinvidvualArray){

	if($startblockdaily1 <= $blockinfoinvidvualArray['endblock']){
		
		$blockperecetnroi = $blockinfoinvidvualArray['roi'];
		
		break;
		
	}
	

}	

										$daily = number_format((float)(($blockperecetnroi))/365, 3, '.', '');
										$valuemoredaycoin1 += (($valuemoredaycoin1/100)*$daily);
										
			
 															 if($i3 == 365){
	
echo $valuemoredaycoin1;

} else {
	
	echo $valuemoredaycoin1.",";
	
}
 											
								
										
										
						


}	
		
		
		?>],
        label: "Balance",
        borderColor: "#3e95cd",
        fill: true,
backgroundColor: "#8d9aa5"
      }
    ]
  }, 
  options: {
	  legend:{
  display:true
}, scales:
        {
            xAxes: [{
           
		   ticks: {
        autoSkip: true,
        maxTicksLimit: 20
    }
			
            }]
        }
  }
});
		 </script>
		 
		 
		 
					 






<div>
						<?php 
							echo "<h5 align='middle'>Calculations along the time</h5>
 						


 								 <table id='portfolioTransactionList' class='table table-hover  table-coin table-coin-res'>
 									 <thead>
 										 <th> Block </th>
 										 <th> Date </th>
										 <th> Daily % </th>
 										 <th> Estimated balance </th>
 										 
 									 </thead>
 									 <tbody>";

 										

$startblockdaily = $resultcoinsblock;
$daysneed = 0;
$valuemoredaycoin = 4089;



									
								
for( $i= 1 ; $i <= 365 ; $i++ )
{

$calcamountblockperday2 = 86400/$row_rs_userlogin4['Block_Time'];
											$startblockdaily += $calcamountblockperday2;
										$daysneed += 1;
										$blockperecetnroi = 0;
										
									
foreach($blockvaluescheckarray as $blockinfoinvidvualArray){

	if($startblockdaily <= $blockinfoinvidvualArray['endblock']){
		
		$blockperecetnroi = $blockinfoinvidvualArray['roi'];
		
		break;
		
	}
	

}	


                                     
										$daily = number_format((float)(($blockperecetnroi))/365, 3, '.', '');
										$valuemoredaycoin += (($valuemoredaycoin/100)*$daily);
										
										
										
										echo "<tr>";
 															 echo "<td align='center'>".$startblockdaily."</td>";
 															 echo "<td align='center'>".$daysneed."</td>";
 															 echo "<td align='center'>".$daily." %</td>";
 															 echo "<td align='center'>".$valuemoredaycoin."</td>";
 															 echo "</tr>";
								
										
										
						


}	 
 														
		 							 	 			echo "</tbody></table>";


						

								?>

								
								</div>
								
								
								
								
								
								
							<script type="text/javascript">
	function OnCalculateClicked() {
		var balance = $('#balance').val();
		var period = $('#period').val();

		return Calculate(balance, period);
	}

	function Calculate(balance, period) {
		var loader = $('.calculate-loader');
		loader.show();

		$.get('/currencies/HOLD/calculate?balance=' + balance + '&period=' + period, function (data) {
			$('#CalculateResult').html(data);
			loader.hide();
		});

		return false;
	}

	$(document).ready(function() {
		Calculate(1000, 'Monthly');
	});
</script>	
								
								
								
								

			 </div>
		 </div>

				<div class="col-md-4">
				
				<div>
					 <h5 align="middle">Proof-of-Staking Tiers</h5>
				 <table id="portfolioTransactionList" class="table table-hover  table-coin table-coin-res">
					 <thead>
						 <th> Block </th>
						 <th> Anual % </th>
						 <th> Daily %</th>
						 <th> Start </th>
					 </thead>
					 <tbody>
					 
					 
					 	<?php
									
									
mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin45 = sprintf("SELECT * FROM coinlist WHERE Coin_TAG = '".$row_rs_userlogin4['Coin_TAG']."'");
$rs_userlogin45 = mysql_query($query_rs_userlogin45, $connectdb) or die(mysql_error());
$row_rs_userlogin45 = mysql_fetch_assoc($rs_userlogin45);
$totalRows_rs_userlogin45 = mysql_num_rows($rs_userlogin45);



									
										if(mysql_num_rows($rs_userlogin45)){ do { 
										
										
										 $block = $row_rs_userlogin45['Start_block'];
										 $endblock = $row_rs_userlogin45['End_block'];
										 $anual = $row_rs_userlogin45['ROI'];
										 $daily = number_format((float)$row_rs_userlogin45['ROI']/365, 3, '.', '');
										 $start = $row_rs_userlogin45['ROI'];

											 echo "<tr>";
											 echo "<td align='center'>$block </td>";
											 echo "<td align='center'>$anual %</td>";
											 echo "<td align='center'>$daily %</td>";
											 echo "<td align='center'>";
											 
											 
											 if($resultcoinsblock > $block && $resultcoinsblock < $endblock){
												 
												 echo "Current";
												 
											 } else if($resultcoinsblock > $block){
												 
												 echo "-";
												 
											 } else {
												 
												 $calcamountblockperdaycurrent = $block - $resultcoinsblock;
												  $calcamountblockperday = 86400/$row_rs_userlogin4['Block_Time'];
												  $calcamountblockperdaycurrentfinal = $calcamountblockperdaycurrent/$calcamountblockperday;
												  
												  
												  if(number_format((float)$calcamountblockperdaycurrentfinal/30, 0, '.', '') > 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal/30, 0, '.', '')." Months";
													  
													  
												  } else if(number_format((float)$calcamountblockperdaycurrentfinal/30, 0, '.', '') == 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal/30, 0, '.', '')." Month";
													  
													  
												  } else if(number_format((float)$calcamountblockperdaycurrentfinal, 0, '.', '') < 30 && number_format((float)$calcamountblockperdaycurrentfinal, 0, '.', '') > 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal, 0, '.', '')." Days";
											
												  } else  if(number_format((float)$calcamountblockperdaycurrentfinal, 0, '.', '') == 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal, 0, '.', '')." Day";
													  
												  } else  if(number_format((float)$calcamountblockperdaycurrentfinal*2.4, 0, '.', '') > 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal*2.4, 0, '.', '')." Hours";
													  
												  } else  if(number_format((float)$calcamountblockperdaycurrentfinal*2.4, 0, '.', '') == 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal*2.4, 0, '.', '')." Hour";
													  
												  }   else  if(number_format((float)$calcamountblockperdaycurrentfinal*1440, 0, '.', '') > 1){
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal*1440, 0, '.', '')." Minutes";
													  
												  } else {
													  
													  echo number_format((float)$calcamountblockperdaycurrentfinal*1440, 0, '.', '')." Minute";
												  }
												  
												  
												 
											 }
											  
										
											 echo "</td>";
											 
											 echo "</tr>";
										
										
										 } while ($row_rs_userlogin45 = mysql_fetch_assoc($rs_userlogin45)); } 
										
			
									
									 ?>
					 
					 

							
							 </tbody>
						 </table>
						 
						 </div>
				
				</div>
				</div>
				</div>
					 

</body>
