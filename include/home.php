<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/
global $current_user;
require_once('include/utils/ListViewUtils.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');
require_once('include/utils/CommonUtils.php');

class Homestuff
{
	var $userid;
	var $dashdetails=Array();	
	function Homestuff()
	{}
	//add stuff
	function addStuff()
	{
		 global $adb;
		 global $current_user;
		 global $current_language;
		 $dashbd_strings = return_module_language($current_language, "Dashboard"); 
		 $stuffid=$adb->getUniqueId('ec_homestuff');
		 $queryseq="select min(stuffsequence) from ec_homestuff";
		 $sequence=$adb->query_result($adb->query($queryseq),0,'min(stuffsequence)')-1;
		 if($this->defaulttitle != "")
		 	$this->stufftitle = $this->defaulttitle;
		 $query="insert into ec_homestuff values($stuffid,$sequence,'".$this->stufftype."',".$current_user->id.",0,'".$this->stufftitle."')"; 
		 $result=$adb->query($query);
		 if(!$result)
		 {
			return false;
		 }
		 if($this->stufftype=="Module")
		 {
			 $fieldarray=explode(",",$this->fieldvalue);
			 $querymod="insert into ec_homemodule values($stuffid,'".$this->selmodule."',".$this->maxentries.",".$this->selFiltername.",'".$this->selmodule."')";
			 $result=$adb->query($querymod);
			if(!$result)
		 	{
				return false;
		 	}
			for($q=0;$q<sizeof($fieldarray);$q++)
			{
				$queryfld="insert into ec_homemoduleflds values($stuffid,'".$fieldarray[$q]."')";
				$result=$adb->query($queryfld);
			}
			if(!$result)
		 	{
				return false;
		 	}
		 }
		 else if($this->stufftype=="RSS")
		 {
			$queryrss="insert into ec_homerss values($stuffid,'".$this->txtRss."',".$this->maxentries.")";
	       		$resultrss=$adb->query($queryrss);
			if(!$resultrss)
			{
				return false;
			}		
		 }
		  else if($this->stufftype=="DashBoard")
		 {
			$querydb="insert into ec_homedashbd values($stuffid,'".$this->seldashbd."','".$this->seldashtype."')";
	       		$resultdb=$adb->query($querydb);
			if(!$resultdb)
			{
				return false;
			}		
		 }
		  else if($this->stufftype=="Default")
		 {
			$querydef="insert into ec_homedefault values($stuffid,'".$this->defaultvalue."')";
	       		$resultdef=$adb->query($querydef);
			if(!$resultdef)
			{
				return false;
			}		
		 }
	 		return "loadAddedDiv($stuffid,'".$this->stufftype."')";
	}
	//add stuff
	function getHomePageFrame()
	{
		global $adb;
		global $current_user;
		$homeval = array();
		$querystuff ="select ec_homestuff.* from ec_homestuff where visible=0 and userid=".$current_user->id." order by stuffsequence";
		$resultstuff=$adb->query($querystuff);
		$rownum = $adb->num_rows($resultstuff);
		if($rownum > 0) {		
			for($i=0;$i<$rownum;$i++)
			{
				
				$stuffid = $adb->query_result($resultstuff,$i,'stuffid');
				$stufftype = $adb->query_result($resultstuff,$i,'stufftype');
				//$stufftitle = $adb->query_result($resultstuff,$i,'stufftitle');
				if($stufftype != "" && is_file("portlets/".$stufftype.".php")) {
					$stuff_title = "";
					$stuff_width = "";
					if(is_file("portlets/".$stufftype.".config.php")) {
						require("portlets/".$stufftype.".config.php");
						$stuff_title = $portlet_title;
						$stuff_width = $portlet_width;
					}
					$homeval[]=Array('Stuffid'=>$stuffid,'Stufftype'=>$stufftype,'Stufftitle'=>$stuff_title,'Width'=>$stuff_width);
				}
			}
		} else {
			$querydefault ="select ec_homedefault.* from ec_homedefault order by stuffsequence";
			$resultdefault = $adb->query($querydefault);
			$rownumdefault = $adb->num_rows($resultdefault);
			if($rownumdefault > 0) {		
				for($i=0;$i<$rownumdefault;$i++)
				{
					$stufftype = $adb->query_result($resultdefault,$i,'stufftype');					
					$stuffid = $adb->getUniqueId('ec_homestuff');
					$queryseq = "select min(stuffsequence) from ec_homestuff";
					$sequence = $adb->query_result($adb->query($queryseq),0,'min(stuffsequence)')-1;
					$query="insert into ec_homestuff values($stuffid,$sequence,'".$stufftype."',".$current_user->id.",0,'')"; 
					$adb->query($query);
					if($stufftype != "" && is_file("portlets/".$stufftype.".php")) {
						$stuff_title = "";
						$stuff_width = "";
						if(is_file("portlets/".$stufftype.".config.php")) {
							require("portlets/".$stufftype.".config.php");
							$stuff_title = $portlet_title;
							$stuff_width = $portlet_width;
						}
						$homeval[]=Array('Stuffid'=>$stuffid,'Stufftype'=>$stufftype,'Stufftitle'=>$stuff_title,'Width'=>$stuff_width);
					}
				}
			}
		}
		$homeframe=$homeval;
		return $homeframe;
	}

	function getSelectedStuff()
	{
		global $adb;
		global $current_user;
		$homeval = array();
		$querystuff ="select ec_homestuff.* from ec_homestuff where visible=0 and userid=".$current_user->id." order by stuffsequence";
		$resultstuff=$adb->query($querystuff);
		$rownum = $adb->num_rows($resultstuff);
		if($rownum > 0) {		
			for($i=0;$i<$rownum;$i++)
			{
				
				$stuffid = $adb->query_result($resultstuff,$i,'stuffid');
				$stufftype = $adb->query_result($resultstuff,$i,'stufftype');
				if($stufftype != "" && is_file("portlets/".$stufftype.".php")) {					
					$homeval[]= $stufftype;
				}
			}
		}
		return $homeval;
	}

	function getHomePageStuff($sid,$stuffType)
	{
		global $adb;
		global $current_user;
		$header=Array();
		if($stuffType=="Module")
			$details=$this->getModuleFilters($sid);
		else if($stuffType=="RSS")
			$details=$this->getRssDetails($sid);
		else if($stuffType=="DashBoard")
			{$details=$this->getDashDetails($sid);}
		else if($stuffType=="Default")
			$details=$this->getDefaultDetails($sid,'');
		return $details;
	}
	Private function getModuleFilters($sid)
	{
		global $adb,$current_user;
		$querycvid="select ec_homemoduleflds.fieldname,ec_homemodule.* from ec_homemoduleflds left join ec_homemodule on ec_homemodule.stuffid=ec_homemoduleflds.stuffid where ec_homemoduleflds.stuffid=".$sid;
		$resultcvid=$adb->query($querycvid);
		$modname=$adb->query_result($resultcvid,0,"modulename");
		$cvid=$adb->query_result($resultcvid,0,"customviewid");
		$maxval=$adb->query_result($resultcvid,0,"maxentries");
		$column_count = $adb->num_rows($resultcvid);
		$cvid_check_query = $adb->pquery("SELECT * FROM ec_customview WHERE cvid = '$cvid'");
		if(isPermitted($modname,'index') == "yes")
		{	
			if($adb->num_rows($cvid_check_query)>0)
			{
				if($modname == 'Calendar')
				{
					require_once("modules/Calendar/Activity.php");
					$focus = new Activity();
				}
				else
				{	
					require_once("modules/$modname/$modname.php");
					$focus = new $modname();
				}
				$oCustomView = new CustomView($modname);
				$listquery = getListQuery($modname);
				if(trim($listquery) == '')
					$listquery = $focus->getListQuery($modname);
				$query = $oCustomView->getModifiedCvListQuery($cvid,$listquery,$modname);
				$count_result = $adb->query(mkCountQuery( $query));
				$noofrows = $adb->query_result($count_result,0,"count");
				$navigation_array = getNavigationValues(1, $noofrows, $maxval);
				//To get the current language file
				global $current_language,$app_strings;
				$fieldmod_strings = return_module_language($current_language, $modname);
				
				if($modname == 'Calendar')
					$query .= "AND ec_activity.activitytype NOT IN ('Emails')";
				
				if( $adb->dbType == "pgsql")
					$list_result = $adb->query($query. " OFFSET 0 LIMIT ".$maxval);
				else
					$list_result = $adb->query($query. " LIMIT 0,".$maxval);
		
				for($l=0;$l < $column_count;$l++)
				{
					$fieldinfo = $adb->query_result($resultcvid,$l,"fieldname");
					list($tabname,$colname,$fldname,$fieldmodlabel) = explode(":",$fieldinfo);
					//For Header starts
					
					$fieldheader=explode("_",$fieldmodlabel,2);
					$fldlabel=$fieldheader[1];
					$pos=strpos($fldlabel,"_");
					if($pos==true)
					$fldlabel=str_replace("_"," ",$fldlabel);
					$field_label = isset($app_strings[$fldlabel])?$app_strings[$fldlabel]:(isset($fieldmod_strings[$fldlabel])?$fieldmod_strings[$fldlabel]:$fldlabel);
					$cv_presence = $adb->query("SELECT * from ec_cvcolumnlist WHERE cvid = $cvid and columnname LIKE '%".$fldname."%'");
					if($is_admin == false){
						$fld_permission = getFieldVisibilityPermission($modname,$current_user->id,$fldname);
					}
					if($fld_permission == 0 && $adb->num_rows($cv_presence)){ 
						$field_query = $adb->query("SELECT fieldlabel FROM ec_field WHERE fieldname = '$fldname' AND tablename = '$tabname'");
						$field_label = $adb->query_result($field_query,0,'fieldlabel');
						$header[] = $field_label;
					}
					$fieldcolumns[$fldlabel] = Array($tabname=>$colname);
					//For Header ends
				}
				$listview_entries = getListViewEntries($focus,$modname,$list_result,$navigation_array,"","","EditView","Delete",$oCustomView,'HomePage',$fieldcolumns);
				$return_value =Array('ModuleName'=>$modname,'cvid'=>$cvid,'Maxentries'=>$maxval,'Header'=>$header,'Entries'=>$listview_entries);
				if(sizeof($header)!=0)
		       		return $return_value;
		       	else
		       		echo "Fields not found in Selected Filter";
			}
			else
				echo "<font color='red'>Filter You have Selected is Not Found</font>";
 		}
		else
			echo "<font color='red'>Permission Denied</font>";
	}

	Private function getRssDetails($rid)
	{
		if(isPermitted('Rss','index') == "yes"){
			require_once('modules/Rss/Rss.php');
			global $adb;
			$qry="select * from ec_homerss where stuffid=".$rid;
			$res=$adb->query($qry);
			$url=$adb->query_result($res,0,"url");
			$maxval=$adb->query_result($res,0,"maxentries");
			$oRss = new vtigerRSS();
			if($oRss->setRSSUrl($url))
			{
				$rss_html = $oRss->getListViewHomeRSSHtml($maxval);
	
			}else
			{
				$rss_html = "<strong>".$mod_strings['LBL_ERROR_MSG']."</strong>";
			}
			$return_value=Array('Maxentries'=>$maxval,'Entries'=>$rss_html);
		}
		else
			echo "<font color='red'>Not Accessible</font>";
		return $return_value;	
	}

	function getDashDetails($did,$chart='')
	{
		global $adb;
		$qry="select * from ec_homedashbd where stuffid=".$did;
		$result=$adb->query($qry);
		$type=$adb->query_result($result,0,"dashbdname");
		$charttype=$adb->query_result($result,0,"dashbdtype");
		$dash=Array('DashType'=>$type,'Chart'=>$charttype);
		$this->dashdetails[$did]=$dash;
		$from_page='HomePage';
		if($chart=='') return $this->getdisplayChart($type,$charttype,$from_page);
		else return $dash;
		
	}
	Private function getdisplayChart($type,$Chart_Type,$from_page)
	{
		require_once('modules/Dashboard/homestuff.php');
		$return_dash=dashboardDisplayCall($type,$Chart_Type,$from_page);
		return $return_dash;
	}
	Private function getDefaultDetails($dfid,$calCnt)
	{
		global $adb;
		$qry="select * from ec_homedefault where stuffid=".$dfid;
		$result=$adb->query($qry);
		$maxval=$adb->query_result($result,0,"maxentries");
		$hometype=$adb->query_result($result,0,"hometype");
		
		if($hometype=="ALVT")
		{
			include_once("modules/Accounts/ListViewTop.php");	
			$home_values = getTopAccounts($maxval,$calCnt);
		}
		elseif($hometype=="HDB")
		{
			if(isPermitted('Dashboard','index') == "yes")
			{
				//$home_values['Dashboard']="true";
			}
		}
		elseif($hometype=="PLVT")
		{
			if(isPermitted('Potentials','index') == "yes")
        		{
				 include_once("modules/Potentials/ListViewTop.php");
				 $home_values=getTopPotentials($maxval,$calCnt);
			}	
		}
		elseif($hometype=="QLTQ")
		{
			if(isPermitted('Quotes','index') == "yes")
        		{
				require_once('modules/Quotes/ListTopQuotes.php');
				$home_values=getTopQuotes($maxval,$calCnt);
			}	
		}
		elseif($hometype=="HLT")
		{
			if(isPermitted('HelpDesk','index') == "yes")
		        {
				require_once('modules/HelpDesk/ListTickets.php');
				$home_values=getMyTickets($maxval,$calCnt);
			}	
		}
		elseif($hometype=="GRT")
		{
			//$home_values = getGroupTaskLists($maxval,$calCnt);	
		}
		elseif($hometype=="OLTSO")
		{
			if(isPermitted('SalesOrder','index') == "yes")
        		{
				require_once('modules/SalesOrder/ListTopSalesOrder.php');
				$home_values=getTopSalesOrder($maxval,$calCnt);
			}	
		}
		elseif($hometype=="ILTI")
		{
			if(isPermitted('Invoice','index') == "yes")
        		{
				require_once('modules/Invoice/ListTopInvoice.php');
				$home_values=getTopInvoice($maxval,$calCnt);
			}	
		}
		elseif($hometype=="MNL")
		{
			if(isPermitted('Leads','index') == "yes")
        		{
				 include_once("modules/Leads/ListViewTop.php");
				 $home_values=getNewLeads($maxval,$calCnt);
			}	
		}
		elseif($hometype=="OLTPO")
		{
			if(isPermitted('PurchaseOrder','index') == "yes")
        		{
				require_once('modules/PurchaseOrder/ListTopPurchaseOrder.php');
				$home_values=getTopPurchaseOrder($maxval,$calCnt);
			}	
		}
		elseif($hometype=="LTFAQ")
		{
			if(isPermitted('Faq','index') == "yes")
		        {
				require_once('modules/Faq/ListFaq.php');
				$home_values=getMyFaq($maxval,$calCnt);
			}	
		}
		elseif($hometype=="CVLVT")
		{
			include_once("modules/CustomView/ListViewTop.php");
			$home_values = getKeyMetrics();
		}
		if($calCnt == 'calculateCnt')
			return $home_values;
		$return_value = Array();
		if(count($home_values) > 0)
			$return_value=Array('Maxentries'=>$maxval,'Details'=>$home_values);
		return $return_value;

	}

}


?>
