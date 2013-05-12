<?php
		$query = "select max(blockid) as blockid from ec_blocks";
		$result = $this->db->query($query);
		$block_id1 = $this->db->query_result($result,0,"blockid") + 1;
		
		//$block_id2 = $this->db->getUniqueID("ec_blocks");
		$block_id2 = $block_id1 + 1;
		//$block_id3 = $this->db->getUniqueID("ec_blocks");
		$block_id3 = $block_id1 + 2;
		

		$this->db->query("insert into ec_blocks values (".$block_id1.",".$tab_id.",'LBL_MAILLIST_INFORMATION',1,0,0,0,0,0)");
		$this->db->query("insert into ec_blocks values (".$block_id2.",".$tab_id.",'LBL_CUSTOM_INFORMATION',2,0,0,0,0,0)");
		$this->db->query("insert into ec_blocks values (".$block_id3.",".$tab_id.",'LBL_DESCRIPTION_INFORMATION',3,0,0,0,0,0)");

		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'maillistname','ec_maillists',1,'2','maillistname','Maillist Name',1,0,0,100,1,".$block_id1.",1,'V~M',0,1,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'smownerid','ec_maillists',1,'53','assigned_user_id','Assigned To',1,0,0,100,2,".$block_id1.",1,'V~M',1,null,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'accountid','ec_maillists',1,'51','account_id','Account Name',1,0,0,100,3,".$block_id1.",1,'V~M',0,1,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'contact_id','ec_maillists',1,'57','contact_id','Contact Name',1,0,0,100,4,".$block_id1.",1,'V~O',1,null,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'salesorderid','ec_maillists',1,'80','salesorder_id','Sales Order',1,0,0,100,5,".$block_id1.",1,'V~O',1,null,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'potentialid','ec_maillists',1,'76','potential_id','Potential Name',1,0,0,100,6,".$block_id1.",1,'V~O',1,null,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'vendorid','ec_maillists',1,'81','vendor_id','Vendor Name',1,0,0,100,7,".$block_id1.",1,'V~O',1,null,'BAS')");	
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'purchaseorderid','ec_maillists',1,'79','purchaseorder_id','Purchase Order',1,0,0,100,8,".$block_id1.",1,'V~O',1,null,'BAS')");	

		$this->db->query("INSERT INTO ec_field VALUES (".$tab_id.",".$this->db->getUniqueID("ec_field").",'smcreatorid','ec_maillists', 1, '1004', 'smcreatorid', 'smcreator', 1, 0, 0, 100, 9, ".$block_id1.", 2, 'V~M', 1, NULL, 'BAS')");	
		
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'createdtime','ec_maillists',1,'70','createdtime','Created Time',1,0,0,100,13,".$block_id1.",2,'T~O',1,null,'BAS')");
		$this->db->query("insert into ec_field values (".$tab_id.",".$this->db->getUniqueID("ec_field").",'modifiedtime','ec_maillists',1,'70','modifiedtime','Modified Time',1,0,0,100,14,".$block_id1.",2,'T~O',1,null,'BAS')");

		$this->db->query("INSERT INTO ec_field VALUES (".$tab_id.", ".$this->db->getUniqueID("ec_field").", 'description', 'ec_maillists', 1, '19', 'description', 'Description', 1, 0, 0, 100, 1, ".$block_id3.", 1, 'V~O', 1, NULL, 'BAS')");

?>