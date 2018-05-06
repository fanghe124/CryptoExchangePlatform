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
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
		  
		  
		  	<script>
	


$(function(){
			var searchInputPast = null;
			$(".clearable").on('keyup keydown change', function(){
				
				searchInputPast = keyword;

				var allChampions = $(".coinslist > .inlinecoins");
				
				
				var keyword = $(this).val().toLowerCase();
				if (keyword == searchInputPast) {
					return;
				}

				

				if (keyword.length > 0) {
					var selectedChampions = $(".coinslist > .inlinecoins[data-coin-name^='" + keyword + "'],.coinslist > .inlinecoins[data-coin-name^='" + keyword + "']");

					allChampions.hide();
					selectedChampions.show();
				} else {
					allChampions.show();
				}
				
				
			});
			

		});
		

		
	</script>
	
		  

		  
		  
		  
					<div class="container">
					
					<h3 style="
    text-align:  center;
    margin-top: 56px;
    font-size: 36px;
    font-weight: 700;
">PROOF OF STAKE COINS</h3>

<form class="searchbar_champions" style="
    display: flex;
    flex: 1 1;
    =: auto
    align-self: auto;
    color: #fff;
    border-radius: 5px;
    height: 100%;
    width: 65%;
    margin: 0 auto;
    text-align:  center;
    margin-top: 40px;
">


<input class="clearable" type="text" name="" value="" placeholder="Enter Proof of Stake Coin" style="
    color: #868686;
    font-family: sans-serif;
    line-height: 1.15;
    margin: 0;
    overflow: visible;
    text-align:  center;
    border-radius: 16px;
    box-sizing: border-box;
    letter-spacing: 1px;
    outline: none;
    border: 2px solid #1a1d23;
    padding: 8px;
    padding-right: 9.7%;
    padding-left: 5%;
    margin:  0 auto;
    width: 100%;
">
</form>


					
					<div class="coinslist" id="coinslist" style="    margin-top: 50px;">
					
					<?php
									
									
mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin = sprintf("SELECT * FROM Main_Coin_List");
$rs_userlogin = mysql_query($query_rs_userlogin, $connectdb) or die(mysql_error());
$row_rs_userlogin = mysql_fetch_assoc($rs_userlogin);
$totalRows_rs_userlogin = mysql_num_rows($rs_userlogin);



						
										
										if(mysql_num_rows($rs_userlogin)){ do { 
										
												echo '<div class="inlinecoins" data-coin-name="'.strtolower($row_rs_userlogin['Coin_Name']).'" style="
    display:  inline-block;
">
    
    <a href="coin.php?coin='.$row_rs_userlogin['Coin_TAG'].'">
    <img src="'.$row_rs_userlogin['logo'].'" style="
    width: 120px;
">
<p style="
    text-align:  center;
    font-size: 18px;
    margin-top: 8px;
    font-weight: 600;
">'.$row_rs_userlogin['Coin_Name'].'</p>
    </a>
 </div>';
										
										 } while ($totalRows_rs_userlogin = mysql_fetch_assoc($rs_userlogin)); } 
										
			
										 
									
									 ?>
					
					</div>
				
</div>

		 

					
		

</body>
