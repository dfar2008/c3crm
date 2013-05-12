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
 * Description:  TODO: To be written.
 ********************************************************************************/

require_once('include/CRMSmarty.php');
require_once('data/Tracker.php');
require_once('modules/Import/ImportContact.php');
require_once('modules/Import/ImportAccount.php');
require_once('modules/Import/ImportOpportunity.php');
require_once('modules/Import/UsersLastImport.php');
require_once('modules/Import/parse_utils.php');
require_once('include/ListView/ListView.php');
require_once('modules/Contacts/Contacts.php');
require_once('include/utils/utils.php');
require_once('modules/Import/ImportNote.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;

if (! isset( $_REQUEST['module']))
{
	$_REQUEST['module'] = 'Home';
}

if (! isset( $_REQUEST['return_id']))
{
	$_REQUEST['return_id'] = '';
}
if (! isset( $_REQUEST['return_module']))
{
	$_REQUEST['return_module'] = '';
}

if (! isset( $_REQUEST['return_action']))
{
	$_REQUEST['return_action'] = '';
}

global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$log->info("Import Step last");

$parenttab = getParenttab();
//This Buttons_List1.tpl is is called to display the add, search, import and export buttons ie., second level tabs
$smarty = new CRMSmarty();

$smarty->assign("MOD", $mod_strings);
$smarty->assign("APP", $app_strings);
$smarty->assign("IMP", $import_mod_strings);
$smarty->assign("THEME", $theme);
$smarty->assign("IMAGE_PATH", $image_path);

$smarty->assign("MODULE", $_REQUEST['modulename']);
$smarty->assign("SINGLE_MOD", $_REQUEST['modulename']);
$smarty->assign("CATEGORY", $_SESSION['import_parenttab']);
@session_unregister('column_position_to_field');
@session_unregister('totalrows');
@session_unregister('recordcount');
@session_unregister('startval');
@session_unregister('return_field_count');
@session_unregister('import_rows_in_excel');
if(isset($_SESSION["eventrecord"])) {
	session_unregister('eventrecord');
}

$smarty->display("Buttons_List1.tpl");
$skipped_record_count = $_REQUEST['skipped_record_count'];

if (isset($_REQUEST['message']))
{
	?>
	<br>

	<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small">
	   <tr>
		<td height="50" valign="middle" align="left" class="mailClientBg genHeaderSmall">
			 <?php echo $mod_strings['LBL_MODULE_NAME']; ?> <?php echo $app_strings[$_REQUEST['modulename']]; ?> 
		</td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"  style="padding-left:40px;width:75%;" >
			<span class="genHeaderGray"><?php echo $mod_strings['LBL_STEP_3_3']; ?></span>&nbsp; 
			<span class="genHeaderSmall"><?php echo $mod_strings['LBL_MAPPING_RESULTS']; ?></span>
		</td>
	   </tr>	
	   <tr>
		<td style="padding-left:140px;">
			<?php 
				echo $_REQUEST['message']; 
			?>
		 <br><br><br> 		 </td>
       </tr>
	   <tr>
	     <td class="reportCreateBottom" >
		 <table width="100%" border="0" cellpadding="5" cellspacing="0" >
           <tr>
             <td align="right" valign="top"><form enctype="multipart/form-data" name="Import" method="POST" action="index.php" style="float:right; ">
                 <input type="hidden" name="module" value="<?php echo $_REQUEST['modulename']; ?>">
                 <input type="hidden" name="action" value="Import">
                 <input type="hidden" name="step" value="1">
                 <input type="hidden" name="return_id" value="<?php echo $_REQUEST['return_id']; ?>">
                 <input type="hidden" name="return_module" value="<?php echo $_REQUEST['return_module']; ?>">
                 <input type="hidden" name="return_action" value="<?php echo (($_REQUEST['return_action'] != '')?$_REQUEST['return_action']:'index'); ?>">
                 <input type="hidden" name="parenttab" value="<?php echo $parenttab; ?>">
                 <input title="<?php echo $mod_strings['LBL_FINISHED'] ?>" accessKey="" class="crmbutton small save" type="submit" name="button" value="  <?php echo $mod_strings['LBL_FINISHED'] ?>  "  onclick="this.form.action.value=this.form.return_action.value;this.form.return_module.value=this.form.return_module.value;return true;">
                 <input title="<?php echo $mod_strings['LBL_IMPORT_MORE'] ?>" accessKey="" class="crmbutton small save" type="submit" name="button" value="  <?php echo $mod_strings['LBL_IMPORT_MORE'] ?>  "  onclick="this.form.return_module.value=this.form.module.value; return true;">
				 <?php
					 if($skipped_record_count > 0)
	                 {
				?>
					<input title="<?php echo $mod_strings['LBL_SKIPPED_ROWS'] ?>" accessKey="" class="crmbutton small save" type="button" name="button" value="  <?php echo $mod_strings['LBL_SKIPPED_ROWS'] ?>  " onclick="document.location.href='index.php?module=Import&action=Popup_skippedrows';">
				<?php
				     }
				 ?>
             </form>
			 </td>
           </tr>
         </table></td>
      </tr>
	</table>
	<?php 
}
?>
