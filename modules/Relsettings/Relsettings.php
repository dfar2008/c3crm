<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Relsettings/ModuleConfig.php');

// Note is used to store customer information.
class Relsettings extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_relsettings');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_relsettings'=>'relsettingsid');
	var $entity_table = "ec_relsettings";

	var $column_fields = Array();

	var $sortby_fields = Array('relsettingname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(
				'Relsetting Name'=>Array('relsettings'=>'relsettingname'),
		        'Assigned To'=>Array('crmentity'=>'smownerid')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'Relsetting Name'=>'relsettingname',
		            'Assigned To'=>'assigned_user_id'
				     );
	var $required_fields =  array("relsettingname"=>1);
	var $list_link_field= 'relsettingname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(
					'Relsetting Name'=>Array('relsettings'=>'relsettingname'),
					'Assigned To'=>Array('crmentity'=>'smownerid')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
					'Relsetting Name'=>'relsettingname',
		            'Assigned To'=>'assigned_user_id'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Relsettings() {
		$this->log = LoggerManager::getLogger('relsettings');
		$this->log->debug("Entering Relsettings() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Relsettings');
		$this->log->debug("Exiting Relsettings method ...");
	}
	
	function setMessageAccounts($order_no){
		global $current_user;
		global $adb;
		$query = "select * from ec_messageaccounttmps where order_no = '".$order_no."' ";
		$row = $adb->getFirstLine($query);
		if(!empty($row)){
			$now = date("Y-m-d H:i:s");
			$userid   = $row['userid'];
			$tc   = $row['tc'];
			$price   = $row['price'];
			$num   = $row['num'];
			$enddate   = $row['enddate'];
			$total_fee   = $row['total_fee'];

			$query2 = "select * from ec_messageaccount where userid = '".$userid."' ";
			$result = $adb->getFirstLine($query2);
			
			if(!empty($result)){
				$updatesql = "update ec_messageaccount set tc='".$tc."',price='".$price."',num='".$num."',enddate='".$enddate."',canuse='".$num."',chargenum=chargenum+1,modifiedtime='".$now."' where userid=$userid ";
			}else{
				$updatesql = "insert into ec_messageaccount(userid,tc,price,num,canuse,chargenum,createdtime,	modifiedtime,enddate) values({$userid},'".$tc."','".$price."','".$num."','".$num."','1','".$now."','".$now."','".$enddate."')";
			}
			$adb->query($updatesql );
			
			$id = $adb->getUniqueID("ec_messageaccountlogs");
			$query = "insert into ec_messageaccountlogs(id,userid,modifiedby,tc,price,num,enddate,modifiedtime,flag,order_no,total_fee) values({$id},{$userid},'".$current_user->id."','".$tc."','".$price."','".$num."','".$enddate."','".$now."',1,'".$order_no."','".$total_fee."')";
			$adb->query($query);	
		}
	}
}
?>
