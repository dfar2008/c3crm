<?php


require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');

global $theme;
$theme_path="themes/".$theme."/";
global $mod_strings;
global $current_user;

?>

<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3>选择 邮件模板</h3>
</div>
<div class="modal-body">

  <form action="index.php">

   <input type="hidden" name="module" value="Users">

		<table class="table table-bordered table-hover table-condensed table-striped">
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
</div>
<div id="returnMsg"></div>
<script>
function submittemplate(templateid)
{
  var url = 'index.php?module=Maillists&action=MaillistsAjax&file=TemplateMerge&templateid='+templateid;
  $("#status").prop("display","inline");
  $.ajax({  
       type: "GET",  
       //dataType:"Text",   
       url:url,
       success: function(msg){   
         $("#status").prop("display","none");
         $("#returnMsg").html(msg); 

        subject =  document.frmrepstr.subject.value;
        repstr =  document.frmrepstr.repstr.value;

        $("#subject").val(subject);
        if(KE != undefined) {
          KE.html("mailcontent",repstr);
        } else {
          $('#mailcontent').val(repstr);
        }

       }  
  }); 
  $('#selecttmpdiv').modal('hide');

}
</script>
</html>
