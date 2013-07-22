<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
//require_once('include/FusionCharts.php');
class ListViewReport
{
    var $reportmodule;
    var $picklistfield;
    var $type;
    var $collectcolumnfield;
    var $iscustomreport;
    var $picklistopts;
    
    var $graphtype;
    
    private $graphtypearr;
    function ListViewReport($reportmodule)
    {
        $this->reportmodule=$reportmodule;
        $graphtypearr=array();
		//changed by xiaoyang on 2012-9-24
//        $graphtypearr['vertical3D']='3D柱图';
     //   $graphtypearr['vertical2D']='2D柱图 ';
      //  $graphtypearr['Line2D']='折线图';
//        $graphtypearr['Pie3D']='3D饼图';
 //       $graphtypearr['Pie2D']='2D饼图';
		$graphtypearr['column']='柱图';
		$graphtypearr['line']='折线图';
        $graphtypearr['pie']='饼图';
        $this->graphtypearr=$graphtypearr;
    }
    
    function getHiddenFieldHTML()
    {
        $keyNotInHidden=array('graphtype','grouptype');
        $hiddenhtml="";
        foreach($_REQUEST as $key=>$value)
        {
           if(!in_array($key,$keyNotInHidden))
           { 
             $hiddenhtml.="<input type='hidden' name='$key' value='$value'>\r\n";
           }
            
        }
        return $hiddenhtml;
    }
    
    function getGraphTypeOpts()
    {
        $graphtypearr=$this->graphtypearr;
        $current_type=$this->graphtype;
        $typeopts="";
        foreach($graphtypearr as $key=>$value)
        {
            $selected="";
            if($key==$current_type)
            {
                $selected="selected";
            }
            $typeopts.="<option value='$key' $selected>$value</option>";
        }
        return $typeopts;
    }


    function getTitle()
    {
        global $app_strings;
        $fieldlabel=$this->picklistfield[0];
        $modulelabel=$app_strings[$this->reportmodule];
        $reportlabel=$fieldlabel."分布统计";
        return "$modulelabel-$reportlabel";
    }
    
    function getModulePicklists()
    {
        global $adb;
        global $app_strings,$current_language;
        $allmodulepicklists=array();
        $current_module=$this->reportmodule;
        $tabid=getTabid($current_module);
        $mod_strings = return_specified_module_language($current_language, $current_module);
        
		$sql = "select ec_field.* from ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0";
		$sql.= " where ec_field.tabid=".$tabid."  and uitype in ('15') and";
		$sql.= " ec_field.displaytype in (1,2) and ec_field.fieldname!='country' ";
		$sql.= " order by sequence";
        
        $result = $adb->getList($sql);
		foreach($result as $row)
        {
            $fieldtablename = $row["tablename"];
			$fieldcolname = $row["columnname"];
			$fieldname =$row["fieldname"];
            $fieldlabel =$row["fieldlabel"];
            if(isset($mod_strings[$fieldlabel])) $fieldlabel=$mod_strings[$fieldlabel];
            elseif(isset($app_strings[$fieldlabel]))
            {
                $fieldlabel = $app_strings[$fieldlabel];
            }
            $allmodulepicklists[]=array($fieldlabel,$fieldname,$fieldtablename,$fieldcolname);
        }
        return $allmodulepicklists;
    }
    
    function retrivePicklistFromRequest()
    {
        global $adb,$app_strings,$current_language;
        $tabid=getTabid($this->reportmodule);
        $mod_strings = return_specified_module_language($current_language, $this->reportmodule);
        $fieldname=$_REQUEST['pickfieldname'];
        //$fieldlabel=$_REQUEST['pickfieldlabel'];
        $fieldtablename=$_REQUEST['pickfieldtable'];
        $fieldcolname=$_REQUEST['pickfieldcolname'];
        if($fieldname!='assign_user_id'){
            $sql="select ec_field.fieldlabel from ec_field where tabid='$tabid' and fieldname='$fieldname'";
            $result=$adb->query($sql);
            $fieldlabel=$adb->query_result($result,0,"fieldlabel");
            if(isset($mod_strings[$fieldlabel])) $fieldlabel=$mod_strings[$fieldlabel];
            elseif(isset($app_strings[$fieldlabel]))
            {
                $fieldlabel = $app_strings[$fieldlabel];
            }
        }else{
            $fieldlabel="负责人";
        }
        $this->picklistfield=array($fieldlabel,$fieldname,$fieldtablename,$fieldcolname);
        
        $this->setDefaultRequestParams();
        
        $this->iscustomreport=false;
    }
    
    function setDefaultRequestParams()
    {
        $this->type=$_REQUEST['grouptype'];
        if($this->type!='count')
        {
            $collectcolumn=$_REQUEST['grouptype'];
            $this->collectcolumnfield=explode(";", $collectcolumn);
            $this->type='sum';
        }
        
        $this->graphtype=$_REQUEST['graphtype'];
        if(empty($this->graphtype)) $this->graphtype="column";
    }
    
    function retrivePicklistFromCustom($custominf)
    {
        $this->picklistfield=$custominf[1];
        $this->picklistopts=$custominf[2];
        $this->setDefaultRequestParams();
        $this->iscustomreport=true;
    }
    
    function getModifiedGroupSQL($query)
    {
        if($this->type=='count')
        {
            return $this->getModifiedCountGroupSQL($query);
        }
        elseif($this->type=='sum')
        {
            return $this->getModifiedSumGroupSQL($query);
        }
    }
    
    function getModifiedCountGroupSQL($query)
    {
        $fieldtablename=$this->picklistfield[2];
        $fieldcolname=$this->picklistfield[3];
        $colname="$fieldtablename.$fieldcolname";
        $listquery=preg_replace('/^\s*SELECT .+? FROM/i',"SELECT $colname,count(*) as totalcountval FROM",$query);
        $listquery.=" group by $colname ";
//        echo $listquery;
        return $listquery;
    }
    
    function getModifiedSumGroupSQL($query)
    {
        $fieldtablename=$this->picklistfield[2];
        $fieldcolname=$this->picklistfield[3];
        
        $collectfieldtablename=$this->collectcolumnfield[2];
        $collectfieldcolname=$this->collectcolumnfield[3];
        $colname="$fieldtablename.$fieldcolname";
        $collectcolname="$collectfieldtablename.$collectfieldcolname";
        $listquery=preg_replace('/^\s*SELECT .+? FROM/i',"SELECT $colname,sum($collectcolname) as totalcountval FROM",$query);
        $listquery.=" group by $colname ";
//        echo $listquery;
        return $listquery;
    }
    
    function getPicklistOptions()
    {
        global $adb;
        $picklistopts=array();
        $fieldname=$this->picklistfield[1];
        if(!$this->iscustomreport){
            if($fieldname!='assign_user_id'){
				$sql = "select colvalue from ec_picklist where colname='".$fieldname."' order by sequence";
                $result=$adb->getList($sql);
				foreach($result as $row)
                {
                    $optval=$row['colvalue'];
                    $picklistopts[]=$optval;
                }
            }elseif($fieldname=='assign_user_id'){
                $useridsstr=getUserIDS();
                if($useridsstr=='()') $picklistopts=array();
                else{
                    $sql="select ec_users.user_name from ec_users where id in $useridsstr";
                    $result=$adb->getList($sql);
                    foreach($result as $row)
                    {
                        $picklistopts[]=$row['user_name'];
                    }
                }
            }
        }else{
            $picklistopts=$this->picklistopts;
        }
        return $picklistopts;
    }
    
    function getCollectColumnOpts()
    {
        global $adb;
        global $app_strings,$current_language;
        $current_module=$this->reportmodule;
        $tabid=getTabid($current_module);
        $mod_strings = return_specified_module_language($current_language, $current_module);
        $collectopts="";
        $selected="";
        if($this->type=='count') $selected="selected";
        $collectopts.="<option value='count' $selected>记录数</option>";
        
        if($this->type=='sum'){
            $selectoptval=implode(";", $this->collectcolumnfield);
        }
        $ssql = "select ec_field.* from ec_field INNER JOIN ec_def_org_field ON ec_def_org_field.fieldid=ec_field.fieldid AND ec_def_org_field.visible=0 inner join ec_tab on ec_tab.tabid = ec_field.tabid where ec_field.uitype != 50 and ec_field.tabid=".$tabid." and ec_field.displaytype = 1  union select * from ec_field where ec_field.displaytype=3 and ec_field.tabid=".$tabid."  order by sequence";
//		echo $ssql;
        $result = $adb->getList($ssql);
		foreach($result as $row)
        {
            $fieldtablename = $row["tablename"];
			$fieldcolname = $row["columnname"];
			$fieldname = $row["fieldname"];
			$fieldtype = $row["typeofdata"];
			$fieldtype = explode("~",$fieldtype);
			$fieldtypeofdata = $fieldtype[0];
			$fieldlabel = $row["fieldlabel"];
            if(isset($mod_strings[$fieldlabel])) $fieldlabel=$mod_strings[$fieldlabel];
            elseif(isset($app_strings[$fieldlabel]))
            {
                $fieldlabel = $app_strings[$fieldlabel];
            }
            $optionvalue ="$fieldlabel;$fieldname;$fieldtablename;$fieldcolname";
            $columnname=substr($fieldcolname,-2);
            if(($fieldtype[0] == "N" || $fieldtype[0] == "NN" || $fieldtype[0] == "I") && $columnname != "id")
            {
                $selected="";
                if($this->type=='sum'&&$optionvalue==$selectoptval)
                {
                    $selected="selected";
                }
                $collectopts.="<option value='$optionvalue' $selected>$fieldlabel</option>";
            }
        }
        return $collectopts;
    }
    
    function getPicklistGroupInf($query)
    {
        global $adb;
        $fieldcolname=$this->picklistfield[3];
        $picklistcount=array();
        $numtotalval=0;
        $picklistcount['INVAILDOPTS']=0;
        $groupsql=$this->getModifiedGroupSQL($query);
        $result=$adb->getList($groupsql);
        $picklistopts=$this->getPicklistOptions();
		foreach($result as $row)
        {
            $colval=$row[$fieldcolname];
            $numval=$row['totalcountval'];
            if(!is_numeric($numval)) $numval=0;
            if(in_array($colval,$picklistopts))
            {
                $picklistcount[$colval]=$numval;
            }else
            {
                $picklistcount['INVAILDOPTS']+=$numval;
            }
            $numtotalval+=$numval;
        }
        return array($picklistopts,$picklistcount,$numtotalval);
        
    }
    
    function getCollectFieldLabel()
    {
        if($this->type=='count') return "记录数";
        else{
            return $this->collectcolumnfield[0];
        }
    }
    
    function getPicklistDataHTML($picklistinf)
    {
        list($picklistopts,$picklistcount,$numtotalval)=$picklistinf;
        $fieldlabel=$this->picklistfield[0];
        $collectfieldlabel=$this->getCollectFieldLabel();
        $reportData = '<table width="97%" border="1" cellspacing="0" cellpadding="0" class="reportTable" baseFont="宋体">
            <tr><td  class="thead">'.$fieldlabel.' 选项</td><td  class="thead">'.$collectfieldlabel.'</td></tr>';	
        foreach($picklistopts as $opt)
        {
            $numval=$picklistcount[$opt];
            if(!isset($numval)) $numval=0;
            $reportData .='<tr><td  class="thead">'.$opt.'</td><td  class="thead">'.$numval.'</td></tr>';
        }
        if($picklistcount['INVAILDOPTS']>0) $reportData .= '<tr><td  class="thead">非标准的选项</td><td  class="thead">'.$picklistcount['INVAILDOPTS'].'</td></tr>';
        $reportData .= '<tr><td  class="thead">合计</td><td  class="thead">'.$numtotalval.'</td></tr>';
        $reportData .= '</table>';
        return $reportData;
        
    }
    /*
    function getPicklistDataHTML2($picklistinf)
    {
        list($picklistopts,$picklistcount,$numtotalval)=$picklistinf;
        $reportData = '<table width="97%" border="1" cellspacing="0" cellpadding="0" class="reportTable">
            <tr><td  class="thead"></td>';	
        foreach($picklistopts as $opt)
        {
            $reportData .='<td  class="thead">'.$opt.'</td>';
        }
        if($picklistcount['INVAILDOPTS']>0) $reportData .= '<td  class="thead">其它的选项</td></tr>';
        $reportData .= '<td  class="thead">合计</td></tr><tr><td  class="thead"></td>';
        
    }
     * */
    
   function getPicklistChartHTML($picklistinf)
    {
        $graphtype=$this->graphtype;
        $graphfuncname="getPicklistChartHTML_$graphtype";
        if(method_exists($this, $graphfuncname))
        {
            return $this->$graphfuncname($picklistinf);
        }
        return "";
    }
    /*
    function getChartParams($picklistinf)
    {
        $fileContents="";
        $title=$this->getTitle();
        $title=str_replace("%", "%25", $title);
        $xAxisName=$this->picklistfield[0];
        $xAxisName=str_replace("%", "%25", $xAxisName);
        $addtionchartattr="";
        if(strpos($this->graphtype,"Pie")!==false)
        {
            $addtionchartattr="showValues='1' ";
        }else{
            $addtionchartattr="showValues='1' ";
        }
        $fileContents.="<chart caption='$title' xAxisName='{$xAxisName}' yAxisName='总计' formatNumberScale='0' $addtionchartattr >";
        list($picklistopts,$picklistcount,$numtotalval)=$picklistinf;
        foreach($picklistopts as $opt)
        {
            $numval=$picklistcount[$opt];
            if(!isset($numval)) $numval=0;
            $fileContents.="<set label='$opt' value='$numval' />";
        }
        $fileContents.="</chart>";
//        echo htmlentities($fileContents,ENT_QUOTES,"UTF-8");
        return array($fileContents,700,500);
    }
    
    function getPicklistChartHTML_vertical3D($picklistinf)
    {
        list($chartxml,$width,$height)=$this->getChartParams($picklistinf);
        $return = renderChartHTML("include/fusioncharts/Charts/FCF_Column3D.swf","",$chartxml,"reportChart",$width,$height);
        return $return;
    }
    
    function getPicklistChartHTML_vertical2D($picklistinf)
    {
        list($chartxml,$width,$height)=$this->getChartParams($picklistinf);
        $return = renderChartHTML("include/fusioncharts/Charts/FCF_Column2D.swf","",$chartxml,"reportChart",$width,$height);
        return $return;
    }
    
    function getPicklistChartHTML_Line2D($picklistinf)
    {
        list($chartxml,$width,$height)=$this->getChartParams($picklistinf);
        $return = renderChartHTML("include/fusioncharts/Charts/FCF_Line.swf","",$chartxml,"reportChart",$width,$height);
        return $return;
    }
    
    function getPicklistChartHTML_Pie3D($picklistinf)
    {
        list($chartxml,$width,$height)=$this->getChartParams($picklistinf);
        $return = renderChartHTML("include/fusioncharts/Charts/FCF_Pie3D.swf","",$chartxml,"reportChart",$width,$height);
        return $return;
    }
    
    function getPicklistChartHTML_Pie2D($picklistinf)
    {
        list($chartxml,$width,$height)=$this->getChartParams($picklistinf);
        $return = renderChartHTML("include/fusioncharts/Charts/FCF_Pie2D.swf","",$chartxml,"reportChart",$width,$height);
        return $return;
    }
    */


    function getSingleCustomReportInf($basefile,$showinreport)
    {
        $modulename=$this->reportmodule;
        $reportfile="modules/{$modulename}/Reports/$basefile.php";
        if(file_exists($reportfile))
        {
            include($reportfile);
        }
        if(is_array($returnval))
        {
            return $returnval;
        }
        return null;
    }
    
    function getAllModReportInf()
    {
        $modulename=$this->reportmodule;
        $dirname="modules/{$modulename}/Reports";
        $allreturnval=array();
        if(is_dir($dirname))
        {
            $thddir=dir($dirname);
            while(($entry=$thddir->read())!==false)
            {
                if(is_file($dirname."/".$entry)&&  preg_match('/\.php$/', $entry))
                {
                    $basefile=basename($entry,".php");
                    $returnval=$this->getSingleCustomReportInf($basefile, false);
                    if(is_array($returnval)){
                        $returnval[]=$basefile;
                        $allreturnval[]=$returnval;
                    }
                }
            }
        }
        usort($allreturnval, "reportparamscmp");
        return $allreturnval;
    }
    
}

function reportparamscmp($a,$b)
{
    if($a[0][0]==$b[0][0])
    {
        return 0;
    }
    return ($a[0][0] < $b[0][0]) ? -1 : 1;
}
?>
