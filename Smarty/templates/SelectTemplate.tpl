<link rel="stylesheet" type="text/css" href="{$THEME_PATH}style.css">
<body class="small" marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 bottommargin=0 rigthmargin=0>
<form name="basicSearch" action="index.php" method="GET">
<table width="30%" cellpadding="5" cellspacing="0">
<tr>
	<td class="dvtCellLabel">{$APP.LBL_SELECT_TEMPLATE}</td>
	<td class="dvtCellLabel">							
	<select name ="templatefile"  id="templatefile" class="txtBox" style="width:150px">
		 {$TEMPLATEOPTION }
	</select> &nbsp;</td>
	<td class="dvtCellLabel">
	<input type="hidden" name="module" value="{$MODULE}">
	<input type="hidden" name="action" value="CreatePDFPrint">
	<input type="hidden" name="record" value="{$RECORD}">
	</td>
	<td class="dvtCellLabel">
		<input type="submit" name="search" value=" &nbsp;{$APP.LNK_PRINT}&nbsp; " class="crmbutton small create">
	</td>
</tr>
 
</table>
</form>
</body>