<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/

// takes a string and parses it into one record per line,
// one ec_field per delimiter, to a maximum number of lines
// some ec_files have a header, some dont.
// keeps track of which ec_fields are used

/**	function used to parse the file
 *	@param string $file_name - file name
 *	@param character $delimiter - delimiter of the csv file
 *	@param int $max_lines - maximum number of lines to parse
 *	@param int $has_header - if the file has header then 1 otherwise 0
 *	@return array $ret_array - return an array which will be "rows"=>&$rows, "field_count"=>$field_count where as &rows is the reference of rows which contains all the parsed rows and $field_count is the number of fields available per row
 */
function parse_import($file_name,$delimiter,$max_lines,$has_header)
{
    include_once("include/utils/utils.php");
	$line_count = 0;
	$field_count = 0;
	$rows = array();
	$return = array();
	if (!is_file($file_name))
	{
		return -1;
	}
	
	if(isset($_SESSION['import_rows_in_excel']) && $_SESSION['import_rows_in_excel'] != "")
	{
		$return = $_SESSION['import_rows_in_excel'];
	}
	else
	{
//		require_once("include/excel/excel_class.php");
		Read_Excel_File2($file_name,$return);
		$_SESSION['import_rows_in_excel'] = $return;
	}
	

	if(is_array($return) && count($return) > 0)
	{
		foreach($return as $sheet)
		{	
			for ($i=0;$i<count($sheet);$i++)
			{
				if(($max_lines == -1 || $line_count < $max_lines)) {
					$fields = $sheet[$i];
					if (count($fields) == 1 && isset($fields[0]) && $fields[0] == '')
					{
						break;
					}
					$this_field_count = count($fields);
					if ($this_field_count > $field_count)
					{
						$field_count = $this_field_count;
					}
					array_push($rows,$fields);
					$line_count++;
				} else
				{
					break;
				}
			}
			break;
		}
	}
	// got no rows
	if (count($rows) == 0)
	{
		return -3;
	}
	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}

function parse_import_new($file_name,$delimiter,$max_lines,$has_header)
{
    include_once("include/utils/utils.php");
	$line_count = 0;
	$field_count = 0;
	$rows = array();
	if (!is_file($file_name))
	{
		return -1;
	}

//	if(isset($_SESSION['import_rows_in_excel']) && $_SESSION['import_rows_in_excel'] != "")
//	{
//		$return = $_SESSION['import_rows_in_excel'];
//	}
//	else
//	{
////		require_once("include/excel/excel_class.php");
//		Read_Excel_File2($file_name,$return);
//		$_SESSION['import_rows_in_excel'] = $return;
//	}
	$return = array();

    Read_Excel_File2($file_name,$return);

	if(is_array($return) && count($return) > 0)
	{
		foreach($return as $sheet)
		{
			for ($i=0;$i<count($sheet);$i++)
			{
				if(($max_lines == -1 || $max_lines !='')) {
					$fields = $sheet[$i];
					if (count($fields) == 1 && isset($fields[0]) && $fields[0] == '')
					{
						break;
					}
					$this_field_count = count($fields);
					if ($this_field_count > $field_count)
					{
						$field_count = $this_field_count;
					}
					array_push($rows,$fields);
					$line_count++;
				} else
				{
					break;
				}
			}
			break;
		}
	}
	// got no rows
	if (count($rows) == 0)
	{
		return -3;
	}
	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}

function parse_import_csv($file_name,$delimiter,$max_lines,$has_header)
{
	$line_count = 0;

	$field_count = 0;

	$rows = array();

	if (! is_file($file_name))
	{
		return -1;
	}

	$fh = fopen($file_name,"r");

	if (! $fh)
	{
		return -1;
	}
	setlocale(LC_ALL,'zh_CN.GBK');
	while ( (( $fields = fgetcsv($fh, 4096, $delimiter) ) !== FALSE)
		&& ( $max_lines == -1 || $line_count < $max_lines))
	{

		if ( count($fields) == 1 && isset($fields[0]) && $fields[0] == '')
		{
			break;
		}
		$this_field_count = count($fields);

		if ( $this_field_count > $field_count)
		{
			$field_count = $this_field_count;
		}

		array_push($rows,$fields);

		$line_count++;

	}

	// got no rows
	if ( count($rows) == 0)
	{
		return -3;
	}
	else
	{
		// converted to UTF-8
		global $default_export_charset;
		foreach($rows as $rowKey => $row)
		{
			foreach($row as $k => $v) {
				$row[$k] = iconv_ec("GBK","UTF-8",$v);
			}
			$rows[$rowKey] = $row;
		}
	}

	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}
function chkCode($string){
   $code = array('ASCII', 'GBK', 'UTF-8');
	foreach($code as $c){
	  if( $string === iconv('UTF-8', $c, iconv($c, 'UTF-8', $string))){
	  	 return $c;
	  }
	}
	return null;
}
function parse_import_csv_new($file_name,$delimiter,$max_lines,$has_header)
{
	$line_count = 0;

	$field_count = 0;

	$rows = array();
	/*if (! is_file($file_name))
	{
		return -1;
	}*/
	
//	$s = new SaeStorage();
//	
//	$fh = $s->read( 'upload' , $file_name) ;
    $fh = file_get_contents($file_name);
	//echo "fh:".$fh."<br>";
    
	
	//$encode = chkCode($fh);
	
//	if($encode !='GBK'){
//		return -5;	
//	}
	
	if ($fh == false)
	{
		return -3;
	}
	$fh = iconv_ec("GBK","UTF-8",$fh);
	//echo "fh2:".$fh."<br>";
    //phpinfo();
    //exit();

	$line_arr =  str_getcsv($fh,"\n");
	$line_count = count($line_arr);// num
	
	if($line_count >2001){
		return -4;
	}
	$rows = array();
	foreach($line_arr as $key=>$line){
		$arr = str_getcsv($line,",");
		$rows[$key] = $arr;
	}
	
	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$line_count
	);
	
	//$s->delete( 'upload' , $file_name) ;
	unlink($file_name);
	
	return $ret_array;

}

/**	function used to parse the act file
 *	@param string $file_name - file name
 *	@param character $delimiter - delimiter of the csv file
 *	@param int $max_lines - maximum number of lines to parse
 *	@param int $has_header - if the file has header then 1 otherwise 0
 *	@return array $ret_array - return an array which will be "rows"=>&$rows, "field_count"=>$field_count where as &rows is the reference of rows which contains all the parsed rows and $field_count is the number of fields available per row
 */
function parse_import_act($file_name,$delimiter,$max_lines,$has_header)
{
	$line_count = 0;

	$field_count = 0;

	$rows = array();

	if (! is_file($file_name))
	{
		return -1;
	}

	$fh = fopen($file_name,"r");

	if (! $fh)
	{
		return -1;
	}

	while ( ($line = fgets($fh, 4096))
                && ( $max_lines == -1 || $line_count < $max_lines) )

	{

		$line = trim($line);
		$line = substr_replace($line,"",0,1);
		$line = substr_replace($line,"",-1);
		$fields = explode("\",\"",$line);

		$this_field_count = count($fields);

		if ( $this_field_count > $field_count)
		{
			$field_count = $this_field_count;
		}

		array_push($rows,$fields);

		$line_count++;

	}

	// got no rows
	if ( count($rows) == 0)
	{
		return -3;
	}

	$ret_array = array(
		"rows"=>&$rows,
		"field_count"=>$field_count
	);

	return $ret_array;

}

function Read_Excel_File2($file_name,&$result){
	global $log;
	$log->debug("Entering into function Read_Excel_File2()");
    require_once 'include/PHPExcel/Classes/PHPExcel/IOFactory.php';
    $result=null;
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
//    $objReader->setReadDataOnly(true);
    try{
        $objPHPExcel = $objReader->load($file_name);
    }catch(Exception $e){}
    if(!isset($objPHPExcel)) return "无法解析文件";
    $allobjWorksheets = $objPHPExcel->getAllSheets();
    foreach($allobjWorksheets as $objWorksheet){
        $sheetname=$objWorksheet->getTitle();
        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        for ($row = 1; $row <= $highestRow; ++$row) {
            for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                $cell =$objWorksheet->getCellByColumnAndRow($col, $row);
                $value=$cell->getValue();
                if($cell->getDataType()==PHPExcel_Cell_DataType::TYPE_NUMERIC){
                    $cellstyleformat=$cell->getParent()->getStyle( $cell->getCoordinate() )->getNumberFormat();
                    $formatcode=$cellstyleformat->getFormatCode();
                    if (preg_match('/^(\[\$[A-Z]*-[0-9A-F]*\])*[hmsdy]/i', $formatcode)) {
                       $value=gmdate("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($value));
                    }else{
                        $value=PHPExcel_Style_NumberFormat::toFormattedString($value,$formatcode);
                    }
//                    echo $value,$formatcode,'<br>';

                }
                $result[$sheetname][$row-1][$col]=$value;
            }
        }
    }
	$log->debug("Exiting function Read_Excel_File2()");
    return 0;
}
?>
