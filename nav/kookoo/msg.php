<?php

include "lib/config.inc.php";
include('../../sms/fullonsms-api.php');
//phpinfo();
$con=$dbhandle;

if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){


	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	$sql="INSERT INTO `inbound_msgs` (`sender`,`message`, `time`, `flag`) VALUES ('".$_REQUEST['cid']."','".$message."','".$time."',1)";
	//echo $sql;
	mysql_query($sql, $con);

	if(strlen($_REQUEST['cid'])==10) $sender= $_REQUEST['cid'];
	else if(strlen($_REQUEST['cid'])>10) $sender= substr($_REQUEST['cid'], -10);
	else echo "<br/>Error:Length of mobile no less than 10<br/>";

	$d=date ("d");
	$m=date ("m");
	$y=date ("Y");
	$t=time();
	$dmt="Current date is ".$d." , month ".$m." , year ".$y." & time ".$t;
	$status = sendFullonSMS ( '9968371143' , '16537' , $sender  , $dmt);
	echo "<pre>".print_r($status)."</pre>";
	//mysql_error();


}


mysql_close($con);




?>