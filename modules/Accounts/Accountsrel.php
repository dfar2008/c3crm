<?php
require_once('include/utils/CommonUtils.php');
require_once('include/utils/utils.php');

class Accountsrel{
	private $lastuseridstr;
	function __construct(){

	}



    /**
	 * 获取订单详细信息
	 */
     function getDetailsOrderInfo($accountid) {

         global $log;
		 global $adb;
         $log->debug("Entering getDetailsOrderInfo method ...");
         $query = "select DISTINCT  ec_salesorder.subject,prorel.salesum,ec_account.accountname,ec_salesorder.createdtime,ec_salesorder.modifiedtime,ec_salesorder.orderstatus,ec_salesorder.total,ec_salesorder.salesorderid,ec_salesorder.ordername,ec_salesorder.orderdate,ec_salesorder.rate,ec_salesorder.ratetotal,ec_salesorder.duedate
		 from ec_salesorder
		 left join ec_inventoryproductrel on ec_inventoryproductrel.id = ec_salesorder.salesorderid
	     inner join ec_account on ec_account.accountid = ec_salesorder.accountid
		 left join (select ec_inventoryproductrel.id,sum(quantity) as salesum from ec_inventoryproductrel
			       left join ec_salesorder on ec_salesorder.salesorderid = ec_inventoryproductrel.id
			       where ec_salesorder.accountid = ".$accountid."  group by ec_inventoryproductrel.id)
			       as prorel  on prorel.id = ec_salesorder.salesorderid
		 where ec_salesorder.deleted=0 and ec_salesorder.accountid = ".$accountid;
		 $result = $adb->getList($query);
		 $arr = array();
		 foreach($result as $row)
		 {
			$row['subject'] = "<a href='index.php?action=DetailView&module=SalesOrder&record=".$row['salesorderid']."&parenttab=Sales' target='_blank'>".$row['subject']."</a>";
			$arr[] = $row;
		 }

         $log->debug("Exiting getDetailsOrderInfo method ...");
		 return $arr;
     }


      /**
	 * 获取客户的收货信息
	 */
     function getReceiveInfo($accountid) {
         global $log;
		 global $adb;
         $log->debug("Entering getReceiveInfo method ...");
         $query = "select * from ec_account  where accountid = ".$accountid;
		 $result = $adb->getList($query);
		 $arr = array();
		 foreach($result as $row)
         {
            $arr[] = $row;
		 }
         $log->debug("Exiting getReceiveInfo method ...");
		 return $arr;
     }

	  /**
	 * 获取购买产品信息
	 */
     function getBuyProducts($accountid) {
         global $log;
		 global $adb;
         $log->debug("Entering getBuyProducts method ...");
         $query = "select ec_salesorder.subject,ec_salesorder.orderdate,ec_salesorder.total,ec_salesorder.salesorderid,ec_products.productcode,ec_products.productid,
		ec_products.productname,ec_inventoryproductrel.quantity as salesum,ec_inventoryproductrel.listprice as price,ec_products.detail_url from ec_products
		inner join ec_inventoryproductrel on ec_inventoryproductrel.productid = ec_products.productid 
		inner join ec_salesorder on ec_salesorder.salesorderid = ec_inventoryproductrel.id where ec_salesorder.accountid = ".$accountid." and ec_salesorder.deleted=0 order by ec_salesorder.salesorderid asc"; 
		 $result = $adb->getList($query);
		 $arr = array();
		 foreach($result as $row)
         {
			$row['subject'] = "<a href='index.php?action=DetailView&module=SalesOrder&record=".$row['salesorderid']."' target='_blank'>".$row['subject']."</a>";
			$row['productname'] = "<a href='index.php?action=DetailView&module=Products&record=".$row['productid']."' target='_blank'>".$row['productname']."</a>";
			$row['productcode'] = "<a href='index.php?action=DetailView&module=Products&record=".$row['productid']."' target='_blank'>".$row['productcode']."</a>";
			$row['detail_url'] = "<a href='".$row['detail_url']."' target='_blank'>".$row['detail_url']."</a>";
            $arr[] = $row;
		 }
         $log->debug("Exiting getBuyProducts method ...");
		 return $arr;
     }

	//获取客户联系记录
	function getDetailsNoteInfo($accountid){
		 global $log;
		 global $adb;
		 $log->debug("Entering getDetailsNoteInfo method ...");
		 if($accountid !=''){
			 $query = "select * from ec_notes where accountid=$accountid and deleted=0 order by ec_notes.modifiedtime desc";
			 $result = $adb->getList($query);
			 foreach($result as $row)
			 {
					//$row['smownerid'] = getUserFullName($row['smownerid']);
					$row['title'] = "<a href='index.php?action=DetailView&module=Notes&record=".$row['notesid']."&parenttab=Customer' target='_blank'>".$row['title']."</a>";
					$arr[] = $row;
			 }
		 }
	 $log->debug("Exiting getDetailsNoteInfo method ...");
	 return $arr;
	}
	//获取客户联系人记录
	function getContactInfo($accountid){
		 global $log;
		 global $adb;
		 $log->debug("Entering getContactInfo method ...");
		 if($accountid !=''){
			 $query = "select * from ec_contacts where accountid=$accountid and deleted=0 order by ec_contacts.modifiedtime desc";
			 $result = $adb->getList($query);
			 foreach($result as $row)
			 {
				//$row['smownerid'] = getUserFullName($row['smownerid']);
				$row['contactname'] = "<a href='index.php?action=DetailView&module=Contacts&record=".$row['contactsid']."&parenttab=Customer' >".$row['contactname']."</a>";
				$arr[] = $row;
			 }
		 }
		 $log->debug("Exiting getContactInfo method ...");
		 return $arr;
	}

	//获取客户的群发短信信息
	function getQunfasInfo($accountid){
		
		global $log;
		global $adb;
		global $current_user;
		$log->debug("Entering getQunfasInfo method ...");
		if($accountid !=''){
		      require_once('Sms/SmsLib.php');
			  $query = "select phone from ec_account where accountid={$accountid} "; 
			  $row = $adb->getFirstLine($query);
			  $phone = $row['phone'];
			
		      $arr =  getUserSmsLogs($current_user->id,$phone);
			
		 }
		$log->debug("Exiting getQunfasInfo method ...");
		return $arr;
	}
	//获取客户的群发短信信息
	function getQunfasInfo_old($accountid){
		
		global $log;
		global $adb;
		global $current_user;
		$log->debug("Entering getQunfasInfo method ...");
		if($accountid !=''){
			  $query = "select ec_smslogs.* from ec_smslogs 
			 				inner join ec_account 
								on ec_account.phone = ec_smslogs.receiver_phone
							where ec_account.accountid={$accountid} 
							and ec_smslogs.userid = '".$current_user->id."' 
							order by ec_smslogs.sendtime desc ";  //and ec_smslogs.flag=1  
			 $result = $adb->getList($query);
			 foreach($result as $row)
			 {
					$arr[] = $row;
			 }
		 }
		$log->debug("Exiting getQunfasInfo method ...");
		return $arr;
	}

	
	//获取客户的群发邮件信息
	function getMaillistsInfo($accountid){
		global $log;
		global $adb;
		global $current_user;
		$log->debug("Entering getMaillistsInfo method ...");
		if($accountid !=''){
			 $query = "select ec_maillogs.* from ec_maillogs 
			 				inner join ec_account 
								on ec_account.email = ec_maillogs.receiver_email
							where ec_account.accountid={$accountid} 
							and ec_maillogs.userid = '".$current_user->id."' 
							order by ec_maillogs.sendtime desc ";  //and ec_maillogs.flag=1 
			 $result = $adb->getList($query);
			 foreach($result as $row)
			 {
					$arr[] = $row;
			 }
		 }
		$log->debug("Exiting getMaillistsInfo method ...");
		return $arr;
	}


		function getMemberNameInfo($id)
		{
			global $adb;
			$query = "select membername from ec_account where accountid='{$id}' and deleted=0";
			$result = $adb->getFirstLine($query);
			$num = $adb->num_rows($result);
			if($num > 0){
				return $result['membername'];
			}else{
				return '';
			}	
		}
	function getMemdaysInfo($id){
		global $adb;
		$query = "select ec_memdays.*,ec_users.user_name from ec_memdays 
					inner join ec_users 
						on ec_users.id = ec_memdays.smownerid 
				where ec_memdays.deleted = 0 and accountid = {$id} ";
		$result = $adb->getList($query);
		$infohtml = '';
		foreach($result as $row)
		{
				$infohtml .= '<tr bgcolor="white">
								<td nowrap><a href="index.php?action=DetailView&module=Memdays&record='.$row['memdaysid'].'" target="_blank">'.$row['memdayname'].'</a></td>
								<td nowrap>'.$row['memday938'].'</td>
								<td nowrap>'.$row['memday1004'].'</td>
								<td nowrap>'.$row['memday940'].'</td>
								<td nowrap>'.$row['memday946'].'</td>		
								<td nowrap><a href="index.php?module=Memdays&action=EditView&record='.$row['memdaysid'].'&return_module=Accounts&return_action=ListView&return_id='.$id.'&parenttab=Customer"> &nbsp;编辑 </a>|<a href=\'javascript:confirmdelete("index.php?module=Memdays&action=Delete&record='.$row['memdaysid'].'&return_module=Accounts&return_action=ListView&return_id='.$id.'&parenttab=Customer&return_viewname=0")\'> 刪除 </a></td>						
						  	</tr>';
		}
		return $infohtml;
	}
	function __destruct(){

	}
}
?>