/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
function set_return(account_id, account_name) {
        window.opener.document.EditView.parent_name.value = account_name;
        window.opener.document.EditView.parent_id.value = account_id;
		window.opener.document.EditView.parent_name.focus();
}
function set_return_specific(account_id, account_name) {
        
        //getOpenerObj used for DetailView 
	if(document.getElementById('from_link').value != '')
	{
		var fldName = window.opener.document.QcEditView.account_name;
		var fldId = window.opener.document.QcEditView.account_id;
	}else
	{	
		var fldName = window.opener.document.EditView.account_name;
		var fldId = window.opener.document.EditView.account_id;
	}
	fldName.value = account_name;
	fldId.value = account_id;
    if(window.opener.updateContactOpts) window.opener.updateContactOpts();
	if(window.opener.setAccountInfo != undefined) {
		window.opener.setAccountInfo(account_id);
	}
}
function add_data_to_relatedlist(entity_id,recordid) {

        opener.document.location.href="index.php?module=Emails&action=updateRelations&destination_module=Accounts&entityid="+entity_id+"&parid="+recordid;
}
function set_return_formname_specific(formname,product_id, product_name) {
        window.opener.document.EditView1.account_name.value = product_name;
        window.opener.document.EditView1.account_id.value = product_id;
        if(window.opener.updateContactOpts) window.opener.updateContactOpts();
}
function set_return_address(account_id, account_name, bill_street, ship_street, bill_city, ship_city, bill_state, ship_state, bill_code, ship_code, bill_country, ship_country,bill_pobox,ship_pobox) {
        window.opener.document.EditView.account_name.value = account_name;
        window.opener.document.EditView.account_id.value = account_id;
        if(window.opener.updateContactOpts) window.opener.updateContactOpts();
		if(window.opener.setAccountInfo != undefined) {
			window.opener.setAccountInfo(account_id);
		}

		//changed by dingjianting on 2006-12-25 for related accounts not specific address
		/*
		if(window.opener.document.EditView.ship_street != undefined) {
			window.opener.document.EditView.ship_street.value = ship_street;
		}
		if(window.opener.document.EditView.ship_city != undefined) {
			window.opener.document.EditView.ship_city.value = ship_city;
		}
		if(window.opener.document.EditView.ship_state != undefined) {
			window.opener.document.EditView.ship_state.value = ship_state;
		}
		if(window.opener.document.EditView.ship_code != undefined) {
			window.opener.document.EditView.ship_code.value = ship_code;
		}
		if(window.opener.document.EditView.ship_country != undefined) {
			window.opener.document.EditView.ship_country.value = ship_country;
		}
		if(window.opener.document.EditView.ship_pobox != undefined) {
			window.opener.document.EditView.ship_pobox.value = ship_pobox;
		}

		if(window.opener.document.EditView.bill_street != undefined) {
			window.opener.document.EditView.bill_street.value = bill_street;
		}
		if(window.opener.document.EditView.bill_city != undefined) {
			window.opener.document.EditView.bill_city.value = bill_city;
		}
		if(window.opener.document.EditView.bill_state != undefined) {
			window.opener.document.EditView.bill_state.value = bill_state;
		}
		if(window.opener.document.EditView.bill_code != undefined) {
			window.opener.document.EditView.bill_code.value = bill_code;
		}
		if(window.opener.document.EditView.bill_country != undefined) {
			window.opener.document.EditView.bill_country.value = bill_country;
		}
		if(window.opener.document.EditView.bill_pobox != undefined) {
			window.opener.document.EditView.bill_pobox.value = bill_pobox;
		}
		*/
}
//added to populate address
function set_return_contact_address(account_id, account_name, bill_street, ship_street, bill_city, ship_city, bill_state, ship_state, bill_code, ship_code, bill_country, ship_country,bill_pobox,ship_pobox ) {
        document.EditView.account_name.value = account_name;
        document.EditView.account_id.value = account_id;
		$('#searchallacct').modal('hide');
//		if(updateContactOpts) updateContactOpts();	
//		if(setAccountInfo != undefined) {
//			setAccountInfo(account_id);
//		}


}

//added by rdhital/Raju for emails
function submitform(id){
		document.massdelete.entityid.value=id;
		document.massdelete.submit();
}	

function searchMapLocation(addressType)
{
        var mapParameter = '';
        if (addressType == 'Main')
        {
		if(fieldname.indexOf('bill_street') > -1)
                        mapParameter = document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('bill_street')]).innerHTML+' ';
                if(fieldname.indexOf('bill_pobox') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('bill_pobox')]).innerHTML+' ';
                if(fieldname.indexOf('bill_city') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('bill_city')]).innerHTML+' ';
		if(fieldname.indexOf('bill_state') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('bill_state')]).innerHTML+' ';
                if(fieldname.indexOf('bill_country') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('bill_country')]).innerHTML+' ';
                if(fieldname.indexOf('bill_code') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('bill_code')]).innerHTML+' ';
        }
        else if (addressType == 'Other')
        {
		if(fieldname.indexOf('ship_street') > -1)
                        mapParameter = document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('ship_street')]).innerHTML+' ';
                if(fieldname.indexOf('ship_pobox') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('ship_pobox')]).innerHTML+' ';
                if(fieldname.indexOf('ship_city') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('ship_city')]).innerHTML+' ';
                if(fieldname.indexOf('ship_state') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('ship_state')]).innerHTML+' ';
		if(fieldname.indexOf('ship_country') > -1)
                        mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('ship_country')]).innerHTML+' ';
                if(fieldname.indexOf('bill_code') > -1)                                                                                            mapParameter = mapParameter + document.getElementById("dtlview_"+fieldlabel[fieldname.indexOf('ship_code')]).innerHTML+' ';

        }
	 window.open('http://maps.google.com/maps?q='+mapParameter,'goolemap','height=450,width=700,resizable=no,titlebar,location,top=200,left=250');
}
//javascript function will open new window to display traffic details for particular url using alexa.com
function getRelatedLink()
{
	var param='';
	param = getObj("website").value;
	window.open('http://www.alexa.com/data/details/traffic_details?q=&url='+param,'relatedlink','height=400,width=700,resizable=no,titlebar,location,top=250,left=250');
}

/*
* javascript function to populate fieldvalue in account editview
* @param id1 :: div tag ID
* @param id2 :: div tag ID
*/
function populateData(id1,id2)
{
	document.EditView.description.value = document.getElementById('summary').innerHTML;
	document.EditView.employees.value = getObj('emp').value;
	document.EditView.website.value = getObj('site').value;
	document.EditView.phone.value = getObj('Phone').value;
	document.EditView.fax.value = getObj('Fax').value;
	document.EditView.bill_street.value = getObj('address').value;
	
	showhide(id1,id2);
}
/*
* javascript function to show/hide the div tag
* @param argg1 :: div tag ID
* @param argg2 :: div tag ID
*/
function showhide(argg1,argg2)
{
        var x=document.getElementById(argg1).style;
	var y=document.getElementById(argg2).style;
        if (y.display=="none")
        {
                y.display="block"
		x.display="none"

        }
}

// JavaScript Document

if (document.all) var browser_ie=true
else if (document.layers) var browser_nn4=true
else if (document.layers || (!document.all && document.getElementById)) var browser_nn6=true

function getObj2(n,d) {
	
  var p,i,x;
  if(!d)d=document;
  if((p=n.indexOf("?"))>0&&parent.frames.length) {d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all)x=d.all[n];
  for(i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++)  x=getObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n);
  return x;
}


function findPosX(obj) {
        var curleft = 0;
        if (document.getElementById || document.all) {
                while (obj.offsetParent) { curleft += obj.offsetLeft; obj = obj.offsetParent;}
        }
        else if (document.layers) { curleft += obj.x; }
        return curleft;
}


function findPosY(obj) {
        var curtop = 0;
        if (document.getElementById || document.all) {
                while (obj.offsetParent) { curtop += obj.offsetTop; obj = obj.offsetParent; }
        }
        else if (document.layers) {curtop += obj.y;}
        return curtop;
}

ScrollEffect = function(){ };
ScrollEffect.lengthcount=202;
ScrollEffect.closelimit=0;
ScrollEffect.limit=0;


function just(){
        ig=getObj("company");
        if(ScrollEffect.lengthcount > ScrollEffect.closelimit ){closet();return;}
        ig.style.display="block";
        ig.style.height=ScrollEffect.lengthcount+'px';
        ScrollEffect.lengthcount=ScrollEffect.lengthcount+10;
        if(ScrollEffect.lengthcount < ScrollEffect.limit){setTimeout("just()",25);}
        else{ getObj("innerLayer").style.display="block";return;}
}

function closet(){
        ig=getObj("company");
        getObj("innerLayer").style.display="none";
        ScrollEffect.lengthcount=ScrollEffect.lengthcount-10;
        ig.style.height=ScrollEffect.lengthcount+'px';
        if(ScrollEffect.lengthcount<20){ig.style.display="none";return;}
        else{setTimeout("closet()", 25);}
}


function fnDown(obj){
        var tagName = document.getElementById(obj);
        document.EditView.description.value = document.getElementById('summary').innerHTML;
        document.EditView.employees.value = getObj('emp').value;
        document.EditView.website.value = getObj('site').value;
        document.EditView.phone.value = getObj('Phone').value;
        document.EditView.fax.value = getObj('Fax').value;
        document.EditView.bill_street.value = getObj('address').value;
        if(tagName.style.display == 'none')
                tagName.style.display = 'block';
        else
                tagName.style.display = 'none';
}

function set_return_todo(product_id, product_name) {
        window.opener.document.createTodo.task_parent_name.value = product_name;
        window.opener.document.createTodo.task_parent_id.value = product_id;
}
var flag = false;


function check_duplicate() {

	flag = formValidate();
	
	if(flag) {
		check_duplicate_ajax();
	}
}
function check_duplicate_ajax()
{
	
	var accountname = window.document.EditView.accountname.value;
	var phone = window.document.EditView.phone.value;
	var email = window.document.EditView.email.value;
	var record = window.document.EditView.record.value;
	
	var strstring = "&accountname="+accountname+"&phone="+phone+"&email="+email+"&record="+record;

	$.ajax({
		type:"GET",
		url:'index.php?module=Accounts&action=AccountsAjax&file=Save&ajax=true&dup_check=true'+strstring,
		success : function(msg){
			if(msg.indexOf('SUCCESS')> -1 ) {
				var buttonsave = document.getElementsByName("savebutton");
				buttonsave[0].disabled = "disabled";
				buttonsave[1].disabled = "disabled";

				document.EditView.submit();

			}else{
				alert(msg);
			}
		}
	});
//	new Ajax.Request(
//                'index.php',
//                {queue: {position: 'end', scope: 'command'},
//                        method: 'post',
//                        postBody: 'module=Accounts&action=AccountsAjax&file=Save&ajax=true&dup_check=true'+strstring,
//                        onComplete: function(response) {
//		                    var result = trim(response.responseText);
//							if(result.indexOf('SUCCESS') > -1) {
//								    //disable save button
//									var buttonsave = $$('.save');
//									var count = buttonsave.length;
//									for(var i=0;i<count;i++){
//										buttonsave[i].disabled = "disabled";
//									}
//									document.EditView.submit();
//							}
//							else {
//										alert(result);
//							}
//						}
//                }
//        );
}

function callCreateAccountDiv()
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Accounts&action=AccountsAjax&file=CreateAccount',
			onComplete: function(response) {
				$("createaccount_div").innerHTML=response.responseText;
				eval($("accountjs").innerHTML);
				
			}
		}
	);
}

function created(form)
{	    
			
		
			var accountname = form.accountname.value;
			var email = form.email.value;
			var phone = form.phone.value;
			if (accountname == "")
			{
				alert(alert_arr.ACCOUNTNAME_CANNOT_EMPTY);
				form.accountname.focus();
				return false;
			}
			if (email == "" && phone == "")
			{
				alert(alert_arr.PHONE_OR_EMAIL_IS_NULL);
				form.phone.focus();
				return false;
			}
			if(email != "") {
				if(!patternValidate("email","Email","email")) {
					form.email.focus();
					return false;
				}
			}
			$("status").style.display="inline";
			new Ajax.Request(
          	  	      'index.php',
			      	{queue: {position: 'end', scope: 'command'},
		                        method: 'post',
                		        postBody:"module=Accounts&action=AccountsAjax&file=SaveAccount&ajax=true&accountname="+ accountname + "&email="+email+"&phone=" + phone,
		                        onComplete: function(response) {
				                        result = response.responseText;
	                        	        if(result == 'REPEAT') {
											$("status").style.display="none";											
											alert(alert_arr.ACCOUNT_NAME_EXISTS);											
										} else {
											$("status").style.display="none";
											hide('accountLay');
											if(window.opener.document.EditView.account_name != undefined) { 
												window.opener.document.EditView.account_name.value=accountname;
												window.opener.document.EditView.account_id.value=result;											
											}
										
											window.close();
										}
		                        }
              			 }
       		);

}

function copyAddressRight(form) {
	if(form.ship_street != undefined && form.bill_street != undefined) {
		form.ship_street.value = form.bill_street.value;
	}
	if(form.ship_city != undefined && form.bill_city != undefined) {
		form.ship_city.value = form.bill_city.value;
	}
	if(form.ship_state != undefined && form.bill_state != undefined) {
		form.ship_state.value = form.bill_state.value;
	}
	if(form.ship_code != undefined && form.bill_code != undefined) {
		form.ship_code.value = form.bill_code.value;
	}
	if(form.ship_country != undefined && form.bill_country != undefined) {
		form.ship_country.value = form.bill_country.value;
	}
	if(form.ship_pobox != undefined && form.bill_pobox != undefined) {
		form.ship_pobox.value = form.bill_pobox.value;
	}
	return true;
}

function copyAddressLeft(form) {
	if(form.bill_street != undefined && form.ship_street != undefined) {
		form.bill_street.value = form.ship_street.value;
	}
	if(form.bill_city != undefined && form.ship_city != undefined) {
		form.bill_city.value = form.ship_city.value;
	}
	if(form.bill_state != undefined && form.ship_state != undefined) {
		form.bill_state.value = form.ship_state.value;
	}
	if(form.bill_code != undefined && form.ship_code != undefined) {
		form.bill_code.value = form.ship_code.value;
	}
	if(form.bill_country != undefined && form.ship_country != undefined) {
		form.bill_country.value = form.ship_country.value;
	}
	if(form.bill_pobox != undefined && form.ship_pobox != undefined) {
		form.bill_pobox.value = form.ship_pobox.value;
	}
	return true;

}

function readmsg(msgid,localname,folder) {
	location = 'index.php?module=Webmails&action=readmsg&sid=0bb71602556532a41037294b5ee6d62c&tid=1&lid=cn&retid=29465&folder='+encodeURIComponent(folder)+'&pag=1&localname='+localname+ '&msgid='+msgid; 
}


// QuickEdit Feature
function create_setting(obj,divid,module) {
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		document.getElementById('idlist').value=idstring;

		create_setting_formload(idstring,module);
		fnvshobj(obj, divid);
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}

}
function create_setting_formload(idstring,module) {
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
	    	method: 'post',
			postBody:"module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+"&file=CreateSetting&mode=ajax",
				onComplete: function(response) {
                	$("status").style.display="none";
               	    var result = response.responseText;
                    $("createsetting_form_div").innerHTML= result;
					document.createsetting_form.createsetting_recordids.value = idstring;
					document.createsetting_form.createsetting_module.value = module;
					var jscripts = $('createsetting_javascript');
					if(jscripts) {
						eval(jscripts.innerHTML);
					}
				}
		}
	);
	
}


function qunfa_mail(obj,divid,module) {
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		document.getElementById('idlist').value=idstring;

		location.href='index.php?module=Maillists&action=ListView&idstring='+idstring+'&modulename='+module;;
		//qunfa_mail_formload(idstring,module);
		//fnvshobj(obj, divid);
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}

}
function qunfa_mail_formload(idstring,module) {
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
	    	method: 'post',
			postBody:"module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+"&file=QunfaMail&mode=ajax&idstring="+idstring,
				onComplete: function(response) {
                	$("status").style.display="none";
               	    var result = response.responseText;
                    $("qunfamail_form_div").innerHTML= result;
					document.qunfamail_form.qunfamail_recordids.value = idstring;
					document.qunfamail_form.qunfamail_module.value = module;
					var jscripts = $('qunfamail_javascript');
					if(jscripts) {
						eval(jscripts.innerHTML);
					}
				}
		}
	);
}
function qunfa_sms(obj,divid,module) {
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	idstring = "";

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring = select_options[i].value +";"+idstring
			xx++
		}
	}
	if (xx != 0)
	{
		document.getElementById('idlist').value=idstring;

		location.href='index.php?module=Qunfas&action=ListView&idstring='+idstring+'&modulename='+module;;;
		//qunfa_mail_formload(idstring,module);
		//fnvshobj(obj, divid);
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}

}



function select_add(obj,divid,module,record) {	
		select_add_formload(record,module);
		fnvshobj(obj, divid);
}
function select_add_formload(record,module) {
	$("status").style.display="inline";
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
	    	method: 'post',
			postBody:"module="+encodeURIComponent(module)+"&action="+encodeURIComponent(module+'Ajax')+"&file=SelectAdd&mode=ajax&record="+record,
				onComplete: function(response) {
                	$("status").style.display="none";
               	    var result = response.responseText;
                    $("selectadd_form_div").innerHTML= result;
					var jscripts = $('selectadd_javascript');
					if(jscripts) {
						eval(jscripts.innerHTML);
					}
				}
		}
	);
}
