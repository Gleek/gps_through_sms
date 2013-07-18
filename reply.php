<?php
//$source="Lakshmi+Nagar+New+Delhi+India";
//$destination="Chandni+chowk+delhi+india";
$source=$_GET['source'];
$destination=$_GET['destination'];
$source=urlencode ( $source );
$destination=urlencode ( $destination );
//echo $source." ".$destination;
$url="http://maps.googleapis.com/maps/api/directions/json?origin=".$source."&destination=".$destination."&sensor=false";

//echo $url;
$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$json = curl_exec($ch);
echo "---".$json;
curl_close($ch);
//echo "---".$json;

	
//$json=file_get_contents($url);
echo $json;

$jsonIterator = new RecursiveIteratorIterator(
    new RecursiveArrayIterator(json_decode($json, TRUE)),
    RecursiveIteratorIterator::SELF_FIRST);

foreach ($jsonIterator as $key => $val) {
    /*if(is_array($val)) {
        echo "$key:\n";
    } else {
        echo "$key => $val\n";
    }*/if(!is_array($val))
	if ($key == "html_instructions")
		echo $val."<br>";
}

