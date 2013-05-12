<?php
//require_once('include/database/PearDatabase.php');
global $adb;
$fld_module=$_REQUEST['fld_module'];
$blockid=$_REQUEST['blockid'];
$fieldlabel=$_REQUEST['fieldlabel'];
$order=$_REQUEST['order'];
$parenttab=$_REQUEST['parenttab'];
$mode=$_REQUEST['mode'];
$fieldid=$_REQUEST['fieldid'];
$fldMandatory = false;
if(isset($_REQUEST['fldMandatory'])) {
	$fldMandatory = true;
}
$tabid = getTabid($fld_module);

if(get_magic_quotes_gpc() == 1)
{
	$label = stripslashes($label);
}


//checking if the user is trying to create a custom ec_field which already exists  
if(!empty($fieldid))
{
	//$query = "update ec_field set sequence=sequence+1 where block='".$blockid."' and sequence>='".$order."'";
	//$adb->query($query);
	$query = "select typeofdata from ec_field  where fieldid=".$fieldid;
	$result = $adb->query($query);		
	$src_typeofdata = $adb->query_result($result,0,'typeofdata');
	//echo $src_typeofdata."<br>";
	if($fldMandatory) {
		$new_typeofdata = str_replace("~O","~M",$src_typeofdata);
		$new_typeofdata = str_replace("~0","~M",$new_typeofdata);
	} else {
		$new_typeofdata = str_replace("~M","~O",$src_typeofdata);
	}
	$query = "update ec_field set block='".$blockid."',sequence=".$order.",typeofdata='".$new_typeofdata."' where fieldid=".$fieldid;
	$adb->query($query);	
	global $current_language;
	global $root_directory;
	if(!is_dir($root_directory."cache/modules/".$fld_module)) {
		mkdir($root_directory."cache/modules/".$fld_module);
	}
	if(!is_dir($root_directory."cache/modules/".$fld_module."/language/")) {
		mkdir($root_directory."cache/modules/".$fld_module."/language/");
	}
	$language_file_path = $root_directory."cache/modules/".$fld_module."/language/".$current_language.".lang.php";
	if(!is_file($language_file_path)) {
		touch($language_file_path);
	}
	if(is_writable($language_file_path)) {		
		$cur_module_strings = return_specified_module_language($current_language,$fld_module);
		$custom_module_strings = return_custom_module_language($current_language,$fld_module);
		$query = "select fieldlabel from ec_field  where fieldid=".$fieldid;
		$result = $adb->query($query);		
		$src_fieldlabel = $adb->query_result($result,0,'fieldlabel');		
		if(isset($cur_module_strings[$src_fieldlabel])) {			
			$bk = chr(10);     // The sign of line break
			$qo = '  ';        // The sign for quote
			$string = '';
			$fd = fopen($language_file_path, 'w');
			fwrite($fd, '<?php'.$bk);//'$mod_strings = array ('.$bk
			if(is_array($custom_module_strings)) {
				$custom_module_strings[$src_fieldlabel] = $fieldlabel;
				foreach($custom_module_strings as $key1 => $arr){				 
					$string .= $qo.'$mod_strings[\''.$key1.'\'] = \''.$arr.'\';'.$bk;
				}
			} else {
				$string .= $qo.'$mod_strings[\''.$src_fieldlabel.'\'] = \''.$fieldlabel.'\';'.$bk;
			}
			fwrite($fd, $string);
			fwrite($fd, $bk.'?>');
			fclose($fd);
		} else {
			$query = "update ec_field set fieldlabel='".$fieldlabel."' where fieldid=".$fieldid;
			$adb->query($query);
		}
	}
}
/*
else {
	//$new_blockid = $adb->getUniqueID("ec_blocks");
	$query = "select max(fieldid) as num from ec_field";
	$result = $adb->query($query);		
	$new_fieldid = $adb->query_result($result,0,'num') + 1;
	$query = "insert into ec_field values (".$tabid.",".$new_fieldid.",".$tabid.",'".$label."',".$order.",0,0,0,0,0)";
}
*/
//echo $query;
echo "<script language='javascript'>";
echo "document.location.href='index.php?module=Settings&action=LayoutList&fld_module=".$fld_module."&parenttab=Settings"."';";
echo "</script>";
//header("Location:index.php?module=Settings&action=CustomBlockList&fld_module=".$fld_module."&parenttab=".$parenttab);
?>
