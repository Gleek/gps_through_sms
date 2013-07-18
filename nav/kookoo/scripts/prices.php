<?php

$temp=0;

$res= $dbh->Query("SELECT * FROM `wheat` WHERE `district`='".$_SESSION['district']."' ORDER BY `date` DESC  ");
if(mysql_num_rows($res)>=1)
{ $row= $dbh->FetchRow($res);
$temp=1; $r->addPlayText("The latest price of wheat in your district is ".$row['modal_price']." rupees per quintal"); }

$res= $dbh->Query("SELECT * FROM `rice` WHERE `district`='".$_SESSION['district']."' ORDER BY `date` DESC  ");
if(mysql_num_rows($res)>=1)
{ $row= $dbh->FetchRow($res);
 $temp=1; $r->addPlayText("The latest price of rice in your district is ".$row['modal_price']." rupees per quintal"); }

$res= $dbh->Query("SELECT * FROM `sugar` WHERE `district`='".$_SESSION['district']."' ORDER BY `date` DESC ");
if(mysql_num_rows($res)>=1)
{ $row= $dbh->FetchRow($res);
 $temp=1; $r->addPlayText("The latest price of sugar in your district is ".$row['modal_price']." rupees per quintal"); }

if($temp==0) $r->addPlayText(" Sorry ,Current prices for commodities are not available for your district");
 $_SESSION['id']= $arr[$_SESSION['id']]['pid'];

?>