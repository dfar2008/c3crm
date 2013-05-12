<?php

require_once 'include/PHPExcel/Classes/PHPExcel/IOFactory.php';
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('modules/Contacts/Contacts.php');
require_once('modules/Accounts/Accounts.php');
require_once('modules/SalesOrder/SalesOrder.php');

class ImportSalesOrder{
    var $accountfile;
    var $contactfile;
    var $empfile;
    var $accountInf;
    var $contactAccountRel;
	var $existprefix;
    var $is_update=true;
	var $skip_record;
	var $total_reocrd;
	var $skip_rows;

    function ImportSalesOrder(){
        $this->accountInf=array();
		$this->existprefix=date("Ymd His");
		$this->skip_record=0;
		$this->total_reocrd=0;
		$this->skip_rows=array();
    }

    function resetAccount(){
        $this->accountInf=array();
        $this->accountInf['contacts']=array();
    }

    function createContactInfo(){
        $contactinfo=array();
        $contactinfo['notes']=array();
        return $contactinfo;
    }

    function setAccountFile($filepath){
        $this->accountfile=$filepath;
    }

   

    function excelAccountRel(){
        $accountrelation=array(
			'subject'=>0,
			'sostatus'=>1,
            'account_id'=>2,
            'contact_id'=>3,
			'duedate'=>4,
			'salestotal'=>5,
			'productname'=>6,
			'productcode'=>7,
			'quantity'=>8,
			'listprice'=>9,
			'commet'=>10
			
        );

        return $accountrelation;
    }
	/*
	 function excelProductRel(){
        $productrelation=array(
			'subject'=>0,
            'accountid'=>1,
            'contactid'=>2,
			'duedate'=>3,
			
        );

        return $accountrelation;
    }
	*/

   

    


    function parseExcel(){
		global $log;
		$log->debug("Entering into function parseExcel()");
       

		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($this->accountfile);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn();
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);

        $accountrel=$this->excelAccountRel();
        for ($row = 2; $row <= $highestRow; ++$row) {
            $salesorderinf=array();
			
            foreach($accountrel as $accountprop=>$pos){
                if($pos<$highestColumnIndex){
                    $accountval=$objWorksheet->getCellByColumnAndRow($pos, $row)->getValue();
                    $accountval=$this->transferExcelProps(1,$accountprop,$accountval);
                    //$this->accountInf[$accountprop]=$accountval;
					$salesorderinf[$accountprop]=$accountval;
                }
            }
            // parse Contact part
           if($this->salesorderIsExist($salesorderinf)==0){
			   //invalid row
			   $this->skip_record+=1;
			   $this->skip_rows[]=$salesorderinf;
			   $this->total_reocrd+=1;
		   }else{
			   $excelrows=$this->accountInf[$salesorderinf['subject']];
			   if(!isset($excelrows)) $excelrows=array();
               $excelrows[]=$salesorderinf;
			   $this->accountInf[$salesorderinf['subject']]=$excelrows;
			   $this->total_reocrd+=1;
		   }
		   
           
            
           
        }
		//save entries
        $this->saveEntries();
		$log->debug("Exit function parseExcel()");

    }
    
	function salesorderIsExist(&$salesorderinf){
        global $adb;
		
		$salessubject=$salesorderinf['subject'];
		$excelrows=$this->accountInf[$salessubject];
		$productcode=$salesorderinf['productcode'];
		$productid=$this->productIsExist($productcode);
		if($productid==-1) return 0;
		else $salesorderinf['productid']=$productid;
		if(isset($excelrows)){
			foreach($excelrows as $otherinf){
				if($otherinf['productid']==$salesorderinf['productid']) return 0;
			}
			return 1;
		}else{
			$sql="select salesorderid from ec_salesorder where deleted=0 and subject='$salessubject' ";
			$result=$adb->query($sql);
			if($adb->num_rows($result)==0) return 1;
			else return 0;
		}

    }

	function productIsExist($productcode){
        global $adb;
        $sql="select productid from ec_products where deleted=0 and productcode='$productcode' ";
		$result=$adb->query($sql);
		if($adb->num_rows($result)==0){
			return -1;
		}
		else {
			return $adb->query_result($result,0,"productid");
		}
    }

    //1:Account,2:Contact
    function transferExcelProps($moduletype,$prop,$val){
		global $adb;
		global $current_user;
//        $accountproparr=array('bill_state','accounttype','industry','ownership');
//        $contactproparr=array('department','title','salutationtype','cf_547','cf_549','cf_551','cf_553','cf_555');
       if($moduletype==1){
		   if($prop=='smownerid'){
			   $sql="select ec_users.id from ec_users where user_name='$val' ";
			   //echo $sql;
			   $result=$adb->query($sql);
			   $userid=$adb->query_result($result,0,"id");
			   if(empty($userid)) $userid=$current_user->id;
			   return $userid;
		   }
		   elseif($prop=='account_id'){
				return $this->add_create_account($val);
		   }
		   elseif($prop=='contact_id'){
			   return $this->add_create_contact($val);
		   }
		   elseif($prop=='duedate'){
			   if(is_numeric($val)) return date("Y-m-d",PHPExcel_Shared_Date::ExcelToPHP($val));
		   }
	   }
        return $val;
    }
	
	function add_create_account($val)
    {
		global $adb;
		global $imported_ids;
        global $current_user;
		$acc_name = $val;
		if ((!isset($acc_name) || $acc_name == '') )
		{
			return; 
		}
        $arr = array();
		// check if it already exists
        $focus = new Accounts();
		$query = '';
		// if user is defining the ec_account id to be associated with this contact..

		//Modified to remove the spaces at first and last in ec_account name -- after 4.2 patch 2
		$acc_name = trim(addslashes($acc_name));
		//Modified the query to get the available account only ie., which is not deleted
		$query = "select ec_account.* from ec_account WHERE accountname like '%{$acc_name}%' and deleted=0";
        $result = $adb->query($query);
        $row = $adb->fetchByAssoc($result, -1, false);
		// we found a row with that id
		if (isset($row['accountid']) && $row['accountid'] != -1)
		{
			$focus->id = $row['accountid'];
		}
		// if we didnt find the ec_account, so create it
		if (! isset($focus->id) || $focus->id == '')
		{
				$focus->column_fields['accountname'] = $acc_name;
				$focus->column_fields['assigned_user_id'] = $current_user->id;
				$focus->column_fields['modified_user_id'] = $current_user->id;
				$focus->save("Accounts");
				$acc_id = $focus->id;
				// avoid duplicate mappings:
				if (! isset( $imported_ids[$acc_id]) )
				{
					$imported_ids[$acc_id] = 1;
				}
		}
		return $focus->id;
    }
	
	function add_create_contact($val)
    {
		
		global $imported_ids;
        global $current_user;
		global $adb;
		$contact_name = $val;
		if ((! isset($contact_name) || $contact_name == '') )
		{
			return; 
		}

        $arr = array();
		// check if it already exists
        $focus = new Contacts();
		$query = '';
		// if user is defining the ec_contact id to be associated with this contact..

		//Modified to remove the spaces at first and last in ec_contactdetails name -- after 4.2 patch 2
		$contact_name = trim(addslashes($contact_name));

		//Modified the query to get the available account only ie., which is not deleted
		$query = "select ec_contactdetails.* from ec_contactdetails WHERE lastname='{$contact_name}' and deleted=0";
        $result = $adb->query($query);

        $row = $adb->fetchByAssoc($result, -1, false);
		// we found a row with that id
        if (isset($row['contactid']) && $row['contactid'] != -1)
        {
			$focus->id = $row['contactid'];
        }

		// if we didnt find the ec_contactdetails, so create it
        if (! isset($focus->id) || $focus->id == '')
        {
			//$this->db->println("Createing new ec_account");
			$focus->column_fields['lastname'] = $contact_name;
			$focus->column_fields['assigned_user_id'] = $current_user->id;
			$focus->column_fields['modified_user_id'] = $current_user->id;
			$focus->save("Contacts");
			$contact_id = $focus->id;

			// avoid duplicate mappings:
			if (! isset( $imported_ids[$contact_id]) )
			{
				$imported_ids[$acc_id] = 1;
			}
        }

		// now just link the ec_contactdetails
        return $focus->id;

    }
	
    function saveEntries(){
		global $log;
		$log->debug("Entering into function saveEntries()");
		
		$accountinf=$this->accountInf;		
		foreach($accountinf as $subject=>$orders){
			$firstorder=$orders[0];
			$orderid=$this->insertSalesOrder($firstorder);
			$this->updateOrderProduct($orders,$orderid);
		}
		$log->debug("Exit function saveEntries()");
    }
	

    
    

     

    
    
     function insertSalesOrder($salesorderinf){
		global $log;
		$log->debug("Entering into function insertSalesOrder()");
		
		global $adb;
		global $current_user;
		
		$focus = new SalesOrder();
		foreach($salesorderinf as $key=>$val){
			$focus->column_fields[$key]=$val;
		}
		$focus->save("SalesOrder");
		//file_put_contents("D:\\abcde.txt",$salesorderinf['duedate']);
		$log->debug("Exit function insertSalesOrder()");
		return $focus->id;
    }

    function updateOrderProduct($productinfs,$salesorderid){
		
		global $adb;
		$seq=1;
		$totalprice=$productinfs[0]['salestotal'];
		foreach($productinfs as $proinf){
			$prod_id = $proinf['productid'];
			$qty = $proinf['quantity'];
			$listprice = $proinf['listprice'];
			$comment = addslashes($proinf['commet']);
			//$totalprice+=$qty*$listprice;

			$query ="insert into ec_inventoryproductrel(id, productid, sequence_no, quantity, listprice, comment) values($salesorderid, $prod_id , $seq, $qty, $listprice, '$comment')";
			$seq++;
			$adb->query($query);
		}
		$updatequery  = "update ec_salesorder set total='$totalprice' where salesorderid='$salesorderid' ";
		$adb->query($updatequery);
    }

   

	function createXls($accountinfs) {
		$headArr=array('合同订单编号','状态','客户名称','联系人姓名','签约日期','合同金额','产品名称','产品编码','数量','价格','备注');
		$filepath=$this->accountfile;
		if(is_array ($accountinfs)&&count($accountinfs)>0){
			$objPHPExcel = new PHPExcel();
			$objWriter =PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
			$objWorksheet = $objPHPExcel->getActiveSheet();
			$rowIndex=1;
			$cellIndex=0;
			$headrows=$headArr;
			foreach($headrows as $headcell){
				$objWorksheet->getCellByColumnAndRow($cellIndex, $rowIndex)->setValue($headcell);
				$cellIndex+=1;
			}
			$rowIndex+=1;
			$cellIndex=0;
			$accountrelation=array('subject','sostatus','account_id','contact_id','duedate','salestotal','productname','productcode','quantity','listprice','commet');
			foreach($accountinfs as $accountinf){
				foreach($accountrelation as $pos=>$propname){
					$accountval=$accountinf[$propname];
					if($propname=='account_id') $accountval=getAccountName($accountval);
					if($propname=='contact_id') $accountval=getContactName($accountval);
					$objWorksheet->getCellByColumnAndRow($pos, $rowIndex)->setValueExplicit($accountval,PHPExcel_Cell_DataType::TYPE_STRING);
					
				}
				$rowIndex+=1;
			}
			$objWriter->save($filepath);

		}
	}

    
}

?>
