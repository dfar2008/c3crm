{assign var = return_modname value='DetailView'}


{foreach key=header name=foo  item=detail from=$RELATEDLISTS}

{if $type eq $header}
<div id="{$header}"  style="display:;">
{else}
<div id="{$header}"  style="display:none;">
{/if}

<table class="table table-bordered  table-condensed" style="margin-bottom:1px;background:#DFEBEF;">
	<tr>
		<td align="left" ><i class="cus-text_padding_left"></i>&nbsp;<b>{$APP.$header}</b></td>
		<td align="right">
			{if $header eq 'Potentials'}			        
				<input title="{$APP.LBL_ADD_NEW} {$APP.Potential}" accessyKey="F" class="btn btn-small btn-primary" onclick="this.form.action.value='EditView';this.form.module.value='Potentials'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Potential}">                               
                        
			{elseif $header eq 'Accounts'}
				
				<input title="{$APP.LBL_ADD_NEW} {$APP.Account}" accessyKey="F" class="btn btn-small btn-primary" onclick="this.form.action.value='EditView';this.form.module.value='Accounts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Account}">
				
			{elseif $header eq 'Contacts' }				
				
				<!--<input title="{$APP.LBL_ADD_NEW} {$APP.Contact}" accessyKey="F" class="btn btn-small btn-primary" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Contact}">-->
				<button title="{$APP.LBL_ADD_NEW} {$APP.Contact}" accessyKey="F" class="btn btn-small btn-primary" type="button" onclick="editAccountRelInfo('index.php?module=Contacts&action=PopupEditView&return_action=CallRelatedList&return_id={$ID}&parenttab=Customer&moduletype=Contacts&return_module={$MODULE}')" name="button">
					<i class="icon-plus icon-white"></i> {$APP.LBL_ADD_NEW} {$APP.Contact}
				</button>

			{elseif $header eq 'Attachments'}
			        {if $MODULE neq 'Maillists'}
						<input type="hidden" name="fileid">				
						<input title="{$APP.LBL_ADD_NEW} {$APP.LBL_ATTACHMENT}" accessyKey="F" class="btn btn-small btn-primary" onclick="window.open('upload.php?return_action={$return_modname}&return_module={$MODULE}&return_id={$ID}','Attachments','width=500,height=300,resizable=1,scrollbars=1');" type="button" name="button" value="{$APP.LBL_ADD_NEW} {$APP.LBL_ATTACHMENT}">
				{/if}
			{elseif $header eq 'Notes'}
				<button title="{$APP.LBL_ADD_NEW} {$APP.Note}" accessyKey="F" class="btn btn-small btn-primary" onclick="editAccountRelInfo('index.php?module=Notes&action=PopupEditView&return_action=CallRelatedList&return_id={$ID}&parenttab=Customer&moduletype=Notes&return_module={$MODULE}')" type="button" name="button">
					<i class="icon-plus icon-white"></i> {$APP.LBL_ADD_NEW} {$APP.Note}
				</button>
				<!--this.form.action.value='EditView'; this.form.return_action.value='{$return_modname}'; this.form.module.value='Notes'-->
				<input type="hidden" name="fileid">
			{elseif $header eq 'Sales Order'}				
				<button title="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}" accessyKey="F" class="btn btn-small btn-primary" onclick="this.form.action.value='EditView';this.form.module.value='SalesOrder'" type="submit" name="button" >
					<i class="icon-plus icon-white"></i> {$APP.LBL_ADD_NEW} {$APP.SalesOrder}
				</button>
			
			{elseif $header eq 'ModuleComments'}
				<input title="{$APP.LBL_ADD_NEW} {$APP.ModuleComments}" accessyKey="F" class="btn btn-small btn-primary" onclick="window.open('addComments.php?return_action={$return_modname}&return_module={$MODULE}&return_id={$ID}&crmid={$ID}','Comments','width=500,height=300');" type="button" name="button" value="{$APP.LBL_ADD_NEW} {$APP.ModuleComments}">
			{elseif $header eq 'Memdays'}
				{if $MODULE == 'Accounts'}
					<button type="button" class="btn btn-small btn-primary" onclick="editAccountRelInfo('index.php?module=Memdays&action=PopupEditView&moduletype=Memdays&parenttab=Customer&ajax=true&return_module={$MODULE}&return_action=CallRelatedList&return_id={$ID}')"/>
						<i class="icon-plus icon-white"></i> {$APP.LBL_ADD_NEW} {$APP.Memdays}
					</button>
					<!-- openNewWindow();this.form.action.value='EditView';this.form.module.value='Memdays'   )-->
				{/if}
            {elseif $header eq 'Qunfas'}
				<input title=" 发送短信 " accessyKey="F" class="btn btn-small btn-primary" onclick="javascript:location.href='index.php?module=Qunfas&action=ListView&idstring={$ID}&modulename={$MODULE}'" type="button" name="button" value=" 发送短信 ">
			{elseif $header eq 'Maillists'}
				<input title=" 发送邮件 " accessyKey="F" class="btn btn-small btn-primary" onclick="javascript:location.href='index.php?module=Maillists&action=ListView&idstring={$ID}&modulename={$MODULE}'" type="button" name="button" value=" 发送邮件 ">
			  
            {elseif $header eq 'Activity History'}
            {/if}
       </td>
   </tr>
</table>
{if $detail ne ''}
	{foreach key=header item=detail from=$detail}
		{if $header eq 'header'}
			<table class="table table-bordered table-hover table-condensed table-striped">
				<tr >
				{foreach key=header item=headerfields from=$detail}
					<th align=left>{$headerfields}</th>
				{/foreach}
             </tr>
		{elseif $header eq 'entries'}
			{foreach key=header item=detail from=$detail}
				<tr>
				{foreach key=header item=listfields from=$detail}
	               <td>{$listfields}</td>
				{/foreach}
				</tr>
			{/foreach}
			</table>
		{/if}
	{/foreach}
{else}	
	<table class="table table-bordered table-hover table-condensedfordv dvtable">
		<tr >
			<td align="center"><i>{$APP.LBL_NONE_INCLUDED}</i></td>
		</tr>
	</table>
{/if}

<br><br>
</div>
{/foreach}
