<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
require_once('data/Tracker.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
$focus = 0;
global $theme;
global $log;
global $oCustomView;
$error_msg = '';
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
require_once('modules/CustomView/CustomView.php');

$cv_module = $_REQUEST['module'];

$recordid = "";
if(isset($_REQUEST['record'])) {
	$recordid = $_REQUEST['record'];
}

$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATEGORY", $_REQUEST['parenttab']);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH", $image_path);
$smarty->assign("MODULE",$cv_module);
$smarty->assign("CVMODULE", $cv_module);
$smarty->assign("CUSTOMVIEWID",$recordid);
$smarty->assign("DATAFORMAT",$current_user->date_format);
if($recordid == "")
{
	$oCustomView = new CustomView();
	$modulecollist = $oCustomView->getModuleColumnsList($cv_module);
	//--start 2012-09-18 xiaoyang
	$selectedcolumnslist = array();
	foreach($modulecollist as $k=>$v)
	{
		foreach($v as $k1=>$v1)
		{
			$selectedcolumnslist = array_merge($selectedcolumnslist, array_keys($v1));
		}
	}
	//--end
	$modulecollectcollist = $oCustomView->getModuleCollectColumnsList($cv_module);
	$log->info('CustomView :: Successfully got ColumnsList for the module'.$cv_module);
	if(isset($modulecollist))
	{
		//$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist);

		$choosecollectcolhtml=getByModule_ColumnsHTML($cv_module,$modulecollectcollist);
	}

	
	//step2
	$stdfilterhtml = $oCustomView->getStdFilterCriteria();
	$log->info('CustomView :: Successfully got StandardFilter for the module'.$cv_module);
	$stdfiltercolhtml = getStdFilterHTML($cv_module);
	$stdfilterjs = $oCustomView->getCriteriaJS();

	//step4
	$advfilterhtml = getAdvCriteriaHTML();

//	for($i=1;$i<10;$i++)
//	{
//		$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist,$selectedcolumnslist[$i-1]);
//		$smarty->assign("CHOOSECOLUMN".$i,$choosecolhtml);
//	}
    $default_list_column=10;
    $listline=ceil($default_list_column/5);
	$colnum=$default_list_column%5;
	$choosecolumnHtml=array();
	for($i=1;$i<=$listline;$i++){
		$entries=array();
		if($colnum==0){
			for($j=$i*5-4;$j<=$i*5;$j++){
				$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist,$selectedcolumnslist[$j-1]);
				$entries[$j]=$choosecolhtml;
			}
		}
        $choosecolumnHtml[]=$entries;
    }
    $smarty->assign("NEWVIEW","true");
    $smarty->assign("CHOOSECOLUMN",$choosecolumnHtml);

	$smarty->assign("CHOOSECOLLECTCOLUMN",$choosecollectcolhtml);
	$log->info('CustomView :: Successfully got AdvancedFilter for the module'.$cv_module);
	for($i=1;$i<6;$i++)
	{
		$smarty->assign("FOPTION".$i,$advfilterhtml);
		$smarty->assign("BLOCK".$i,$choosecolhtml);
	}

	$smarty->assign("STDFILTERCOLUMNS",$stdfiltercolhtml);
	$smarty->assign("STDFILTERCRITERIA",$stdfilterhtml);
	$smarty->assign("STDFILTER_JAVASCRIPT",$stdfilterjs);

	$smarty->assign("MANDATORYCHECK",implode(",",$oCustomView->mandatoryvalues));
	$smarty->assign("SHOWVALUES",implode(",",$oCustomView->showvalues));
}
else
{
	$oCustomView = new CustomView();
	$customviewdtls = $oCustomView->getCustomViewByCvid($recordid); 
	
	
//	if(!is_admin($current_user)){
//		if($customviewdtls['smownerid'] == 0){
//			echo "<script>alert('公共视图不能修改！');history.go(-1);</script>";
//			die;
//		}
//	}
	
	$log->info('CustomView :: Successfully got ViewDetails for the Viewid'.$recordid);
	$modulecollist = $oCustomView->getModuleColumnsList($cv_module);
	$modulecollectcollist = $oCustomView->getModuleCollectColumnsList($cv_module);
	$selectedcolumnslist = $oCustomView->getColumnsListByCvid($recordid);
	$log->info('CustomView :: Successfully got ColumnsList for the Viewid'.$recordid);

	$smarty->assign("VIEWNAME",$customviewdtls["viewname"]);

	if($customviewdtls["setdefault"] == 1)
	{
		$smarty->assign("CHECKED","checked");
	}
	if($customviewdtls["setmetrics"] == 1)
	{
		$smarty->assign("MCHECKED","checked");
	}
	
	$choosecollectcolhtml=getByModule_ColumnsHTML($cv_module,$modulecollectcollist,$customviewdtls["collectcolumn"]);
	$smarty->assign("CHOOSECOLLECTCOLUMN",$choosecollectcolhtml);
//	for($i=1;$i<10;$i++)
//	{
//		$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist,$selectedcolumnslist[$i-1]);
//		$smarty->assign("CHOOSECOLUMN".$i,$choosecolhtml);
//	}
    $default_list_column=10;
    $listline=ceil($default_list_column/5);
	$colnum=$default_list_column%5;
	$choosecolumnHtml=array();
	for($i=1;$i<=$listline;$i++){
		$entries=array();
		if($colnum==0){
			for($j=$i*5-4;$j<=$i*5;$j++){
				$choosecolhtml = getByModule_ColumnsHTML($cv_module,$modulecollist,$selectedcolumnslist[$j-1]);
				$entries[$j]=$choosecolhtml;
			}
		}
        $choosecolumnHtml[]=$entries;
    }
    $smarty->assign("CHOOSECOLUMN",$choosecolumnHtml);

	$stdfilterlist = $oCustomView->getStdFilterByCvid($recordid);
	$log->info('CustomView :: Successfully got Standard Filter for the Viewid'.$recordid);
	$stdfilterhtml = $oCustomView->getStdFilterCriteria($stdfilterlist["stdfilter"]);
	$stdfiltercolhtml = getStdFilterHTML($cv_module,$stdfilterlist["columnname"]);
	$stdfilterjs = $oCustomView->getCriteriaJS();

	if(isset($stdfilterlist["startdate"]) && isset($stdfilterlist["enddate"]))
	{
		$smarty->assign("STARTDATE",$stdfilterlist["startdate"]);
		$smarty->assign("ENDDATE",$stdfilterlist["enddate"]);
	}

	$advfilterlist = $oCustomView->getAdvFilterByCvid($recordid);
	$log->info('CustomView :: Successfully got Advanced Filter for the Viewid'.$recordid,'info');
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
    if(is_array($oCustomView->mandatoryvalues)) {
		$smarty->assign("MANDATORYCHECK",implode(",",$oCustomView->mandatoryvalues));
	}
	if(is_array($oCustomView->showvalues)) {
		$smarty->assign("SHOWVALUES",implode(",",$oCustomView->showvalues));
	}

	$cactionhtml = "<input name='customaction' class='button' type='button' value='Create Custom Action' onclick=goto_CustomAction('".$cv_module."');>";

	if($cv_module == "Leads" || $cv_module == "Accounts" || $cv_module == "Contacts")
	{
		$smarty->assign("CUSTOMACTIONBUTTON",$cactionhtml);
	}
}


if(empty($customviewdtls)){
	$publictype="private";
}else{
	if($customviewdtls['smownerid']==0){
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

$smarty->assign("RETURN_MODULE", $cv_module);
$return_action = "index";
	
$smarty->assign("RETURN_ACTION", $return_action);

$smarty->display("CustomView.tpl");

/** to get the custom columns for the given module and columnlist  
  * @param $module (modulename):: type String 
  * @param $columnslist (Module columns list):: type Array 
  * @param $selected (selected or not):: type String (Optional)
  * @returns  $advfilter_out array in the following format 
  *	$advfilter_out = Array ('BLOCK1 NAME'=>
  * 					Array(0=>
  *						Array('value'=>$tablename:$colname:$fieldname:$fieldlabel:$typeofdata,
  *						      'text'=>$fieldlabel,
  *					      	      'selected'=><selected or ''>),
  *			      		      1=>
  *						Array('value'=>$tablename1:$colname1:$fieldname1:$fieldlabel1:$typeofdata1,
  *						      'text'=>$fieldlabel1,
  *					      	      'selected'=><selected or ''>)
  *					      ),
  *								|
  *								|
  *					      n=>
  *						Array('value'=>$tablenamen:$colnamen:$fieldnamen:$fieldlabeln:$typeofdatan,
  *						      'text'=>$fieldlabeln,
  *					      	      'selected'=><selected or ''>)
  *					      ), 
  *				'BLOCK2 NAME'=>
  * 					Array(0=>
  *						Array('value'=>$tablename:$colname:$fieldname:$fieldlabel:$typeofdata,
  *						      'text'=>$fieldlabel,
  *					      	      'selected'=><selected or ''>),
  *			      		      1=>
  *						Array('value'=>$tablename1:$colname1:$fieldname1:$fieldlabel1:$typeofdata1,
  *						      'text'=>$fieldlabel1,
  *					      	      'selected'=><selected or ''>)
  *					      )
  *								|
  *								|
  *					      n=>
  *						Array('value'=>$tablenamen:$colnamen:$fieldnamen:$fieldlabeln:$typeofdatan,
  *						      'text'=>$fieldlabeln,
  *					      	      'selected'=><selected or ''>)
  *					      ), 
  *
  *					||
  *					||
  *				'BLOCK_N NAME'=>
  * 					Array(0=>
  *						Array('value'=>$tablename:$colname:$fieldname:$fieldlabel:$typeofdata,
  *						      'text'=>$fieldlabel,
  *					      	      'selected'=><selected or ''>),
  *			      		      1=>
  *						Array('value'=>$tablename1:$colname1:$fieldname1:$fieldlabel1:$typeofdata1,
  *						      'text'=>$fieldlabel1,
  *					      	      'selected'=><selected or ''>)
  *					      )
  *								|
  *								|
  *					      n=>
  *						Array('value'=>$tablenamen:$colnamen:$fieldnamen:$fieldlabeln:$typeofdatan,
  *						      'text'=>$fieldlabeln,
  *					      	      'selected'=><selected or ''>)
  *					      ), 
  *
  */

function getByModule_ColumnsHTML($module,$columnslist,$selected="")
{
	global $oCustomView;
	global $app_list_strings;
	global $app_strings;
	global $current_language;
	$advfilter = array();
	//changed by dingjianting on 2006-11-8 for simplized chinese
	$mod_strings = return_specified_module_language($current_language,$module);

	foreach($oCustomView->module_list[$module] as $key=>$value)
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
	global $oCustomView;
	global $current_language;
	$stdfilter = array();
	$result = $oCustomView->getStdCriteriaByModule($module);
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
