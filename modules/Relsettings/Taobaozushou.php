<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $current_language;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$apphead = array("xh"=>"序号","shopname"=>"店铺名","appkey"=>"appKey","appsecret"=>"appSecret","nick"=>"昵称","status"=>"状态","tools"=>"工具");
$smarty->assign("APPHEAD", $apphead);
$smarty->assign("counthead", count($apphead));
if(!is_admin($current_user))
{
	$query = "select * from ec_appkey where smownerid='".$current_user->id."'";
}else{
	$query = "select * from ec_appkey";
}
$rows = $adb->getList($query);
if(!empty($rows)){
	$list_entries = array();
	foreach($rows as $key=>$row){
		$entries = array();
		$id = $row['id'];
		if($row['status'] ==1){
			$qiyong = "<font color=red>启用</font>";
			$current_id = $id;
			$current_appkey = $row['appkey'];
			$current_appsecret = $row['appsecret'];
			$current_nick = $row['nick'];
			$current_topsession = $row['topsession'];
		}else{
			$qiyong = "未启用";
		}
		
		
		foreach($apphead as $col=>$head){
			if($col=='xh'){
				$entries[] = $key+1;	
			}elseif($col == 'status'){
				$entries[] = $qiyong;	
			}elseif($col == 'tools'){
				$entries[] = "<a href='index.php?module=Relsettings&action=EditShopapp&record=$id'>编辑</a>&nbsp;|&nbsp;<a href='javascript:confirmdelete(\"index.php?module=Relsettings&action=DelShopapp&record=$id\");'>删除</a>";	
			}else{
				$entries[] = $row[$col]."&nbsp;";	
			}
			$list_entries[$id] = $entries;
		}
	}
}
$smarty->assign("LIST_ENTRIES", $list_entries);

//当前appkey与appsecret
if(isset($current_id) && $current_id !=''){
	$smarty->assign("current_id", $current_id);
	$smarty->assign("current_appkey", $current_appkey);
	$smarty->assign("current_appsecret", $current_appsecret);
	$smarty->assign("current_nick", $current_nick);
	$smarty->assign("current_topsession", $current_topsession);
}else{
	$noselect = "<font color=red>你尚未启用任何店铺应用，请设置！</font>";	
	$smarty->assign("noselect", $noselect);
}


if(is_admin($current_user)){
	$smarty->assign("ADMIN", "All");
}


$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/Taobaozushou.tpl");


?>
