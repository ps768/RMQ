#!/usr/bin/php
<?php
include 

//require_once('/home/mihir/git/rabbitMQ/path.inc');
//require_once('/home/mihir/git/rabbitMQ/get_host_info.inc');
//require_once('/home/mihir/git/rabbitMQ/rabbitMQLib.inc');

//$client = new rabbitMQClient("/home/mihir/git/rabbitMQ/testRabbitMQ.ini","testServer");
/*
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "loginnnnnnnnnn";
}


$request = array();
$request['type'] = "login";
$request['username'] = $_POST['username'];
$request['password'] = $_POST['password'];
$request['message'] = $msg;
$response = $client->send_request($request);
//$response = $client->publish($request);
echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

if ($response == 0 ) {

header("location:login.html");
echo "Login Failed Please try again";

}
else {

	header("location:success.php");

}
*/


$username= $_GET['username'];
$passowrd= $_GET['password'];





?>
