<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header$
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/CRMSmarty.php');
require_once('modules/Import/ImportAccount.php');
require_once('modules/Import/ImportProduct.php');
require_once('modules/Import/ImportSalesorder.php');
require_once('modules/Accounts/Accounts.php');
require_once('modules/Import/Forms.php');
require_once('modules/Import/parse_utils.php');
require_once('modules/Import/ImportMap.php');
require_once('include/database/PearDatabase.php');
require_once('include/CustomFieldUtil.php');
require_once('include/utils/CommonUtils.php');

@session_unregister('column_position_to_field');
@session_unregister('totalrows');
@session_unregister('recordcount');
@session_unregister('startval');
@session_unregister('return_field_count');
@session_unregister('import_rows_in_excel');
@session_unregister('skipped_rows_in_excel');
$_SESSION['totalrows'] = '';
$_SESSION['recordcount'] = 200;
$_SESSION['startval'] = 0;
$width = 500; 

global $mod_strings;
global $mod_list_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $import_file_name;
global $upload_maxsize;
global $root_directory;
global $import_dir;

$focus_impacc = new ImportAccount();
$focus_imppro = new ImportProduct();
$focus_impso = new ImportSalesorder();

$focus = 0;
$delimiter = ',';
$max_lines = 3;

$has_header1 = 1;
$overwrite1 = 1;

$has_header2 = 1;
$overwrite2 = 1;


global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once($theme_path.'layout_utils.php');

$smarty = new CRMSmarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMP", $import_mod_strings);
$smarty->assign("MODULE", $_REQUEST['module']);

$filename1 = $_REQUEST['filename1'];
$filename2 = $_REQUEST['filename2'];

if(empty($filename1)){
	show_error_import2("The order list file is empty!");
	exit;
}

if(empty($filename2)){
	show_error_import2("The order detail file is empty!");
	exit;
}

if(strpos($filename1,".csv") == false){
	show_error_import2("The order list file is not a csv file!");
	exit;
}

if(strpos($filename2,".csv") == false){
	show_error_import2("The order detail file is not a csv file!");
	exit;
}

$s = new SaeStorage();
$is_exist1 = $s->fileExists("upload",$filename1);

if (!$is_exist1) {
	show_error_import2("Order List Csv is Not Exist!");
	exit;
}

$is_exist2 = $s->fileExists("upload",$filename2);

if (!$is_exist2) {
	show_error_import2("Order List Csv is Not Exist!");
	exit;
}


// Now parse the file and look for errors
$ret_value = 0;


$ret_value1 = parse_import_csv_new($filename1,$delimiter,$max_lines,$has_header1);//excel
$ret_value2 = parse_import_csv_new($filename2,$delimiter,$max_lines,$has_header2);//excel



if ($ret_value1 == -1)
{
	show_error_import2( $mod_strings['LBL_CANNOT_OPEN'] );
	exit;
}
else if ($ret_value1 == -2)
{
	show_error_import2( $mod_strings['LBL_NOT_SAME_NUMBER'] );
	exit;
}
else if ( $ret_value1 == -3 )
{
	show_error_import2( $mod_strings['LBL_NO_LINES'] );
	exit;
}
else if ($ret_value1 == -4){
	
	show_error_import2( "Order List Data Num Over 2000!" );
	exit;
}
else if ($ret_value1 == -5){
	
	show_error_import2( "The order list csv file is not ANSI encoding." );
	exit;
}

if ($ret_value2 == -1)
{
	show_error_import2( $mod_strings['LBL_CANNOT_OPEN'] );
	exit;
}
else if ($ret_value2 == -2)
{
	show_error_import2( $mod_strings['LBL_NOT_SAME_NUMBER'] );
	exit;
}
else if ( $ret_value2 == -3 )
{
	show_error_import2( $mod_strings['LBL_NO_LINES'] );
	exit;
}
else if ($ret_value2 == -4){
	
	show_error_import2( "Order Detail file Data Num Over 2000!" );
	exit;
}
else if ($ret_value2 == -5){
	
	show_error_import2( "The order detail csv file is not ANSI encoding." );
	exit;
}

@session_unregister('import_has_header1');
$_SESSION['import_has_header1'] = $has_header1;

@session_unregister('import_has_header2');
$_SESSION['import_has_header2'] = $has_header2;

@session_unregister('import_overwrite1');
$_SESSION['import_overwrite1'] = $overwrite1;

@session_unregister('import_overwrite2');
$_SESSION['import_overwrite2'] = $overwrite2;


$rows1 = $ret_value1['rows'];
$ret_field_count1 = $ret_value1['field_count'];



$rows2 = $ret_value2['rows'];
$ret_field_count2 = $ret_value2['field_count'];

$list_count  = count($rows1);
$detail_count = count($rows2);



//"店铺名称"=>"belongshop",
$accfieldarr = array("买家会员名"=>"membername",
					 "收货人姓名"=>"accountname","收货地址"=>"bill_street","联系电话"=>"tel","联系手机"=>"phone");
$accfieldkeysarr = array_keys($accfieldarr);

$phonearr = array("联系电话","联系手机");


$sofiedlarr = array("订单编号"=>'subject',"买家会员名"=>"buyer_nick","买家应付货款"=>'total',"订单状态"=>'orderstatus',"订单创建时间"=>'createdtime',"订单备注"=>'description');
$sofiedlkeysarr = array_keys($sofiedlarr);
	

$focus_impacc->ClearColumnFields();
$focus_impso->ClearColumnFields();

$pix1 = $width / $list_count; 
$progress1 = 0;

flush();

echo "<script language=\"JavaScript\">
function updateProgress(sMsg, iWidth)
{ 
document.getElementById(\"status1\").innerHTML = sMsg;
document.getElementById(\"progress\").style.width = iWidth + \"px\";
document.getElementById(\"percent\").innerHTML = parseInt(iWidth / ". $width ." * 100) + \"%\";
	if(sMsg == \"操作完成!\"){
	document.getElementById(\"listcontent\").style.display =\"none\";
	}
}
</script>";
$width8 =  $width+8;
echo "<div id=\"listcontent\"   style=\"width:527px;padding-left:365px;\">
	<div style=\"margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: ". $width8 .".px\" align=\"left\">
	<div align=\"center\">订单列表导入进度条:</div>
	<div style=\"padding: 0; background-color: white; border: 1px solid navy; width: ". $width ."px\" align=\"left\">
	<div id=\"progress\" style=\"padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px\" ></div>
	</div>
	<div id=\"status1\" >&nbsp;</div>
	<div id=\"percent\" style=\"position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt\" >0%</div>
	</div>
</div>";
// 1 成功 2 失败 3 跳过
$success_account = 0;
$fail_account = 0;
$jump_account = 0;
$success_salesorder = 0;
$fail_salesorder = 0;
$jump_salesorder = 0;
foreach($rows1 as $key=>$val){
	if($key > 0){
		foreach($val as $k=>$v){
			$title = trim($titlearr[$k]);
			if(in_array($title,$accfieldkeysarr)){
				$focus_impacc->column_fields[$accfieldarr[$title]]=preg_replace('/\'/', '',$v);
			}

			if(in_array($title,$sofiedlkeysarr)){
				$focus_impso->column_fields[$sofiedlarr[$title]]=preg_replace('/\'/', '',$v);
			}
		}
		$focus_impacc->column_fields['leadsource'] = "淘宝";
		$return1 =  $focus_impacc->save("Accounts");
		if($return1 =='1'){
			$success_account++;
		}elseif($return1 =='2'){
			$fail_account++;
		}elseif($return1 =='3'){
			$jump_account++;
		}
		
		$return2 =  $focus_impso->save("SalesOrder");
		if($return2 =='1'){
			$success_salesorder++;
		}elseif($return2 =='2'){
			$fail_salesorder++;
		}elseif($return2 =='3'){
			$jump_salesorder++;
		}
	}else{
		$titlearr = $val;
	}
	
	$key1 = $key+1;
	echo "<script language=\"JavaScript\">
	updateProgress('当前进度:第".$key1."条', ". min($width, intval($progress1)).");
	</script>";
	
	flush();
	$progress1 += $pix1;
}

echo "<script language=\"JavaScript\">
updateProgress(\"操作完成!\", ".$width.");
</script>";


$smarty->assign("success_account", $success_account);
$smarty->assign("fail_account", $fail_account);
$smarty->assign("jump_account", $jump_account);
$smarty->assign("success_salesorder", $success_salesorder);
$smarty->assign("fail_salesorder", $fail_salesorder);
$smarty->assign("jump_salesorder", $jump_salesorder);

flush();	
	
$profiedlarr = array("标题"=>'productname',"价格"=>'price');
$profiedlkeysarr = array_keys($profiedlarr);

$titlearr =  array();

$focus_imppro->ClearColumnFields();

$pix2 = $width / $detail_count; 
$progress2 = 0;

echo "<script language=\"JavaScript\">
function updateProgress2(sMsg, iWidth)
{ 
document.getElementById(\"status2\").innerHTML = sMsg;
document.getElementById(\"progress2\").style.width = iWidth + \"px\";
document.getElementById(\"percent2\").innerHTML = parseInt(iWidth / ".$width." * 100) + \"%\";
if(sMsg == \"操作完成!\"){
document.getElementById(\"detailcontent\").style.display =\"none\";
}
}
</script>";

echo "<div id=\"detailcontent\"  style=\"width:527px;padding-left:365px;\">
	<div style=\"margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: ". $width8 ."px\" align=\"left\">
	<div align=\"center\">宝贝列表导入进度条:</div>
	<div style=\"padding: 0; background-color: white; border: 1px solid navy; width: ".$width."px\" >
	<div id=\"progress2\" style=\"padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px\"></div>
	</div>
	<div id=\"status2\">&nbsp;</div>
	<div id=\"percent2\" style=\"position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt\">0%</div>
	</div>
</div>";

$success_product = 0;
$fail_product = 0;
$jump_product = 0;
foreach($rows2 as $key=>$val){
	if($key > 0){
		foreach($val as $k=>$v){
			$title = trim($titlearr[$k]);
			if(in_array($title,$profiedlkeysarr)){
				$focus_imppro->column_fields[$profiedlarr[$title]]=preg_replace('/\'/', '',$v);
			}
		}
		$return3 = $focus_imppro->save("Products");
		if($return3 =='1'){
			$success_product++;
		}elseif($return3 =='2'){
			$fail_product++;
		}elseif($return3 =='3'){
			$jump_product++;
		}
	}else{
		$titlearr = $val;
	}
	$key1 = $key+1;
	echo "<script language=\"JavaScript\">
	updateProgress2(\"当前进度:第'".$key1."'条\", ". min($width, intval($progress2)) .");
	</script>";

	flush();
	$progress2 += $pix2;
}

echo "<script language=\"JavaScript\">
updateProgress2(\"操作完成!\", ".$width.");
</script>";

$smarty->assign("success_product", $success_product);
$smarty->assign("fail_product", $fail_product);
$smarty->assign("jump_product", $jump_product);

flush();	
$smarty->assign("success_product", $success_product);
$inventprofiedlarr = array("订单编号"=>'subject',"标题"=>'productname',"价格"=>'listprice',"购买数量"=>'quantity',"商品属性"=>'comment');
$inventprofiedlkeysarr = array_keys($inventprofiedlarr);

$success_inventproduct = 0;
$fail_inventproduct = 0;
$titlearr =  array();
foreach($rows2 as $key=>$val){
	if($key > 0){
		foreach($val as $k=>$v){
			$title = trim($titlearr[$k]);
			if(in_array($title,$inventprofiedlkeysarr)){
				$focus_imppro->column_fields[$inventprofiedlarr[$title]]= preg_replace('/\'/', '',$v);
			}
		}
		$return4 = $focus_imppro->saveInventPro();
		if($return4 =='1'){
			$success_inventproduct++;
		}elseif($return4 =='2'){
			$fail_inventproduct++;
		}
	}else{
		$titlearr = $val;
	}

}
$smarty->assign("success_inventproduct", $success_inventproduct);
$smarty->assign("fail_inventproduct", $fail_inventproduct);

//require_once ('getBuyNums.php');

$smarty->display("ImportStepXin2.tpl");

?>

