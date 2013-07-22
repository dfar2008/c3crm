<?php 
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/UserInfoUtil.php');

// User is used to store customer information.
 /** Main class for the user module
   *
  */
class Users {
	var $log;
	var $db;
	// Stored fields
	var $id;
	var $authenticated = false;
	var $confirmemail = false;
	var $error_string;
	var $is_admin;
	var $deleted;
	var $homeorder;
	//added by dingjianting on 2006-12-13 for login error with display all errors
 	var $record_module;


	var $tab_name = Array('ec_users');	
	var $tab_name_index = Array('ec_users'=>'id');
	var $column_fields = Array('user_name'=>'user_name','is_admin' =>'is_admin','user_password'=>'','confirm_password'=>'',
	'last_name' =>'',
	'status' =>'',
	'title' =>'',
	'phone_work' =>'',
	'phone_mobile' =>'',
	'description' =>'',
	'address_street' =>'',
	'address_city' =>'',
	'address_state' =>'',
	'address_country' =>'',
);
	var $table_name = "ec_users";

	// This is the list of fields that are in the lists.
	var $list_link_field= 'last_name';

	var $list_mode;
	var $popup_type;

	var $search_fields = Array(
		'Name'=>Array('ec_users'=>'last_name'),
		'Mobile'=>Array('ec_users'=>'phone_mobile'),
		'Email'=>Array('ec_users'=>'email1')		
	);
	var $search_fields_name = Array(
		'Name'=>'last_name',
		'Mobile'=>'phone_mobile',
		'Email'=>'email1'		
	);

	var $module_name = "Users";

	var $object_name = "User";
	var $encodeFields = Array("last_name", "description");

	var $sortby_fields = Array('status','email1','phone_work','is_admin','user_name','last_name');	  

	// This is the list of ec_fields that are in the lists.
	var $list_fields = Array(
		'Last Name'=>Array('ec_users'=>'last_name'),
		'User Name'=>Array('ec_users'=>'user_name'),
		'Status'=>Array('ec_users'=>'status'), 
		'Email'=>Array('ec_users'=>'email1'),
		'Admin'=>Array('ec_users'=>'is_admin'),
		'Phone'=>Array('ec_users'=>'phone_work')
	);
	var $list_fields_name = Array(
		'Last Name'=>'last_name',
		'User Name'=>'user_name',
		'Status'=>'status',
		'Email'=>'email1',
		'Admin'=>'is_admin',	
		'Phone'=>'phone_work'	
	);

	// This is the list of fields that are in the lists.
	var $default_order_by = "user_name";
	var $default_sort_order = 'ASC';

	var $record_id;
	var $new_schema = true;

	/** constructor function for the main user class
            instantiates the Logger class and PearDatabase Class	
  	  *
 	*/
	
	function Users() {
		$this->log = LoggerManager::getLogger('user');
		$this->log->debug("Entering Users() method ...");
		$this->db = & getSingleDBInstance();
		$this->log->debug("Exiting Users() method ...");

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
			$sorder = (($_SESSION['USERS_SORT_ORDER'] != '')?($_SESSION['USERS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder method ...");
		return $sorder;
	}
	
	/**
	 * Function to get order by
	 * return string  $order_by    - fieldname(eg: 'subject')
	 */
	function getOrderBy()
	{
		global $log;
                 $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by'])) 
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['USERS_ORDER_BY'] != '')?($_SESSION['USERS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}	
	


	/**
	 * @return string encrypted password for storage in DB and comparison against DB password.
	 * @param string $user_name - Must be non null and at least 2 characters
	 * @param string $user_password - Must be non null and at least 1 character.
	 * @desc Take an unencrypted username and password and return the encrypted password
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function encrypt_password($user_password)
	{
		// encrypt the password.
		global $dbconfig;
		//$salt = substr($this->column_fields["user_name"], 0, 2);
//		$salt = $dbconfig['db_name'];
        $salt='$1$rasm$';
		$encrypted_password = crypt($user_password, $salt);	

		return $encrypted_password;

	}

	function encrypt_discuz_password($user_password)
	{
		// encrypt the password.
		$encrypted_password = crypt($user_password);
		return $encrypted_password;

	}

	
	/** Function to authenticate the current user with the given password
  	  * @param $password -- password::Type varchar
	  * @returns true if authenticated or false if not authenticated
 	*/
	function authenticate_user($password){
		$usr_name = $this->column_fields["user_name"];

		$query = "SELECT * from $this->table_name where user_name='$usr_name' AND user_hash='$password'";
		$result = $this->db->requireSingleResult($query, false);

		if(empty($result)){
			$this->log->fatal("SECURITY: failed login by $usr_name");
			return false;
		}

		return true;
	}

	/** Function for validation check 
  	  *
 	*/
	function validation_check($validate, $md5, $alt=''){
		$validate = base64_decode($validate);
		if(is_file($validate) && $handle = fopen($validate, 'rb', true)){
			$buffer = fread($handle, filesize($validate));
			if(md5($buffer) == $md5 || (!empty($alt) && md5($buffer) == $alt)){
				return 1;
			}
			return -1;

		}else{
			return -1;
		}

	}

	/** Function for authorization check 
  	  *
 	*/	
	function authorization_check($validate, $authkey, $i){
		$validate = base64_decode($validate);
		$authkey = base64_decode($authkey);
		if(is_file($validate) && $handle = fopen($validate, 'rb', true)){
			$buffer = fread($handle, filesize($validate));
			if(substr_count($buffer, $authkey) < $i)
				return -1;
		}else{
			return -1;
		}

	}
	/**
	 * Checks the config.php AUTHCFG value for login type and forks off to the proper module
	 *
	 * @param string $user_password - The password of the user to authenticate
	 * @return true if the user is authenticated, false otherwise
	 */
	function doLogin($user_password) {
		$usr_name = $this->column_fields["user_name"];
		
		$this->log->debug("Using integrated/SQL authentication");
		$encrypted_password = $this->encrypt_password($user_password);
		$query = "SELECT id,is_admin from $this->table_name where deleted=0 and user_name='$usr_name' AND user_password='$encrypted_password'";
		$result = $this->db->query($query);
		$noofrows = $this->db->num_rows($result);
		if ($noofrows > 0) {
			$id = $this->db->query_result($result,0,"id");
			//*changed by xiaoyang on 2012-09-14  start
			if($this->db->query_result($result,0,"is_admin") == "on")
			{
				$_SESSION['crm_is_admin'] = true;
			}
			else
			{
				$_SESSION['crm_is_admin'] = false;
			}
			//*end
			$this->log->debug("Using integrated/SQL authentication id:".$id);
			return true;
		} else {
			$this->log->debug("Using integrated/SQL authentication NO Record");
			return false;
		}
				
		return false;
	}


	/** 
	 * Load a user based on the user_name in $this
	 * @return -- this if load was successul and null if load failed.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function load_user($user_password)
	{
		$usr_name = $this->column_fields["user_name"];
		if(isset($_SESSION['loginattempts'])){
			$_SESSION['loginattempts'] += 1;
		}else{
			$_SESSION['loginattempts'] = 1;	
		}
		if($_SESSION['loginattempts'] > 5){
			echo "登录失败次数超过5次";
			$this->log->info("SECURITY: " . $usr_name . " has attempted to login ". 	$_SESSION['loginattempts'] . " times.");
			die;
		}
		$this->log->info("Starting user load for $usr_name");
		$validation = 0;
		unset($_SESSION['validation']);
		if( !isset($this->column_fields["user_name"]) || $this->column_fields["user_name"] == "" || !isset($user_password) || $user_password == "")
			return null;

		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvc3VnYXJzYWxlc19tZC5naWY=','1a44d4ab8f2d6e15e0ff6ac1c2c87e6f', '866bba5ae0a15180e8613d33b0acc6bd') == -1)$validation = -1;
		//if($this->validation_check('aW5jbHVkZS9pbWFnZXMvc3VnYXJzYWxlc19tZC5naWY=','1a44d4ab8f2d6e15e0ff6ac1c2c87e6f') == -1)$validation = -1;
		if($this->validation_check('aW5jbHVkZS9pbWFnZXMvcG93ZXJlZF9ieV9zdWdhcmNybS5naWY=' , '3d49c9768de467925daabf242fe93cce') == -1)$validation = -1;
		if($this->authorization_check('aW5kZXgucGhw' , 'PEEgaHJlZj0naHR0cDovL3d3dy5zdWdhcmNybS5jb20nIHRhcmdldD0nX2JsYW5rJz48aW1nIGJvcmRlcj0nMCcgc3JjPSdpbmNsdWRlL2ltYWdlcy9wb3dlcmVkX2J5X3N1Z2FyY3JtLmdpZicgYWx0PSdQb3dlcmVkIEJ5IFN1Z2FyQ1JNJz48L2E+', 1) == -1)$validation = -1;
		$encrypted_password = $this->encrypt_password($user_password);

		$authCheck = false;
		$authCheck = $this->doLogin($user_password);

		if(!$authCheck)
		{
			$this->log->info("User authentication for $usr_name failed");
			return null;
		}

		$query = "SELECT * from $this->table_name where deleted=0 and user_name='$usr_name'";
		$result = $this->db->query($query);
		$noofrows = $this->db->num_rows($result);
		$id = $this->db->query_result($result,0,"id");
		if(empty($id)) {
			$this->log->warn("User authentication for $usr_name failed,not get id");
			return null;
		}
		$status = $this->db->query_result($result,0,"status");
		$src_user_hash = $this->db->query_result($result,0,"user_hash");
		$this->id = $id;	
		
		$user_hash = strtolower(md5($user_password));


		// If there is no user_hash is not present or is out of date, then create a new one.
		if(!isset($src_user_hash) || $src_user_hash != $user_hash)
		{
			$query = "UPDATE $this->table_name SET user_hash='$user_hash' where id='{$id}'";
			$this->db->query($query, true, "Error setting new hash for {$usr_name}: ");	
		}


		if ($status != "Inactive") $this->authenticated = true;

		unset($_SESSION['loginattempts']);
		return $this;
	}		


	/**
	 * @param string $user name - Must be non null and at least 1 character.
	 * @param string $user_password - Must be non null and at least 1 character.
	 * @param string $new_password - Must be non null and at least 1 character.
	 * @return boolean - If passwords pass verification and query succeeds, return true, else return false.
	 * @desc Verify that the current password is correct and write the new password to the DB.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function change_password($user_password, $new_password)
	{
		
		$usr_name = $this->column_fields["user_name"];
		global $current_user;
		$mod_strings = return_module_language("zh_cn",'Users');
		
		$this->log->info("Starting password change for $usr_name");
		
		if( !isset($new_password) || $new_password == "") {
			$this->error_string = $mod_strings['ERR_PASSWORD_CHANGE_FAILED_1'].$user_name.$mod_strings['ERR_PASSWORD_CHANGE_FAILED_2'];
			
			echo $this->error_string;die;
			return false;
		}

		$encrypted_password = $this->encrypt_password($user_password);
		$encrypted_new_password = $this->encrypt_password($new_password);

		//if (!is_admin($current_user)) {
			//check old password first
			$query = "SELECT user_name,user_password FROM $this->table_name WHERE id='$this->id'";
			$row =$this->db->getFirstLine($query);	
			$this->log->info("select old password query: $query");
			$this->log->info("return result of $row");

			if($encrypted_password != $row['user_password'])
			{	
				$this->log->info("Incorrect old password for $usr_name");
				$this->error_string = $mod_strings['ERR_PASSWORD_INCORRECT_OLD'];
				echo $this->error_string;die;
				return false;
			}
		//}		

		
		$user_hash = strtolower(md5($new_password));

		//set new password
		$query = "UPDATE $this->table_name SET user_password='$encrypted_new_password', user_hash='$user_hash' where id='$this->id'";
		$this->db->query($query, true, "Error setting new password for $usr_name: ");	
		return true;
	}

	function reset_password($new_password)
	{		
		global $mod_strings;
		global $current_user;
		$this->log->info("Starting password change for admin");
		$encrypted_new_password = $this->encrypt_password($new_password);
		$user_hash = strtolower(md5($new_password));

		//set new password
		$query = "UPDATE $this->table_name SET user_password='$encrypted_new_password', user_hash='$user_hash' where id='1'";
		$this->db->query($query, true, "Error resetting new password for admin: ");	
		return true;
	}

	function is_authenticated()
	{
		return $this->authenticated;
	}
	
	function is_confirmemail()
	{
		return $this->confirmemail;
	}


	/** gives the user id for the specified user name 
  	  * @param $user_name -- user name:: Type varchar
	  * @returns user id
 	*/
	
	function retrieve_user_id($user_name)
	{
		global $adb;
		$query = "SELECT id from ec_users where user_name='$user_name' AND deleted=0";
		$result  =$adb->query($query);
		$userid = $adb->query_result($result,0,'id');
		return $userid;
	}
	
	/** Function to return the column name array 
  	  *
 	*/
	
	function getColumnNames_User()
	{

		$mergeflds = array("FIRSTNAME","LASTNAME","USERNAME","YAHOOID","TITLE","OFFICEPHONE","DEPARTMENT",
				"MOBILE","OTHERPHONE","FAX","EMAIL",
				"HOMEPHONE","OTHEREMAIL","PRIMARYADDRESS",
				"CITY","STATE","POSTALCODE","COUNTRY");	
		return $mergeflds;
	}


	/** Function to get the current user information from the user_privileges file 
  	  * @param $userid -- user id:: Type integer
  	  * @returns user info in $this->column_fields array:: Type array
  	  *
 	 */
	
	function retrieveCurrentUserInfoFromFile($userid)
	{
		$this->id = $userid;
		$query = "select is_admin,user_name from ec_users where id={$userid}";
		$result = $this->db->query($query);
		$row_num = $this->db->num_rows($result);
        $i=0;//added by ligangze 2013-08-12
		if($row_num  > 0){
			$user_name = $this->db->query_result($result,$i,"user_name");
			$this->column_fields['user_name'] = $user_name;
			$is_admin = $this->db->query_result($result,$i,"is_admin");
			if($is_admin == "on") {
				$this->column_fields['is_admin'] = true;
				$this->is_admin = true;
			}
		}

		return $this;

	}



	/** Function to save the user information into the database
  	  * @param $module -- module name:: Type varchar
  	  *
 	 */
	function saveentity($module)
	{	
		global $current_user;//$adb added by raju for mass mailing
		$insertion_mode = $this->mode;

		$this->db->println("TRANS saveentity starts $module");
		$this->db->startTransaction();
		foreach($this->tab_name as $table_name)
		{
			if($table_name == 'ec_attachments')
			{
				$this->insertIntoAttachment($this->id,$module);
			}
			else
			{
				$this->insertIntoEntityTable($table_name, $module);			
			}
		}
		$this->db->completeTransaction();
		$this->db->println("TRANS saveentity ends");
	}

	/** Function to insert values in the specifed table for the specified module
  	  * @param $table_name -- table name:: Type varchar
  	  * @param $module -- module:: Type varchar
 	 */	
	function insertIntoEntityTable($table_name, $module)
	{	
		global $log;	
		$log->info("function insertIntoEntityTable ".$module.' ec_table name ' .$table_name);
		global $adb;
		$insertion_mode = $this->mode;

		//Checkin whether an entry is already is present in the ec_table to update
		if($insertion_mode == 'edit')
		{
			$check_query = "select * from ".$table_name." where ".$this->tab_name_index[$table_name]."=".$this->id;
			$check_result=$this->db->query($check_query);

			$num_rows = $this->db->num_rows($check_result);

			if($num_rows <= 0)
			{
				$insertion_mode = '';
			}	 
		}

		if($insertion_mode == 'edit')
		{
			$update = '';
			$tabid= getTabid($module);	
			$sql = "select * from ec_field where tabid=".$tabid." and tablename='".$table_name."' and displaytype in (1,3)"; 
		}
		else
		{
			$column = $this->tab_name_index[$table_name];
			if($column == 'id' && $table_name == 'ec_users')
			{
				$currentuser_id = $this->db->getUniqueID("ec_users");
				$this->id = $currentuser_id;
			}
			$value = $this->id;
			$tabid= getTabid($module);	
			$sql = "select * from ec_field where tabid=".$tabid." and tablename='".$table_name."' and displaytype in (1,3,4)"; 
		}
		$result = $this->db->query($sql);
		$noofrows = $this->db->num_rows($result);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldname=$this->db->query_result($result,$i,"fieldname");
			$columname=$this->db->query_result($result,$i,"columnname");
			$uitype=$this->db->query_result($result,$i,"uitype");
			if(isset($this->column_fields[$fieldname]))
			{
				if($uitype == 56)
				{
					if($this->column_fields[$fieldname] == 'on' || $this->column_fields[$fieldname] == 1)
					{
						$fldvalue = 1;
					}
					else
					{
						$fldvalue = 0;
					}

				}
				elseif($uitype == 33)
				{
					$j = 0;
					$field_list = '';
					if(is_array($this->column_fields[$fieldname]) && count($this->column_fields[$fieldname]) > 0)
					{
						foreach($this->column_fields[$fieldname] as $key=>$multivalue)
						{
							if($j != 0)
							{
								$field_list .= ' , ';
							}
							$field_list .= $multivalue;
							$j++;
						}
					}
					$fldvalue = $field_list;
				}
				elseif($uitype == 99)
				{
					$fldvalue = $this->encrypt_password($this->column_fields[$fieldname]);
				}
				else
				{
					$fldvalue = $this->column_fields[$fieldname]; 
					$fldvalue = stripslashes($fldvalue);
				}
				//$fldvalue = from_html($this->db->formatString($table_name,$columname,$fldvalue),($insertion_mode == 'edit')?true:false);
			   // $fldvalue = $this->db->formatString($table_name,$columname,$fldvalue);
				  if($insertion_mode == 'edit')
				  {	
					  if($i == 0)
					  {
						  $update = $columname."='".$fldvalue."'";
					  }
					  else
					  {
						  $update .= ', '.$columname."='".$fldvalue."'";
					  }
				  }
				  else
				  {
					  $column .= ", ".$columname;
					  $value .= ", '".$fldvalue."'";
				  }
			}
			

		}





		if($insertion_mode == 'edit')
		{
			//Check done by Don. If update is empty the the query fails
			if(trim($update) != '')
			{
				$sql1 = "update ".$table_name." set ".$update." where ".$this->tab_name_index[$table_name]."=".$this->id;

				$this->db->query($sql1); 
			}

		}
		else
		{	
			$sql1 = "insert into ".$table_name." (".$column.") values(".$value.")";
//                        echo $sql1;
			$this->db->query($sql1); 
		}

	}



	/** Function to insert values into the attachment table
  	  * @param $id -- entity id:: Type integer
  	  * @param $module -- module:: Type varchar
 	 */
	function insertIntoAttachment($id,$module)
	{
		global $log;
		$log->debug("Entering into insertIntoAttachment($id,$module) method.");

		foreach($_FILES as $fileindex => $files)
		{
			if($files['name'] != '' && $files['size'] > 0)
			{
				$this->uploadAndSaveFile($id,$module,$files);
			}
		}

		$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
	}

	/** Function to retreive the user info of the specifed user id The user info will be available in $this->column_fields array
  	  * @param $record -- record id:: Type integer
  	  * @param $module -- module:: Type varchar
 	 */
	function retrieve_entity_info($record, $module)
	{
		global $adb,$log;
		$log->debug("Entering into retrieve_entity_info($record, $module) method.");

		if($record == '')
		{
			$log->debug("record is empty. returning null");
			return null;
		}

		$result = Array();
		foreach($this->tab_name_index as $table_name=>$index)
		{
			$result[$table_name] = $adb->query("select * from ".$table_name." where ".$index."=".$record);
		}
		$tabid = getTabid($module);
		$sql1 =  "select * from ec_field where tabid=".$tabid;
		$result1 = $adb->query($sql1);
		$noofrows = $adb->num_rows($result1);
		for($i=0; $i<$noofrows; $i++)
		{
			$fieldcolname = $adb->query_result($result1,$i,"columnname");
			$tablename = $adb->query_result($result1,$i,"tablename");
			$fieldname = $adb->query_result($result1,$i,"fieldname");

			$fld_value = $adb->query_result($result[$tablename],0,$fieldcolname);
			$this->column_fields[$fieldname] = $fld_value;
			$this->$fieldname = $fld_value;

		}
		$this->column_fields["record_id"] = $record;
		$this->column_fields["record_module"] = $module;
//		$groupid = 0;
//		$group_query = "select * from ec_users2group where userid='".$record."'";
//		$group_result = $adb->query($group_query);
//		if($adb->num_rows($group_result) > 0)
//		{
//			$groupid = $adb->query_result($group_result,0,"groupid");
//		}		
//
//		$this->column_fields["groupid"] = $groupid;
		$this->id = $record;
		$log->debug("Exit from retrieve_entity_info() method.");

		return $this;
	}


	
	/** Function to save the user information into the database
  	  * @param $module -- module name:: Type varchar
  	  *
 	 */	
	function save($module_name) 
	{
		global $log;
	        $log->debug("module name is ".$module_name);
		//GS Save entity being called with the modulename as parameter
		$this->saveentity($module_name);
		if($this->column_fields['user_name'] != "") 
		{
			require_once("include/utils/ChineseSpellUtils.php");
			$spell = new ChineseSpell();
			$chineseStr = $this->column_fields['user_name'];
			$chineseStr = iconv_ec("UTF-8","GBK",$chineseStr);
			$prefixa = $spell->getFullSpell($chineseStr,'');
			$prefixa = strtoupper($prefixa);
			$query = "update ec_users set prefix='".$prefixa."' where id='".$this->id."'"; 
		    $this->db->query($query);
		}
	}


	/**
	 * Track the viewing of a detail record.  This leverages get_summary_text() which is object specific
	 * params $user_id - The user that is viewing the record.
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function track_view($user_id, $current_module,$id='')
	{
		require_once('data/Tracker.php');
		$this->log->debug("About to call ec_tracker (user_id, module_name, item_id)($user_id, $current_module, $this->id)");

		$tracker = new Tracker();
		$tracker->track_view($user_id, $current_module, $id, '');
	}

	function getListQuery($where=""){		
		$query = "select id,last_name,user_name,ec_groups.groupid,ec_groups.groupname,status,is_admin,email1,phone_work from ec_users left join ec_users2group on ec_users2group.userid=ec_users.id left join ec_groups on ec_groups.groupid=ec_users2group.groupid where deleted=0 ";
		$query = $query.$where;
		return $query;
	}
	
	function getUserID($user_name){
		$query  = "select id from ec_users where user_name='".$user_name."' "; 
		$row = $this->db->getFirstLine($query);
		if(!empty($row)){
			return $row['id'];
		}else{
			return '';
		}
	}
	
}
?>
