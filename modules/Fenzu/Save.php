<?php

require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
global $adb;
global $log;
global $current_user;

$cvid = $_REQUEST["record"];
$cvmodule = $_REQUEST["cvmodule"];

$return_module = $_REQUEST["return_module"];
$parenttab = $_REQUEST["parenttab"];
$return_action = $_REQUEST["return_action"];

if($cvmodule != "")
{
	$viewname = $_REQUEST["viewName"];

 	$allKeys = array_keys($_POST);

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


	if(isset($_REQUEST["publictype"]) && $_REQUEST["publictype"] !=''){
		if($_REQUEST["publictype"] == 'public'){
			$smownerid = 0;
		}else{
			$smownerid = $current_user->id;	
		}
	}else{
		$smownerid = $current_user->id;	
	}
	
	if(!$cvid)
	{
		$genCVid = $adb->getUniqueID("ec_fenzu")+100;
		if($genCVid != "")
		{
			$Fenzusql = "INSERT INTO ec_fenzu(cvid,viewname,entitytype,smownerid)	VALUES (".$genCVid.",".$adb->quote($viewname).",".$adb->quote($return_module).",".$smownerid.")";
			$Fenzuresult = $adb->query($Fenzusql);
			$log->info("Fenzu :: Save :: ec_fenzu created successfully");
			if($Fenzuresult)
			{
					$stdfiltersql = "INSERT INTO ec_cvstdfilterfenzu
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
					$log->info("Fenzu :: Save :: ec_cvstdfilterfenzu created successfully");
					for($i=0;$i<count($adv_filter_col);$i++)
					{
						$advfiltersql = "INSERT INTO ec_cvadvfilterfenzu
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
					$log->info("Fenzu :: Save :: ec_cvadvfilterfenzu created successfully");

			}
			$cvid = $genCVid;
		}
	}
	else
	{

		$updatecvsql = "UPDATE ec_fenzu SET viewname = ".$adb->quote($viewname).",smownerid='".$smownerid."' WHERE cvid = ".$cvid;
		$updatecvresult = $adb->query($updatecvsql);
			$log->info("Fenzu :: Save :: ec_fenzu upated successfully");

			$deletesql = "DELETE FROM ec_cvstdfilterfenzu WHERE cvid = ".$cvid;
			$deleteresult = $adb->query($deletesql);

			$deletesql = "DELETE FROM ec_cvadvfilterfenzu WHERE cvid = ".$cvid;
			$deleteresult = $adb->query($deletesql);
			$log->info("Fenzu :: Save :: ec_cvcolumnlist,cvstdfilter,cvadvfilter deleted successfully before update");

		$genCVid = $cvid;
		if($updatecvresult)
		{
				$stdfiltersql = "INSERT INTO ec_cvstdfilterfenzu
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
				$log->info("Fenzu :: Save :: ec_cvstdfilterfenzu update successfully".$genCVid);
				for($i=0;$i<count($adv_filter_col);$i++)
				{
					$advfiltersql = "INSERT INTO ec_cvadvfilterfenzu
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
				$log->info("Fenzu :: Save :: ec_cvadvfilterfenzu update successfully".$genCVid);

		}
	}
}
clear_cache_files();
header("Location: index.php?action=$return_action&parenttab=$parenttab&module=$return_module&viewname=$cvid");
?>
