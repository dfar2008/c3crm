<script language="JavaScript" type="text/javascript" src="include/js/customview.js"></script>
<script language="javascript">
function getCustomFieldList(customField)
{ldelim}
	var modulename = customField.options[customField.options.selectedIndex].value;
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CustomFieldList&fld_module='+modulename+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {ldelim}
				$("cfList").innerHTML=response.responseText;
			{rdelim}
		{rdelim}
	);	
{rdelim}

{literal}
function deleteCustomField(id, fld_module, colName, uitype)
{
        if(confirm(alert_arr.SURE_TO_DELETE))
        {
                document.form.action="index.php?module=Settings&action=DeleteCustomField&fld_module="+fld_module+"&fld_id="+id+"&colName="+colName+"&uitype="+uitype
                document.form.submit()
        }
}

function getCreateCustomFieldForm(customField,id,tabid,ui)
{
        var modulename = customField;
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateCustomField&fld_module='+customField+'&parenttab=Settings&ajax=true&fieldid='+id+'&tabid='+tabid+'&uitype='+ui,
			onComplete: function(response) {
				$("createcf").innerHTML=response.responseText;
				gselected_fieldtype = '';
			}
		}
	);

}
function makeFieldSelected(oField,fieldid)
{
	if(gselected_fieldtype != '')
	{
		$(gselected_fieldtype).className = 'customMnu';
	}
	oField.className = 'customMnuSelected';	
	gselected_fieldtype = oField.id;	
	selFieldType(fieldid)
	document.getElementById('selectedfieldtype').value = fieldid;
}
function CustomFieldMapping()
{
        document.form.action="index.php?module=Settings&action=LeadCustomFieldMapping";
        document.form.submit();
}
var gselected_fieldtype = '';
{/literal}
</script>
<div class="container-fluid" style="height:602px;">
	   <!--Dashboad-->
	<div class="container-fluid" style="height:602px;">
		<div class="row-fluid">
			<div class="span2" style="margin-left:-10px;">
				<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
					{include file='Settings/SettingLeft.tpl'}
				</div>
			</div>

			<div class="span10" style="margin-left:10px;">
				<!--	Setting		-->
				<div class="row-fluid box">
					  <div class="padded">
						<div id="createcf" style="display:block;position:absolute;width:500px;"></div>
						<table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
						 <tbody><tr><td class="small" align="left">
							{$MOD.LBL_SELECT_CF_TEXT}
							<select name="pick_module" class="importBox" onChange="getCustomFieldList(this)">
							{foreach key=sel_value item=value from=$MODULES}
							{if $MODULE eq $sel_value}
								{assign var = "selected_val" value="selected"}
							{else}
								{assign var = "selected_val" value=""}
							{/if}
							<option value="{$sel_value}" {$selected_val}>{$APP.$value}</option>
							{/foreach}
							</select>
							<strong>{$MOD.LBL_CUSTOM_FILED_IN}</strong>
							</td>
							</tr>
						</tbody>
						</table>
						<div id="cfList">
						{include file="Settings/CustomFieldEntries.tpl"}
						</div>
					  </div>
				</div>
					
				</div>
				
			</div>
	</div></div>
</div>