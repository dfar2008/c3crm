<?php
require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Notes/Notes.php');
require_once('include/utils/utils.php');

global $app_strings,$app_list_strings,$mod_strings,$theme,$currentModule;

$focus = new Notes();
$smarty = new CRMSmarty();

if(isset($_REQUEST['upload_error']) && $_REQUEST['upload_error'] == true)
{
	echo '<br><b><font color="red"> The selected file has no data or a invalid file.</font></b><br>';
}

if(isset($_REQUEST['record']) && $_REQUEST['record'] !='')
{
	$focus->id = $_REQUEST['record'];
	$focus->mode = 'edit';
	$focus->retrieve_entity_info($_REQUEST['record'],"Notes");
    $focus->name=$focus->column_fields['notes_title'];
	$focus->column_fields['notecontent'] = decode_html($focus->column_fields["notecontent"]);

}

if(isset($_REQUEST['potential_id']) && $_REQUEST['potential_id'] !='')
{
	$potential_id = $_REQUEST['potential_id'];
	$sql = "select accountid,contact_id from ec_potential  where deleted=0 and potentialid='".$potential_id."'";
	$result = $focus->db->query($sql);
	$num_rows = $focus->db->num_rows($result);
	if($num_rows > 0) {
		$accountid = $focus->db->query_result($result,0,"accountid");
		$contact_id = $focus->db->query_result($result,0,"contact_id");
		$focus->mode = '';
		$focus->column_fields['account_id'] = $accountid;
		$focus->column_fields['contact_id'] = $contact_id;
		$focus->column_fields['potential_id'] = $potential_id;
	}
}
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Potentials')
{
	$potential_id = $_REQUEST['return_id'];
	$sql = "select accountid,contact_id from ec_potential where deleted=0 and potentialid='".$potential_id."'";
	$result = $focus->db->query($sql);
	$num_rows = $focus->db->num_rows($result);
	if($num_rows > 0) {
		$accountid = $focus->db->query_result($result,0,"accountid");
		$contact_id = $focus->db->query_result($result,0,"contact_id");
		$focus->mode = '';
		$focus->column_fields['account_id'] = $accountid;
		$focus->column_fields['contact_id'] = $contact_id;
		$focus->column_fields['potential_id'] = $potential_id;
	}
}
if(isset($_REQUEST['return_module']) && $_REQUEST['return_module'] == 'Accounts')
{
	$account_id = $_REQUEST['return_id'];

	$focus->column_fields['account_id'] = $account_id;

}
$old_id = '';
if(isset($_REQUEST['isDuplicate']) && $_REQUEST['isDuplicate'] == 'true')
{
	$old_id = $_REQUEST['record'];
	if (! empty($focus->filename) )
	{
	 $old_id = $focus->id;
	}
	$focus->id = "";
	$focus->mode = '';
}



//setting default flag value so due date and time not required
//if (!isset($focus->id)) $focus->date_due_flag = 'on';

//needed when creating a new case with default values passed in
if (isset($_REQUEST['contact_name']) && is_null($focus->contact_name)) {
	$focus->contact_name = $_REQUEST['contact_name'];
}
if (isset($_REQUEST['contact_id']) && is_null($focus->contact_id)) {
	$focus->contact_id = $_REQUEST['contact_id'];
}

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$disp_view = getView($focus->mode);
if($disp_view == 'edit_view')
	$smarty->assign("BLOCKS",getBlocks($currentModule,$disp_view,$focus->mode,$focus->column_fields));
else
{
	$smarty->assign("BASBLOCKS",getBlocks($currentModule,$disp_view,$focus->mode,$focus->column_fields,'BAS'));
}
$smarty->assign("OP_MODE",$disp_view);
$category = getParentTab();
$smarty->assign("CATEGORY",$category);


$log->info("Note detail view");

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("MODULE",$currentModule);
$smarty->assign("SINGLE_MOD",'Note');
//Display the FCKEditor or not? -- configure $FCKEDITOR_DISPLAY in config.php
//$smarty->assign("FCKEDITOR_DISPLAY",$FCKEDITOR_DISPLAY);

if (isset($focus->name))
$smarty->assign("NAME", $focus->name);
else
$smarty->assign("NAME", "");

if($focus->mode == 'edit')
{
	$smarty->assign("UPDATEINFO",updateInfo($focus->id));
        $smarty->assign("MODE", $focus->mode);
}

if (isset($_REQUEST['return_module']))
$smarty->assign("RETURN_MODULE", $_REQUEST['return_module']);
else
$smarty->assign("RETURN_MODULE","Notes");
if (isset($_REQUEST['return_action']))
$smarty->assign("RETURN_ACTION", $_REQUEST['return_action']);
else
$smarty->assign("RETURN_ACTION","index");
if (isset($_REQUEST['return_id']))
$smarty->assign("RETURN_ID", $_REQUEST['return_id']);
if (isset($_REQUEST['fileid']))
$smarty->assign("FILEID", $_REQUEST['fileid']);
if (isset($_REQUEST['record']))
{
         $smarty->assign("CANCELACTION", "DetailView");
}
else
{
         $smarty->assign("CANCELACTION", "index");
}
if (isset($_REQUEST['return_viewname']))
$smarty->assign("RETURN_VIEWNAME", $_REQUEST['return_viewname']);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);
//$smarty->assign("PRINT_URL", "phprint.php?jt=".session_id().$GLOBALS['request_string']);
$smarty->assign("ID", $focus->id);
$smarty->assign("OLD_ID", $old_id );
$tabid = getTabid("Notes");
$data = getSplitDBValidationData($focus->tab_name,$tabid);

$smarty->assign("VALIDATION_DATA_FIELDNAME",$data['fieldname']);
$smarty->assign("VALIDATION_DATA_FIELDDATATYPE",$data['datatype']);
$smarty->assign("VALIDATION_DATA_FIELDLABEL",$data['fieldlabel']);
$smarty->display("Notes/NewCreateView.tpl");

?>
