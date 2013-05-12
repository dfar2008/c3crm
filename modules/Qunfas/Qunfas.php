<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Qunfas/ModuleConfig.php');

// Note is used to store customer information.
class Qunfas extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_qunfas');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_qunfas'=>'qunfasid');
	var $entity_table = "ec_qunfas";

	var $column_fields = Array();

	var $sortby_fields = Array('qunfaname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(
				'编号'=>Array('qunfas'=>'qunfaname'),
		        '发送日期'=>Array('qunfas'=>'createdtime'),
		        '群发短信内容' =>Array('qunfas'=>'msg')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'编号'=>'qunfaname',
					'发送日期'=>'createdtime',
					'群发短信内容' =>'msg'
				     );
	var $required_fields =  array("qunfaname"=>1);
	var $list_link_field= 'qunfaname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(
					'编号'=>Array('qunfas'=>'qunfaname'),
					'Assigned To'=>Array('crmentity'=>'smownerid')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
					'编号'=>'qunfaname',
		            'Assigned To'=>'assigned_user_id'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Qunfas() {
		$this->log = LoggerManager::getLogger('qunfas');
		$this->log->debug("Entering Qunfas() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Qunfas');
		$this->log->debug("Exiting Qunfas method ...");
	}

	function save_module($module)
	{
		global $module_enable_product;
		if(isset($module_enable_product) && $module_enable_product && $_REQUEST['action'] != 'QunfasAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW')
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
		$module = "Qunfas";
		
		$query = "SELECT ec_qunfas.qunfasid as crmid,ec_users.user_name,ec_qunfas.* 
				FROM ec_qunfas
				LEFT JOIN ec_users	ON ec_users.id = ec_qunfas.smownerid ";
		
		$query .= " WHERE ec_qunfas.deleted = 0 ";

		return $query;
	}


	//get next salesorder id
	function get_next_id() {
		//$query = "select count(*) as num from ec_qunfas";
		//$result = $this->db->query($query);
		//$num = $this->db->query_result($result,0,'num') + 1;
		$num = $this->db->getUniqueID("ec_qunfas");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}
	/**	Function used to get the sort order for Qunfas listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['QUNFAS_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	 */
	function getSortOrder()
	{
		global $log;
        $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['QUNFAS_SORT_ORDER'])?($_SESSION['QUNFAS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for QUNFAS listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['QUNFAS_ORDER_BY'] if this session value is empty then default order by will be returned.
	 */
	function getOrderBy()
	{
		global $log;
        $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['QUNFAS_ORDER_BY'])?($_SESSION['QUNFAS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}
    //
    function getQunfatmpsInfo(){
		global $current_user;
		$query = "select * from ec_qunfatmps where deleted=0 and smownerid=".$current_user->id." ";
		$result = $this->db->getList($query);
		$num_rows = $this->db->num_rows($result);
		if($num_rows > 0){
			foreach($result as $row) {
				$arr[] = array($row['qunfatmpsid'],$row['qunfatmpname'],$row['description']);
			}
			return $arr;
		}else{
			return '';
		}
    }
}
?>
