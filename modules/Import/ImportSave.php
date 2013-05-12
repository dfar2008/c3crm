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

$count = 0;
$skip_required_count = 0;

/**	function used to save the records into database
 *	@param array $rows - array of total rows of the csv file
 *	@param array $rows1 - rows to be saved
 *	@param object $focus - object of the corresponding import module
 *	@param int $ret_field_count - total number of fields(columns) available in the csv file
 *	@param int $col_pos_to_field - field position in the mapped array
 *	@param int $start - starting row count value to import
 *	@param int $recordcount - count of records to be import ie., number of records to import
 *	@param string $module - import module
 *	@param int $totalnoofrows - total number of rows available
 *	@param int $skip_required_count - number of records skipped
 	This function will redirect to the ImportStep3 if the available records is greater than the record count (ie., number of records import in a single loop) otherwise (total records less than 500) then it will be redirected to import step last
 */
function InsertImportRecords($rows,$rows1,$focus,$ret_field_count,$col_pos_to_field,$start,$recordcount,$module,$totalnoofrows,$skip_required_count)
{
	global $current_user;
	global $adb,$log;
	$log->debug("Entering into function InsertImportRecords()");
	// MWC ** Getting ec_users
	$temp = get_user_array(false);
	foreach ($temp as $key=>$data) {
		$my_users[$data] = $key;
	}


	if($start == 0)
	{
		$_SESSION['totalrows'] = $rows;
		$_SESSION['return_field_count'] = $ret_field_count;
		$_SESSION['column_position_to_field'] = $col_pos_to_field;
	}
	$ii = $start;
	// go thru each row, process and save()
	foreach ($rows1 as $row)
	{
		global $mod_strings;
		$do_save = 1;
		$my_userid = $current_user->id;

		for($field_count = 0; $field_count < $ret_field_count; $field_count++)
		{
			if ( isset( $col_pos_to_field[$field_count]) )
			{
				//if (! isset( $row[$field_count]) )
				//{
				//	continue;
				//}

				// TODO: add check for user input
				// addslashes, striptags, etc..
				$field = $col_pos_to_field[$field_count];
				if (substr(trim($field), 0, 3) == "CF_") 
				{
					$resCustFldArray[$field] = $row[$field_count]; 
				}
				elseif ( $field == "assignedto" || $field == "assigned_user_id" )
				{
					$focus->column_fields[$field] = $my_users[$row[$field_count]];	
				}
				else
				{
					$focus->column_fields[$field] = $row[$field_count];
				}
				
			}

		}
		foreach ($focus->required_fields as $field=>$notused) 
		{ 
			$fv = $focus->column_fields[$field];
			if (!isset($fv) || $fv == '') 
			{
				$do_save = 0; 
				$skip_required_count++;
				addSkippedRows($row);
				break; 
			}
		}
		if($do_save && method_exists($focus,"isExist") && $focus->isExist())
		{
			$do_save = 0; 
			$skip_required_count ++;
			addSkippedRows($row);
		}
		if ($do_save)
		{
			if (!isset($focus->column_fields["assigned_user_id"]) || $focus->column_fields["assigned_user_id"]=='')
			{
				$focus->column_fields["assigned_user_id"] = $my_userid;
			}
			$focus->process_special_fields();
		
			$focus->save($module);
			if(empty($focus->id)) {
				$skip_required_count ++;
				addSkippedRows($row);
			} else {
				$return_id = $focus->id;
				$count++;
			}
		}
	$ii++;	
	}

	$_REQUEST['count'] = $ii;
	if(isset($_REQUEST['module']))
		$modulename = $_REQUEST['module'];

	$end = $start+$recordcount;
	$START = $start + $recordcount;
	$RECORDCOUNT = $recordcount;

	if($end >= $totalnoofrows)
	{
		$module = 'Import';//$_REQUEST['module'];
		$action = 'ImportSteplast';
		//exit;
		$imported_records = $ii - $skip_required_count;
		if($imported_records == $ii)
			$skip_required_count = 0;
		 $message= urlencode("<br>" .$mod_strings['LBL_SUCCESS_1']."  $imported_records" ."<br><br>" .$mod_strings['LBL_SKIPPED_1']."  $skip_required_count " );
	}
	else
	{
		$module = 'Import';
		$action = 'ImportStep3';
	}
?>

<script>
setTimeout("b()",1000);
function b()
{
	document.location.href="index.php?action=<?php echo $action?>&module=<?php echo $module?>&modulename=<?php echo $modulename?>&startval=<?php echo $end?>&recordcount=<?php echo $RECORDCOUNT?>&noofrows=<?php echo $totalnoofrows?>&message=<?php echo $message?>&skipped_record_count=<?php echo $skip_required_count?>&parenttab=<?php echo $_SESSION['import_parenttab']?>";
}
</script>

<?php
$_SESSION['import_display_message'] = '<br>'.$start.' to '.$end.' of '.$totalnoofrows.' are imported successfully';
//return $_SESSION['import_display_message'];
$log->debug("Exiting function InsertImportRecords()");
}

function addSkippedRows($row)
{
	$skipped_rows = array();
	if(isset($_SESSION['skipped_rows_in_excel']) && $_SESSION['skipped_rows_in_excel'] != "")
	{
		$skipped_rows = $_SESSION['skipped_rows_in_excel'];
	}
	array_push($skipped_rows,$row);
	$_SESSION['skipped_rows_in_excel'] = $skipped_rows;
}
?>