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

$maillistsid = $_REQUEST['maillistsid'];

if(isset($maillistsid) && !empty($maillistsid)){
	$listview_header =array("id"=>"序号","sender"=>"发送人","receiver"=>"接收人","receiver_email"=>"接收人Email","flag"=>"是否发送成功","mailresult"=>"发送结果","sendtime"=>"发送时间");
}else{
	$listview_header =array("id"=>"序号","sender"=>"发送人","receiver"=>"接收人","receiver_email"=>"接收人Email","subject"=>"邮件主题","mailcontent"=>"邮件内容","flag"=>"是否发送成功","mailresult"=>"发送结果","sendtime"=>"发送时间");
	
}

$smarty->assign("LISTHEADER", $listview_header);
$smarty->assign("countheader", count($listview_header));


$where = '';
$search_url = '';
$receiver = $_REQUEST['receiver'];
if(!empty($receiver)){
	$where .=" and receiver like '%".$receiver."%'";
	$search_url .="&receiver=$receiver";
	$smarty->assign("receiver", $receiver);
}

$receiver_email = $_REQUEST['receiver_email'];
if(!empty($receiver_email)){
	$where .=" and receiver_email like '%".$receiver_email."%'";
	$search_url .="&receiver_email=$receiver_email";
	$smarty->assign("receiver_email", $receiver_email);
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



$smarty->assign("maillistsid", $maillistsid);
$search_url .="&maillistsid=$maillistsid";

if(isset($maillistsid) && !empty($maillistsid)){
	$selectsql = "select * from ec_maillists where maillistsid=$maillistsid and deleted=0";
	$selrow = $adb->getFirstLine($selectsql);
	if(!empty($selrow)){
		$mailids = $selrow['mailids'];
		
		$maillistname = $selrow['maillistname'];
		$from_name  = $selrow['from_name'];
		$from_email  = $selrow['from_email'];
		$receiverinfo = $selrow['receiverinfo'];
		$subject = $selrow['subject'];
		$contents  = $selrow['mailcontent'];
		$contents = str_replace("##",'&',$contents);	
		
		$successrate = $selrow['successrate'];
		//$readrate  = $selrow['readrate'];
		$totalnum  = $selrow['totalnum'];
		
		
		$smarty->assign("maillistname", $maillistname);
		$smarty->assign("from_name", $from_name);
		$smarty->assign("from_email", $from_email);
		$smarty->assign("receiverinfo", $receiverinfo);
		$smarty->assign("subject", $subject);
		$smarty->assign("contents", $contents);
		$smarty->assign("totalnum", $totalnum);
		$smarty->assign("successrate", $successrate);
		//$smarty->assign("readrate", $readrate);
		
		if(!empty($mailids)){
			$mailids = substr($mailids,0,-1);
			$listsql = " and id in ($mailids)";
		}
		
		if($totalnum < 30){
			$totalnumpx = $totalnum*20+5;
			$successratepx = $successrate*20+5;
			//$readratepx = $readrate*20+5;
		}elseif($totalnum >= 30 && $totalnum < 90){
			$totalnumpx = $totalnum*10+5;
			$successratepx = $successrate*10+5;
			//$readratepx = $readrate*10+5;
		}elseif($totalnum >= 90 && $totalnum < 1000){
			$totalnumpx = $totalnum+5;
			$successratepx = $successrate+5;
			//$readratepx = $readrate+5;
		}else{
			$totalnumpx = $totalnum/10+5;;
			$successratepx = $successrate/10+5;
			//$readratepx = $readrate/10+5;
		}
		
		
		
		$tongjihtml = '';
		$tongjihtml .='<div style="background-color:#F00;width:'.$totalnumpx.'px;float:left;margin-bottom:5px;">&nbsp;</div><div style="float:left;padding-left:5px;">总数:<font color="#990033"><b>'.$totalnum.'</b></font></div>'; 
        $tongjihtml .='<div style="clear:left;"></div>';
        $tongjihtml .='<div style="background-color:#0F0;width:'.$successratepx.'px;float:left;margin-bottom:5px;">&nbsp;</div><div style="float:left;padding-left:5px;">成功:<font color="#990033"><b>'.$successrate.'</b></font></div>';
       $tongjihtml .='<div style="clear:left;"></div>';
       //$tongjihtml .='<div style="background-color:#06F;width:'.$readratepx.'px;float:left;margin-bottom:5px;">&nbsp;</div><div style="float:left;padding-left:5px;">查看:<font color="#990033"><b>'.$readrate.'</b></font></div>';
       $tongjihtml .='<div style="clear:left;"></div>';
	   $smarty->assign("tongjihtml", $tongjihtml);
		
		
	}
}
//changed by xiaoyang on 2012-9-17  -- start
//$query = "select * from ec_maillogs where userid = '".$current_user->id."' {$listsql}";
if(!is_admin($current_user))
{
	$query = "select * from ec_maillogs where maillistsid=".$maillistsid." and userid = '".$current_user->id."' {$listsql}";
}
else
{
	$query = "select * from ec_maillogs where maillistsid=".$maillistsid."";
}
//--end

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
				   $entries[] = "<font color=green>Yes</font>";
			   }else{
				   $entries[] = "<font color=red>No</font>";
			   }
//			}elseif($col =='isread'){
//			   if($row['isread'] > 0){
//				   $entries[] = "<font color=green>已读</font>";
//			   }else{
//				   $entries[] = "<font color=red>未读</font>";
//			   }
			}elseif($col =='id'){
				 $entries[] = $i;
			}elseif($col == 'mailcontent'){
				 $entries[] = htmlspecialchars(msubstr1($row[$col],0,50)); 
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
$navigationOutput = getTableHeaderNavigation($navigation_array, '',"Settings","MailLogs",'');

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->assign("search_url", $search_url);

$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$relsetmode = "view";
if(isset($_REQUEST['relsetmode']) && $_REQUEST['relsetmode'] != ''){
	$relsetmode = $_REQUEST['relsetmode'];
}
$smarty->assign("RELSETMODE", $relsetmode);

$smarty->display("Relsettings/MailLogs.tpl");
?>
