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
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Contacts/Contacts.php');
require_once('modules/Potentials/Potentials.php');
require_once('modules/Notes/Notes.php');
require_once('modules/Accounts/Accounts.php');
require_once('modules/Notes/Notes.php');


class ImportNote extends Notes {
	 var $db;

	// This is the list of the functions to run when importing
	var $special_functions =  array("add_create_contact","add_create_account");
	var $required_fields =  array("notes_title"=>1);

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
			if($this->db->num_rows($result)!=1)
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
	/**	function used to create or map with existing contact if the notes has mapped with an contact during import
	 */
	function add_create_contact()
    {
		
		global $imported_ids;
        global $current_user;
		$contact_name = $this->column_fields['contact_id'];
		if ((! isset($contact_name) || $contact_name == '') )
		{
			return; 
		}

        $arr = array();
		// check if it already exists
        $focus = new Contacts();
		$query = '';
		// if user is defining the ec_contact id to be associated with this contact..

		//Modified to remove the spaces at first and last in ec_contactdetails name -- after 4.2 patch 2
		$contact_name = trim(addslashes($contact_name));

		//Modified the query to get the available account only ie., which is not deleted
		$query = "select * from ec_contactdetails WHERE lastname='{$contact_name}' and deleted=0";
        $result = $this->db->query($query);

        $row = $this->db->fetchByAssoc($result, -1, false);
		// we found a row with that id
        if (isset($row['contactid']) && $row['contactid'] != -1)
        {
			$focus->id = $row['contactid'];
        }

		// if we didnt find the ec_contactdetails, so create it
        if (! isset($focus->id) || $focus->id == '')
        {
			//$this->db->println("Createing new ec_account");
			$focus->column_fields['lastname'] = $contact_name;
			$focus->column_fields['assigned_user_id'] = $current_user->id;
			$focus->column_fields['modified_user_id'] = $current_user->id;
			$focus->save("Contacts");
			$contact_id = $focus->id;

			// avoid duplicate mappings:
			if (! isset( $imported_ids[$contact_id]) )
			{
				$imported_ids[$acc_id] = 1;
			}
        }

		// now just link the ec_contactdetails
        $this->column_fields["contact_id"] = $focus->id;

    }

	/**	function used to create or map with existing account if the contact has mapped with an account during import
	 */
	function add_create_account()
    {
		
		global $imported_ids;
        global $current_user;
		$acc_name = $this->column_fields['account_id'];
		if ((!isset($acc_name) || $acc_name == '') )
		{
			return; 
		}
        $arr = array();
		// check if it already exists
        $focus = new Accounts();
		$query = '';
		// if user is defining the ec_account id to be associated with this contact..

		//Modified to remove the spaces at first and last in ec_account name -- after 4.2 patch 2
		$acc_name = trim(addslashes($acc_name));
		//Modified the query to get the available account only ie., which is not deleted
		$query = "select * from ec_account WHERE accountname like '%{$acc_name}%' and deleted=0";
        $result = $this->db->query($query);
        $row = $this->db->fetchByAssoc($result, -1, false);
		// we found a row with that id
		if (isset($row['accountid']) && $row['accountid'] != -1)
		{
			$focus->id = $row['accountid'];
		}
		// if we didnt find the ec_account, so create it
		if (! isset($focus->id) || $focus->id == '')
		{
				$focus->column_fields['accountname'] = $acc_name;
				$focus->column_fields['assigned_user_id'] = $current_user->id;
				$focus->column_fields['modified_user_id'] = $current_user->id;
				$focus->save("Accounts");
				$acc_id = $focus->id;
				// avoid duplicate mappings:
				if (! isset( $imported_ids[$acc_id]) )
				{
					$imported_ids[$acc_id] = 1;
				}
		}
		// now just link the ec_account
        $this->column_fields["account_id"] = $focus->id;
    }

	/** Constructor which will set the importable_fields as $this->importable_fields[$key]=1 in this object where key is the fieldname in the field table
	 */
	function ImportNote() {
		
		$this->log = LoggerManager::getLogger('import_notes');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Notes");
		foreach($colf as $key=>$value)
			$this->importable_fields[$key]=1;
	}

	function save($module) { 
		$this->id = ""; 
		$this->mode = ''; 
		CRMEntity::save($module);
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

		  $sql1 = "insert into ".$table_name." (".$column.",smcreatorid,createdtime,modifiedtime) values(".$value.",'".$current_user->id."',NOW(),NOW())";
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
