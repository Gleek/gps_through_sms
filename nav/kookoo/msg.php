<?php

include "lib/config.inc.php";
include('../../sms/fullonsms-api.php');
//phpinfo();
$con=$dbhandle;

 function break_msg($message){
 	$message="nav from: jamia millia islamia to: noida";
	$source="";
    $destination="";
    if(substr($message,0,3)=="nav")
    {
        echo "entered";
        $main1=explode("from:",$message);
        $main2=explode("to:",$main1);
        //print_r($main1);
        $source=$main2[0];
        $destination=$main2[1];
    }

    echo "end of if";
    $url="http://engineerinme.com/hammad/peerhack/replymsg.php?source=".$source."&destination=".$destination;
    echo "url is ".$url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $text = curl_exec($ch);
    curl_close($ch);
    echo $text;
}

break_msg("abc");

function send(){

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
		echo "status is ".$status."<br/>";

		if($status[0]['result']==1){
			$result=mysql_query("SELECT id from inbound_msgs ORDER BY entry_time DESC LIMIT 1", $con);
			$row = mysql_fetch_array($result);
			$sql="UPDATE `inbound_msgs` SET `flag`= 2 WHERE `id` = ".$row['id'];
			mysql_query($sql, $con);
			echo "trying to put 2";
		}
		//mysql_error();

		echo "outside";


	}
}


//mysql_close($con);




?>
