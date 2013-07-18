<?php

//include "lib/config.inc.php";
phpinfo();


if(isset($_REQUEST['event']) && $_REQUEST=="NewSMS"){

	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	mysqli_query($con,"INSERT INTO inbound_msgs (message, time, flag) VALUES ('$message','$time' ,1)");



}

mysqli_close($con);




?>