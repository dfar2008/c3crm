<?php
global $current_language;

$mod_strings = return_module_language($current_language, "Import");

include_once('modules/Import/error.php');

if (! isset($_REQUEST['step'] ) )
{
	$_REQUEST['step'] = 1;
}

$mod_list_strings = return_mod_list_strings_language($current_language,"Import");

include_once('modules/Import/ImportStep'. $_REQUEST['step']. '.php');

?>
