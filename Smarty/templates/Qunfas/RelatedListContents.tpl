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

{if $SinglePane_View eq 'true'}
	{assign var = return_modname value='DetailView'}
{else}
	{assign var = return_modname value='CallRelatedList'}
{/if}

{foreach key=header item=detail from=$RELATEDLISTS}

<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="border-bottom:1px solid #999999;padding:5px;">
        <tr>
                <td  valign=bottom>
		{if $APP.$header ne ''}
			<b>{$APP.$header}</b>
		{else}
			<b>{$header}</b>
		{/if}
		</td>
                {if $detail ne ''}
                <td align=center>{$detail.navigation.0}</td>
                {$detail.navigation.1}
                {/if}
                <td align=right>
			{if $header eq 'Potentials'}
                                <input title="{$APP.LBL_ADD_NEW} {$APP.Potential}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Potentials'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Potential}">
                        {elseif $header eq 'Products'}
                               <input title="{$APP.LBL_ADD_NEW} {$APP.Product}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Products';this.form.return_module.value='{$MODULE}';this.form.return_action.value='{$return_modname}'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Product}"></td>
			{elseif $header eq 'Leads'}
				<input title="Change" accessKey="" class="crmbutton small edit" value="{$APP.LBL_SELECT_BUTTON_LABEL} {$APP.Lead}" LANGUAGE=javascript onclick='return window.open("index.php?module=Leads&return_module={$MODULE}&return_action={$return_modname}&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid={$ID}","qunfa","width=640,height=602,resizable=1,scrollbars=1");' type="button"  name="button">
				<input title="{$APP.LBL_ADD_NEW} {$APP.Lead}" accessyKey="F" class="crmbutton small edit" onclick="this.form.action.value='EditView';this.form.module.value='Leads'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Lead}"></td>
			{elseif $header eq 'Accounts'}
				<input title="Change" accessKey="" class="crmbutton small edit" value="{$APP.LBL_SELECT_BUTTON_LABEL} {$APP.Account}" LANGUAGE=javascript onclick='return window.open("index.php?module=Accounts&return_module={$MODULE}&return_action={$return_modname}&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid={$ID}","qunfa","width=640,height=602,resizable=1,scrollbars=1");' type="button"  name="button">
				<input title="{$APP.LBL_ADD_NEW} {$APP.Account}" accessyKey="F" class="crmbutton small edit" onclick="this.form.action.value='EditView';this.form.module.value='Accounts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Account}"></td>
			{elseif $header eq 'Contacts' }				
				<input title="Change" accessKey="" class="crmbutton small edit" value="{$APP.LBL_SELECT_BUTTON_LABEL} {$APP.Contact}" LANGUAGE=javascript onclick='return window.open("index.php?module=Contacts&return_module={$MODULE}&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid={$ID}","qunfa","width=640,height=602,resizable=1,scrollbars=1");' type="button"  name="button">
				<input title="{$APP.LBL_ADD_NEW} {$APP.Contact}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Contact}"></td>
			{elseif $header eq 'Activities'}
				<input type="hidden" name="activity_mode">
				<input title="{$APP.LBL_ADD_NEW} {$APP.Event}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='{$return_modname}'; this.form.module.value='Calendar'; this.form.return_module.value='{$MODULE}'; this.form.activity_mode.value='Events'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Event}"></td>
			{elseif $header eq 'HelpDesk'}
				<input title="{$APP.LBL_ADD_NEW} {$APP.Ticket}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='HelpDesk'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Ticket}"></td>
			{elseif $header eq 'Campaigns'}
                                <input title="Change" accessKey="" class="crmbutton small edit" value="{$APP.LBL_SELECT_BUTTON_LABEL} {$APP.Campaign}" LANGUAGE=javascript onclick='return window.open("index.php?module=Campaigns&return_module={$MODULE}&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid={$ID}","qunfa","width=640,height=602,resizable=1,scrollbars=1");' type="button"  name="button"></td>
			{elseif $header eq 'Attachments'}
				<input type="hidden" name="fileid">				
				<input title="{$APP.LBL_ADD_NEW} {$APP.LBL_ATTACHMENT}" accessyKey="F" class="crmbutton small create" onclick="window.open('upload.php?return_action={$return_modname}&return_module={$MODULE}&return_id={$ID}','Attachments','width=500,height=300,resizable=1,scrollbars=1');" type="button" name="button" value="{$APP.LBL_ADD_NEW} {$APP.LBL_ATTACHMENT}">
			{elseif $header eq 'Sales Order'}				
				<input title="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='SalesOrder'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}"></td>
			{elseif $header eq 'Purchase Order'}
                                <input title="{$APP.LBL_ADD_NEW} {$APP.PurchaseOrder}" accessyKey="O" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.module.value='PurchaseOrder'; this.form.return_module.value='{$MODULE}'; this.form.return_action.value='{$return_modname}'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.PurchaseOrder}"></td>
                        {/if}
		</td>
        </tr>
</table>
{if $detail ne ''}
	{foreach key=header item=detail from=$detail}
		{if $header eq 'header'}
			<table border=0 cellspacing=1 cellpadding=3 width=100% style="background-color:#eaeaea;" class="small">
				<tr style="height:25px" bgcolor=white>
				{foreach key=header item=headerfields from=$detail}
					<td class="lvtCol">{$headerfields}</td>
				{/foreach}
                                </tr>
		{elseif $header eq 'entries'}
			{foreach key=header item=detail from=$detail}
				<tr bgcolor=white>
				{foreach key=header item=listfields from=$detail}
	                                 <td>{$listfields}</td>
				{/foreach}
				</tr>
			{/foreach}
			</table>
		{/if}
	{/foreach}
{else}
	<table style="background-color:#eaeaea;color:eeeeee" border="0" cellpadding="3" cellspacing="1" width="100%" class="small">
		<tr style="height: 25px;" bgcolor="white">
			<td><i>{$APP.LBL_NONE_INCLUDED}</i></td>
		</tr>
	</table>
{/if}
<br><br>
{/foreach}
