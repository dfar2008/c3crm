<?php

require_once ('include/CRMSmarty.php');
require_once ('data/Tracker.php');
require_once ('include/utils/utils.php');
//require_once ('modules/Accounts/Accounts.php');
//require_once ('modules/Products/Products.php');
//require_once ('modules/SalesOrder/SalesOrder.php');
require_once ('user_privileges/seqprefix_config.php');
require_once ('modules/Synchronous/Synfunction.php');
require_once ('modules/Synchronous/time.php');
require_once ('modules/Synchronous/Syn_fun.php');
require_once ('modules/Synchronous/config.php');
global $adb;
global $current_user;

//$focus_pro = new Products();
//$focus_so = new SalesOrder();

//执行时间类
$timer = new timer;
$timer->start(); 

$timemessage = '';

$start_created = '';
$end_created = '';


$id = $_REQUEST['record'];
if(empty($id)){
	die("No Selected One AppKey!");
}

$query = "select * from ec_appkey where id='".$id."'";
$row = $adb->getFirstLine($query);

$appKey = $row['appkey'];
$appSecret = $row['appsecret'];
$nick = $row['nick'];
$session = $row['topsession'];

if($nick==''){
	header("Location: index.php?module=Relsettings&action=Taobaozushou&parenttab=Settings");
}

$timer->stop();  
$timemessage .="获取淘宝账号信息用时: <font color=red>".$timer->spent()."</font><br>";
$timer->start(); 

//获取淘宝订单总数
$resultcount_arr = getTaobaoOrderCount($rooturl,$session,$appKey,$appSecret,$start_created,$end_created);
if(!empty($resultcount_arr['msg'])){
	echo $resultcount_arr['msg'];
	die;
}
$resultcount = $resultcount_arr['total_results'];

$timer->stop();  
$timemessage .="获取淘宝订单总数用时: <font color=red>".$timer->spent()."</font><br>";
$timer->start(); 

if($resultcount == 0){
	echo $timemessage;
	if(!empty($syntime)){
		$start_created = $syntime;
		$end_created = date("Y-m-d H:i:s");
		$msgstr = "没有订单信息。";	
	}else{
		$msgstr = "三个月内没有订单信息。";
	}
	echo $msgstr;
	die;
}

//进度条总长度
$width = 500; 
$width8 = $width+8;

$errormess='';

echo "<script language=\"JavaScript\">
function updateProgress(sMsg, iWidth)
{ 
document.getElementById(\"prostatus\").innerHTML = sMsg;
document.getElementById(\"progress\").style.width = iWidth + \"px\";
document.getElementById(\"percent\").innerHTML = parseInt(iWidth / ".$width ."* 100) + \"%\";
if(sMsg == \"操作完成!\"){
	document.getElementById(\"syncontent\").style.display =\"none\";
}
}</script>";

echo "<div  width=\"100%\" align=\"center\" id=\"syncontent\">
    <div style=\"margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width: ". $width8 ."px\" align=\"left\">
    <div align=\"center\" style=\"font-size:14px\">进度条</div>
    <div style=\"padding: 0; background-color: white; border: 1px solid navy; width: ".$width."px\" align=\"left\">
    <div id=\"progress\" style=\"padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px\"></div>
    </div>
    <div id=\"prostatus\">&nbsp;</div>
    <div id=\"percent\" style=\"position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt\">0%</div>
    </div>
</div>";

$page_size = 40;
$page_no = intval($resultcount / $page_size)+1;

$taobaoorders_page = array();
$taobaoorders = array();


//获取淘宝订单信息
$taobaoorders_page = getTaobaoOrderInfo($rooturl,$session,$appKey,$appSecret,$page_no,$page_size,$start_created,$end_created);

$timer->stop();  
$timemessage .="获取淘宝订单详细数据用时: <font color=red>".$timer->spent()."</font><br>";
$timer->start(); 

//总数 > 40 处理数组 array[0][0] to array[0]

if($resultcount >40){
	foreach($taobaoorders_page as $pageorders){
		foreach($pageorders as $pageorder){
				$taobaoorders[] = $pageorder;
		}
	}
}else{
	$taobaoorders = $taobaoorders_page[0];
}

$timer->stop();  
$timemessage .="数据转换形式用时: <font color=red>".$timer->spent()."</font><br>";
$timer->start(); 

//订单总数
$count_all = count($taobaoorders);

$pix = $width / $count_all; 
$progress = 0;

$successorder = 0;
$order_num = 0;



foreach ($taobaoorders as $key => $taobaoorder) {  //begin {1}

	//taobao.trade.fullinfo.get 
	//获取交易详情
	$tid = $taobaoorder['tid'];
	//获取单笔交易的详细信息 
	$taobaoothers = getTaobaoTradeInfo($rooturl,$session,$appKey,$appSecret,$tid);
	
	//买家昵称
	$buyer_nick = $taobaoothers['buyer_nick'];
	
	//Email
	$buyer_email_temp =   $taobaoothers['buyer_email'];  
	if(is_array($buyer_email_temp)){ 
		if(empty($buyer_email_temp)){
				$buyer_email='';
		}else{
			foreach($buyer_email_temp as $rel_email){
				$buyer_email .= " ".$rel_email;
			}
		}
	}else{
		$buyer_email = $buyer_email_temp;
	} 
	
	//收货人姓名
	$receiver_name =  $taobaoothers['receiver_name'];
	//收货人省份
	$receiver_state  = $taobaoothers['receiver_state'];
	//收货人城市
	$receiver_city = $taobaoothers['receiver_city'];
	//收货人区域
	$receiver_district = $taobaoothers['receiver_district'];
	//收货人详细地址
	$receiver_street = $taobaoothers['receiver_address'];
	//收货人邮编
	$receiver_code = $taobaoothers['receiver_zip'];
	//收货人手机号码
	$receiver_phone =  $taobaoothers['receiver_mobile'];
	//收货人电话
	$receiver_tel_temp = $taobaoothers['receiver_phone'];
	$receiver_tel = '';
	if(is_array($receiver_tel_temp)){ 
		if(empty($receiver_tel_temp)){
				$receiver_tel='';
		}else{
			foreach($receiver_tel_temp as $rel_tel){
				$receiver_tel .= " ".$rel_tel;
			}
		}
	}else{
		$receiver_tel = $receiver_tel_temp;
	}
	
	//创建时间
	$trade_created = $taobaoothers['created']; 
	
	//订单备注
	$description_order =  addslashes($taobaoothers['trade_memo']); 
	
	//加载交易数据 
	$orders = $taobaoothers['orders']['order'];
	
	$index =0;
	if(!is_array($orders)){
			continue;
	}
	foreach($orders as $order){  //order details begin
				
		//子订单编号
		$oid = $order['oid'];

		$order_is_exist =  checkOrderIsExist($oid); //返回结果：true 不存在 ， false 已存在
		if(!$order_is_exist){
			$errormess .="订单:'$oid'已存在。<br>";
			$order_num++;
			continue;
		}
		//SKU的值
		$sku_properties_name = $order['sku_properties_name'];
		
		//商品个数
		$item_num = $order['num']; //All_num
		
		//商品价格
		$item_price = $order['price'];
		
		//应付金额
		$total = $order['total_fee'];
		
		//创建时间
		$createdtime_order = $trade_created;

		//修改时间
		$modifiedtime_order =  $order['modified'];
		if($modifiedtime_order == ''){
			$modifiedtime_order = date("Y-m-d H:i:s");
		}

			// begin insert 
				
			$accountid_tmp = checkAccountIsExist($buyer_nick); //判断客户是否已存在

			if(empty($accountid_tmp)){
				//不存在
				$accountid =$adb->getUniqueID("ec_crmentity");
				//同步的客户信息
				$accountname = $receiver_name;
				
				//会员名
				$membername  =  $buyer_nick;	
				
				//客户类型
				$account_type = "客户";
				
				//手机
				$phone = $receiver_phone; 
				
				//电话
				$tel = $receiver_tel;
			
				//Email
				$email =  $buyer_email;

				//客户最新订单时间
				$lastorderdate = $trade_created;
				
				//订单金额
				$ordertotal = $total;
				
				//省
				$bill_state = $receiver_state;
				//城市
				$bill_city = $receiver_city;
				//区域
				$bill_district = $receiver_district;
				//街道
				$bill_street = $receiver_street;
				//邮编
				$bill_code = $receiver_code;
				//描述
				$description_account = '';
				
				//创建时间
				$createdtime_account = date("Y-m-d H:i:s");
				
				//修改时间
				$modifiedtime_account = date("Y-m-d H:i:s");
				
				$prefixa ='';
				if($accountname !=''){
					$prefixa = getEveryWordFirstSpell($accountname);
				}
				
				$insertaccountsql = "insert into ec_account(accountid,accountname,prefix,leadsource,membername,account_type,contact_date,contacttimes,lastorderdate,phone,tel,email,ordernum,ordertotal,bill_state,bill_city,bill_district,bill_street,bill_code,description,smcreatorid,smownerid,modifiedby,createdtime,modifiedtime,deleted) values(".$accountid.",'".$accountname."','".$prefixa."','淘宝','".$membername."','".$account_type."','0000-00-00',0,'".$lastorderdate."','".$phone."','".$tel."','".$email."','1','".$ordertotal."','".$bill_state."','".$bill_city."','".$bill_district."','".$bill_street."','".$bill_code."','".$description_account."',".$current_user->id.",".$current_user->id.",0,'".$createdtime_account."','".$modifiedtime_account."',0)";
				
				$rs0 = $adb->query($insertaccountsql);
				if(!$rs0){
					$errormess .='客户插入未成功!'.$membername."<br>";
				}
				//插入ec_crmentity
				$insertcrmentityaccountsql = "insert into ec_crmentity(crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) " .
						"values(".$accountid.",".$current_user->id.",".$current_user->id.",'Accounts','".$description_account."','".$createdtime_account."','".$modifiedtime_account."')";
				
				$rn0 = $adb->query($insertcrmentityaccountsql);
				if(!$rn0){
					$errormess .='客户关联插入未成功!<br>';
				}
			}else{
				$accountid = $accountid_tmp;
				$updateaccountsql = "update ec_account set lastorderdate='".$createdtime_order."',ordernum=ordernum+1,ordertotal=ordertotal+".$total."  where accountid= '".$accountid."'";
				$rs1 = $adb->query($updateaccountsql);
			   if(!$rs1){
						$errormess .='客户更新未成功!\r\n';
				}
			}
		
		//订单ID
		$salesorderid = $adb->getUniqueID("ec_crmentity");
		
		//订单编号
		//$subject = $salesorder_seqprefix.date("Ymd")."-".get_next_id('ec_salesorder');

		$insertorderssql = "insert into ec_salesorder(salesorderid,subject,accountid,orderstatus,orderdate,num,total,description,smcreatorid,smownerid,modifiedby,createdtime,modifiedtime,deleted) values(".$salesorderid.",'".$oid."','".$accountid."','全额付款','".$createdtime_order."','','".$total."','".$description_order."',".$current_user->id.",".$current_user->id.",0,'".$createdtime_order."','".$modifiedtime_order."',0);";
		$rs2 = $adb->query($insertorderssql);
		if(!$rs2){
					$errormess .='订单插入未成功!'.$oid."<br>";
		}else{
			$update_acc_pay_sql = "update ec_account set allsuccessbuy=allsuccessbuy+1 where accountid='".$accountid."'";
			$adb->query($update_acc_pay_sql);
		}
		
		
		//插入ec_crmentity
		$insertcrmentityordersql = "insert into ec_crmentity(crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) " .
					"values(".$salesorderid.",".$current_user->id.",".$current_user->id.",'SalesOrder','".$description_order."','".$createdtime_order."','".$modifiedtime_order."')";

		$adb->query($insertcrmentityordersql);
		

		//商品数字id
		$num_iid = $order['num_iid'];
		
		//判断产品是否已存在
		$productid_tmp = checkItemIsExist($num_iid);
		if(empty($productid_tmp)){
			//获取订单产品信息
			$ItemInfo =getProductInfo($rooturl,$session,$appKey,$appSecret,$num_iid);
			if(empty($ItemInfo)){
				$errormess .="获取订单产品信息失败。<br>";
			}else{
				$productid = $adb->getUniqueID("ec_crmentity");
				$productname =  $ItemInfo['title'];
				$productcode = $product_seqprefix.get_next_id('ec_products');
				
				//商品url
				$detail_url = $ItemInfo['detail_url'];

				//商品数量
				$pro_num = $ItemInfo['num'];
				//商品价格
				$price =  $ItemInfo['price'];
				
				$comment = $sku_properties_name;
				//创建时间
				$createdtime_pro =  $ItemInfo['created'];
				if($createdtime_pro == ''){
					$createdtime_pro = date("Y-m-d H:i:s");
				}
				//修改时间
				$modifiedtime_pro =  $ItemInfo['modified'];
				if($modifiedtime_pro == ''){
					$modifiedtime_pro = date("Y-m-d H:i:s");
				}
				
				
				$insertproductsql = "insert into ec_products(productid,productname,productcode,detail_url,num_iid,price,smcreatorid,smownerid,modifiedby,createdtime,modifiedtime,deleted) values(".$productid.",'".$productname."','".$productcode."','".$detail_url ."','".$num_iid."','".$price."',".$current_user->id.",".$current_user->id.",0,'".$createdtime_pro."','".$modifiedtime_pro."',0)";
				$rs3 = $adb->query($insertproductsql);
				if(!$rs3){
					$errormess .='产品插入未成功!'.$productname."<br>";
				}
				//插入ec_crmentity
				$insertcrmentityproductsql = "insert into ec_crmentity(crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) " .
						"values(".$productid.",".$current_user->id.",".$current_user->id.",'Products','".$description_pro."','".$createdtime_pro."','".$modifiedtime_pro."')";

				$adb->query($insertcrmentityproductsql);
			}
		}else{
			$productid = $productid_tmp;
		}

		$insertInventoryProductsql = "insert into ec_inventoryproductrel(id,productid,sequence_no,quantity,listprice,discount_percent,discount_amount,comment,pricebookid) " .
				"values(".$salesorderid.",".$productid.",'1','".$item_num."','".$item_price."','','','".$comment."','')";
		$rs4 = $adb->query($insertInventoryProductsql);
		if(!$rs4){
			$errormess .='产品关联插入未成功!'.$productname."<br>";
		}
		if($rs2){
			$successorder += 1;
			$index++;
		}else{
			$index--;
		}
		//end insert salesorder
		$order_num++;

	}
	//order details end	
	
	

	if($index == -3){
		$failed += 1;
	}elseif($index == 0){
		//空
	}else{
		$success += 1;
	}
	
	$minprogress = min($width, intval($progress));
	echo "<script language=\"JavaScript\">";
	echo "updateProgress('当前交易号:".$tid."',".$minprogress.");";
	echo "</script>";

	
	$progress += $pix;
	
} //end  {1}

$timer->stop();  
$timemessage .="写入数据库用时: <font color=red>".$timer->spent()."</font><br>";
$timer->start(); 


echo "<script language=\"JavaScript\">";
echo "updateProgress('操作完成!',".$width.");";
echo "</script>";


$message = "当前订单总数:<font color=red>".$order_num." ;</font>&nbsp;&nbsp;&nbsp;";
$message .="已成功导入订单数:<font color=red>".$successorder." ;</font>";

$importresult = "<font color=green>导入完毕</font>";

?>
<table style="background-color: rgb(234, 234, 234);margin-top:-16px;" class="small" width="100%" border="0" cellpadding="3" cellspacing="1">
 <tr style="height: 30px;" bgcolor="white" valign="bottom">
    <td width="100%" colspan="2" class="detailedViewHeader" style="font-weight:bolder;">
    	同步三个月内订单 >> <?php echo '<a href="index.php?module=Relsettings&action=Taobaozushou">返回</a>'; ?>
    </td>
  </tr>
   <tr style="height: 30px;" bgcolor="white" valign="bottom">
    <td width="100%"  ><br>
    	&nbsp;&nbsp;&nbsp;&nbsp;>>&nbsp;&nbsp;<?php if(!empty($importresult)){echo $importresult;} ?><br><br>
    	<?php if(!empty($message)){echo "&nbsp;&nbsp;&nbsp;&nbsp;>>&nbsp;&nbsp;".$message."&nbsp;&nbsp;&nbsp;&nbsp;<br><br>";} ?>
		<div style="padding-left:32px;">
		<?php echo $timemessage; ?> 
        </div>
        <div style="padding-left:32px;"><input type="button"  name="button" value="返回"  class="crmbutton small edit" onclick="javascript:location.href='index.php?module=Relsettings&action=Taobaozushou'"/></div>
    </td>
  </tr>
 
</table>