<?php
$currentModule=$_REQUEST['relatedmodule'];
require_once('include/database/PearDatabase.php');
require_once('include/CRMSmarty.php');
require_once("modules/$currentModule/$currentModule.php");
require_once('include/ListView/ListView.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/database/Postgres8.php');
require_once('include/DatabaseUtil.php');
require_once('modules/ListViewReport/ListViewCustomReport.php');

global $app_strings,$mod_strings,$list_max_entries_per_page,$theme,$adb;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$focus = new $currentModule();
$oCustomView = new CustomView($currentModule);
$viewid = $oCustomView->getViewId($currentModule);
$viewnamedesc = $oCustomView->getCustomViewByCvid($viewid);


if(isset($_REQUEST['query']) && $_REQUEST['query'] == 'true')
{
	list($where, $ustring) = explode("#@@#",getWhereCondition($currentModule));
}
elseif(isset($_SESSION['LiveViewSearch'][$currentModule]))
{
//    if($viewid==$_SESSION['LiveViewSearch'][$currentModule][0])
//    {
        $where=$_SESSION['LiveViewSearch'][$currentModule][1];
//    }
}
//print_r($_SESSION['LiveViewSearch'][$currentModule]);
$listviewreport=new ListViewCustomReport($currentModule,$viewid,$oCustomView,$where);

$showinreport=true;
$reportfun=$_REQUEST['reportfun'];
$modulename=$currentModule;
$reportfile="modules/{$modulename}/Reports/$reportfun.php";
if(is_file($reportfile))
{
    include($reportfile);
}
?>
