<?php
//require_once('include/database/PearDatabase.php');
global $adb;
$fld_module=$_REQUEST['fld_module'];
$parenttab=$_REQUEST['parenttab'];
$templatename=$_REQUEST['templatename'];
$tabid = getTabid($fld_module);


//checking if the user is trying to create a custom ec_field which already exists  
if(!empty($templatename))
{
	$query = "select * from ec_modulelist where filememo='".$templatename."'";
	$result = $adb->query($query);		
	$rownum = $adb->num_rows($result);
	if($rownum == 0) {
		$filename = $fld_module."HtmlTemplate".getEveryWordFirstSpell($templatename);
		$query = "insert into ec_modulelist(tabid,type,filename,filememo) values (".$tabid.",'template','".$filename."','".$templatename."')";
		$adb->query($query);
		$query_temp = "select filename from ec_modulelist where type='template' and tabid='".$tabid."' and filememo is NULL";
		$result_temp = $adb->query($query_temp);
		$num_rows=$adb->num_rows($result_temp);
		if($num_rows > 0) {
			$defaultFilename = $adb->query_result($result_temp,0,'filename');
			$defaultTemp = $root_directory."modules/".$fld_module."/".$defaultFilename."Def.html";
			$newTemp = $root_directory."modules/".$fld_module."/".$filename.".html";
			$filedata=file_get_contents($defaultTemp);
			$error = file_put_contents($newTemp,$filedata);
		} else {
			$defaultTemp = $root_directory."modules/".$fld_module."/".$fld_module."HtmlTemplateDef.html";
			$newTemp = $root_directory."modules/".$fld_module."/".$filename.".html";
			$filedata=file_get_contents($defaultTemp);
			$error = file_put_contents($newTemp,$filedata);
		}
	}
}

echo "<script language='javascript'>";
echo "document.location.href='index.php?module=Settings&action=PrintTemplate&fld_module=".$fld_module."&parenttab=Settings"."';";
echo "</script>";
?>
