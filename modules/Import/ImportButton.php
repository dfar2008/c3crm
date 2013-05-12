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

global $mod_strings;
global $allow_exports;
?>
<!--
<table width="100%" cellpadding="6">
<tr>
-->
<?php
require_once('include/utils/UserInfoUtil.php'); 
if ($_REQUEST['module'] == 'Products' ||
	$_REQUEST['module'] == 'Contacts' ||
	$_REQUEST['module'] == 'Potentials' ||
	$_REQUEST['module'] == 'Accounts' ||
	$_REQUEST['module'] == 'Leads')
{
	if(isPermitted($_REQUEST['module'],'Import') == 0)
	{
?>
<!--
<form name="Import" method="get" action="index.php">
<input type="hidden" name="module" value="<?php echo $_REQUEST['module']; ?>">
<input type="hidden" name="action" value="Import">
<input type="hidden" name="step" value="1">
<input type="hidden" name="return_module" value="<?php echo $_REQUEST['module']; ?>">
<input type="hidden" name="return_action" value="index">
<td valign="middle" align="right" width="99%"><input title="<?php echo $app_strings['LBL_IMPORT']; ?> <?php echo $mod_strings['LBL_MODULE_NAME']?>" accessKey="" class="button" type="submit" name="button" value="  <?php echo $app_strings['LBL_IMPORT']; ?> <?php echo $mod_strings['LBL_MODULE_NAME']?>  " ></td>
</form>
-->
<li>
	<a href="index.php?module=<?php echo $_REQUEST['module']; ?>&action=Import&step=1&return_module=<?php echo $_REQUEST['module']; ?>&return_action=index"><?php echo $app_strings['LBL_IMPORT']; ?> <?php echo $mod_strings['LBL_MODULE_NAME']?></a>
</li>
<?php
	}
}

if  ( $allow_exports=='all' || 
	(  $allow_exports=='admin' &&  is_admin($current_user))  ) 
	{
		if($_REQUEST['module'] != 'Calendar')
		{
			if(isPermitted($_REQUEST['module'],'Export') == 'yes')
			{
?>
<!--
<form name="EXPORT" method="get" action="include\export.php">
<input type="hidden" name="module" value="<?php echo $_REQUEST['module']; ?>">
<input type="hidden" name="all" value="1">
<input type="hidden" name="action" value="Export">
<td valign="middle" align="right" width="1%"><input title="<?php echo $app_strings['LBL_EXPORT_ALL']?> <?php echo $mod_strings['LBL_MODULE_NAME']?>" accessKey="" class="button" type="submit" name="button" value="  <?php echo $app_strings['LBL_EXPORT_ALL']?> <?php echo $mod_strings['LBL_MODULE_NAME']?>  " ></td>
</form>
-->
<li>
	<a href="index.php?module=<?php echo $_REQUEST['module']; ?>&action=Export&all=1"><?php echo $app_strings['LBL_EXPORT_ALL']?> <?php echo $mod_strings['LBL_MODULE_NAME']?></a>
</li>
<?php
			}
		}
	}
?>
<!--
</tr>
</table>
-->
