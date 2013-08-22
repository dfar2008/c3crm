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

<link href="themes/bootcss/css/Setting.css" rel="stylesheet" type="text/css"/>

<!-- header - level 2 tabs -->
{*include file='Buttons_List.tpl'*}	
<div class="container-fluid" style="margin-right:10px">
	<form enctype="multipart/form-data" name="Import" method="POST" action="index.php">
		<input type="hidden" name="module" value="{$MODULE}">
		<input type="hidden" name="step" value="1">
		<input type="hidden" name="action" value="Import">
		<div class="row-fluid box" style="height:502px">
			<div class="tab-header">导入结果</div>
			<div class="padded text-center" style="margin-top:100px">
				<div align='center' width='100%'><font color='green'><b>导入完毕</b></font></div>
				<div>
					<font color='green'><b>成功插入记录：<font color="red">{$success_account_insert}</font>；失败:<font color=red>{$failed_account_insert}</font></b></font><br>
					<font color='green'><b>其中重复跳过的记录:<font color="red">{$tiaoguo_account}</font></b></font>
				</div>
			</div>
			<div class="breadcrumb text-center" style="margin-top:200px">
				<button type="button" name="button"  accessyKey="F"  class="btn btn-small btn-primary"
				onclick="javascript:location.href='index.php?module={$MODULE}&action=ListView'" />
					<i class="icon-arrow-left icon-white"></i> 返回{$APP.$MODULE}
				</button>

				<button title="{$MOD.LBL_IMPORT_MORE}"  class="btn btn-small btn-primary" type="submit" name="button" onclick="this.form.action.value='Import';this.form.step.value='1' ">
					<i class="icon-circle-arrow-right icon-white"></i> {$MOD.LBL_IMPORT_MORE}
				</button>
			</div>
		</div>
	</form>
</div>
