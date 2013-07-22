<?php
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');
require_once('include/utils/utils.php');
// Account is used to store ec_account information.
class SalesOrder extends CRMEntity {
	var $log;
	var $db;

	var $table_name = "ec_salesorder";
	var $tab_name = Array('ec_crmentity','ec_salesorder');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_salesorder'=>'salesorderid');

	var $entity_table = "ec_salesorder";

	var $object_name = "SalesOrder";

	var $new_schema = true;

	var $module_id = "salesorderid";

	var $column_fields = Array();

	var $sortby_fields = Array('subject','smownerid');


	// This is the list of ec_fields that are in the lists.
	var $list_fields = Array(
				'Subject'=>Array('salesorder'=>'subject'),
				//'ordername'=>Array('salesorder'=>'ordername'),
				//'Account Name'=>Array('account'=>'accountid'),
				'Order Status'=>Array('salesorder'=>'orderstatus'),
				'orderdate'=>Array('salesorder'=>'orderdate'),
				'duedate'=>Array('salesorder'=>'duedate'),
				'rate'=>Array('salesorder'=>'rate'),
				'ratetotal'=>Array('salesorder'=>'ratetotal'),
                 '合计'=>Array('salesorder'=>'total')
				);

	var $list_fields_name = Array(
				'Subject'=>'subject',
		        //'ordername'=>'ordername',
				//'Account Name'=>'account_id',
				'Order Status'=>'orderstatus',
				'orderdate'=>'orderdate',
				'duedate'=>'duedate',
				'rate'=>'rate',
				'ratetotal'=>'ratetotal'
				);
	var $list_link_field= 'subject';

	var $search_fields = Array(
				'Subject'=>Array('salesorder'=>'subject'),
				'ordername'=>Array('salesorder'=>'ordername'),
				//'Account Name'=>Array('account'=>'accountid'),
				'Order Status'=>Array('salesorder'=>'orderstatus'),
				'orderdate'=>Array('salesorder'=>'orderdate'),
				'duedate'=>Array('salesorder'=>'duedate'),
				'rate'=>Array('salesorder'=>'rate'),
				'ratetotal'=>Array('salesorder'=>'ratetotal')
				);

	var $search_fields_name = Array(
				'Subject'=>'subject',
		        'ordername'=>'ordername',
				//'Account Name'=>'account_id',
				'Order Status'=>'orderstatus',
				'orderdate'=>'orderdate',
				'duedate'=>'duedate',
				'rate'=>'rate',
				'ratetotal'=>'ratetotal'
				);

	// This is the list of ec_fields that are required.
	var $required_fields =  array("account_id"=>1);

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';

	/** Constructor Function for SalesOrder class
	 *  This function creates an instance of LoggerManager class using getLogger method
	 *  creates an instance for PearDatabase class and get values for column_fields array of SalesOrder class.
	 */
	function SalesOrder() {
		$this->log =LoggerManager::getLogger('SalesOrder');
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('SalesOrder');
	}

	function save_module($module)
	{
     	
		if($this->mode == "" && $this->column_fields['account_id'] != '')
		{
			$newdate = getNewDisplayDate();
			$query = "update ec_account set lastorderdate='".$newdate."',modifiedtime=NOW() where accountid='".$this->column_fields['account_id']."' and (lastorderdate is NULL or lastorderdate<'".$newdate."')";
			$this->db->query($query);
			/*$query2 = "update ec_account set ordernum=ordernum+1  where accountid='".$this->column_fields['account_id']."'";
			$this->db->query($query2);*/
		}
		
		if($this->column_fields['account_id'] != '')
		{
           	$this->saveAccountTotals($this->column_fields['account_id']);
		}


		//Based on the total Number of rows we will save the product relationship with this entity
		//in ajax save we should not call this function, because this will delete all the existing product values
		if($_REQUEST['action'] != 'SalesOrderAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW')
		{
			//Based on the total Number of rows we will save the product relationship with this entity
			$this->saveInventoryProductDetails();
		}

	}
	function saveAccountTotals($accountid){
		$query = "select sum(total) as total,count(*) as num from ec_salesorder where accountid=$accountid and deleted=0";
		$row = $this->db->getFirstLine($query);
		$total = $row['total'];
		$num = $row['num'];
		$total = getConvertedPrice($total);//convert total to $
		$query3 = "update ec_account set ordertotal ='".$total."',ordernum='".$num."'  where accountid='".$accountid."'";
		$this->db->query($query3);
	}

     /** Function to export the account records in CSV Format
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export Accounts Query.
	*/
	function create_export_query(&$order_by, &$where)
	{
		global $log;
		global $current_user;
                $log->debug("Entering create_export_query(".$order_by.",".$where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("SalesOrder", "detail_view");
		global $mod_strings;
		global $current_language;
		if(empty($mod_strings)) {
			$mod_strings = return_module_language($current_language,"SalesOrder");
		}
		$fields_list = $this->getFieldsListFromQuery($sql,$mod_strings);

		//echo($fields_list);
		$query = "SELECT $fields_list FROM ec_salesorder
				LEFT JOIN ec_account
					ON ec_account.accountid = ec_salesorder.accountid
				LEFT JOIN ec_users
					ON ec_salesorder.smownerid = ec_users.id
				LEFT JOIN ec_inventoryproductrel
					ON ec_salesorder.salesorderid=ec_inventoryproductrel.id";
		$where_auto = " ec_salesorder.deleted = 0 ";

		if($where != "")
			$query .= "WHERE ($where) AND ".$where_auto;
		else
			$query .= "WHERE ".$where_auto;

		//we should add security check when the user has Private Access
		

		if(!empty($order_by))
			$query .= " ORDER BY $order_by, ec_inventoryproductrel.sequence_no";

		$log->debug("Exiting create_export_query method ...");
		return $query;
	}

	/**	function used to get the list of fields from the input query as a comma seperated string
	 *	@param string $query - field table query which contains the list of fields
	 *	@return string $fields - list of fields as a comma seperated string
	 */
	function getFieldsListFromQuery($query,$export_mod_strings='')
	{
		global $log,$app_strings;
		global $current_language;
		$log->debug("Entering into the function getFieldsListFromQuery()");

		$pro_mod_strings = return_module_language($current_language,"Products");
		//$result = $this->db->query($query);
		//$num_rows = $this->db->num_rows($result);
		$headArr=array('合同订单编号','状态','客户名称','联系人姓名','签约日期','合同金额','产品名称','产品编码','数量','价格','备注');
		$accountrelation=array('subject','sostatus','accountid','contactid','duedate','total','productname','productcode','quantity','listprice','comment');
		for($i=0; $i < count($headArr);$i++)
		{
			//$columnName = $this->db->query_result($result,$i,"columnname");
			//$fieldlabel = $this->db->query_result($result,$i,"fieldlabel");
			//$tablename = $this->db->query_result($result,$i,"tablename");
			$columnName =$accountrelation[$i];
			$fieldlabel=$headArr[$i];
			$tablename ="ec_salesorder";
			if(!empty($export_mod_strings) && isset($export_mod_strings[$fieldlabel]))
			{
				$fieldlabel = $export_mod_strings[$fieldlabel];
			}
			elseif(isset($app_strings[$fieldlabel]))
			{
				$fieldlabel = $app_strings[$fieldlabel];
			}
			if($columnName == 'smownerid')//for all assigned to user name
			{
				$fields .= "ec_users.user_name as '".$fieldlabel."', ";
			}
			elseif($columnName == 'accountid')//Account Name
			{
				$fields .= "ec_account.accountname as '".$fieldlabel."', ";
			}
			
			elseif($columnName == 'quantity'||$columnName == 'listprice'||$columnName == 'comment')
			{
				$tablename ="ec_inventoryproductrel";
				$fields .= $tablename.".".$columnName. " '" .$fieldlabel."',";
			}
			elseif($columnName == 'productname'||$columnName == 'productcode')
			{
				$tablename ="ec_products";
				$fields .= $tablename.".".$columnName. " '" .$fieldlabel."',";
			}
			else
			{
				$query_rel = "SELECT ec_entityname.* FROM ec_entityname WHERE ec_entityname.tabid>30 and ec_entityname.entityidfield='".$columnName."'";
				$fldmod_result = $this->db->query($query_rel);
				$rownum = $this->db->num_rows($fldmod_result);
				if($rownum > 0) {
					$rel_tablename = $this->db->query_result($fldmod_result,0,'tablename');
					$rel_entityname = $this->db->query_result($fldmod_result,0,'fieldname');
					$fields .= " ".$rel_tablename.".".$rel_entityname." as '".$fieldlabel."',";
				} else {
					$fields .= $tablename.".".$columnName. " '" .$fieldlabel."',";
				}
			}
		}

		/*
		$fieldlabellist = getProductFieldLabelList("SalesOrder");
		$fieldnamelist = getProductFieldList("SalesOrder");
		//print_r($fieldlabellist);
		for($i=0;$i<count($fieldnamelist);$i++)
		{
			$productfieldname=$fieldnamelist[$i];
			$productlabel=$fieldlabellist[$i];
			$productlabel=$productlabel['LABEL'];

			if($productfieldname=='catalogname') $producttablename="ec_catalog";
			elseif($productfieldname=='vendorname') $producttablename="ec_vendor";
			elseif(strpos($productfieldname,"cf")===0) $producttablename="ec_productcf";
			else $producttablename="ec_products";

			$fields .= $producttablename.".".$productfieldname. " as '" .$productlabel."',";
		}
		$fields .="ec_inventoryproductrel.quantity as '数量',";
		$fields .="ec_inventoryproductrel.listprice as '价格',";
		$fields .="ec_inventoryproductrel.comment as '备注',";
		*/
		$fields = trim($fields,",");

		$log->debug("Exit from the function getFieldsListFromQuery()");
		return $fields;
	}

	/**	Function used to get the sort order for Sales Order listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['SALESORDER_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	 */
	function getSortOrder()
	{
		global $log;
                $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (isset($_SESSION['SALESORDER_SORT_ORDER'])?($_SESSION['SALESORDER_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for Sales Order listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['SALESORDER_ORDER_BY'] if this session value is empty then default order by will be returned.
	 */
	function getOrderBy()
	{
		global $log;
                $log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (isset($_SESSION['SALESORDER_ORDER_BY'])?($_SESSION['SALESORDER_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}

	
	/**	Function used to get the Status history of the Sales Order
	 *	@param $id - salesorder id
	 *	@return $return_data - array with header and the entries in format Array('header'=>$header,'entries'=>$entries_list) where as $header and $entries_list are arrays which contains header values and all column values of all entries
	 */
	function get_sostatushistory($id)
	{
		global $log;
		$log->debug("Entering get_sostatushistory(".$id.") method ...");
		global $mod_strings;
		global $app_strings;

		$query = 'select ec_sostatushistory.*, ec_salesorder.subject from ec_sostatushistory inner join ec_salesorder on ec_salesorder.salesorderid = ec_sostatushistory.salesorderid where ec_salesorder.deleted = 0 and ec_salesorder.salesorderid = '.$id." order by ec_sostatushistory.lastmodified desc";
		$result=$this->db->getList($query);
		$header[] = $mod_strings['Subject'];
		$header[] = $mod_strings['Account Name'];
		$header[] = $mod_strings['Total'];
		$header[] = $mod_strings['Status'];
		$header[] = $app_strings['LBL_LAST_MODIFIED'];
		foreach($result as $row)
		{
			$entries = Array();

			$entries[] = $row['subject'];
			$entries[] = $row['accountname'];
			$entries[] = $row['total'];
			$entries[] = $row['sostatus'];
			$entries[] = getDisplayDate($row['lastmodified']);

			$entries_list[] = $entries;
		}

		$return_data = Array('header'=>$header,'entries'=>$entries_list);

	 	$log->debug("Exiting get_sostatushistory method ...");

		return $return_data;
	}

	

	//get next salesorder id
	function get_next_id() {
		$query = "select count(*) as num from ec_salesorder";
		$result = $this->db->query($query);
		$num = $this->db->query_result($result,0,'num') + 1;
		//$num = $this->db->getUniqueID("ec_salesorder");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

	
	function getAssociatedProducts()
	{
		global $log;
		$log->debug("Entering getAssociatedProducts() method ...");
		$output = '';
		global $current_user;
		$product_Detail = Array();

		$query="select ec_products.*,ec_inventoryproductrel.*,ec_products.productid as crmid from ec_inventoryproductrel inner join ec_products on ec_products.productid=ec_inventoryproductrel.productid     where ec_inventoryproductrel.id=".$this->id." ORDER BY sequence_no";
		$fieldlist = getProductFieldList("SalesOrder");

		$result = $this->db->query($query);
		$num_rows=$this->db->num_rows($result);
		for($i=1;$i<=$num_rows;$i++)
		{
			$productid = $this->db->query_result($result,$i-1,'crmid');
			$product_Detail[$i]['delRow'.$i]="Del";
			$product_Detail[$i]['hdnProductId'.$i] = $productid;
			foreach($fieldlist as $fieldname) {
				if($fieldname == "productname") {
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;<a href="index.php?action=DetailView&module=Products&record='.$productid.'" target="_blank">'.$fieldvalue.'</a></td>';
				} elseif(strpos($fieldname,"price")) {
					$fieldvalue = getConvertedPriceFromDollar($fieldvalue,1);
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;'.$fieldvalue.'</td>';
				} else {
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;'.$fieldvalue.'</td>';
				}
				if($fieldname != "imagename") {
					$fieldvalue = $this->db->query_result($result,$i-1,$fieldname);
					if(strpos($fieldname,"price")) {
						$fieldvalue = getConvertedPriceFromDollar($fieldvalue,1);
					}

				}
				$product_Detail[$i][$fieldname.$i] = $fieldvalue;
			}
			$comment=$this->db->query_result($result,$i-1,'comment');
			$qty=$this->db->query_result($result,$i-1,'quantity');
			$listprice=$this->db->query_result($result,$i-1,'listprice');
			if($listprice == '')
				$listprice = 0;
			if($qty == '')
				$qty = 1;
			//calculate productTotal
			$productTotal = $qty*$listprice;
			$listprice = getConvertedPriceFromDollar($listprice);
			$productTotal = getConvertedPriceFromDollar($productTotal);
			$qty = getConvertedPriceFromDollar($qty,1);
			$product_Detail[$i]['qty'.$i]=$qty;
			$product_Detail[$i]['listPrice'.$i]=$listprice;
			$product_Detail[$i]['comment'.$i]= $comment;
			$product_Detail[$i]['productTotal'.$i]=$productTotal;
			$product_Detail[$i]['netPrice'.$i] = $productTotal;
		}

		//To set the grand total
		$grandTotal = ($this->column_fields['hdnGrandTotal'] != '')?$this->column_fields['hdnGrandTotal']:'0.00';
		$grandTotal = getConvertedPriceFromDollar($grandTotal);
		$product_Detail[1]['final_details']['grandTotal'] = $grandTotal;

		$log->debug("Exiting getAssociatedProducts method ...");

		return $product_Detail;

	}

	function getDetailAssociatedProducts()
	{
		global $log;
		$log->debug("Entering getDetailAssociatedProducts() method ...");
		global $adb;
		global $theme;
		global $log;
		global $app_strings,$current_user;
		$theme_path="themes/".$theme."/";
		$image_path=$theme_path."images/";
		$output = '';
		$fieldlabellist = getProductFieldLabelList("SalesOrder");
		$fieldnamelist = getProductFieldList("SalesOrder");

		$output .= '<table  class="table table-bordered table-hover table-condensedforev dvtable" id="proTab">
		   <tr valign="top">
			<td colspan="50" class="dvInnerHeader"><b>'.$app_strings['LBL_PRODUCT_DETAILS'].'</b></td>
		   </tr>
		   <tr valign="top">';
		foreach($fieldlabellist as $field) {
			$output .= '<td width="'.$field["LABEL_WIDTH"].'" class="lvtCol"><b>'.$field["LABEL"].'</b></td>';
		}
		$output .= '
			<td width=10% class="lvtCol"><b>'.$app_strings['LBL_QTY'].'</b></td>
			<td width=10% class="lvtCol" align="left"><b>'.$app_strings['LBL_LIST_PRICE'].'</b></td>
			<td width=15% wrap class="lvtCol" align="left"><b>'.$app_strings['LBL_COMMENT'].'</b></td>';
		$output .= '<td width=10% nowrap class="lvtCol" align="right"><b>'.$app_strings['LBL_PRODUCT_TOTAL'].'</b></td>';
		$output .= '</tr>';
		$query="select ec_products.*,ec_inventoryproductrel.*,ec_products.productid as crmid  from ec_inventoryproductrel inner join ec_products on ec_products.productid=ec_inventoryproductrel.productid    where ec_inventoryproductrel.id=".$this->id." ORDER BY sequence_no";

		$result = $adb->query($query);
		$num_rows=$adb->num_rows($result);
		$netTotal = '0.00';
		for($i=1;$i<=$num_rows;$i++)
		{

			$productid=$adb->query_result($result,$i-1,'crmid');
			$comment=$adb->query_result($result,$i-1,'comment');
			if(empty($comment)) $comment = "&nbsp;";
			$qty=$adb->query_result($result,$i-1,'quantity');
			$listprice=$adb->query_result($result,$i-1,'listprice');
			$total_1 = $qty*$listprice;
			$listprice = convertFromDollar($listprice,1);
			$total = convertFromDollar($total_1,1);
			$qty = convertFromDollar($qty,1);
			$netprice = $total_1;
			$output .= '<tr valign="top">';
			foreach($fieldnamelist as $fieldname) {
				$fieldvalue = $adb->query_result($result,$i-1,$fieldname);
				if($fieldname == "productname") {
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;<a href="index.php?action=DetailView&module=Products&record='.$productid.'" target="_blank">'.$fieldvalue.'</a></td>';
				} elseif(strpos($fieldname,"price")) {
					$fieldvalue = convertFromDollar($fieldvalue,1);
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;'.$fieldvalue.'</td>';
				} else {
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;'.$fieldvalue.'</td>';
				}
			}
			$output .= '<td class="crmTableRow small lineOnTop">&nbsp;'.$qty.'</td>';
			$output .= '<td class="crmTableRow small lineOnTop">&nbsp;'.$listprice.'</td>';
			$output .= '<td class="crmTableRow small lineOnTop" valign="bottom" align="left">&nbsp;'.$comment.'</td>';
			$output .= '<td class="crmTableRow small lineOnTop" align="right">&nbsp;'.$total.'</td>';
			$output .= '</tr>';
			$netTotal = $netTotal + $netprice; 
		}
		$output .= '</table>';

		//Display the total, adjustment, S&H details
		$output .= '<table  class="table table-bordered table-hover table-condensedforev dvtable" style="margin-top:5px;">';
 
		$grandTotal = ($netTotal != '')?$netTotal:'0.00';
		$grandTotal = convertFromDollar($grandTotal,1);
		$output .= '<tr>';
		$output .= '<td align="right" class="crmTableRow small lineOnTop"><b>'.$app_strings['LBL_GRAND_TOTAL'].'</b></td>';
		$output .= '<td align="right" class="crmTableRow small lineOnTop" width="11%"><b>￥'.$grandTotal.'</b></td>';
		$output .= '</tr>';
		$output .= '</table>';
		$log->debug("Exiting getDetailAssociatedProducts method ...");
		return $output;

	}

	function getAssociatedProductsFromQuote($quoteid)
	{
		global $log;
		$log->debug("Entering getAssociatedProductsFromQuote() method ...");
		$output = '';
		global $current_user;
		$product_Detail = Array();

		$query="select ec_products.*,ec_inventoryproductrel.*,ec_products.productid as crmid from ec_inventoryproductrel inner join ec_products on ec_products.productid=ec_inventoryproductrel.productid   where ec_inventoryproductrel.id=".$quoteid." ORDER BY sequence_no";
		$fieldlist = getProductFieldList("SalesOrder");

		$result = $this->db->query($query);
		$num_rows=$this->db->num_rows($result);
		for($i=1;$i<=$num_rows;$i++)
		{
			$productid = $this->db->query_result($result,$i-1,'crmid');
			$product_Detail[$i]['delRow'.$i]="Del";
			$product_Detail[$i]['hdnProductId'.$i] = $productid;
			foreach($fieldlist as $fieldname) {
				if($fieldname == "productname") {
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;<a href="index.php?action=DetailView&module=Products&record='.$productid.'" target="_blank">'.$fieldvalue.'</a></td>';
				} elseif(strpos($fieldname,"price")) {
					$fieldvalue = convertFromDollar($fieldvalue,1);
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;'.$fieldvalue.'</td>';
				} else {
					$output .= '<td class="crmTableRow small lineOnTop" nowrap>&nbsp;'.$fieldvalue.'</td>';
				}
				if($fieldname != "imagename") {
					$fieldvalue = $this->db->query_result($result,$i-1,$fieldname);
					if(strpos($fieldname,"price")) {
						$fieldvalue = convertFromDollar($fieldvalue,1);
					}

				} else {
					$image_query = 'select ec_attachments.path, ec_attachments.attachmentsid, ec_attachments.name from ec_products left join ec_seattachmentsrel on ec_seattachmentsrel.crmid=ec_products.productid inner join ec_attachments on ec_attachments.attachmentsid=ec_seattachmentsrel.attachmentsid where productid='.$productid;
					$result_image = $this->db->query($image_query);
					$nums = $this->db->num_rows($result_image);
					if($nums > 0) {
						$image_id = $this->db->query_result($result_image,0,'attachmentsid');
						$image_name = $this->db->query_result($result_image,0,'name');
						$image_path = $this->db->query_result($result_image,0,'path');
						$imagename = $image_path.$image_id."_".base64_encode_filename($image_name);
					} else {
						$imagename = "";
					}
				}
				$product_Detail[$i][$fieldname.$i] = $fieldvalue;
			}
			$comment=$this->db->query_result($result,$i-1,'comment');
			$qty=$this->db->query_result($result,$i-1,'quantity');
			$listprice=$this->db->query_result($result,$i-1,'listprice');
			$discountPercent= $this->db->query_result($result,$i-1,'discount_percent');
			$discountAmount=$this->db->query_result($result,$i-1,'discount_amount');
			if(is_numeric ($discountPercent))
				$discountPercent=$discountPercent*100;
			//calculate productTotal
			if(is_numeric ($discountAmount)){
				$productTotal =$qty*$discountAmount;
			}else{
				$productTotal = $qty*$listprice;
			}
			$listprice = getConvertedPriceFromDollar($listprice);
			$productTotal = getConvertedPriceFromDollar($productTotal);
			$qty = convertFromDollar($qty,1);
			$product_Detail[$i]['qty'.$i]=$qty;
			$product_Detail[$i]['listPrice'.$i]=$discountAmount;
			$product_Detail[$i]['comment'.$i]= $comment;
			$product_Detail[$i]['productTotal'.$i]=$productTotal;
			$product_Detail[$i]['netPrice'.$i] = $productTotal;
		}


		//Get the Final Discount, S&H charge, Tax for S&H and Adjustment values
		//To set the Final Discount details
		$finalDiscount = '0.00';
		$product_Detail[1]['final_details']['discount_type_final'] = 'zero';

		$subTotal = ($this->column_fields['hdnSubTotal'] != '')?$this->column_fields['hdnSubTotal']:'0.00';
		$subTotal = getConvertedPriceFromDollar($subTotal);

		$discountPercent = ($this->column_fields['hdnDiscountPercent'] != '')?$this->column_fields['hdnDiscountPercent']:'0.00';
		$discountAmount = ($this->column_fields['hdnDiscountAmount'] != '')?$this->column_fields['hdnDiscountAmount']:'0.00';

		if($this->column_fields['hdnDiscountPercent'] != '' && $this->column_fields['hdnDiscountPercent'] != '0.0')
		{
			$finalDiscount = ($subTotal*$discountPercent/100);
			$product_Detail[1]['final_details']['discount_type_final'] = 'percentage';
			$product_Detail[1]['final_details']['discount_percentage_final'] = $discountPercent;
			$product_Detail[1]['final_details']['checked_discount_percentage_final'] = ' checked';
			$product_Detail[1]['final_details']['style_discount_percentage_final'] = ' style="visibility:visible"';
			$product_Detail[1]['final_details']['style_discount_amount_final'] = ' style="visibility:hidden"';
		}
		elseif($this->column_fields['hdnDiscountAmount'] != '')
		{
			$finalDiscount = $this->column_fields['hdnDiscountAmount'];
			$finalDiscount = getConvertedPriceFromDollar($finalDiscount);
			$discountAmount = getConvertedPriceFromDollar($discountAmount);

			$product_Detail[1]['final_details']['discount_type_final'] = 'amount';
			$product_Detail[1]['final_details']['discount_amount_final'] = $discountAmount;
			$product_Detail[1]['final_details']['checked_discount_amount_final'] = ' checked';
			$product_Detail[1]['final_details']['style_discount_amount_final'] = ' style="visibility:visible"';
			$product_Detail[1]['final_details']['style_discount_percentage_final'] = ' style="visibility:hidden"';
		}
		$product_Detail[1]['final_details']['discountTotal_final'] = $finalDiscount;


		//To set the Shipping & Handling charge
		$shCharge = ($this->column_fields['hdnS_H_Amount'] != '')?$this->column_fields['hdnS_H_Amount']:'0.00';
		$shCharge = getConvertedPriceFromDollar($shCharge);
		$product_Detail[1]['final_details']['shipping_handling_charge'] = $shCharge;

		//To set the Adjustment value
		$adjustment = ($this->column_fields['txtAdjustment'] != '')?$this->column_fields['txtAdjustment']:'0.00';
		$adjustment = getConvertedPriceFromDollar($adjustment);
		$product_Detail[1]['final_details']['adjustment'] = $adjustment;

		//To set the grand total
		$grandTotal = ($this->column_fields['hdnGrandTotal'] != '')?$this->column_fields['hdnGrandTotal']:'0.00';
		$grandTotal = getConvertedPriceFromDollar($grandTotal);
		$product_Detail[1]['final_details']['grandTotal'] = $grandTotal;

		$log->debug("Exiting getAssociatedProductsFromQuote method ...");

		return $product_Detail;

	}

	/**	Function used to save the Inventory product details for the passed entity
	 *	@param object reference $this - object reference to which we want to save the product details from REQUEST values where as the entity will be Purchase Order, Sales Order, Quotes or Invoice
	 *	@param string $module - module name
	 *	@param $update_prod_stock - true or false (default), if true we have to update the stock for PO only
	 *	@return void
	 */
	function saveInventoryProductDetails()

	{
		global $log;
		$log->debug("Entering into function saveInventoryProductDetails().");
		global $app_strings;

		if($this->mode == 'edit')
		{
			$inventarr = $this->getInventProInfo($this->id);
			
//			$update_productsql2 = "update ec_products set num = num +".$inventarr['quantity']." where productid =".$inventarr['productid'];
//			$this->db->query($update_productsql2);
			deleteInventoryProductDetails($this->id,'');
		}

		$tot_no_prod = $_REQUEST['totalProductCount'];

		$prod_seq=1;
		for($i=1; $i<=$tot_no_prod; $i++)
		{
			$prod_id = $_REQUEST['hdnProductId'.$i];
			$qty = $_REQUEST['qty'.$i];
			$listprice = $_REQUEST['listPrice'.$i];
			$listprice = getConvertedPrice($listprice);//convert the listPrice into $

			$comment = addslashes($_REQUEST['comment'.$i]);

			//if the product is deleted then we should avoid saving the deleted products
			if($_REQUEST["deleted".$i] == 1)
				continue;
			$query ="insert into ec_inventoryproductrel(id, productid, sequence_no, quantity, listprice, comment) values($this->id, $prod_id , $prod_seq, $qty, $listprice, '$comment')";
			$prod_seq++;
			$this->db->query($query);
		}

		//we should update the netprice (subtotal), taxtype, group discount, S&H charge, S&H taxes, adjustment and total
		//netprice, group discount, taxtype, S&H amount, adjustment and total to entity table

		$updatequery  = " update $this->table_name set ";

		$total = getConvertedPrice($_REQUEST['total']);//convert total to $
		$updatequery .= " total='".$total."'";
		$updatequery .= " where salesorderid=$this->id"; 
		$this->db->query($updatequery);
		$log->debug("Exit from function saveInventoryProductDetails().");
	}
	//根据ID获取关联产品信息
	function getInventProInfo($id){
		 global $log;
		 global $adb;
		 $log->debug("Entering getInventProInfo() method ...");
		 $query ="select * from ec_inventoryproductrel where id={$id}";
		 $row = $adb->getFirstLine($query);
		 $arr = array();
		 $arr['productid'] = $row['productid'];
		 $arr['quantity'] = $row['quantity'];
		 
		 $log->debug("Exiting getInventProInfo method ...");
		 return $arr;
	}

	function get_generalmodules($id,$related_tabname)
	{
		global $log, $singlepane_view;
        $log->debug("Entering get_generalmodules() method ...");
		require_once("modules/$related_tabname/$related_tabname.php");
		global $app_strings;
		$focus = new $related_tabname();
		$button = '';
		if($singlepane_view == 'true')
			$returnset = '&return_module=SalesOrder&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module=SalesOrder&return_action=CallRelatedList&return_id='.$id;
		$key = "generalmodules_salesorder_query_".$related_tabname;
		$related_bean = substr($related_tabname,0,-1);
		$related_bean = strtolower($related_bean);
		$query = getSqlCacheData($key);
		if(!$query) {
			$query = "SELECT ec_".$related_bean."s.*,ec_".$related_bean."s.".$related_bean."sid as crmid,ec_users.user_name
				FROM ec_".$related_bean."s
				INNER JOIN ec_salesorder
					ON ec_salesorder.salesorderid = ec_".$related_bean."s.salesorderid
				LEFT JOIN ec_users
					ON ec_".$related_bean."s.smownerid = ec_users.id
				WHERE ec_".$related_bean."s.deleted = 0";
			setSqlCacheData($key,$query);
		}
		$query .= " and ec_".$related_bean."s.salesorderid = ".$id." ";
		$log->debug("Exiting get_generalmodules method ...");
		return GetRelatedList("SalesOrder",$related_tabname,$focus,$query,$button,$returnset);
	}
    //审批流程回调函数
    function afterEntityApprove($crmid,$approveid,$currentstepid,$status,$nextstepid){
 //       file_put_contents("D:\\log.txt", "$crmid   $approveid $currentstepid  $status\r\n", FILE_APPEND | LOCK_EX);
    }

  // 获取订单产品信息
    function getProductsInfo($salesorderid) {
		 global $log;
		 global $adb;
         $log->debug("Entering getProductsInfo method ...");
         $query = "select ec_products.productcode,ec_products.productname,ec_inventoryproductrel.quantity,ec_inventoryproductrel.listprice as price,ec_products.detail_url,ec_products.productid
		 from ec_inventoryproductrel
		 inner join ec_products on ec_products.productid = ec_inventoryproductrel.productid
		 inner join ec_salesorder on ec_salesorder.salesorderid = ec_inventoryproductrel.id
		 where ec_salesorder.deleted=0 and  ec_inventoryproductrel.id = ".$salesorderid;
		 $result = $adb->getList($query);
		 $arr = array();
		 foreach($result as $row)
		 {
			 $row['productcode'] = "<a href='index.php?action=DetailView&module=Products&record=".$row['productid']."&parenttab=Product'>".$row['productcode']."</a>";
			 $row['productname'] = "<a href='index.php?action=DetailView&module=Products&record=".$row['productid']."&parenttab=Product'>".$row['productname']."</a>";
			 $row['detail_url'] = "<a href='".$row['detail_url']."' target=\"_blank\">".$row['detail_url']."</a>";
             $arr[] =$row;
		 }

         $log->debug("Exiting getProductsInfo method ...");
		 return $arr;
    }








}

?>
