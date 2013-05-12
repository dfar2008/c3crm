<?php
if(isset($_REQUEST['file']) && ($_REQUEST['file'] !=''))
{
	require_once('modules/Users/'.$_REQUEST['file'].'.php');
}
?>
