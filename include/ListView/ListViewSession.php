<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/

require_once('include/logging.php');
	
class ListViewSession {

	var $module = null;
	var $viewname = null;
	var $start = null;
	var $sorder = null;
	var $sortby = null;
	var $page_view = null;

/**initializes ListViewSession 
 * Portions created by vtigerCRM are Copyright (C) vtigerCRM.
 * All Rights Reserved.
*/

	function ListViewSession()
	{
		global $log,$currentModule;
		$log->debug("Entering ListViewSession() method ...");
		
		$this->module = $currentModule;
		$this->sortby = 'ASC';
		$this->start =1;
	}

}
?>
