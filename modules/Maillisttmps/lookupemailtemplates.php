<?php



require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');

global $theme;
$theme_path="themes/".$theme."/";
global $mod_strings;
global $current_user;

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="en">
<head>
  <title><?php echo $mod_strings['LBL_LIST_FORM_TITLE']; ?></title>
  <link type="text/css" rel="stylesheet" href="<?php echo $theme_path ?>/style.css"/>
</head>
<body>
            <form action="index.php">
	    
             <input type="hidden" name="module" value="Users">
		<table style="background-color: rgb(204, 204, 204);" class="small" border="0" cellpadding="5" cellspacing="1" width="100%">
		<tr align="left">
		<th width="35%" class="lvtCol"><b><?php echo $mod_strings['Maillisttmp Name']; ?></b></th>
                <th width="65%" class="lvtCol"><b><?php echo $mod_strings['Description']; ?></b></td>
                </tr>
<?php
   $sql = "select * from ec_maillisttmps where deleted=0 and smownerid=".$current_user->id." order by maillisttmpsid desc";
   $result = $adb->getList($sql);
$cnt=1;

require_once('include/utils/UserInfoUtil.php');
foreach($result as $temprow)
{
  printf("<tr class='lvtColData' onmouseover=\"this.className='lvtColDataHover'\" onmouseout=\"this.className='lvtColData'\" bgcolor='white'> <td height='25'>");
 $templatename = $temprow["maillisttmpname"];
  echo "<a href='javascript:submittemplate(".$temprow['maillisttmpsid'].");'>".$temprow["maillisttmpname"]."</a></td>";
   printf("<td height='25'>%s</td>",$temprow["description"]);
  $cnt++;
}
?>
</table>
</body>
<script>
function submittemplate(templateid)
{
	window.document.location.href = 'index.php?module=Maillists&action=MaillistsAjax&file=TemplateMerge&templateid='+templateid;
}
</script>
</html>
