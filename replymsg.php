<?php
$source=$_GET['source'];
$destination=$_GET['destination'];
$source=urlencode ( $source );
$destination=urlencode ( $destination );
$url="http://maps.googleapis.com/maps/api/directions/json?origin=".$source."&destination=".$destination."&sensor=false";
//echo $url ;
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


$omega="";
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
                $val =str_replace("\n","",$val);
                $val =str_replace("<b>","",$val);
                $val =str_replace("</b>","",$val);
                $val=str_replace('<div style="font-size:0.9em">',"<br>",$val);
                $val=str_replace('</div>',"<br>",$val);
                
	        	$omega = $omega.$val ;
            }
        }
}


echo $omega;

?>




