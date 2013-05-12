<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/dom-drag.js"></script>
<script type="text/javascript" language="JavaScript" src="include/js/general.js"></script>
<script language="javascript">
function getHomeActivities(mode,view)

{ldelim}
        $("status").style.display="inline";
        new Ajax.Request(
                'index.php',
                {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                        method: 'post',
                        postBody: 'module=Calendar&action=ActivityAjax&file=OpenListView&activity_view='+view+'&mode='+mode+'&parenttab=My Home Page&ajax=true',
                        onComplete: function(response) {ldelim}
			        $("status").style.display="none";
                                if(mode == 0)
                                        $("upcomingActivities").innerHTML=response.responseText;
                                else
                                        $("pendingActivities").innerHTML=response.responseText;
                        {rdelim}
                {rdelim}
        );
{rdelim}

</script>

{*<!--Home Page Entries  -->*}

	<TABLE border=0 cellspacing=0 cellpadding=0 width=100% class=small>
	<tr>
		<td style="height:2px" colspan="2"></td>
	</tr>
	<tr>
		<td style="padding-left:10px;padding-right:50px" class="moduleName" nowrap>{$APP.$CATEGORY} >
			<a class="hdrLink" href="index.php?action=index&module={$MODULE}">{$APP.$MODULE}</a>
		</td>
		<td width=100% nowrap>
					<table border="0" cellspacing="0" cellpadding="0" >
					<tr>
					<td class="sep1" style="width:1px;"></td>
					<td class=small >
					<table border=0 cellspacing=0 cellpadding=5>
						<tr>
						<td style="padding-right:5px;padding-left:5px;"><img src="{$IMAGE_PATH}btnL3Add-Faded.gif" border=0></td>	
						<td style="padding-right:5px"><img src="{$IMAGE_PATH}btnL3Search-Faded.gif" border=0></td>
						<td style="padding-right:5px"><a href="javascript:;" onClick='return window.open("index.php?module=Home&action=PopupPM","PM","width=650,height=450,resizable=1,scrollbars=1");'><img src="{$IMAGE_PATH}tbarChat.gif" alt="{$APP.LBL_CHAT_ALT}" title="{$APP.LBL_CHAT_TITLE}" border=0></a></td>
						<td style="padding-right:5px;padding-left:10px;"><img src="{$IMAGE_PATH}tbarImport-Faded.gif" border="0"></td>	
						<td style="padding-right:5px"><img src="{$IMAGE_PATH}tbarExport-Faded.gif" border="0"></td>
						</tr>
					</table>
					</td>
					
								
				</tr>
			</table>
		</td>
	</tr>
	<tr><td style="height:2px"></td></tr>
</TABLE>



{* Main Contents Start Here *}
<table width="98%" cellpadding="0" cellspacing="0" border="0" class="small showPanelBg" align="center" valign="top">
	<tr>
		<td width="75%" align="center" class="homePageSeperator" valign="top">
				<div id="MainMatrix">
					{foreach key=modulename item=tabledetail from=$HOMEDETAILS}
						{if $modulename neq 'Dashboard'}
							{if $tabledetail neq ''}
								<div class="MatrixLayer" style="float:left;" id="{$tabledetail.Title.2}">
										<table width="100%" border="0" cellpadding="5" cellspacing="0" class="small">
								<tr style="cursor:move;height:20px;">
									<td align="left" class="homePageMatrixHdr" ><b>{$tabledetail.Title.1}</b></td>
									<td align="right" class="homePageMatrixHdr" ><img src="{$IMAGE_PATH}uparrow.gif" align="absmiddle" /></td>
								</tr>
								<tr align="left">
									<td valign=top  colspan=2>
											<div style="overflow-y:auto;overflow-x:hidden;height:250px;width:99%"> 
											<table border=0 cellspacing=0 cellpadding=5 width=100%>
												{foreach item=elements from=$tabledetail.Entries}
													<tr>
														{if $tabledetail.Title.2 neq 'home_mytopinv' && $tabledetail.Title.2 neq 'home_mytopso' && $tabledetail.Title.2 neq 'home_mytopquote' && $tabledetail.Title.2 neq 'home_metrics' &&  $tabledetail.Title.2 neq 'home_mytoppo' &&  $tabledetail.Title.2 neq 'home_myfaq'  }
															<td colspan="2"><img src="{$IMAGE_PATH}bookMark.gif" align="absmiddle" /> {$elements.0}</td>
														{elseif $tabledetail.Title.2 eq 'home_metrics'}
															<td><img src="{$IMAGE_PATH}bookMark.gif" align="absmiddle" /> {$elements.0}</td>
															<td align="absmiddle" /> {$elements.1}</td>
														{else}	
															<td colspan="2"><img src="{$IMAGE_PATH}bookMark.gif" align="absmiddle" /> {$elements.0}</td>
														{/if}
													</tr>
												{/foreach}
											</table>	
											</div>
											<table border=0 cellspacing=0 cellpadding=5 width=100%>
													<tr>
														<td colspan="2" align="right" valign="bottom">
															{if $modulename neq 'CustomView' && $modulename neq 'GroupAllocation'}
																<a href="index.php?module={$modulename}&action=index">{$APP.LBL_MORE}..</a>
															{else}
																&nbsp;	
															{/if}
														</td>
													</tr>
											</table>										
									</td>
								</tr>
							</table>
								</div>
							{/if}	
							{else}
								
								
						{/if}
				{/foreach}
			</div>
		</td>
		<td width="25%" valign="top" style="padding:5px;">
			<div id="upcomingActivities">
                                {include file="upcomingActivities.tpl"}
                        </div><br>
                        <div id="pendingActivities">
                                {include file="pendingActivities.tpl"}
                        </div><br>
			<table border=0 cellspacing=0 cellpadding=0 width=100% class="tagCloud">
			<tr>
			<td class="tagCloudTopBg"><img src="{$IMAGE_PATH}tagCloudName.gif" border=0></td>
			</tr>
			<tr>
			<td class="tagCloudDisplay" valign=top> <span id="tagfields">{$ALL_TAG}</span></td>
			</tr>
			</table>

		</td>
		</table>

{literal}
<script  language="javascript">
Sortable.create("MainMatrix",
{constraint:false,tag:'div',overlap:'horizontal',
onUpdate:function(){
//	alert(Sortable.serialize('MainMatrix')); 
}
});

//new Sortable.create('MainMatrix','div');

function fetch_homeDB()
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
		method: 'post',
		postBody: 'module=Dashboard&action=DashboardAjax&file=HomepageDB',
			onComplete: function(response)
			{
				$("dashborad_cont").style.display = 'none';
				//alert(response.responseText);
				$("dashborad_cont").innerHTML=response.responseText;
				Effect.Appear("dashborad_cont");
			}
		}
	);
}
</script>
{/literal}
<script>
function showhide(tab)
{ldelim}
var divid = document.getElementById(tab);
if(divid.style.display!='none')
hide(tab)
else
show(tab)
{rdelim}

{if $IS_HOMEDASH eq 'true'}
//fetch_homeDB();
{/if}
</script>

	
			
