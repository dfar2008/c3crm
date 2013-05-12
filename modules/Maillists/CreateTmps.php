<?php
require_once('include/CRMSmarty.php');
require_once('modules/Maillisttmps/Maillisttmps.php');

global $mod_strings;
global $current_user;
global $adb;

$focus = new Maillisttmps();
$smarty = new CRMSmarty();

$datetime = date("Y-m-d H:i:s");

if($_REQUEST['mode'] =='save'){
	$maillisttmpname = $_REQUEST['maillisttmpname'];
	$description = $_REQUEST['description'];
	/*$maillisttmpsid = $adb->getUniqueID("ec_crmentity");
	$smownerid = $current_user->id;
	$query  = "insert into ec_maillisttmps(maillisttmpsid,maillisttmpname,description,smownerid,smcreatorid,createdtime,modifiedtime) values({$maillisttmpsid},'{$maillisttmpname}','{$description}',{$smownerid},{$smownerid},'{$datetime}','{$datetime}');";
	$adb->query($query);*/
	
	require_once('modules/Maillisttmps/Maillisttmps.php');
	$focus = new Maillisttmps();
	setObjectValuesFromRequest($focus);
	
	//Save the Maillisttmps
	$focus->save("Maillisttmps");
	
	
	echo "<script>window.opener.document.getElementById('subject').value='".$maillisttmpname."';</script>";
	echo "<script>
	if(window.opener.oFCKeditor != undefined) {
		window.opener.oFCKeditor.SetHTML('".$description."');
		window.opener.oFCKeditor.ReplaceTextarea();
	} else if(window.opener.KE != undefined) {
		window.opener.KE.html(\"mailcontent\",'".$description."');
	} else {
		window.opener.document.getElementById('mailcontent').value = '".$description."'
	}
	</script>";
	echo "<script>window.close();</script>>";
}





$smarty->display("Maillists/CreateTmps.tpl");

?>
