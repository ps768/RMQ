#!/usr/bin/php
<?php
require_once('path.inc');
require_once('get_host_info.inc');
require_once('rabbitMQLib.inc');

function doLogin($username,$password)
{
$mydb = mysqli_connect('localhost','dbadmin','dbadminpw','db');

if ($mydb->errno != 0)
{
        echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        exit(0);
}

echo "successfully connected to database".PHP_EOL;
	$query = mysqli_query($mydb,"SELECT * FROM users WHERE username = '$username' AND password = '$password' ");
	$count = mysqli_num_rows($query);
	//Check if credentials match the database
	if ($count == 1){
			//Match
			echo "<br><br>USERS CREDENTIALS VERIFIED";
			return true;
		}else{
			//No Match
                	echo "<br><br>Failed user login. User entered incorrect credentials.";
        	        return false;
		}

if ($mydb->errno != 0)
{
        echo "failed to execute query:".PHP_EOL;
        echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
        exit(0);
}

}


function doregister($firstname,$lastname,$username,$password,$height,$weight,$gender,$dietplan)
{
$mydb = mysqli_connect('localhost','dbadmin','dbadminpw','db');

if ($mydb->errno != 0)
{
        echo "failed to connect to database: ". $mydb->error . PHP_EOL;
        exit(0);
}

echo "successfully connected to database".PHP_EOL;

	$query = mysqli_query($mydb,"SELECT * FROM users WHERE username = '$username' AND password = '$password'");
	$count = mysqli_num_rows($query);

        //Check if credentials match the database
        if ($count > 0){
                        //Match
                        echo "<br><br>Please register with differernt User Name";
                        return false;
                }else{
                        //No Match
			$query = mysqli_query($mydb,"INSERT INTO users (firstname, lastname, username, password,height,weight,gender,dietplan) VALUES ('$firstname','$lastname','$username','$password','$height','$weight','$gender','$dietplan')");

			echo "<br><br>Register Successful!!!!";
                        return true;
                }

if ($mydb->errno != 0)
{
        echo "failed to execute query:".PHP_EOL;
        echo __FILE__.':'.__LINE__.":error: ".$mydb->error.PHP_EOL;
        exit(0);
}



}





function requestProcessor($request)
{
	$result = "";
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch ($request['type'])
  {
    case "Login":
	    if(doLogin($request['username'],$request['password'])){

		$result= array("returnCode" => '1', 'message'=>"Login successful: Server received request and processed");
} else{
$result= array("returnCode" => '1', 'message'=>"Login failed. try again!: Server received request and processed");
} break;
    case "register":
	  if( doregister($request ['firstname'],$request['lastname'],$request['username'],$request['password'],$request ['height'],$request['weight'],$request['gender'],$request['dietplan'])){
$result= array("returnCode" => '1', 'message'=>"Registration Successful: Server received request and processed");


}else{
$result= array("returnCode" => '1', 'message'=>"Registration failed. try again!: Server received request and processed");
} break;


    /*case "validate_session":
      return doValidate($request['sessionId']);
*/
  }
  return $result;
}







$server = new rabbitMQServer("testRabbitMQ.ini","testServer");
echo "rabbitMQServer BEGIN".PHP_EOL;
$server->process_requests('requestProcessor');
echo "rabbitMQServer END".PHP_EOL;
exit();



?>
