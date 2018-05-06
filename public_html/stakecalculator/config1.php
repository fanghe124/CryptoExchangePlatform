
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_connectdb = "localhost";
$database_connectdb = "crypto_lol";
$username_connectdb = "crypto_lol";
$password_connectdb = "emmaweston7";
$connectdb = mysql_pconnect($hostname_connectdb, $username_connectdb, $password_connectdb) or trigger_error(mysql_error(),E_USER_ERROR); 
?>


