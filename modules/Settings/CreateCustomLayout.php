<?php
require_once('include/CustomFieldUtil.php');
global $mod_strings,$app_strings,$app_list_strings,$theme,$adb;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


require_once('include/utils/CommonUtils.php');

$tabid=$_REQUEST['tabid'];
$fieldid=$_REQUEST['fieldid'];
$fieldlabel=$_REQUEST['fieldlabel'];
$order=$_REQUEST['order'];
$blockid=$_REQUEST['blockid'];
$blocklabel=$_REQUEST['blocklabel'];
$typeofdata=$_REQUEST['typeofdata'];
$fieldmandatory = "";
if($typeofdata == "true") {
	$fieldmandatory = "checked";
}


$blockArr = getCustomBlocks($_REQUEST['fld_module'],$tabid);
//print_r($blockArr);
$output .= ' <div id="layoutLayer" >
                <form action="index.php" method="post" name="addtodb" onSubmit="return validate_layout()">
                <input type="hidden" name="module" value="Settings">
                <input type="hidden" name="fld_module" value="'.$_REQUEST['fld_module'].'">
                <input type="hidden" name="parenttab" value="Settings">
                <input type="hidden" name="action" value="AddCustomLayoutToDB">
                <input type="hidden" name="blockid" value="'.$blockid.'">
                <input type="hidden" name="fieldid" value="'.$fieldid.'">
                <input type="hidden" name="mode" value="'.$mode.'">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
                if($mode == 'edit')
				$output .= '<h3 id="myModalLabel">'.$mod_strings['LBL_EDIT_LAYOUT'].'</h3>';
			else
				$output .= '<h3 id="myModalLabel">'.$mod_strings['LBL_ADD_LAYOUT'].'</h3>';



      $output.='</div>
                <div class="modal-body">
                    <table class="table-consdened">
                          <tr>
                            <td ><strong>'.$mod_strings['LBL_MANDATORY'].'</strong></td>
                            <td><input name="fldMandatory" value="1" '.$fieldmandatory.' type="checkbox" ></td>
                        </tr>
                        <tr>
                            <td><strong>'.$mod_strings['FIELD_LABEL'].'</strong></td>
                            <td><input type="text" size=20 name="fieldlabel" value="'.$fieldlabel.'" ></td>
                        </tr>
                        <tr>
                            <td ><strong>'.$mod_strings['LBL_LAYOUT_LABEL'].'</strong></td>
                            <td width="50%" align="left"><select name="blockid">'.get_select_options($blockArr, $blockid).'</select></td>
                        </tr>
                      
                        <tr>
                            <td ><strong>'.$mod_strings['LBL_BLOCK_ORDER'].'</strong></td>
                            <td><input type="text" size=20 name="order" value="'.$order.'" ></td>
                        </tr>
                     </table>
                </div>
                <div class="modal-footer">
                    <button class="btn pull-left btn-small btn-primary" data-dismiss="modal" aria-hidden="true">
                    <i class ="icon-arrow-left icon-white"></i> '.$app_strings['LBL_CANCEL_BUTTON_LABEL']
                    .'</button>
                    <button class="btn btn-small btn-success pull-right" type="submit"><i class="icon-ok icon-white"></i> '.$app_strings['LBL_SAVE_BUTTON_LABEL'].'</button>
                </div>
                </from>
              </div>';
echo $output;

function getCustomBlocks($module,$tabid){
   	//$tabid = getTabid($module);
	global $adb;
	global $theme;
	global $current_language;
	$cur_module_strings = return_specified_module_language($current_language,$module);
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$dbQuery = "select blockid,blocklabel,sequence from ec_blocks where tabid=$tabid and visible = 0 order by sequence";
	$result = $adb->getList($dbQuery);
	$cflist = Array();
	foreach($result as $row)
	{
		if(isset($cur_module_strings[$row["blocklabel"]])) {
			$cflist[$row['blockid']] = $cur_module_strings[$row["blocklabel"]];
		} else {
			$cflist[$row['blockid']] = $row["blocklabel"];
		}
		
	}
	return $cflist;
}
?>
