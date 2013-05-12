<?php
require_once('modules/Products/Products.php');
global $adb;
global $app_strings;
global $current_user;
$productname = $_REQUEST['productname'];
$productcode = $_REQUEST['productcode'];
$price = $_REQUEST['price'];
if($productcode != $app_strings["AUTO_GEN_CODE"]) {
	$query = "SELECT productcode FROM ec_products WHERE deleted=0 and smownerid=".$current_user->id." and productcode ='".$productcode."'";		
	$result = $adb->query($query);
	if($adb->num_rows($result) > 0)
	{
		echo "REPEAT";
		die;
	}
}


$focus = new Products();
$focus->column_fields["productname"] = $productname;
if($productcode == $app_strings["AUTO_GEN_CODE"]) {
	require_once('user_privileges/seqprefix_config.php');
	$productcode = $product_seqprefix.$focus->get_next_id();
}
//$log->info("productcode:".$productcode);
$focus->column_fields['productcode'] = $productcode;
$focus->column_fields["price"] = $price;
$focus->id = "";
$focus->mode = "";
$focus->save("Products");
$return_id = $focus->id;
echo $return_id;
die;
?>
