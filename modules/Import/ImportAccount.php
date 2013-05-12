<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header$
 * Description:  Defines the Account SugarBean Account entity with the necessary
 * methods and variables.
 ********************************************************************************/

include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Notes/Notes.php');
require_once('modules/Accounts/Accounts.php');

// Account is used to store ec_account information.
class ImportAccount extends Accounts {
	 var $db;

	// This is the list of ec_fields that are required.
	var $required_fields =  array("accountname"=>1);

	// This is the list of the functions to run when importing
	var $special_functions =  array();

	var $importable_fields = Array();

	/**   function used to set the assigned_user_id value in the column_fields when we map the username during import
         */
	function assign_user()
	{
		global $current_user;
		$this->column_fields["assigned_user_id"] = $current_user->id;
//		$ass_user = $this->column_fields["assigned_user_id"];
//		if( $ass_user != $current_user->id)
//		{
//			$result = $this->db->query("select id from ec_users where user_name = '".$ass_user."'");
//			if($this->db->num_rows($result) == 0)
//			{
//				$this->column_fields["assigned_user_id"] = $current_user->id;
//			}
//			else
//			{
//
//				$row = $this->db->fetchByAssoc($result, -1, false);
//				if (isset($row['id']) && $row['id'] != -1)
//        	    {
//					$this->column_fields["assigned_user_id"] = $row['id'];
//				}
//				else
//				{
//					$this->column_fields["assigned_user_id"] = $current_user->id;
//				}
//			}
//		}
	}


	/** Constructor which will set the importable_fields as $this->importable_fields[$key]=1 in this object where key is the fieldname in the field table
	 */
	function ImportAccount() {

		$this->log = LoggerManager::getLogger('import_account');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Accounts");
		foreach($colf as $key=>$value)
			//$this->importable_fields[$key]=1;
			$this->column_fields[$key]='';
	}
	function ClearColumnFields() {

		$this->log = LoggerManager::getLogger('import_account');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Accounts");
		foreach($colf as $key=>$value)
			//$this->importable_fields[$key]=1;
			$this->column_fields[$key]='';
	}


	function isExist()
	{
		$this->log->info("Entering into isExist function");
		if(!isset($_SESSION['import_overwrite']) || $_SESSION['import_overwrite'] != 1) {
			$where_clause = "and ec_account.membername='".trim($this->column_fields['membername'])."'";
			$query = "SELECT ec_account.accountid FROM ec_account where deleted=0 $where_clause";
			$result = $this->db->query($query, false, "Retrieving record $where_clause");
			if ($this->db->getRowCount($result) > 0) {
				return true;
			}
		}
		$this->log->info("Exit isExist function");
		return false;
	}


	function save($module) {
		
		global $current_user;
		$this->log->info("begin account save function");
		$this->log->info("account save function(import_overwrite)");
		if(!empty($this->column_fields['accountname'])) {
			$where_clause = "and ec_account.smownerid='".$current_user->id."' and ec_account.accountname='".trim($this->column_fields['accountname'])."'";
			$query = "SELECT ec_account.accountid FROM ec_account where deleted=0  $where_clause";
			$result = $this->db->query($query, false, "Retrieving record $where_clause"); 
			if ($this->db->getRowCount($result) >= 1) { 
				/*$this->log->info("account save function(import_overwrite update)");
				$accountid = $this->db->query_result($result,0,"accountid");
				$this->id = $accountid;
				$this->mode = 'edit';
				$eof = $this->saveentity($module);
				 $this->ClearColumnFields();
				 if($eof){
					return "3";
				  }else{
					return "4";
				  }*/
				 return "3";
			} else {
				$this->log->info("account save function(import_overwrite insert)");
				$this->id = "";
				$this->mode = '';
				$eof = $this->saveentity($module);
				 $this->ClearColumnFields();
				 if($eof){
					return "1";
				  }else{
					return "2";
				  }
			}
		}

		$this->log->info("end account save function");
	}



	function insertIntoEntityTable($table_name, $module)
	{
	  global $log;
  	  global $current_user;
	  $log->debug("Entering into function insertIntoEntityTable()");

      if(isset($this->column_fields['createdtime']) && $this->column_fields['createdtime'] != "") {
			$createdtime = getDisplayDate_WithTime($this->column_fields['createdtime']);
		} else {
			$createdtime = date('YmdHis');
		}
		if(isset($this->column_fields['modifiedtime']) && $this->column_fields['modifiedtime'] != "") {
			$modifiedtime = getDisplayDate_WithTime($this->column_fields['modifiedtime']);
		} else {
			$modifiedtime = date('YmdHis');
		}
		if(isset($this->column_fields['assigned_user_id']) && $this->column_fields['assigned_user_id'] != '') {
			$ownerid = $this->column_fields['assigned_user_id'];
		} else {
			$ownerid = $current_user->id;
		}
       $this->column_fields['assigned_user_id']=$ownerid;
	  $key = "import_columnnames_".$module."_".$table_name;
	  $importColumns = getSqlCacheData($key);
	  if(!$importColumns) {
		  $importColumns = array();
		  $tabid= getTabid($module);
		  $sql = "select fieldname,columnname from ec_field where tabid=".$tabid." and tablename='".$table_name."' and displaytype in (1,3,4)";
		  $result = $this->db->query($sql);
		  $noofrows = $this->db->num_rows($result);
		  for($i=0; $i<$noofrows; $i++)
		  {
			  $fieldname=$this->db->query_result($result,$i,"fieldname");
			  $columname=$this->db->query_result($result,$i,"columnname");
			  $importColumns[$fieldname] = $columname;
		  }
		  setSqlCacheData($key,$importColumns);
	  }
	  if($this->mode == 'edit') {
		  $update = "";
		  $iCount = 0;
		  foreach($importColumns as $fieldname=>$columname) {
			  if(isset($this->column_fields[$fieldname]))
			  {
				  $fldvalue = trim($this->column_fields[$fieldname]);
				  $fldvalue = stripslashes($fldvalue);
				  //$fldvalue = $this->db->formatString($table_name,$columname,$fldvalue);
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''"&&$columname != "smcreatorid"&&$columname != "smownerid") {
					  if($iCount == 0)
					  {
						  $update = $columname."='".$fldvalue."'";
						  $iCount =1;
					  }
					  else
					  {
						  $update .= ', '.$columname."='".$fldvalue."'";
					  }
				  }
			  }
		  }
		  if(trim($update) != '')
          {
		      $sql1 = "update ".$table_name." set modifiedby='".$current_user->id."',modifiedtime=NOW(),".$update." where ".$this->tab_name_index[$table_name]."=".$this->id;
		      $eof = $this->db->query($sql1);
		  }

	  } else {
		  $column = $this->tab_name_index[$table_name];
	      $value = $this->id;
		  foreach($importColumns as $fieldname=>$columname) {
			  if(isset($this->column_fields[$fieldname]))
			  {
				  $fldvalue = trim($this->column_fields[$fieldname]);
				  $fldvalue = stripslashes($fldvalue);
				  //$fldvalue = $this->db->formatString($table_name,$columname,$fldvalue);
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''"&&$columname != "smcreatorid"&&$columname != "smownerid") {
					  $column .= ", ".$columname;
					  $value .= ", '".$fldvalue."'";
				  }
			  }
		  }

		  $sql1 = "insert into ".$table_name." (".$column.",smcreatorid,smownerid,createdtime,modifiedtime) values(".$value.",'".$current_user->id."','".$current_user->id."',NOW(),NOW())";
		  $eof = $this->db->query($sql1);
	  }
	  if($eof){
		return true;
	  }else{
		return false;
	  }
	  $log->debug("Exiting function insertIntoEntityTable()");
	}



	function saveentity($module)
	{	
		global $log;
		$log->debug("Enterint into function saveentity");
		global $current_user;
		$insertion_mode = $this->mode;
		foreach($this->tab_name as $table_name)
		{
			if($table_name == "ec_crmentity")
			{
				$this->insertIntoCrmEntity($module);
			}
			else
			{
				$eof = $this->insertIntoEntityTable($table_name, $module);
			}
		}
			
		 if($eof){
			return true;
		  }else{
			return false;
		  }
		$log->debug("Exiting function saveentity");
	}

}



?>
