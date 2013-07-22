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


$listview_header =array("tc"=>"套餐","price"=>"价格(元/月)","num"=>"次数(次/月)","tools"=>"工具");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));

$search_url = '';
$where = '';

//排序
$ordercol = array(
	"tc"=>"ec_smstc.tc",
	"price"=>"ec_smstc.price",
	"num"=>"ec_smstc.num"
);
$orderkeycol = array_keys($ordercol);
$order_by = $_REQUEST['order_by'];
$sorder = $_REQUEST['sorder'];
if(empty($order_by)){
    $order_by = 'tc';
}
if(empty($sorder)){
    $sorder = 'desc';
}
$ordersql = $ordercol[$order_by];
//$order_url = "&order_by={$order_by}&sorder={$sorder}";

$today = date("Y-m-d");
$nextweek = date("Y-m-d",strtotime("1 week"));


$query = "select * from ec_smstc where 1";
	

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


if($nun_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		$id = $row['id'];
		foreach($listview_header as $col=>$list){
		   if($col =='tools'){
				$entries[] = "<a href=\"index.php?module=Settings&action=SmsTcManageEdit&record=".$id."\"> &nbsp;编辑 </a> | <a href=\"javascript:confirmdelete('index.php?module=Settings&action=DeleteSmsTcManage&record=".$id."')\"> &nbsp;删除</a>";
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
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","SmsTcManage",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);


$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->assign("SETTYPE","SmsTcManage");
$smarty->display("Settings/SmsTcManage.tpl");
?>
