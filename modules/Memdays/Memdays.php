<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('modules/Memdays/ModuleConfig.php');

// Note is used to store customer information.
class Memdays extends CRMEntity {
	var $log;
	var $db;

	var $tab_name = Array('ec_crmentity','ec_memdays');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_memdays'=>'memdaysid');
	var $entity_table = "ec_memdays";

	var $column_fields = Array();

	var $sortby_fields = Array('memdayname');

	// This is the list of ec_fields that are in the lists.
	/* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $list_fields = Array(		        
				'Memday Name'=>Array('memdays'=>'memdayname'),
				'纪念日类型'=>Array('memdays'=>'memday938'),
				'日历'=>Array('memdays'=>'memday1004'),
				'纪念日'=>Array('memdays'=>'memday940'),
				'下次提醒'=>Array('memdays'=>'memday946'),
		       // 'Assigned To'=>Array('crmentity'=>'smownerid')
				);
	/* Format: Field Label => fieldname */
	var $list_fields_name = Array(
					'Memday Name'=>'memdayname',
					'纪念日类型'=>'memday938',
					'日历'=>'memday1004',
					'纪念日'=>'memday940',
					'下次提醒'=>'memday946',
		            //'Assigned To'=>'assigned_user_id'
				     );
	var $required_fields =  array("memdayname"=>1);
	var $list_link_field= 'memdayname';
    /* Format: Field Label => Array(tablename, columnname) */
	// tablename should not have prefix 'ec_'
	var $search_fields = Array(
		'Memday Name'=>Array('memdays'=>'memdayname'),
		'纪念日类型'=>Array('memdays'=>'memday938'),
		'日历'=>Array('memdays'=>'memday1004'),
		'纪念日'=>Array('memdays'=>'memday940'),
		'下次提醒'=>Array('memdays'=>'memday946'),
		//'Assigned To'=>Array('crmentity'=>'smownerid')
		);
	/* Format: Field Label => fieldname */
	var $search_fields_name = Array(
		'Memday Name'=>'memdayname',
		'纪念日类型'=>'memday938',
		'日历'=>'memday1004',
		'纪念日'=>'memday940',
		'下次提醒'=>'memday946',
		//'Assigned To'=>'assigned_user_id'
		);
	//added for import and export function
	var $special_functions =  array("create_user","add_create_account");
	var $importable_fields = Array();

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';
	var $is_custom_module = true;

	function Memdays() {
		$this->log = LoggerManager::getLogger('memdays');
		$this->log->debug("Entering Memdays() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Memdays');
		$this->log->debug("Exiting Memdays method ...");
	}

	function save_module($module)
	{
		global $module_enable_product,$adb;
		if(isset($module_enable_product) && $module_enable_product && $_REQUEST['action'] != 'MemdaysAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW')
		{			
			//$this->saveProductDetails(true); update product qty
			$this->saveProductDetails();
		}

		$nowyear = date("Y");$nowmonth = date("m");
		$nowday = date("d");$nowdate = date("Y-m-d");
		
		if($this->column_fields['memday1004'] == '公历'){
			$datestr = $this->column_fields["memday940"];
			$datearr = explode(" ",$datestr);
			$year = $datearr[0]+0;
			$month = $datearr[1]+0;
			$days = $datearr[2]+0;
			if($month > $nowmonth){
				$lastdate = sprintf("%d-%02d-%02d",$nowyear,$month,$days);
			}else if($month < $nowmonth){
				$nowyear += 1;
				$lastdate = sprintf("%d-%02d-%02d",$nowyear,$month,$days);
			}else if($days >= $nowday){
				$lastdate = sprintf("%d-%02d-%02d",$nowyear,$month,$days);
			}else{
				$nowyear += 1;
				$lastdate = sprintf("%d-%02d-%02d",$nowyear,$month,$days);
			}
		}else{//农历
			$montharr = array("正月"=>"1","二月"=>"2","三月"=>"3","四月"=>"4","五月"=>"5",
							"六月"=>"6","七月"=>"7","八月"=>"8","九月"=>"9","十月"=>"10",
								"十一月"=>"11","腊月"=>"12");
			$daysarr = Array("初一"=>"1","初二"=>"2","初三"=>"3","初四"=>"4","初五"=>"5",
								"初六"=>"6","初七"=>"7","初八"=>"8","初九"=>"9","初十"=>"10",
								"十一"=>"11","十二"=>"12","十三"=>"13","十四"=>"14","十五"=>"15",
								"十六"=>"16","十七"=>"17","十八"=>"18","十九"=>"19","二十"=>"20",
								"二十一"=>"21","二十二"=>"22","二十三"=>"23","二十四"=>"24","二十五"=>"25",
								"二十六"=>"26","二十七"=>"27","二十八"=>"28","二十九"=>"29","三十"=>"30");
			$datestr = $this->column_fields["memday940"];
			$datearr = explode(" ",$datestr);
			$yearval = $datearr[0]+0;
			$monthval = $montharr[$datearr[1]];
			$daysval = $daysarr[$datearr[2]];
			require_once('modules/Memdays/Lunar.php');
			$lunar = new Lunar();
			//先计算去年
			$yeardate = sprintf("%d-%02d-%02d",($nowyear-1),$monthval,$daysval);
			$gl = $lunar->L2S($yeardate);
			$gldate = date("Y-m-d",$gl);
			if($gldate > $nowdate){
				$lastdate = $gldate;
			}else{
				$yeardate = sprintf("%d-%02d-%02d",$nowyear,$monthval,$daysval);
				$gl = $lunar->L2S($yeardate);
				$gldate = date("Y-m-d",$gl);
				$year = date("Y",$gl);
				$month = date("m",$gl);
				$days = date("d",$gl);
				$gldate = sprintf("%d-%02d-%02d",$year,$month,$days);
				if($year > $nowyear){
					$lastdate = $gldate;
				}else if($month > $nowmonth){
					$lastdate = $gldate;
				}else if($month < $nowmonth){
					$nowyear += 1;
					$lastdate = sprintf("%d-%02d-%02d",$nowyear,$month,$days);
				}else if($days > $nowday){
					$lastdate = $gldate;
				}else{
					$nowyear += 1;
					$lastdate = sprintf("%d-%02d-%02d",$nowyear,$month,$days);
				}
			}
		}
		$query = "update ec_memdays set memday946 = '{$lastdate}' where memdaysid = {$this->id} ";
		$adb->query($query);
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
		$module = "Memdays";		
		$query = "SELECT ec_memdays.memdaysid as crmid,ec_users.user_name,			
		ec_memdays.* FROM ec_memdays
		LEFT JOIN ec_users
			ON ec_users.id = ec_memdays.smownerid ";
		$query .= " left join ec_account ON ec_memdays.accountid=ec_account.accountid  ";
		$query .= " WHERE ec_memdays.deleted = 0 and ec_users.id='".$current_user->id."' ";
		$query .= $where;
		return $query;
	}

	

	//get next salesorder id
	function get_next_id() {
		//$query = "select count(*) as num from ec_memdays";
		//$result = $this->db->query($query);		
		//$num = $this->db->query_result($result,0,'num') + 1;
		$num = $this->db->getUniqueID("ec_memdays");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

	/**	Function used to get the sort order for Memdays listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['MEMDAYS_SORT_ORDER'] if this session value is empty then default sort order will be returned. 
	 */
	function getSortOrder()
	{
		global $log;
        $log->debug("Entering getSortOrder() method ...");	
		if(isset($_REQUEST['sorder'])) 
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['MEMDAYS_SORT_ORDER'])?($_SESSION['MEMDAYS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for MEMDAYS listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['MEMDAYS_ORDER_BY'] if this session value is empty then default order by will be returned. 
	 */
	function getOrderBy()
	{
		global $log;
        $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['MEMDAYS_ORDER_BY'])?($_SESSION['MEMDAYS_ORDER_BY']):($this->default_order_by));
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
			$result = $this->db->query("select id from ec_users where user_name = '".$ass_user."'");
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

	/**   
	function used to set the assigned_user_id value in the column_fields when we map the username during import
    */
	function create_user()
	{
		global $current_user;
		$ass_user = $this->column_fields["smcreatorid"];		
		if( $ass_user != $current_user->id)
		{
			$result = $this->db->query("select id from ec_users where user_name = '".$ass_user."'");
			if($this->db->num_rows($result) != 1)
			{
				$this->column_fields["smcreatorid"] = $current_user->id;
			}
			else
			{
			
				$row = $this->db->fetchByAssoc($result, -1, false);
				if (isset($row['id']) && $row['id'] != -1)
        	    {
					$this->column_fields["smcreatorid"] = $row['id'];
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
		$where_clause = "and ec_memdays.memdayname like '%".trim($this->column_fields['memdayname'])."%'"; 
		$query = "SELECT * FROM ec_memdays  where deleted=0 $where_clause"; 
		$result = $this->db->query($query, false, "Retrieving record $where_clause"); 
		if ($this->db->getRowCount($result) > 0) {
			return true;
		}
		*/
		return false;
	}
	/**
	 * 修改下次提醒时间
	 */
	function setLastdate(){
		global $adb,$log;
		$log->debug("Entering setLastdate() method ...");
		$query = "select memdaysid,memday940,memday1004,memday946 from ec_memdays 
					where deleted = 0 and memday946 < '{$nowdate}' ";
		$result = $adb->getList($query);
			$nowyear = date("Y");$nowmonth = date("m");
			$nowday = date("d");$nowdate = date("Y-m-d");
			foreach($result as $row)
			{
				$memdaysid = $row["memdaysid"];
				$dateval = $row["memday940"];
				$calendar = $row["memday1004"];
				$lastval = $row["memday946"];
				if($calendar == '公历'){
					$datearr = explode("-",$lastval);
					$year = $datearr[0]+0;
					$month = $datearr[1]+0;
					$days = $datearr[2]+0;
					$lastdate = sprintf("%d-%02d-%02d",($year+1),$month,$days);
				}else{
					$montharr = array("正月"=>"1","二月"=>"2","三月"=>"3","四月"=>"4","五月"=>"5",
							"六月"=>"6","七月"=>"7","八月"=>"8","九月"=>"9","十月"=>"10",
								"十一月"=>"11","腊月"=>"12");
					$daysarr = Array("初一"=>"1","初二"=>"2","初三"=>"3","初四"=>"4","初五"=>"5",
										"初六"=>"6","初七"=>"7","初八"=>"8","初九"=>"9","初十"=>"10",
										"十一"=>"11","十二"=>"12","十三"=>"13","十四"=>"14","十五"=>"15",
										"十六"=>"16","十七"=>"17","十八"=>"18","十九"=>"19","二十"=>"20",
										"二十一"=>"21","二十二"=>"22","二十三"=>"23","二十四"=>"24","二十五"=>"25",
										"二十六"=>"26","二十七"=>"27","二十八"=>"28","二十九"=>"29","三十"=>"30");
					$lastdatearr = explode(" ",$lastval);
					$year = $lastdatearr[0]+0;
					$datearr = explode(" ",$dateval);
					$monthval = $montharr[$datearr[1]];
					$daysval = $daysarr[$datearr[2]];
					require_once('modules/Memdays/Lunar.php');
					$lunar = new Lunar();
					//今年
					$yeardate = sprintf("%d-%02d-%02d",$year,$monthval,$daysval);
					$gl = $lunar->L2S($yeardate);
					$lastdate = date("Y-m-d",$gl);
					if($lastdate < $nowdate){
						$yeardate = sprintf("%d-%02d-%02d",($year+1),$monthval,$daysval);
						$gl = $lunar->L2S($yeardate);
						$lastdate = date("Y-m-d",$gl);
					}
				}
				$upquery = "update ec_memdays set memday946 = '{$lastdate}' where memdaysid = {$memdaysid} ";
				$adb->query($upquery);
			}
		$log->debug("Exiting setLastdate method ...");
	}

}
?>
