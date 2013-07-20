<?php

//error_reporting(E_ALL  & ~E_NOTICE & ~E_DEPRECATED);
function nav ($p1,$p2,$r)
{
$source=$p1;
$destination=$p2;
$source=urlencode ( $source );
$destination=urlencode ( $destination );
$url="http://maps.googleapis.com/maps/api/directions/json?origin=".$source."&destination=".$destination."&sensor=false";

$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$json = curl_exec($ch);
curl_close($ch);



$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

$r->addPlayText("Next five Turns are .");
$omega="";
    $i =1 ;
foreach ($jsonIterator as $key => $val)
{
    if(!is_array($val))
    {
        if($key == "status")
        if($val !='OK'){
            $omega = $omega.$val ;
            die();}
    }
    if(!is_array($val)){
        if ($key ==  "html_instructions")
            {
            if ($i == 5 )
                break ;
            else
                $i =$i + 1 ;
                $val =str_replace("\n","",$val);
                $val =str_replace("<b>","",$val);
                $val =str_replace("</div>","",$val);
                $val =str_replace('<div style="font-size:0.9em">',"",$val);
                $val =str_replace("</b>","",$val);
                $val =str_replace("&nbsp;","",$val);
                $r->addPlayText($val);
            }
        }
}
}




$username = "thinkdif";
$password = "kgggdkp1992";
$hostname = "67.23.226.179";

$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");

$selected = mysql_select_db("thinkdif_peerhack",$dbhandle);
session_start();
require "response.php";
$r = new Response("start"); // response handler
$cd = new CollectDtmf();
$cd->setTermChar("#");
$cd->setTimeOut("25000");


if($_REQUEST['event']=="NewCall" ||  $_SESSION['error']==1) // Receiving New Call
{
    $num =$_REQUEST['cid'];
	$r->addPlayText("Welcome to PeerHack Navigator .");
 	
    $query = "SELECT * FROM `inbound_msgs` WHERE `sender` = '91".$_REQUEST['cid']."' and flag =1  ";
    $result = mysql_query($query);
    $v= 1;
    $r->addPlayText("  Your last  query is  ") ;
    while ($row = mysql_fetch_assoc($result)) {
       
       $service = explode(" ",$row['message']);
       if ($service[0] == 'search' )
       {
             $r->addPlayText("Search for shops ");
             $searchq= " SELECT * FROM  `market` WHERE  `market` LIKE  '%".trim($service[1]," ")."%' AND  `keyword` LIKE  '%".trim($service[2]," ")."%' LIMIT 0, 3";
             //echo $searchq ;
             $r->addPlayText(".  Shops are " );
             $sresult = mysql_query($searchq);
             $i=1;
             $v =2 ;
             while ($srow = mysql_fetch_assoc($sresult))
                        {
                         
                          $val =str_replace("\t"," ",$srow['text']);
                          $val =str_replace("\n"," ",$val);
                          //echo "<pre>".$val."</pre>";
                          $r->addPlayText(".  ".$i." ".$val."");
                          $i=$i+1;
                        }


       }

      elseif ($service[0] == 'nav' )
       {
             $r->addPlayText("Navigation From ".$service[1]." To ".$service[2].".");
             
             nav($service[1],$service[2],$r);
             
       }
       else
       {
        $r->addPlayText( "Error in Query . Try again ." ) ;
       }
    
     $q="UPDATE `inbound_msgs` SET `flag`=2  WHERE `sender` = '91".$_REQUEST['cid']."'   " ;
     $v=2;
     $result = mysql_query($q);
     break;
    }
    if ($v == 1 )
    {
    $r->addPlayText( "None" ) ;
    
    }

 	
	$cd->setMaxDigits("12");
	$r->addCollectDtmf($cd);
	$r->send();

}
?>


