<?php

if (!defined('LOG4PHP_DIR')) define('LOG4PHP_DIR', dirname(__FILE__));
ini_set('display_errors',0);


class SaeLog {
    function SaeLog() 
	{
	}
    function log($message, $errLevel = null)
    {
        sae_debug($message);
    }
    
    function internalDebugging($value = null)
    {
	   if($value != null) {
		   $message = print_r($value,true);
		   sae_debug($message);
	   }
       
    }
    
   
    function debug($message)
    {
        sae_debug($message);
    }
    

    function error($message)
    {
        sae_debug($message);
    }
    

    function warn($message)
    {
        sae_debug($message);
    }
	function info($message)
    {
        sae_debug($message);
    }
	function fatal($message)
    {
        sae_debug($message);
    }
}
?>