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
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
global $adb;
global $log;
global $current_user;

$cvid = $_REQUEST["record"];
$cvmodule = $_REQUEST["cvmodule"];
$parenttab = $_REQUEST["parenttab"];
$return_action = $_REQUEST["return_action"];
if($cvmodule != "")
{
	$viewname = $_REQUEST["viewName"];
	/*if(isset($_REQUEST["setDefault"]))
	{
	  $setdefault = 1;
	}else
	{
	  $setdefault = 0;
	}*/
	$setdefault = 0;
	$setpublic = '';
	if(isset($_REQUEST["setPublic"]))
	{
	  $setpublic = '0';
	}else
	{
	  //$setpublic = $current_user->id;
	  if(isset($_REQUEST["roleid"]) && $_REQUEST["roleid"] != "") {
		$setpublic = implode(",",$_REQUEST["roleid"]);
	  }
	}

	if(isset($_REQUEST["setMetrics"]))
	{
	  $setmetrics = 1;
	}else
	{
	  $setmetrics = 0;
	}
    $choosecollectcolhtml=$_REQUEST['collectcolumn'];
 	$allKeys = array_keys($_POST);

	//<<<<<<<columns>>>>>>>>>>
	for ($i=0;$i<count($allKeys);$i++)
	{
	   $string = substr($allKeys[$i], 0, 6);
	   if($string == "column")
	   {
        	   $columnslist[] = $_REQUEST[$allKeys[$i]];
   	   }
	}
	//<<<<<<<columns>>>>>>>>>

	//<<<<<<<standardfilters>>>>>>>>>
	$stdfiltercolumn = $_REQUEST["stdDateFilterField"];
	$std_filter_list["columnname"] = $stdfiltercolumn;
	$stdcriteria = $_REQUEST["stdDateFilter"];
	$std_filter_list["stdfilter"] = $stdcriteria;
	$startdate = $_REQUEST["startdate"];
	$std_filter_list["startdate"] = $startdate;
	$enddate = $_REQUEST["enddate"];
	$std_filter_list["enddate"]=$enddate;
	
	//add by chengliang for null and formatDate
	if($std_filter_list["startdate"] != ''){
		$std_filter_list["startdate"] = $adb->formatDate($std_filter_list["startdate"]);
	}else{
		$std_filter_list["startdate"] = "''";
	}
	if($std_filter_list["enddate"] != ''){
		$std_filter_list["enddate"] = $adb->formatDate($std_filter_list["enddate"]);
	}else{
		$std_filter_list["enddate"] = "''";
	}
	//<<<<<<<standardfilters>>>>>>>>>

	//<<<<<<<advancedfilter>>>>>>>>>
	for ($i=0;$i<count($allKeys);$i++)
	{
	   $string = substr($allKeys[$i], 0, 4);
	   if($string == "fcol")
   	   {
           	$adv_filter_col[] = $_REQUEST[$allKeys[$i]];
   	   }
	}

	for ($i=0;$i<count($allKeys);$i++)
	{
	   $string = substr($allKeys[$i], 0, 3);
	   if($string == "fop")
   	   {
           	$adv_filter_option[] = $_REQUEST[$allKeys[$i]];
   	   }
	}
	for ($i=0;$i<count($allKeys);$i++)
	{
   	   $string = substr($allKeys[$i], 0, 4);
	   if($string == "fval")
   	   {
		   $adv_filter_value[] = $_REQUEST[$allKeys[$i]];
   	   }
	}
	//<<<<<<<advancedfilter>>>>>>>>
	
	//changed by xiaoyang on 2012-9-18
	/*if(isset($_REQUEST['publictype']) && $_REQUEST['publictype'] !=''){
		if($_REQUEST['publictype'] == 'public'){
			$smownerid = 0;
		}else{
			$smownerid = $current_user->id;	
		}
	}else{
		$smownerid = $current_user->id;	
	}*/
	$smownerid = 0;

	if(!$cvid)
	{
		$genCVid = $adb->getUniqueID("ec_customview");
		if($genCVid != "")
		{

			/*if($setdefault == 1)
			{
				$updatedefaultsql = "UPDATE ec_customview SET setdefault = 0 WHERE entitytype = ".$adb->quote($cvmodule)." and setpublic=".$adb->quote($setpublic);
				$updatedefaultresult = $adb->query($updatedefaultsql);
			}*/
			$log->info("CustomView :: Save :: setdefault upated successfully");

			$customviewsql = "INSERT INTO ec_customview(cvid, viewname,	setdefault, setmetrics,	entitytype,setpublic,collectcolumn,smownerid)	VALUES (".$genCVid.",".$adb->quote($viewname).",".$setdefault.",".$setmetrics.",".$adb->quote($cvmodule).",".$adb->quote($setpublic).",'$choosecollectcolhtml',".$smownerid.")";
			$customviewresult = $adb->query($customviewsql);
			$log->info("CustomView :: Save :: ec_customview created successfully");
			if($customviewresult)
			{
				if(isset($columnslist))
				{
					for($i=0;$i<count($columnslist);$i++)
					{
						$columnsql = "INSERT INTO ec_cvcolumnlist (cvid, columnindex, columnname)
							VALUES (".$genCVid.", ".$i.", ".$adb->quote($columnslist[$i]).")";
						$columnresult = $adb->query($columnsql);
					}
					$log->info("CustomView :: Save :: ec_cvcolumnlist created successfully");

					$stdfiltersql = "INSERT INTO ec_cvstdfilter
								(cvid,
								columnname,
								stdfilter,
								startdate,
								enddate)
							VALUES
								(".$genCVid.",
								".$adb->quote($std_filter_list["columnname"]).",
								
								".$adb->quote($std_filter_list["stdfilter"]).",
								".$std_filter_list["startdate"].",
								".$std_filter_list["enddate"].")";
					$stdfilterresult = $adb->query($stdfiltersql);
					$log->info("CustomView :: Save :: ec_cvstdfilter created successfully");
					for($i=0;$i<count($adv_filter_col);$i++)
					{
						$advfiltersql = "INSERT INTO ec_cvadvfilter
								(cvid,
								columnindex,
								columnname,
								comparator,
								value)
							VALUES
								(".$genCVid.",
								".$i.",
								".$adb->quote($adv_filter_col[$i]).",
								".$adb->quote($adv_filter_option[$i]).",
								".$adb->quote($adv_filter_value[$i]).")";
						$advfilterresult = $adb->query($advfiltersql);
					}
					$log->info("CustomView :: Save :: ec_cvadvfilter created successfully");
				}
			}
			$cvid = $genCVid;
		}
	}
	else
	{

		/*if($setdefault == 1)
		{
			//$updatedefaultsql = "UPDATE ec_customview SET setdefault = 0 WHERE entitytype = ".$adb->quote($cvmodule);
			$updatedefaultsql = "UPDATE ec_customview SET setdefault = 0 WHERE entitytype = ".$adb->quote($cvmodule)." and setpublic=".$adb->quote($setpublic);
			$updatedefaultresult = $adb->query($updatedefaultsql);
		}*/
		$updatecvsql = "UPDATE ec_customview SET viewname = ".$adb->quote($viewname).",setdefault = ".$setdefault.",setpublic = ".$adb->quote($setpublic).",setmetrics = ".$setmetrics.",collectcolumn='$choosecollectcolhtml',smownerid='".$smownerid."' WHERE cvid = ".$cvid;
		$updatecvresult = $adb->query($updatecvsql);
		$log->info("CustomView :: Save :: ec_customview upated successfully");
		$deletesql = "DELETE FROM ec_cvcolumnlist WHERE cvid = ".$cvid;
		$deleteresult = $adb->query($deletesql);

		$deletesql = "DELETE FROM ec_cvstdfilter WHERE cvid = ".$cvid;
		$deleteresult = $adb->query($deletesql);

		$deletesql = "DELETE FROM ec_cvadvfilter WHERE cvid = ".$cvid;
		$deleteresult = $adb->query($deletesql);
		$log->info("CustomView :: Save :: ec_cvcolumnlist,cvstdfilter,cvadvfilter deleted successfully before update");

		$genCVid = $cvid;
		if($updatecvresult)
		{
			if(isset($columnslist))
			{
				for($i=0;$i<count($columnslist);$i++)
				{
					$columnsql = "INSERT INTO ec_cvcolumnlist (cvid, columnindex, columnname)
						VALUES (".$genCVid.", ".$i.", ".$adb->quote($columnslist[$i]).")";

					$columnresult = $adb->query($columnsql);
				}
				$log->info("CustomView :: Save :: ec_cvcolumnlist update successfully".$genCVid);
				$stdfiltersql = "INSERT INTO ec_cvstdfilter
							(cvid,
							columnname,
							stdfilter,
							startdate,
							enddate)
						VALUES
							(".$genCVid.",
							".$adb->quote($std_filter_list["columnname"]).",
							".$adb->quote($std_filter_list["stdfilter"]).",
							".$std_filter_list["startdate"].",
							".$std_filter_list["enddate"].")";
				$stdfilterresult = $adb->query($stdfiltersql);
				$log->info("CustomView :: Save :: ec_cvstdfilter update successfully".$genCVid);
				for($i=0;$i<count($adv_filter_col);$i++)
				{
					$advfiltersql = "INSERT INTO ec_cvadvfilter
								(cvid,
								columnindex,
								columnname,
								comparator,
								value)
							VALUES
								(".$genCVid.",
								".$i.",
								".$adb->quote($adv_filter_col[$i]).",
								".$adb->quote($adv_filter_option[$i]).",
								".$adb->quote($adv_filter_value[$i]).")";
					$advfilterresult = $adb->query($advfiltersql);
				}
				$log->info("CustomView :: Save :: ec_cvadvfilter update successfully".$genCVid);
			}
		}
	}
}
clear_cache_files();
header("Location: index.php?action=$return_action&parenttab=$parenttab&module=$cvmodule&viewname=$cvid");
?>
