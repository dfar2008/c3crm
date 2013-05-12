<?php
function convert_html($string, $encode=true){
	global $log;
	$log->debug("Entering to_html() method ...");
	global $toHtml;
	$string = str_replace(array_values($toHtml), array_keys($toHtml), $string);
	$log->debug("Exiting convert_html method ...");
	return $string;
}
global $adb;
$sql = "select notecontent from ec_notes where notesid='".$_REQUEST['record']."'";
$result = $adb->query($sql);
$body = $adb->query_result($result,0,"notecontent");
$body = convert_html($body);
//echo $body;
/*
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=\"GBK\">\r\n";


$body = preg_replace("content=([\"|\']?)text/html;([ ]?)charset=([a-z0-9~#%@\&:=?+\/\.,_-]+[a-z0-9~#%@\&=?+\/_-]+)([\"|\']?)", "", $body);
$body = preg_replace("target=([\"|\']?)[A-Z_]+([\"|\']?)", "target=_blank", $body);
$body = preg_replace("href=([\"|\']?)file:\/\/[a-z0-9~#%@\&:=?+\/\.,_-]+([\"|\']?)","\\1\\2",$body);
$body = preg_replace("href=([\"|\']?)http([s]?):\/\/", "target=\"_blank\" href=\\1http\\2://", $body);

if (!preg_match("/<html>/i", $body)){
	echo '
<style>
BODY { font-family: Arial, Helvetica, sans-serif; color: #333333; font-size: 9pt; }
A { font-family: Arial, Helvetica, sans-serif; text-decoration: underline; color: #004080; font-size: 9pt;}
</style>
';
}

if (preg_match("/<body/i", $body))
	$body = preg_replace("<body", "<body onLoad=\"setHeight()\"", $body);
else
	$body = "<body onLoad=\"setHeight()\">\r\n".$body."\r\n</body>\r\n";
*/
echo $body;
?>