<?php
//require_once('include/database/PearDatabase.php');
global $adb;
$fld_module=$_REQUEST['fld_module'];
$blockid=$_REQUEST['blockid'];
$label=$_REQUEST['label'];
$order=$_REQUEST['order'];
$parenttab=$_REQUEST['parenttab'];
$mode=$_REQUEST['mode'];
$tabid = getTabid($fld_module);

if(get_magic_quotes_gpc() == 1)
{
	$label = stripslashes($label);
}


//checking if the user is trying to create a custom ec_field which already exists  
if(!empty($blockid))
{
	$query = "select blocklabel from ec_blocks where blockid='".$blockid."'";
	$result = $adb->query($query);		
	$blocklabel_src = $adb->query_result($result,0,'blocklabel');
	if($blocklabel_src != 'LBL_CUSTOM_INFORMATION') { 
		$query = "update ec_blocks set blocklabel='".$label."',sequence=".$order." where blockid='".$blockid."'";
		$adb->query($query);
	}
}
else {
	//$new_blockid = $adb->getUniqueID("ec_blocks");
	$query = "select max(blockid) as num from ec_blocks";
	$result = $adb->query($query);		
	$new_blockid = $adb->query_result($result,0,'num') + 1;
	$query = "insert into ec_blocks values (".$new_blockid.",".$tabid.",'".$label."',".$order.",0,0,0,0,0)";
	$adb->query($query);
}
//echo $query;

echo "<script language='javascript'>";
echo "document.location.href='index.php?module=Settings&action=CustomBlockList&fld_module=".$fld_module."&parenttab=Settings"."';";
echo "</script>";
//header("Location:index.php?module=Settings&action=CustomBlockList&fld_module=".$fld_module."&parenttab=".$parenttab);
?>
