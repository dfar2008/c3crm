<?php
set_time_limit(0);
require_once('config.inc.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');
require('copydirr.inc.php');
require('modules/SfaDesktops/SfaDesktopsDataPopulator.php');
global $root_directory;
global $adb;
if(isset($_SESSION['authenticated_user_language']) && $_SESSION['authenticated_user_language'] != '')
{
	$current_language = $_SESSION['authenticated_user_language'];
}
else 
{
	$current_language = $default_language;
}
copydirr($root_directory."modules/SfaDesktops/Smarty/templates/",$root_directory."Smarty/templates/");
//增加cache/application/language/zh_cn.lang.php中所需要的选项
$language_file_path = $root_directory."cache/application/language/".$current_language.".lang.php";
if(!is_file($language_file_path)) {
	touch($language_file_path);
}
$language_file_path = $root_directory."cache/application/language/".$current_language.".lang.php";
if(!is_file($language_file_path)) {
	touch($language_file_path);
}
if(is_writable($language_file_path)) {	
    $custom_app_strings = return_custom_application_language($current_language);
	$custom_applist_strings = return_custom_app_list_strings_language($current_language);
	if((is_array($custom_app_strings) && count($custom_app_strings) > 0) || (is_array($custom_applist_strings) && count($custom_applist_strings) > 0)) {	
		$bk = chr(10);     // The sign of line break
		$qo = '  ';        // The sign for quote
		$string = '';		
		$fd = fopen($language_file_path, 'w');
		fwrite($fd, '<?php'.$bk);//'$mod_strings = array ('.$bk
		if(is_array($custom_app_strings) && count($custom_app_strings) > 0) {
			unset($custom_app_strings['SfaDesktops']);
			unset($custom_app_strings['SfaDesktop']);
			foreach($custom_app_strings as $key1 => $arr){			
					$string .= $qo.'$app_strings[\''.$key1.'\'] = \''.$arr.'\';'.$bk;
			}
		}
		$string .= $qo.'$app_strings[\'SfaDesktops\'] = \'SFA工作台\';'.$bk;
		$string .= $qo.'$app_strings[\'SfaDesktop\'] = \'SFA工作台\';'.$bk;
		if(is_array($custom_applist_strings) && count($custom_applist_strings) > 0) {
			unset($custom_applist_strings['moduleList']['SfaDesktops']);
			foreach($custom_applist_strings['moduleList'] as $key1 => $arr){
					$string .= $qo.'$app_list_strings[\'moduleList\'][\''.$key1.'\'] = \''.$arr.'\';'.$bk;
			}
		}
		$string .= $qo.'$app_list_strings[\'moduleList\'][\'SfaDesktops\'] = \'SFA工作台\';'.$bk;
		fwrite($fd, $string);
		fwrite($fd, $bk.'?>');
		fclose($fd);
	} else {
		$bk = chr(10);     // The sign of line break
		$qo = '  ';        // The sign for quote
		$string = '';
		$fd = fopen($language_file_path, 'w');
		fwrite($fd, '<?php'.$bk);//'$mod_strings = array ('.$bk		
		$string .= $qo.'$app_strings[\'SfaDesktops\'] = \'SFA工作台\';'.$bk;
		$string .= $qo.'$app_strings[\'SfaDesktop\'] = \'SFA工作台\';'.$bk;
		$string .= $qo.'$app_list_strings[\'moduleList\'][\'SfaDesktops\'] = \'SFA工作台\';'.$bk;		
		fwrite($fd, $string);
		fwrite($fd, $bk.'?>');
		fclose($fd);
	}
}
$focus = new SfaDesktopsDataPopulator();
$focus->create_tables();
$focus->create_defautdata(true);
echo "Install SfaDesktops Module successfully!<br>";
?>