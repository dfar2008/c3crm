<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('include/ListView/ListView.php');
require_once('include/DatabaseUtil.php');

global $app_strings,$mod_strings,$list_max_entries_per_page;

global $currentModule,$image_path,$theme;
$smarty = new CRMSmarty();
if(is_file('modules/SfaDesktops/c3crm_news.php'))
{
	require('modules/SfaDesktops/c3crm_news.php');
	$c3crm_news = $html_contents;
	$smarty->assign("C3CRM_NEWS", $c3crm_news);
}

if(is_file('modules/SfaDesktops/key_customview.php'))
{
	require('modules/SfaDesktops/key_customview.php');
	$key_customview = $html_contents;
	$smarty->assign("KEY_CUSTOMVIEW", $key_customview);
}
/*
//需要我执行的
$query="select ec_sfalistevents.*,ec_sfalists.accountid from ec_sfalistevents
			inner join ec_sfalists on ec_sfalists.sfalistsid = ec_sfalistevents.sfalistsid
			where  ec_sfalists.deleted=0 and ec_sfalists.smownerid='".$current_user->id."' and ec_sfalists.zxzt in('未执行','执行中') and  (ec_sfalistevents.datestart is NULL or ec_sfalistevents.datestart ='0000-00-00' or (ec_sfalistevents.datestart <='".date("Y-m-d")."' and ec_sfalistevents.dateend >='".date("Y-m-d")."')) and ec_sfalistevents.zt in('未执行','再次执行') order by ec_sfalistevents.datestart	";

$result = $adb->getList($query);
foreach($result as $row){
	$sfalisteventsid = $row['id'];
	$accountname = getAccountName($row['accountid']);
	$sfalistevents_do[$sfalisteventsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"#\" onclick=\"openRunEvent(".$sfalisteventsid.");return false;\">".$row['sj']."</a> &nbsp;&nbsp; (开始日期:<font color=\"#666666\">".$row['datestart']."</font>)&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\">".$accountname."</a>&nbsp;&nbsp;".$row['zxdz']."";
}

$smarty->assign("SFALISTEVENTS_DO", $sfalistevents_do);

//执行失败的
$query="select ec_sfalistevents.*,ec_sfalists.accountid from ec_sfalistevents
			inner join ec_sfalists on ec_sfalists.sfalistsid = ec_sfalistevents.sfalistsid
			where  ec_sfalists.deleted=0 and ec_sfalists.smownerid='".$current_user->id."' and ec_sfalists.zxzt ='执行中' and ec_sfalistevents.zt='执行失败' and ec_sfalists.deleted=0 order by ec_sfalistevents.datestart";

$result = $adb->getList($query);
foreach($result as $row) {
	$sfalisteventsid = $row['id'];
	$accountname = getAccountName($row['accountid']);
	$sfalistevents_failed[$sfalisteventsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"#\" onclick=\"openRunEvent(".$sfalisteventsid.");return false;\">".$row['sj']."</a> &nbsp;&nbsp; (开始日期:<font color=\"#666666\">".$row['datestart']."</font>)&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\">".$accountname."</a>&nbsp;&nbsp;".$row['zxdz']."";
}

$smarty->assign("SFALISTEVENTS_FAILED", $sfalistevents_failed);


//最近自动执行成功的SFA日志
$query="select * from ec_sfalogs where  deleted=0 and smownerid='".$current_user->id."' and zidong ='自动执行' and logstatus='成功' order by modifiedtime desc";

$result = $adb->getList($query);
foreach($result as $row){
		$sfalogsid = $row['sfalogsid'];
		$accountname = getAccountName($row['accountid']);
		$sfasettingname = getSfasettingName($row['sfasettingsid']);
		$sfalistevents_successlog[$sfalogsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"#\" onclick=\"openRunEvent(".$row['sfalisteventsid'].");return false;\">".$row['sj']."</a> &nbsp;&nbsp; (执行时间:<font color=\"#666666\">".$row['modifiedtime']."</font>)&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\">".$accountname."</a>&nbsp;&nbsp;<a href=\"index.php?module=Sfasettings&action=SfaDetails&sfasettingsid=".$row['sfasettingsid']."\">".$sfasettingname."</a>&nbsp;&nbsp;".$row['zxdz']." ";
}

$smarty->assign("SFALISTEVENTS_SUCCESSLOG", $sfalistevents_successlog);

//最近自动执行失败的SFA日志
$query="select * from ec_sfalogs where  deleted=0 and smownerid='".$current_user->id."' and zidong ='自动执行' and logstatus='失败' order by modifiedtime desc";

$result = $adb->getList($query);
foreach($result as $row){
		$sfalogsid = $row['sfalogsid'];
		$accountname = getAccountName($row['accountid']);
		$sfasettingname = getSfasettingName($row['sfasettingsid']);
		$sfalistevents_faillog[$sfalogsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"#\" onclick=\"openRunEvent(".$row['sfalisteventsid'].");return false;\">".$row['sj']."</a> &nbsp;&nbsp; (执行时间:<font color=\"#666666\">".$row['modifiedtime']."</font>)&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\">".$accountname."</a>&nbsp;&nbsp;<a href=\"index.php?module=Sfasettings&action=SfaDetails&sfasettingsid=".$row['sfasettingsid']."\">".$sfasettingname."</a>&nbsp;&nbsp;".$row['zxdz']." ";
}

$smarty->assign("SFALISTEVENTS_FAILLOG", $sfalistevents_faillog);*/

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

/*
//SFA方案对应客户(未结束)
$query = "select * from ec_sfasettings where deleted=0 and smownerid='".$current_user->id."' and sfastatus='已启用'";
$result = $adb->getList($query);
foreach($result as $row){
		$sfasettingsid = $row['sfasettingsid'];
		$sfasettingname = $row['sfasettingname'];
		
		$query_1 = "select ec_account.* 
					from ec_account 
					inner join ec_sfalists on ec_sfalists.accountid = ec_account.accountid
				    where ec_account.deleted=0 and ec_account.smownerid='".$current_user->id."' 
					and ec_sfalists.sfasettingsid='".$sfasettingsid."' and ec_sfalists.deleted=0";
		$result_1 = $adb->getList($query_1);
		$num_rows_1 = $adb->num_rows($result_1);
		$acc_str = '';
		foreach($result_1 as $row_1) {
			$accountid = $row_1['accountid'];
			$accountname = $row_1['accountname'];
			$acc_str .= "&nbsp;&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$accountid."\">".$accountname."</a>";
		}
		
		$sfasettingaccount[$sfasettingsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"index.php?module=Sfasettings&action=SfaDetails&sfasettingsid=".$sfasettingsid."\">".$sfasettingname."</a>&nbsp;&nbsp;【总数:<font color=red><b>".$num_rows_1."</b></font>】".$acc_str;
			
	}

$smarty->assign("SFASETTINGACCOUNT", $sfasettingaccount);


//$buyer_credit_arr = array("1钻","2钻","3钻","4钻","5钻","1蓝冠","2蓝冠","3蓝冠","4蓝冠","5蓝冠","1皇冠","2皇冠","3皇冠","4皇冠","5皇冠");
//$buyer_credit = '';
//foreach($buyer_credit_arr as $key => $val){
//	if($key == 0){
//		$buyer_credit .= "'".$val."'";
//	}else{
//		$buyer_credit .= ",'".$val."'";
//	}	
//}

$dzsmarr = array("manual"=>"具体事务","sms"=>"发短信","email"=>"发邮件");
$zxztarr = array("成功"=>"s31.png","跳过"=>"s32.png","再次执行"=>"me.png","执行失败"=>"s33.png","未执行"=>"me.png","自动执行中"=>"s34.png",);
$bjztarr = array("正在执行期内"=>"jinxing","过期未执行的"=>"guoqi","正常的"=>"zhengchang");


//意向客户的SFA序列
$query = "select  ec_sfalists.*,ec_account.accountname 
				from ec_sfalists 
				inner join ec_account on ec_sfalists.accountid = ec_account.accountid
				where ec_account.deleted=0 and ec_account.smownerid='".$current_user->id."' 
				and ec_account.rating='意向' and ec_sfalists.zxzt in('未执行','执行中') 
				and ec_sfalists.deleted=0";
				
$result = $adb->getList($query);
foreach($result as $row){
		$sfalistsid = $row['sfalistsid'];
		$sfalistname = $row['sfalistname'];
		$sfasettingname = getSfasettingName($row['sfasettingsid']);
		$sfalistaccount[$sfalistsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\">".$row['accountname']."</a>&nbsp;&nbsp;<a href=\"index.php?module=Sfasettings&action=SfaDetails&sfasettingsid=".$row['sfasettingsid']."\">".$sfasettingname."</a>&nbsp;&nbsp;";
			
			$Sfalists_now_events = getSfalistEvent($sfalistsid);
			
			foreach($Sfalists_now_events[$sfalistsid] as $id=>$val){
				$ms = $val['sj']."  ".$val['datestart']."  ".$val['dateend']."  ".$dzsmarr[$val['at']];
				
				$today = date("Y-m-d");
				if($today >= $val['datestart'] && $today <= $val['dateend']){
					$bjzt = "正在执行期内";
				}else if($today > $val['dateend'] && ($val['zt'] =='未执行' || $val['zt'] =='再次执行') && $val['dateend'] !='0000-00-00'){
					$bjzt = "过期未执行的";
				}else{
					$bjzt = "正常的";
				}
				
				$sfalist_now_events_list[$sfalistsid][$id] = "<div class=\"".$bjztarr[$bjzt]."\"><li class=\"sfasn\">&nbsp;&nbsp;<a href=\"#\" title=\"".$ms."\" onclick=\"openRunEvent(".$id.");return false;\"><span>".$val['sj']."".$val['sjbz']."[<img src=\"themes/softed/images/".$zxztarr[$val['zt']]."\" border=0/>]</span></a>&nbsp;&nbsp;</li></div>";
			}
			
			
			
}

$smarty->assign("SFALISTACCOUNT", $sfalistaccount);
$smarty->assign("SFALIST_NOW_EVENTS_LIST", $sfalist_now_events_list);*/



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
	$smarty->display("SfaDesktops/ListViewEntries.tpl");
else
	$smarty->display("SfaDesktops/ListView.tpl");
function getSfasettingName($sfasettingsid){
	global $adb;
	$query = "select sfasettingname from ec_sfasettings where sfasettingsid='".$sfasettingsid."' and deleted=0";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$sfasettingname = $adb->query_result($result,0,"sfasettingname");
	}
	return $sfasettingname;
}

function getSfalistEvent($sfalistsid){
	global $adb;
	$query = "select * from ec_sfalistevents where sfalistsid='".$sfalistsid."' order by datestart ";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	$arr = array();
	$arr2 = array();
	$arr3 = array();
	if($num_rows > 0){
		for($i=0;$i<$num_rows;$i++){
			$id = $adb->query_result($result,$i,"id");
			$sj = $adb->query_result($result,$i,"sj");
			$sjbz = $adb->query_result($result,$i,"sjbz");
			$datestart = $adb->query_result($result,$i,"datestart");
			$dateend = $adb->query_result($result,$i,"dateend");
			$at = $adb->query_result($result,$i,"at");
			$zt = $adb->query_result($result,$i,"zt");
			
			$arr['sj'] = $sj;
			$arr['sjbz'] = $sjbz;
			$arr['datestart'] = $datestart;
			$arr['dateend'] = $dateend;
			$arr['at'] = $at;
			$arr['zt'] = $zt;
			$arr2[$id] = $arr;
		}
		$arr3[$sfalistsid]  = $arr2;
	}
	return $arr3;	
}
?>
