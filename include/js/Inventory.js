/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

function copyAddressRight(form) {

	form.ship_street.value = form.bill_street.value;

	form.ship_city.value = form.bill_city.value;

	form.ship_state.value = form.bill_state.value;

	form.ship_code.value = form.bill_code.value;

	form.ship_country.value = form.bill_country.value;

	form.ship_pobox.value = form.bill_pobox.value;
	
	return true;

}

function copyAddressLeft(form) {

	form.bill_street.value = form.ship_street.value;

	form.bill_city.value = form.ship_city.value;

	form.bill_state.value = form.ship_state.value;

	form.bill_code.value =	form.ship_code.value;

	form.bill_country.value = form.ship_country.value;

	form.bill_pobox.value = form.ship_pobox.value;

	return true;

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
	if(module == 'PurchaseOrder') {
		popuptype = 'inventory_prod_po';
		if(vendor_id == '') {
			alert(alert_arr.VENDOR_CANNOT_EMPTY);
			return ;
		} else {
			window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype="+popuptype+"&curr_row="+rowId+"&vendor_id="+vendor_id,"productWin","width=770,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");
		}
	} else {
		window.open("index.php?module=Products&action=Popup&html=Popup_picker&form=HelpDeskEditView&popuptype="+popuptype+"&curr_row="+rowId,"productWin","width=770,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");
	}
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
    if(module != ""){//changed by dingjianting on 2007-2-25 for gloso project and quote
		calcTotal();
	}
}
/*  End */



function calcTotal() {

	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//Because the table has two header rows. so we will reduce two from row length
	var netprice = 0.00;
	for(var i=1;i<=max_row_count;i++)
	{
		rowId = i;
		
		if(document.getElementById('deleted'+rowId).value == 0)
		{
			
			var total=eval(getObj("qty"+rowId).value*getObj("listPrice"+rowId).value);
			getObj("productTotal"+rowId).innerHTML=roundValue(total.toString());			
			getObj("netPrice"+rowId).innerHTML=roundValue(total.toString())

		}
	}
	calcGrandTotal()
}

function calcGrandTotal() {
	var netTotal = 0.0, grandTotal = 0.0;
	var discountTotal_final = 0.0, finalTax = 0.0, sh_amount = 0.0, sh_tax = 0.0, adjustment = 0.0;

	//var taxtype = document.getElementById("taxtype").value;

	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//Because the table has two header rows. so we will reduce two from row length

	for (var i=1;i<=max_row_count;i++) 
	{
		if(document.getElementById('deleted'+i).value == 0)
		{
			
			if (document.getElementById("netPrice"+i).innerHTML=="") 
				document.getElementById("netPrice"+i).innerHTML = 0.0
			if (!isNaN(document.getElementById("netPrice"+i).innerHTML))
				netTotal += parseFloat(document.getElementById("netPrice"+i).innerHTML)
		}
	}
//	alert(netTotal);
	document.getElementById("netTotal").innerHTML = netTotal;
	document.getElementById("subtotal").value = netTotal;

	discountTotal_final = document.getElementById("discountTotal_final").innerHTML;
	if(discountTotal_final != "") {
		netTotal = eval(netTotal - discountTotal_final);
	}


	sh_amount = eval(netTotal*getObj("shipping_handling_charge").value/100);
	sh_amount = roundValue(sh_amount.toString());

	adjustment = getObj("adjustment").value

	//Add or substract the adjustment based on selection
	adj_type = document.getElementById("adjustmentType").value;
	if(adj_type == '+')
		//grandTotal = eval(netTotal)-eval(discountTotal_final)+eval(finalTax)+eval(sh_amount)+eval(sh_tax)+eval(adjustment)
	    grandTotal = eval(netTotal)+eval(sh_amount)+eval(adjustment)
	else
		//grandTotal = eval(netTotal)-eval(discountTotal_final)+eval(finalTax)+eval(sh_amount)+eval(sh_tax)-eval(adjustment)
		grandTotal = eval(netTotal)+eval(sh_amount)-eval(adjustment)

	document.getElementById("grandTotal").innerHTML = roundValue(grandTotal.toString())
	document.getElementById("total").value = roundValue(grandTotal.toString())
}

//Method changed as per advice by jon http://forums.vtiger.com/viewtopic.php?t=4162
function roundValue(val) {
   val = parseFloat(val);
   val = Math.round(val*100)/100;
   val = val.toString();
   
   if (val.indexOf(".")<0) {
      //val+=".00"
   } else {
      var dec=val.substring(val.indexOf(".")+1,val.length)
      if (dec.length>2)
         val=val.substring(0,val.indexOf("."))+"."+dec.substring(0,2)
      else if (dec.length==1)
         val=val+"0"
   }
   
   
   return val;
} 

//This function is used to validate the Inventory modules 
function validateInventory(module) 
{
	if(!formValidate())
		return false

	//for products, vendors and pricebook modules we won't validate the product details. here return the control
	if(module == 'Products' || module == 'Vendors' || module == 'PriceBooks')
	{
		return true;
	}

	var max_row_count = document.getElementById('proTab').rows.length;
	var row_count = 0;
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
		
		row_count ++;
	}

	if(row_count == 0)
	{
		alert(alert_arr.NO_PRODUCT_SELECTED);
		return false;
	}

	//Product - Discount validation - not allow negative values
	//if(!validateProductDiscounts())
	//	return false;

	//Final Discount validation - not allow negative values
	discount_checks = document.getElementsByName("discount_final");

	//Percentage selected, so validate the percentage
	if(discount_checks[1].checked == true)
	{
		temp = /^(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?$/.test(document.getElementById("discount_percentage_final").value);
		if(!temp)
		{
			alert(alert_arr.VALID_FINAL_PERCENT);
			return false;
		}
	}
	if(discount_checks[2].checked == true)
	{
		temp = /^(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?$/.test(document.getElementById("discount_amount_final").value);
		if(!temp)
		{
			alert(alert_arr.VALID_FINAL_AMOUNT);
			return false;
		}
	}

	//Shipping & Handling validation - not allow negative values
	temp = /^(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?$/.test(document.getElementById("shipping_handling_charge").value);
	if(!temp)
	{
		alert(alert_arr.VALID_SHIPPING_CHARGE);
		return false;
	}

	//Adjustment validation - allow negative values
	temp = /^-?(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?$/.test(document.getElementById("adjustment").value)
	if(!temp)
	{
		alert(alert_arr.VALID_ADJUSTMENT);
		return false;
	}
	return true;    
}

function FindDuplicate()
{
	var max_row_count = document.getElementById('proTab').rows.length;
        max_row_count = eval(max_row_count)-2;//As the table has two header rows, we will reduce two from row length

	var duplicate = false, iposition = '', positions = '', duplicate_products = '';

	var product_id = new Array(max_row_count-1);
	var product_name = new Array(max_row_count-1);
	product_id[1] = getObj("hdnProductId"+1).value;
	product_name[1] = getObj("productName"+1).value;
	for (var i=1;i<=max_row_count;i++)
	{
		iposition = ""+i;
		for(var j=i+1;j<=max_row_count;j++)
		{
			if(i == 1)
			{
				product_id[j] = getObj("hdnProductId"+j).value;
			}
			if(product_id[i] == product_id[j] && product_id[i] != '')
			{
				if(!duplicate) positions = iposition;
				duplicate = true;
				if(positions.search(j) == -1) positions = positions+" & "+j;

				if(duplicate_products.search(getObj("productName"+j).value) == -1)
					duplicate_products = duplicate_products+getObj("productName"+j).value+" \n";
			}
		}
	}
	if(duplicate)
	{
		//alert("You have selected < "+duplicate_products+" > more than once in line items  "+positions+".\n It is advisable to select the product just once but change the Qty. Thank You");
		if(!confirm(alert_arr.SELECTED_MORE_THAN_ONCE+"\n"+duplicate_products+"\n "+alert_arr.WANT_TO_CONTINUE))
			return false;
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


//Function used to add a new product row in PO, SO, Quotes and Invoice
function fnAddProductRow(module,image_path){
	rowCnt++;

	var tableName = document.getElementById('proTab');
	var prev = tableName.rows.length;
    	var count = eval(prev)-1;//As the table has two headers, we should reduce the count
    	var row = tableName.insertRow(prev);
		row.id = "row"+count;
		row.style.verticalAlign = "top";

	
	var colone = row.insertCell(0);
	var coltwo = row.insertCell(1);
	var colthree = row.insertCell(2);
	if(module == "PurchaseOrder"){		
		var colfive = row.insertCell(3);
		var colsix = row.insertCell(4);
		var colseven = row.insertCell(5);
		var coleight = row.insertCell(6);
	}
	else{
		var colfour = row.insertCell(3);
		var colfive = row.insertCell(4);
		var colsix = row.insertCell(5);
		var colseven;
		var coleight;
		if(module != ""){//changed by dingjianting on 2007-2-25 for gloso project and quote
			colseven = row.insertCell(6);
			coleight = row.insertCell(7);
		}
	}
	
	//Delete link
	colone.className = "crmTableRow small";
	colone.innerHTML='<img src="'+image_path+'delete.gif" border="0" onclick="deleteRow(\''+module+'\','+count+')"><input id="deleted'+count+'" name="deleted'+count+'" type="hidden" value="0">';

	//Product Name with Popup image to select product
	coltwo.className = "crmTableRow small"
	if(module == "PurchaseOrder"){
		coltwo.innerHTML= '<input id="productName'+count+'" name="productName'+count+'" class="small" style="width: 100px;" value="" readonly="readonly" type="text"><input id="hdnProductId'+count+'" name="hdnProductId'+count+'" value="" type="hidden"><img src="'+image_path+'search.gif" style="cursor: pointer;" onclick="productPickList(this,\''+module+'\','+count+',document.EditView.vendor_id.value)" align="absmiddle">';	
	} else {
		coltwo.innerHTML= '<input id="productName'+count+'" name="productName'+count+'" class="small" style="width: 100px;" value="" readonly="readonly" type="text"><input id="hdnProductId'+count+'" name="hdnProductId'+count+'" value="" type="hidden"><img src="'+image_path+'search.gif" style="cursor: pointer;" onclick="productPickList(this,\''+module+'\','+count+',\'\')" align="absmiddle">';	
	}
    //producut code
	colthree.className = "crmTableRow small"
	colthree.innerHTML='<span id="productcode'+count+'">&nbsp;</span>';
	//
	
	//Quantity In Stock - only for SO, Quotes and Invoice
	if(module != "PurchaseOrder"){
	colfour.className = "crmTableRow small"
	colfour.innerHTML='<span id="qtyInStock'+count+'">&nbsp;</span>';
	}
	
	//Quantiry
	colfive.className = "crmTableRow small"
	if(module != ""){//changed by dingjianting on 2007-2-25 for gloso project and quote
		colfive.innerHTML='<input id="qty'+count+'" name="qty'+count+'" type="text" class="small " style="width:50px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows(); calcTotal();" value=""/>';
	} else {
		colfive.innerHTML='<input id="qty'+count+'" name="qty'+count+'" type="text" class="small " style="width:50px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();" value=""/>';
	}
	
	//List Price with Discount, Total after Discount and Tax labels
	colsix.className = "crmTableRow small";
	var tempSix = '';
    if(module != ""){//changed by dingjianting on 2007-2-25 for gloso project and quote
		colsix.innerHTML = '<input id="listPrice'+count+'" name="listPrice'+count+'" value="0.00" type="text" class="small " style="width:70px" onBlur="calcTotal();"/>&nbsp;<a href="javascript:;;" onclick="priceBookPickList(this,'+count+')"><img border=0 src="'+image_path+'pricebook.gif"></a>';
	} else {
		colsix.innerHTML = '<input id="listPrice'+count+'" name="listPrice'+count+'" value="0.00" type="text" class="small " style="width:70px"/>&nbsp;<a href="javascript:;;" onclick="priceBookPickList(this,'+count+')"><img border=0 src="'+image_path+'pricebook.gif"></a>';

	}

    colseven.innerHTML = '<input id="comment1" name="comment'+count+'" class=small style="width:70px">';

	//Total and Discount, Total after Discount and Tax details
    var tempEight = '';
	if(module != ""){//changed by dingjianting on 2007-2-25 for gloso project and quote
		coleight.className = "crmTableRow small";
		tempEight = '<table width="100%" cellpadding="0" cellpadding="5"><tr><td style="padding:5px;" id="productTotal'+count+'" align="right">0.00</td></tr>';
		tempEight += '</table>';
		tempEight += '<span style="display:none" id="netPrice'+count+'"><b>&nbsp;</b></span>';
		coleight.innerHTML = tempEight;
		
	}
	
    if(module != ""){//changed by dingjianting on 2007-2-25 for gloso project and quote
		//changed by dingjianting on 2007-1-5 for gloso project
		calcTotal();
	}
}

function decideTaxDiv()
{
	/*
	var taxtype = document.getElementById("taxtype").value

	calcTotal();

	if(taxtype == 'group')
	{
		//if group tax selected then we have to hide the individual taxes and also calculate the group tax
		hideIndividualTaxes()
		calcGroupTax();
	}
	else if(taxtype == 'individual')
		hideGroupTax()
	*/

}

function hideIndividualTaxes()
{
	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//Because the table has two header rows. so we will reduce two from row length

	for(var i=1;i<=max_row_count;i++)
	{
		document.getElementById("individual_tax_row"+i).className = 'TaxHide';
		document.getElementById("taxTotal"+i).style.display = 'none';
	}
	document.getElementById("group_tax_row").className = 'TaxShow';
}

function hideGroupTax()
{
	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//Because the table has two header rows. so we will reduce two from table row length

	for(var i=1;i<=max_row_count;i++)
	{
		document.getElementById("individual_tax_row"+i).className = 'TaxShow';
		document.getElementById("taxTotal"+i).style.display = 'block';
	}
	document.getElementById("group_tax_row").className = 'TaxHide';
}

function setDiscount(currObj,curr_row)
{
	var discount_checks = new Array();

	discount_checks = document.getElementsByName("discount"+curr_row);

	if(discount_checks[0].checked == true)
	{
		document.getElementById("discount_type"+curr_row).value = 'zero';
		document.getElementById("discount_percentage"+curr_row).style.visibility = 'hidden';
		document.getElementById("discount_amount"+curr_row).style.visibility = 'hidden';
		document.getElementById("discountTotal"+curr_row).innerHTML = 0.00;
	}
	if(discount_checks[1].checked == true)
	{
		document.getElementById("discount_type"+curr_row).value = 'percentage';
		document.getElementById("discount_percentage"+curr_row).style.visibility = 'visible';
		document.getElementById("discount_amount"+curr_row).style.visibility = 'hidden';

		var discount_amount = 0.00;
		//This is to calculate the final discount
		if(curr_row == '_final')
		{
			discount_amount = eval(document.getElementById("netTotal").innerHTML)*eval(document.getElementById("discount_percentage"+curr_row).value)/eval(100);
		}
		else//This is to calculate the product discount
		{
			discount_amount = eval(document.getElementById("productTotal"+curr_row).innerHTML)*eval(document.getElementById("discount_percentage"+curr_row).value)/eval(100);
		}

		document.getElementById("discountTotal"+curr_row).innerHTML = discount_amount;
	}
	if(discount_checks[2].checked == true)
	{
		document.getElementById("discount_type"+curr_row).value = 'amount';
		document.getElementById("discount_percentage"+curr_row).style.visibility = 'hidden';
		document.getElementById("discount_amount"+curr_row).style.visibility = 'visible';
		document.getElementById("discountTotal"+curr_row).innerHTML = document.getElementById("discount_amount"+curr_row).value;
	}

	calcTotal();
}

//This function is added to call the tax calculation function
function callTaxCalc(curr_row)
{
	/*
	//changed by dingjianting on 2006-12-28 for gloso project
	//when we change discount or list price, we have to calculate the taxes again before calculate the total
	tax_count = eval(document.getElementById('tax_table'+curr_row).rows.length-1);//subtract the title tr length

	for(var i=0, j=i+1;i<tax_count;i++,j++)
	{
		var tax_hidden_name = "hidden_tax"+j+"_percentage"+curr_row;
		var tax_name = document.getElementById(tax_hidden_name).value;
		calcCurrentTax(tax_name,curr_row,i);
	}
	*/
}

function calcCurrentTax(tax_name, curr_row, tax_row)
{
	//we should calculate the tax amount only for the total After Discount
	var product_total = getObj("totalAfterDiscount"+curr_row).innerHTML
	//var product_total = document.getElementById("productTotal"+curr_row).innerHTML
	var new_tax_percent = document.getElementById(tax_name).value;

	var new_amount_lbl = document.getElementsByName("popup_tax_row"+curr_row);

	//calculate the new tax amount
	new_tax_amount = eval(product_total)*eval(new_tax_percent)/eval(100);

	//assign the new tax amount in the corresponding text box
	new_amount_lbl[tax_row].value = new_tax_amount;

	var tax_total = 0.00;
	for(var i=0;i<new_amount_lbl.length;i++)
	{
		tax_total = tax_total + eval(new_amount_lbl[i].value);
	}
	document.getElementById("taxTotal"+curr_row).innerHTML = tax_total;

	calcTotal();
}


function validateProductDiscounts()
{
	var max_row_count = document.getElementById('proTab').rows.length;
	max_row_count = eval(max_row_count)-2;//As the table has two header rows, we will reduce two from table row length

	for(var i=1;i<=max_row_count;i++)
	{
		//if the row is deleted then avoid validate that row values
		if(document.getElementById("deleted"+i).value == 1)
			continue;

		discount_checks = document.getElementsByName("discount"+i);

		//Percentage selected, so validate the percentage
		if(discount_checks[1].checked == true)
		{
			temp = /^(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?$/.test(document.getElementById("discount_percentage"+i).value);
			if(!temp)
			{
				alert(alert_arr.VALID_DISCOUNT_PERCENT);
				return false;
			}
		}
		if(discount_checks[2].checked == true)
		{
			temp = /^(0|[1-9]{1}\d{0,})(\.(\d{1}\d{0,}))?$/.test(document.getElementById("discount_amount"+i).value);
			if(!temp)
			{
				alert(alert_arr.VALID_DISCOUNT_AMOUNT);
				return false;
			}
		}
	}
	return true;
}

function selectProductRows(form)
{
	/*
	module = form.module.value;
	
	if(module != 'PurchaseOrder') {		
		window.open("index.php?module=Products&action=PopupForInventory&html=Popup_picker&popuptype=inventory_prods&select=enable","productWin","width=740,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");
	} else {
		vendor_id = form.vendor_id.value;
		if(vendor_id == '') {
			alert(alert_arr.VENDOR_CANNOT_EMPTY);
			return ;
		} else {
			window.open("index.php?module=Products&action=PopupForInventory&html=Popup_picker&popuptype=inventory_prods&select=enable&vendor_id="+vendor_id,"productWin","width=740,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");
		
		}		
	}
	*/
	window.open("index.php?module=Products&action=PopupForInventory&html=Popup_picker&popuptype=inventory_prods&select=enable","productWin","width=740,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");
	
}

function UpdateIDString()
{
	x = document.selectall.selected_id.length;
	var y=0;	
	var idstring = document.selectall.idlist.value;
	var productstring = document.selectall.productlist.value;
	namestr = "";
	if ( x == undefined)
	{
		if(document.selectall.selected_id != undefined) {
		        //单条记录
		        if(document.selectall.selected_id.checked) {
				var idvalue = document.selectall.selected_id.value;
				var qtyinstock = $("qtyinstock_"+idvalue).value;
				/*
				if(alert_arr.IS_ZERO_QTYINSTOCK == "1") {
					if(qtyinstock < 1) {
						alert("库存数量为0，不能下订单！");
						document.selectall.selected_id.checked = false;
						return false;
					}
				}
				*/
				
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
						//format:productid#productname#productcode#listprice#qtyinstock
						var productname = $("productname_"+idvalue).value;
						var productcode = $("productcode_"+idvalue).value;
						var listprice = $("listprice_"+idvalue).value;
						var serialno = $("serialno_"+idvalue).value;
						qtyinstock = $("qtyinstock_"+idvalue).value;
						if(productstring != "") {
							productstring = productstring + ";" + idvalue + "##" + productname + "##" + productcode + "##" + listprice + "##" + qtyinstock + "##" + serialno;
						} else {
							productstring = idvalue + "##" + productname + "##" + productcode + "##" + listprice + "##" + qtyinstock + "##" + serialno;
						}
					}
				}
				
			} else {
				var idvalue = document.selectall.selected_id.value+";";
				idstring = idstring.replace(idvalue,"");
				idvalue = document.selectall.selected_id.value;
				//format:productid#productname#productcode#listprice#qtyinstock
				var productname = $("productname_"+idvalue).value;
				var productcode = $("productcode_"+idvalue).value;
				var listprice = $("listprice_"+idvalue).value;
				var qtyinstock = $("qtyinstock_"+idvalue).value;
				var serialno = $("serialno_"+idvalue).value;

				productvalue = idvalue + "##" + productname + "##" + productcode + "##" + listprice + "##" + qtyinstock  + "##" + serialno + ";";
				productstring = productstring.replace(productvalue,"");
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
				var qtyinstock = $("qtyinstock_"+idvalue).value;
				/*
				if(alert_arr.IS_ZERO_QTYINSTOCK == "1") {
					if(qtyinstock < 1) {
						alert("库存数量为0，不能下订单！");
						document.selectall.selected_id[i].checked = false;
					}
				}
				*/
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
						//format:productid#productname#productcode#listprice#qtyinstock
						var productname = $("productname_"+idvalue).value;
						var productcode = $("productcode_"+idvalue).value;
						var listprice = $("listprice_"+idvalue).value;
						qtyinstock = $("qtyinstock_"+idvalue).value;
						var serialno = $("serialno_"+idvalue).value;
						if(productstring != "") {
							productstring = productstring + ";" + idvalue + "##" + productname + "##" + productcode + "##" + listprice + "##" + qtyinstock  + "##" + serialno;
						} else {
							productstring = idvalue + "##" + productname + "##" + productcode + "##" + listprice + "##" + qtyinstock + "##" + serialno;
						}
					}
				}
				
			} else {
				var idvalue = document.selectall.selected_id[i].value+";";
				idstring = idstring.replace(idvalue,"");
				idvalue = document.selectall.selected_id[i].value;
				//format:productid#productname#productcode#listprice#qtyinstock
				var productname = $("productname_"+idvalue).value;
				var productcode = $("productcode_"+idvalue).value;
				var listprice = $("listprice_"+idvalue).value;
				var qtyinstock = $("qtyinstock_"+idvalue).value;
				var serialno = $("serialno_"+idvalue).value;
				
				productvalue = idvalue + "##" + productname + "##" + productcode + "##" + listprice + "##" + qtyinstock  + "##" + serialno + ";";
				productstring = productstring.replace(productvalue,"");

			}
			y=y+1;
		}
	}
	if (y != 0)
	{
		document.selectall.idlist.value = idstring;
		document.selectall.productlist.value = productstring;
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}
	//alert(productstring);

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

function addMultiProductRow()
{
	var idlist = document.selectall.idlist.value;
	var productstring = document.selectall.productlist.value;
	var id_arr = idlist.split(';');
	var product_arr = productstring.split(';');
	var module = window.opener.document.EditView.module.value;
	for (var j = 0; j < id_arr.length; j++) {
		if(id_arr[j] != "")
		{
		    var row = product_arr[j];
			var row_arr = row.split('##');
			//format:productid#productname#productcode#listprice#qtyinstock#serialno
			productrowid = row_arr[0];
			productname = row_arr[1];
			productcode = row_arr[2];
			listprice = row_arr[3];
			qtyinstock = row_arr[4];
			serialno = row_arr[5];
			var tableName = window.opener.document.getElementById('proTab');
			var prev = tableName.rows.length;
			var count = eval(prev)-1;
			var row = tableName.insertRow(prev);
			row.id = "row"+count;
			row.style.verticalAlign = "top";
			
			
			var colone = row.insertCell(0);
			var coltwo = row.insertCell(1);
			var colthree = row.insertCell(2);
			if(module != "PurchaseOrder") {
				var colfour = row.insertCell(3);
				var colfive = row.insertCell(4);
				var colsix = row.insertCell(5);
				var colseven = row.insertCell(6);
				var coleight = row.insertCell(7);
				var colnine = row.insertCell(8);
			} else {
				var colfour = row.insertCell(3);
				var colfive = row.insertCell(4);
				var colsix = row.insertCell(5);
				var colseven = row.insertCell(6);
				var coleight = row.insertCell(7);
				
			}
			
			

			//id
			//colone.className = "crmTableRow small";
			//colone.innerHTML= count;

			//Delete link
			colone.className = "crmTableRow small";
			colone.innerHTML='<img src="themes/softed/images/delete.gif" border="0" onclick="deleteRow(\''+module+'\','+count+')"><input id="deleted'+count+'" name="deleted'+count+'" type="hidden" value="0">';

			coltwo.className = "crmTableRow small"
			coltwo.innerHTML= '<input id="productName'+count+'" name="productName'+count+'" class="small" value="' + productname + '" readonly="readonly" type="text"><input id="hdnProductId'+count+'" name="hdnProductId'+count+'" value="'+ productrowid +'" type="hidden">';
			
			//Code
			colthree.className = "crmTableRow small tdnowrap";
			colthree.innerHTML= '&nbsp;'+productcode+'<input id="productcode'+count+'" name="productcode'+count+'" value="'+ productcode +'" type="hidden">';

			//serialno
			colfour.className = "crmTableRow small tdnowrap";
			colfour.innerHTML= '&nbsp;'+serialno+'<input id="serialno'+count+'" name="serialno'+count+'" value="'+ serialno +'" type="hidden">';

			//qtyinstock
			if(module != "PurchaseOrder") {
				colfive.className = "crmTableRow small";
				colfive.innerHTML= '&nbsp;'+qtyinstock+'<input id="qtyinstock'+count+'" name="qtyinstock'+count+'" value="'+ qtyinstock +'" type="hidden">';
				//Quantity
				colsix.className = "crmTableRow small";
				colsix.innerHTML='<input id="qty'+count+'" name="qty'+count+'" type="text" class="small " style="width:50px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value=""/>';

				//listprice
				if(module != "Tuihuos") {
					colseven.className = "crmTableRow small";
					colseven.innerHTML= '<input id="listPrice'+count+'" name="listPrice'+count+'" type="text" class="small " style="width:70px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value="'+ listprice +'"/>&nbsp;<a href="javascript:;;" onclick="priceBookPickList(this,'+count+')"><img border=0 src="themes/softed/images/pricebook.gif">';
				} else {
					colseven.className = "crmTableRow small";
					colseven.innerHTML= '<input id="listPrice'+count+'" name="listPrice'+count+'" type="text" class="small " style="width:70px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value="'+ listprice +'"/>';
				}

				

				//comments
				coleight.className = "crmTableRow small";
				coleight.innerHTML='<input id="comment'+count+'" name="comment'+count+'" class=small style="width:100px">';

				colnine.className = "crmTableRow small";
				tempnine = '<table width="100%" cellpadding="0" cellpadding="5"><tr><td style="padding:5px;" id="productTotal'+count+'" align="right">0.00</td></tr>';
				tempnine += '</table>';
				tempnine += '<span style="display:none" id="netPrice'+count+'"><b>&nbsp;</b></span>';
				colnine.innerHTML = tempnine;
			} else {
				
				//Quantity
				colfive.className = "crmTableRow small";
				colfive.innerHTML='<input id="qty'+count+'" name="qty'+count+'" type="text" class="small" style="width:50px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value=""/>';

				//listprice
				colsix.className = "crmTableRow small";
				colsix.innerHTML= '<input id="listPrice'+count+'" name="listPrice'+count+'" type="text" class="small"  style="width:70px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value="'+ listprice +'"/>&nbsp;<a href="javascript:;;" onclick="priceBookPickList(this,'+count+')"><img border=0 src="themes/softed/images/pricebook.gif">';

				

				//comments
				colseven.className = "crmTableRow small";
				colseven.innerHTML='<input id="comment'+count+'" name="comment'+count+'" class=small style="width:100px">';

				coleight.className = "crmTableRow small";
				tempEight = '<table width="100%" cellpadding="0" cellpadding="5"><tr><td style="padding:5px;" id="productTotal'+count+'" align="right">0.00</td></tr>';
				tempEight += '</table>';
				tempEight += '<span style="display:none" id="netPrice'+count+'"><b>&nbsp;</b></span>';
				coleight.innerHTML = tempEight;
			}

			


		}								
	}
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
	}
    calcTotal();
}