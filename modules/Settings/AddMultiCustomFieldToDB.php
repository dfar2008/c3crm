<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('include/database/PearDatabase.php');

$fldmodule=$_REQUEST['fld_module'];
 $fldlabel=$_REQUEST['fldLabel'];
 $fldType= $_REQUEST['fieldType'];
 $parenttab=$_REQUEST['parenttab'];
 $mode=$_REQUEST['mode'];

$tabid = getTabid($fldmodule);

if(get_magic_quotes_gpc() == 1)
{
	$fldlabel = stripslashes($fldlabel);
}


//checking if the user is trying to create a custom ec_field which already exists  
if($mode != 'edit')
{
	$checkquery="select * from ec_multifield where tabid='".$tabid."'and multifieldname='".$fldlabel."'";
	$checkresult=$adb->query($checkquery);
}
else
	$checkresult=0;

if($adb->num_rows($checkresult) != 0)
{
	redirect("index.php?module=Settings&action=CustomMultiFieldList&fld_module=".$fldmodule."&parenttab=".$parenttab);
	die;

}
else
{
	$fldlength=$_REQUEST['fldLength'];
	$columnNames=array();
	for($i=0;$i<$fldlength;$i++)
	{
		$max_fieldid = $adb->getUniqueID("ec_field");
		$columnName = 'cf_'.$max_fieldid;
		$columnNames[]=$columnName;
	}
	$fieldNames = $columnNames;
  
	//Assigning the ec_table Name
	$entityArr = getEntityTable($fldmodule);
	$tableName = $entityArr["tablename"];
	//Assigning the uitype
	$uitype='';
	$fldPickList='';
	
	
	
	$uitype = 15;
	$type = "C(255)"; //adodb type
	$uiorichekdata='V~O';

	
	// No Decimal Pleaces Handling

        


        

        //1. add the customfield ec_table to the ec_field ec_table as Block4
        //2. fetch the contents of the custom ec_field and show in the UI
        
	//retreiving the sequence
	$custfld_fieldids=array();
	for($i=0;$i<$fldlength;$i++)
	{
		$custfld_fieldid=$adb->getUniqueID("ec_field");
		$custfld_fieldids[]=$custfld_fieldid;
	}

	$adb->startTransaction();
	//$custfld_sequece=$adb->getUniqueId("ec_customfield_sequence");
    	$custfld_sequeces=array();
		for($i=0;$i<$fldlength;$i++)
		{
			$custfld_sequece=$adb->getUniqueId("ec_customfield_sequence");
			$custfld_sequeces[]=$custfld_sequece;
		}
	$blockid ='';
        //get the blockid for this custom block
        $blockid = getBlockId($tabid,'LBL_CUSTOM_INFORMATION');
		

	if(is_numeric($blockid))
	{
		
		for($i=0;$i<$fldlength;$i++)
		{
			$columnName=$columnNames[$i];
			$result = $adb->alterTable($tableName, $columnName." ".$type, "Add_Column");
			if($result != 2) {
				//without error
				redirect("index.php?module=Settings&action=CustomMultiFieldList&fld_module=".$fldmodule."&parenttab=".$parenttab);
				die;
			}
		}
			
			//insert multifield table
			$multifieldid=$adb->getUniqueID("ec_multifield");
			$fieldtablename='ec_'.$columnNames[0];
			$query = "insert into ec_multifield(multifieldid,multifieldname,tablename,totallevel,tabid) values ('$multifieldid','$fldlabel','$fieldtablename','$fldlength','$tabid')";
			$adb->query($query);
		for($i=0;$i<$fldlength;$i++)
		{
				$custfld_fieldid=$custfld_fieldids[$i];
				$columnName=$columnNames[$i];
				$uitype=1021+$i;
				$fieldName=$fieldNames[$i];
				$cffldlabel=$fldlabel.$i;
				$custfld_sequece=$custfld_sequeces[$i];
                $uichekdata=$uiorichekdata."~::$multifieldid";
				$query = "insert into ec_field values(".$tabid.",".$custfld_fieldid.",'".$columnName."','".$tableName."',2,'".$uitype."','".$fieldName."','".$cffldlabel."',0,0,0,100,".$custfld_sequece.",$blockid,1,'".$uichekdata."',1,0,'BAS')";
                $adb->query($query);
			
				//Inserting values into def_org ec_tables
				$sql_def = "insert into ec_def_org_field values(".$tabid.", ".$custfld_fieldid.", 0, 1)";
				$adb->query($sql_def);
			
		}
		if($adb->isMssql()) {
			$qur = "CREATE TABLE $fieldtablename (
				actualfieldid int NOT NULL,
				actualfieldname varchar(200) NOT NULL,
				sortorderid int NOT NULL default '0',
				presence int NOT NULL default '1',
				thelevel int NOT NULL default '1',
				parentfieldid int NOT NULL default '0',
					PRIMARY KEY  (actualfieldid)
			)";
		} else {
			$qur = "CREATE TABLE $fieldtablename (
				actualfieldid int(19) NOT NULL,
				actualfieldname varchar(200) NOT NULL,
				sortorderid int(19) NOT NULL default '0',
				presence int(1) NOT NULL default '1',
				thelevel int(11) NOT NULL default '1',
				parentfieldid int(19) NOT NULL default '0',
					PRIMARY KEY  (actualfieldid)
			)";
		}
		$adb->query($qur);
	}
	$adb->completeTransaction();
	redirect("index.php?module=Settings&action=EditMultiCustomField&multifieldid={$multifieldid}&fld_module=".$fldmodule."&parenttab=".$parenttab);
}
?>
