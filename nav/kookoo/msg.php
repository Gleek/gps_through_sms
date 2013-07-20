
<?php
function bug($e)
{
    echo "<pre>";
    print_r($e);
    echo "</pre>";
}

include "lib/config.inc.php";
include('../../sms/fullonsms-api.php');
//phpinfo();
$con=$dbhandle;


function msgparse($message,$con)
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
        $url="http://192.73.234.205/hammad/peerhack/replymsg.php?source=".$source."&destination=".$destination;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        $text = curl_exec($ch);
        curl_close($ch);
        
        $arr = array() ;
        $arr =explode ( " " , $text);
        $i =0 ;
        $ret =array();
        $count =0 ;
        while ( 1 )
        {
        if ($count > count($arr) )
                break;
            $str="";
            while (strlen($str) < 139 )
            {
                $str= $str." ".$arr[$count] ;
                $count =$count + 1  ;
            }$count =$count - 1 ;
            //bug($count . " ". count($arr));
            
            
            $ret[$i]=$str;$i=$i+1;
        }

          //$parts = str_split($text, 139);
          //bug($text);
          //bug( "<br>sending ".$i." messages<br>" );
         
    }
    else if($md =="loc")
    {
        $main=preg_split("/(in:|type:)\s*/", $message);
        $in=$main[1];
        $type=$main[2];

        //$query="SELECT text FROM market WHERE market='$in' AND keyword ='$type' LIMIT 0,5";
        //print_r($main);
        $query ="SELECT * FROM  `market` WHERE  `market` LIKE  '%".trim($main[1]," ")."%' AND  `keyword` LIKE  '%".trim($main[2]," ")."%' LIMIT 0 ,3";

        $result=mysql_query($query,$con);
        if (!$result) {
            $err  = 'Invalid query: ' . mysql_error() . "\n";
            $err .= 'Whole query: ' . $query;
            bug($err);
            die();
		}
		$ret = array();
		$i =0;
        while($row = mysql_fetch_assoc($result))
        {
            //print_r($row);
            $parts =str_split($row['text'],139);
            $ret[$i] =$parts[0];
            $text .= $row['text']." ";
            $i =$i+1;
        }

    }
    else
    {
        $text="Error! Example: 'nav from:lakshmi nagar new delhi india to:lajpat nagar new delhi india' or 'loc in:lajpat type:fabric'";
    }
    //echo $text;

  
    return $ret;


}

function check_service(){
	//$message= $_REQUEST['message'];
	$message="nav from: jamia millia islamia to: noida";
	if(substr($message,0,3)=="nav") return break_nav();
	else if(substr($message,0,6)=="search") return break_search();
	else die();
}

function break_text(){
	echo "In break_text : text is ".$text;
	if(strlen($text)<=140) return array($text);
	$text_container = array();

	for ($i=0; $i < strlen($text) ;) {
		$j=strpos($text, "<br>");
		$temp=substr($text, $i,$j-$i);

		if(strlen($temp)<=160){
			array_push($text_container, $temp);
			$i=$j+4;
		}else{
			array_push($text_container, substr($temp, $i, 160) );
			$i=$i + 140;
		}

	}// end of for loop

	return $text_container;
}// break_text ends
function init($con){
	$message=$_REQUEST['message'];
	$time=$_REQUEST['time'];
	$sql="INSERT INTO `inbound_msgs` (`sender`,`message`, `time`, `flag`) VALUES ('".$_REQUEST['cid']."','".$message."','".$time."',0)";
	//echo $sql;
	mysql_query($sql, $con);




	//function send

	if(strlen($_REQUEST['cid'])==10) $sender= $_REQUEST['cid'];
	else if(strlen($_REQUEST['cid'])>10) $sender= substr($_REQUEST['cid'], -10);
	else {
		echo "<br/>Error:Length of mobile no is less than 10<br/>";
		die();
	}

	//$text_send=break_text();
	//print_r($text_send);




	$parts=msgparse($message,$con);
	$status = sendFullonSMS ( '9968371143' , '16537' , $sender  , "Your request has been recorded please call this IVRS no . 011-30715373");

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





mysql_close($con);

echo "In send text is ".$text;
}


/*
$message="nav from:lajpat to:gurgaon";
bug(msgparse($message,$con));
*/


if(isset($_REQUEST['event']) && $_REQUEST['event']=="NewSms"){
	init($con);
}


?>





