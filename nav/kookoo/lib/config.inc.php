<?php
#set_time_limit(0);
error_reporting(E_ALL  & ~E_NOTICE & ~E_DEPRECATED);

$username = "dbusrenamee";
$password = "dbpass";
$hostname = "hostname";

//connection to the database
$dbhandle = mysql_connect($hostname, $username, $password)
  or die("Unable to connect to MySQL");
echo "Connected to MySQL<br>";

$selected = mysql_select_db("thinkdif_peerhack",$dbhandle)
  or die("Could not select peerhack db");

?>
