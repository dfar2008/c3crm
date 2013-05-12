<?php
//require_once('include/database/PearDatabase.php');
global $adb;
$fld_module=$_REQUEST['fld_module'];
$relation_id=$_REQUEST['relation_id'];
$label=$_REQUEST['label'];
$sequence=$_REQUEST['sequence'];
if(isset($_REQUEST['presence'])) {
	$presence = 0;
} else {
	$presence = 1;
}


//checking if the user is trying to create a custom ec_field which already exists  
if(!empty($relation_id))
{   
	//label='".$label."',
	$query = "update ec_relatedlists set sequence='".$sequence."',presence='".$presence."' where relation_id='".$relation_id."'";
	$adb->query($query);
}

$url = "index.php?module=Settings&action=RelatedList&parenttab=Settings&fld_module=".$fld_module;
redirect($url);
?>
