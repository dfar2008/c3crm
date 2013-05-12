<?php
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');


// Note is used to store customer information.
class Notes extends CRMEntity {
	var $log;
	var $db;


	var $tab_name = Array('ec_crmentity','ec_notes');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_notes'=>'notesid');
	var $entity_table = "ec_notes";

	var $column_fields = Array();

    //var $sortby_fields = Array('notes_title','modifiedtime','contact_id','filename','smownerid');
	var $sortby_fields = Array('notes_title','contact_date','accountid','contact_id','notetype');

	// This is the list of ec_fields that are in the lists.
	var $list_fields = Array(
				'Note Title'=>Array('notes'=>'title'),
		        //'Account Name' => Array('account'=>'accountname'),
	            'Note Type'=>Array('notes'=>'notetype'),
				'Created Time'=>Array('notes'=>'createdtime'),
		        'Contact Date'=>Array('notes'=>'contact_date'),				
				'rating'=>Array('notes'=>'rating'),	
		       // 'Assigned To'=>Array('crmentity'=>'smownerid'),
				'Note'=>Array('notes'=>'notecontent')
				);
	var $list_fields_name = Array(
					'Note Title'=>'notes_title',
					//'Account Name'=>'account_id',
		            'Note Type'=>'notetype',
					'Created Time'=>'createdtime',
		            'Contact Date'=>'contact_date',
					'rating'=>'rating',
		           // 'Assigned To'=>'assigned_user_id',
		            'Note'=>'notecontent'
				     );
	var $search_fields = Array(
				'Note Title'=>Array('notes'=>'title'),
		        //'Account Name' => Array('account'=>'accountname'),
	            'Note Type'=>Array('notes'=>'notetype'),
				'Created Time'=>Array('notes'=>'createdtime'),
		        'Contact Date'=>Array('notes'=>'contact_date'),				
				'rating'=>Array('notes'=>'rating'),	
		       // 'Assigned To'=>Array('crmentity'=>'smownerid'),
				'Note'=>Array('notes'=>'notecontent')
				);
	var $search_fields_name = Array(
					'Note Title'=>'notes_title',
					//'Account Name'=>'account_id',
		            'Note Type'=>'notetype',
					'Created Time'=>'createdtime',
		            'Contact Date'=>'contact_date',
					'rating'=>'rating',
		           // 'Assigned To'=>'assigned_user_id',
		            'Note'=>'notecontent'
				     );
	var $required_fields =  array("title"=>1);
	var $list_link_field= 'title';

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';

	function Notes() {
		$this->log = LoggerManager::getLogger('notes');
		$this->log->debug("Entering Notes() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Notes');
		$this->log->debug("Exiting Note method ...");
	}

	function save_module($module)
	{
		$date_var = date('YmdHis');
		$newdate = getNewDisplayDate();
		if($this->mode == '' && $this->column_fields['account_id'] != '')
		{			
			$query = "update ec_account set contacttimes=contacttimes+1,lastcontactdate='".$newdate."',modifiedtime=NOW() where accountid='".$this->column_fields['account_id']."'";
			$this->db->query($query);			
		}
		if($this->column_fields['account_id'] != '')
		{
			global $app_strings;
			$contact_date = $this->column_fields['contact_date'];
			if($contact_date != "") {
				$newdate = getNewDisplayDate();
				$query = "update ec_account set contact_date='".$contact_date."',modifiedtime=NOW() where accountid='".$this->column_fields['account_id']."'";
				$this->db->query($query);
			}
			
			$rating = $this->column_fields['rating'];
			if($rating != $app_strings["LBL_NONE"]) {
				$query = "update ec_account set rating='".$rating."' where accountid='".$this->column_fields['account_id']."'";
				$this->db->query($query);
			}
		}



		//Inserting into attachments table
		//$this->insertIntoAttachment($this->id,'Notes');

	}


	/**
	 *      This function is used to add the ec_attachments. This will call the function uploadAndSaveFile which will upload the attachment into the server and save that attachment information in the database.
	 *      @param int $id  - entity id to which the ec_files to be uploaded
	 *      @param string $module  - the current module name
	*/
	function insertIntoAttachment($id,$module)
	{
		global $log, $adb;
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


	/** Function to export the notes in CSV Format
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export Notes Query.
	*/
	function create_export_query(&$order_by, &$where)
	{
		global $log;
		$log->debug("Entering create_export_query(".$order_by.",". $where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("Notes", "detail_view");
		global $mod_strings;
		global $current_language;
		if(empty($mod_strings)) {
			$mod_strings = return_module_language($current_language,"Notes");
		}
		$fields_list = getFieldsListFromQuery($sql,$mod_strings);

		$query = "SELECT $fields_list FROM ec_notes
				LEFT JOIN ec_account
					ON ec_notes.accountid=ec_account.accountid
				LEFT JOIN ec_users
					ON ec_notes.smownerid = ec_users.id
				LEFT JOIN ec_users as ucreator
					ON ec_notes.smcreatorid = ucreator.id
				WHERE ec_notes.deleted=0 ".$where;

		$log->debug("Exiting create_export_query method ...");
        return $query;
    }

     /**Function used to get the sort order for Sales Order listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['SALESORDER_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	 */
	function getSortOrder()
	{
		global $log;
                $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['NOTES_SORT_ORDER'])?($_SESSION['NOTES_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

    /**	Function used to get the order by value for Sales Order listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['SALESORDER_ORDER_BY'] if this session value is empty then default order by will be returned.
	 */
	function getOrderBy()
	{
		global $log;
                $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['NOTES_ORDER_BY'])?($_SESSION['NOTES_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}
}
?>
