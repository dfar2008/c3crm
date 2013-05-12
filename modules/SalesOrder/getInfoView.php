<?php
require_once('modules/SalesOrder/SalesOrder.php');
require_once('include/utils/utils.php');

$rel_focus = new SalesOrder();
global $adb,$current_user;
global $currentModule;

$type = $_REQUEST["type"];

$record = $_REQUEST["record"];

if(!$type || $type == '' ){
	echo '';die;
}
$infohtml = '<table class="dvtContentSpace" style="border-top: 1px solid rgb(222, 222, 222);" width="100%" border="0">
<tbody><tr><td style="padding:5px;">';
if($type == 'ProductsInfo'){

	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%" border="0" cellpadding="3" cellspacing="1">


      <tr style="height: 20px;">

        <td class="lvtCol2"  nowrap>产品编号</td>

        <td class="lvtCol2" nowrap>产品名称</td>

        <td class="lvtCol2" nowrap>购买数量</td>

        <td class="lvtCol2" nowrap>价格</td>

         <td class="lvtCol2" nowrap>商品URL</td>

      </tr>';

	 if(!empty($record)){
	   $relorderinfo = $rel_focus->getProductsInfo($record);

	   if($relorderinfo && $relorderinfo != ''){
		  $i = 1;
          foreach($relorderinfo as $productinfo){
				  $infohtml .= '<tr bgcolor="white">
					            <td nowrap>'.$productinfo['productcode'].'</td>
								<td nowrap>'.$productinfo['productname'].'</td>
								<td nowrap>'.$productinfo['quantity'].'</td>
								<td nowrap>'.$productinfo['price'].'</td>
								<td nowrap>'.$productinfo['detail_url'].'</td>
								</tr>';
				 $i++;
		  }
	   }
	}
    $infohtml .= '</table>';
}else{
	$infohtml .= '';
}
$infohtml .= '</td></tr></tbody></table>';
echo $infohtml;
exit();

?>