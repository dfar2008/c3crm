<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<link href="themes/softed/style.css" rel="stylesheet" type="text/css"></link>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>
<body class="small" marginwidth=0 marginheight=0 leftmargin=0 topmargin=0 bottommargin=0 rigthmargin=0>

<form action="index.php" method="post" id="form">
<input type='hidden' name='module' value='Users'>
<input type='hidden' id='userid' name='userid' value='{$USERID}'>

<table  width="100%" border="0" cellspacing="0" cellpadding="0" class="mailClient mailClientBg">
	<tr>
		<td>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
				<tr>
					<td class="moduleName" width="80%" style="padding-left:10px;">{$MOD.LBL_AUDIT_TRAIL}</td>
					<td  width=30% nowrap class="componentName" align=right>{$APP.VTIGER}</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="hdrNameBg small">
			<div id="AuditTrailContents">
				{include file="ShowAuditTrailContents.tpl"}
			</div>
		</td>
	</tr>
	<tr>
    <td align="center" style="padding:10px;" class="reportCreateBottom" >&nbsp;</td>
  </tr>
</table>
</form>
</body>
{literal}
<script>
function getListViewEntries_js(module,url)
{
	var userid = document.getElementById('userid').value;
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Users&action=UsersAjax&file=ShowAuditTrail&ajax=true&'+url+'&userid='+userid,
                        onComplete: function(response) {
                                $("AuditTrailContents").innerHTML= response.responseText;
                        }
                }
        );
}

function getListViewWithPageNo(module,pageElement)
{
	//var pageno = document.getElementById('listviewpage').value;
	var pageno = pageElement.options[pageElement.options.selectedIndex].value;
	getListViewEntries_js(module,'start='+pageno);
}
</script>
{/literal}
