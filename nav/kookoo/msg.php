
<?php

include "lib/config.inc.php";
include('../../sms/fullonsms-api.php');
//phpinfo();
$con=$dbhandle;

<<<<<<< HEAD
function msgparse($message)
{

$source="";
    $destination="";
    $md=substr($message,0,3);
    //echo $md;
    if($md=="nav")
    {
        
        $main=preg_split("/(from:|to:)\s*/", $message);
        $source=urlencode($main[1]);
        $destination=urlencode($main[2]);
        $url="http://engineerinme.com/hammad/peerhack/replymsg.php?source=".$source."&destination=".$destination;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $text = curl_exec($ch);
        curl_close($ch);
        //echo $text;
    }
    else if($md =="loc")
    {
        $main=preg_split("/(in:|type:)\s*/", $message);
        $in=$main[1];
        $type=$main[2];

        $query="SELECT text FROM market WHERE market='$in' AND keyword ='$type' LIMIT 0,5";
        $result=mysql_query($query,$con);
        if (!$result) {
            $err  = 'Invalid query: ' . mysql_error() . "\n";
            $err .= 'Whole query: ' . $query;
            die($err);
}
        while($row = mysql_fetch_assoc($result))
        {
            $text .= $row['text']." ";
        }

    }
    else
    {
        $text="Error! Example: 'nav from:lakshmi nagar new delhi india to:lajpat nagar new delhi india' or 'loc in:lajpat type:fabric'";
    }
    echo $text;
    
        $parts = str_split($text, 149);
        /*echo "<pre>";
        print_r($parts);
        echo "</pre>";*/
        echo "<br>sending ".count($parts)." messages<br>";
    return $parts

    
}
=======
function check_service(){
	//$message= $_REQUEST['message'];
	$message="nav from: jamia millia islamia to: noida";
	if(substr($message,0,3)=="nav") return break_nav();
	else if(substr($message,0,6)=="search") return break_search();
	else die();
}

function break_nav(){
	//$message= $_REQUEST['message'];
 	$message="nav from: jamia millia islamia to: noida";
	$source="";
    $destination="";

    $main1=explode("from:",$message);
    $main2=explode("to:",$main1[1]);
    //print_r($main1);
    $source=urlencode($main2[0]);
    $destination=urlencode($main2[1]);


    $url="http://engineerinme.com/hammad/peerhack/replymsg.php?source=".$source."&destination=".$destination;
    //echo "url is ".$url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $text = curl_exec($ch);
    curl_close($ch);
    //echo "text is ".$text;
    return $text;
}

function break_search(){
>>>>>>> 3a731cf91164ac958454e2fec012ed9b3037417e

	//$message= $_REQUEST['message'];
 	$message="nav from: jamia millia islamia to: noida";
	$query="";

<<<<<<< HEAD
if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){
=======
    $main1=explode("search:",$message);
    $query= $main[1];
>>>>>>> 3a731cf91164ac958454e2fec012ed9b3037417e

    $text="sample";
    return $text;
}

function init(){
	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	$sql="INSERT INTO `inbound_msgs` (`sender`,`message`, `time`, `flag`) VALUES ('".$_REQUEST['cid']."','".$message."','".$time."',1)";
	//echo $sql;
	if(mysql_query($sql, $con)==true) send();
	else{
		echo "Error in init()";
		die();
	}
}

function break_text(){
	if(strlen($text)<=160) return array($text);
	$text_container = array();

	for ($i=0; $i < strlen($text) ;) {
		$j=strpos($text, '\n');
		$temp=substr($text, $i,$j-$i);

		if(strlen($temp)<=160){
			array_push($text_container, $temp);
			$i=$j+1;
		}else{
			array_push($text_container, substr($temp, $i, 160) );
			$i=$i + 160;
		}

	}// end of for loop

	return $text_container;
}// break_text ends

function send(){

	if(strlen($_REQUEST['cid'])==10) $sender= $_REQUEST['cid'];
	else if(strlen($_REQUEST['cid'])>10) $sender= substr($_REQUEST['cid'], -10);
<<<<<<< HEAD
	else echo "<br/>Error:Length of mobile no less than 10<br/>";
=======
	else {
		echo "<br/>Error:Length of mobile no less than 10<br/>";
		die();
	}

	$text_send=break_text();
	print_r($text_send);
>>>>>>> 3a731cf91164ac958454e2fec012ed9b3037417e

	$d=date ("d");
	$m=date ("m");
	$y=date ("Y");
<<<<<<< HEAD
	$dmt="Current date is ".$d." , month ".$m." & year ".$y.". Here's a random number : ".rand(100,1000);*/
	
	
	$parts=msgparse($message);
	foreach ($parts as $dmt)
    {
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
    }
	echo "outside";


}


mysql_close($con);


=======
	$dmt="Current date is ".$d." , month ".$m." & year ".$y.". Here's a random number : ".rand(100,1000);
	/*$status = sendFullonSMS ( '9968371143' , '16537' , $sender  , $dmt);

	if($status[0]['result']==1){
		$result=mysql_query("SELECT id from inbound_msgs ORDER BY entry_time DESC LIMIT 1", $con);
		$row = mysql_fetch_array($result);
		$sql="UPDATE `inbound_msgs` SET `flag`= 2 WHERE `id` = ".$row['id'];
		mysql_query($sql, $con);
	}*/
	echo "In send text is ".$text;
}


$text=check_service();
>>>>>>> 3a731cf91164ac958454e2fec012ed9b3037417e

if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){
	init();
}

<<<<<<< HEAD
?>


=======
?>
>>>>>>> 3a731cf91164ac958454e2fec012ed9b3037417e
