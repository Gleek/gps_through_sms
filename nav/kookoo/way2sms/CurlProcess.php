<?php
 
/*
 *
 *  Author Name     : Thangaraj Mariappan
 *  Email           : thaangaraj@gmail.com
 *  Created on      : 2012-07-14
 *  Description     : Curl to access SMS server to send  SMS.
 *
 *  Copyright 2012 Openshell. All rights reserved.
 */

    class CurlProcess{
        
        var $headers;
        var $user_agent;
        var $compression;
        var $cookie_file;
        var $proxy;
        
        public function CurlProcess($cookies=TRUE,$cookie='',$compression='gzip',$proxy='')
        {
            $this->headers[]    =  'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
            $this->headers[]    =  'Connection: Keep-Alive';
            $this->headers[]    =  'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
            $this->headers[]    =  'Accept-Language: en-us,en;q=0.5';
            $this->headers[]    =  'Accept-Encoding gzip,deflate';
            $this->headers[]    =  'Keep-Alive: 300';
            $this->headers[]    =  'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
            $this->user_agent   =   'iPhone 4.0';
            $this->compression  =   $compression;
            $this->proxy        =   $proxy;
            $this->cookies      =   $cookies;
            
            if ($this->cookies == TRUE)
                $this->cookie_file = tempnam('/tmp','cookie'.time().'.txt');
        }
        
        public function __destruct()
        {
            $this->end();
        }
        
        private function end(){
            if(file_exists($this->cookie_file))
                unlink($this->cookie_file);
        }
        
        public function setProxy($proxy)
        {
            $this->proxy = $proxy;
        }
        
        public function get($url)
        {
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($process, CURLOPT_HEADER, 0);
            curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
            
            if ($this->cookies == TRUE) {
                curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
                curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
            }
            
            curl_setopt($process,CURLOPT_ENCODING , $this->compression);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_PROXY, $this->proxy);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
            $return = curl_exec($process);
            curl_close($process);
            return $return;
        }
        
        public function post($url,$data,$referer=FALSE)
        {
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($process, CURLOPT_HEADER, 1);
            curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
            
            if ($this->cookies == TRUE) {
                curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
                curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
            }
            
            curl_setopt($process, CURLOPT_ENCODING , $this->compression);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            curl_setopt($process, CURLOPT_PROXY, $this->proxy);
            curl_setopt($process, CURLOPT_POSTFIELDS, $data);
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
            
            if($referer)
                curl_setopt($process, CURLOPT_REFERER, $referer);
            
            curl_setopt($process, CURLOPT_POST, 1);
            curl_setopt($process, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2); 
            $return = curl_exec($process);
            curl_close($process);
            return $return;
        }
    }
?>
