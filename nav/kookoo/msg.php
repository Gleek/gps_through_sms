<?php

include "lib/config.inc.php";
include('../../sms/fullonsms-api.php');
//phpinfo();
$con=$dbhandle;

if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){


	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	$sql="INSERT INTO `inbound_msgs` (`message`, `time`, `flag`) VALUES ('".$message."','".$time."',1)";
	//echo $sql;
	mysql_query($sql, $con);
	sendFullonSMS ( '9968371143' , '16537' , $_REQUEST['cid']  , 'Hello, Thanks for trying out our service !!');
	//mysql_error();


}


mysql_close($con);




?>