<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Accounts/Accounts.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $log, $currentModule, $singlepane_view;
global $current_user;

$focus = new Accounts();
if(isset($_REQUEST['record']) && $_REQUEST['record'] !='') {
    $focus->retrieve_entity_info($_REQUEST['record'],"Accounts");
    $focus->id = $_REQUEST['record'];
    $focus->name=$focus->column_fields['accountname'];
}
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
	$focus->id = "";
}
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty = new CRMSmarty();
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);


//$smarty->assign("CUSTOMFIELD", $cust_fld);
$smarty->assign("ID", $_REQUEST['record']);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);


$moduletype = $_REQUEST['moduletype'];
$smarty->assign("type", $moduletype);

$query = "select * from ec_sfasettings where sfastatus='已启用' and deleted=0 and smownerid='".$current_user->id."' ";
$result = $adb->query($query);
$num_rows = $adb->num_rows($result);
if($num_rows > 0){
		for($i=0;$i<$num_rows;$i++){
			$id = $adb->query_result($result,$i,"sfasettingsid");
			$name = $adb->query_result($result,$i,"sfasettingname");
			$sfa_entries[$id] = $name;			
		}
}
$sfasettingshtml = '';
if(!empty($sfa_entries)){
	foreach($sfa_entries  as $sfa_id => $sfa_name){
		$sfasettingshtml .='<option value="'.$sfa_id.'">'.$sfa_name.'</option>';
	}
}
$smarty->assign("sfasettingshtml", $sfasettingshtml);

$dzsmarr = array("manual"=>"具体事务","sms"=>"发短信","email"=>"发邮件");
$zxztarr = array("成功"=>"s31.png","跳过"=>"s32.png","再次执行"=>"me.png","执行失败"=>"s33.png","未执行"=>"me.png","自动执行中"=>"s34.png",);
$bjztarr = array("正在执行期内"=>"jinxing","过期未执行的"=>"guoqi","正常的"=>"zhengchang");

$query = "select * from ec_sfalists where accountid=".$focus->id." and deleted=0 and smownerid='".$current_user->id."'";
$result = $adb->getList($query);
	$Sfalists_now = array();
	$Sfalists_over = array();
	foreach($result as $row)
	{
		$zxzt = $row['zxzt'];
		$sfalistsid = $row['sfalistsid'];
		$sfasettingsid = $row['sfasettingsid'];
		$sfasettingname = getSfasettingName($sfasettingsid);
		if($zxzt =='中止' || $zxzt =='结束'){
			$Sfalists_over[$sfalistsid] = " <img src=\"themes/softed/images/s1.png\" border=0/> <a href=\"index.php?module=Sfalists&action=DetailView&record=".$sfalistsid."\">".$row['sfalistname']."</a>  (<font color=\"#666666\">".$sfasettingname."</font>)";
		}else{
			$tools = '<a href="#" onclick="openEdit('.$sfalistsid.');return false;"><img src="themes/softed/images/sfaeedit.png" border=0/ >编辑</a>';
			if($zxzt == '未执行'){
				$tools .='  |  <a href="#" onclick="openDel('.$sfalistsid.');return false;"><img src="themes/softed/images/sfaedel.png" border=0 />删除</a>';
			}
			$tools .='   |   <a href="#" onclick="openZhongzhi('.$sfalistsid.');return false;"><img src="themes/softed/images/sfastop.png" border=0 />中止</a>';
			
			$Sfalists_now[$sfalistsid] = " <img src=\"themes/softed/images/s1.png\" border=0/> <a href=\"index.php?module=Sfalists&action=DetailView&record=".$sfalistsid."\">".$row['sfalistname']."</a>  (<font color=\"#666666\">".$sfasettingname."</font>)"."  &nbsp;&nbsp;&nbsp;".$tools;
			
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
	}
//repeat-x scroll 0 -21px transparent;
// url("/images/sfa/sfa_blue.png") no-repeat scroll right -42px transparent;

$smarty->assign("Sfalists_now", $Sfalists_now);
$smarty->assign("Sfalists_now_events", $Sfalists_now_events);
$smarty->assign("sfalist_now_events_list", $sfalist_now_events_list);
$smarty->assign("Sfalists_over", $Sfalists_over);


$query = "select * from ec_sfalogs where logstatus !='未执行' and accountid=".$focus->id." and smownerid='".$current_user->id."' and sfalisteventsid !=0  and (modifiedtime >= '".date("Y-m-d")." 00:00:00' && modifiedtime <= '".date("Y-m-d")." 59:59:59') order by modifiedtime desc";
$result = $adb->getList($query);
foreach($result as $row)
{
	$sfalogsid = $row['sfalogsid'];
	$sfalogs[$sfalogsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;[".$row['logstatus']."] &nbsp;&nbsp;<a href=\"#\" onclick=\"openRunEvent(".$row['sfalisteventsid'].");return false;\">".$row['sj']."</a> &nbsp;&nbsp; (执行时间: <font color=\"#666666\">".$row['modifiedtime']."</font>)";
}

$smarty->assign("Sfalogs", $sfalogs);

$check_button = Button_Check($module);
$smarty->assign("CHECK", $check_button);
$smarty->assign("MODULE",$currentModule);


$smarty->display("Accounts/Sfalists.tpl");

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
