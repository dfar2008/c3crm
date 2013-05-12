<?php
global $currentModule;
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


$focus = new $currentModule();
$other_text = Array();
$url_string = ''; // assigning http url string
//<<<<<<<<<<<<<<<<<<< sorting - stored in session >>>>>>>>>>>>>>>>>>>>
$sorder = $focus->getSortOrder();
$order_by = $focus->getOrderBy();

$collectcolumnhtml=true;
$picklistreporthtml=true;

$listviewreport=new ListViewReport($currentModule);
$allcustomreports=$listviewreport->getAllModReportInf();
$allmodulepicklists=$listviewreport->getModulePicklists();
if($currentModule=='Products'||$currentModule=='Faq'||$currentModule == "PriceBooks"){
    if(count($allmodulepicklists)+count($allcustomreports)==0){

        $picklistreporthtml=false;
    }
}
//<<<<cutomview>>>>>>>
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

if($viewid != "0")
{
    $customviewdtls = $oCustomView->getCustomViewByCvid($viewid);
    if(empty($customviewdtls["collectcolumn"]))
    {
         $collectcolumnhtml=false;
    }
    else
    {
        $collectcolumn=$customviewdtls["collectcolumn"];
        $list = explode(":",$collectcolumn);

        $fieldlabel=trim(str_replace(array($currentModule."_","_"), " ", $list[3]));
        if(isset($mod_strings[$fieldlabel])) $fieldlabel=$mod_strings[$fieldlabel];
        elseif(isset($app_strings[$fieldlabel]))
        {
            $fieldlabel = $app_strings[$fieldlabel];
        }
        $fieldname=$list[2];
        $columnname=$list[1];
        $tablename=$list[0];
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
        $list_query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,$currentModule);
    //    echo $list_query;
        $list_sum_query = $oCustomView->getModifiedCollectListQuery($viewid,$listquery,$currentModule,$customviewdtls,2);
    //   echo $list_sum_query;
        $sum_result=$adb->query($list_sum_query);
        $allrecordtotal=$adb->query_result($sum_result,0,$columnname."_total");
        if(empty($allrecordtotal)) $allrecordtotal=0;
        //limiting the query
        $query_order_by = "";
        if(isset($order_by) && $order_by != '')
        {
            if($order_by == 'smownerid')
            {
                $query_order_by = 'user_name';
            }
            else
            {
                $tablename = getTableNameForField($currentModule,$order_by);
                $tablename = (($tablename != '')?($tablename."."):'');
                $query_order_by =  $tablename.$order_by;
            }
        }
        //分页
        $start = $_SESSION['lvs'][$currentModule]['start'];
        if($start<=0){
           $start=1;
        }
         $limit_start_rec=($start-1)*$list_max_entries_per_page;

        $list_result = $adb->limitQuery2($list_query,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);
        $currentpagetotal=0;
		foreach($list_result as $row)
        {
            $currentpagetotal+=$row[$columnname];
        }
    }
}
else
{
    $collectcolumnhtml=false;
    $picklistreporthtml=false;
}

if($collectcolumnhtml){
?>
 <table border=0 cellspacing=0 cellpadding=0 width=100% class="lvt small" >
     <tr>
	 <td colspan="3" valign="middle" width=100%>
	 <table>
	     <tr>
	     <td valign="middle"><img src="themes/images/count.gif" width="15" height="15" border=0></td>
         <td valign="middle"><span style="font-size:12px;"><b>本次查询汇总结果</b></span></td>
		 </tr>
	 </table>
     </tr>
    <tr bgcolor="white">
        <td align="right" width="30%"><?php echo  $fieldlabel ?>&nbsp;&nbsp;</td>
        <td align="left" width="35%">本页汇总：<?php echo $currentpagetotal?></td>
        <td align="left" width="35%">所有汇总：<?php echo $allrecordtotal?></td>
    </tr>

</table>
<?php
}
if($picklistreporthtml)
{
?>
<table cellspacing="0" cellpadding="0" border="0" class="lvt small" style="margin-top: 0px;" width="100%">
    <tbody><tr>
	  <td valign="middle">
	  <table>
	     <tr>
	     <td valign="middle"><a onclick="ToggleGroupContent('Gsub2','Gimg2')" href="###"><img id="Gimg2" src="themes/images/collapse.gif"   border=0><b><span style="font-size:12px;">本次查询统计报表</span></b></a></td>
		 </tr>
	 </table>
	 </td>
    </tr>
  </tbody>
</table>
<div id="Gsub2" style="display:none;">
<table cellspacing="0" cellpadding="0" border="0" class="lvt small" style="margin-top: 0px;" width="100%">
 <tbody>
   <tr bgcolor="white">
      <td valign="top" style="line-height: 26px;">
<?php
$urlstr1="";
foreach($_REQUEST as $key=>$value)
{
    if($key!='module'&&$key!='action'&&$key!='file'&&$key!='ajax'&&$key!='parenttab')
    {
        $urlstr1.="&$key=$value";
    }

}
foreach($allmodulepicklists as $picklistfield)
{
    $picklistfieldlabel=$picklistfield[0];
    $picklistfieldname=$picklistfield[1];
    $picklistfieldtablename=$picklistfield[2];
    $picklistfieldcolname=$picklistfield[3];

    $reportparams="pickfieldname=$picklistfieldname&pickfieldtable=$picklistfieldtablename&pickfieldcolname=$picklistfieldcolname";
?>
●<a style="color: rgb(153, 102, 51);" href="javascript:openListViewReport('index.php?module=ListViewReport&action=Popup_ListView&grouptype=count&<?php echo $reportparams;?>','<?php echo $urlstr1;?>');"><?php echo $picklistfieldlabel; ?>分布统计</a>　
<?php
}
if($currentModule!='Products'&&$currentModule!='Faq'&&$currentModule != "PriceBooks"){
$reportparams="pickfieldname=assign_user_id&pickfieldtable=ec_users&pickfieldcolname=user_name";
?>
<?php
}
if(is_array($allcustomreports))
{
    foreach($allcustomreports as $customreportinf)
    {
        //$fieldinf=$focus->$reportfun(false);
        $reporttype=$customreportinf[0][1];
        if($reporttype==1)
        {
            $actionname='Popup_ListView';
            $labelsuffix='分布统计';
        }else{
            $actionname='Popup_CustomListView';
            $labelsuffix='';
        }
        $fieldinf=$customreportinf[1];
        $reportfun=$customreportinf[2];
        $picklistfield=$fieldinf[1];
        $picklistfieldlabel=$picklistfield[0];
        $picklistfieldname=$picklistfield[1];
        $picklistfieldtablename=$picklistfield[2];
        $picklistfieldcolname=$picklistfield[3];

        $reportparams="iscustomreport=true&reportfun={$reportfun}";
?>
●<a style="color: rgb(153, 102, 51);" href="javascript:openListViewReport('index.php?module=ListViewReport&action=<?php echo $actionname;?>&grouptype=count&<?php echo $reportparams;?>','<?php echo $urlstr1;?>');"><?php echo $picklistfieldlabel.$labelsuffix; ?></a>
<?php

    }
}
?>
      </td>
    </tr>

  </tbody></table>
  </div>

<?php
}
?>