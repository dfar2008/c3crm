<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Maillisttmps/ModuleConfig.php');

// Note is used to store customer information.
class Maillisttmps extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_maillisttmps');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_maillisttmps'=>'maillisttmpsid');
	var $entity_table = "ec_maillisttmps";

	var $column_fields = Array();

	var $sortby_fields = Array('maillisttmpname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(
				'Maillisttmp Name'=>Array('maillisttmps'=>'maillisttmpname'),
		        'Assigned To'=>Array('crmentity'=>'smownerid')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'Maillisttmp Name'=>'maillisttmpname',
		            'Assigned To'=>'assigned_user_id'
				     );
	var $required_fields =  array("maillisttmpname"=>1);
	var $list_link_field= 'maillisttmpname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(
					'Maillisttmp Name'=>Array('maillisttmps'=>'maillisttmpname'),
					'Assigned To'=>Array('crmentity'=>'smownerid')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
					'Maillisttmp Name'=>'maillisttmpname',
		            'Assigned To'=>'assigned_user_id'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Maillisttmps() {
		$this->log = LoggerManager::getLogger('maillisttmps');
		$this->log->debug("Entering Maillisttmps() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Maillisttmps');
		$this->log->debug("Exiting Maillisttmps method ...");
	}

	function save_module($module)
	{
		global $module_enable_product;
		if(isset($module_enable_product) && $module_enable_product && $_REQUEST['action'] != 'MaillisttmpsAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW')
		{
			//$this->saveProductDetails(true); update product qty
			$this->saveProductDetails();

		}
	}


	/**
	 *      This function is used to add the ec_attachments. This will call the function uploadAndSaveFile which will upload the attachment into the server and save that attachment information in the database.
	 *      @param int $id  - entity id to which the ec_files to be uploaded
	 *      @param string $module  - the current module name
	*/
	function insertIntoAttachment($id,$module)
	{
		global $log;
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");

		$file_saved = false;

		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$file_saved = $this->uploadAndSaveFile($id,$module,$files);
			}
		}

		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}

	function getListQuery($where,$isSearchAll=false){
		global $current_user;

		$query = "SELECT ec_maillisttmps.maillisttmpsid as crmid,ec_users.user_name,
		ec_maillisttmps.* FROM ec_maillisttmps
		LEFT JOIN ec_users
			ON ec_users.id = ec_maillisttmps.smownerid ";
		$query .= " WHERE ec_maillisttmps.deleted = 0 and ec_maillisttmps.smownerid='".$current_user->id."' ";
		$query = $query.$where;
		return $query;
	}

	

	//get next salesorder id
	function get_next_id() {
		//$query = "select count(*) as num from ec_maillisttmps";
		//$result = $this->db->query($query);
		//$num = $this->db->query_result($result,0,'num') + 1;
		$num = $this->db->getUniqueID("ec_maillisttmps");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

	/**	Function used to get the sort order for Maillisttmps listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['MAILLISTTMPS_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	 */
	function getSortOrder()
	{
		global $log;
        $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['MAILLISTTMPS_SORT_ORDER'])?($_SESSION['MAILLISTTMPS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for MAILLISTTMPS listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['MAILLISTTMPS_ORDER_BY'] if this session value is empty then default order by will be returned.
	 */
	function getOrderBy()
	{
		global $log;
        $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['MAILLISTTMPS_ORDER_BY'])?($_SESSION['MAILLISTTMPS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}
}
?>
