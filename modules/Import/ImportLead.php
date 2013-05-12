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
 * $Header: /advent/projects/wesat/ec_crm/sugarcrm/modules/Import/ImportLead.php,v 1.3 2005/03/05 05:41:09 jack Exp $
 * Description:  Defines the Account SugarBean Account entity with the necessary
 * methods and variables.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/


include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Contacts/Contacts.php');
require_once('modules/Potentials/Potentials.php');
require_once('modules/Notes/Notes.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/ComboUtil.php');
require_once('modules/Leads/Leads.php');


class ImportLead extends Leads {
	 var $db;

	// This is the list of the functions to run when importing
	var $special_functions =  array("assign_user");

	var $importable_fields = Array();

	/**	function used to set the assigned_user_id value in the column_fields when we map the username during import
	 */
	function assign_user()
	{
		global $current_user;
		$ass_user = $this->column_fields["assigned_user_id"];
		$this->db->println("assign_user ".$ass_user." cur_user=".$current_user->id);
		
		if( $ass_user != $current_user->id)
		{
			$this->db->println("searching and assigning ".$ass_user);

			//$result = $this->db->query("select id from ec_users where user_name = '".$ass_user."'");
			$result = $this->db->query("select id from ec_users where id = '".$ass_user."'");
			if($this->db->num_rows($result)!=1)
			{
				$this->db->println("not exact records setting current userid");
				$this->column_fields["assigned_user_id"] = $current_user->id;
			}
			else
			{
			
				$row = $this->db->fetchByAssoc($result, -1, false);
				if (isset($row['id']) && $row['id'] != -1)
        	        	{
					$this->db->println("setting id as ".$row['id']);
					$this->column_fields["assigned_user_id"] = $row['id'];
				}
				else
				{
					$this->db->println("setting current userid");
					$this->column_fields["assigned_user_id"] = $current_user->id;
				}
			}
		}
	}

	/** Constructor which will set the importable_fields as $this->importable_fields[$key]=1 in this object where key is the fieldname in the field table
	 */
	function ImportLead() {
		
		$this->log = LoggerManager::getLogger('import_lead');
		$this->db = & getSingleDBInstance();
		$this->db->println("IMP ImportLead");
		$colf = getColumnFields("Leads");
		foreach($colf as $key=>$value)
			$this->importable_fields[$key]=1;
		
		$this->db->println($this->importable_fields);
	}

}
?>
