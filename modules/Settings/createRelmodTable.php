<?php
global $mod_strings,$app_strings,$log,$adb,$theme,$current_language;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";
$nowmodule = $_REQUEST['nowmodule'];
$tabid = getTabid($nowmodule);
$query = "SELECT ec_field.columnname,ec_field.fieldlabel,ec_relmodfieldlist.fieldname,ec_relmodfieldlist.width,ec_relmodfieldlist.module,ec_field.fieldid
                  FROM ec_field inner join ec_relmodfieldlist on ec_relmodfieldlist.fieldname=ec_field.columnname and ec_relmodfieldlist.module='".$nowmodule."'
                  WHERE ec_field.tabid='".$tabid."' order by ec_relmodfieldlist.id";
$result = $adb->query($query);
$noofrows = $adb->num_rows($result);
$language_strings = return_module_language($current_language,$nowmodule);
$tableBuffer = "";
for($i=0; $i<$noofrows; $i++)
{
    $fieldlabel = $adb->query_result($result,$i,"fieldlabel");
    if(isset($language_strings[$fieldlabel])) {
        $fieldlabel = $language_strings[$fieldlabel];
    }
    $fieldwidth = $adb->query_result($result,$i,"width");
    $tableBuffer .= '<td width="'.$fieldwidth.'" class="lvtCol"><b>'.$fieldlabel.'</b></td>';
}
if($nowmodule == 'Quotes')
{
    $CreateTable = '<div id="orgLay" style="display: block;" class="layerPopup" >
                  <table border="0" celspacing="0" cellpadding="5" width="100%" align="center" bgcolor="white">
                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
                        <tr>
			<td id="gather_div_title" class="layerPopupHeading"  nowrap align="left">相关信息</td>
			<td align="right"><a href="javascript:fninvsh(\'orgLay\');"><img src="'.$image_path.'close.gif" align="absmiddle" border="0"></a></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="white">
                        <tr>
                        '.$tableBuffer.'
                        </tr>
                        <tr><td colspan=20>&nbsp;</td></tr>
                    </table>
                  </table>
                   ';
}
else
{
    $CreateTable = '<div id="orgLay" style="display: block;" class="layerPopup" >
                  <table border="0" celspacing="0" cellpadding="5" width="100%" align="center" bgcolor="white">
                    <table width="100%" border="0" cellpadding="5" cellspacing="0" class="layerHeadingULine">
                        <tr>
			<td id="gather_div_title" class="layerPopupHeading"  nowrap align="left">相关信息</td>
			<td align="right"><a href="javascript:fninvsh(\'orgLay\');"><img src="'.$image_path.'close.gif" align="absmiddle" border="0"></a></td>
                        </tr>
                    </table>
                    <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="white">
                        <tr>
                        '.$tableBuffer.'
                        </tr>
                        <tr><td colspan=20>&nbsp;</td></tr>
                    </table>
                  </table>
                   ';
}
echo $CreateTable;
?>