<?php
$root_directory = dirname(__FILE__)."/";
require($root_directory.'include/init.php');
$current_user = new Users();
$use_current_login = false;
$current_user->id = $_SESSION['authenticated_user_id'];

$app_strings = return_application_language($current_language);


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml"><HEAD id=Head1><TITLE></TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK href="include/mainresource/style.css" type='text/css' rel='stylesheet' charset="gb2312">
<META content="MSHTML 6.00.6000.17092" name=GENERATOR>
<script type="text/javascript" src="include/mainresource/leftMenuOp.js"></script>
<script type="text/javascript" src="include/mainresource/js.js" charset="gb2312"></script>
<script type="text/javascript">
function show_confirm(){
	if(confirm("确认清空缓存?")){
		return true;
	}else{
		return false;
	}
}
</script>
</HEAD>
<BODY class=menuBody>

<DIV>
</DIV>
<TABLE id=tbBody cellSpacing=0 cellPadding=0 width='172px' border=0>
  <TBODY>
  <TR>
    <TD style="VERTICAL-ALIGN: top; WIDTH: 169px">
<?php
$header_array = getHeaderArray(); 
$index=1;
foreach($header_array as $parenttab=>$detail){
    if($index==1) $dislpaystyle="block";
    else $dislpaystyle="none";
?>
      <DIV class='header' id='div<?php echo $index;?>_1' onClick="displayDiv(0,<?php echo $index;?>);"><?php echo $app_strings[$parenttab];?></DIV>
      <DIV id=div<?php echo $index;?>_2 class=itemStyle style="DISPLAY: <?php echo $dislpaystyle;?>;">
<?php
foreach($detail as $modules){
		if($modules[0] =='Caches'){
	 ?>
             <A title="<?php echo $app_strings[$modules[0]];?>"  target="main" href="index.php?module=<?php echo $modules[0]?>&action=index" onClick="return show_confirm();">·<SPAN>&nbsp;</SPAN><?php echo $app_strings[$modules[0]];?></A> 
     <?php
		}else{
	?> 
			  <A title="<?php echo $app_strings[$modules[0]];?>"  target="main" href="index.php?module=<?php echo $modules[0]?>&action=index">·<SPAN>&nbsp;</SPAN><?php echo $app_strings[$modules[0]];?></A> 
		  
	<?php
		}
    }
    $index+=1;
?>
    </DIV>
<?php
}
?>

      </TD>
    <TD class=left_BorderColor style="CURSOR: pointer" onClick=""></TD></TR></TBODY></TABLE>
	 

</BODY></HTML>
