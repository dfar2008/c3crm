<?php
$next_blockid=$this->get_next_blockid();
$this->db->query("insert into ec_blocks values (".$next_blockid.",".$tab_id.",'LBL_DESCRIPTION_INFORMATION',3,0,0,0,0,0)");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'description','ec_contacts',1,'19','description','Description',1,0,0,100,1,".$next_blockid.",1,'V~O',0,1,'BAS')");
$next_blockid=$this->get_next_blockid();
$this->db->query("insert into ec_blocks values (".$next_blockid.",".$tab_id.",'LBL_CONTACT_INFORMATION',1,0,0,0,0,0)");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactname','ec_contacts',1,'2','contactname','Contact Name',1,0,0,100,1,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'accountid','ec_contacts',1,'51','account_id','Account Name',1,0,0,100,2,".$next_blockid.",1,'V~M',0,1,'BAS')");

$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactsex','ec_contacts',1,'15','contactsex','contactsex',1,0,0,100,5,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contacttitle','ec_contacts',1,'1','contacttitle','contacttitle',1,0,0,100,7,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactmobile','ec_contacts',1,'1','contactmobile','contactmobile',1,0,0,100,9,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactemail','ec_contacts',1,'13','contactemail','contactemail',1,0,0,100,11,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactphone','ec_contacts',1,'1','contactphone','contactphone',1,0,0,100,13,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactfax','ec_contacts',1,'1','contactfax','contactfax',1,0,0,100,15,".$next_blockid.",1,'V~M',0,1,'BAS')");

$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactqq','ec_contacts',1,'86','contactqq','contactqq',1,0,0,100,17,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactmsn','ec_contacts',1,'87','contactmsn','contactmsn',1,0,0,100,19,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactww','ec_contacts',1,'88','contactww','contactww',1,0,0,100,21,".$next_blockid.",1,'V~M',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contactwb','ec_contacts',1,'13','contactwb','contactwb',1,0,0,100,23,".$next_blockid.",1,'V~M',0,1,'BAS')");

$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'createdtime','ec_contacts',1,'70','createdtime','Created Time',1,0,0,100,25,".$next_blockid.",2,'T~O',0,1,'BAS')");
$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'modifiedtime','ec_contacts',1,'70','modifiedtime','Modified Time',1,0,0,100,27,".$next_blockid.",2,'T~O',0,1,'BAS')");
$next_blockid=$this->get_next_blockid();
$this->db->query("insert into ec_blocks values (".$next_blockid.",".$tab_id.",'LBL_CUSTOM_INFORMATION',2,0,0,0,0,0)");
?>
