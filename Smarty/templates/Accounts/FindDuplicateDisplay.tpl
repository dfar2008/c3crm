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
{literal}
<script language="javascript">
function getListViewEntries_js(module,url)
{
	$("status").style.display="inline";
	if($('search_url').value!='')
                urlstring = $('search_url').value;
	else
		urlstring = '';
        new Ajax.Request(
        	'index.php',
                {queue: {position: 'end', scope: 'command'},
                	method: 'post',
                        postBody:"module="+module+"&action="+module+"Ajax&file=FindDuplicate" + module + "&ajax=true&"+url+urlstring,
			onComplete: function(response) {
                        	$("status").style.display="none";
                                //result = response.responseText.split('&#&#&#');
				//alert(result);
                                $("duplicate_ajax").innerHTML= response.responseText;
                                if(result[1] != '')
                                        alert(result[1]);
                  	}
                }
        );
}

function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
}
</script>
{/literal}
<input type=hidden name="search_url" id="search_url" value="">
<table width="100%" cellpadding="2" cellspacing="0" border="0">
<tr>
	{if $VIEW eq true}
		<td>
			{include file='Buttons_List.tpl'}
		</td>
	{else}
		<td>
			&nbsp;
		</td>
	{/if}
</tr>

<tr><td>
<div id="duplicate_ajax">

{include file='Accounts/FindDuplicateAjax.tpl'}
</div>
<div id="current_action" style="display:none">{$smarty.request.action}</div>
</td></tr>
</table>

