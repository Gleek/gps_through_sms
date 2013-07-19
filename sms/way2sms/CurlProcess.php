<?php
 
/*
 *
 *  Author Name     : Thangaraj Mariappan
 *  Email           : thaangaraj@gmail.com
 *  Created on      : 2012-07-14
 *  Updated on      : 2013-05-01
 *  Description     : Curl to access SMS server to send  SMS.
 *
 *  Copyright 2012-2103 Openshell. All rights reserved.
 */

    class CurlProcess{
        
        var $headers;
        var $user_agent;
        var $compression;
        var $cookie_file;
        var $proxy;
        var $proxy_port;
        
        public function CurlProcess($cookies=TRUE,$cookie='',$compression='gzip',$proxy='',$proxy_port='')
        {
            $this->headers[]    =   'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8';
            $this->headers[]    =   'Connection: Keep-Alive';
            $this->headers[]    =   'Content-type: application/x-www-form-urlencoded;charset=UTF-8';
            $this->headers[]    =   'Accept-Language: en-us,en;q=0.5';
            $this->headers[]    =   'Accept-Encoding: gzip,deflate';
            $this->headers[]    =   'Keep-Alive: 300';
            $this->headers[]    =   'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7';
            $this->user_agent   =   'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:18.0) Gecko/20100101 Firefox/18.0';
            $this->compression  =   $compression;
            $this->proxy        =   $proxy;
            $this->proxy_port   =   $proxy_port;
            $this->cookies      =   $cookies;
            if ($this->cookies == TRUE)
                $this->cookie_file =    tempnam('/tmp', 'OsSMS');
        }
        
        public function __destruct()
        {
            $this->end();
        }
        
        private function end(){
            if(file_exists($this->cookie_file))
                unlink($this->cookie_file);
        }
                
        public function get($url, $cookieData="")
        {
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($process, CURLOPT_HEADER, 0);
            curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
                        
            if ($this->cookies == TRUE) {
                if(empty($cookieData)){
                    curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
                    curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
                } else 
      					curl_setopt($process, CURLOPT_COOKIE,$cookieData);
            }
            
            curl_setopt($process,CURLOPT_ENCODING , $this->compression);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
            
            if(!empty($this->proxy)){
              curl_setopt($process, CURLOPT_PROXY, $this->proxy);
              curl_setopt($process, CURLOPT_PROXYTYPE, 'HTTP');
              curl_setopt($process, CURLOPT_PROXYPORT, $this->proxy_port);
            }
            
            curl_setopt($process, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($process, CURLOPT_FOLLOWLOCATION, 1);
            $return = curl_exec($process);
            curl_close($process);
            return $return;
        }
        
        public function post($url,$data,$referer=FALSE, $cookieData="")
        {
            $process = curl_init($url);
            curl_setopt($process, CURLOPT_HTTPHEADER, $this->headers);
            curl_setopt($process, CURLOPT_HEADER, 1);
            curl_setopt($process, CURLOPT_USERAGENT, $this->user_agent);
            
            if ($this->cookies == TRUE) {
                if(empty($cookieData)){
                    curl_setopt($process, CURLOPT_COOKIEFILE, $this->cookie_file);
                    curl_setopt($process, CURLOPT_COOKIEJAR, $this->cookie_file);
                } else {
          					curl_setopt($process, CURLOPT_COOKIE, $cookieData);
					      }
            }
            
            if(!empty($this->proxy)){
              curl_setopt($process, CURLOPT_PROXY, $this->proxy);
              curl_setopt($process, CURLOPT_PROXYTYPE, 'HTTP');
              curl_setopt($process, CURLOPT_PROXYPORT, $this->proxy_port);
            }
            
            curl_setopt($process, CURLOPT_ENCODING , $this->compression);
            curl_setopt($process, CURLOPT_TIMEOUT, 30);
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
