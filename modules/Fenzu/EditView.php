<?php

require_once('data/Tracker.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
$focus = 0;
global $theme;
global $log;

//<<<<<>>>>>>
global $oFenzu;
//<<<<<>>>>>>
//ALTER TABLE `ec_Fenzu` ADD `collectcolumn` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ;
$error_msg = '';
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

require_once('modules/Fenzu/Fenzu.php');

$currentmodule = $_REQUEST['module'];
$cv_module = "Accounts";
$recordid = "";
if(isset($_REQUEST['record'])) {
	$recordid = $_REQUEST['record'];
}

$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATEGORY", $_REQUEST['parenttab']);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("MODULE",$cv_module);
$smarty->assign("CURRENTMODULE",$currentmodule);
$smarty->assign("CVMODULE", $cv_module);
$smarty->assign("FenzuID",$recordid);
$smarty->assign("DATAFORMAT",$current_user->date_format);
if($recordid == "")
{

	$oFenzu = new Fenzu();
	$modulecollist = $oFenzu->getModuleColumnsList($cv_module); 
	$modulecollectcollist = $oFenzu->getModuleCollectColumnsList($cv_module); 
	$log->info('Fenzu :: Successfully got ColumnsList for the module'.$cv_module);
	if(isset($modulecollist))
	{
		$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist);
		$choosecollectcolhtml=getByModule_ColumnsHTML($cv_module,$modulecollectcollist);
	}


	//step2
	$stdfilterhtml = $oFenzu->getStdFilterCriteria();
	$log->info('Fenzu :: Successfully got StandardFilter for the module'.$cv_module);
	$stdfiltercolhtml = getStdFilterHTML($cv_module);
	$stdfilterjs = $oFenzu->getCriteriaJS();

	//step4
	$advfilterhtml = getAdvCriteriaHTML();
	for($i=1;$i<10;$i++)
	{
		$smarty->assign("CHOOSECOLUMN".$i,$choosecolhtml);
	}
	$smarty->assign("CHOOSECOLLECTCOLUMN",$choosecollectcolhtml);
	$log->info('Fenzu :: Successfully got AdvancedFilter for the module'.$cv_module);
	for($i=1;$i<6;$i++)
	{
		$smarty->assign("FOPTION".$i,$advfilterhtml);
		$smarty->assign("BLOCK".$i,$choosecolhtml);
	}

	$smarty->assign("STDFILTERCOLUMNS",$stdfiltercolhtml);
	$smarty->assign("STDFILTERCRITERIA",$stdfilterhtml);
	$smarty->assign("STDFILTER_JAVASCRIPT",$stdfilterjs);

	$smarty->assign("MANDATORYCHECK",implode(",",$oFenzu->mandatoryvalues));
	$smarty->assign("SHOWVALUES",implode(",",$oFenzu->showvalues));
}
else
{
	$oFenzu = new Fenzu();

	$Fenzudtls = $oFenzu->getFenzuByCvid($recordid);
	
	
	if(!is_admin($current_user)){
		if($Fenzudtls['smownerid'] == 0){
			echo "<script>alert('公共分组不能修改！');history.go(-1);</script>";
			die;
		}
	}
	
	
	$log->info('Fenzu :: Successfully got ViewDetails for the Viewid'.$recordid);
	$modulecollist = $oFenzu->getModuleColumnsList($cv_module);
	$modulecollectcollist = $oFenzu->getModuleCollectColumnsList($cv_module);

	$log->info('Fenzu :: Successfully got ColumnsList for the Viewid'.$recordid);

	$smarty->assign("VIEWNAME",$Fenzudtls["viewname"]);



	$stdfilterlist = $oFenzu->getStdFilterByCvid($recordid);
	$log->info('Fenzu :: Successfully got Standard Filter for the Viewid'.$recordid);
	$stdfilterhtml = $oFenzu->getStdFilterCriteria($stdfilterlist["stdfilter"]) ;
	$stdfiltercolhtml = getStdFilterHTML($cv_module,$stdfilterlist["columnname"]);
	$stdfilterjs = $oFenzu->getCriteriaJS();

	if(isset($stdfilterlist["startdate"]) && isset($stdfilterlist["enddate"]))
	{
		$smarty->assign("STARTDATE",$stdfilterlist["startdate"]);
		$smarty->assign("ENDDATE",$stdfilterlist["enddate"]);
	}

	$advfilterlist = $oFenzu->getAdvFilterByCvid($recordid);
	$log->info('Fenzu :: Successfully got Advanced Filter for the Viewid'.$recordid,'info');
	for($i=1;$i<6;$i++)
	{
		$advfilterhtml = getAdvCriteriaHTML($advfilterlist[$i-1]["comparator"]);
		$advcolumnhtml = getByModule_ColumnsHTML($cv_module,$modulecollist,$advfilterlist[$i-1]["columnname"]);
		$smarty->assign("FOPTION".$i,$advfilterhtml);
		$smarty->assign("BLOCK".$i,$advcolumnhtml);
		$smarty->assign("VALUE".$i,$advfilterlist[$i-1]["value"]);
	}

	$smarty->assign("STDFILTERCOLUMNS",$stdfiltercolhtml);
	$smarty->assign("STDFILTERCRITERIA",$stdfilterhtml);
	$smarty->assign("STDFILTER_JAVASCRIPT",$stdfilterjs);
    if(is_array($oFenzu->mandatoryvalues)) {
		$smarty->assign("MANDATORYCHECK",implode(",",$oFenzu->mandatoryvalues));
	}
	if(is_array($oFenzu->showvalues)) {
		$smarty->assign("SHOWVALUES",implode(",",$oFenzu->showvalues));
	}

	$cactionhtml = "<input name='customaction' class='button' type='button' value='Create Custom Action' onclick=goto_CustomAction('".$cv_module."');>";

	if($cv_module == "Leads" || $cv_module == "Accounts" || $cv_module == "Contacts")
	{
		$smarty->assign("CUSTOMACTIONBUTTON",$cactionhtml);
	}
}


if(empty($Fenzudtls)){
	$publictype="private";
}else{
	if($Fenzudtls['smownerid']==0){
		$publictype="public";
	}else{
		$publictype="private";
	}
}

$publicarr = array("public"=>"公用","private"=>"私用");
$publichtml = '';
$publichtml .='<select name="publictype">';
foreach($publicarr as $key=>$public){
	if($key == $publictype ){
		$publichtml .='<option value="'.$key.'" selected="selected">'.$public.'</option>';	
	}else{
		$publichtml .='<option value="'.$key.'">'.$public.'</option>';	
	}
}
$publichtml .='</select>';


if(is_admin($current_user)){
	$smarty->assign("ADMIN","on");
}else{
	$publichtml = "<input type=\"hidden\" value=\"private\" name=\"publictype\">";	
}


$smarty->assign("publichtml", $publichtml);

$smarty->assign("RETURN_MODULE", $currentmodule);
if($cv_module == "Calendar")
        $return_action = "ListView";
else
        $return_action = "index";

$smarty->assign("RETURN_ACTION", $return_action);

$smarty->display("Fenzu.tpl");

function getByModule_ColumnsHTML($module,$columnslist,$selected="")
{
	global $oFenzu;
	global $app_list_strings;
	global $app_strings;
	global $current_language;
	$advfilter = array();
	//changed by dingjianting on 2006-11-8 for simplized chinese
	$mod_strings = return_specified_module_language($current_language,$module);

	foreach($oFenzu->module_list[$module] as $key=>$value)
	{
		$advfilter = array();
		$label = $key;
		if(isset($columnslist[$module][$key]))
		{
			foreach($columnslist[$module][$key] as $field=>$fieldlabel)
			{
				if(isset($mod_strings[$fieldlabel]))
				{
					if($selected == $field)
					{
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = $mod_strings[$fieldlabel];
						$advfilter_option['selected'] = "selected";
					}else
					{
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = $mod_strings[$fieldlabel];
						$advfilter_option['selected'] = "";
					}
				}
				elseif(isset($app_list_strings['moduleList'][$fieldlabel]))
				{
					if($selected == $field)
					{
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = $app_list_strings['moduleList'][$fieldlabel];
						$advfilter_option['selected'] = "selected";
					}else
					{
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = $app_list_strings['moduleList'][$fieldlabel];
						$advfilter_option['selected'] = "";
					}
				}
				else
				{
					if($selected == $field)
					{
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = $fieldlabel;
						$advfilter_option['selected'] = "selected";
					}else
					{
						$advfilter_option['value'] = $field;
						$advfilter_option['text'] = $fieldlabel;
						$advfilter_option['selected'] = "";
					}
				}
				$advfilter[] = $advfilter_option;
			}
			$advfilter_out[$label]= $advfilter;
		}
	}
	return $advfilter_out;
}


       /** to get the standard filter criteria
	* @param $module(module name) :: Type String
	* @param $elected (selection status) :: Type String (optional)
	* @returns  $filter Array in the following format
	* $filter = Array( 0 => array('value'=>$tablename:$colname:$fieldname:$fieldlabel,'text'=>$mod_strings[$field label],'selected'=>$selected),
	* 		     1 => array('value'=>$$tablename1:$colname1:$fieldname1:$fieldlabel1,'text'=>$mod_strings[$field label1],'selected'=>$selected),
	*/
function getStdFilterHTML($module,$selected="")
{
	global $app_list_strings;
	global $oFenzu;
	global $current_language;
	$stdfilter = array();
	$result = $oFenzu->getStdCriteriaByModule($module); 
	$mod_strings = return_specified_module_language($current_language,$module);

	if(isset($result))
	{
		foreach($result as $key=>$value)
		{
			if(isset($mod_strings[$value]))
			{
				if($key == $selected)
				{
					$filter['value'] = $key;
					$filter['text'] = $app_list_strings['moduleList'][$module]." - ".$mod_strings[$value];
					$filter['selected'] = "selected";
				}else
				{
					$filter['value'] = $key;
					$filter['text'] = $app_list_strings['moduleList'][$module]." - ".$mod_strings[$value];
					$filter['selected'] ="";
				}
			}else
			{
				if($key == $selected)
				{
					$filter['value'] = $key;
					$filter['text'] = $app_list_strings['moduleList'][$module]." - ".$value;
					$filter['selected'] = 'selected';
				}else
				{
					$filter['value'] = $key;
					$filter['text'] = $app_list_strings['moduleList'][$module]." - ".$value;
					$filter['selected'] ='';
				}
			}
			$stdfilter[]=$filter;
		}
	}

	return $stdfilter;
}

      /** to get the Advanced filter criteria
	* @param $selected :: Type String (optional)
	* @returns  $AdvCriteria Array in the following format
	* $AdvCriteria = Array( 0 => array('value'=>$tablename:$colname:$fieldname:$fieldlabel,'text'=>$mod_strings[$field label],'selected'=>$selected),
	* 		     1 => array('value'=>$$tablename1:$colname1:$fieldname1:$fieldlabel1,'text'=>$mod_strings[$field label1],'selected'=>$selected),
	*		                             		|
	* 		     n => array('value'=>$$tablenamen:$colnamen:$fieldnamen:$fieldlabeln,'text'=>$mod_strings[$field labeln],'selected'=>$selected))
	*/
function getAdvCriteriaHTML($selected="")
{
	global $adv_filter_options;
	global $app_list_strings;
	$AdvCriteria = array();
	foreach($adv_filter_options as $key=>$value)
	{
		if($selected == $key)
		{
			$advfilter_criteria['value'] = $key;
			$advfilter_criteria['text'] = $value;
			$advfilter_criteria['selected'] = "selected";
		}else
		{
			$advfilter_criteria['value'] = $key;
			$advfilter_criteria['text'] = $value;
			$advfilter_criteria['selected'] = "";
		}
		$AdvCriteria[] = $advfilter_criteria;
	}

	return $AdvCriteria;
}
//step4

?>
