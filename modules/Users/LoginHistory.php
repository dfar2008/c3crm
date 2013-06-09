<?php
require_once('include/logging.php');
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/database/PearDatabase.php');

/** This class is used to store and display the login history of all the Users.
  * An Admin User can view his login history details  and of all the other users as well.
  * StandardUser is allowed to view only his login history details.
**/
class LoginHistory {
	var $log;
	var $db;

	// Stored ec_fields
	var $login_id;
	var $user_name;
	var $user_ip;
	var $login_time;
	var $logout_time;
	var $status;
	var $module_name = "Users";

	var $table_name = "ec_loginhistory";

	var $object_name = "LoginHistory";
	
	var $new_schema = true;

	var $column_fields = Array("id"
		,"login_id"
		,"user_name"
		,"user_ip"
		,"login_time"
		,"logout_time"
		,"status"
		);
	
	function LoginHistory() {
		$this->log = LoggerManager::getLogger('loginhistory');
		$this->db = & getSingleDBInstance();
	}
	
	var $sortby_fields = Array('user_name', 'user_ip', 'login_time', 'logout_time', 'status');	 
       	
	// This is the list of ec_fields that are in the lists.
	var $list_fields = Array(
			'User Name'=>Array('ec_loginhistory'=>'user_name'), 
			'User IP'=>Array('ec_loginhistory'=>'user_ip'), 
			'Signin Time'=>Array('ec_loginhistory'=>'login_time'),
		        'Signout Time'=>Array('ec_loginhistory'=>'logout_time'), 
			'Status'=>Array('ec_loginhistory'=>'status'),
		);	
	
	var $list_fields_name = Array(
		'User Name'=>'user_name',
		'User IP'=>'user_ip',
		'Signin Time'=>'login_time',
		'Signout Time'=>'logout_time',
		'Status'=>'status'
		);	
	var $default_order_by = "login_time";
	var $default_sort_order = 'DESC';

/**
 * Function to get the Header values of Login History.
 * Returns Header Values like UserName, IP, LoginTime etc in an array format.
**/
	function getHistoryListViewHeader()
	{
		global $log;
		$log->debug("Entering getHistoryListViewHeader method ...");
		global $app_strings;
		
		$header_array = array($app_strings['LBL_LIST_USER_NAME'], $app_strings['LBL_LIST_USERIP'], $app_strings['LBL_LIST_SIGNIN'], $app_strings['LBL_LIST_SIGNOUT'], $app_strings['LBL_LIST_STATUS']);

		$log->debug("Exiting getHistoryListViewHeader method ...");
		return $header_array;
		
	}

/**
  * Function to get the Login History values of the User.
  * @param $navigation_array - Array values to navigate through the number of entries.
  * @param $sortorder - DESC
  * @param $orderby - login_time
  * Returns the login history entries in an array format.
**/
	function getHistoryListViewEntries($username, $navigation_array, $sorder='', $orderby='')
	{
		global $log;
		$log->debug("Entering getHistoryListViewEntries() method ...");
		global $adb, $current_user;	
		
		$list_query = "Select * from ec_loginhistory where user_name='".$username."' order by ".$this->default_order_by." ".$this->default_sort_order;


		$result = $adb->query($list_query);
		$entries_list = array();
		
	if($navigation_array['end_val'] != 0)
	{
		for($i = $navigation_array['start']; $i <= $navigation_array['end_val']; $i++)
		{
			$entries = array();
			$loginid = $adb->query_result($result, $i-1, 'login_id');

			$entries[] = $adb->query_result($result, $i-1, 'user_name');
			$entries[] = $adb->query_result($result, $i-1, 'user_ip');
			$entries[] = $adb->query_result($result, $i-1, 'login_time');
			$entries[] = $adb->query_result($result, $i-1, 'logout_time');
			$entries[] = $adb->query_result($result, $i-1, 'status');

			$entries_list[] = $entries;
		}	
		$log->debug("Exiting getHistoryListViewEntries() method ...");
		return $entries_list;
	}	
	}
	
	/** Function that Records the Login info of the User 
	 *  @param ref variable $usname :: Type varchar
	 *  @param ref variable $usip :: Type varchar
	 *  @param ref variable $intime :: Type timestamp
	 *  Returns the query result which contains the details of User Login Info
	*/
	function user_login(&$usname,&$usip,&$intime)
	{

		$login_id = $this->db->getUniqueID('ec_loginhistory');
		$query = "Insert into ec_loginhistory (login_id,user_name, user_ip, logout_time, login_time, status) values ('".$login_id."','$usname','$usip','',NOW(),'Signed in')";
		$result = $this->db->query($query);
		
		return $result;
	}
	
	/** Function that Records the Logout info of the User 
	 *  @param ref variable $usname :: Type varchar
	 *  @param ref variable $usip :: Type varchar
	 *  @param ref variable $outime :: Type timestamp
	 *  Returns the query result which contains the details of User Logout Info
	*/
	function user_logout(&$usname,&$usip,&$outtime)
	{
		$logid_qry = "SELECT max(login_id) AS login_id from ec_loginhistory where user_name='$usname' and user_ip='$usip'";
		$result = $this->db->query($logid_qry);
		$loginid = $this->db->query_result($result,0,"login_id");
		if ($loginid == '')
                {
                        return;
                }
		// update the user login info.
		$query = "Update ec_loginhistory set logout_time =NOW(), status='Signed off' where login_id = $loginid";
		$result = $this->db->query($query)
                        or die("MySQL error: ".mysql_error());
	}

	/** Function to create list query 
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Query.
	*/
  	function create_list_query(&$order_by, &$where)
  	{
		// Determine if the ec_account name is present in the where clause.
		global $current_user;
		$query = "SELECT user_name,user_ip, status,login_time,logout_time FROM ".$this->table_name;
		if($where != "")
		{
			if(!is_admin($current_user))
			$where .=" AND user_name = '".$current_user->user_name."'";
			$query .= " WHERE ($where)";
		}
		else
		{
			if(!is_admin($current_user))
			$query .= " WHERE user_name = '".$current_user->user_name."'";
		}
		
		if(!empty($order_by))
			$query .= " ORDER BY $order_by";

                return $query;
	}

}



?>
