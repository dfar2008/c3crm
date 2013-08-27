<?php
require_once('include/logging.php');
require_once('modules/Contacts/Contacts.php');
require_once('modules/Import/UsersLastImport.php');
require_once('include/database/PearDatabase.php');

// Contact is used to store customer information.
class ImportContact extends Contacts {
	var $db;

   // This is the list of the functions to run when importing
	var $special_functions =  array("add_create_account");
	var $importable_fields = Array();
	
	/**   function used to set the assigned_user_id value in the column_fields when we map the username during import
         */
	function assign_user()
	{
		global $current_user;
		$ass_user = $this->column_fields["assigned_user_id"];		
		if( $ass_user != $current_user->id)
		{
			$result = $this->db->query("select id from ec_users where user_name = '".$ass_user."' or last_name = '".$ass_user."'");
			if($this->db->num_rows($result) != 1)
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
	/**	function used to create or map with existing account if the contact has mapped with an account during import
	 */
	function add_create_account()
    {
		
		global $imported_ids;
        global $current_user;

		$acc_name = trim($this->column_fields['accountid']);

		if ((! isset($acc_name) || $acc_name == '') )
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
		$query = "select ec_account.* from ec_account WHERE accountname like '{$acc_name}%' 
					and ec_account.deleted=0 ORDER BY accountname ";
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
			if (!isset( $imported_ids[$acc_id]) )
			{
				$imported_ids[$acc_id] = 1;
			}
		}
		// now just link the ec_account
        $this->column_fields["account_id"] = $focus->id;

    }

		
	/** Constructor which will set the importable_fields as $this->importable_fields[$key]=1 in this object where key is the fieldname in the field table
	 */
	function ImportContact() {
		$this->log = LoggerManager::getLogger('import_contact');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Contacts");
		foreach($colf as $key=>$value)
			$this->importable_fields[$key]=1;
	}
    function ClearColumnFields() {

		$this->log = LoggerManager::getLogger('import_contact');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Contacts");
		foreach($colf as $key=>$value)
			//$this->importable_fields[$key]=1;
			$this->column_fields[$key]='';
	}

	function isExist()
	{
		$this->log->info("Entering into isExist function");
		if(!isset($_SESSION['import_overwrite']) || $_SESSION['import_overwrite'] != 1) {
			if($this->column_fields['contactemail'] != "") {
				$where_clause = "and ec_contacts.contactemail = '".$this->column_fields['contactemail']."'"; 
				$query = "SELECT ec_contacts.contactsid as crmid FROM ec_contacts where deleted=0 ".$where_clause; 
				$result = $this->db->query($query, false, "Retrieving record $where_clause"); 
				if ($this->db->getRowCount($result) > 0) {
					if(isset($_SESSION["eventrecord"]) && $_SESSION["eventrecord"] != "") {
						$crmid = $this->db->query_result($result,0,"crmid");
						require_once("modules/Ckevents/Ckevents.php");
						$focus_event = new Ckevents();
						$focus_event->save_related_module("Ckevents",$_SESSION["eventrecord"], "Contacts", $crmid);
					}
					return true;
				}
			}
		}
		return false;
	}

	function save($module) {
       // var_dump($this->column_fields);
        global $current_user;
		$this->log->info("begin contact save function");
		$this->log->info("contact save function(import_overwrite)");
		if(!empty($this->column_fields['contactemail'])) {
            $where_clause = "and ec_contacts.contactemail = '".$this->column_fields['contactemail']."'"; 
            $query = "SELECT ec_contacts.contactsid FROM ec_contacts where deleted=0  $where_clause";
            $result =& $this->db->query($query, false, "Retrieving record $where_clause"); 
            
            if ($this->db->getRowCount($result ) >= 1) {
                    return "3";
            }else{
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
				  $fldvalue = $this->db->formatString($table_name,$columname,$fldvalue);
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''") {
					  if($iCount == 0)
					  {
						  $update = $columname."=".$fldvalue."";
						  $iCount =1;
					  }
					  else
					  {
						  $update .= ', '.$columname."=".$fldvalue."";
					  }
				  }
			  }		 
		  }
		  if(trim($update) != '')
          {
		      $sql1 = "update ".$table_name." set modifiedby='".$current_user->id."',modifiedtime=".$this->db->formatDate($date_var).",".$update." where ".$this->tab_name_index[$table_name]."=".$this->id;
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
				  $fldvalue = $this->db->formatString($table_name,$columname,$fldvalue);
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''") {
					  $column .= ", ".$columname;
					  $value .= ", ".$fldvalue."";
				  }
			  }		 
		  }

		  $sql1 = "insert into ".$table_name." (".$column.",smcreatorid,createdtime,modifiedtime) values(".$value.",'".$current_user->id."',".$this->db->formatDate($createdtime).",".$this->db->formatDate($modifiedtime).")";

          //$sql1 = "insert into ".$table_name." (".$column.",createdtime,modifiedtime) values(".$value.",".$this->db->formatDate($createdtime).",".$this->db->formatDate($modifiedtime).")";
          //var_dump($sql1);
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
