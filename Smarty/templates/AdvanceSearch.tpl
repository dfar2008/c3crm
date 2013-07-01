
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>高级搜索</h3>
</div>
<div id="advSearch" class="modal-body">
<form name="advSearch" action="index.php" onsubmit="return false;">
<input type="hidden" name="searchtype" value="advance">
<input type="hidden" name="module" value="{$MODULE}">
<input type="hidden" name="parenttab" value="{$CATEGORY}">
<input type="hidden" name="action" value="index">
<input type="hidden" name="query" value="true">
<input type="hidden" name="search_cnt">
		<table  cellspacing=0 cellpadding=5 width=98% class="searchUIAdv1 small" align="center" border=0>
			<tr>
					<td class="searchUIName small" nowrap align="left"><span class="moduleName">{$APP.LBL_SEARCH}</span></td>
					{if $SEARCHMATCHTYPE=='all'}
					<td nowrap class="small"><b><input name="matchtype" type="radio" value="all" checked>&nbsp;{$APP.LBL_ADV_SEARCH_MSG_ALL}</b></td>
					<td nowrap width=60% class="small" ><b><input name="matchtype" type="radio" value="any" >&nbsp;{$APP.LBL_ADV_SEARCH_MSG_ANY}</b></td>
					{else}
					<td nowrap class="small"><b><input name="matchtype" type="radio" value="all">&nbsp;{$APP.LBL_ADV_SEARCH_MSG_ALL}</b></td>
					<td nowrap width=60% class="small" ><b><input name="matchtype" type="radio" value="any" checked>&nbsp;{$APP.LBL_ADV_SEARCH_MSG_ANY}</b></td>
					{/if}
			</tr>
		</table>
		<table cellpadding="2" cellspacing="0" 	="98%" align="center" class="searchUIAdv2 small" border=0>
			<tr>
				<td align="center" class="small" width=90%>
				<div id="fixed" style="position:relative;width:98%;height:300px;padding:0px; overflow:auto;border:1px solid #CCCCCC;background-color:#ffffff" class="small">
					<table border=0 width=95%>
					<tr>
					<td align=left>
						<table width="100%"  border="0" cellpadding="2" cellspacing="0" id="adSrc" align="left">
						
							{if $SEARCHCONSHTML}
							   {foreach from=$SEARCHCONSHTML  item=cons name=foo}
							     <tr  >
								<td width="31%">
								<select name="Fields{$smarty.foreach.foo.index}" class="detailedViewTextBox" >
								{$cons.0}
								</select>
								</td>
								<td width="32%">
								<select name="Condition{$smarty.foreach.foo.index}" class="detailedViewTextBox" >
									{$cons.1}
								</select>
								</td>
								<td width="32%">
								<input type="text" name="Srch_value{$smarty.foreach.foo.index}" value="{$cons.2}" class="detailedViewTextBox"> 
								</td>
							        </tr>
							     {/foreach}
							{else}
							     <tr  >
								<td width="31%">
								<select name="Fields0" class="detailedViewTextBox" >
								{$FIELDNAMES}
								</select>
								</td>
								<td width="32%">
								<select name="Condition0" class="detailedViewTextBox" >
									{$CRITERIA}
								</select>
								</td>
								<td width="32%">
								<input type="text" name="Srch_value0" class="detailedViewTextBox">
								</td>
							     </tr>
							{/if}
						
						</table>
					</td>
					</tr>
				</table>
				</div>	
				</td>
			</tr>
		</table>
		
    </form>
</div>	
<div class="modal-footer">
	<div class="pull-left">
		<button class="btn btn-success" onClick="fnAddSrch('{$FIELDNAMES}','{$CRITERIA}')">{$APP.LBL_MORE_BUTTON}</button>
		<button class="btn btn-success" onclick="delRow()">{$APP.LBL_FEWER_BUTTON}</button>
	</div>
	<div class="pull-right">
	 <button class="btn btn-primary" onClick="totalnoofrows();callSearch('Advanced');">立即查找</button>
	 <button class="btn" onclick="clearSearchResult('{$MODULE}','advSearch');" data-dismiss="modal" aria-hidden="true">取消查找</button>	
	</div>
</div>
