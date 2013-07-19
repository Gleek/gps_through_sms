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
	$dmt="Current date is ".$d." , month ".$m." & year ".$y.". Here's a random number : ".rand(100,1000);
	$status = sendFullonSMS ( '9968371143' , '16537' , $sender  , $dmt);
	echo "<pre>".print_r($status)."</pre>";

	if($status['result']==1){
		$result=mysql_query("SELECT id from inbound_msgs ORDER BY entry_time DESC LIMIT 1", $con);
		$row = mysql_fetch_array($result);
		$sql="UPDATE `inbound_msgs` SET `flag`= 2 WHERE `id` = ".$row['id'];
		mysql_query($sql, $con);
		echo "trying to put 2";
	}
	//mysql_error();


}


mysql_close($con);




?>