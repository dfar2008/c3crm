<?php
$phpversion = preg_replace('/^(\d+)\..+$/', '\1', phpversion());
if ($phpversion < 5) {
    die('易客CRM仅支持PHP 5.2.x版本.');
}

/** Function to  return a string with backslashes stripped off
 * @param $value -- value:: Type string
 * @returns $value -- value:: Type string array
 */
 function stripslashes_checkstrings($value){
 	if(is_string($value)){
 		return stripslashes($value);
 	}
 	return $value;

 }
 if(get_magic_quotes_gpc() == 1){
 	$_REQUEST = array_map("stripslashes_checkstrings", $_REQUEST);
	$_POST = array_map("stripslashes_checkstrings", $_POST);
	$_GET = array_map("stripslashes_checkstrings", $_GET);

}
			
if (isset($_REQUEST['file'])) $the_file = $_REQUEST['file'];
else $the_file = "0welcome.php";

include("install/".$the_file);

?>
