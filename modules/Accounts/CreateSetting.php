<?php
require_once('include/CRMSmarty.php');
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');

global $mod_strings,$app_strings,$theme,$currentModule,$current_user;
$focus = new Accounts();
$focus->mode = '';

$smarty = new CRMSmarty();

$selectsql = "select * from ec_sfasettings where sfastatus='已启用' and deleted=0 and smownerid='".$current_user->id."' ";
$selectrow = $adb->getList($selectsql);
if(!empty($selectrow)){
	foreach($selectrow as $row){
		$id = $row['sfasettingsid'];
		$name = $row['sfasettingname'];
		$sfa_entries[$id] = $name;		
	}
}

$sfasettingshtml = '';
if(!empty($sfa_entries)){
	foreach($sfa_entries  as $sfa_id => $sfa_name){
		$sfasettingshtml .='<option value="'.$sfa_id.'">'.$sfa_name.'</option>';
	}
}
$smarty->assign("sfasettingshtml", $sfasettingshtml);

$smarty->display('CreateSettingForm.tpl');

?>
