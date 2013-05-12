<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Qunfatmps/ModuleConfig.php');

// Note is used to store customer information.
class Qunfatmps extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_qunfatmps');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_qunfatmps'=>'qunfatmpsid');
	var $entity_table = "ec_qunfatmps";

	var $column_fields = Array();

	var $sortby_fields = Array('qunfatmpname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(
				'Qunfatmp Name'=>Array('qunfatmps'=>'qunfatmpname'),
		        'Assigned To'=>Array('crmentity'=>'smownerid')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'Qunfatmp Name'=>'qunfatmpname',
		            'Assigned To'=>'assigned_user_id'
				     );
	var $required_fields =  array("qunfatmpname"=>1);
	var $list_link_field= 'qunfatmpname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(
					'Qunfatmp Name'=>Array('qunfatmps'=>'qunfatmpname'),
					'Assigned To'=>Array('crmentity'=>'smownerid')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
					'Qunfatmp Name'=>'qunfatmpname',
		            'Assigned To'=>'assigned_user_id'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Qunfatmps() {
		$this->log = LoggerManager::getLogger('qunfatmps');
		$this->log->debug("Entering Qunfatmps() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Qunfatmps');
		$this->log->debug("Exiting Qunfatmps method ...");
	}

	function save_module($module)
	{
		
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
		$query = "SELECT ec_qunfatmps.qunfatmpsid as crmid,ec_users.user_name,
		ec_qunfatmps.* FROM ec_qunfatmps
		LEFT JOIN ec_users
			ON ec_users.id = ec_qunfatmps.smownerid ";

		$query .= " WHERE ec_qunfatmps.deleted = 0 and ec_users.id = '".$current_user->id."'";

		$query .= $where;		
		
		return $query;
	}

	/**	Function used to get the sort order for Qunfatmps listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['QUNFATMPS_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	 */
	function getSortOrder()
	{
		global $log;
        $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['QUNFATMPS_SORT_ORDER'])?($_SESSION['QUNFATMPS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for QUNFATMPS listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['QUNFATMPS_ORDER_BY'] if this session value is empty then default order by will be returned.
	 */
	function getOrderBy()
	{
		global $log;
        $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['QUNFATMPS_ORDER_BY'])?($_SESSION['QUNFATMPS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}
}
?>
