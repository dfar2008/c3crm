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

$listview_header =array("user_name"=>"帐号","last_name"=>"姓名","tools"=>"工具");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));
$where = '';
$search_url = '';
$user_name = $_REQUEST['user_name'];
if(!empty($user_name)){
	$where .=" and ec_users.user_name like '%".$user_name."%'";
	$search_url .="&user_name=$user_name";
	$smarty->assign("user_name", $user_name);
}
$last_name = $_REQUEST['last_name'];
if(!empty($last_name)){
	$where .=" and ec_users.last_name like '%".$last_name."%'";
	$search_url .="&last_name=$last_name";
	$smarty->assign("last_name", $last_name);
}

$query = "select * from ec_users where deleted=0 ";
$query .=$where;

$count_result = $adb->query( mkCountQuery( $query));
$noofrows = $adb->query_result($count_result,0,"count");

$start = $_REQUEST['start'];
if($start =='' || $start >= $noofrows){
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

$query .=" order by id desc "; 
$query.=" limit $limit_start_rec,$list_max_entries_per_page";

$result = $adb->getList($query);
$num_rows = $adb->num_rows($result); 
if($num_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		$id = $row['id'];
		foreach($listview_header as $col=>$list){
		   if($col =='tools'){
				$entries[] = "<a href=\"index.php?module=Settings&action=SmsUserEdit&userid=".$id."\"> &nbsp;充值 </a>";
			}else{
				$entries[] = $row[$col];
			}
		}
		$listview_entries[$id]=$entries;
		$i++;
	}
}
$smarty->assign("LISTENTITY", $listview_entries);

$record_string= $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","SearchSmsUser",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Settings/SearchSmsUser.tpl");
?>
