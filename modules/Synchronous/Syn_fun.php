<?php

function get_next_id($tab) {
		global $adb;
		$query = "select count(*) as num from $tab ";
		$result = $adb->query($query);
		$num = $adb->query_result($result,0,'num') + 1;
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

//获取订单总数
function getTaobaoOrderCount($rooturl,$session,$appKey,$appSecret,$start_created,$end_created){
	$fields = 'buyer_nick';
	$extra = array();
	if(!empty($start_created) && !empty($end_created)){
			$extra = array('start_created'=>$start_created,'end_created'=>$end_created);
	}
	$extra = array_merge($extra,array('status'=>'TRADE_FINISHED'));

	$resultcount = getArrayCount('taobao.trades.sold.get',$rooturl,$session,$appKey,$appSecret,$fields,$extra); 
	return $resultcount;
}
//获取淘宝订单信息
function getTaobaoOrderInfo($rooturl,$session,$appKey,$appSecret,$page_no,$page_size,$start_created,$end_created){
	$fields = 'tid';
	$trades = array();
	for($i=1;$i<=$page_no;$i++){ 
		if(!empty($start_created) && !empty($end_created)){
			$extra = array('page_no'=>$i,'page_size'=>$page_size,'start_created'=>$start_created,'end_created'=>$end_created);
		}else{
			$extra = array('page_no'=>$i,'page_size'=>$page_size);
		}
		
		$extra = array_merge($extra,array('status'=>'TRADE_FINISHED'));
		
		 $result = getArrayResult('taobao.trades.sold.get',$rooturl,$session,$appKey,$appSecret,$fields,'trade','s',$extra);
		 $trades[$i-1] = $result['total_results'];
	}
	return $trades;
	
}
//获取淘宝订单以外的交易信息
function getTaobaoTradeInfo($rooturl,$session,$appKey,$appSecret,$tid){
	//changed by xiaoyang on 2012-09-21  淘宝改变有些字段没有权限获得了receiver_name,receiver_address,receiver_mobile,receiver_phone,buyer_email,buyer_alipay_no
	//$fields = 'buyer_nick,title,type,created,tid,seller_rate,buyer_rate,status,post_fee,pay_time,consign_time,received_payment,shipping_type,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,buyer_email,buyer_alipay_no,trade_memo,orders,buyer_message,buyer_memo,express_agency_fee,invoice_name,seller_name,promotion_details'; 
	$fields = 'buyer_nick,title,type,created,tid,seller_rate,buyer_rate,status,post_fee,pay_time,consign_time,received_payment,shipping_type,receiver_state,receiver_city,receiver_district,receiver_zip,trade_memo,orders,buyer_message,buyer_memo,express_agency_fee,invoice_name,seller_name';
	$extra = array('tid'=>$tid);

	$result = getArrayResult('taobao.trade.fullinfo.get',$rooturl,$session,$appKey,$appSecret,$fields,'trade','',$extra);
	$trade = $result['total_results'];
	if(!empty($trade)){
		$orders = $trade['orders']['order'];
		$orders_0 = $trade['orders']['order'][0];
		if(!is_array($orders_0)){
			unset($trade['orders']['order']);
			$trade['orders']['order'][0] = $orders;
		}
	}
	
	return $trade;
}


//获取订单客户信息
function getAccountInfo($rooturl,$session,$appKey,$appSecret,$buyer_nick){
	$extra = array('nick' => $buyer_nick);
	$fields = 'user_id,uid,nick,buyer_credit,seller_credit,created,last_visit,type,vip_info';
	$result = getArrayResult('taobao.user.get',$rooturl,$session,$appKey,$appSecret,$fields,'user','',$extra);
	$user = $result['total_results'];
	return $user;
}


//获取订单产品信息
function getProductInfo($rooturl,$session,$appKey,$appSecret,$num_iid){
	if($num_iid && $num_iid !=''){
		$fields = 'detail_url,num_iid,title,cid,num,price,modified,created';
		$extra = array('num_iid' => $num_iid);
		$result = getArrayResult('taobao.item.get',$rooturl,$session,$appKey,$appSecret,$fields,'item','',$extra);
		$items = $result['total_results'];
		return $items;
	}else{
		return array();
	}
}

//判断订单信息是否已存在
function checkOrderIsExist($oid){
	global $adb;
	global $current_user;
	$return  = true;
	$query = "select * from ec_salesorder where subject='$oid' and deleted=0 and smownerid='".$current_user->id."'";
	$rst = $adb->query($query);
	$num = $adb->num_rows($rst);
	if($num > 0){
		$return = false;
	}
	return $return;
}


//根据昵称判断客户是否已存在
function checkAccountIsExist($nick){
	global $adb;
	global $current_user;
	$accountid = '';
	$query = "select accountid from ec_account where membername='".$nick."' and deleted=0 and smownerid='".$current_user->id."' limit 0,1";
	$accountid = $adb->getOne($query); 
	return $accountid;
}


//判断产品是否已存在
function checkItemIsExist($num_iid){
	global $current_user;
	if($num_iid && $num_iid !=''){
		global $adb;
		$productid = '';
		$query = "select productid from ec_products where num_iid='$num_iid' and deleted=0 and smownerid='".$current_user->id."' limit 0,1";
		$productid = $adb->getOne($query);
		return $productid;
	}else{
		return '';
	}
}

//获取会员级别对应的中文
function getVipInfo($vipinfo_tmp){
	$vipinfo = '';
	if($vipinfo_tmp =='c' ){
		$vipinfo = "普通会员";
	}elseif($vipinfo_tmp == 'asso_vip'){
		$vipinfo = "荣誉会员";
	}elseif($vipinfo_tmp == 'exp_vip1'){
		$vipinfo = "体验vip会员1级";
	}elseif($vipinfo_tmp =='exp_vip2'){
		$vipinfo = "体验vip会员2级";
	}elseif($vipinfo_tmp =='exp_vip3'){
		$vipinfo = "体验vip会员2级";
	}elseif($vipinfo_tmp =='exp_vip4'){
		$vipinfo = "体验vip会员2级";
	}elseif($vipinfo_tmp =='vip1'){
		$vipinfo = "vip会员1级";
	}elseif($vipinfo_tmp =='vip2'){
		$vipinfo = "vip会员2级";
	}elseif($vipinfo_tmp =='vip3'){
		$vipinfo = "vip会员3级";
	}elseif($vipinfo_tmp =='vip4'){
		$vipinfo = "vip会员4级";
	}else{
		$vipinfo = "普通会员";
	}
	return $vipinfo;
}

?>