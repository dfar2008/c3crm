<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $list_max_entries_per_page;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$listview_header =array("numble"=>"序号","user_name"=>"用户名","user_ip"=>"用户IP","login_time"=>"登录时间","logout_time"=>"退出时间","status"=>"状态");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));


$where = '';
$userid = $_REQUEST['userid'];
$search_url = '';
if(!empty($userid)){
	$smarty->assign("userid", $userid);
	$search_url .="&userid=$userid";
}else{
	die("UserID is empty!");	
}
$selectsql = "select user_name from ec_users where id=$userid";
$row = $adb->getFirstLine($selectsql);
if(!empty($row)){
	$user_name = $row['user_name'];
}
$list_query = "Select * from ec_loginhistory where user_name='".$user_name."'";

$count_result = $adb->query(mkCountQuery($list_query));
$noofrows = $adb->query_result($count_result,0,"count");

$start = $_REQUEST['start'];
if($start ==''){
	$start = 1;
}
$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);

$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val'];

$_SESSION['nav_start']=$start_rec;
$_SESSION['nav_end']=$end_rec;

if ($start_rec ==0)
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;

$list_query .=" order by login_time DESC"; 
$list_query .=" limit $limit_start_rec,$list_max_entries_per_page";

$result = $adb->getList($list_query);
$num_rows = $adb->num_rows($result); 
$entries_list = array();
if($num_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		foreach($listview_header as $col=>$list){
			if($col == 'numble'){
				$entries[] = $i;
			}else{
				$entries[] = $row[$col];
			}
		}
		$entries_list[]=$entries;
		$i++;
	}
}
$smarty->assign("LISTENTITY", $entries_list);

$record_string= $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","SmsUserLogs",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);
$smarty->assign("SETTYPE", "SmsUserLogs");//added by ligangze
$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Settings/SmsUserLogs.tpl");
?>
