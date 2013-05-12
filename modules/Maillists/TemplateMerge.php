<?php

//require_once('include/utils/CommonUtils.php');
function getTemplateDetails2($templateid)
{
        global $adb,$log;
        $log->debug("Entering into getTemplateDetails() method ...");
        $returndata =  Array();
        $result = $adb->query("select * from ec_maillisttmps where maillisttmpsid=$templateid");
        $returndata[] = $templateid;
        $returndata[] = $adb->query_result($result,0,'description');
        $returndata[] = $adb->query_result($result,0,'maillisttmpname');
        $log->debug("Exiting from getTemplateDetails($templateid) method ...");
        return $returndata;
}

if(isset($_REQUEST['templateid']) && $_REQUEST['templateid'] !='')
{
	$templatedetails = getTemplateDetails2($_REQUEST['templateid']);
	//$details['Email Information'][2][0][3][0] = $templatedetails[2]; //Subject
	//$details['Email Information'][3][0][3][0] = nl2br($templatedetails[1]); //Body
}
?>
<form name="frmrepstr">
<input type="hidden" name="subject" value="<?php echo $templatedetails[2];?>"></input>
<textarea name="repstr" style="visibility:hidden">
<?php echo nl2br($templatedetails[1]); ?>
</textarea>
</form>
<script language="javascript">
window.opener.document.getElementById('subject').value = window.document.frmrepstr.subject.value
if(window.opener.oFCKeditor != undefined) {
	window.opener.oFCKeditor.SetHTML(window.document.frmrepstr.repstr.value);
	window.opener.oFCKeditor.ReplaceTextarea();
} else if(window.opener.KE != undefined) {
	window.opener.KE.html("mailcontent",window.document.frmrepstr.repstr.value);
} else {
	window.opener.document.getElementById('mailcontent').value = window.document.frmrepstr.repstr.value
	//window.opener.document.getElementById('description').value = window.document.frmrepstr.repstr.value
}
window.close();
</script>
