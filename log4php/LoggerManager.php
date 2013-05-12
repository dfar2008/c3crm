<?php

if (!defined('LOG4PHP_DIR')) define('LOG4PHP_DIR', dirname(__FILE__));
require_once(LOG4PHP_DIR . '/NotLog.php');

/**
 * Use the LoggerManager to get Logger instances.
 *
 * @author VxR <vxr@vxr.it>
 * @version $Revision: 1.18 $
 * @package log4php
 * @see Logger
 * @todo create a configurator selector  
 */
class LoggerManager {
   
    /**
     * Returns the specified Logger.
     * 
     * @param string $name logger name
     * @param LoggerFactory $factory a {@link LoggerFactory} instance or null
     * @static
     * @return Logger
     */
    function &getLogger($name, $factory = null)
    {
        $log = new NotLog();
        return $log;
    }
    
   
}
?>