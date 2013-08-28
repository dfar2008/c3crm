<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('modules/Maillists/Maillists.php');
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/Maillists/ModuleConfig.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');
require_once('modules/Fenzu/Fenzu.php');
global $app_strings,$mod_strings,$list_max_entries_per_page;
global $adb;

$log = LoggerManager::getLogger('maillist_list');

global $currentModule,$image_path,$theme;

$focus = new Maillists();
$smarty = new CRMSmarty();

if($_REQUEST['parenttab'] != '')
{
	$category = $_REQUEST['parenttab'];
}
else
{ 
	$category = getParentTab();
}
$nowdatetime = date("Y-m-d H:i:s");

//<<<<cutomview>>>>>>>
$oFenzu = new Fenzu("Maillists");
$viewid =$_REQUEST['viewname'];
$customviewcombo_html = $oFenzu->getFenzuCombo($viewid); 
//$viewnamedesc = $oFenzu->getCustomViewByCvid($viewid);
//<<<<<customview>>>>>

global $current_user;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("CUSTOMVIEW_OPTION",$customviewcombo_html);
$smarty->assign("VIEWID", $viewid);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Qunfa');
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("CATEGORY",$category);


//生成事件id
$sjid = $adb->getUniqueID("ec_crmentity");
$smarty->assign("sjid",$sjid);

$res = $adb->query("select * from ec_systems where smownerid='".$current_user->id."'");
$from_name = $adb->query_result($res,0,'from_name');
$from_email = $adb->query_result($res,0,'from_email');
$interval = $adb->query_result($res,0,'interval');
$smarty->assign("from_name",$from_name);
$smarty->assign("from_email",$from_email);
$smarty->assign("interval",$interval);

if(isset($_REQUEST['idstring']) && $_REQUEST['idstring'] !=''){
	$idstring = $_REQUEST['idstring'];
	$modulename = $_REQUEST['modulename'];
	$receiveaccountinfo = getAccountMailInfo($idstring,$modulename);
}

if(isset($_REQUEST['useridstr']) && $_REQUEST['useridstr'] !=''){
	$useridstr = $_REQUEST['useridstr'];
	$receiveaccountinfo = getUserMailInfo($useridstr);
}

$smarty->assign("receiveaccountinfo",$receiveaccountinfo);

//Retreive the List View Table Header
if($viewid !='')
$url_string .="&viewname=".$viewid;
$smarty->assign("ISADMIN",$current_user->is_admin);

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Maillists/ListViewEntries.tpl");
else
	$smarty->display("Maillists/ListView.tpl");
	
function getAccountMailInfo($idstring,$modulename){
	global $adb;
	if (strpos($idstring, ";")) {
		$idstring = substr($idstring,0,-1);
		$id_arr = explode(";",$idstring);
		$id_str = implode(",",$id_arr);
	}else{
		$id_str = $idstring;
	}
	if($modulename =='Accounts'){
		$query = "select membername,email from ec_account where accountid in ($id_str) and deleted=0 ";
	}
	if($modulename =='Contacts'){
		$query = "select contactname as membername,contactemail as email from ec_contacts where contactsid in ($id_str) and deleted=0 ";
	}
	$rows = $adb->getList($query);
	$return = '';
	foreach($rows as $row){
		if($row['email'] !=''){
			$return .= $row['email']."(".$row['membername'].")\n";
		}
	}
	return $return;
}
function getUserMailInfo($useridstr){
	global $adb;
	$useridstr = substr($useridstr,0,-1);
	$id_arr = explode(";",$useridstr);
	$id_str = implode(",",$id_arr);
	
	$query = "select user_name,last_name,phone_mobile,email1,department from ec_users where id in ($id_str) and deleted=0 ";
	$rows = $adb->getList($query);
	$return = '';
	foreach($rows as $row){
		if($row['email1'] !=''){
			if($row['department'] =='weibo' && $row['last_name'] ==''){
				$return .= $row['email1']."(".$row['user_name'].")\n";
			}else{
				$return .= $row['email1']."(".$row['last_name'].")\n";
			}
		}
	}
	return $return;
}

	
?>
