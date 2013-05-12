<?php
require_once("config.php");
require_once("include/utils/utils.php");
require_once('include/database/PearDatabase.php');
require_once('include/fusioncharts/Class/FusionCharts.php');
require_once("include/fusioncharts/horizontal_chart.php");
require_once("include/fusioncharts/vertical_chart.php");
require_once("include/fusioncharts/pie_chart.php");
require_once('modules/ListViewReport/ListViewReport.php');
require_once('include/fusioncharts/Class/FusionCharts.php');
require_once('include/DatabaseUtil.php');
global $adb,$current_user,$list_max_entries_per_page;
$order = "ec_account.lastorderdate";$desc = 'asc';
//视图标签
$setype = 'flash';
if($_REQUEST['setype'] && !empty($_REQUEST['setype'])){
	$setype = $_REQUEST['setype'];
	$findurlstr .= "&setype=".$_REQUEST["setype"];
}
$setypearr = array("flash"=>"视图","report"=>"报表");
//flash
$flashtype = "vertical";
if(isset($_REQUEST["flashtype"]) && $_REQUEST["flashtype"] != "") {
	$flashtype = $_REQUEST["flashtype"];
	$findurlstr .= "&flashtype=".$_REQUEST["flashtype"];
}
//时间
if(empty($_REQUEST['stdDateFilter'])){
	$_REQUEST['stdDateFilter'] = 'thismonth';
}
if($_REQUEST['stdDateFilter'] != 'custom'){
	$startdate = date("Y-m-01");
	$enddate = date("Y-m-t");
	if($_REQUEST['startdate'] && !empty($_REQUEST['startdate'])){
		$startdate = $_REQUEST['startdate'];		
	}
	if($startdate && !empty($startdate)){
		$where .= "and ec_account.lastorderdate > '{$startdate} 00:00:00' ";
	}
	if($_REQUEST['enddate'] && !empty($_REQUEST['enddate'])){
		$enddate = $_REQUEST['enddate'];		
	}
	if($enddate && !empty($enddate)){
		$where .= "and ec_account.lastorderdate < '{$enddate} 23:59:59' ";
	}
}
$findurlstr .= "&stdDateFilter=".$_REQUEST["stdDateFilter"]."&startdate=".$startdate."&enddate=".$enddate."";
$startarr = split("-",$startdate);
$groupdatearr = array(
	"day"=>"".db_convert("ec_account.lastorderdate",'date_format',array("'%Y-%m-%d'"),array("'{$startarr[0]}'-'{$startarr[1]}'-DD"))."",
	"week"=>"DATE_FORMAT(ec_account.lastorderdate, '%x %v')",
	"month"=>"".db_convert('ec_account.lastorderdate','date_format',array("'%Y-%m'"),array("'{$startarr[0]}-MM'"))."",
	"year"=>"".db_convert("ec_account.lastorderdate",'date_format',array("'%Y'"),array("'{$startarr[0]}'")).""
);
//统计类型
$grouptype = 'day';
if($_REQUEST['grouptype'] && !empty($_REQUEST['grouptype'])){
	$grouptype = $_REQUEST['grouptype'];
	$findurlstr .= "&grouptype=".$_REQUEST["grouptype"];
}
//$groupsql = $groupdatearr[$grouptype];
$groupsql = "case when ec_account.bill_state = '' or ec_account.bill_state is null 
				then SUBSTRING(bill_street,1,2) else SUBSTRING(ec_account.bill_state,1,3) end";
$query = "select {$groupsql} as groupdate,count(*) as groupnum from ec_account where ec_account.deleted = 0 and ec_account.smownerid=".$current_user->id." ";
if($where && !empty($where)){
	$query .= $where;	
}
$query .= "group by {$groupsql} ";

///page
$currentpage = '1';
if($_REQUEST['start'] && $_REQUEST['start'] > 0){
	$currentpage = $_REQUEST['start'];
	$findurlstr .= "&start=".$currentpage;
}
if($_REQUEST['limitpage'] && $_REQUEST['limitpage'] > 0){
	$list_max_entries_per_page = $_REQUEST['limitpage'];
	$currentpage = '1';
	$findurlstr .= "&limitpage=".$list_max_entries_per_page."&start=".$currentpage;
}

$noofrows = $adb->num_rows($adb->query($query));//总记录数
$navigation_array = getNavigationValues($currentpage, $noofrows, $list_max_entries_per_page);
$navigation_array['totalnum'] = $noofrows;
//modified by rdhital
$start_rec = $navigation_array['start'];
$end_rec = $navigation_array['end_val']; 
//By Raju Ends
$_SESSION['nav_start']=$start_rec;
$_SESSION['nav_end']=$end_rec;
$noofrows= $navigation_array['totalnum']; 
if ($start_rec == 0) 
	$limit_start_rec = 0;
else
	$limit_start_rec = $start_rec -1;
$record_string = $app_strings["LBL_SHOWING"]." " .$start_rec." - ".$end_rec." " .$app_strings["LBL_LIST_OF"] ." ".$noofrows;

$result = $adb->limitQuery2($query,$limit_start_rec,$list_max_entries_per_page,$order,$desc);
if($noofrows && $noofrows > 0){
	$for_i = 1;$listentryhtml = '';
	while($row = $adb->fetch_array($result)){
		$listentryhtml .= "<tr bgcolor='white' class='report_part' style='height: 25px; display:none;'>";
		$listentryhtml .= "<td align='center'>{$for_i}</td>";
		$listentryhtml .= "<td align='center'>{$row['groupdate']}</td>";
		$listentryhtml .= "<td align='center'>{$row['groupnum']}</td>";
		$listentryhtml .= '</tr>';
		//flash
		$months_arr[$row['groupdate']] = $row['groupdate'];
		$months_count[$row['groupdate']] += $row['groupnum'];
		$for_i ++;
	}
}
$navigationOutput = getTableHeaderNavigation($navigation_array, $url_string,$currentModule,"index",$viewid);
///flash
if(count($months_count) > 0) {
	$resflash = '';
	$title = "会员地区分布统计";
	if($flashtype == "horizontal") {
		$resflash = horizontal_graph_fusion2($months_count,$months_arr,$title);
	} elseif($flashtype == "vertical") {
		$resflash = vertical_graph_fusion2($months_count,$months_arr,$title);
	} elseif($flashtype == "pie") {
		$resflash = pie_chart_fusion2($months_count,$months_arr,$title);
	} elseif($flashtype == "line") {
		$resflash = line_chart_fusion2($months_count,$months_arr,$title);
	} elseif($flashtype == "pie2d") {
		$resflash = horizontal_graph_Pie2D($months_count,$months_arr,$title);
	} else {
		$resflash = horizontal_graph_fusion2($months_count,$months_arr,$title);
	}		
} else {
	$return = "No Data";
}

$title = "会员地区分布统计";
$connection = '<a href="#" onclick="setsearch_click();return false;">搜索</a> | 
				<a href="javascript:;" onclick="exportReport();return false;">导出</a>';
$smarty->assign('title',$title);
$smarty->assign('connection',$connection);
$smarty->assign('LISTENTRYHTML',$listentryhtml);
$smarty->assign('RESFLASH',$resflash);
$smarty->assign('SETYPEARR',$setypearr);
$smarty->assign('SETYPE',$setype);
$smarty->assign('MODULE',$currentModule);
$smarty->assign('ACTIONS','ListView');
$smarty->assign('FINDURLSTR',$findurlstr);
$smarty->assign('colspan','4');
//搜索
$dateFilterHtml = getStdDateFilterHtml($_REQUEST['stdDateFilter']);
$dateFilterJs = getStdDateFilterJs();
$smarty->assign("dateFilterHtml", $dateFilterHtml);
$smarty->assign("dateFilterJs", $dateFilterJs);
$smarty->assign("startdate", $startdate);
$smarty->assign("enddate", $enddate);

$grouptypearr = array("day"=>"以天为单位查询","week"=>"以周为单位查询",
						"month"=>"以月为单位查询","year"=>"以年为单位查询");
$smarty->assign("GROUPTYPEARR", $grouptypearr);
$smarty->assign("grouptype", $grouptype);

$flashtypearr = array("vertical"=>"三维柱状图","horizontal"=>"二维柱状图",
						"line"=>"折线表图","pie"=>"三维饼状图","pie2d"=>"二维饼状图");
$smarty->assign("FLASHTYPEARR", $flashtypearr);
$smarty->assign("flashtype", $flashtype);

$smarty->assign("NAVIGATION", $navigationOutput);
$smarty->assign("RECORD_COUNTS", $record_string);
$smarty->display("Addressreports/ListView.tpl");

function horizontal_graph_Pie2D($datax,$datay,$title,$width = 800,$height=400){	
	if(!is_array($datay) || !is_array($datax)) {
		return;
	}
	$fileContents = '';
	$i = 0;
	foreach($datay as $datay_item) {
		$color = generate_fusioncharts_color($datay_item,$i);
		$fileContents .= "<set name='".$datay_item."' value='".$datax[$datay_item]."' color='".$color."' />";
		$i ++;
	}
	$fileContents = "<graph labelDisplay='WRAP' caption='".$title."' shownames='1' showvalues='1'  numDivLines='4' formatNumberScale='0' decimalPrecision='0'
anchorSides='10' anchorRadius='3' anchorBorderColor='009900' outCnvBaseFontSize='12' baseFontSize='12'>".$fileContents."</graph>";
	
	$return = renderChartHTML("include/fusioncharts/Charts/FCF_Pie2D.swf","",$fileContents,"reportChart",$width,$height);
	return $return;
}
?>
