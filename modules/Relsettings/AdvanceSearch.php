<?php
require_once('include/CRMSmarty.php');
require_once("data/Tracker.php");
require_once('include/ListView/ListView.php');
require_once('include/database/PearDatabase.php');
require_once('include/ComboUtil.php');
require_once('include/utils/utils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');
global $mod_strings;
global $current_user;
global $adb;
global $theme;

$currentModule = $_REQUEST['modulename'];
$category = getParentTab();

$smarty = new CRMSmarty();

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("BUTTONS",$other_text);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("CATEGORY",$category);


if(isset($_SESSION['LiveViewSearch'][$currentModule]) && !empty($_SESSION['LiveViewSearch'][$currentModule]))
{
		$where=$_SESSION['LiveViewSearch'][$currentModule][1];
		$url_string .="&query=true".$_SESSION['LiveViewSearch'][$currentModule][2];
		$searchopts=$_SESSION['LiveViewSearch'][$currentModule][3];
		if($searchopts['searchtype']=='BasicSearch')
		{
			$smarty->assign("BASICSEARCH",'true');
			if($searchopts['type']!="alpbt"){
				$smarty->assign("BASICSEARCHVALUE",$searchopts['search_text']);
				$smarty->assign("BASICSEARCHFIELD",$searchopts['search_field']);
			}else{
				$alpbtselectedvalue=$searchopts['search_text'];
			}
		}else{
			$smarty->assign("ADVSEARCH",'true');
			$smarty->assign("SEARCHMATCHTYPE",$searchopts['matchtype']);

			$searchcons=$searchopts['conditions'];
			$searchconshtml=array();
			foreach($searchcons as $eachcon)
			{
				$column=$eachcon[0];
				$searchop=$eachcon[1];
				$searchval=$eachcon[2];

				$columnhtml = getAdvSearchfields($currentModule,$column);
				$searchophtml = getcriteria_options($searchop);

				$searchconshtml[]=array($columnhtml,$searchophtml,$searchval);
			}
			$smarty->assign("SEARCHCONSHTML",$searchconshtml);
		}
}



$fieldnames = getAdvSearchfields($currentModule);
$criteria = getcriteria_options();
$smarty->assign("CRITERIA", $criteria);
$smarty->assign("FIELDNAMES", $fieldnames);


$smarty->display("AdvanceSearch.tpl");
?>
