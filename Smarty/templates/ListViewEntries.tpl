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
{if $smarty.request.ajax neq ''}
&#&#&#{$ERROR}&#&#&#
{/if}

<form name="massdelete" method="POST" action="index.php">
     <input name='search_url' id="search_url" type='hidden' value='{$SEARCH_URL}'>
     <input name="idlist" id="idlist" type="hidden">
     <input name="action" id="action" type="hidden">
     <input name="module" id="module" type="hidden">
     <input id="viewname" name="viewname" type="hidden" value="{$VIEWID}">
     <input name="change_owner" type="hidden">
     <input name="change_status" type="hidden">
     <input name="allids" type="hidden" value="{$ALLIDS}">
				<!-- List View Master Holder starts -->
				<table border=0 cellspacing=1 cellpadding=0 width=100% class="lvtBg">
				<tr>
				<td>
				<!-- List View's Buttons and Filters starts -->
		        <table border=0 cellspacing=0 cellpadding=2 width=100% class="small">
			    <tr>
				<!-- Buttons -->
                 <td style="width:10px;"><img border="0" src="themes/images/filter.png"></td>
                <td style="padding-right:50px;padding-left:9px;" align="left" nowrap>
                <a id="moreoperate" href="index.php?module=Contacts&action=index" target="main" onmouseover="fnDropDown(this,'selectoperate');" onmouseout="fnHideDrop('selectoperate');" >批量操作<img border="0" src="themes/images/collapse.gif"></a>
                 </td>
				
				<!-- Page Navigation -->
				<td nowrap width="100%" align="right" valign="middle">
					<table border=0 cellspacing=0 cellpadding=0 class="small">
					     <tr><td style="padding-right:5px">{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}</td></tr>
					</table>
				</td>
			
					
       		    </tr>
			</table>
			<!-- List View's Buttons and Filters ends -->
			
			<div  >
			<table border=0 cellspacing=1 cellpadding=3 width=100% class="lvt small">
			<!-- Table Headers -->
			<tr>
            <td class="lvtCol"><input type="checkbox"  name="selectall" onClick=toggleSelect(this.checked,"selected_id")></td>
				 {foreach name="listviewforeach" item=header from=$LISTHEADER}
 			<td class="lvtCol">{$header}</td>
				{/foreach}
			</tr>
			<!-- Table Contents -->
			{foreach item=entity key=entity_id from=$LISTENTITY}
			<tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
			<td width="2%"><input type="checkbox" NAME="selected_id" value= '{$entity_id}' onClick=toggleSelectAll(this.name,"selectall")></td>
			{foreach item=data from=$entity}	
			<td>{$data}</td>
	        {/foreach}
			</tr>
			{foreachelse}
			<tr><td style="background-color:#efefef;height:340px" align="center" colspan="{$smarty.foreach.listviewforeach.iteration+1}">
			<div style="border: 3px solid rgb(153, 153, 153); background-color: rgb(255, 255, 255); width: 45%; position: relative; z-index: 0.1;">
										
				<table border="0" cellpadding="5" cellspacing="0" width="98%">
				<tr>
					<td rowspan="2" width="25%"><img src="{$IMAGE_PATH}empty.jpg" height="60" width="61"></td>
					<td style="border-bottom: 1px solid rgb(204, 204, 204);" nowrap="nowrap" width="75%"><span class="genHeaderSmall">
					{$APP.LBL_FOUND}
					</span></td>
				</tr>
				
				</table> 
					
				</div>					
				</td></tr>	
			{/foreach}
                
			 </table>
		       </td>
		   </tr>
	    </table>
			 </div>
   </form>	
<div id="basicsearchcolumns" style="display:none;"><select name="search_field" id="bas_searchfield" class="txtBox" style="width:150px">{html_options  options=$SEARCHLISTHEADER}</select></div>
