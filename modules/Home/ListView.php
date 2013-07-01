<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('include/ListView/ListView.php');
require_once('include/DatabaseUtil.php');

global $app_strings,$mod_strings,$list_max_entries_per_page;

global $currentModule,$image_path,$theme;
$smarty = new CRMSmarty();
if(is_file('modules/Home/c3crm_news.php'))
{
	require('modules/Home/c3crm_news.php');
	$c3crm_news = $html_contents;
	$smarty->assign("C3CRM_NEWS", $c3crm_news);
}

if(is_file('modules/Home/key_customview.php'))
{
	require('modules/Home/key_customview.php');
	$key_customview = $html_contents;
	$smarty->assign("KEY_CUSTOMVIEW", $key_customview);
}

//一周内待联系客户
$query="select * from ec_account where  deleted=0 and smownerid='".$current_user->id."' and contact_date !='' and contact_date !='0000-00-00'  and contact_date between '".date("Y-m-d")."' and '".date("Y-m-d",strtotime("1 week"))."' order by contact_date asc"; 
$result = $adb->getList($query);
foreach($result as $row){
	    $accountid = $row['accountid'];
		$NextContactAccount[$accountid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\" >".$row['accountname']."</a> &nbsp;&nbsp; ".$row['contact_date']." &nbsp;&nbsp;<a href=\"index.php?module=Notes&action=EditView&&return_module=Accounts&return_action=ListView&return_id=".$row['accountid']."\" >新增联系记录</a>";
}

$smarty->assign("NEXTCONTACTACCOUNT", $NextContactAccount);

//一月内到期纪念日
$onemonthlater = date("m-d",strtotime("1 month"));
$query="select * from ec_memdays where  deleted=0 and smownerid='".$current_user->id."' and substr(memday946,-5) between '".date("m-d")."' and '".$onemonthlater."'  order by memday946 asc";  
$result = $adb->getList($query);
foreach($result as $row){
	    $memdaysid = $row['memdaysid'];
		$accountname = getAccountName($row['accountid']);
		$OneMonthMemday[$memdaysid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\" >".$accountname."</a> &nbsp;&nbsp; ".$row['memday938']."&nbsp;&nbsp; ".$row['memday946']." &nbsp;&nbsp;";
}

$smarty->assign("ONEMONTHMEMDAY", $OneMonthMemday);



$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'SfaDesktop');
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("CATEGORY",$category);


if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Home/ListViewEntries.tpl");
else
	$smarty->display("Home/ListView.tpl");
?>
