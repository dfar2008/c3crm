<?php
session_start();

$root_directory = dirname(__FILE__)."/";
require($root_directory.'include/init.php'); 

$query_string = "module=SfaDesktops&action=index";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML style="OVERFLOW: hidden">
<HEAD>
    <TITLE>易客CRM开源免费版</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<STYLE type='text/css'>
* {
	PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; PADDING-TOP: 0px
}
.tableStyle {
	BORDER-RIGHT: #163e7f 1px solid; PADDING-RIGHT: 0px; BORDER-TOP: #163e7f 1px solid; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; BORDER-LEFT: #163e7f 1px solid; WIDTH: 100%; PADDING-TOP: 0px; BORDER-BOTTOM: #163e7f 1px solid; HEIGHT: 0px; BACKGROUND-COLOR: #f4f9fd
}
A:hover {
	COLOR: rgb(5,95,192); TEXT-DECORATION: underline
}
</STYLE>
<style type="text/css">@import url("themes/softed/style.css");</style>

<!--[if lte IE 8]>
<style type="text/css">	
#ActivityRemindercallback {position: absolute;display:block;width:209px;
top:expression(eval(document.compatMode &&
document.compatMode=='CSS1Compat') ?
documentElement.scrollTop
+(documentElement.clientHeight-this.clientHeight)
: document.body.scrollTop
+(document.body.clientHeight-this.clientHeight));}
</style>
<![endif]-->

<!-- End -->
<LINK href="include/mainresource/style.css" type=text/css rel=stylesheet>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/json.js"></script>
<script src="include/scriptaculous/prototype.js" type="text/javascript" language="javascript"></script>
<script src="include/scriptaculous/scriptaculous.js" type="text/javascript" language="javascript"></script>
<script src="include/scriptaculous/dom-drag.js" type="text/javascript" language="javascript"></script>
<META content="MSHTML 6.00.6000.17092" name=GENERATOR>
</HEAD>
<BODY style="PADDING-RIGHT: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; MARGIN: 0px; OVERFLOW: hidden; PADDING-TOP: 0px">
<TABLE height="100%" cellSpacing=0 cellPadding=0 width="100%" border=0>
  <TBODY>
  <TR>
    <TD vAlign=top colSpan=2>
	<IFRAME id=top name=top src="maintop.php" frameBorder=0 width="100%" scrolling=no height=42px></IFRAME>
    </TD>
  </TR>
  <TR>
    <TD id=tdLeft vAlign=top width=172 height="100%">
	<IFRAME id=outlook name=outlook src="leftmenu.php" frameBorder=0 width='172px'  height="100%"></IFRAME></TD>
    <TD vAlign=top height="100%">
	<IFRAME id=main name=main src="index.php?<?php echo $query_string; ?>" frameBorder=0 width="100%" height="100%"></IFRAME>
	</TD>
  </TR>
  
  </TBODY></TABLE>
  <div id="status" style="position:absolute;display:none;left:930px;top:95px;height:27px;white-space:nowrap;"><img src="themes/softed/images/status.gif"></div>
<!-- ActivityReminder Customization for callback -->
 
<script>
    
</script>
</BODY>
</HTML>
