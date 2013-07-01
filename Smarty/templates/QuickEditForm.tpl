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
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>批量修改</h3>
</div>
<div class="modal-body">
<input type="hidden" name="quickedit_recordids">
<input type="hidden" name="quickedit_module">
<table border=0 cellspacing=0 cellpadding=5 width=95% align=center> 
	<tr>
		<td class=small >		
			<!-- popup specific content fill in starts -->
	     
				<table border=0 celspacing=0 cellpadding=5 width=100% align=center bgcolor=white>
				<tr>
					<td width="40%" valign="top">		

						<select name="quickedit_field" class=small onchange="quick_edit_fieldchange(this)">
						<option>{$SELECT}</option>

						{foreach key=header item=data from=$BLOCKS}
							
							{foreach key=label item=subdata from=$data}

								{foreach key=mainlabel item=maindata from=$subdata}						
									{assign var="uitype" value="$maindata[0][0]"}
									{assign var="fldlabel" value="$maindata[1][0]"}
									{assign var="fldlabel_sel" value="$maindata[1][1]"}
									{assign var="fldlabel_combo" value="$maindata[1][2]"}
									{assign var="fldname" value="$maindata[2][0]"}
									{assign var="fldvalue" value="$maindata[3][0]"}
									{assign var="secondvalue" value="$maindata[3][1]"}
									{assign var="thirdvalue" value="$maindata[3][2]"}
									{assign var="vt_tab" value="$maindata[4][0]"}
									{if $fldlabel neq '' && $uitype neq ''}
									<option value="{$fldname}">{$fldlabel}</option>
									{/if}

								{/foreach}
							{/foreach}
						{/foreach}
					</select>
					</td>

					<td valign="top">
						
						{include file='QuickEditDisplayFields.tpl'}			
					<td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</div>
<div class="modal-footer">
	<button class="btn" data-dismiss="modal" aria-hidden="true">关闭</button>
    <button class="btn btn-primary" onClick="ajax_quick_edit()">保存</button>
</div>

<script type="text/javascript" id="quickedit_javascript">
        var quick_fieldname = new Array({$VALIDATION_DATA_FIELDNAME});
        var quick_fieldlabel = new Array({$VALIDATION_DATA_FIELDLABEL});
        var quick_fielddatatype = new Array({$VALIDATION_DATA_FIELDDATATYPE});
</script>

