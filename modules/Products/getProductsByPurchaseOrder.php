<?php
require_once("include/Zend/Json.php");
global $adb;
global $app_strings;
global $current_user;
global $log;

$idlist = $_REQUEST['idlist'];
$basemodule = $_REQUEST['basemodule'];
$idlist = str_replace(";",",",$idlist);
$fieldlist = getProductFieldList($basemodule);
//$fieldlist = array("productname","productcode","serialno","unit_price","catalogname");
//$fieldlist = array("productname","productcode","serialno","unit_price");
$productlist = array();

$query = "SELECT ec_products.productid as crmid,ec_products.*,ec_catalog.catalogname,ec_vendor.vendorname FROM ec_products left join ec_catalog on ec_catalog.catalogid=ec_products.catalogid left join ec_vendor on ec_vendor.vendorid=ec_products.vendor_id WHERE ec_products.deleted=0 and ec_products.productid in (".$idlist.")";
$result = $adb->query($query);
$rownum = $adb->num_rows($result);
if($rownum > 0)
{
	for($i=0;$i<$rownum;$i++) {
		$product = array();
		$productid = $adb->query_result($result,$i,'crmid');
		$unit_price = $adb->query_result($result,$i,'cost_price');
		if($unit_price == null) $unit_price = 0;
		$product["fieldlist"] = $fieldlist;
		$product["productid"] = $productid;
		$product["listprice"] = $unit_price;
		foreach($fieldlist as $fieldname) {
			$fieldvalue = $adb->query_result($result,$i,$fieldname);
			if(strpos($fieldname,"price")) {
				$fieldvalue = convertFromDollar($fieldvalue,1);
			}
			$product[$fieldname] = $fieldvalue;
		}
		$productlist[] = $product;
		unset($product);
	}
	$json = new Zend_Json();
	$jsonproduct = $json->encode($productlist);
	$log->info($jsonproduct);
	echo $jsonproduct;

}
die;
?>