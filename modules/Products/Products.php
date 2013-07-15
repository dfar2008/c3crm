<?php
require_once('include/logging.php');
require_once('include/database/PearDatabase.php');
require_once('data/CRMEntity.php');

class Products extends CRMEntity {
	var $log;
	var $db;

	var $unit_price;
	var $table_name = "ec_products";
	var $object_name = "Product";
	var $entity_table = "ec_products";
	var $required_fields = Array(
			'productname'=>1
	);
	var $tab_name = Array('ec_crmentity','ec_products');
	var $tab_name_index = Array('ec_crmentity'=>'crmid','ec_products'=>'productid');
	var $column_fields = Array();

	var $sortby_fields = Array('productname','pro_type','price');

        // This is the list of ec_fields that are in the lists.
		//fieldname is field name of table,columnname of ec_field
        var $list_fields = Array(
                                'Product Name'=>Array('products'=>'productname'),
                                'Product Code'=>Array('products'=>'productcode'),
								'Price'=>Array('products'=>'price'),
								'Detail Url'=>Array('products'=>'detail_url')
                                );
		//fieldname is field name of ec_field
        var $list_fields_name = Array(
								'Product Name'=>'productname',
								'Product Code'=>'productcode',
								'Price'=>'price',
								'Detail Url'=>'detail_url'
							 );
        var $list_link_field= 'productname';

    //popup list fields
		var $search_fields = Array(
                               'Product Name'=>Array('products'=>'productname'),
                                'Product Code'=>Array('products'=>'productcode'),
								'Price'=>Array('products'=>'price'),
								//'Detail Url'=>Array('products'=>'detail_url')
								
                                );
        var $search_fields_name = Array(
                                'Product Name'=>'productname',
								'Product Code'=>'productcode',
								'Price'=>'price',
								//'Detail Url'=>'detail_url'
                                     );

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'modifiedtime';
	var $default_sort_order = 'DESC';

	/**	Constructor which will set the column_fields in this object
	 */
	function Products() {
		$this->log =LoggerManager::getLogger('product');
		$this->log->debug("Entering Products() method ...");
		$this->db = & getSingleDBInstance();
		$this->column_fields = getColumnFields('Products');
		$this->log->debug("Exiting Product method ...");
	}

	function save_module($module)
	{
		

	}


	/**	Function used to get the sort order for Product listview
	 *	@return string	$sorder	- first check the $_REQUEST['sorder'] if request value is empty then check in the $_SESSION['PRODUCTS_SORT_ORDER'] if this session value is empty then default sort order will be returned.
	 */
	function getSortOrder()
	{
		global $log;
		$log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $_REQUEST['sorder'];
		else
			$sorder = (($_SESSION['PRODUCTS_SORT_ORDER'] != '')?($_SESSION['PRODUCTS_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**	Function used to get the order by value for Product listview
	 *	@return string	$order_by  - first check the $_REQUEST['order_by'] if request value is empty then check in the $_SESSION['PRODUCTS_ORDER_BY'] if this session value is empty then default order by will be returned.
	 */
	function getOrderBy()
	{
		global $log;
		$log->debug("Entering getOrderBy() method ...");
		if (isset($_REQUEST['order_by']))
			$order_by = $_REQUEST['order_by'];
		else
			$order_by = (($_SESSION['PRODUCTS_ORDER_BY'] != '')?($_SESSION['PRODUCTS_ORDER_BY']):($this->default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}

	/**	function used to get the export query for product
	 *	@param reference &$order_by - reference of the order by variable which will be added with the query
	 *	@param reference &$where - reference of the where variable which will be added with the query
	 *	@return string $query - return the query which will give the list of products to export
	 */
	function create_export_query(&$order_by, &$where)
	{
		global $log;
		$log->debug("Entering create_export_query(".$order_by.",".$where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("Products", "detail_view");
		global $mod_strings;
		global $current_language;
		if(empty($mod_strings)) {
			$mod_strings = return_module_language($current_language,"Products");
		}
		$fields_list = getFieldsListFromQuery($sql,$mod_strings);

		$query = "SELECT $fields_list FROM ".$this->table_name ."
			LEFT JOIN ec_users as ucreator
					ON ec_products.smcreatorid = ucreator.id
			WHERE ec_products.deleted = 0 ";
			//ProductRelatedToLead, Account and Potential tables are added to get the Related to field


		if($where != "")
                        $query .= " AND ($where) ";

                if(!empty($order_by))
                        $query .= " ORDER BY $order_by";

		$log->debug("Exiting create_export_query method ...");
                return $query;

	}

	function isExists($productname,$productid) {
		global $log;
		$query = "select productid from ec_products where productname='".$productname."' and productid!=".$productid;
		$result = $this->db->query($query);
		$num = $this->db->num_rows($result);
		$log->debug("Exiting isExists method ...");
		if($num > 0) return true;
		else return false;
	}

	function get_next_id() {
		$query = "select count(*) as num from ec_products";
		$result = $this->db->query($query);
		$num = $this->db->query_result($result,0,'num') + 1;
		//$num = $this->db->getUniqueID("ec_products");
		if($num > 99) return $num;
		elseif($num > 9) return "0".$num;
		else return "00".$num;
	}

	function getListQuery($where_relquery) {
		$query = "SELECT ec_products.productid as crmid,ec_products.* FROM ec_products WHERE ec_products.deleted = 0  ".$where_relquery;
		return $query;
	}


}
?>