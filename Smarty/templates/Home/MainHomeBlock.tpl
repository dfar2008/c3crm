	<div id="stuff_{$tablestuff.Stuffid}" class="portlet" style="overflow-y:auto;overflow-x:hidden;height=280;width:{$tablestuff.Width};float:left;position:relative">
	<table width="100%" cellpadding="0" cellspacing="0" class="small portlet_topper" style="padding-right:0px;padding-left:0px;padding-top:0px;">
		<tr id="headerrow_{$tablestuff.Stuffid}">			
		<td align="left" style="height:20px;" nowrap width=60%><b>&nbsp;{$tablestuff.Stufftitle}</b></td>
		<td align="right" style="height:20px;" width=5%>
		<span id="refresh_{$tablestuff.Stuffid}" style="position:relative;">&nbsp;&nbsp;</span>
		</td>
		<td align="right" style="height:20px;" width=35% nowrap>
			<a style='cursor:pointer;' onclick="loadStuff({$tablestuff.Stuffid},'{$tablestuff.Stufftype}');"><img src="{$IMAGE_PATH}windowRefresh.gif" border="0" alt="{$APP.LBL_REFRESH}" title="{$APP.LBL_REFRESH}" hspace="2" align="absmiddle"/></a>
			
			<a id="deletelink" style='cursor:pointer;' onclick="DelStuff({$tablestuff.Stuffid})"><img src="{$IMAGE_PATH}windowClose.gif" border="0" alt="{$APP.LBL_CLOSE}" title="{$APP.LBL_CLOSE}" hspace="5" align="absmiddle"/></a>			
		</td>
		</tr>
	</table>
		
	<table width="100%" cellpadding="0" cellspacing="0" class="small portlet_content" style="padding-right:0px;padding-left:0px;padding-top:0px;">
		<tr id="maincont_row_{$tablestuff.Stuffid}">	
			<td>
				<div id="stuffcont_{$tablestuff.Stuffid}" style="overflow-y: auto; overflow-x:hidden;width:100%;height:100%;cursor:auto;">
				</div>
			</td>
		</tr>
	</table>
</div>
<script language="javascript">
	window.onresize = function(){ldelim}positionDivInAccord('stuff_{$tablestuff.Stuffid}','{$tablestuff.Width}');{rdelim};
	positionDivInAccord('stuff_{$tablestuff.Stuffid}','{$tablestuff.Width}');
</script>	
