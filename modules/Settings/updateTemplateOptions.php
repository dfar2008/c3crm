<?php
$moduleType=$_REQUEST["moduleType"];
global $adb;
$printArray = array();
$query = "select ec_modulelist.*,ec_tab.name from ec_modulelist inner join ec_tab on ec_tab.tabid=ec_modulelist.tabid where ec_modulelist.type='template' and ec_tab.name='".$moduleType."'";
$result = $adb->query($query);
//echo $query;
$num_rows = $adb->num_rows($result);
$optionsstr = "<option value=0 selected> ".$app_strings["LBL_NONE"]." </option>";
for($i=0; $i<$num_rows; $i++)
{
	$modulename = $adb->query_result($result,$i,'name');
	$template = $adb->query_result($result,$i,'filename');
	$filememo = $adb->query_result($result,$i,'filememo');
	if($filememo == "") $filememo = $app_strings["LBL_DEFAULT"];
	$temppath = $modulename.'/'.$template;
	$optionsstr .= "<option value='".$temppath."'>".$filememo."</option>";
		 
}
echo $optionsstr;
?>
