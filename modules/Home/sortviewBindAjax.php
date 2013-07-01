<?php
global $app_strings,$adb,$current_user;
$sortview = $_REQUEST['sortview'];
$modname = $_REQUEST['modname'];
$entityname = getModTabName($modname);
if(!$entityname || empty($entityname)){
	echo '';die;
}
if($sortview == 'view_assort'){
	$key = "view_assort_{$modname}_".$current_user->id;
	//$treeproj = getSqlCacheData($key);
	if(!$treeproj) {
		if($modname == 'Contacts'){
			$modname = 'Accounts';
			$entityname = getModTabName("Accounts");
		}
		$query = "select fieldid,columnname,fieldlabel from ec_field where 
					tabid = {$entityname['tabid']} and uitype in (15,16,111) "; 
		$result = $adb->getList($query);
		$numrows = $adb->num_rows($result);
		$treeproj = array();
		$tree["treeid"] = 'tree';
		$tree["treename"] = $app_strings["Category"];
		$tree["click"] = '';
		$tree["treeparent"] = '-1';
		$treeproj[] = $tree;
		if($numrows > 0){
			$mod_strings = return_specified_module_language("zh_cn",$modname);
			for($i=0;$i<$numrows;$i++){
				$fieldid = $adb->query_result($result,$i,"fieldid");
				$columnname = $adb->query_result($result,$i,"columnname");
				$fieldlabel = $adb->query_result($result,$i,"fieldlabel");
				if($app_strings[$fieldlabel]){
					$fieldtitle = $app_strings[$fieldlabel];
				}else if($mod_strings[$fieldlabel]){
					$fieldtitle = $mod_strings[$fieldlabel];
				}else{
					$fieldtitle = $fieldlabel;
				}
				$tree = array();
				$tree["treeid"] = $fieldid;
				$tree["treename"] = $fieldtitle;
				$tree["click"] = '';
				$tree["treeparent"] = 'tree';
				$treeproj[] = $tree;
				// if($columnname == 'account_type'){
				// 	$colname = "accounttype";
				// }else{
				// 	$colname = $columnname;
				// }
				$colname = $columnname;
				$picksql = "select colvalue from ec_picklist where colname = '{$colname}' order by sequence ";
				$pickresult = $adb->getList($picksql);
				$pickrows = $adb->num_rows($pickresult);
				if($pickrows && $pickrows > 0){
					for($j=0;$j<$pickrows;$j++){
						$colvalue = $adb->query_result($pickresult,$j,"colvalue");
						$tree = array();
						$tree["treeid"] = $colvalue;
						$tree["treename"] = $colvalue;
						$tree["click"] = "search_field={$entityname['tablename']}.{$columnname}&
											search_text={$colvalue}&sortview={$sortview}";
						$tree["treeparent"] = $fieldid;
						$treeproj[] = $tree;
					}
				}
			}
		}
		setSqlCacheData($key,$treeproj);
	}
}else if($sortview == 'view_area'){
	$key = "view_area_{$modname}_".$current_user->id;
	$treeproj = getSqlCacheData($key);
	if(!$treeproj) {
		$query = "select actualfieldid,actualfieldname,parentfieldid,thelevel 
					from ec_bill_country where actualfieldname not in ('нч') 
				and actualfieldid not in (408,409,410) order by sortorderid ";
		$result = $adb->getList($query);
		$numrows = $adb->num_rows($result);
		$treeproj = array();
		if($numrows && $numrows > 0){
			for($i=0;$i<$numrows;$i++){
				$actualfieldid = $adb->query_result($result,$i,"actualfieldid");
				$actualfieldname = $adb->query_result($result,$i,"actualfieldname");
				$parentfieldid = $adb->query_result($result,$i,"parentfieldid");
				$thelevel = $adb->query_result($result,$i,"thelevel");
				if($actualfieldname == 'нч'){
					continue;
				}
				if($parentfieldid == '0'){
					$parentfieldid = '-1';
				}
				if($thelevel == '1'){
					$fldname = 'ec_account.bill_country';
				}else if($thelevel == '2'){
					$fldname = 'ec_account.bill_state';
				}else if($thelevel == '3'){
					$fldname = 'ec_account.bill_city';
				}
				$tree = array();
				$tree["treeid"] = $actualfieldid;
				$tree["treename"] = $actualfieldname;
				$tree["click"] = "search_field={$fldname}&search_text={$actualfieldname}&sortview={$sortview}";
				$tree["treeparent"] = $parentfieldid;
				$treeproj[] = $tree;
			}
		}
		setSqlCacheData($key,$treeproj);
	}
}
require_once("include/Zend/Json.php");
$json = new Zend_Json();
$jsontree = $json->encode($treeproj);
echo $jsontree;
?>