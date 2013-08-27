<?php
//header('Content-Type: text/html; charset=utf-8');
//set_time_limit(0);
require_once('include/CRMSmarty.php');
require_once('modules/Import/ImportAccount.php');
require_once('modules/Import/ImportContact.php');
require_once('modules/Contacts/Contacts.php');
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

$mod_strings = return_module_language("zh_cn","Import");
global $mod_list_strings;
global $app_strings;
global $app_list_strings;
global $current_user;
global $import_file_name;
global $upload_maxsize;
global $root_directory;
global $import_dir;

switch($_REQUEST['module']){
    case "Accounts":
    $focus_impacc = new ImportAccount();
    break;
    case "Contacts":
    $focus_impacc = new ImportContact();
    break;
}

$focus = 0;
$delimiter = ',';
$max_lines = 500;//最大行数

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$smarty = new CRMSmarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMP", $import_mod_strings);
$smarty->assign("MODULE", $_REQUEST['module']);

//added by ligangze 2013-08-09
$filepath = $_REQUEST['filename'];//临时文件的路径
$filepath = str_replace("\\","/",$filepath);
//var_dump($filepath);
//exit();
$filesize = filesize($filepath);
if(!isset($filepath)){
    show_error_import($mod_strings['LBL_IMPORT_MODULE_ERROR_NO_UPLOAD']);
	exit;
}else if($filesize > $upload_maxsize){
    show_error_import( $mod_strings['LBL_IMPORT_MODULE_ERROR_LARGE_FILE'] . " ". $upload_maxsize. " ". $mod_strings['LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END']);
	exit;
}

// noted by ligangze 2013-08-09
//if (!is_uploaded_file($_FILES['userfile']['tmp_name']) )
//{
//	show_error_import($mod_strings['LBL_IMPORT_MODULE_ERROR_NO_UPLOAD']);
//	exit;
//}
//else if ($_FILES['userfile']['size'] > $upload_maxsize)
//{
//	show_error_import( $mod_strings['LBL_IMPORT_MODULE_ERROR_LARGE_FILE'] . " ". $upload_maxsize. " ". $mod_strings['LBL_IMPORT_MODULE_ERROR_LARGE_FILE_END']);
//	exit;
//}
if( !is_writable( $import_dir ))
{
	show_error_import($mod_strings['LBL_IMPORT_MODULE_NO_DIRECTORY'].$import_dir.$mod_strings['LBL_IMPORT_MODULE_NO_DIRECTORY_END']);
	exit;
}

// noted by ligangze 2013-08-09
//$tmp_file_name = $import_dir. "IMPORT_".$current_user->id;
//move_uploaded_file($_FILES['userfile']['tmp_name'], $tmp_file_name);


$ret_value = 0;

//$ret_value = parse_import_csv_new($filepath,$delimiter,$max_lines,1);//excel
$ret_value = parse_import_csv($filepath,$delimiter,$max_lines,1);//changed by ligangze 2013-08-09


if ($ret_value == -1)
{
	show_error_import( $mod_strings['LBL_CANNOT_OPEN'] );
	exit;
}
else if ($ret_value == -2)
{
	show_error_import( $mod_strings['LBL_NOT_SAME_NUMBER'] );
	exit;
}
else if ( $ret_value == -3 )
{
	show_error_import( $mod_strings['LBL_NO_LINES'] );
	exit;
}
else if ($ret_value == -4){
	
	show_error_import( "Data Num Over 2000!" );
	exit;
}
else if ($ret_value == -5){
	
	show_error_import( "The csv file is not ANSI encoding." );
	exit;
}
@session_unregister('import_has_header');
$_SESSION['import_has_header'] =1;

@session_unregister('import_overwrite');
$_SESSION['import_overwrite'] = 1;


$rows = $ret_value['rows'];
$count = $ret_value['field_count'];
switch($_REQUEST['module']){
    case 'Accounts':
        //$head = array("客户名称","创建人","联系人","负责人","职位","性别","客户状态","vip信息","热度","成交意愿","客户来源","客户类型","下次联系日期","手机号码","电话","QQ","Email","传真","微博","MSN","淘宝旺旺","网站","所属国家","所属省份","所属城市","所属区域","详细地址","客户邮编","最近5天发送邮件次数","最近一月发送邮件次数","最近三月发送短信次数","最近三月发送邮件次数","最新发送短信日期","最新发送邮件日期","最新联系时间","联系次数","最新订单日期","订单数量","订单金额","创建时间","修改时间","失效日期","姓名1","电话122","备注");
        $head = array("客户名称","联系人","职位","性别","手机号码","电话","QQ","Email","传真","网站","所属国家","所属省份","所属城市","所属区域","详细地址","客户邮编","备注");
    break;
    case 'Contacts':
        $head = array("姓名","客户","性别","职位","手机","Email","电话","传真","QQ","MSN","旺旺","微博","备注");
    break;
}


$accfieldarr = $rows[0];
//var_dump($rows);//怎么只有两行？
//exit();

foreach($accfieldarr as $key=>$accfield){
	if($accfield != $head[$key]){
		show_error_import( "文件标题不正确: \"".$accfield."\" 出错，请检查。" );
		exit;
	}
}
$filed_lable = getColumnField();

$focus_impacc->ClearColumnFields();
//var_dump($focus_impacc);
//exit();

$pix1 = $width / $count; 
$progress1 = 0;

//header('Content-Type: text/html; charset=utf-8');
flush();
?>
<script language="JavaScript">
function updateProgress(sMsg, iWidth)
{ 
document.getElementById("status1").innerHTML = sMsg;
document.getElementById("progress").style.width = iWidth + "px";
document.getElementById("percent").innerHTML = parseInt(iWidth / <?php echo $width; ?> * 100) + "%";
	if(sMsg == "操作完成!"){
	document.getElementById("listcontent").style.display ="none";
	}
}
</script>
<div id="listcontent"  width="100%" align="center">
	<div style="margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: <?php echo $width+8; ?>px" align="left">
	<div align="center">客户列表导入进度条:</div>
	<div style="padding: 0; background-color: white; border: 1px solid navy; width: <?php echo $width; ?>px" align="left">
	<div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px" ></div>
	</div>
	<div id="status1" >&nbsp;</div>
	<div id="percent" style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt" >0%</div>
	</div>
</div>
<?php
$success_account_insert = 0;
$failed_account_insert = 0;
$tiaoguo_account = 0;
foreach($rows as $key=>$val){
	if($key > 0){
		foreach($val as $k=>$v){
			$t = $rows[0][$k];
			$field = $filed_lable[$t];
			$focus_impacc->column_fields[$field]=$v;
		}
		$focus_impacc->process_special_fields();
	
		 //$eof = $focus_impacc->save("Accounts");
         $eof = $focus_impacc->save($_REQUEST['module']);
		 if($eof == 1){
			$success_account_insert +=1;
		 }elseif($eof == 2){
			 $failed_account_insert +=1;
		 }elseif($eof == 3){
			 $tiaoguo_account +=1;
		 }
	}
	?>
	<script language="JavaScript">
	updateProgress("当前进度:第“<?php echo $key+1; ?>”条", <?php echo min($width, intval($progress1)); ?>);
	</script>
	<?php
	flush();
	$progress1 += $pix1;
}
?>
<script language="JavaScript">
updateProgress("操作完成!", <?php echo $width; ?>);
</script>
<?php
	flush();	

$smarty->assign("success_account_insert", $success_account_insert);
$smarty->assign("failed_account_insert", $failed_account_insert);
$smarty->assign("tiaoguo_account", $tiaoguo_account);

$smarty->display("ImportStepNew2.tpl");

function getColumnField(){
	global $adb;
	//$mods = return_module_language("zh_cn","Accounts");
    $mods = return_module_language("zh_cn",$_REQUEST['module']);
//    var_dump($mods);
//    exit();
    $tabid = getTabid($_REQUEST['module']);
	$query = "SELECT columnname,fieldlabel FROM `ec_field` WHERE tabid=$tabid ";
	$rows = $adb->getList($query);
	if(count($rows) >0){
		foreach($rows as $row){
			$columnname = $row['columnname'];
			$fieldlabel = $row['fieldlabel'];
			if(preg_match("/[a-z]/",$fieldlabel)){
				$fieldlabel = $mods[$fieldlabel];
			}
			$arr[$fieldlabel] = $columnname;
		}
	}
//	var_dump($arr);
//    exit();
	return $arr;

}


?>
<script language="javascript" type="text/javascript">
function validate_import_map()
{
	var tagName;
	var count = 0;
	var field_count = "<?php echo $field_count; ?>";
	var required_fields = new Array();
	var required_fields_name = new Array();
	var seq_string = '';

	<?php
		foreach($focus->required_fields as $name => $index)
		{
			?>
			required_fields[count] = "<?php echo $name; ?>";
			required_fields_name[count] = "<?php echo $translated_column_fields[$name]; ?>";
			count = count + 1;
			<?php
		}
	?>
	for(loop_count = 0; loop_count<field_count;loop_count++)
	{
		tagName = document.getElementById('colnum'+loop_count);
		optionData = tagName.options[tagName.selectedIndex].value;

		if(optionData != -1)
		{
			tmp = seq_string.indexOf("\""+optionData+"\"");
			if(tmp == -1)
			{
				seq_string = seq_string + "\""+optionData+"\"";
			}
			else
			{
				//if a ec_field mapped more than once, alert the user and return
				alert("'"+tagName.options[tagName.selectedIndex].text+"' " + alert_arr.ERR_MAP_TWICE);
				return false;
			}
		}

	}

	//check whether the mandatory ec_fields have been mapped.
	for(inner_loop = 0; inner_loop<required_fields.length;inner_loop++)
	{
		if(seq_string.indexOf(required_fields[inner_loop]) == -1)
		{
			alert(alert_arr.ERR_MAP_MANDORY + ' "'+required_fields_name[inner_loop]+'"');
			return false;
		}
	}

	//This is to check whether the save map name has been given or not when save map check box is checked
	if(document.getElementById("save_map").checked == true)
	{
		if(trim(document.getElementById("save_map_as").value) == '')
		{
			alert(alert_arr.ERR_SAVE_MAP);
			document.getElementById("save_map_as").focus();
			return false;
		}
	}

	return true;
}

function updateProgress(sMsg, iWidth)
{ 
document.getElementById("status").innerHTML = sMsg;
document.getElementById("progress").style.width = iWidth + "px";
document.getElementById("percent").innerHTML = parseInt(iWidth / <?php echo $width; ?> * 100) + "%";
}



</script>
