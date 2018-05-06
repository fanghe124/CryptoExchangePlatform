
<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Highcharts Example</title>

		<style type="text/css">

		</style>
	</head>
	<body>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<!-- <script src="code/highcharts.js"></script> -->
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<!-- <script src="code/modules/exporting.js"></script> -->

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="demo" ></div>



<script type="text/javascript">

// eto ung data from out database
// $.getJSON('http://localhost/chart/jsondb.php', function (data) {
// $.getJSON('http://localhost/chart/file.json', function (data) {
$.when(
	$.getJSON('http://localhost/chart/usdprice.php'),
	$.getJSON('http://localhost/chart/btcprice.php')
 ).done(function(data, data2){

	
	// return data
// });
	// kinonvert ko ung data sa json para mabasa ng js script ntin
	// console.log(dat.responseText);
	data = JSON.parse(data[0])
	data2 = JSON.parse(data2[0])
	// check mo ung data sa console
	console.log(data2[2000])
	
	// mas madali mo syang maggets kung pano nakuha ung mga datas ko kung titignan mo ung console mo s chrome,, 
	load = []
	load1 = []
	volume = []

	// dito mo isserialize ung datas mo, so issegregate mo lang sya para sa chart datas na need ng bawat series mo,,
	// ung series, sya ung type of chart, ex: line, column, candle stick, spline
	// makkita mo sa baba ung series
	for(i=0; i < data.length; i ++){
		// data sample {time: 1352160000, close: 0, high: 0, low: 0, open: 0, low:0, volumeto:0, volumefrom }
		// console.log(data2[i], i)
		// first data para sa line ng USD price
		load.push([
				data[i]['time'] * 1000, //date na nakaunix time sya, then minultiply ko sa 1000, kasi un ung required na data na need netong chart, pihikan ehh
				data[i]['close'] // close data, pwedeng open data ang ilagay mo dito,, pero yan ay sample lng, 
			])
			
		// second line para sa line ng BTC price*** sample lng to,,kasi wala pa sa database natin un
		load1.push([
			data[i]['time'] * 1000,
			data2[i]['close']
		])
		
		// volume data, na nageexists sa datasets ntin,
		volume.push([
				data[i]['time'] * 1000,
				data[i]['volumeto']
			])
	};
	// console.log(data[2000]),
	// console.log(volume),
	
	Highcharts.stockChart('container', {
		
		chart:{
			borderColor: '#EBBA95',
            borderWidth: 3,
			zoomType: 'x',
			height:"40%"
			
		},
		
		colors: ["#1A98FA", "#BA0000", "#6F6F6F"],
		
		// eto ung color legend na makkita mo sa baba ng chart
		legend: {
            enabled: true,
            layout: 'horizontal',
            maxHeight: 100               
           },
		
			
        rangeSelector: {
            selected: 1
        },
		
		// title ng chart
        title: {
            text: 'XML Price'
        },
		tooltip: {
            split: true
        },
		
		// dito mag sseparate ung chart mo,, kung makkita mo, nakaseparate ung chart sa line at volume sa baba
		// yAxis: [{ //for line chart
            // labels: {
                // align: 'right',
                // x: -3
            // },
            // title: {
                // text: 'Line'
            // },
            // height: '60%',
            // lineWidth: 2,
            // resize: {
                // enabled: true
            // }
        // },{ //for volume chart
            // labels: {
                // align: 'right',
                // x: -3
            // },
            // title: {
                // text: 'Volume'
            // },
            // top: '65%',
            // height: '35%',
            // offset: 0,
            // lineWidth: 2
        // }],
		
		yAxis: [
		{ //for line chart
            title:{
				text:"USD"
			}
        },{ //for line chart
            title:{
				text:"BTC"
			}
        },
		{ //for volume chart
            labels: {
                align: 'right',
                x: -3
            },
            title: {
                text: 'Volume'
            },
            top: '65%',
            height: '35%',
            offset: 0,
            lineWidth: 2
        }],
			
		
		// eto ung series na kung saan dito ka mag ccall ng charts mo, ex: line, column, candle stick, spline
		// so meron tayong tatlong series, two lines at one volume,
        series: [{ // for USD Price line
            name: 'Price (USD)',
            data: load,
            tooltip: {
                valueDecimals: 2
            },
			
        },{ // for BTC Price line
            name: 'Price (BTC)',
            data: load1,
            tooltip: {
                valueDecimals: 2
            },
			
        },{ // for Volume
            type: 'column',
            name: '24h Volume',
            data: volume,
            yAxis: 1,
          
        }]
    });
		

   
});

</script>
</body>
</html>
