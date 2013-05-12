<?php
require_once('include/logging.php');
require_once('include/utils/utils.php');
require_once('include/utils/CommonUtils.php');
require_once('include/database/SaeMysql.php');
$log = LoggerManager::getLogger('VT');

class PreparedQMark2SqlValue {
	// Constructor
	function PreparedQMark2SqlValue($vals){
        $this->ctr = 0;
        $this->vals = $vals;
    }
    function call($matches){ 
            /** 
             * If ? is found as expected in regex used in function convert2sql 
             * /('[^']*')|(\"[^\"]*\")|([?])/ 
             * 
             */ 
            if($matches[3]=='?'){ 
                    $this->ctr++; 
                    return $this->vals[$this->ctr-1]; 
            }else{ 
                    return $matches[0]; 
            } 
    } 
}

class PearDatabase extends SaeMysql{ 
    var $database = null;
    var $dieOnError = false;
    var $query_time = 0;
	var $_genIDSQL = "update %s set id=LAST_INSERT_ID(id+1);";
	var $_genSeqSQL = "create table %s (id int not null)";
	var $_genSeq2SQL = "insert into %s values (%s)";
	var $_dropSeqSQL = "drop table %s";
	
    function isMySQL() { return $this->dbType=='mysql'; }
	function isMssql() { return $this->dbType=='mssql'; }
    
    public function println($msg)
    {
		global $log;
		if(is_array($msg))
		{
			$log->info("PearDatabse ->".print_r($msg,true));
		}
		else
		{
			$log->info("PearDatabase ->".$msg);
		}
    }

   

    public function startTransaction()
    {

    }

    public function completeTransaction()
    {	

    }

    public function hasFailedTransaction(){
    	return false;
    }
    
    public function checkError($msg='', $dieOnError=false)
    {
	
		if($this->dieOnError || $dieOnError)
		{
			die ($msg."ADODB error ".$msg."->".$this->database->ErrorMsg());
		}
		else
		{
			global $log;
			$log->error($msg);
		}
		return false;
    }

    public function change_key_case($arr)
    {
		return is_array($arr)?array_change_key_case($arr):$arr;
    }

    var $req_flist;	
    public function query($sql, $dieOnError=false, $msg='')
    {
		global $log;			
		if($this->javaStrPos($sql,'select') > -1) {
			$log->debug('select query being executed : '.$sql);
			$result = $this->getData($sql);
			if($this->errno() != 0)
			{
				$this->checkError($this->errmsg().' Query Failed:'.$sql);
			}
			if(!$result) {
				$result = array();
			}
		} else {
			$log->debug('runsql query being executed : '.$sql);
			$result = $this->runSql($sql);
			if($this->errno() != 0)
			{
				$this->checkError($this->errmsg().' Query Failed:'.$sql);
			}
		}
		return $result;
    }
	public function getList($sql)
    {
		global $log;			
		$log->debug('select query being executed : '.$sql);
		$result = $this->getData($sql);
		if($this->errno() != 0)
		{
			$this->checkError($this->errmsg().' Query Failed:'.$sql);
		}
		if(!$result) {
			$result = array();
		}
		return $result;
    }
	
    public function getEmptyBlob($is_string=true)
    {
		if ($is_string) return 'null';
		else return null;
    }

    public function updateBlob($tablename, $colname, $id, $data)	
    {
		return $this->query("UPDATE ".$tablename." SET ".$colname."='".$data."' WHERE ".$id);
    }


    public function limitQuery2($sql,$start,$count,$orderby='',$sorder='',$dieOnError=false, $msg='')
    {
		global $log;
		$log->debug('limitQuery2 sql = '.$sql .' start = '.$start .' count = '.$count);
		$sql = $sql." ORDER BY ".$orderby." ".$sorder." LIMIT ".$start.",".$count;
		$result = $this->query($sql);
		if($this->errno() != 0)
		{
			$this->checkError($this->errmsg().' Query Failed:'.$sql);
		}
		if(!$result) {
			$result = array();
		}
		return $result;
    }

    public function limitQuery($sql,$start,$count, $dieOnError=false, $msg='')
    {
		global $log;		
		$sql = $sql." LIMIT ".$start.",".$count;
		$result = $this->query($sql);
		$log->debug('limitQuery sql = '.$sql);
		if($this->errno() != 0)
		{
			$this->checkError($this->errmsg().' Query Failed:'.$sql);
		}
		if(!$result) {
			$result = array();
		}
		return $result;		
    }
    
//    function getOne($sql, $dieOnError=false, $msg='')
//    {
//		$result = $this->limitQuery($sql,1,-1);
//		if($result === false) $this->checkError($msg.' Get one Query Failed:' . $sql . '::', $dieOnError);
//		return $result;	
//    }

    public function getFieldsArray($result)
    {
		$field_array = array();
		if(is_array($result) && is_array($result[0]))
		{
			$field_array = array_keys($result[0]);
		}
		return $field_array;			
    }
    
    public function getRowCount($result){
		$rows = 0;
		if(is_array($result)) {
			$rows = count($result);
		}
		return $rows;			
    }

    public function num_rows($result)
    {
		return $this->getRowCount($result);
    }

    public function num_fields(&$result)
    {
		$field_array = array();
		if(is_array($result) && is_array($result[0]))
		{
			$field_array = array_keys($result[0]);
		}
		$num = count($field_array);
		return $num;
    }

    public function sql_quote($data)
    {
		if (is_array($data))
		{
			switch($data{'type'})
			{
				case 'text':
				case 'numeric':
				case 'integer':
				case 'oid':
					return $this->quote($data{'value'});
					break;
				case 'timestamp':
					return $this->formatDate($data{'value'});
					break;
				default:
					throw new Exception("unhandled type: ".serialize($cur));
			}
		} else
			return $this->quote($data);
    }
    public function sql_concat($list)
    {
	    switch ($this->dbType)
	    {
		    case 'mysql':
			    return 'concat('.implode(',',$list).')';
		    case 'pgsql':
			    return '('.implode('||',$list).')';
		    default:
			    throw new Exception("unsupported dbtype \"".$this->dbType."\"");
	    }
    }

    public function query_result($result, $row, $col=0)
    {
		$coldata = "";
		if (is_array($result) && is_array($result[$row])) {
			$coldata = $result[$row][$col];
		}		
		return $coldata;
    }


    public function requireSingleResult($sql, $dieOnError=false,$msg='', $encode=true)
    {
		$result = $this->query($sql, $dieOnError, $msg);

		if($this->getRowCount($result) == 1)				
			return $result;
		$this->log->error('Rows Returned:'. $this->getRowCount($result) .' More than 1 row returned for '. $sql);
		return false;
    } 


    public function quote($string){
		return $this->qstr($string);	
    }
	public function qstr($s,$magic_quotes=false)
	{
		if (!$magic_quotes) {	
			$s = "'".$this->escape($s)."'";
			return $s;
		}		
		// undo magic quotes for "
		$s = str_replace('\\"','"',$s);
		return "'$s'";
	}

    public function disconnect() {
		$this->closeDb();
    }
	public function formatString($tablename,$fldname, $str)
    {
		return "'".$str."'";
	}
    public function formatString_old($tablename,$fldname, $str)
    {
		$key = "tablemetacolumns_".$tablename;
		$metaColumns = getSqlCacheData($key);
		if(!$metaColumns) {
			$metaColumns = array();
			$sql = "select COLUMN_NAME,DATA_TYPE from information_schema.columns where table_name='".$tablename."'";
			$result = $this->getData($sql);			
			foreach ( $result as $fld )
			{
				$colname = $fld["COLUMN_NAME"];
				$datatype = $fld["DATA_TYPE"];
				$metaColumns[$colname] = $datatype;
			}
			setSqlCacheData($key,$metaColumns);
		}
		if(isset($metaColumns[$fldname])) {			
			$fldtype = strtoupper($metaColumns[$fldname]); 	
			if(strcmp($fldtype,'CHAR')==0 || strcmp($fldtype,'VARCHAR') == 0 || strcmp($fldtype,'VARCHAR2') == 0 || strcmp($fldtype,'LONGTEXT')==0 || strcmp($fldtype,'TEXT')==0)
			{
				if(empty($str) || $str == 'null' || $str == 'NULL') return $this->quote('');
				else return "'".$str."'";
			}
			else if(strcmp($fldtype,'DATE') == 0 || strcmp($fldtype,'TIMESTAMP')== 0 || strcmp($fldtype,'DATETIME') == 0)
			{
				return $this->formatDate($str);
			}
			else if((strcmp($fldtype,'NUMERIC') == 0 || strcmp($fldtype,'INT') == 0) && empty ($str))
			{
				return '0';
			}
			else
			{
				//if(empty ($str)) return '';
				//else return "'".$str."'";
				return "'".$str."'";
			}			
			
		} else {
			return "'".$str."'";
		}
		return $str;
    }

    public function formatDate($datetime, $strip_quotes=false)
    {
		$date = date("Y-m-d H:i:s", strtotime($datetime));
		if($strip_quotes == true) {
			return trim($date, "'");
		}
		if($date == 'null' || $date == 'NULL') return $this->quote('');
		return "'".$date."'";
    }

    public function getUniqueID($seqname)
    {
		$seqname = $seqname."_seq";
		$getnext = sprintf($this->_genIDSQL,$seqname);
		$rs = $this->runSql($getnext);
		if (!$rs) {
			$entityTable = substr($seqname,0,-4);
			$query = "select count(*) as countnum from ".$entityTable;
			$startID = $this->GetOne($query) + 1;
			$u = strtoupper($seqname);
			$this->runSql(sprintf($this->_genSeqSQL,$seqname));
			$this->runSql(sprintf($this->_genSeq2SQL,$seqname,$startID-1));
			$rs = $this->runSql($getnext);
		}
		$this->genID = $this->lastId();
		return $this->genID;
    }

	public function getOne($sql) {
		return $this->getVar($sql);
	}
	public function getFirstLine($sql) {
		$result = $this->getLine($sql);
		if($this->errno() != 0)
		{
			$this->checkError($this->errmsg().' Query Failed:'.$sql);
		}
		if(!$result) {
			$result = array();
		}
		return $result;
	}
    //get first row
	public function fetch_array($result)
	{		
		if(is_array($result) && count($result)>0) {
			$firstrow = $result[0];
			return $firstrow;
		}
		return false;		
	}
	public function fetchByAssoc($result, $rowNum = -1, $encode=true)
	{		
		if(is_array($result) && count($result)>0) {
			$firstrow = $result[0];
			return $firstrow;
		}
		return false;		
	}

	/**
	 * Convert PreparedStatement to SQL statement
	 */
	function convert2Sql($ps, $vals) {
		if(empty($vals)) { return $ps; }
		// TODO: Checks need to be added array out of bounds situations
		for($index = 0; $index < count($vals); $index++) {
			if(is_string($vals[$index])) {
				if($vals[$index] == '') {
					$vals[$index] = $this->quote($vals[$index]);
				}
				else {
					$vals[$index] = "'".$this->sql_escape_string($vals[$index]). "'";
				}
			} 
			if($vals[$index] === null) {
				$vals[$index] = "NULL";
			}
		}
		$sql = preg_replace_callback("/('[^']*')|(\"[^\"]*\")|([?])/", array(new PreparedQMark2SqlValue($vals),"call"), $ps); 
		return $sql;
	}

	function pquery($sql, $params, $dieOnError=false, $msg='') {		
		global $log;
		$log->debug('Prepared sql query being executed : '.$sql);
		$params = $this->flatten_array($params);
		if (count($params) > 0) {
			$log->debug('Prepared sql query parameters : [' . implode(",", $params) . ']'); 
		}		
		$sql = $this->convert2Sql($sql, $params);
		$result = $this->query($sql);	
		return $result;	
	}

	/**
	 * Flatten the composite array into single value.
	 * Example:
	 * $input = array(10, 20, array(30, 40), array('key1' => '50', 'key2'=>array(60), 70));
	 * returns array(10, 20, 30, 40, 50, 60, 70);
	 */
	function flatten_array($input, $output=null) {
		if($input == null) return null;
		if($output == null) $output = array();
		foreach($input as $value) {
			if(is_array($value)) {	
				$output = $this->flatten_array($value, $output);
			} else {	
				array_push($output, $value);
			}
		}
		return $output;
	}
	
	
	//To get a function name with respect to the database type which escapes strings in given text 
	public function sql_escape_string($str)
	{
		$result_data = $this->escape($str);			
		return $result_data;
	}
	function javaStrPos($base,$findme)
	{
		$result = stripos($base,$findme);
		if ($result === false) $result = -1;
		return $result;
	}
	function addTableField($tableName,$add_filelds,$type = "int",$size="11",$is_null = "null"){
		if($tableName && $tableName != "" && $add_filelds && $add_filelds != ""){
			if($type == "int"){
				if($size == "30"){
					$size = "11";
				}
				$fileldtype = "INT({$size})";
			}else if($type == "string"){
				$fileldtype = "VARCHAR( ".$size." ) CHARACTER SET utf8 COLLATE utf8_general_ci";
			}else if($type == "varchar"){
				$fileldtype = "VARCHAR( ".$size." ) ";
			}else if($type == "price"){
				$fileldtype = "DECIMAL( 19, 4 )";
			}else if($type == "timestamp"){
				$fileldtype = "timestamp";
			}else if($type == "numeric"){
				$fileldtype = "numeric( 18, 4 )";
			}else if($type == "date"){
				$fileldtype = "DATE";
			}else if($type == "time"){
				$fileldtype = "DATETIME";
			}else if($type == "uniqueidentifier"){
				$fileldtype = "uniqueidentifier";
			}else if($type == "text"){
				$fileldtype = "TEXT";
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
			$result = $this->query($query);
			return $result;
		}
		return false;
		
	}
	public function __destruct() {
			$this->close_db();
	}
} /* End of class */

function getSingleDBInstance(){
	static $db = false;
    if ($db === false)
    {		
		global $log;		
		$log->info("start create peardatabase");		
		$db = new PearDatabase();
		$log->info("end create peardatabase");	
	}    
	return $db;
}
if(empty($adb)) {
	$adb = getSingleDBInstance();
}
?>
