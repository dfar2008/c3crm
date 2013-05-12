<?php /* Smarty version 2.6.18, created on 2013-05-10 11:54:15
         compiled from ListViewReport/ReportGraph.tpl */ ?>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<TITLE><?php echo $this->_tpl_vars['TITLE']; ?>
</TITLE>
<!-- <LINK REL="stylesheet" TYPE="text/css" HREF="include/phpreports/sales.css"> -->
<link href="themes/images/style_cn.css" rel="stylesheet" type="text/css">
<link href="themes/images/report.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="themes/images/tabpane.js"></script>
<script type="text/javascript" src="include/js/jquery.min.js"></script>
<script src="include/js/highcharts.js"></script>
<script src="include/js/exporting.js"></script>
<link href="themes/images/tab.css" rel="stylesheet" type="text/css">
</HEAD>
<body BGCOLOR="#FFFFFF" marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" align="center">
<div class="mtitle">
<div class="mtitle-row">&nbsp;</div>
<?php echo $this->_tpl_vars['TITLE']; ?>

</div>

<div  style="position: relative;height: 20px;margin-bottom: 20px">
    <table border="0" align="left" width="100%">
        <form method="post" action="index.php">
            <?php echo $this->_tpl_vars['HIDDENFIELDHTML']; ?>

            <tbody>
                <tr>
                    <td align="center">
                       显示类型: <select name="graphtype">
                            <?php echo $this->_tpl_vars['GRAPHTYPEOPTS']; ?>

                        </select>
                       &nbsp; &nbsp;统计项目: <select name="grouptype">
                            <?php echo $this->_tpl_vars['COLLECTCOLUMNOPTS']; ?>

                        </select>
                       <input type="submit" value="确定" name="submit" class="small button save">
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
	<!-- changed by xiaoyang on 2012-9-24 -->
	<div id="container"></div>
	<script type="text/javascript">

   $(function () {
    var chart;
    $(document).ready(function() {
		var colors = Highcharts.getOptions().colors,
            categories = [<?php echo $this->_tpl_vars['CATEGORIES']; ?>
],
            name = '<?php echo $this->_tpl_vars['FIELDNAME']; ?>
',
			type = '<?php echo $this->_tpl_vars['TYPE']; ?>
',
			title = '<?php echo $this->_tpl_vars['TITLE']; ?>
',
            data = [<?php echo $this->_tpl_vars['SERIES']; ?>
];	
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
				inverted: false  //左右显示，默认上下正向。假如设置为true，则横纵坐标调换位置
            },
            title: {
                text: title
            },
            xAxis: {
                categories: categories,
				labels: {
                        rotation: 0      //坐标值显示的倾斜度    
                    }
            },
            yAxis: {
                min: 0,
                title: {
                    text: '数值(个)'
                }
            },
			plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.y ;
                        }
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    var s;
                    if (type == 'pie') {// the pie chart
                        s = ''+
                            this.point.name + ': '+ this.percentage +' %';
                    } else {
                        s = ''+
                            this.x  +': '+ this.y;
                    }
                    return s;
                }
            },
           series: [{
				name: name,
				type: type,
                data: data
           }]
        });
   });  
});
    </script>
	</div>
	<div class="tab-page" id="tabPage2">
		<h2 class="tab">报表数据</h2>
			<div id="report">
				<div class="reportTitle"><?php echo $this->_tpl_vars['TITLE']; ?>
</div>
				<?php echo $this->_tpl_vars['REPORT_DATA']; ?>

			</div>
	</div>
</div>
</body>
</html>