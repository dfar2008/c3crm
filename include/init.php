<?php
if (__FILE__ == '')
{
    die('Fatal error code: 0');
}

require_once($root_directory.'include/waf.php');
require($root_directory.'config.php');


/* 对用户传入的变量进行转义操作。*/
if (!get_magic_quotes_gpc())
{
    if (!empty($_GET))
    {
        $_GET  = stripslashes_deep($_GET);
    }
    if (!empty($_POST))
    {
        $_POST = stripslashes_deep($_POST);
    }

    $_COOKIE   = stripslashes_deep($_COOKIE);
    $_REQUEST  = stripslashes_deep($_REQUEST);


}
header('Content-Type: text/html; charset=UTF-8');
global $entityDel;
global $display;
global $category;
global $currentModule;
require_once($root_directory.'include/utils/utils.php');
require_once($root_directory.'include/database/PearDatabase.php');
require_once($root_directory.'include/logging.php');
require_once($root_directory.'modules/Users/Users.php');
$log = & LoggerManager::getLogger('index');
$adb = & getSingleDBInstance();
$skipActions = array ("Save", "Delete", "Popup", "Ajax","ChangePassword","CreatePDF");
$theme = "softed";
$current_language = "zh_cn";
if(isset($_REQUEST['PHPSESSID']))
{
	session_id($_REQUEST['PHPSESSID']);
	//Setting the same session id to Forums as in CRM
    $sid=$_REQUEST['PHPSESSID'];
}
// Create or reestablish the current session
session_start();






/**
 * 递归方式的对变量中的特殊字符去除转义
 *
 * @access  public
 * @param   mix     $value
 *
 * @return  mix
 */
function stripslashes_deep($value)
{
    if (empty($value))
    {
        return $value;
    }
    else
    {
        return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
    }
}
?>