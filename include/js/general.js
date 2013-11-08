if (document.all)

	var browser_ie=true

else if (document.layers)

	var browser_nn4=true

else if (document.layers || (!document.all && document.getElementById))

	var browser_nn6=true


function getObj(n,d) {
	
  var p,i,x; 

  if(!d)

      d=document;

   
   if(n != undefined)
   {
	   if((p=n.indexOf("?"))>0&&parent.frames.length) {

		   d=parent.frames[n.substring(p+1)].document;n=n.substring(0,p);

	   }
   }



  if(!(x=d[n])&&d.all)

      x=d.all[n];

 

  for(i=0;!x&&i<d.forms.length;i++)

      x=d.forms[i][n];

 

  for(i=0;!x&&d.layers&&i<d.layers.length;i++)

      x=getObj(n,d.layers[i].document);

 

  if(!x && d.getElementById)

      x=d.getElementById(n);



  return x;

}

function getOpenerObj(n) {

    return getObj(n,opener.document)

}



function findPosX(obj) {

	var curleft = 0;

	if (document.getElementById || document.all) {

		while (obj.offsetParent) {

			curleft += obj.offsetLeft

			obj = obj.offsetParent;

		}

	} else if (document.layers) {

		curleft += obj.x;

	}



	return curleft;

}



function findPosY(obj) {

	var curtop = 0;



	if (document.getElementById || document.all) {

		while (obj.offsetParent) {

			curtop += obj.offsetTop

			obj = obj.offsetParent;

		}

	} else if (document.layers) {

		curtop += obj.y;

	}



	return curtop;

}



function clearTextSelection() {

	if (browser_ie) document.selection.empty();

    else if (browser_nn4 || browser_nn6) window.getSelection().removeAllRanges();

}

// Setting cookies
function set_cookie ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
  var cookie_string = name + "=" + escape ( value );

  if (exp_y) //delete_cookie(name)
  {
    var expires = new Date ( exp_y, exp_m, exp_d );
    cookie_string += "; expires=" + expires.toGMTString();
  }

  if (path) cookie_string += "; path=" + escape ( path );
  if (domain) cookie_string += "; domain=" + escape ( domain );
  if (secure) cookie_string += "; secure";

  document.cookie = cookie_string;
}

// Retrieving cookies
function get_cookie(cookie_name)
{
  var results = document.cookie.match(cookie_name + '=(.*?)(;|$)');
  if (results) return (unescape(results[1]));
  else return null;
}

// Delete cookies 
function delete_cookie( cookie_name )
{
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}
//End of Utility Functions


function emptyCheck(fldName,fldLabel, fldType)
{
        var currObj=getObj(fldName)
        if (fldType=="text") {
                if (currObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '').length==0) {
                        alert(fldLabel+alert_arr.CANNOT_BE_EMPTY)
                        currObj.focus()
                        return false
                }
                else
                        return true
        }
        else if (fldType=="select-one") {
               if (currObj.value == "" || currObj.value == alert_arr.NONE) {
                        alert(fldLabel+alert_arr.CANNOT_BE_EMPTY)
                        currObj.focus()
                        return false
               }
               else
                        return true                
        } else {
                if (currObj.value == "") {
                        alert(fldLabel+alert_arr.CANNOT_BE_EMPTY)
                        return false
               }
               else
                        return true
        }
}



function patternValidate(fldName,fldLabel,type) {
	var currObj=getObj(fldName)
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
		if(userDateFormat===undefined){
			var userDateFormat="yyyy-mm-dd";
		}
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
		alert(alert_arr.ENTER_VALID + fldLabel);
		currObj.focus();
		return false
	}
	else return true
}

function isChar(str) {
	//var re= new RegExp(/[a-zA-Z0-9_]/);
	var re = /^[a-zA-Z\d\_]+$/i;
	if (!re.test(str)) {
		return false;
	}
	else {
		return true;
	}
}
function splitDateVal(dateval) {
	var datesep;
	var dateelements = new Array(3);
	
	if (dateval.indexOf("-")>=0) datesep="-"
	else if (dateval.indexOf(".")>=0) datesep="."
	else if (dateval.indexOf("/")>=0) datesep="/"
	if(userDateFormat===undefined){
			var userDateFormat="yyyy-mm-dd";
		}
	switch (userDateFormat) {
		case "yyyy-mm-dd" :
							dateelements[0]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length) //dd
							dateelements[1]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep)) //mm
							dateelements[2]=dateval.substring(0,dateval.indexOf(datesep)) //yyyyy
							break;
		case "mm-dd-yyyy" :
							dateelements[0]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep))
							dateelements[1]=dateval.substring(0,dateval.indexOf(datesep))
							dateelements[2]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length)
							break;
		case "dd-mm-yyyy" :
							dateelements[0]=dateval.substring(0,dateval.indexOf(datesep))
							dateelements[1]=dateval.substring(dateval.indexOf(datesep)+1,dateval.lastIndexOf(datesep))
							dateelements[2]=dateval.substr(dateval.lastIndexOf(datesep)+1,dateval.length)
	}
	
	return dateelements;
}

function compareDates(date1,fldLabel1,date2,fldLabel2,type) {
	var ret=true
	switch (type) {
		case 'L'	:if (date1>=date2) {//DATE1 VALUE LESS THAN DATE2
							alert(fldLabel1+ alert_arr.SHOULDBE_LESS +fldLabel2)
							ret=false
						}
						break;
		case 'LE'	:if (date1>date2) {//DATE1 VALUE LESS THAN OR EQUAL TO DATE2
							alert(fldLabel1+alert_arr.SHOULDBE_LESS_EQUAL+fldLabel2)
							ret=false
						}
						break;
		case 'E'	:if (date1!=date2) {//DATE1 VALUE EQUAL TO DATE
							alert(fldLabel1+alert_arr.SHOULDBE_EQUAL+fldLabel2)
							ret=false
						}
						break;
		case 'G'	:if (date1<=date2) {//DATE1 VALUE GREATER THAN DATE2
							alert(fldLabel1+alert_arr.SHOULDBE_GREATER+fldLabel2)
							ret=false
						}
						break;	
		case 'GE'	:if (date1<date2) {//DATE1 VALUE GREATER THAN OR EQUAL TO DATE2
							alert(fldLabel1+alert_arr.SHOULDBE_GREATER_EQUAL+fldLabel2)
							ret=false
						}
						break;
	}
	
	if (ret==false) return false
	else return true
}

function compareDatesNoAlert(date1,date2,type) {
	var ret=true
	switch (type) {
		case 'L'	:if (date1>=date2) {//DATE1 VALUE LESS THAN DATE2
							ret=false
						}
						break;
		case 'LE'	:if (date1>date2) {//DATE1 VALUE LESS THAN OR EQUAL TO DATE2
							ret=false
						}
						break;
		case 'E'	:if (date1!=date2) {//DATE1 VALUE EQUAL TO DATE
							ret=false
						}
						break;
		case 'G'	:if (date1<=date2) {//DATE1 VALUE GREATER THAN DATE2
							ret=false
						}
						break;	
		case 'GE'	:if (date1<date2) {//DATE1 VALUE GREATER THAN OR EQUAL TO DATE2
							ret=false
						}
						break;
	}
	
	if (ret==false) return false
	else return true
}

function dateTimeValidate(dateFldName,timeFldName,fldLabel,type) {
	if(patternValidate(dateFldName,fldLabel,"DATE")==false)
		return false;
	dateval=getObj(dateFldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '') 
	
	var dateelements=splitDateVal(dateval)
	
	dd=dateelements[0]
	mm=dateelements[1]
	yyyy=dateelements[2]
	
	if (dd<1 || dd>31 || mm<1 || mm>12 || yyyy<1 || yyyy<1000) {
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(dateFldName).focus()
		return false
	}
	
	if ((mm==2) && (dd>29)) {//checking of no. of days in february month
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(dateFldName).focus()
		return false
	}
	
	if ((mm==2) && (dd>28) && ((yyyy%4)!=0)) {//leap year checking
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(dateFldName).focus()
		return false
	}

	switch (parseInt(mm)) {
		case 2 : 
		case 4 : 
		case 6 : 
		case 9 : 
		case 11 :if (dd>30) {
						alert(alert_arr.ENTER_VALID+fldLabel)
						getObj(dateFldName).focus()
						return false
					}	
	}
	
	if (patternValidate(timeFldName,fldLabel,"TIME")==false)
		return false
		
	var timeval=getObj(timeFldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
	var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))
	var currObj=getObj(timeFldName)
	
	if (hourval>23 || minval>59) {
		alert(alert_arr.ENTER_VALID+fldLabel)
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
			getObj(dateFldName).focus()
			return false
		} else return true;
	} else return true;
}

function dateTimeComparison(dateFldName1,timeFldName1,fldLabel1,dateFldName2,timeFldName2,fldLabel2,type) {
	var dateval1=getObj(dateFldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var dateval2=getObj(dateFldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	
	var dateelements1=splitDateVal(dateval1)
	var dateelements2=splitDateVal(dateval2)
	
	dd1=dateelements1[0]
	mm1=dateelements1[1]
	yyyy1=dateelements1[2]
	
	dd2=dateelements2[0]
	mm2=dateelements2[1]
	yyyy2=dateelements2[2]
	
	var timeval1=getObj(timeFldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var timeval2=getObj(timeFldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	
	var hh1=timeval1.substring(0,timeval1.indexOf(":"))
	var min1=timeval1.substring(timeval1.indexOf(":")+1,timeval1.length)
	
	var hh2=timeval2.substring(0,timeval2.indexOf(":"))
	var min2=timeval2.substring(timeval2.indexOf(":")+1,timeval2.length)
	
	var date1=new Date()
	var date2=new Date()		
	
	date1.setYear(yyyy1)
	date1.setMonth(mm1-1)
	date1.setDate(dd1)
	date1.setHours(hh1)
	date1.setMinutes(min1)
	
	date2.setYear(yyyy2)
	date2.setMonth(mm2-1)
	date2.setDate(dd2)
	date2.setHours(hh2)
	date2.setMinutes(min2)
	
	if (type!="OTH") {
		if (!compareDates(date1,fldLabel1,date2,fldLabel2,type)) {
			getObj(dateFldName1).focus()
			return false
		} else return true;
	} else return true;
}

function dateValidate(fldName,fldLabel,type) {
	if(patternValidate(fldName,fldLabel,"DATE")==false)
		return false;
	dateval=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '') 

	var dateelements=splitDateVal(dateval)
	
	dd=dateelements[0]
	mm=dateelements[1]
	yyyy=dateelements[2]
	
	if (dd<1 || dd>31 || mm<1 || mm>12 || yyyy<1 || yyyy<1000) {
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(fldName).focus()
		return false
	}
	
	if ((mm==2) && (dd>29)) {//checking of no. of days in february month
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(fldName).focus()
		return false
	}
	
	if ((mm==2) && (dd>28) && ((yyyy%4)!=0)) {//leap year checking
		alert(alert_arr.ENTER_VALID+fldLabel)
		getObj(fldName).focus()
		return false
	}

	switch (parseInt(mm)) {
		case 2 : 
		case 4 : 
		case 6 : 
		case 9 : 
		case 11 :if (dd>30) {
						alert(alert_arr.ENTER_VALID+fldLabel)
						getObj(fldName).focus()
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
			getObj(fldName).focus()
			return false
		} else return true;
	} else return true;
}

function dateComparison(fldName1,fldLabel1,fldName2,fldLabel2,type) {
	var dateval1=getObj(fldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var dateval2=getObj(fldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')

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
			getObj(fldName1).focus()
			return false
		} else return true;
	} else return true
}

function timeValidate(fldName,fldLabel,type) {
	if (patternValidate(fldName,fldLabel,"TIME")==false)
		return false
		
	var timeval=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var hourval=parseInt(timeval.substring(0,timeval.indexOf(":")))
	var minval=parseInt(timeval.substring(timeval.indexOf(":")+1,timeval.length))
	var currObj=getObj(fldName)
	
	if (hourval>23 || minval>59) {
		alert(alert_arr.ENTER_VALID+fldLabel)
		currObj.focus()
		return false
	}
	
	var currtime=new Date()
	var chktime=new Date()
	
	chktime.setHours(hourval)
	chktime.setMinutes(minval)
	
	if (type!="OTH") {
		if (!compareDates(chktime,fldLabel1,currtime,"current time",type)) {
			getObj(fldName).focus()
			return false
		} else return true;
	} else return true
}

function timeComparison(fldName1,fldLabel1,fldName2,fldLabel2,type) {
	var timeval1=getObj(fldName1).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	var timeval2=getObj(fldName2).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	
	var hh1=timeval1.substring(0,timeval1.indexOf(":"))
	var min1=timeval1.substring(timeval1.indexOf(":")+1,timeval1.length)
	
	var hh2=timeval2.substring(0,timeval2.indexOf(":"))
	var min2=timeval2.substring(timeval2.indexOf(":")+1,timeval2.length)

	var time1=new Date()
	var time2=new Date()		
	
	time1.setHours(hh1)
	time1.setMinutes(min1)
	
	time2.setHours(hh2)
	time2.setMinutes(min2)

	if (type!="OTH") {	
		if (!compareDates(time1,fldLabel1,time2,fldLabel2,type)) {
			getObj(fldName1).focus()
			return false
		} else return true;
	} else return true;
}

function numValidate(fldName,fldLabel,format,neg) {
   var val=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
   if (format!="any") {
       if (isNaN(val)) {
           var invalid=true
       } else {
           var format=format.split(",")
           var splitval=val.split(".")
		   /*
           if (neg==true) {
               if (splitval[0].indexOf("-")>=0) {
                   if (splitval[0].length-1>format[0])
                       invalid=true
               } else {
                   if (splitval[0].length>format[0])
                       invalid=true
               }
           } else {
               if (val<0)
                   invalid=true
               else if (splitval[0].length>format[0])
                   invalid=true
           }
		   */
		   if (splitval[0].indexOf("-")>=0) {
			   if (splitval[0].length-1>format[0])
				   invalid=true
		   } else {
			   if (splitval[0].length>format[0])
				   invalid=true
		   }
           if (splitval[1] && splitval[1].length>format[1]) {
                   invalid=true
		   }
       }
       if (invalid==true) {
           alert(alert_arr.INVALID+fldLabel)
           getObj(fldName).focus()
           return false;
       } else {
		   return true
	   }
   } else {
	
	   var splitval=val.split(".")

		if(splitval[0]>2147483647000)
		{
			alert( fldLabel + alert_arr.EXCEEDS_MAX);
			return false;
		}

       /*
       if (neg == "" || neg==true) {
           var re=/^(-|)\d+(\.\d\d*)*$/
	   }
       else {
           var re=/^\d+(\.\d\d*)*$/
	   }
	   */
	   var re=/^(-|)\d+(\.\d\d*)*$/
   }
      if (!re.test(val)) {
       alert(alert_arr.INVALID+fldLabel)
       getObj(fldName).focus()
       return false
   } else return true
}


function intValidate(fldName,fldLabel) {
	var val=getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, '')
	if (isNaN(val) || (val.indexOf(".")!=-1 && fldName != 'potential_amount')) 
	{
		alert(alert_arr.INVALID+fldLabel)
		getObj(fldName).focus()
		return false
	} 
        else if( val < -2147483648 || val > 2147483647)
        {
                alert(fldLabel +alert_arr.OUT_OF_RANGE);
                return false;
        }

	else
	{
		return true
	}
}


function numConstComp(fldName,fldLabel,type,constval) {
	var val=parseFloat(getObj(fldName).value.replace(/^\s+/g, '').replace(/\s+$/g, ''))
	constval=parseFloat(constval)

	var ret=true
	switch (type) {
		case "L"  :if (val>=constval) {
						alert(fldLabel+alert_arr.SHOULDBE_LESS+constval)
						ret=false
					}
					break;
		case "LE" :if (val>constval) {
					alert(fldLabel+alert_arr.SHOULDBE_LESS_EQUAL+constval)
			        ret=false
					}
					break;
		case "E"  :if (val!=constval) {
                                        alert(fldLabel+alert_arr.SHOULDBE_EQUAL+constval)
                                        ret=false
                                }
                                break;
		case "NE" :if (val==constval) {
						 alert(fldLabel+alert_arr.SHOULDNOTBE_EQUAL+constval)
							ret=false
					}
					break;
		case "G"  :if (val<=constval) {
							alert(fldLabel+alert_arr.SHOULDBE_GREATER+constval)
							ret=false
					}
					break;
		case "GE" :if (val<constval) {
							alert(fldLabel+alert_arr.SHOULDBE_GREATER_EQUAL+constval)
							ret=false
					}
					break;
	}
	
	if (ret==false) {
		getObj(fldName).focus()
		return false
	} else return true;
}

//added by xiaoyang on 2013-4-25
function removeHTMLTag(str) {
	str = str.replace(/(^\s*)|(\s*$)/g,""); //去除首尾空白
	str = str.replace(/<\/?[^>]*>/g,''); //去除HTML tag
	str = str.replace(/[ | ]*\n/g,'\n'); //去除行尾空白
	//str = str.replace(/\n[\s| | ]*\r/g,'\n'); //去除多余空行
	//str=str.replace(/&nbsp;/ig,'');//去掉&nbsp;
	return str;
}

function formValidate() { 
	for (var i=0; i<fieldname.length; i++) {
		
		if(getObj(fieldname[i]) != null)
		{   
			var type=fielddatatype[i].split("~");

				
				if (type[1]=="M") {
					if (!emptyCheck(fieldname[i],fieldlabel[i],getObj(fieldname[i]).type))
				    { 
						//getObj(fieldname[i]).focus();
						return false;
					}
				}
            //added by xiaoyang on 2013-4-25
			if(fieldname[i] != "title"){
				getObj(fieldname[i]).value = removeHTMLTag(getObj(fieldname[i]).value);
			}else{
				document.getElementById(fieldname[i]).value = removeHTMLTag(document.getElementById(fieldname[i]).value);
			}
			switch (type[0]) {
				case "O"  :break;
				case "V"  :break;
				case "C"  :break;
				case "DT" :
					if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if (type[1]=="M")
							if (!emptyCheck(type[2],fieldlabel[i],getObj(type[2]).type)) {
							    //getObj(fieldname[i]).focus();
								return false;
						    }

									if(typeof(type[3])=="undefined") var currdatechk="OTH"
									else var currdatechk=type[3]

										if (!dateTimeValidate(fieldname[i],type[2],fieldlabel[i],currdatechk)) {
											//getObj(fieldname[i]).focus();
											return false;
										}
												if (type[4]) {
													if (!dateTimeComparison(fieldname[i],type[2],fieldlabel[i],type[5],type[6],type[4])) {
														//getObj(fieldname[i]).focus();
														return false;
													}

												}
					}		
				break;
				case "D"  :
					if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if(typeof(type[2])=="undefined") var currdatechk="OTH"
						else var currdatechk=type[2]

							if (!dateValidate(fieldname[i],fieldlabel[i],currdatechk)) {
								//getObj(fieldname[i]).focus();
								return false;
							}
									if (type[3]) {
										if (!dateComparison(fieldname[i],fieldlabel[i],type[4],type[5],type[3])) {
											//getObj(fieldname[i]).focus();
											return false;
										}
									}
					}	
				break;
				case "T"  : 
					if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if(typeof(type[2])=="undefined") var currtimechk="OTH"
						else var currtimechk=type[2]

							if (!timeValidate(fieldname[i],fieldlabel[i],currtimechk)) {
								//getObj(fieldname[i]).focus();
								return false;
							}
									if (type[3]) {
										if (!timeComparison(fieldname[i],fieldlabel[i],type[4],type[5],type[3])) {
											//getObj(fieldname[i]).focus();
											return false;
										}
									}
					}
				break;
				case "I"  :
					if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if (getObj(fieldname[i]).value.length!=0)
						{
							if (!intValidate(fieldname[i],fieldlabel[i])) {
								//getObj(fieldname[i]).focus();
								return false;
							}
									if (type[2]) {
										if (!numConstComp(fieldname[i],fieldlabel[i],type[2],type[3])) {
											//getObj(fieldname[i]).focus();
											return false;
										}
									}
						}
					}
				break;
				case "N"  :
					case "NN" :
					if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (getObj(fieldname[i]).value.length!=0)
						{
							if (typeof(type[2])=="undefined") var numformat="any"
							else var numformat=type[2]

								if (type[0]=="NN") {

									if (!numValidate(fieldname[i],fieldlabel[i],numformat,true)) {
										//getObj(fieldname[i]).focus();
										return false;
									}
								} else {
									if (!numValidate(fieldname[i],fieldlabel[i],numformat)){
										//getObj(fieldname[i]).focus();
										return false;
									}
								}
							if (type[3]) {
								if (!numConstComp(fieldname[i],fieldlabel[i],type[3],type[4])){
										//getObj(fieldname[i]).focus();
										return false;
								}
							}
						}
					}
				break;
				case "E"  :
					if (getObj(fieldname[i]) != null && getObj(fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (getObj(fieldname[i]).value.length!=0)
						{
							var etype = "EMAIL"
								if (!patternValidate(fieldname[i],fieldlabel[i],etype)) {
										//getObj(fieldname[i]).focus();
										return false;
								}
						}
					}
				break;
			}
		}
	}

	
	return true
}

function quickEditFormValidate_OLD(quickeditfield,quick_fieldname,quick_fieldlabel,quick_fielddatatype) {
	for (var i=0; i<quick_fieldname.length; i++) {
		if(quick_fieldname[i] != quickeditfield) continue;
		if(getObj("quickedit_value_"+quick_fieldname[i]) != null)
		{
			var type=quick_fielddatatype[i].split("~")
				if (type[1]=="M") {
					if (!emptyCheck("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],getObj("quickedit_value_"+quick_fieldname[i]).type))
				    { 
						//getObj("quickedit_value_"+quick_fieldname[i]).focus();
						return false;
					}
				}

			switch (type[0]) {
				case "O"  :break;
				case "V"  :break;
				case "C"  :break;
				case "DT" :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if (type[1]=="M")
							if (!emptyCheck(type[2],quick_fieldlabel[i],getObj(type[2]).type)) {
							    //getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
						    }

									if(typeof(type[3])=="undefined") var currdatechk="OTH"
									else var currdatechk=type[3]

										if (!dateTimeValidate("quickedit_value_"+quick_fieldname[i],type[2],quick_fieldlabel[i],currdatechk)) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
												if (type[4]) {
													if (!dateTimeComparison("quickedit_value_"+quick_fieldname[i],type[2],quick_fieldlabel[i],type[5],type[6],type[4])) {
														//getObj("quickedit_value_"+quick_fieldname[i]).focus();
														return false;
													}

												}
					}		
				break;
				case "D"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if(typeof(type[2])=="undefined") var currdatechk="OTH"
						else var currdatechk=type[2]

							if (!dateValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],currdatechk)) {
								//getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
							}
									if (type[3]) {
										if (!dateComparison("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[4],type[5],type[3])) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
									}
					}	
				break;
				case "T"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if(typeof(type[2])=="undefined") var currtimechk="OTH"
						else var currtimechk=type[2]

							if (!timeValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],currtimechk)) {
								//getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
							}
									if (type[3]) {
										if (!timeComparison("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[4],type[5],type[3])) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
									}
					}
				break;
				case "I"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if (getObj("quickedit_value_"+quick_fieldname[i]).value.length!=0)
						{
							if (!intValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i])) {
								//getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
							}
									if (type[2]) {
										if (!numConstComp("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[2],type[3])) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
									}
						}
					}
				break;
				case "N"  :
					case "NN" :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (getObj("quickedit_value_"+quick_fieldname[i]).value.length!=0)
						{
							if (typeof(type[2])=="undefined") var numformat="any"
							else var numformat=type[2]

								if (type[0]=="NN") {

									if (!numValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],numformat,true)) {
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
									}
								} else {
									if (!numValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],numformat)){
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
									}
								}
							if (type[3]) {
								if (!numConstComp("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[3],type[4])){
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
								}
							}
						}
					}
				break;
				case "E"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (getObj("quickedit_value_"+quick_fieldname[i]).value.length!=0)
						{
							var etype = "EMAIL"
								if (!patternValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],etype)) {
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
								}
						}
					}
				break;
			}
		}
	}
	return true
}

function quickEditFormValidate(quickeditfield,quick_fieldname,quick_fieldlabel,quick_fielddatatype) {

	for (var i=0; i<quick_fieldname.length; i++) {
		if(quick_fieldname[i] != quickeditfield) continue;
		if(getObj("quickedit_value_"+quick_fieldname[i]) != null)
		{	
			var type=quick_fielddatatype[i].split("~");
			
				if (type[1]=="M") {
					if (!emptyCheck("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],getObj("quickedit_value_"+quick_fieldname[i]).type))
				    { 
						//getObj("quickedit_value_"+quick_fieldname[i]).focus();
						return false;
					}
				}

			switch (type[0]) {
				case "O"  :break;
				case "V"  :break;
				case "C"  :break;
				case "DT" :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if (type[1]=="M")
							if (!emptyCheck(type[2],quick_fieldlabel[i],getObj(type[2]).type)) {
							    //getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
						    }

									if(typeof(type[3])=="undefined") var currdatechk="OTH"
									else var currdatechk=type[3]

										if (!dateTimeValidate("quickedit_value_"+quick_fieldname[i],type[2],quick_fieldlabel[i],currdatechk)) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
												if (type[4]) {
													if (!dateTimeComparison("quickedit_value_"+quick_fieldname[i],type[2],quick_fieldlabel[i],type[5],type[6],type[4])) {
														//getObj("quickedit_value_"+quick_fieldname[i]).focus();
														return false;
													}

												}
					}		
				break;
				case "D"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if(typeof(type[2])=="undefined") var currdatechk="OTH"
						else var currdatechk=type[2]

							if (!dateValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],currdatechk)) {
								//getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
							}
									if (type[3]) {
										if (!dateComparison("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[4],type[5],type[3])) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
									}
					}	
				break;
				case "T"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	 
						if(typeof(type[2])=="undefined") var currtimechk="OTH"
						else var currtimechk=type[2]

							if (!timeValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],currtimechk)) {
								//getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
							}
									if (type[3]) {
										if (!timeComparison("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[4],type[5],type[3])) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
									}
					}
				break;
				case "I"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{	
						if (getObj("quickedit_value_"+quick_fieldname[i]).value.length!=0)
						{
							if (!intValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i])) {
								//getObj("quickedit_value_"+quick_fieldname[i]).focus();
								return false;
							}
									if (type[2]) {
										if (!numConstComp("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[2],type[3])) {
											//getObj("quickedit_value_"+quick_fieldname[i]).focus();
											return false;
										}
									}
						}
					}
				break;
				case "N"  :
					case "NN" :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (getObj("quickedit_value_"+quick_fieldname[i]).value.length!=0)
						{
							if (typeof(type[2])=="undefined") var numformat="any"
							else var numformat=type[2]

								if (type[0]=="NN") {

									if (!numValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],numformat,true)) {
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
									}
								} else {
									if (!numValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],numformat)){
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
									}
								}
							if (type[3]) {
								if (!numConstComp("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],type[3],type[4])){
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
								}
							}
						}
					}
				break;
				case "E"  :
					if (getObj("quickedit_value_"+quick_fieldname[i]) != null && getObj("quickedit_value_"+quick_fieldname[i]).value.replace(/^\s+/g, '').replace(/\s+$/g, '').length!=0)
					{
						if (getObj("quickedit_value_"+quick_fieldname[i]).value.length!=0)
						{
							var etype = "EMAIL"
								if (!patternValidate("quickedit_value_"+quick_fieldname[i],quick_fieldlabel[i],etype)) {
										//getObj("quickedit_value_"+quick_fieldname[i]).focus();
										return false;
								}
						}
					}
				break;
			}
		}
	}
	return true
}

function clearId(fldName) {

	var currObj=getObj(fldName)	

	currObj.value=""

}

function showCalc(fldName) {
	var currObj=getObj(fldName)
	openPopUp("calcWin",currObj,"/crm/Calc.do?currFld="+fldName,"Calc",170,220,"menubar=no,toolbar=no,location=no,status=no,scrollbars=no,resizable=yes")
}

function showLookUp(fldName,fldId,fldLabel,searchmodule,hostName,serverPort,username) {
	var currObj=getObj(fldName)

	//var fldValue=currObj.value.replace(/^\s+/g, '').replace(/\s+$/g, '')

	//need to pass the name of the system in which the server is running so that even when the search is invoked from another system, the url will remain the same

	openPopUp("lookUpWin",currObj,"/crm/Search.do?searchmodule="+searchmodule+"&fldName="+fldName+"&fldId="+fldId+"&fldLabel="+fldLabel+"&fldValue=&user="+username,"LookUp",500,400,"menubar=no,toolbar=no,location=no,status=no,scrollbars=yes,resizable=yes")
}

function openPopUp(winInst,currObj,baseURL,winName,width,height,features) {
	var left=parseInt(findPosX(currObj))
	var top=parseInt(findPosY(currObj))
	
	if (window.navigator.appName!="Opera") top+=parseInt(currObj.offsetHeight)
	else top+=(parseInt(currObj.offsetHeight)*2)+10

	if (browser_ie)	{
		top+=window.screenTop-document.body.scrollTop
		left-=document.body.scrollLeft
		if (top+height+30>window.screen.height) 
			top=findPosY(currObj)+window.screenTop-height-30 //30 is a constant to avoid positioning issue
		if (left+width>window.screen.width) 
			left=findPosX(currObj)+window.screenLeft-width
	} else if (browser_nn4 || browser_nn6) {
		top+=(scrY-pgeY)
		left+=(scrX-pgeX)
		if (top+height+30>window.screen.height) 
			top=findPosY(currObj)+(scrY-pgeY)-height-30
		if (left+width>window.screen.width) 
			left=findPosX(currObj)+(scrX-pgeX)-width
	}
	
	features="width="+width+",height="+height+",top="+top+",left="+left+";"+features
	eval(winInst+'=window.open("'+baseURL+'","'+winName+'","'+features+'")')
}

var scrX=0,scrY=0,pgeX=0,pgeY=0;

if (browser_nn4 || browser_nn6) {
	document.addEventListener("click",popUpListener,true)
}

function popUpListener(ev) {
	if (browser_nn4 || browser_nn6) {
		scrX=ev.screenX
		scrY=ev.screenY
		pgeX=ev.pageX
		pgeY=ev.pageY
	}
}
function toggleSelect(state,relCheckName) {
	var checkboxs=document.getElementsByName(relCheckName);
	if (typeof(checkboxs.length)=="undefined") {
		checkboxs.checked = state
	} else { 
		if (checkboxs) {
				for (var i=0;i<checkboxs.length;i++)
				{
					checkboxs[i].checked=state
				}
		}
	}
}
function toggleSelectAll(relCheckName,selectAllName) {
    var checkboxs=document.getElementsByName(relCheckName);
	var checkboxsall=document.getElementsByName(selectAllName);
	
	if (typeof(checkboxs.length)=="undefined") {
		checkboxsall.checked=checkboxs.checked
	} else { 
		var atleastOneFalse=false; 
		for (var i=0;i<checkboxs.length;i++) {
			if (checkboxs[i].checked==false) {
				atleastOneFalse=true
				break;
			}
		}
		checkboxsall.checked=!atleastOneFalse
	}
}

function toggleSelectOLD(state,relCheckName) {
	
	if (getNewObj(relCheckName)) {
		if (typeof(getNewObj(relCheckName).length)=="undefined") {
			getNewObj(relCheckName).checked=state			
		} else {
			for (var i=0;i<getNewObj(relCheckName).length;i++)
				getNewObj(relCheckName)[i].checked=state
		}
	}
}

function toggleSelectAllOLD(relCheckName,selectAllName) {
    
	if (typeof(getNewObj(relCheckName).length)=="undefined") {
		getNewObj(selectAllName).checked=getNewObj(relCheckName).checked
	} else {  
		var atleastOneFalse=false;
		for (var i=0;i<getNewObj(relCheckName).length;i++) {
			if (getNewObj(relCheckName)[i].checked==false) {
				atleastOneFalse=true
				break;
			}
		}
		getNewObj(selectAllName).checked=!atleastOneFalse
	}
}


//added for show/hide 10July
function expandCont(bn)
{
	var leftTab = document.getElementById(bn);
       	leftTab.style.display = (leftTab.style.display == "block")?"none":"block";
       	img = document.getElementById("img_"+bn);
      	img.src=(img.src.indexOf("images/toggle1.gif")!=-1)?"themes/images/toggle2.gif":"themes/images/toggle1.gif";
      	set_cookie_gen(bn,leftTab.style.display)

}

function setExpandCollapse_gen()
{
	var x = leftpanelistarray.length;
	for (i = 0 ; i < x ; i++)
	{
		var listObj=getObj(leftpanelistarray[i])
		var tgImageObj=getObj("img_"+leftpanelistarray[i])
		var status = get_cookie_gen(leftpanelistarray[i])
		
		if (status == "block") {
			listObj.style.display="block";
			tgImageObj.src="themes/images/toggle2.gif";
		} else if(status == "none") {
			listObj.style.display="none";
			tgImageObj.src="themes/images/toggle1.gif";
		}
	}
}

function toggleDiv(id) {

	var listTableObj=getObj(id)

	if (listTableObj.style.display=="block") 
	{
		listTableObj.style.display="none"
	}else{
		listTableObj.style.display="block"
	}
	//set_cookie(id,listTableObj.style.display)
}

//Setting cookies
function set_cookie_gen ( name, value, exp_y, exp_m, exp_d, path, domain, secure )
{
  var cookie_string = name + "=" + escape ( value );

  if ( exp_y )
  {
    var expires = new Date ( exp_y, exp_m, exp_d );
    cookie_string += "; expires=" + expires.toGMTString();
  }

  if ( path )
        cookie_string += "; path=" + escape ( path );

  if ( domain )
        cookie_string += "; domain=" + escape ( domain );
  
  if ( secure )
        cookie_string += "; secure";
  
  document.cookie = cookie_string;
}

// Retrieving cookies
function get_cookie_gen ( cookie_name )
{
  var results = document.cookie.match ( cookie_name + '=(.*?)(;|$)' );

  if ( results )
    return ( unescape ( results[1] ) );
  else
    return null;
}

// Delete cookies 
function delete_cookie_gen ( cookie_name )
{
  var cookie_date = new Date ( );  // current date & time
  cookie_date.setTime ( cookie_date.getTime() - 1 );
  document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
}
//end added for show/hide 10July

/** This is Javascript Function which is used to toogle between
  * assigntype user and group/team select options while assigning owner to entity.
  */
function toggleAssignType(currType)
{
        if (currType=="U")
        {
                getObj("assign_user").style.display="block"
                getObj("assign_team").style.display="none"
        }
        else
        {
                getObj("assign_user").style.display="none"
                getObj("assign_team").style.display="block"
        }
}
//to display type of address for google map
function showLocateMapMenu()
    {
            getObj("dropDownMenu").style.display="block"
            getObj("dropDownMenu").style.left=findPosX(getObj("locateMap"))
            getObj("dropDownMenu").style.top=findPosY(getObj("locateMap"))+getObj("locateMap").offsetHeight
    }


function hideLocateMapMenu(ev)
    {
            if (browser_ie)
                    currElement=window.event.srcElement
            else if (browser_nn4 || browser_nn6)
                    currElement=ev.target

            if (currElement.id!="locateMap")
                    if (getObj("dropDownMenu").style.display=="block")
                            getObj("dropDownMenu").style.display="none"
    }
/*
* javascript function to display the div tag
* @param divId :: div tag ID
*/
function show(divId)
{
    var id = document.getElementById(divId);
	id.style.display = 'inline';
    id.style.visibility = 'visible';

}

function fnshow(divId)
{   
    var id = document.getElementById(divId); 
	id.style.display = 'inline';
    id.style.visibility = 'visible';

}
function fntogger(divId)
{
    var id = document.getElementById(divId);
	if(id.style.display == 'none'){
	 id.style.display = 'inline';
     id.style.visibility = 'visible';
	}else{
     id.style.visibility = 'hidden';
     id.style.display = 'none';
	}
	

}

/*
* javascript function to display the div tag
* @param divId :: div tag ID
*/
function showBlock(divId)
{
	var tagName = document.getElementById(divId);
	if(typeof(tagName) == 'undefined') {
		return;
	}
	tagName.style.visibility = 'visible';
    tagName.style.display = 'block';
}


/*
* javascript function to hide the div tag
* @param divId :: div tag ID
*/
function hide(divId)
{

    var tagName = document.getElementById(divId);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    tagName.style.visibility = 'hidden';
    tagName.style.display = 'none';

}
function fnhide(divId)
{
	
    var tagName = document.getElementById(divId);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    tagName.style.visibility = 'hidden';
    tagName.style.display = 'none';
}

function fnLoadValues(obj1,obj2,SelTab,unSelTab,moduletype,module){
	
   var oform = document.forms['EditView'];
   oform.action.value='Save';	
   if((moduletype == 'inventory' && validateInventory(module)) ||(moduletype == 'normal') && formValidate())	
   if(formValidate())
   {	
	   var tabName1 = document.getElementById(obj1);

	   var tabName2 = document.getElementById(obj2);

	   var tagName1 = document.getElementById(SelTab);

	   var tagName2 = document.getElementById(unSelTab);

	   if(tabName1.className == "dvtUnSelectedCell")

		   tabName1.className = "dvtSelectedCell";

	   if(tabName2.className == "dvtSelectedCell")

		   tabName2.className = "dvtUnSelectedCell";   
	   tagName1.style.display='block';

	   tagName2.style.display='none';
   }
}

function fnCopy(source,design){

   document.getElementById(source).value=document.getElementById(design).value;

   document.getElementById(source).disabled=true;

}

function fnClear(source){

   document.getElementById(source).value=" ";

   document.getElementById(source).disabled=false;

}

function fnCpy(){

   var tagName=document.getElementById("cpy");

   if(tagName.checked==true){   
       fnCopy("shipaddress","address");

       fnCopy("shippobox","pobox");

       fnCopy("shipcity","city");

       fnCopy("shipcode","code");

       fnCopy("shipstate","state");

       fnCopy("shipcountry","country");

   }

   else{

       fnClear("shipaddress");

       fnClear("shippobox");

       fnClear("shipcity");

       fnClear("shipcode");

       fnClear("shipstate");

       fnClear("shipcountry");

   }

}
function fnDown(obj){
        var tagName = document.getElementById(obj);
        var tabName = document.getElementById("one");
        if(tagName.style.display == 'none'){
                tagName.style.display = 'block';
                tabName.style.display = 'block';
        }
        else{
                tabName.style.display = 'none';
                tagName.style.display = 'none';
        }
}

/*
* javascript function to add field rows
* @param option_values :: List of Field names
*/
var count = 0;
var rowCnt = 1;
function fnAddSrch(option_values,criteria_values){

    var tableName = document.getElementById('adSrc');

    var prev = tableName.rows.length;

    var count = prev;

    var row = tableName.insertRow(prev);

    if(count%2)

        row.className = "dvtCellLabel";

    else

        row.className = "dvtCellInfo";

    var colone = row.insertCell(0);

    var coltwo = row.insertCell(1);

    var colthree = row.insertCell(2);

    colone.innerHTML="<select id='Fields"+count+"' name='Fields"+count+"' class='detailedViewTextBox'>"+option_values+"</select>";

    coltwo.innerHTML="<select id='Condition"+count+"' name='Condition"+count+"' class='detailedViewTextBox'>"+criteria_values+"</select> ";

    colthree.innerHTML="<input type='text' id='Srch_value"+count+"' name='Srch_value"+count+"' class='detailedViewTextBox'>";

}

function totalnoofrows()
{
	var tableName = document.getElementById('adSrc');
	document.advSearch.search_cnt.value = tableName.rows.length;
}

/*
* javascript function to delete field rows in advance search
* @param void :: void
*/
function delRow()
{

    var tableName = document.getElementById('adSrc');

    var prev = tableName.rows.length;

    if(prev > 1)

    document.getElementById('adSrc').deleteRow(prev-1);

}

function fnVis(obj){

   var profTag = document.getElementById("prof");

   var moreTag = document.getElementById("more");

   var addrTag = document.getElementById("addr");

  
   if(obj == 'prof'){

       document.getElementById('mnuTab').style.display = 'block';

       document.getElementById('mnuTab1').style.display = 'none';

       document.getElementById('mnuTab2').style.display = 'none';

       profTag.className = 'dvtSelectedCell';

       moreTag.className = 'dvtUnSelectedCell';

       addrTag.className = 'dvtUnSelectedCell';

   }

  
   else if(obj == 'more'){

       document.getElementById('mnuTab1').style.display = 'block';

       document.getElementById('mnuTab').style.display = 'none';

       document.getElementById('mnuTab2').style.display = 'none';

       moreTag.className = 'dvtSelectedCell';

       profTag.className = 'dvtUnSelectedCell';

       addrTag.className = 'dvtUnSelectedCell';

   }

  
   else if(obj == 'addr'){

       document.getElementById('mnuTab2').style.display = 'block';

       document.getElementById('mnuTab').style.display = 'none';

       document.getElementById('mnuTab1').style.display = 'none';

       addrTag.className = 'dvtSelectedCell';

       profTag.className = 'dvtUnSelectedCell';

       moreTag.className = 'dvtUnSelectedCell';

   }

}

function fnvsh(obj,Lay){
    var tagName = document.getElementById(Lay);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    var leftSide = findPosX(obj);
    var topSide = findPosY(obj);
    tagName.style.left= leftSide + 175 + 'px';
    tagName.style.top= topSide + 'px';
    tagName.style.visibility = 'visible';
}

function fnvshobj(obj,Lay){ 
    var tagName = document.getElementById(Lay);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    var leftSide = findPosX(obj);
    var topSide = findPosY(obj);
	alert(tagName);
    var maxW = tagName.style.width; 
	
    var widthM = maxW.substring(0,maxW-2);
    var getVal = eval(leftSide) + eval(widthM);
    if(getVal  > document.body.clientWidth ){
        leftSide = eval(leftSide) - eval(widthM);
        tagName.css({"left":leftSide + 34 + 'px'});
    }
    else
    tagName.css({"left":leftSide + 'px'});
    tagName.css({"top":topSide + 'px'});
    tagName.css('display','block');
	//tagName.style.display="block";
	//tagName.style.visibility="visible";
    tagName.css('visibility','visible'); 
}

function posLay(obj,Lay){
    var tagName = document.getElementById(Lay);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    var leftSide = findPosX(obj);
    var topSide = findPosY(obj);
    var maxW = tagName.style.width;
    var widthM = maxW.substring(0,maxW.length-2);
    var getVal = eval(leftSide) + eval(widthM);
    if(getVal  > document.body.clientWidth ){
        leftSide = eval(leftSide) - eval(widthM);
        tagName.style.left = leftSide + 'px';
    }
    else
        tagName.style.left= leftSide + 'px';
    tagName.style.top= topSide + 'px';
}

function fninvsh(Lay){
    var tagName = document.getElementById(Lay);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    tagName.style.visibility = 'hidden';
    tagName.style.display = 'none';
}

function fnvshNrm(Lay){
    var tagName = document.getElementById(Lay);
	if(typeof(tagName) == 'undefined') {
		return;
	}
    tagName.style.visibility = 'visible';
    tagName.style.display = 'block';
}

function cancelForm(frm)
{
	    goback();
}

function trim(s)
{
	while (s.substring(0,1) == " " || s.substring(0,1) == "\n")
	{
		s = s.substring(1, s.length);
	}
	while (s.substring(s.length-1, s.length) == " " || s.substring(s.length-1,s.length) == "\n") {
		s = s.substring(0,s.length-1);
	}
	return s;
}

function clear_form(form)
{
	for (j = 0; j < form.elements.length; j++)
	{
		if (form.elements[j].type == 'text' || form.elements[j].type == 'select-one')
		{
			form.elements[j].value = '';
		}
	}
}

function ActivateCheckBox()
{
        var map = document.getElementById("saved_map_checkbox");
        var source = document.getElementById("saved_source");

        if(map.checked == true)
        {
                source.disabled = false;
        }
        else
        {
                source.disabled = true;
        }
}

//wipe for Convert Lead  

function fnSlide2(obj,inner)
{
  var buff = document.getElementById(obj).height;
  closeLimit = buff.substring(0,buff.length);
  menu_max = eval(closeLimit);
  var tagName = document.getElementById(inner);
  document.getElementById(obj).style.height=0 + "px";menu_i=0;
  if (tagName.style.display == 'none')
          fnexpanLay2(obj,inner);
  else
        fncloseLay2(obj,inner);
 }

function fnexpanLay2(obj,inner)
{
    // document.getElementById(obj).style.display = 'run-in';
   var setText = eval(closeLimit) - 1;
   if (menu_i<=eval(closeLimit))
   {
            if (menu_i>setText){document.getElementById(inner).style.display='block';}
       document.getElementById(obj).style.height=menu_i + "px";
           setTimeout(function() {fnexpanLay2(obj,inner);},5);
        menu_i=menu_i+5;
   }
}

 function fncloseLay2(obj,inner)
{
  if (menu_max >= eval(openLimit))
   {
            if (menu_max<eval(closeLimit)){document.getElementById(inner).style.display='none';}
       document.getElementById(obj).style.height=menu_max +"px";
          setTimeout(function() {fncloseLay2(obj,inner);}, 5);
       menu_max = menu_max -5;
   }
}

function addOnloadEvent(fnc){
  if ( typeof window.addEventListener != "undefined" )
    window.addEventListener( "load", fnc, false );
  else if ( typeof window.attachEvent != "undefined" ) {
    window.attachEvent( "onload", fnc );
  }
  else {
    if ( window.onload != null ) {
      var oldOnload = window.onload;
      window.onload = function ( e ) {
        oldOnload( e );
        window[fnc]();
      };
    }
    else
      window.onload = fnc;
  }
}
function InternalMailer(toemail) {
        var url;
        url = 'index.php?module=Webmails&action=newmsg&&folder=INBOX&nameto=&mailto='+toemail;
        var opts = "menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes";
        openPopUp('xComposeEmail',this,url,'createemailWin',830,662,opts);
}

function fnHide_Event(obj){
        document.getElementById(obj).style.visibility = 'hidden';
}

function OpenCompose(id,mode) 
{
	switch(mode)
	{		
		case 'edit':
			url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&record='+id;
			break;
		case 'create':
			url = 'index.php?module=Emails&action=EmailsAjax&file=EditView';
			break;
		case 'forward':
			url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&record='+id+'&forward=true';
			break;
		case 'reply':
			url = 'index.php?module=Emails&action=EmailsAjax&file=EditView&record='+id+'&reply=single';
			break;
	}
	openPopUp('xComposeEmail',this,url,'createemailWin',820,689,'menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes');
}

//Function added for Mass select in Popup - Philip
function SelectAll(mod,parmod)
{

	x = document.selectall.selected_id.length;
	var y=0;
	if(parmod != 'Calendar')
	{
			var module = window.opener.document.getElementById('return_module').value;
			if(module == "") {
				module = parmod;
			}
			var entity_id = window.opener.document.getElementById('parent_id').value;
	}
	idstring = "";
	namestr = "";

	if ( x == undefined)
	{

			if (document.selectall.selected_id.checked)
			{
				idstring = document.selectall.selected_id.value;
				if(parmod == 'Calendar')
						namestr = document.getElementById('calendarCont'+idstring).innerHTML;
				y=1;
			}
			else
			{
					alert(alert_arr.SELECT);
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
							idstring = document.selectall.selected_id[i].value +";"+idstring;
							if(parmod == 'Calendar')
							{
									idval = document.selectall.selected_id[i].value;
									namestr = document.getElementById('calendarCont'+idval).innerHTML+"\n"+namestr;
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
			alert(alert_arr.SELECT);
			return false;
	}
	//if(confirm("确认已选记录？"))
	//{
			if(parmod == 'Calendar')
			{
					window.opener.document.EditView.contactidlist.value = idstring;
					window.opener.document.EditView.contactlist.value = namestr;
			}
			else
			{
					opener.document.location.href="index.php?module="+module+"&parentid="+entity_id+"&action=updateRelations&destination_module="+mod+"&idlist="+idstring;
			}
			self.close();
	//}
	//else
	//{
	//		return false;
	//}
}
function ShowEmail(id)
{
       url = 'index.php?module=Emails&action=EmailsAjax&file=DetailView&record='+id;
       openPopUp('xComposeEmail',this,url,'createemailWin',820,695,'menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes');
}

var bSaf = (navigator.userAgent.indexOf('Safari') != -1);
var bOpera = (navigator.userAgent.indexOf('Opera') != -1);
var bMoz = (navigator.appName == 'Netscape');
function execJS(node) {
    var st = node.getElementsByTagName('SCRIPT');
    var strExec;
    for(var i=0;i<st.length; i++) {
      if (bSaf) {
        strExec = st[i].innerHTML;
      }
      else if (bOpera) {
        strExec = st[i].text;
      }
      else if (bMoz) {
        strExec = st[i].textContent;
      }
      else {
        strExec = st[i].text;
      }
      try {
        eval(strExec);
      } catch(e) {
        alert(e);
      }
    }
}

//Function added for getting the Tab Selected Values (Standard/Advanced Filters) for Custom View - Ahmed
function fnLoadCvValues(obj1,obj2,SelTab,unSelTab){

   var tabName1 = document.getElementById(obj1);

   var tabName2 = document.getElementById(obj2);

   var tagName1 = document.getElementById(SelTab);

   var tagName2 = document.getElementById(unSelTab);

   if(tabName1.className == "dvtUnSelectedCell")

       tabName1.className = "dvtSelectedCell";

   if(tabName2.className == "dvtSelectedCell")

       tabName2.className = "dvtUnSelectedCell";   
   tagName1.style.display='block';

   tagName2.style.display='none';

}


// Drop Dwon Menu


function fnDropDown(obj,Lay){
    var tagName = document.getElementById(Lay); 
	if(typeof tagName == 'undefined') {
		return;
	}
    var leftSide = findPosX(obj);
    var topSide = findPosY(obj);
    var maxW = tagName.style.width;
    var widthM = maxW.substring(0,maxW.length-2);
    var getVal = eval(leftSide) + eval(widthM);
    if(getVal  > document.body.clientWidth ){
        leftSide = eval(leftSide) - eval(widthM);
        tagName.style.left = leftSide + 34 + 'px';
    }
    else
        tagName.style.left= leftSide + 'px';
		
    tagName.style.top= topSide + 15 +'px';
    tagName.style.display = 'block';
 }

function fnShowDrop(obj){
	document.getElementById(obj).style.display = 'block';
}

function fnHideDrop(obj){
	document.getElementById(obj).style.display = 'none';
}

function getCalendarPopup(imageid,fieldid,dateformat)
{
        Calendar.setup ({
                inputField : fieldid, ifFormat : dateformat, showsTime : false, button : imageid, singleClick : true, step : 1
        });
}

function openContactPopup() 
{
	var flag = false;
	var url = "index.php?module=Contacts&action=Popup&html=Popup_picker&popuptype=specific&form=EditView";
	for(var i=0;i<document.EditView.elements.length;i++) {
		if(document.EditView.elements[i].name == "account_id") {
			flag = true;
		}
	}
	if(flag) 
	{
		if(document.EditView.account_id.value == '') 
		{
			alert(alert_arr.ACCOUNT_CANNOT_EMPTY);
			return false;
		}
		url = url + "&account_id=" + document.EditView.account_id.value;
	}
	return window.open(url,"test","width=640,height=602,resizable=1,scrollbars=1");
}
function openSOPopup() 
{
	var flag = false;
	var url = "index.php?module=SalesOrder&action=Popup&html=Popup_picker&popuptype=specific&form=EditView";
	for(var i=0;i<document.EditView.elements.length;i++) {
		if(document.EditView.elements[i].name == "account_id") {
			flag = true;
		}
	}
	if(flag) 
	{
		if(document.EditView.account_id.value == '') 
		{
			alert(alert_arr.ACCOUNT_CANNOT_EMPTY);
			return false;
		}
		url = url + "&account_id=" + document.EditView.account_id.value;
	}
	return window.open(url,"test","width=640,height=602,resizable=1,scrollbars=1");
}
function openInvoicePopup() 
{
	var flag = false;
	var url = "index.php?module=Invoice&action=Popup&html=Popup_picker&popuptype=specific&form=EditView";
	for(var i=0;i<document.EditView.elements.length;i++) {
		if(document.EditView.elements[i].name == "account_id") {
			flag = true;
		}
	}
	if(flag) 
	{
		if(document.EditView.account_id.value == '') 
		{
			alert(alert_arr.ACCOUNT_CANNOT_EMPTY);
			return false;
		}
		url = url + "&account_id=" + document.EditView.account_id.value;
	}
	return window.open(url,"test","width=640,height=602,resizable=1,scrollbars=1");
}
function openCalendarContactPopup() 
{
	var flag = false;
	var url = "index.php?module=Contacts&action=Popup&return_module=Calendar&popuptype=detailview&form=EditView&form_submit=false";
	for(var i=0;i<document.EditView.elements.length;i++) {
		if(document.EditView.elements[i].name == "parent_id" && document.EditView.parent_type.value == "Accounts") {
			flag = true;
		}
	}
	if(flag) 
	{
		if(document.EditView.parent_id.value == '') 
		{
			alert(alert_arr.ACCOUNT_CANNOT_EMPTY);
			return false;
		}
		url = url + "&account_id=" + document.EditView.parent_id.value;
	}
	return window.open(url,"test","width=640,height=602,resizable=1,scrollbars=1");
}

function openPotentialPopup() 
{
	var flag = false;
	var url = "index.php?module=Potentials&action=Popup&html=Popup_picker&popuptype=specific_potential_account_address&form=EditView";
	/*
	for(var i=0;i<document.EditView.elements.length;i++) {
		if(document.EditView.elements[i].name == "account_id") {
			flag = true;
		}
	}
	if(flag) 
	{
		if(document.EditView.account_id.value == '') 
		{
			alert(alert_arr.ACCOUNT_CANNOT_EMPTY);
			return false;
		}
		url = url + "&account_id=" + document.EditView.account_id.value;
	}
	*/
	return window.open(url,"test","width=640,height=602,resizable=1,scrollbars=1");
}

function fnshowHide(currObj,txtObj)
{
	if(currObj.checked == true)
		document.getElementById(txtObj).style.visibility = 'visible';
	else
		document.getElementById(txtObj).style.visibility = 'hidden';
}
	

function delimage(id)
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Contacts&action=ContactsAjax&file=DelImage&recordid='+id,
			onComplete: function(response)
				    {
					if(response.responseText.indexOf("SUCESS")>-1)
						$("replaceimage").innerHTML= alert_arr.IMAGE_DELETED;
					else
						alert(alert_arr.IMAGE_DELETED);
				    }
		}
	);

}
function approved(form)
{	    
	    var status = "";
	    for(var i=0;i<form.elements.length;i++) {
			if(form.elements[i].name == "approvestatus" && form.elements[i].checked == true) {
				status = form.elements[i].value;
				break;
			}
		}
		var record = form.record.value;
                var rejectdescel= form.rejected_reason;
		var rejectdesc = null;
                if(rejectdescel) rejectdesc = rejectdescel.value;
                var approveel=form.approveid;
                var approveidvalue="";
                if(approveel) approveidvalue=approveel.value;

                var stepel=form.stepid;
                var stepidvalue="";
                if(stepel) stepidvalue=stepel.value;
                
                var nextuserel=form.nextuserid;
                if(nextuserel) var nextuserid=nextuserel.value;
                if(status==3||(status==-1&&$('userselected_div'))){
                    if($('userselected_div').style.display!='none'){
                        chooseNextStepUser(document.forms['userchoose_form']);
                    } 
                    if(nextuserel) nextuserid=nextuserel.value;
                    if($F('userselected_hidden')==1&&nextuserid==''){
                        alert('没有选择下一步的审批人');
                        return false;
                    }
                }

		if (rejectdesc != null && rejectdesc != "")
		{
			//rejectdesc = alert_arr.REJECT_DESC + ":" + rejectdesc;
		} else {
			rejectdesc = "";
		}
                var otherparms="";
                if(status==3){
                   var nextstepid=form.nextstep.value;
                   otherparms="&nextstep="+nextstepid;
                }
                $("status").style.display="inline";
			new Ajax.Request(
                          'index.php',
                            {queue: {position: 'end', scope: 'command'},
                            method: 'post',
                            postBody:"module=Users&&action=UsersAjax&file=Approve&ajax=true&status="+status+"&description="+ rejectdesc + "&record="+record+"&approveid="+approveidvalue+"&stepid="+stepidvalue+"&nextstepuserid="+nextuserid+otherparms,
                        onComplete: function(response) {
                                result = response.responseText;
                                if(result == 'SUCCESS') {
                                            $("status").style.display="none";
                                            hide('approveLay');
                                             var userselectdiv=$('userselected_div');
                                             if(userselectdiv)  userselectdiv.style.display='none';
                                            alert(alert_arr.APPROVED);
                                            window.location.reload();
                                    } else if(result == 'ALREADY_APPROVED') {
                                            $("status").style.display="none";
                                            hide('approveLay');
                                            alert(alert_arr.ALREADY_APPROVED);
                                            //window.location.reload();
                                    } else if(result == 'APPROVE_FAILED') {
                                            $("status").style.display="none";
                                            hide('approveLay');
                                            alert(alert_arr.APPROVE_FAILED);
                                            window.location.reload();
                                    }
            }
     }
);

//		if(status == "1")
//		{
//
//			$("status").style.display="inline";
//			new Ajax.Request(
//          	  	      'index.php',
//			      	{queue: {position: 'end', scope: 'command'},
//		                        method: 'post',
//                		        postBody:"module=Users&&action=UsersAjax&file=Approve&ajax=true&status=1&description="+ rejectdesc + "&record="+record,
//		                        onComplete: function(response) {
//				                        result = response.responseText;
//	                        	        if(result == 'SUCCESS') {
//											$("status").style.display="none";
//											hide('approveLay');
//											alert(alert_arr.APPROVED);
//											window.location.reload();
//										} else if(result == 'ALREADY_APPROVED') {
//											$("status").style.display="none";
//											hide('approveLay');
//											alert(alert_arr.ALREADY_APPROVED);
//											//window.location.reload();
//										} else if(result == 'APPROVE_FAILED') {
//											$("status").style.display="none";
//											hide('approveLay');
//											alert(alert_arr.APPROVE_FAILED);
//											window.location.reload();
//										}
//		                        }
//              			 }
//       			);
//		}
//		else
//		{
//			$("status").style.display="inline";
//			new Ajax.Request(
//          	  	      'index.php',
//			      	{queue: {position: 'end', scope: 'command'},
//		                        method: 'post',
//                		        postBody:"module=Users&action=UsersAjax&file=Approve&ajax=true&status=-1&description="+ rejectdesc + "&record="+record,
//		                        onComplete: function(response) {
//				                        result = response.responseText;
//	                        	        if(result == 'SUCCESS') {
//											$("status").style.display="none";
//											hide('approveLay');
//											alert(alert_arr.APPROVED);
//											window.location.reload();
//										} else if(result == 'ALREADY_APPROVED') {
//											$("status").style.display="none";
//											hide('approveLay');
//											alert(alert_arr.ALREADY_APPROVED);
//											//window.location.reload();
//										} else if(result == 'APPROVE_FAILED') {
//											$("status").style.display="none";
//											hide('approveLay');
//											alert(alert_arr.APPROVE_FAILED);
//											window.location.reload();
//										}
//		                        }
//              			 }
//       		);
//		}

}


function callCreateApproveDiv(id)
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Users&action=UsersAjax&file=CreateApprove&record='+id,
			onComplete: function(response) {
				$("createapprove_div").innerHTML=response.responseText;
				eval($("approvejs").innerHTML);
				Drag.init(document.getElementById("approve_div_title"), document.getElementById("approveLay"));
			}
		}
	);
}
function toggleApproveType(currType)
{
        if (currType=="1")
        {
                getObj("approved_span").style.display="block"
                getObj("rejected_span").style.display="none"
        }
        else
        {
                getObj("approved_span").style.display="none"
                getObj("rejected_span").style.display="block"
        }
}

function check_approved_ajax()
{
	var record = window.document.EditView.record.value;
	new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: 'module=Users&&action=UsersAjax&file=CheckApproved&ajax=true&record='+record,
                        onComplete: function(response) {
							if(response.responseText == 'SUCCESS') {
								    //flag = true;
									document.EditView.submit();									
							}									
							else {
								    //flag = false;
									alert(response.responseText);
							}
						}
                }
        );
}

/******************************************************************************/
/* Activity reminder Customization: Setup Callback */
function ActivityReminderProgressIndicator(show) {
	if(show) $("status").style.display = "inline";
	else $("status").style.display = "none";
}

function ActivityReminderSetupCallback(cbmodule, cbrecord) { 
	if(cbmodule && cbrecord) {

		ActivityReminderProgressIndicator(true);
		new Ajax.Request(
    		'index.php',
	        {queue: {position: 'end', scope: 'command'},
        		method: 'post',
                postBody:"module=Calendar&action=CalendarAjax&ajax=true&file=ActivityReminderSetupCallbackAjax&cbmodule="+ 
					encodeURIComponent(cbmodule) + "&cbrecord=" + encodeURIComponent(cbrecord),
                onComplete: function(response) {
                $("ActivityReminder_callbacksetupdiv").innerHTML=response.responseText;
				
				ActivityReminderProgressIndicator(false);

                }});
	}
}

function ActivityReminderSetupCallbackSave(form) {
	var cbmodule = form.cbmodule.value;   
	var cbrecord = form.cbrecord.value;
	var cbaction = form.cbaction.value;

	var cbdate   = form.cbdate.value;
	var cbtime   = form.cbhour.value + ":" + form.cbmin.value;

	if(cbmodule && cbrecord) {
		ActivityReminderProgressIndicator(true);

		new Ajax.Request("index.php", 
			{queue:{position:"end", scope:"command"}, method:"post", 
				postBody:"module=Calendar&action=CalendarAjax&ajax=true&file=ActivityReminderSetupCallbackAjax" + 
				"&cbaction=" + encodeURIComponent(cbaction) +
				"&cbmodule="+ encodeURIComponent(cbmodule) + 
				"&cbrecord=" + encodeURIComponent(cbrecord) + 
				"&cbdate=" + encodeURIComponent(cbdate) + 
				"&cbtime=" + encodeURIComponent(cbtime),
				onComplete:function (response) {ActivityReminderSetupCallbackSaveProcess(response.responseText);}}); 
	}
}
function ActivityReminderSetupCallbackSaveProcess(message) {
	ActivityReminderProgressIndicator(false);
	$('ActivityReminder_callbacksetupdiv_lay').style.display='none';
}

function ActivityReminderPostponeCallback(cbmodule, cbrecord) { 
	if(cbmodule && cbrecord) {

		ActivityReminderProgressIndicator(true);
		new Ajax.Request("index.php", 
			{queue:{position:"end", scope:"command"}, method:"post", 
				postBody:"module=Calendar&action=CalendarAjax&ajax=true&file=ActivityReminderSetupCallbackAjax&cbaction=POSTPONE&cbmodule="+ 
				encodeURIComponent(cbmodule) + "&cbrecord=" + encodeURIComponent(cbrecord), 
				onComplete:function (response) {ActivityReminderPostponeCallbackProcess(response.responseText);}}); 
	}
}
function ActivityReminderPostponeCallbackProcess(message) {
	ActivityReminderProgressIndicator(false);
}
/* END */

/* ActivityReminder Customization: Pool Callback */
var ActivityReminder_regcallback_timer;

var ActivityReminder_callback_delay = 40 * 1000; // Milli Seconds
var ActivityReminder_autohide = false; // If the popup should auto hide after callback_delay?

var ActivityReminder_popup_maxheight = 75;

var ActivityReminder_callback;
var ActivityReminder_timer;
var ActivityReminder_progressive_height = 2; // px
var ActivityReminder_popup_onscreen = 2 * 1000; // Milli Seconds (should be less than ActivityReminder_callback_delay)

var ActivityReminder_callback_win_uniqueids = new Object();

var firstgettitle=true;
var origintitle="";
var falsh_pe=null;
function flash_title()  
{ 
    //当窗口效果为最小化，或者没焦点状态下才闪动
    if(isMinStatus() || !window.focus)
    {
        newMsgCount();
    }
    else
    {
        document.title=origintitle;//窗口没有消息的时候默认的title内容
        if(falsh_pe) falsh_pe.stop();
        falsh_pe=null;
    }
} 
//消息提示
var flag=false;
function newMsgCount(){
    if(flag){
        flag=false;
        document.title='您有新的短消息';
    }else{
        flag=true;
        document.title=origintitle;
    }
    if(!falsh_pe){
        falsh_pe=new PeriodicalExecuter(flash_title, 1);
    }
}
//判断窗口是否最小化
//在Opera中还不能显示
var isMin = false;
function isMinStatus() {
    //除了Internet Explorer浏览器，其他主流浏览器均支持Window outerHeight 和outerWidth 属性
    if(window.outerWidth != undefined && window.outerHeight != undefined){
        isMin = window.outerWidth <= 160 && window.outerHeight <= 27;
    }else{
        isMin = window.outerWidth <= 160 && window.outerHeight <= 27;
    }
    //除了Internet Explorer浏览器，其他主流浏览器均支持Window screenY 和screenX 属性
    if(window.screenY != undefined && window.screenX != undefined ){
        isMin = window.screenY < -30000 && window.screenX < -30000;//FF Chrome             
    }else{
        isMin = window.screenTop < -30000 && window.screenLeft < -30000;//IE
    }
    return isMin;
}

function ActivityReminderCallback() { 
	if(ActivityReminder_regcallback_timer) {
		window.clearTimeout(ActivityReminder_regcallback_timer);
		ActivityReminder_regcallback_timer = null;
	}
	new Ajax.Request("index.php", 
			{queue:{position:"end", scope:"command"}, method:"post", 
			postBody:"module=Home&action=HomeAjax&file=ActivityReminderCallbackAjax&ajax=true", 
			onComplete:function (response) {
		          ActivityReminderCallbackProcess(response.responseText);
    }}); 
}
function ActivityReminderCallbackProcess(message) {
	ActivityReminder_callback = document.getElementById("ActivityRemindercallback");
	//clear old reminder window
	//alert(ActivityReminder_callback.innerHTML);
	//if(ActivityReminder_callback.innerHTML != "") {
		ActivityReminder_callback.innerHTML = "";
	//}
	if(ActivityReminder_callback == null) return;
	if(firstgettitle){
       origintitle=document.title;
       firstgettitle=false;
    } 
    if(message.include('div')) flash_title();
//    document.title="你有新消息";
//    alert("你有新消息");
//    document.title=orititle;
	var winuniqueid = 'ActivityReminder_callback_win_' + (new Date()).getTime();
	if(ActivityReminder_callback_win_uniqueids[winuniqueid]) {
		winuniqueid += "-" + (new Date()).getTime();
	}
	ActivityReminder_callback_win_uniqueids[winuniqueid] = true;

	var ActivityReminder_callback_win = document.createElement("span");
	ActivityReminder_callback_win.id  = winuniqueid;
	ActivityReminder_callback.appendChild(ActivityReminder_callback_win);
	
	ActivityReminder_callback_win.innerHTML = message; 
	ActivityReminder_callback_win.style.height = "0px"; 
	ActivityReminder_callback_win.style.display = ""; 
	if(message != "") ActivityReminderCallbackRollout(ActivityReminder_popup_maxheight, ActivityReminder_callback_win); 
	else {ActivityReminderCallbackReset(0, ActivityReminder_callback_win);}
}
function ActivityReminderCallbackRollout(z, ActivityReminder_callback_win) {
	ActivityReminder_callback_win = $(ActivityReminder_callback_win);

	if (ActivityReminder_timer) {window.clearTimeout(ActivityReminder_timer);} 
	if (parseInt(ActivityReminder_callback_win.style.height) < z) { 
		ActivityReminder_callback_win.style.height = parseInt(ActivityReminder_callback_win.style.height) + ActivityReminder_progressive_height + "px"; 
		ActivityReminder_timer = setTimeout("ActivityReminderCallbackRollout(" + z + ",'" + ActivityReminder_callback_win.id + "')", 1); 
	} else { 
		ActivityReminder_callback_win.style.height = z + "px"; 
		if(ActivityReminder_autohide) ActivityReminder_timer = setTimeout("ActivityReminderCallbackRollin(1,'" + ActivityReminder_callback_win.id + "')", ActivityReminder_popup_onscreen);
		else ActivityReminderRegisterCallback(ActivityReminder_callback_delay);
	} 
}
function ActivityReminderCallbackRollin(z, ActivityReminder_callback_win) {
	ActivityReminder_callback_win = $(ActivityReminder_callback_win);

	if (ActivityReminder_timer) {window.clearTimeout(ActivityReminder_timer);} 
	if (parseInt(ActivityReminder_callback_win.style.height) > z) { 
		ActivityReminder_callback_win.style.height = parseInt(ActivityReminder_callback_win.style.height) - ActivityReminder_progressive_height + "px"; 
		ActivityReminder_timer = setTimeout("ActivityReminderCallbackRollin(" + z + ",'" + ActivityReminder_callback_win.id + "')", 1); 
	} else { 
		ActivityReminderCallbackReset(z, ActivityReminder_callback_win);
	} 
}
function ActivityReminderCallbackReset(z, ActivityReminder_callback_win) {
	ActivityReminder_callback_win = $(ActivityReminder_callback_win);

	if(ActivityReminder_callback_win) {
		ActivityReminder_callback_win.style.height = z + "px"; 
		ActivityReminder_callback_win.style.display = "none";
	} 
	if(ActivityReminder_timer) {
		window.clearTimeout(ActivityReminder_timer);
		ActivityReminder_timer = null;
	}
	ActivityReminderRegisterCallback(ActivityReminder_callback_delay);
}
function ActivityReminderRegisterCallback(timeout) {
	if(timeout == null) timeout = 1;
	if(ActivityReminder_regcallback_timer == null) {
		ActivityReminder_regcallback_timer = setTimeout("ActivityReminderCallback()", timeout);
	}
}

function confirmdelete(url)
{
		if(confirm(alert_arr.SURE_TO_DELETE))
		{	
				window.location.href=url;
		}
}

function selectAllDel(state,checkedName)
{
		var selectedOptions=document.getElementsByName(checkedName);
		var length=document.getElementsByName(checkedName).length;
		if(typeof(length) == 'undefined')
		{
			return false;
		}	
		for(var i=0;i<length;i++)
		{
			selectedOptions[i].checked=state;
		}	
}

function selectDel(ThisName,CheckAllName)
	{
		var ThisNameOptions=document.getElementsByName(ThisName);
		var CheckAllNameOptions=document.getElementsByName(CheckAllName);
		var len1=document.getElementsByName(ThisName).length;
		var flag = true;
		if (typeof(document.getElementsByName(ThisName).length)=="undefined")
	       	{
			flag=true;
		}
	       	else 
		{
			for (var j=0;j<len1;j++) 
			{
				if (ThisNameOptions[j].checked==false)
		       		{
					flag=false
					break;
				}
			}
		}
		CheckAllNameOptions[0].checked=flag
}

// Added for page navigation in duplicate-listview
var dup_start = "";
function getDuplicateListViewEntries_js(module,url)
{
	dup_start = url;
	$("status").style.display="block";
	new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody:"module="+module+"&action="+module+"Ajax&file=FindDuplicate"+module+"&ajax=true&"+dup_start,
				onComplete: function(response) {
					$("status").style.display="none";
					$("duplicate_ajax").innerHTML = response.responseText;
				}
			}
	);
}

function merge_fields(selectedNames,module,parent_tab)
{
			
		var select_options=document.getElementsByName(selectedNames);
		var x= select_options.length;
		var req_module=module;
		var num_group=$("group_count").innerHTML;
		var pass_url="";
		var flag=0;
		//var i=0;		
		var xx = 0;
		for(i = 0; i < x ; i++)
		{
			if(select_options[i].checked)
			{
				pass_url = pass_url+select_options[i].value +","
				xx++
			}
		}
		var tmp = 0
		if ( xx != 0)
		{
			
			if(xx > 3)
			{
				alert(alert_arr.MAX_THREE)
					return false;
			}
			if(xx > 0)
			{
				for(j=0;j<num_group;j++)
				{
					flag = 0
					var group_options=document.getElementsByName("group"+j);
					for(i = 0; i < group_options.length ; i++)
						{
							if(group_options[i].checked)
							{
								flag++
							}
						}
					if(flag > 0)
					tmp++;
				}
				if (tmp > 1)
				{
				alert(alert_arr.SAME_GROUPS)
				return false;
				}
				if(xx <2)
				{
					alert(alert_arr.ATLEAST_TWO)
					return false;
				}
				
			}			
					
			window.open("index.php?module="+req_module+"&action=PopupMergeField"+req_module+"&passurl="+pass_url+"&parenttab="+parent_tab,"Merge","width=750,height=602,menubar=no,toolbar=no,location=no,status=no,resizable=no,scrollbars=yes");	
		}
		else
		{
			alert(alert_arr.ATLEAST_TWO);			
			return false;
		}		
}

function validate_merge(module)
{
	var check_var=false;
	var check_lead1=false;
	var check_lead2=false;	
	
	var select_parent=document.getElementsByName('record');
	var len = select_parent.length;
	for(var i=0;i<len;i++)
	{
		if(select_parent[i].checked)
		{
			var check_parentvar=true;
		}
	}
	if (check_parentvar!=true)
	{
		alert('Select one record as parent record');
		return false;
	}
	if(module == 'Accounts')
	{
		var select_options=document.getElementsByName('accountname');
		var len=select_options.length;
		for(var i=0;i<len;i++)
		{	
			
			if(select_options[i].checked)
			{
				var check_var=true;
			}
		}
		alert_str=alert_arr.ACC_MANDATORY;
	}	
		
	
	
	
	if (check_var == false &&  module!= 'Leads')
	{
		alert (alert_str);
		return false;
	}
	else if((check_lead1 == false || check_lead2 == false) && module == 'Leads')
	{
		alert (alert_str);
		return false;
	}
}

function delete_fields(module)
{
	var select_options=document.getElementsByName('del');
	var x=select_options.length;
	var xx=0;
	url_rec="";
	
	for(var i=0;i<x;i++)
	{
		if(select_options[i].checked)
		{
		url_rec=url_rec+select_options[i].value +","
		xx++
		}	
	}			
	if($("current_action"))
		cur_action = $("current_action").innerHTML		
	if (xx == 0)
	{
		alert(alert_arr.SELECT);
		return false;
	} 
    //var alert_str = alert_arr.DELETE + xx +alert_arr.RECORDS;
	//if(module=="Accounts")
	//var  alert_str = alert_arr.SURE_TO_DELETE + xx +alert_arr.RECORDS;
	var  alert_str = alert_arr.SURE_TO_DELETE;
	if(confirm(alert_str))
	{
		$("status").style.display="inline";
		new Ajax.Request(
				  'index.php',
				{queue: {position: 'end', scope: 'command'},
							method: 'post',
							postBody:"module="+module+"&action="+module+"Ajax&file=FindDuplicate"+module+"&del_rec=true&ajax=true&return_module="+module+"&idlist="+url_rec+"&current_action="+cur_action+"&"+dup_start,
							onComplete: function(response) {
									$("status").style.display="none";
									$("duplicate_ajax").innerHTML= response.responseText;
					}
					 }
			);
	}
	else
		return false;	
}

//export start
function selectedRecords(module,category)
{
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
	if(idstring != '')
			window.location.href="index.php?module="+module+"&action=ExportRecords&parenttab="+category+"&idstring="+idstring;
	else
			window.location.href="index.php?module="+module+"&action=ExportRecords&parenttab="+category;
	return false;
}

function record_export(module,category,exform,idstring)
{
	var searchType = document.getElementsByName('search_type');
	var exportData = document.getElementsByName('export_data');
	for(i=0;i<2;i++){
		if(searchType[i].checked == true)
			var sel_type = searchType[i].value;
	}
	for(i=0;i<3;i++){
		if(exportData[i].checked == true)
			var exp_type = exportData[i].value;
	}

	$.ajax({
			type:"GET",
            url: "index.php?module="+module+"&action=ExportAjax&export_record=true&search_type="+sel_type+"&export_data="+exp_type+"&idstring="+idstring,
            success: function(msg) {
						if( msg == 'NOT_SEARCH_WITHSEARCH_ALL'){
							$('#not_search').css("display","block");
							$('#not_search').html("<font color='red'><b>"+alert_arr.LBL_NOTSEARCH_WITHSEARCH_ALL+" "+module+"</b></font>");
							setTimeout(hideErrorMsg1,6000);
							exform.submit();
						}else if(msg == 'NOT_SEARCH_WITHSEARCH_CURRENTPAGE'){
							$('#not_search').css("display","block");
							$('#not_search').html("<font color='red'><b>"+alert_arr.LBL_NOTSEARCH_WITHSEARCH_CURRENTPAGE+" "+module+"</b></font>");
							setTimeout(hideErrorMsg1,7000);

							exform.submit();
						}else if(msg == 'NO_DATA_SELECTED'){
							$('#not_search').css("display","block");	
							$('not_search').html("<font color='red'><b>"+alert_arr.LBL_NO_DATA_SELECTED+"</b></font>");
							setTimeout(hideErrorMsg1,3000);
						}else if(msg== 'SEARCH_WITHOUTSEARCH_ALL'){
							if(confirm(alert_arr.LBL_SEARCH_WITHOUTSEARCH_ALL)){
								exform.submit();
							}					
						}else if(msg == 'SEARCH_WITHOUTSEARCH_CURRENTPAGE'){
							if(confirm(alert_arr.LBL_SEARCH_WITHOUTSEARCH_CURRENTPAGE)){
                                 exform.submit();
							}
						}else{
                          exform.submit(); 
						}
                 }
			}
        );

}


function hideErrorMsg1()
{
        $('not_search').style.display = 'none';
}

function callAntiCreateApproveDiv(id)
{
	var  alert_str = alert_arr.SURE_TO_ANTI_APPROVE;
	if(confirm(alert_str)) {
		var url = 'index.php?module=Users&action=AntiApprove&record='+id;
		document.location.href=url;
	}
}

function callCancelCreateApproveDiv(id)
{
	var  alert_str = alert_arr.SURE_TO_CANCEL_APPROVE;
	if(confirm(alert_str)) {
		var url = 'index.php?module=Users&action=CancelApprove&record='+id;
		document.location.href=url;
	}
}

function checkNewEmail(url) 
{
		$("status").style.display="inline";
		new Ajax.Request(
				  'index.php',
				{queue: {position: 'end', scope: 'command'},
							method: 'post',
							postBody:url,
							onComplete: function(response) {
									$("status").style.display="none";
									alert(response.responseText);
									//window.location.reload();
					}
					 }
		);
}

function openVContactPopup() 
{
	var flag = false;
	var url = "index.php?module=Vcontacts&action=Popup&popuptype=specific";
	for(var i=0;i<document.EditView.elements.length;i++) {
		if(document.EditView.elements[i].name == "vendor_id") {
			flag = true;
		}
	}
	if(flag) 
	{
		if(document.EditView.vendor_id.value == '') 
		{
			alert(alert_arr.VENDOR_CANNOT_EMPTY);
			return false;
		}
		url = url + "&vendor_id=" + document.EditView.vendor_id.value;
	}
	return window.open(url,"test","width=640,height=602,resizable=1,scrollbars=1");
}

function openUITenPopup(module) 
{
	var flag = false;
	var url = "index.php?module="+ module +"&action=Popup&popuptype=specific";
	if(module == "Agentcontacts") {
		for(var i=0;i<document.EditView.elements.length;i++) {
			if(document.EditView.elements[i].name == "agentsid") {
				flag = true;
			}
		}
		if(flag) 
		{
			if(document.EditView.agentsid.value == '') 
			{
				alert(alert_arr.AGENT_CANNOT_EMPTY);
				return false;
			}
			url = url + "&agentsid=" + document.EditView.agentsid.value;
		}
	}
	return window.open(url,"test","width=700,height=602,resizable=1,scrollbars=1");
}

function convertDateValToDateObject(dateval) {
	var dateelements = splitDateVal(dateval);	
	dd = dateelements[0];
	mm = dateelements[1];
	yyyy = dateelements[2];
	var chkdate = new Date(yyyy,mm-1,dd);
	//chkdate.setYear(yyyy);
	//chkdate.setDate(dd);
	//chkdate.setMonth(mm-1);
	return chkdate;
}

Date.prototype.dateAdd = function(interval,number)
{
	var d = this;
	var k={'y':'FullYear', 'q':'Month', 'm':'Month', 'w':'Date', 'd':'Date', 'h':'Hours', 'n':'Minutes', 's':'Seconds', 'ms':'MilliSeconds'};
	var n={'q':3, 'w':7};
	eval('d.set'+k[interval]+'(d.get'+k[interval]+'()+'+((n[interval]||1)*number)+')');
	return d;
}
Date.prototype.dateDiff = function(interval,objDate2)
{
	var d=this, i={}, t=d.getTime(), t2=objDate2.getTime();
	i['y']=objDate2.getFullYear()-d.getFullYear();
	i['q']=i['y']*4+Math.floor(objDate2.getMonth()/4)-Math.floor(d.getMonth()/4);
	i['m']=i['y']*12+objDate2.getMonth()-d.getMonth();
	i['ms']=objDate2.getTime()-d.getTime();
	i['w']=Math.floor((t2+345600000)/(604800000))-Math.floor((t+345600000)/(604800000));
	i['d']=Math.floor(t2/86400000)-Math.floor(t/86400000);
	i['h']=Math.floor(t2/3600000)-Math.floor(t/3600000);
	i['n']=Math.floor(t2/60000)-Math.floor(t/60000);
	i['s']=Math.floor(t2/1000)-Math.floor(t/1000);
	return i[interval];
} 
function showApproveHistory(){
        Position.absolutize($("approveLay"));
//        fnvshobj($("reminder"),'reminderLay');
//        $("reminderLay").setStyle({zIndex:50});
        new Draggable("createapprovehistory_div");
        Position.clone($("approveLay"), 'createapprovehistory_div', {setHeight:false,setWidth:false,offsetLeft:401,offsetTop:0});
        $('createapprovehistory_div').toggle();
}

function showApproveSteps(){
        Position.absolutize($("approveLay"));
//        fnvshobj($("reminder"),'reminderLay');
//        $("reminderLay").setStyle({zIndex:50});
        new Draggable("createapprovestep_div");
        Position.clone($("approveLay"), 'createapprovestep_div', {setHeight:false,setWidth:false,offsetLeft:401,offsetTop:0});
        $('createapprovestep_div').toggle();
}

function callCreateProductDiv()
{
	new Ajax.Request(
		'index.php',
		{queue: {position: 'end', scope: 'command'},
			method: 'post',
			postBody: 'module=Products&action=ProductsAjax&file=CreateProduct',
			onComplete: function(response) {
				$("createproduct_div").innerHTML=response.responseText;
				//eval($("productjs").innerHTML);
				Drag.init(document.getElementById("product_div_title"), document.getElementById("productLay"));
				
			}
		}
	);
}

function created(form)
{	    
			
		
			var productname = form.productname.value;
			var productcode = form.productcode.value;
			var price = form.price.value;
			if (productname == "")
			{
				alert("商品名称不能为空");
				form.productname.focus();
				return false;
			}
			if (productcode == "")
			{
				alert(alert_arr.PRODUCTCODE_IS_NULL);
				form.productcode.focus();
				return false;
			}
			if (price != "")
			{
				if (!numValidate("price","价格","any")) return false;
			}
			
			
			$("status").style.display="inline";
			new Ajax.Request(
          	  	      'index.php',
			      	{queue: {position: 'end', scope: 'command'},
		                        method: 'post',
                		        postBody:"module=Products&action=ProductsAjax&file=SaveProduct&ajax=true&productname="+ productname + "&price=" + price+"&productcode=" + productcode,
		                        onComplete: function(response) {
				                        result = response.responseText;
	                        	        if(result == 'REPEAT') {
											$("status").style.display="none";											
											alert(alert_arr.PRODUCTCODE_EXISTS);											
										} else {
											$("status").style.display="none";
											hide('productLay');
											//window.opener.document.EditView.account_name.value=accountname;
											//window.opener.document.EditView.account_id.value=result;
											window.location.reload();
											//window.close();
										}
		                        }
              			 }
       		);

}

//add for multifields
function getSelectFieldId(el)
{
	
    var element=el;

    var index = element.selectedIndex;
    if(index >= 0){
        var optel=element.options[index];
        var id=optel.getAttribute("relvalue");
        if(id=='') id=null;
        return id;
    }else{
        return null;
    }
}

function multifieldSelectChange(uitype,multifieldid,module,element)
{
    var level=0;
    if(uitype=='1021') level=1;
    else if(uitype=='1022') level=2;
    else if(uitype=='1023') level=3;
    var valueid=getSelectFieldId(element);
    if(valueid==null) return;
    $("#status").css("display","inline");
		$.ajax({
			type:"get",
			url:"index.php?module="+module+"&action="+module+"Ajax&file=UpdateMultiFields&multifieldid="+ multifieldid + "&level=" + level+"&parentfieldid=" + valueid,
			success:function(msg){
				$("#status").css("display","none");
				eval(msg);
			}
		});
}

function showhide_dept_userselect(deptId,imgId)
{
	var x=document.getElementById(deptId).style;
	if (x.display=="none")
	{
		x.display="block";
		document.getElementById(imgId).src = "themes/softed/images/minus.gif";
	}
	else
	{
		x.display="none";
		document.getElementById(imgId).src = "themes/softed/images/plus.gif";
	}
}


function getTableViewForFenzu(setype,url,theelement,viewname){

	$('viewname').value = viewname;
	var classmethods=$('#tablink ul');
	var classnum = classmethods.children('li').length;
	for(var i=1;i<classnum;i++){ 
	   classmethods.children('li:eq('+i+')').removeClass('active');
	}
	$(theelement).parent().addClass('active');

	getAccountInfoToSend(setype,viewname);
}
function getAccountInfoToSend(setype,viewname){	

	$("#status").css("display","inline");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module="+setype+"&action="+setype+"Ajax&file=getAccountToSend&viewname="+viewname,
		   success: function(msg){   
		   	 $("#status").css("display","none");
		   	 $("#receiveaccountinfo").html(msg); 
		   	 $("#viewname").val(viewname);
		   }  
	});
}
  //函数名：fucCheckLength  
  //功能介绍：检查字符串的长度  
  //参数说明：要检查的字符串  
  //返回值：长度值  
function   fucCheckLength2(strTemp)  
{  
  var   i,sum;  
  sum=0;  
  for(i=0;i<strTemp.length;i++)  
  {  
	  if   ((strTemp.charCodeAt(i)>=0)   &&   (strTemp.charCodeAt(i)<=255))  
	  sum=sum+1;  
	  else  
	  sum=sum+1;  
  }  
  return   sum;  
}   

function SendMessToAll(setype){
	sendmessageinfoobj = document.getElementById('sendmessageinfo');
	if(typeof sendmessageinfoobj != 'undefined') {
		var sendmessageinfo = $("#sendmessageinfo").val();
		while( sendmessageinfo.indexOf( "&" ) != -1 ) { 
			 sendmessageinfo = sendmessageinfo.replace("&",'##'); 
		}
		if(sendmessageinfo ==''){
			alert("短信内容不能为空"); 
			$("#sendmessageinfo").val('');
			$("#sendmessageinfo").focus();
			return false;
		}
		var contentlen = fucCheckLength2(sendmessageinfo);
		if(contentlen >65){
			alert("短信内容不能超过65个字"); 
			$("#sendmessageinfo").focus();
			return false;
		}
		
		var receiveaccountinfo = $("#receiveaccountinfo").val();// document.getElementById('receiveaccountinfo').value; 
		while( receiveaccountinfo.indexOf( "&" ) != -1 ) { 
			 receiveaccountinfo = receiveaccountinfo.replace("&",'##'); 
		} 
		if(receiveaccountinfo ==''){
			alert("接收人不能为空"); 
			$("#receiveaccountinfo").val('');
			$("#receiveaccountinfo").focus();
			return false;
		}  
		//sendtimeobj = document.getElementById('jscal_field_sendtime');
		//var sendtime = sendtimeobj.value;
		var sendtime = $("#jscal_field_sendtime").val();
		if(sendtime == 'undefined'|| sendtime == ''){
			sendtimeurl = '';
		}else{
			sendtimeurl = '&sendtime='+sendtime;	
		}
			
			document.getElementById('savebutton').disabled = "disabled";
			
			$("#status").css("display","inline");
			$.ajax({
				type:"GET",
				url:"index.php?module="+setype+"&action="+setype+"Ajax&file=SendMessToAll&message="+sendmessageinfo+"&receiveaccountinfo="+receiveaccountinfo+sendtimeurl,
				success:function(msg){
					$("#status").css("display","none");
					if(msg.indexOf('SUCCESS') != -1){
						alert("发送任务已添加至发送队列，请耐心等候发送...");
						window.location.reload();
					}else if(msg.indexOf('YES') != -1){
						alert("发送任务已成功写入数据库。");
						window.location.reload();
					}else{
						alert("短信发送失败"+msg);
						document.getElementById('savebutton').disabled = "";
					}

				}
			});
//            new Ajax.Request(
//                    'index.php',
//                    {queue: {position: 'end', scope: 'command'},
//                        method: 'post',
//                        postBody:"module="+setype+"&action="+setype+"Ajax&file=SendMessToAll&message="+sendmessageinfo+"&receiveaccountinfo="+receiveaccountinfo+sendtimeurl,
//                        onComplete: function(response) { 
//                                $("status").style.display="none";
//								result = response.responseText;
//								if(result.indexOf('SUCCESS') != -1){
//									alert("发送任务已添加至发送队列，请耐心等候发送...");
//									window.location.reload();
//								}else if(result.indexOf('YES') != -1){
//									alert("发送任务已成功写入数据库。");
//									window.location.reload();
//								}else{
//									alert("短信发送失败"+result);
//									document.getElementById('savebutton').disabled = "";
//								}
//								
//                        }
//                 }
//            );
	}
	
}
//JS 替换所有的&为##
function replaceAll(objid){
		while( objid.indexOf( "&" ) != -1 ) { 
			 objid = objid.replace("&",'##'); 
		}
}
function SendMailToAll(setype,sjid,ke){
	if(sjid ==''){
		sjid = document.getElementById('sjid').value;
	}
	mailcontentobj = document.getElementById('mailcontent');
	subjectobj = document.getElementById('subject');
	from_name = document.getElementById('from_name').value;
	from_email = document.getElementById('from_email').value;
	if(mailcontentobj && subjectobj){
		subject = document.getElementById('subject').value;
		//subject = subject.replace(/\s/ig,'');
		while( subject.indexOf( "&" ) != -1 ) {
			 subject = subject.replace("&",'##'); 
		}
		if(subject ==''){
			alert("邮件主题不能为空"); 
			document.getElementById('subject').value ='';
			document.getElementById('subject').focus();
			return false;
		}
		if(ke=='KE'){
			KE.util.setData("mailcontent");
		}
		//mailcontent = getEditorTextContents("mailcontent");
		mailcontent =  document.getElementById('mailcontent').value;
		//mailcontent = mailcontent.replace("&nbsp;",' '); 
		while( mailcontent.indexOf( "&" ) != -1 ) {
			 mailcontent = mailcontent.replace("&",'##'); 
		}
		if(mailcontent ==''){
			alert("邮件内容不能为空"); 
			document.getElementById('mailcontent').value ='';
			document.getElementById('mailcontent').focus();
			return false;
		}
		receiveaccountinfo = document.getElementById('receiveaccountinfo').value;  
		receiveaccountinfo = receiveaccountinfo.replace(/\s/ig,'**');

		//alert(receiveaccountinfo);
		
		while( receiveaccountinfo.indexOf( "&" ) != -1 ) {
			 receiveaccountinfo = receiveaccountinfo.replace("&",'##'); 
		}
		
		if(receiveaccountinfo ==''){
			alert("接收人不能为空"); 
			document.getElementById('receiveaccountinfo').value ='';
			document.getElementById('receiveaccountinfo').focus();
			return false;
		}  
		document.getElementById('savebutton').disabled = "disabled";

		$("#status").css('display','inline');
	    $.ajax({  
	       type: "GET",  
	       //dataType:"Text",   
	       url:"index.php?module="+setype+"&action="+setype+"Ajax&file=SendMailToAll&subject="+subject+"&mailcontent="+mailcontent+"&receiveaccountinfo="+receiveaccountinfo+"&sjid="+sjid+"&from_name="+from_name+"&from_email="+from_email,
	       success: function(msg){   
	         $("#status").css('display','none');
	         	if(msg.indexOf('SUCCESS') != -1){
					alert("邮件已成功放入发送队列，请耐心等候。");
					window.location.reload();
				}else{
					document.getElementById('savebutton').disabled = "";
					alert("邮件放入发送队列失败："+msg);
				}
	       }
	     });
	}
	
	if(ke ==''){
		fninvsh('qunfamail');	
	}
}   


function getTabView(setype,url,theelement,viewname){
    $('viewname').value = viewname;
	var classmethods=$('#tablink ul');
	var classnum = classmethods.children('li').length;
	for(var i=1;i<classnum;i++){ 
	   classmethods.children('li:eq('+i+')').removeClass('active');
	}
	$(theelement).parent().addClass('active');
	getListViewEntries_js(setype,url);
	
}

function getTabViewNew(record,theelement) {
	
	setype = $("tabview").value;

	if(setype == ''){
		setype = "Noteinfo";
	}
	var classmethods=$('.tablink');

	for(var i=0;i<classmethods.length;i++){

	   classmethods[i].removeClass('selected');

	}
	tableview_theelement = document.getElementById(setype);
		
	$(tableview_theelement).addClass('selected');
	
	module = $("modulename").value;
	
	if(theelement == ''){
		theelement = document.getElementById("row_"+record);
	}
	
	new Ajax.Request(

		'index.php',

		  {queue: {position: 'end', scope: 'command'},

			method: 'post',

			postBody: 'module='+module+'&action='+module+'Ajax&file=getInfoView&record='+record+'&type='+setype,

			onComplete: function(response) {

				$("status").style.display = "none";

				recordago =  $("recordid").value; 
				if(recordago != ''){
					temprecordid = 'row_'+recordago;
				  if($(temprecordid) == null || $(temprecordid) == "null" || $(temprecordid) == undefined){
				  }else{
					  $(temprecordid).removeClass('lvtColDataHover');
					  $(temprecordid).addClass('lvtColData');
					}
				}
				$("recordid").value = record;

				$("row_"+record).removeClass('lvtColData');
				$("row_"+record).addClass('lvtColDataHover');
				$("tabviewContent").update(response.responseText);	
	
			}
		  }
	);
	
}
function getTabViewNewClear() {
	
	setype = $("#tabview").val();

	if(setype != ''){
		
		module = $("modulename").value;

		new Ajax.Request(

			'index.php',

			  {queue: {position: 'end', scope: 'command'},

				method: 'post',

				postBody: 'module='+module+'&action='+module+'Ajax&file=getInfoView&record=&type='+setype,

				onComplete: function(response) {

					$("status").style.display = "none";

                   
					$("tabviewContent").update(response.responseText);		
				}
			  }
	    );
	}
}

function getTabViewForList(setype,theelement) {
	if(setype == ''){
		setype = "Noteinfo";
	}

	urlstring='';

	var classmethods=$('.tablink');

	for(var i=0;i<classmethods.length;i++){

	   classmethods[i].removeClass('selected');

	}
	if(theelement == '' ){
		theelement = document.getElementById(setype);
	}
	
	$(theelement).addClass('selected');
	module = $("modulename").value;
	record = $("recordid").value;
	
	

	$("status").style.display="inline";

			new Ajax.Request(

				'index.php',

				  {queue: {position: 'end', scope: 'command'},

					method: 'post',

					postBody: 'module='+module+'&action='+module+'Ajax&file=getInfoView&record='+record+'&type='+setype,

					onComplete: function(response) {

						$("status").style.display = "none";

						$("tabview").value = setype;
	 
						$("tabviewContent").update(response.responseText);		

					}
				  }

			);

}


function editView(setype,category) {
    var viewid = $('#viewname').val();
	var url = "index.php?module=" + setype +"&action=CustomView&record=" + viewid +"&parenttab="+category;
	window.location.href = url;
}


function deleteView(setype,category) {
	var viewid = $('#viewname').val();
	var url ="index.php?module=CustomView&dmodule=" + setype +"&action=Delete&record=" + viewid +"&parenttab="+category;
	if(confirm(alert_arr.SURE_TO_DELETE))
	{
		//document.location.href=url;
		window.location.href = url;
	}
}
function editFenzu(setype,category) {
	
	viewid = $("#viewname").val();

	var url = "index.php?module=" + setype +"&action=Fenzu&record=" + viewid +"&parenttab="+category;

	window.location.href = url;
}
function deleteFenzu(setype,category) {
	
	viewid = $("#viewname").val();

	var url ="index.php?module=Fenzu&dmodule=" + setype +"&action=Delete&record=" + viewid +"&parenttab="+category;
	if(confirm(alert_arr.SURE_TO_DELETE))
	{
		//document.location.href=url;
		window.location.href = url;
	}
}

function SearchAccountVal(){
    var obj={};
    var el=$('#account_search_val');
    if(el){
        obj.searchval=el.val();
    }
    //var querystr=$H(obj).toQueryString();
    var querystr = $.param(obj); 
    $("#status").css('display','inline');

    $.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:'index.php?module=Accounts&action=AccountsAjax&file=getAccountSearch&'+querystr,
		   success: function(msg){   
		   	 $("#status").css("display","none");
	            $('#SelCustomer_popview').html(msg);
	            $('#SelCustomer_popview').show(); 

	            $('#SelCustomer_popview').css({ 
					position: 'absolute', 
					top: $('#account_search_val').offset().top + 23 + 'px', 
					left: $('#account_search_val').offset().left + 'px' 
				}); 
		   }  
	});
}

function chooseAccountFromLink(linkel){
    var accountid=$(linkel).attr('cu_id');
    var accountname=$(linkel).html();
    $("input[name=account_name]").val(accountname);
    $("input[name=account_id]").val(accountid);
    $('#SelCustomer_popview').hide();
    if($("#contact_id")){
       // updateContactOpts();
    }
}

function updateContactOpts(){
    var obj={}
    if(!$("input[name=contact_id]")) return;
    obj.accountid=$("input[name=account_id]").val();
    obj.contactid=$("#contact_id").val();
    var querystr=$.param(obj); 
    $("status").css('display','block');
    $.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:'index.php?module=Contacts&action=ContactsAjax&file=getContactOptions&'+querystr,
		   success: function(msg){   
		   	 $("#status").css("display","none");
	            $('#SelCustomer_popview').html(msg);
	            $('#SelCustomer_popview').show(); 

	            $('#SelCustomer_popview').css({ 
					position: 'absolute', 
					top: $('#account_search_val').offset().top + 23 + 'px', 
					left: $('#account_search_val').offset().left + 'px' 
				}); 
		   }  
	});
    // new Ajax.Request(
    //           'index.php',
    //         {queue: {position: 'end', scope: 'command'},
    //             method: 'post',
    //             postBody:"module=Contacts&action=ContactsAjax&file=getContactOptions&"+querystr,
    //             onComplete: function(response) {
    //                     $("status").style.display="none";
    //                     $('#contact_id').html(msg);
    //             }
    //      }
    // );
}


function SearchContactVal(fieldname){
    var obj={}
    var el=$('account_search_val');
    if(el){
        obj.searchval=el.value;
    }
    var querystr=$H(obj).toQueryString();
// postBody:"module=Contacts&action=ContactsAjax&file=getContactSearch&fieldname="+fieldname+"&"+querystr,
    $("status").style.display="block";
    new Ajax.Request(
              'index.php',
            {queue: {position: 'end', scope: 'command'},
                method: 'post',
                postBody:"module=Contacts&action=ContactsAjax&file=getContactSearch&fieldname="+fieldname+"&"+querystr,
                onComplete: function(response) {
                        $("status").style.display="none";
						$("SelContact_popview").innerHTML=response.responseText;
						fnvshNrm("SelContact_popview");
                }
         }
    );
}

function chooseContactFromLink(lastname,fieldname){
    //var contactid=$(linkel).getAttribute('cu_id');
    //var lastname=linkel.innerHTML;
	lastname=lastname.replace("(","<");
	lastname=lastname.replace(")",">");
	$(fieldname).value += lastname + ";";
	fninvsh('SelContact_popview');
 
}

function ToggleGroupContent(id,imgId){
    
	var flag  = $("#"+id).css("display");
	if (flag != "none"){ 
		$("#"+id).hide(); 
		$("#"+imgId).src="themes/images/expand.gif";  
	}else {
		$("#"+id).show(); 
		$("#"+imgId).src="themes/images/collapse.gif";
	}

}


function openfullscreen(htmlurl) {   
   window.close();
   window.open(htmlurl,"","fullscreen=1,menubar=0,toolbar=0,directories=0,location=0,status=0,scrollbars=0");
}

/***********************************
calendar start on 2011-12-05
*/
var turnOffYearSpan = false;     // true = Only show This Year and Next, false = show +/- 5 years
var weekStartsOnSunday = false;  // true = Start the week on Sunday, false = start the week on Monday
var showWeekNumber = true;  // true = show week number,  false = do not show week number

var calendar_display_time = true;

// Format of current day at the bottom of the calendar
// [todayString] = the value of todayString
// [dayString] = day of week (examle: mon, tue, wed...)
// [UCFdayString] = day of week (examle: Mon, Tue, Wed...) ( First letter in uppercase)
// [day] = Day of month, 1..31
// [monthString] = Name of current month
// [year] = Current year
var todayStringFormat = '[year]/[monthString]/[day] [todayString] [UCFdayString]';
var pathToImages = 'themes/images/calendar/';	// Relative to your HTML file

var speedOfSelectBoxSliding = 200;	// Milliseconds between changing year and hour when holding mouse over "-" and "+" - lower value = faster
var intervalSelectBox_minutes = 5;	// Minute select box - interval between each option (5 = default)

var calendar_offsetTop = 0;		// Offset - calendar placement - You probably have to modify this value if you're not using a strict doctype
var calendar_offsetLeft = 0;	// Offset - calendar placement - You probably have to modify this value if you're not using a strict doctype
var calendarDiv = false;

var MSIE = false;
var Opera = false;
if(navigator.userAgent.indexOf('MSIE')>=0 && navigator.userAgent.indexOf('Opera')<0)MSIE=true;
if(navigator.userAgent.indexOf('Opera')>=0)Opera=true;

if (weekStartsOnSunday) {
   var tempDayName = dayArray[6];
   for(var theIx = 6; theIx > 0; theIx--) {
      dayArray[theIx] = dayArray[theIx-1];
   }
   dayArray[0] = tempDayName;
}



var daysInMonthArray = [31,28,31,30,31,30,31,31,30,31,30,31];
var currentMonth;
var currentYear;
var currentHour;
var currentMinute;
var calendarContentDiv;
var returnDateTo;
var returnFormat;
var activeSelectBoxMonth;
var activeSelectBoxYear;
var activeSelectBoxHour;
var activeSelectBoxMinute;

var iframeObj = false;
//// fix for EI frame problem on time dropdowns 09/30/2006
var iframeObj2 =false;
function EIS_FIX_EI1(where2fixit)
{

		if(!iframeObj2)return;
		iframeObj2.style.display = 'block';
		iframeObj2.style.height =document.getElementById(where2fixit).offsetHeight+1;
		iframeObj2.style.width=document.getElementById(where2fixit).offsetWidth;
		iframeObj2.style.left=getleftPos(document.getElementById(where2fixit))+1-calendar_offsetLeft;
		iframeObj2.style.top=getTopPos(document.getElementById(where2fixit))-document.getElementById(where2fixit).offsetHeight-calendar_offsetTop;
}

function EIS_Hide_Frame()
{		if(iframeObj2)iframeObj2.style.display = 'none';}
//// fix for EI frame problem on time dropdowns 09/30/2006
var returnDateToYear;
var returnDateToMonth;
var returnDateToDay;
var returnDateToHour;
var returnDateToMinute;

var inputYear;
var inputMonth;
var inputDay;
var inputHour;
var inputMinute;
var calendarDisplayTime = false;

var selectBoxHighlightColor = '#D60808'; // Highlight color of select boxes
var selectBoxRolloverBgColor = '#E8EDF4'; // Background color on drop down lists(rollover) #E2EBED(初始)

var selectBoxMovementInProgress = false;
var activeSelectBox = false;

function cancelCalendarEvent()
{
	return false;
}
function isLeapYear(inputYear)
{
	if(inputYear%400==0||(inputYear%4==0&&inputYear%100!=0)) return true;
	return false;

}
var activeSelectBoxMonth = false;
var activeSelectBoxDirection = false;

function highlightMonthYear()
{
	if(activeSelectBoxMonth)activeSelectBoxMonth.className='';
	activeSelectBox = this;


	if(this.className=='monthYearActive'){
		this.className='';
	}else{
		this.className = 'monthYearActive';
		activeSelectBoxMonth = this;
	}

	if(this.innerHTML.indexOf('-')>=0 || this.innerHTML.indexOf('+')>=0){
		if(this.className=='monthYearActive')
			selectBoxMovementInProgress = true;
		else
			selectBoxMovementInProgress = false;
		if(this.innerHTML.indexOf('-')>=0)activeSelectBoxDirection = -1; else activeSelectBoxDirection = 1;

	}else selectBoxMovementInProgress = false;

}

function showMonthDropDown()
{
	if(document.getElementById('monthDropDown').style.display=='block'){
		document.getElementById('monthDropDown').style.display='none';
		//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	}else{
		document.getElementById('monthDropDown').style.display='block';
		document.getElementById('yearDropDown').style.display='none';
		document.getElementById('hourDropDown').style.display='none';
		document.getElementById('minuteDropDown').style.display='none';
			if (MSIE)
		{ EIS_FIX_EI1('monthDropDown')}
		//// fix for EI frame problem on time dropdowns 09/30/2006

	}
}

function showYearDropDown()
{
	if(document.getElementById('yearDropDown').style.display=='block'){
		document.getElementById('yearDropDown').style.display='none';
		//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	}else{
		document.getElementById('yearDropDown').style.display='block';
		document.getElementById('monthDropDown').style.display='none';
		document.getElementById('hourDropDown').style.display='none';
		document.getElementById('minuteDropDown').style.display='none';
			if (MSIE)
		{ EIS_FIX_EI1('yearDropDown')}
		//// fix for EI frame problem on time dropdowns 09/30/2006

	}

}
function showHourDropDown()
{
	if(document.getElementById('hourDropDown').style.display=='block'){
		document.getElementById('hourDropDown').style.display='none';
		//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	}else{
		document.getElementById('hourDropDown').style.display='block';
		document.getElementById('monthDropDown').style.display='none';
		document.getElementById('yearDropDown').style.display='none';
		document.getElementById('minuteDropDown').style.display='none';
				if (MSIE)
		{ EIS_FIX_EI1('hourDropDown')}
		//// fix for EI frame problem on time dropdowns 09/30/2006
	}

}
function showMinuteDropDown()
{
	if(document.getElementById('minuteDropDown').style.display=='block'){
		document.getElementById('minuteDropDown').style.display='none';
		//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	}else{
		document.getElementById('minuteDropDown').style.display='block';
		document.getElementById('monthDropDown').style.display='none';
		document.getElementById('yearDropDown').style.display='none';
		document.getElementById('hourDropDown').style.display='none';
				if (MSIE)
		{ EIS_FIX_EI1('minuteDropDown')}
		//// fix for EI frame problem on time dropdowns 09/30/2006
	}

}

function selectMonth()
{
	document.getElementById('calendar_month_txt').innerHTML = this.innerHTML
	currentMonth = this.id.replace(/[^\d]/g,'');

	document.getElementById('monthDropDown').style.display='none';
	//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	for(var no=0;no<monthArray.length;no++){
		document.getElementById('monthDiv_'+no).style.color='';
	}
	this.style.color = selectBoxHighlightColor;
	activeSelectBoxMonth = this;
	writeCalendarContent();

}

function selectHour()
{
	document.getElementById('calendar_hour_txt').innerHTML = this.innerHTML
	currentHour = this.innerHTML.replace(/[^\d]/g,'');
	document.getElementById('hourDropDown').style.display='none';
	//// fix for EI frame problem on time dropdowns 09/30/2006
	EIS_Hide_Frame();
	if(activeSelectBoxHour){
		activeSelectBoxHour.style.color='';
	}
	activeSelectBoxHour=this;
	this.style.color = selectBoxHighlightColor;
}

function selectMinute()
{
	document.getElementById('calendar_minute_txt').innerHTML = this.innerHTML
	currentMinute = this.innerHTML.replace(/[^\d]/g,'');
	document.getElementById('minuteDropDown').style.display='none';
	//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	if(activeSelectBoxMinute){
		activeSelectBoxMinute.style.color='';
	}
	activeSelectBoxMinute=this;
	this.style.color = selectBoxHighlightColor;
}


function selectYear()
{
	document.getElementById('calendar_year_txt').innerHTML = this.innerHTML
	currentYear = this.innerHTML.replace(/[^\d]/g,'');
	document.getElementById('yearDropDown').style.display='none';
	//// fix for EI frame problem on time dropdowns 09/30/2006
				EIS_Hide_Frame();
	if(activeSelectBoxYear){
		activeSelectBoxYear.style.color='';
	}
	activeSelectBoxYear=this;
	this.style.color = selectBoxHighlightColor;
	writeCalendarContent();

}

function switchMonth()
{
	if(this.src.indexOf('left')>=0){
		currentMonth=currentMonth-1;;
		if(currentMonth<0){
			currentMonth=11;
			currentYear=currentYear-1;
		}
	}else{
		currentMonth=currentMonth+1;;
		if(currentMonth>11){
			currentMonth=0;
			currentYear=currentYear/1+1;
		}
	}

	writeCalendarContent();


}

function createMonthDiv(){
	var div = document.createElement('DIV');
	div.className='monthYearPicker';
	div.id = 'monthPicker';

	for(var no=0;no<monthArray.length;no++){
		var subDiv = document.createElement('DIV');
		subDiv.innerHTML = monthArray[no];
		subDiv.onmouseover = highlightMonthYear;
		subDiv.onmouseout = highlightMonthYear;
		subDiv.onclick = selectMonth;
		subDiv.id = 'monthDiv_' + no;
		subDiv.style.width = '56px';
		subDiv.onselectstart = cancelCalendarEvent;
		div.appendChild(subDiv);
		if(currentMonth && currentMonth==no){
			subDiv.style.color = selectBoxHighlightColor;
			activeSelectBoxMonth = subDiv;
		}

	}
	return div;

}

function changeSelectBoxYear(e,inputObj)
{
	if(!inputObj)inputObj =this;
	var yearItems = inputObj.parentNode.getElementsByTagName('DIV');
	if(inputObj.innerHTML.indexOf('-')>=0){
		var startYear = yearItems[1].innerHTML/1 -1;
		if(activeSelectBoxYear){
			activeSelectBoxYear.style.color='';
		}
	}else{
		var startYear = yearItems[1].innerHTML/1 +1;
		if(activeSelectBoxYear){
			activeSelectBoxYear.style.color='';

		}
	}

	for(var no=1;no<yearItems.length-1;no++){
		yearItems[no].innerHTML = startYear+no-1;
		yearItems[no].id = 'yearDiv' + (startYear/1+no/1-1);

	}
	if(activeSelectBoxYear){
		activeSelectBoxYear.style.color='';
		if(document.getElementById('yearDiv'+currentYear)){
			activeSelectBoxYear = document.getElementById('yearDiv'+currentYear);
			activeSelectBoxYear.style.color=selectBoxHighlightColor;;
		}
	}
}
function changeSelectBoxHour(e,inputObj)
{
	if(!inputObj)inputObj = this;

	var hourItems = inputObj.parentNode.getElementsByTagName('DIV');
	if(inputObj.innerHTML.indexOf('-')>=0){
		var startHour = hourItems[1].innerHTML/1 -1;
		if(startHour<0)startHour=0;
		if(activeSelectBoxHour){
			activeSelectBoxHour.style.color='';
		}
	}else{
		var startHour = hourItems[1].innerHTML/1 +1;
		if(startHour>14)startHour = 14;
		if(activeSelectBoxHour){
			activeSelectBoxHour.style.color='';

		}
	}
	var prefix = '';
	for(var no=1;no<hourItems.length-1;no++){
		if((startHour/1 + no/1) < 11)prefix = '0'; else prefix = '';
		hourItems[no].innerHTML = prefix + (startHour+no-1);

		hourItems[no].id = 'hourDiv' + (startHour/1+no/1-1);

	}
	if(activeSelectBoxHour){
		activeSelectBoxHour.style.color='';
		if(document.getElementById('hourDiv'+currentHour)){
			activeSelectBoxHour = document.getElementById('hourDiv'+currentHour);
			activeSelectBoxHour.style.color=selectBoxHighlightColor;;
		}
	}
}

function updateYearDiv()
{
    var yearSpan = 5;
    if (turnOffYearSpan) {
       yearSpan = 0;
    }
	var div = document.getElementById('yearDropDown');
	var yearItems = div.getElementsByTagName('DIV');
	for(var no=1;no<yearItems.length-1;no++){
		yearItems[no].innerHTML = currentYear/1 -yearSpan + no;
		if(currentYear==(currentYear/1 -yearSpan + no)){
			yearItems[no].style.color = selectBoxHighlightColor;
			activeSelectBoxYear = yearItems[no];
		}else{
			yearItems[no].style.color = '';
		}
	}
}

function updateMonthDiv()
{
	for(no=0;no<12;no++){
		document.getElementById('monthDiv_' + no).style.color = '';
	}
	document.getElementById('monthDiv_' + currentMonth).style.color = selectBoxHighlightColor;
	activeSelectBoxMonth = 	document.getElementById('monthDiv_' + currentMonth);
}


function updateHourDiv()
{
	var div = document.getElementById('hourDropDown');
	var hourItems = div.getElementsByTagName('DIV');

	var addHours = 0;
	if((currentHour/1 -6 + 1)<0){
		addHours = 	(currentHour/1 -6 + 1)*-1;
	}
	for(var no=1;no<hourItems.length-1;no++){
		var prefix='';
		if((currentHour/1 -6 + no + addHours) < 10)prefix='0';
		hourItems[no].innerHTML = prefix +  (currentHour/1 -6 + no + addHours);
		if(currentHour==(currentHour/1 -6 + no)){
			hourItems[no].style.color = selectBoxHighlightColor;
			activeSelectBoxHour = hourItems[no];
		}else{
			hourItems[no].style.color = '';
		}
	}
}

function updateMinuteDiv()
{
	for(no=0;no<60;no+=intervalSelectBox_minutes){
		var prefix = '';
		if(no<10)prefix = '0';

		document.getElementById('minuteDiv_' + prefix + no).style.color = '';
	}
	if(document.getElementById('minuteDiv_' + currentMinute)){
		document.getElementById('minuteDiv_' + currentMinute).style.color = selectBoxHighlightColor;
		activeSelectBoxMinute = document.getElementById('minuteDiv_' + currentMinute);
	}
}



function createYearDiv()
{

	if(!document.getElementById('yearDropDown')){
		var div = document.createElement('DIV');
		div.className='monthYearPicker';
	}else{
		var div = document.getElementById('yearDropDown');
		var subDivs = div.getElementsByTagName('DIV');
		for(var no=0;no<subDivs.length;no++){
			subDivs[no].parentNode.removeChild(subDivs[no]);
		}
	}


	var d = new Date();
	if(currentYear){
		d.setFullYear(currentYear);
	}

	var startYear = d.getFullYear()/1 - 5;

    var yearSpan = 10;
	if (! turnOffYearSpan) {
    	var subDiv = document.createElement('DIV');
    	subDiv.innerHTML = '&nbsp;&nbsp;- ';
    	subDiv.onclick = changeSelectBoxYear;
    	subDiv.onmouseover = highlightMonthYear;
    	subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
    	subDiv.onselectstart = cancelCalendarEvent;
    	div.appendChild(subDiv);
    } else {
       startYear = d.getFullYear()/1 - 0;
       yearSpan = 2;
    }

	for(var no=startYear;no<(startYear+yearSpan);no++){
		var subDiv = document.createElement('DIV');
		subDiv.innerHTML = no;
		subDiv.onmouseover = highlightMonthYear;
		subDiv.onmouseout = highlightMonthYear;
		subDiv.onclick = selectYear;
		subDiv.id = 'yearDiv' + no;
		subDiv.onselectstart = cancelCalendarEvent;
		div.appendChild(subDiv);
		if(currentYear && currentYear==no){
			subDiv.style.color = selectBoxHighlightColor;
			activeSelectBoxYear = subDiv;
		}
	}
	if (! turnOffYearSpan) {
    	var subDiv = document.createElement('DIV');
    	subDiv.innerHTML = '&nbsp;&nbsp;+ ';
    	subDiv.onclick = changeSelectBoxYear;
    	subDiv.onmouseover = highlightMonthYear;
    	subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
    	subDiv.onselectstart = cancelCalendarEvent;
    	div.appendChild(subDiv);
	}
	return div;
}

/* This function creates the hour div at the bottom bar */

function slideCalendarSelectBox()
{
	if(selectBoxMovementInProgress){
		if(activeSelectBox.parentNode.id=='hourDropDown'){
			changeSelectBoxHour(false,activeSelectBox);
		}
		if(activeSelectBox.parentNode.id=='yearDropDown'){
			changeSelectBoxYear(false,activeSelectBox);
		}

	}
	setTimeout('slideCalendarSelectBox()',speedOfSelectBoxSliding);

}

function createHourDiv()
{
	if(!document.getElementById('hourDropDown')){
		var div = document.createElement('DIV');
		div.className='monthYearPicker';
	}else{
		var div = document.getElementById('hourDropDown');
		var subDivs = div.getElementsByTagName('DIV');
		for(var no=0;no<subDivs.length;no++){
			subDivs[no].parentNode.removeChild(subDivs[no]);
		}
	}

	if(!currentHour)currentHour=0;
	var startHour = currentHour/1;
	if(startHour>14)startHour=14;

	var subDiv = document.createElement('DIV');
	subDiv.innerHTML = '&nbsp;&nbsp;- ';
	subDiv.onclick = changeSelectBoxHour;
	subDiv.onmouseover = highlightMonthYear;
	subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
	subDiv.onselectstart = cancelCalendarEvent;
	div.appendChild(subDiv);

	for(var no=startHour;no<startHour+10;no++){
		var prefix = '';
		if(no/1<10)prefix='0';
		var subDiv = document.createElement('DIV');
		subDiv.innerHTML = prefix + no;
		subDiv.onmouseover = highlightMonthYear;
		subDiv.onmouseout = highlightMonthYear;
		subDiv.onclick = selectHour;
		subDiv.id = 'hourDiv' + no;
		subDiv.onselectstart = cancelCalendarEvent;
		div.appendChild(subDiv);
		if(currentYear && currentYear==no){
			subDiv.style.color = selectBoxHighlightColor;
			activeSelectBoxYear = subDiv;
		}
	}
	var subDiv = document.createElement('DIV');
	subDiv.innerHTML = '&nbsp;&nbsp;+ ';
	subDiv.onclick = changeSelectBoxHour;
	subDiv.onmouseover = highlightMonthYear;
	subDiv.onmouseout = function(){ selectBoxMovementInProgress = false;};
	subDiv.onselectstart = cancelCalendarEvent;
	div.appendChild(subDiv);

	return div;
}
/* This function creates the minute div at the bottom bar */

function createMinuteDiv()
{
	if(!document.getElementById('minuteDropDown')){
		var div = document.createElement('DIV');
		div.className='monthYearPicker';
	}else{
		var div = document.getElementById('minuteDropDown');
		var subDivs = div.getElementsByTagName('DIV');
		for(var no=0;no<subDivs.length;no++){
			subDivs[no].parentNode.removeChild(subDivs[no]);
		}
	}
	var startMinute = 0;
	var prefix = '';
	for(var no=startMinute;no<60;no+=intervalSelectBox_minutes){

		if(no<10)prefix='0'; else prefix = '';
		var subDiv = document.createElement('DIV');
		subDiv.innerHTML = prefix + no;
		subDiv.onmouseover = highlightMonthYear;
		subDiv.onmouseout = highlightMonthYear;
		subDiv.onclick = selectMinute;
		subDiv.id = 'minuteDiv_' + prefix +  no;
		subDiv.onselectstart = cancelCalendarEvent;
		div.appendChild(subDiv);
		if(currentYear && currentYear==no){
			subDiv.style.color = selectBoxHighlightColor;
			activeSelectBoxYear = subDiv;
		}
	}
	return div;
}

function highlightSelect()
{

	if(this.className=='selectBoxTime'){
		this.className = 'selectBoxTimeOver';
		this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_time_over.gif';
	}else if(this.className=='selectBoxTimeOver'){
		this.className = 'selectBoxTime';
		this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_time.gif';
	}

	if(this.className=='selectBox'){
		this.className = 'selectBoxOver';
		this.getElementsByTagName('IMG')[0].src = pathToImages + 'down_over.gif';
	}else if(this.className=='selectBoxOver'){
		this.className = 'selectBox';
		this.getElementsByTagName('IMG')[0].src = pathToImages + 'down.gif';
	}

}

function highlightArrow()
{
	if(this.src.indexOf('over')>=0){
		if(this.src.indexOf('left')>=0)this.src = pathToImages + 'left.gif';
		if(this.src.indexOf('right')>=0)this.src = pathToImages + 'right.gif';
	}else{
		if(this.src.indexOf('left')>=0)this.src = pathToImages + 'left_over.gif';
		if(this.src.indexOf('right')>=0)this.src = pathToImages + 'right_over.gif';
	}
}

function highlightClose()
{
	if(this.src.indexOf('over')>=0){
		this.src = pathToImages + 'close.gif';
	}else{
		this.src = pathToImages + 'close_over.gif';
	}

}

function closeCalendar(){

	document.getElementById('yearDropDown').style.display='none';
	document.getElementById('monthDropDown').style.display='none';
	document.getElementById('hourDropDown').style.display='none';
	document.getElementById('minuteDropDown').style.display='none';

	calendarDiv.style.display='none';
	if(iframeObj){
		iframeObj.style.display='none';
		 //// //// fix for EI frame problem on time dropdowns 09/30/2006
			EIS_Hide_Frame();}
	if(activeSelectBoxMonth)activeSelectBoxMonth.className='';
	if(activeSelectBoxYear)activeSelectBoxYear.className='';


}

function writeTopBar()
{

	var topBar = document.createElement('DIV');
	topBar.className = 'topBar';
	topBar.id = 'topBar';
	calendarDiv.appendChild(topBar);

	// Left arrow
	var leftDiv = document.createElement('DIV');
	leftDiv.style.margin = '2px';//Right
	var img = document.createElement('IMG');
	img.src = pathToImages + 'left.gif';
	img.onmouseover = highlightArrow;
	img.onclick = switchMonth;
	img.onmouseout = highlightArrow;
	leftDiv.appendChild(img);
	topBar.appendChild(leftDiv);
	if(Opera)leftDiv.style.width = '16px';

	// Right arrow
	var rightDiv = document.createElement('DIV');
	rightDiv.style.margin = '2px';//Right
	var img = document.createElement('IMG');
	img.src = pathToImages + 'right.gif';
	img.onclick = switchMonth;
	img.onmouseover = highlightArrow;
	img.onmouseout = highlightArrow;
	rightDiv.appendChild(img);
	if(Opera)rightDiv.style.width = '16px';
	topBar.appendChild(rightDiv);


	// Month selector
	var monthDiv = document.createElement('DIV');
	monthDiv.id = 'monthSelect';
	monthDiv.onmouseover = highlightSelect;
	monthDiv.onmouseout = highlightSelect;
	monthDiv.onclick = showMonthDropDown;
	monthDiv.style.marginLeft = '4px';
	var span = document.createElement('SPAN');
	span.innerHTML = monthArray[currentMonth];
	span.id = 'calendar_month_txt';
	monthDiv.appendChild(span);

	var img = document.createElement('IMG');
	img.src = pathToImages + 'down.gif';
	img.style.position = 'absolute';
	img.style.right = '0px';
	monthDiv.appendChild(img);
	monthDiv.className = 'selectBox';
	if(Opera){
		img.style.cssText = 'float:right;position:relative';
		img.style.position = 'relative';
		img.style.styleFloat = 'right';
	}
	topBar.appendChild(monthDiv);

	var monthPicker = createMonthDiv();
	monthPicker.style.left = '37px';
	monthPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
	monthPicker.style.width ='60px';
	monthPicker.id = 'monthDropDown';

	calendarDiv.appendChild(monthPicker);

	// Year selector
	var yearDiv = document.createElement('DIV');
	yearDiv.onmouseover = highlightSelect;
	yearDiv.onmouseout = highlightSelect;
	yearDiv.onclick = showYearDropDown;
	var span = document.createElement('SPAN');
	span.innerHTML = currentYear;
	span.id = 'calendar_year_txt';
	yearDiv.appendChild(span);
	topBar.appendChild(yearDiv);

	var img = document.createElement('IMG');
	img.src = pathToImages + 'down.gif';
	yearDiv.appendChild(img);
	yearDiv.className = 'selectBox';

	if(Opera){
		yearDiv.style.width = '50px';
		img.style.cssText = 'float:right';
		img.style.position = 'relative';
		img.style.styleFloat = 'right';
	}

	var yearPicker = createYearDiv();
	yearPicker.style.left = '113px';
	yearPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
	yearPicker.style.width = '35px';
	yearPicker.id = 'yearDropDown';
	calendarDiv.appendChild(yearPicker);


	var img = document.createElement('IMG');
	img.src = pathToImages + 'close.gif';
	img.style.styleFloat = 'right';
	img.onmouseover = highlightClose;
	img.onmouseout = highlightClose;
	img.onclick = closeCalendar;
	topBar.appendChild(img);
	if(!document.all){
		img.style.position = 'absolute';
		img.style.right = '2px';
	}



}

function writeCalendarContent()
{
	var calendarContentDivExists = true;
	if(!calendarContentDiv){
		calendarContentDiv = document.createElement('DIV');
		calendarDiv.appendChild(calendarContentDiv);
		calendarContentDivExists = false;
	}
	currentMonth = currentMonth/1;
	var d = new Date();

	d.setFullYear(currentYear);
	d.setDate(1);
	d.setMonth(currentMonth);

	var dayStartOfMonth = d.getDay();
	if (! weekStartsOnSunday) {
      if(dayStartOfMonth==0)dayStartOfMonth=7;
      dayStartOfMonth--;
   }
    currentHour = d.getHours().toString();
    currentMinute = d.getMinutes().toString();
	if(currentHour.substr(0,1) == 0) {
		currentHour = currentHour.substr(1);
	}
	if(currentMinute.substr(0,1) == 0) {
		currentMinute = currentMinute.substr(1);
	}
	document.getElementById('calendar_year_txt').innerHTML = currentYear;
	document.getElementById('calendar_month_txt').innerHTML = monthArray[currentMonth];
	document.getElementById('calendar_hour_txt').innerHTML = currentHour/1 > 9 ? currentHour : '0' + currentHour;
	document.getElementById('calendar_minute_txt').innerHTML = currentMinute/1 >9 ? currentMinute : '0' + currentMinute;

	var existingTable = calendarContentDiv.getElementsByTagName('TABLE');
	if(existingTable.length>0){
		calendarContentDiv.removeChild(existingTable[0]);
	}

	var calTable = document.createElement('TABLE');
	calTable.width = '100%';
	calTable.cellSpacing = '0';
	calendarContentDiv.appendChild(calTable);




	var calTBody = document.createElement('TBODY');
	calTable.appendChild(calTBody);
	var row = calTBody.insertRow(-1);
	row.className = 'calendar_week_row';
   if (showWeekNumber) {
      var cell = row.insertCell(-1);
	   cell.innerHTML = weekString;
	   cell.className = 'calendar_week_column';
	   //cell.style.backgroundColor = selectBoxRolloverBgColor;
	}

	for(var no=0;no<dayArray.length;no++){
		var cell = row.insertCell(-1);
		cell.innerHTML = dayArray[no];
	}

	var row = calTBody.insertRow(-1);

   if (showWeekNumber) {
	   var cell = row.insertCell(-1);
	   cell.className = 'calendar_week_column';
	   //cell.style.backgroundColor = selectBoxRolloverBgColor;
	   var week = getWeek(currentYear,currentMonth,1);
	   cell.innerHTML = week;		// Week
	}
	for(var no=0;no<dayStartOfMonth;no++){
		var cell = row.insertCell(-1);
		cell.innerHTML = '&nbsp;';
	}

	var colCounter = dayStartOfMonth;
	var daysInMonth = daysInMonthArray[currentMonth];
	if(daysInMonth==28){
		if(isLeapYear(currentYear))daysInMonth=29;
	}

	for(var no=1;no<=daysInMonth;no++){
		d.setDate(no-1);
		if(colCounter>0 && colCounter%7==0){
			var row = calTBody.insertRow(-1);
         if (showWeekNumber) {
            var cell = row.insertCell(-1);
            cell.className = 'calendar_week_column';
            var week = getWeek(currentYear,currentMonth,no);
            cell.innerHTML = week;		// Week
            cell.style.backgroundColor = selectBoxRolloverBgColor;
         }
		}
		var cell = row.insertCell(-1);
		if(currentYear==inputYear && currentMonth == inputMonth && no==inputDay){
			cell.className='activeDay';
		}
		cell.innerHTML = no;
		cell.onclick = pickDate;
		colCounter++;
	}


	if(!document.all){
		if(calendarContentDiv.offsetHeight)
			document.getElementById('topBar').style.top = calendarContentDiv.offsetHeight + document.getElementById('timeBar').offsetHeight + document.getElementById('topBar').offsetHeight -1 + 'px';
		else{
			document.getElementById('topBar').style.top = '';
			document.getElementById('topBar').style.bottom = '0px';
		}

	}

	if(iframeObj){
		if(!calendarContentDivExists)setTimeout('resizeIframe()',350);else setTimeout('resizeIframe()',10);
	}




}

function resizeIframe()
{
	iframeObj.style.width = calendarDiv.offsetWidth + 'px';
	iframeObj.style.height = calendarDiv.offsetHeight + 'px' ;


}

function pickTodaysDate()
{
	var d = new Date();
	currentMonth = d.getMonth();
	currentYear = d.getFullYear();
	pickDate(false,d.getDate());

}

function pickDate(e,inputDay)
{
	var month = currentMonth/1 +1;
	if(month<10)month = '0' + month;
	var day;
	if(!inputDay && this)day = this.innerHTML; else day = inputDay;

	if(day/1<10)day = '0' + day;
	if(returnFormat){
		returnFormat = returnFormat.replace('dd',day);
		returnFormat = returnFormat.replace('mm',month);
		returnFormat = returnFormat.replace('yyyy',currentYear);
		returnFormat = returnFormat.replace('hh',currentHour);
		returnFormat = returnFormat.replace('ii',currentMinute);
		returnFormat = returnFormat.replace('d',day/1);
		returnFormat = returnFormat.replace('m',month/1);

		returnDateTo.value = returnFormat;
		try{
			returnDateTo.onchange();
		}catch(e){

		}
	}else{
		for(var no=0;no<returnDateToYear.options.length;no++){
			if(returnDateToYear.options[no].value==currentYear){
				returnDateToYear.selectedIndex=no;
				break;
			}
		}
		for(var no=0;no<returnDateToMonth.options.length;no++){
			if(returnDateToMonth.options[no].value==parseFloat(month)){
				returnDateToMonth.selectedIndex=no;
				break;
			}
		}
		for(var no=0;no<returnDateToDay.options.length;no++){
			if(returnDateToDay.options[no].value==parseFloat(day)){
				returnDateToDay.selectedIndex=no;
				break;
			}
		}
		if(calendarDisplayTime){
			for(var no=0;no<returnDateToHour.options.length;no++){
				if(returnDateToHour.options[no].value==parseFloat(currentHour)){
					returnDateToHour.selectedIndex=no;
					break;
				}
			}
			for(var no=0;no<returnDateToMinute.options.length;no++){
				if(returnDateToMinute.options[no].value==parseFloat(currentMinute)){
					returnDateToMinute.selectedIndex=no;
					break;
				}
			}
		}
	}
	closeCalendar();

}

// This function is from http://www.codeproject.com/csharp/gregorianwknum.asp
// Only changed the month add
function getWeek(year,month,day){
   if (! weekStartsOnSunday) {
	   day = (day/1);
	} else {
	   day = (day/1)+1;
	}
	year = year /1;
    month = month/1 + 1; //use 1-12
    var a = Math.floor((14-(month))/12);
    var y = year+4800-a;
    var m = (month)+(12*a)-3;
    var jd = day + Math.floor(((153*m)+2)/5) +
                 (365*y) + Math.floor(y/4) - Math.floor(y/100) +
                 Math.floor(y/400) - 32045;      // (gregorian calendar)
    var d4 = (jd+31741-(jd%7))%146097%36524%1461;
    var L = Math.floor(d4/1460);
    var d1 = ((d4-L)%365)+L;
    NumberOfWeek = Math.floor(d1/7) + 1;
    return NumberOfWeek;
}

function writeTimeBar()
{
	var timeBar = document.createElement('DIV');
	timeBar.id = 'timeBar';
	timeBar.className = 'timeBar';

	var subDiv = document.createElement('DIV');
	subDiv.innerHTML = 'Time:';

	// hour selector
	var hourDiv = document.createElement('DIV');
	hourDiv.onmouseover = highlightSelect;
	hourDiv.onmouseout = highlightSelect;
	hourDiv.onclick = showHourDropDown;
	hourDiv.style.width = '30px';
	var span = document.createElement('SPAN');
	span.innerHTML = currentHour;
	span.id = 'calendar_hour_txt';
	hourDiv.appendChild(span);
	timeBar.appendChild(hourDiv);

	var img = document.createElement('IMG');
	img.src = pathToImages + 'down_time.gif';
	hourDiv.appendChild(img);
	hourDiv.className = 'selectBoxTime';

	if(Opera){
		hourDiv.style.width = '30px';
		img.style.cssText = 'float:right';
		img.style.position = 'relative';
		img.style.styleFloat = 'right';
	}

	var hourPicker = createHourDiv();
	hourPicker.style.left = '130px';
	//hourPicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
	hourPicker.style.width = '35px';
	hourPicker.id = 'hourDropDown';
	calendarDiv.appendChild(hourPicker);

	// Add Minute picker

	// Year selector
	var minuteDiv = document.createElement('DIV');
	minuteDiv.onmouseover = highlightSelect;
	minuteDiv.onmouseout = highlightSelect;
	minuteDiv.onclick = showMinuteDropDown;
	minuteDiv.style.width = '30px';
	var span = document.createElement('SPAN');
	span.innerHTML = currentMinute;

	span.id = 'calendar_minute_txt';
	minuteDiv.appendChild(span);
	timeBar.appendChild(minuteDiv);

	var img = document.createElement('IMG');
	img.src = pathToImages + 'down_time.gif';
	minuteDiv.appendChild(img);
	minuteDiv.className = 'selectBoxTime';

	if(Opera){
		minuteDiv.style.width = '30px';
		img.style.cssText = 'float:right';
		img.style.position = 'relative';
		img.style.styleFloat = 'right';
	}

	var minutePicker = createMinuteDiv();
	minutePicker.style.left = '167px';
	//minutePicker.style.top = monthDiv.offsetTop + monthDiv.offsetHeight + 1 + 'px';
	minutePicker.style.width = '35px';
	minutePicker.id = 'minuteDropDown';
	calendarDiv.appendChild(minutePicker);


	return timeBar;

}

function writeBottomBar()
{
	var d = new Date();
	var bottomBar = document.createElement('DIV');

	bottomBar.id = 'bottomBar';

	bottomBar.style.cursor = 'pointer';
	bottomBar.className = 'todaysDate';
	// var todayStringFormat = '[todayString] [dayString] [day] [monthString] [year]';	;;

	var subDiv = document.createElement('DIV');
	subDiv.onclick = pickTodaysDate;
	subDiv.id = 'todaysDateString';
	subDiv.style.width = (calendarDiv.offsetWidth - 95) + 'px';
	var day = d.getDay();
	if (! weekStartsOnSunday) {
      if(day==0)day = 7;
      day--;
   }

	var bottomString = todayStringFormat;
	bottomString = bottomString.replace('[monthString]',monthArrayShort[d.getMonth()]);
	bottomString = bottomString.replace('[day]',d.getDate());
	bottomString = bottomString.replace('[year]',d.getFullYear());
	bottomString = bottomString.replace('[dayString]',dayArray[day]);
	bottomString = bottomString.replace('[UCFdayString]',dayArray[day]);
	bottomString = bottomString.replace('[todayString]',todayString);


	subDiv.innerHTML = todayString + ': ' + d.getDate() + '. ' + monthArrayShort[d.getMonth()] + ', ' +  d.getFullYear() ;
	subDiv.innerHTML = bottomString ;
	bottomBar.appendChild(subDiv);

	var timeDiv = writeTimeBar();
	bottomBar.appendChild(timeDiv);

	calendarDiv.appendChild(bottomBar);



}
function getTopPos(inputObj)
{

  var returnValue = inputObj.offsetTop + inputObj.offsetHeight;
  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetTop;
  return returnValue + calendar_offsetTop;
}

function getleftPos(inputObj)
{
  var returnValue = inputObj.offsetLeft;
  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft;
  return returnValue + calendar_offsetLeft;
}

function positionCalendar(inputObj)
{
	calendarDiv.style.left = getleftPos(inputObj) + 'px';
	calendarDiv.style.top = getTopPos(inputObj) + 'px';
	if(iframeObj){
		iframeObj.style.left = calendarDiv.style.left;
		iframeObj.style.top =  calendarDiv.style.top;
		//// fix for EI frame problem on time dropdowns 09/30/2006
		iframeObj2.style.left = calendarDiv.style.left;
		iframeObj2.style.top =  calendarDiv.style.top;
	}

}

function initCalendar()
{
	if(MSIE){
		iframeObj = $("<iframe style='z-index:999999'></iframe>").appendTo(document.body);
		iframeObj.css('filter','alpha(opacity=0)');
		iframeObj.css('position','absolute'); 
		iframeObj.attr('border','0');
		iframeObj.css('border','0px'); 
		iframeObj.css('backgroundColor','#FF0000'); 
		//// fix for EI frame problem on time dropdowns 09/30/2006
		iframeObj2 = $("<iframe style='z-index:999999'></iframe>").appendTo(document.body);
		iframeObj2.css('position','absolute'); 
		iframeObj2.css('border','0px'); 
		iframeObj2.attr('border','0');
		iframeObj2.css('height','1px'); 
		iframeObj2.css('width','1px'); 

		//// fix for EI frame problem on time dropdowns 09/30/2006
		// Added fixed for HTTPS
		iframeObj2.attr("src","blank.html");
		iframeObj.attr("src","blank.html");;
	}

	calendarDiv = $("<div/>").appendTo(document.body);
	calendarDiv.attr('id','calendarDiv');
	calendarDiv.css('zIndex','1000');
	slideCalendarSelectBox();

	writeBottomBar();
	writeTopBar();



	if(!currentYear){
		var d = new Date();
		currentMonth = d.getMonth();
		currentYear = d.getFullYear();
	}
	writeCalendarContent();



}

function setTimeProperties()
{
	if(!calendarDisplayTime){
		document.getElementById('timeBar').style.display='none';
		document.getElementById('timeBar').style.visibility='hidden';
		document.getElementById('todaysDateString').style.width = '100%';


	}else{
		document.getElementById('timeBar').style.display='block';
		document.getElementById('timeBar').style.visibility='visible';
		document.getElementById('hourDropDown').style.top = document.getElementById('calendar_minute_txt').parentNode.offsetHeight + calendarContentDiv.offsetHeight + document.getElementById('topBar').offsetHeight + 'px';
		document.getElementById('minuteDropDown').style.top = document.getElementById('calendar_minute_txt').parentNode.offsetHeight + calendarContentDiv.offsetHeight + document.getElementById('topBar').offsetHeight + 'px';
		document.getElementById('minuteDropDown').style.right = '50px';
		document.getElementById('hourDropDown').style.right = '50px';
		document.getElementById('todaysDateString').style.width = '115px';
	}
}

function calendarSortItems(a,b)
{
	return a/1 - b/1;
}


function displayCalendar_old(inputFieldID,buttonObj,displayTime,timeInput)
{	
    var format = "yyyy-mm-dd";
	if(displayTime) {
		calendarDisplayTime=true;
		format = format + " hh:ii"

	} else { 
		calendarDisplayTime = false;
	}
	var inputField = $("#"+inputFieldID);
	
	if(inputField.val().length>6){ //dates must have at least 6 digits...
       if(!inputField.val().match(/^[0-9]*?$/gi)){
       	
			var items = inputField.val().split(/[^0-9]/gi);
			var positionArray = new Object();
			positionArray.m = format.indexOf('mm');
			if(positionArray.m==-1)positionArray.m = format.indexOf('m');
			positionArray.d = format.indexOf('dd');
			if(positionArray.d==-1)positionArray.d = format.indexOf('d');
			positionArray.y = format.indexOf('yyyy');
			positionArray.h = format.indexOf('hh');
			positionArray.i = format.indexOf('ii');
			
			this.initialHour = '00';
			this.initialMinute = '00';				
			var elements = ['y','m','d','h','i'];
			var properties = ['currentYear','currentMonth','inputDay','currentHour','currentMinute'];
			var propertyLength = [4,2,2,2,2];
			for(var i=0;i<elements.length;i++) {
				if(positionArray[elements[i]]>=0) {
					window[properties[i]] = inputField.val().substr(positionArray[elements[i]],propertyLength[i])/1;
				}					
			}			
			currentMonth--;
		}else{
			var monthPos = format.indexOf('mm');
			currentMonth = inputField.val().substr(monthPos,2)/1 -1;
			var yearPos = format.indexOf('yyyy');
			currentYear = inputField.val().substr(yearPos,4);
			var dayPos = format.indexOf('dd');
			tmpDay = inputField.val().substr(dayPos,2);

			var hourPos = format.indexOf('hh');
			if(hourPos>=0){
				tmpHour = inputField.val().substr(hourPos,2);
				currentHour = tmpHour;
				if(currentHour.length==1) currentHour = '0'
			}else{
				currentHour = '00';
			}
			var minutePos = format.indexOf('ii');
			if(minutePos>=0){
				tmpMinute = inputField.val().substr(minutePos,2);
				currentMinute = tmpMinute;
			}else{
				currentMinute = '00';
			}
		}
	}else{
		var d = new Date();
		currentMonth = d.getMonth();
		currentYear = d.getFullYear();
		currentHour = '08';
		currentMinute = '00';
		inputDay = d.getDate()/1;
	}

	inputYear = currentYear;
	inputMonth = currentMonth;
	if(!calendarDiv){
		initCalendar();
	}else{
		if(calendarDiv.css('display') =='block'){
			closeCalendar();
			return false;
		}
		writeCalendarContent();
	}



	returnFormat = format;
	returnDateTo = inputField;
	positionCalendar(buttonObj);
	calendarDiv.css('visibility','visible');
	calendarDiv.css('display','block');
	if(iframeObj){
		iframeObj.css('display','');
		iframeObj.css('height','140px');
		iframeObj.css('width','195px');
		iframeObj2.css('display','');
		iframeObj2.css('height','140px');
		iframeObj2.css('width','195px');
	}

	setTimeProperties();
	updateYearDiv();
	updateMonthDiv();
	updateMinuteDiv();
	updateHourDiv();

}

function displayCalendarSelectBox(yearInput,monthInput,dayInput,hourInput,minuteInput,buttonObj)
{
	if(!hourInput)calendarDisplayTime=false; else calendarDisplayTime = true;

	currentMonth = monthInput.options[monthInput.selectedIndex].value/1-1;
	currentYear = yearInput.options[yearInput.selectedIndex].value;
	if(hourInput){
		currentHour = hourInput.options[hourInput.selectedIndex].value;
		inputHour = currentHour/1;
	}
	if(minuteInput){
		currentMinute = minuteInput.options[minuteInput.selectedIndex].value;
		inputMinute = currentMinute/1;
	}

	inputYear = yearInput.options[yearInput.selectedIndex].value;
	inputMonth = monthInput.options[monthInput.selectedIndex].value/1 - 1;
	inputDay = dayInput.options[dayInput.selectedIndex].value/1;

	if(!calendarDiv){
		initCalendar();
	}else{
		writeCalendarContent();
	}



	returnDateToYear = yearInput;
	returnDateToMonth = monthInput;
	returnDateToDay = dayInput;
	returnDateToHour = hourInput;
	returnDateToMinute = minuteInput;




	returnFormat = false;
	returnDateTo = false;
	positionCalendar(buttonObj);
	calendarDiv.style.visibility = 'visible';
	calendarDiv.style.display = 'block';
	if(iframeObj){
		iframeObj.style.display = '';
		iframeObj.style.height = calendarDiv.offsetHeight + 'px';
		iframeObj.style.width = calendarDiv.offsetWidth + 'px';
		//// fix for EI frame problem on time dropdowns 09/30/2006
		iframeObj2.style.display = '';
		iframeObj2.style.height = calendarDiv.offsetHeight + 'px';
		iframeObj2.style.width = calendarDiv.offsetWidth + 'px'
	}
	setTimeProperties();
	updateYearDiv();
	updateMonthDiv();
	updateHourDiv();
	updateMinuteDiv();

}
function goback(){
	var t = confirm("确认取消?");
	if(t){
		window.history.back();
	}else{
		return false;
	}
}


function openAdvanceDialogs_old(module){
var winsa = null;
if(!winsa){
	winsa = new Window({maximizable:false,minimizable:false,className:"mac_os_x", title:"高级搜索",width:"600px",height:"360px",destroyOnClose: false, recenterAuto:false});
}
var options={
              method: 'post',
              asynchronous:false,
              postBody:"module=Relsettings&action=RelsettingsAjax&file=AdvanceSearch&modulename="+module
            };
    
winsa.setAjaxContent("index.php", options, true, false);
if(!winsa.isMinimized()&&!winsa.isMaximized()){
new PeriodicalExecuter(function(pe) {
var width=600;
var height=360;
if(width!=0&&height!=0){
	if(Prototype.Browser.IE){
		height=height+23;
	}else{
		height=height+10;
	}
	if(width<600) width=600;
	winsa.setSize(width, height);
	pe.stop();
}

}, 0.5);
}
}
function openAdvanceDialogs(module){
	$("#status").prop("display","inline");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module=Relsettings&action=RelsettingsAjax&file=AdvanceSearch&modulename="+module,
		   success: function(msg){   
		   	 $("#status").prop("display","none");
		   	 $("#gaojisearch").html(msg); 
		   }  
	}); 
	$('#gaojisearch').modal('show');
}
function showhide()
{
	if(winsa){
            var x = $(winsa.getId()).style;
            if(x.display == "block")
            {
                    x.display = "none";
            }
            else
            {
                    x.display = "block";
            }
        }
}

function winhide(){
    Windows.close(winsa.getId());
    //wins.destroy();
}


/***********************************
calendar end on 2011-12-05
*/




function displayCalendar(inputFieldID,buttonObj,displayTime,timeInput){ //alert(inputFieldID);
	$('#'+inputFieldID).datepicker();
}

function BrowerAcct(popuptype){

	$("#status").prop("display","inline");
	$.ajax({  
		   type: "GET",  
		   //dataType:"Text",   
		   url:"index.php?module=Accounts&action=Popup&popuptype="+popuptype+"&select=enable",
		   success: function(msg){   
		   	 $("#status").prop("display","none");
		   	 $("#searchallacct").html(msg); 
		   }  
	}); 
	$('#searchallacct').modal('show');
}

//added by ligangze 2013-08-13
function SearchSmownerUser(objid,sectuserid,obj){
	var searchtext = obj.value;
	if($("#"+objid+"_bind_div") && $("#"+objid+"_bind_div").html() != ''){
		var rest = $("#"+objid+"_bind_div").html();
		var userObj = eval('('+ rest +')')?eval('('+ rest +')'):JSON.parse(rest);
		var resulthtml = '';var grouphtml = '';var userhtml = '';var color = '';
		for(var groupid in userObj){
			if(groupid > 0){
				grouphtml = '<div class="smowner-group-div" onclick="displaysmowner_click('+groupid+')"'+
										'>'+userObj[groupid].groupname.value+'</div>';
				var userArr = userObj[groupid].user;
				userhtml = '';
				for(var userid in userArr){
					var lastname = userArr[userid].lastname.value;
					var username = userArr[userid].username.value;
					var prefix = userArr[userid].prefix.value;
					color = '';
					if(sectuserid == userid){
						color = '#32A636';
					}
					if(lastname.indexOf(searchtext) >= 0 || username.indexOf(searchtext) >= 0 || prefix.indexOf(searchtext) >= 0){
						var groupcss = "smowner-group-"+groupid;
						userhtml += '<div class="smowner-user-div '+groupcss+'" onmouseover="this.className=\'smowner-user-over '+groupcss+'\';" '+
								'onmouseout="this.className=\'smowner-user-div '+groupcss+'\'" '+
								'onclick="setsmownerid_click(\''+objid+'\',\''+userid+'\',\''+lastname+'\',\''+username+'\');"'+
								'style="color:'+color+'">'+lastname+'</div>';
					}
				}
				if(userhtml && userhtml != ''){
					resulthtml += grouphtml + userhtml;
				}
			}
		}
		$("#"+objid+"_info_div").html(resulthtml);
	}
}

function ShowSeltUser_click(objid){
	if($("#"+objid+"_div").css("display") == 'none'){
		//show(""+objid+"_div");
		$("#"+objid+"_div").css("display","inline");
	}else{
		$("#"+objid+"_div").css("display",'none');
	}
}

/**
 * 初始化负责人弹出层
 */
function setSmownerUserOpts(objid,sectuserid){
	$.ajax({
		url: "index.php",
		data: "module=Users&action=UsersAjax&file=setSmownerUserOpts",
		success:function(rest){
			var resulthtml = '';
			if(rest != ''){
				$("#"+objid+"_bind_div").html(rest);
				var userObj = eval('('+ rest +')')?eval('('+ rest +')'):JSON.parse(rest);
				var color = '';
				var userArr = userObj.user;
				//alert(userArr);
				for(var userid in userArr){
					var lastname = userArr[userid].lastname.value;
					var username = userArr[userid].username.value;
					var prefix = userArr[userid].prefix.value;
					color = '';
					if(sectuserid == userid){
						color = '#32A636';
					}
					
					//resulthtml += '<div onclick="setsmownerid_click(\''+objid+'\',\''+userid+'\',\''+lastname+'\',\''+username+'\');" style="color:'+color+'">'+lastname+'</div>';
					resulthtml +='<li><a onclick="setsmownerid_click(\''+objid+'\',\''+userid+'\',\''+lastname+'\',\''+username+'\')">'+lastname+'</a></li>';
				}
			}
			$("#"+objid+"_info_div").html(resulthtml);
		},error:function(){
			alert('Null');
		}
	});
}
function setsmownerid_click(objid,userid,lastname,username){
	$("#"+objid+"_name").val(lastname);
	$("#"+objid+"").val(userid);
	$("#"+objid+"_div").css("display",'none');
	//回调
	if(window.smownerchangebind != undefined) {
		window.smownerchangebind(objid,userid,lastname,username);
	}
}

/***********	查看范围		**********/
function setViewScopeOpts(modulename,objid,sectuserid){
	var viewname=$("viewname").value;
	$.ajax({
		url: "index.php",
		data: "module=Users&action=UsersAjax&file=setViewScopeOpts&modulename="+modulename+"",
		success:function(rest){
			var resulthtml = '';
			if(rest != ''){
				$("#"+objid+"_bind_div").html(rest);
				var userProj = eval('('+ rest +')')?eval('('+ rest +')'):JSON.parse(rest);
				var color = '';
				var scopreObj = userProj.scopre;
				if(sectuserid == 'all_to_me'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'all_to_me\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.all_to_me.value+'</div>';
				color = '';
				if(sectuserid == 'current_user'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'current_user\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.current_user.value+'</div>';
				color = '';
				if(sectuserid == 'sub_user'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'sub_user\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.sub_user.value+'</div>';
				var userObj = userProj.group;
				for(var groupid in userObj){
					if(groupid > 0){
						resulthtml += '<div class="smowner-group-div" onclick="displaysmowner_click('+groupid+')"'+
										'>'+userObj[groupid].groupname.value+'</div>';
						var userArr = userObj[groupid].user;
						for(var userid in userArr){
							var lastname = userArr[userid].lastname.value;
							var username = userArr[userid].username.value;
							var prefix = userArr[userid].prefix.value;
							color = '';
							if(sectuserid == userid){
								color = '#32A636';
							}
							var groupcss = "smowner-group-"+groupid;
							resulthtml += '<div class="smowner-user-div '+groupcss+'" onmouseover="this.className=\'smowner-user-over '+groupcss+'\';" '+
											'onmouseout="this.className=\'smowner-user-div '+groupcss+'\'" '+
											'onclick="setViewScopeinfo_click(\''+objid+'\',\''+userid+'\',\''+viewname+'\',\''+modulename+'\');"'+
											'style="color:'+color+'">'+lastname+'</div>';
						}
					}
				}
				color = '';
				if(sectuserid == 'creator'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'creator\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.creator.value+'</div>';
				color = '';
				if(sectuserid == 'subcreator'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'subcreator\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.subcreator.value+'</div>';
				color = '';
				if(sectuserid == 'share_to_me'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'share_to_me\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.share_to_me.value+'</div>';
				color = '';
				if(sectuserid == 'share_of_me'){
					color = '#32A636';
				}
				resulthtml += '<div class="smowner-scope-div" onmouseover="this.className=\'smowner-scope-over\';" '+
									'onmouseout="this.className=\'smowner-scope-div\'" '+
									'onclick="setViewScopeinfo_click(\''+objid+'\',\'share_of_me\','+
									'\''+viewname+'\',\''+modulename+'\');"'+
									'style="color:'+color+'">'+scopreObj.share_of_me.value+'</div>';
			}
			$("#"+objid+"_info_div").html(resulthtml);
		},error:function(){
			alert('Null');
		}
	});
}