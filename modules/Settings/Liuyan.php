<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
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


$listview_header =array("id"=>"ID","name"=>"姓名","tel"=>"电话","content"=>"留言","createdtime"=>"提交时间","reply"=>"是否回复","replytime"=>"回复时间");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));

$search_url = '';
$where = '';

//排序
$ordercol = array(
	"id"=>"ec_liuyan.id",
	"name"=>"ec_liuyan.name",
	"tel"=>"ec_liuyan.tel",
	"content"=>"ec_liuyan.content",
	"createdtime"=>"ec_liuyan.createdtime",
	"reply"=>"ec_liuyan.reply"
);
$orderkeycol = array_keys($ordercol);
$order_by = $_REQUEST['order_by'];
$sorder = $_REQUEST['sorder'];
if(empty($order_by)){
    $order_by = 'createdtime';
}
if(empty($sorder)){
    $sorder = 'desc';
}
$ordersql = $ordercol[$order_by];
//$order_url = "&order_by={$order_by}&sorder={$sorder}";

if(isset($_REQUEST['change']) && $_REQUEST['change'] == 1 && $_REQUEST['id'] != ''){
	$updatesql = "update ec_liuyan set reply=1,replytime='".date("Y-m-d H:i:s")."' where id='".$_REQUEST['id']."' ";
	$adb->query($updatesql);
}


$today = date("Y-m-d");
$lastweek = date("Y-m-d",strtotime("-1 week"));
$nextweek = date("Y-m-d",strtotime("1 week"));

$name = $_REQUEST['name'];
if(!empty($name)){
	$where .=" and ec_liuyan.name like '%".$name."%'";
	$search_url .="&name=$name";
	$smarty->assign("name", $name);
}
$tel = $_REQUEST['tel'];
if(!empty($tel)){
	$where .=" and ec_liuyan.tel like '%".$tel."%'";
	$search_url .="&tel=$tel";
	$smarty->assign("tel", $tel);
}
$content = $_REQUEST['content'];
if(!empty($content)){
	$where .=" and ec_liuyan.content like '%".$content."%'";
	$search_url .="&content=$content";
	$smarty->assign("content", $content);
}

$smarty->assign("search_notype", $search_url);



$query = "select * from ec_liuyan where 1 ";
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
		foreach($listview_header as $col=>$list){
		   if($col =='reply'){
			   if($row['reply'] == 1){
				   $entries[] = "已回复";
			   }else{
				   $entries[] = "<a href='javascript:changeReply(".$id.");'><font color=red>未回复</font></a>";
			   }
		   }elseif($col =='content'){
			   	$t = strlen($row[$col]);
				if($t >150){
					$entries[] =msubstr1($row[$col],0,50)."<a href=\"index.php?module=Settings&action=DetailLiuyan&id=".$id."\">详细</a>";
				}else{
					$entries[] = $row[$col];
				}
			     
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
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","Liuyan",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);


$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Settings/Liuyan.tpl");
?>
