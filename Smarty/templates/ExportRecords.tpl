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
<style>
 label{
	font-size:12px;
 }
 {/literal}
</style>
<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid" style="height:580px;margin-right:10px">
	<div class="row-fluid box" style="height:400px">
		<div class="tab-header">导出{$APP.$MODULE}</div>
		<div class="padded">
			<form  name="Export_Records"  method="POST">
				<input type="hidden" name="module" value="{$MODULE}">
				<input type="hidden" name="action" value="Export">
				<input type="hidden" name="idstring" value="{$IDSTRING}">
				<input type="hidden" name="id_cur_str" value="{$IDCURSTR}">
				<input type="hidden" name="viewname" value="{$VIEWNAME}">
				<div>
					<span class="label label-info">{$APP.LBL_SEARCH_CRITERIA_RECORDS}:</span>
					<p style="margin-left:10px;">
						{ if $SESSION_WHERE neq ''}
						<label class="radio">
							<input  type="radio" name="search_type" checked value="includesearch">{$APP.LBL_WITH_SEARCH}
						</label>
						{else}
						<label class="radio">
							<input type="radio"  name="search_type"  disabled="true" value="includesearch">{$APP.LBL_WITH_SEARCH}
						</label>
						{/if}
						{if $SESSION_WHERE eq ''}
						<label class="radio">
							<input type="radio" name="search_type" checked value="withoutsearch">{$APP.LBL_WITHOUT_SEARCH}
						</label>
						{else}
						<label>
							<input type="radio" name="search_type" value="withoutsearch">{$APP.LBL_WITHOUT_SEARCH}
						</label>
						{/if}
					</p>
					<span class="label label-info">{$APP.LBL_EXPORT_RECORDS}:</span>
					<p style="margin-left:10px"><small>
						{if   $IDSTRING eq ''}
						<label class="radio">
							<input type="radio" name="export_data" checked value="all">{$APP.LBL_ALL_DATA}
						</label>
						{else}
						<label class="radio">
							<input type="radio" name="export_data" value="all">{$APP.LBL_ALL_DATA}
						</label>
						{/if}
						{if  $IDSTRING neq ''}
						<label class="radio">
							<input type="radio" name="export_data" checked value="selecteddata">{$APP.LBL_ONLY_SELECTED_RECORDS}
						</label>
						{else}
						<label class="radio">
							<input type="radio" name="export_data" disabled="true" value="selecteddata">{$APP.LBL_ONLY_SELECTED_RECORDS}
						</label>
						{/if}
						{if  $VIEWNAME neq ''}
						<label class="radio" >
							<input type="radio" name="export_data" value="vieweddata">{$APP.LBL_ONLY_VIEWED_RECORDS}
						</label>
						{else}
						<label class="radio">
							<input type="radio" name="export_data" disabled="true" value="vieweddata">{$APP.LBL_ONLY_VIEWED_RECORDS}
						</label>
						{/if}
						</small>
					</p>
				</div>

				<div class="breadcrumb text-center" style="width:97%;margin-top:100px">
					<button type="button" name="{$APP.LBL_CANCEL_BUTTON_LABEL}" class="btn btn-small btn-primary" onclick="goback()" >
						<i class="icon-arrow-left icon-white"></i> {$APP.LBL_CANCEL_BUTTON_LABEL}
					</button>&nbsp;&nbsp;&nbsp;

					<button type="button" name="{$APP.LBL_EXPORT}" class="btn btn-small btn-primary" onclick="record_export('{$APP.$MODULE}','{$CATEGORY}',this.form,'{$smarty.request.idstring}')">
						<i class="icon-circle-arrow-down icon-white"></i> 导出{$APP.$MODULE}
					</button>
				</div>

			</form>
		</div>
	</div>
</div>
