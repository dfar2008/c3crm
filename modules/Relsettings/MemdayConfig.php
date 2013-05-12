<?php

require_once('include/CRMSmarty.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

//Display the mail send status
$smarty = new CRMSmarty();

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$listview_header =array("xh"=>"序号","type"=>"纪念日类型","zxrq"=>"执行日期","sms"=>"短信发送","smsto"=>"短信发送对象","autoact_sms_sm"=>"短信内容","email"=>"邮件发送","emailto"=>"邮件发送对象","autoact_email_sm"=>"邮件说明","tools"=>"工具");
$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countnheader", count($listview_header));

if(is_admin($current_user))
{
	$query = "select * from ec_memdayconfig";
}else{
	$query = "select * from ec_memdayconfig where smownerid='".$current_user->id."'";
}
$result = $adb->getList($query);
$num_rows = $adb->num_rows($result);
if($num_rows > 0){
	$i=1;
	foreach($result as $row) {		
		$entries = array();
		$id = $row['id'];
		foreach($listview_header as $col=>$list){
		   if($col =='tools'){
				$entries[] = "<a href=\"index.php?module=Relsettings&action=MemdayConfigEdit&record=".$id."\"> &nbsp;编辑 </a> | <a href=\"javascript:confirmdelete('index.php?module=Relsettings&action=MemdayConfigEdit&record=".$id."&del=1')\"> 刪除 </a>";
			}elseif($col =='xh'){
				$entries[] = $i;
			}elseif($col =='zxrq'){
				$entries[] = " 于纪念日提前<font color=\"#CC6699\">".$row['tp']." </font>天提醒";
			}elseif($col =='sms'){
				if($row['sms'] =='on'){
					$entries[] = "Yes";
				}else{
					$entries[] = "No";
				}
			}elseif($col =='smsto'){
				$smsto = '';
				if($row['smstoacc'] =='on'){
					$smsto .= "发给客户<br>";
				}
				if($row['smstouser'] =='on'){
					$smsto .= " 发给自己";
				}
				$entries[] = $smsto;
			}elseif($col =='email'){
				if($row['email'] =='on'){
					$entries[] = "Yes";
				}else{
					$entries[] = "No";
				}
			}elseif($col =='emailto'){
				$emailto = '';
				if($row['emailtoacc'] =='on'){
					$emailto .= "发给客户<br>";
				}
				if($row['emailtouser'] =='on'){
					$emailto .= " 发给自己";
				}
				$entries[] = $emailto;
			}elseif($col =='autoact_email_sm'){
				
			    $entries[] = "<font color=red>邮件标题:</font><br>".$row['autoact_email_bt']." <br><font color=red>邮件内容:</font><br>".$row['autoact_email_sm'];;
				
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
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);
$smarty->display("Relsettings/MemdayConfig.tpl");
?>
