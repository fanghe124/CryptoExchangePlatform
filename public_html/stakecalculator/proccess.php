
 <?php

include 'config.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$coinname = $_POST["coinname1"];
$cointag  = $_POST["cointag1"];

$startblock = $_POST["startblock1"];
$startblocktime = $_POST["startblockdate1"];

$bblock1  = $_POST["bblock1"];
$eblock1  = $_POST["eblock1"];
$btime1   = $_POST["btime1"];
$roi1     = $_POST["roi1"];

$bblock2  = $_POST["bblock2"];
$eblock2  = $_POST["eblock2"];
$btime2   = $_POST["btime2"];
$roi2     = $_POST["roi2"];

$bblock3  = $_POST["bblock3"];
$eblock3  = $_POST["eblock3"];
$btime3   = $_POST["btime3"];
$roi3     = $_POST["roi3"];

$bblock4  = $_POST["bblock4"];
$eblock4  = $_POST["eblock4"];
$btime4   = $_POST["btime4"];
$roi4     = $_POST["roi4"];

$bblock5  = $_POST["bblock5"];
$eblock5  = $_POST["eblock5"];
$btime5   = $_POST["btime5"];
$roi5     = $_POST["roi5"];

$bblock6  = $_POST["bblock6"];
$eblock6  = $_POST["eblock6"];
$btime6   = $_POST["btime6"];
$roi6     = $_POST["roi6"];

$bblock7  = $_POST["bblock7"];
$eblock7  = $_POST["eblock7"];
$btime7   = $_POST["btime7"];
$roi7     = $_POST["roi7"];

$bblock8  = $_POST["bblock8"];
$eblock8  = $_POST["eblock8"];
$btime8   = $_POST["btime8"];
$roi8     = $_POST["roi8"];

$bblock9  = $_POST["bblock9"];
$eblock9  = $_POST["eblock9"];
$btime9   = $_POST["btime9"];
$roi9     = $_POST["roi9"];

$bblock10  = $_POST["bblock10"];
$eblock10  = $_POST["eblock10"];
$btime10   = $_POST["btime10"];
$roi10     = $_POST["roi10"];

$bblock11  = $_POST["bblock11"];
$eblock11  = $_POST["eblock11"];
$btime11   = $_POST["btime11"];
$roi11     = $_POST["roi11"];

$bblock12  = $_POST["bblock12"];
$eblock12  = $_POST["eblock12"];
$btime12   = $_POST["btime12"];
$roi12     = $_POST["roi12"];

$stblock1  = $_POST["stblock1"];
$stanual1  = $_POST["stanual1"];
$stdaily1  = $_POST["stdaily1"];
$ststart1  = $_POST["ststart1"];

$stblock2  = $_POST["stblock2"];
$stanual2  = $_POST["stanual2"];
$stdaily2  = $_POST["stdaily2"];
$ststart2  = $_POST["ststart2"];

$first_table_name = "$cointag"."_start";
$second_table_name = "$cointag"."_postiers";

$sql = "CREATE TABLE $first_table_name (
    CoinName varchar(255),
    StartBlock varchar(255),
    StartBlockTime varchar(255)
);";
$sql1 = "INSERT INTO $first_table_name (CoinName, StartBlock, StartBlockTime)
VALUES ('$coinname', '$startblock', '$startblocktime');";

$sql2 = "CREATE TABLE $cointag (
    BeginBlock varchar(255),
    EndBlock varchar(255),
    BlockTime varchar(255),
    Roi decimal(5,3)
);";
$sql3 = "INSERT INTO $cointag (BeginBlock, EndBlock, BlockTime, Roi)
VALUES ('$bblock1', '$eblock1', '$btime1', '$roi1'),
	     ('$bblock2', '$eblock2', '$btime2', '$roi2'),
	     ('$bblock3', '$eblock3', '$btime3', '$roi3'),
	     ('$bblock4', '$eblock4', '$btime4', '$roi4'),
	     ('$bblock5', '$eblock5', '$btime5', '$roi5'),
	     ('$bblock6', '$eblock6', '$btime6', '$roi6'),
	     ('$bblock7', '$eblock7', '$btime7', '$roi7'),
	     ('$bblock8', '$eblock8', '$btime8', '$roi8'),
	     ('$bblock9', '$eblock9', '$btime9', '$roi9'),
	     ('$bblock10', '$eblock10', '$btime10', '$roi10'),
	     ('$bblock11', '$eblock11', '$btime11', '$roi11'),
	     ('$bblock12', '$eblock12', '$btime12', '$roi12');";

$sql4 = "INSERT INTO coinlist (CoinTag, CoinName)
VALUES ('$cointag','$coinname');";

$sql5 = "CREATE TABLE $second_table_name (
    Block varchar(255),
    Anual varchar(255),
    Daily varchar(255),
    Start varchar(255)
);";
$sql6 = "INSERT INTO $second_table_name (Block, Anual, Daily, Start)
VALUES ('$stblock1', '$stanual1', '$stdaily1', '$ststart1'),
	     ('$stblock2', '$stanual2', '$stdaily2', '$ststart2');";


if ($conn->query($sql) === TRUE) {
    echo "PROCCESSING <br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
if ($conn->query($sql1) === TRUE) {
    echo "PROCCESSING <br>";
} else {
    echo "Error: " . $sql1 . "<br>" . $conn->error;
}
if ($conn->query($sql2) === TRUE) {
    echo "PROCCESSING <br>";
} else {
    echo "Error: " . $sql2 . "<br>" . $conn->error;
}
if ($conn->query($sql3) === TRUE) {
    echo "PROCCESSING <br>";
} else {
    echo "Error: " . $sql3 . "<br>" . $conn->error;
}
if ($conn->query($sql4) === TRUE) {
    echo "PROCCESSING";
} else {
    echo "Error: " . $sql4 . "<br>" . $conn->error;
}
if ($conn->query($sql5) === TRUE) {
    echo "PROCCESSING";
} else {
    echo "Error: " . $sql5 . "<br>" . $conn->error;
}
if ($conn->query($sql6) === TRUE) {
    echo "PROCCESSING <br> New coin record created successfully <br> <a href='admin.php'> << Return</a>";
} else {
    echo "Error: " . $sql6 . "<br>" . $conn->error;
}

$conn->close();
?>
