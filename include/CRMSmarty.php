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
include_once("config.php");
include_once('Smarty/libs/Smarty.class.php');
class CRMSmarty extends Smarty{
	
	/**This function sets the smarty directory path for the member variables	
	*/
	function CRMSmarty()
	{
		global $root_directory;
		$this->Smarty();
		$this->template_dir = $root_directory.'Smarty/templates';
		$this->compile_dir = $root_directory.'Smarty/templates_c';
		$this->config_dir = $root_directory.'Smarty/configs';
		$this->cache_dir = $root_directory.'Smarty/cache';

		//$this->caching = true;
	        //$this->assign('app_name', 'Login');
	}
}

?>
