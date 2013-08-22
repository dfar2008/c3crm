<?php
require_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Accounts/Accounts.php');
require_once('modules/Notes/Notes.php');
require_once('modules/Users/Users.php');
require_once('modules/Products/Products.php');
require_once('include/utils/UserInfoUtil.php');
require_once('modules/CustomView/CustomView.php');

global $allow_exports;


/**Function convert line breaks to space in description during export 
 * Pram $str - text
 * retrun type string
*/
function br2nl_vt($str) 
{
	global $log;
	$log->debug("Entering br2nl_vt(".$str.") method ...");
	$str = preg_replace("/(\r\n)/", " ", $str);
	$log->debug("Exiting br2nl_vt method ...");
	return $str;
}

/**This function exports all the data for a given module
 * Param $type - module name
 * Return type text
*/
function export_all($type)
{
	global $log,$list_max_entries_per_page;
	$log->debug("Entering export_all(".$type.") method ...");
	global $adb;

	$focus = 0;
	$content = '';

	if ($type != "")
	{
		//changed by dingjianting on 2009-2-15 for supporting new module
		require_once("modules/$type/$type.php");
		$focus = new $type;
	}
	$where = '';
	/*

	if ( isset($_REQUEST['all']) )
	{
		$where = '';
	}
	else
	{
		$where = $_SESSION['export_where'];
	}
	*/
	if(!isset($_REQUEST['allids']) || $_REQUEST['allids'] == "") {
		$where = "";
	} else {
		$allids = str_replace(";",",",$_REQUEST['allids']);
		$allids =  substr($allids,0,-1);
		$where = $crmid." in (".$allids.")";
	}

	$search_type = $_REQUEST['search_type'];
    $export_data = $_REQUEST['export_data'];
	$viewname = $_REQUEST['viewname'];
	$entityArr = getEntityTable($type);
	$ec_crmentity = $entityArr["tablename"];
	$entityidfield = $entityArr["entityidfield"];
	$crmid = $ec_crmentity.".".$entityidfield;

	$order_by = "";

	$query = $focus->create_export_query($order_by,$where);
  

	if(isset($_SESSION['export_where']) && $_SESSION['export_where']!='' && $search_type == 'includesearch')
	{
		$where = $_SESSION['export_where'];
		$query .= ' and  ('.$where.') ';
	}

	if(($search_type == 'withoutsearch' || $search_type == 'includesearch') && $export_data == 'selecteddata')
	{
		$idstring = str_replace(";",",",$_REQUEST['idstring']);
		$idstring =  substr($idstring,0,-1);
		if($idstring != "") {
			$query .= ' and '.$crmid.' in ('.$idstring.')';
		}
	}
	if($export_data == 'vieweddata' && $viewname != "" && $viewname != 0)
	{
		$oCustomView = new CustomView($type);
		if($type == "SalesOrder" || $type == "PurchaseOrder") {
			$query = $oCustomView->getExportModifiedCvListQuery($viewname,$query,$type,true);//getModifiedCvListQuery
		} else {
			$query = $oCustomView->getExportModifiedCvListQuery($viewname,$query,$type,false);//getModifiedCvListQuery
		}
	}
	

	

	if(isset($_SESSION['nav_start']) && $_SESSION['nav_start'] != '' && $export_data == 'currentpage')
	{
		$start_rec = $_SESSION['nav_start'];
		$limit_start_rec = ($start_rec == 0) ? 0 : ($start_rec - 1);
		$query_order_by = $crmid;
		$sorder = "desc";
		$result = $adb->limitQuery2($query,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);
	} else {	
		$query .= " order by ".$crmid." desc";
		$result = $adb->query($query,true,"Error exporting $type: "."<BR>$query");
	}
	$numRows = $adb->num_rows($result);

	$fields_array = $adb->getFieldsArray($result);
	global $current_language;
	$spec_mod_strings = return_specified_module_language($current_language,$type);
	foreach($fields_array as $key=>$fieldlabel) {
		if(isset($spec_mod_strings[$fieldlabel])) {
			$fields_array[$key] = $spec_mod_strings[$fieldlabel];
		}
	}
	

	$header = implode("\",\"",array_values($fields_array));
	$header = "\"" .$header;
	$header .= "\"\r\n";
	$content .= $header;

	$column_list = implode(",",array_values($fields_array));
    foreach($result as $val)
	{
		$new_arr = array();

		foreach ($val as $key => $value)
		{
			if($key=="description")
			{
				$value=br2nl_vt($value);
			}
			array_push($new_arr, preg_replace("/\"/","\"\"",$value));
		}
		$line = implode("\",\"",$new_arr);
		$line = "\"" .$line;
		$line .= "\"\r\n";
		$content .= $line;
	}
	$log->debug("Exiting export_all method ...");
	return $content;
	
}

$content = export_all($_REQUEST['module']);

ob_end_clean();
header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("X-DNS-Prefetch-Control: off");
header("Cache-Control: private, no-cache, must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");

header("Content-Type: application/octet-stream");
header("Content-Type: application/force-download");
header("Content-Disposition: attachment; filename={$_REQUEST['module']}.csv");
$content = iconv_ec("UTF-8","GBK",$content);
print $content;
unset($content);
exit;
?>
