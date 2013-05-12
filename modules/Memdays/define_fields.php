<?php
$next_blockid=$this->get_next_blockid();
$this->db->query("insert into ec_blocks values (".$next_blockid.",".$tab_id.",'LBL_DESCRIPTION_INFORMATION',3,0,0,0,0,0)");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'description','ec_memdays',1,'19','description','Description',1,0,0,100,1,".$next_blockid.",1,'V~O',0,1,'BAS')");
$next_blockid=$this->get_next_blockid();
$this->db->query("insert into ec_blocks values (".$next_blockid.",".$tab_id.",'LBL_MEMDAY_INFORMATION',1,0,0,0,0,0)");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'memdayname','ec_memdays',1,'2','memdayname','Memday Name',1,0,0,100,1,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'smownerid','ec_memdays',1,'53','assigned_user_id','Assigned To',1,0,0,100,2,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'memday946','ec_memdays',1,'1','memday946','下次提醒',1,0,0,100,10,".$next_blockid.",2,'V~O~LE~50',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contact_id','ec_memdays',1,'57','contact_id','Contact Name',1,0,0,100,4,".$next_blockid.",1,'V~O',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'modifiedtime','ec_memdays',1,'70','modifiedtime','Modified Time',1,0,0,100,14,".$next_blockid.",2,'T~O',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'accountid','ec_memdays',1,'51','account_id','Account Name',1,0,0,100,3,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'createdtime','ec_memdays',1,'70','createdtime','Created Time',1,0,0,100,13,".$next_blockid.",2,'T~O',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'smcreatorid','ec_memdays',1,'1004','smcreatorid','smcreator',1,0,0,100,9,".$next_blockid.",2,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'memday938','ec_memdays',1,'15','memday938','纪念日类型',1,0,0,100,5,".$next_blockid.",1,'V~O',0,1,'BAS')");
$combo_strings['memday938'] = Array('请选择','生日','子女生日','父母生日','结婚纪念日','公司成立纪念日','毕业纪念日','其他');
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'memday940','ec_memdays',1,'15','memday940','纪念日',1,0,0,100,7,".$next_blockid.",1,'V~O',0,1,'BAS')");
$combo_strings['memday940'] = Array('年(可选)');
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'memday1004','ec_memdays',1,'15','memday1004','日历类型',1,0,0,100,6,".$next_blockid.",1,'V~O',0,1,'BAS')");
$combo_strings['memday1004'] = Array('公历','农历');
$next_blockid=$this->get_next_blockid();
$this->db->query("insert into ec_blocks values (".$next_blockid.",".$tab_id.",'LBL_CUSTOM_INFORMATION',2,0,0,0,0,0)");
?>
