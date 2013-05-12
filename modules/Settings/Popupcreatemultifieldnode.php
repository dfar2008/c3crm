<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
require_once('include/CRMSmarty.php');
require_once('include/utils/MultiFieldUtils.php');

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty = new CRMSmarty();

$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];
//$multifieldinfo=getMultiFieldInfo($multifieldid,false);
//$tablename=$multifieldinfo["tablename"];

if(isset($_REQUEST['catalogid']) && $_REQUEST['catalogid'] != '')
{
	$fieldid= $_REQUEST['catalogid'];
	$mode = $_REQUEST['mode'];
	$fieldInfo=getFieldNodeInformation($fieldid,$multifieldid);
	
	$catalogname = $fieldInfo[0];
	$sortorderid =$fieldInfo[1];

}
elseif(isset($_REQUEST['parent']) && $_REQUEST['parent'] != '')
{
	$mode = 'create';
	$parent=$_REQUEST['parent'];
    $sortorderid =getMultiFieldPos($parent,$multifieldid);
    $sortorderid +=1;
}
//$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", $mod_strings);

//$parentname=getCatalogName($parent);
$smarty->assign("RETURN_ACTION",$_REQUEST['returnaction']);
$smarty->assign("CATALOGID",$fieldid);
$smarty->assign("MODE",$mode);
$smarty->assign("THEME",$theme_path);
$smarty->assign("PARENT",$parent);
$smarty->assign("PARENTNAME",$sortorderid);
$smarty->assign("CATALOGNAME",$catalogname);
$smarty->assign("MULTIFIELDID",$multifieldid);
$smarty->assign("LEVEL",$level);
$smarty->assign("PARENTFIELDID",$parentfieldid);

$smarty->display("Settings/EditMultiFieldNode.tpl");

?>
