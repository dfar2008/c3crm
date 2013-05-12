<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
global $adb;
$fld_module=$_REQUEST['fld_module'];
$type=$_REQUEST['type'];
if(empty($type) || empty($fld_module))
{
    $result = " ";
    echo $result;
}
else
{
	$tabid = getTabid($fld_module);
	$query_temp = "select filename from ec_modulelist where type='template' and tabid='".$tabid."' and filememo is NULL";
	$result_temp = $adb->query($query_temp);
	$num_rows=$adb->num_rows($result_temp);
	if($num_rows > 0) {
		$defaultFilename = $adb->query_result($result_temp,0,'filename');
		$defaultTemp = $root_directory."modules/".$fld_module."/".$defaultFilename."Def.html";
		$dic=$root_directory."modules/{$type1}";
		$result=file_get_contents($defaultTemp);
		echo $result;
	}
}
?>
