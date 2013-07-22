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

{*<!-- module header -->*}
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/UnifiedSearch.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/search.js"></script>
{if $MODULE eq 'Contacts'}
{$IMAGELISTS}
<script language="JavaScript" type="text/javascript" src="include/js/thumbnail.js"></script>
<div id="dynloadarea" style=float:left;position:absolute;left:350px;top:150px;></div>
{/if}
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>

{if $SEARCH_MODULE eq 'All'}
<script>
displayModuleList(document.getElementById('global_search_module'));
</script>
{/if}

{*<!-- Contents -->*}

{if $MODULE eq $SEARCH_MODULE && $SEARCH_MODULE neq ''}
	<div id="global_list_{$SEARCH_MODULE}" style="display:block">
{elseif $MODULE eq 'Contacts' && $SEARCH_MODULE eq ''}
	<div id="global_list_{$MODULE}" style="display:block">
{elseif $SEARCH_MODULE neq ''}
	<div id="global_list_{$MODULE}" style="display:none">
{else}
	<div id="global_list_{$MODULE}" style="display:block">
{/if}
<table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
     <form name="massdelete" method="POST">
     <input name="idlist" type="hidden">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <tr>
		<td>
	   <!-- PUBLIC CONTENTS STARTS-->
	   <br>
	   <div id="searchlistview_{$MODULE}" class="small" style="padding:2px">
        	{include file="GlobalListViewEntries.tpl"}
	   </div>
	   
	</td>
	</form>	
   </tr>
</table>

</div>
{$SELECT_SCRIPT}
