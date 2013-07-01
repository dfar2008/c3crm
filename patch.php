<?php
set_time_limit(0);
define('IN_CRMONE', true);
$root_directory = dirname(__FILE__)."/";
require($root_directory.'/include/init.php');
global $adb;


//addTableFiles("ec_qunfas","msg","text");
// insertIntoField("ec_qunfas","msg","Qunfas",1,"群发短信内容");
//addTableFiles("ec_maillists","from_name","string");
// insertIntoField("ec_maillists","from_name","Maillists",1,"发件人");
//addTableFiles("ec_maillists","subject","string");
// insertIntoField("ec_maillists","subject","Maillists",1,"邮件主题");
//addTableFiles("ec_maillists","mailcontent","text");
// insertIntoField("ec_maillists","mailcontent","Maillists",19,"邮件内容");

//addTableFiles("ec_salesorder","pro_type","text");
//insertIntoField("ec_salesorder","pro_type","Maillists",19,"邮件内容");
/**
$query = "ALTER TABLE `ec_shops` ADD INDEX ( `is_on` )";
$adb->query($query);

$query = "ALTER TABLE `ec_account` CHANGE `allsuccessbuy` `allsuccessbuy` INT( 11 ) NULL DEFAULT '0' ";
$adb->query($query);
//begin


$adb->query("ALTER TABLE `ec_products` ADD `smownerid` INT( 19 ) NULL DEFAULT '0' AFTER `smcreatorid` ;");
$adb->query("ALTER TABLE `ec_products` ADD INDEX ( `smownerid` ) ;");

$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 4 LIMIT 1;");


$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 5 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 8 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 10 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 11 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 13 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 14 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 22 LIMIT 1;");

$adb->query("UPDATE `ec_field` SET `block` = '3' WHERE `ec_field`.`fieldid` =18 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `block` = '1' WHERE `ec_field`.`fieldid` =19 LIMIT 1 ;");


$adb->query("UPDATE `ec_field` SET `sequence` = '5' WHERE `ec_field`.`fieldid` =17 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '19' WHERE `ec_field`.`fieldid` =316 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '3' WHERE `ec_field`.`fieldid` =306 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '5' WHERE `ec_field`.`fieldid` =307 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '2' WHERE `ec_field`.`fieldid` =308 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '4' WHERE `ec_field`.`fieldid` =309 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '6' WHERE `ec_field`.`fieldid` =310 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '7' WHERE `ec_field`.`fieldid` =311 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '9' WHERE `ec_field`.`fieldid` =312 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '11' WHERE `ec_field`.`fieldid` =313 LIMIT 1 ;");
$adb->query("UPDATE `ec_field` SET `block` = '8' WHERE `ec_field`.`fieldid` =314 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '10' WHERE `ec_field`.`fieldid` =315 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '8',`block` = '7' WHERE `ec_field`.`fieldid` =314 LIMIT 1 ;");


$adb->query("UPDATE `ec_field` SET `sequence` = '7',`block` = '3' WHERE `ec_field`.`fieldid` =316 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '21' WHERE `ec_field`.`fieldid` =305 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `block` = '3' WHERE `ec_field`.`fieldid` =305 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '22',`block` = '3' WHERE `ec_field`.`fieldid` =306 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '23',`block` = '3' WHERE `ec_field`.`fieldid` =307 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '1' WHERE `ec_field`.`fieldid` =308 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '3' WHERE `ec_field`.`fieldid` =309 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '5' WHERE `ec_field`.`fieldid` =310 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '2' WHERE `ec_field`.`fieldid` =311 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '4' WHERE `ec_field`.`fieldid` =312 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '6' WHERE `ec_field`.`fieldid` =313 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '15',`block` = '1' WHERE `ec_field`.`fieldid` =20 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '16',`block` = '1' WHERE `ec_field`.`fieldid` =21 LIMIT 1 ;");

$adb->query("UPDATE `ec_field` SET `sequence` = '17',`block` = '1' WHERE `ec_field`.`fieldid` =23 LIMIT 1 ;");


$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 76 LIMIT 1;");


$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 84 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 85 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 90 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 91 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 102 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 115 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 116 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 117 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 118 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 120 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 121 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 122 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 126 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 127 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 128 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 129 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 130 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 131 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 132 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 133 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 134 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 135 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 136 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 137 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 138 LIMIT 1;");


$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 49 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 52 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 54 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 55 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 56 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 57 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 58 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 60 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 61 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 62 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 63 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 64 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 65 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 66 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 67 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 68 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 69 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 70 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 71 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 72 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 73 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 74 LIMIT 1;");
$adb->query("DELETE FROM `ec_field` WHERE `ec_field`.`fieldid` = 75 LIMIT 1;");


$adb->query("UPDATE `ec_field` SET `block` = '41' WHERE `ec_field`.`fieldid` =59 LIMIT 1 ;");

$adb->query("ALTER TABLE `ec_products` CHANGE `detail_url` `detail_url` VARCHAR( 300 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");


$adb->query("ALTER TABLE `ec_products` CHANGE `num_iid` `num_iid` INT( 29 ) NULL DEFAULT NULL ");

$adb->query("ALTER TABLE `ec_products` CHANGE `num_iid` `num_iid` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ");


 
$adb->query("DELETE FROM `ec_productfieldlist` WHERE `ec_productfieldlist`.`id` = 3 LIMIT 1 ");

//项目采购申请单 增加 创建人 字段
$tabid = getTabid("SalesOrder");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'smownerid','ec_salesorder',1,'53','assigned_user_id','Assigned To',1,0,0,100,7,".$blockid.",2,'V~M',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);



//项目采购申请单 增加 创建人 字段
$tabid = getTabid("Products");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'description','ec_products',1,'19','description','Description',1,0,0,100,7,".$blockid.",1,'V~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);


addTableFiles("ec_account","tel","string");
insertIntoField("ec_account","tel","Accounts",1,"电话");
insertIntoField("ec_products","outer_id","Products",1,"商家编码");



//SFA序列 增加sfasettingsid 字段
$tabid = getTabid("Sfalists");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'sfasettingsid','ec_sfalists',1,'1','sfasettingsid','Sfasetting Name',1,0,0,100,7,".$blockid.",2,'V~M',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);

//SFA序列 增加 fsdate 字段
$tabid = getTabid("Sfalists");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'fsdate','ec_sfalists',1,'5','fsdate','基准日期',1,0,0,100,7,".$blockid.",2,'D~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);


//SFA序列 增加 zxzt 字段
$tabid = getTabid("Sfalists");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'zxzt','ec_sfalists',1,'1','zxzt','执行状态',1,0,0,100,7,".$blockid.",2,'V~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);

//SFA方案 增加 sfastatus 字段
$tabid = getTabid("Sfasettings");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'sfastatus','ec_sfasettings',1,'1','sfastatus','状态',1,0,0,100,7,".$blockid.",2,'V~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);


**/
 
/*//客户 增加 tradedwish 字段 成交意愿
$tabid = getTabid("Accounts");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'tradedwish','ec_account',1,'15','tradedwish','成交意愿',1,0,0,100,7,".$blockid.",1,'V~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);

//客户 增加 redu 字段 热度
$tabid = getTabid("Accounts");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'redu','ec_account',1,'15','redu','热度',1,0,0,100,7,".$blockid.",1,'V~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);
*/

/*
$tabid = getTabid("Users");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'confirm_email','ec_users',1,'1','confirm_email','邮箱验证',1,0,0,100,7,".$blockid.",1,'N~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);

$tabid = getTabid("Users");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'confirm_time','ec_users',1,'70','confirm_time','验证时间',1,0,0,100,7,".$blockid.",1,'T~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);


$tabid = getTabid("Users");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'register_time','ec_users',1,'70','register_time','注册时间',1,0,0,100,7,".$blockid.",1,'T~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);
*/


/* $now = date("Y-m-d H:i:s");
$onemonth = date("Y-m-d",strtotime("1 month"));
$query = "select * from ec_users where confirm_email=1 ";
$rows = $adb->getList($query);
foreach($rows as $row){
	$id = $row['id'];
	$insertsql ="insert into ec_messageaccount(userid,tc,price,num,canuse,chargenum,createdtime,modifiedtime,enddate) values($id,'','0','0','0','0','".$now."','".$now."','".$onemonth."')";
	$adb->query($insertsql);
} */

//客户 增加 leadsource 字段 热度
/*addTableFiles("ec_account","leadsource","string");
$tabid = getTabid("Accounts");
$blockid = get_block_id($tabid);
$fieldid = $adb->getUniqueID("ec_field");
$query = "insert into ec_field values (".$tabid.",".$fieldid.",'leadsource','ec_account',1,'15','leadsource','客户来源',1,0,0,100,7,".$blockid.",1,'V~O',1,1,'BAS')";
$adb->query($query);
insertModuleProfile2field2($tabid,$fieldid);*/


/*
$query = "select userid from ec_messageaccount where userid not in (select userid from ec_systemcharges)";
$rows = $adb->getList($query);

foreach($rows as $row){
	$userid = $row['userid'];
	
	$query2 = "insert into ec_systemcharges(userid,chargenum,chargetime,chargefee,endtime) values({$userid},0,'0000-00-00 00:00:00','0.00','2012-08-10 00:00:00')";
	$adb->query($query2);
}
*/

/**
$query = "select * from ec_messageaccount where enddate >'2012-08-10'";
$rows = $adb->getList($query);
foreach($rows as $row){
	$userid = $row['userid'];
	$enddate = $row['enddate'];
	
	$query2 = "update ec_systemcharges set endtime ='".$enddate." 00:00:00' where userid = {$userid}"; 
	echo $query2."<br>";
	$adb->query($query2);
}

**/


/**
 * 给表添加字段
 * @param $tableName 要添加字段的表名
 * @param $add_filelds 字段名称
 * @param $type 字段类型 默认 int
 * @param $is_null 是否为空 默认 null
 */
function addTableFiles($tableName,$add_filelds,$type = "int",$is_null = "null"){
	global $adb;
	if($tableName && $tableName != "" && $add_filelds && $add_filelds != ""){
		if($type == "int"){
			$fileldtype = "INT";
		}else if($type == "string"){
			$fileldtype = "VARCHAR(100)";
		}else if($type == "price"){
			$fileldtype = "numeric( 11, 2 )";
		}else if($type == "date"){
			$fileldtype = "DATE";
		}else if($type == "time"){
			$fileldtype = "DATETIME";
		}else if($type == "text"){
			$fileldtype = "TEXT";
		}else if($type == "float"){
			$fileldtype = "float";
		}else{
			$fileldtype = "INT";
		}
		if($is_null == "null"){
			$is_null = "NULL";
		}else{
			$is_null = "NOT NULL";
		}
		///
		$query = "ALTER TABLE ".$tableName." ADD ".$add_filelds." ".$fileldtype." ".$is_null." ";
		$adb->query($query);
		return true;
	}
	return false;
}
/**
 * 给表删除字段
 * @param $tableName 要删除字段的表名
 * @param $del_filelds 字段名称
 */
function deleteTableFiles($tableName,$del_filelds){
	global $adb;
	if($tableName && $tableName != "" && $del_filelds && $del_filelds != ""){
		$query = "ALTER TABLE ".$tableName." DROP COLUMN ".$del_filelds." ";
		$adb->query($query);
		return true;
	}
	return false;
}
/**
 * 将关联字段中一个字段删除
 * @param $tableName 要删除的表名
 * @param $add_filelds 要删除的字段名
 * @param $modues 表相关模块名
 * @param $uitype 字段显示格式
 * @param $labelName 字段描述
 */
function insertIntoField($tableName,$add_filelds,$modues,$uitype,$labelName){
	global $adb;
	$tabid = getTabid($modues);
	$blockid = get_block_id($tabid);
	$fieldid = $adb->getUniqueID("ec_field");
	$query = "insert into ec_field values (".$tabid.",".$fieldid.",'".$add_filelds."','".$tableName."',1,'".$uitype."','".$add_filelds."','".$labelName."',1,0,0,100,5,".$blockid.",1,'V~O',1,'','BAS')";
	$adb->query($query);

	insertModuleProfile2field2($tabid,$fieldid);
}
/**
 * 将一个字段插入到关联字段中去
 * @param $tableName 要插入的表名
 * @param $del_filelds 要插入的字段名
 */
function deleteIntoField($tableName,$del_filelds){
	global $adb;
    $sql ="select tabid,fieldid from ec_field where tablename ='".$tableName."' and columnname ='".$del_filelds."' ";
	$result = $adb->query($sql);
	while($row = $adb->fetch_array($result)){
		$tabid = $row['tabid'];
		$fieldid = $row['fieldid'];
        $query = "delete from  ec_field where tabid =".$tabid." and fieldid =".$fieldid." ";
	    $adb->query($query);
		deleteModuleProfile2field2($tabid,$fieldid);
	}
}
function insertModuleProfile2field2($tab_id,$field_id)
{
	global $adb;
	$adb->query("insert into ec_def_org_field values (".$tab_id.",".$field_id.",0,1)");
	/*$query = "SELECT * FROM ec_profile order by profileid";
	$fld_result = $adb->query($query);
	$num_rows = $adb->num_rows($fld_result);
	for($i=0; $i<$num_rows; $i++)
	{
		 $profileid = $adb->query_result($fld_result,$i,'profileid');
		 $adb->query("insert into ec_profile2field values (".$profileid.",".$tab_id.",".$field_id.",0,1)");
		 //$adb->query("insert into ec_profile2utility values (".$profileid.",".$tab_id.",11,0)");//approve permission
	}*/
	echo "ok<br>";

}
function deleteModuleProfile2field2($tab_id,$field_id)
{
	global $adb;
	$sql = "delete from ec_def_org_field  where tabid =".$tab_id." and fieldid =".$field_id." ";
	$adb->query($sql);
	$query = "SELECT * FROM ec_profile order by profileid";
	$fld_result = $adb->query($query);
	$num_rows = $adb->num_rows($fld_result);
	for($i=0; $i<$num_rows; $i++)
	{
		 $profileid = $adb->query_result($fld_result,$i,'profileid');
		 $delquery = "delete from ec_profile2field where profileid=".$profileid." and tabid=".$tab_id." and fieldid=".$field_id." ";
		 $adb->query($delquery);
		 //$adb->query("insert into ec_profile2utility values (".$profileid.",".$tab_id.",11,0)");//approve permission
	}
   echo "ok<br>";

}



function get_block_id($tab_id)
{
	global $adb;
	$query = "SELECT blockid FROM ec_blocks where tabid=".$tab_id." order by blockid";
	$fld_result = $adb->query($query);
	$num_rows = $adb->num_rows($fld_result);
	if($num_rows > 0)
	{
		 $blockid = $adb->query_result($fld_result,0,'blockid');
		 return $blockid;
	}
	return 0;
}

function get_next_blockid() {
	global $adb;
	$query = "select max(blockid) as blockid from ec_blocks";
	$result = $adb->query($query);
	$block_id = $adb->query_result($result,0,"blockid") + 1;
	return $block_id;
}
?>
