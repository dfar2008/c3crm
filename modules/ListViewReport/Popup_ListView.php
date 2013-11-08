<?php
$currentModule=$_REQUEST['relatedmodule'];
require_once('include/database/PearDatabase.php');
require_once('include/CRMSmarty.php');
require_once("modules/$currentModule/$currentModule.php");
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');
require_once('modules/ListViewReport/ListViewReport.php');

global $app_strings,$mod_strings,$list_max_entries_per_page,$theme,$adb;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new CRMSmarty();
$focus = new $currentModule();

$listviewreport=new ListViewReport($currentModule);
if(isset($_REQUEST['iscustomreport'])&&$_REQUEST['iscustomreport']=='true'){
    $reportfun=$_REQUEST['reportfun'];
    $reportparams=$listviewreport->getSingleCustomReportInf($reportfun,true);
    $reportparams=$reportparams[1];
    $listviewreport->retrivePicklistFromCustom($reportparams);
}else{
    $listviewreport->retrivePicklistFromRequest();
}

$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);


if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = split("#@@#",getWhereCondition($currentModule));
}
elseif(isset($_SESSION['LiveViewSearch'][$currentModule]))
{
//    if($viewid==$_SESSION['LiveViewSearch'][$currentModule][0])
//    {
        $where=$_SESSION['LiveViewSearch'][$currentModule][1];
//    }
}

if(isset($_REQUEST['iscustomreport'])&&$_REQUEST['iscustomreport']=='true'){
    $listquery = $reportparams[0];
    if(!empty($where)){
        $listquery .= ' and '.$where;
    }
}else{
    if(method_exists($focus,"getListQuery")){
        //Retreive the list from Database
        //<<<<<<<<<customview>>>>>>>>>
        if(isset($where) && $where != '')
        {
            $where = ' and '.$where;
        }
        $listquery = $focus->getListQuery($where);
    }else{
        $listquery = getListQuery($currentModule);
        if(!empty($where)){
            $listquery .= ' and '.$where;
        }
    }
}

if($viewid != "0")
{
    $list_query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,$currentModule);
}
else
{
    $list_query =$listquery;
}
//print_r($listviewreport->getPicklistGroupInf($list_query));

$picklistinf=$listviewreport->getPicklistGroupInf($list_query);
$reportData=$listviewreport->getPicklistDataHTML($picklistinf);

//changed by xiaoyang on 2012-9-24
//$return=$listviewreport->getPicklistChartHTML($picklistinf);
$categories = "";
$i = 0;
foreach($picklistinf[0] as $v)
{
	$categories .= "'".$v."',";
	if($picklistinf[1][$v])
	{
		$value = $picklistinf[1][$v];
	}
	else
	{
		$value = 0;
	}
	$series .= "{name:'".$v."',y:".$value.",color: colors[".$i."]},";
	$i++;
}
$categories = rtrim($categories, ",");

$series = rtrim($series,",");
$graphtypeopts=$listviewreport->getGraphTypeOpts();
$collectcolumnopts=$listviewreport->getCollectColumnOpts();
//$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("TITLE", $listviewreport->getTitle());
$smarty->assign("HIDDENFIELDHTML",$listviewreport->getHiddenFieldHTML());
$smarty->assign("QUERY_STRING", $queryString);
$smarty->assign("CATEGORIES", $categories);
$smarty->assign("SERIES", $series);
$smarty->assign("TYPE", $listviewreport->graphtype);
$smarty->assign("FIELDNAME", $listviewreport->picklistfield[0]);
//$smarty->assign("REPORT_FLASH", $return);
$smarty->assign("REPORT_DATA", $reportData);
$smarty->assign("GRAPHTYPEOPTS", $graphtypeopts);
$smarty->assign("COLLECTCOLUMNOPTS",$collectcolumnopts);
$smarty->display("ListViewReport/ReportGraph.tpl");
?>
