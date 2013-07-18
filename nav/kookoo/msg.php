<?php

$myFile = "testFile.txt";
$fh = fopen($myFile, 'w') or die("can't open file");


if(isset($_REQUEST['event']) && $_REQUEST=="NewSMS"){

	fwrite($fh, $_REQUEST['message']." from ".$_REQUEST['cid']);

}



?>