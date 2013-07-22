<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the 
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/
/*********************************************************************************
 * $Header: /advent/projects/wesat/ec_crm/sugarcrm/modules/Home/UnifiedSearch.php,v 1.4 2005/02/21 07:02:49 jack Exp $
 * Description:  TODO: To be written.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.
 * All Rights Reserved.
 * Contributor(s): ______________________________________..
 ********************************************************************************/

require_once('include/logging.php');
//require_once('modules/Home/language/en_us.lang.php');
require_once('include/database/PearDatabase.php');
require_once('modules/CustomView/CustomView.php');
require_once('include/DatabaseUtil.php');
require_once('include/CRMSmarty.php');
global $mod_strings;
global $list_max_entries_per_page;

$total_record_count = 0;

$query_string = trim($_REQUEST['query_string']);
//var_dump($query_string);
//exit();
if(isset($query_string) && $query_string != '')//preg_match("/[\w]/", $_REQUEST['query_string'])) 
{

	//module => object
	$object_array = getSearchModules();
	foreach($object_array as $curr_module=>$curr_object)
	{
		if(is_file("modules/$curr_module/$curr_object.php")) {
			require_once("modules/$curr_module/$curr_object.php");
		} else {
			unset($object_array[$curr_module]);
		}
	}

	global $adb;
	global $current_user;
	global $current_language;
	if(empty($current_language)) {
		$current_language = "zh_cn";
	}
	global $theme;
	$theme_path="themes/".$theme."/";
	$image_path=$theme_path."images/";

	$search_val = $query_string;
	$search_module = $_REQUEST['search_module'];

	 if(!(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')) getSearchModulesComboList($search_module);

	foreach($object_array as $module => $object_name)
	{
		if(isPermitted($module,"index") == "yes")
		{
			$focus = new $object_name();

			$smarty = new CRMSmarty();

			require_once("modules/$module/language/".$current_language.".lang.php");
			global $mod_strings;
			global $app_strings;

			$smarty->assign("MOD", $mod_strings);
			$smarty->assign("APP", $app_strings);
			$smarty->assign("IMAGE_PATH",$image_path);
			$smarty->assign("MODULE",$module);
			$smarty->assign("SEARCH_MODULE",$_REQUEST['search_module']);
			$smarty->assign("SINGLE_MOD",$module);
			//changed by dingjianting on 2007-1-23 for new module
			if(method_exists($focus,"getListQuery")) {
				$listquery = $focus->getListQuery('',true);//viewscope = all_to_me
			} else {
				$listquery = getListQuery($module,'',true);//viewscope = all_to_me
			}
			$oCustomView = '';

			//$oCustomView = new CustomView($module);
		
			if($search_module != '')//This is for Tag search
			{
		
				$where = getTagWhere($search_val,$current_user->id,$module);
				$search_msg =  $app_strings['LBL_TAG_SEARCH'];
				$search_msg .=	"<b>".$search_val."</b>";
			}
			else			//This is for Global search
			{
				$where = getUnifiedWhere($listquery,$module,$search_val);
				//$search_msg = $app_strings['LBL_SEARCH_RESULTS_FOR'];
				$search_msg =	"<b>".$search_val."</b>";
			}

			if($where != '')
				$listquery .= ' and ('.$where.')';
            
            //Retreiving the no of rows
            $count_result = $adb->query( mkCountQuery( $listquery));
            $noofrows = $adb->query_result($count_result,0,"count");
//			$list_result = $adb->query($listquery);
//			$noofrows = $adb->num_rows($list_result);
//
//			if($noofrows >= 1)
//				$list_max_entries_per_page = $noofrows;
			//Here we can change the max list entries per page per module
           
            $start=1;
            if(isset($_REQUEST['start'])&&$_REQUEST['start']!=''){
                $start=$_REQUEST['start'];
            }
			$navigation_array = getNavigationValues($start, $noofrows, $list_max_entries_per_page);
            $start_rec = $navigation_array['start'];
            $end_rec = $navigation_array['end_val'];
			$entityArr = getEntityTable($module);
			$tablename = $entityArr["tablename"];
            $query_order_by = $tablename.".modifiedtime";
            $sorder="desc";
            if ($start_rec == 0) 
                $limit_start_rec = 0;
            else
                $limit_start_rec = $start_rec -1;
            
            $list_result = $adb->limitQuery2($listquery,$limit_start_rec,$list_max_entries_per_page,$query_order_by,$sorder);
			$listview_header = getListViewHeader($focus,$module,"","","","global",$oCustomView);
			$listview_entries = getListViewEntries($focus,$module,$list_result,$navigation_array,"","","","",$oCustomView);
//            echo $listquery;
            $record_string= $app_strings['LBL_SHOWING']." " .$start_rec." - ".$end_rec." " .$app_strings['LBL_LIST_OF'] ." ".$noofrows;
            
			//Do not display the Header if there are no entires in listview_entries
			if(count($listview_entries) > 0)
			{
				$display_header = 1;
			}
			else
			{
				$display_header = 0;
			}
            $navigationOutput = getTableHeaderNavigation($navigation_array, "",$module,"index");
			$smarty->assign("LISTHEADER", $listview_header);
			$smarty->assign("LISTENTITY", $listview_entries);
			$smarty->assign("DISPLAYHEADER", $display_header);
			$smarty->assign("HEADERCOUNT", count($listview_header));
            $smarty->assign("NAVIGATION", $navigationOutput);
            $smarty->assign("RECORD_COUNTS", $record_string);

			$total_record_count = $total_record_count + $noofrows;

			$smarty->assign("SEARCH_CRITERIA","( $noofrows )--查找结果:".$search_msg);
			$smarty->assign("MODULES_LIST", $object_array);
            if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')
                $smarty->display("GlobalListViewEntries.tpl");
            else
                $smarty->display("GlobalListView.tpl");
			unset($_SESSION['lvs'][$module]);
		}
	}

	//Added to display the Total record count
    if(!(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != '')){
?>
	<script>
        document.getElementById("global_search_total_count").innerHTML = " <span class='label label-info'>搜索到的记录数:</span><b>&nbsp;&nbsp;<?php echo $total_record_count; ?></b>&nbsp;条";
	</script>
<?php
    }
}
else {
	echo "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>".$mod_strings['ERR_ONE_CHAR']."</em>";
}

/**	Function to get the where condition for a module based on the field table entries
  *	@param  string $listquery  -- ListView query for the module 
  *	@param  string $module     -- module name
  *	@param  string $search_val -- entered search string value
  *	@return string $where      -- where condition for the module based on field table entries
  */
function getUnifiedWhere($listquery,$module,$search_val)
{
	global $adb;

	$query = "SELECT columnname, tablename FROM ec_field WHERE tabid = ".getTabid($module);
	$result = $adb->query($query);
	$noofrows = $adb->num_rows($result);

	$where = '';
	for($i=0;$i<$noofrows;$i++)
	{
		$columnname = $adb->query_result($result,$i,'columnname');
		$tablename = $adb->query_result($result,$i,'tablename');

		//Before form the where condition, check whether the table for the field has been added in the listview query
		if(strstr($listquery,$tablename))
		{
			if($where != '')
				$where .= " OR ";
			$where .= $tablename.".".$columnname." LIKE ".$adb->quote("%$search_val%");
		}
	}

	return $where;
}

/**	Function to get the Tags where condition
  *	@param  string $search_val -- entered search string value
  *	@param  string $current_user_id     -- current user id
  *	@return string $where      -- where condition with the list of crmids, will like ec_crmentity.crmid in (1,3,4,etc.,)
  */
function getTagWhere($search_val,$current_user_id,$search_module='')
{
	require_once('include/freetag/freetag.class.php');

	$freetag_obj = new freetag();

	$crmid_array = $freetag_obj->get_objects_with_tag_all($search_val,$current_user_id);
	$entityArr = getEntityTable($search_module);
	$ec_crmentity = $entityArr["tablename"];
	$entityidfield = $entityArr["entityidfield"];
	$crmid = $ec_crmentity.".".$entityidfield;

	$where = '';
	if(count($crmid_array) > 0)
	{
		$where = $crmid." IN (";
		foreach($crmid_array as $index => $crmid)
		{
			$where .= $crmid.',';
		}
		$where = trim($where,',').')';
	}

	return $where;
}


/**	Function to get the the List of Searchable Modules as a combo list which will be displayed in right corner under the Header
  *	@param  string $search_module -- search module, this module result will be shown defaultly 
  */
function getSearchModulesComboList($search_module)
{
	global $object_array;
	global $app_strings;
	global $mod_strings;
	
	?>
        <script language="JavaScript" type="text/javascript" src="include/js/UnifiedSearch.js"></script>
		<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
		<script>
		function displayModuleList(selectmodule_view)
		{
			<?php
			foreach($object_array as $module => $object_name)
			{
				?>
				mod = "global_list_"+"<?php echo $module; ?>";
				if(selectmodule_view.options[selectmodule_view.options.selectedIndex].value == "All")
					show(mod);
				else
					hide(mod);
				<?php
			}
			?>
			
			if(selectmodule_view.options[selectmodule_view.options.selectedIndex].value != "All")
			{
				selectedmodule="global_list_"+selectmodule_view.options[selectmodule_view.options.selectedIndex].value;
				show(selectedmodule);
			}
		}
		</script>
        <input type="hidden" id="the_query_string" value="<?php echo trim($_REQUEST['query_string']);?>">
		 <table border=0 cellspacing=0 cellpadding=0 width=98% align=center>
		     <tr>
		        <td colspan="3" id="global_search_total_count" style="padding-left:30px">&nbsp;</td>
		        <td nowrap align="right">结果显示&nbsp;
		            <select id="global_search_module" name="global_search_module" onChange="displayModuleList(this);">
			            <option value="All">所有</option>
						<?php
						foreach($object_array as $module => $object_name)
						{
							$selected = '';
							if($search_module != '' && $module == $search_module)
								$selected = 'selected';
							if($search_module == '' && $module == 'All')
								$selected = 'selected';
							?>
						<option value="<?php echo $module; ?>" <?php echo $selected; ?> ><?php echo $app_strings[$module]; ?></option>
						<?php
						}
						?>
		     		</select>
		        </td>
		     </tr>
		</table>
        <div style="margin:8px 15px 5px 15px;padding-top:5px;border-top:2px solid #0088CC;"></div>
	<?php
}

/*To get the modules allowed for global search this function returns all the 
 * modules which supports global search as an array in the following structure 
 * array($module_name1=>$object_name1,$module_name2=>$object_name2,$module_name3=>$object_name3,$module_name4=>$object_name4,-----);
 */
 function getSearchModules()
 {
	 global $adb;
	 $modulenames=array();
	 if(isset($_REQUEST['selectedmodule']) && $_REQUEST['selectedmodule'] != ''){
        $modulenames=array($_REQUEST['selectedmodule']); 
     }else{
         $modulenames = array(
			"Accounts"=>"Accounts",
			"Contacts"=>"Contacts",
			"Notes"=>"Notes"
		);
//        $sql = 'select distinct ec_field.tabid,name from ec_field inner join ec_tab on ec_tab.tabid=ec_field.tabid where ec_tab.tabid not in (16,29) and ec_tab.tabid in (select distinct tabid from ec_parenttabrel)';
//	    $result = $adb->getList($sql);
//		foreach($result as $module_result)
//		{
//			$modulename = $module_result['name'];
//			$modulenames[]=$modulename;
//		}
	 }
     foreach($modulenames as $modulename)
     {
         if($modulename != 'Calendar')
		{
			$return_arr[$modulename] = $modulename;
		}else
		{
			$return_arr[$modulename] = 'Activity';
		}
     }
	
	return $return_arr;
 }

?>
