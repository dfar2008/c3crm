/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/


function qcemptyCheck(fldName,fldLabel, fldType) {
	var currObj=window.document.QcEditView[fldName]
	

	if (fldType=="text") {
		if (currObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) {

       			alert(fldLabel+"不能为空")

			currObj.focus()

                	return false

		}

        	else
            	
		return true
	} else {
		if (currObj.value == "" ) {

	                alert(fldLabel+"不能为空")

        	        return false

 	       } else return true

	}

}

function qcpatternValidate(fldName,fldLabel,type) {
	var currObj=window.document.QcEditView[fldName];
	if (type.toUpperCase()=="EMAIL") //Email ID validation
		var re=new RegExp(/^.+@.+\..+$/)
	
	if (type.toUpperCase()=="DATE") {//DATE validation 
		//YMD
		//var reg1 = /^\d{2}(\-|\/|\.)\d{1,2}\1\d{1,2}$/ //2 digit year
		//var re = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/ //4 digit year
	   
		//MYD
		//var reg1 = /^\d{1,2}(\-|\/|\.)\d{2}\1\d{1,2}$/ 
		//var reg2 = /^\d{1,2}(\-|\/|\.)\d{4}\1\d{1,2}$/ 
	   
	   //DMY
		//var reg1 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{2}$/ 
		//var reg2 = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/

		switch (userDateFormat) {
			case "yyyy-mm-dd" : 
								var re = /^\d{4}(\-|\/|\.)\d{1,2}\1\d{1,2}$/
								break;
			case "mm-dd-yyyy" : 
			case "dd-mm-yyyy" : 
								var re = /^\d{1,2}(\-|\/|\.)\d{1,2}\1\d{4}$/								
		}
	}
	
	if (type.toUpperCase()=="TIME") {//TIME validation
		var re = /^\d{1,2}\:\d{1,2}$/
	}
	
	if (!re.test(currObj.value)) {
		alert("请输入有效的"+fldLabel)
		currObj.focus()
		return false
	}
	else return true
}
function qcdateValidate(fldName,fldLabel,type) {
	if(qcpatternValidate(fldName,fldLabel,"DATE")==false)
		return false;
	dateval=window.document.QcEditView[fldName].value.replace(/^\s+/g, '').replace(/\s+$/g, '') 

	var dateelements=splitDateVal(dateval)
	
	dd=dateelements[0]
	mm=dateelements[1]
	yyyy=dateelements[2]
	
	if (dd<1 || dd>31 || mm<1 || mm>12 || yyyy<1 || yyyy<1000) {
		alert("请输入有效的"+fldLabel)
		window.document.QcEditView[fldName].focus()
		return false
	}
	
	if ((mm==2) && (dd>29)) {//checking of no. of days in february month
		alert("请输入有效的"+fldLabel)
		window.document.QcEditView[fldName].focus()
		return false
	}
	
	if ((mm==2) && (dd>28) && ((yyyy%4)!=0)) {//leap year checking
		alert("请输入有效的"+fldLabel)
		window.document.QcEditView[fldName].focus()
		return false
	}

	switch (parseInt(mm)) {
		case 2 : 
		case 4 : 
		case 6 : 
		case 9 : 
		case 11 :	if (dd>30) {
						alert("请输入有效的"+fldLabel)
						window.document.QcEditView[fldName].focus()
						return false
					}	
	}
	
	var currdate=new Date()
	var chkdate=new Date()
	
	chkdate.setYear(yyyy)
	chkdate.setMonth(mm-1)
	chkdate.setDate(dd)
	
	if (type!="OTH") {
		if (!compareDates(chkdate,fldLabel,currdate,"current date",type)) {
			window.document.QcEditView[fldName].focus()
			return false
		} else return true;
	} else return true;
}

function qcdateComparison(fldName1,fldLabel1,fldName2,fldLabel2,type) {
	var dateval1=window.document.QcEditView[fldName1].value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var dateval2=window.document.QcEditView[fldName2].value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	var dateelements1=splitDateVal(dateval1)
	var dateelements2=splitDateVal(dateval2)
	
	dd1=dateelements1[0]
	mm1=dateelements1[1]
	yyyy1=dateelements1[2]
	
	dd2=dateelements2[0]
	mm2=dateelements2[1]
	yyyy2=dateelements2[2]
	
	var date1=new Date()
	var date2=new Date()		
	
	date1.setYear(yyyy1)
	date1.setMonth(mm1-1)
	date1.setDate(dd1)		
	
	date2.setYear(yyyy2)
	date2.setMonth(mm2-1)
	date2.setDate(dd2)
	
	if (type!="OTH") {
		if (!compareDates(date1,fldLabel1,date2,fldLabel2,type)) {
			window.document.QcEditView[fldName1].focus()
			return false
		} else return true;
	} else return true
}

function qcintValidate(fldName,fldLabel) {
	var val=window.document.QcEditView[fldName].value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	if (isNaN(val) || (val.indexOf(".")!=-1 && fldName != 'potential_amount')) 
	{
		alert("无效的 "+fldLabel)
		window.document.QcEditView[fldName].focus()
		return false
	} 
        else if( val < -2147483648 || val > 2147483647)
        {
                alert(fldLabel +"越界");
                return false;
        }

	else
	{
		return true
	}
}

function qcnumConstComp(fldName,fldLabel,type,constval) {
	var val=parseFloat(window.document.QcEditView[fldName].value.replace(/^\s+/g, '').replace(/\s+$/g, ''))
	constval=parseFloat(constval)

	var ret=true
	switch (type) {
		case "L"  : if (val>=constval) {
						alert(fldLabel+" should be less than "+constval)
						ret=false
					}
					break;
		case "LE" :	if (val>constval) {
					alert(fldLabel+" should be less than or equal to "+constval)
			        ret=false
					}
					break;
		case "E"  :	if (val!=constval) {
                                        alert(fldLabel+" should be equal to "+constval)
                                        ret=false
                                }
                                break;
		case "NE" : if (val==constval) {
						 alert(fldLabel+" should not be equal to "+constval)
							ret=false
					}
					break;
		case "G"  :	if (val<=constval) {
							alert(fldLabel+" should be greater than "+constval)
							ret=false
					}
					break;
		case "GE" : if (val<constval) {
							alert(fldLabel+" should be greater than or equal to "+constval)
							ret=false
					}
					break;
	}
	
	if (ret==false) {
		window.document.QcEditView[fldName].focus()
		return false
	} else return true;
}
function qcdateTimeValidate(dateFldName,timeFldName,fldLabel,type) {
	if(qcpatternValidate(dateFldName,fldLabel,"DATE")==false)
		return false;
	dateval=window.document.QcEditView[dateFldName].value.replace(/^\s+/g, '').replace(/\s+$/g, ''); 
	var dateelements=splitDateVal(dateval);
	
	dd=dateelements[0];
	mm=dateelements[1];
	yyyy=dateelements[2];
	
	if (dd<1 || dd>31 || mm<1 || mm>12 || yyyy<1 || yyyy<1000) {
		alert("请输入有效的"+fldLabel)
		window.document.QcEditView[dateFldName].focus()
		return false
	}
	
	if ((mm==2) && (dd>29)) {//checking of no. of days in february month
		alert("请输入有效的"+fldLabel)
		window.document.QcEditView[dateFldName].focus()
		return false
	}
	
	if ((mm==2) && (dd>28) && ((yyyy%4)!=0)) {//leap year checking
		alert("请输入有效的"+fldLabel)
		window.document.QcEditView[dateFldName].focus()
		return false
	}

	switch (parseInt(mm)) {
		case 2 : 
		case 4 : 
		case 6 : 
		case 9 : 
		case 11 :	if (dd>30) {
						alert("请输入有效的"+fldLabel)
						window.document.QcEditView[dateFldName].focus()
						return false
					}	
	}
	
	if (qcpatternValidate(timeFldName,fldLabel,"TIME")==false)
		return false
		
	var timeval=window.document.QcEditView[timeFldName].value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
	var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))
	var currObj=window.document.QcEditView[timeFldName]
	
	if (hourval>23 || minval>59) {
		alert("请输入有效的"+fldLabel)
		currObj.focus()
		return false
	}
	
	var currdate=new Date()
	var chkdate=new Date()
	
	chkdate.setYear(yyyy)
	chkdate.setMonth(mm-1)
	chkdate.setDate(dd)
	chkdate.setHours(hourval)
	chkdate.setMinutes(minval)
	
	if (type!="OTH") {
		if (!compareDates(chkdate,fldLabel,currdate,"current date & time",type)) {
			window.document.QcEditView[dateFldName].focus()
			return false
		} else return true;
	} else return true;
}

