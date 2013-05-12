<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/ec_crm/sugarcrm/data/Tracker.php,v 1.15 2005/04/28 05:44:22 samk Exp $
 * Description:  Updates entries for the Last Viewed functionality tracking the
 * last viewed records on a per user basis.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');

/** This class is used to track the recently viewed items on a per user basis.
 * It is intended to be called by each module when rendering the detail form.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
*/
class Tracker {
    var $log;
    var $db;
    var $table_name = "ec_tracker";

    // Tracker ec_table
    var $column_fields = Array(
        "id",
        "user_id",
        "module_name",
        "item_id",
        "item_summary"
    );

    function Tracker()
    {
        $this->log = LoggerManager::getLogger('Tracker');
	//$this->db = & getSingleDBInstance();
	global $adb;
        $this->db = $adb;
    }

    /**
     * Add this new item to the ec_tracker ec_table.  If there are too many items (global config for now)
     * then remove the oldest item.  If there is more than one extra item, log an error.
     * If the new item is the same as the most recent item then do not change the list
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
     */
    function track_view($user_id, $current_module, $item_id, $item_summary)
    {
      global $adb;
      $this->delete_history($user_id, $item_id);
      global $log;
$log->info("in  track view method ".$current_module);
        // Add a new item to the user's list

        $esc_item_id = addslashes($item_id);
        
//No genius required. Just add an if case and change the query so that it puts the tracker entry whenever you touch on the DetailView of the required entity
         //get the first name and last name from the respective modules
	 if($current_module != '')
	 {
		 $query = "select fieldname,tablename,entityidfield from ec_entityname where modulename = '$current_module'";
		 $result = $adb->query($query);
		 $fieldsname = $adb->query_result($result,0,'fieldname');
		 $tablename = $adb->query_result($result,0,'tablename'); 
		 $entityidfield = $adb->query_result($result,0,'entityidfield'); 
		 if(!(strpos($fieldsname,',') === false))
		 {
			 $fieldlists = explode(',',$fieldsname);
			 $fieldsname = "concat(";
			 $fieldsname = $fieldsname.implode(",' ',",$fieldlists);
			 $fieldsname = $fieldsname.")";
		 }	
		 $query1 = "select $fieldsname as entityname from $tablename where $entityidfield =" .$item_id; 
		 $result = $adb->query($query1);
		 $item_summary = $adb->query_result($result,0,'entityname');
		 if(strlen($item_summary) > 30)
	     {
		    $item_summary=substr($item_summary,0,30).'...';
	     }
	 }
	 
	 #if condition added to skip ec_faq in last viewed history
	      $id = $this->db->getUniqueID($this->table_name);
          $query = "INSERT into $this->table_name (id,user_id, module_name, item_id, item_summary) values ('".$id."','$user_id', '$current_module', '$esc_item_id', '".$item_summary."')";
          
          $this->log->info("Track Item View: ".$query);
          
          $this->db->query($query, true);
          
          
          $this->prune_history($user_id);
    }

    /**
     * param $user_id - The id of the user to retrive the history for
     * param $module_name - Filter the history to only return records from the specified module.  If not specified all records are returned
     * return - return the array of result set rows from the query.  All of the ec_table ec_fields are included
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
     */
    function get_recently_viewed($user_id, $module_name = "")
    {
    	if (empty($user_id)) {
    		return;
    	}

//        $query = "SELECT * from $this->table_name WHERE user_id='$user_id' ORDER BY id DESC";
	$query = "SELECT * from $this->table_name inner join ec_crmentity on ec_crmentity.crmid=ec_tracker.item_id WHERE user_id='$user_id' and ec_crmentity.deleted=0 ORDER BY id DESC";
        $this->log->debug("About to retrieve list: $query");
        $result = $this->db->query($query, true);
        $list = Array();
        while($row = $this->db->fetchByAssoc($result, -1, false))
        {
		//echo "while loppp";
		//echo '<BR>';


            // If the module was not specified or the module matches the module of the row, add the row to the list
            if($module_name == "" || $row[module_name] == $module_name)
            {
		//Adding Security check
		require_once('include/utils/utils.php');
		require_once('include/utils/UserInfoUtil.php');
		$entity_id = $row['item_id'];
		$module = $row['module_name'];
		//echo "module is ".$module."  id is      ".$entity_id;
		//echo '<BR>';
		if($module == "Users")
		{
			global $current_user;
			if(is_admin($current_user))
			{
				$per = 'yes';
			}	
		}
		else
		{
			
			$per = isPermitted($module,'DetailView',$entity_id);
			
		}
		if($per == 'yes')
		{
            		$list[] = $row;
		}
            }
        }
        return $list;
    }



    /**
     * INTERNAL -- This method cleans out any entry for a record for a user.
     * It is used to remove old occurances of previously viewed items.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
     */
    function delete_history( $user_id, $item_id)
    {
        $query = "DELETE from $this->table_name WHERE user_id='$user_id' and item_id='$item_id'";
       $this->db->query($query, true);
    }

    /**
     * INTERNAL -- This method cleans out any entry for a record.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
     */
    function delete_item_history($item_id)
    {
        $query = "DELETE from $this->table_name WHERE item_id='$item_id'";
       $this->db->query($query, true);

    }

    /**
     * INTERNAL -- This function will clean out old history records for this user if necessary.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
     */
    function prune_history($user_id)
    {
        global $history_max_viewed;

        // Check to see if the number of items in the list is now greater than the config max.
        $query = "SELECT count(*) from $this->table_name WHERE user_id='$user_id'";

        $this->log->debug("About to verify history size: $query");

        $count = $this->db->getOne($query);


        $this->log->debug("history size: (current, max)($count, $history_max_viewed)");
        while($count > $history_max_viewed)
        {
            // delete the last one.  This assumes that entries are added one at a time.
            // we should never add a bunch of entries
            $query = "SELECT * from $this->table_name WHERE user_id='$user_id' ORDER BY id ASC";
            $this->log->debug("About to try and find oldest item: $query");
            $result =  $this->db->limitQuery2($query,0,1);

            $oldest_item = $this->db->fetchByAssoc($result, -1, false);
            $query = "DELETE from $this->table_name WHERE id='{$oldest_item['id']}'";
            $this->log->debug("About to delete oldest item: ");

            $result = $this->db->query($query, true);


            $count--;
        }
    }

}
?>
