<?php
require_once('data/Tracker.php');
require_once('include/utils/utils.php');
require_once('include/database/PearDatabase.php');

global $mod_strings,$app_strings,$log,$current_user,$theme;

$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";


if(isset($_REQUEST['record']))
{
	$id = $_REQUEST['record'];
	$log->debug(" the id is ".$id);
}


$category = getParentTab();
$CreateAccount = '<div id="accountLay" style="display: block;" class="layerPopup" >
    <form name="CreateAccount" method="POST" action="index.php">
	<input type="hidden" name="record" value="'.$id.'">	
	<table width="300" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
		<tr style="cursor:move;">
			<td id="account_div_title" class="layerPopupHeading"  nowrap align="left">'.$mod_strings['LBL_NEW_FORM_TITLE'].'</td>
			<td align="right"><a href="javascript:fninvsh(\'accountLay\');"><img src="'.$image_path.'close.gif" align="absmiddle" border="0"></a></td>
		</tr>
		</table>
	
	<table border=0 cellspacing=0 cellpadding=0 width=300 align=center> 
	<tr>
		<td class=small >
			<table border=0 celspacing=0 cellpadding=5 width=95% align=center bgcolor=white>
				<tr>
					<td width="30%" align="right" class="dvtCellLabel">'.$mod_strings['Account Name'].'</td>
					<td width="70%" align="left" class="dvtCellInfo"><input class="detailedViewTextBox"  onfocus="this.className=\'detailedViewTextBoxOn\'" name="accountname" id="accountname" onblur="this.className=\'detailedViewTextBox\'" value=""></td>
			    </tr>
				<tr>
					<td width="30%" align="right" class="dvtCellLabel">'.$mod_strings['Email'].'</td>
					<td width="70%" align="left" class="dvtCellInfo"><input class="detailedViewTextBox"  onfocus="this.className=\'detailedViewTextBoxOn\'" name="email" id="email" onblur="this.className=\'detailedViewTextBox\'" value=""></td>
			    </tr>
				<tr>
					<td width="30%" align="right" class="dvtCellLabel">'.$mod_strings['Phone'].'</td>
					<td width="70%" align="left" class="dvtCellInfo"><input class="detailedViewTextBox"  onfocus="this.className=\'detailedViewTextBoxOn\'" name="phone" id="phone" onblur="this.className=\'detailedViewTextBox\'" value=""></td>
			    </tr>';

$CreateAccount .='</table>
			   <script id="accountjs">Drag.init(document.getElementById("account_div_title"), document.getElementById("accountLay"));</script>
			</td>
		</tr>
	</table>
	<table border=0 cellspacing=0 cellpadding=5 width=300 class="layerPopupTransport">
	<tr>
			<td align="center">
				<input name="Save" value=" '.$app_strings['LBL_SAVE_BUTTON_LABEL'].' " type="button" onClick="javascript:;created(this.form)" class="crmbutton save small">&nbsp;&nbsp;
				<input type="button" name=" Cancel " value=" '.$app_strings['LBL_CANCEL_BUTTON_LABEL'].' " onClick="fninvsh(\'accountLay\')" class="crmbutton cancel small">
			</td>
		</tr>
	</table></form>
</div>';
echo $CreateAccount;

?>
