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
require_once('modules/Accounts/Accounts.php');
require_once('modules/Products/Products.php');
require_once('user_privileges/seqprefix_config.php');

class ImportProduct extends Products {
	 var $db;
	 

	// This is the list of the functions to run when importing
	var $special_functions =  array("catalog","add_create_vendor");

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

	/**	function used to create or map with existing vendor if the product has mapped with an vendor during import
	 */
	function add_create_vendor()
    {

		global $imported_ids;
        global $current_user;

		$vendor_name = trim($this->column_fields['vendor_id']);

		if ((! isset($vendor_name) || $vendor_name == '') )
		{
			return;
		}

        $arr = array();

		// check if it already exists
        $focus = new Vendors();

		$query = '';

		// if user is defining the ec_vendor id to be associated with this contact..

		//Modified to remove the spaces at first and last in ec_account name -- after 4.2 patch 2
		$vendor_name = trim(addslashes($vendor_name));

		//Modified the query to get the available vendor only ie., which is not deleted
		$query = "select * from ec_vendor WHERE vendorname like '%{$vendor_name}%' and deleted=0";
		$result = $this->db->query($query);
		$row = $this->db->fetchByAssoc($result, -1, false);
		// we found a row with that id
		if (isset($row['vendorid']) && $row['vendorid'] != -1)
		{
			$focus->id = $row['vendorid'];
		}

		// if we didnt find the ec_account, so create it
		if (! isset($focus->id) || $focus->id == '')
		{
			$focus->column_fields['vendorname'] = $vendor_name;
			$focus->column_fields['assigned_user_id'] = $current_user->id;
			$focus->column_fields['modified_user_id'] = $current_user->id;
			$focus->save("Vendors");
			$vendor_id = $focus->id;
			// avoid duplicate mappings:
			if (!isset( $imported_ids[$vendor_id]) )
			{
				$imported_ids[$vendor_id] = 1;
			}
		}
		// now just link the ec_vendor
        $this->column_fields["vendor_id"] = $focus->id;

    }
	/**
	  *function used to set the catalog value in the column_fields when we map the catalogname during import
    */
	function catalog()
	{
		$catalogid = $this->column_fields["catalogid"];
		$result = $this->db->query("select catalogid from ec_catalog where catalogname='".$catalogid."'");
		if($this->db->num_rows($result) > 0)
		{
			$row = $this->db->fetchByAssoc($result, -1, false);
			$this->column_fields["catalogid"] = $row['catalogid'];
		} else {
			$this->column_fields["catalogid"] = "";
		}
	}

	/** Constructor which will set the importable_fields as $this->importable_fields[$key]=1 in this object where key is the fieldname in the field table
	 */
	function ImportProduct() {

		$this->log = LoggerManager::getLogger('import_product');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Products");
		foreach($colf as $key=>$value)
			$this->importable_fields[$key]=1;
	}
	function ClearColumnFields() {

		$this->log = LoggerManager::getLogger('import_product');
		$this->db = & getSingleDBInstance();
		$colf = getColumnFields("Products");
		foreach($colf as $key=>$value)
			$this->column_fields[$key]='';
	}

	function save($module) {
		global $app_strings;
		global $product_seqprefix;
		 
		if($this->column_fields['productcode'] == $app_strings["AUTO_GEN_CODE"] || $this->column_fields['productcode'] =='') {
			$this->column_fields['productcode'] = $product_seqprefix.$this->get_next_id();
		}
		
		if(isset($_SESSION['import_overwrite2']) && $_SESSION['import_overwrite2'] == 1) {
			if(!empty($this->column_fields['productname'])) {
				$where_clause = " and ec_products.productname='".trim($this->column_fields['productname'])."' ";
				$query = "SELECT ec_products.productid FROM ec_products where ec_products.deleted=0 $where_clause";
				$result =& $this->db->query($query, false, "Retrieving record $where_clause");
				if ($this->db->getRowCount($result ) >= 1) {
					/*$productid = $this->db->query_result($result,0,"productid");
					$this->id = $productid;
					$this->mode = 'edit';
					$this->saveentity($module);*/
					return "3";
				}else {
					$this->id = "";
					$this->mode = '';
					$eof = $this->saveentity($module);
					if($eof){
						return "1";
					 }else{
						return "2";
					}
				}
			}
		} else {
			$this->id = "";
			$this->mode = '';
			$eof = $this->saveentity($module);
			if($eof){
				return "1";
			 }else{
				return "2";
			}
		}
		$this->ClearColumnFields();
	}

	function saveInventPro(){
		$subject=$this->column_fields['subject'];
		$productname=$this->column_fields['productname'];
		$listprice=$this->column_fields['listprice'];
		$quantity=$this->column_fields['quantity'];
		$comment=$this->column_fields['comment'];
		
		$salesorderid ='';
		$where_clause = "and ec_salesorder.subject='".trim($subject)."'";
		$query = "SELECT ec_salesorder.salesorderid FROM ec_salesorder where deleted=0 $where_clause";
		$result =& $this->db->query($query, false, "Retrieving record $where_clause");
		if ($this->db->getRowCount($result ) >= 1) {
			$salesorderid = $this->db->query_result($result,0,"salesorderid");
		}

		$productid='';
		$where_clause2 = "and ec_products.productname='".trim($productname)."'";
		$query2 = "SELECT ec_products.productid FROM ec_products where deleted=0 $where_clause2";
		$result2 =& $this->db->query($query2, false, "Retrieving record $where_clause2");
		if ($this->db->getRowCount($result2 ) >= 1) {
			$productid = $this->db->query_result($result2,0,"productid");
		}


		if($salesorderid !='' && $productid !=''){
			
			$this->db->query("delete from ec_inventoryproductrel where id=".$salesorderid." ");
			$insertsql = "insert into ec_inventoryproductrel(id,productid,quantity,listprice,comment) " .
					"values(".$salesorderid.",".$productid.",'".$listprice."','".$quantity."','".$comment."')";
			$eof =  $this->db->query($insertsql);
			
		}

		$this->column_fields['subject']='';
		$this->column_fields['productname']='';
		$this->column_fields['listprice']='';
		$this->column_fields['quantity']='';
		$this->column_fields['comment']='';
		
		if($eof){
			return "1";
		  }else{
			return "2";
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
		       $eof =  $this->db->query($sql1);
		  }

	  } else {
		  $column = $this->tab_name_index[$table_name];
	      $value = $this->id;
		  
		 
		  foreach($importColumns as $fieldname=>$columname) {
			  if(isset($this->column_fields[$fieldname]))
			  {
				  $fldvalue = trim($this->column_fields[$fieldname]);
				  $fldvalue = stripslashes($fldvalue);
				 // $fldvalue = $this->db->formatString($table_name,$columname,$fldvalue);
				  if($fldvalue != "" && $fldvalue != "NULL" && $fldvalue != "''") {
					  $column .= ", ".$columname;
					  $value .= ", '".$fldvalue."'";
				  }
			  }
		  }

		  $sql1 = "insert into ".$table_name." (".$column.",smcreatorid,smownerid,createdtime,modifiedtime) values(".$value.",'".$current_user->id."','".$current_user->id."',NOW(),NOW())"; 
		   $eof =  $this->db->query($sql1);
	  }
	  $log->debug("Exiting function insertIntoEntityTable()");
	  
	  if($eof){
		return true;
	  }else{
		return false;
	  }
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
				$eof =  $this->insertIntoEntityTable($table_name, $module);
			}
		}
		$this->db->completeTransaction();		
		$this->db->println("TRANS saveentity ends");
		 if($eof){
			return true;
		  }else{
			return false;
		  }
	}

}
?>
