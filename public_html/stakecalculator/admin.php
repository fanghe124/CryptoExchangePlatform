<?php
include 'config1.php';
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
					
					
					<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

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
                         <a class="nav-link" href="admin.php">Home (Admin) <span class="sr-only">(current)</span></a>
                       </li>
                     </ul>
                   </div>
           </nav>

					<div class="col-md-12">
						<div class="pane bg-white">

							<h5 style="text-align:center;margin-bottom: 26px;    font-size: 35px;">Add a coin</h5>
							
							
							<form id="alert-form" action="edit.php" method="post">
								<h5 style="    text-align: center;
    font-size: 18px;
    margin-top: 60px;">Current Coins</h5>

								<select style="   height: calc(3.25rem + 2px);
    width: 400px;
    text-align: center;
    margin: 0 auto;" name="coin"  class="select2 form-control">
									<?php
									
									
mysql_select_db($database_connectdb, $connectdb);
$query_rs_userlogin = sprintf("SELECT * FROM Main_Coin_List");
$rs_userlogin = mysql_query($query_rs_userlogin, $connectdb) or die(mysql_error());
$row_rs_userlogin = mysql_fetch_assoc($rs_userlogin);
$totalRows_rs_userlogin = mysql_num_rows($rs_userlogin);



										if ($totalRows_rs_userlogin > 0) {
										
										if(mysql_num_rows($rs_userlogin)){ do {
										
												echo "<option value='".$row_rs_userlogin['Coin_TAG']."'>[".$row_rs_userlogin['Coin_TAG']."] ".$row_rs_userlogin['Coin_Name']."</option>";
										

 } while ($row_rs_userlogin = mysql_fetch_assoc($rs_userlogin)); } 										

										
			
										} else {
											echo "<div style='color: red;'>No coins on the Database!</div>";
										}
									
									 ?>
								</select>
									<br>
										<button style="display: none;margin: 0 auto; width: 104px;" class="btn btn-sm btn-primary">Current Coin</button>
										<br>
											<a href="delete.php?coinTag=" style=" display:none;   color: red;

    margin: 0 auto;
    width: 104px;">Delete this coin</a>
							</form>
							
							
			<script>
    $(document).ready(function(){
        $(".addmore").on('click', function () {
            var count = $('table tr').length;
            var data = "<tr class='case'><td><input class='form-control' type='text' id='c1' name='c1[]'/></td> <td><input class='form-control' type='text' id='c2' name='c2[]'/></td></tr>";
            $('#form_table').append(data);
            i++;
        });
        $(".delete").on('click', function () {
            $('tr.case:last').remove();
        });
        //insert into database
        $('.insert').on('click', function(){
            $.ajax({
                url: 'ajax.php',
                method: 'post',
                data: $('form#alert-form').serialize(),
                success: function(data){
                    $('#record_list').html(data);
                }
            });
        });
    });
</script>
				
							
							
							<form id='alert-form' method='post' name='alert-form' action='admin.php' style="    margin-top: 75px;">
							
							
							<div class="col-md-6" style="
    display:  inline-block;
    text-align:  center;
">	
							
								<h6 style="margin-bottom: 20px;">Coin name</h6>
												<div  style="margin-top:20px;margin-bottom: 4px">
													<div style="margin-bottom: 10px;">
														<input style="height: calc(3.25rem + 2px);" type="text" name="coinname1" class="form-control" required/>
													</div>
												</div>
</div>
												
												
												<div class="col-md-6" style="
    display:  inline-block;
    text-align:  center;
">	
												<h6 style="margin-bottom: 20px;">Coin TAG</h6>
												<div  style="margin-top:20px;margin-bottom: 4px">
													<div  style="margin-bottom: 10px;">
														<input style="height: calc(3.25rem + 2px);" type="text" name="cointag1" class="form-control" required/>
													</div>
												</div>
												</div>
												
												
												<div class="col-md-6" style="
    display:  inline-block;
    text-align:  center;
">	
												<h6 style="margin-bottom: 20px;">Block Time</h6>
												<div  style="margin-top:20px;margin-bottom: 4px">
													<div style="margin-bottom: 10px;">
														<input style="height: calc(3.25rem + 2px);" type="text" name="blocktime1" class="form-control" required/>
													</div>
												</div>
												
												</div>
												
												<div class="col-md-6" style="
    display:  inline-block;
    text-align:  center;
">	
												<h6 style="margin-bottom: 20px;">API_LINK</h6>
												<div  style="margin-top:20px;margin-bottom: 4px">
													<div style="margin-bottom: 10px;">
														<input style="height: calc(3.25rem + 2px);" type="text" name="apilink1" class="form-control" required/>
													</div>
												</div>
												
												</div>
												
												<div class="col-md-6" style="
    display:  inline-block;
    text-align:  center;
">	
												<h6 style="margin-bottom: 20px;">LOGO</h6>
												<div  style="margin-top:20px;margin-bottom: 4px">
													<div style="margin-bottom: 10px;">
														<input style="height: calc(3.25rem + 2px);" type="text" name="logo1" class="form-control" required/>
													</div>
												</div>
												
												</div>
												
												<div class="col-md-6" style="
    display:  inline-block;
    text-align:  center;
">	
												<h6 style="margin-bottom: 20px;">WEBSITE</h6>
												<div  style="margin-top:20px;margin-bottom: 4px">
													<div style="margin-bottom: 10px;">
														<input style="height: calc(3.25rem + 2px);" type="text" name="website1" class="form-control" required/>
													</div>
												</div>
							</div>
							
							
    <div style="padding-top: 56px;" class="table-responsive">
        <table id="form_table" class="table table-bordered">
            <tr>
                <th>Start Block</th>
                <th>ROI %</th>
            </tr>
            <tr class='case'>
                <td><input class="form-control" type='number' id='c1' name='c1[]'/></td>
                <td><input class="form-control" type='number' id='c2' name='c2[]'/></td>
            </tr>
        </table>
        <input type="hidden" name="is_submit" value="yes"/>
        <button type="button" class='btn btn-danger delete'>- Delete</button>
        <button type="button" class='btn btn-primary insert'>- Insert</button>
        <button type="button" class='btn btn-success addmore'>+ Add More</button>
    </div>
</form>
							
							
						
							

							

									</div>
								</div>
								

</body>
