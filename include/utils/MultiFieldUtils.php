<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');

function getMultiFieldInfo($multifieldid,$usecache=true){
    global $adb;
    $key = "MultiFieldInfo_".$multifieldid;
    //if($usecache) $fieldinfo = getSqlCacheData($key);
     if(!$fieldinfo){
            $sql="select ec_multifield.*,ec_tab.name as modulename from ec_multifield inner join ec_tab on ec_tab.tabid=ec_multifield.tabid where multifieldid='$multifieldid' "; 
            $fieldinfo = $adb->getFirstLine($sql);
            $fieldinfo["fields"]=array();
            $tabid=$fieldinfo["tabid"];
            $sql="select * from ec_field where tabid='$tabid' and uitype in ('1021','1022','1023') and typeofdata like '%::$multifieldid%' ";
			$result=$adb->getList($sql);
			foreach($result as $row)
            {
                if($row['uitype']=='1021'){
                   $fieldinfo["fields"][0]=$row;
                }elseif($row['uitype']=='1022'){
                    $fieldinfo["fields"][1]=$row;
                }elseif($row['uitype']=='1023'){
                    $fieldinfo["fields"][2]=$row;
                }
            }
           // if($usecache) setSqlCacheData($key,$fieldinfo);
     }

    return $fieldinfo;
}

//type 1.编辑控制面板信息 2.作为外部UI使用
function getMultiFieldOptions($multifieldid,$level,$parentid,$type){
    global $adb;
    $optionsstr="";
    if($type==1){
       $optionsstr="<option value=''>--未选择--</option>";
       $multifieldinfo=getMultiFieldInfo($multifieldid,false);
       $tablename=$multifieldinfo["tablename"];
       if($level==1){
           $sql="select * from $tablename where thelevel=1 order by sortorderid asc";
           $result=$adb->getList($sql);
		   foreach($result as $row)
           {
               $optval=$row["actualfieldid"];
               $opttxt=$row["actualfieldname"];
               $optionsstr.="<option value='$optval'>$opttxt</option>";
           }

       }else{
           $sql="select * from $tablename where thelevel=$level and parentfieldid='$parentid' order by sortorderid asc";
           $result=$adb->getList($sql);
		   foreach($result as $row)
           {
               $optval=$row["actualfieldid"];
               $opttxt=$row["actualfieldname"];
               $optionsstr.="<option value='$optval'>$opttxt</option>";
           }
       }
    }elseif($type==2){
        $optionsstr=array();
        $strinopts="";
        $multifieldinfo=getMultiFieldInfo($multifieldid); 
        $tablename=$multifieldinfo["tablename"];
        $totallevel=$multifieldinfo["totallevel"];
        if($level>$totallevel) return null;
        if($level==1){
           $sql="select * from $tablename where thelevel=1 order by sortorderid asc";
           $result=$adb->getList($sql);
           $firstcall=true;
           $firstoptid=null;
		   foreach($result as $row)
           {
               $optval=$row["actualfieldid"];
               $opttxt=$row["actualfieldname"];
               $strinopts.='<option relvalue="'.$optval.'" value="'.$opttxt.'">'.$opttxt.'</option>';
               if($firstcall) $firstoptid=$optval;
               $firstcall=false;
           }
           $optionsstr[]=array($multifieldinfo["fields"][$level-1]["fieldname"],$strinopts);
           if(!empty($firstoptid)&&$level<$totallevel){
               $childopts=getMultiFieldOptions($multifieldid,$level+1,$firstoptid,$type);
               $optionsstr=array_merge($optionsstr,$childopts);
           }
       }else{
           $sql="select * from $tablename where thelevel=$level and parentfieldid='$parentid' order by sortorderid asc";
           $result=$adb->getList($sql);
           $firstcall=true;
           $firstoptid=null;
		   foreach($result as $row)
           {
               $optval=$row["actualfieldid"];
               $opttxt=$row["actualfieldname"];
               $strinopts.='<option relvalue="'.$optval.'" value="'.$opttxt.'">'.$opttxt.'</option>';
               if($firstcall) $firstoptid=$optval;
               $firstcall=false;
           }
           $optionsstr[]=array($multifieldinfo["fields"][$level-1]["fieldname"],$strinopts);
           if(!empty($firstoptid)&&$level<$totallevel){
               $childopts=getMultiFieldOptions($multifieldid,$level+1,$firstoptid,$type);
               $optionsstr=array_merge($optionsstr,$childopts);
           }elseif(empty($firstoptid)&&$level<$totallevel){
               $childopts=array();
               $childopts[]=array($multifieldinfo["fields"][$level]["fieldname"],"");
               $optionsstr=array_merge($optionsstr,$childopts);
           }
       }
    }
    return $optionsstr;
}

function getMultiFieldEditViewValue($multifieldid,$uitype,$col_fields){
    global $adb;
    if($uitype=='1021'){
        $level=1;
    }elseif($uitype=='1022'){
        $level=2;
    }elseif($uitype=='1023'){
        $level=3;
    }
    $multifieldinfo=getMultiFieldInfo($multifieldid);
    $totallevel=$multifieldinfo["totallevel"];
    $tablename=$multifieldinfo["tablename"];

    if($level==1){
        $pick_query = "select * from $tablename where thelevel=1 order by sortorderid";
        $parentid=0;
    }elseif($level==2){
        $parentlabel=$multifieldinfo["fields"][0]["fieldname"];
        $parentval=$col_fields[$parentlabel];
        $parentid=getActualFieldID($level,$tablename,$parentval);
        $pick_query = "select * from $tablename where thelevel=2 and parentfieldid=$parentid order by sortorderid";
    }elseif($level==3){
        $toplabel=$multifieldinfo["fields"][0]["fieldname"];
        $topval=$col_fields[$toplabel];
        $parentlabel=$multifieldinfo["fields"][1]["fieldname"];
        $parentval=$col_fields[$parentlabel];
        $parentid=getActualFieldID($level,$tablename,$parentval,$topval);
        $pick_query = "select * from $tablename where thelevel=3 and parentfieldid=$parentid order by sortorderid";
    }
    $key = "MultiFieldPickArray_".$multifieldid."_{$level}_{$parentid}";
    $picklist_array = getSqlCacheData($key);
    if(!$picklist_array){
        $pickListResult = $adb->getList($pick_query);
        $picklist_array = array();
        foreach($pickListResult as $row) {
            $picklist_array[] =array($row['actualfieldid'],$row['actualfieldname']);
        }
       setSqlCacheData($key,$picklist_array);
    }
    $options = array();
    $found = false;
    $thislabel=$multifieldinfo["fields"][$level-1]["fieldname"];
    $value=$col_fields[$thislabel];
    foreach($picklist_array as &$pickListValue)
    {
        if($value == $pickListValue[1])
        {
            $chk_val = "selected";
            $found = true;
        }
        else
        {
            $chk_val = '';
        }
        $pickListValue[2]=$chk_val;
        $options[] = $pickListValue;
    }
//    print_r($options);
    return $options;
}

function getActualFieldID($level,$tablename,$parentval,$topval=''){
    global $adb;
    $fieldid=null;
    if($level==2){
        if(empty($parentval)){
            $sql="select actualfieldid from $tablename where thelevel=1 order by sortorderid";
        }else{
            $sql="select actualfieldid from $tablename where thelevel=1 and actualfieldname='$parentval' order by sortorderid";
        }
        $result=$adb->query($sql);
        $fieldid=$adb->query_result($result,0,"actualfieldid");
    }elseif($level==3){
        if(empty($topval)){
            $sql="select secondtab.actualfieldid from $tablename as toptab inner join $tablename as secondtab on toptab.actualfieldid=secondtab.parentfieldid where secondtab.thelevel=2  order by toptab.sortorderid,secondtab.sortorderid";
        }else{
            if(!empty($parentval)){
                $sql="select secondtab.actualfieldid from $tablename as toptab inner join $tablename as secondtab on toptab.actualfieldid=secondtab.parentfieldid where secondtab.thelevel=2 and secondtab.actualfieldname='$parentval' and toptab.actualfieldname='$topval' order by secondtab.sortorderid";
            }else{
                $sql="select secondtab.actualfieldid from $tablename as toptab inner join $tablename as secondtab on toptab.actualfieldid=secondtab.parentfieldid where secondtab.thelevel=2 and toptab.actualfieldname='$topval' order by secondtab.sortorderid";
            }
        }
//        echo $sql;
        $result=$adb->query($sql);
        $fieldid=$adb->query_result($result,0,"actualfieldid");
    }
    if(empty($fieldid)) $fieldid=0;
//    echo $fieldid;
    return $fieldid;
}

function getFieldNodeInformation($fieldid,$multifieldid){
    global $adb;
    $fieldinf=array();
    $multifieldinfo=getMultiFieldInfo($multifieldid);
    $totallevel=$multifieldinfo["totallevel"];
    $tablename=$multifieldinfo["tablename"];
    $sql="select * from $tablename where actualfieldid='$fieldid'";
    $row=$adb->getFirstLine($sql);
    if($row){
        $sortorderid=$row['sortorderid'];
        $sortorderid+=1;
        $fieldname=$row['actualfieldname'];
        $fieldinf[]=$fieldname;
        $fieldinf[]=$sortorderid;
    }
    return $fieldinf;
}

function getMultiFieldPos($fieldid,$multifieldid){
    global $adb;
    if($feildid==-1) return 1;
    $multifieldinfo=getMultiFieldInfo($multifieldid);
    $totallevel=$multifieldinfo["totallevel"];
    $tablename=$multifieldinfo["tablename"];
    $sql="select * from $tablename where actualfieldid='$fieldid'";
    $row=$adb->getFirstLine($sql);
    if($row){
        $sortorderid=$row['sortorderid'];
        $sortorderid+=1; 
    }
    return $sortorderid;
}

function deleteOptionNode($multifieldid,$fieldid,$level,$totallevel,$tablename)
{
    global $adb;
    $deletesql="delete from $tablename where actualfieldid='$fieldid' ";
    //file_put_contents("D:\\deletelog.txt", "$deletesql\r\n", FILE_APPEND | LOCK_EX);
    $adb->query($deletesql);

    deleteSubOptionNode($multifieldid,$level+1,$totallevel,$fieldid,$tablename);
}

function deleteSubOptionNode($multifieldid,$level,$totallevel,$parentfieldid,$tablename)
{
    global $adb;
    if($level>$totallevel){
        return;
    }
    if($level+1<=$totallevel){
        $sql="select actualfieldid from $tablename where thelevel='$level' and parentfieldid='$parentfieldid'";
        $result=$adb->getList($sql);
		foreach($result as $row)
        {
            $eachfieldid=$row["actualfieldid"];
            deleteSubOptionNode($multifieldid,$level+1,$totallevel,$eachfieldid,$tablename);
        }
    }

    $deletesql="delete from $tablename where thelevel='$level' and parentfieldid='$parentfieldid'";
    //file_put_contents("D:\\deletelog.txt", "$deletesql\r\n", FILE_APPEND | LOCK_EX);
    $adb->query($deletesql);
}
/*
function getPreviousNode($sortorderid,$level,$parentfieldid){
    $parentarr=array();
    if($sortorderid==0){
        $parentid=-1;
        $parentname="第一个选项";
    }else{

    }
    return $parentarr;
}
 * */

?>
