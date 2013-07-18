<?php

/*
 *
 *  Author Name     : Thangaraj Mariappan
 *  Email           : thaangaraj@gmail.com
 *  Created on      : 2012-07-14
 *  Updated on	    : 2013-01-19
 *  Description     : Send SMS
 *
 *  Copyright 2012 Openshell. All rights reserved.
 */

    $username   =   "9968371143";
    $password   =   "hack123";
    $receiver   =   "9968371143";
    $message    =   "hello there";

    if (empty($username))
        echo "Enter Mobile No";
    elseif (empty($password))
        echo "Enter Password";
    else {
        require_once 'Way2Sms.php';
        $sms            =   new Way2Sms();
        $result         =   $sms->login($username, $password);
        if($result) {
            $smsStatus  =   $sms->send($receiver, $message);
            if($smsStatus)
                echo "Message sent successfully";
            else
                echo "Unable to send message";
            $sms->logout();
        }
        else
            echo "Invalid Mobile No or Password";
    }

?>
