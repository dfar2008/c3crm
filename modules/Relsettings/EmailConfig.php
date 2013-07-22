<?php

require_once('include/CRMSmarty.php');
global $mod_strings;
global $app_strings;
global $app_list_strings;
global $current_user;

//Display the mail send status
$smarty = new CRMSmarty();
if($_REQUEST['mail_error'] != '')
{
    $error_msg = strip_tags($_REQUEST['mail_error']);
	$smarty->assign("ERROR_MSG",'<b><font color="red">'.$mod_strings['Test_Mail_status'].' : '.$error_msg.'</font></b>');
}

global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$sql="select * from ec_systems where server_type = 'email' and smownerid='".$current_user->id."'";
$result = $adb->query($sql);
$mail_server = $adb->query_result($result,0,'server');
$mail_server_port = $adb->query_result($result,0,'server_port');
$mail_server_username = $adb->query_result($result,0,'server_username');
$mail_server_password = $adb->query_result($result,0,'server_password');
$smtp_auth = $adb->query_result($result,0,'smtp_auth');
$from_name = $adb->query_result($result,0,'from_name');
$from_email = $adb->query_result($result,0,'from_email');
$interval = $adb->query_result($result,0,'interval');

if (isset($mail_server))
	$smarty->assign("MAILSERVER",$mail_server);
if (isset($mail_server_port))
	$smarty->assign("MAILSERVER_PORT",$mail_server_port);
else 
    $smarty->assign("MAILSERVER_PORT","25");
if (isset($mail_server_username))
	$smarty->assign("USERNAME",$mail_server_username);
if (isset($mail_server_password))
	$smarty->assign("PASSWORD",$mail_server_password);
if (isset($smtp_auth))
{
	if($smtp_auth == 'true')
		$smarty->assign("SMTP_AUTH",'checked');
	else
		$smarty->assign("SMTP_AUTH",'');
}

if(isset($from_name)){
	$smarty->assign("FROMNAME",$from_name);
}
if(isset($from_email)){
	$smarty->assign("FROMEMAIL",$from_email);
}
if(isset($interval)){
	$smarty->assign("INTERVAL",$interval);
}
$intervaloptions = '<select name="interval">';
for($i=1;$i<21;$i++){
	if($i == $interval){
		$intervaloptions .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
	}else{
		$intervaloptions .= '<option value="'.$i.'">'.$i.'</option>';
	}
}
 $intervaloptions .= '</select>';
$smarty->assign("intervaloptions",$intervaloptions);

if(isset($_REQUEST['emailconfig_mode']) && $_REQUEST['emailconfig_mode'] != '')
	$smarty->assign("EMAILCONFIG_MODE",$_REQUEST['emailconfig_mode']);
else
	$smarty->assign("EMAILCONFIG_MODE",'view');

$smarty->assign("MOD", return_module_language($current_language,'Settings'));
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("CMOD", $mod_strings);

$relsetmode = "view";
if(isset($_REQUEST['relsetmode']) && $_REQUEST['relsetmode'] != ''){
	$relsetmode = $_REQUEST['relsetmode'];
}
$smarty->assign("RELSETMODE", $relsetmode);
//$smarty->display("Relsettings/EmailConfig.tpl");
?>
