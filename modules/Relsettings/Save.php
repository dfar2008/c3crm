<?php
require_once("include/database/PearDatabase.php");
global $current_user;
$mod_strings =  return_specified_module_language("zh_cn","Settings"); 
$server=$_REQUEST['server'];
$port=$_REQUEST['port'];
$server_username=$_REQUEST['server_username'];
$server_password=$_REQUEST['server_password'];
$server_type = $_REQUEST['server_type'];
$from_email = $_REQUEST['from_email'];
$from_name = $_REQUEST['from_name'];
$interval = $_REQUEST['interval'];

$db_update = true;
if($_REQUEST['smtp_auth'] == 'on' || $_REQUEST['smtp_auth'] == 1)
	$smtp_auth = 'true';
else
	$smtp_auth = 'false';

$date_array = $adb->getFirstLine("select * from ec_systems where server_type='".$server_type."' and smownerid='".$current_user->id."'");
if(empty($date_array)) {
	$id ='';
}else{
	$id =$date_array['id'];
}

if($db_update)
{
	if($id=='')
	{
		$id = $adb->getUniqueID("ec_systems");
		$sql="insert into ec_systems(id,server,server_port,server_username,server_password,server_type,smtp_auth,smownerid,from_email,from_name,`interval`) values(" .$id .",'".$server."','".$port."','".$server_username."','".$server_password."','".$server_type."','".$smtp_auth."','".$current_user->id."','".$from_email."','".$from_name."','".$interval."')";
	}else{
		$sql="update ec_systems set server = '".$server."', server_username = '".$server_username."', server_password = '".$server_password."', smtp_auth='".$smtp_auth."', server_type = '".$server_type."',from_name = '".$from_name."',from_email = '".$from_email."',server_port='".$port."',smownerid='".$current_user->id."',`interval`='".$interval."' where id = ".$id;
	}

	$adb->query($sql);
}


$options = array(
	'id' => $id,
	'server' => $server,
	'server_port' => $port,
 	'server_username' => $server_username,
	'server_password' => $server_password,
	'server_type' 	=> $server_type,
	'smtp_auth'	=> $smtp_auth,
	'smownerid' =>	$current_user->id,
	'from_email' =>	$from_email,
	'from_name' => $from_name
	);
if($server_type =='email'){
	$key = "webmail_array_".$current_user->id;
}

setSqlCacheData($key,$options);	

//Added code to send a test mail to the currently logged in user
if($server_type != 'backup' && $server_type != 'proxy')
{
	include_once("modules/Webmails/mail.php");
	global $current_user;

	$to_email = $server_username;
	$subject = $mod_strings['Test_mail_configuration'];
	$description = $mod_strings['Test_mail_Description'];
	$error_str = "";
	
	if($to_email != '' && $smtp_auth =='true')
	{	
		$mail_status = send_webmail($to_email,$subject,$description);
		if($mail_status != "") {
			$error_str = "mail_error=".urlencode($mail_status);
		}
	}
	//$action = 'EmailConfig';
	//if($error_str != "")
		//$action = 'EmailConfig&emailconfig_mode=edit';

        $action = 'index';
	if($error_str != "")
		$action = 'index&emailconfig_mode=edit';

}
redirect("index.php?module=Relsettings&parenttab=Settings&action=$action&$error_str");
?>
