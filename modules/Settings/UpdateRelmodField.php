<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');


$field_module = array();
$result = $adb->query("select name from ec_tab where reportable=1 order by tabid");
$num_rows = $adb->num_rows($result);
for($i=0; $i<$num_rows; $i++)
{
	$modulename = $adb->query_result($result,$i,'name');
	$field_module[] = $modulename;
		 
}

//$tab_id = getTabid($fld_module);
foreach($field_module as $fld_module)
{
    global $adb;
    global $image_path;
    $standCustFld = Array();
	$tabid = getTabid($fld_module);
    $query = "SELECT ec_field.columnname,ec_field.fieldlabel,ec_relmodfieldlist.fieldname,ec_relmodfieldlist.width,ec_relmodfieldlist.module,ec_field.fieldid,ec_field.sequence
          FROM ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid left join ec_relmodfieldlist on ec_relmodfieldlist.fieldname=ec_field.columnname and ec_relmodfieldlist.module='$fld_module'
          WHERE ec_def_org_field.visible=0 and ec_field.tabid='".$tabid."' and ec_field.uitype not in(19,69,61,30,105) union SELECT ec_field.columnname,ec_field.fieldlabel,ec_relmodfieldlist.fieldname,ec_relmodfieldlist.width,ec_relmodfieldlist.module,ec_field.fieldid,ec_field.sequence
          FROM ec_field left join ec_relmodfieldlist on ec_relmodfieldlist.fieldname=ec_field.columnname and ec_relmodfieldlist.module='$fld_module'
          WHERE ec_field.columnname='total' and ec_field.displaytype=3 and ec_field.tabid='".$tabid."' order by sequence";
    $result = $adb->query($query);
    $noofrows = $adb->num_rows($result);
    
    $delete_query ="delete from ec_relmodfieldlist where module ='".$fld_module."'" ;
    $adb->query($delete_query);


    for($i=0; $i<$noofrows; $i++)
    {
        $fieldlabel =  $adb->query_result($result,$i,"fieldlabel");
        $fieldcolumnname = $adb->query_result($result,$i,"columnname");
        $fieldid =  $adb->query_result($result,$i,"fieldid");
        $nameid = $fieldid.''.$fld_module;
        $widthid = text.''.$fieldid.''.$fld_module;
 //   echo  $widthid;
        $visible = $_REQUEST[$nameid];


  
    //echo 8989;
        if($visible == 'on')
        {
            $idwidth = $_REQUEST[$widthid];
            $idwidth = (int)($idwidth);
            $idwidth = $idwidth.''.'%';
			$id = $adb->getUniqueID("ec_relmodfieldlist");
			$insert_query = "INSERT INTO ec_relmodfieldlist (id, fieldname, module, width) VALUES ('".$id."','".$fieldcolumnname."', '".$fld_module."', '".$idwidth."')";
            $adb->query($insert_query);
        }
    }
}
$loc = "index.php?action=RelmodField&module=Settings&parenttab=Settings&fld_module=".$_REQUEST['fld_module'];
redirect($loc);
?>