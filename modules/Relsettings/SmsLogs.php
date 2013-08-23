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


$listview_header =array("id"=>"序号","sender"=>"发送人","receiver"=>"接收人","receiver_phone"=>"接收人手机","sendmsg"=>"短信内容","flag"=>"是否成功","sendtime"=>"发送时间");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));


$where = '';
$search_url = '';
$receiver = $_REQUEST['receiver'];
if(isset($receiver)){
	$where .=" and receiver like '%".$receiver."%'";
	$search_url .="&receiver=$receiver";
	$smarty->assign("receiver", $receiver);
}
$receiver_phone = $_REQUEST['receiver_phone'];
if(isset($receiver_phone)){
	$where .=" and receiver_phone like '%".$receiver_phone."%'";
	$search_url .="&receiver_phone=$receiver_phone";
	$smarty->assign("receiver_phone", $receiver_phone);
}
$flag = 'all';
if(isset($_REQUEST['flag'])){
	$flag = $_REQUEST['flag'];
}
if($flag == 'yes'){
	$where .=" and flag = 1 ";
}elseif($flag == 'no'){
	$where .=" and flag = 0 ";
}

$search_url .="&flag=$flag";
$smarty->assign("flag", $flag);

$flagarr = array("all"=>"全部","yes"=>"是","no"=>"否");
$smarty->assign("FLAGARR", $flagarr);
//changed by ligangze on 2013-08-23  --start
$query = "select * from ec_smslogs where userid = '".$current_user->id."' ";
//if(!is_admin($current_user))
//{
//	$query = "select * from ec_smslogs where userid = '".$current_user->id."' ";
//}
//else
//{
//	$query = "select * from ec_smslogs";
//}
//--end
$query .=$where;	
//var_dump($query);

$count_result = $adb->query( mkCountQuery( $query));
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

$query .=" order by sendtime desc "; 
$query.=" limit $limit_start_rec,$list_max_entries_per_page";

$result = $adb->getList($query);
$nun_rows = $adb->num_rows($result); 


if($nun_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		$id = $row['id'];
		foreach($listview_header as $col=>$list){
		   if($col =='flag'){
			   if($row['flag'] == 1){
				   $entries[] = "Yes";
			   }else{
				   $entries[] = "No";
			   }
			}elseif($col =='sendmsg'){
				 $entries[] = wordwrap($row[$col],10);
			}elseif($col =='id'){
				 $entries[] = $i;
			}elseif($col == 'sender'){
				$selectsql = "select user_name from ec_users where id=".$row['userid'];
				$user_row = $adb->getFirstLine($selectsql);
				$entries[] = $user_row['user_name'];
			}else{
				$entries[] = $row[$col];
			}
		}
		$listview_entries[$id]=$entries;
		$i++;
	}
}

$smarty->assign("LISTENTITY", $listview_entries);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));

$record_string= $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","SmsUser",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);

$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
//$smarty->display("Relsettings/SmsLogs.tpl");
?>
