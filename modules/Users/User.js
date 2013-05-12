/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/



document.write("<script type='text/javascript' src='include/js/Mail.js'></"+"script>");
function set_return(user_id, user_name) {
		window.opener.document.EditView.reports_to_name.value = user_name;
		window.opener.document.EditView.reports_to_id.value = user_id;
}


function set_return_mobiles(entity_id,name,mobile) 
{
	if(mobile == "") {
		alert("手机不能为空！");
		return ;
	} else {
		//window.opener.document.EditView.phones.value = window.opener.document.EditView.phones.value + ";" + name + ":" + mobile;
		if(window.opener.document.EditView.phones.value.indexOf(mobile) != -1) {
			alert("手机号码已存在！");
			return ;            
		} else {
			if(window.opener.document.EditView.phones.value != "") {
				window.opener.document.EditView.phones.value = window.opener.document.EditView.phones.value + "," + mobile;
			} else {
				window.opener.document.EditView.phones.value = mobile;
			}			
		}
	}
	window.close();
}

//Function added for Mass select in Popup - Philip
function SelectPhones()
{

	x = document.selectall.selected_id.length;
	idstring = "";
	namestr = "";
	phonestr = "";
	phones = "";

	if ( x == undefined)
	{

			if (document.selectall.selected_id.checked)
			{
				idstring = document.selectall.selected_id.value;
				//phones = document.selectall.contact_name.value + ":" + document.selectall.contact_phone.value;
				phones = document.selectall.contact_phone.value;
				y=1;
			}
			else
			{
					alert("请至少选择一条记录");
					return false;
			}
	}
	else
	{
			y=0;
			for(i = 0; i < x ; i++)
			{
					if(document.selectall.selected_id[i].checked)
					{
						if(window.opener.document.EditView.phones.value.indexOf(document.selectall.contact_phone[i].value) == -1) {
							idstring = document.selectall.selected_id[i].value +","+idstring;
							//phones = phones + ";" + document.selectall.contact_name[i].value + ":" + document.selectall.contact_phone[i].value;
							phones = phones + ";" + document.selectall.contact_phone[i].value;
						} else{
							alert("手机号码(" + document.selectall.contact_phone[i].value + ")已存在！");
							document.selectall.selected_id[i].checked = false;
							document.selectall.select_all.checked = false;
							continue;
						}
						y=y+1;
					}
			}
	}
	if (y != 0)
	{
		document.selectall.idlist.value=idstring;
	}
	else
	{
			alert("请至少选择一条记录");
			return false;
	}
	if(window.opener.document.EditView.phones.value != "") {
		window.opener.document.EditView.phones.value = window.opener.document.EditView.phones.value + "," + phones;
	} else {
		window.opener.document.EditView.phones.value = phones;
	}
	//window.opener.document.EditView.phones.value = window.opener.document.EditView.phones.value + ";" + phones;
	window.close();
}

function toggleSelectContact(state,relCheckName) {
	if (getObj(relCheckName)) {
		if (typeof(getObj(relCheckName).length)=="undefined") {
			if(getObj(relCheckName).disabled != true)
				getObj(relCheckName).checked=state
		} else {
			for (var i=0;i<getObj(relCheckName).length;i++)
				if(getObj(relCheckName)[i].disabled != true)
					getObj(relCheckName)[i].checked=state
		}
	}
}

function toggleSelectAllContact(relCheckName,selectAllName) {
	if (typeof(getObj(relCheckName).length)=="undefined") {
		getObj(selectAllName).checked=getObj(relCheckName).checked
	} else {
		var atleastOneFalse=false;
		for (var i=0;i<getObj(relCheckName).length;i++) {
			if (getObj(relCheckName)[i].checked==false) {
				atleastOneFalse=true
				break;
			}
		}
		getObj(selectAllName).checked=!atleastOneFalse
	}
}

