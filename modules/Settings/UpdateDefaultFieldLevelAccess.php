<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');
global $adb;
$field_module = getDefaultFieldModuleList();
foreach($field_module as $fld_module)
{
	$fieldListResult = getDefOrgFieldList($fld_module);
	$noofrows = $adb->num_rows($fieldListResult);
	$tab_id = getTabid($fld_module);
	for($i=0; $i<$noofrows; $i++)
	{
		$fieldid =  $adb->query_result($fieldListResult,$i,"fieldid");
		$visible = $_REQUEST[$fieldid];
		if($visible == 'on')
		{
			$visible_value = 0;
		}
		else
		{
			$visible_value = 1;
		}
		//Updating the Mandatory ec_fields
		$uitype = $adb->query_result($fieldListResult,$i,"uitype");
		if($uitype == 2 || $uitype == 6 || $uitype == 22 || $uitype == 73 || $uitype == 24 || $uitype == 81 || $uitype == 50 || $uitype == 23 || $uitype == 16 || $uitype == 20)
		{
			$visible_value = 0; 
		}
		//Updating the database
		$update_query = "update ec_def_org_field set visible=".$visible_value." where fieldid='".$fieldid."' and tabid=".$tab_id;
		$adb->query($update_query);

	}
}
$loc = "index.php?action=DefaultFieldPermissions&module=Settings&parenttab=Settings&fld_module=".$_REQUEST['fld_module'];
redirect($loc);

?>
