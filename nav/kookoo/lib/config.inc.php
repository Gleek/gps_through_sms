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
  echo "Failed to connect to MySQL: " . mysql_connect_error();
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

define("TB_COUNTRY", "country");
define("MYSQL_SERVER","engineerinme.com");
define("MYSQL_USER","root");
define("MYSQL_PASS","kgggdkp2692");
define("MYSQL_DB","peerhack");
define("RDBMS","MYSQL");




define("TB_ADMINEM","tbl_adminemail");
define("TB_ADMIN","tbl_admin");
define("TB_PAGES","tbl_pages");
define("TB_RIGHT","tbl_copyright");
define("TB_IMGB","tbl_imgbaner");
define("TB_MAIL","tbl_mail");
define("TB_HOME","tbl_home");
define("TB_PAGES","tbl_pages");




define("WEBSITE_NAME","peerhack.herokuapp.com");


require("database.inc");

$dbh = new cDatabases();
$dbh->Set(RDBMS);
$dbh->Connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASS,MYSQL_DB);




define("ENABLE_URL_REWRIING",true) ;         // check if URL Rewiting enable
define("DEFAULT_POST_NAME","fld_id");            // this is default name of post/get name
//include_once("url_rewrite.php");

?>


