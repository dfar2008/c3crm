<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('include/ListView/ListView.php');
require_once('include/DatabaseUtil.php');

global $app_strings,$mod_strings,$list_max_entries_per_page;

global $currentModule,$image_path,$theme;
$smarty = new CRMSmarty();
//if(is_file('modules/Home/c3crm_news.php'))
//{
	//require('modules/Home/c3crm_news.php');
	//$c3crm_news = $html_contents;
	//$smarty->assign("C3CRM_NEWS", $c3crm_news);
//}

//noted by ligangze on 2013/11/27
//if(is_file('modules/Home/key_customview.php'))
//{
//
//	require('modules/Home/key_customview.php');
//	$key_customview = $html_contents;
//	$smarty->assign("KEY_CUSTOMVIEW", $key_customview);
//}

$dashboard_arr = array();
if($current_user->is_admin===true){
    $isadmin = "";
}else{
    $isadmin = " and smownerid='".$current_user->id."'";
}
//====================================一周内待联系客户===========================//
$query="select * from ec_account where  deleted=0 and smownerid='".$current_user->id."' and contact_date !='' and contact_date !='0000-00-00'  and contact_date between '".date("Y-m-d")."' and '".date("Y-m-d",strtotime("1 week"))."' order by contact_date asc"; 

$result = $adb->getList($query);
foreach($result as $row){
	    $accountid = $row['accountid'];
		$NextContactAccount[$accountid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\" >".$row['accountname']."</a> &nbsp;&nbsp; ".$row['contact_date']." &nbsp;&nbsp;<a href=\"index.php?module=Notes&action=EditView&&return_module=Accounts&return_action=ListView&return_id=".$row['accountid']."\" >新增联系记录</a>";
}

$dashboard_arr['contact']['title'] = "7天内待联系客户(下次联系日期)";
$dashboard_arr['contact']['type'] = "text";
$dashboard_arr['contact']['divid'] = "7_day_contact";
$dashboard_arr['contact']['content'] = $NextContactAccount;




//=========================一月内到期纪念日==================================//
$onemonthlater = date("m-d",strtotime("1 month"));
$query="select * from ec_memdays where  deleted=0 and smownerid='".$current_user->id."' and substr(memday946,-5) between '".date("m-d")."' and '".$onemonthlater."'  order by memday946 asc";  
$result = $adb->getList($query);
foreach($result as $row){
	    $memdaysid = $row['memdaysid'];
		$accountname = getAccountName($row['accountid']);
		$OneMonthMemday[$memdaysid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;<a href=\"index.php?module=Accounts&action=DetailView&record=".$row['accountid']."\" >".$accountname."</a> &nbsp;&nbsp; ".$row['memday938']."&nbsp;&nbsp; ".$row['memday946']." &nbsp;&nbsp;";
}
$dashboard_arr['memday']['title'] = "一月内到期纪念日";
$dashboard_arr['memday']['type'] = "text";
$dashboard_arr['memday']['divid'] = "1_month_memday";
$dashboard_arr['memday']['content'] = $OneMonthMemday;


//=========================最近6个月销售情况=====================================//
$date_start = date('Y-m-d',mktime(0,0,0,date("m")-5,date("d"),date("Y")));
$date_end = date('Y-m-d',mktime (0,0,0,date("m"),date("d"),date("Y")));
if($current_user->is_admin===true){
    $soadmin = "";
}else{
    $soadmin = " and ec_salesorder.smownerid='".$current_user->id."'";
}
$where .= " ec_salesorder.orderdate >= ".db_convert("'".$date_start."'",'date')." AND ec_salesorder.orderdate <= ".db_convert("'".$date_end."'",'date')." ";
$query = "SELECT ".db_convert('ec_salesorder.orderdate','date_format',array("'%Y-%m'"),array("'YYYY-MM'"))." as m, 
			sum(ec_salesorder.total) as total, count(*) as so_count 
		FROM ec_salesorder 
			inner join ec_account 
				on ec_salesorder.accountid = ec_account.accountid 
			left join ec_users 
				on ec_users.id = ec_salesorder.smownerid 
		where ec_salesorder.deleted = 0  ";
$query .= " AND ".$where.$soadmin;
$query .= " GROUP BY ".db_convert('ec_salesorder.orderdate','date_format',array("'%Y-%m'"),array("'YYYY-MM'"))." ORDER BY m";
$result = $adb->query($query);

$categorys = date("Y-m",strtotime("-5 month")).",".date("Y-m",strtotime("-4 month")).",".date("Y-m",strtotime("-3 month")).
",".date("Y-m",strtotime("-2 month")).",".date("Y-m",strtotime("-1 month")).",".date("Y-m",strtotime("now"));
$datearr = explode(",",$categorys);

//订单金额 and 订单数量
$j=0;
$series = "";
$so_count ="";
for($i=0;$i<count($datearr);$i++){
    if($datearr[$i]==$adb->query_result($result,$j,"m")){
        $series .= $adb->query_result($result,$j,"total").",";
        $so_count .= $adb->query_result($result,$j,"so_count").",";
        $j++;
    }else{
         $series .= "0,";
         $so_count .="0,";
    }
}
$series = rtrim($series,",");
$so_count = rtrim($so_count,",");

$series = $series."_".$so_count;

$dashboard_arr['salesorder']['title'] = "最近6个月销售情况";
$dashboard_arr['salesorder']['type'] = "column,spline";
$dashboard_arr['salesorder']['divid'] = "6_month_sale";
$dashboard_arr['salesorder']['categorys'] = $categorys;
$dashboard_arr['salesorder']['series'] = $series;
$dashboard_arr['salesorder']['name'] = "销售额,订单数";
$dashboard_arr['salesorder']['content'] = "waiting...";




    $week = date("W");
    $year = date("Y");
    $timestamp = mktime(1,0,0,1,1,$year);
    $firstday = date("N",$timestamp);
    if($firstday >4)
        $firstweek = strtotime('+'.(8-$firstday).' days', $timestamp);
    else
        $firstweek = strtotime('-'.($firstday-1).' days', $timestamp);
    
    $monday = strtotime('+'.($week - 1).' week', $firstweek);
    $sunday = strtotime('+6 days', $monday);
    $start = date("Y-m-d", $monday);

    $lastweek = date("Y-m-d",strtotime("-1 week"));
    $lastweek_start = date("Y-m-d",strtotime("-1 week",$monday));
    $lastweek_end = date("Y-m-d",strtotime("-1 week",$sunday));
   // var_dump($lastweek_start);
    $end   = date("Y-m-d", $sunday);


//===================本周新增客户数========================//
$query  = "SELECT COUNT(*) AS daytotal FROM ec_account WHERE LEFT(createdtime,10)>='".$start."' AND deleted=0".$isadmin;
$lw_query = "SELECT COUNT(*) AS lwaccount FROM ec_account where LEFT(createdtime,10) BETWEEN '".$lastweek_start."' AND '".$lastweek_end."' AND deleted=0".$isadmin;


$result =$adb->query($query);
$lw_result = $adb->query($lw_query);
$daytotal = $adb->query_result($result,0,"daytotal");
$lw_account = $adb->query_result($lw_result,0,"lwaccount");
if($lw_account==0){
    $week_account_percent="U".($daytotal*100)."%";
}elseif($daytotal==0){
    $week_account_percent = "D".($lw_account*100)."%";
}elseif($daytotal>$lw_account){
    $week_account_percent = "U".(number_format(($daytotal-$lw_account)/$lw_account,2,'.',',')*100)."%";
}elseif($daytotal<$lw_account){
    $week_account_percent = "D".(number_format(($lw_account-$daytotal)/$daytotal,2,'.',',')*100)."%";
}else{
    $week_account_percent = "U0%";
}


//===================本周订单成交额=========================//
$query = "select sum(total) as monthdealorder from ec_salesorder where left(orderdate,10) between '".$start."' and '".$end."' and deleted=0".$isadmin;
$lw_query = "select sum(total) as lwdealorder from ec_salesorder where  deleted=0 and left(orderdate,10) between '".$lastweek_start."' and '".$lastweek_end."'".$isadmin;

$result = $adb->query($query);
$month_deal_order = $adb->query_result($result,0,"monthdealorder");
if(!$month_deal_order) $month_deal_order=0;
$lw_result = $adb->query($lw_query);
$lwdealorder = $adb->query_result($lw_result,0,"lwdealorder");

if($lwdealorder==0){
    $week_order_percent="U".($month_deal_order*100)."%";
}elseif($month_deal_order==0){
    $week_order_percent = "D".($lwdealorder*100)."%";
}elseif($month_deal_order>$lwdealorder){
    $week_order_percent = "U".(number_format(($month_deal_order-$lwdealorder)/$lwdealorder,4,'.',',')*100)."%";
}elseif($month_deal_order<$lwdealorder){
    $week_order_percent = "D".(number_format(($lwdealorder-$month_deal_order)/$month_deal_order,4,'.',',')*100)."%";
}else{
    $week_order_percent = "U0%";
}


//===================本周订单成交量=========================//
$query = "select count(*) as monthdealorder from ec_salesorder where left(orderdate,10) between '".$start."' and '".$end."' and deleted=0".$isadmin;
$lw_query = "select count(*) as lwdealorder from ec_salesorder where  deleted=0 and left(orderdate,10) between '".$lastweek_start."' and '".$lastweek_end."'".$isadmin;

$result = $adb->query($query);
$month_deal_count_order = $adb->query_result($result,0,"monthdealorder");
$lw_result = $adb->query($lw_query);
$lwdealorder = $adb->query_result($lw_result,0,"lwdealorder");

if($lwdealorder==0){
    $week_order_count_percent="U".($month_deal_count_order*100)."%";
}elseif($month_deal_count_order==0){
    $week_order_count_percent = "D".($lwdealorder*100)."%";
}elseif($month_deal_count_order>$lwdealorder){
    $week_order_count_percent = "U".(number_format(($month_deal_count_order-$lwdealorder)/$lwdealorder,4,'.',',')*100)."%";
}elseif($month_deal_count_order<$lwdealorder){
    $week_order_count_percent = "D".(number_format(($lwdealorder-$month_deal_count_order)/$month_deal_count_order,4,'.',',')*100)."%";
}else{
    $week_order_count_percent = "U0%";
}


//==================本周联系记录数=====================================//
$query = "select count(*) as weeknotes from ec_notes where left(createdtime,10)>='".$start."' and deleted=0".$isadmin;
$lw_query = "select count(*) as lwnotes from ec_notes where left(createdtime,10)between '".$lastweek_start."' and '".$lastweek_end."' and deleted=0".$isadmin;

$result = $adb->query($query);
$weeknewnotes = $adb->query_result($result,0,"weeknotes");
$lw_result = $adb->query($lw_query);
$lwnewnotes = $adb->query_result($lw_result,0,"lwnotes");

if($lwnewnotes==0){
    $week_notes_percent="U".($weeknewnotes*100)."%";
}elseif($weeknewnotes==0){
    $week_notes_percent = "D".($lwnewnotes*100)."%";
}elseif($weeknewnotes>$lwnewnotes){
    $week_notes_percent = "U".(number_format(($weeknewnotes-$lwnewnotes)/$lwnewnotes,4,'.',',')*100)."%";
}elseif($weeknewnotes<$lwnewnotes){
    $week_notes_percent = "D".(number_format(($lwnewnotes-$weeknewnotes)/$weeknewnotes,4,'.',',')*100)."%";
}else{
    $week_notes_percent = "U0%";
}

//=============================关键视图============================================//
$query = "select ec_customview.* from ec_customview inner join ec_tab on ec_tab.name = ec_customview.entitytype where ec_customview.setmetrics = 1 order by ec_customview.entitytype";
$result = $adb->query($query);
if($result){
require_once('modules/CustomView/CustomView.php');
require_once('modules/CustomView/ListViewTop.php');
}
$metriclists = Array();
$metricslist = Array();
for($i=0;$i<$adb->num_rows($result);$i++) {
	$metr_id = $adb->query_result($result,$i,'cvid');
    $metr_name = $adb->query_result($result,$i,'viewname');
    $metr_module = $adb->query_result($result,$i,'entitytype');
    $metr_count = "";

	$listquery = getListQuery($metr_module,'',true);
	$oCustomView = new CustomView($metr_module);
	$metricsql = $oCustomView->getMetricsCvListQuery($metr_id,$listquery,$metr_module);
	$log->info("metricsql:".$metricsql);
	if(isset($metricsql) && !empty($metricsql)){
		$metricresult = $adb->query($metricsql);
	}
	if($metricresult){
		$rowcount = $adb->fetch_array($metricresult);
		if(isset($rowcount)){
			$keyview_body .=  '<tr>
			<td>
			&nbsp;<a href="index.php?action=index&module='.$metr_module.'&viewname='.$metr_id.'">'.$metr_name.'</a>
			</td>
			<td align="left">&nbsp;'.$app_strings[$metr_module].'</td>
			<td align="left">&nbsp;'.$rowcount['count'].'</td>
			</tr>';
		}
	}
}

$dashboard_arr['keyview']['title'] = "关键视图";
$dashboard_arr['keyview']['type'] = "table";
$dashboard_arr['keyview']['divid'] = "keyview";
$dashboard_arr['keyview']['thead'] = array("视图名","模块","数量");
$dashboard_arr['keyview']['tbody'] = $keyview_body;
$dashboard_arr['keyview']['content'] = $OneMonthMemday;

//=================================易客CRM新闻=================================//

require('modules/Home/c3crm_news.php');

$dashboard_arr['crmnews']['title'] = "易客CRM新闻";
$dashboard_arr['crmnews']['type'] = "text";
$dashboard_arr['crmnews']['divid'] = "crmnews";
$dashboard_arr['crmnews']['content']= $html_contents;


$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'SfaDesktop');
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("CATEGORY",$category);
$smarty->assign("MYDASHBOARD",$dashboard_arr);
$smarty->assign("ACCOUNTPERCENT",substr($week_account_percent,1));
$smarty->assign("ACCOUNTUPDOWN",substr($week_account_percent,0,1));
$smarty->assign("WEEKNEWNOTES",$weeknewnotes);
$smarty->assign("MONTHDEALORDER",$month_deal_order);//订单销售额
$smarty->assign("DAYTOTAL",$daytotal);
$smarty->assign("ORDERPERCENT",substr($week_order_percent,1));
$smarty->assign("ORDERUPDOWN",substr($week_order_percent,0,1));
$smarty->assign("NOTESPERCENT",substr($week_notes_percent,1));
$smarty->assign("NOTESUPDOWN",substr($week_notes_percent,0,1));
$smarty->assign("ORDERCOUNTPERCENT",substr($week_order_count_percent,1));
$smarty->assign("ORDERCOUNT",$month_deal_count_order);//订单数量
$smarty->assign("ORDERCOUNTUPDOWN",substr($week_order_count_percent,0,1));



if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
	$smarty->display("Home/ListViewEntries.tpl");
else
	$smarty->display("Home/ListView.tpl");
?>
