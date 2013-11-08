<?php
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');

// Account is used to store ec_account information.
class Accounts extends CRMEntity {
	var $log;
	var $db;

    var $entity_table = "ec_account";
	var $tab_name = Array('ec_crmentity','ec_account');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_account'=>'accountid');


	var $column_fields = Array();

	var $sortby_fields = Array('accountname','city','website','phone','smownerid');


	// This is the list of ec_fields that are in the lists.
	var $list_fields = Array(
			'Account Name'=>Array('ec_account'=>'accountname'),
			'MemberName'=>Array('ec_account'=>'membername'),
			'Phone'=>Array('ec_account'=> 'phone'),
			'Email'=>Array('ec_account'=>'email')
			);

	var $list_fields_name = Array(
			'Account Name'=>'accountname',
			'MemberName'=>'membername',
			'Phone'=>'phone',
			'Email'=>'email'
			);
	var $list_link_field= 'accountname';

	var $search_fields = Array(
			'Account Name'=>Array('ec_account'=>'accountname'),
			'MemberName'=>Array('ec_account'=>'membername'),
		    'Phone'=>Array('ec_account'=> 'phone'),
		    'Email'=>Array('ec_account'=>'email')
			);

	var $search_fields_name = Array(
			'Account Name'=>'accountname',
			'MemberName'=>'membername',
            'Phone'=>'phone',
		    'Email'=>'email'
			);


	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';

	function Accounts() {
		$this->log =LoggerManager::getLogger('account');
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Accounts');
	}

	/** Function to handle module specific operations when saving a entity
	*/
	function save_module($module)
	{
		if($this->column_fields['accountname'] != "")
		{
            //ALTER TABLE `ec_account` CHANGE `prefix` `prefix` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL
			$prefixa = getEveryWordFirstSpell($this->column_fields['accountname']);
			$query = "update ec_account set prefix='".$prefixa."' where accountid='".$this->id."'";
		    $this->db->query($query);
		}
	}


	// Mike Crowe Mod --------------------------------------------------------Default ordering for us
	/**
	 * Function to get sort order
 	 * return string  $sorder    - sortorder string either 'ASC' or 'DESC'
	 */
	function getSortOrder()
	{
		global $log;
                $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = ((isset($_SESSION['ACCOUNTS_SORT_ORDER']) && $_SESSION['ACCOUNTS_SORT_ORDER'] != '')?($_SESSION['ACCOUNTS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}
	/**
	 * Function to get order by
	 * return string  $order_by    - fieldname(eg: 'accountname')
 	 */
	function getOrderBy()
	{
		global $log;
                $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = ((isset($_SESSION['ACCOUNTS_ORDER_BY']) && $_SESSION['ACCOUNTS_ORDER_BY'] != '')?($_SESSION['ACCOUNTS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}

	function get_opportunities($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_opportunities(".$id.") method ...");
		global $mod_strings;

		$focus = new Potentials();
		$button = '';


		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT ec_potential.*,ec_users.user_name,ec_potential.potentialid as crmid FROM ec_potential
			LEFT join ec_moduleentityrel
					ON ec_moduleentityrel.crmid = ec_potential.potentialid
			LEFT JOIN ec_users
				ON ec_potential.smownerid = ec_users.id
			WHERE ec_potential.deleted = 0
			AND (ec_potential.accountid = '".$id."' or ec_moduleentityrel.relcrmid='".$id."')";
		$log->debug("Exiting get_opportunities method ...");

		return GetRelatedList('Accounts','Potentials',$focus,$query,$button,$returnset);
	}

	

	/**
	 * Function to get Account related Attachments
 	 * @param  integer   $id      - accountid
 	 * returns related Attachment record in array format
 	 */
	function get_notes_old($id)
	{
		global $log,$singlepane_view;
        $log->debug("Entering get_notes(".$id.") method ...");
		require_once('modules/Notes/Notes.php');
		$focus = new Notes();
		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT ec_notes.*,ec_account.accountname,ec_users.user_name,ec_notes.notesid as crmid
			FROM ec_notes
			LEFT JOIN ec_account
				ON ec_account.accountid = ec_notes.accountid
			LEFT JOIN ec_users
				ON ec_notes.smownerid = ec_users.id
			WHERE ec_account.accountid = ".$id."
			AND ec_notes.deleted = 0 ";

		$log->debug("Exiting get_notes method ...");
		return GetRelatedList('Accounts','Notes',$focus,$query,$button,$returnset);
	}
	
	function get_notes($id)
	{
		global $log,$singlepane_view;
		global $adb;
        $log->debug("Entering get_notes(".$id.") method ...");
		$query = "SELECT ec_notes.*,ec_account.accountname,ec_users.user_name,ec_notes.notesid as crmid
			FROM ec_notes
			LEFT JOIN ec_account
				ON ec_account.accountid = ec_notes.accountid
			LEFT JOIN ec_users
				ON ec_notes.smownerid = ec_users.id
			WHERE ec_account.accountid = ".$id."
			AND ec_notes.deleted = 0 order by ec_notes.modifiedtime desc";

		$list_result = $adb->getList($query);
		$num_rows = $adb->num_rows($list_result);

 
 		$header = array();
		$header[] = "主题";
		$header[] = "联系类型";
		$header[] = "记录时间";
		$header[] = "下次联系日期";
		$header[] = "客户状态";
		$header[] = "内容";
		$header[] = "编辑|删除";
		if($num_rows && $num_rows > 0){
			$row_i = 1;
			foreach($list_result as $row){
				$entries = Array();
                //changed by ligangze on 2013-09-29
				$entries[] = '<a href="index.php?module=Notes&action=DetailView&record='.$row['notesid'].'&parenttab=Customer">'
                            .$row['title'].'</a>';
				$entries[] = $row['notetype'];
				$entries[] = $row['modifiedtime'];
				$entries[] = getDisplayDate($row['contact_date']);
				$entries[] = $row['rating'];
				$entries[] = msubstr1($row['notecontent'],0,50);
                $url = 'index.php?module=Notes&action=PopupEditView&record='.$row['notesid'].'&return_module=Accounts&return_action=CallRelatedList&return_id='.$id.'&parenttab=Customer';
				$entries[] = '<a href="#" onclick="editAccountRelInfo(\''.$url.'\')" title="编辑"> &nbsp;<i class="cus-pencil"></i> </a>|<a href=\'javascript:confirmdelete("index.php?module=Notes&action=Delete&record='.$row['notesid'].'&return_module=Accounts&return_action=CallRelatedList&return_id='.$id.'&parenttab=Customer&return_viewname=0")\'> <img src="themes/bootcss/img/del.gif" border=0 title="删除"></a>';
				$entries_list[] = $entries;
				$row_i ++;
			}
		}
		if($num_rows>0){
			$return_data = array('header'=>$header,'entries'=>$entries_list);
			$log->debug("Exiting get_notes method ...");
			return $return_data; 
		}
	}
	

	/**
	* Function to get Account related SalesOrder
	* @param  integer   $id      - accountid
	* returns related SalesOrder record in array format
	*/
	function get_salesorder($id)
	{
		global $log, $singlepane_view;
        $log->debug("Entering get_salesorder(".$id.") method ...");
		require_once('modules/SalesOrder/SalesOrder.php');
		global $app_strings;

		$focus = new SalesOrder();

		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT ec_salesorder.*,ec_salesorder.salesorderid as crmid,
			ec_account.accountname,
			ec_users.user_name
			FROM ec_salesorder
			LEFT JOIN ec_account
				ON ec_account.accountid = ec_salesorder.accountid
			LEFT JOIN ec_users
				ON ec_salesorder.smownerid = ec_users.id
			WHERE ec_salesorder.deleted = 0
			AND ec_salesorder.accountid = ".$id;
		$log->debug("Exiting get_salesorder method ...");
		return GetRelatedList('Accounts','SalesOrder',$focus,$query,$button,$returnset);
	}
	
	/**
	* Function to get Account related Products
	* @param  integer   $id      - accountid
	* returns related Products record in array format
	*/
	function get_products($id)
	{
		global $log, $singlepane_view;
        $log->debug("Entering get_products(".$id.") method ...");
		global $app_strings;
		global $current_user;
		global $adb;
		$query = "select ec_salesorder.subject,ec_salesorder.orderdate,ec_salesorder.total,ec_salesorder.salesorderid,ec_products.productcode,ec_products.productid,
		ec_products.productname,ec_inventoryproductrel.quantity as salesum,ec_inventoryproductrel.listprice as price,ec_products.detail_url from ec_products
		inner join ec_inventoryproductrel on ec_inventoryproductrel.productid = ec_products.productid 
		inner join ec_salesorder on ec_salesorder.salesorderid = ec_inventoryproductrel.id where ec_salesorder.accountid = ".$id." and ec_salesorder.deleted=0 order by ec_salesorder.salesorderid asc"; 

		$list_result = $adb->getList($query);
		$num_rows = $adb->num_rows($list_result);

		$header = array();
		$header[] = "订单编号";
		$header[] = "订单日期";
		$header[] = "订单总额";
		$header[] = "产品编号";
		$header[] = "产品名称";
		$header[] = "购买数量";
		$header[] = "价格";
        $header[] = "小计";//added by ligangze 2013-08-12
		$header[] = "商品URL";
		if($num_rows && $num_rows > 0){
			$row_i = 1;
			foreach($list_result as $row){
				$entries = Array();
				$entries[] = "<a href='index.php?action=DetailView&module=SalesOrder&record=".$row['salesorderid']."' target='_blank'>".$row['subject']."</a>";
				$entries[] = $row['orderdate'];
				$entries[] = $row['total'];
				$entries[] = "<a href='index.php?action=DetailView&module=Products&record=".$row['productid']."' target='_blank'>".$row['productcode']."</a>";
				$entries[] =  "<a href='index.php?action=DetailView&module=Products&record=".$row['productid']."' target='_blank'>".$row['productname']."</a>";
				$entries[] = $row['salesum'];
				$entries[] = $row['price'];
                $entries[] = number_format($row['salesum']*$row['price'],"2",".",",");//added by ligangze 2013-08-12
				$entries[] = "<a href='".$row['detail_url']."' target='_blank'>".$row['detail_url']."</a>";
				$entries_list[] = $entries;
				$row_i ++;
			}
		}
		if($num_rows>0){
			$return_data = array('header'=>$header,'entries'=>$entries_list);
			$log->debug("Exiting get_products method ...");
			return $return_data; 
		}
	}

	/**
	* Function to get Account related Products
	* @param  integer   $id      - accountid
	* returns related Products record in array format
	*/
	function get_soproducts($id)
	{
		global $log, $singlepane_view;
                $log->debug("Entering get_products(".$id.") method ...");
		require_once('modules/Products/Products.php');
		global $app_strings;

		$focus = new Products();

		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;

		$query = "SELECT ec_products.productid, ec_products.productname,
			ec_products.productcode, ec_products.commissionrate,
			ec_products.qty_per_unit, ec_inventoryproductrel.listprice as unit_price,ec_products.productid as crmid
			FROM ec_products
			INNER JOIN ec_inventoryproductrel
				ON ec_products.productid = ec_inventoryproductrel.productid
			INNER JOIN ec_salesorder on ec_salesorder.salesorderid=ec_inventoryproductrel.id
			INNER JOIN ec_account
				ON ec_account.accountid = ec_salesorder.accountid
			WHERE ec_account.accountid = ".$id."
			AND ec_products.deleted = 0";
		$log->debug("Exiting get_products method ...");
		return GetRelatedList('Accounts','Products',$focus,$query,$button,$returnset);
	}

	

	/** Function to export the account records in CSV Format
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export Accounts Query.
	*/
	function create_export_query(&$order_by, &$where)
	{
		global $log;
		global $current_user; 
        $log->debug("Entering create_export_query(".$order_by.",".$where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("Accounts", "detail_view");
		global $mod_strings;
		global $current_language;
		if(empty($mod_strings)) {
			$mod_strings = return_module_language($current_language,"Accounts");
		}
		$fields_list = getFieldsListFromQuery($sql,$mod_strings);

		$query = "SELECT $fields_list FROM ec_account
				LEFT JOIN ec_users
					ON ec_account.smownerid = ec_users.id
				LEFT JOIN ec_users as ucreator
					ON ec_account.smcreatorid = ucreator.id ";


		$where_auto = " ec_account.deleted = 0 ";

		if($where != "")
			$query .= "WHERE ($where)  AND ".$where_auto;
		else
			$query .= "WHERE ".$where_auto;
		if(!is_admin($current_user))
		{
			$query .= " and ucreator.id=".$_SESSION['authenticated_user_id']." ";
		}
		
		if(!empty($order_by))
			$query .= " ORDER BY $order_by";

		$log->debug("Exiting create_export_query method ...");
		return $query;
	}


	


	function get_next_id() {
		$query = "select count(*) as num from ec_account";
		$result = $this->db->query($query);
		$num = $this->db->query_result($result,0,'num') + 1;
		//$num = $this->db->getUniqueID("ec_account");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

	function get_generalmodules($id,$related_tabname)
	{
		global $log, $singlepane_view;
        $log->debug("Entering get_generalmodules() method ...");
		require_once("modules/$related_tabname/$related_tabname.php");
		global $app_strings;
		$focus = new $related_tabname();
		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=Accounts&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=Accounts&return_action=CallRelatedList&return_id='.$id;
		$key = "generalmodules_account_query_".$related_tabname;
		$related_bean = substr($related_tabname,0,-1);
		$related_bean = strtolower($related_bean);
		$query = getSqlCacheData($key);
		if(!$query) {
			$query = "SELECT ec_".$related_bean."s.*,ec_users.user_name,ec_".$related_bean."s.".$related_bean."sid as crmid
				FROM ec_".$related_bean."s
				INNER JOIN ec_account
					ON ec_account.accountid = ec_".$related_bean."s.accountid
				LEFT JOIN ec_users
					ON ec_".$related_bean."s.smownerid = ec_users.id
				WHERE ec_".$related_bean."s.deleted = 0";
			setSqlCacheData($key,$query);
		}
		$query .= " and ec_".$related_bean."s.accountid = ".$id." ";
		$log->debug("Exiting get_generalmodules method ...");
		return GetRelatedList("Accounts",$related_tabname,$focus,$query,$button,$returnset);
	}

	

	function get_maillists($id)
	{
		global $log, $singlepane_view;
		global $app_strings;
		global $current_user;
		global $adb;
        $log->debug("Entering get_maillists(".$id.") method ...");
		$query = "select ec_maillogs.* from ec_maillogs 
			 				inner join ec_account 
								on ec_account.email = ec_maillogs.receiver_email
							where ec_account.accountid={$id} 
							and ec_maillogs.userid = '".$current_user->id."' 
							order by ec_maillogs.sendtime asc ";  //and ec_maillogs.flag=1 
		$list_result = $adb->getList($query);
		$num_rows = $adb->num_rows($list_result);

		$header = array();
		$header[] = "接收人";
		$header[] = "接收人邮件";
		$header[] = "邮件主题";
		$header[] = "邮件内容";
		$header[] = "发送结果";
		$header[] = "发送时间";
		
		if($num_rows && $num_rows > 0){
			$row_i = 1;
			foreach($list_result as $row){
				$entries = Array();
				$entries[] = $row['receiver'];
				$entries[] = $row['receiver_email'];
				$entries[] = $row['subject'];
				$entries[] = msubstr1($row['mailcontent'], 0, 50);
				$entries[] = $row['result'];
				$entries[] = $row['sendtime'];
				$entries_list[] = $entries;
				$row_i ++;
			}
		}
		if($num_rows>0){
			$return_data = array('header'=>$header,'entries'=>$entries_list);
			$log->debug("Exiting get_maillists method ...");
			return $return_data; 
		}
	}

	function get_qunfas_fromsae($id)
	{
		global $log, $singlepane_view;
		global $app_strings;
		global $adb;
		global $current_user;
        $log->debug("Entering get_qunfas(".$id.") method ...");
		
		require_once('Sms/SmsLib.php');
		$query = "select phone from ec_account where accountid={$id} "; 
		$row = $adb->getFirstLine($query);
		$phone = $row['phone'];
		if($phone == "") {
			return "";
		} 
		
		$list_result =  getUserSmsLogs($current_user->id,$phone);
		$num_rows = count($list_result);

		$header = array();
		$header[] = "#";
		$header[] = "接收人";
		$header[] = "接收人手机";
		$header[] = "短信内容";
		$header[] = "发送结果";
		$header[] = "发送时间";
		
		if($num_rows > 0 && is_array($list_result)){
			$row_i = 1;
			foreach($list_result as $row){
				$entries = Array();
				$entries[] = $row_i;
				$entries[] = $row->receiver;
				$entries[] = $row->receiver_phone;
				$entries[] = msubstr1($row->sendmsg, 0, 30);
				$entries[] = $row->result;
				$entries[] = $row->sendtime;
				$entries_list[] = $entries;
				$row_i ++;
			}
		}
		if($num_rows>0){
			$return_data = array('header'=>$header,'entries'=>$entries_list);
			$log->debug("Exiting get_maillists method ...");
			return $return_data; 
		}
	}
	
	
	function get_qunfas($id)
	{
		global $log, $singlepane_view;
		global $app_strings;
		global $adb;
		global $current_user;
        $log->debug("Entering get_qunfas(".$id.") method ...");
		 $query = "select ec_smslogs.* from ec_smslogs 
			 				inner join ec_account 
								on ec_account.phone = ec_smslogs.receiver_phone
							where ec_account.accountid={$id} 
							and ec_smslogs.userid = '".$current_user->id."' 
							order by ec_smslogs.sendtime asc ";  //and ec_smslogs.flag=1  
		$list_result = $adb->getList($query);
		$num_rows = $adb->num_rows($list_result);

		$header = array();
		$header[] = "接收人";
		$header[] = "接收人手机";
		$header[] = "短信内容";
		$header[] = "发送结果";
		$header[] = "发送时间";
		
		if($num_rows && $num_rows > 0){
			$row_i = 1;
			foreach($list_result as $row){
				$entries = Array();
				$entries[] = $row['receiver'];
				$entries[] = $row['receiver_phone'];
				$entries[] = msubstr1($row['sendmsg'], 0, 50);
				$entries[] = $row['result'];
				$entries[] = $row['sendtime'];
				$entries_list[] = $entries;
				$row_i ++;
			}
		}
		if($num_rows>0){
			$return_data = array('header'=>$header,'entries'=>$entries_list);
			$log->debug("Exiting get_maillists method ...");
			return $return_data; 
		}
	}

	function getSortView($modname){ 
		global $adb;
		$entityname = getModTabName($modname);
		
		$query = "select fieldid,columnname,fieldlabel from ec_field where 
					tabid = {$entityname['tabid']} and uitype in (15,16,111) ";
		$result = $adb->getList($query);
		$numrows = $adb->num_rows($result);
		$treeproj = array();
		$tree["treeid"] = 'tree';
		$tree["treename"] = $app_strings["Category"];
		$tree["click"] = '';
		$tree["treeparent"] = '-1';
		$treeproj[] = $tree;
		if($numrows > 0){
			$mod_strings = return_specified_module_language("zh_cn",$modname);

			for($i=0;$i<$numrows;$i++){
				$fieldid = $adb->query_result($result,$i,"fieldid");
				$columnname = $adb->query_result($result,$i,"columnname");
				$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
				if($app_strings[$fieldlabel]){
					$fieldtitle = $app_strings[$fieldlabel];
				}else if($mod_strings[$fieldlabel]){
					$fieldtitle = $mod_strings[$fieldlabel];
				}else{
					$fieldtitle = $fieldlabel;
				}
				$tree = array();
				$tree["treeid"] = $fieldid;
				$tree["treename"] = $fieldtitle;
				$tree["click"] = '';
				$tree["treeparent"] = 'tree';
				$treeproj[] = $tree;
				if($columnname == 'account_type'){
					$colname = "accounttype";
				}else{
					$colname = $columnname;
				}
				$picksql = "select colvalue from ec_picklist where colname = '{$colname}' order by sequence ";
				$pickresult = $adb->getList($picksql);
				$pickrows = $adb->num_rows($pickresult); 
				if($pickrows && $pickrows > 0){
					for($j=0;$j<$pickrows;$j++){
						$colvalue = $adb->query_result($pickresult,$j,"colvalue");
						$tree = array();
						$tree["treeid"] = $colvalue;
						$tree["treename"] = $colvalue;
						$tree["click"] = "search_field={$entityname['tablename']}.{$columnname}&
											search_text={$colvalue}&sortview={$sortview}";
						$tree["treeparent"] = $fieldid;
						$treeproj[] = $tree;
					}
				}
			}
		}
		require_once("include/Zend/Json.php");
		$json = new Zend_Json();
		$jsontree = $json->encode($treeproj);
		return $jsontree;
	}



}

?>
