function set_return(product_id, product_name) {
        window.opener.document.EditView.parent_name.value = product_name;
        window.opener.document.EditView.parent_id.value = product_id;
}
function set_return_specific(product_id, product_name, mode) {

        //getOpenerObj used for DetailView 
        var fldName = getOpenerObj("salesorder_name");
        var fldId = getOpenerObj("salesorder_id");
        fldName.value = product_name;
        fldId.value = product_id;
	if(mode != 'DetailView' && window.opener.document.EditView.convertmode != undefined)
	{
		    window.opener.document.EditView.action.value = 'EditView';
        	window.opener.document.EditView.convertmode.value = 'update_so_val';
        	window.opener.document.EditView.submit();
	}
}
function set_return_formname_specific(formname, product_id, product_name) {
        window.opener.document.EditView1.purchaseorder_name.value = product_name;
        window.opener.document.EditView1.purchaseorder_id.value = product_id;
}

function selectProductRows()
{
	//window.open("index.php?module=Products&action=PopupForSO&html=Popup_picker&popuptype=inventory_prods&select=enable","productWin","width=740,height=565,resizable=1,scrollbars=1,status=1,top=150,left=200");	
	$("#status").prop("display","inline");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module=Products&action=PopupForSO&html=Popup_picker&popuptype=inventory_prods&select=enable",
		   success: function(msg){
		   	 $("#status").prop("display","none");
		   	 $("#selectProductRows").html(msg); 

		   	 //$("#searchallacct").html(msg); 		   
			 }  
	}); 
	$('#selectProductRows').modal('show');
	//BrowerAcct("specific_contact_account_address");
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
					var selectedProductsLength = document.forms['EditView'].elements.length;
					for(var m=0;m<selectedProductsLength;m++) {
						if(document.forms['EditView'].elements[m].name.indexOf('hdnProductId') > -1) {
							tmpProductID = document.forms['EditView'].elements[m].name;
							tmpProductIndex = tmpProductID.substring(12);
							
							if(document.forms['EditView'].elements["deleted"+tmpProductIndex].value == 0 && document.forms['EditView'].elements[m].value == idvalue) {
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
//					var selectedProductsLength = opener.window.document.forms['EditView'].elements.length;
//					for(var m=0;m<selectedProductsLength;m++) {
//						if(opener.window.document.forms['EditView'].elements[m].name.indexOf('hdnProductId') > -1) {
//							tmpProductID = opener.window.document.forms['EditView'].elements[m].name;
//							tmpProductIndex = tmpProductID.substring(12);
//							
//							if(opener.window.document.forms['EditView'].elements["deleted"+tmpProductIndex].value == 0 && opener.window.document.forms['EditView'].elements[m].value == idvalue) {
//								alert(alert_arr.PRODUCT_SELECTED);
//								document.selectall.selected_id[i].checked = false;
//								repeated = true;
//								break;
//							}
//						}
//					} 

					var selectedProductsLength = window.document.forms['EditView'].elements.length;
					for(var m=0;m<selectedProductsLength;m++) {
						if(window.document.forms['EditView'].elements[m].name.indexOf('hdnProductId') > -1) {
							tmpProductID = window.document.forms['EditView'].elements[m].name;
							tmpProductIndex = tmpProductID.substring(12);
							
							if(window.document.forms['EditView'].elements["deleted"+tmpProductIndex].value == 0 && window.document.forms['EditView'].elements[m].value == idvalue) {
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
function addMultiProductRow(module) 
{   
	UpdateIDString(); 
	var idlist = document.selectall.idlist.value;

	$.ajax({
		type:"GET",
		url:"index.php?module=Products&action=ProductsAjax&file=getProductsByModule&ajax=true&idlist="+ encodeURIComponent(idlist)+"&basemodule="+encodeURIComponent(module),
		success:function(msg){
			//productarr = JSON.parse(msg);
			productarr = $.parseJSON(msg);
			for (var j = eval(productarr.length-1); j > -1; j--) {
				addProductRow(productarr[j]);
			}
			$("#selectProductRows").modal("hide");
			calcTotal();
			//window.close();

		}
	});
}
function addProductRow(productrow) 
{
	var fieldlist = productrow["fieldlist"];
	//var module = window.opener.document.EditView.module.value;
	//var tableName = window.opener.document.getElementById('proTab');
	var module = document.EditView.module.value;
	var tableName = document.getElementById('proTab');
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
	coli.innerHTML='<input id="qty'+count+'" name="qty'+count+'" type="text" class="small " style="width:50px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value="1"/>';
	i = i + 1;
    coli = row.insertCell(i);
	//listprice
	coli.className = "crmTableRow small";
	coli.innerHTML= '<input id="listPrice'+count+'" name="listPrice'+count+'" type="text" class="small " style="width:70px" onfocus="this.className=\'detailedViewTextBoxOn\'" onBlur="FindDuplicate(); settotalnoofrows();calcTotal();" value="'+ productrow["listprice"] +'"/>&nbsp;';	

	//comments
	i = i + 1;
    coli = row.insertCell(i);
	coli.className = "crmTableRow small";
	coli.innerHTML='<input type="text" id="comment'+count+'" name="comment'+count+'" class=small style="width:150px">';

    i = i + 1;
    coli = row.insertCell(i);
	coli.className = "crmTableRow small";
	temp = '<table class="table table-bordered " ><tr><td style="padding:5px;" id="productTotal'+count+'" align="right">0.00</td></tr>';
	temp += '</table>';
	temp += '<span style="display:none;font-size:12px;" id="netPrice'+count+'" ><b>&nbsp;</b></span>';
	coli.innerHTML = temp;
} 


//This function is used to validate the Inventory modules 
function validateInventory(module) 
{
	if(!formValidate())
		return false

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
	settotalnoofrows();
	calcGrandTotal();

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
	var buttonsave = $$('.save');
	var count = buttonsave.length;
	for(var i=0;i<count;i++){
		buttonsave[i].disabled = "disabled";
	}
	document.EditView.submit();
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
	document.getElementById("grandTotal").innerHTML = roundValue(netTotal.toString())
	document.getElementById("total").value = roundValue(netTotal.toString())
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

function settotalnoofrows() {
	var max_row_count = document.getElementById('proTab').rows.length;
        max_row_count = eval(max_row_count)-2;

	//set the total number of products
	document.EditView.totalProductCount.value = max_row_count;	
}