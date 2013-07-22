/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *
 ********************************************************************************/

function infValidate(){
	var textArea = document.EditView.notecontent;
	var oEditor = FCKeditorAPI.GetInstance("notecontent");
	textArea.value = oEditor.GetXHTML(true);
	//return formValidate();
	return saveNots();
}

/**
 * save click submit
 */
function saveNots(){	
	var isValidate = formValidate();
	if(isValidate){
		var buttonsave = $('#savebutton');
		var count = buttonsave.length;
		for(var i=0;i<count;i++){
			buttonsave[i].disabled = "disabled";
		}

		document.EditView.submit();
	}
	
}