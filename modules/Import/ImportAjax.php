<?php


require_once('include/CRMSmarty.php');
include('modules/Import/ImportMap.php');
include('modules/Import/Forms.php');

//This is to delete the map
if($_REQUEST['delete_map'] != '')
{
	$query = "update ec_import_maps set deleted=1 where id = ".$_REQUEST['mapping'];
	$adb->query($query);
}

$mapping_file = new ImportMap();
$mapping_arr = $mapping_file->getSavedMappingContent($_REQUEST['mapping']);

$importable_fields = $_SESSION['import_module_object_column_fields'];
$field_count = $_SESSION['import_module_field_count'];
$required_fields = $_SESSION['import_module_object_required_fields'];
$translated_column_fields = $_SESSION['import_module_translated_column_fields'];

$tablename = '';
$has_header = $_SESSION['import_has_header'];
$firstrow = $_SESSION['import_firstrow'];
$field_map = &$mapping_arr;//$_SESSION['import_field_map'];
$smarty_array1 = array();

for($i=0;$i<$field_count;$i++)
{
	$suggest = '';
	if ($has_header && isset( $field_map[$firstrow[$i]] ) )
	{
		$suggest = $field_map[$firstrow[$i]];
	}
	else if (isset($field_map[$i]))
	{
		$suggest = $field_map[$i];
	}

	$smarty_array1[$i+1] = getFieldSelect(	$importable_fields,
                                                $i,
                                                $required_fields,
                                                $suggest,
                                                $translated_column_fields,
                                                $tablename
                                              );
}

$smarty =  new CRMSmarty;
$smarty->assign("FIRSTROW",$firstrow);
$smarty->assign("SELECTFIELD",$smarty_array1);

$smarty->display('ImportMap.tpl');



?>
