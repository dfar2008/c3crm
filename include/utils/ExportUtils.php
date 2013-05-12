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


/**	function used to get the permitted blocks
 *	@param string $module - module name
 *	@param string $disp_view - view name, this may be create_view, edit_view or detail_view
 *	@return string $blockid_list - list of block ids within the paranthesis with comma seperated
 */
function getPermittedBlocks($module, $disp_view)
{
	global $adb, $log;
	$log->debug("Entering into the function getPermittedBlocks()");
	
        $tabid = getTabid($module);
        $block_detail = Array();
        $query="select blockid,blocklabel,show_title from ec_blocks where tabid=$tabid and $disp_view=0 and visible = 0 order by sequence";

        $result = $adb->query($query);
        $noofrows = $adb->num_rows($result);
	$blockid_list ='(';
	for($i=0; $i<$noofrows; $i++)
	{
		$blockid = $adb->query_result($result,$i,"blockid");
		if($i != 0)
			$blockid_list .= ', ';
		$blockid_list .= $blockid;
		$block_label[$blockid] = $adb->query_result($result,$i,"blocklabel");
	}
	$blockid_list .= ')';

	$log->debug("Exit from the function getPermittedBlocks($module, $disp_view). Return value = $blockid_list");
	return $blockid_list;
}

/**	function used to get the query which will list the permitted fields 
 *	@param string $module - module name
 *	@param string $disp_view - view name, this may be create_view, edit_view or detail_view
 *	@return string $sql - query to get the list of fields which are permitted to the current user
 */
function getPermittedFieldsQuery($module, $disp_view)
{
	global $adb, $log;
	$log->debug("Entering into the function getPermittedFieldsQuery()");
	//To get the permitted blocks
	$blockid_list = getPermittedBlocks($module, $disp_view);	
	$tabid = getTabid($module);
	$sql = "SELECT ec_field.columnname, ec_field.fieldlabel, ec_field.tablename FROM ec_field inner join ec_def_org_field on ec_def_org_field.fieldid=ec_field.fieldid left join ec_blocks on ec_blocks.blockid=ec_field.block WHERE ec_def_org_field.visible=0 and ec_field.tabid=".$tabid." AND ec_field.block IN $blockid_list AND ec_field.displaytype IN (1,2,4) ORDER BY ec_blocks.sequence,ec_field.sequence";
  	
	$log->debug("Exit from the function getPermittedFieldsQuery().");
	return $sql;
}

/**	function used to get the list of fields from the input query as a comma seperated string 
 *	@param string $query - field table query which contains the list of fields 
 *	@return string $fields - list of fields as a comma seperated string
 */
function getFieldsListFromQuery($query,$export_mod_strings='')
{
	global $adb, $log,$app_strings;
	$log->debug("Entering into the function getFieldsListFromQuery($query)");
	
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);

	for($i=0; $i < $num_rows;$i++)
	{
		$columnName = $adb->query_result($result,$i,"columnname");
		$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
		$tablename = $adb->query_result($result,$i,"tablename");
		//changed by dingjianting on 2007-01-07 for gloso project
		//if(!empty($export_mod_strings) && isset($export_mod_strings[$fieldlabel])) {
		//	$fieldlabel = $export_mod_strings[$fieldlabel];
		//}

		//HANDLE HERE - Mismatch fieldname-tablename in field table, in future we have to avoid these if elses
		if($columnName == 'smownerid')//for all assigned to user name
		{
			$fields .= "ec_users.user_name  as '".$fieldlabel."', ";
		}
		elseif($columnName == 'smcreatorid')//for all assigned to user name
		{
			$fields .= "ucreator.user_name  as '".$fieldlabel."', ";
		}
		elseif($tablename == 'ec_account' && $columnName == 'parentid')//Account - Member Of
		{
			 $fields .= "ec_account2.accountname as '".$fieldlabel."', ";
		}
		elseif($tablename == 'ec_contactdetails' && $columnName == 'accountid')//Contact - Account Name
		{
			$fields .= "ec_account.accountname as '".$fieldlabel."', ";
		}
		elseif($tablename == 'ec_contactdetails' && $columnName == 'reportsto')//Contact - Reports To
		{
			$fields .= " ec_contactdetails2.lastname as '".$fieldlabel."', ";
		}
		elseif($tablename == 'ec_potential' && $columnName == 'accountid')//Potential - Account Name
		{
			$fields .= "ec_account.accountname as '".$fieldlabel."',";
		}
		elseif($tablename == 'ec_potential' && $columnName == 'campaignid')//Potential - Campaign Source
		{
			$fields .= "ec_campaign.campaignname as '".$fieldlabel."',";
		}
		elseif($tablename == 'ec_seproductsrel' && $columnName == 'crmid')//Product - Related To
		{
			if($adb->isMssql()){
				$fields .= "case ec_crmentityRelatedTo.setype 
					when 'Leads' then ('Leads ::: '+ec_ProductRelatedToLead.lastname+ec_ProductRelatedToLead.firstname) 
					when 'Accounts' then ('Accounts ::: '+ec_ProductRelatedToAccount.accountname) 
					when 'Potentials' then ('Potentials ::: '+ec_ProductRelatedToPotential.potentialname) 
				    End as 'Related To',";
			} else {
				$fields .= "case ec_crmentityRelatedTo.setype 
					when 'Leads' then concat('Leads ::: ',ec_ProductRelatedToLead.lastname,' ',ec_ProductRelatedToLead.firstname) 
					when 'Accounts' then concat('Accounts ::: ',ec_ProductRelatedToAccount.accountname) 
					when 'Potentials' then concat('Potentials ::: ',ec_ProductRelatedToPotential.potentialname) 
				    End as 'Related To',";
			}
			//This will export as 3 seperate columns for each Leads, Accounts and Potentials
			//$fields .= "  case ec_crmentityRelatedTo.setype when 'Leads' then ec_ProductRelatedToLead.lastname End as 'Lead Name', case ec_crmentityRelatedTo.setype when 'Accounts' then ec_ProductRelatedToAccount.accountname End as 'Account Name', case ec_crmentityRelatedTo.setype when 'Potentials' then ec_ProductRelatedToPotential.potentialname End as 'Potential Name',";
		}
		elseif($tablename == 'ec_products' && $columnName == 'vendor_id')//Product - Vendor Name
		{
			$fields .= "ec_vendor.vendorname as '".$fieldlabel."',";
		}
		elseif($tablename == 'ec_products' && $columnName == 'catalogid')//Product - Catalog Name
		{
			$fields .= "ec_catalog.catalogname as '".$fieldlabel."',";
		}		
		elseif($tablename == 'ec_notes' && $columnName == 'contact_id')//Notes - contact_id
		{
			$fields .= " ec_contactdetails.lastname as '".$fieldlabel."',";
		}
		elseif($tablename == 'ec_notes' && $columnName == 'accountid')//Notes - account_id
		{
			$fields .= " ec_account.accountname as '".$fieldlabel."',";
		}
		
		elseif($tablename == 'ec_attachments' && $columnName == 'filename')//Emails filename
		{
			$fields .= $tablename.".name as '".$fieldlabel."',";
		}
		else
		{
			$fields .= $tablename.".".$columnName. " as '" .$fieldlabel."',";
		}
	}
	$fields = trim($fields,",");

	$log->debug("Exit from the function getFieldsListFromQuery($query). Return value = $fields");
	return $fields;
}



?>
