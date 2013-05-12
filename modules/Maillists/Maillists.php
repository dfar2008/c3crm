<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Maillists/ModuleConfig.php');

// Note is used to store customer information.
class Maillists extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_maillists');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_maillists'=>'maillistsid');
	var $entity_table = "ec_maillists";

	var $column_fields = Array();

	var $sortby_fields = Array('maillistname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(
				'编号'=>Array('maillists'=>'maillistname'),
				'发件人'=>Array('maillists'=>'from_name'),
				'发送日期'=>Array('maillists'=>'createdtime'),
				'邮件主题'=>Array('maillists'=>'subject'),
				'邮件内容'=>Array('maillists'=>'mailcontent')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'编号'=>'maillistname',
		            '发件人'=>'from_name',
		            '发送日期'=>'createdtime',
					'邮件主题'=>'subject',
					'邮件内容'=>'mailcontent',
				     );
	var $required_fields =  array("maillistname"=>1);
	var $list_link_field= 'maillistname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(
					'编号'=>Array('maillists'=>'maillistname'),
					'邮件主题'=>Array('maillists'=>'subject'),
					'邮件内容'=>Array('maillists'=>'mailcontent')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
					'编号'=>'maillistname',
		            '邮件主题'=>'subject',
					'邮件内容'=>'mailcontent'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Maillists() {
		$this->log = LoggerManager::getLogger('maillists');
		$this->log->debug("Entering Maillists() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Maillists');
		$this->log->debug("Exiting Maillists method ...");
	}

	function save_module($module)
	{
		global $module_enable_product;
		if(isset($module_enable_product) && $module_enable_product && $_REQUEST['action'] != 'MaillistsAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW')
		{
			//$this->saveProductDetails(true); update product qty
			$this->saveProductDetails();

		}
	}


	function getListQuery($where,$isSearchAll=false){
		$query = "SELECT ec_maillists.maillistsid as crmid,ec_users.user_name,
			ec_maillists.* FROM ec_maillists
			LEFT JOIN ec_users
				ON ec_users.id = ec_maillists.smownerid ";
		return $query;
	}

	

	//get next salesorder id
	function get_next_id() {
		//$query = "select count(*) as num from ec_maillists";
		//$result = $this->db->query($query);
		//$num = $this->db->query_result($result,0,'num') + 1;
		$num = $this->db->getUniqueID("ec_maillists");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}
}
?>
