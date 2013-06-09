/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/

function splitValues() {
        var picklistObj=getObj("fldPickList")
        var pickListContent=picklistObj.value
        var pickListAry=new Array()
        var i=0;

        //Splitting up of Values
        if (pickListContent.indexOf("\n")!=-1) {
                while(pickListContent.length>0) {
                        if(pickListContent.indexOf("\n")!=-1) {
                                if (pickListContent.replace(/^\s+/g, '').replace(/\s+$/g, '').length>0) {
                                        pickListAry[i]=pickListContent.substr(0,pickListContent.indexOf("\n")).replace(/^\s+/g, '').replace(/\s+$/g, '')
                                        pickListContent=pickListContent.substr(pickListContent.indexOf("\n")+1,pickListContent.length)
                                        i++
                                } else break;
                        } else {
                                pickListAry[i]=pickListContent.substr(0,pickListContent.length)
                                break;
                        }
                }
        } else if (pickListContent.replace(/^\s+/g, '').replace(/\s+$/g, '').length>0) {
                pickListAry[0]=pickListContent.replace(/^\s+/g, '').replace(/\s+$/g, '')
        }

        return pickListAry;
}


function validate() {
	var nummaxlength = 255;
        var fieldtype = document.getElementById('selectedfieldtype').value;
	var mode = document.getElementById('cfedit_mode').value;
        if(fieldtype == "" && mode != 'edit')
	{
		alert(alert_arr.FIELD_TYPE_NOT_SELECTED);
		return false;
	}
	lengthLayer=getObj("lengthdetails")
        decimalLayer=getObj("decimaldetails")
        pickListLayer=getObj("picklist")
        var str = getObj("fldLabel").value;
        if (!emptyCheck("fldLabel",alert_arr.LABEL))
                return false
		/*
		changed by dingjianting on 2006-10-30 for chinese label
        var re1=/^[a-z\d\_ ]+$/i
        if (!re1.test(str))
        {
                alert(alert_arr.SPECIAL_CHARACTERS_NOT_ALLOWED);
                return false;
        }
		*/

        if (lengthLayer.style.visibility=="visible") {
                if (!emptyCheck("fldLength",alert_arr.LENGTH))
                        return false

                if (!intValidate("fldLength",alert_arr.LENGTH))
                        return false

                if (!numConstComp("fldLength",alert_arr.LENGTH,"GT",0))
                        return false

        }

        if (decimalLayer.style.visibility=="visible") {
                if (getObj("fldDecimal").value.replace(/^\s+/g, '').replace(/\s+$/g, '').length>0)
                        if (!intValidate("fldDecimal","Decimal"))
                                return false
                if (!numConstComp("fldDecimal","Decimal","GE",0))
                        return false

                if (!numConstComp("fldDecimal","Decimal","LE",30))
                        return false
        }
	var decimallength = document.addtodb.fldDecimal.value;
        if(fieldtype == '1' || fieldtype == '2' || fieldtype == '3')
        {
                if(decimallength == '')
                        decimallength = 0;
                nummaxlength = 65 - (eval(decimallength) + 1);
        }
        if (!numConstComp("fldLength",alert_arr.LENGTH,"LE",nummaxlength))
                return false
var picklistObj=getObj("fldPickList")
        if (pickListLayer.style.visibility=="visible") {
                if (emptyCheck("fldPickList","Picklist values"))        {
                        var pickListAry=new Array()
                        pickListAry=splitValues()

                        //Empty Check validation
                        for (i=0;i<pickListAry.length;i++) {
                                if (pickListAry[i]=="") {
                                        alert(alert_arr.PICKLIST_CANNOT_BE_EMPTY)
                                        picklistObj.focus()
                                        return false
                                }
                        }

                        //Duplicate Values' Validation
                        for (i=0;i<pickListAry.length;i++) {
                                for (j=i+1;j<pickListAry.length;j++) {
                                        if (pickListAry[i]==pickListAry[j]) {
                                                alert(alert_arr.DUPLICATE_VALUES_FOUND)
                                                picklistObj.focus()
                                                return false
                                        }
                                }
                        }

                        return true
                } else return false
        }
}
var fieldValueArr=new Array('Text','Number','Percent','Currency','Date','Email','Phone','Picklist','URL','Checkbox','TextArea','MultiSelectCombo','QQ','Msn','Trade','Yahoo','Skype','Account','Contact');
var fieldTypeArr=new Array('text','number','percent','currency','date','email','phone','picklist','url','checkbox','textarea','multiselectcombo','qq','msn','trade','yahoo','skype','account','contact');
var currFieldIdx=0,totFieldType;
var focusFieldType;

function init() {
        lengthLayer=getObj("lengthdetails")
        decimalLayer=getObj("decimaldetails")
        pickListLayer=getObj("picklist")
        totFieldType=fieldTypeArr.length-1
}


function setVisible() {
        if (focusFieldType==true) {
                var selFieldType=fieldLayer.getObj("field"+currFieldIdx)
                var height=findPosY(selFieldType)+selFieldType.offsetHeight

                if (currFieldIdx==0) {
                        fieldLayer.document.body.scrollTop=0
                } else if (height>220) {
                        fieldLayer.document.body.scrollTop+=height-220
                } else {
                        fieldLayer.document.body.scrollTop-=220-height
                }

                if (window.navigator.appName.toUpperCase()=="OPERA") {
                                var newDiv=fieldLayer.document.createElement("DIV")
                                newDiv.style.zIndex="-1"
                                newDiv.style.position="absolute"
                                newDiv.style.top=findPosY(selFieldType)+"px"
                                newDiv.style.left="25px"

                                var newObj=fieldLayer.document.createElement("INPUT")
                                newObj.type="text"

                                fieldLayer.document.body.appendChild(newDiv)
                                newDiv.appendChild(newObj)
                                newObj.focus()

                                fieldLayer.document.body.removeChild(newDiv)
                }
        }
}

function selFieldType(id,scrollLayer,bool) {
        currFieldIdx=id
        var type=fieldTypeArr[id]
	var lengthLayer=getObj("lengthdetails");
	var decimalLayer=getObj("decimaldetails");
	var pickListLayer=getObj("picklist");
        if (type=='text') {
                lengthLayer.style.visibility="visible"
                decimalLayer.style.visibility="hidden"
                pickListLayer.style.visibility="hidden"
        } else if (type=='date' || type=='email' || type=='phone' || type=='url' || type=='checkbox' || type=='textarea' || type=='qq' || type=='msn' || type=='trade' || type=='yahoo' || type=='skype' || type=='account' || type=='contact') {
                getObj("lengthdetails").style.visibility="hidden"
                decimalLayer.style.visibility="hidden"
                pickListLayer.style.visibility="hidden"
        } else if (type=='number' || type=='percent' || type=='currency') {
                lengthLayer.style.visibility="visible"
                decimalLayer.style.visibility="visible"
                pickListLayer.style.visibility="hidden"
        } else if (type=='picklist' || type=='multiselectcombo') {
                lengthLayer.style.visibility="hidden"
                decimalLayer.style.visibility="hidden"
                pickListLayer.style.visibility="visible"
        }


        parent.getObj("fieldType").value = fieldValueArr[id];
}

function srchFieldType(ev) {
        if (browser_ie) {
                var keyCode=window.fieldLayer.event.keyCode
                var currElement=window.fieldLayer.event.srcElement
                if (currElement.id.indexOf("field")>=0) var doSearch=true
                else var doSearch=false
                window.fieldLayer.event.cancelBubble=true
        } else if (browser_nn4 || browser_nn6) {
                var keyCode=ev.which
                var currElement=ev.target
                if (currElement.type) doSearch=false
                else doSearch=true
        }

        if (doSearch==true) {
                switch (keyCode) {
                        case 9  : //Reset Field Type
                                                resetFieldTypeHilite();break;
                        case 33 : //Page Up
                        case 36 : //Home
                                                selFieldType(0);break;
                        case 34 : //Page Down
                        case 35 : //End
                                                selFieldType(totFieldType);break;
                        case 38 : //Up
                                                if (currFieldIdx!=0)
                                                        selFieldType(currFieldIdx-1);
                                                else
                                                        selFieldType(totFieldType,"yes");
                                                break;
                        case 40 : //Down
                                                if (currFieldIdx!=totFieldType)
                                                        selFieldType(currFieldIdx+1);
                                                else
                                                        selFieldType(0,"yes");
default : //Character Search
                                                if (keyCode>=65 && keyCode<=90) {
                                                        var srchChar=String.fromCharCode(keyCode)
                                                        if (currFieldIdx==totFieldType) var startIdx=0
                                                        else var startIdx=currFieldIdx+1

                                                        var loop=1
                                                        for (i=startIdx;i<=totFieldType;) {
                                                                currFieldStr=fieldLayer.getObj("field"+i).innerHTML
                                                                currFieldStr=currFieldStr.replace(/^\s+/g, '').replace(/\s+$/g, '').substr(0,1)
                                                                if (currFieldStr==srchChar) {
                                                                        selFieldType(i,"yes")
                                                                        i++
                                                                } else if (i==totFieldType && loop<=2) {
                                                                        i=0
                                                                        loop++
                                                                } else i++
                                                        }
                                           }
                }
        }
}
function resetFieldTypeHilite() {
        fieldLayer.getObj("field"+currFieldIdx).className="fieldType sel"
}
function validateCustomFieldAccounts()
        {
                var obj=document.getElementsByTagName("SELECT");
                var i,j=0,k=0,l=0;
                var n=obj.length;
                account = new Array;
                contact =  new Array;
                potential = new Array;
                for( i = 0; i < n; i++)
                {
                        if(obj[i].name.indexOf("_account")>0)
                        {
                                account[j]=obj[i].value;
                                j++;
                        }
                        if(obj[i].name.indexOf("_contact")>0)
                        {
                                contact[k]=obj[i].value;
                                k++;
                        }
                        if(obj[i].name.indexOf("_potential")>0)
                        {
                                potential[l]=obj[i].value;
                                l++;
                        }
                }
                for( i = 0; i < account.length; i++)
                {
                        for(j=i+1; j<account.length; j++)
                        {
                                if( account[i] == account[j] && account[i]!="None" && account[j] !="None")
                                {
                                        alert(alert_arr.DUPLICATE_MAPPING_ACCOUNTS);
                                        return false;
                                }
                        }
                }
for( i = 0; i < contact.length; i++)
                {
                        for(k=i+1; k< contact.length; k++)
                        {
                                if( contact[i] == contact[k] && contact[i]!="None" && contact[k]!="None")
                                {
                                        alert(alert_arr.DUPLICATE_MAPPING_ACCOUNTS);
                                        return false;
                                }
                        }
                }
                for( i = 0; i < potential.length; i++)
                {
                        for(l=i+1; l<potential.length; l++)
                        {
                                if( potential[i] == potential[l] && potential[i]!="None" && potential[l]!="None")
                                {
                                        alert(alert_arr.DUPLICATE_MAPPING_ACCOUNTS);
                                        return false;
                                }
                        }

                }
        }


function gotourl(url)
{
                document.location.href=url;
}

function validateTypeforCFMapping(leadtype,leadtypeofdata,field_name,cf_form)
{
	var combo_val = cf_form.options[cf_form.selectedIndex].value;
	if(combo_val != 'None')
	{
		var type = document.getElementById(combo_val+"_type").value;
		var typeofdata = document.getElementById(combo_val+"_typeofdata").value;
		if(leadtype == type)
		{
			if(leadtypeofdata == typeofdata)
			{
				return true;
			}
			else
			{
				var lead_tod = leadtypeofdata.split("~");
				var tod = typeofdata.split("~");
				switch (lead_tod[0]) {
                	                case "V"  :
						if(lead_tod[3] <= tod[3])
							return true;
						else
						{
							alert(alertmessage[3]);
							document.getElementById(field_name).value = 'None';
							return false;
						}
						break;
					case "N"  :
						if(lead_tod[2].indexOf(",")>0)
						{
							var lead_dec = lead_tod[2].split(",");
							var dec = tod[2].split(",");
						
						}
						else
						{
							var lead_dec = lead_tod[2].split("~");
                	                                var dec = tod[2].split("~");
						}
						if(lead_dec[0] <= dec[0])
						{
							if(lead_dec[1] <= dec[1])
								return true;
							else
							{
								alert(alertmessage[4]);
								document.getElementById(field_name).value = 'None';
								return false;
							}
						}
						else
						{
							alert(alertmessage[3]);
							document.getElementById(field_name).value = 'None';
							return false;
						}
						break;
				}	
			}
		}
		else
		{
			alert(alertmessage[0]+" "+leadtype+" "+alertmessage[1]+" "+type+" "+alertmessage[2]);
			document.getElementById(field_name).value = 'None';
			return false;
		}
	}
}
