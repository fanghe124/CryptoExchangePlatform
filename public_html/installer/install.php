<?php

$dbhost = input('dbhost');
$dbusername = input('dbusername');
$dbname = input('dbname');
$dbprefix = input('dbprefix');
$dbpassword = input('dbpassword');
$fullname = input('fullname');
$username = input('username');
$email = input('email');
$password = input('password');
$confirmPassword = input('confirm_password');
$appID = input('app_id');
$error = false;
$errorType = '';

function hash_make($content)
{
   return md5($content);
}

function request_url($url) {
    $ch = curl_init($url);
    curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
    curl_setopt( $ch, CURLOPT_COOKIEJAR, tempnam ("/tmp", "CURLCOOKIE") );
    curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 100 );
    curl_setopt( $ch, CURLOPT_TIMEOUT, 100 );
    curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json'
    ));
    $result = curl_exec($ch);
    //var_dump($result)
    curl_close($ch);
    $session = @json_decode($result, true);
    return $session;
}


class InstallDatabase {
    private static $instance;

    private $host;
    private $dbName;
    private $username;
    private $password;

    public $db;
    private $driver;

    private $dbPrefix;

    public function __construct($host,$dbName,$dbUsername,$dbPassword,$dbPrefix) {
        $this->host = $host;
        $this->dbName = $dbName;
        $this->username = $dbUsername;
        $this->password = $dbPassword;
        $this->dbPrefix = $dbPrefix;
        try {
            $this->db = new \PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(Exception $e) {
            exit($e->getMessage());
        }
    }

    public function query($query) {
        $args = func_get_args();
        array_shift($args);
        if (isset($args[0]) and is_array($args[0])) {
            $args = $args[0];
        }
        $response = $this->db->prepare($query);
        $response->execute($args);

        return $response;
    }

    public function lastInsertId(){
        return $this->db->lastInsertId();
    }

    public function prepare($query) {

        $args = func_get_args();

        $response = $this->db->prepare($query);
        return $response;
    }

}

//test for
try {
    $db = new InstallDatabase($dbhost,$dbname,$dbusername,$dbpassword,'');
   //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Exception $e) {
    ///exit($e->getMessage());
    $error = true;
    $errorType = 'db';
   // exit('am her');
}

if (!$error) {
    if ($password != $confirmPassword) {
        $error = true;
        $errorType = 'password';
    } else {
        $configHolderContent = file_get_contents('../app/vendor/cfg.php');
        $configHolderContent = str_replace(array('{host}','{username}','{name}','{password}','{installed}'), array(
            $dbhost,$dbusername,$dbname,$dbpassword,1
        ), $configHolderContent);

        file_put_contents('../config.php', $configHolderContent);


        $sqlContent = file_get_contents('sql.txt');
        $db->query($sqlContent);

        $db = new mysqli($dbhost, $dbusername, $dbpassword, $dbname);

        //insert rate_app_id
        $db->query("INSERT INTO settings (setting_key,setting_value) VALUES('rate_app_id','$appID')");
        //print_r($db->db->errorInfo());

        //add admin
        $password = hash_make($password);


        $time = time();

        $db->query("INSERT INTO members (username,email,password,role,date_created,active)
        VALUES('$username','$email','$password','1','$time','1')");

        $homeUrl = url('?step=4');

        header("location:".$homeUrl);

    }
}

//header("location:".url('?step'))