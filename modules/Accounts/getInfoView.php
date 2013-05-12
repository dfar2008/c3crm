<?php
require_once('modules/Accounts/Accounts.php');
require_once('include/utils/utils.php');
require_once('modules/Accounts/Accountsrel.php');

$rel_focus = new Accountsrel();
$account_focus = new Accounts();
global $adb,$current_user;
global $currentModule;
global $theme;
$theme_path="themes/".$theme."/";
$image_path=$theme_path."images/";

$type = $_REQUEST["type"];
$_SESSION['list_type'] = $type;

$record = $_REQUEST["record"];

if(!$type || $type == ''){
	echo '';die;
}

$infohtml = '<table class="dvtContentSpace" width="100%" style="border-top: 1px solid rgb(222, 222, 222);" border="0"><tbody><tr><td style="padding:1px;">';
if($type == 'DetailsOrders'){
	
	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%" border="0" cellpadding="3" cellspacing="1" >



      <tr style="height: 20px;">
        <td class="lvtCol2"  nowrap>订单编号</td>
		<td class="lvtCol2"  nowrap>订单状态</td>
        <td class="lvtCol2"  nowrap>订单日期</td>
		<td class="lvtCol2"  nowrap>合同到期日期</td>
        <td class="lvtCol2"  nowrap >订单总额</td>
		<td class="lvtCol2"  nowrap>提成比例</td>
		<td class="lvtCol2"  nowrap>提成金额</td>
		<td class="lvtCol2"  nowrap>编辑|删除</td>
      </tr>';

  if(!empty($record)){
	  $relorderinfo = $rel_focus->getDetailsOrderInfo($record);

	  if($relorderinfo && $relorderinfo != ''){
		  $i = 1;
		 foreach($relorderinfo as $orderinfo){
				  $infohtml .= '<tr bgcolor="white">
					<td nowrap>'.$orderinfo['subject'].'</td>
				    <td nowrap>'.$orderinfo['orderstatus'].'</td>
					<td nowrap>'.getDisplayDate($orderinfo['orderdate']).'</td>
					<td nowrap>'.getDisplayDate($orderinfo['duedate']).'</td>
					<td nowrap>'.$orderinfo['total'].'</td>
					<td nowrap>'.$orderinfo['rate'].'</td>
					<td nowrap>'.$orderinfo['ratetotal'].'</td>
					<td nowrap><a href="index.php?module=SalesOrder&action=EditView&record='.$orderinfo['salesorderid'].'&return_module=Accounts&return_action=ListView&return_id='.$record.'&parenttab=Customer"> &nbsp;编辑 </a>|<a href=\'javascript:confirmdelete("index.php?module=SalesOrder&action=Delete&record='.$orderinfo['salesorderid'].'&return_module=Accounts&return_action=ListView&return_id='.$record.'&parenttab=Customer&return_viewname=0")\'> 刪除 </a></td>
				  </tr>';
				  $i++;
		 }
	  }
  }
    $infohtml .= '</table>';
	if($record != ''){
	  $infohtml .= '<tr style="height: 20px;"><td><input class="crmbutton small create" type="button" value="新增订单" name="Create" onclick="javascript:location.href=\'index.php?module=SalesOrder&action=EditView&return_module=Accounts&return_id='.$record.'\'" accesskey="新增订单" title="新增订单"></td></tr>';
	 }
}else if($type == 'Receiveinfo'){

	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%" border="0" cellpadding="3" cellspacing="1">


      <tr style="height: 20px;">

        <td class="lvtCol2"  nowrap>收货人姓名</td>

        <td class="lvtCol2"  nowrap>所在省份</td>

        <td class="lvtCol2"  nowrap>所在市</td>

        <td class="lvtCol2"  nowrap>所在区</td>

        <td class="lvtCol2"  nowrap>详细地址</td>

        <td class="lvtCol2"  nowrap>邮编</td>

	    <td class="lvtCol2"  nowrap>手机号码</td>

        <td class="lvtCol2"  nowrap>联系电话</td>

        <td class="lvtCol2"  nowrap>E-mail</td>

      </tr>';

	 if(!empty($record)){
		$relreceiveinfo = $rel_focus->getReceiveInfo($record);

		if($relreceiveinfo && $relreceiveinfo != ''){
		  $i = 1;
		    foreach($relreceiveinfo as $receiveinfo){
				  $infohtml .= '<tr bgcolor="white">
								<td nowrap>'.$receiveinfo['accountname'].'</td>
								<td nowrap>'.$receiveinfo['bill_state'].'</td>
								<td nowrap>'.$receiveinfo['bill_city'].'</td>
								<td nowrap>'.$receiveinfo['bill_district'].'</td>
								<td nowrap>'.$receiveinfo['bill_street'].'</td>
								<td nowrap>'.$receiveinfo['bill_code'].'</td>
								<td nowrap>'.$receiveinfo['phone'].'</td>
								<td nowrap>'.$receiveinfo['tel'].'</td>
								<td nowrap>'.$receiveinfo['email'].'</td>
							  </tr>';
					$i++;
		    }
		 }
	 }

	$infohtml .= '</table>';
}else if($type == 'BuyProducts'){

	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%"  border="0" cellpadding="3" cellspacing="1">

      <tr style="height: 20px;">
		<td class="lvtCol2"  nowrap>订单编号</td>
        <td class="lvtCol2"  nowrap>订单日期</td>
        <td class="lvtCol2"  nowrap >订单总额</td>
        <td class="lvtCol2"  nowrap>产品编号</td>
        <td class="lvtCol2" nowrap>产品名称</td>
        <td class="lvtCol2" nowrap>购买数量</td>
        <td class="lvtCol2" nowrap>价格</td>
        <td class="lvtCol2" nowrap>商品URL</td>
      </tr>';

	 if(!empty($record)){
		$relreceiveinfo = $rel_focus->getBuyProducts($record);

		if($relreceiveinfo && $relreceiveinfo != ''){
		  $i = 1;
		    foreach($relreceiveinfo as $productinfo){
				  $infohtml .= '<tr bgcolor="white">
								<td nowrap>'.$productinfo['subject'].'</td>
								<td nowrap>'.$productinfo['orderdate'].'</td>
								<td nowrap>'.$productinfo['total'].'</td>
								<td nowrap>'.$productinfo['productcode'].'</td>
								<td nowrap>'.$productinfo['productname'].'</td>
								<td nowrap>'.$productinfo['salesum'].'</td>
								<td nowrap>'.$productinfo['price'].'</td>
								<td nowrap>'.$productinfo['detail_url'].'</td>

							  </tr>';
					$i++;
		    }
		 }
	 }

	$infohtml .= '</table>';
}else if($type == 'Contacts'){
	$infohtml .= '<table style="background-color: rgb(234, 234, 234);"  class="small" width="100%"  border="0" cellpadding="3" cellspacing="1" >';
	
     $infohtml .= ' <tr style="height: 20px;">
        <td class="lvtCol2"  nowrap>姓名</td>
        <td class="lvtCol2" nowrap>性别</td>
		<td class="lvtCol2" nowrap>职位</td>
        <td class="lvtCol2" nowrap>手机</td>
		<td class="lvtCol2" nowrap>电话</td>
		<td class="lvtCol2" nowrap>Email</td>
		<td class="lvtCol2" nowrap>QQ</td>
		<td class="lvtCol2" nowrap>编辑|删除</td>
      </tr>';

	 if(!empty($record)){
		$relcontactinfos = $rel_focus->getContactInfo($record);

		if($relcontactinfos && $relcontactinfos != ''){
		  $i = 1;
		    foreach($relcontactinfos as $relcontactinfo){
				  $infohtml .= '<tr bgcolor="white">
								<td nowrap>'.$relcontactinfo['contactname'].'</td>
								<td nowrap>'.$relcontactinfo['contactsex'].'</td>
								<td nowrap>'.$relcontactinfo['contacttitle'].'</td>
								<td nowrap><a href="index.php?module=Qunfas&action=ListView&idstring='.$relcontactinfo['contactsid'].'&modulename=Contacts" target="main">'.$relcontactinfo['contactmobile'].'</a></td>
								<td nowrap>'.$relcontactinfo['contactphone'].'</td>
								<td nowrap><a href="index.php?module=Maillists&action=ListView&idstring='.$relcontactinfo['contactsid'].'&modulename=Contacts" target="main">'.$relcontactinfo['contactemail'].'</a></td>
								<td nowrap>'.$relcontactinfo['contactqq'].'</td>
								<td nowrap><a href="index.php?module=Contacts&action=EditView&record='.$relcontactinfo['contactsid'].'&return_module=Accounts&return_action=ListView&return_id='.$record.'&parenttab=Customer"> &nbsp;编辑 </a>|<a href=\'javascript:confirmdelete("index.php?module=Contacts&action=Delete&record='.$relcontactinfo['contactsid'].'&return_module=Accounts&return_action=ListView&return_id='.$record.'&parenttab=Customer&return_viewname=0")\'> 刪除 </a></td>
							  </tr>';
					$i++;
		    }
		 }
	 }

		$infohtml .= '</table>';
		if($record != ''){
		  $infohtml .= '<tr style="height: 20px;"><td><input class="crmbutton small create" type="button" value="新增联系人" name="Create" onclick="javascript:location.href=\'index.php?module=Contacts&action=EditView&return_module=Accounts&return_id='.$record.'\'" accesskey="新增联系人" title="新增联系人"></td></tr>';
		 }
}else if($type == 'Noteinfo'){
	$infohtml .= '<table style="background-color: rgb(234, 234, 234);"  class="small" width="100%"  border="0" cellpadding="3" cellspacing="1">';

     $infohtml .= ' <tr style="height: 20px;">
        <td class="lvtCol2"  nowrap width="20%">主题</td>
        <td class="lvtCol2" nowrap>联系类型</td>
		<td class="lvtCol2" nowrap>记录时间</td>
        <td class="lvtCol2" nowrap>下次联系日期</td>
		<td class="lvtCol2" nowrap>客户状态</td>
		<td class="lvtCol2" nowrap>内容</td>
		<td class="lvtCol2" nowrap>编辑|删除</td>
      </tr>';

	 if(!empty($record)){
		$relnoteinfos = $rel_focus->getDetailsNoteInfo($record);

		if($relnoteinfos && $relnoteinfos != ''){
		  $i = 1;
		    foreach($relnoteinfos as $relnoteinfo){
				  $infohtml .= '<tr bgcolor="white">
								<td nowrap>'.$relnoteinfo['title'].'</td>
								<td nowrap>'.$relnoteinfo['notetype'].'</td>
								<td nowrap>'.$relnoteinfo['modifiedtime'].'</td>
								<td nowrap>'.getDisplayDate($relnoteinfo['contact_date']).'</td>
								<td nowrap>'.$relnoteinfo['rating'].'</td>
								<td nowrap>'.msubstr1($relnoteinfo['notecontent'],0,50).'</td>
								<td nowrap><a href="index.php?module=Notes&action=EditView&record='.$relnoteinfo['notesid'].'&return_module=Accounts&return_action=ListView&return_id='.$record.'&parenttab=Customer"> &nbsp;编辑 </a>|<a href=\'javascript:confirmdelete("index.php?module=Notes&action=Delete&record='.$relnoteinfo['notesid'].'&return_module=Accounts&return_action=ListView&return_id='.$record.'&parenttab=Customer&return_viewname=0")\'> 刪除 </a></td>
							  </tr>';
					$i++;
		    }
		 }
	 }

		$infohtml .= '</table>';
	
	if($record != ''){
      $infohtml .= '<tr style="height: 20px;"><td><input class="crmbutton small create" type="button" onclick="openDialogs('.$record.');" value="新增联系记录"></td></tr>';
     }
}else if($type == 'Qunfas'){
	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%"  border="0" cellpadding="3" cellspacing="1">';
     $infohtml .= ' <tr style="height: 20px;">

		 <td class="lvtCol2" nowrap>#</td>
        <td class="lvtCol2" nowrap>接收人</td>
		
		<td class="lvtCol2" nowrap>接收人手机</td>
		
		<td class="lvtCol2" nowrap>短信内容</td>
				
		<td class="lvtCol2" nowrap>发送结果</td>
		
		<td class="lvtCol2" nowrap>发送时间</td>

      </tr>';

	 if(!empty($record)){
		$qunfainfos = $rel_focus->getQunfasInfo($record); 
		
		//$qunfainfos = json_encode($qunfainfos);
		//print_r($qunfainfos);die;

		if($qunfainfos && $qunfainfos != ''){
		  $i = 1;
		    foreach($qunfainfos as $qunfainfo){
				  $infohtml .= '<tr bgcolor="white">
				  				<td nowrap>'.$i.'</td>
								<td nowrap>'.$qunfainfo->receiver.'</td>
								<td nowrap>'.$qunfainfo->receiver_phone.'</td>
								<td nowrap>'.msubstr1($qunfainfo->sendmsg, 0, 30).'</td>
								<td nowrap>'.$qunfainfo->result.'</td>
								<td nowrap>'.$qunfainfo->sendtime.'</td>
							  </tr>';
					$i++;
		    }
		 }
	 }

		$infohtml .= '</table>';
		if($record != ''){
		  $infohtml .= '<tr style="height: 20px;"><td><input class="crmbutton small create" type="button" value="发送短信" name="Create" onclick="javascript:location.href=\'index.php?module=Qunfas&action=ListView&idstring='.$record.'&modulename=Accounts\'" accesskey="发送短信" title="发送短信"></td></tr>';
		 }

}else if($type == 'Maillists'){
	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%"  border="0" cellpadding="3" cellspacing="1">';
     $infohtml .= ' <tr style="height: 20px;">


        <td class="lvtCol2" nowrap>接收人</td>
		
		<td class="lvtCol2" nowrap>接收人邮件</td>

		<td class="lvtCol2" nowrap>邮件主题</td>
		
		<td class="lvtCol2" nowrap>邮件内容</td>
				
		<td class="lvtCol2" nowrap>发送结果</td>
		
		<td class="lvtCol2" nowrap>发送时间</td>
		
      </tr>';

	 if(!empty($record)){
		$maillistinfos = $rel_focus->getMaillistsInfo($record);

		if($maillistinfos && $maillistinfos != ''){
		  $i = 1;
		    foreach($maillistinfos as $maillistinfo){
				  $infohtml .= '<tr bgcolor="white">
								<td nowrap>'.$maillistinfo['receiver'].'</td>
								<td nowrap>'.$maillistinfo['receiver_email'].'</td>
								<td nowrap>'.$maillistinfo['subject'].'</td>
								<td nowrap>'.msubstr1($maillistinfo['mailcontent'], 0, 50).'</td>
								<td nowrap>'.$maillistinfo['result'].'</td>
								<td nowrap>'.$maillistinfo['sendtime'].'</td>
							  </tr>';
					$i++;
		    }
		 }
	 }

		$infohtml .= '</table>';
		if($record != ''){
				  $infohtml .= '<tr style="height: 20px;"><td><input class="crmbutton small create" type="button" value="发送邮件" name="Create" onclick="javascript:location.href=\'index.php?module=Maillists&action=ListView&idstring='.$record.'&modulename=Accounts\'" accesskey="发送邮件" title="发送邮件"></td></tr>';
		 }

}else if($type == 'Memdays'){
	
	$infohtml .= '<table style="background-color: rgb(234, 234, 234);" class="small" width="100%"  border="0" cellpadding="3" cellspacing="1">';
    $infohtml .= ' <tr style="height: 20px;">
						<td class="lvtCol2"  nowrap width="20%">纪念日主题</td>
						<td class="lvtCol2" nowrap>纪念日类型</td>
						<td class="lvtCol2" nowrap>日历</td>
						<td class="lvtCol2" nowrap>纪念日</td>
						<td class="lvtCol2" nowrap>下次提醒</td>
						<td class="lvtCol2" nowrap>编辑|删除</td>
						</tr>';

	 if(!empty($record)){
		$reshtml = $rel_focus->getMemdaysInfo($record);
		if($reshtml && !empty($reshtml)){
			$infohtml .= $reshtml;
		}
		
	 }

		$infohtml .= '</table>';
	if($record != ''){
	  $infohtml .= '<tr style="height: 20px;"><td><input class="crmbutton small create" type="button" value="新增纪念日" name="Create" onclick="javascript:location.href=\'index.php?module=Memdays&action=EditView&return_module=Accounts&return_id='.$record.'\'" accesskey="新增纪念日" title="新增纪念日"></td></tr>';
	 }
}else if($type == 'Sfa'){
	
	$dzsmarr = array("manual"=>"具体事务","sms"=>"发短信","email"=>"发邮件");
$zxztarr = array("成功"=>"s31.png","跳过"=>"s32.png","再次执行"=>"me.png","执行失败"=>"s33.png","未执行"=>"me.png","自动执行中"=>"s34.png",);
$bjztarr = array("正在执行期内"=>"jinxing","过期未执行的"=>"guoqi","正常的"=>"zhengchang");

$query = "select * from ec_sfalists where accountid='".$record."' and deleted=0 and smownerid='".$current_user->id."'";
$result = $adb->getList($query);
	$Sfalists_now = array();
	$Sfalists_over = array();
	foreach($result as $row)
	{
		$zxzt = $row['zxzt'];
		$sfalistsid = $row['sfalistsid'];
		$sfasettingsid = $row['sfasettingsid'];
		$sfasettingname = getSfasettingName($sfasettingsid);
		if($zxzt =='中止' || $zxzt =='结束'){
			$Sfalists_over[$sfalistsid] = " <img src=\"themes/softed/images/s1.png\" border=0/> <a href=\"index.php?module=Sfalists&action=DetailView&record=".$sfalistsid."\">".$row['sfalistname']."</a>  (<font color=\"#666666\">".$sfasettingname."</font>)";
		}else{
			$tools = '<a href="#" onclick="openEdit('.$sfalistsid.');return false;"><img src="themes/softed/images/sfaeedit.png" border=0/ >编辑</a>';
			if($zxzt == '未执行'){
				$tools .='  |  <a href="#" onclick="openDel('.$sfalistsid.');return false;"><img src="themes/softed/images/sfaedel.png" border=0 />删除</a>';
			}
			$tools .='   |   <a href="#" onclick="openZhongzhi('.$sfalistsid.');return false;"><img src="themes/softed/images/sfastop.png" border=0 />中止</a>';
			
			$Sfalists_now[$sfalistsid] = " <img src=\"themes/softed/images/s1.png\" border=0/> <a href=\"index.php?module=Sfalists&action=DetailView&record=".$sfalistsid."\">".$row['sfalistname']."</a>  (<font color=\"#666666\">".$sfasettingname."</font>)"."  &nbsp;&nbsp;&nbsp;".$tools;
			
			$Sfalists_now_events = getSfalistEvent($sfalistsid);
			
			foreach($Sfalists_now_events[$sfalistsid] as $id=>$val){
				$ms = $val['sj']."  ".$val['datestart']."  ".$val['dateend']."  ".$dzsmarr[$val['at']];
				
				$today = date("Y-m-d");
				if($today >= $val['datestart'] && $today <= $val['dateend']){
					$bjzt = "正在执行期内";
				}else if($today > $val['dateend'] && ($val['zt'] =='未执行' || $val['zt'] =='再次执行') && $val['dateend'] !='0000-00-00'){
					$bjzt = "过期未执行的";
				}else{
					$bjzt = "正常的";
				}
				
				$sfalist_now_events_list[$sfalistsid][$id] = "<div class=\"".$bjztarr[$bjzt]."\"><li class=\"sfasn\">&nbsp;&nbsp;<a href=\"#\" title=\"".$ms."\" onclick=\"openRunEvent(".$id.");return false;\"><span>".$val['sj']."".$val['sjbz']."[<img src=\"themes/softed/images/".$zxztarr[$val['zt']]."\" border=0/>]</span></a>&nbsp;&nbsp;</li></div>";
			}
			
			
		}
	}

	$query = "select * from ec_sfalogs where logstatus !='未执行' and accountid='".$record."' and smownerid='".$current_user->id."' and sfalisteventsid !=0  and (modifiedtime >= '".date("Y-m-d")." 00:00:00' && modifiedtime <= '".date("Y-m-d")." 59:59:59') order by modifiedtime desc"; 
	$result = $adb->getList($query);
	foreach($result as $row)
	{
		$sfalogsid = $row['sfalogsid'];
		$sfalogs[$sfalogsid] = "<img src=\"themes/softed/images/s1.png\" border=0/> &nbsp;&nbsp;[".$row['logstatus']."] &nbsp;&nbsp;<a href=\"#\" onclick=\"openRunEvent(".$row['sfalisteventsid'].");return false;\">".$row['sj']."</a> &nbsp;&nbsp; (执行时间: <font color=\"#666666\">".$row['modifiedtime']."</font>)";
	}


	$query = "select * from ec_sfasettings where sfastatus='已启用' and deleted=0 and smownerid='".$current_user->id."' ";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
			for($i=0;$i<$num_rows;$i++){
				$id = $adb->query_result($result,$i,"sfasettingsid");
				$name = $adb->query_result($result,$i,"sfasettingname");
				$sfa_entries[$id] = $name;			
			}
	}
	$sfasettingshtml = '';
	if(!empty($sfa_entries)){
		foreach($sfa_entries  as $sfa_id => $sfa_name){
			$sfasettingshtml .='<option value="'.$sfa_id.'">'.$sfa_name.'</option>';
		}
	}

	
	$infohtml .= '<table class="small" width="100%"  border="0" cellpadding="3" cellspacing="1">';
	if($record != ''){
		$infohtml .= ' <tr style="height: 20px;">
						 <td style="background: none repeat scroll 0 0 #E8E8E8;">启动 SFA序列: 
              		<select id="sfasettingsid" name="sfasettingsid">
                    	<option value="0">无</option>
                        	'.$sfasettingshtml.'
                    </select>
                <input type="button" name="qidong" value=" 开始 " class="crmbutton small create" onclick="CreateSfaList();"  />
              </td></tr>';
	}
	 
    $infohtml .= ' <tr style="height: 20px;">
						<td  nowrap width="20%" style="background: none repeat scroll 0 0 #9C9;border-bottom:1px solid #999999;height:30px;" onclick="ToggleGroupContent(\'sfalist1\',\'sfaimg1\')" style="cursor:Pointer;">
						 <img id="sfaimg1" border="0" src="themes/images/collapse.gif"> 正在执行的序列：图示【<img border="0" src="'.$image_path.'s31.png">成功<img border="0" src="'.$image_path.'s32.png">跳过<img border="0" src="'.$image_path.'s33.png">执行失败<img border="0" src="'.$image_path.'me.png">未执行/再次执行】  背景【<img border="0" src="'.$image_path.'sfa_blue_1.gif">正常的<img border="0" src="'.$image_path.'sfa_yellow_1.gif">正在执行期内<img border="0" src="'.$image_path.'sfa_gray_1.gif">过期未执行的】
						</td>
						</tr>';
						
    $infohtml .= ' <tr style="height: 20px;">
						<td  nowrap width="20%">
						  <div id="sfalist1" style="display:block;">';
						   if(!empty($Sfalists_now)){
							  foreach($Sfalists_now as $key=>$now){
								  $infohtml .= '<div class="clear"></div>&nbsp;&nbsp;<div style="height:25px;">'.$now.'</div><div style="padding-left:35px;">';
								   if(!empty($sfalist_now_events_list)){
									   foreach($sfalist_now_events_list[$key] as $data){
											$infohtml .=$data;
									   }
								   }
								 $infohtml .= ' </div><br>';
							  }
						   }
     $infohtml .= ' </div></td></tr>';						
						
						
		 $infohtml .= ' <tr style="height: 20px;">
		 				<td style="background: none repeat scroll 0 0 #CCF;border-bottom:1px solid #999999;height:30px;"  onclick="ToggleGroupContent(\'sfalist2\',\'sfaimg2\')" style="cursor:Pointer;">
                  <img id="sfaimg2" border="0" src="themes/images/expand.gif">停止执行的序列:
                </td>';
		 $infohtml .= ' <tr style="height: 20px;">
						<td  nowrap width="20%">
						  <div id="sfalist2" style="display:none;">';
						  if(!empty($Sfalists_over)){
							  foreach($Sfalists_over as $key=>$over){
								  $infohtml .= '<div style="height:25px;">'.$over.'</div>';
							  }
						  }
     $infohtml .= ' </div></td></tr>';	
	 
	  $infohtml .= ' <tr style="height: 20px;">
		 				 <td style="background: none repeat scroll 0 0 #99F;border-bottom:1px solid #999999;height:30px;" onclick="ToggleGroupContent(\'sfalist3\',\'sfaimg3\')" style="cursor:Pointer;">
                <img id="sfaimg3" border="0" src="themes/images/expand.gif">最近执行的事件:
                </td>';
	  $infohtml .= ' <tr style="height: 20px;">
						<td  nowrap width="20%">
						  <div id="sfalist3" style="display:none;">';
						  if(!empty($sfalogs)){
							  	foreach($sfalogs as $key=>$log){
								  $infohtml .= '<div style="height:25px;">'.$log.'</div>';
							  }
						  }
     $infohtml .= ' </div></td></tr>';	
	 
	
						
	$infohtml .= '</table>';
	
}else{
	$infohtml .= '';
}
$infohtml .= '</td></tr><tr><td>&nbsp;&nbsp;&nbsp;</td></tr></tbody></table>';

echo $infohtml;
exit();

function getSfasettingName($sfasettingsid){
	global $adb;
	$query = "select sfasettingname from ec_sfasettings where sfasettingsid='".$sfasettingsid."' and deleted=0";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	if($num_rows > 0){
		$sfasettingname = $adb->query_result($result,0,"sfasettingname");
	}
	return $sfasettingname;
}

function getSfalistEvent($sfalistsid){
	global $adb;
	$query = "select * from ec_sfalistevents where sfalistsid='".$sfalistsid."' order by datestart ";
	$result = $adb->query($query);
	$num_rows = $adb->num_rows($result);
	$arr = array();
	$arr2 = array();
	$arr3 = array();
	if($num_rows > 0){
		for($i=0;$i<$num_rows;$i++){
			$id = $adb->query_result($result,$i,"id");
			$sj = $adb->query_result($result,$i,"sj");
			$sjbz = $adb->query_result($result,$i,"sjbz");
			$datestart = $adb->query_result($result,$i,"datestart");
			$dateend = $adb->query_result($result,$i,"dateend");
			$at = $adb->query_result($result,$i,"at");
			$zt = $adb->query_result($result,$i,"zt");
			
			$arr['sj'] = $sj;
			$arr['sjbz'] = $sjbz;
			$arr['datestart'] = $datestart;
			$arr['dateend'] = $dateend;
			$arr['at'] = $at;
			$arr['zt'] = $zt;
			$arr2[$id] = $arr;
		}
		$arr3[$sfalistsid]  = $arr2;
	}
	return $arr3;	
}

?>