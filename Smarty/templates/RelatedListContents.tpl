<link href="include/ajaxtabs/ajaxtabs.css" type="text/css" rel="stylesheet"/>
{literal}
<style>
 .newtaba li a{
	padding-top:5px; 
	padding-bottom:5px;
	font-weight:normal;
 }
 .newtaba li a.selected{
	padding-top:5px; 
	padding-bottom:5px; 
	font-weight:bold;
 }
</style>
{/literal}
{if $SinglePane_View eq 'true'}
	{assign var = return_modname value='DetailView'}
{else}
	{assign var = return_modname value='CallRelatedList'}
{/if}

{if $RELATEDLISTS|@count neq 1}
<ul id="countrytabs" class="shadetabs newtaba" style=" white-space:nowrap; border-bottom:1px solid #999999;padding-bottom:8px;">
{foreach key=header name=foo item=detail from=$RELATEDLISTS}
  {if $smarty.foreach.foo.index eq 0}
   <li><a href="javascript:;" onClick="getTabViewForRelated('{$header}');return false;" id="{$header}" rel="#default" class="tablink selected">
   <input type="hidden" id="typeid" value="{$header}"/>
  {else}
   <li><a href="javascript:;" onClick="getTabViewForRelated('{$header}');return false;" id="{$header}" rel="#default" class="tablink">
  {/if}

 {if $APP.$header ne ''}
    {if $APP.$header == '产品'}
    &nbsp;已购买产品
    {else}
    &nbsp;{$APP.$header}
    {/if}
{else} 
    {if $header == '产品'}
    &nbsp;已购买产品
    {else}
    &nbsp;{$header}
    {/if}
{/if}
</li></a>
{if $smarty.foreach.foo.index ne 0 && $smarty.foreach.foo.index % 9 eq 0}
</ul>
<ul id="countrytabs" class="shadetabs newtaba" style=" white-space:nowrap;border-bottom:1px solid #999999;padding-top:5px;padding-bottom:6px;">
{/if}
{/foreach}
</ul>
{/if}

{foreach key=header name=foo  item=detail from=$RELATEDLISTS}
{if $smarty.foreach.foo.index eq 0}
<div id="{$header}1"  style="display:;">
{else}
<div id="{$header}1" style="display:none;">
{/if}

<table border=0 cellspacing=0 cellpadding=0 width=100% class="small" style="border-bottom:1px solid #999999;padding:5px;">
        <tr >
                {if $detail ne ''}
                <td align=left><!--{$detail.navigation.0}--></td>
                {$detail.navigation.1}
                {/if}
                <td align=right>
			{if $header eq 'Potentials'}			        
				<input title="{$APP.LBL_ADD_NEW} {$APP.Potential}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Potentials'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Potential}">                               
				 </td>                       
                        
			{elseif $header eq 'Accounts'}
				
				<input title="{$APP.LBL_ADD_NEW} {$APP.Account}" accessyKey="F" class="crmbutton small edit" onclick="this.form.action.value='EditView';this.form.module.value='Accounts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Account}"></td>
				
			{elseif $header eq 'Contacts' }				
				
				<input title="{$APP.LBL_ADD_NEW} {$APP.Contact}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='Contacts'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Contact}"></td>

			{elseif $header eq 'Attachments'}
			        {if $MODULE neq 'Maillists'}
						<input type="hidden" name="fileid">				
						<input title="{$APP.LBL_ADD_NEW} {$APP.LBL_ATTACHMENT}" accessyKey="F" class="crmbutton small create" onclick="window.open('upload.php?return_action={$return_modname}&return_module={$MODULE}&return_id={$ID}','Attachments','width=500,height=300,resizable=1,scrollbars=1');" type="button" name="button" value="{$APP.LBL_ADD_NEW} {$APP.LBL_ATTACHMENT}">
				{/if}
				</td>
			{elseif $header eq 'Notes'}
				<input title="{$APP.LBL_ADD_NEW} {$APP.Note}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView'; this.form.return_action.value='{$return_modname}'; this.form.module.value='Notes'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.Note}">&nbsp;
				<input type="hidden" name="fileid">
				</td>
			{elseif $header eq 'Sales Order'}				
				<input title="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}" accessyKey="F" class="crmbutton small create" onclick="this.form.action.value='EditView';this.form.module.value='SalesOrder'" type="submit" name="button" value="{$APP.LBL_ADD_NEW} {$APP.SalesOrder}"></td>				
			
			{elseif $header eq 'ModuleComments'}
				<input title="{$APP.LBL_ADD_NEW} {$APP.ModuleComments}" accessyKey="F" class="crmbutton small create" onclick="window.open('addComments.php?return_action={$return_modname}&return_module={$MODULE}&return_id={$ID}&crmid={$ID}','Comments','width=500,height=300');" type="button" name="button" value="{$APP.LBL_ADD_NEW} {$APP.ModuleComments}"></td>
			{elseif $header eq 'Memdays'}
				{if $MODULE == 'Accounts'}
					<input type="submit" value="{$APP.LBL_ADD_NEW} {$APP.Memdays}" class="crmbutton small create"
							onclick="this.form.action.value='EditView';this.form.module.value='Memdays'"/>
				{/if}
            {elseif $header eq 'Qunfas'}
				<input title=" 发送短信 " accessyKey="F" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Qunfas&action=ListView&idstring={$ID}&modulename={$MODULE}'" type="button" name="button" value=" 发送短信 "></td>
			{elseif $header eq 'Maillists'}
				<input title=" 发送邮件 " accessyKey="F" class="crmbutton small create" onclick="javascript:location.href='index.php?module=Maillists&action=ListView&idstring={$ID}&modulename={$MODULE}'" type="button" name="button" value=" 发送邮件 "></td>
			
            {elseif $header eq 'Activity History'}
                &nbsp;</td>
            {/if}
        </tr>
</table>
{if $detail ne ''}
	{foreach key=header item=detail from=$detail}
		{if $header eq 'header'}
			<table border=0 cellspacing=1 cellpadding=3 width=100% style="background-color:#eaeaea;" class="small">
				<tr style="height:25px;background:#DFEBEF" >
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
</div>
{/foreach}
<div id="selectadd" class="drop_mnu" onMouseOut="fnHideDrop('selectadd')" onMouseOver="fnShowDrop('selectadd')" >
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Notes&action=EditView&return_module=Accounts&return_action=DetailView&return_id={$ID}'" class="drop_down">{$APP.LBL_ADD_NEW} {$APP.Notes}</a></td></tr>

<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Accounts&action=EditView'" class="drop_down">{$APP.LNK_NEW_ACCOUNT}</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=SalesOrder&action=EditView&return_module=Accounts&return_action=DetailView&return_id={$ID}&account_id={$ID}'" class="drop_down">{$APP.LBL_ADD_NEW}  {$APP.SalesOrder}</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Memdays&action=EditView&return_module=Accounts&return_action=DetailView&return_id={$ID}&convertmode=invoicetodelivery'" class="drop_down">{$APP.LBL_ADD_NEW} {$APP.Memdays}</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Contacts&action=EditView&return_module=Accounts&return_action=DetailView&return_id={$ID}'" class="drop_down">{$APP.LBL_ADD_NEW} {$APP.Contacts}</a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Maillists&action=ListView&idstring={$ID}&modulename=Accounts'" class="drop_down"> 发送邮件 </a></td></tr>
<tr><td><a href="#" onclick="javascript:location.href='index.php?module=Qunfas&action=ListView&idstring={$ID}&modulename=Accounts'" class="drop_down"> 发送短信 </a></td></tr>

</table>
</div>
