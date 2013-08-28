<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('modules/Qunfas/Qunfas.php');

require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/Qunfas/ModuleConfig.php');
require_once('include/DatabaseUtil.php');
require_once('modules/Fenzu/Fenzu.php');

global $app_strings,$mod_strings,$list_max_entries_per_page;

$log = LoggerManager::getLogger('qunfa_list');

global $currentModule,$image_path,$theme;
$focus = new Qunfas();
$smarty = new CRMSmarty();

if($_REQUEST['parenttab'] != '')
{
	$category = $_REQUEST['parenttab'];
}
else
{
	$category = getParentTab();
}


//<<<<cutomview>>>>>>>
$oFenzu = new Fenzu("Qunfas");
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
$qunfatmps = $focus->getQunfatmpsInfo();

$smarty->assign("QUNFATMPS",$qunfatmps);

if(isset($_REQUEST['idstring']) && $_REQUEST['idstring'] !=''){
	$idstring = $_REQUEST['idstring'];
	$modulename = $_REQUEST['modulename'];
	$receiveaccountinfo = getAccountPhoneInfo($idstring,$modulename);
}

if(isset($_REQUEST['useridstr']) && $_REQUEST['useridstr'] !=''){
	$useridstr = $_REQUEST['useridstr'];
	$receiveaccountinfo = getUserPhoneInfo($useridstr);
}
$smarty->assign("receiveaccountinfo",$receiveaccountinfo);


//Retreive the List View Table Header
if($viewid !='')
$url_string .="&viewname=".$viewid;
$smarty->assign("ISADMIN",$current_user->is_admin);

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Qunfas/ListViewEntries.tpl");
else
	$smarty->display("Qunfas/ListView.tpl");
	
function getAccountPhoneInfo($idstring,$modulename){
	global $adb;
	if (strpos($idstring, ";")) {
		$idstring = substr($idstring,0,-1);
		$id_arr = explode(";",$idstring);
		$id_str = implode(",",$id_arr);
	}else{
		$id_str = $idstring;
	}
	if($modulename =='Accounts'){
		$query = "select membername,phone from ec_account where accountid in ($id_str) and deleted=0 ";
	}
	if($modulename =='Contacts'){
		$query = "select contactname as membername,contactmobile as phone from ec_contacts where contactsid in ($id_str) and deleted=0 ";
	}
	$rows = $adb->getList($query);
	$return = '';
	foreach($rows as $row){
		if($row['phone'] !=''){
			$return .= $row['phone']."(".$row['membername'].")\n";
		}
	}
	return $return;
}

function getUserPhoneInfo($useridstr){
	global $adb;
	$useridstr = substr($useridstr,0,-1);
	$id_arr = explode(";",$useridstr);
	$id_str = implode(",",$id_arr);
	
	$query = "select user_name,last_name,phone_mobile,email1,department from ec_users where id in ($id_str) and deleted=0 ";
	$rows = $adb->getList($query);
	$return = '';
	foreach($rows as $row){
		if($row['phone_mobile'] !=''){
			if($row['department'] =='weibo' && $row['last_name'] ==''){
				$return .= $row['phone_mobile']."(".$row['user_name'].")\n";
			}else{
				$return .= $row['phone_mobile']."(".$row['last_name'].")\n";
			}
		}
	}
	return $return;
}

	
?>
