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
require_once('modules/Import/UsersLastImport.php');
require_once('modules/Import/parse_utils.php');
require_once('include/ListView/ListView.php');
require_once('modules/Contacts/Contacts.php');
require_once('include/utils/utils.php');


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

$smarty->assign("MODULE", 'SalesOrder');
$smarty->assign("SINGLE_MOD", 'SalesOrder');
$smarty->assign("CATEGORY",'Accounts');


$smarty->display("Buttons_List1.tpl");
$skipped_record_count = $_SESSION['import_skipped_record_count'];
$import_mod_strings=return_module_language($current_language, "Import");
if (isset($_SESSION['import_message']))
{
	$themessage=$_SESSION['import_message'];
	@session_unregister('import_message');
	?>
	<br>

	<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small">
	   <tr>
		<td height="50" valign="middle" align="left" class="mailClientBg genHeaderSmall">
			 <?php echo $import_mod_strings['LBL_MODULE_NAME']; ?> <?php echo '合同订单'; ?> 
		</td>
	   </tr>
	   <tr><td>&nbsp;</td></tr>
	   <tr>
		<td align="left"  style="padding-left:40px;width:75%;" >
			<span class="genHeaderGray"><?php echo '导入完成'; ?></span>&nbsp; 
			<span class="genHeaderSmall"><?php echo $import_mod_strings['LBL_MAPPING_RESULTS']; ?></span>
		</td>
	   </tr>	
	   <tr>
		<td style="padding-left:140px;">
			<?php 
				echo $themessage; 
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
                 <input title="<?php echo '完成'?>" accessKey="" class="crmbutton small save" type="button" name="button" value="  <?php echo '完成' ?>  "  onclick="document.location.href='index.php?module=SalesOrder&action=index';">
                 <input title="<?php echo $import_mod_strings['LBL_IMPORT_MORE'] ?>" accessKey="" class="crmbutton small save" type="button" name="button" value="  <?php echo $import_mod_strings['LBL_IMPORT_MORE'] ?>  "  onclick="document.location.href='index.php?module=SalesOrder&action=Import';">
				 <?php
					 if($skipped_record_count > 0)
	                 {
				?>
					<input title="<?php echo '下载忽略记录' ?>" accessKey="" class="crmbutton small save" type="button" name="button" value="  <?php echo '下载忽略记录' ?>  " onclick="document.location.href='index.php?module=SalesOrder&action=Popup_skippedrows';">
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
