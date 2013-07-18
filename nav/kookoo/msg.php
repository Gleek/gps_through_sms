<?php

include "lib/config.inc.php";
//phpinfo();
$con=$dbhandle;
require_once("kookoophp/snippets/response.php");

$r= new Response();

if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){


	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	$sql="INSERT INTO `inbound_msgs` (`message`, `time`, `flag`) VALUES ('".$message."','".$time."',1)";
	//echo $sql;
	mysql_query($sql, $con);
	//mysql_error();
	$r->sendSms("hello",$_REQUEST['cid']);



}

mysql_close($con);




?>