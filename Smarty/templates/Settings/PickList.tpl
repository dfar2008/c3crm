<link rel="stylesheet" type="text/css" href="themes/bootcss/css/Setting.css">
<div class="container-fluid">
	<div class="row-fluid">
		<div class="span2  ">
			<div class="accordion affix span2" id="settingion1" style="overflow:auto;height:580px;">
			{include file='Settings/SettingLeft.tpl'}
			</div>
		</div>

		<div id="editdiv" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"   ></div>

		<div class="span10" style="margin-left:10px">
			<div class="row-fluid box">
				<div class="tab-header">{$MOD.LBL_PICKLIST_EDITOR}
					<!--<div class="page-header" style="margin-top:-10px">
						<h4 style="margin-bottom:-8px">
							<img src="{$IMAGE_PATH}picklist.gif" width="48" height="48" border=0 >{$MOD.LBL_PICKLIST_EDITOR}
							<small>{$MOD.LBL_PICKLIST_DESCRIPTION}</small>
						</h4>
					</div>-->
				</div>
				<div class="padded">
					<!-- choose the module-->
					<div style="margin-top:-10px" >
						<span class="label label-info">1. {$MOD.LBL_SELECT_MODULE}</span>
						<table width="100%">
								<tr class="small">
									<td width="15%"><strong>{$MOD.LBL_SELECT_CRM_MODULE}</strong></td>
									<td width="85%">
										<select name="pickmodule" class="detailedViewTextBox" onChange="changeModule(this);">
										{foreach key=tabid item=module from=$MODULE_LISTS}
												{if $module eq $MODULE}
												<option selected value="{$module}">{$APP.$module}</option>
											{else}
												<option value="{$module}">{$APP.$module}</option>
											{/if}
										{/foreach}
										</select>
									</td>
								</tr>
						</table>
					</div>
					<!-- choose the module end -->

					<div id="picklist_datas">	
								{include file='Settings/PickListContents.tpl'}
					</div>
				</div>
					
			</div>
			<div class="pull-right">
				<a href="#top" title="返回顶部">[<i class="icon-arrow-up"></i>]</a>
			</div>
		</div>
	</div>
</div>


{literal}
<script>
function SavePickList(fieldname,module,uitype)
{
	$("#status").css("display","inline");
	//Effect.Puff($('editdiv'),{duration:2});
	var body = escape($("#picklist_values").val());
	var post_url = 'index.php?action=SettingsAjax&module=Settings&directmode=ajax&file=UpdateComboValues&table_name='+fieldname+'&fld_module='+module+'&listarea='+body+'&uitype='+uitype;
	$.ajax({
		type:"GET",
		url:post_url,
		success: function(msg){
			$("#status").css("display","none");
			$("#picklist_datas").html(msg);
			$("#editdiv").modal("hide");
		}
	});

}

function changeModule(pickmodule)
{
	$("#status").css("display","inline");//进度条
	var module=pickmodule.options[pickmodule.options.selectedIndex].value;
	$.ajax({
		type:"GET",
		url:"index.php?action=SettingsAjax&module=Settings&directmode=ajax&file=PickList&fld_module="+module,
		success:function(msg){
			$("#status").css("display","none");
			$("#picklist_datas").html(msg);
		}
	});
}

function fetchEditPickList(module,fieldname,uitype)
{
	$("#status").css("display","inline");
	$.ajax({
		type:"GET",
		url:'index.php?action=SettingsAjax&module=Settings&mode=edit&file=EditComboField&fld_module='+module+'&fieldname='+fieldname+'&uitype='+uitype,
		success: function(msg){
			$("#status").css("display","none");
			$("#editdiv").html(msg);
		}
	});
	$("#editdiv").modal("show");
//	new Ajax.Request(
//                '',
//                {queue: {position: 'end', scope: 'command'},
//                        method: 'post',
//                        postBody: 'action=SettingsAjax&module=Settings&mode=edit&file=EditComboField&fld_module='+module+'&fieldname='+fieldname+'&uitype='+uitype,
//			onComplete: function(response) {
//                                        $("status").style.display="none";
//                                        $("editdiv").innerHTML=response.responseText;					
//					//Effect.Grow('editdiv');
//					////changed by dingjianting on 2007-1-4 for gloso project and drag layer
					//var theEventHandle_picklist = document.getElementById("orgLay_title");
					//var theEventRoot_picklist   = document.getElementById("orgLay");
					//Drag.init(theEventHandle_picklist, theEventRoot_picklist);
//                	}
//                }
//        );
	
}

function picklist_validate(mode,fieldname,module,uitype)
{
	
	//alert(trim($("picklist_values").value));
	
	var pick_arr=new Array();
	pick_arr=trim($("#picklist_values").val()).split('\n');	
	var len=pick_arr.length;
	for(i=0;i<len;i++)
	{
		var valone;
		curr_iter = i;
		valone=pick_arr[curr_iter];
		for(j=curr_iter+1;j<len;j++)
		{
			var valnext;
			valnext=pick_arr[j];
			if(trim(valone) == trim(valnext))
			{
				alert("下拉框列表值重复");
				return false;
			}
		}
		i = curr_iter		

	}
	if(mode == 'edit')
	{
		if(trim($("#picklist_values").val()) == '')
		{
			alert("下拉框列表值重复");
			$("#picklist_values").focus();	
			return false;
		}
	}
	SavePickList(fieldname,module,uitype)	
}
</script>
{/literal}
