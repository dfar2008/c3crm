<?php
require_once('config.php');
require_once('modules/Users/Users.php');
require_once('include/logging.php');
require_once('include/utils/UserInfoUtil.php');
require_once('include/utils/utils.php');
global $adb;
$focus = new Users();
if(isset($_REQUEST["record"]) && $_REQUEST["record"] != '')
{
    $focus->mode='edit';
	$focus->id = $_REQUEST["record"];
}
else
{
    $focus->mode='';
}    


if($_REQUEST['changepassword'] == 'true')
{
	$focus->retrieve_entity_info($_REQUEST['record'],'Users');
	$focus->id = $_REQUEST['record'];
	if (isset($_REQUEST['new_password'])) {
			if (!$focus->change_password($_REQUEST['old_password'], $_REQUEST['new_password'])) {
				redirect("index.php?action=Error&module=Home&error_string=".urlencode($focus->error_string));
				exit;
			}else{
				echo "<script>alert('密码修改成功');</scr"."ipt>";
				redirect("index.php?action=index&module=Home");
			}
	}
	
}

?>
