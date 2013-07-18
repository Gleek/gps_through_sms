<?php
#####################################################################
#																	#
#				Script : Configuraion file							#
#																	#
#				 													#
#####################################################################
#set_time_limit(0);
error_reporting(E_ALL  & ~E_NOTICE & ~E_DEPRECATED);

$con=mysql_connect("engineerinme.com","root","kgggdkp2692","peerhack");
if (mysql_connect_errno())
  {
  echo "Failed to connect to MySQL: ";
  die();
  }


// For Live


/*************************************************************************/
//if ssl enable
//define ("SSL_ENABLE", false);
/*
if($_SERVER['SERVER_PORT'] == '80'  &&  SSL_ENABLE == true ) {
   header("location: https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}*/
/**************************************************************************************************/


//define tables

?>


