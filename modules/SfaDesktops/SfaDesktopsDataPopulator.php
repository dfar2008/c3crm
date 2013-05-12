<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/utils/utils.php');

/** 
 ** Class to populate the module required data during installation  
 */

class SfaDesktopsDataPopulator extends CRMEntity {
		
	function SfaDesktopsDataPopulator() {
		$this->log = LoggerManager::getLogger('SfaDesktopsDataPopulator');
		$this->db = & getSingleDBInstance();
	}

	var $new_schema = true;
	function create_tables() {

	}

	/** 
	 **Function to populate the default required data during installation  
 	*/
	function create_defautdata($is_upgrade=false) {
		//$this->db->query( "CREATE SEQUENCE ".$sequence." INCREMENT BY 1 NO MAXVALUE NO MINVALUE CACHE 1;");
		$query = "select tabid from ec_tab where name='SfaDesktops'";
		$result = $this->db->query($query);
		$noofrows = $this->db->num_rows($result);
		if($noofrows > 0) {
			$tab_id = $this->db->query_result($result,0,"tabid");
		} 
		else {
			//$tab_id = $this->db->getUniqueID("ec_tab");
			$query = "select max(tabid) as tabid from ec_tab";
			$result = $this->db->query($query);
			$tab_id = $this->db->query_result($result,0,"tabid") + 1;
			$this->db->query("insert into ec_tab values (".$tab_id.",'SfaDesktops',0,".$tab_id.",'SfaDesktops',null,null,1,1)");
			
		}
		//echo "tabid:".$tab_id."<br>";

		
		if($is_upgrade) {
			$this->db->query("delete from ec_blocks where tabid=".$tab_id);
			$this->db->query("delete from ec_field where tabid=".$tab_id);
		    $this->db->query("delete from ec_profile2field where tabid=".$tab_id);
			
			$this->db->query("delete from ec_def_org_field where tabid=".$tab_id);			
			$this->db->query("delete from ec_entityname where tabid=".$tab_id);
			$this->db->query("delete from ec_profile2tab where tabid=".$tab_id);
			$this->db->query("delete from ec_profile2standardpermissions where tabid=".$tab_id);
			$this->db->query("delete from ec_profile2utility where tabid=".$tab_id);
			$this->db->query("delete from ec_def_org_share where tabid=".$tab_id);
			$this->db->query("delete from ec_org_share_action2tab where tabid=".$tab_id);
			$this->db->query("delete from ec_moduleowners where tabid=".$tab_id);
			$this->db->query("delete from ec_parenttabrel where tabid=".$tab_id);
			$this->db->query("delete from ec_blocks where tabid=".$tab_id);
			$this->db->query("delete from ec_entityname where tabid=".$tab_id);
			$this->db->query("delete from ec_customview where entitytype='SfaDesktops'");
			$this->db->query("delete from ec_profile2tab where tabid=".$tab_id);
			$this->db->query("delete from ec_profile2standardpermissions where tabid=".$tab_id);
			$this->db->query("delete from ec_profile2utility where tabid=".$tab_id);
			$this->db->query("delete from ec_org_share_action2tab where tabid=".$tab_id);
			$this->db->query("delete from ec_parenttabrel where tabid=".$tab_id);
			$this->db->query("delete from ec_profile2tab where tabid=".$tab_id);
			$this->db->query("delete from ec_relatedlists where tabid=".$tab_id);
			$this->db->query("delete from ec_relatedlists where related_tabid=".$tab_id);
			$this->db->query("delete from ec_modulelist where tabid=".$tab_id);
		}		

		//parent tab id:首页 1,客户管理 2,销售 3,售后服务 4,库存管理 5,财务管理 6,统计分析 7
		$this->db->query("insert into ec_parenttabrel values ('".$module_parenttabid."',".$tab_id.",'".$module_displayorder."')");
		
	}

	

	function insert_def_org_modulefield($tab_id)
	{
		$this->log->debug("Entering insert_def_org_modulefield() method ...");
		$this->db->database->SetFetchMode(ADODB_FETCH_ASSOC); 
		$fld_result = $this->db->query("select * from ec_field where generatedtype=1 and displaytype in (1,2) and tabid =".$tab_id);
		$num_rows = $this->db->num_rows($fld_result);
		for($i=0; $i<$num_rows; $i++)
		{
				 $field_id = $this->db->query_result($fld_result,$i,'fieldid');
				 $this->db->query("insert into ec_def_org_field values (".$tab_id.",".$field_id.",0,1)");
		}
		$this->log->debug("Exiting insert_def_org_modulefield() method ...");
	}

	function get_next_blockid() {
		$query = "select max(blockid) as blockid from ec_blocks";
		$result = $this->db->query($query);
		$block_id = $this->db->query_result($result,0,"blockid") + 1;
		return $block_id;
	}

	function get_block_id($tab_id)
	{
		$query = "SELECT blockid FROM ec_blocks where tabid=".$tab_id." order by sequence";
		$fld_result = $this->db->query($query);
		$num_rows = $this->db->num_rows($fld_result);
		if($num_rows > 0)
		{
			 $blockid = $this->db->query_result($fld_result,0,'blockid');
			 return $blockid;		 
		}
	}
}
?>