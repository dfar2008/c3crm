<?php
$currentModule=$_REQUEST['relatedmodule'];
$mod_strings = return_specified_module_language($current_language, $currentModule);
include('include/Ajax/UpdateCollectTotalInf.php');
?>
