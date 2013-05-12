<?php
/**
 * This is a rest entry point for rest version 2
 */
define('IN_CRMONE', true);
$root_directory = dirname(__FILE__)."/";
require($root_directory.'config.php');
require_once($root_directory.'include/utils/utils.php');
require_once($root_directory.'include/utils/CommonUtils.php');
require_once($root_directory.'include/database/PearDatabase.php');
require_once($root_directory.'include/logging.php');
require_once($root_directory.'modules/Users/Users.php');
require_once($root_directory.'service/utils/clean_incoming_data.php');
require_once($root_directory.'user_privileges/seqprefix_config.php');
global $log;
global $adb;
global $account_seqprefix;
$log = & LoggerManager::getLogger('rest');
$GLOBALS['log'] = $log;
$adb = & getSingleDBInstance();
//clean
clean_incoming_data();
ob_start();
require_once('service/core/SoapError.php');
require_once('service/core/SoapHelperWebService.php');
require_once('service/core/CrmoneRestUtils.php');
require_once('service/core/CrmoneRestService.php');
$service = new CrmoneRestService();
$service->serve();
?>
