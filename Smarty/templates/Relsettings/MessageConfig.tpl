<!--	Setting Contact		-->
<ul class="breadcrumb">
	<li><a href="#">{$RELSETHEAD}</a> <span class="divider">/</span></li>
	<li class="active"><a href="index.php?module=Relsettings&action=index&relset={$RELSET}&parenttab=Settings">{$RELSETARRAY[$RELSET]}</a> <span class="divider">/</span></li>
	<li class="active">{$RELSETTITLE}</li>
	<li class="pull-right">
		<button type="button" class="btn btn-small btn-primary" style="margin-top:-2px;"
			onclick="window.location.reload();">
			<i class="icon-refresh icon-white"></i>刷新
		</button>
	</li>
</ul>
{if $RELSETMODE == 'edit'}
	<table class="table table-condensed table-bordered table-hover">
		<thead>
		  <tr>  
			<th>订单号</th>
			<th>总金额(元)</th>
			<th>有效期至</th>
		  </tr>
		</thead>
		<tbody style="text-align: center;">
		  <tr>  
			<td><font color=red>{$order_no}</font>&nbsp;</td>
			<td><font color=red>{$total_fee}</font></td>
			<td><font color=red>{$endtime}</font></td>
		  </tr>
		</tbody>
	</table>

	<table class="table table-condensed table-bordered table-hover">
		<thead>
		  <tr>  
			<th><input type="image" src="../../../alipay/images/280x50.png"  value="付款" name="pay" /></th>
		  </tr>
		</thead>
		<tbody style="text-align: center;">
		  <tr>  
			<td><font color=red><b>付款已完成？ 付款遇到问题？ <a href="javascript:history.go(-1);">返回</a></b></font></td>
		  </tr>
		</tbody>
	</table>
{else}
	<table class="table table-condensed table-bordered table-hover">
		<tbody style="text-align: center;">
		  <tr>  
			<td>上次充值时间&nbsp;&nbsp;<font color=blue>{$chargetime}</font></td>
			<td>上次充值金额&nbsp;&nbsp;<font color=red>{$chargefee}元</font></td>
			<td>到期时间&nbsp;&nbsp;<font color=red>{$endtime}</font></td>
		  </tr>
		</tbody>
	</table>

	<table class="table table-condensed table-bordered table-hover">
		<thead>
		  <tr>  
			<th>价格</th>
			<th>充值</th>
		  </tr>
		</thead>
		<tbody style="text-align: center;">
		  <tr>  
			<td>6（元/月）&nbsp;</td>
			<td>
				<a href="javascript:;" onclick="confirmPay('onemonth');"><font color=green><b>一个月</b></font></a> &nbsp;|&nbsp;
				<a href="javascript:;" onclick="confirmPay('threemonths');"><font color=orange><b>三个月</b></font></a> &nbsp;|&nbsp;
				<a href="javascript:;" onclick="confirmPay('sixmonths');"><font color=red><b>半年</b></font></a> &nbsp;|&nbsp;
				<a href="javascript:;" onclick="confirmPay('oneyear');"><font color=blue><b>一年</b></font></a>
			</td>
		  </tr>
		</tbody>
	</table>
{/if}
<script>
var endtime = '{$endtime}';
{literal}
function confirmPay(yeartype){
	var str = "确认充值";
	if(yeartype == 'onemonth'){
		str +="<一个月>";
	}else if(yeartype == 'threemonths'){
		str +="<三个月>";
	}else if(yeartype == 'sixmonths'){
		str +="<半年>";
	}else if(yeartype == 'oneyear'){
		str +="<一年>";
	}
	str +="?";
	if(confirm(str)){
		document.location.href="index.php?module=Relsettings&action=index&relset=MessageConfig&relsetmode=edit&newtcdate="+yeartype+"&endtime="+endtime;
	}
}
{/literal}
</script>