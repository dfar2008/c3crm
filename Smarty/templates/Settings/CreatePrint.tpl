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

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
<br>
	<div align=center>
	
			{include file='SetMenu.tpl'}
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<form action="index.php" method="post" name="templatecreate" onsubmit="return check4null();">  
				<input type="hidden" name="action">
				<input type="hidden" name="mode" value="{$EMODE}">
				<input type="hidden" name="module" value="Users">
				<input type="hidden" name="templateid" value="{$TEMPLATEID}">
				<input type="hidden" name="parenttab" value="PARENTTAB}">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}ViewTemplate.gif" alt="Users" width="45" height="60" border=0 title="Users"></td>
				{if $EMODE eq 'edit'}
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > <a href="index.php?module=Users&action=listemailtemplates&parenttab=Settings">{$UMOD.LBL_EMAIL_TEMPLATES}</a> &gt; {$MOD.LBL_EDIT} &quot;{$TEMPLATENAME}&quot; </b></td>
				{else}
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > <a href="index.php?module=Users&action=listemailtemplates&parenttab=Settings">{$UMOD.LBL_EMAIL_TEMPLATES}</a> &gt; {$MOD.LBL_CREATE_EMAIL_TEMPLATES} </b></td>
				{/if}
					
				</tr>
				<tr>
					<td valign=top class="small">{$UMOD.LBL_EMAIL_TEMPLATE_DESC}</td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						{if $EMODE eq 'edit'}
						<td class="big"><strong>{$UMOD.LBL_PROPERTIES} &quot;{$TEMPLATENAME}&quot; </strong></td>
						{else}
						<td class="big"><strong>{$MOD.LBL_CREATE_EMAIL_TEMPLATES}</strong></td>
						{/if}
						<td class="small" align=right>
							<input type="submit" value="{$APP.LBL_SAVE_BUTTON_LABEL}" class="crmButton small save" onclick="this.form.action.value='saveemailtemplate'; this.form.parenttab.value='Settings'" >&nbsp;&nbsp;
			{if $EMODE eq 'edit'}
				<input type="submit" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="crmButton small cancel" onclick="cancelForm(this.form)" />
			{else}
				<input type="button" value="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="crmButton small cancel" onclick="goback()" >
			{/if}
						</td>
					</tr>
					</table>
					
					</td>
					  </tr>
					</table>
					<br>
					
				</td>
				</tr>
				</table>
			
			
			
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</form>
	</table>
		
	</div>

</td>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
   </tr>
</tbody>
</table>
<script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
       <script type="text/javascript" defer="1">
       var oFCKeditor = null;
       oFCKeditor = new FCKeditor( "PrintTemplate","100%","350","Default","Template") ;       
       oFCKeditor.BasePath   = "include/fckeditor/" ;
       oFCKeditor.ReplaceTextarea() ;
</script>