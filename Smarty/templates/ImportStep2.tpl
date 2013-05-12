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


<script type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<script type="text/javascript" src="include/js/general.js"></script>
<script>

function getImportSavedMap(impoptions)
{ldelim}
	var mapping = impoptions.options[impoptions.options.selectedIndex].value;

	//added to show the delete link
	if(mapping != -1)
		document.getElementById("delete_mapping").style.visibility = "visible";
	else
		document.getElementById("delete_mapping").style.visibility = "hidden";

	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Import&mapping='+mapping+'&action=ImportAjax',
			onComplete: function(response) {ldelim}
					$("importmapform").innerHTML = response.responseText;
				{rdelim}
			{rdelim}
		);
{rdelim}
function deleteMapping()
{ldelim}
	var options_collection = document.getElementById("saved_source").options;
	var mapid = options_collection[options_collection.selectedIndex].value;

	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Import&mapping='+mapid+'&action=ImportAjax&delete_map='+mapid,
			onComplete: function(response) {ldelim}
					$("importmapform").innerHTML = response.responseText;
				{rdelim}
			{rdelim}
		);

	//we have emptied the map name from the select list
	document.getElementById("saved_source").options[options_collection.selectedIndex] = null;
	document.getElementById("delete_mapping").style.visibility = "hidden";
	alert(alert_arr.MAPPING_LIST_DELETED);
{rdelim}

</script>
<!-- header - level 2 tabs -->
{include file='Buttons_List1.tpl'}	

<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%" class="small">
<tbody>
   <tr>
	<td class="showPanelBg" valign="top" width="100%">
		<table  cellpadding="0" cellspacing="0" width="100%" class="small">
		   <tr>
			<td width="75%" valign=top>
				<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
				<input type="hidden" name="module" value="{$MODULE}">
				<input type="hidden" name="action" value="Import">
				<input type="hidden" name="step" value="3">
				<input type="hidden" name="has_header" value="{$HAS_HEADER}">
				<input type="hidden" name="overwrite" value="{$OVERWRITE}">
				<input type="hidden" name="source" value="{$SOURCE}">
				<input type="hidden" name="delimiter" value="{$DELIMITER}">
				<input type="hidden" name="tmp_file" value="{$TMP_FILE}">
				<input type="hidden" name="return_module" value="{$RETURN_MODULE}">
				<input type="hidden" name="return_id" value="{$RETURN_ID}">
				<input type="hidden" name="return_action" value="{$RETURN_ACTION}">
				<input type="hidden" name="parenttab" value="{$CATEGORY}">

				<!-- IMPORT LEADS STARTS HERE  -->
				<br />
				<table align="center" cellpadding="5" cellspacing="0" width="95%" class="mailClient importLeadUI small">
				   <tr>
					<td class="mailClientBg genHeaderSmall" height="50" valign="middle" align="left" >{$MOD.LBL_MODULE_NAME}{$APP.$MODULE}</td>
				   </tr>
				   <tr>
					<td>&nbsp;</td>
				   </tr>
				   <tr>
					<td align="left"  style="padding-left:40px;">
						<span class="genHeaderGray">{$MOD.LBL_STEP_2_3} </span>&nbsp; 
						<span class="genHeaderSmall">{$APP.$MODULE} {$MOD.LBL_LIST_MAPPING} </span>
					</td>
				   </tr>
				   <tr>
					<td align="left" style="padding-left:40px;"> 
					   {$MOD.LBL_STEP_2_MSG} {$APP.$MODULE} {$MOD.LBL_STEP_2_MSG1} 
					   {$MOD.LBL_STEP_2_TXT} 
					</td>
				   </tr>
				   <tr>
					<td>&nbsp;</td>
				   </tr>
				   <tr>
					<td align="left" style="padding-left:40px;" >
						<input type="checkbox" name="use_saved_mapping" id="saved_map_checkbox" onclick="ActivateCheckBox()" />&nbsp;&nbsp;
						{$MOD.LBL_USE_SAVED_MAPPING}&nbsp;&nbsp;&nbsp;{$SAVED_MAP_LISTS}
					</td>
				   </tr>
				   <tr>
					<td  align="left"style="padding-left:40px;padding-right:40px;">
						<table style="background-color: rgb(204, 204, 204);" class="small" border="0" cellpadding="5" cellspacing="1" width="100%" >
						   <tr bgcolor="white">
							<td width="25%" class="lvtCol" align="center"><b>{$MOD.LBL_MAPPING}</b></td>
							{if $HASHEADER eq 1}
							<td width="25%" bgcolor="#E1E1E1"  ><b>{$MOD.LBL_HEADERS}</b></td>
							<td width="25%" ><b>{$MOD.LBL_ROW} 1</b></td>
							<td width="25%" ><b>{$MOD.LBL_ROW} 2</b></td>
							{else}
							<td width="25%" ><b>{$MOD.LBL_ROW} 1</b></td>
							<td width="25%" ><b>{$MOD.LBL_ROW} 2</b></td>
							<td width="25%" ><b>{$MOD.LBL_ROW} 3</b></td>
							{/if}
						   </tr>
						</table>
						{assign var="Firstrow" value=$FIRSTROW}
						{assign var="Secondrow" value=$SECONDROW}
						{assign var="Thirdrow" value=$THIRDROW}				
						<table border="0" cellpadding="0" cellspacing="0" width="100%">
						   <tr>
							<td width="25%" valign="top">
								<div id="importmapform">
									{include file="ImportMap.tpl"}
								</div>
							</td>	
							<td valign="top">
								<table border="0" cellpadding="0" cellspacing="1" width="100%" valign="top"  class="small">
								   {foreach name=iter item=row1 from=$Firstrow}
									{assign var="counter" value=$smarty.foreach.iter.iteration}
									{math assign="num" equation="x - y" x=$counter y=1}	
								   <tr bgcolor="white" >
									{if $HASHEADER eq 1}
										<td bgcolor="#E1E1E1" width="33%" height="30">&nbsp;{$row1}</td>
										<td width="34%">&nbsp;{$Secondrow[$num]}</td>
										<td>&nbsp;{$Thirdrow[$num]}</td>
									{else}
										<td width="31%" height="30">&nbsp;{$row1}</td>
										<td width="30%">&nbsp;{$Secondrow[$num]}</td>
										<td>&nbsp;{$Thirdrow[$num]}</td>
									{/if}	
								   </tr>
								   {/foreach}
								</table>
							</td>
						   </tr>
						</table>	
					</td>
				   </tr>
				   <tr>
					<td align="left" style="padding-left:40px;" >
						<input type="checkbox" name="save_map" id="save_map" onclick="set_readonly(this.form)" />&nbsp;&nbsp;
						{$MOD.LBL_SAVE_AS_CUSTOM} &nbsp;&nbsp;&nbsp;
						<input type="text" readonly name="save_map_as" id="save_map_as" value="" class="importBox" >
					</td>
				   </tr>
				   <tr >
					<td align="right" style="padding-right:40px;" class="reportCreateBottom" >
						<input type="submit" name="button"  value=" &nbsp;&lsaquo; {$MOD.LBL_BACK} &nbsp; " class="crmbutton small cancel" onclick="this.form.action.value='Import';this.form.step.value='1'; return true;" />
						&nbsp;&nbsp;
						<input type="submit" name="button"  value=" &nbsp; {$MOD.LBL_IMPORT_NOW} &rsaquo; &nbsp; " class="crmbutton small save" onclick="this.form.action.value='Import';this.form.step.value='3'; return validate_import_map();" />
					</td>
				   </tr>
				  </table>
				</form>
				<!-- IMPORT LEADS ENDS HERE -->	
			</td>
		   </tr>
		</table>
	</td>
   </tr>
</table>

