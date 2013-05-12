<?php
include_once('config.php');
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/utils/utils.php');

/** 
 ** Class to populate the module required data during installation  
 */

class MaillisttmpsDataPopulator extends CRMEntity {
		
	function MaillisttmpsDataPopulator() {
		$this->log = LoggerManager::getLogger('MaillisttmpsDataPopulator');
		$this->db = & getSingleDBInstance();
	}

	var $new_schema = true;
	function create_tables() {
		$success = $this->db->createTables("modules/Maillisttmps/Schema.xml");
		if($success == 0) {
			echo ("Error: 创建数据库表失败.\n");
		}
		elseif ($success == 1) {
			echo ("Error: 部分表创建成功。创建数据库表失败.\n");
		}
	}

	/** 
	 **Function to populate the default required data during installation  
 	*/
	function create_defautdata($is_upgrade=false) {
		//$this->db->query( "CREATE SEQUENCE ".$sequence." INCREMENT BY 1 NO MAXVALUE NO MINVALUE CACHE 1;");
		$query = "select tabid from ec_tab where name='Maillisttmps'";
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
			$this->db->query("insert into ec_tab values (".$tab_id.",'Maillisttmps',0,".$tab_id.",'Maillisttmps',null,null,1,1)");
			
		}
		//echo "tabid:".$tab_id."<br>";

		$combo_strings = array();

		include("define_fields.php");
		if(!isset($block_id1) || empty($block_id1)) {
			$block_id1 = $this->get_block_id($tab_id);		
		}
		include('modules/Maillisttmps/ModuleConfig.php');

		$this->insert_def_org_modulefield($tab_id);
		$this->db->query("insert into ec_entityname values(".$tab_id.",'Maillisttmps','ec_maillisttmps','maillisttmpname','maillisttmpsid')");

		//custom view
		//$query = "select max(cvid) as cvid from ec_customview";
		//$result = $this->db->query($query);
		//$cvid = $this->db->query_result($result,0,"cvid") + 1;
		$cvid = $this->db->getUniqueID("ec_customview");
		$customview_sql = "INSERT INTO ec_customview(cvid,viewname,setdefault,setmetrics,entitytype,setpublic) VALUES('".$cvid."','所有','1','0','Maillisttmps','0')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 0, 'ec_maillisttmps:maillisttmpname:maillisttmpname:Maillisttmps_Maillisttmp_Name:V')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 1, 'ec_maillisttmps:smownerid:assigned_user_id:Maillisttmps_Assigned_To:V')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 2, '')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 3, '')";
        $this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 4, '')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 5, '')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 6, '')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 7, '')";
		$this->db->query($customview_sql);
		$customview_sql = "INSERT INTO ec_cvcolumnlist VALUES (".$cvid.", 8, '')";
		$this->db->query($customview_sql);		

		//parent tab id:首页 1,客户管理 2,销售 3,售后服务 4,库存管理 5,财务管理 6,统计分析 7
		$this->db->query("insert into ec_parenttabrel values ('".$module_parenttabid."',".$tab_id.",'".$module_displayorder."')");

		
	

		foreach ($combo_strings as $key=>$value)
		{
			insertPicklistValues($value,$key);
		}
		
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