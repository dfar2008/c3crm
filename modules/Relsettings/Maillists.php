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


$listview_header =array("maillistsid"=>"序号","maillistname"=>"编号","subject"=>"邮件主题","from_name"=>"发件人","from_email"=>"发件人邮箱","totalnum"=>"邮件总数（条）","successrate"=>"成功发送（条）","createdtime"=>"发送时间");//"mailcontent"=>"邮件内容","receiverinfo"=>"接收人及邮箱",
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));


$where = '';
$search_url = '';


//排序
$ordercol = array(
	"maillistname"=>"ec_maillists.maillistname",
	"subject"=>"ec_maillists.subject",
	"mailcontent"=>"ec_maillists.mailcontent",
	"receiverinfo"=>"ec_maillists.receiverinfo",
	"from_name"=>"ec_maillists.from_name",
	"from_email"=>"ec_maillists.from_email",
	"successrate"=>"ec_maillists.successrate",
	"totalnum"=>"ec_maillists.totalnum",
	"createdtime"=>"ec_maillists.createdtime"
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
$order_url ="&order_by=".$order_by."&sorder=".$sorder;

$ordersql = $ordercol[$order_by];


$subject = $_REQUEST['subject'];
if(!empty($subject)){
	$where .=" and subject like '%".$subject."%'";
	$search_url .="&subject=$subject";
	$smarty->assign("subject", $subject);
}

$from_name = $_REQUEST['from_name'];
if(!empty($from_name)){
	$where .=" and from_name like '%".$from_name."%'";
	$search_url .="&from_name=$from_name";
	$smarty->assign("from_name", $from_name);
}

$from_email = $_REQUEST['from_email'];
if(!empty($from_email)){
	$where .=" and from_email like '%".$from_email."%'";
	$search_url .="&from_email=$from_email";
	$smarty->assign("from_email", $from_email);
}


$query = "select * from ec_maillists where smcreatorid = '".$current_user->id."' ";
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


if($nun_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		$maillistsid = $row['maillistsid'];
		foreach($listview_header as $col=>$list){
		    if($col =='maillistsid'){
				 $entries[] = $i;
			}elseif($col == 'receiverinfo'){
				 $entries[] = msubstr1($row[$col],0,30);
				 
			}elseif($col == 'totalnum'){
				 $entries[] = "<font color=red>".$row[$col]."</font>";
				 
			}elseif($col == 'maillistname'){
				 $entries[] = '<a href="index.php?module=Relsettings&action=MailLogs&maillistsid='.$maillistsid.'">'.$row[$col].'</a>';
				 
			}elseif($col == 'mailcontent'){
				 $entries[] = htmlspecialchars(msubstr1($row[$col],0,30));
				 
			}elseif($col == 'successrate'){
				if(empty($row[$col])){
					  $entries[] = "<font color=blue>0</font>";
				}else{
					  $entries[] = "<font color=blue>".$row[$col]."</font>";
				}
				 
//			}elseif($col == 'readrate'){
//				if(empty($row[$col])){
//					 $entries[] = "<font color=green>0</font>";
//				}else{
//					 $entries[] = "<font color=green>".$row[$col]."</font>";
//				}
			}else{
				$entries[] = $row[$col];
			}
		}
		$listview_entries[$maillistsid]=$entries;
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
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","Maillists",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);
$smarty->assign("order_url", $order_url);

$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/Maillists.tpl");
?>
