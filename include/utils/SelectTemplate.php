<?php
if(!isset($_REQUEST['templatefile']) || empty($_REQUEST['templatefile'])) {
	require_once('include/CRMSmarty.php');
	global $app_strings;
	global $mod_strings;
	global $theme;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$smarty = new CRMSmarty();
	$smarty->assign("APP", $app_strings);
	$smarty->assign("IMAGE_PATH", $image_path);
	$smarty->assign("THEME_PATH", $theme_path);
    if(isset($_REQUEST['record']) && $_REQUEST['record'] != "") $record = $_REQUEST['record'];
    $fld_module = $_REQUEST['module'];
	$tabid = getTabid($fld_module);
	$printArray = array();
	$result = $adb->query("select * from ec_modulelist  where type='template' and tabid='".$tabid."'");
	$num_rows = $adb->num_rows($result);
	if($num_rows <= 1) {
		$filename = $adb->query_result($result,0,'filename');
		$url = "index.php?module=".$fld_module."&action=CreatePDFPrint&record=".$record."&templatefile=".$filename;
		redirect($url);
	} else {
		for($i=0; $i<$num_rows; $i++)
		{
			$filename = $adb->query_result($result,$i,'filename');
			$filememo = $adb->query_result($result,$i,'filememo');
			if($filememo == "") $filememo = $app_strings["LBL_DEFAULT"];
			$printArray[$filename] = $filememo;				 
		}
	}
    $moduleOtions = get_select_options($printArray,$app_strings["LBL_DEFAULT"]);
	$smarty->assign('TEMPLATEOPTION',$moduleOtions);
	$smarty->assign('MODULE',$fld_module);
	$smarty->assign('RECORD',$record);
	$smarty->display("SelectTemplate.tpl");
	die();


} else {
	$templatefile = $_REQUEST['templatefile'];
}
?>