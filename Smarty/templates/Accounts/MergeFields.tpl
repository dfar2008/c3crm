<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<link href="themes/softed/style.css" rel="stylesheet" type="text/css"></link>
<script language="JavaScript" type="text/javascript" src="include/js/zh_cn.lang.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="modules/{$MODULE}/{$SINGLE_MOD}.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>
</head>
<form name="merge" method="POST" action="index.php" id="form" onsubmit="return validate_merge('{$MODULENAME}');">
	<input type=hidden name="module" value="{$MODULENAME}">
	
	<input type=hidden name="return_module" value="{$MODULENAME}">
	<input type="hidden" name="action" value="MergeSave{$MODULENAME}">
	<input type="hidden" name="parent" value="{$PARENT_TAB}">
	<input type="hidden" name="pass_rec" value="{$IDSTRING}">
	<input type="hidden" name="return_action" value="FindDuplicate{$MODULENAME}">
	
	<br>
		<table border="0" cellspacing=0  cellpadding=o width="100%">	
			<tr>
				<td align="left" colspan="2">
				<span class="moduleName">{$MOD.LBL_MERGE_DATA}</span><br>
				<span font-weight:normal><font size="2">{$MOD.LBL_DESC_FOR_MERGE_FIELDS}</font></span>
				</td>
			</tr>
		</table>
	<br>
		<table class="lvt small" border="0" cellpadding="3" cellspacing="1" width="100%">
			<tr >
				<td  class="lvtCol">
					<b>{$MOD.LBL_FIELDLISTS}</b>
				</td>
				{assign var=count value=1}
				{assign var=cnt_rec value=0}
				{if $NO_EXISTING eq 1}
					{foreach key=cnt item=record from=$ID_ARRAY}	
						<td  class="lvtCol" >
							<b>{$MOD.LBL_RECORD}{$count}</b>
							{if $count eq 1}
								<input name="record" value="{$record}" onclick="select_All('{$JS_ARRAY}','{$cnt}','{$MODULENAME}');" type="radio" checked> <span style="font-size:11px">{$MOD.LBL_SELECT_AS_PARENT}</span>
							{else}
								<input name="record" value="{$record}" onclick="select_All('{$JS_ARRAY}','{$cnt}','{$MODULENAME}');" type="radio"> <span style="font-size:11px">{$MOD.LBL_SELECT_AS_PARENT}</span>
							{/if}
						</td>
						{assign var=cnt_rec value=$cnt_rec+1}
						{assign var=count value=$count+1}
					{/foreach}
				{else}
					{foreach key=cnt item=record from=$ID_ARRAY}	
						<td  class="lvtCol" >
							<b>{$MOD.LBL_RECORD}{$count}</b>
						{assign var=found value=0}
						{foreach item=child key=k from=$IMPORTED_RECORDS}
							{if $record eq $child}	
								{assign var=found value=1}
							{/if}
						{/foreach}
						{if $found eq 0}
							{if $count eq 1}
								<input name="record" value="{$record}" onclick="select_All('{$JS_ARRAY}','{$cnt}','{$MODULENAME}');" type="radio" checked> <span style="font-size:11px">{$MOD.LBL_SELECT_AS_PARENT}</span>
							{else}
								<input name="record" value="{$record}" onclick="select_All('{$JS_ARRAY}','{$cnt}','{$MODULENAME}');" type="radio"> <span style="font-size:11px">{$MOD.LBL_SELECT_AS_PARENT}</span>
							{/if}
						{/if}
						</td>
						{assign var=cnt_rec value=$cnt_rec+1}
						{assign var=count value=$count+1}
					{/foreach}
				{/if}
			</tr>
				{foreach item=data key=cnt from=$ALLVALUES}
				{foreach item=fld_array key=label from=$data}
			<tr class="IvtColdata" onmouseover="this.className='lvtColDataHover';" onmouseout="this.className='lvtColData';" bgcolor="white">
						
						{if $FIELD_ARRAY[$cnt] eq 'lastname' || $FIELD_ARRAY[$cnt] eq 'accountname' || $FIELD_ARRAY[$cnt] eq 'company' || $FIELD_ARRAY[$cnt] eq 'productname'} 
						<td ><b>{$label}<font color="red">*</font></b>
						</td>
						{else}
						<td ><b>{$label}</b>
						</td>
						{/if}
						{foreach item=fld_value key=cnt2 from=$fld_array}
							{if $fld_value.disp_value neq ''}
								{if $cnt2 eq 0}
									<td nowrap><input name='{$FIELD_ARRAY[$cnt]}' value='{$fld_value.org_value}' type="radio" checked>{$fld_value.disp_value}</td>
								{else}
									<td nowrap><input name='{$FIELD_ARRAY[$cnt]}' value='{$fld_value.org_value}' type="radio">{$fld_value.disp_value}</td>
								{/if}
							{else}
								{if $cnt2 eq 0}
									<td><input name='{$FIELD_ARRAY[$cnt]}' value='' type="radio" checked>{$APP.LBL_NONE}</td>
								{else}
									<td><input name='{$FIELD_ARRAY[$cnt]}' value='' type="radio">{$APP.LBL_NONE}</td>
								{/if}
							{/if}
						{/foreach}
			</tr>
					{/foreach}	
					{/foreach}	
			</table>
			<br>
			<table border=0 class="lvtColData"  width="100%" cellspacing=0 cellpadding="0px">	
			<tr>
					<td align="center" >
					<input title="{$APP.LBL_MERGE_BUTTON_TITLE}" class="crmbutton small save" type="submit" name="button" value="  {$APP.LBL_MERGE_BUTTON_LABEL}  " >	
					</td>
				</tr>	
			</table>
</form>
</html>			
