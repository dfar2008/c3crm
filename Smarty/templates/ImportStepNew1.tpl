<link href="swfupload/css/default2.css" rel="stylesheet" type="text/css" />
{include file='Buttons_List.tpl'}	

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" class="small">
   <tr>
	<td class="showPanelBg" valign="top" width="100%">

		<table  cellpadding="0" cellspacing="0" width="100%" border=0>
		   <tr>
			<td width="75%" valign=top>
				<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
				<input type="hidden" name="module" value="{$MODULE}">
				<input type="hidden" name="step" value="1">
				<input type="hidden" name="source" value="{$SOURCE}">
				<input type="hidden" name="source_id" value="{$SOURCE_ID}">
				<input type="hidden" name="action" value="Import">
				<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
				<input type="hidden" name="return_id" value="{$RETURN_ID}">
				<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
				<input type="hidden" name="parenttab" value="{$CATEGORY}">
				<input type="hidden" name="filename" id="filename" value="">
				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small" border="0">
                
				   <tr>
					<td colspan="2" height="50" valign="middle" align="left" class="mailClientBg  genHeaderSmall">{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				  
				  
				   <tr ><td align="left" valign="top" colspan="2">&nbsp;</td></tr>
				   <tr >
					
                    <td align="left" width="50%" valign="middle"  style="padding-left:40px;">
                    说明:<br><br>
                   1.若不能上传文件，请刷新本页面即可。<br><br>
                   2.请保持文件默认编码ANSI，以免造成编码错误。<br><br>
                   3.导入文件的第一行"标题"请不要删除，添加或更改，以免不能导入<br><br>
                   4.重复的记录跳过不更新<br><br>
                    <a href="c3crm.csv"><font color=red size="+1"><b>>>下载样例</b></font></a>
                    </td>
					<td align="left" valign="middle" >
						<input type="file" name="userfile"  size="40"   class=small/>
                       
				   </tr>
				    <tr >
						<td  align="left" style="padding-left:40px;" class="reportCreateBottom">
                        &nbsp;
                        </td>
                        <td  align="right" style="padding-right:40px;" class="reportCreateBottom">
							<input title="{$MOD.LBL_NEXT}" accessKey="" class="crmButton small save" type="submit" name="button" value="   开始导入 &rsaquo; "  onclick="this.form.action.value='Import';this.form.step.value='2';">
						</td>
				   </tr>				</form>
				 </table>
				<br>
				<!-- IMPORT LEADS ENDS HERE -->
			</td>
		   </tr>
		</table>

	</td>
   </tr>
</table>
<br>