<?php  
require_once('include/logging.php');
require_once('include/ListView/ListView.php');
require_once('include/database/PearDatabase.php');
require_once('include/utils/utils.php');
require_once('include/DatabaseUtil.php');
require_once("modules/Accounts/Accounts.php");
global $current_user;
$searchval=$_REQUEST['searchval'];
$where_relquery=" and (ec_account.accountname like '%{$searchval}%' or ec_account.prefix like '%{$searchval}%')";
$query = getListQuery($currentModule,$where_relquery,true); 
$result=$adb->limitQuery2($query,0,11,"ec_account.accountid","asc");
$count=0;
$allaccountinfs=array();
foreach($result as $row)
{
    if($count==10){
        $count++;
        break;
    }
    $accountid=$row['accountid'];
    $accountname=$row['accountname'];
    $allaccountinfs[]=array('accountid'=>$accountid,'accountname'=>$accountname);
    $count++;
}
?>

<table width="180" class="layerHeadingULine" cellspacing="0" border="0">
  <tbody>
  <tr>
  <td nowrap="" class="layerPopupHeading" >
  <div id="AjaxPopView_Title">查询条件:<?php echo $searchval;?></div>
  </td>
  <td valign="middle" >
  <a id="popviewclose" href="javascript:;" onclick="$('#SelCustomer_popview').hide();">
  <img border="0" src="themes/softed/images/close.gif"></a></td></tr>
  <tr bgcolor="white"><td style="line-height: 15pt;" colspan="2">
  <div id="AjaxPopView_cont">
  <?php if($count>0){ ?><b>关键字</b>&nbsp;查询结果:<br><?php }else{?>
    没有符合条件的客户 <?php }?>
  <?php
   foreach($allaccountinfs as $accountinf){
  ?>
  ·<a id="selcustomerview<?php echo $accountinf['accountid'];?>" class="selcustomerview" style="color:black;text-decoration:underline;font-size:9pt;" cu_id="<?php echo $accountinf['accountid'];?>" href="javascript:;" onclick="chooseAccountFromLink(this);"><?php echo $accountinf['accountname'];?></a><br>
  <?php } ?>
  <span gfield="cu_sub" dt="opport" i4="name" i3="id" i2="cu_id" i1="contact" con="cont2" id="SelCustomer_val0"></span>
  <span num="1" id="SelCustomer_count"></span>
  <?php if($count>10){ ?>
  <font color="#ff0099">注意：<br>关键字过短，查询结果多于10条。</font>
  <?php } ?>
  </div></td></tr></tbody></table>