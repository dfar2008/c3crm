/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/

function set_return_specific(id, name) {
        window.opener.document.EditView.memdayname.value = name;
        window.opener.document.EditView.memdaysid.value = id;
}

function set_return(id, name) {
        window.opener.document.EditView.memdayname.value = name;
        window.opener.document.EditView.memdaysid.value = id;
}


function settotalnoofrows() {
	var max_row_count = document.getElementById('proTab').rows.length;
        max_row_count = eval(max_row_count)-2;

	//set the total number of products
	document.EditView.totalProductCount.value = max_row_count;	
}

function productPickList(currObj,module, row_no,vendor_id) {
	var trObj=currObj.parentNode.parentNode
	var rowId=row_no;//parseInt(trObj.id.substr(trObj.id.indexOf("w")+1,trObj.id.length))
	popuptype = 'inventory_prod';	
	window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype="+popuptype+"&curr_row="+rowId,"productWin","width=740,height=565,resizable=0,scrollbars=0,status=1,top=150,left=200");
}

function priceBookPickList(currObj, row_no) {
	var trObj=currObj.parentNode.parentNode
	var rowId=row_no;//parseInt(trObj.id.substr(trObj.id.indexOf("w")+1,trObj.id.length))
	window.open("index.php?module=PriceBooks&action=Popup&html=Popup_picker&form=EditView&popuptype=inventory_pb&fldname=listPrice"+rowId+"&productid="+getObj("hdnProductId"+rowId).value,"priceBookWin","width=640,height=565,resizable=0,scrollbars=0,top=150,left=200");
}


function getProdListBody() {
	if (browser_ie) {
		var prodListBody=getObj("productList").children[0].children[0]
	} else if (browser_nn4 || browser_nn6) {
		if (getObj("productList").childNodes.item(0).tagName=="TABLE") {
			var prodListBody=getObj("productList").childNodes.item(0).childNodes.item(0)
		} else {
			var prodListBody=getObj("productList").childNodes.item(1).childNodes.item(1)
		}
	}
	return prodListBody;
}


function deleteRow(module,i)
{
	rowCnt--;
	var tableName = document.getElementById('proTab');
	var prev = tableName.rows.length;
//	document.getElementById('proTab').deleteRow(i);
	document.getElementById("row"+i).style.display = 'none';
	document.getElementById("hdnProductId"+i).value = "";
	//document.getElementById("productName"+i).value = "";
	document.getElementById('deleted'+i).value = 1;    
}



//Method changed as per advice by jon http://forums.vtiger.com/viewtopic.php?t=4162
function roundValue(val) {
   val = parseFloat(val);
   val = Math.round(val*10000)/10000;
   val = val.toString();
   
   if (val.indexOf(".")<0) {
      //val+=".00"
   } else {
      var dec=val.substring(val.indexOf(".")+1,val.length)
      if (dec.length>4)
         val=val.substring(0,val.indexOf("."))+"."+dec.substring(0,4)
      else if (dec.length==1)
         val=val+"0"
   }
   
   
   return val;
} 

//This function is used to validate the Inventory modules 
function validateInventory() 
{
	if(!formValidate())
		return false;
	
	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//As the table has two header rows, we will reduce two from table row length
    if(max_row_count == 0)
	{
		alert(alert_arr.NO_PRODUCT_SELECTED);
		return false;
	}
	if(!FindDuplicate())
		return false;
	for (var i=1;i<=max_row_count;i++) 
	{
		//if the row is deleted then avoid validate that row values
		if(document.getElementById("deleted"+i).value == 1)
			continue;
		if (!emptyCheck("productName"+i,alert_arr.LBL_PRODUCT,"text")) return false;
		if (!emptyCheck("qty"+i,alert_arr.LBL_QTY,"text")) return false;
		if (!numValidate("qty"+i,alert_arr.LBL_QTY,"any")) return false;
		if (!numConstComp("qty"+i,alert_arr.LBL_QTY,"G","0")) return false;
		if (!emptyCheck("listPrice"+i,alert_arr.LBL_LISTPRICE,"text")) return false;
		if (!numValidate("listPrice"+i,alert_arr.LBL_LISTPRICE,"any")) return false;          
	}
	calcGrandTotal();
	return true;
}

function FindDuplicate()
{
	var max_row_count = document.getElementById('proTab').rows.length;
    max_row_count = eval(max_row_count)-2;//As the table has two header rows, we will reduce two from row length
	var product_id = new Array(max_row_count-1);
	var product_name = new Array(max_row_count-1);
	product_id[1] = getObj("hdnProductId"+1).value;
	product_name[1] = getObj("productName"+1).value;
	for (var i=1;i<=max_row_count;i++)
	{
		for(var j=i+1;j<=max_row_count;j++)
		{
			if(i == 1)
			{
				product_id[j] = getObj("hdnProductId"+j).value;
			}
			if(product_id[i] == product_id[j] && product_id[i] != '')
			{
				alert(alert_arr.SELECTED_MORE_THAN_ONCE);
				return false;
			}
		}
	}
    return true;
}

function fnshow_Hide(Lay){
    var tagName = document.getElementById(Lay);
   	if(tagName.style.display == 'none')
   		tagName.style.display = 'block';
	else
		tagName.style.display = 'none';
}



function calcTotal() {
	calcGrandTotal();
}

function calcGrandTotal() {
	var total = 0;
	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//Because the table has two header rows. so we will reduce two from row length

	for (var i=1;i<=max_row_count;i++) 
	{
		if(document.getElementById('deleted'+i).value == 0)
		{			
			if (document.getElementById('qty'+i).value == "") 
				document.getElementById("qty"+i).value = 0;
			var producttotal = eval(getObj("qty"+i).value*getObj("listPrice"+i).value);
			getObj("productTotal"+i).innerHTML=roundValue(producttotal.toString());
			total += producttotal;
		}
	}

	document.getElementById("grandTotal").innerHTML = roundValue(total.toString());
	document.getElementById("total").value = roundValue(total.toString());
}


function selectProductRows(form)
{
	window.open("index.php?module=Products&action=PopupForModules&html=Popup_picker&popuptype=inventory_prods&select=enable&modules=Memdays","productWin","width=740,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");	
}




function setSelectedProductRow()
{
	var idlist = document.selectall.idlist.value;
	var id_arr = idlist.split(';');
	x = document.selectall.selected_id.length;
	if ( x != undefined) {
		for(var i = 0; i < x ; i++)
		{
			for (var j = 0; j < id_arr.length; j++) {
			        
				if(document.selectall.selected_id[i].value == id_arr[j])
				{
					document.selectall.selected_id[i].checked = true;
				}								
			}
			
		}
	} else {
	        if(document.selectall.selected_id != undefined) {
			for (var j = 0; j < id_arr.length; j++) {			        
				if(document.selectall.selected_id.value == id_arr[j])
				{
					document.selectall.selected_id.checked = true;
				}								
			}
		}
	}
}
function UpdateIDString()
{
	x = document.selectall.selected_id.length;
	var y=0;
	var idstring = document.selectall.idlist.value;
	namestr = "";
	if ( x == undefined)
	{
		if(document.selectall.selected_id != undefined) {
		        //单条记录
		        if(document.selectall.selected_id.checked) {
				var idvalue = document.selectall.selected_id.value;
				var id_arr = idstring.split(';');
				var flag = false;
				for (var j = 0; j < id_arr.length; j++) {
					if(idvalue == id_arr[j])
					{
						flag = true;
						break;
					}
				}
				if(!flag) {
					var repeated = false;
					var selectedProductsLength = opener.window.document.forms['EditView'].elements.length;
					for(var m=0;m<selectedProductsLength;m++) {
						if(opener.window.document.forms['EditView'].elements[m].name.indexOf('hdnProductId') > -1) {
							tmpProductID = opener.window.document.forms['EditView'].elements[m].name;
							tmpProductIndex = tmpProductID.substring(12);

							if(opener.window.document.forms['EditView'].elements["deleted"+tmpProductIndex].value == 0 && opener.window.document.forms['EditView'].elements[m].value == idvalue) {
								alert(alert_arr.PRODUCT_SELECTED);
								document.selectall.selected_id.checked = false;
								repeated = true;
								break;
							}
						}
					}
					if(!repeated) {
						if(idstring != "") {
							idstring = idstring + ";" + idvalue;
						} else {
							idstring = idvalue;
						}
					}
				}

			} else {
				var idvalue = document.selectall.selected_id.value+";";
				idstring = idstring.replace(idvalue,"");
			}
			y=y+1;

		}
		//return false;
	}
	else
	{
	        //多条记录
		y=0;
		for(i = 0; i < x ; i++)
		{
			if(document.selectall.selected_id[i].checked)
			{
			    var idvalue = document.selectall.selected_id[i].value;
				var id_arr = idstring.split(';');
				var flag = false;
				for (var j = 0; j < id_arr.length; j++) {
					if(idvalue == id_arr[j])
					{
						flag = true;
						break;
					}
				}
				if(!flag) {
					var repeated = false;
					var selectedProductsLength = opener.window.document.forms['EditView'].elements.length;
					for(var m=0;m<selectedProductsLength;m++) {
						if(opener.window.document.forms['EditView'].elements[m].name.indexOf('hdnProductId') > -1) {
							tmpProductID = opener.window.document.forms['EditView'].elements[m].name;
							tmpProductIndex = tmpProductID.substring(12);

							if(opener.window.document.forms['EditView'].elements["deleted"+tmpProductIndex].value == 0 && opener.window.document.forms['EditView'].elements[m].value == idvalue) {
								alert(alert_arr.PRODUCT_SELECTED);
								document.selectall.selected_id[i].checked = false;
								repeated = true;
								break;
							}
						}
					}
					if(!repeated) {
						if(idstring != "") {
							idstring = idstring + ";" + idvalue;
						} else {
							idstring = idvalue;
						}
					}
				}

			} else {
				var idvalue = document.selectall.selected_id[i].value+";";
				idstring = idstring.replace(idvalue,"");
			}
			y=y+1;
		}
	}
	if (y != 0)
	{
		document.selectall.idlist.value = idstring;
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}
	//alert(idstring);

}
function addMultiProductRow(module)
{
	UpdateIDString();
	var idlist = document.selectall.idlist.value;
	new Ajax.Request(
		  'index.php',
		  {queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody:"module=Products&action=ProductsAjax&file=getProductsByModule&ajax=true&idlist="+ encodeURIComponent(idlist)+"&basemodule="+encodeURIComponent(module),
					onComplete: function(response) {
							result = response.responseText;
							productarr = JSON.parse(result);
							for (var j = eval(productarr.length-1); j > -1; j--) {
								addProductRow(productarr[j]);
							}
							window.close();

					}
			 }
    );
}

function addProductRow(productrow)
{
	var fieldlist = productrow["fieldlist"];
	var module = window.opener.document.EditView.module.value;
	var tableName = window.opener.document.getElementById('proTab');
	var prev = tableName.rows.length;
	var count = eval(prev)-1;
	var row = tableName.insertRow(prev);
	row.id = "row"+count;
	row.style.verticalAlign = "top";
	var colone = row.insertCell(0);
	colone.className = "crmTableRow small";
	colone.innerHTML='<img src="themes/softed/images/delete.gif" border="0" onclick="deleteRow(\''+module+'\','+count+')"><input id="deleted'+count+'" name="deleted'+count+'" type="hidden" value="0">';
	var coli;
	for (var i=0;i<fieldlist.length;i++) {
		rowvalue = productrow[fieldlist[i]];
		if(rowvalue == null) rowvalue = "";
		coli = row.insertCell(i+1);
		if(fieldlist[i] == "productname") {
			coli.className = "crmTableRow small";
			coli.innerHTML= '<input id="productName'+count+'" name="productName'+count+'" class="small" value="' + rowvalue + '" readonly="readonly" type="text"><input id="hdnProductId'+count+'" name="hdnProductId'+count+'" value="'+ productrow["productid"] +'" type="hidden">';
		} else {
			coli.className = "crmTableRow small tdnowrap";
			coli.innerHTML= '&nbsp;' + rowvalue;
		}
	}
	i = i + 1;
	coli = row.insertCell(i);
	coli.className = "crmTableRow small";
	coli.innerHTML='<input id="qty'+count+'" name="qty'+count+'" type="text" class="small " style="width:50px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value=""/>';
	i = i + 1;
    coli = row.insertCell(i);
	//listprice
	coli.className = "crmTableRow small";
	coli.innerHTML= '<input id="listPrice'+count+'" name="listPrice'+count+'" type="text" class="small " style="width:70px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value="'+ productrow["listprice"] +'"/>&nbsp;<a href="javascript:;;" onclick="priceBookPickList(this,'+count+')"><img border=0 src="themes/softed/images/pricebook.gif">';

	//comments
	i = i + 1;
    coli = row.insertCell(i);
	coli.className = "crmTableRow small";
	coli.innerHTML='<input id="comment'+count+'" name="comment'+count+'" class=small style="width:100px">';

    i = i + 1;
    coli = row.insertCell(i);
	coli.className = "crmTableRow small";
	temp = '<table width="100%" cellpadding="0" cellpadding="5"><tr><td style="padding:5px;" id="productTotal'+count+'" align="right">0.00</td></tr>';
	temp += '</table>';
	temp += '<span style="display:none" id="netPrice'+count+'"><b>&nbsp;</b></span>';
	coli.innerHTML = temp;
}
// Function to Get the price for all the products of an Inventory based on the Currency choosen by the User
function updatePrices() {
	
	var prev_cur = document.getElementById('prev_selected_currency_name');
	var inventory_currency = document.EditView.currency;
	if(confirm(alert_arr.MSG_CHANGE_CURRENCY_REVISE_UNIT_PRICE)) {	
		var current_currency = "";
		var prev_currency = "";
		if (prev_cur != null && inventory_currency != null) {
			current_currency = inventory_currency.value;
			prev_currency = prev_cur.value;
			prev_cur.value = inventory_currency.value;
			//Retrieve all the prices for all the products in currently selected currency
			new Ajax.Request(
				'index.php',
				{queue: {position: 'end', scope: 'command'},
					method: 'post',
					postBody: 'module=Products&action=ProductsAjax&file=InventoryPriceAjax&current_currency='+current_currency+'&prev_currency='+prev_currency,
					onComplete: function(response)
						{
							//alert(response.responseText);
							if(trim(response.responseText).indexOf('SUCCESS') == 0) {
								var res = trim(response.responseText).split("$");
								updatePriceValues(res[1]);							
							} else {
								alert(alert_arr.ERROR);
							}			
						}
				}
			);
		}
	} else {
		if (prev_cur != null && inventory_currency != null)
			inventory_currency.value = prev_cur.value;
	}
}

// Function to Update the price for the products in the Inventory Edit View based on the Currency choosen by the User.
function updatePriceValues(rate) {
	
	if (rate == null || rate == '') return;	
	var productsListElem = document.getElementById('proTab');
	if (productsListElem == null) return;
	
	var max_row_count = productsListElem.rows.length;
	max_row_count = eval(max_row_count)-2;//Because the table has two header rows. so we will reduce two from row length

    var products_list = "";
	for(var i=1;i<=max_row_count;i++)
	{
		var list_price_elem = document.getElementById("listPrice"+i);
		list_price_elem.value = roundValue(eval(list_price_elem.value*rate));
                changeDiscountValue(3,getObj("listPrice"+i));
	}
    calcTotal();
}