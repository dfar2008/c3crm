<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/MultiFieldUtils.php');
global $adb;
$multifieldid=$_REQUEST["multifieldid"];
$level=$_REQUEST["level"];
$parentfieldid=$_REQUEST["parentfieldid"];

$multifieldinfo=getMultiFieldInfo($multifieldid);
$tablename=$multifieldinfo["tablename"];

$fieldname = $_REQUEST['catalogName'];
$mode = $_REQUEST['mode'];
if(isset($_REQUEST['dup_check']) && $_REQUEST['dup_check']!='')
{
	if($mode != 'edit')
	{
        if($level==1){
            $query = "select actualfieldid from $tablename where thelevel=1 and actualfieldname='$fieldname' order by sortorderid asc";
        }else{
            $query = "select actualfieldid from $tablename where thelevel=$level and parentfieldid='$parentfieldid' and actualfieldname='$fieldname' order by sortorderid asc";
        }
	}
	else
	{
		$fieldid=$_REQUEST['catalogid'];
        if($level==1){
            $query = "select actualfieldid from $tablename where thelevel=1 and actualfieldname='$fieldname' and actualfieldid<>'$fieldid' order by sortorderid asc";
        }else{
            $query = "select actualfieldid from $tablename where thelevel=$level and parentfieldid='$parentfieldid' and actualfieldname='$fieldname' and actualfieldid<>'$fieldid' order by sortorderid asc";
        }
	}
	$result = $adb->query($query);
	if($adb->num_rows($result) > 0)
	{
		echo '下拉框选项已存在';
		die;
	}else
	{
		echo 'SUCESS';
		die;
	}

}

//Inserting values into Catalog Table
if(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'edit')
{
	$fieldid = $_REQUEST['catalogid'];
	//updateCatalog($catalogId,$catalogname);
    $updatesql="update $tablename set actualfieldname='$fieldname' where actualfieldid='$fieldid' ";
    //echo $updatesql;
    $adb->query($updatesql);
}
elseif(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'create')
{
	//Inserting into ec_catalog Table
	//$catalogId = createCatalog($catalogname,$parentCatalogId);
    $theparentfieldId=$_REQUEST['parent'];
    if($theparentfieldId!=-1){
        $sql="select sortorderid from $tablename where actualfieldid='$theparentfieldId'";
        $result=$adb->query($sql);
        $sortorderid=$adb->query_result($result,0,"sortorderid");
    }else{
        $sortorderid=-1;
    }
    if($level==1){
        $updatesql="update $tablename set sortorderid=sortorderid+1 where thelevel=1 and sortorderid>$sortorderid";
    }else{
        $updatesql="update $tablename set sortorderid=sortorderid+1 where thelevel=$level and parentfieldid='$parentfieldid' and sortorderid>$sortorderid";
    }
    $adb->query($updatesql);
    $id = $adb->getUniqueID($tablename);
    $newsortorderid=$sortorderid+1;
    $insertsql="insert into $tablename values($id,'$fieldname','$newsortorderid','0','$level','$parentfieldid')";
    $adb->query($insertsql);

}

$loc = "Location: index.php?action=PopupMultiFieldTree&module=Settings&multifieldid={$multifieldid}&level={$level}&parentfieldid={$parentfieldid}";
header($loc);


?>
