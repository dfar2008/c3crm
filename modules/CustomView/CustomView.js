 /*********************************************************************************
 ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/
function trimfValues(value)
{
    var string_array;
    string_array = value.split(":");
    return string_array[4];
}

function updatefOptions(sel, opSelName) {
    var selObj = document.getElementById(opSelName);
    var fieldtype = null ;

    var currOption = selObj.options[selObj.selectedIndex];
    var currField = sel.options[sel.selectedIndex];

    if(currField.value != null && currField.value.length != 0)
    {
	fieldtype = trimfValues(currField.value);
	ops = typeofdata[fieldtype];
	var off = 0;
	if(ops != null)
	{

		var nMaxVal = selObj.length;
		for(nLoop = 0; nLoop < nMaxVal; nLoop++)
		{
			selObj.remove(0);
		}
		selObj.options[0] = new Option (alert_arr.NONE, '');
		if (currField.value == '') {
			selObj.options[0].selected = true;
		}
		off = 1;
		for (var i = 0; i < ops.length; i++)
		{
			var label = fLabels[ops[i]];
			if (label == null) continue;
			var option = new Option (fLabels[ops[i]], ops[i]);
			selObj.options[i + off] = option;
			if (currOption != null && currOption.value == option.value)
			{
				option.selected = true;
			}
		}
	}
    }else
    {
	var nMaxVal = selObj.length;
	for(nLoop = 0; nLoop < nMaxVal; nLoop++)
	{
		selObj.remove(0);
	}
	selObj.options[0] = new Option (alert_arr.NONE, '');
	if (currField.value == '') {
		selObj.options[0].selected = true;
	}
    }

}
function verify_data() {
	var isError = false;
	var errorMessage = "";
	if (trim(document.CustomView.viewName.value) == "") {
		isError = true;
		errorMessage += "\n"+alert_arr.CUSTOM_VIEW_NAME;
	}
	// Here we decide whether to submit the form.
	if (isError == true) {
		alert(alert_arr.MISSING_FIELDS + errorMessage);
		return false;
	}
	//return true;
}


function CancelForm()
{
var cvmodule = document.templatecreate.cvmodule.value;
var viewid = document.templatecreate.cvid.value;
document.location.href = "index.php?module="+cvmodule+"&action=index&viewname="+viewid;
}


function check4null(form)
{
        var isError = false;
        var errorMessage = "";
        // Here we decide whether to submit the form.
        if (trim(form.subject.value) =='') {
                isError = true;
                errorMessage += "\n"+alert_arr.SUBJECT;;
                form.subject.focus();
        }

        // Here we decide whether to submit the form.
        if (isError == true) {
                alert(alert_arr.MISSING_FIELDS + errorMessage);
                return false;
        }
 return true;
}



