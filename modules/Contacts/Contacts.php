<?php
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Contacts/ModuleConfig.php');

// Note is used to store customer information.
class Contacts extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_contacts');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_contacts'=>'contactsid');
	var $entity_table = "ec_contacts";

	var $column_fields = Array();

	var $sortby_fields = Array('contactname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(		        
				'Contact Name'=>Array('contacts'=>'contactname'),
				'contactsex'=>Array('contacts'=>'contactsex'),
				'contacttitle'=>Array('contacts'=>'contacttitle'),
				'contactmobile'=>Array('contacts'=>'contactmobile'),
				'contactemail'=>Array('contacts'=>'contactemail'),
		        'contactqq'=>Array('crmentity'=>'contactqq')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'Contact Name'=>'contactname',
					'contactsex'=>'contactsex',
					'contacttitle'=>'contacttitle',
					'contactmobile'=>'contactmobile',
					'contactemail'=>'contactemail',
		            'contactqq'=>'contactqq'
				     );
	var $required_fields =  array("contactname"=>1);
	var $list_link_field= 'contactname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(		        
				'Contact Name'=>Array('contacts'=>'contactname'),
				'contactsex'=>Array('contacts'=>'contactsex'),
				'contacttitle'=>Array('contacts'=>'contacttitle'),
				'contactmobile'=>Array('contacts'=>'contactmobile'),
				'contactemail'=>Array('contacts'=>'contactemail'),
		        'contactqq'=>Array('crmentity'=>'contactqq')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
		            'Contact Name'=>'contactname',
					'contactsex'=>'contactsex',
					'contacttitle'=>'contacttitle',
					'contactmobile'=>'contactmobile',
					'contactemail'=>'contactemail',
		            'contactqq'=>'contactqq'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Contacts() {
		$this->log = LoggerManager::getLogger('contacts');
		$this->log->debug("Entering Contacts() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Contacts');
		$this->log->debug("Exiting Contacts method ...");
	}

	function save_module($module)
	{
		
	}

	/** Function to export the notes in CSV Format
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export Contacts Query.
	*/
	function create_export_query(&$order_by, &$where)
	{
		global $log;
		$log->debug("Entering create_export_query(".$order_by.",". $where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$module = "Contacts";
		$sql = getPermittedFieldsQuery($module, "detail_view");
		global $mod_strings;
		global $current_language;
		if(empty($mod_strings)) {
			$mod_strings = return_module_language($current_language,"Contacts");
		}
		$fields_list = $this->getFieldsListFromQuery($sql,$mod_strings);

		$query = "SELECT $fields_list FROM ec_contacts
				LEFT JOIN ec_users
					ON ec_contacts.smownerid = ec_users.id 
				LEFT JOIN ec_users as ua
					ON ec_contacts.approvedby = ua.id 
				LEFT JOIN ec_users as ucreator
					ON ec_contacts.smcreatorid = ucreator.id ";
				//LEFT JOIN ec_approvestatus ON ec_contacts.approved = ec_approvestatus.statusid ";
		$query .= " left join ec_account ON ec_contacts.accountid=ec_account.accountid  ";
		//$query .= " left join ec_contactdetails ON ec_contacts.contact_id=ec_contactdetails.contactid  ";
       // var_dump($query);
       // exit(); 2013-08-22 by ligangze
		
		$where_auto = " ec_contacts.deleted = 0 ";

		if($where != "")
			$query .= " WHERE ($where) AND ".$where_auto;
		else
			$query .= " WHERE ".$where_auto;
		
		$log->debug("Exiting create_export_query method ...");
		return $query;
	}

	/**	function used to get the list of fields from the input query as a comma seperated string 
	 *	@param string $query - field table query which contains the list of fields 
	 *	@return string $fields - list of fields as a comma seperated string
	 */
	function getFieldsListFromQuery($query,$export_mod_strings='')
	{
		global $log,$app_strings;
		$log->debug("Entering into the function getFieldsListFromQuery()");
		
		$result = $this->db->query($query);
		$num_rows = $this->db->num_rows($result);

		for($i=0; $i < $num_rows;$i++)
		{
			$columnName = $this->db->query_result($result,$i,"columnname");
			$fieldlabel = $this->db->query_result($result,$i,"fieldlabel");
			$tablename = $this->db->query_result($result,$i,"tablename");
			if(!empty($export_mod_strings) && isset($export_mod_strings[$fieldlabel])) 
			{
				$fieldlabel = $export_mod_strings[$fieldlabel];
			}
			elseif(isset($app_strings[$fieldlabel])) 
			{
				$fieldlabel = $app_strings[$fieldlabel];
			}
			if($columnName == 'smownerid')//for all assigned to user name
			{
				$fields .= "ec_users.user_name as '".$fieldlabel."', ";
			}
			elseif($columnName == 'accountid')//Account Name
			{
				$fields .= "ec_account.accountname as '".$fieldlabel."', ";
			}
			elseif($columnName == 'campaignid')//Campaign Source
			{
				$fields .= "ec_campaign.campaignname as '".$fieldlabel."',";
			}
			elseif($columnName == 'vendor_id')//Vendor Name
			{
				$fields .= "ec_vendor.vendorname as '".$fieldlabel."',";
			}
			elseif($columnName == 'vendorid')//Vendor Name
			{
				$fields .= "ec_vendor.vendorname as '".$fieldlabel."',";
			}
			elseif($columnName == 'potentialid')//Vendor Name
			{
				$fields .= "ec_potential.potentialname as '".$fieldlabel."',";
			}
			elseif($columnName == 'salesorderid')//Vendor Name
			{
				$fields .= "ec_salesorder.subject as '".$fieldlabel."',";
			}
			elseif($columnName == 'purchaseorderid')//Vendor Name
			{
				$fields .= "ec_purchaseorder.subject as '".$fieldlabel."',";
			}
			elseif($columnName == 'catalogid')//Catalog Name
			{
				$fields .= "ec_catalog.catalogname as '".$fieldlabel."',";
			}		
			elseif($columnName == 'contact_id')//contact_id
			{
				$fields .= " ec_contactdetails.lastname as '".$fieldlabel."',";
			}
			elseif($columnName == 'smcreatorid')
			{
				$fields .= "ucreator.user_name as '".$fieldlabel."',";
			}
			elseif($columnName == 'approvedby')
			{
				$fields .= "ua.user_name as '".$fieldlabel."',";
			}
			elseif($columnName == 'approved')
			{
				$fields .= "ec_approvestatus.approvestatus as '".$fieldlabel."',";
			}
			else
			{
				$query_rel = "SELECT ec_entityname.* FROM ec_entityname WHERE ec_entityname.tabid>30 and ec_entityname.entityidfield='".$columnName."'";
				$fldmod_result = $this->db->query($query_rel);
				$rownum = $this->db->num_rows($fldmod_result);
				if($rownum > 0) {
					$rel_tablename = $this->db->query_result($fldmod_result,0,'tablename');
					$rel_entityname = $this->db->query_result($fldmod_result,0,'fieldname');
					$fields .= " ".$rel_tablename.".".$rel_entityname." as '".$fieldlabel."',";
				} else {
					$fields .= $tablename.".".$columnName. " '" .$fieldlabel."',";
				}
			}
		}
		$fields = trim($fields,",");

		$log->debug("Exit from the function getFieldsListFromQuery()");
		return $fields;
	}

	function getListQuery($where,$isSearchAll=false){
		global $current_user;
		$module = "Contacts";		
		$query = "SELECT ec_contacts.contactsid as crmid,ec_users.user_name,			
		ec_contacts.* FROM ec_contacts
		LEFT JOIN ec_users
			ON ec_users.id = ec_contacts.smownerid ";
		$query .= " left join ec_account ON ec_contacts.accountid=ec_account.accountid  ";
		$query .= " WHERE ec_contacts.deleted = 0 and ec_users.id='".$current_user->id."' ";
		$query .= $where;
		return $query;
	}

	

	//get next salesorder id
	function get_next_id() {
		//$query = "select count(*) as num from ec_contacts";
		//$result = $this->db->query($query);		
		//$num = $this->db->query_result($result,0,'num') + 1;
		$num = $this->db->getUniqueID("ec_contacts");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

	

	/**	Function used to get the sort order for Contacts listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['CONTACTS_SORT_ORDER'] if this session value is empty then default sort order will be returned. 
	 */
	function getSortOrder()
	{
		global $log;
        $log->debug("Entering getSortOrder() method ...");	
		if(isset($_REQUEST['sorder'])) 
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['CONTACTS_SORT_ORDER'])?($_SESSION['CONTACTS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for CONTACTS listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['CONTACTS_ORDER_BY'] if this session value is empty then default order by will be returned. 
	 */
	function getOrderBy()
	{
		global $log;
        $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['CONTACTS_ORDER_BY'])?($_SESSION['CONTACTS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}

	/**   
	function used to set the importable fields
    */
	function initImport()
	{
		foreach($this->column_fields as $key=>$value)
			$this->importable_fields[$key]=1;
	}

	/**   
	function used to set the assigned_user_id value in the column_fields when we map the username during import
    */
	function assign_user()
	{
		global $current_user;
		$ass_user = $this->column_fields["assigned_user_id"];		
		if( $ass_user != $current_user->id)
		{
			$userid = $this->db->getOne("select id from ec_users where user_name = '".$ass_user."'");
			if(!$userid)
			{
				$this->column_fields["assigned_user_id"] = $current_user->id;
			}
			else
			{				
				if ($userid != -1)
        	    {
					$this->column_fields["assigned_user_id"] = $userid;
				}
				else
				{
					$this->column_fields["assigned_user_id"] = $current_user->id;
				}
			}
		}
	}

	/**   
	function used to set the assigned_user_id value in the column_fields when we map the username during import
    */
	function create_user()
	{
		global $current_user;
		$ass_user = $this->column_fields["smcreatorid"];		
		if( $ass_user != $current_user->id)
		{
			$userid = $this->db->getOne("select id from ec_users where user_name = '".$ass_user."'");
			if(!$userid)
			{
				$this->column_fields["smcreatorid"] = $current_user->id;
			}
			else
			{
				if ($userid != -1)
        	    {
					$this->column_fields["smcreatorid"] = $userid;
				}
				else
				{
					$this->column_fields["smcreatorid"] = $current_user->id;
				}
			}
		}
	}
    
	/**	
	function used to create or map with existing account if the contact has mapped with an account during import
	 */
	function add_create_account()
    {
		global $imported_ids;
        global $current_user;
		require_once('modules/Accounts/Accounts.php');
		$acc_name = trim($this->column_fields['account_id']);
		if ((! isset($acc_name) || $acc_name == '') )
		{
			return; 
		}
        $arr = array();
        $focus = new Accounts();
		$query = '';
		$acc_name = trim(addslashes($acc_name));
		$query = "select  ec_account.* from ec_account WHERE accountname like '%{$acc_name}%' and deleted=0";
		$result = $this->db->query($query);
		$row = $this->db->fetchByAssoc($result, -1, false);
		if (isset($row['accountid']) && $row['accountid'] != -1)
		{
			$focus->id = $row['accountid'];
		}
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
    /**
	check whether record exists during import,
	the function default as disabled
	*/
	function isExist()
	{
		/*
		$where_clause = "and ec_contacts.contactname like '%".trim($this->column_fields['contactname'])."%'"; 
		$query = "SELECT * FROM ec_contacts  where deleted=0 $where_clause"; 
		$result = $this->db->query($query, false, "Retrieving record $where_clause"); 
		if ($this->db->getRowCount($result) > 0) {
			return true;
		}
		*/
		return false;
	}

}
?>
