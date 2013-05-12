<?php
//require_once('include/database/PearDatabase.php');
set_time_limit(0);
global $adb,$current_language;
$id=$_REQUEST['id'];
$parenttab_label=$_REQUEST['parenttab_label'];
$parenttab_label_cn = $_REQUEST['parenttab_label_cn'];
$sequence=$_REQUEST['sequence'];
$mode=$_REQUEST['mode'];

//checking if the user is trying to create a custom ec_field which already exists  
if(!empty($id))
{
	$query = "update ec_parenttab set parenttab_label='".$parenttab_label."',sequence='".$sequence."' where parenttabid='".$id."'";
	//echo $query;
	$adb->query($query);
}
else {
	$query = "select max(parenttabid) as parenttabid from ec_parenttab";
	$result = $adb->query($query);
	$id = $adb->query_result($result,0,"parenttabid") + 1;
	$query = "insert into ec_parenttab(parenttabid,parenttab_label,sequence,visible) values ('".$id."','".$parenttab_label."','".$sequence."','0')";
	$adb->query($query);
	//echo $query;
}
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
			unset($custom_app_strings[$parenttab_label]);
			foreach($custom_app_strings as $key1 => $arr){			
					$string .= $qo.'$app_strings[\''.$key1.'\'] = \''.$arr.'\';'.$bk;
			}
		}
		$string .= $qo.'$app_strings[\''.$parenttab_label.'\'] = \''.$parenttab_label_cn.'\';'.$bk;
		if(is_array($custom_applist_strings) && count($custom_applist_strings) > 0) {		
			foreach($custom_applist_strings['moduleList'] as $key1 => $arr){
					$string .= $qo.'$app_list_strings[\'moduleList\'][\''.$key1.'\'] = \''.$arr.'\';'.$bk;
			}
		}
		fwrite($fd, $string);
		fwrite($fd, $bk.'?>');
		fclose($fd);
	} else {
		$bk = chr(10);     // The sign of line break
		$qo = '  ';        // The sign for quote
		$string = '';
		$fd = fopen($language_file_path, 'w');
		fwrite($fd, '<?php'.$bk);//'$mod_strings = array ('.$bk		
		$string .= $qo.'$app_strings[\''.$parenttab_label.'\'] = \''.$parenttab_label_cn.'\';'.$bk;	
		fwrite($fd, $string);
		fwrite($fd, $bk.'?>');
		fclose($fd);
	}
}
$display_tabs = array();
$tabs_def = urldecode($_REQUEST['display_tabs_def']);
$DISPLAY_ARR = array();
parse_str($tabs_def,$DISPLAY_ARR);
$display_tabs = $DISPLAY_ARR['display_tabs'];
if(is_array($display_tabs) && count($display_tabs) > 0) {
	$count = 0;
	$query = "delete from ec_parenttabrel where parenttabid='".$id."'";
	$adb->query($query);
	foreach($display_tabs as $tabid) {
		$count ++;
		$query = "insert into ec_parenttabrel(parenttabid,tabid,sequence) values('".$id."','".$tabid."','".$count."')";
		// $query;
		$adb->query($query);
	}
} else {
	$query = "delete from ec_parenttabrel where parenttabid='".$id."'";
	$adb->query($query);
}

//echo $query;
$url = "index.php?module=Settings&action=CustomTabList&parenttab=Settings";
redirect($url);
?>
