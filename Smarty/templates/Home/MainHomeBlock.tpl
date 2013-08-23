	<!--<div id="stuff_{$tablestuff.Stuffid}" class="portlet" style="overflow-y:auto;overflow-x:hidden;height=280;width:{$tablestuff.Width};float:left;position:relative">
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
</div>-->
<script language="javascript">
	//window.onresize = function(){ldelim}positionDivInAccord('stuff_{$tablestuff.Stuffid}','{$tablestuff.Width}');{rdelim};
	//positionDivInAccord('stuff_{$tablestuff.Stuffid}','{$tablestuff.Width}');
	function hiddenwin(divid){ldelim}
		$("#"+divid).css("display","none");
	{rdelim}
</script>	

<style>
{literal}
.mydash{
	background:none repeat scroll 0 0 #fff;
	cursor:pointer;
	float:left;
	height:280px;
	margin:10px 0 0 10px;
	margin-top:10px;
	-webkit-box-shadow:0 1px 3px rgba(0,0,0,0.2);
	-moz-box-shadow:0 1px 3px rgba(0,0,0,0.2);
	box-shadow:0 1px 3px rgba(0,0,0,0.2);
}
.mydash h4{
	background: -moz-linear-gradient(center top , #FEFEFE, #F5F5F5) repeat-x scroll 0 0 #FAFAFA;
	border-bottom:1px solid #d4d4d4;
	color:#666;
	cursor:pointer;
	font-size:14px;
	font-weight:400;
	padding:0px 0 6px 10px;
	position:relative;
	background:#fafafa repeat-x;
	background-image:-webkit-gradient(linear,0,0,0 100%,from(#fefefe),to(whiteSmoke));
}
.mydash h4 span{
		display:none;
}
.mydash h4 span{
	position:absolute;
	right:10px;
	top:2px;
}

.mydash h4:hover span{
	display:inline;
}
{/literal}
</style>
<div style="width:33.3%;float:left;">
	<div style="width:97%;float:left;position:relative;display:block;overflow-y:auto;overflow-x:hidden;" class="mydash" id="{$val.divid}_win">
		<div style="background-color:#fafafa;padding-top:1px">
			<h4>
				{$val.title}
				<span>
					<a href="#" hidefocus="true" onclick=""><i class="icon-repeat"></i></a>
					<a href="#" hidefocus="true" onclick="hiddenwin('{$val.divid}_win')"><i class="icon-remove"></i></a>
				</span>
			</h4>
		</div>
		<div style="margin-left:5px;margin-right:5px" >
			{if $val.type=="text"}
				{foreach from=$val.content item=cont}
					<p>{$cont}</p>
				{/foreach}
			{elseif $val.type=="table"}
				<table class="table table-bordered table-condensed table-striped table-hover">
					<thead>
						{foreach from=$val.thead item=heads}
						<td>{$heads}</td>
						{/foreach}
					</thead>
					<tbody>
						{$val.tbody}
					</tbody>
				</table>
			{else}
				<div id="{$val.divid}">
				<script>highchartss("{$val.categorys}",'{$val.divid}',"{$val.series}","{$val.title}","{$val.type}","{$val.name}");</script>
				</div>
			{/if}
		</div>
	</div>
</div>