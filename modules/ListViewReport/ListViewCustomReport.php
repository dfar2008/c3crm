<?php

require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
class ListViewCustomReport{
    var $viewid;
    var $oCustomView;
    var $where;
    var $reportmodule;
    
    function ListViewCustomReport($modulename,$viewid,$oCustomView,$where)
    {
        $this->viewid=$viewid;
        $this->oCustomView=$oCustomView;
        $this->where=$where;
        $this->reportmodule=$modulename;
    }
    
    function getModifiedListQuery($query)
    {
        $list_query=$query;
        if(!empty($this->where)) $list_query .= ' and '.$this->where;
        $viewid=$this->viewid;
        $currentModule=$this->reportmodule;
        $oCustomView=$this->oCustomView;
        if($viewid != "0")
        {
            $stdfiltersql = $oCustomView->getCVStdFilterSQL($viewid);
            $advfiltersql = $oCustomView->getCVAdvFilterSQL($viewid);
            if(isset($stdfiltersql) && $stdfiltersql != '' && $stdfiltersql != '()')
            {
                $list_query .= ' and '.$stdfiltersql;
            }
            if(isset($advfiltersql) && $advfiltersql != '' && $advfiltersql != '()')
            {
                $list_query .= ' and '.$advfiltersql;
            }
//            $list_query = $oCustomView->getModifiedCvListQuery($viewid,$listquery,$currentModule);
        }
        else
        {
            $list_query =$listquery;
        }
        return $list_query;
    }
       
    function addSecurityParameter($query)
    {
        global $current_user;
        $tab_id = getTabid($this->reportmodule);
       
        return $query;
    }
}
?>
