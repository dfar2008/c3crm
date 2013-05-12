<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<script language="javascript">
function getRelatedList(customField)
{ldelim}
	var modulename = customField.options[customField.options.selectedIndex].value;
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=RelatedList&fld_module='+modulename+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {ldelim}
				$("cfList").innerHTML=response.responseText;
			{rdelim}
		{rdelim}
	);	
{rdelim}

{literal}


function getCreateRelatedListForm(fld_module,relation_id,label,sequence,presence)
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateRelatedList&fld_module='+fld_module+'&parenttab=Settings&ajax=true&relation_id='+relation_id+'&label='+label+'&sequence='+sequence+'&presence='+presence,
			onComplete: function(response) {
				$("createrelatedlist").innerHTML=response.responseText;
				execJS($('createRelatedListLayer'));
			}
		}
	);

}
function validate_relatedlist() {
		if(document.addtodb.label.value == "") {
			alert("相关信息不能为空！");
			document.addtodb.label.focus();
			return false;
		}
		if(document.addtodb.sequence.value == "") {
			alert("显示顺序不能为空！");
			document.addtodb.sequence.focus();
			return false;
		} else {
			if(isNaN(trim(document.addtodb.sequence.value))) {
				alert("无效的数字");
				document.addtodb.sequence.focus();
				return false;
			}
		}
		return true;
}
{/literal}
</script>
<div id="createrelatedlist" style="display:block;position:absolute;width:300px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
        <br>

	<div align=center>
			{include file='SetMenu.tpl'}
			<!-- DISPLAY -->
			{if $MODE neq 'edit'}
			<b><font color=red>{$DUPLICATE_ERROR} </font></b>
			{/if}
			
				<table class="settingsSelUITopLine" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td rowspan="2" valign="top" width="50"><img src="{$IMAGE_PATH}relatedinfo.gif" alt="Users" title="Users" border="0" height="48" width="48"></td>
					<td class="heading2" valign="bottom"><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> &gt; {$MOD.LBL_RELATED_LIST}</b></td>
				</tr>

				<tr>
					<td class="small" valign="top">{$MOD.LBL_RELATED_LIST_DESCRIPTION}</td>
				</tr>
				</tbody></table>
				
				<br>
				<table border="0" cellpadding="10" cellspacing="0" width="100%">
				<tbody><tr>
				<td>

				<table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
				<tbody><tr>
					<td class="small" align="left">
					{$MOD.LBL_SELECT_CF_TEXT}
		                	<select name="pick_module" class="importBox" onChange="getRelatedList(this)">
                		        {foreach key=sel_value item=value from=$MODULES}
		                        {if $MODULE eq $sel_value}
                	                       	{assign var = "selected_val" value="selected"}
		                        {else}
                        	                {assign var = "selected_val" value=""}
                                	{/if}
	                                <option value="{$sel_value}" {$selected_val}>{$APP.$value}</option>
        		                {/foreach}
			                </select>
					<strong>{$MOD.LBL_RELATED_INFO}</strong>
					</td>
					</tr>
				</tbody>
				</table>
				<div id="cfList">
                                {include file="Settings/RelatedEntries.tpl"}
				</div>	
			<table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>

		  	<td class="small" align="right" nowrap="nowrap"><a href="#top">{$MOD.LBL_SCROLL}</a></td>
			</tr>
			</table>
			</td>
			</tr>
			</table>
		<!-- End of Display -->
		
		</td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </div>

        </td>
        </tr>
</tbody>
</table>
<br>
