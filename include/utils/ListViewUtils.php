<?php
require_once('include/database/PearDatabase.php');
require_once('include/utils/CommonUtils.php'); //new
function AlphabeticalSearch($module,$action,$fieldname,$query,$type,$popuptype='',$recordid='',$return_module='',$append_url='',$viewid='',$groupid='',$selectedval="")
{
	global $log;
	$log->debug("Entering AlphabeticalSearch() method ...");
	$flag = "";
	$returnvalue = "";
	$list = "";
	$popuptypevalue = "";
	if($type=='advanced')
		$flag='&advanced=true';

	if($popuptype != '')
		$popuptypevalue = "&popuptype=".$popuptype;

        if($recordid != '')
                $returnvalue = '&recordid='.$recordid;
        if($return_module != '')
                $returnvalue .= '&return_module='.$return_module;

	//change by renzhen for save the search information
	for($var='A',$i =1;$i<=26;$i++,$var++)
	{
		if($var==$selectedval){
			$list .= '<td class="searchAlphselected" id="alpha_'.$i.'" align="center" onClick=\'alphabetic("'.$module.'","gname='.$groupid.'&query='.$query.'&search_field='.$fieldname.'&searchtype=BasicSearch&type=alpbt&search_text='.$var.$flag.$popuptypevalue.$returnvalue.$append_url.'","alpha_'.$i.'")\'>'.$var.'</td>';
		}else{
	// Mike Crowe Mod --------------------------------------------------------added groupid to url
			$list .= '<td class="searchAlph" id="alpha_'.$i.'" align="center" onClick=\'alphabetic("'.$module.'","gname='.$groupid.'&query='.$query.'&search_field='.$fieldname.'&searchtype=BasicSearch&type=alpbt&search_text='.$var.$flag.$popuptypevalue.$returnvalue.$append_url.'","alpha_'.$i.'")\'>'.$var.'</td>';
		}
	}

	$log->debug("Exiting AlphabeticalSearch method ...");
	return $list;
}
/**This function is used to get the list view header values in a list view
*Param $focus - module object
*Param $module - module name
*Param $sort_qry - sort by value
*Param $sorder - sorting order (asc/desc)
*Param $order_by - order by
*Param $relatedlist - flag to check whether the header is for listvie or related list
*Param $oCv - Custom view object
*Returns the listview header values in an array
*/
function getListViewHeader($focus, $module,$sort_qry='',$sorder='',$order_by='',$relatedlist='',$oCv='',$relatedmodule='')
{
	global $log,$adb,$singlepane_view;
	$log->debug("Entering getListViewHeader() method ...");
	global $theme;
	global $app_strings;
	global $mod_strings;
	global $current_language;
	$current_module_strings = return_module_language($current_language,$module);
	$arrow='';
	$qry = getURLstring($focus);
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$list_header = Array();

	//Get the ec_tabid of the module
	$tabid = getTabid($module);
	//added for ec_customview 27/5
	if($oCv != "" && $oCv)
	{
		if(isset($oCv->list_fields))
		{
			$focus->list_fields = $oCv->list_fields;
			$focus->list_fields_name = $oCv->list_fields_name;
		}
	}
	//modified for ec_customview 27/5 - $app_strings change to $mod_strings
	foreach($focus->list_fields as $name=>$tableinfo)
	{
		//added for ec_customview 27/5
		$fieldname = $focus->list_fields_name[$name]; 
				$change_sorder = array('ASC'=>'DESC','DESC'=>'ASC');
				$arrow_gif = array('ASC'=>'arrow_down.gif','DESC'=>'arrow_up.gif');
				
				foreach($focus->list_fields[$name] as $tab=>$col)
				{
					//changed by dingjianting on 2007-3-11 for all fields can be sorted
						if($order_by == $col)
						{
							$temp_sorder = $change_sorder[$sorder];
							$arrow = "<img src ='".$image_path.$arrow_gif[$sorder]."' border='0'>";
						}
						else
						{
							$temp_sorder = 'ASC';
						}

						if(isset($current_module_strings[$name]))
						{
							$lbl_name = $current_module_strings[$name];
						}
						elseif(isset($app_strings[$name]))
						{
							$lbl_name = $app_strings[$name];
						}
						else
						{
							$lbl_name = $name;
						}
						if($relatedlist ==''){
							$name = "<a href='javascript:;' onClick='getListViewEntries_js(\"".$module."\",\"order_by=".$col."&start=".$_SESSION["lvs"][$module]["start"]."&sorder=".$temp_sorder."".$sort_qry."\");' class='listFormHeaderLinks'>".$lbl_name."&nbsp;".$arrow."</a>";
						} else {
							$name = $lbl_name;
						}							
						$arrow = '';


				//}
			//}

			$list_header[]=$name;

		}
     }
	if($module !='Qunfas' && $module !='Maillists'){
		$list_header[] = $app_strings["LBL_ACTION"];
	}

	$log->debug("Exiting getListViewHeader method ...");
	return $list_header;
}

/**This function generates the navigation array in a listview
*Param $display - start value of the navigation
*Param $noofrows - no of records
*Param $limit - no of entries per page
*Returns an array type
*/

//code contributed by raju for improved pagination
function getNavigationValues($display, $noofrows, $limit)
{
	global $log;
	$log->debug("Entering getNavigationValues() method ...");
	$navigation_array = Array();
	global $limitpage_navigation;
	if(isset($_REQUEST['allflag']) && $_REQUEST['allflag'] == 'All'){
		$navigation_array['start'] =1;
		$navigation_array['first'] = 1;
		$navigation_array['end'] = 1;
		$navigation_array['prev'] =0;
		$navigation_array['next'] =0;
		$navigation_array['end_val'] =$noofrows;
		$navigation_array['current'] =1;
		$navigation_array['allflag'] ='Normal';
		$navigation_array['verylast'] =1;
		$log->debug("Exiting getNavigationValues method ...");
		return $navigation_array;
	}
	if($noofrows != 0 && $display != 0) {
		$start = ((($display * $limit) - $limit)+1);
	}
	else
	$start = 0;
	//added by dingjiantiing on 2007-12-10 for display_errors
	$last = '';

	$end = $start + ($limit-1);
	if($end > $noofrows)
	{
		$end = $noofrows;
	}
	$paging = ceil ($noofrows / $limit);
	// Display the navigation
	if ($display > 1) {
		$previous = $display - 1;
	}
	else {
		$previous=0;
	}
	if($noofrows < $limit)
	{
		$first = '';
	}
	elseif ($noofrows != $limit) {
		$last = $paging;
		$first = 1;
		if ($paging > $limitpage_navigation) {
			$first = $display-floor(($limitpage_navigation/2));
			if ($first<1) $first=1;
			$last = ($limitpage_navigation - 1) + $first;
		}
		if ($last > $paging ) {
			$first = $paging - ($limitpage_navigation - 1);
			$last = $paging;
		}
	}
	if ($display < $paging) {
		$next = $display + 1;
	}
	else {
		$next=0;
	}
	$navigation_array['start'] = $start;
	$navigation_array['first'] = $first;
	$navigation_array['end'] = $last;
	$navigation_array['prev'] = $previous;
	$navigation_array['next'] = $next;
	$navigation_array['end_val'] = $end;
	$navigation_array['current'] = $display;
	$navigation_array['allflag'] ='All';
	$navigation_array['verylast'] =$paging;
	$log->debug("Exiting getNavigationValues method ...");
	return $navigation_array;

}


//End of code contributed by raju for improved pagination

/**This function generates the List view entries in a list view
*Param $focus - module object
*Param $list_result - resultset of a listview query
*Param $navigation_array - navigation values in an array
*Param $relatedlist - check for related list flag
*Param $returnset - list query parameters in url string
*Param $edit_action - Edit action value
*Param $del_action - delete action value
*Param $oCv - ec_customview object
*Returns an array type
*/

//parameter added for ec_customview $oCv 27/5
function getListViewEntries($focus, $module,$list_result,$navigation_array,$relatedlist='',$returnset='',$edit_action='EditView',$del_action='Delete',$oCv='')
{
 
	global $log;
	$log->debug("Entering getListViewEntries() method ...");
	$tabname = getParentTab();
	global $adb,$current_user;
	global $app_strings;
	$noofrows = $adb->num_rows($list_result);
	$list_block = Array();
	$tabid = getTabid($module);
	//added for ec_customview 27/5
	if($oCv)
	{
		if(isset($oCv->list_fields))
		{
			$focus->list_fields = $oCv->list_fields;
			$focus->list_fields_name = $oCv->list_fields_name;
		}
	}
	
	$key_ui = "getlistview_fieldsui_".$tabid;
	$fieldlist = getSqlCacheData($key_ui);
	if(!$fieldlist) {
		$fieldlist = array();
		$query  = "SELECT DISTINCT ec_field.fieldname,ec_field.columnname,ec_field.uitype FROM ec_field
			       LEFT JOIN ec_def_org_field ON ec_def_org_field.fieldid = ec_field.fieldid
			       WHERE ec_field.tabid = ".$tabid." AND (ec_def_org_field.visible = 0 or ec_field.displaytype=3) ";
		$result = $adb->query($query);
		$rownum = $adb->num_rows($result);
		$field=Array();
		for($k=0;$k < $rownum;$k++)
		{
			$columnname = $adb->query_result($result,$k,"columnname");
			$uitype = $adb->query_result($result,$k,"uitype");
			$fieldlist[$columnname] = $uitype;
		}
		setSqlCacheData($key_ui,$fieldlist);
	}
	if($navigation_array['start'] !=0)
	for ($i=1; $i<=$noofrows; $i++)
	//for ($i=$navigation_array['start']; $i<=$navigation_array['end_val']; $i++)
	{
		$list_header =Array();
		//Getting the entityid
		$entity_id = $adb->query_result($list_result,$i-1,"crmid"); 
		foreach($focus->list_fields as $name=>$tableinfo)
		{
			$fieldname = $focus->list_fields_name[$name];
			$tableinfo = array_values($tableinfo);
			$columnname = $tableinfo[0];
			$list_result_count = $i-1;
			$uitype = $fieldlist[$columnname];
			$value = getValue($uitype,$list_result,$columnname,$focus,$module,$entity_id,$list_result_count,"list","",$returnset);
			$list_header[] = $value;
		}

		$varreturnset = '';
		if($returnset=='')
			$varreturnset = '&return_module='.$module.'&return_action=index';
		else
			$varreturnset = $returnset;
		$links_info ='';

		if($module !='Qunfas' && $module !='Maillists'){
			//Added for Actions ie., edit and delete links in listview
			$edit_link = getListViewEditLink($module,$entity_id,$relatedlist,$varreturnset,$list_result,$list_result_count);
			$del_link = getListViewDeleteLink($module,$entity_id,$relatedlist,$varreturnset);
           
            //added by ligangze 2013-08-06
            if(($module=='Memdays'|| $module=='Contacts') && $relatedlist=='relatedlist'){
                $links_info .= "<a href=\"#\" role=\"button\" data-toggle=\"modal\" onclick='editAccountRelInfo(\"$edit_link\")'>&nbsp;<i class=\"cus-pencil\"></i> </a>";
            }else{
			$links_info .= "<a href=\"$edit_link\" title=\"".$app_strings["LNK_EDIT"]."\"> &nbsp;<i class=\"cus-pencil\"></i> </a> ";//".$app_strings["LNK_EDIT"]."
            }
			if($del_link != '')
			$links_info .=	" | <a href='javascript:confirmdelete(\"$del_link\")'> <img src=\"themes/bootcss/img/del.gif\" border=0 title=\"".$app_strings["LNK_DELETE"]."\"> </a>";//".."
			$list_header[] = $links_info;
		}
		
		$list_block[$entity_id] = $list_header;

	}
	$log->debug("Exiting getListViewEntries method ...");
   // var_dump($list_block);exit;
	return $list_block;

}

/**This function generates the List view entries in a popup list view
*Param $focus - module object
*Param $list_result - resultset of a listview query
*Param $navigation_array - navigation values in an array
*Param $relatedlist - check for related list flag
*Param $returnset - list query parameters in url string
*Param $edit_action - Edit action value
*Param $del_action - delete action value
*Param $oCv - ec_customview object
*Returns an array type
*/


function getSearchListViewEntries($focus, $module,$list_result,$navigation_array,$oCv='')
{
	global $log;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getSearchListViewEntries() method ...");
	global $adb,$current_user;
	$noofrows = $adb->num_rows($list_result);
	$list_header = '';
	$list_block = Array();
	//getting the ec_fieldtable entries from database
	$tabid = getTabid($module);
	if($oCv != "" && $oCv)
	{
		if(isset($oCv->list_fields))
		{
			$focus->search_fields = $oCv->list_fields;
			$focus->search_fields_name = $oCv->list_fields_name;
		}
	}
	
	$key_ui = "getlistview_fieldsui_".$tabid;
	$fieldlist = getSqlCacheData($key_ui);
	if(!$fieldlist) {
		$fieldlist = array();
		$query  = "SELECT DISTINCT ec_field.fieldname,ec_field.columnname,ec_field.uitype FROM ec_field
			       LEFT JOIN ec_def_org_field ON ec_def_org_field.fieldid = ec_field.fieldid
			       WHERE ec_field.tabid = ".$tabid." AND (ec_def_org_field.visible = 0 or ec_field.displaytype=3) ";
		$result = $adb->query($query);
		$rownum = $adb->num_rows($result);
		$field=Array();
		for($k=0;$k < $rownum;$k++)
		{
			$columnname = $adb->query_result($result,$k,"columnname");
			$uitype = $adb->query_result($result,$k,"uitype");
			$fieldlist[$columnname] = $uitype;
		}
		setSqlCacheData($key_ui,$fieldlist);
	}
	if($navigation_array['end_val'] > 0)
	{
		for ($i=1; $i<=$noofrows; $i++)
		{
			$entity_id = $adb->query_result($list_result,$i-1,"crmid");
			$list_header=Array();
			foreach($focus->search_fields as $name=>$tableinfo)
			{

				$fieldname = $focus->search_fields_name[$name];
				$tableinfo = array_values($tableinfo);
				$columnname = $tableinfo[0];
				$value = "";
				if($columnname != '')
				{
					$list_result_count = $i-1;
					$uitype = $fieldlist[$columnname];
					$value = getValue($uitype,$list_result,$columnname,$focus,$module,$entity_id,$list_result_count,"search",$focus->popup_type);
				}
				$list_header[] = $value;
			}
			$list_block[$entity_id]=$list_header;
		}
	}
	$log->debug("Exiting getSearchListViewEntries method ...");
	return $list_block;
}


/**This function generates the value for a given ec_field namee
*Param $field_result - ec_field result in array
*Param $list_result - resultset of a listview query
*Param $fieldname - ec_field name
*Param $focus - module object
*Param $module - module name
*Param $entity_id - entity id
*Param $list_result_count - list result count
*Param $mode - mode type
*Param $popuptype - popup type
*Param $returnset - list query parameters in url string
*Param $viewid - custom view id
*Returns an string value
*/
function getValue($uitype, $list_result,$fieldname,$focus,$module,$entity_id,$list_result_count,$mode,$popuptype,$returnset='',$viewid='')
{
	global $log;
	global $app_strings;
	//changed by dingjianting on 2007-11-05 for php5.2.x
	$log->debug("Entering getValue() method ...");
	global $adb,$current_user;
	if($uitype == 10){
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($temp_val != "") {
			$value = "";
			$module_entityname = "";
			$modulename_lower = substr($fieldname,0,-2);
			$modulename = ucfirst($modulename_lower);
			$modulesid = $modulename_lower."id";
			$tablename = "ec_".$modulename_lower;
			$entityname = substr($fieldname,0,-3)."name";
			$query = "SELECT $entityname FROM $tablename WHERE $modulesid='".$temp_val."' and deleted=0";
			$fldmod_result = $adb->query($query);
			$rownum = $adb->num_rows($fldmod_result);
			if($rownum > 0) {
				$value = $adb->query_result($fldmod_result,0,$entityname);
			}
		} else {
			$value = '';
		}
	}
	elseif($uitype == 52 || $uitype == 53 || $uitype == 77)
	{
		$value = $adb->query_result($list_result,$list_result_count,'user_name');
	}
	elseif($uitype == 5 || $uitype == 6 || $uitype == 23 || $uitype == 70)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if(isValidDate($temp_val))
		{
			$value = getDisplayDate($temp_val);
		}
		else
		{
			$value = '';
		}
	}
	elseif($uitype == 33)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		$value = str_ireplace(' |##| ',', ',$temp_val);
	}
	elseif($uitype == 17)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		$value = '<a href="http://'.$temp_val.'" target="_blank">'.$temp_val.'</a>';
	}
	elseif($uitype == 13 || $uitype == 104)
    {
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		//$value = '<a href="'.getComposeMailUrl($temp_val).'" target="_blank">'.$temp_val.'</a>';
		$value='<a href="index.php?module=Maillists&action=ListView&idstring='.$entity_id.'&modulename='.$module.'" target="main">'.$temp_val.'</a>';
	}
	elseif($uitype == 56)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($temp_val == 1)
		{
			$value = 'yes';
		}
		else
		{
			$value = 'no';
		}
		//changed by dingjianting on 2006-10-15 for simplized chinese
		if(isset($app_strings[$value])) $value = $app_strings[$value];
	}
	elseif($uitype == 51  || $uitype == 73  || $uitype == 50)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($temp_val != '') {
			$value = getAccountName($temp_val);
            //if($module=="Notes")  //added by ligangze on 2013-09-30
            $value = '<a href="index.php?action=DetailView&module=Accounts&record='.$temp_val.'&parenttab=Customer" target="_blank">'.$value.'</a>';
		} else {
			$value='';
		}
	}
	elseif($uitype == 59)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($temp_val != '')
		{
			$value = getProductName($temp_val);
		}
		else
		{
			$value = '';
		}
	}
	
	elseif($uitype == 76)
    {
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($temp_val != '')
        {
			$value = getPotentialName($temp_val);
		}
		else
			$value='';
    }
	
	elseif($uitype == 80)
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($temp_val != '')
		{

			$value = getSoName($temp_val);
		}
		else
			$value='';
	}
	

	//added by dingjianting on 2007-9-24 for smcreator shown in listview
	elseif($uitype == 1004) //display creator in editview page
	{
		$value = $adb->query_result($list_result,$list_result_count,'smcreatorid');
		$value = getUserName($value);
	}
	//added by dingjianting on 2007-9-24 for smcreator shown in listview
	elseif($uitype == 1004) //display creator in editview page
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		$value = getUserName($temp_val);
	}
	//added by dingjianting on 2007-9-24 for approvedby shown in listview
	elseif($uitype == 1008) //display approvedby in listview page
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		$value = getUserName($temp_val);
	}
	else
	{
		$temp_val = $adb->query_result($list_result,$list_result_count,$fieldname);
		if($fieldname != $focus->list_link_field)
		{
			
			if($fieldname =='phone' || $fieldname =='contactmobile'){
				$value='<a href="index.php?module=Qunfas&action=ListView&idstring='.$entity_id.'&modulename='.$module.'" target="main">'.$temp_val.'</a>';
			}else{
				$value = $temp_val;
			}
		}
		else {
			if($mode == "list") {
			    $tabname = getParentTab();
				$value = '<a href="index.php?action=DetailView&module='.$module.'&record='.$entity_id.'&parenttab='.$tabname.'">'.$temp_val.'</a>';
			}
			elseif($mode == "search")
			{
				if($popuptype == "specific")
				{
					$temp_val = str_replace("'",'\"',$temp_val);
					$temp_val = popup_from_html($temp_val);

					//Added to avoid the error when select SO from Invoice through AjaxEdit
					if($module == 'Salesorders')
						$value = '<a href="javascript:window.close();" onclick=\'set_return_specific("'.$entity_id.'", "'.br2nl($temp_val).'","'.$_REQUEST['form'].'");\'>'.$temp_val.'</a>';
					else
						$value = '<a href="javascript:window.close();" onclick=\'set_return_specific("'.$entity_id.'", "'.br2nl($temp_val).'");\'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "detailview")
				{
					$temp_val = popup_from_html($temp_val);

					$focus->record_id = $_REQUEST['recordid'];
					if($_REQUEST['return_module'] == "Calendar")
					{
						$value = '<a href="javascript:window.close();" id="calendarCont'.$entity_id.'" LANGUAGE=javascript onclick=\'add_data_to_relatedlist_incal("'.$entity_id.'","'.$temp_val.'");\'>'.$temp_val.'</a>';
					}
					else
						$value = '<a href="javascript:window.close();" onclick=\'add_data_to_relatedlist("'.$entity_id.'","'.$focus->record_id.'","'.$module.'");\'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "formname_specific")
				{
					$temp_val = popup_from_html($temp_val);
					$value = '<a href="javascript:window.close();" onclick=\'set_return_formname_specific("'.$_REQUEST['form'].'", "'.$entity_id.'", "'.br2nl($temp_val).'");\'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "inventory_prod")//select only one products
				{
					$row_id = $_REQUEST['curr_row'];

					//To get all the tax types and values and pass it to product details
					$tax_str = '';

					$unitprice=$adb->query_result($list_result,$list_result_count,'unit_price');
					$qty_stock=$adb->query_result($list_result,$list_result_count,'qtyinstock');
					$productcode = $adb->query_result($list_result,$list_result_count,'productcode');

					$temp_val = popup_from_html($temp_val);
					$value = '<a href="javascript:window.close();" onclick=\'set_return_inventory("'.$entity_id.'", "'.br2nl($temp_val).'", "'.$unitprice.'", "'.$qty_stock.'","'.$tax_str.'","'.$row_id.'","'.$productcode.'");\'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "inventory_prods")//select multi products once
				{

					$unitprice =$adb->query_result($list_result,$list_result_count,'unit_price');
					$qty_stock=$adb->query_result($list_result,$list_result_count,'qtyinstock');
					$productcode = $adb->query_result($list_result,$list_result_count,'productcode');
					$serialno = $adb->query_result($list_result,$list_result_count,'serialno');
					$temp_val = popup_from_html($temp_val);
					$value = $temp_val.'<input type="hidden" name="productname_'.$entity_id.'" id="productname_'.$entity_id.'" value="'.$temp_val.'"><input type="hidden" name="listprice_'.$entity_id.'" id="listprice_'.$entity_id.'" value="'.$unitprice.'"><input type="hidden" name="qtyinstock_'.$entity_id.'" id="qtyinstock_'.$entity_id.'" value="'.$qty_stock.'"><input type="hidden" id="productcode_'.$entity_id.'" name="productcode_'.$entity_id.'" value="'.$productcode.'"><input type="hidden" id="serialno_'.$entity_id.'" name="serialno_'.$entity_id.'" value="'.$serialno.'">';
				}
				elseif($popuptype == "salesorder_prod")
				{
					$row_id = $_REQUEST['curr_row'];
					$unitprice=$adb->query_result($list_result,$list_result_count,'unit_price');
					$temp_val = popup_from_html($temp_val);
					$producttype = $_REQUEST['producttype'];
					$value = '<a href="javascript:window.close();" onclick=\'set_return_inventory_so("'.$entity_id.'", "'.br2nl($temp_val).'", "'.$unitprice.'", "'.$row_id.'","'.$producttype.'");\'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "inventory_prod_po")
				{
					$row_id = $_REQUEST['curr_row'];
					$unitprice=$adb->query_result($list_result,$list_result_count,'unit_price');
					$productcode = $adb->query_result($list_result,$list_result_count,'productcode');

					$temp_val = popup_from_html($temp_val);
					$value = '<a href="javascript:window.close();" onclick=\'set_return_inventory_po("'.$entity_id.'", "'.br2nl($temp_val).'", "'.$unitprice.'", "'.$productcode.'","'.$row_id.'"); \'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "inventory_prod_noprice")
				{
					$row_id = $_REQUEST['curr_row'];
					$temp_val = popup_from_html($temp_val);
					$qtyinstock = $adb->query_result($list_result,$list_result_count,'qtyinstock');
					$productcode = $adb->query_result($list_result,$list_result_count,'productcode');
					$value = '<a href="javascript:window.close();" onclick=\'set_return_inventory_noprice("'.$entity_id.'", "'.br2nl($temp_val).'","'.$row_id.'","'.$qtyinstock.'","'.$productcode.'");\'>'.$temp_val.'</a>';
				}
				elseif($popuptype == "inventory_prod_check")
				{
					$row_id = $_REQUEST['curr_row'];
					$temp_val = popup_from_html($temp_val);
					$productcode = $adb->query_result($list_result,$list_result_count,'productcode');
					$usageunit = $adb->query_result($list_result,$list_result_count,'usageunit');
					$qtyinstock = $adb->query_result($list_result,$list_result_count,'qtyinstock');
					$value = '<a href="javascript:window.close();" onclick=\'set_return_inventory_check("'.$entity_id.'", "'.br2nl($temp_val).'","'.$row_id.'","'.$productcode.'","'.$usageunit.'","'.$qtyinstock.'"); \'>'.$temp_val.'</a>';
				}

				elseif($popuptype == "specific_account_address")
				{
					require_once('modules/Accounts/Accounts.php');
					$acct_focus = new Accounts();
					$acct_focus->retrieve_entity_info($entity_id,"Accounts");

					$temp_val = popup_from_html($temp_val);
					$value = '<a href="javascript:window.close();" onclick=\'set_return_address("'.$entity_id.'", "'.br2nl($temp_val).'", "'.br2nl($acct_focus->column_fields['bill_street']).'", "'.br2nl($acct_focus->column_fields['ship_street']).'", "'.br2nl($acct_focus->column_fields['bill_city']).'", "'.br2nl($acct_focus->column_fields['ship_city']).'", "'.br2nl($acct_focus->column_fields['bill_state']).'", "'.br2nl($acct_focus->column_fields['ship_state']).'", "'.br2nl($acct_focus->column_fields['bill_code']).'", "'.br2nl($acct_focus->column_fields['ship_code']).'", "'.br2nl($acct_focus->column_fields['bill_country']).'", "'.br2nl($acct_focus->column_fields['ship_country']).'","'.br2nl($acct_focus->column_fields['bill_pobox']).'", "'.br2nl($acct_focus->column_fields['ship_pobox']).'");\'>'.$temp_val.'</a>';

				}
				elseif($popuptype == "specific_contact_account_address")
				{
					require_once('modules/Accounts/Accounts.php');
					$acct_focus = new Accounts();
					$acct_focus->retrieve_entity_info($entity_id,"Accounts");

					$temp_val = popup_from_html($temp_val);
					$value = '<a href="javascript:;" onclick=\'set_return_contact_address("'.$entity_id.'", "'.br2nl($temp_val).'", "'.br2nl($acct_focus->column_fields['bill_street']).'", "'.br2nl($acct_focus->column_fields['ship_street']).'", "'.br2nl($acct_focus->column_fields['bill_city']).'", "'.br2nl($acct_focus->column_fields['ship_city']).'", "'.br2nl($acct_focus->column_fields['bill_state']).'", "'.br2nl($acct_focus->column_fields['ship_state']).'", "'.br2nl($acct_focus->column_fields['bill_code']).'", "'.br2nl($acct_focus->column_fields['ship_code']).'", "'.br2nl($acct_focus->column_fields['bill_country']).'", "'.br2nl($acct_focus->column_fields['ship_country']).'","'.br2nl($acct_focus->column_fields['bill_pobox']).'", "'.br2nl($acct_focus->column_fields['ship_pobox']).'");\'>'.$temp_val.'</a>';

				}
				elseif($popuptype == "specific_potential_account_address")
				{
					$acntid = $adb->query_result($list_result,$list_result_count,"accountid");
					if($acntid != "") {
						//require_once('modules/Accounts/Accounts.php');
						//$acct_focus = new Accounts();
						//$acct_focus->retrieve_entity_info($acntid,"Accounts");
						$account_name = getAccountName($acntid);

						$temp_val = popup_from_html($temp_val);
						$value = '<a href="javascript:window.close();" onclick=\'set_return_address("'.$entity_id.'", "'.br2nl($temp_val).'", "'.$acntid.'", "'.br2nl($account_name).'");\'>'.$temp_val.'</a>';
					} else {
						$temp_val = popup_from_html($temp_val);
						$value = '<a href="javascript:window.close();" >'.$temp_val.'</a>';
					}

				}
				//added by rdhital/Raju for better emails
				elseif($popuptype == "set_return_emails")
				{
					$name=$adb->query_result($list_result,$list_result_count,"lastname");
					$emailaddress=$adb->query_result($list_result,$list_result_count,"email");
					if($emailaddress == '')
						$emailaddress=$adb->query_result($list_result,$list_result_count,"msn");
					$where = isset($_REQUEST['where'])?$_REQUEST['where']:"";
					$value = '<a href="javascript:;" onclick=\'return set_return_emails("'.$where.'","'.$name.'","'.$emailaddress.'"); \'>'.$name.'</a>';


				}
				elseif($popuptype == "set_return_mobiles")
				{
						//$firstname=$adb->query_result($list_result,$list_result_count,"first_name");
						$contactname=$adb->query_result($list_result,$list_result_count,"lastname");
						$mobile=$adb->query_result($list_result,$list_result_count,"mobile");
						//changed by dingjianting on 2006-11-9 for simplized chinese
						$value = '<a href="#" onclick=\'return set_return_mobiles('.$entity_id.',"'.$contactname.'","'.$mobile.'"); \'>'.$contactname.'</a>';
				}
				elseif($popuptype == "set_return_usermobiles")
				{
						//$firstname=$adb->query_result($list_result,$list_result_count,"first_name");
						$lastname=$adb->query_result($list_result,$list_result_count,"last_name");
						$mobile=$adb->query_result($list_result,$list_result_count,"phone_mobile");
						//changed by dingjianting on 2006-11-9 for simplized chinese
						$value = '<a href="#" onclick=\'return set_return_mobiles('.$entity_id.',"'.$lastname.'","'.$mobile.'"); \'>'.$lastname.'</a>';
				}
				
				else
				{
					$temp_val = str_replace("'",'\"',$temp_val);
					$temp_val = popup_from_html($temp_val);
					$value = '<a href="javascript:window.close();" onclick=\'set_return("'.$entity_id.'", "'.br2nl($temp_val).'");\'>'.$temp_val.'</a>';
				}
			}

		}

	}
	$log->debug("Exiting getValue method ...");
	return $value;
}

/** Function to get the list query for a module
  * @param $module -- module name:: Type string
  * @param $where -- where:: Type string
  * @returns $query -- query:: Type query
  */
function getListQuery($module,$where='',$isSearchAll=false)
{	
	global $log;
	$log->debug("Entering getListQuery() method ...");
		$tab_id = getTabid($module);
		if($module == "Accounts")
		{	
			//Query modified to sort by assigned to
			$query = "SELECT  ec_account.accountid as crmid,ec_users.user_name,ec_account.*
				FROM ec_account
				LEFT JOIN ec_users
					ON ec_users.id = ec_account.smownerid
				
				WHERE ec_account.deleted = 0";
		}
		elseif($module == "Notes")
		{
			$query = "SELECT ec_notes.notesid as crmid,ec_users.user_name,ec_notes.*
				FROM ec_notes
				LEFT JOIN ec_account
					ON ec_account.accountid = ec_notes.accountid
				LEFT JOIN ec_users
					ON ec_users.id = ec_notes.smownerid
				WHERE ec_notes.deleted = 0";
				
		}
		elseif($module == "Products")
		{
			$query = "SELECT ec_products.productid as crmid, ec_products.*
				FROM ec_products
			    WHERE ec_products.deleted = 0";
				
		}
		elseif($module == "SalesOrder")
		{
			//Query modified to sort by assigned to
					$query = "SELECT ec_salesorder.salesorderid as crmid,ec_users.user_name,
				ec_salesorder.*,ec_account.accountname
				FROM ec_salesorder
				LEFT OUTER JOIN ec_account
					ON ec_account.accountid = ec_salesorder.accountid
				LEFT JOIN ec_users
					ON ec_users.id = ec_salesorder.smownerid
				WHERE ec_salesorder.deleted = 0";
			
		}

		elseif($module == "Users")
		{
			$query = "select id,user_name,roleid,first_name,last_name,email1,phone_mobile,phone_work,is_admin,status from ec_users inner join ec_user2role on ec_user2role.userid=ec_users.id where deleted=0 ";
		}
		//*changed by xiaoyang on 2012-09-14  start
		elseif($module == "Memdays")
		{
			//Query modified to sort by assigned to
					$query = "SELECT ec_memdays.memdaysid as crmid,ec_users.user_name,			
				ec_memdays.* FROM ec_memdays
				LEFT JOIN ec_users
					ON ec_users.id = ec_memdays.smownerid
				LEFT JOIN ec_account 
					ON ec_memdays.accountid=ec_account.accountid
				WHERE ec_memdays.deleted = 0";
			
		}
		$is_admin = $_SESSION['crm_is_admin'];
		$module_arr = array("Accounts","Notes","SalesOrder","Memdays");
		if(in_array($module,$module_arr))
		{
			if(!$is_admin)
			{
				$query .=  " and ec_users.id = '".$_SESSION['authenticated_user_id']."'";
			}
		}
		//*end
		

	$query = $query.$where;
	$log->debug("Exiting getListQuery method ...");
	return $query;
}

/**Function to get the table headers for a listview
*Param $navigation_arrray - navigation values in array
*Param $url_qry - url string
*Param $module - module name
*Param $action- action file name
*Param $viewid - view id
*Returns an string value
*/


function getTableHeaderNavigation($navigation_array, $url_qry,$module='',$action_val='index',$viewid='',$isShow=true)
{
	global $log;
	$log->debug("Entering getTableHeaderNavigation() method ...");
	global $theme;
	global $app_strings,$list_max_entries_per_page;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$output = '';
	if($isShow) {
		$output .= '<select name="listpagesize" id="listpagesize" class="pull-right" style="height:20px;width:55px;" onchange="getListViewWithPageSize(\''.$module.'\',this)">';
		$pagesize_array = array(10,15,20,30,40,50,100,200);
		foreach ($pagesize_array as $pagesize) {
			if ($pagesize != $list_max_entries_per_page){
				$output .= '<option value="'.$pagesize.'">'.$pagesize.'</option>';
			} else {
				$output .= '<option selected value="'.$pagesize.'">'.$pagesize.'</option>';
			}
		}
		$output .= '</select>';
		$output .= '<small class="pull-right" style="color:#999999;">&nbsp;&nbsp;'.$app_strings['LBL_PAGESIZE'].'&nbsp;&nbsp;</small>';
	}

	
	if($navigation_array['first'] != '') {
		//$output = '<td style="padding-right:20px">';
		$output .= '<ul class="pull-right">';

		/*    //commented due to usablity conflict -- Philip
		$output .= '<a href="index.php?module='.$module.'&action='.$action_val.$url_qry.'&start=1&viewname='.$viewid.'&allflag='.$navigation_array['allflag'].'" >'.$navigation_array['allflag'].'</a>&nbsp;';
		*/
		if(($navigation_array['prev']) != 0)
		{
			$output .= '<li><a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'start=1\');" title="'.$app_strings['LBL_FIRST'].'"><<</a></li>';
			$output .= '<li><a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'start='.$navigation_array['prev'].'\');" title="'.$app_strings['LBL_PREVIOUS'].'"><</a></li>';
		}
		else
		{
			$output .= '<li><a href="javascript:void(0);" style="font-size:14px;"><<</a></li>';
			$output .= '<li><a href="javascript:void(0);" style="font-size:14px;"><</a></li>';
		}
		for ($i=$navigation_array['first'];$i<=$navigation_array['end'];$i++){
			if ($navigation_array['current']==$i){
				$output .='<li><a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'start='.$i.'\');" ><b><font color=red>'.$i.'</font></b></a></li>';
			}
			else{
				$output .= '<li><a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'start='.$i.'\');" >'.$i.'</a></li>';
			}
		}
		if(($navigation_array['next']) !=0)
		{
			$output .= '<li><a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'start='.$navigation_array['next'].'\');" title="'.$app_strings['LBL_NEXT'].'">></a></li>';
			$output .= '<li><a href="javascript:;" onClick="getListViewEntries_js(\''.$module.'\',\'start='.$navigation_array['verylast'].'\');" title="'.$app_strings['LBL_LAST'].'">>></a></li>';
		}
		else
		{
			$output .= '<li><a href="javascript:void(0);" style="font-size:14px;">></a></li>';
			$output .= '<li><a href="javascript:void(0);" style="font-size:14px;">>></a></li>';
		}
		/*
		$output .= '&nbsp;<select name="listviewpage" id="listviewpage" class="small" onchange="getListViewWithPageNo(\''.$module.'\',this)">';
		for ($i=1;$i<=$navigation_array['verylast'];$i++){
			if ($navigation_array['current'] != $i){
				$output .= '<option value="'.$i.'">'.$app_strings['LBL_PAGENO'].$i.$app_strings['LBL_PAGE'].'</option>';
			} else {
				$output .= '<option selected value="'.$i.'">'.$app_strings['LBL_PAGENO'].$i.$app_strings['LBL_PAGE'].'</option>';
			}
		}
		$output .= '</select>';
		*/
		$output .= '</ul>';
	}
	//when isShow , show pagesize dropdown list on list page on 2010-11-25
	
	//$output .= '</td>';
	$log->debug("Exiting getTableHeaderNavigation method ...");

	return $output;
}

/**This function return the entity ids that need to be excluded in popup listview for a given record
Param $currentmodule - modulename of the entity to be selected
Param $returnmodule - modulename for which the entity is assingned
Param $recordid - the record id for which the entity is assigned
Return type string.
*/

function getRelCheckquery($currentmodule,$returnmodule,$recordid)
{
	global $log;
	$log->debug("Entering getRelCheckquery() method ...");
	global $adb;
	$skip_id = Array();
	$where_relquery = "";
	$reltable = "";
	if($reltable != null)
		$query = "SELECT ".$selectfield." FROM ".$reltable." ".$condition;
	if($query !='')
	{
		$result = $adb->query($query);
		if($adb->num_rows($result)!=0)
		{
			for($k=0;$k < $adb->num_rows($result);$k++)
			{
				$skip_id[]=$adb->query_result($result,$k,$selectfield);
			}
			$skipids = constructList($skip_id,'INTEGER');
			$where_relquery = "and ".$table.".".$field." not in ".$skipids;
		}
	}
	$log->debug("Exiting getRelCheckquery method ...");
	return $where_relquery;
}

/**This function stores the variables in session sent in list view url string.
*Param $lv_array - list view session array
*Param $noofrows - no of rows
*Param $max_ent - maximum entires
*Param $module - module name
*Param $related - related module
*Return type void.
*/

function setSessionVar($lv_array,$noofrows,$max_ent,$module='',$related='')
{
	global $currentModule;
	$start = '';
	if($noofrows>=1)
	{
		$lv_array['start']=1;
		$start = 1;
	}
	elseif($related!='' && $noofrows == 0)
	{
	        $lv_array['start']=1;
	        $start = 1;
	}
	else
	{
		$lv_array['start']=0;
		$start = 0;
	}

	if(isset($_REQUEST['start']) && $_REQUEST['start'] !='')
	{
		$lv_array['start'] = $_REQUEST['start'];
		$start = $_REQUEST['start'];
	} else {
		//changed by dingjianting on 2007-8-17 for many pages problem posted by free users
		if(isset($_SESSION['lvs'][$currentModule]['start']) && $_SESSION['lvs'][$currentModule]['start'] !='')
		{
			$lv_array['start'] = $_SESSION['lvs'][$currentModule]['start'];
			$start = $_SESSION['lvs'][$currentModule]['start'];
		}
	}
	if(isset($_REQUEST['viewname']) && $_REQUEST['viewname'] != '') {
		$lv_array['viewname']=$_REQUEST['viewname'];
	}
	if($related == '') {
		$_SESSION['lvs'][$currentModule] = $lv_array;
	}
	else {
		$_SESSION['rlvs'][$module][$related] = $lv_array;
	}

	if ($start !='' && $start > ceil($noofrows / $max_ent))
	{
		$start = ceil ($noofrows / $max_ent);
		if($related == '') {
			$_SESSION['lvs'][$currentModule]['start'] = $start;
		}
	}
}

/**Function to get the table headers for related listview
*Param $navigation_arrray - navigation values in array
*Param $url_qry - url string
*Param $module - module name
*Param $action- action file name
*Param $viewid - view id
*Returns an string value
*/

//Temp function to be be deleted
function getRelatedTableHeaderNavigation($navigation_array, $url_qry,$module='',$action_val='',$viewid='')
{
	global $log, $singlepane_view;
	$log->debug("Entering getTableHeaderNavigation() method ...");
	global $theme;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$output = '<td align="right" style="padding="5px;">';
	if($singlepane_view == 'true')
		$action_val = 'DetailView';
	else
		$action_val = 'CallRelatedList';
	if(($navigation_array['prev']) != 0)
	{
		$output .= '<a href="index.php?module='.$module.'&action='.$action_val.$url_qry.'&start=1&viewname='.$viewid.'" title="First"><img src="'.$image_path.'start.gif" border="0" align="absmiddle"></a>&nbsp;';
		$output .= '<a href="index.php?module='.$module.'&action='.$action_val.$url_qry.'&start='.$navigation_array['prev'].'&viewname='.$viewid.'"><img src="'.$image_path.'previous.gif" border="0" align="absmiddle"></a>&nbsp;';

	}
	else
	{
		$output .= '<img src="'.$image_path.'start_disabled.gif" border="0" align="absmiddle">&nbsp;';
		$output .= '<img src="'.$image_path.'previous_disabled.gif" border="0" align="absmiddle">&nbsp;';
	}
	for ($i=$navigation_array['first'];$i<=$navigation_array['end'];$i++){
		if ($navigation_array['current']==$i){
			$output .='<b>'.$i.'</b>&nbsp;';
		}
		else{
			$output .= '<a href="index.php?module='.$module.'&action='.$action_val.$url_qry.'&start='.$i.'&viewname='.$viewid.'" >'.$i.'</a>&nbsp;';
		}
	}
	if(($navigation_array['next']) !=0)
	{
			$output .= '<a href="index.php?module='.$module.'&action='.$action_val.$url_qry.'&start='.$navigation_array['next'].'&viewname='.$viewid.'"><img src="'.$image_path.'next.gif" border="0" align="absmiddle"></a>&nbsp;';
			$output .= '<a href="index.php?module='.$module.'&action='.$action_val.$url_qry.'&start='.$navigation_array['verylast'].'&viewname='.$viewid.'"><img src="'.$image_path.'end.gif" border="0" align="absmiddle"></a>&nbsp;';
	}
	else
	{
		$output .= '<img src="'.$image_path.'next_disabled.gif" border="0" align="absmiddle">&nbsp;';
		$output .= '<img src="'.$image_path.'end_disabled.gif" border="0" align="absmiddle">&nbsp;';
	}
	$output .= '</td>';
		$log->debug("Exiting getTableHeaderNavigation method ...");
		if($navigation_array['first']=='')
		return;
		else
		return $output;
}

/**	Function to get the Edit link details for ListView and RelatedListView
 *	@param string 	$module 	- module name
 *	@param int 	$entity_id 	- record id
 *	@param string 	$relatedlist 	- string "relatedlist" or may be empty. if empty means ListView else relatedlist
 *	@param string 	$returnset 	- may be empty in case of ListView. For relatedlists, return_module, return_action and return_id values will be passed like &return_module=Accounts&return_action=CallRelatedList&return_id=10
 *	return string	$edit_link	- url string which cotains the editlink details (module, action, record, etc.,) like index.php?module=Accounts&action=EditView&record=10
 */
function getListViewEditLink($module,$entity_id,$relatedlist,$returnset,$result,$count)
{
	global $adb;
	$return_action = "index";
    if(($module=="Memdays"||$module=="Contacts") && $relatedlist=="relatedlist"){//added by ligangze
        $edit_link = "index.php?module=$module&action=PopupEditView&record=$entity_id";
    }else{
	$edit_link = "index.php?module=$module&action=EditView&record=$entity_id";
    }
	//This is relatedlist listview
	if($relatedlist == 'relatedlist')
	{
		$edit_link .= $returnset;
	}
	else
	{
		$edit_link .= "&return_module=$module&return_action=$return_action";
	}
	$parenttab = "";
	if(isset($_REQUEST["parenttab"])) {
		$parenttab = $_REQUEST["parenttab"];
	}

	$edit_link .= "&parenttab=".$parenttab;
	//Appending view name while editing from ListView
	if(isset($_SESSION['lvs'][$module]["viewname"])) {
		$edit_link .= "&return_viewname=".$_SESSION['lvs'][$module]["viewname"];
	}
	return $edit_link;
}

/**	Function to get the Del link details for ListView and RelatedListView
 *	@param string 	$module 	- module name
 *	@param int 	$entity_id 	- record id
 *	@param string 	$relatedlist 	- string "relatedlist" or may be empty. if empty means ListView else relatedlist
 *	@param string 	$returnset 	- may be empty in case of ListView. For relatedlists, return_module, return_action and return_id values will be passed like &return_module=Accounts&return_action=CallRelatedList&return_id=10
 *	return string	$del_link	- url string which cotains the editlink details (module, action, record, etc.,) like index.php?module=Accounts&action=Delete&record=10
 */
function getListViewDeleteLink($module,$entity_id,$relatedlist,$returnset)
{
	$current_module = $_REQUEST['module'];
	$viewname = '';
	if(isset($_SESSION['lvs'][$current_module]['viewname'])) {
		$viewname = $_SESSION['lvs'][$current_module]['viewname'];
	}


	if($module == "Calendar")
		$return_action = "ListView";
	else
		$return_action = "index";

	//This is added to avoid the del link in Product related list for the following modules
	$avoid_del_links = Array("PurchaseOrder","SalesOrder","Quotes","Invoice");

	if($current_module == 'Products' && in_array($module,$avoid_del_links))
	{
		return '';
	}

	$del_link = "index.php?module=$module&action=Delete&record=$entity_id";

	//This is added for relatedlist listview
	if($relatedlist == 'relatedlist')
	{
		$del_link .= $returnset;
	}
	else
	{
		$del_link .= "&return_module=$module&return_action=$return_action";
	}
	$parenttab = "";
	if(isset($_REQUEST["parenttab"])) {
		$parenttab = $_REQUEST["parenttab"];
	}

	$del_link .= "&parenttab=".$parenttab."&return_viewname=".$viewname;

	return $del_link;
}

function getListViewViewLink($module,$entity_id)
{
	$view_link = "index.php?module=$module&action=DetailView&record=$entity_id";
	$parenttab = "";
	if(isset($_REQUEST["parenttab"])) {
		$parenttab = $_REQUEST["parenttab"];
	}
	$view_link .= "&parenttab=".$parenttab;
	return $view_link;
}
/**This function is used to get the list view header in popup
*Param $focus - module object
*Param $module - module name
*Param $sort_qry - sort by value
*Param $sorder - sorting order (asc/desc)
*Param $order_by - order by
*Returns the listview header values in an array
*/

function getSearchListViewHeader($focus, $module,$sort_qry='',$sorder='',$order_by='',$oCv='')
{
	global $log;
	$log->debug("Entering getSearchListViewHeader() method ...");
	global $adb;
	global $current_user,$theme,$mod_strings;
	$arrow='';
	$list_header = Array();
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";
	$tabid = getTabid($module);
	if($oCv != "" && $oCv)
	{
		if(isset($oCv->list_fields))
		{
			$focus->search_fields = $oCv->list_fields;
			$focus->search_fields_name = $oCv->list_fields_name;
		}
	}

	foreach($focus->search_fields as $name=>$tableinfo)
	{
		$fieldname = $focus->search_fields_name[$name];
		foreach($focus->search_fields[$name] as $tab=>$col)
		{
			if(isset($mod_strings[$name])) $name_label = $mod_strings[$name];
			else $name_label = $name;
			if($order_by == $col)
			{
					if($sorder == 'ASC')
					{
							$sorder = "DESC";
							$arrow = "<img src ='".$image_path."arrow_down.gif' border='0'>";
					 }
					else
					{
							$sorder = 'ASC';
							$arrow = "<img src ='".$image_path."arrow_up.gif' border='0'>";
					}
			}
			$name = "<a href='javascript:;' onClick=\"getListViewSorted_js('".$module."','".$sort_qry."&order_by=".$col."&sorder=".$sorder."')\" class='listFormHeaderLinks'>".$name_label."&nbsp;".$arrow."</a>";
			$arrow = '';

		}
		$list_header[]=$name;
	}
	$log->debug("Exiting getSearchListViewHeader method ...");
	return $list_header;

}
?>
