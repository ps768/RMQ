#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

$client = new rabbitMQClient("testRabbitMQ.ini","testServer");
if (isset($argv[1]))
{
  $msg = $argv[1];
}
else
{
  $msg = "test message";
}

$request = array();
$request['type'] = $_GET['type'];
$request['username'] = $_GET['username'];
$request['password'] = $_GET['password'];

$request['message'] = $msg;


if($request['type'] == 'register'){
$request['firstname'] = $_GET['firstname'];
$request['lastname'] = $_GET['lastname'];
$request['weight'] = $_GET['weight'];
$request['height'] = $_GET['height'];
$request['gender'] = $_GET['gender'];
$request['dietplan'] = $_GET['dietplan'];
}


$response = $client->send_request($request);
//$response = $client->publish($request);

echo "client received response: ".PHP_EOL;
print_r($response);
echo "\n\n";

echo $argv[0]." END".PHP_EOL;
