{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
<br>
	
			

				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ogmailserver.gif" alt="Users" width="48" height="48" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Relsettings&action=index&parenttab=Settings">{$MOD.LBL_RELSETTINGS}</a> > {$MOD.LBL_DATABASE_SETUP} </b></td>
				</tr>
				<tr>
					<td valign=top class="small">{$MOD.LBL_DATABASE_BACKUP_DESCRIPTION} </td>
				</tr>
				</table>
			      <table border=0 cellspacing=0 cellpadding=5 width=100%>
			      
			       <tr>
				<td>
				 {$BACKUP_RESULT}
				</td>
			      </tr>
			     </table>
			    </td></tr></table>
			 </td></tr></table>
				
		
	</div>
	</form>
	
</td>
   </tr>
</tbody>
</table>
