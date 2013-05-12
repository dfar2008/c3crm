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

require_once('data/Tracker.php');
require_once('modules/Import/ImportContact.php');
require_once('modules/Import/ImportAccount.php');
require_once('modules/Import/UsersLastImport.php');
require_once('modules/Import/parse_utils.php');
require_once('include/utils/utils.php');

global $mod_strings;
global $app_list_strings;
global $app_strings;
global $current_user;
global $theme;

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

$parenttab = getParenttab();

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


$log->info("Import Undo");
$last_import = new UsersLastImport();
$ret_value = $last_import->undo($current_user->id);
?>

<br>


<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small">
        <tr>
         <td bgcolor="#FFFFFF" height="50" valign="middle" align="left" class="mailClientBg genHeaderSmall"> <?php echo $mod_strings['LBL_MODULE_NAME']; ?> <?php echo $app_strings[$_REQUEST['module']] ; ?> </td>
        </tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
				<td align="left"  style="padding-left:40px;">
					<span class="genHeaderGray"><?php echo $mod_strings['LBL_STEP_3_3']; ?></span>&nbsp;
					<span class="genHeaderSmall"><?php echo $mod_strings['LBL_MAPPING_RESULTS']; ?></span>
				</td>
		</tr>
          <tr>
                <td style="padding-left:140px;">
					<br>
					<?php 
					if ($ret_value) {
					?>
					<?php echo "<b>" . $mod_strings['LBL_SUCCESS']."</b>" ?><BR><br>
					<?php echo $mod_strings['LBL_LAST_IMPORT_UNDONE'] ?>
					<?php 
					} 
					else 
					{
					?>
					<?php echo $mod_strings['LBL_FAIL'] ?><br>
					<?php echo $mod_strings['LBL_NO_IMPORT_TO_UNDO'] ?>
					<?php
					} 
					?>
					<br>
					<br>
				</td>
			</tr>
			<tr>
				<td align="right" class="reportCreateBottom" >
					<form name="Import" method="POST" action="index.php">
					<input type="hidden" name="module" value="<?php echo $_REQUEST['module']; ?>">
					<input type="hidden" name="action" value="Import">
					<input type="hidden" name="step" value="1">
					<input type="hidden" name="return_module" value="<?php echo $_REQUEST['RETURN_MODULE'] ?>">
					<input type="hidden" name="return_id" value="<?php echo $_REQUEST['RETURN_ID'] ?>">
					<input type="hidden" name="return_action" value="<?php echo $_REQUEST['RETURN_ACTION'] ?>">	
					<input type="hidden" name="parenttab" value="<?php echo $parenttab ?>">
					<input title="<?php echo $mod_strings['LBL_TRY_AGAIN'] ?>" accessKey="" class="crmbutton small save" type="submit" name="button" value="  <?php echo $mod_strings['LBL_TRY_AGAIN'] ?>  ">
					</form>
				</td>
			</tr>
		</table>

