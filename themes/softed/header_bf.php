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

 * Description:  Contains a variety of utility functions used to display UI

 * components such as form headers and footers.  Intended to be modified on a per

 * theme basis.

 ********************************************************************************/

require_once('include/CRMSmarty.php');
require_once("include/utils/utils.php");
require_once("modules/Synchronous/config.php");
global $currentModule;
global $app_strings;
global $app_list_strings;
global $moduleList;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";




$smarty = new CRMSmarty();
$header_array = getHeaderArray();
$smarty->assign("HEADERS",$header_array);
$smarty->assign("THEME",$theme);
$smarty->assign("IMAGEPATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE_NAME", $currentModule);
$smarty->assign("DATE", getDisplayDate(date("Y-m-d H:i")));
$smarty->assign("CURRENT_USER", $current_user->user_name);
$smarty->assign("CURRENT_USER_ID", $current_user->id);
$smarty->assign("MODULELISTS",$app_list_strings['moduleList']);
$smarty->assign("CATEGORY",getParentTab());
//$smarty->assign("ANNOUNCEMENT",get_announcements());

$module_path="modules/".$currentModule."/";

///auth
$nowdate = date("Ymd");
$auth = md5($nowdate.$current_user->email2);
$smarty->assign("AUTH",$auth);

//NEW taobao
if($_REQUEST['ac']=='logout'){
		$_SESSION['topsession'] = '';
		$_SESSION['nick'] = '';
		//echo "<script>window.close();</script>";
       //echo "<script>location.href='index.php?module=$module&action=index';</script>";
}




$top_appkey = $_GET['top_appkey'];
$top_parameters = $_GET['top_parameters'];
$top_session = $_GET['top_session'];
$top_sign = $_GET['top_sign'];


$md5 = md5( $top_appkey . $top_parameters . $top_session . $appSecret, true );
$sign = base64_encode( $md5 );

if ( $sign != $top_sign ) {
	echo "signature invalid.";
	exit();
}

$parameters = array();

parse_str( base64_decode( $top_parameters ), $parameters );


$now = time();
$ts = $parameters['ts'] / 1000;
if ( $ts > ( $now + 60 * 10 ) || $now > ( $ts + 60 * 30 ) ) {
	echo "request out of date.";
	exit();
}

$_SESSION['topsession'] = $_REQUEST['top_session'];

$_SESSION['nick'] =iconv_ec("GBK","UTF-8",$parameters['visitor_nick']);


//Assign the entered global search string to a variable and display it again
if(isset($_REQUEST['query_string']) && $_REQUEST['query_string'] != '')
	$smarty->assign("QUERY_STRING",$_REQUEST['query_string']);
else
	$smarty->assign("QUERY_STRING",$app_strings["LBL_SEARCH_STRING"]);
$smarty->display("Header.tpl");
?>
