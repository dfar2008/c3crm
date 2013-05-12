<?php

require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Fenzu/Fenzu.php');
global $adb;

$cvid = $_REQUEST["record"];
$module = $_REQUEST["dmodule"];
$smodule = $REQUEST["smodule"];
$parenttab = $_REQUEST["parenttab"];

$oFenzu = new Fenzu();
$Fenzudtls = $oFenzu->getFenzuByCvid($cvid);

if(!is_admin($current_user)){
	if($Fenzudtls['smownerid'] == 0){
		echo "<script>alert('公共分组不能删除！');history.go(-1);</script>";
		die;
	}
}


if(isset($cvid) && $cvid != '')
{
	$deletesql = "delete from ec_fenzu where cvid =".$cvid;
	$deleteresult = $adb->query($deletesql);
	$_SESSION['lvs'][$module]["viewname"] = '';
}
if(isset($smodule) && $smodule != '')
{
	$smodule_url = "&smodule=".$smodule;
}
clear_cache_files();
header("Location: index.php?action=ListView&parenttab=$parenttab&module=$module".$smodule_url);
?>
