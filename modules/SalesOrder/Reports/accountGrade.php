<?php

global $adb;

//report type:1.半自定义报表 2.完全自定义
$customreporttype=1;
//报表相对位置（数字越小越靠前）
$order=1;
// 自定义sql语句
$query=getListQuery("SalesOrder");
// 自定义字段信息
$fieldlabel="客户级别";
$fieldname='grade';
$fieldtablename='ec_account';
$fieldcolname='grade';
$fieldinf=array($fieldlabel,$fieldname,$fieldtablename,$fieldcolname);
// 自定义字段选项列表
$picklistopts=array();
// $showinreport:表示该文件在报表中运行，需要选项字段，否则表示在ListView.php显示，无需选项列表
if($showinreport)
{
    $sql="select * from ec_grade order by sortorderid asc";
    $result=$adb->getList($sql);
	foreach($result as $row)
    {
        $picklistopts[]=$row['grade'];
    }
}
$returnval = array(array($order,$customreporttype),array($query,$fieldinf,$picklistopts));
?>
