<div class="container-fluid" style="height:602px">
	<div class="row-fluid">
		<!-- left nav-->
		<div class="span2" style="">
			<div class="accordion" id="settingion1" style="overflow:auto;height:580px;">
				{include file='Settings/SettingLeft.tpl'}
			</div>
		</div>
		<!-- end nav-->

		<!--content-->
		<div class="span10" style="margin-left:10px;">
			 <div class="accordion"  style="margin-top:0px;margin-bottom:0px;">
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle"  href="#">登录日志 </a> 
					</div><br>
					<div class="accordion-body">
						<div class="accordion-inline">
							<table class="table table-hover table-condensed table-bordered">
								<tr>
									{foreach name="listviewforeach" item=header from=$LISTHEADER}
										<td class="lvtCol">{$header}</td>
									{/foreach}
								</tr>
								<!-- Table Contents -->
								{foreach item=entity key=entity_id from=$LISTENTITY}
								   <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
									{foreach item=data from=$entity}	
									<td>{$data}</td>
									{/foreach}
								  </tr>
								 {foreachelse}
								  <tr bgcolor=white onMouseOver="this.className='lvtColDataHover'" onMouseOut="this.className='lvtColData'" id="row_{$entity_id}">
									<td colspan="{$countheader}" align="center">---&nbsp;无&nbsp;---</td>
								  </tr>
								{/foreach}
							</table>
							<div class="pagination pagination-mini pagination-right" style="margin-bottom:5px">
								{$RECORD_COUNTS}&nbsp;&nbsp;&nbsp;&nbsp;{$NAVIGATION}
							</div>
						</div><br><br>
						<div class="pull-left" style="margin-top:5px">
							<button title="{$APP.LBL_CANCEL_BUTTON_LABEL}" accessKey="{$APP.LBL_CANCEL_BUTTON_KEY}" class="btn btn-small btn-primary" onclick="location.href='index.php?module=Settings&action=SmsUser'" type="button" name="button"><i class="icon-arrow-left icon-white"></i> 返回</button>
						</div>
						<div class="pull-right" style="margin-top:5px">
							<button type="button"  name="button" class="btn btn-small btn-inverse" onclick="window.location.reload();"/><i class="icon-refresh icon-white"></i> 刷新</button>
						</div>
					</div>
				</div>
			</div>

		</div>
		<!-- end of content-->
	</div>
</div>

<input type="hidden" value="{$search_url}" id="search_url"  name="search_url"/>
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>
{literal}
<script>
function getListViewEntries_js(module,url)
{	
	$("#status").css("display","inline");

	if($('#search_url').val()!='')
		urlstring = $('#search_url').val();
	else
		urlstring = '';
	location.href="index.php?module=Settings&action=SmsUserLogs&"+url+urlstring;
}
function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
}
function getListViewWithPageSize(module,pageElement)
{
	var pagesize = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'pagesize='+pagesize);
} 

</script>
{/literal}