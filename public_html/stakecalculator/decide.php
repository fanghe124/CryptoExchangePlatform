<?php
$selectedcoin    = $_POST["coin"];
if (empty($selectedcoin)) {
    header("Location: index.php");
}
$calculatedbalance = $_POST["quantity"];
if (empty($calculatedbalance)) {
    header("Location: index.php");
}
$selectedop = $_POST["stktype"];
if (empty($selectedop)) {
    header("Location: index.php");
}
//-------------------------------------
switch(strtoupper($selectedop))
{
    case 'monthly': header("Location: monthly.php?coin=$selectedcoin&quantity=$calculatedbalance");  break;
    case 'weekly': header("Location: weekly.php?coin=$selectedcoin&quantity=$calculatedbalance"); break;
    case 'daily': header("Location: daily.php?coin=$selectedcoin&quantity=$calculatedbalance");  break;
    default:  header("Location: monthly.php?coin=$selectedcoin&quantity=$calculatedbalance");  break;
}
?>
