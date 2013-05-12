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
require_once('modules/SalesOrder/SalesOrder.php');
require_once('user_privileges/seqprefix_config.php');

// Account is used to store ec_salesorder information.
class ImportSalesorder extends SalesOrder {
	 var $db;

	// This is the list of ec_fields that are required.
	var $required_fields =  array("subject"=>1);

	// This is the list of the functions to run when importing
	var $special_functions =  array();

	var $importable_fields = Array();

	/**   function used to set the assigned_user_id value in the column_fields when we map the username during import
         */
	function assign_user()
	{
		global $current_user;
		$ass_user = $this->column_fields["assigned_user_id"];
		if( $ass_user != $current_user->id)
		{
			$result = $this->db->query("select id from ec_users where user_name = '".$ass_user."'");
			if($this->db->num_rows($result) == 0)
			{
				$this->column_fields["assigned_user_id"] = $current_user->id;
			}
			else
			{

				$row = $this->db->fetchByAssoc($result, -1, false);
				if (isset($row['id']) && $row['id'] != -1)
        	    {
					$this->column_fields["assigned_user_id"] = $row['id'];
				}
				else
				{
					$this->column_fields["assigned_user_id"] = $current_user->id;
				}
			}
		}
	}


	/** Constructor which will set the importable_fields as $this->importable_fields[$key]=1 in this object where key is the fieldname in the field table
	 */
	function ImportSalesorder() {

		$this->log = LoggerManager::getLogger('import_salesorder');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("SalesOrder");
		foreach($colf as $key=>$value)
			$this->importable_fields[$key]=1;
	}

	function ClearColumnFields() {

		$this->log = LoggerManager::getLogger('import_salesorder');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("SalesOrder");
		foreach($colf as $key=>$value)
			$this->column_fields[$key]='';
	}

	function isExist()
	{
		$this->log->info("Entering into isExist function");
		if(!isset($_SESSION['import_overwrite']) || $_SESSION['import_overwrite'] != 1) {
			$where_clause = "and ec_salesorder.oid='".trim($this->column_fields['oid'])."'";
			$query = "SELECT ec_salesorder.salesorderid FROM ec_salesorder where deleted=0 $where_clause";
			$result = $this->db->query($query, false, "Retrieving record $where_clause");
			if ($this->db->getRowCount($result) > 0) {
				return true;
			}
		}
		$this->log->info("Exit isExist function");
		return false;
	}


	function save($module) {
		$this->log->info("begin salesorder save function");

		$queryacc = "select accountid from ec_account where deleted=0 and  membername='".trim($this->column_fields['buyer_nick'])."'";
		$resultacc =& $this->db->query($queryacc, false, "Retrieving record");
		if ($this->db->getRowCount($resultacc ) >= 1) {
			$this->log->info("account get function");
			$this->column_fields['account_id'] = $this->db->query_result($resultacc,0,"accountid");
		}else{
			$this->column_fields['account_id'] = '';
		}
		
		
		$salesorderid = '';

		if(isset($_SESSION['import_overwrite1']) && $_SESSION['import_overwrite1'] == 1) {
		$this->log->info("salesorder save function(import_overwrite)");
			if(!empty($this->column_fields['subject'])) {
				$where_clause = "and ec_salesorder.subject='".trim($this->column_fields['subject'])."'";
				$query = "SELECT ec_salesorder.salesorderid FROM ec_salesorder where deleted=0 $where_clause";

				$result =& $this->db->query($query, false, "Retrieving record $where_clause");
				if ($this->db->getRowCount($result ) >= 1) {
					/*$this->log->info("salesorder save function(import_overwrite update)");
					$salesorderid = $this->db->query_result($result,0,"salesorderid");
					$this->id = $salesorderid;
					$this->mode = 'edit';
					//CRMEntity::save($module);
					$this->SaveSalesOrder($salesorderid,$this->column_fields);*/
					return "3";
				} else {
					$this->log->info("salesorder save function(import_overwrite insert)");
					$this->id = "";
					$this->mode = '';
					//CRMEntity::save($module);
					$eof = $this->SaveSalesOrder($salesorderid,$this->column_fields);
					if($eof){
						return "1";
				  	}else{
						return "2";
				  	}
				}
			}
		} else {
			$this->log->info("salesorder save function(no import_overwrite)");
			$this->id = "";
			$this->mode = '';
			//CRMEntity::save($module);
			$eof = $this->SaveSalesOrder($salesorderid,$this->column_fields);
			if($eof){
				return "1";
			}else{
				return "2";
			}
		}
		$this->ClearColumnFields();

		$this->log->info("end salesorder save function");
	}

	function SaveSalesOrder($salesorderid,$column_fields){
		global $current_user;
		global $salesorder_seqprefix;
		$datetime = date("Y-m-d H:i:s");
		$column_fields['assigned_user_id'] = $current_user->id;
		$fieldkeys='';
		$fieldvals='';
		$keyvals ='';
		$index=0;
		
		$column_fields['accountid'] = $column_fields['account_id'];
		$column_fields['smcreatorid'] = $current_user->id;
		$column_fields['modifiedtime'] = $datetime;
		$column_fields['smownerid'] = $current_user->id;
		
		
		foreach($column_fields as $key=>$val){
			if($key == 'assigned_user_id' || $key == 'buyer_nick' || $key == 'account_id'){
				continue;
			}
			
			if($index == 0){
					$fieldkeys .=$key;
					$fieldvals .="'".$val."'";
			}else{
					$fieldkeys .=','.$key;
					$fieldvals .=",'".$val."'";
			  }
			$index++;
		}
	
		if($fieldkeys !=''){
			$soid = $this->db->getUniqueID("ec_crmentity");
			
			$insertsql = "insert into ec_salesorder(salesorderid,{$fieldkeys}) values(".$soid.",{$fieldvals})"; 
			$eof = $this->db->query($insertsql); 
			
			
			$updatesql_acc = "update ec_account set ordernum=ordernum+1,ordertotal=ordertotal+".$column_fields['total'].",lastorderdate='".$column_fields['createdtime']."'  where accountid= '".$column_fields['accountid']."' ";
			$this->db->query($updatesql_acc);
		}
		if($eof){
			return true;
		  }else{
			return false;
		  }
			
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
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''") {
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
		      $this->db->query($sql1);
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
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''") {
					  $column .= ", ".$columname;
					  $value .= ", '".$fldvalue."'";
				  }
			  }
		  }

		  $sql1 = "insert into ".$table_name." (".$column.",smcreatorid,smownerid,createdtime,modifiedtime) values(".$value.",'".$current_user->id."','".$current_user->id."',NOW(),NOW())";
		  $this->db->query($sql1);
	  }
	  $log->debug("Exiting function insertIntoEntityTable()");
	}



	function saveentity($module)
	{
		global $current_user;
		$insertion_mode = $this->mode;
		$this->db->println("TRANS saveentity starts $module");
		$this->db->startTransaction();
		foreach($this->tab_name as $table_name)
		{
			if($table_name == "ec_crmentity")
			{
				$this->insertIntoCrmEntity($module);
			}
			else
			{
				$this->insertIntoEntityTable($table_name, $module);
			}
		}
		$this->db->completeTransaction();
		$this->db->println("TRANS saveentity ends");
	}

}



?>
