<?php

$arr=array();
$arr[0]=array('pid' => 0, 'name' => 'Welcome to Main Menu', 'child' => array(1,2,3,4),'limit'=>4);

$arr[1]=array('pid' => 0, 'name' => 'Press 1 to hear weather forecast' , 'child' => array() , 'limit'=>0 , 'script' => 'weather.php');
$arr[2]=array('pid' => 0, 'name' => 'Press 2 to submit information' , 'child' => array(5,6,7) , 'limit'=>3);
$arr[3]=array('pid' => 0, 'name' => 'Press 3 to hear current commodity prices' , 'child' => array() , 'limit'=>0 , 'script' => 'prices.php');
$arr[4]=array('pid' => 0, 'name' => 'Press 0 to exit' , 'child' => array() , 'limit'=>0);

$arr[5]=array('pid' => 2, 'name' => 'Press 1 to submit size of cultivated land in squared meters' , 'child' => array() , 'limit'=>0 , 'script'=>'input.php', 'var' => 0);
$arr[6]=array('pid' => 2, 'name' => 'Press 2 to submit the name of crop being grown' , 'child' => array(8,9,10) , 'limit'=>3 );
$arr[7]=array('pid' => 2, 'name' => 'Press 0 to return to previous menu' , 'child' => array() , 'limit'=>0);

$arr[8]=array('pid' => 6, 'name' => 'Press 1 for RICE' , 'child' => array() , 'limit'=>0 , 'script'=>'input.php' , 'var' => 1);
$arr[9]=array('pid' => 6, 'name' => 'Press 2 for WHEAT' , 'child' => array() , 'limit'=>0 , 'script'=>'input.php' , 'var' => 2);
$arr[10]=array( 'pid' => 6, 'name' => 'Press 0 to return to previous menu' , 'child' => array() , 'limit'=>0);




























?>