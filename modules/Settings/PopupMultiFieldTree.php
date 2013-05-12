<?php
require_once('include/utils/UserInfoUtil.php');
require_once('include/CRMSmarty.php');
$smarty = new CRMSmarty();

global $mod_strings;
global $app_strings;
global $app_list_strings;



global $adb;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];
$multifieldinfo=getMultiFieldInfo($multifieldid);
$tablename=$multifieldinfo["tablename"];

//Retreiving the hierarchy
if($level==1){
    $hquery = "select * from $tablename where thelevel=1 order by sortorderid asc";
}else{
    $hquery = "select * from $tablename where thelevel=$level and parentfieldid='$parentfieldid' order by sortorderid asc";
}
//echo $hquery;
$result = $adb->getList($hquery);
$hrarray= Array();
foreach($result as $row)
{
    $hrarray[]=$row;
}
//print_r($hrarray);
//Constructing the Catalogdetails array


$catalogout ='';
$catalogout .= indent($hrarray,$catalogout);

/** recursive function to construct the catalog tree ui
  * @param $hrarray -- Hierarchial catalog tree array with only the catalogid:: Type array
  * @param $catalogout -- html string ouput of the constucted catalog tree ui:: Type varchar
  * @param $catalog_det -- Catalogdetails array got from calling getAllCatalogDetails():: Type array
  * @returns $catalog_out -- html string ouput of the constucted catalog tree ui:: Type string
  *
 */

function indent($hrarray,$catalogout)
{
	global $theme;
	global $mod_strings;
	global $current_user;
    global $adb;

    $multifieldid=$_REQUEST["multifieldid"];
    $level=$_REQUEST["level"];
    $parentfieldid=$_REQUEST["parentfieldid"];

    $multifieldinfo=getMultiFieldInfo($multifieldid);
    $tablename=$multifieldinfo["tablename"];
    $totallevel=$multifieldinfo["totallevel"];

    if($level==1){
        $previousName="根目录";
        $hreflink="javascript:;";
    }else{
        $sql="select * from $tablename where actualfieldid='$parentfieldid' ";
        $result=$adb->query($sql);
        $previousName=$adb->query_result($result,0,"actualfieldname");
        $previousparentid=$adb->query_result($result,0,"parentfieldid");
        $hreflink="javascript:gotoPreviousLevel($multifieldid,$level,$previousparentid);";
    }

	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";

    $catalogout .= '<ul class="uil" id="-1" style="display:block;list-style-type:none;">';
    $catalogout .=  '<li ><table border="0" cellpadding="0" cellspacing="0" onMouseOver="fnVisible(\'layer_-1\')" onMouseOut="fnInVisible(\'layer_-1\')">';
    $catalogout.= '<tr><td nowrap>';

    $catalogout.='<b style="font-weight:bold;margin:0;padding:0;cursor:pointer;">';
    $catalogout .= '<img src="'.$image_path.'/menu_root.gif" id="img_-1" border="0"  alt="上一级目录" title="上一级目录" align="absmiddle">';
    $catalogout .= '&nbsp;<a href="'.$hreflink.'"><b class="genHeaderGray">'.$previousName.'</b></a></td>';
    $catalogout .= '<td nowrap><div id="layer_-1" class="drag_Element">';
    $catalogout .= '<a href="index.php?module=Settings&action=Popupcreatemultifieldnode&multifieldid='.$multifieldid.'&level='.$level.'&parentfieldid='.$parentfieldid.'&parent=-1"><img src="'.$image_path.'/Rolesadd.gif" align="absmiddle" border="0" alt="添加选项在下拉框首位" title="添加选项在下拉框首位"></a>';
    $catalogout .= '</div></td></tr></table>';
	foreach($hrarray as $row)
	{

		

        $actualfieldid=$row["actualfieldid"];
        $multifieldname=$row["actualfieldname"];
		$catalogout .= '<ul class="uil" id="'.$actualfieldid.'" style="display:block;list-style-type:none;">';
		$catalogout .=  '<li ><table border="0" cellpadding="0" cellspacing="0" onMouseOver="fnVisible(\'layer_'.$actualfieldid.'\')" onMouseOut="fnInVisible(\'layer_'.$actualfieldid.'\')">';
		$catalogout.= '<tr><td nowrap>';
		
        $catalogout.='<b style="font-weight:bold;margin:0;padding:0;cursor:pointer;">';
       
        $catalogout .= '<img src="'.$image_path.'/vtigerDevDocs.gif" id="img_'.$actualfieldid.'" border="0"  alt="'.$mod_strings["Expand/Collapse"].'" title="'.$mod_strings["Expand/Collapse"].'" align="absmiddle">';

		
	
			$catalogout .= '&nbsp;<a href="javascript:gotoNextLevel('.$multifieldid.','.$level.','.$totallevel.','.$actualfieldid.');" class="x" id="user_'.$actualfieldid.'">'.$multifieldname.'</a></td>';

			$catalogout.='<td nowrap><div id="layer_'.$actualfieldid.'" class="drag_Element">';
			if(is_admin($current_user)) {
				$catalogout.='<a href="index.php?module=Settings&action=Popupcreatemultifieldnode&multifieldid='.$multifieldid.'&level='.$level.'&parentfieldid='.$parentfieldid.'&parent='.$actualfieldid.'"><img src="'.$image_path.'/Rolesadd.gif" align="absmiddle" border="0" alt="在本选项后面添加一个新的选项" title="在本选项后面添加一个新的选项"></a>';
				$catalogout.='<a href="index.php?module=Settings&action=Popupcreatemultifieldnode&multifieldid='.$multifieldid.'&level='.$level.'&parentfieldid='.$parentfieldid.'&catalogid='.$actualfieldid.'&mode=edit"><img src="'.$image_path.'/RolesEdit.gif" align="absmiddle" border="0" alt="编辑下拉框选项" title="编辑下拉框选项"></a>';
				$catalogout .=	'<a href="javascript:deleteFieldNode('.$actualfieldid.','.$multifieldid.','.$level.','.$parentfieldid.');"><img src="'.$image_path.'/RolesDelete.gif" align="absmiddle" border="0" alt="删除下拉框选项" title="删除下拉框选项"></a>';
			}

			

		        
				$catalogout .='</div></td></tr></table>';


		
 		$catalogout .=  '</li>';
		

		$catalogout .=  '</ul>';

	}

	return $catalogout;
}
$smarty->assign("THEME",$theme_path);
$smarty->assign("IMAGE_PATH",$image_path);
$smarty->assign("APP", $app_strings);
$smarty->assign("MOD", $mod_strings);
$smarty->assign("CATALOGTREE", $catalogout);
$smarty->assign("MULTIFIELDID", $multifieldid);

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'true')
{
	$smarty->display("Settings/MultiFieldTree.tpl");
}
else
{
	$smarty->display("Settings/MultiFieldDetailView.tpl");
}

?>
