<?php
set_time_limit(0);
require_once('include/CustomFieldUtil.php');
require_once('include/CRMSmarty.php');
require_once('include/utils/CommonUtils.php');
//require_once('modules/Import/error.php');
require_once('modules/SalesOrder/ImportSalesOrder.php');

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


@session_unregister('import_skipped_record_count');
@session_unregister('import_message');
@session_unregister('import_skipped_rows');
$import_mod_strings=return_module_language($current_language, "Import");
if (!is_uploaded_file($_FILES['userfile']['tmp_name']) )
{
	show_error_import($import_mod_strings['LBL_IMPORT_MODULE_ERROR_NO_UPLOAD']);
	exit;
}
else if ($_FILES['userfile']['size'] > $upload_maxsize)
{
	show_error_import( $import_mod_strings['LBL_IMPORT_MODULE_ERROR_LARGE_FILE'] . " ". $upload_maxsize. " ". $import_mod_strings['LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END']);
	exit;
}
if( !is_writable( $import_dir ))
{
	show_error_import($import_mod_strings['LBL_IMPORT_MODULE_NO_DIRECTORY'].$import_dir.$import_mod_strings['LBL_IMPORT_MODULE_NO_DIRECTORY_END']);
	exit;
}
if(trim(substr(strrchr(basename($_FILES['userfile']['name']), '.'), 1, 10))!="xls"){
	show_error_import("导入文件格式不正确");
	exit;
}
$tmp_file_name = $import_dir. "IMPORT_".$current_user->id;

move_uploaded_file($_FILES['userfile']['tmp_name'], $tmp_file_name);
$focus=new ImportSalesOrder();
$focus->setAccountFile($tmp_file_name);
$focus->parseExcel();
$_SESSION['import_skipped_record_count']=$focus->skip_record;
$totalrecord=$focus->total_reocrd;
$importrecord=$totalrecord-$focus->skip_record;
$_SESSION['import_message']="一共有 $totalrecord 条,共导入 $importrecord 条";
$_SESSION['import_skipped_rows']=$focus->skip_rows;
unlink($tmp_file_name);
header("Location: index.php?action=ImportSteplast&module=SalesOrder&parenttab=Accounts");

function show_error_import($message)
{
	global $current_language;
	$import_mod_strings=return_module_language($current_language, "Import");
	global $theme;

	global $log;
	global $mod_strings;
	global $app_strings;
	global $current_user;

	include('themes/'.$theme.'/header.php');

	$theme_path="themes/".$theme."/";

	$image_path=$theme_path."images/";

	

	$log->info("Upload Error");

	$smarty = new CRMSmarty();
	$smarty->assign("MOD", $import_mod_strings);
	$smarty->assign("APP", $app_strings);

	if (isset($_REQUEST['return_module'])) $smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);

	if (isset($_REQUEST['return_action'])) $smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);

	$smarty->assign("THEME", $theme);

	$category = getParenttab();
	$smarty->assign("CATEGORY", $category); 

	$smarty->assign("IMAGE_PATH", $image_path);
	//$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);

	$smarty->assign("MODULE", "SalesOrder");
	$smarty->assign("MESSAGE", $message);
	
	$smarty->display('SalesOrder/Importerror.tpl');
}
?>