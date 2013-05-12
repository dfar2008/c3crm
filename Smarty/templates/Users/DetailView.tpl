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
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/ColorPicker2.js"></script>
<script language="javascript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/dtlviewajax.js"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript"></script>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<span id="crmspanid" style="display:none;position:absolute;"  onmouseover="show('crmspanid');">
   <a class="link"  align="right" href="javascript:;">{$APP.LBL_EDIT_BUTTON}</a>
</span>

<br>
<!-- Shadow table -->
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tr>
    <td class="showPanelBg" style="padding: 1px;" valign="top" width="100%">
    <div align=center>
		{if $CATEGORY eq 'Settings'}
			{include file='SetMenu.tpl'}
		{/if}
				<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td class="padTab" align="left">
						<form name="DetailView" method="POST" action="index.php" ENCTYPE="multipart/form-data" id="form" style="margin:0px">
							<input type="hidden" name="module" value="Users" style="margin:0px">
							<input type="hidden" name="record" id="userid" value="{$ID}" style="margin:0px">
							<input type="hidden" name="isDuplicate" value=false style="margin:0px">
							<input type="hidden" name="action" style="margin:0px">
							<input type="hidden" name="changepassword" style="margin:0px">
							{if $CATEGORY neq 'Settings'}
								<input type="hidden" name="modechk" value="prefview" style="margin:0px">
							{/if}
							<input type="hidden" name="old_password" style="margin:0px">
							<input type="hidden" name="new_password" style="margin:0px">
							<input type="hidden" name="return_module" value="Users" style="margin:0px">
							<input type="hidden" name="return_action" value="ListView"  style="margin:0px">
							<input type="hidden" name="return_id" style="margin:0px">
							<input type="hidden" name="forumDisplay" style="margin:0px">
							{if $CATEGORY eq 'Settings'}
							<input type="hidden" name="parenttab" value="{$PARENTTAB}" style="margin:0px">
							{/if}	
							<table width="100%" border="0" cellpadding="0" cellspacing="0" >
							<tr>
								<td colspan=2>
									<!-- Heading and Icons -->
									<table width="100%" cellpadding="5" cellspacing="0" border="0" >
									<tr style="background:#DFEBEF;height:27px;">
										
										<td>
											{if $CATEGORY eq 'Settings'}
											<span class="heading2">
											<b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS} </a> &gt; <a href="index.php?module=Users&action=index&parenttab=Settings"> {$MOD.LBL_USERS} </a>&gt;"{$USERNAME}" </b></span>
											{else}
											<span class="heading2">	
											<b>{$APP.LBL_MY_PREFERENCES}</b>
											</span>
											{/if}
											<span id="vtbusy_info" style="display:none;" valign="bottom"><img src="{$IMAGE_PATH}vtbusy.gif" border="0"></span>					
										</td>
										
									</tr>
									
									</table>
								</td>
							</tr>
							<tr><td colspan="2">&nbsp;</td></tr>
							
							<tr>
								<td colspan="2" align=left>
								<!-- User detail blocks -->
								<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
								<tr>
								<td align="left" valign="top">
								        <table class="tableHeading" border="0" cellpadding="5" cellspacing="0" width="100%">
									<tr>
										<td class="big">	
										<strong>{$UMOD.LBL_USER_INFORMATION}</strong>
										 </td>
										 <td colspan="2" nowrap align="right">					
									
									{$EDIT_BUTTON}
									{if $CATEGORY eq 'Settings' && $ID neq 1 && $ID neq $CURRENT_USERID}
									<input type="button" onclick="deleteUser({$ID});" class="crmButton small cancel" value="{$UMOD.LBL_DELETE}"></input>
									{/if}
								</td>
									</tr>
									</table>
									<table border="0" cellpadding="5" cellspacing="0" width="100%">
									<tbody>
									<tr style="height: 25px;">
									<td class="dvtCellLabel" align="right" width="20%"> 用户名</td>
									<td class="dvtCellInfo" align="left" width="30%">{$COLUMNS.user_name}</td>
									<td class="dvtCellLabel" width="25%" align="right">密码 </td>
                                    <td class="dvtCellInfo" width="25%" align="left">
                                    {$CHANGE_PW_BUTTON}
                                    </td>
									</tr>
									<tr style="height: 25px;">
                                    <td class="dvtCellLabel" align="right" width="20%">管理员</td>
									<td class="dvtCellInfo" align="left" width="30%">
									{if $COLUMNS.is_admin eq 'on'}
									Yes</td>
									{else}
									No</td>
									{/if}
									

									<td class="dvtCellLabel" align="right" width="20%">状态</td>
									<td class="dvtCellInfo" align="left" width="30%">									
									{if $COLUMNS.status eq 'Active'}
									{$MOD.LBL_ACTIVE}
									{else}
									{$MOD.LBL_INACTIVE}
									{/if}									
									</select>
									</td>
									</tr>
									<tr style="height: 25px;">
									<td class="dvtCellLabel" align="right" width="20%"> 姓名</td>
									<td class="dvtCellInfo" align="left" width="30%">
									{$COLUMNS.last_name}
									</td>		
									<td class="dvtCellLabel" align="right" width="20%">
									 角色</td>
									<td class="dvtCellInfo" align="left" width="30%">
									{$COLUMNS.rolename}
									
									</td>
									</tr>
									<tr style="height: 25px;">
									<td class="dvtCellLabel" align="right" width="20%"> 电话</td>
									<td class="dvtCellInfo" align="left" width="30%">
									{$COLUMNS.phone_work}
									</td>
									<td class="dvtCellLabel" align="right" width="20%">
									 Email</td>
									<td class="dvtCellInfo" align="left" width="30%">{$COLUMNS.email1}</td>
									</tr>
									<tr style="height: 25px;">
									<td class="dvtCellLabel" align="right" width="20%"> 部门</td>
									<td class="dvtCellInfo" align="left" width="30%">
									{$GROUP_NAME}
									</td>
									<td colspan=2 class="dvtCellLabel" align="right" width="20%">
									 </td>
									</tr>
									</tbody>
							
						</table>									
								</td>
								</tr>
								</table>
								<!-- User detail blocks ends -->
								
								</td>
							</tr>
							
							</table>
							
						</form>
			
					</td>
				</tr>
				</table>

		
	</div>
	</td>
	
</tr>
</table>
			
			</td>
			</tr>
			</table>
			
			</td>
			<td valign="top"></td>			
			</tr>
			</table>
			



<br>
{$JAVASCRIPT}
<div id="tempdiv" style="display:block;position:absolute;left:350px;top:200px;"></div>
<!-- added for validation -->
<script language="javascript">
function ShowHidefn(divid)
{ldelim}
	if($(divid).style.display != 'none')
		Effect.Fade(divid);
	else
		Effect.Appear(divid);
{rdelim}
{literal}
function fetchGroups_js(id)
{
	if($('user_group_cont').style.display != 'none')
		Effect.Fade('user_group_cont');
	else
		fetchUserGroups(id);
}
function fetchUserGroups(id)
{
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Users&action=UsersAjax&file=UserGroups&ajax=true&record='+id,
                        onComplete: function(response) {
                                $("status").style.display="none";
                                $("user_group_cont").innerHTML= response.responseText;
				Effect.Appear('user_group_cont');
                        }
                }
        );

}

function showAuditTrail()
{
	var userid =  document.getElementById('userid').value;
	window.open("index.php?module=Users&action=UsersAjax&file=ShowAuditTrail&userid="+userid,"","width=650,height=800,resizable=0,scrollbars=1,left=100");
}

function deleteUser(userid)
{
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'action=UsersAjax&file=UserDeleteStep1&return_action=ListView&return_module=Users&module=Users&parenttab=Settings&record='+userid,
                        onComplete: function(response) {
                                $("status").style.display="none";
                                $("tempdiv").innerHTML= response.responseText;
                        }
                }
        );
}
function transferUser(del_userid)
{
        $("status").style.display="inline";
        $("DeleteLay").style.display="none";
        var trans_userid=$('transfer_user_id').options[$('transfer_user_id').options.selectedIndex].value;
	window.document.location.href = 'index.php?module=Users&action=DeleteUser&ajax_delete=false&delete_user_id='+del_userid+'&transfer_user_id='+trans_userid;
}
{/literal}
</script>
<script>
function getListViewEntries_js(module,url)
{ldelim}
	$("status").style.display="inline";
        new Ajax.Request(
        	'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                	method: 'post',
                        postBody:"module="+module+"&action="+module+"Ajax&file=ShowHistory&record={$ID}&ajax=true&"+url,
			onComplete: function(response) {ldelim}
                        	$("status").style.display="none";
                                $("login_history_cont").innerHTML= response.responseText;
                  	{rdelim}
                {rdelim}
        );
{rdelim}

function getListViewWithPageNo(module,pageElement)
{ldelim}
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
{rdelim}

</script>

