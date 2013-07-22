<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $list_max_entries_per_page;

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$listview_header =array("user_name"=>"帐号","is_admin"=>"管理员","last_name"=>"姓名","phone_mobile"=>"手机","email1"=>"Email","register_time"=>"创建时间","status"=>"状态","tools"=>"工具");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));

$search_url = '';
$where = '';

//排序
$ordercol = array(
	"user_name"=>"ec_users.user_name",
	"last_name"=>"ec_users.last_name",
	"phone_mobile"=>"ec_users.phone_mobile",
	"email1"=>"ec_users.email1",
	"register_time"=>"ec_users.register_time",
);
$orderkeycol = array_keys($ordercol);
$order_by = $_REQUEST['order_by'];
$sorder = $_REQUEST['sorder'];
if(empty($order_by)){
    $order_by = 'register_time';
}
if(empty($sorder)){
    $sorder = 'desc';
}
$order_url ="&order_by=".$order_by."&sorder=".$sorder;

$ordersql = $ordercol[$order_by];
//$order_url = "&order_by={$order_by}&sorder={$sorder}";



$user_name = $_REQUEST['user_name'];
if(!empty($user_name)){
	$where .=" and (ec_users.user_name like '%".$user_name."%' or ec_users.last_name like '%".$user_name."%' or ec_users.phone_mobile like '%".$user_name."%' or ec_users.email1 like '%".$user_name."%') ";
	$search_url .="&user_name=$user_name";
	$smarty->assign("user_name", $user_name);
}

$today = date("Y-m-d");
$lastweek = date("Y-m-d",strtotime("-1 week"));
$nextweek = date("Y-m-d",strtotime("1 week"));

$todaytime = date("Y-m-d H:i:s");
$lastweektime = date("Y-m-d H:i:s",strtotime("-1 week"));
$nextweektime = date("Y-m-d H:i:s",strtotime("1 week"));

$query = "select ec_users.id,ec_users.user_name,ec_users.last_name,ec_users.phone_mobile,
			ec_users.email1,ec_users.register_time,is_admin	,status	
			from ec_users  
			where ec_users.deleted =0 ";
$query .=$where;			

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

$query .=" order by {$ordersql} {$sorder} "; 
$query.=" limit $limit_start_rec,$list_max_entries_per_page";

$result = $adb->getList($query);
$nun_rows = $adb->num_rows($result); 

$stop = 0;
$currentdate = date("Y-m-d");

if($nun_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		$id = $row['id'];
        $status = $row['status'];
		foreach($listview_header as $col=>$list){
		   if($col =='is_admin'){
			   if($row[$col] != "on") {
					$entries[] = "No";
			   } else {
				   $entries[] = "Yes";
			   }
		   } elseif($col =='tools'){
               if($status=="Active"){
                   $on_off =" &nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"onoffUser(".$id.",'off');\" title=\"禁用用户\"><font color=blue>禁用</font></a>&nbsp;&nbsp;";
               }else{
                   $on_off = "&nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"onoffUser(".$id.",'on');\" title=\"启用用户\"><font color=blue>启用</font></a>&nbsp;&nbsp;";
               }
			    if($_SESSION['authenticated_user_id'] != $id) {
					$entries[] = "<a href=\"index.php?module=Settings&action=EditMoreInfo&userid=".$id."\" title=\"编辑\"><font color=red>编辑</font></a>&nbsp;&nbsp;|".$on_off."|&nbsp;&nbsp;<a href=\"javascript:;\" onclick=\"confirmDel(".$id.");\" title=\" 删除用户\"><font color=blue>删除</font></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href=\"index.php?module=Settings&action=SmsUserLogs&userid=".$id."\" title=\"日志\">日志</a>";
				} else {
					$entries[] = "&nbsp;";
				}
				
			}elseif($col=="status"){
                if($row[$col]=="Active")
                    $entries[] = "启用";
                else 
                    $entries[] = "禁用";
            }else{
				$entries[] = $row[$col];
			}
		}
		$listview_entries[$id]=$entries;
		$i++;
	}
}

$smarty->assign("LISTENTITY", $listview_entries);

foreach($listview_header as $key=>$header){
	if(in_array($key,$orderkeycol)){
		$sorderimg = "";
		$newsorder = "asc";
		if($order_by == $key){
			if($sorder == 'asc'){
				$newsorder = "desc";
				$sorderimg = "<img border=0 src='themes/softed/images/arrow_up.gif'>";
			}else{
				$sorderimg = "<img border=0 src='themes/softed/images/arrow_down.gif'>";
			}
		}
		$orderhtml = '<a href="javascript:;"  class="listFormHeaderLinks" 
						onclick="getOrderBy(\'order_by='.$key.'&sorder='.$newsorder.'\');return false;">'.$header.$sorderimg.'</a>';
	}else{
		$orderhtml = $header;
	}
	$headerhtml .= "<td class='lvtCol' nowrap>{$orderhtml}</td>";
	
}
$smarty->assign("headerhtml", $headerhtml);

$smarty->assign("MOD", return_module_language($current_language,'Settings'));

$record_string= $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","SmsUser",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);
$smarty->assign("order_url", $order_url);

$relsethead = $app_strings['Settings'];
$smarty->assign("RELSETHEAD", $relsethead);
$smarty->assign("SETTYPE", "SmsUser");
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->display("Settings/SmsUser.tpl");
?>
