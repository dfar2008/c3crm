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


<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
	<tr>
		<td class=small >		
			<!-- popup specific content fill in starts -->
	     
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white  class="small">
				<tr>
                    <td align="center">
                      <input title="{$APP.LNK_NEW_ACCOUNT}" accessKey="{$APP.LNK_NEW_ACCOUNT}" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Accounts&action=EditView'" type="button" name="Create" value="{$APP.LNK_NEW_ACCOUNT}">
                      &nbsp;&nbsp;
                      </td>
                    <td align="center">   
                      <input title="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='SalesOrder'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}"> &nbsp;&nbsp;
                      </td>
                      <td align="center">  
                      <input type="submit" value="{$APP.LBL_ADD_NEW} {$APP.Memdays}" class="crmbutton small create"
							onclick="this.form.action.value='EditView';this.form.module.value='Memdays'"/> &nbsp;&nbsp; 
                     </td>
                      </tr>
                      <tr>
                      <td align="center">  
                       <input title="{$APP.LBL_ADD_NEW} {$APP.Note}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='{$return_modname}'; this.form.module.value='Notes'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Note}">&nbsp;
				<input type="hidden" name="fileid">&nbsp;&nbsp; 
                 </td>
                      <td align="center">  
                <input title="{$APP.LBL_ADD_NEW} {$APP.Contact}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Contact}">
                    </td>
                </tr>
			</table>
		</td>
	</tr>
</table>

