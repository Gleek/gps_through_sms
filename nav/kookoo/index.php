<?php

session_start();

include "kookoophp/response.php";
include "lib/config.inc.php";
include "array.php";


$r = new Response("start"); // response handler
$cd = new CollectDtmf();
$cd->setTermChar("#");
$cd->setTimeOut("25000");
/*
$res=$dbh->Query("Select * from user WHERE aadhar='12345' ");

 	 if(mysql_num_rows($res)>=1){ echo "yesy";
 	 		//$r->addPlayText("Welcome valid aadhar user");
 	 }else{ echo "no";	
 	 		//$r->addPlayText("Sorry, The aadhar no provided is not present in the database");
 	 		//$r->addPlayText("Please register at our website first. Ending call");
 	 		//$r->addHangup();
			//$r->send();

 	 }

*/
if($_REQUEST['event']=="NewCall" || $_SESSION['error']==1) // Receiving New Call
{
	$r->addPlayText("Welcome to 12th plan Agricultural app");
	
	$cd->setMaxDigits("12");
	$cd->addPlayText("Please enter your 12 digit Aadhar number to continue");
	$r->addCollectDtmf($cd);
	$_SESSION['state'] = "gotid";
	$r->send();

}else
if ($_REQUEST['event']=="GotDTMF" && $_SESSION['state'] == "gotid") // Receiving aadhar id
{
	$aadhar_num = $_REQUEST['data'];
  if($aadhar_num!='')
  {

 	$res=$dbh->Query("Select * from user WHERE aadhar='$aadhar_num' ");

 	 if(mysql_num_rows($res)>=1){ 
 	 	$row= $dbh->FetchRow($res);
 	 		$r->addPlayText("Welcome ".$row['name']);
 	 		$_SESSION['error']=0;
 	 		$_SESSION['state']="menu_show";
 	 		$_SESSION['id']=0;
 	 		$_SESSION['aadhar']= $aadhar_num;
 	 		$_SESSION['district'] = $row['district'];
 	 		$r->send();

 	 }else{ 	
 	 		$r->addPlayText("Sorry, The aadhar no provided is not present in the database");
 	 		$r->addPlayText("Please register at our website first or try again");
 	 		$_SESSION['error']=1;
			$r->send();
 	 }
 	 
  }else $_SESSION['error']=1;

}
else
if ($_SESSION['id']>=0 && $_SESSION['state']=="menu_show") // Playing Menu Choices
{
		if(count($arr[$_SESSION['id']]['child'])>=1)
	{
			foreach ($arr[$_SESSION['id']]['child'] as $node)
		  { 
		  	$r->addPlayText($arr[$node]['name']);
		  		  	
		  }
		  $cd->setMaxDigits("1");
		  $cd->setTimeOut("7000");

		  	$r->addCollectDtmf($cd);  
		  $_SESSION['state']="menu_listen";
	}else
	{	if($_SESSION['var']!=10)$_SESSION['var']= $arr[$_SESSION['id']]['var'];
		include "scripts/".$arr[$_SESSION['id']]['script'];
		

	}

  
  $r->send();



}else


if ($_SESSION['id']>=0 && $_SESSION['state']=="menu_listen")  // Analysing Menu Choices
{
	$id=$_REQUEST['data'];
	if($id!='')
	{
		if($id==0 && $_SESSION['id']==0) $r->addHangup();
		else if($id==0) $_SESSION['id']=$arr[ $_SESSION['id'] ]['pid'];
		else if($id <limit && $id >=0 ) $_SESSION['id']= $arr[$_SESSION['id']]['child'][$id-1];		
		else $r->addPlayText("Sorry, Invalid choice. PLease try again");
	}

	$_SESSION['state']= "menu_show";
	$r->send();
}






?>
