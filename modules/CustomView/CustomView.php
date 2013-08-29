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

global $calpath;
global $app_strings,$mod_strings;
global $app_list_strings;
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/utils/utils.php');

global $adv_filter_options;

$adv_filter_options = array("e"=>"".$app_strings['equals']."",
                            "n"=>"".$app_strings['not_equal_to']."",
                            "s"=>"".$app_strings['starts_with']."",
                            "c"=>"".$app_strings['contains']."",
                            "k"=>"".$app_strings['does_not_contain']."",
                            "l"=>"".$app_strings['less_than']."",
                            "g"=>"".$app_strings['greater_than']."",
                            "m"=>"".$app_strings['less_or_equal']."",
                            "h"=>"".$app_strings['greater_or_equal']."",
                            );

class CustomView extends CRMEntity{



	var $module_list = Array();

	var $customviewmodule;

	var $list_fields;

	var $list_fields_name;

	var $setdefaultviewid;

	var $escapemodule;

	var $mandatoryvalues;

	var $showvalues;

	/** This function sets the currentuser id to the class variable smownerid,
	  * modulename to the class variable customviewmodule
	  * @param $module -- The module Name:: Type String(optional)
	  * @returns  nothing
	 */
	function CustomView($module="")
	{
		global $current_user,$adb;
		$this->customviewmodule = $module;
		$this->escapemodule[] =	$module."_";
		$this->escapemodule[] = "_";
		$this->smownerid = $current_user->id;
	}


	/** To get the customViewId of the specified module
	  * @param $module -- The module Name:: Type String
	  * @returns  customViewId :: Type Integer
	 */
	function getViewId($module)
	{
		global $adb;
		global $current_user;
		
		if(isset($_REQUEST['viewname']) == false)
		{ 
			if (isset($_SESSION['lvs'][$module]["viewname"]) && $_SESSION['lvs'][$module]["viewname"]!='')
			{
				$viewid = $_SESSION['lvs'][$module]["viewname"];
			}
			elseif($this->setdefaultviewid != "")
			{
				$viewid = $this->setdefaultviewid;
			}else
			{
			
               $public_condition = " 1=1 ";
			
				$query="select cvid from ec_customview where setdefault=1 and entitytype='".$module."' and ".$public_condition;
				$cvresult=$adb->query($query);
				if($adb->num_rows($cvresult) == 0)
				{
					$query="select cvid from ec_customview where entitytype='".$module."' and ".$public_condition;
					$cvresult=$adb->query($query);
				}
				$viewid = $adb->query_result($cvresult,0,'cvid');
			}
		}
		else
		{
			$viewid =  $_REQUEST['viewname'];
		}
		if(empty($viewid) || $viewid == '0') {
			$viewid = "0";
		} else {
			$_SESSION['lvs'][$module]["viewname"] = $viewid;
			$query="select cvid from ec_customview where cvid='".$viewid."' and entitytype='".$module."'";
			$cvresult = $adb->query($query);
			if($adb->num_rows($cvresult) == 0)
			{
				$viewid = '0';
			}
		}
		return $viewid;

	}

	// return type array
	/** to get the details of a customview
	  * @param $cvid :: Type Integer
	  * @returns  $customviewlist Array in the following format
	  * $customviewlist = Array('viewname'=>value,
	  *                         'setdefault'=>defaultchk,
	  *                         'setmetrics'=>setmetricschk)
	 */

	function getCustomViewByCvid($cvid)
	{
		global $adb;
		if(empty($cvid)) {
			return array();
		}
		$ssql = "select ec_customview.* from ec_customview";
		$ssql .= " where ec_customview.cvid=".$cvid;
		$result = $adb->getList($ssql);
		foreach($result as $cvrow)
		{
			$customviewlist["viewname"] = $cvrow["viewname"];
			$customviewlist["setdefault"] = $cvrow["setdefault"];
			$customviewlist["setmetrics"] = $cvrow["setmetrics"];
			$customviewlist["setpublic"] = $cvrow["setpublic"];
			$customviewlist["collectcolumn"] = $cvrow["collectcolumn"];
			$customviewlist["smownerid"] = $cvrow["smownerid"];
		}
		return $customviewlist;
	}

	/** to get the customviewCombo for the class variable customviewmodule
	  * @param $viewid :: Type Integer
	  * $viewid will make the corresponding selected
	  * @returns  $customviewCombo :: Type String
	 */

	function getCustomViewCombo_bakcup($viewid='',$is_relate=false)
	{
		global $adb;
		global $current_user;
		global $app_strings;
		$tabid = getTabid($this->customviewmodule);
		$ssql = "select ec_customview.* from ec_customview inner join ec_tab on ec_tab.name = ec_customview.entitytype";
		$ssql .= " where ec_tab.tabid=".$tabid."  order by cvid";
		$result = $adb->getList($ssql);
		foreach($result as $cvrow)
		{
			//all should be gotten via app_strings by dingjianting on 2007-04-24 for customview problem
			if($cvrow['viewname'] == $app_strings['All'])
			{
				$cvrow['viewname'] = $app_strings['COMBO_ALL'];
			}

			if(!$is_relate) {
				if($cvrow['setdefault'] == 1 && $viewid =='')
				{
							 $shtml .= "<option selected value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
							 $this->setdefaultviewid = $cvrow['cvid'];
				}
				elseif($cvrow['cvid'] == $viewid)
				{
					$shtml .= "<option selected value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
					$this->setdefaultviewid = $cvrow['cvid'];
				}
				else
				{
					$shtml .= "<option value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
				}
			} else {
				$shtml .= "<option value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
			}
		}
		return $shtml;
	}

	/** to get the customviewCombo for the class variable customviewmodule
	  * @param $viewid :: Type Integer
	  * $viewid will make the corresponding selected
	  * @returns  $customviewCombo :: Type String
	 */

	function getCustomViewCombo($viewid='',$is_relate=false)
	{
		global $log;
		global $current_user;
		$log->debug("Entering getCustomViewCombo(".$viewid.") method ...");
		global $adb;
		global $app_strings;
		$public_condition = " 1=1 ";
		$tabid = getTabid($this->customviewmodule);
		$ssql = "select ec_customview.cvid,ec_customview.viewname from ec_customview";
		//$ssql .= " where ec_customview.entitytype='".$this->customviewmodule."'  and ".$public_condition." and ec_customview.smownerid in(0,".$current_user->id.") ";
        $ssql .= " where ec_customview.entitytype='".$this->customviewmodule."'  and ".$public_condition;
		$ssql .= " order by ec_customview.cvid ";
		$result = $adb->getList($ssql);
		$CustomViewCombo = array();
		foreach ($result as $cvrow)
		{
			$CustomViewCombo[$cvrow['cvid']] = $cvrow['viewname'];
		}
			
		$log->debug("Exiting getCustomViewCombo(".$viewid.") method ...");
		return $CustomViewCombo;
	}
	function getCustomViewCombo2($viewid='',$is_relate=false)
	{
		global $log;
		global $current_user;
		$log->debug("Entering getCustomViewCombo(".$viewid.") method ...");
		global $adb;
		global $app_strings;
		
		$public_condition = " 1=1 ";
		
		$tabid = getTabid($this->customviewmodule);
		$ssql = "select ec_customview.cvid,ec_customview.viewname from ec_customview";
		$ssql .= " where ec_customview.entitytype='".$this->customviewmodule."'  and ".$public_condition;
		$ssql .= " order by ec_customview.cvid ";
		$result = $adb->getList($ssql);
		$CustomViewCombo = array();
		foreach ($result as $cvrow)
		{
			$CustomViewCombo[$cvrow['cvid']] = $cvrow['viewname'];
		}
			
		$log->debug("Exiting getCustomViewCombo(".$viewid.") method ...");
		return $CustomViewCombo;
	}

	/** to get the customviewCombo for the class variable customviewmodule
	  * @param $viewid :: Type Integer
	  * $viewid will make the corresponding selected
	  * @returns  $customviewCombo :: Type String
	 */

	function getCustomViewCombo_html($viewid='',$is_relate=false)
	{
		global $adb;
		global $app_strings;
		global $current_user;
		
		$public_condition = " 1 ";
		
		$tabid = getTabid($this->customviewmodule);
		$ssql = "select ec_customview.cvid,ec_customview.viewname from ec_customview inner join ec_tab on ec_tab.name = ec_customview.entitytype";
		$ssql .= " where ec_tab.tabid=".$tabid."  and ".$public_condition;
		$result = $adb->getList($ssql);
		$shtml = array();
		foreach($result as $cvrow)
		{
			//all should be gotten via app_strings by dingjianting on 2007-04-24 for customview problem

			if($cvrow['viewname'] == $app_strings['All'])
			{
				$cvrow['viewname'] = $app_strings['COMBO_ALL'];
			}


			if(!$is_relate) {
				if($cvrow['setdefault'] == 1 && $viewid =='')
				{
							 $shtml .= "<option selected value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
							 $this->setdefaultviewid = $cvrow['cvid'];
				}
				elseif($cvrow['cvid'] == $viewid)
				{
					$shtml .= "<option selected value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
					$this->setdefaultviewid = $cvrow['cvid'];
				}
				else
				{
					$shtml .= "<option value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
				}
			} else {
				$shtml .= "<option value=\"".$cvrow['cvid']."\">".$cvrow['viewname']."</option>";
			}
			//$shtml[$cvrow['cvid']] = $cvrow['viewname'];
		}
		return $shtml;
	}

	/** to get the getColumnsListbyBlock for the given module and Block
	  * @param $module :: Type String
	  * @param $block :: Type Integer
	  * @returns  $columnlist Array in the format
	  * $columnlist = Array ($fieldlabel =>'$fieldtablename:$fieldcolname:$fieldname:$module_$fieldlabel1:$fieldtypeofdata',
	                         $fieldlabel1 =>'$fieldtablename1:$fieldcolname1:$fieldname1:$module_$fieldlabel11:$fieldtypeofdata1',
					|
			         $fieldlabeln =>'$fieldtablenamen:$fieldcolnamen:$fieldnamen:$module_$fieldlabel1n:$fieldtypeofdatan')
	 */

	function getColumnsListbyBlock($module,$block)
	{
		global $adb;
		$tabid = getTabid($module);
		global $current_user;
		$sql = "select ec_field.* from ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0";
		$sql.= " where ec_field.tabid=".$tabid." and ec_field.block in (".$block.") and";
		$sql.= " ec_field.displaytype in (1,2) union select ec_field.* from ec_field where ec_field.displaytype=3 and ec_field.block in (".$block.") and ec_field.tabid=".$tabid;
		$sql.= " order by sequence";
		$result = $adb->query($sql);
		$noofrows = $adb->num_rows($result);
		//Added to include ec_activity type in ec_activity ec_customview list
		if($module == 'Calendar' && $block == 19)
		{
			$module_columnlist['ec_activity:activitytype:activitytype:Calendar_Activity_Type:C'] = 'Activity Type';
		}

		for($i=0; $i<$noofrows; $i++)
		{
			$fieldtablename = $adb->query_result($result,$i,"tablename");
			$fieldcolname = $adb->query_result($result,$i,"columnname");
			$fieldname = $adb->query_result($result,$i,"fieldname");
			$fieldtype = $adb->query_result($result,$i,"typeofdata");
			$fieldtype = explode("~",$fieldtype);
			$fieldtypeofdata = $fieldtype[0];
			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			if($fieldlabel == "Related To")
			{
				$fieldlabel = "Related to";
			}
			if($fieldlabel == "Start Date & Time")
			{
				$fieldlabel = "Start Date";
				if($module == 'Calendar' && $block == 19)
					$module_columnlist['ec_activity:time_start::Calendar_Start_Time:I'] = 'Start Time';

			}
			$fieldlabel1 = str_replace(" ","_",$fieldlabel);
			$optionvalue = $fieldtablename.":".$fieldcolname.":".$fieldname.":".$module."_".$fieldlabel1.":".$fieldtypeofdata;
			//added to escape attachments fields in customview as we have multiple attachments
			if($module != 'HelpDesk' || $fieldname !='filename')
				$module_columnlist[$optionvalue] = $fieldlabel;
			if($fieldtype[1] == "M")
			{
				$this->mandatoryvalues[] = "'".$optionvalue."'";
				$this->showvalues[] = $fieldlabel;
			}
		}
		return $module_columnlist;
	}

	/** to get the getModuleColumnsList for the given module
	  * @param $module :: Type String
	  * @returns  $ret_module_list Array in the following format
	  * $ret_module_list =
		Array ('module' =>
				Array('BlockLabel1' =>
						Array('$fieldtablename:$fieldcolname:$fieldname:$module_$fieldlabel1:$fieldtypeofdata'=>$fieldlabel,
	                                        Array('$fieldtablename1:$fieldcolname1:$fieldname1:$module_$fieldlabel11:$fieldtypeofdata1'=>$fieldlabel1,
				Array('BlockLabel2' =>
						Array('$fieldtablename:$fieldcolname:$fieldname:$module_$fieldlabel1:$fieldtypeofdata'=>$fieldlabel,
	                                        Array('$fieldtablename1:$fieldcolname1:$fieldname1:$module_$fieldlabel11:$fieldtypeofdata1'=>$fieldlabel1,
					 |
				Array('BlockLabeln' =>
						Array('$fieldtablename:$fieldcolname:$fieldname:$module_$fieldlabel1:$fieldtypeofdata'=>$fieldlabel,
	                                        Array('$fieldtablename1:$fieldcolname1:$fieldname1:$module_$fieldlabel11:$fieldtypeofdata1'=>$fieldlabel1,


	 */


	function getModuleColumnsList($module)
	{

		$module_info = $this->getCustomViewModuleInfo($module);
		foreach($this->module_list[$module] as $key=>$value)
		{
			$columnlist = $this->getColumnsListbyBlock($module,$value);
			if(isset($columnlist))
			{
				$ret_module_list[$module][$key] = $columnlist;
			}
		}
		return $ret_module_list;
	}

	function getCollectColumnsListbyBlock($module,$block)
	{
		global $adb;
		$tabid = getTabid($module);
		global $current_user;
		

        $ssql = "select ec_field.* from ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 inner join ec_tab on ec_tab.tabid = ec_field.tabid where ec_field.uitype != 50 and ec_field.tabid=".$tabid." and ec_field.displaytype = 1 and ec_field.block in (".$block.") union select * from ec_field where ec_field.displaytype in (2,3) and ec_field.tabid=".$tabid." and ec_field.block in (".$block.") order by sequence";
		$result = $adb->query($ssql);
		$noofrows = $adb->num_rows($result);
		
		//Added to include ec_activity type in ec_activity ec_customview list
		if($module == 'Calendar' && $block == 19)
		{
			$module_columnlist['ec_activity:activitytype:activitytype:Calendar_Activity_Type:C'] = 'Activity Type';
		}

		for($i=0; $i<$noofrows; $i++)
		{
			$fieldtablename = $adb->query_result($result,$i,"tablename");
			$fieldcolname = $adb->query_result($result,$i,"columnname");
			$fieldname = $adb->query_result($result,$i,"fieldname");
			$fieldtype = $adb->query_result($result,$i,"typeofdata");
			$fieldtype = explode("~",$fieldtype);
			$fieldtypeofdata = $fieldtype[0];
			$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
			if($fieldlabel == "Related To")
			{
				$fieldlabel = "Related to";
			}
			if($fieldlabel == "Start Date & Time")
			{
				$fieldlabel = "Start Date";
				if($module == 'Calendar' && $block == 19)
					$module_columnlist['ec_activity:time_start::Calendar_Start_Time:I'] = 'Start Time';

			}
			$fieldlabel1 = str_replace(" ","_",$fieldlabel);
			$optionvalue = $fieldtablename.":".$fieldcolname.":".$fieldname.":".$module."_".$fieldlabel1.":".$fieldtypeofdata;
			//added to escape attachments fields in customview as we have multiple attachments
			if($module != 'HelpDesk' || $fieldname !='filename'){
                $columnname=substr($fieldcolname,-2);
                if(($fieldtype[0] == "N" || $fieldtype[0] == "NN" || $fieldtype[0] == "I") && $columnname != "id")
                {
                    $module_columnlist[$optionvalue] = $fieldlabel;
                }
            }
			if($fieldtype[1] == "M")
			{
				$this->mandatoryvalues[] = "'".$optionvalue."'";
				$this->showvalues[] = $fieldlabel;
			}
		}
		return $module_columnlist;
	}

	function getModuleCollectColumnsList($module)
	{

		$module_info = $this->getCustomViewModuleInfo($module);
		foreach($this->module_list[$module] as $key=>$value)
		{
			$columnlist = $this->getCollectColumnsListbyBlock($module,$value);
			if(isset($columnlist))
			{
				$ret_module_list[$module][$key] = $columnlist;
			}
		}
		return $ret_module_list;
	}

	/** to get the getModuleColumnsList for the given customview
	  * @param $cvid :: Type Integer
	  * @returns  $columnlist Array in the following format
	  * $columnlist = Array( $columnindex => $columnname,
	  *			 $columnindex1 => $columnname1,
	  *					|
	  *			 $columnindexn => $columnnamen)
	  */
	function getColumnsListByCvid($cvid)
	{
		global $log;
        $log->debug("Entering getColumnsListByCvid(".$cvid.") method ...");
		global $current_user;
		//changed by dingjianting on 2007-10-3 for cache HeaderArray
		$key = "columnlist_".$cvid;
		$columnlist = getSqlCacheData($key);
		if(!$columnlist) {
			global $adb;
			$sSQL = "select ec_cvcolumnlist.* from ec_cvcolumnlist";
			$sSQL .= " inner join ec_customview on ec_customview.cvid = ec_cvcolumnlist.cvid";
			$sSQL .= " where ec_customview.cvid =".$cvid." order by ec_cvcolumnlist.columnindex";
			$result = $adb->getList($sSQL);
			foreach($result as $columnrow)
			{
				$columnlist[$columnrow['columnindex']] = $columnrow['columnname'];
			}
			setSqlCacheData($key,$columnlist);
		}
		$log->debug("Exiting getColumnsListByCvid method ...");
		return $columnlist;
	}

	/** to get the standard filter fields or the given module
	  * @param $module :: Type String
	  * @returns  $stdcriteria_list Array in the following format
	  * $stdcriteria_list = Array( $tablename:$columnname:$fieldname:$module_$fieldlabel => $fieldlabel,
	  *			 $tablename1:$columnname1:$fieldname1:$module_$fieldlabel1 => $fieldlabel1,
	  *					|
	  *			 $tablenamen:$columnnamen:$fieldnamen:$module_$fieldlabeln => $fieldlabeln)
	  */
	function getStdCriteriaByModule($module)
	{
		global $adb;
		$tabid = getTabid($module);

		global $current_user;
		
		$module_info = $this->getCustomViewModuleInfo($module);
		foreach($this->module_list[$module] as $key=>$blockid)
		{
			$blockids[] = $blockid;
		}
		$blockids = implode(",",$blockids);
		$sql = "select * from ec_field inner join ec_tab on ec_tab.tabid = ec_field.tabid ";
		$sql.= " where ec_field.tabid=".$tabid." and ec_field.block in (".$blockids.")
					and ec_field.uitype in (5,6,23,70) ";
		$sql.= " order by ec_field.sequence";
		
		$result = $adb->getList($sql);
        foreach($result as $criteriatyperow)
		{
			$fieldtablename = $criteriatyperow["tablename"];
			$fieldcolname = $criteriatyperow["columnname"];
			$fieldlabel = $criteriatyperow["fieldlabel"];
			$fieldname = $criteriatyperow["fieldname"];
			$fieldlabel1 = str_replace(" ","_",$fieldlabel);
			$optionvalue = $fieldtablename.":".$fieldcolname.":".$fieldname.":".$module."_".$fieldlabel1;
			$stdcriteria_list[$optionvalue] = $fieldlabel;
		}

		return $stdcriteria_list;

	}

	/** to get the standard filter criteria
	  * @param $selcriteria :: Type String (optional)
	  * @returns  $filter Array in the following format
	  * $filter = Array( 0 => array('value'=>$filterkey,'text'=>$mod_strings[$filterkey],'selected'=>$selected)
	  * 		     1 => array('value'=>$filterkey1,'text'=>$mod_strings[$filterkey1],'selected'=>$selected)
	  *		                             		|
	  * 		     n => array('value'=>$filterkeyn,'text'=>$mod_strings[$filterkeyn],'selected'=>$selected)
	  */
	function getStdFilterCriteria($selcriteria = "")
	{
		global $mod_strings;
		$filter = array();//7,15,30,60,100

		$stdfilter = Array("custom"=>"".$mod_strings['Custom']."",
				"prevfy"=>"".$mod_strings['Previous FY']."",
				"thisfy"=>"".$mod_strings['Current FY']."",
				"nextfy"=>"".$mod_strings['Next FY']."",
				"prevfq"=>"".$mod_strings['Previous FQ']."",
				"thisfq"=>"".$mod_strings['Current FQ']."",
				"nextfq"=>"".$mod_strings['Next FQ']."",
				"yesterday"=>"".$mod_strings['Yesterday']."",
				"today"=>"".$mod_strings['Today']."",
				"tomorrow"=>"".$mod_strings['Tomorrow']."",
				"lastweek"=>"".$mod_strings['Last Week']."",
				"thisweek"=>"".$mod_strings['Current Week']."",
				"nextweek"=>"".$mod_strings['Next Week']."",
				"lastmonth"=>"".$mod_strings['Last Month']."",
				"thismonth"=>"".$mod_strings['Current Month']."",
				"nextmonth"=>"".$mod_strings['Next Month']."",

		        "before3days"=>"".$mod_strings['Before 3 Days']."",
			    "before7days"=>"".$mod_strings['Before 7 Days']."",
				"before15days"=>"".$mod_strings['Before 15 Days']."",
				"before30days"=>"".$mod_strings['Before 30 Days']."",
				"before60days"=>"".$mod_strings['Before 60 Days']."",
				"before100days"=>"".$mod_strings['Before 100 Days']."",
				"before180days"=>"".$mod_strings['Before 180 Days']."",
                "after3days"=>"".$mod_strings['After 3 Days']."",
				"after7days"=>"".$mod_strings['After 7 Days']."",
				"after15days"=>"".$mod_strings['After 15 Days']."",
				"after30days"=>"".$mod_strings['After 30 Days']."",
				"after60days"=>"".$mod_strings['After 60 Days']."",
				"after100days"=>"".$mod_strings['After 100 Days']."",
				"after180days"=>"".$mod_strings['After 180 Days']."",

                "last3days"=>"".$mod_strings['Last 3 Days']."",
				"last7days"=>"".$mod_strings['Last 7 Days']."",
				"last15days"=>"".$mod_strings['Last 15 Days']."",
				"last30days"=>"".$mod_strings['Last 30 Days']."",
				"last60days"=>"".$mod_strings['Last 60 Days']."",
				"last90days"=>"".$mod_strings['Last 90 Days']."",
				"last180days"=>"".$mod_strings['Last 180 Days']."",
			    "next3days"=>"".$mod_strings['Next 3 Days']."",
				"next7days"=>"".$mod_strings['Next 7 Days']."",
				"next15days"=>"".$mod_strings['Next 15 Days']."",
				"next30days"=>"".$mod_strings['Next 30 Days']."",
				"next60days"=>"".$mod_strings['Next 60 Days']."",
				"next90days"=>"".$mod_strings['Next 90 Days']."",
				"next180days"=>"".$mod_strings['Next 180 Days']."",
					);

				foreach($stdfilter as $FilterKey=>$FilterValue)
				{
					if($FilterKey == $selcriteria)
					{
						$shtml['value'] = $FilterKey;
						$shtml['text'] = $FilterValue;
						$shtml['selected'] = "selected";
					}else
					{
						$shtml['value'] = $FilterKey;
						$shtml['text'] = $FilterValue;
						$shtml['selected'] = "";
					}
					$filter[] = $shtml;
				}
				return $filter;

	}

	/** to get the standard filter criteria scripts
	  * @returns  $jsStr : Type String
	  * This function will return the script to set the start data and end date
	  * for the standard selection criteria
	  */
	function getCriteriaJS()
	{


		$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
		$tomorrow  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
		$yesterday  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));

		$currentmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m"), "01",   date("Y")));
		$currentmonth1 = date("Y-m-t");
		$lastmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
		$lastmonth1 = date("Y-m-t", mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
		$nextmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")+1, "01",   date("Y")));
		$nextmonth1 = date("Y-m-t", mktime(0, 0, 0, date("m")+1, "01",   date("Y")));

		$lastweek0 = date("Y-m-d",strtotime("-2 week Sunday"));
		$lastweek1 = date("Y-m-d",strtotime("-1 week Saturday"));

		$thisweek0 = date("Y-m-d",strtotime("-1 week Sunday"));
		$thisweek1 = date("Y-m-d",strtotime("this Saturday"));

		$nextweek0 = date("Y-m-d",strtotime("this Sunday"));
		$nextweek1 = date("Y-m-d",strtotime("+1 week Saturday"));

		$next3days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+2, date("Y")));
		$next7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+6, date("Y")));
		$next15days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+14, date("Y")));
		$next30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+29, date("Y")));
		$next60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+59, date("Y")));
		$next90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+89, date("Y")));
		$next180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+179, date("Y")));

		$last3days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-2, date("Y")));
		$last7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-6, date("Y")));
		$last15days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-14, date("Y")));
		$last30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-29, date("Y")));
		$last60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-59, date("Y")));
		$last90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-89, date("Y")));
		$last180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-179, date("Y")));

		$before3days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-3, date("Y")));
		$before7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")));
		$before15days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-15, date("Y")));
		$before30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-30, date("Y")));
		$before60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-60, date("Y")));
		$before100days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-100, date("Y")));
		$before180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-180, date("Y")));

		$after3days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+2, date("Y")));
		$after7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+6, date("Y")));
		$after15days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+14, date("Y")));
		$after30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+29, date("Y")));
		$after60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+59, date("Y")));
		$after100days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+99, date("Y")));
		$after180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+179, date("Y")));

		$currentFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")));
		$currentFY1 = date("Y-m-t",mktime(0, 0, 0, "12", date("d"),   date("Y")));
		$lastFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")-1));
		$lastFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")-1));

		$nextFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")+1));
		$nextFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")+1));

		if(date("m") <= 3)
		{
			$cFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
			$cFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
			$nFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
			$nFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
			$pFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")-1));
			$pFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")-1));
		}
		else if(date("m") > 3 and date("m") <= 7)
    	{
			$pFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
		  	$pFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
		  	$cFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
		  	$cFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
      		$nFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
		  	$nFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));

    	}
		else if(date("m") > 7 and date("m") <= 9)
    	{
			$pFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
		  	$pFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));
		  	$cFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
		  	$cFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
      		$nFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
		  	$nFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));

    	}
		else
    	{
		  	$nFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")+1));
		  	$nFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")+1));
		  	$pFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
		  	$pFq1 = date("Y-m-d",mktime(0, 0, 0, "09","31",date("Y")));
      		$cFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
		  	$cFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));
    	}

			$maxdate = "2099-12-31";
			$mindate = "1900-01-01";

		$sjsStr = '<script language="JavaScript" type="text/javaScript">
			function showDateRange( type )
			{
				if (type!="custom")
				{
					document.CustomView.startdate.readOnly=true
						document.CustomView.enddate.readOnly=true
						//getObj("jscal_trigger_date_start").style.visibility="hidden"
						//getObj("jscal_trigger_date_end").style.visibility="hidden"
                        $("#jscal_trigger_date_start").css("visibility","hidden");
						$("#jscal_trigger_date_end").css("visibility","hidden");
				}
				else
				{
					document.CustomView.startdate.readOnly=false
						document.CustomView.enddate.readOnly=false
						$("#jscal_trigger_date_start").css("visibility","visible");
						$("#jscal_trigger_date_end").css("visibility","visible");
				}
				if( type == "today" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$today.'";
				}
				else if( type == "yesterday" )
				{
					document.CustomView.startdate.value = "'.$yesterday.'";
					document.CustomView.enddate.value = "'.$yesterday.'";
				}
				else if( type == "tomorrow" )
				{

					document.CustomView.startdate.value = "'.$tomorrow.'";
					document.CustomView.enddate.value = "'.$tomorrow.'";
				}
				else if( type == "thisweek" )
				{
					document.CustomView.startdate.value = "'.$thisweek0.'";
					document.CustomView.enddate.value = "'.$thisweek1.'";
				}
				else if( type == "lastweek" )
				{
					document.CustomView.startdate.value = "'.$lastweek0.'";
					document.CustomView.enddate.value = "'.$lastweek1.'";
				}
				else if( type == "nextweek" )
				{
					document.CustomView.startdate.value = "'.$nextweek0.'";
					document.CustomView.enddate.value = "'.$nextweek1.'";
				}
				else if( type == "thismonth" )
				{
					document.CustomView.startdate.value = "'.$currentmonth0.'";
					document.CustomView.enddate.value = "'.$currentmonth1.'";
				}
				else if( type == "lastmonth" )
				{
					document.CustomView.startdate.value = "'.$lastmonth0.'";
					document.CustomView.enddate.value = "'.$lastmonth1.'";
				}
				else if( type == "nextmonth" )
				{
					document.CustomView.startdate.value = "'.$nextmonth0.'";
					document.CustomView.enddate.value = "'.$nextmonth1.'";
				}
				else if( type == "before3days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before3days.'";
				}
				else if( type == "before7days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before7days.'";
				}
				else if( type == "before15days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before15days.'";
				}
				else if( type == "before30days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before30days.'";
				}
				else if( type == "before60days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before60days.'";
				}
				else if( type == "before100days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before100days.'";
				}
				else if( type == "before180days" )
				{
					document.CustomView.startdate.value = "'.$mindate.'";
					document.CustomView.enddate.value = "'.$before180days.'";
				}
				else if( type == "after3days" )
				{
					document.CustomView.startdate.value = "'.$after3days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "after7days" )
				{
					document.CustomView.startdate.value = "'.$after7days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "after15days" )
				{
					document.CustomView.startdate.value = "'.$after15days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "after30days" )
				{
					document.CustomView.startdate.value = "'.$after30days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "after60days" )
				{
					document.CustomView.startdate.value = "'.$after60days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "after100days" )
				{
					document.CustomView.startdate.value = "'.$after100days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "after180days" )
				{
					document.CustomView.startdate.value = "'.$after180days.'";
					document.CustomView.enddate.value = "'.$maxdate.'";
				}
				else if( type == "next3days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next3days.'";
				}
				else if( type == "next7days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next7days.'";
				}
				else if( type == "next15days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next15days.'";
				}
				else if( type == "next30days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next30days.'";
				}
				else if( type == "next60days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next60days.'";
				}
				else if( type == "next90days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next90days.'";
				}
				else if( type == "next180days" )
				{
					document.CustomView.startdate.value = "'.$today.'";
					document.CustomView.enddate.value = "'.$next180days.'";
				}
				else if( type == "last3days" )
				{
					document.CustomView.startdate.value = "'.$last3days.'";
					document.CustomView.enddate.value =  "'.$today.'";
				}
				else if( type == "last7days" )
				{
					document.CustomView.startdate.value = "'.$last7days.'";
					document.CustomView.enddate.value =  "'.$today.'";
				}
				else if( type == "last15days" )
				{
					document.CustomView.startdate.value = "'.$last15days.'";
					document.CustomView.enddate.value =  "'.$today.'";
				}
				else if( type == "last30days" )
				{
					document.CustomView.startdate.value = "'.$last30days.'";
					document.CustomView.enddate.value = "'.$today.'";
				}
				else if( type == "last60days" )
				{
					document.CustomView.startdate.value = "'.$last60days.'";
					document.CustomView.enddate.value = "'.$today.'";
				}
				else if( type == "last90days" )
				{
					document.CustomView.startdate.value = "'.$last90days.'";
					document.CustomView.enddate.value = "'.$today.'";
				}
				else if( type == "last180days" )
				{
					document.CustomView.startdate.value = "'.$last180days.'";
					document.CustomView.enddate.value = "'.$today.'";
				}
				else if( type == "thisfy" )
				{
					document.CustomView.startdate.value = "'.$currentFY0.'";
					document.CustomView.enddate.value = "'.$currentFY1.'";
				}
				else if( type == "prevfy" )
				{
					document.CustomView.startdate.value = "'.$lastFY0.'";
					document.CustomView.enddate.value = "'.$lastFY1.'";
				}
				else if( type == "nextfy" )
				{
					document.CustomView.startdate.value = "'.$nextFY0.'";
					document.CustomView.enddate.value = "'.$nextFY1.'";
				}
				else if( type == "nextfq" )
				{
					document.CustomView.startdate.value = "'.$nFq.'";
					document.CustomView.enddate.value = "'.$nFq1.'";
				}
				else if( type == "prevfq" )
				{
					document.CustomView.startdate.value = "'.$pFq.'";
					document.CustomView.enddate.value = "'.$pFq1.'";
				}
				else if( type == "thisfq" )
				{
					document.CustomView.startdate.value = "'.$cFq.'";
					document.CustomView.enddate.value = "'.$cFq1.'";
				}
				else
				{
					document.CustomView.startdate.value = "";
					document.CustomView.enddate.value = "";
				}
			}
		</script>';

		return $sjsStr;
	}

	/** to get the standard filter for the given customview Id
	  * @param $cvid :: Type Integer
	  * @returns  $stdfilterlist Array in the following format
	  * $stdfilterlist = Array( 'columnname' =>  $tablename:$columnname:$fieldname:$module_$fieldlabel,'stdfilter'=>$stdfilter,'startdate'=>$startdate,'enddate'=>$enddate)
	  */

	function getStdFilterByCvid($cvid)
	{
		global $log;
		$log->debug("Entering getStdFilterByCvid() method ...");
		global $current_user;
		//changed by dingjianting on 2007-10-3 for cache HeaderArray
		$key = "stdfilterlist_".$cvid;
		$stdfilterlist = getSqlCacheData($key);
		if(!$stdfilterlist) {
			global $adb;
			$sSQL = "select ec_cvstdfilter.* from ec_cvstdfilter inner join ec_customview on ec_customview.cvid = ec_cvstdfilter.cvid";
			$sSQL .= " where ec_cvstdfilter.cvid=".$cvid;

			$stdfilterrow = $adb->getFirstLine($sSQL);
			$stdfilterlist["columnname"] = $stdfilterrow["columnname"];
			$stdfilterlist["stdfilter"] = $stdfilterrow["stdfilter"];

			if($stdfilterrow["stdfilter"] == "custom")
			{
				if(isValidDate($stdfilterrow["startdate"]))
				{
					$stdfilterlist["startdate"] = $stdfilterrow["startdate"];
				}
				if(isValidDate($stdfilterrow["enddate"]))
				{
					$stdfilterlist["enddate"] = $stdfilterrow["enddate"];
				}
			}else  //if it is not custom get the date according to the selected duration
			{
				$datefilter = $this->getDateforStdFilterBytype($stdfilterrow["stdfilter"]);
				$stdfilterlist["startdate"] = $datefilter[0];
				$stdfilterlist["enddate"] = $datefilter[1];
			}
			setSqlCacheData($key,$stdfilterlist);
		}
		$log->debug("Exiting getStdFilterByCvid method ...");
		return $stdfilterlist;
	}

	/** to get the Advanced filter for the given customview Id
	  * @param $cvid :: Type Integer
	  * @returns  $stdfilterlist Array in the following format
	  * $stdfilterlist = Array( 0=>Array('columnname' =>  $tablename:$columnname:$fieldname:$module_$fieldlabel,'comparator'=>$comparator,'value'=>$value),
	  *			    1=>Array('columnname' =>  $tablename1:$columnname1:$fieldname1:$module_$fieldlabel1,'comparator'=>$comparator1,'value'=>$value1),
	  *		   			|
	  *			    4=>Array('columnname' =>  $tablename4:$columnname4:$fieldname4:$module_$fieldlabel4,'comparator'=>$comparatorn,'value'=>$valuen),
	  */
    function getAdvFilterByCvid($cvid)
	{
		global $log;
		$log->debug("Entering getAdvFilterByCvid() method ...");
		global $current_user;
		//changed by dingjianting on 2007-10-3 for cache HeaderArray
		$key = "advfilterlist_".$cvid;
		$advfilterlist = getSqlCacheData($key);
		if(!$advfilterlist) {
			global $adb;
			global $modules;

			$sSQL = "select ec_cvadvfilter.* from ec_cvadvfilter inner join ec_customview on ec_cvadvfilter.cvid = ec_customview.cvid";
			$sSQL .= " where ec_cvadvfilter.cvid=".$cvid;
			$result = $adb->getList($sSQL);
			foreach($result as $advfilterrow)
			{
				$advft["columnname"] = $advfilterrow["columnname"];
				$advft["comparator"] = $advfilterrow["comparator"];
				$advft["value"] = $advfilterrow["value"];
				$advfilterlist[] = $advft;
			}
			setSqlCacheData($key,$advfilterlist);
		}
		$log->debug("Exiting advfilterlist method ...");
		return $advfilterlist;
	}

    function getColumnsListByCvidWithCollect($cvid)
	{
		global $log;
        $log->debug("Entering getColumnsListByCvid(".$cvid.") method ...");
		global $current_user;
		//changed by dingjianting on 2007-10-3 for cache HeaderArray
		$key = "columnlistwithcollect_".$cvid;

		$columnlist = getSqlCacheData($key);
		if(!$columnlist) {
			global $adb;
			$sSQL = "select ec_cvcolumnlist.* from ec_cvcolumnlist";
			$sSQL .= " inner join ec_customview on ec_customview.cvid = ec_cvcolumnlist.cvid";
			$sSQL .= " where ec_customview.cvid =".$cvid." order by ec_cvcolumnlist.columnindex";
			
			$result = $adb->getList($sSQL);
			foreach($result as $columnrow)
			{
				$columnlist[$columnrow['columnindex']] = $columnrow['columnname'];
			}
            $customviewdtls = $this->getCustomViewByCvid($cvid);
            $othercolumnname=$customviewdtls["collectcolumn"];
            if(!in_array($othercolumnname,$columnlist)){
                $columnlist[]=$othercolumnname;
            }
			setSqlCacheData($key,$columnlist);
		}
		$log->debug("Exiting getColumnsListByCvid method ...");
		return $columnlist;
	}
	/** to get the customview Columnlist Query for the given customview Id
	  * @param $cvid :: Type Integer
	  * @returns  $getCvColumnList as a string
	  * This function will return the columns for the given customfield in comma seperated values in the format
	  *                     $tablename.$columnname,$tablename1.$columnname1, ------ $tablenamen.$columnnamen
	  *
	  */
	function getCvColumnListSQL($cvid)
	{	
		$columnslist = $this->getColumnsListByCvidWithCollect($cvid);
		$returnsql = "";
		$sqllist = array();
		if(isset($columnslist))
		{
			foreach($columnslist as $columnname=>$value)
			{
				$tablefield = "";
				$value = trim($value);
				if($value != "")
				{
					$list = explode(":",$value);

					//Added For getting status for Activities -Jaguar
					$sqllist_column = $list[0].".".$list[1];
					//Added for for assigned to sorting
					if($list[1] == "smownerid")
					{
						$sqllist_column = "ec_users.user_name";
					}

					$sqllist[] = $sqllist_column;
					//Ends

					$tablefield[$list[0]] = $list[1];
					$fieldlabel = trim(str_replace($this->escapemodule," ",$list[3]));
					$this->list_fields[$fieldlabel] = $tablefield;
					$this->list_fields_name[$fieldlabel] = $list[2];
				}
			}
			if(is_array($sqllist)) {
				$returnsql = implode(",",$sqllist);
			}
		}
		return $returnsql;

	}

	/** to get the customview stdFilter Query for the given customview Id
	  * @param $cvid :: Type Integer
	  * @returns  $stdfiltersql as a string
	  * This function will return the standard filter criteria for the given customfield
	  *
	  */
	function getCVStdFilterSQL($cvid)
	{
		global $adb;
		$stdfiltersql = "";
		$stdfilterlist = $this->getStdFilterByCvid($cvid);
		if(isset($stdfilterlist))
		{
			foreach($stdfilterlist as $columnname=>$value)
			{
				if($columnname == "columnname")
				{
					$filtercolumn = $value;
				}elseif($columnname == "stdfilter")
				{
					$filtertype = $value;
				}elseif($columnname == "startdate")
				{
					$startdate = $value;
				}elseif($columnname == "enddate")
				{
					$enddate = $value;
				}
			}
			if($filtertype != "custom")
			{
				$datearray = $this->getDateforStdFilterBytype($filtertype);
				$startdate = $datearray[0];
				$enddate = $datearray[1];
			}
			if(isset($startdate) && $startdate != "" && isset($enddate) && $enddate != "")
			{
				$startdate = getDisplayDate($startdate);
				$enddate = getDisplayDate($enddate);
				$columns = explode(":",$filtercolumn);
				if($startdate != "" && $enddate != "") {
					$stdfiltersql = $columns[0].".".$columns[1]." between '".$startdate." 00:00:00' and '".$enddate." 23:59:00'";
				} elseif($startdate == "" && $enddate != "") {
					$stdfiltersql = $columns[0].".".$columns[1]." < '".$enddate." 23:59:00'";
				} elseif($startdate != "" && $enddate == "") {
					$stdfiltersql = $columns[0].".".$columns[1]." > '".$startdate." 00:00:00'";
				} else {
					$stdfiltersql = "";
				}

			}
		}
		return $stdfiltersql;
	}
	/** to get the customview AdvancedFilter Query for the given customview Id
	  * @param $cvid :: Type Integer
	  * @returns  $advfiltersql as a string
	  * This function will return the advanced filter criteria for the given customfield
	  *
	  */
	function getCVAdvFilterSQL($cvid)
	{
		$advfsql = "";
		$advfilter = $this->getAdvFilterByCvid($cvid);
		if(isset($advfilter) && is_array($advfilter))
		{
			foreach($advfilter as $key=>$advfltrow)
			{
				if(isset($advfltrow))
				{
					$columns = explode(":",$advfltrow["columnname"]);
					$datatype = (isset($columns[4])) ? $columns[4] : "";
					$advfltrow["columnname"] = trim($advfltrow["columnname"]);
					$advfltrow["comparator"] = trim($advfltrow["comparator"]);
					if($advfltrow["columnname"] != "" && $advfltrow["comparator"] != "")
					{

						$valuearray = explode(",",trim($advfltrow["value"]));
						if(isset($valuearray) && count($valuearray) > 1)
						{
							$advorsql = "";
							for($n=0;$n<count($valuearray);$n++)
							{
								$advorsql[] = $this->getRealValues($columns[0],$columns[1],$advfltrow["comparator"],trim($valuearray[$n]),$datatype);
							}
							$advorsqls = implode(" or ",$advorsql);
							$advfiltersql[] = " (".$advorsqls.") ";
						}else
						{
							//Added for getting ec_activity Status -Jaguar
							if($this->customviewmodule == "Calendar" && $columns[1] == "status")
							{
								$advfiltersql[] = "case when (ec_activity.status not like '') then ec_activity.status else ec_activity.eventstatus end".$this->getAdvComparator($advfltrow["comparator"],trim($advfltrow["value"]),$datatype);
							}
							else
							{
								$advfiltersql[] = $this->getRealValues($columns[0],$columns[1],$advfltrow["comparator"],trim($advfltrow["value"]),$datatype);
							}
						}
					}
				}
			}
		}
		if(isset($advfiltersql))
		{
			$advfsql = implode(" and ",$advfiltersql);
		}
		return $advfsql;
	}

	/** to get the realvalues for the given value
	  * @param $tablename :: type string
	  * @param $fieldname :: type string
	  * @param $comparator :: type string
	  * @param $value :: type string
	  * @returns  $value as a string in the following format
	  *	  $tablename.$fieldname comparator
	  */
	function getRealValues($tablename,$fieldname,$comparator,$value,$datatype)
	{
		if($fieldname == "smownerid" || $fieldname == "approvedby" || $fieldname == "smcreatorid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,getUserId_Ol($value),$datatype);
		}else if($fieldname == "parentid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getAccountId($value),$datatype);
		}else if($fieldname == "accountid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getAccountId($value),$datatype);
		}else if($fieldname == "contactid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getContactId($value),$datatype);
		}else if($fieldname == "vendor_id" || $fieldname == "vendorid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getVendorId($value),$datatype);
		}else if($fieldname == "potentialid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getPotentialId($value),$datatype);
		}else if($fieldname == "quoteid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getQuoteId($value),$datatype);
		}
		else if($fieldname == "product_id")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getProductId($value),$datatype);
		}
		else if($fieldname == "salesorderid")
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$this->getSoId($value),$datatype);
		}
		else if($fieldname == "crmid" || $fieldname == "parent_id")
		{
			//Added on 14-10-2005 -- for HelpDesk
			if($this->customviewmodule == 'HelpDesk' && $fieldname == "crmid")
			{
				$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$value,$datatype);
			}
			else
			{
				$value = $tablename.".".$fieldname." in (".$this->getSalesEntityId($value).") ";
			}
		}
		else
		{
			$value = $tablename.".".$fieldname.$this->getAdvComparator($comparator,$value,$datatype);
		}
		return $value;
	}

	/** to get the entityId for the given module
	  * @param $setype :: type string
	  * @returns  $parent_id as a string of comma seperated id
	  *       $id,$id1,$id2, ---- $idn
	  */

	function getSalesEntityId($setype)
	{
                global $log;
                $log->info("in getSalesEntityId ".$setype);
		global $adb;
		$sql = "select crmid from ec_crmentity where setype='".$setype."'";
		$result = $adb->getList($sql);
		foreach($result as $row)
		{
			$parent_id[] = $row["crmid"];
		}
		if(isset($parent_id))
		{
			$parent_id = implode(",",$parent_id);
		}else
		{
			$parent_id = 0;
		}
		return $parent_id;
	}

	/** to get the salesorder id for the given sales order subject
	  * @param $so_name :: type string
	  * @returns  $so_id as a Integer
	  */

	function getSoId($so_name)
	{
		global $log;
                $log->info("in getSoId ".$so_name);
		global $adb;
		if($so_name != '')
		{
			$sql = "select salesorderid from ec_salesorder where subject='".$so_name."'";
			$result = $adb->query($sql);
			$so_id = $adb->query_result($result,0,"salesorderid");
		}
		return $so_id;
	}

	/** to get the Product id for the given Product Name
	  * @param $product_name :: type string
	  * @returns  $productid as a Integer
	  */

	function getProductId($product_name)
	{
		global $log;
                $log->info("in getProductId ".$product_name);
		global $adb;
		if($product_name != '')
		{
			$sql = "select productid from ec_products where productname='".$product_name."'";
			$result = $adb->query($sql);
			$productid = $adb->query_result($result,0,"productid");
		}
		return $productid;
	}

	/** to get the Quote id for the given Quote Name
	  * @param $quote_name :: type string
	  * @returns  $quote_id as a Integer
	  */

	function getQuoteId($quote_name)
	{
		global $log;
                $log->info("in getQuoteId ".$quote_name);
		global $adb;
		if($quote_name != '')
		{
			$sql = "select quoteid from ec_quotes where subject='".$quote_name."'";
			$result = $adb->query($sql);
			$quote_id = $adb->query_result($result,0,"quoteid");
		}
		return $quote_id;
	}

	/** to get the Potential  id for the given Potential Name
	  * @param $pot_name :: type string
	  * @returns  $potentialid as a Integer
	  */

	function getPotentialId($pot_name)
	{
		 global $log;
                $log->info("in getPotentialId ".$pot_name);
		global $adb;
		if($pot_name != '')
		{
			$sql = "select potentialid from ec_potential where potentialname='".$pot_name."'";
			$result = $adb->query($sql);
			$potentialid = $adb->query_result($result,0,"potentialid");
		}
		return $potentialid;
	}

	/** to get the Vendor id for the given Vendor Name
	  * @param $vendor_name :: type string
	  * @returns  $vendor_id as a Integer
	  */


	function getVendorId($vendor_name)
	{
		 global $log;
                $log->info("in getVendorId ".$vendor_name);
		global $adb;
		if($vendor_name != '')
		{
			$sql = "select vendorid from ec_vendor where vendorname='".$vendor_name."'";
			$result = $adb->query($sql);
			$vendor_id = $adb->query_result($result,0,"vendorid");
		}
		return $vendor_id;
	}

	/** to get the Contact id for the given Contact Name
	  * @param $contact_name :: type string
	  * @returns  $contact_id as a Integer
	  */


	function getContactId($contact_name)
	{
		global $log;
                $log->info("in getContactId ".$contact_name);
		global $adb;
		if($contact_name != '')
		{
			$sql = "select contactid from ec_contactdetails where lastname='".$contact_name."'";
			$result = $adb->query($sql);
			$contact_id = $adb->query_result($result,0,"contactid");
		}
		return $contact_id;
	}

	/** to get the Account id for the given Account Name
	  * @param $account_name :: type string
	  * @returns  $accountid as a Integer
	  */

	function getAccountId($account_name)
	{
		 global $log;
                $log->info("in getAccountId ".$account_name);
		global $adb;
		if($account_name != '')
		{
			$sql = "select accountid from ec_account where accountname='".$account_name."'";
			$result = $adb->query($sql);
			$accountid = $adb->query_result($result,0,"accountid");
		}
		return $accountid;
	}

	/** to get the comparator value for the given comparator and value
	  * @param $comparator :: type string
	  * @param $value :: type string
	  * @returns  $rtvalue in the format $comparator $value
	  */

	function getAdvComparator($comparator,$value,$datatype = '')
	{

		global $adb;
		if($comparator == "e")
		{
			if(trim($value) == "NULL")
			{
				$rtvalue = " is NULL";
			}elseif(trim($value) != "")
			{
				$rtvalue = " = ".$adb->quote($value);
			}elseif(trim($value) == "" && $datatype == "V")
			{
				$rtvalue = " = ".$adb->quote($value);
			}else
			{
				$rtvalue = " is NULL";
			}
		}
		if($comparator == "n")
		{
			if(trim($value) == "NULL")
			{
				$rtvalue = " is NOT NULL";
			}elseif(trim($value) != "")
			{
				$rtvalue = " <> ".$adb->quote($value);
			}elseif(trim($value) == "" && $datatype == "V")
			{
				$rtvalue = " <> ".$adb->quote($value);
			}else
			{
				$rtvalue = " is NOT NULL";
			}
		}
		if($comparator == "s")
		{
			$rtvalue = " like ".$adb->quote($value."%");
		}
		if($comparator == "c")
		{
			$rtvalue = " like ".$adb->quote("%".$value."%");
		}
		if($comparator == "k")
		{
			$rtvalue = " not like ".$adb->quote("%".$value."%");
		}
		if($comparator == "l")
		{
			$rtvalue = " < ".$adb->quote($value);
		}
		if($comparator == "g")
		{
			$rtvalue = " > ".$adb->quote($value);
		}
		if($comparator == "m")
		{
			$rtvalue = " <= ".$adb->quote($value);
		}
		if($comparator == "h")
		{
			$rtvalue = " >= ".$adb->quote($value);
		}

		return $rtvalue;
	}

	/** to get the date value for the given type
	  * @param $type :: type string
	  * @returns  $datevalue array in the following format
	  *             $datevalue = Array(0=>$startdate,1=>$enddate)
	  */

	function getDateforStdFilterBytype($type)
	{
		//$thisyear = date("Y");
		$maxdate = "2099-12-31";
		$mindate = "1900-01-01";
		$datevalue = array();

		if($type == "today" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $today;
		}
		elseif($type == "yesterday" )
		{
			$yesterday  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
			$datevalue[0] = $yesterday;
			$datevalue[1] = $yesterday;
		}
		elseif($type == "tomorrow" )
		{
			$tomorrow  = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+1, date("Y")));
			$datevalue[0] = $tomorrow;
			$datevalue[1] = $tomorrow;
		}
		elseif($type == "thisweek" )
		{
			$thisweek0 = date("Y-m-d",strtotime("-1 week Sunday"));
			$thisweek1 = date("Y-m-d",strtotime("this Saturday"));
			$datevalue[0] = $thisweek0;
			$datevalue[1] = $thisweek1;
		}
		elseif($type == "lastweek" )
		{
			$lastweek0 = date("Y-m-d",strtotime("-2 week Sunday"));
			$lastweek1 = date("Y-m-d",strtotime("-1 week Saturday"));
			$datevalue[0] = $lastweek0;
			$datevalue[1] = $lastweek1;
		}
		elseif($type == "nextweek" )
		{
			$nextweek0 = date("Y-m-d",strtotime("this Sunday"));
		    $nextweek1 = date("Y-m-d",strtotime("+1 week Saturday"));
			$datevalue[0] = $nextweek0;
			$datevalue[1] = $nextweek1;
		}
		elseif($type == "thismonth" )
		{
			$currentmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m"), "01",   date("Y")));
			$currentmonth1 = date("Y-m-t");
			$datevalue[0] =$currentmonth0;
			$datevalue[1] = $currentmonth1;
		}

		elseif($type == "lastmonth" )
		{
			$lastmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
			$lastmonth1 = date("Y-m-t", mktime(0, 0, 0, date("m")-1, "01",   date("Y")));
			$datevalue[0] = $lastmonth0;
			$datevalue[1] = $lastmonth1;
		}
		elseif($type == "nextmonth" )
		{
			$nextmonth0 = date("Y-m-d",mktime(0, 0, 0, date("m")+1, "01",   date("Y")));
		    $nextmonth1 = date("Y-m-t", mktime(0, 0, 0, date("m")+1, "01",   date("Y")));
			$datevalue[0] = $nextmonth0;
			$datevalue[1] = $nextmonth1;
		}
		elseif($type == "next3days" )
		{
			$next7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+2, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $next7days;
		}
		elseif($type == "next7days" )
		{
			$next7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+6, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $next7days;
		}
		elseif($type == "next15days" )
		{
			$next7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+14, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $next7days;
		}
		elseif($type == "next30days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$next30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+29, date("Y")));

			$datevalue[0] =$today;
			$datevalue[1] =$next30days;
		}
		elseif($type == "next60days" )
		{

			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$next60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+59, date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $next60days;
		}
		elseif($type == "next90days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$next90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+89, date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $next90days;
		}
		elseif($type == "next180days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$next180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+179, date("Y")));
			$datevalue[0] = $today;
			$datevalue[1] = $next180days;
		}
		elseif($type == "before3days" )
		{
			$before7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-3, date("Y")));
			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $mindate;
			$datevalue[1] = $before7days;
		}
		elseif($type == "before7days" )
		{
			$before7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-7, date("Y")));
			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $mindate;
			$datevalue[1] = $before7days;
		}
		elseif($type == "before15days" )
		{
			$before7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-15, date("Y")));
			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $mindate;
			$datevalue[1] = $before7days;
		}
		elseif($type == "before30days" )
		{
			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$before30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-30, date("Y")));

			$datevalue[0] =$mindate;
			$datevalue[1] =$before30days;
		}
		elseif($type == "before60days" )
		{

			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$before60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-60, date("Y")));
			$datevalue[0] = $mindate;
			$datevalue[1] = $before60days;
		}
		elseif($type == "before100days" )
		{
			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$before100days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-100, date("Y")));
			$datevalue[0] = $mindate;
			$datevalue[1] = $before100days;
		}
		elseif($type == "before180days" )
		{
			//$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$before180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-180, date("Y")));
			$datevalue[0] = $mindate;
			$datevalue[1] = $before180days;
		}
		elseif($type == "after3days" )
		{
			$after7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+2, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $after7days;
			$datevalue[1] = $maxdate;
		}
		elseif($type == "after7days" )
		{
			$after7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+6, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $after7days;
			$datevalue[1] = $maxdate;
		}
		elseif($type == "after15days" )
		{
			$after7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+14, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $after7days;
			$datevalue[1] = $maxdate;
		}
		elseif($type == "after30days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$after30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+29, date("Y")));

			$datevalue[0] =$after30days;
			$datevalue[1] =$maxdate;
		}
		elseif($type == "after60days" )
		{

			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$after60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+59, date("Y")));
			$datevalue[0] = $after60days;
			$datevalue[1] = $maxdate;
		}
		elseif($type == "after100days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$after100days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+99, date("Y")));
			$datevalue[0] = $after100days;
			$datevalue[1] = $maxdate;
		}
		elseif($type == "after180days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$after180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")+179, date("Y")));
			$datevalue[0] = $after180days;
			$datevalue[1] = $maxdate;
		}
		elseif($type == "last3days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$last7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-2, date("Y")));
			$datevalue[0] = $last7days;
			$datevalue[1] = $today;
		}
		elseif($type == "last7days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$last7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-6, date("Y")));
			$datevalue[0] = $last7days;
			$datevalue[1] = $today;
		}
		elseif($type == "last15days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$last7days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-14, date("Y")));
			$datevalue[0] = $last7days;
			$datevalue[1] = $today;
		}
		elseif($type == "last30days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$last30days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-29, date("Y")));
			$datevalue[0] = $last30days;
			$datevalue[1] =  $today;
		}
		elseif($type == "last60days" )
		{
			$last60days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-59, date("Y")));
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$datevalue[0] = $last60days;
			$datevalue[1] = $today;
		}
		else if($type == "last90days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$last90days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-89, date("Y")));
			$datevalue[0] = $last90days;
			$datevalue[1] = $today;
		}
		elseif($type == "last180days" )
		{
			$today = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d"), date("Y")));
			$last180days = date("Y-m-d",mktime(0, 0, 0, date("m")  , date("d")-179, date("Y")));
			$datevalue[0] = $last180days;
			$datevalue[1] = $today;
		}
		elseif($type == "thisfy" )
		{
			$currentFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")));
			$currentFY1 = date("Y-m-t",mktime(0, 0, 0, "12", date("d"),   date("Y")));
			$datevalue[0] = $currentFY0;
			$datevalue[1] = $currentFY1;
		}
		elseif($type == "prevfy" )
		{
			$lastFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")-1));
			$lastFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")-1));
			$datevalue[0] = $lastFY0;
			$datevalue[1] = $lastFY1;
		}
		elseif($type == "nextfy" )
		{
			$nextFY0 = date("Y-m-d",mktime(0, 0, 0, "01", "01",   date("Y")+1));
			$nextFY1 = date("Y-m-t", mktime(0, 0, 0, "12", date("d"), date("Y")+1));
			$datevalue[0] = $nextFY0;
			$datevalue[1] = $nextFY1;
		}
		elseif($type == "nextfq" )
		{
			if(date("m") <= 3)
			{
				$nFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
				$nFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));
    		}else if(date("m") > 3 and date("m") <= 6)
    		{
				$nFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
				$nFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));

    		}
			else if(date("m") > 6 and date("m") <= 9)
    		{
				$nFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
				$nFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));

    		}
			else
    		{
				$nFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")+1));
				$nFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")+1));
    		}
			$datevalue[0] = $nFq;
			$datevalue[1] = $nFq1;
		}
		elseif($type == "prevfq" )
		{
			if(date("m") <= 3)
			{
				$pFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")-1));
				$pFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")-1));
    		}
			else if(date("m") > 3 and date("m") <= 6)
    		{
				$pFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
				$pFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));

    		}
			else if(date("m") > 6 and date("m") <= 9)
    		{
				$pFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
				$pFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));

    		}
			else
    		{
				$pFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
				$pFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));
    		}
			$datevalue[0] = $pFq;
			$datevalue[1] = $pFq1;
		}
		elseif($type == "thisfq")
		{
			if(date("m") <= 3)
			{
				$cFq = date("Y-m-d",mktime(0, 0, 0, "01","01",date("Y")));
				$cFq1 = date("Y-m-d",mktime(0, 0, 0, "03","31",date("Y")));

    		}
			else if(date("m") > 3 and date("m") <= 6)
    		{
				$cFq = date("Y-m-d",mktime(0, 0, 0, "04","01",date("Y")));
				$cFq1 = date("Y-m-d",mktime(0, 0, 0, "06","30",date("Y")));

    		}
			else if(date("m") > 6 and date("m") <= 9)
    		{
				$cFq = date("Y-m-d",mktime(0, 0, 0, "07","01",date("Y")));
				$cFq1 = date("Y-m-d",mktime(0, 0, 0, "09","30",date("Y")));

    		}
			else
    		{
				$cFq = date("Y-m-d",mktime(0, 0, 0, "10","01",date("Y")));
				$cFq1 = date("Y-m-d",mktime(0, 0, 0, "12","31",date("Y")));
    		}
			$datevalue[0] = $cFq;
			$datevalue[1] = $cFq1;
		}
		else
		{
			$datevalue[0] = "";
			$datevalue[1] = "";
		}

		return $datevalue;
	}

	/** to get the customview query for the given customview
	  * @param $viewid (custom view id):: type Integer
	  * @param $listquery (List View Query):: type string
	  * @param $module (Module Name):: type string
	  * @returns  $query
	  */

	function getModifiedCvListQuery($viewid,$listquery,$module,$is_popup=false,$module_focus=false)
	{   
		$entityArr = getEntityTable($module);

		$ec_crmentity = $entityArr["tablename"];
		$entityidfield = $entityArr["entityidfield"];
		$crmid = $ec_crmentity.".".$entityidfield; 
		if(!$is_popup) {
			$fieldquery = $this->getCvColumnListSQL($viewid); 
			
			if($viewid != "" && $listquery != "" && $fieldquery != "")
			{

				$listviewquery = substr($listquery, strpos($listquery,'FROM'),strlen($listquery));
				if($module == "Calendar" || $module == "Emails")
				{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
				}else if($module == "Notes")
				{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
				}
				else if($module == "Products")
				{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
				}
				else if($module == "Vendors")
				{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
				}
				else if($module == "PriceBooks")
				{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
				}
				else if($module == "Faq")
					{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
				}
				else
				{
					$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;

				}
				$stdfiltersql = $this->getCVStdFilterSQL($viewid);
				$advfiltersql = $this->getCVAdvFilterSQL($viewid);
				if(isset($stdfiltersql) && $stdfiltersql != '' && $stdfiltersql != '()')
				{
					$query .= ' and '.$stdfiltersql;
				}
				if(isset($advfiltersql) && $advfiltersql != '' && $advfiltersql != '()')
				{
					$query .= ' and '.$advfiltersql;
				}

			} else {
				$query = $listquery;
			}
			
		} else {
			if($module_focus && is_array($module_focus->search_fields)) {
				$listviewquery = substr($listquery, strpos($listquery,'FROM'),strlen($listquery));
				$fieldquery = "";
				foreach($module_focus->search_fields as $name=>$tableinfo)
				{
					$tablename = key($tableinfo);
					$fieldname = current($tableinfo);
					$tablename = trim($tablename);
					$table_prefix = substr($tablename,0,3);
					if($table_prefix != "ec_") {
						$tablename = "ec_".$tablename;
					}
					if($fieldname == "smownerid") {
						$fieldquery .= "ec_users.user_name,";
					} else {
						$fieldquery .= $tablename.'.'.$fieldname.',';
					}
				}
				$query = "select ".$fieldquery." ".$crmid." as crmid ".$listviewquery;
			} else {
				$query = $listquery;
			}
			if($viewid != "") {
				$stdfiltersql = $this->getCVStdFilterSQL($viewid);
				$advfiltersql = $this->getCVAdvFilterSQL($viewid);
				if(isset($stdfiltersql) && $stdfiltersql != '')
				{
					$query .= ' and '.$stdfiltersql;
				}
				if(isset($advfiltersql) && $advfiltersql != '')
				{
					$query .= ' and '.$advfiltersql;
				}
			}
		}
		return $query;
	}

    /** to get the customview query for the given customview
	  * @param $viewid (custom view id):: type Integer
	  * @param $listquery (List View Query):: type string
	  * @param $module (Module Name):: type string
	  * @returns  $query
	  */
      //$type: 1.current page sql 2. all records sql
	function getModifiedCollectListQuery($viewid,$listquery,$module,$customviewdtls,$type)
	{

			if($viewid != "" && $listquery != "" )
			{
				$querystr=$customviewdtls["collectcolumn"];
                $list = explode(":",$querystr);
                if($type==1){
                    $fieldquery = $list[0].".".$list[1];
                }elseif($type==2){
                    $fieldquery = "sum(".$list[0].".".$list[1].") as ".$list[1]."_total";
                }
				$listviewquery = substr($listquery, strpos($listquery,'FROM'),strlen($listquery));
				$query = "select ".$fieldquery." ".$listviewquery;
				$stdfiltersql = $this->getCVStdFilterSQL($viewid);
				$advfiltersql = $this->getCVAdvFilterSQL($viewid);
				if(isset($stdfiltersql) && $stdfiltersql != '' && $stdfiltersql != '()')
				{
					$query .= ' and '.$stdfiltersql;
				}
				if(isset($advfiltersql) && $advfiltersql != '' && $advfiltersql != '()')
				{
					$query .= ' and '.$advfiltersql;
				}

			} else {
				$query = $listquery;
			}

		return $query;
	}

	function getNewCvListQuery($viewid,$listquery,$module,$is_popup=false)
	{
		$entityArr = getEntityTable($module);
		$ec_crmentity = $entityArr["tablename"];
		$entityidfield = $entityArr["entityidfield"];
		$crmid = $ec_crmentity.".".$entityidfield;
		if(!$is_popup) {
			$key = "cvlistquery".$module."_".$viewid;
			$query = getSqlCacheData($key);
			if(!$query) {
				$fieldquery = $this->getNewCvColumnListSQL($viewid);
				if($viewid != "" && $listquery != "" && $fieldquery != "")
				{

					$listviewquery = substr($listquery, strpos($listquery,'FROM'),strlen($listquery));
					if($module != "Calendar")
					{
						$query = "select ".$fieldquery." ,".$crmid." as crmid ".$listviewquery;
					}
					else
					{
						$query = "select ".$fieldquery." ,".$crmid." as crmid,ec_activity.* ".$listviewquery;
					}
					$stdfiltersql = $this->getCVStdFilterSQL($viewid);
					$advfiltersql = $this->getCVAdvFilterSQL($viewid);
					if(isset($stdfiltersql) && $stdfiltersql != '' && $stdfiltersql != '()')
					{
						$query .= ' and '.$stdfiltersql;
					}
					if(isset($advfiltersql) && $advfiltersql != '' && $advfiltersql != '()')
					{
						$query .= ' and '.$advfiltersql;
					}

				} else {
					$query = $listquery;
				}
				setSqlCacheData($key,$query);
			}
		} else {
			$query = $listquery;
			if($viewid != "") {
				$stdfiltersql = $this->getCVStdFilterSQL($viewid);
				$advfiltersql = $this->getCVAdvFilterSQL($viewid);
				if(isset($stdfiltersql) && $stdfiltersql != '')
				{
					$query .= ' and '.$stdfiltersql;
				}
				if(isset($advfiltersql) && $advfiltersql != '')
				{
					$query .= ' and '.$advfiltersql;
				}
			}
		}
		return $query;
	}

	function getNewCvColumnListSQL($cvid)
	{
		global $adb;
		$key = "entityname_fieldlist";
		$entitylist = getSqlCacheData($key);
		if(!$entitylist) {
			$entitylist = array();
			$sql = "select * from ec_entityname";
			$result = $adb->query($sql);
			$noofrows = $adb->num_rows($result);
			if($noofrows > 0) {
				for($i=0;$i<$noofrows;$i++) {
					$tablename = $adb->query_result($result,$i,"tablename");
					$fieldname = $adb->query_result($result,$i,"fieldname");
					$entityidfield = $adb->query_result($result,$i,"entityidfield");
					$tabid = $adb->query_result($result,$i,"tabid");
					$modulename = $adb->query_result($result,$i,"modulename");
					$entitylist[$entityidfield] = Array('tablename'=>$tablename,'fieldname'=>$fieldname,'tabid'=>$tabid,'modulename'=>$modulename);
				}
				setSqlCacheData($key,$entitylist);
			}
		}
		$columnslist = $this->getColumnsListByCvid($cvid);
		if(isset($columnslist))
		{
			foreach($columnslist as $columnname=>$value)
			{
				$tablefield = "";
				if($value != "")
				{
					$list = explode(":",$value);

					//Added For getting status for Activities -Jaguar
					$sqllist_column = $list[0].".".$list[1];
					if($this->customviewmodule == "Calendar")
					{
						if($list[1] == "status")
						{
							$sqllist_column = "case when (ec_activity.status not like '') then ec_activity.status else ec_activity.eventstatus end as activitystatus";
						}
					}

					//Added for for assigned to sorting
					if($list[1] == "smownerid")
					{
						$sqllist_column = "ec_users.user_name as assigned_user_id";
						$sqllist[] = $sqllist_column;
					} else {
						if(strlen($list[1]) > 3) {
							//$sqllist[] = $sqllist_column;
							$moduleid = $list[1];
							$postfix = substr($moduleid,-3,3);
							if($postfix == "_id") {
								$moduleid = substr($moduleid,0,strlen($moduleid)-3);
								$moduleid = $moduleid."id";
								if(isset($entitylist[$moduleid])) {
									$tablename = $entitylist[$moduleid]["tablename"];
									$fieldname = $entitylist[$moduleid]["fieldname"];
									$sqllist_column = $tablename.".".$fieldname;
								}
							}
						}
						$sqllist[] = $sqllist_column." as ".$list[2];
					}
					//Ends

					$tablefield[$list[0]] = $list[1];
					$fieldlabel = trim(str_replace($this->escapemodule," ",$list[3]));
					$this->list_fields[$fieldlabel] = $tablefield;
					$this->list_fields_name[$fieldlabel] = $list[2];
				}
			}
			$returnsql = implode(",",$sqllist);
		}
		return $returnsql;

	}

	/** to get the popup customview's condition query for the given customview
	  * @param $viewid (custom view id):: type Integer
	  * @param $listquery (List View Query):: type string
	  * @param $module (Module Name):: type string
	  * @returns  $query
	  */

	function getPopupCvListQuery($viewid,$listquery,$module)
	{
		if($viewid != "" && $listquery != "")
		{

			$stdfiltersql = $this->getCVStdFilterSQL($viewid);
			$advfiltersql = $this->getCVAdvFilterSQL($viewid);
			if(isset($stdfiltersql) && $stdfiltersql != '')
			{
				$query .= ' and '.$stdfiltersql;
			}
			if(isset($advfiltersql) && $advfiltersql != '')
			{
				$query .= ' and '.$advfiltersql;
			}

		} else {
			$query = $listquery;
		}
		return $query;
	}

	/** to get the Key Metrics for the home page query for the given customview  to find the no of records
	  * @param $viewid (custom view id):: type Integer
	  * @param $listquery (List View Query):: type string
	  * @param $module (Module Name):: type string
	  * @returns  $query
	  */
	function getMetricsCvListQuery($viewid,$listquery,$module)
	{
		if($viewid != "" && $listquery != "")
                {
                        $listviewquery = substr($listquery, strpos($listquery,'FROM'),strlen($listquery));

                        $query = "select count(*) AS count ".$listviewquery;

			$stdfiltersql = $this->getCVStdFilterSQL($viewid);
                        $advfiltersql = $this->getCVAdvFilterSQL($viewid);
                        if(isset($stdfiltersql) && $stdfiltersql != '')
                        {
                                $query .= ' and '.$stdfiltersql;
                        }
                        if(isset($advfiltersql) && $advfiltersql != '')
                        {
                                $query .= ' and '.$advfiltersql;
                        }

                }

                return $query;
	}


	/* This function sets the block information for the given module to the class variable module_list
	* and return the array
	*/

	function getCustomViewModuleInfo($module)
	{
		global $adb;
		global $current_language;
		$current_mod_strings = return_specified_module_language($current_language, $module);
		$block_info = Array();
		$tabid = getTabid($module);
		$Sql = "select distinct block,ec_field.tabid,name,blocklabel from ec_field inner join ec_blocks on ec_blocks.blockid=ec_field.block inner join ec_tab on ec_tab.tabid=ec_field.tabid where ec_field.block not in(40,6,75,35,30,54,60,66,72) and ec_tab.tabid='$tabid' order by block";
		$result = $adb->getList($Sql);
		foreach($result as $block_result)
		{
			$block_label = $block_result['blocklabel'];
			if (trim($block_label) == '')
			{
				$block_info[$pre_block_label] = $block_info[$pre_block_label].",".$block_result['block'];
			}else
			{
				if(isset($current_mod_strings[$block_label])) {
					$lan_block_label = $current_mod_strings[$block_label];
				} else {
					$lan_block_label = $block_label;
				}
				$block_info[$lan_block_label] = $block_result['block'];
			}
			$pre_block_label = $lan_block_label;
		}
		$this->module_list[$module] = $block_info;
		return $this->module_list;
	}

		/** to get the customview query for the given customview
	  * @param $viewid (custom view id):: type Integer
	  * @param $listquery (List View Query):: type string
	  * @param $module (Module Name):: type string
	  * @returns  $query
	  */

	function getExportModifiedCvListQuery($viewid,$listquery,$module,$is_popup=false)
	{
		if(!$is_popup) {
			$fieldquery = $this->getExportCvColumnListSQL($viewid);
			if($viewid != "" && $listquery != "" && $fieldquery != "")
			{

				$listviewquery = substr($listquery, strpos($listquery,'FROM'),strlen($listquery));
				if($module == "Calendar")
				{
					$query = "select ".$fieldquery."  ".$listviewquery;
				}else if($module == "Notes")
				{
					$query = "select ".$fieldquery."  ".$listviewquery;
				}
				else if($module == "Products")
				{
					$query = "select ".$fieldquery."  ".$listviewquery;
				}
				else if($module == "Vendors")
				{
					$query = "select ".$fieldquery." ".$listviewquery;
				}
				else if($module == "PriceBooks")
				{
					$query = "select ".$fieldquery."  ".$listviewquery;
				}
				else if($module == "Faq")
					{
					$query = "select ".$fieldquery." ".$listviewquery;
				}
				else
				{
					$query = "select ".$fieldquery."  ".$listviewquery;
				}
				$stdfiltersql = $this->getCVStdFilterSQL($viewid);
				$advfiltersql = $this->getCVAdvFilterSQL($viewid);
				if(isset($stdfiltersql) && $stdfiltersql != '' && $stdfiltersql != '()')
				{
					$query .= ' and '.$stdfiltersql;
				}
				if(isset($advfiltersql) && $advfiltersql != '' && $advfiltersql != '()')
				{
					$query .= ' and '.$advfiltersql;
				}

			} else {
				$query = $listquery;
			}
		} else {
			$query = $listquery;
			if($viewid != "") {
				$stdfiltersql = $this->getCVStdFilterSQL($viewid);
				$advfiltersql = $this->getCVAdvFilterSQL($viewid);
				if(isset($stdfiltersql) && $stdfiltersql != '')
				{
					$query .= ' and '.$stdfiltersql;
				}
				if(isset($advfiltersql) && $advfiltersql != '')
				{
					$query .= ' and '.$advfiltersql;
				}
			}
		}
		return $query;
	}

	function getExportCvColumnListSQL($cvid)
	{
		global $adb;
		$columnslist = $this->getColumnsListByCvid($cvid);
		if(isset($columnslist))
		{
			foreach($columnslist as $columnname=>$value)
			{
				$tablefield = "";
				if($value != "")
				{
					$list = explode(":",$value);
					$fieldlabel = trim(str_replace($this->escapemodule," ",$list[3]));

					//Added For getting status for Activities -Jaguar
					$sqllist_column = $list[0].".".$list[1]." as "."'$fieldlabel'";
					if($this->customviewmodule == "Calendar")
					{
						if($list[1] == "status")
						{
							$sqllist_column = "case when (ec_activity.status not like '') then ec_activity.status else ec_activity.eventstatus end as activitystatus "." as "."'$fieldlabel'";
						}
					}

					//Added for for assigned to sorting
					if($list[1] == "smownerid")
					{
						$sqllist_column = "ec_users.user_name "." as "."'$fieldlabel'";
					}
					elseif($list[1] == "crmid")
					{
						$sqllist_column ="";
					}
					elseif($list[1] == 'accountid')//Account Name
					{
						$sqllist_column = "ec_account.accountname as '".$fieldlabel."'";
					}
					elseif($list[1] == 'campaignid')//Campaign Source
					{
						$sqllist_column = "ec_campaign.campaignname as '".$fieldlabel."'";
					}
					elseif($list[1] == 'vendor_id')//Vendor Name
					{
						$sqllist_column = "ec_vendor.vendorname as '".$fieldlabel."'";
					}
					elseif($list[1] == 'catalogid')//Catalog Name
					{
						$sqllist_column = "ec_catalog.catalogname as '".$fieldlabel."'";
					}
					elseif($list[1] == 'contactid')//contact_id
					{
						$sqllist_column = " ec_contactdetails.lastname as '".$fieldlabel."'";
					}
					elseif($list[1] == 'quoteid')//contact_id
					{
						$sqllist_column =" ec_quotes.subject as '".$fieldlabel."'";
					}
					elseif($list[1] == 'potentialid')//contact_id
					{
						$sqllist_column = " ec_potential.potentialname as '".$fieldlabel."'";
					}
					else
					{
						$query_rel = "SELECT ec_entityname.* FROM ec_entityname WHERE ec_entityname.tabid>30 and ec_entityname.entityidfield='".$list[1]."'";
						$fldmod_result = $adb->query($query_rel);
						$rownum = $adb->num_rows($fldmod_result);
						if($rownum > 0) {
							$rel_tablename = $adb->query_result($fldmod_result,0,'tablename');
							$rel_entityname = $adb->query_result($fldmod_result,0,'fieldname');
							$sqllist_column = " ".$rel_tablename.".".$rel_entityname." as '".$fieldlabel."'";
						} else {
							$sqllist_column = $list[0].".".$list[1]. " '" .$fieldlabel."'";
						}
					}

					$sqllist[] = $sqllist_column;
					//Ends

					$tablefield[$list[0]] = $list[1];
					$this->list_fields[$fieldlabel] = $tablefield;
					$this->list_fields_name[$fieldlabel] = $list[2];
				}
			}
			$returnsql = implode(",",$sqllist);
		}
		return $returnsql;

	}

}
?>
