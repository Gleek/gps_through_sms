<?php

include "lib/config.inc.php";
//phpinfo();
$con=$dbhandle;

if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){

echo "in";
	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	$sql="INSERT INTO `inbound_msgs` (`message`, `time`, `flag`) VALUES ('".$message."','".$time."',1)";
	echo $sql;
	mysql_query($sql, $con);
	mysql_error();



}
echo "out";
mysql_close($con);




?>