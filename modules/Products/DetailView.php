<?php
require_once('include/CRMSmarty.php');
require_once('modules/Products/Products.php');

$focus = new Products();

if(isset($_REQUEST['record']) && isset($_REQUEST['record'])) {
	//Display the error message
	if(isset($_SESSION['image_type_error']) && $_SESSION['image_type_error'] != '')
	{
		echo '<font color="red">'.$_SESSION['image_type_error'].'</font>';
		session_unregister('image_type_error');
	}

	$focus->retrieve_entity_info($_REQUEST['record'],"Products");
	$focus->id = $_REQUEST['record'];
	$focus->name=$focus->column_fields['productname'];
	$focus->column_fields['product_description'] = decode_html($focus->column_fields["product_description"]);//描述
}

if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true') {
        $focus->id = "";
}

global $app_strings,$currentModule,$singlepane_view;
global $mod_strings;

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$smarty = new CRMSmarty();
$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);

if (isset($focus->name)) $smarty->assign("NAME", $focus->name);
else $smarty->assign("NAME", "");
$focus->column_fields['description'] = html_entity_decode($focus->column_fields['description']);

$smarty->assign("BLOCKS", getBlocks($currentModule,"detail_view",'',$focus->column_fields));
$category = getParentTab();
$smarty->assign("CATEGORY",$category);
$smarty->assign("UPDATEINFO",updateInfo($focus->id));
$smarty->assign("SINGLE_MOD", 'Product');
$smarty->assign("IMAGE_PATH", $image_path);
//$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);
$smarty->assign("ID", $_REQUEST['record']);

$productcangkunums=array();
$productid=$focus->id;

$smarty->assign("MODULE", $currentModule);


if($singlepane_view == 'true')
{
	$related_array = getRelatedLists($currentModule,$focus);
	$smarty->assign("RELATEDLISTS", $related_array);
}

$smarty->assign("SinglePane_View", $singlepane_view);
$smarty->display("Products/DetailView.tpl");

function getProductCangkuSeccheck(){
    global $adb;
    global $current_user;
    $userid=$current_user->id;

    $sec_check=" and ec_cangkus.cangkusid in (select ec_cangkuserrel.cangkusid from ec_cangkuserrel where ec_cangkuserrel.userid=$userid ) ";
    
    return $sec_check;
}
?>
