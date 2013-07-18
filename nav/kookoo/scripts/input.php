<?php

if ( $_SESSION['var'] == 0 ) {

	$cd->setMaxDigits("10");
	$cd->setTimeOut("12000");
	$r->addPlayText("Please enter your land area in digits"); 
	$r->addCollectDtmf($cd);  
	$_SESSION['var']=10;
	

}else if($_SESSION['var']==10){

	$area = $_REQUEST['data'];
  if($area!='')
   {
 	$res=$dbh->Query("Select * from user_land WHERE aadhar='".$_SESSION['aadhar']."' ");

 	 if(mysql_num_rows($res)>=1){ 
 	 	$res= $dbh->Query("UPDATE `user_land` SET `area` = $area WHERE `aadhar` = '".$_SESSION['aadhar']."'");
 	 	
 	 }else{ 	
 	 		$res= $dbh->Query("INSERT INTO `user_land`(`aadhar` , `area`) VALUES('".$_SESSION['aadhar']."' , $area) ");
 	 	
 	 }

 	 $r->addPlayText("Thanks for using this service");
 	 $_SESSION['id']= $arr[$_SESSION['id']]['pid'];
 	 if($res) $r->addPlayText("Land area successfully submitted"); 
 	 	else { $r->addPlayText("Sorry, there seems to be some problem");   }
  }
}
else
if ( $_SESSION['var'] == 1 ) {

	$res=$dbh->Query("Select * from user_crop WHERE aadhar='".$_SESSION['aadhar']."'");

 	 if(mysql_num_rows($res)>=1){ 
 	 	$res= $dbh->Query("UPDATE `user_crop` SET `crop` = 1 WHERE `aadhar` = '".$_SESSION['aadhar']."'");
 	 	
 	 }else{ 	
 	 		$res= $dbh->Query("INSERT INTO `user_crop`(`aadhar` , `crop`) VALUES('".$_SESSION['aadhar']."' , 1) ");
 	 	
 	 }

 	 $r->addPlayText("Thanks for using this service");
 	 $_SESSION['id']= $arr[$_SESSION['id']]['pid'];
 	 if($res) $r->addPlayText("Crop grown successfully submitted"); 
 	 	else { $r->addPlayText("Sorry, there seems to be some problem"); }
	

}else if($_SESSION['var']==2){

	$res=$dbh->Query("Select * from user_crop WHERE aadhar='".$_SESSION['aadhar']."'");

 	 if(mysql_num_rows($res)>=1){ 
 	 	$res= $dbh->Query("UPDATE `user_crop` SET `crop` = 2 WHERE `aadhar` = '".$_SESSION['aadhar']."'");
 	 	
 	 }else{ 	
 	 		$res= $dbh->Query("INSERT INTO `user_crop`(`aadhar` , `crop`) VALUES('".$_SESSION['aadhar']."' , 2) ");
 	 	
 	 }

 	 $r->addPlayText("Thanks for using this service");
 	 $_SESSION['id']= $arr[$_SESSION['id']]['pid'];
 	 if($res) $r->addPlayText("Crop grown successfully submitted"); 
 	 	else { $r->addPlayText("Sorry, there seems to be some problem"); }
 	
}




?>