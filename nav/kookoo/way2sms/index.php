<?php

/*
 *
 *  Author Name     : Thangaraj Mariappan
 *  Email           : thaangaraj@gmail.com
 *  Created on      : 2012-07-14
 *  Updated on      : 2013-05-01
 *  Description     : Send SMS using SMS gateway
 *
 *  Copyright 2012-2013 Openshell. All rights reserved.
 */

    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    $username   =   "9968371143";
    $password   =   "hack123";
    $receiver   =   "9968371143";
    $output     =   "hi vipul";
    //$receiver   =   isset($_REQUEST['receiver'])?trim($_REQUEST['receiver']):"";
    //$output    =   isset($_REQUEST['message'])?trim($_REQUEST['message']):"";

    if (empty($username))
        echo "Enter Username";
    elseif (empty($password))
        echo "Enter Password";
    elseif (empty($receiver))
        echo "Enter Mobile No";
    elseif (empty($output))
        echo "Enter Message";
    else {
        require 'Way2Sms.php';
        $sms            =   new Way2Sms();
        $result         =   $sms->login($username, $password);
        if($result) {
            $smsStatus  =   $sms->send($receiver, $message);
            if($smsStatus)
                echo "Message sent successfully!!!";
            else
                echo "Unable to send message";
            $sms->logout();
        }
        else
            echo "Invalid Username or Password";
    }
?>
