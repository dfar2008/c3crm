<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	<form action="index.php" method="post" name="dbbackup" id="form">
	<input type="hidden" name="type" value="full">

	<input type="hidden" name="module" value="Relsettings">
	<input type="hidden" name="action">
	<input type="hidden" name="parenttab" value="Settings">
	<input type="hidden" name="return_module" value="Relsettings">
	<input type="hidden" name="return_action" value="index">
	<div align=center>
			

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
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
				<tr>
					<td class="big"><strong>{$MOD.LBL_DATABASE_BACKUP}</strong>&nbsp;<br>{$ERROR_MSG}</td>
				</tr>
				<tr>
					<td class="small">
					        {if $MSSQL_DISABLED eq 'true'}
						<font color='red'><strong>{$MOD.LBL_MSSQL_BACKUP_TIPS}</strong></font>						
						{else}
						<input class="crmButton small save" title="{$APP.LBL_SAVE_BUTTON_TITLE}" accessKey="{$APP.LBL_SAVE_BUTTON_KEY}" onclick="this.form.action.value='do_dbbackup'" type="submit" name="Edit" value="&nbsp;&nbsp;{$MOD.LBL_BACKUP_BUTTON_LABEL}&nbsp;&nbsp;">
						{/if}
					</td>
					
				</tr>
				</table>
				<!--
				<table cellspacing='1' cellpadding='3' >
				
				<tr>
				<td class="cellLabel">{$MOD.LBL_BACKUP_OPTION}</td>
				<td class="cellText"><input type="radio" name="ext_insert" class="radio" value='1'>{$APP.yes}&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ext_insert" class="radio" value='0' checked="checked">{$APP.no}</td>
				</tr>
				<tr>
				<td class="cellLabel">{$MOD.LBL_BACKUP_SIZE}</td>
				<td class="cellText"><input type="text" name="vol_size" value="{$vol_size}"></td>
				</tr>
				<tr>
				<td class="cellLabel">{$MOD.LBL_BACKUP_FILENAME}</td>
				<td class="cellText"><input type="text" name="sql_file_name" value="{$sql_name}"></td>
				</tr>
				</table>
				-->
			    </td></tr></table>
			 </td></tr></table>
				
		
	</div>
	</form>
	
</td>
   </tr>
</tbody>
</table>
