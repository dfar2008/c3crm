/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/

document.write("<script type='text/javascript' src='modules/Products/multifile.js'></"+"script>");
document.write("<script type='text/javascript' src='include/js/dtree.js'></"+"script>");

// catalog the tree creates
function catalogPopup_Bind(catalog_div,opens){
	//var opens = arguments[1]?arguments[1]:"1";
	new Ajax.Request(	
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Products&action=ProductsAjax&file=catalogBindAjax',
			onComplete: function(response) {
				var res = response.responseText;
				if(res == "error"){
					catalog_d = "none";					
				}else{
					var catalog = eval('('+ res +')')?eval('('+ res +')'):JSON.parse(res);
					catalog_d = new dTree('catalog_d');				
					var urlstring = '';var url='';
					for(var i=0;i<catalog.length;i++){
						if(catalog[i].depth == 0 && catalog[i].catalogid == "H1"){
							catalog[i].parentcatalogid = "-1";	
						}
						var currObj = "user_"+catalog[i].catalogid;var catalogid = catalog[i].catalogid;
						var parentcatalog = catalog[i].parentcatalog;		
						if(opens == "2"){
							catalog_d.add(catalog[i].catalogid,catalog[i].parentcatalogid,catalog[i].catalogname,
								'javascript:loadValue(\''+currObj+'\',\''+catalogid+'\',\''+parentcatalog+'\',\''+catalog[i].catalogname+'\');',
									catalog[i].catalogname,"_self","","",1);							
						}else{
							catalog_d.add(catalog[i].catalogid,catalog[i].parentcatalogid,catalog[i].catalogname,
								'javascript:loadValue(\''+currObj+'\',\''+catalogid+'\',\''+parentcatalog+'\',\''+catalog[i].catalogname+'\');',
									catalog[i].catalogname,"_self");
						}
					}
				}
				document.getElementById(catalog_div).innerHTML = catalog_d;
			}
		}
	);
}
// vendor the tree creates
function vendorPopup_Bind(vendor_div){		
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Products&action=ProductsAjax&file=VendorBindAjax',
			onComplete: function(response) {
				var res = response.responseText;
				if(res == "error"){
					vendor_d = "none";					
				}else{
					var vendor = eval('('+ res +')')?eval('('+ res +')'):JSON.parse(res);
					vendor_d = new dTree('vendor_d');
					vendor_d.add(0,-1,"供应商",'javascript:loadProductValue(\'\');',
								'供应商',"_self");
					var urlstring = '';var url='';
					for(var i=0;i<vendor.length;i++){
						vendor_d.add(vendor[i].vendorid,0,vendor[i].vendorname,
							'javascript:loadProductValue(\''+vendor[i].vendorname+'\');',
								vendor[i].vendorname,"_self");
					}
				}
				document.getElementById(vendor_div).innerHTML = vendor_d;
			}
		}
	);
}


function updateListPrice(unitprice,fieldname, oSelect)
{
	if(oSelect.checked == true)
	{
		document.getElementById(fieldname).style.visibility = 'visible';
		document.getElementById(fieldname).value = unitprice;
	}else
	{
		document.getElementById(fieldname).style.visibility = 'hidden';
	}
}

function check4null(form)
{
  var isError = false;
  var errorMessage = "";
  if (trim(form.productname.value) =='') {
			 isError = true;
			 errorMessage += "\n " + alert_arr.LBL_PRODUCT_NAME;
			 form.productname.focus();
  }

  if (isError == true) {
			 alert(alert_arr.MISSING_REQUIRED_FIELDS + errorMessage);
			 return false;
  }
  return true;
}

function set_return(product_id, product_name) {
        window.opener.document.EditView.parent_name.value = product_name;
        window.opener.document.EditView.parent_id.value = product_id;
}
function set_return_specific(product_id, product_name) {
        //getOpenerObj used for DetailView 

	if(document.getElementById('from_link').value != '')
	{
		var fldName = window.opener.document.QcEditView.product_name;
		var fldId = window.opener.document.QcEditView.product_id;
	}else if(typeof(window.opener.document.DetailView) != 'undefined')
	{
	   var fldName = window.opener.document.DetailView.product_name;
	   var fldId = window.opener.document.DetailView.product_id;
	}else
	{
	   var fldName = window.opener.document.EditView.product_name;
	   var fldId = window.opener.document.EditView.product_id;
	}
        fldName.value = product_name;
        fldId.value = product_id;
}

function set_return_formname_specific(formname,product_id, product_name) {
        window.opener.document.EditView1.product_name.value = product_name;
        window.opener.document.EditView1.product_id.value = product_id;
}
function add_data_to_relatedlist_old(entity_id,recordid) {

        opener.document.location.href="index.php?module={RETURN_MODULE}&action=updateRelations&smodule={SMODULE}&destination_module=Products&entityid="+entity_id+"&parid="+recordid;
}

function set_return_inventory(product_id,product_name,unitprice,qtyinstock,taxstr,row_id,productcode) {
	curr_row = row_id;

	window.opener.document.EditView.elements["productName"+curr_row].value = product_name;
	window.opener.document.EditView.elements["hdnProductId"+curr_row].value = product_id;
	window.opener.document.EditView.elements["listPrice"+curr_row].value = unitprice;
	if(qtyinstock == "") qtyinstock = 0;
	//getOpenerObj("unitPrice"+curr_row).innerHTML = unitprice;
	getOpenerObj("qtyInStock"+curr_row).innerHTML = qtyinstock;
	getOpenerObj("productcode"+curr_row).innerHTML = productcode;
	window.opener.document.EditView.elements["qty"+curr_row].value = 1;
	window.opener.document.EditView.elements["qty"+curr_row].focus();
}

function set_return_inventory_po(product_id,product_name,unitprice,productcode,curr_row) {
        window.opener.document.EditView.elements["productName"+curr_row].value = product_name;
        window.opener.document.EditView.elements["hdnProductId"+curr_row].value = product_id;
	window.opener.document.EditView.elements["listPrice"+curr_row].value = unitprice;
	//getOpenerObj("unitPrice"+curr_row).innerHTML = unitprice;
	getOpenerObj("productcode"+curr_row).innerHTML = productcode;
	
	window.opener.document.EditView.elements["qty"+curr_row].focus()
}
function set_return_inventory_noprice(product_id,product_name,curr_row,qtyinstock,productcode) {
    window.opener.document.EditView.elements["productName"+curr_row].value = product_name;
    window.opener.document.EditView.elements["hdnProductId"+curr_row].value = product_id;
	getOpenerObj("qtyInStock"+curr_row).innerHTML = qtyinstock;
	getOpenerObj("productcode"+curr_row).innerHTML = productcode;
	window.opener.document.EditView.elements["qty"+curr_row].focus();
}

function set_return_inventory_check(product_id,product_name,curr_row,productcode,usageunit,qtyinstock) {
    window.opener.document.EditView.elements["productName"+curr_row].value = product_name;
    window.opener.document.EditView.elements["hdnProductId"+curr_row].value = product_id;
	window.opener.document.EditView.elements["productcode"+curr_row].value = productcode;
	window.opener.document.EditView.elements["usageunit"+curr_row].value = usageunit;
	window.opener.document.EditView.elements["qtyinstock"+curr_row].value = qtyinstock;
	window.opener.document.EditView.elements["qtyinreal"+curr_row].focus();
}
	

function set_return_product(product_id, product_name) {
    window.opener.document.EditView.product_name.value = product_name;
    window.opener.document.EditView.product_id.value = product_id;
}
function getImageListBody() {
	if (browser_ie) {
		var ImageListBody=getObj("ImageList")
	} else if (browser_nn4 || browser_nn6) {
		if (getObj("ImageList").childNodes.item(0).tagName=="TABLE") {
			var ImageListBody=getObj("ImageList")
		} else {
			var ImageListBody=getObj("ImageList")
		}
	}
	return ImageListBody;
}

function check_duplicate() {
	flag = formValidate();
	if(flag) {
		check_duplicate_ajax();
	}
}
function check_duplicate_ajax()
{
	if(window.document.EditView.productcode != undefined)
	{
		var productcode = window.document.EditView.productcode.value;
		if(productcode == "") {
			alert("产品编码不能为空");
			window.document.EditView.productcode.focus();
			return false;
		}
		var record = window.document.EditView.record.value;
		new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Products&action=ProductsAjax&file=Save&ajax=true&dup_check=true&productcode='+productcode+'&record='+record,
                        onComplete: function(response) {
							var result = trim(response.responseText);
							if(result.indexOf('SUCCESS') > -1)
										document.EditView.submit();
							else
										alert(result);
						}
                }
        );
	} else {
		document.EditView.submit();
	}
	
}

function clearSearchResult(module){
    $("status").style.display="inline";
    new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody:'clearquery=true&file=index&module='+module+'&action='+module+'Ajax&ajax=true',
			onComplete: function(response) {
			        moveMe('searchAcc');
				searchshowhide('searchAcc','advSearch');
				for(i=1;i<=26;i++)
				{
					var data_td_id = 'alpha_'+ eval(i);
					getObj(data_td_id).className = 'searchAlph';
				}
				$("status").style.display="none";
                                result = response.responseText.split('&#&#&#');
                                $("ListViewContents").innerHTML= result[2];
                                result[2].evalScripts();
                                if(result[1] != '')
                                        alert(result[1]);
			}
	       }
        );

}