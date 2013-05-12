<script language="javascript" type="text/javascript" src="modules/Home/Homestuff.js"></script>
{*<!--Home Page Entries  -->*}
	<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
	<tr>
		<td style="padding-left:10px;padding-right:50px" width=10% class="moduleName" nowrap>{$APP.$CATEGORY}&gt; 
			<a class="hdrLink" href="index.php?action=index&module={$MODULE}">{$APP.$MODULE}</a>
		</td>
		<td width=40% nowrap>
			<table border="0" cellspacing="0" cellpadding="0" >
			<tr>
				<td class="sep1" style="width:1px;"></td>
				<td class=small >
				<table border=0 cellspacing=0 cellpadding=0>
				<tr>
					<td>
					<table border=0 cellspacing=0 cellpadding=5>
					<tr>
						<td style="padding-right:5px;padding-left:5px;"><img src="{$IMAGE_PATH}btnL3Add-Faded.gif" border=0></td>	
						<td style="padding-right:5px"><img src="{$IMAGE_PATH}btnL3Search-Faded.gif" border=0></td>
					</tr>
					</table>
					</td>
				</tr>
				</table>
				</td>
				<td style="width:20px;">&nbsp;</td>
				<td class="small">
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td style="padding-right:5px"><a href="javascript:;" onClick='return window.open("index.php?module=Home&action=PopupPM","Chat","width=600,height=450,resizable=1,scrollbars=1");'><img src="{$IMAGE_PATH}tbarChat.gif" alt="{$APP.LBL_CHAT_ALT}" title="{$APP.LBL_CHAT_TITLE}" border=0></a></td>	
					
				</tr>
				</table>
				</td>
				<td style="width:20px;">&nbsp;</td>
				<td class="small">
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td style="padding-right:5px;padding-left:10px;"><img src="{$IMAGE_PATH}tbarImport-Faded.gif" border="0"></td>	
					<td style="padding-right:5px"><img src="{$IMAGE_PATH}tbarExport-Faded.gif" border="0"></td>
				</tr>
				</table>	
				</td>
				<td style="width:20px;">&nbsp;</td>
				<td class="small">
				<table border=0 cellspacing=0 cellpadding=5>
				<tr>
					<td style="padding-right:5px;padding-left:10px;"><img onClick='fnAddWindow();' src="{$IMAGE_PATH}btnL3CreateWindow.gif" border="0" title="{$MOD.LBL_CONFIG_PORTLETS}" alt="{$MOD.LBL_CONFIG_PORTLETS}" style="cursor:pointer;"></td>	
					<td style="padding-right:5px"><div id="vtbusy_info" style="display:none;"><img src="{$IMAGE_PATH}status.gif" border="0"></div></td>
				</tr>
				</table>	
				</td>
							
			</tr>
			</table>
		</td>
		</tr>
		<tr><td colspan="2" align="center">
		<div id='createConfigBlockDiv' style='display:none;width:80%'></div>
		</td></tr>
	</TABLE>
<div id="vtbusy_homeinfo" style="display:none;"><img src="{$IMAGE_PATH}vtbusy.gif" border="0"></div>
<div id="seqSettings" style="position:absolute;width:250px;height:20px;top:2px;left:360px;z-index:6000000;display:none;"></div>
{* Main Contents Start Here *}
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="small showPanelBg" align="center" valign="top">
	<tr>
		<td width="100%" align="center" valign="top" height=300>
			<div id="MainMatrix" style="padding:5px;width:100%">
				{foreach item=tablestuff from=$HOMEFRAME name="homeframe"}
					{include file="Home/MainHomeBlock.tpl"}
					<script>
					{if $tablestuff.Stufftype neq ''}
						loadStuff({$tablestuff.Stuffid},'{$tablestuff.Stufftype}');
					{/if}
					</script>
				{/foreach}
			</div>
		</td>	
		
	</tr>
</table>
{* Main Contents Ends Here *}
<script>
{literal}

initHomePage = function(){
Sortable.create
(
	"MainMatrix",
	{
		constraint:false,tag:'div',overlap:'Horizontal',handle:'portlet_topper',
		onUpdate:function()
		{
			matrixarr = Sortable.serialize('MainMatrix').split("&");
			matrixseqarr=new Array();
			seqarr=new Array();
			for(x=0;x<matrixarr.length;x++)
			{
				matrixseqarr[x]=matrixarr[x].split("=")[1];
			}
			BlockSorting(matrixseqarr);	
			
		}
	}
);
}

initHomePage();

function BlockSorting(matrixseqarr)
{
var sequence = matrixseqarr.join("_");

new Ajax.Request('index.php',
					{queue: {position: 'end', scope: 'command'},
						method: 'post',
						postBody:'module=Home&action=HomeAjax&file=HomestuffAjax&matrixsequence='+sequence,
						onComplete: function(response) 
						{
							$('seqSettings').innerHTML=response.responseText;
							LocateObj($('seqSettings'))
							Effect.Appear('seqSettings');
							setTimeout(hideSeqSettings,3000);
						}
					}
				);
}
function fnAddWindow(obj,CurrObj)
{
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Home&action=HomeAjax&file=ConfigBlock',
				onComplete: function(response) {
					$("createConfigBlockDiv").innerHTML=response.responseText;
					//eval($("addDefaultPlan").innerHTML);
					document.getElementById("createConfigBlockDiv").style.display = "block";
					//Drag.init(document.getElementById("block_div_title"), document.getElementById("blockLay"));
				}
			}
	);	
}
{/literal}	
</script>


