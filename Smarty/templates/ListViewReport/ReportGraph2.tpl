<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<TITLE>{$TITLE}</TITLE>
<LINK REL="stylesheet" TYPE="text/css" HREF="include/phpreports/sales.css">
<link href="themes/images/style_cn.css" rel="stylesheet" type="text/css">
<link href="themes/images/report.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="themes/images/tabpane.js"></script>
<link href="themes/images/tab.css" rel="stylesheet" type="text/css">

</HEAD>
<body BGCOLOR="#FFFFFF" marginheight="0" marginwidth="0" leftmargin="0" topmargin="0" style="text-align:center;" align="center">
<div class="mtitle">
<div class="mtitle-row">&nbsp;</div>
{$TITLE}
</div>

<div  style="position: relative;height: 20px;margin-bottom: 20px">
    <table border="0" align="left" width="100%">
        <form method="post" action="index.php">
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
	{$REPORT_FLASH}
	</div>
	<div class="tab-page" id="tabPage2">
		<h2 class="tab">报表数据</h2>
		
		
			<div id="report">
				<div class="reportTitle">{$TITLE}</div>
				{$REPORT_DATA}
			</div>
	</div>
</div>
</body>
</html>