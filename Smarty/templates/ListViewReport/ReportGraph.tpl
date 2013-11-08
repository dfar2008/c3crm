<!--<LINK REL="stylesheet" TYPE="text/css" HREF="include/phpreports/sales.css">-->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery.js"></script>-->
<link href="themes/images/report.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="themes/images/tabpane.js"></script>
<link href="themes/images/tab.css" rel="stylesheet" type="text/css">
<script src="include/js/highcharts.js"></script>
<script src="include/js/exporting.js"></script>
<script>
	{literal}
		function changeTypeOfReport(url){
		
			$.ajax({
				type:"GET",
				url:url,
				success:function(msg){
					$("#showReportInfo").html(msg);
				}
			});
		}
	{/literal}
</script>

<div class="modal-header">
	<button class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h3 id="myModalLabel">{$TITLE}</h3>
</div>
<div class="modal-body" style="max-height:520px;height:520px">
	<div  style="position: relative;height: 20px;margin-bottom: 20px">
		<table border="0" align="left" width="100%">
			<form method="post" action="index.php" >
				{$HIDDENFIELDHTML}
				<tbody>
					<tr>
						<td align="center">
						   显示类型: <select name="graphtype">
								{$GRAPHTYPEOPTS}
							</select>
						   &nbsp; &nbsp;统计项目: <select name="grouptype">
								{$COLLECTCOLUMNOPTS}
							</select>
							<button type="button" class="btn btn-success btn-small" onclick="changeTypeOfReport('index.php?module=ListViewReport&action=Popup_ListView&pickfieldname='+document.getElementsByName('pickfieldname')[0].value+'&pickfieldtable='+document.getElementsByName('pickfieldtable')[0].value+'&pickfieldcolname='+document.getElementsByName('pickfieldcolname')[0].value+'&relatedmodule='+document.getElementsByName('relatedmodule')[0].value+'&PHPSESSID='+document.getElementsByName('PHPSESSID')[0].value+'&graphtype='+document.getElementsByName('graphtype')[0].value+'&grouptype='+document.getElementsByName('grouptype')[0].value)">
							<i class="icon-ok icon-white"></i> 确定 </button>
						</td>
					</tr>
				</tbody>
			</form>
		</table>
	</div>

	<div class="tab-pane" id="tabPane1">
		<div align="left" class="tab-page" id="tabPage1">
		<h2 class="tab">报表图形</h2>
		<br>
		<div id="container"></div>

		<script type="text/javascript">
		var chart;
		$(function () {ldelim}
		
		//$(document).ready(function() {ldelim}
			var colors = Highcharts.getOptions().colors,
				categories = [{$CATEGORIES}],
				name = '{$FIELDNAME}',
				type = '{$TYPE}',
				title = '{$TITLE}',
				data = [{$SERIES}];	
			chart = new Highcharts.Chart({ldelim}
				chart: {ldelim}
					renderTo: 'container',
					inverted: false  //左右显示，默认上下正向。假如设置为true，则横纵坐标调换位置
				{rdelim},
				title: {ldelim}
					text: title
				{rdelim},
				xAxis: {ldelim}
					categories: categories,
					labels: {ldelim}
							rotation: 0      //坐标值显示的倾斜度    
						{rdelim}
				{rdelim},
				yAxis: {ldelim}
					min: 0,
					title: {ldelim}
						text: '数值(个)'
					{rdelim}
				{rdelim},
				plotOptions: {ldelim}
					pie: {ldelim}
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {ldelim}
							enabled: true,
							color: '#000000',
							connectorColor: '#000000',
							formatter: function() {ldelim}
								return '<b>'+ this.point.name +'</b>: '+ this.y ;
							{rdelim}
						{rdelim}
					{rdelim}
				{rdelim},
				tooltip: {ldelim}
					crosshairs: true,
					formatter: function() {ldelim}
						var s;
						if (type == 'pie') {ldelim}// the pie chart
							s = ''+
								this.point.name + ': '+ this.percentage +' %';
						{rdelim} else {ldelim}
							s = ''+
								this.x  +': '+ this.y;
						{rdelim}
						return s;
					{rdelim}
				{rdelim},
			   series: [{ldelim}
					name: name,
					type: type,
					data: data
			   {rdelim}]
			{rdelim});
	  // {rdelim});  
	{rdelim});

	</script>
		</div>
		<div class="tab-page" id="tabPage2">
			<h2 class="tab">报表数据</h2>
				<div id="report">
					<div class="reportTitle" style="margin-top:10px">{$TITLE}</div>
					{$REPORT_DATA}
				</div>
		</div>
	</div>

</div>
<div class="modal-footer">
</div>
