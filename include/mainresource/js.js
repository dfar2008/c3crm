//检测浏览器版本信息 
window["MzBrowser"]={};(function()   
{   
if(MzBrowser.platform) return;   
var ua = window.navigator.userAgent;   
MzBrowser.platform = window.navigator.platform;    
MzBrowser.firefox = ua.indexOf("Firefox")>0;   
MzBrowser.opera = typeof(window.opera)=="object";   
MzBrowser.ie = !MzBrowser.opera && ua.indexOf("MSIE")>0;   
MzBrowser.mozilla = window.navigator.product == "Gecko";   
MzBrowser.netscape= window.navigator.vendor=="Netscape";   
MzBrowser.safari= ua.indexOf("Safari")>-1;    
if(MzBrowser.firefox) var re = /Firefox(\s|\/)(\d+(\.\d+)?)/;   
else if(MzBrowser.ie) var re = /MSIE( )(\d+(\.\d+)?)/;   
else if(MzBrowser.opera) var re = /Opera(\s|\/)(\d+(\.\d+)?)/;   
else if(MzBrowser.netscape) var re = /Netscape(\s|\/)(\d+(\.\d+)?)/;   
else if(MzBrowser.safari) var re = /Version(\/)(\d+(\.\d+)?)/;   
else if(MzBrowser.mozilla) var re = /rv(\:)(\d+(\.\d+)?)/;
if("undefined"!=typeof(re)&&re.test(ua))   
MzBrowser.version = parseFloat(RegExp.$2);   
})();    
function GetName()
{
	var name = "undefined";
	if(MzBrowser.ie) name = "ie";
	else if(MzBrowser.firefox)  name = "firefox";
	return name;
}

function GetVersion(){return MzBrowser.version;}
function IsIE(versionValue)
{
	var name = GetName();
	var version = GetVersion();
	if(name=='ie' && parseInt(version)==versionValue) return true;
	else return false;
}
function mouseCoords(ev) {
    if (ev.pageX || ev.pageY) {
        return { x: ev.pageX, y: ev.pageY };
    }
    return {
        x: ev.clientX + document.body.scrollLeft - document.body.clientLeft,
        y: ev.clientY + document.body.scrollTop - document.body.clientTop
    };
}
function numberToN(s)
{
	 if(/[^0-9\.\-]/.test(s)) return s;
	 s=s.replace(/^(\d*)$/,"$1.");
	 s=(s+"00").replace(/(\d*\.\d\d)\d*/,"$1");
	 s=s.replace(".",",");
	var re=/(\d)(\d{3},)/;
	while(re.test(s)) s=s.replace(re,"$1,$2");
	s=s.replace(/,(\d\d)$/,".$1");
   return s.replace(/^\./,"0.");
}
//数据验证  
 function IsFloatNumber(obj,isAllowNegative) {IsFloatNumber_Default_IsAllowNegative(obj,0,isAllowNegative);} 
 function IsFloatNumber_Default(obj,defaultValue) {IsFloatNumber_Default_IsAllowNegative(obj,defaultValue,true);}
 function IsFloatNumber_Default_IsAllowNegative(obj, defaultValue, isAllowNegative) {
    if (defaultValue == 0) defaultValue = "0.00";
	var id = jQuery(obj).attr("id");
	var theValue = jQuery(obj).val().trim();
	if(theValue.trim().length==0 || isNaN(theValue)) newAlertAndExcute('无效数据',"$('#"+id+"').val('"+defaultValue+ "');"+"$('#"+id+"').focus();");
	else if(!isAllowNegative && parseFloat(theValue)<0) newAlertAndExcute('无效数据',"$('#"+id+"').val('"+defaultValue+"');"+"$('#"+id+"').focus();");
 }
 function IsIntNumber(obj,isAllowNegative) {IsIntNumber_Default_IsAllowNegative(obj,0,isAllowNegative);} 
 function IsIntNumber_Default(obj,defaultValue){IsIntNumber_Default_IsAllowNegative(obj,defaultValue,true);}
 function IsIntNumber_Default_IsAllowNegative(obj,defaultValue,isAllowNegative) {
    if (defaultValue == 0) defaultValue = "0.00";
	var id = jQuery(obj).attr("id");
	var theValue = jQuery(obj).val().trim();
	if (theValue.trim().length == 0 || isNaN(theValue)) newAlertAndExcute('无效数据', "$('#" + id + "').val('" + defaultValue + "');" + "$('#" + id + "').focus();");
	else if (theValue.indexOf('.') > -1) newAlertAndExcute('无效数据',"$('#"+id+"').val('"+defaultValue+"');"+"$('#"+id+"').focus();");
	else if(!isAllowNegative && parseInt(theValue)<0) newAlertAndExcute('无效数据',"$('#"+id+"').val('"+defaultValue+"');"+"$('#"+id+"').focus();");
 }
//
function BatchAdd(tableName)
{
	var btnSave = $("#btnSave");
	if(btnSave.attr("disabled")==true)
	{
		var info = btnSave.attr("info");
		if(info !=null && info.trim().length>0) newErrorInfo(info);
		else newErrorInfo('不支持当前的操作！');
		return;
	}
	var str = '/Products/SelectPro3.aspx?isMulti=true&tableName=' + tableName;
	if(tableName=="V_ContractProduct") str = '/Products/SelectPro3.aspx?isMulti=true&tableName=V_ContractProduct&mainTableName=V_ContractProduct';
	else if (tableName == "V_Product_BindingDetails") str = '/Products/SelectPro3.aspx?isMulti=true&tableName=V_Product_BindingDetails&mainTableName=V_Product_Binding';
    var returnTableName = GetQueryString("returnTableName");
	if( returnTableName !=null) str+="&mainTableName="+returnTableName;
	if($('#hfClientId').attr("id") !=null && parseInt($('#hfClientId').val())>0 ) str+="&clientId="+$('#hfClientId').val();
	if ($('#hfProviderId').attr("id") != null && parseInt($('#hfProviderId').val()) > 0) str += "&providerId=" + $('#hfProviderId').val();
	str = str + "&isAutoMoneyEqualSumMoney=" + IsAutoMoneyEqualSumMoney().toString();
	OpenWindowsYes_Scroll(str, 920, 640);
}


function GetMainTableCondition_QueryString() {
    var str = "";
    var viewId = GetQueryString("viewId");
    if (viewId != null) str = str + "&viewId=" + viewId;

    var showOnlyOne = GetQueryString("showOnlyOne");
    if (showOnlyOne != null) str = str + "&showOnlyOne=" + showOnlyOne;

    var showOnly_InnerOther = GetQueryString("showOnly_InnerOther");
    if (showOnly_InnerOther != null) str = str + "&showOnly_InnerOther=" + showOnly_InnerOther;

    var isChoose = GetQueryString("isChoose");
    if (isChoose != null) str = str + "&isChoose=true";

    var isFilterNotTui = GetQueryString("isFilterNotTui");
    if (isFilterNotTui != null) str = str + "&isFilterNotTui=true";

    var isFilterStatus = GetQueryString("isFilterStatus");
    if (isFilterStatus != null) str = str + "&isFilterStatus=true";

    var isFilterClient = GetQueryString("isFilterClient");
    if (isFilterClient != null) str = str + "&isFilterClient=" + isFilterClient;

    var isFilterLinkman = GetQueryString("isFilterLinkman");
    if (isFilterLinkman != null) str = str + "&isFilterLinkman=" + isFilterLinkman;

    var isFilterProvider = GetQueryString("isFilterProvider");
    if (isFilterProvider != null) str = str + "&isFilterProvider=" + isFilterProvider;

    var isFilterDate = GetQueryString("isFilterDate");
    if (isFilterDate != null) str = str + "&isFilterDate=" + isFilterDate;

    var isFilterPerson = GetQueryString("isFilterPerson");
    if (isFilterPerson != null) str = str + "&isFilterPerson=" + isFilterPerson;

    var sectionName = GetQueryString("sectionName");
    if (sectionName != null) str = str + "&sectionName=" + escape(sectionName);

	var isFilterImportId = GetQueryString("isFilterImportId"); //按导入ID过滤
    if (isFilterImportId != null) str = str + "&isFilterImportId=" + isFilterImportId;
		
    var pId = GetQueryString("pId");
    if (pId != null) str = str + "&pId=" + pId;

    var storeId = GetQueryString("storeId");
    if (storeId != null) str = str + "&storeId=" + storeId;

    var classId = GetQueryString("classId");
    if (classId != null) str = str + "&classId=" + classId;

    var searchFieldList = GetQueryString("searchFieldList");
    var searchValue = GetQueryString("searchValue");
    if (searchFieldList != null && searchValue != null && searchValue.trim().length > 0) {
        str = str + "&init_searchFieldList=" + searchFieldList + "&init_searchValue="+searchValue;
    }
    return str;
}

function CloseWindowOp(isMainOp) {
    if (GetQueryString("isFromNavigation") != null) { history.go(-1); return; }
    else if (GetQueryString("isFromClient") != null) { history.go(-1); return; }
    if (window.opener != null) { window.close(); return; }
    var returnTableName = GetQueryString("returnTableName");
    var isOpenNew = GetQueryString("isOpenNew");
    var url = "";
    if (isOpenNew == null) {
        if (returnTableName == null) { history.go(-1); return; }
        else {
            url = '/Sales/ListView.aspx?tableName=' + returnTableName;
            url += GetMainTableCondition_QueryString();
            location = url;
        }
    }
    else window.close();
}
var isMainOp = true;
function SaveWindowOp(mainOpFlag) {
	isMainOp = mainOpFlag;//保存临时值
	if (window.parent) window.parent.ymPrompt.succeedInfo({ message: '操作成功！', handler: handler_Success });
	else ymPrompt.succeedInfo({ message: '操作成功！', handler: handler_Success });
}
function handler_Success(tp)
{
	var returnTableName = GetQueryString("returnTableName");
	var isOpenNew = GetQueryString("isOpenNew");
	var isTheTabItem = GetQueryString("isTheTabItem");
	if (isTheTabItem == 'true') isMainOp = false;
	var url = "";
	if (isOpenNew == null) {
	    url = '/Sales/ListView.aspx?tableName=' + returnTableName;
	    url += GetMainTableCondition_QueryString();
	    location = url;
	}
	else {
	    try {
	        if (isMainOp) opener.onSubmitPage();
	        else opener.onSubmitPage_Details();
	    }
	    catch (ex) { }
	    window.close();
	}
}
function Import(fromName,toName,isClient)
{
	var btnSave = $("#btnSave");
	if(btnSave.attr("disabled")==true)
	{
		var info = btnSave.attr("info");
		if(info !=null && info.trim().length>0) newErrorInfo(info);
		else newErrorInfo('不支持当前的操作！');
		return;
	}
	if(isClient)
	{
		var hfClientId=$("#hfClientId");
		if(parseInt(hfClientId.val())==0){newAlert('请选择客户！');return ;}
		var theUrl = '/Sales/ListView.aspx?tableName='+fromName+'&isFilterStatus=true&isChoose=true&isTo='+toName+'&isFilterClient='+hfClientId.val();
		if(fromName=='V_Data_Order' && toName=="V_Data_Sales") theUrl +="&isFilterNotTui=true";
		else if(fromName=='V_Purchase_Order' && toName=="V_Purchase_Stock") theUrl +="&isFilterNotTui=true";
		else if(fromName=='V_Data_Sales' && toName=="V_Data_UnSales") theUrl +="&isFilterNotTui=true";
		else if(fromName=='V_Purchase_Stock' && toName=="V_Purchase_UnPayment") theUrl +="&isFilterNotTui=true";
		OpenWindowsYes_Scroll(theUrl,800,600);
	}
	else 
	{
		var hfProviderId=$("#hfProviderId");
		if(parseInt(hfProviderId.val())==0){newAlert('请选择供货单位！');return ;}
		OpenWindowsYes_Scroll('/Sales/ListView.aspx?tableName='+fromName+'&isFilterStatus=true&isChoose=true&isTo='+toName+'&isFilterProvider='+hfProviderId.val(),840,500);
	}
}

function AutoSelectDepart(obj)
{            
	var oRequest = $.ajax({
	type: "POST",
	async:false,
	url: "/control/Login/GetDepartId.aspx",
	data: "userId="+jQuery(obj).val()+"&time="+new Date(),
	success:null
	}); 
	var returnTxt=unescape(oRequest.responseText);
	var ddlDepart = $("#ddlDepart");
	ddlDepart.val(returnTxt);
}
function CheckDanExist(obj,sectionId,oldId)
{        
	if(jQuery(obj).val().trim().length==0) return;
	var id = jQuery(obj).attr("id");
	var oRequest = $.ajax({
	type: "POST",
	async:false,
	url: "/control/sys/CheckDanExist.aspx",
	data: "oldId="+oldId+"&sectionId="+sectionId+"&dan="+jQuery(obj).val()+"&time="+new Date(),
	success:null
	});
	var returntxt=unescape(oRequest.responseText);   
	if(returntxt=='True'){newAlertAndExcute('系统已存在指定单号或名称！',"$('#"+id+"').focus();");}     
}  
function OpenWindows(FileName, OpenW, OpenH) {
	var w = (window.screen.availWidth - 27) / 2 - OpenW / 2;
	var h = (window.screen.availHeight - 8) / 2 - OpenH / 2;
	var str = "width=" + OpenW + ",height=" + OpenH + ",top=" + h + ",left=" + w + ",resizable=0,scrollbars=no";
	window.open(FileName, "", str);
}
function OpenWindowsYes(FileName, OpenW, OpenH) {
	var w = (window.screen.availWidth - 27) / 2 - OpenW / 2;
	var h = (window.screen.availHeight - 8) / 2 - OpenH / 2-30;
	var str = "width=" + OpenW + ",height=" + OpenH + ",top=" + h + ",left=" + w + ",resizable=0,scrollbars=yes";
	window.open(FileName, "", str);
}
function OpenWindowsYes_Scroll(FileName, OpenW, OpenH) {
	var w = (window.screen.availWidth - 27) / 2 - OpenW / 2;
	var h = (window.screen.availHeight - 8) / 2 - OpenH / 2-30;
	var str = "width=" + OpenW + ",height=" + OpenH + ",top=" + h + ",left=" + w + ",resizable=1,scrollbars=yes";
	window.open(FileName, "", str);
}
function OpenChatWindows(FileName, OpenW, OpenH) {
	var w = (window.screen.availWidth - 27) / 2 - OpenW / 2;
	var h = (window.screen.availHeight - 8) / 2 - OpenH / 2;
	var str = "width=" + OpenW + ",height=" + OpenH + ",top=" + h + ",left=" + w + ",resizable=1,scrollbars=no";
	window.open(FileName, "", str);
}
function OpenDialogBOX(FileName, OpenW, OpenH) {
	var str = "edge:raised;scroll:0;status:0;help:0;resizable:1;dialogWidth:" + OpenW + "px;dialogHeight:" + OpenH + "px";
	showModelessDialog(FileName, window, str);
}
function killErrors() {return true;}
window.onerror = killErrors;
function CompareDate(d1, d2) {return ((new Date(d1.replace(/-/g, "\/"))) > (new Date(d2.replace(/-/g, "\/"))));}
String.prototype.trim = function() {return this.replace(/(^\s*)|(\s*$)/g, "");}
function CheckFloat(strTemp) {
	var a = strTemp.match(/^(-?\d+)(\.\d+)?$/);
	if (a == null) return false;
	else return true;
}
function checkFloat(e) {
	var result = true;
	result = (event.keyCode == 9 || event.keyCode == 45 ||
   event.keyCode == 46 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 8 ||
   event.keyCode == 110 || event.keyCode == 190 ||(event.keyCode >= 96 && event.keyCode <= 105) ||
   (event.keyCode >= 48 && event.keyCode <= 57));
	event.returnValue = result;
}
function GetQueryString(str) 
{
	var sValue=location.search.match(new RegExp("[?&]"+str+"=([^&]*)(&?)","i"));
	return sValue?sValue[1]:sValue;
}
function GetQueryString_Opener(str) 
{
	var sValue=opener.location.search.match(new RegExp("[?&]"+str+"=([^&]*)(&?)","i"));
	return sValue?sValue[1]:sValue;
}
function GetQueryString_Parent(str) 
{
	var sValue=parent.location.search.match(new RegExp("[?&]"+str+"=([^&]*)(&?)","i"));
	return sValue?sValue[1]:sValue;
}
function checkisNaN(obj) {
	var k = parseInt(obj.value);
	if (isNaN(k)) {obj.value = 0;return 0;}
	else {obj.value = k;return k;}
}
function formatnumber(value, num) {return parseFloat(value).toFixed(num);}//四舍五入
function FillDropDownList(control, nameAndValueList) {
	var ddl = document.getElementById(control);
	ddl.options.length = 0;
	var arrstr = new Array();
	arrstr = nameAndValueList.split(",");
	for (var i = 0; i < arrstr.length; i++) {
		var subarrstr = new Array();
		subarrstr = arrstr[i].split("|");
		ddl.options.add(new Option(subarrstr[0], subarrstr[1]));
	}
}
function IsEmpty(fData) {return ((fData == null) || (fData.length == 0))}
function IsDigit(fData) {return ((fData >= "0") && (fData <= "9"))}
function IsInteger(fData) {
	if (IsEmpty(fData)) return true;
	if ((isNaN(fData)) || (fData.indexOf(".") != -1) || (fData.indexOf("-") != -1)) return false;
	return true;
}
function IsMobileNum(number){var re=new RegExp(/^(^13\d{8,9}$)|(^15\d{8,9}$)|(^18\d{8,9}$)|(^0\d{10,11}$)/);return re.test(number);}
function IsEmail(strEmail) {return (strEmail.match(/^(.+)@(.+)$/)) !=null;}
function IsPhone(fData) {
	var str;
	var fDatastr = "";
	if (IsEmpty(fData)) return true;
	for (var i = 0; i < fData.length; i++) {
		str = fData.substring(i, i + 1);
		if (str != "(" && str != ")" && str != "（" && str != "）" && str != "+" && str != "-" && str != " ") fDatastr = fDatastr + str;
	}  
	if (isNaN(fDatastr)) return false;
	return true;
}
function IsNumeric(fData) {
	if (IsEmpty(fData)) return true;
	if (isNaN(fData)) return false;
	return true;
}
function GetRole(RoleTemp, userid, Role) {
	if (RoleTemp.length <= 0) return true;
	var tmp = RoleTemp.substring(RoleTemp.indexOf(userid) + 6, RoleTemp.length);
	if (tmp.indexOf("#")>-1) tmp = tmp.substring(0, tmp.indexOf("#"));
	if (tmp.indexOf(Role) > -1) return true; else return false;
}
//移动Div
var x1,y1;
function moveStart(event,name)
{
var offset=$("#"+name).offset();
  x1=event.clientX-offset.left;
  y1=event.clientY-offset.top;
  var witchButton=false;
  if(document.all&&event.button==1){witchButton=true;}
  else{if(event.button==0)witchButton=true;}
  if(witchButton)//按左键,FF是0，IE是1
  {
   $(document).mousemove
   (
	   function(event)
	   {
		$("#"+name).css("left",(event.clientX-x1)+"px"); 
		$("#"+name).css("top",(event.clientY-y1)+"px"); 
	   }
	   
   )
  }  
 $("#"+name).mouseup(function(event){$(document).unbind("mousemove");})
}
function SendEmail(address) {$.ajax({type: "POST",url: "/control/OA/SendEmail.aspx",data: "address="+address+"&openNew=true",success:fnTransactByPost_SendEmail});}
function SendSms(mobileNumber,name)
{
	var condition = "openNew=true";
	if(name.trim().length==0) condition +="&toNumber="+mobileNumber;
	else condition +="toNumber="+name+"["+mobileNumber+"]";
	$.ajax({type: "POST",url: "/control/OA/SendSms.aspx",data: condition,success:fnTransactByPost_SendSms});
}
function fnTransactByPost_SendSms(data) {
if (data == '-1') {newAlert('系统没有找到符合条件的短信帐号，原因可能是：<br/>1、当前没有短信帐号，请先添加！<br/>2、当前用户没有发送短信的权限！<br/>3、短信帐号被禁用，无法发送短信！');}
else eval(data);
}
function fnTransactByPost_SendEmail(data) {eval(data);}
function dothis(tmp){$("#subtitle1"+tmp).toggle();}
//jQuery JavaScript Library v1.3.1
(function(){var l=this,g,y=l.jQuery,p=l.$,o=l.jQuery=l.$=function(E,F){return new o.fn.init(E,F)},D=/^[^<]*(<(.|\s)+>)[^>]*$|^#([\w-]+)$/,f=/^.[^:#\[\.,]*$/;o.fn=o.prototype={init:function(E,H){E=E||document;if(E.nodeType){this[0]=E;this.length=1;this.context=E;return this}if(typeof E==="string"){var G=D.exec(E);if(G&&(G[1]||!H)){if(G[1]){E=o.clean([G[1]],H)}else{var I=document.getElementById(G[3]);if(I&&I.id!=G[3]){return o().find(E)}var F=o(I||[]);F.context=document;F.selector=E;return F}}else{return o(H).find(E)}}else{if(o.isFunction(E)){return o(document).ready(E)}}if(E.selector&&E.context){this.selector=E.selector;this.context=E.context}return this.setArray(o.makeArray(E))},selector:"",jquery:"1.3.1",size:function(){return this.length},get:function(E){return E===g?o.makeArray(this):this[E]},pushStack:function(F,H,E){var G=o(F);G.prevObject=this;G.context=this.context;if(H==="find"){G.selector=this.selector+(this.selector?" ":"")+E}else{if(H){G.selector=this.selector+"."+H+"("+E+")"}}return G},setArray:function(E){this.length=0;Array.prototype.push.apply(this,E);return this},each:function(F,E){return o.each(this,F,E)},index:function(E){return o.inArray(E&&E.jquery?E[0]:E,this)},attr:function(F,H,G){var E=F;if(typeof F==="string"){if(H===g){return this[0]&&o[G||"attr"](this[0],F)}else{E={};E[F]=H}}return this.each(function(I){for(F in E){o.attr(G?this.style:this,F,o.prop(this,E[F],G,I,F))}})},css:function(E,F){if((E=="width"||E=="height")&&parseFloat(F)<0){F=g}return this.attr(E,F,"curCSS")},text:function(F){if(typeof F!=="object"&&F!=null){return this.empty().append((this[0]&&this[0].ownerDocument||document).createTextNode(F))}var E="";o.each(F||this,function(){o.each(this.childNodes,function(){if(this.nodeType!=8){E+=this.nodeType!=1?this.nodeValue:o.fn.text([this])}})});return E},wrapAll:function(E){if(this[0]){var F=o(E,this[0].ownerDocument).clone();if(this[0].parentNode){F.insertBefore(this[0])}F.map(function(){var G=this;while(G.firstChild){G=G.firstChild}return G}).append(this)}return this},wrapInner:function(E){return this.each(function(){o(this).contents().wrapAll(E)})},wrap:function(E){return this.each(function(){o(this).wrapAll(E)})},append:function(){return this.domManip(arguments,true,function(E){if(this.nodeType==1){this.appendChild(E)}})},prepend:function(){return this.domManip(arguments,true,function(E){if(this.nodeType==1){this.insertBefore(E,this.firstChild)}})},before:function(){return this.domManip(arguments,false,function(E){this.parentNode.insertBefore(E,this)})},after:function(){return this.domManip(arguments,false,function(E){this.parentNode.insertBefore(E,this.nextSibling)})},end:function(){return this.prevObject||o([])},push:[].push,find:function(E){if(this.length===1&&!/,/.test(E)){var G=this.pushStack([],"find",E);G.length=0;o.find(E,this[0],G);return G}else{var F=o.map(this,function(H){return o.find(E,H)});return this.pushStack(/[^+>] [^+>]/.test(E)?o.unique(F):F,"find",E)}},clone:function(F){var E=this.map(function(){if(!o.support.noCloneEvent&&!o.isXMLDoc(this)){var I=this.cloneNode(true),H=document.createElement("div");H.appendChild(I);return o.clean([H.innerHTML])[0]}else{return this.cloneNode(true)}});var G=E.find("*").andSelf().each(function(){if(this[h]!==g){this[h]=null}});if(F===true){this.find("*").andSelf().each(function(I){if(this.nodeType==3){return}var H=o.data(this,"events");for(var K in H){for(var J in H[K]){o.event.add(G[I],K,H[K][J],H[K][J].data)}}})}return E},filter:function(E){return this.pushStack(o.isFunction(E)&&o.grep(this,function(G,F){return E.call(G,F)})||o.multiFilter(E,o.grep(this,function(F){return F.nodeType===1})),"filter",E)},closest:function(E){var F=o.expr.match.POS.test(E)?o(E):null;return this.map(function(){var G=this;while(G&&G.ownerDocument){if(F?F.index(G)>-1:o(G).is(E)){return G}G=G.parentNode}})},not:function(E){if(typeof E==="string"){if(f.test(E)){return this.pushStack(o.multiFilter(E,this,true),"not",E)}else{E=o.multiFilter(E,this)}}var F=E.length&&E[E.length-1]!==g&&!E.nodeType;return this.filter(function(){return F?o.inArray(this,E)<0:this!=E})},add:function(E){return this.pushStack(o.unique(o.merge(this.get(),typeof E==="string"?o(E):o.makeArray(E))))},is:function(E){return !!E&&o.multiFilter(E,this).length>0},hasClass:function(E){return !!E&&this.is("."+E)},val:function(K){if(K===g){var E=this[0];if(E){if(o.nodeName(E,"option")){return(E.attributes.value||{}).specified?E.value:E.text}if(o.nodeName(E,"select")){var I=E.selectedIndex,L=[],M=E.options,H=E.type=="select-one";if(I<0){return null}for(var F=H?I:0,J=H?I+1:M.length;F<J;F++){var G=M[F];if(G.selected){K=o(G).val();if(H){return K}L.push(K)}}return L}return(E.value||"").replace(/\r/g,"")}return g}if(typeof K==="number"){K+=""}return this.each(function(){if(this.nodeType!=1){return}if(o.isArray(K)&&/radio|checkbox/.test(this.type)){this.checked=(o.inArray(this.value,K)>=0||o.inArray(this.name,K)>=0)}else{if(o.nodeName(this,"select")){var N=o.makeArray(K);o("option",this).each(function(){this.selected=(o.inArray(this.value,N)>=0||o.inArray(this.text,N)>=0)});if(!N.length){this.selectedIndex=-1}}else{this.value=K}}})},html:function(E){return E===g?(this[0]?this[0].innerHTML:null):this.empty().append(E)},replaceWith:function(E){return this.after(E).remove()},eq:function(E){return this.slice(E,+E+1)},slice:function(){return this.pushStack(Array.prototype.slice.apply(this,arguments),"slice",Array.prototype.slice.call(arguments).join(","))},map:function(E){return this.pushStack(o.map(this,function(G,F){return E.call(G,F,G)}))},andSelf:function(){return this.add(this.prevObject)},domManip:function(K,N,M){if(this[0]){var J=(this[0].ownerDocument||this[0]).createDocumentFragment(),G=o.clean(K,(this[0].ownerDocument||this[0]),J),I=J.firstChild,E=this.length>1?J.cloneNode(true):J;if(I){for(var H=0,F=this.length;H<F;H++){M.call(L(this[H],I),H>0?E.cloneNode(true):J)}}if(G){o.each(G,z)}}return this;function L(O,P){return N&&o.nodeName(O,"table")&&o.nodeName(P,"tr")?(O.getElementsByTagName("tbody")[0]||O.appendChild(O.ownerDocument.createElement("tbody"))):O}}};o.fn.init.prototype=o.fn;function z(E,F){if(F.src){o.ajax({url:F.src,async:false,dataType:"script"})}else{o.globalEval(F.text||F.textContent||F.innerHTML||"")}if(F.parentNode){F.parentNode.removeChild(F)}}function e(){return +new Date}o.extend=o.fn.extend=function(){var J=arguments[0]||{},H=1,I=arguments.length,E=false,G;if(typeof J==="boolean"){E=J;J=arguments[1]||{};H=2}if(typeof J!=="object"&&!o.isFunction(J)){J={}}if(I==H){J=this;--H}for(;H<I;H++){if((G=arguments[H])!=null){for(var F in G){var K=J[F],L=G[F];if(J===L){continue}if(E&&L&&typeof L==="object"&&!L.nodeType){J[F]=o.extend(E,K||(L.length!=null?[]:{}),L)}else{if(L!==g){J[F]=L}}}}}return J};var b=/z-?index|font-?weight|opacity|zoom|line-?height/i,q=document.defaultView||{},s=Object.prototype.toString;o.extend({noConflict:function(E){l.$=p;if(E){l.jQuery=y}return o},isFunction:function(E){return s.call(E)==="[object Function]"},isArray:function(E){return s.call(E)==="[object Array]"},isXMLDoc:function(E){return E.nodeType===9&&E.documentElement.nodeName!=="HTML"||!!E.ownerDocument&&o.isXMLDoc(E.ownerDocument)},globalEval:function(G){G=o.trim(G);if(G){var F=document.getElementsByTagName("head")[0]||document.documentElement,E=document.createElement("script");E.type="text/javascript";if(o.support.scriptEval){E.appendChild(document.createTextNode(G))}else{E.text=G}F.insertBefore(E,F.firstChild);F.removeChild(E)}},nodeName:function(F,E){return F.nodeName&&F.nodeName.toUpperCase()==E.toUpperCase()},each:function(G,K,F){var E,H=0,I=G.length;if(F){if(I===g){for(E in G){if(K.apply(G[E],F)===false){break}}}else{for(;H<I;){if(K.apply(G[H++],F)===false){break}}}}else{if(I===g){for(E in G){if(K.call(G[E],E,G[E])===false){break}}}else{for(var J=G[0];H<I&&K.call(J,H,J)!==false;J=G[++H]){}}}return G},prop:function(H,I,G,F,E){if(o.isFunction(I)){I=I.call(H,F)}return typeof I==="number"&&G=="curCSS"&&!b.test(E)?I+"px":I},className:{add:function(E,F){o.each((F||"").split(/\s+/),function(G,H){if(E.nodeType==1&&!o.className.has(E.className,H)){E.className+=(E.className?" ":"")+H}})},remove:function(E,F){if(E.nodeType==1){E.className=F!==g?o.grep(E.className.split(/\s+/),function(G){return !o.className.has(F,G)}).join(" "):""}},has:function(F,E){return F&&o.inArray(E,(F.className||F).toString().split(/\s+/))>-1}},swap:function(H,G,I){var E={};for(var F in G){E[F]=H.style[F];H.style[F]=G[F]}I.call(H);for(var F in G){H.style[F]=E[F]}},css:function(G,E,I){if(E=="width"||E=="height"){var K,F={position:"absolute",visibility:"hidden",display:"block"},J=E=="width"?["Left","Right"]:["Top","Bottom"];function H(){K=E=="width"?G.offsetWidth:G.offsetHeight;var M=0,L=0;o.each(J,function(){M+=parseFloat(o.curCSS(G,"padding"+this,true))||0;L+=parseFloat(o.curCSS(G,"border"+this+"Width",true))||0});K-=Math.round(M+L)}if(o(G).is(":visible")){H()}else{o.swap(G,F,H)}return Math.max(0,K)}return o.curCSS(G,E,I)},curCSS:function(I,F,G){var L,E=I.style;if(F=="opacity"&&!o.support.opacity){L=o.attr(E,"opacity");return L==""?"1":L}if(F.match(/float/i)){F=w}if(!G&&E&&E[F]){L=E[F]}else{if(q.getComputedStyle){if(F.match(/float/i)){F="float"}F=F.replace(/([A-Z])/g,"-$1").toLowerCase();var M=q.getComputedStyle(I,null);if(M){L=M.getPropertyValue(F)}if(F=="opacity"&&L==""){L="1"}}else{if(I.currentStyle){var J=F.replace(/\-(\w)/g,function(N,O){return O.toUpperCase()});L=I.currentStyle[F]||I.currentStyle[J];if(!/^\d+(px)?$/i.test(L)&&/^\d/.test(L)){var H=E.left,K=I.runtimeStyle.left;I.runtimeStyle.left=I.currentStyle.left;E.left=L||0;L=E.pixelLeft+"px";E.left=H;I.runtimeStyle.left=K}}}}return L},clean:function(F,K,I){K=K||document;if(typeof K.createElement==="undefined"){K=K.ownerDocument||K[0]&&K[0].ownerDocument||document}if(!I&&F.length===1&&typeof F[0]==="string"){var H=/^<(\w+)\s*\/?>$/.exec(F[0]);if(H){return[K.createElement(H[1])]}}var G=[],E=[],L=K.createElement("div");o.each(F,function(P,R){if(typeof R==="number"){R+=""}if(!R){return}if(typeof R==="string"){R=R.replace(/(<(\w+)[^>]*?)\/>/g,function(T,U,S){return S.match(/^(abbr|br|col|img|input|link|meta|param|hr|area|embed)$/i)?T:U+"></"+S+">"});var O=o.trim(R).toLowerCase();var Q=!O.indexOf("<opt")&&[1,"<select multiple='multiple'>","</select>"]||!O.indexOf("<leg")&&[1,"<fieldset>","</fieldset>"]||O.match(/^<(thead|tbody|tfoot|colg|cap)/)&&[1,"<table>","</table>"]||!O.indexOf("<tr")&&[2,"<table><tbody>","</tbody></table>"]||(!O.indexOf("<td")||!O.indexOf("<th"))&&[3,"<table><tbody><tr>","</tr></tbody></table>"]||!O.indexOf("<col")&&[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"]||!o.support.htmlSerialize&&[1,"div<div>","</div>"]||[0,"",""];L.innerHTML=Q[1]+R+Q[2];while(Q[0]--){L=L.lastChild}if(!o.support.tbody){var N=!O.indexOf("<table")&&O.indexOf("<tbody")<0?L.firstChild&&L.firstChild.childNodes:Q[1]=="<table>"&&O.indexOf("<tbody")<0?L.childNodes:[];for(var M=N.length-1;M>=0;--M){if(o.nodeName(N[M],"tbody")&&!N[M].childNodes.length){N[M].parentNode.removeChild(N[M])}}}if(!o.support.leadingWhitespace&&/^\s/.test(R)){L.insertBefore(K.createTextNode(R.match(/^\s*/)[0]),L.firstChild)}R=o.makeArray(L.childNodes)}if(R.nodeType){G.push(R)}else{G=o.merge(G,R)}});if(I){for(var J=0;G[J];J++){if(o.nodeName(G[J],"script")&&(!G[J].type||G[J].type.toLowerCase()==="text/javascript")){E.push(G[J].parentNode?G[J].parentNode.removeChild(G[J]):G[J])}else{if(G[J].nodeType===1){G.splice.apply(G,[J+1,0].concat(o.makeArray(G[J].getElementsByTagName("script"))))}I.appendChild(G[J])}}return E}return G},attr:function(J,G,K){if(!J||J.nodeType==3||J.nodeType==8){return g}var H=!o.isXMLDoc(J),L=K!==g;G=H&&o.props[G]||G;if(J.tagName){var F=/href|src|style/.test(G);if(G=="selected"&&J.parentNode){J.parentNode.selectedIndex}if(G in J&&H&&!F){if(L){if(G=="type"&&o.nodeName(J,"input")&&J.parentNode){throw"type property can't be changed"}J[G]=K}if(o.nodeName(J,"form")&&J.getAttributeNode(G)){return J.getAttributeNode(G).nodeValue}if(G=="tabIndex"){var I=J.getAttributeNode("tabIndex");return I&&I.specified?I.value:J.nodeName.match(/(button|input|object|select|textarea)/i)?0:J.nodeName.match(/^(a|area)$/i)&&J.href?0:g}return J[G]}if(!o.support.style&&H&&G=="style"){return o.attr(J.style,"cssText",K)}if(L){J.setAttribute(G,""+K)}var E=!o.support.hrefNormalized&&H&&F?J.getAttribute(G,2):J.getAttribute(G);return E===null?g:E}if(!o.support.opacity&&G=="opacity"){if(L){J.zoom=1;J.filter=(J.filter||"").replace(/alpha\([^)]*\)/,"")+(parseInt(K)+""=="NaN"?"":"alpha(opacity="+K*100+")")}return J.filter&&J.filter.indexOf("opacity=")>=0?(parseFloat(J.filter.match(/opacity=([^)]*)/)[1])/100)+"":""}G=G.replace(/-([a-z])/ig,function(M,N){return N.toUpperCase()});if(L){J[G]=K}return J[G]},trim:function(E){return(E||"").replace(/^\s+|\s+$/g,"")},makeArray:function(G){var E=[];if(G!=null){var F=G.length;if(F==null||typeof G==="string"||o.isFunction(G)||G.setInterval){E[0]=G}else{while(F){E[--F]=G[F]}}}return E},inArray:function(G,H){for(var E=0,F=H.length;E<F;E++){if(H[E]===G){return E}}return -1},merge:function(H,E){var F=0,G,I=H.length;if(!o.support.getAll){while((G=E[F++])!=null){if(G.nodeType!=8){H[I++]=G}}}else{while((G=E[F++])!=null){H[I++]=G}}return H},unique:function(K){var F=[],E={};try{for(var G=0,H=K.length;G<H;G++){var J=o.data(K[G]);if(!E[J]){E[J]=true;F.push(K[G])}}}catch(I){F=K}return F},grep:function(F,J,E){var G=[];for(var H=0,I=F.length;H<I;H++){if(!E!=!J(F[H],H)){G.push(F[H])}}return G},map:function(E,J){var F=[];for(var G=0,H=E.length;G<H;G++){var I=J(E[G],G);if(I!=null){F[F.length]=I}}return F.concat.apply([],F)}});var C=navigator.userAgent.toLowerCase();o.browser={version:(C.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)||[0,"0"])[1],safari:/webkit/.test(C),opera:/opera/.test(C),msie:/msie/.test(C)&&!/opera/.test(C),mozilla:/mozilla/.test(C)&&!/(compatible|webkit)/.test(C)};o.each({parent:function(E){return E.parentNode},parents:function(E){return o.dir(E,"parentNode")},next:function(E){return o.nth(E,2,"nextSibling")},prev:function(E){return o.nth(E,2,"previousSibling")},nextAll:function(E){return o.dir(E,"nextSibling")},prevAll:function(E){return o.dir(E,"previousSibling")},siblings:function(E){return o.sibling(E.parentNode.firstChild,E)},children:function(E){return o.sibling(E.firstChild)},contents:function(E){return o.nodeName(E,"iframe")?E.contentDocument||E.contentWindow.document:o.makeArray(E.childNodes)}},function(E,F){o.fn[E]=function(G){var H=o.map(this,F);if(G&&typeof G=="string"){H=o.multiFilter(G,H)}return this.pushStack(o.unique(H),E,G)}});o.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(E,F){o.fn[E]=function(){var G=arguments;return this.each(function(){for(var H=0,I=G.length;H<I;H++){o(G[H])[F](this)}})}});o.each({removeAttr:function(E){o.attr(this,E,"");if(this.nodeType==1){this.removeAttribute(E)}},addClass:function(E){o.className.add(this,E)},removeClass:function(E){o.className.remove(this,E)},toggleClass:function(F,E){if(typeof E!=="boolean"){E=!o.className.has(this,F)}o.className[E?"add":"remove"](this,F)},remove:function(E){if(!E||o.filter(E,[this]).length){o("*",this).add([this]).each(function(){o.event.remove(this);o.removeData(this)});if(this.parentNode){this.parentNode.removeChild(this)}}},empty:function(){o(">*",this).remove();while(this.firstChild){this.removeChild(this.firstChild)}}},function(E,F){o.fn[E]=function(){return this.each(F,arguments)}});function j(E,F){return E[0]&&parseInt(o.curCSS(E[0],F,true),10)||0}var h="jQuery"+e(),v=0,A={};o.extend({cache:{},data:function(F,E,G){F=F==l?A:F;var H=F[h];if(!H){H=F[h]=++v}if(E&&!o.cache[H]){o.cache[H]={}}if(G!==g){o.cache[H][E]=G}return E?o.cache[H][E]:H},removeData:function(F,E){F=F==l?A:F;var H=F[h];if(E){if(o.cache[H]){delete o.cache[H][E];E="";for(E in o.cache[H]){break}if(!E){o.removeData(F)}}}else{try{delete F[h]}catch(G){if(F.removeAttribute){F.removeAttribute(h)}}delete o.cache[H]}},queue:function(F,E,H){if(F){E=(E||"fx")+"queue";var G=o.data(F,E);if(!G||o.isArray(H)){G=o.data(F,E,o.makeArray(H))}else{if(H){G.push(H)}}}return G},dequeue:function(H,G){var E=o.queue(H,G),F=E.shift();if(!G||G==="fx"){F=E[0]}if(F!==g){F.call(H)}}});o.fn.extend({data:function(E,G){var H=E.split(".");H[1]=H[1]?"."+H[1]:"";if(G===g){var F=this.triggerHandler("getData"+H[1]+"!",[H[0]]);if(F===g&&this.length){F=o.data(this[0],E)}return F===g&&H[1]?this.data(H[0]):F}else{return this.trigger("setData"+H[1]+"!",[H[0],G]).each(function(){o.data(this,E,G)})}},removeData:function(E){return this.each(function(){o.removeData(this,E)})},queue:function(E,F){if(typeof E!=="string"){F=E;E="fx"}if(F===g){return o.queue(this[0],E)}return this.each(function(){var G=o.queue(this,E,F);if(E=="fx"&&G.length==1){G[0].call(this)}})},dequeue:function(E){return this.each(function(){o.dequeue(this,E)})}});
// Sizzle CSS Selector Engine - v0.9.3
(function(){var Q=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]+['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[]+)+|[>+~])(\s*,\s*)?/g,K=0,G=Object.prototype.toString;var F=function(X,T,aa,ab){aa=aa||[];T=T||document;if(T.nodeType!==1&&T.nodeType!==9){return[]}if(!X||typeof X!=="string"){return aa}var Y=[],V,ae,ah,S,ac,U,W=true;Q.lastIndex=0;while((V=Q.exec(X))!==null){Y.push(V[1]);if(V[2]){U=RegExp.rightContext;break}}if(Y.length>1&&L.exec(X)){if(Y.length===2&&H.relative[Y[0]]){ae=I(Y[0]+Y[1],T)}else{ae=H.relative[Y[0]]?[T]:F(Y.shift(),T);while(Y.length){X=Y.shift();if(H.relative[X]){X+=Y.shift()}ae=I(X,ae)}}}else{var ad=ab?{expr:Y.pop(),set:E(ab)}:F.find(Y.pop(),Y.length===1&&T.parentNode?T.parentNode:T,P(T));ae=F.filter(ad.expr,ad.set);if(Y.length>0){ah=E(ae)}else{W=false}while(Y.length){var ag=Y.pop(),af=ag;if(!H.relative[ag]){ag=""}else{af=Y.pop()}if(af==null){af=T}H.relative[ag](ah,af,P(T))}}if(!ah){ah=ae}if(!ah){throw"Syntax error, unrecognized expression: "+(ag||X)}if(G.call(ah)==="[object Array]"){if(!W){aa.push.apply(aa,ah)}else{if(T.nodeType===1){for(var Z=0;ah[Z]!=null;Z++){if(ah[Z]&&(ah[Z]===true||ah[Z].nodeType===1&&J(T,ah[Z]))){aa.push(ae[Z])}}}else{for(var Z=0;ah[Z]!=null;Z++){if(ah[Z]&&ah[Z].nodeType===1){aa.push(ae[Z])}}}}}else{E(ah,aa)}if(U){F(U,T,aa,ab)}return aa};F.matches=function(S,T){return F(S,null,null,T)};F.find=function(Z,S,aa){var Y,W;if(!Z){return[]}for(var V=0,U=H.order.length;V<U;V++){var X=H.order[V],W;if((W=H.match[X].exec(Z))){var T=RegExp.leftContext;if(T.substr(T.length-1)!=="\\"){W[1]=(W[1]||"").replace(/\\/g,"");Y=H.find[X](W,S,aa);if(Y!=null){Z=Z.replace(H.match[X],"");break}}}}if(!Y){Y=S.getElementsByTagName("*")}return{set:Y,expr:Z}};F.filter=function(ab,aa,ae,V){var U=ab,ag=[],Y=aa,X,S;while(ab&&aa.length){for(var Z in H.filter){if((X=H.match[Z].exec(ab))!=null){var T=H.filter[Z],af,ad;S=false;if(Y==ag){ag=[]}if(H.preFilter[Z]){X=H.preFilter[Z](X,Y,ae,ag,V);if(!X){S=af=true}else{if(X===true){continue}}}if(X){for(var W=0;(ad=Y[W])!=null;W++){if(ad){af=T(ad,X,W,Y);var ac=V^!!af;if(ae&&af!=null){if(ac){S=true}else{Y[W]=false}}else{if(ac){ag.push(ad);S=true}}}}}if(af!==g){if(!ae){Y=ag}ab=ab.replace(H.match[Z],"");if(!S){return[]}break}}}ab=ab.replace(/\s*,\s*/,"");if(ab==U){if(S==null){throw"Syntax error, unrecognized expression: "+ab}else{break}}U=ab}return Y};var H=F.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,CLASS:/\.((?:[\w\u00c0-\uFFFF_-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF_-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF_-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*_-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF_-]|\\.)+)(?:\((['"]*)((?:\([^\)]+\)|[^\2\(\)]*)+)\2\))?/},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(S){return S.getAttribute("href")}},relative:{"+":function(W,T){for(var U=0,S=W.length;U<S;U++){var V=W[U];if(V){var X=V.previousSibling;while(X&&X.nodeType!==1){X=X.previousSibling}W[U]=typeof T==="string"?X||false:X===T}}if(typeof T==="string"){F.filter(T,W,true)}},">":function(X,T,Y){if(typeof T==="string"&&!/\W/.test(T)){T=Y?T:T.toUpperCase();for(var U=0,S=X.length;U<S;U++){var W=X[U];if(W){var V=W.parentNode;X[U]=V.nodeName===T?V:false}}}else{for(var U=0,S=X.length;U<S;U++){var W=X[U];if(W){X[U]=typeof T==="string"?W.parentNode:W.parentNode===T}}if(typeof T==="string"){F.filter(T,X,true)}}},"":function(V,T,X){var U="done"+(K++),S=R;if(!T.match(/\W/)){var W=T=X?T:T.toUpperCase();S=O}S("parentNode",T,U,V,W,X)},"~":function(V,T,X){var U="done"+(K++),S=R;if(typeof T==="string"&&!T.match(/\W/)){var W=T=X?T:T.toUpperCase();S=O}S("previousSibling",T,U,V,W,X)}},find:{ID:function(T,U,V){if(typeof U.getElementById!=="undefined"&&!V){var S=U.getElementById(T[1]);return S?[S]:[]}},NAME:function(S,T,U){if(typeof T.getElementsByName!=="undefined"&&!U){return T.getElementsByName(S[1])}},TAG:function(S,T){return T.getElementsByTagName(S[1])}},preFilter:{CLASS:function(V,T,U,S,Y){V=" "+V[1].replace(/\\/g,"")+" ";var X;for(var W=0;(X=T[W])!=null;W++){if(X){if(Y^(" "+X.className+" ").indexOf(V)>=0){if(!U){S.push(X)}}else{if(U){T[W]=false}}}}return false},ID:function(S){return S[1].replace(/\\/g,"")},TAG:function(T,S){for(var U=0;S[U]===false;U++){}return S[U]&&P(S[U])?T[1]:T[1].toUpperCase()},CHILD:function(S){if(S[1]=="nth"){var T=/(-?)(\d*)n((?:\+|-)?\d*)/.exec(S[2]=="even"&&"2n"||S[2]=="odd"&&"2n+1"||!/\D/.test(S[2])&&"0n+"+S[2]||S[2]);S[2]=(T[1]+(T[2]||1))-0;S[3]=T[3]-0}S[0]="done"+(K++);return S},ATTR:function(T){var S=T[1].replace(/\\/g,"");if(H.attrMap[S]){T[1]=H.attrMap[S]}if(T[2]==="~="){T[4]=" "+T[4]+" "}return T},PSEUDO:function(W,T,U,S,X){if(W[1]==="not"){if(W[3].match(Q).length>1){W[3]=F(W[3],null,null,T)}else{var V=F.filter(W[3],T,U,true^X);if(!U){S.push.apply(S,V)}return false}}else{if(H.match.POS.test(W[0])){return true}}return W},POS:function(S){S.unshift(true);return S}},filters:{enabled:function(S){return S.disabled===false&&S.type!=="hidden"},disabled:function(S){return S.disabled===true},checked:function(S){return S.checked===true},selected:function(S){S.parentNode.selectedIndex;return S.selected===true},parent:function(S){return !!S.firstChild},empty:function(S){return !S.firstChild},has:function(U,T,S){return !!F(S[3],U).length},header:function(S){return/h\d/i.test(S.nodeName)},text:function(S){return"text"===S.type},radio:function(S){return"radio"===S.type},checkbox:function(S){return"checkbox"===S.type},file:function(S){return"file"===S.type},password:function(S){return"password"===S.type},submit:function(S){return"submit"===S.type},image:function(S){return"image"===S.type},reset:function(S){return"reset"===S.type},button:function(S){return"button"===S.type||S.nodeName.toUpperCase()==="BUTTON"},input:function(S){return/input|select|textarea|button/i.test(S.nodeName)}},setFilters:{first:function(T,S){return S===0},last:function(U,T,S,V){return T===V.length-1},even:function(T,S){return S%2===0},odd:function(T,S){return S%2===1},lt:function(U,T,S){return T<S[3]-0},gt:function(U,T,S){return T>S[3]-0},nth:function(U,T,S){return S[3]-0==T},eq:function(U,T,S){return S[3]-0==T}},filter:{CHILD:function(S,V){var Y=V[1],Z=S.parentNode;var X=V[0];if(Z&&(!Z[X]||!S.nodeIndex)){var W=1;for(var T=Z.firstChild;T;T=T.nextSibling){if(T.nodeType==1){T.nodeIndex=W++}}Z[X]=W-1}if(Y=="first"){return S.nodeIndex==1}else{if(Y=="last"){return S.nodeIndex==Z[X]}else{if(Y=="only"){return Z[X]==1}else{if(Y=="nth"){var ab=false,U=V[2],aa=V[3];if(U==1&&aa==0){return true}if(U==0){if(S.nodeIndex==aa){ab=true}}else{if((S.nodeIndex-aa)%U==0&&(S.nodeIndex-aa)/U>=0){ab=true}}return ab}}}}},PSEUDO:function(Y,U,V,Z){var T=U[1],W=H.filters[T];if(W){return W(Y,V,U,Z)}else{if(T==="contains"){return(Y.textContent||Y.innerText||"").indexOf(U[3])>=0}else{if(T==="not"){var X=U[3];for(var V=0,S=X.length;V<S;V++){if(X[V]===Y){return false}}return true}}}},ID:function(T,S){return T.nodeType===1&&T.getAttribute("id")===S},TAG:function(T,S){return(S==="*"&&T.nodeType===1)||T.nodeName===S},CLASS:function(T,S){return S.test(T.className)},ATTR:function(W,U){var S=H.attrHandle[U[1]]?H.attrHandle[U[1]](W):W[U[1]]||W.getAttribute(U[1]),X=S+"",V=U[2],T=U[4];return S==null?V==="!=":V==="="?X===T:V==="*="?X.indexOf(T)>=0:V==="~="?(" "+X+" ").indexOf(T)>=0:!U[4]?S:V==="!="?X!=T:V==="^="?X.indexOf(T)===0:V==="$="?X.substr(X.length-T.length)===T:V==="|="?X===T||X.substr(0,T.length+1)===T+"-":false},POS:function(W,T,U,X){var S=T[2],V=H.setFilters[S];if(V){return V(W,U,T,X)}}}};var L=H.match.POS;for(var N in H.match){H.match[N]=RegExp(H.match[N].source+/(?![^\[]*\])(?![^\(]*\))/.source)}var E=function(T,S){T=Array.prototype.slice.call(T);if(S){S.push.apply(S,T);return S}return T};try{Array.prototype.slice.call(document.documentElement.childNodes)}catch(M){E=function(W,V){var T=V||[];if(G.call(W)==="[object Array]"){Array.prototype.push.apply(T,W)}else{if(typeof W.length==="number"){for(var U=0,S=W.length;U<S;U++){T.push(W[U])}}else{for(var U=0;W[U];U++){T.push(W[U])}}}return T}}(function(){var T=document.createElement("form"),U="script"+(new Date).getTime();T.innerHTML="<input name='"+U+"'/>";var S=document.documentElement;S.insertBefore(T,S.firstChild);if(!!document.getElementById(U)){H.find.ID=function(W,X,Y){if(typeof X.getElementById!=="undefined"&&!Y){var V=X.getElementById(W[1]);return V?V.id===W[1]||typeof V.getAttributeNode!=="undefined"&&V.getAttributeNode("id").nodeValue===W[1]?[V]:g:[]}};H.filter.ID=function(X,V){var W=typeof X.getAttributeNode!=="undefined"&&X.getAttributeNode("id");return X.nodeType===1&&W&&W.nodeValue===V}}S.removeChild(T)})();(function(){var S=document.createElement("div");S.appendChild(document.createComment(""));if(S.getElementsByTagName("*").length>0){H.find.TAG=function(T,X){var W=X.getElementsByTagName(T[1]);if(T[1]==="*"){var V=[];for(var U=0;W[U];U++){if(W[U].nodeType===1){V.push(W[U])}}W=V}return W}}S.innerHTML="<a href='#'></a>";if(S.firstChild&&S.firstChild.getAttribute("href")!=="#"){H.attrHandle.href=function(T){return T.getAttribute("href",2)}}})();if(document.querySelectorAll){(function(){var S=F,T=document.createElement("div");T.innerHTML="<p class='TEST'></p>";if(T.querySelectorAll&&T.querySelectorAll(".TEST").length===0){return}F=function(X,W,U,V){W=W||document;if(!V&&W.nodeType===9&&!P(W)){try{return E(W.querySelectorAll(X),U)}catch(Y){}}return S(X,W,U,V)};F.find=S.find;F.filter=S.filter;F.selectors=S.selectors;F.matches=S.matches})()}if(document.getElementsByClassName&&document.documentElement.getElementsByClassName){H.order.splice(1,0,"CLASS");H.find.CLASS=function(S,T){return T.getElementsByClassName(S[1])}}function O(T,Z,Y,ac,aa,ab){for(var W=0,U=ac.length;W<U;W++){var S=ac[W];if(S){S=S[T];var X=false;while(S&&S.nodeType){var V=S[Y];if(V){X=ac[V];break}if(S.nodeType===1&&!ab){S[Y]=W}if(S.nodeName===Z){X=S;break}S=S[T]}ac[W]=X}}}function R(T,Y,X,ab,Z,aa){for(var V=0,U=ab.length;V<U;V++){var S=ab[V];if(S){S=S[T];var W=false;while(S&&S.nodeType){if(S[X]){W=ab[S[X]];break}if(S.nodeType===1){if(!aa){S[X]=V}if(typeof Y!=="string"){if(S===Y){W=true;break}}else{if(F.filter(Y,[S]).length>0){W=S;break}}}S=S[T]}ab[V]=W}}}var J=document.compareDocumentPosition?function(T,S){return T.compareDocumentPosition(S)&16}:function(T,S){return T!==S&&(T.contains?T.contains(S):true)};var P=function(S){return S.nodeType===9&&S.documentElement.nodeName!=="HTML"||!!S.ownerDocument&&P(S.ownerDocument)};var I=function(S,Z){var V=[],W="",X,U=Z.nodeType?[Z]:Z;while((X=H.match.PSEUDO.exec(S))){W+=X[0];S=S.replace(H.match.PSEUDO,"")}S=H.relative[S]?S+"*":S;for(var Y=0,T=U.length;Y<T;Y++){F(S,U[Y],V)}return F.filter(W,V)};o.find=F;o.filter=F.filter;o.expr=F.selectors;o.expr[":"]=o.expr.filters;F.selectors.filters.hidden=function(S){return"hidden"===S.type||o.css(S,"display")==="none"||o.css(S,"visibility")==="hidden"};F.selectors.filters.visible=function(S){return"hidden"!==S.type&&o.css(S,"display")!=="none"&&o.css(S,"visibility")!=="hidden"};F.selectors.filters.animated=function(S){return o.grep(o.timers,function(T){return S===T.elem}).length};o.multiFilter=function(U,S,T){if(T){U=":not("+U+")"}return F.matches(U,S)};o.dir=function(U,T){var S=[],V=U[T];while(V&&V!=document){if(V.nodeType==1){S.push(V)}V=V[T]}return S};o.nth=function(W,S,U,V){S=S||1;var T=0;for(;W;W=W[U]){if(W.nodeType==1&&++T==S){break}}return W};o.sibling=function(U,T){var S=[];for(;U;U=U.nextSibling){if(U.nodeType==1&&U!=T){S.push(U)}}return S};return;l.Sizzle=F})();o.event={add:function(I,F,H,K){if(I.nodeType==3||I.nodeType==8){return}if(I.setInterval&&I!=l){I=l}if(!H.guid){H.guid=this.guid++}if(K!==g){var G=H;H=this.proxy(G);H.data=K}var E=o.data(I,"events")||o.data(I,"events",{}),J=o.data(I,"handle")||o.data(I,"handle",function(){return typeof o!=="undefined"&&!o.event.triggered?o.event.handle.apply(arguments.callee.elem,arguments):g});J.elem=I;o.each(F.split(/\s+/),function(M,N){var O=N.split(".");N=O.shift();H.type=O.slice().sort().join(".");var L=E[N];if(o.event.specialAll[N]){o.event.specialAll[N].setup.call(I,K,O)}if(!L){L=E[N]={};if(!o.event.special[N]||o.event.special[N].setup.call(I,K,O)===false){if(I.addEventListener){I.addEventListener(N,J,false)}else{if(I.attachEvent){I.attachEvent("on"+N,J)}}}}L[H.guid]=H;o.event.global[N]=true});I=null},guid:1,global:{},remove:function(K,H,J){if(K.nodeType==3||K.nodeType==8){return}var G=o.data(K,"events"),F,E;if(G){if(H===g||(typeof H==="string"&&H.charAt(0)==".")){for(var I in G){this.remove(K,I+(H||""))}}else{if(H.type){J=H.handler;H=H.type}o.each(H.split(/\s+/),function(M,O){var Q=O.split(".");O=Q.shift();var N=RegExp("(^|\\.)"+Q.slice().sort().join(".*\\.")+"(\\.|$)");if(G[O]){if(J){delete G[O][J.guid]}else{for(var P in G[O]){if(N.test(G[O][P].type)){delete G[O][P]}}}if(o.event.specialAll[O]){o.event.specialAll[O].teardown.call(K,Q)}for(F in G[O]){break}if(!F){if(!o.event.special[O]||o.event.special[O].teardown.call(K,Q)===false){if(K.removeEventListener){K.removeEventListener(O,o.data(K,"handle"),false)}else{if(K.detachEvent){K.detachEvent("on"+O,o.data(K,"handle"))}}}F=null;delete G[O]}}})}for(F in G){break}if(!F){var L=o.data(K,"handle");if(L){L.elem=null}o.removeData(K,"events");o.removeData(K,"handle")}}},trigger:function(I,K,H,E){var G=I.type||I;if(!E){I=typeof I==="object"?I[h]?I:o.extend(o.Event(G),I):o.Event(G);if(G.indexOf("!")>=0){I.type=G=G.slice(0,-1);I.exclusive=true}if(!H){I.stopPropagation();if(this.global[G]){o.each(o.cache,function(){if(this.events&&this.events[G]){o.event.trigger(I,K,this.handle.elem)}})}}if(!H||H.nodeType==3||H.nodeType==8){return g}I.result=g;I.target=H;K=o.makeArray(K);K.unshift(I)}I.currentTarget=H;var J=o.data(H,"handle");if(J){J.apply(H,K)}if((!H[G]||(o.nodeName(H,"a")&&G=="click"))&&H["on"+G]&&H["on"+G].apply(H,K)===false){I.result=false}if(!E&&H[G]&&!I.isDefaultPrevented()&&!(o.nodeName(H,"a")&&G=="click")){this.triggered=true;try{H[G]()}catch(L){}}this.triggered=false;if(!I.isPropagationStopped()){var F=H.parentNode||H.ownerDocument;if(F){o.event.trigger(I,K,F,true)}}},handle:function(K){var J,E;K=arguments[0]=o.event.fix(K||l.event);var L=K.type.split(".");K.type=L.shift();J=!L.length&&!K.exclusive;var I=RegExp("(^|\\.)"+L.slice().sort().join(".*\\.")+"(\\.|$)");E=(o.data(this,"events")||{})[K.type];for(var G in E){var H=E[G];if(J||I.test(H.type)){K.handler=H;K.data=H.data;var F=H.apply(this,arguments);if(F!==g){K.result=F;if(F===false){K.preventDefault();K.stopPropagation()}}if(K.isImmediatePropagationStopped()){break}}}},props:"altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode metaKey newValue originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),fix:function(H){if(H[h]){return H}var F=H;H=o.Event(F);for(var G=this.props.length,J;G;){J=this.props[--G];H[J]=F[J]}if(!H.target){H.target=H.srcElement||document}if(H.target.nodeType==3){H.target=H.target.parentNode}if(!H.relatedTarget&&H.fromElement){H.relatedTarget=H.fromElement==H.target?H.toElement:H.fromElement}if(H.pageX==null&&H.clientX!=null){var I=document.documentElement,E=document.body;H.pageX=H.clientX+(I&&I.scrollLeft||E&&E.scrollLeft||0)-(I.clientLeft||0);H.pageY=H.clientY+(I&&I.scrollTop||E&&E.scrollTop||0)-(I.clientTop||0)}if(!H.which&&((H.charCode||H.charCode===0)?H.charCode:H.keyCode)){H.which=H.charCode||H.keyCode}if(!H.metaKey&&H.ctrlKey){H.metaKey=H.ctrlKey}if(!H.which&&H.button){H.which=(H.button&1?1:(H.button&2?3:(H.button&4?2:0)))}return H},proxy:function(F,E){E=E||function(){return F.apply(this,arguments)};E.guid=F.guid=F.guid||E.guid||this.guid++;return E},special:{ready:{setup:B,teardown:function(){}}},specialAll:{live:{setup:function(E,F){o.event.add(this,F[0],c)},teardown:function(G){if(G.length){var E=0,F=RegExp("(^|\\.)"+G[0]+"(\\.|$)");o.each((o.data(this,"events").live||{}),function(){if(F.test(this.type)){E++}});if(E<1){o.event.remove(this,G[0],c)}}}}}};o.Event=function(E){if(!this.preventDefault){return new o.Event(E)}if(E&&E.type){this.originalEvent=E;this.type=E.type}else{this.type=E}this.timeStamp=e();this[h]=true};function k(){return false}function u(){return true}o.Event.prototype={preventDefault:function(){this.isDefaultPrevented=u;var E=this.originalEvent;if(!E){return}if(E.preventDefault){E.preventDefault()}E.returnValue=false},stopPropagation:function(){this.isPropagationStopped=u;var E=this.originalEvent;if(!E){return}if(E.stopPropagation){E.stopPropagation()}E.cancelBubble=true},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=u;this.stopPropagation()},isDefaultPrevented:k,isPropagationStopped:k,isImmediatePropagationStopped:k};var a=function(F){var E=F.relatedTarget;while(E&&E!=this){try{E=E.parentNode}catch(G){E=this}}if(E!=this){F.type=F.data;o.event.handle.apply(this,arguments)}};o.each({mouseover:"mouseenter",mouseout:"mouseleave"},function(F,E){o.event.special[E]={setup:function(){o.event.add(this,F,a,E)},teardown:function(){o.event.remove(this,F,a)}}});o.fn.extend({bind:function(F,G,E){return F=="unload"?this.one(F,G,E):this.each(function(){o.event.add(this,F,E||G,E&&G)})},one:function(G,H,F){var E=o.event.proxy(F||H,function(I){o(this).unbind(I,E);return(F||H).apply(this,arguments)});return this.each(function(){o.event.add(this,G,E,F&&H)})},unbind:function(F,E){return this.each(function(){o.event.remove(this,F,E)})},trigger:function(E,F){return this.each(function(){o.event.trigger(E,F,this)})},triggerHandler:function(E,G){if(this[0]){var F=o.Event(E);F.preventDefault();F.stopPropagation();o.event.trigger(F,G,this[0]);return F.result}},toggle:function(G){var E=arguments,F=1;while(F<E.length){o.event.proxy(G,E[F++])}return this.click(o.event.proxy(G,function(H){this.lastToggle=(this.lastToggle||0)%F;H.preventDefault();return E[this.lastToggle++].apply(this,arguments)||false}))},hover:function(E,F){return this.mouseenter(E).mouseleave(F)},ready:function(E){B();if(o.isReady){E.call(document,o)}else{o.readyList.push(E)}return this},live:function(G,F){var E=o.event.proxy(F);E.guid+=this.selector+G;o(document).bind(i(G,this.selector),this.selector,E);return this},die:function(F,E){o(document).unbind(i(F,this.selector),E?{guid:E.guid+this.selector+F}:null);return this}});function c(H){var E=RegExp("(^|\\.)"+H.type+"(\\.|$)"),G=true,F=[];o.each(o.data(this,"events").live||[],function(I,J){if(E.test(J.type)){var K=o(H.target).closest(J.data)[0];if(K){F.push({elem:K,fn:J})}}});o.each(F,function(){if(this.fn.call(this.elem,H,this.fn.data)===false){G=false}});return G}function i(F,E){return["live",F,E.replace(/\./g,"`").replace(/ /g,"|")].join(".")}o.extend({isReady:false,readyList:[],ready:function(){if(!o.isReady){o.isReady=true;if(o.readyList){o.each(o.readyList,function(){this.call(document,o)});o.readyList=null}o(document).triggerHandler("ready")}}});var x=false;function B(){if(x){return}x=true;if(document.addEventListener){document.addEventListener("DOMContentLoaded",function(){document.removeEventListener("DOMContentLoaded",arguments.callee,false);o.ready()},false)}else{if(document.attachEvent){document.attachEvent("onreadystatechange",function(){if(document.readyState==="complete"){document.detachEvent("onreadystatechange",arguments.callee);o.ready()}});if(document.documentElement.doScroll&&typeof l.frameElement==="undefined"){(function(){if(o.isReady){return}try{document.documentElement.doScroll("left")}catch(E){setTimeout(arguments.callee,0);return}o.ready()})()}}}o.event.add(l,"load",o.ready)}o.each(("blur,focus,load,resize,scroll,unload,click,dblclick,mousedown,mouseup,mousemove,mouseover,mouseout,mouseenter,mouseleave,change,select,submit,keydown,keypress,keyup,error").split(","),function(F,E){o.fn[E]=function(G){return G?this.bind(E,G):this.trigger(E)}});o(l).bind("unload",function(){for(var E in o.cache){if(E!=1&&o.cache[E].handle){o.event.remove(o.cache[E].handle.elem)}}});(function(){o.support={};var F=document.documentElement,G=document.createElement("script"),K=document.createElement("div"),J="script"+(new Date).getTime();K.style.display="none";K.innerHTML='   <link/><table></table><a href="/a" style="color:red;float:left;opacity:.5;">a</a><select><option>text</option></select><object><param/></object>';var H=K.getElementsByTagName("*"),E=K.getElementsByTagName("a")[0];if(!H||!H.length||!E){return}o.support={leadingWhitespace:K.firstChild.nodeType==3,tbody:!K.getElementsByTagName("tbody").length,objectAll:!!K.getElementsByTagName("object")[0].getElementsByTagName("*").length,htmlSerialize:!!K.getElementsByTagName("link").length,style:/red/.test(E.getAttribute("style")),hrefNormalized:E.getAttribute("href")==="/a",opacity:E.style.opacity==="0.5",cssFloat:!!E.style.cssFloat,scriptEval:false,noCloneEvent:true,boxModel:null};G.type="text/javascript";try{G.appendChild(document.createTextNode("window."+J+"=1;"))}catch(I){}F.insertBefore(G,F.firstChild);if(l[J]){o.support.scriptEval=true;delete l[J]}F.removeChild(G);if(K.attachEvent&&K.fireEvent){K.attachEvent("onclick",function(){o.support.noCloneEvent=false;K.detachEvent("onclick",arguments.callee)});K.cloneNode(true).fireEvent("onclick")}o(function(){var L=document.createElement("div");L.style.width="1px";L.style.paddingLeft="1px";document.body.appendChild(L);o.boxModel=o.support.boxModel=L.offsetWidth===2;document.body.removeChild(L)})})();var w=o.support.cssFloat?"cssFloat":"styleFloat";o.props={"for":"htmlFor","class":"className","float":w,cssFloat:w,styleFloat:w,readonly:"readOnly",maxlength:"maxLength",cellspacing:"cellSpacing",rowspan:"rowSpan",tabindex:"tabIndex"};o.fn.extend({_load:o.fn.load,load:function(G,J,K){if(typeof G!=="string"){return this._load(G)}var I=G.indexOf(" ");if(I>=0){var E=G.slice(I,G.length);G=G.slice(0,I)}var H="GET";if(J){if(o.isFunction(J)){K=J;J=null}else{if(typeof J==="object"){J=o.param(J);H="POST"}}}var F=this;o.ajax({url:G,type:H,dataType:"html",data:J,complete:function(M,L){if(L=="success"||L=="notmodified"){F.html(E?o("<div/>").append(M.responseText.replace(/<script(.|\s)*?\/script>/g,"")).find(E):M.responseText)}if(K){F.each(K,[M.responseText,L,M])}}});return this},serialize:function(){return o.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?o.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||/select|textarea/i.test(this.nodeName)||/text|hidden|password/i.test(this.type))}).map(function(E,F){var G=o(this).val();return G==null?null:o.isArray(G)?o.map(G,function(I,H){return{name:F.name,value:I}}):{name:F.name,value:G}}).get()}});o.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","),function(E,F){o.fn[F]=function(G){return this.bind(F,G)}});var r=e();o.extend({get:function(E,G,H,F){if(o.isFunction(G)){H=G;G=null}return o.ajax({type:"GET",url:E,data:G,success:H,dataType:F})},getScript:function(E,F){return o.get(E,null,F,"script")},getJSON:function(E,F,G){return o.get(E,F,G,"json")},post:function(E,G,H,F){if(o.isFunction(G)){H=G;G={}}return o.ajax({type:"POST",url:E,data:G,success:H,dataType:F})},ajaxSetup:function(E){o.extend(o.ajaxSettings,E)},ajaxSettings:{url:location.href,global:true,type:"GET",contentType:"application/x-www-form-urlencoded",processData:true,async:true,xhr:function(){return l.ActiveXObject?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest()},accepts:{xml:"application/xml, text/xml",html:"text/html",script:"text/javascript, application/javascript",json:"application/json, text/javascript",text:"text/plain",_default:"*/*"}},lastModified:{},ajax:function(M){M=o.extend(true,M,o.extend(true,{},o.ajaxSettings,M));var W,F=/=\?(&|$)/g,R,V,G=M.type.toUpperCase();if(M.data&&M.processData&&typeof M.data!=="string"){M.data=o.param(M.data)}if(M.dataType=="jsonp"){if(G=="GET"){if(!M.url.match(F)){M.url+=(M.url.match(/\?/)?"&":"?")+(M.jsonp||"callback")+"=?"}}else{if(!M.data||!M.data.match(F)){M.data=(M.data?M.data+"&":"")+(M.jsonp||"callback")+"=?"}}M.dataType="json"}if(M.dataType=="json"&&(M.data&&M.data.match(F)||M.url.match(F))){W="jsonp"+r++;if(M.data){M.data=(M.data+"").replace(F,"="+W+"$1")}M.url=M.url.replace(F,"="+W+"$1");M.dataType="script";l[W]=function(X){V=X;I();L();l[W]=g;try{delete l[W]}catch(Y){}if(H){H.removeChild(T)}}}if(M.dataType=="script"&&M.cache==null){M.cache=false}if(M.cache===false&&G=="GET"){var E=e();var U=M.url.replace(/(\?|&)_=.*?(&|$)/,"$1_="+E+"$2");M.url=U+((U==M.url)?(M.url.match(/\?/)?"&":"?")+"_="+E:"")}if(M.data&&G=="GET"){M.url+=(M.url.match(/\?/)?"&":"?")+M.data;M.data=null}if(M.global&&!o.active++){o.event.trigger("ajaxStart")}var Q=/^(\w+:)?\/\/([^\/?#]+)/.exec(M.url);if(M.dataType=="script"&&G=="GET"&&Q&&(Q[1]&&Q[1]!=location.protocol||Q[2]!=location.host)){var H=document.getElementsByTagName("head")[0];var T=document.createElement("script");T.src=M.url;if(M.scriptCharset){T.charset=M.scriptCharset}if(!W){var O=false;T.onload=T.onreadystatechange=function(){if(!O&&(!this.readyState||this.readyState=="loaded"||this.readyState=="complete")){O=true;I();L();H.removeChild(T)}}}H.appendChild(T);return g}var K=false;var J=M.xhr();if(M.username){J.open(G,M.url,M.async,M.username,M.password)}else{J.open(G,M.url,M.async)}try{if(M.data){J.setRequestHeader("Content-Type",M.contentType)}if(M.ifModified){J.setRequestHeader("If-Modified-Since",o.lastModified[M.url]||"Thu, 01 Jan 1970 00:00:00 GMT")}J.setRequestHeader("X-Requested-With","XMLHttpRequest");J.setRequestHeader("Accept",M.dataType&&M.accepts[M.dataType]?M.accepts[M.dataType]+", */*":M.accepts._default)}catch(S){}if(M.beforeSend&&M.beforeSend(J,M)===false){if(M.global&&!--o.active){o.event.trigger("ajaxStop")}J.abort();return false}if(M.global){o.event.trigger("ajaxSend",[J,M])}var N=function(X){if(J.readyState==0){if(P){clearInterval(P);P=null;if(M.global&&!--o.active){o.event.trigger("ajaxStop")}}}else{if(!K&&J&&(J.readyState==4||X=="timeout")){K=true;if(P){clearInterval(P);P=null}R=X=="timeout"?"timeout":!o.httpSuccess(J)?"error":M.ifModified&&o.httpNotModified(J,M.url)?"notmodified":"success";if(R=="success"){try{V=o.httpData(J,M.dataType,M)}catch(Z){R="parsererror"}}if(R=="success"){var Y;try{Y=J.getResponseHeader("Last-Modified")}catch(Z){}if(M.ifModified&&Y){o.lastModified[M.url]=Y}if(!W){I()}}else{o.handleError(M,J,R)}L();if(X){J.abort()}if(M.async){J=null}}}};if(M.async){var P=setInterval(N,13);if(M.timeout>0){setTimeout(function(){if(J&&!K){N("timeout")}},M.timeout)}}try{J.send(M.data)}catch(S){o.handleError(M,J,null,S)}if(!M.async){N()}function I(){if(M.success){M.success(V,R)}if(M.global){o.event.trigger("ajaxSuccess",[J,M])}}function L(){if(M.complete){M.complete(J,R)}if(M.global){o.event.trigger("ajaxComplete",[J,M])}if(M.global&&!--o.active){o.event.trigger("ajaxStop")}}return J},handleError:function(F,H,E,G){if(F.error){F.error(H,E,G)}if(F.global){o.event.trigger("ajaxError",[H,F,G])}},active:0,httpSuccess:function(F){try{return !F.status&&location.protocol=="file:"||(F.status>=200&&F.status<300)||F.status==304||F.status==1223}catch(E){}return false},httpNotModified:function(G,E){try{var H=G.getResponseHeader("Last-Modified");return G.status==304||H==o.lastModified[E]}catch(F){}return false},httpData:function(J,H,G){var F=J.getResponseHeader("content-type"),E=H=="xml"||!H&&F&&F.indexOf("xml")>=0,I=E?J.responseXML:J.responseText;if(E&&I.documentElement.tagName=="parsererror"){throw"parsererror"}if(G&&G.dataFilter){I=G.dataFilter(I,H)}if(typeof I==="string"){if(H=="script"){o.globalEval(I)}if(H=="json"){I=l["eval"]("("+I+")")}}return I},param:function(E){var G=[];function H(I,J){G[G.length]=encodeURIComponent(I)+"="+encodeURIComponent(J)}if(o.isArray(E)||E.jquery){o.each(E,function(){H(this.name,this.value)})}else{for(var F in E){if(o.isArray(E[F])){o.each(E[F],function(){H(F,this)})}else{H(F,o.isFunction(E[F])?E[F]():E[F])}}}return G.join("&").replace(/%20/g,"+")}});var m={},n,d=[["height","marginTop","marginBottom","paddingTop","paddingBottom"],["width","marginLeft","marginRight","paddingLeft","paddingRight"],["opacity"]];function t(F,E){var G={};o.each(d.concat.apply([],d.slice(0,E)),function(){G[this]=F});return G}o.fn.extend({show:function(J,L){if(J){return this.animate(t("show",3),J,L)}else{for(var H=0,F=this.length;H<F;H++){var E=o.data(this[H],"olddisplay");this[H].style.display=E||"";if(o.css(this[H],"display")==="none"){var G=this[H].tagName,K;if(m[G]){K=m[G]}else{var I=o("<"+G+" />").appendTo("body");K=I.css("display");if(K==="none"){K="block"}I.remove();m[G]=K}this[H].style.display=o.data(this[H],"olddisplay",K)}}return this}},hide:function(H,I){if(H){return this.animate(t("hide",3),H,I)}else{for(var G=0,F=this.length;G<F;G++){var E=o.data(this[G],"olddisplay");if(!E&&E!=="none"){o.data(this[G],"olddisplay",o.css(this[G],"display"))}this[G].style.display="none"}return this}},_toggle:o.fn.toggle,toggle:function(G,F){var E=typeof G==="boolean";return o.isFunction(G)&&o.isFunction(F)?this._toggle.apply(this,arguments):G==null||E?this.each(function(){var H=E?G:o(this).is(":hidden");o(this)[H?"show":"hide"]()}):this.animate(t("toggle",3),G,F)},fadeTo:function(E,G,F){return this.animate({opacity:G},E,F)},animate:function(I,F,H,G){var E=o.speed(F,H,G);return this[E.queue===false?"each":"queue"](function(){var K=o.extend({},E),M,L=this.nodeType==1&&o(this).is(":hidden"),J=this;for(M in I){if(I[M]=="hide"&&L||I[M]=="show"&&!L){return K.complete.call(this)}if((M=="height"||M=="width")&&this.style){K.display=o.css(this,"display");K.overflow=this.style.overflow}}if(K.overflow!=null){this.style.overflow="hidden"}K.curAnim=o.extend({},I);o.each(I,function(O,S){var R=new o.fx(J,K,O);if(/toggle|show|hide/.test(S)){R[S=="toggle"?L?"show":"hide":S](I)}else{var Q=S.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),T=R.cur(true)||0;if(Q){var N=parseFloat(Q[2]),P=Q[3]||"px";if(P!="px"){J.style[O]=(N||1)+P;T=((N||1)/R.cur(true))*T;J.style[O]=T+P}if(Q[1]){N=((Q[1]=="-="?-1:1)*N)+T}R.custom(T,N,P)}else{R.custom(T,S,"")}}});return true})},stop:function(F,E){var G=o.timers;if(F){this.queue([])}this.each(function(){for(var H=G.length-1;H>=0;H--){if(G[H].elem==this){if(E){G[H](true)}G.splice(H,1)}}});if(!E){this.dequeue()}return this}});o.each({slideDown:t("show",1),slideUp:t("hide",1),slideToggle:t("toggle",1),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"}},function(E,F){o.fn[E]=function(G,H){return this.animate(F,G,H)}});o.extend({speed:function(G,H,F){var E=typeof G==="object"?G:{complete:F||!F&&H||o.isFunction(G)&&G,duration:G,easing:F&&H||H&&!o.isFunction(H)&&H};E.duration=o.fx.off?0:typeof E.duration==="number"?E.duration:o.fx.speeds[E.duration]||o.fx.speeds._default;E.old=E.complete;E.complete=function(){if(E.queue!==false){o(this).dequeue()}if(o.isFunction(E.old)){E.old.call(this)}};return E},easing:{linear:function(G,H,E,F){return E+F*G},swing:function(G,H,E,F){return((-Math.cos(G*Math.PI)/2)+0.5)*F+E}},timers:[],fx:function(F,E,G){this.options=E;this.elem=F;this.prop=G;if(!E.orig){E.orig={}}}});o.fx.prototype={update:function(){if(this.options.step){this.options.step.call(this.elem,this.now,this)}(o.fx.step[this.prop]||o.fx.step._default)(this);if((this.prop=="height"||this.prop=="width")&&this.elem.style){this.elem.style.display="block"}},cur:function(F){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null)){return this.elem[this.prop]}var E=parseFloat(o.css(this.elem,this.prop,F));return E&&E>-10000?E:parseFloat(o.curCSS(this.elem,this.prop))||0},custom:function(I,H,G){this.startTime=e();this.start=I;this.end=H;this.unit=G||this.unit||"px";this.now=this.start;this.pos=this.state=0;var E=this;function F(J){return E.step(J)}F.elem=this.elem;if(F()&&o.timers.push(F)==1){n=setInterval(function(){var K=o.timers;for(var J=0;J<K.length;J++){if(!K[J]()){K.splice(J--,1)}}if(!K.length){clearInterval(n)}},13)}},show:function(){this.options.orig[this.prop]=o.attr(this.elem.style,this.prop);this.options.show=true;this.custom(this.prop=="width"||this.prop=="height"?1:0,this.cur());o(this.elem).show()},hide:function(){this.options.orig[this.prop]=o.attr(this.elem.style,this.prop);this.options.hide=true;this.custom(this.cur(),0)},step:function(H){var G=e();if(H||G>=this.options.duration+this.startTime){this.now=this.end;this.pos=this.state=1;this.update();this.options.curAnim[this.prop]=true;var E=true;for(var F in this.options.curAnim){if(this.options.curAnim[F]!==true){E=false}}if(E){if(this.options.display!=null){this.elem.style.overflow=this.options.overflow;this.elem.style.display=this.options.display;if(o.css(this.elem,"display")=="none"){this.elem.style.display="block"}}if(this.options.hide){o(this.elem).hide()}if(this.options.hide||this.options.show){for(var I in this.options.curAnim){o.attr(this.elem.style,I,this.options.orig[I])}}this.options.complete.call(this.elem)}return false}else{var J=G-this.startTime;this.state=J/this.options.duration;this.pos=o.easing[this.options.easing||(o.easing.swing?"swing":"linear")](this.state,J,0,1,this.options.duration);this.now=this.start+((this.end-this.start)*this.pos);this.update()}return true}};o.extend(o.fx,{speeds:{slow:600,fast:200,_default:400},step:{opacity:function(E){o.attr(E.elem.style,"opacity",E.now)},_default:function(E){if(E.elem.style&&E.elem.style[E.prop]!=null){E.elem.style[E.prop]=E.now+E.unit}else{E.elem[E.prop]=E.now}}}});if(document.documentElement.getBoundingClientRect){o.fn.offset=function(){if(!this[0]){return{top:0,left:0}}if(this[0]===this[0].ownerDocument.body){return o.offset.bodyOffset(this[0])}var G=this[0].getBoundingClientRect(),J=this[0].ownerDocument,F=J.body,E=J.documentElement,L=E.clientTop||F.clientTop||0,K=E.clientLeft||F.clientLeft||0,I=G.top+(self.pageYOffset||o.boxModel&&E.scrollTop||F.scrollTop)-L,H=G.left+(self.pageXOffset||o.boxModel&&E.scrollLeft||F.scrollLeft)-K;return{top:I,left:H}}}else{o.fn.offset=function(){if(!this[0]){return{top:0,left:0}}if(this[0]===this[0].ownerDocument.body){return o.offset.bodyOffset(this[0])}o.offset.initialized||o.offset.initialize();var J=this[0],G=J.offsetParent,F=J,O=J.ownerDocument,M,H=O.documentElement,K=O.body,L=O.defaultView,E=L.getComputedStyle(J,null),N=J.offsetTop,I=J.offsetLeft;while((J=J.parentNode)&&J!==K&&J!==H){M=L.getComputedStyle(J,null);N-=J.scrollTop,I-=J.scrollLeft;if(J===G){N+=J.offsetTop,I+=J.offsetLeft;if(o.offset.doesNotAddBorder&&!(o.offset.doesAddBorderForTableAndCells&&/^t(able|d|h)$/i.test(J.tagName))){N+=parseInt(M.borderTopWidth,10)||0,I+=parseInt(M.borderLeftWidth,10)||0}F=G,G=J.offsetParent}if(o.offset.subtractsBorderForOverflowNotVisible&&M.overflow!=="visible"){N+=parseInt(M.borderTopWidth,10)||0,I+=parseInt(M.borderLeftWidth,10)||0}E=M}if(E.position==="relative"||E.position==="static"){N+=K.offsetTop,I+=K.offsetLeft}if(E.position==="fixed"){N+=Math.max(H.scrollTop,K.scrollTop),I+=Math.max(H.scrollLeft,K.scrollLeft)}return{top:N,left:I}}}o.offset={initialize:function(){if(this.initialized){return}var L=document.body,F=document.createElement("div"),H,G,N,I,M,E,J=L.style.marginTop,K='<div style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;"><div></div></div><table style="position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;" cellpadding="0" cellspacing="0"><tr><td></td></tr></table>';M={position:"absolute",top:0,left:0,margin:0,border:0,width:"1px",height:"1px",visibility:"hidden"};for(E in M){F.style[E]=M[E]}F.innerHTML=K;L.insertBefore(F,L.firstChild);H=F.firstChild,G=H.firstChild,I=H.nextSibling.firstChild.firstChild;this.doesNotAddBorder=(G.offsetTop!==5);this.doesAddBorderForTableAndCells=(I.offsetTop===5);H.style.overflow="hidden",H.style.position="relative";this.subtractsBorderForOverflowNotVisible=(G.offsetTop===-5);L.style.marginTop="1px";this.doesNotIncludeMarginInBodyOffset=(L.offsetTop===0);L.style.marginTop=J;L.removeChild(F);this.initialized=true},bodyOffset:function(E){o.offset.initialized||o.offset.initialize();var G=E.offsetTop,F=E.offsetLeft;if(o.offset.doesNotIncludeMarginInBodyOffset){G+=parseInt(o.curCSS(E,"marginTop",true),10)||0,F+=parseInt(o.curCSS(E,"marginLeft",true),10)||0}return{top:G,left:F}}};o.fn.extend({position:function(){var I=0,H=0,F;if(this[0]){var G=this.offsetParent(),J=this.offset(),E=/^body|html$/i.test(G[0].tagName)?{top:0,left:0}:G.offset();J.top-=j(this,"marginTop");J.left-=j(this,"marginLeft");E.top+=j(G,"borderTopWidth");E.left+=j(G,"borderLeftWidth");F={top:J.top-E.top,left:J.left-E.left}}return F},offsetParent:function(){var E=this[0].offsetParent||document.body;while(E&&(!/^body|html$/i.test(E.tagName)&&o.css(E,"position")=="static")){E=E.offsetParent}return o(E)}});o.each(["Left","Top"],function(F,E){var G="scroll"+E;o.fn[G]=function(H){if(!this[0]){return null}return H!==g?this.each(function(){this==l||this==document?l.scrollTo(!F?H:o(l).scrollLeft(),F?H:o(l).scrollTop()):this[G]=H}):this[0]==l||this[0]==document?self[F?"pageYOffset":"pageXOffset"]||o.boxModel&&document.documentElement[G]||document.body[G]:this[0][G]}});o.each(["Height","Width"],function(H,F){var E=H?"Left":"Top",G=H?"Right":"Bottom";o.fn["inner"+F]=function(){return this[F.toLowerCase()]()+j(this,"padding"+E)+j(this,"padding"+G)};o.fn["outer"+F]=function(J){return this["inner"+F]()+j(this,"border"+E+"Width")+j(this,"border"+G+"Width")+(J?j(this,"margin"+E)+j(this,"margin"+G):0)};var I=F.toLowerCase();o.fn[I]=function(J){return this[0]==l?document.compatMode=="CSS1Compat"&&document.documentElement["client"+F]||document.body["client"+F]:this[0]==document?Math.max(document.documentElement["client"+F],document.body["scroll"+F],document.documentElement["scroll"+F],document.body["offset"+F],document.documentElement["offset"+F]):J===g?(this.length?o.css(this[0],I):null):this.css(I,typeof J==="string"?J:J+"px")}})})();
(function() {
	if (window.ymPrompt) return;
	window.ymPrompt = {
		version: '4.0',
		pubDate: '2009-02-07',
		apply: function(o, c, d) {
			if (d) ymPrompt.apply(o, d);
			if (o && c && typeof c == 'object') for (var p in c) o[p] = c[p];
			return o;
		},
		eventList: []
	};
	/*初始化可能在页面加载完成调用的接口，防止外部调用失败。_initFn:缓存初始调用传入的参数*/
	var initFn = ['setDefaultCfg','show'], _initFn = {},t;
	while(t=initFn.shift()) ymPrompt[t] = eval('0,function(){_initFn.'+t+'=arguments}');

	/*以下为公用函数及变量*/
	var isIE=!+'\v1';	//IE浏览器
	var useIframe = isIE && /MSIE (\d)\./.test(navigator.userAgent) && parseInt(RegExp.$1) < 7; //是否需要用iframe来遮罩
	var $ = function(id) {
		return document.getElementById(id)
	}; //获取元素
	var $height = function(obj) {
		return parseInt(obj.style.height) || obj.offsetHeight
	}; //获取元素高度
	var addEvent = (function() {
		return new Function('env','fn','obj',['obj=obj||document;', window.attachEvent ? "obj.attachEvent('on'+env,fn)": 'obj.addEventListener(env,fn,false)', ';ymPrompt.eventList.push([env,fn,obj])'].join(''))
	})(); //事件绑定
	var detachEvent = (function() {
		return new Function('env','fn','obj',['obj=obj||document;', window.attachEvent ? "obj.detachEvent('on'+env,fn)": 'obj.removeEventListener(env,fn,false)'].join(''))
	})(); //取消事件绑定
	//为元素的设定样式值
	var setCss = function(el, n){
		if (!el) return;
		/*dom数组或dom集合*/
		if (el instanceof Array) {
			var arr=el.concat();
			while(el=arr.shift())setCss(el, n);
			return;
		}
		el.style.cssText+=';'+n;
	};
	/*----------------和业务有关的公用函数-----------------*/
	var btnIndex = 0, btnCache, seed = 0; //当前焦点的按钮的索引、当前存在的按钮、id种子
	/*创建按钮*/
	var defaultBtn=function(){return {OK:[curCfg.okTxt, 'ok'], CANCEL:[curCfg.cancelTxt, 'cancel']}};
	var mkBtn = function(txt, sign, autoClose, id) {
		if (!txt) return;
		if (txt instanceof Array) {
			/*无效按钮删除*/
			var item,t=[];
			while(txt.length) (item=txt.shift())&&t[t.push(mkBtn.apply(null, defaultBtn()[item]||item))-1]||t.pop();
			return t;
		}
		id = id || 'ymPrompt_btn_' + seed++;
		autoClose = typeof autoClose == 'undefined' ? 'undefined': !!autoClose;
		return {
			id: id,
			html: "<input type='button' id='" + id + "' onclick='ymPrompt.doHandler(\"" + sign + "\"," + autoClose + ")' style='cursor:pointer' class='btnStyle handler' value='" + txt + "' />"
		};
	}
	/*生成按钮组合的html*/
	var joinBtn = function(btn) {
		if (!btn) return btnCache = '';
		if (! (btn instanceof Array)) btn = [btn];
		if(!btn.length) return btnCache='';
		btnCache = btn.concat();
		var html=[];
		while(btn.length) html.push(btn.shift().html);
		return html.join('&nbsp;&nbsp;');
	}
	/*默认显示配置及用户当前配置*/
	var dftCfg = {
		titleBar: true,
		fixPosition: false,
		dragOut: true,
		autoClose: true,
		showMask: true,
		maskAlphaColor: '#000',	//遮罩透明色
		maskAlpha: 0.1,		//遮罩透明度
		winAlpha:0.8,	//拖动窗体时窗体的透明度
		title: '标题',		//消息框标题
		message: '内容',	//消息框按钮
		width: 420,
		height: 185,
		winPos: 'c',
		iframe: false,
		btn: null,
		closeTxt: '关闭',
		okTxt:' 确 定 ',
		cancelTxt:' 取 消 ',
		icoCls: '',
		handler: function() {} //回调事件
	},curCfg = {};
	/*开始解析*/
	(function() {
		if (!document.body || typeof document.body != 'object') return addEvent('load', arguments.callee, window); //等待页面加载完成
		var rootEl = document.compatMode == 'CSS1Compat' ? document.documentElement: document.body; //根据html Doctype获取html根节点，以兼容非xhtml的页面
		/*保存窗口定位信息*/
		var saveWinInfo = function() {
			ymPrompt.apply(dragVar, {
				_offX: ym_win.offsetLeft-rootEl.scrollLeft,	//弹出框相对屏幕的位移差
				_offY: ym_win.offsetTop-rootEl.scrollTop
			});
		};
		/*-------------------------创建弹窗html-------------------*/
		var maskStyle = 'position:absolute;top:0;left:0;display:none;text-align:center';
		var div = document.createElement('div');
		div.innerHTML = [
		/*遮罩*/
		"<div id='maskLevel' style=\'" + maskStyle + ';z-index:10000;\'></div>', useIframe ? ("<iframe id='maskIframe' style='" + maskStyle + ";z-index:9999;filter:alpha(opacity=0);opacity:0'></iframe>") : '',
		/*窗体*/
		"<div id='ym-window' style='position:absolute;z-index:10001;display:none'>", useIframe ? "<iframe style='width:100%;height:100%;position:absolute;top:0;left:0;z-index:-1'></iframe>": '', "<div class='ym-tl' id='ym-tl'><div class='ym-tr'><div class='ym-tc' style='cursor:move;'><div class='ym-header-text'></div><div class='ym-header-tools'></div></div></div></div>", "<div class='ym-ml' id='ym-ml'><div class='ym-mr'><div class='ym-mc'><div class='ym-body'></div></div></div></div>", "<div class='ym-ml' id='ym-btnl'><div class='ym-mr'><div class='ym-btn'></div></div></div>", "<div class='ym-bl' id='ym-bl'><div class='ym-br'><div class='ym-bc'></div></div></div>", "</div>"].join('');
		document.body.appendChild(div),div = null;

		var dragVar = {};
		/*mask、window*/
		var maskLevel = $('maskLevel');
		var ym_win = $('ym-window');
		/*header*/
		var ym_headbox = $('ym-tl');
		var ym_head = ym_headbox.firstChild.firstChild;
		var ym_hText = ym_head.firstChild;
		var ym_hTool = ym_hText.nextSibling;
		/*content*/
		var ym_body = $('ym-ml').firstChild.firstChild.firstChild;
		/*button*/
		var ym_btn = $('ym-btnl');
		var ym_btnContent = ym_btn.firstChild.firstChild;
		/*bottom*/
		var ym_bottom = $('ym-bl');
		var maskEl=[maskLevel];
		useIframe&&maskEl.push($('maskIframe'));

		/*绑定事件*/
		var getWinSize=function(){return [Math.max(rootEl.scrollWidth,rootEl.clientWidth),Math.max(rootEl.scrollHeight,rootEl.clientHeight)]};
		var winSize=getWinSize();	//保存页面的实际大小
		var bindEl=ym_head.setCapture&&ym_head;	//绑定拖放事件的对象
		var mEvent=function(e) { 
			e = e || window.event;
			var sLeft = dragVar.offX + (e.x||e.pageX);
			var sTop = dragVar.offY + (e.y||e.pageY);

			if (!curCfg.dragOut) {
				var sl = rootEl.scrollLeft,st = rootEl.scrollTop;
				sLeft = Math.min(Math.max(sLeft, sl), rootEl.clientWidth - ym_win.offsetWidth + sl);
				sTop = Math.min(Math.max(sTop, st), rootEl.clientHeight - ym_win.offsetHeight + st);
			}else if(curCfg.showMask && ''+winSize!=''+getWinSize())
				resizeMask(true);
			setCss(ym_win,['left:',sLeft,'px;top:',sTop,'px'].join(''));
		};	//mousemove事件
		var uEvent=function() {
			setCss(ym_win,isIE?';filter: alpha(opacity=100)':';opacity:1');	//鼠标按下时取消窗体的透明度
			detachEvent("mousemove",mEvent,bindEl);
			detachEvent("mouseup",uEvent,bindEl);
			saveWinInfo();//保存当前窗口的位置
			bindEl&&(detachEvent("losecapture",uEvent,bindEl),bindEl.releaseCapture());
		};	//mouseup事件
		addEvent('mousedown',function(e) {
			e = e || window.event;
			setCss(ym_win,isIE?'filter: alpha(opacity='+curCfg.winAlpha*100+')':';opacity:'+curCfg.winAlpha);//鼠标按下时窗体的透明度
			ymPrompt.apply(dragVar, {
				offX: ym_win.offsetLeft-(e.x||e.pageX),	//鼠标与弹出框的左上角的位移差
				offY: ym_win.offsetTop-(e.y||e.pageY)
			});
			addEvent("mousemove",mEvent,bindEl);
			addEvent("mouseup",uEvent,bindEl);
			bindEl&&(addEvent("losecapture",uEvent,bindEl),bindEl.setCapture());
		},ym_head);
		
		/*键盘监听*/
		var keydownEvent=function(e) {
			var e = e || event, keyCode=e.keyCode;
			if(keyCode==27) destroy();//esc键
			if(btnCache){
				var l = btnCache.length,nofocus;
				/*tab键/左右方向键切换焦点*/
				document.activeElement&&document.activeElement.id!=btnCache[btnIndex].id && (nofocus=true);
				if (keyCode == 9 || keyCode == 39) nofocus&&(btnIndex=-1),$(btnCache[++btnIndex == l ? (--btnIndex) : btnIndex].id).focus();
				if (keyCode == 37) nofocus&&(btnIndex=l),$(btnCache[--btnIndex < 0 ? (++btnIndex) : btnIndex].id).focus();
				if (keyCode == 13) return true;
			}
			/*禁止F1-F12/ tab 回车*/
			return keyEvent(e,(keyCode > 110 && keyCode < 123) || keyCode == 9 || keyCode == 13);
		};
		/*页面滚动弹出窗口滚动*/
		var scrollEvent=function(){
			setCss(ym_win, ['left:',dragVar._offX + rootEl.scrollLeft,'px;top:',dragVar._offY + rootEl.scrollTop,'px'].join(''));
		};
		/*监听键盘事件*/
		var keyEvent=function(e,d){
			e=e||event;
			/*允许对表单项进行操作*/
			if(!d&&/input|select|textarea/i.test((e.srcElement||e.target).tagName)) return true;
			try{
				e.returnValue=false;
				e.keyCode = 0;
			} catch(ex) {
				e.preventDefault&&e.preventDefault();
			}
		};
		maskLevel.oncontextmenu = ym_win.onselectstart = ym_win.oncontextmenu = keyEvent; //禁止右键
		/*重新计算遮罩的大小*/
		var resizeMask=function(noDelay){
			setCss(maskEl, 'display:none');	//先隐藏
			var size=getWinSize();
			var resize=function(){
				setCss(maskEl, ['width:',size[0],'px;height:',size[1],'px;display:block;'].join(''));
			};
			isIE?noDelay===true?resize():setTimeout(resize,0):resize();
			setWinSize();
		};
		/*蒙版的显示隐藏,state:true显示,false隐藏，默认为true*/
		var maskVisible = function(visible) {
			if (!curCfg.showMask) return;
			(visible === false?detachEvent:addEvent)("resize",resizeMask,window);
			if (visible === false) return setCss(maskEl, 'display:none');
			setCss(maskLevel, 'background:'+curCfg.maskAlphaColor+(isIE?';filter: alpha(opacity='+curCfg.maskAlpha * 100+')':';opacity:'+curCfg.maskAlpha));
			resizeMask(true);
		}; 
		var getPos=function(f){
			var pos=[rootEl.clientWidth - ym_win.offsetWidth, rootEl.clientHeight - ym_win.offsetHeight, rootEl.scrollLeft, rootEl.scrollTop];
			var arr=f.replace(/\{(\d)\}/g,function(s,s1){return pos[s1]}).split(',');
			return [eval(arr[0]),eval(arr[1])];
		};
		var posMap = {
			c: '{0}/2+{2},{1}/2+{3}',
			l: '{2},{1}/2+{3}',
			r: '{0}+{2},{1}/2+{3}',
			t: '{0}/2+{2},{3}',
			b: '{0}/2,{1}+{3}',
			lt: '{2},{3}',
			lb: '{2},{1}+{3}',
			rb: '{0}+{2},{1}+{3}',
			rt: '{0}+{2},{3}'
		};
		/*设定窗口大小及定位*/
		var setWinSize = function(w, h) {
			if (!isShow) return;
			curCfg.height = parseInt(h) || curCfg.height;
			curCfg.width = parseInt(w) || curCfg.width;
			setCss(ym_win, ['left:0;top:0;width:',curCfg.width ,'px;height:',curCfg.height,'px'].join(''));
			var pos = posMap[curCfg.winPos];
			pos = pos ? getPos(pos) : curCfg.winPos; //支持自定义坐标
			if(!(pos instanceof Array))pos=getPos(posMap['c']);
			setCss(ym_win, ['top:', pos[1] , 'px;left:',pos[0],'px'].join(''));
			saveWinInfo();	//保存当前窗口位置信息
			setCss(ym_body, ['height:', curCfg.height - $height(ym_headbox) - $height(ym_btn) - $height(ym_bottom) , 'px'].join('')); //设定内容区的高度
		};
		var _obj=[];	//IE中可见的obj元素
		var winVisible = function(visible) {
			var fn=visible===false?detachEvent:addEvent;
			if (curCfg.fixPosition) fn('scroll', scrollEvent, window);
			fn('keydown', keydownEvent);
			if (visible === false) {
				setCss(ym_win, 'display:none');
				setCss(_obj, 'visibility:visible');
				_obj=[];
				return ;
			}
			for(var o=document.getElementsByTagName('object'),i=o.length-1;i>-1;i--) o[i].style.visibility!='hidden'&&_obj.push(o[i])&&(o[i].style.visibility='hidden');
			setCss([ym_hText, ym_hTool], 'display:'+(curCfg.titleBar ? 'block': 'none'));
			ym_head.className = 'ym-tc' + (curCfg.titleBar ? '': ' ym-ttc');
			ym_hText.innerHTML = curCfg.title; //标题
			//ym_hTool.innerHTML = "<div class='ymPrompt_close' onmouseout='this.className=\"ymPrompt_close\"' onmouseover='this.className=\"ymPrompt_close_Over\"'  title='"+curCfg.closeTxt+"' onclick='ymPrompt.doHandler(\"close\")'>&nbsp;</div>";
			ym_hTool.innerHTML = "<div class='ymPrompt_close' title='"+curCfg.closeTxt+"' onclick='ymPrompt.doHandler(\"close\")'>&nbsp;</div>";
			ym_body.innerHTML = !curCfg.iframe ? ('<div class="ym-content">' + curCfg.message + '</div>') : "<iframe width='100%' height='100%' border='0' frameborder='0' src='" + curCfg.message + "'></iframe>"; //内容
			(function(el,obj){for(var i in obj)try{el[i]=obj[i]}catch(e){}})(ym_body.firstChild,curCfg.iframe);//为iframe添加自定义属性
			ym_body.className = "ym-body " + curCfg.icoCls; //图标类型
			setCss(ym_btn, 'display:'+((ym_btnContent.innerHTML = joinBtn(mkBtn(curCfg.btn))) ? 'block': 'none')); //没有按钮则隐藏
			setCss(ym_win, 'display:block');
			setWinSize();	//定位窗口
			btnCache && $(btnCache[btnIndex = 0].id).focus(); //第一个按钮获取焦点
		}; //初始化
		var isShow=false;
		var init = function() {
			isShow=true;
			maskVisible();
			winVisible();
		}; //销毁
		var destroy = function() {
			isShow=false;
			maskVisible(false);
			winVisible(false);
		};
		ymPrompt.apply(ymPrompt, {
			close: destroy,
			getPage: function() {
				return curCfg.iframe ? ym_body.firstChild: null
			},
			/*显示消息框,fargs:优先配置，会覆盖args中的配置*/
			show: function(args, fargs) {
				if(isShow) ymPrompt.doHandler('close',curCfg.autoClose,true);
				/*支持两种参数传入方式:(1)JSON方式 (2)多个参数传入*/
				var a = [].slice.call(args, 0), o = {};
				if (typeof a[0] != 'object') {
					var cfg = ['message', 'width', 'height', 'title', 'handler', 'maskAlphaColor', 'maskAlpha', 'iframe', 'icoCls', 'btn', 'autoClose', 'fixPosition', 'dragOut', 'titleBar', 'showMask', 'winPos', 'winAlpha'];
					for (var i = 0,l = a.length; i < l; i++) if (a[i]) o[cfg[i]] = a[i];
				} else {
					o = a[0];
				}
				ymPrompt.apply(curCfg, ymPrompt.apply({},o, fargs), ymPrompt.setDefaultCfg()); //先还原默认配置
				/*修正curCfg中的无效值(null/undefined)改为默认值*/
				for(var i in curCfg) curCfg[i]=curCfg[i]!=null?curCfg[i]:ymPrompt.cfg[i];
				init();
			},
			doHandler: function(sign, autoClose, closeFirst) {
				if(typeof autoClose == 'undefined' ? curCfg.autoClose: autoClose) destroy();
				try{(curCfg.handler)(sign)}catch(e){};
			},
			resizeWin: setWinSize,
			/*设定默认配置*/
			setDefaultCfg: function(cfg) {
				return ymPrompt.cfg = ymPrompt.apply({},
				cfg, ymPrompt.apply({},
				ymPrompt.cfg, dftCfg));
			},
			getButtons:function(){
				var btns=btnCache||[],btn,rBtn=[];
				while(btn=btns.shift())rBtn.push($(btn.id));
				return btns=btn=null,rBtn;
			}
		});
		ymPrompt.setDefaultCfg(); //初始化默认配置
		/*执行用户初始化时的调用*/
		for (var i in _initFn) ymPrompt[i].apply(null, _initFn[i]);
		/*取消事件绑定*/
		addEvent('unload',function() {
			while(ymPrompt.eventList.length) detachEvent.apply(null, ymPrompt.eventList.shift());
		},window);
	})();
})(); //各消息框的相同操作
ymPrompt.apply(ymPrompt, {
	alert: function() {
		ymPrompt.show(arguments, {
			icoCls: 'ymPrompt_alert',
			btn: ['OK']
		});
	},
	succeedInfo: function() {
		ymPrompt.show(arguments, {
			icoCls: 'ymPrompt_succeed',
			btn: ['OK']
		});
	},
	errorInfo: function() {
		ymPrompt.show(arguments, {
			icoCls: 'ymPrompt_error',
			btn: ['OK']
		});
	},
	confirmInfo: function() {
	if (window.parent)
		window.parent.ymPrompt.show(arguments, { icoCls: 'ymPrompt_confirm', btn: [['是','ok'],['否','cancel']] });
	else
		ymPrompt.show(arguments, {icoCls: 'ymPrompt_confirm',btn:[['是','ok'],['否','cancel']]});
	},
	win: function() {ymPrompt.show(arguments);}
});
ymPrompt.setDefaultCfg({ width: 420, title: 'E4消息提示' });
function newAlert(info) {
	if (window.parent)window.parent.ymPrompt.alert(info);
	else ymPrompt.alert(info);
}
function newErrorInfo(info) {
	if (window.parent) window.parent.ymPrompt.errorInfo(info);
	else ymPrompt.errorInfo(info);
}
function newSuccessInfo(info) {
	if (window.parent) window.parent.ymPrompt.succeedInfo(info);
	else ymPrompt.succeedInfo(info);
}
function newAlertAndExcute(message, code) {
	if (window.parent) window.parent.ymPrompt.alert(message, null, null, null, function(tp) { eval(code); });
	else ymPrompt.alert(message, null, null, null, function(tp) { eval(code); });
}
function newSuccessAndExcute(message, code) {
	if (window.parent) window.parent.ymPrompt.succeedInfo(message, null, null, null, function(tp) { eval(code); });
	else ymPrompt.succeedInfo(message, null, null, null, function(tp) { eval(code); });
}
function newconfirmInfo(message,a,b,c, handler)
{
	if (window.parent) window.parent.ymPrompt.confirmInfo(message, null, null, null, handler);
	else ymPrompt.confirmInfo(message, null, null, null, handler);
}
function SetDivCenter(divName, width_Div, height_Div) 
{
	var pageWidth = $(document).width();
	var pageHeight = screen.availHeight-120;
	var divDetails = $('#' + divName);
	divDetails.css("top", document.documentElement.scrollTop+(pageHeight - height_Div) / 2-50);
	divDetails.css("left", document.documentElement.scrollLeft+(pageWidth - width_Div) / 2);
} 
function SetDivCenter_Screen(divName, width_Div, height_Div) 
{
	var pageWidth = $(document).width();
	var pageHeight = screen.availHeight;
	var divDetails = $('#' + divName);
	divDetails.css("top", document.documentElement.scrollTop+(pageHeight - height_Div) / 2-50);
	divDetails.css("left", document.documentElement.scrollLeft+(pageWidth - width_Div) / 2);
}

function LoadIframe(main) {
	//ToLoadIframe(main,true);
}
function ToLoadIframe(main,isAddTime) 
{
	var obj_main = $(window.parent.document).find('#main');
	if(isAddTime)
	{
		if (main.indexOf("?") > -1) main += "&"; 
		else main += "?";
		main += "t=" + new Date();
	 }
	if ($.trim(main).length > 0) obj_main.attr("src", main);
}
function LoadMenuIframe(outlook) 
{
	var Menu = $(window.parent.document).find('#outlook');
	if (outlook.indexOf("?") > -1) outlook += "&"; 
	else outlook += "?";
	outlook += "t=" + new Date();
	if ($.trim(outlook).length > 0) Menu.attr("src", outlook);
}

function ShowChooseBatch()
{
	var txtProductBatch = $("#txtProductBatch");
	var hfProductId = $("#hfProductId");
	if(txtProductBatch.attr("id") ==null) return;
	if(hfProductId.attr("id") ==null) return;
	var theTableName= GetQueryString("returnTableName");
	if(theTableName==null) theTableName='';
	var conditionUrl = "pId=" + hfProductId.val()+"&tableName="+theTableName;
	//根据产品核算方法显示选择批次行
	$.ajax({
	type: "POST",
	url: "/control/Product/IsShowChooseBatch.aspx",
	data: conditionUrl,
	success:fnTransactByPost_ChooseProductBatch
	});
}
function fnTransactByPost_ChooseProductBatch(data)
{
	var trProductBatch = $("#trProductBatch");
	if(data=="true") trProductBatch.show();
	else trProductBatch.hide();	
	if(data=="true")//产品拆卸宽度的单独处理
	{
		var returnTableName = GetQueryString("returnTableName");
		if(returnTableName !=null && returnTableName=="V_Store_ProductUnBuild")
		{
			var txtProductBatch = $("#txtProductBatch");
			txtProductBatch.width(160+(screen.availWidth-1024)/3);
		}
	}
}
function SetProductByQuickSelect(pId)//根据选择的产品作出设置相关控件的内容
{
	$("#hfProductId").val(pId);
	$.ajax({
	type: "POST",
	url: "/control/Product/GetProductProperties.aspx",
	data: "pId="+pId,
	success:fnTransactByPost_ProductProperties
	});
}
function fnTransactByPost_ProductProperties(data)
{
	var txtProductNo = $("#txtProductNo");
	var txtProductName=$("#txtProductName");
	var txtProductSpec = $("#txtProductSpec");
	var txtProductMode=$("#txtProductMode");
	var txtProductUnit = $("#txtProductUnit");
	var tempArray = data.split('@');            
	txtProductNo.val(tempArray[0].trim());
	txtProductName.val(tempArray[1].trim());
	txtProductSpec.val(tempArray[2].trim());
	txtProductMode.val(tempArray[3].trim());
	txtProductUnit.val(tempArray[4].trim());
	//清除批次信息
	var txtProductBatch = opener.$("#txtProductBatch");
	if (txtProductBatch.attr("id") != null) txtProductBatch.val("");
	var hfBatchDan = opener.$("#hfBatchDan");
	if (hfBatchDan.attr("id") != null) hfBatchDan.val("");
	var hfBatchId = opener.$("#hfBatchId");
	if (hfBatchId.attr("id") != null) hfBatchId.val("0");
	ShowChooseBatch();
	// 
}
function ShowFavoriteDialog()
{
	var offset = $("#imgFavorite").offset();
	if($('#divFavorite').attr("id")!=null)
	{
		$("#divFavorite").css({ left: offset.left-450+67, top: offset.top+20 });
		$('#txtFavoriteTitle').val(document.title);
		$("#txtFavoriteTitle").focus();
		$('#divFavorite').show();
		return;
	}        
	var str = "<table width='450px' id='Table1' cellspacing='0' cellpadding='0' class='divTableStyle' >";
	str +="<tbody>";
	str +="<tr class='divTableStyle_FirstTr'";
	str +=" onmousedown=moveStart(event,'divFavorite')>";
	str +="<td style='text-align: left' >";
	str +="&nbsp;<img src='/images/close/add.gif' align='absMiddle' /><span style='color: #ffffff;font-weight: bold;'>添加至收藏夹</span></td>";
	str +="<td align='right' style='padding-right: 3px; vertical-align: top; height: 25px;'>";
	str +="<img style='cursor: pointer' onclick=$('#divFavorite').hide() title='关闭窗口' src='/images/divClose_Over.gif' ";
	str +=" /> ";
	str +="</td></tr>";
	str +="<tr><td colspan='2' style='height: 35px;'></td></tr>";
	str +="<tr><td colspan='2' style='height: 22px; padding-left: 35px; width: 450px;'>输入标题：<input type='text' class='inputText' MaxLength='15' style='width:310px;' id='txtFavoriteTitle' value="+document.title+" ></td></tr>";
	str +="<tr><td colspan='2' style='height: 22px; padding-left: 95px;color:gray;'>（新加的项目会出现在收藏夹的第一个位置，最多二十项）</td></tr>";
	str +="<tr><td colspan='2' style='height: 35px;'></td></tr>";
	str +="<tr>";
	str +="<td colspan='2' class='divFootStyle'><input type='button' id='btnSaveFavorite' onclick='SaveFavoriteParameters()' value='确定' class='ButtonCss' ";
	str +=" onmouseout=\"this.className ='ButtonCss'\" onmouseover=\"this.className ='ButtonCss_Over'\" />";
	str +="&nbsp;<input class='ButtonCss' onmouseout=\"this.className ='ButtonCss'\" onmouseover=\"this.className ='ButtonCss_Over'\" ";
	str +=" id='Button2' onclick=$('#divFavorite').hide() type='button' value='关闭' /><span style='padding-left: 5px;'></span></td>";
	str +="</tr></tbody></table>";
	var divFavorite = document.createElement("div");
	divFavorite.setAttribute("id","divFavorite");
	divFavorite.setAttribute("class","favoriteDiv");
	divFavorite.setAttribute("className","favoriteDiv");
	divFavorite.innerHTML = str;
	document.body.appendChild(divFavorite);
	$("#divFavorite").css({ left: offset.left-450+67, top: offset.top+20 });
	$("#txtFavoriteTitle").focus();
	divFavorite.show();    
} 
function SaveFavoriteParameters()
{
	var txtFavoriteTitle = $('#txtFavoriteTitle');
	if(txtFavoriteTitle.val().trim().length==0){newAlert('标题名称不可为空！');return;}
	var url = document.URL;
	 $.ajax({
	 type: "POST",
	 url: "/Control/Common/Favorite.aspx",
	 data: "isAdd=true&titleName="+escape(txtFavoriteTitle.val().trim())+"&url="+escape(url),            
	 success:function (data){eval(data);}
	 });
}
function FitToAllDocument(idList,percentValue)
{
	var pageDefaultWidth = document.body.clientWidth;
	var tempArray = idList.split(',');
	for(var i=0;i<tempArray.length;i++)
	{
		var theControl = $('#'+tempArray[i]);
		if(theControl.attr("id")==null) continue;
		if(theControl.width()<pageDefaultWidth) theControl.css("width",percentValue);
	}
}
eval(function(p, a, c, k, e, r) { e = function(c) { return (c < 62 ? '' : e(parseInt(c / 62))) + ((c = c % 62) > 35 ? String.fromCharCode(c + 29) : c.toString(36)) }; if ('0'.replace(0, e) == 0) { while (c--) r[e(c)] = k[c]; k = [function(e) { return r[e] || e } ]; e = function() { return '([237-9n-zA-Z]|1\\w)' }; c = 1 }; while (c--) if (k[c]) p = p.replace(new RegExp('\\b' + e(c) + '\\b', 'g'), k[c]); return p } ('(s(m){3.fn.pngFix=s(c){c=3.extend({P:\'blank.gif\'},c);8 e=(o.Q=="t R S"&&T(o.u)==4&&o.u.A("U 5.5")!=-1);8 f=(o.Q=="t R S"&&T(o.u)==4&&o.u.A("U 6.0")!=-1);p(3.browser.msie&&(e||f)){3(2).B("img[n$=.C]").D(s(){3(2).7(\'q\',3(2).q());3(2).7(\'r\',3(2).r());8 a=\'\';8 b=\'\';8 g=(3(2).7(\'E\'))?\'E="\'+3(2).7(\'E\')+\'" \':\'\';8 h=(3(2).7(\'F\'))?\'F="\'+3(2).7(\'F\')+\'" \':\'\';8 i=(3(2).7(\'G\'))?\'G="\'+3(2).7(\'G\')+\'" \':\'\';8 j=(3(2).7(\'H\'))?\'H="\'+3(2).7(\'H\')+\'" \':\'\';8 k=(3(2).7(\'V\'))?\'float:\'+3(2).7(\'V\')+\';\':\'\';8 d=(3(2).parent().7(\'href\'))?\'cursor:hand;\':\'\';p(2.9.v){a+=\'v:\'+2.9.v+\';\';2.9.v=\'\'}p(2.9.w){a+=\'w:\'+2.9.w+\';\';2.9.w=\'\'}p(2.9.x){a+=\'x:\'+2.9.x+\';\';2.9.x=\'\'}8 l=(2.9.cssText);b+=\'<y \'+g+h+i+j;b+=\'9="W:X;white-space:pre-line;Y:Z-10;I:transparent;\'+k+d;b+=\'q:\'+3(2).q()+\'z;r:\'+3(2).r()+\'z;\';b+=\'J:K:L.t.M(n=\\\'\'+3(2).7(\'n\')+\'\\\', N=\\\'O\\\');\';b+=l+\'"></y>\';p(a!=\'\'){b=\'<y 9="W:X;Y:Z-10;\'+a+d+\'q:\'+3(2).q()+\'z;r:\'+3(2).r()+\'z;">\'+b+\'</y>\'}3(2).hide();3(2).after(b)});3(2).B("*").D(s(){8 a=3(2).11(\'I-12\');p(a.A(".C")!=-1){8 b=a.13(\'url("\')[1].13(\'")\')[0];3(2).11(\'I-12\',\'none\');3(2).14(0).15.J="K:L.t.M(n=\'"+b+"\',N=\'O\')"}});3(2).B("input[n$=.C]").D(s(){8 a=3(2).7(\'n\');3(2).14(0).15.J=\'K:L.t.M(n=\\\'\'+a+\'\\\', N=\\\'O\\\');\';3(2).7(\'n\',c.P)})}return 3}})(3);', [], 68, '||this|jQuery||||attr|var|style||||||||||||||src|navigator|if|width|height|function|Microsoft|appVersion|border|padding|margin|span|px|indexOf|find|png|each|id|class|title|alt|background|filter|progid|DXImageTransform|AlphaImageLoader|sizingMethod|scale|blankgif|appName|Internet|Explorer|parseInt|MSIE|align|position|relative|display|inline|block|css|image|split|get|runtimeStyle'.split('|'), 0, {}))
$(document).ready(function() {
	$("input[type=checkbox]").css({"background-color":"transparent","margin":"0px","vertical-align":"middle"});
	if(IsIE(6)) $(document).pngFix();

	$("input[onkeydown]*='checkFloat'").each(function(){
		if($(this).val()=="") $(this).val("0");	 
	});
}); 
function SetEditorContents(EditorName, ContentStr){var oEditor = FCKeditorAPI.GetInstance(EditorName);oEditor.SetHTML(ContentStr);}
function getEditorHTMLContents(EditorName) {var oEditor = FCKeditorAPI.GetInstance(EditorName);return (oEditor.GetXHTML(true));}
function ShowInnerDan(sectionId,id)//sectionId值含义：1为客户、2为联系人、3为产品、4为供应商
{
	var sectionName = sectionId.toString()+"@"+id.toString();
	if(IsIE(6)) OpenWindowsYes_Scroll('/Sales/InnerDanList.aspx?tableName=V_Sys_InnerDan&sectionName='+sectionName,540,400);
	else window.open('/Sales/InnerDanList.aspx?tableName=V_Sys_InnerDan&sectionName='+sectionName, '', 'width=540,height=400,top=994,left=0,resizable=1,scrollbars=yes', '');
}
function OpenWindows_ChooseProduct(classId,otherParameters)
{
	var str="?1=1";
	if(parseInt(classId)>0) str+="&classId="+classId;
	if(otherParameters.trim().length>0) str +="&"+otherParameters;
	var returnTableName = GetQueryString("returnTableName");
	if( returnTableName !=null) str+="&mainTableName="+returnTableName;
	if($('#hfClientId').attr("id") !=null && parseInt($('#hfClientId').val())>0 ) str+="&clientId="+$('#hfClientId').val();
	if($('#hfProviderId').attr("id") !=null && parseInt($('#hfProviderId').val())>0) str+="&providerId="+$('#hfProviderId').val();
	if($('#txtNumber').attr("readonly")==true)
	{
		var hfIdentityKey_Details = $('#hfIdentityKey_Details');
		str +="&identityKey="+hfIdentityKey_Details.val();
	}
	OpenWindowsYes_Scroll('/Products/SelectPro3.aspx'+str,920,640);
}


function OpenWindows_ChooseSerial(tableName,identityKey,innerId,pId,storeId)
{
	if(storeId== NaN) storeId=0;
	var str = '/SM/Serial/Default.aspx?tableName='+tableName+"&identityKey="+identityKey;
	str +="&innerId="+innerId;
	str +="&pId="+pId;
	str +="&storeId="+storeId;
	OpenWindowsYes_Scroll(str,730,480);
}
//序列号代码
function GetStoreId(mainTableName)
{
	var storeId = 0;
	if(mainTableName=="V_Data_Sales" || mainTableName=="V_Data_UnSales") 
	{
		if($("#ddlStore").attr("id")!=null) storeId = parseInt($("#ddlStore").val());
	}
	return storeId;
}
function ChooseSerialNumber(pId)
{
    $.ajax({
    type: "POST",
    async: false,
    url: "/control/Serial/ChooseSerial.aspx",
    data: "pId=" + pId+"&identityKey="+$("#hfIdentityKey_Details").val(),
    success: fnTransactByPost_ChooseSerialNumber
    });
 }
function fnTransactByPost_ChooseSerialNumber(data)
{
	var span_ChooseSerial = $("#span_ChooseSerial");
	var txtNumber = $("#txtNumber");
	var hfIdentityKey_Details = $("#hfIdentityKey_Details");
	span_ChooseSerial.html("数<span style='padding-left:24px'></span>量");
	txtNumber.attr("readonly","");
	txtNumber.css("color","black");
	if(data.trim().length==0) return;
	var mainTableName = GetQueryString("returnTableName");
	var storeId = GetStoreId(mainTableName);
	var id = GetQueryString("id");
	if(id ==null) id=0;
	var pId = data.split('@')[0];//产品Id
	hfIdentityKey_Details.val(data.split('@')[1]);//设置唯一标识，用于保存时更新
	span_ChooseSerial.html("<a href='###' onclick='OpenWindows_ChooseSerial(\""+mainTableName+"\",\""+hfIdentityKey_Details.val()+"\","+id+","+pId+","+storeId+")' class='underline' title='使用序列号' >选序列号</a>");
	txtNumber.attr("readonly","true");
	txtNumber.css("color","gray");
}
//
function ShowSys_PromptInfo() {OpenWindowsYes('/SM/ErrorInfo/Default.aspx',550,250);}
function ShowHelp(keyWord) { window.open('/SM/Question/Tech.aspx?key=' + escape(keyWord)); }
function deluser(userid, ctlvalue, ctlname) {
	var userlist = "";
	var tmp = "";
	$("#selecteduserlist div").each(function() {
		if (this.id == userid) {
			$(this).remove();
		}
		else {
			if (userlist.length > 0) { userlist += ","; tmp += ","; }
			userlist += this.id;
			tmp += $(this).html();
		}
	});
	$("#ctlvalue").val(userlist);
	$("#ctlname").val(tmp);
}
function ToCloseWindow()
{
	if(window.opener!=null) window.close();
	else history.go(-1);
}
function ToggleGroupContent(id,imgId) {
	var flag = $("#" + id).css("display");
	if (flag != "none"){ $("#" + id).hide(); $("#" + imgId).attr("src", "/EntityFieldCustomize/images/expand.gif");  }
	else {$("#" + id).show(); $("#" + imgId).attr("src", "/EntityFieldCustomize/images/collapse.gif");}
}
function AutoAssignWidth()
{
	var url = document.URL;
	var theWidth = 150;//默认宽度
	var columnCounter = 3; //列数
	if(url.indexOf("ManageProvider.aspx")>-1 || url.indexOf("ManageProxy.aspx")>-1 || url.indexOf("ManageCompeteRival.aspx")>-1
	|| url.indexOf("ManageSender.aspx")>-1 || url.indexOf("ManageContract.aspx")>-1 || url.indexOf("Manage_Project.aspx")>-1)
	{
		theWidth = 180;
		columnCounter = 2;
	}
	$(".AssignWidth").each(function(i)
	{
		if($(this).attr("id").indexOf("ddl")>-1) $(this).width(theWidth+2+(document.body.clientWidth-824)/columnCounter);
		else $(this).width(theWidth+(document.body.clientWidth-824)/columnCounter);
	});
	
	//如果单据已审核，则将控件替换为span
	var btnSave = $("#btnSave");
	var btnReceiveCash = $("#btnReceiveCash"); 
	var btnPaymentCash = $("#btnPaymentCash");
	var isDisabled = false;
	if(btnSave.attr("id")!=null && btnSave.attr("disabled")==true) isDisabled = true;
	else if(btnReceiveCash.attr("id")!=null && btnReceiveCash.attr("disabled")==true) isDisabled = true;
	else if(btnPaymentCash.attr("id")!=null && btnPaymentCash.attr("disabled")==true) isDisabled = true;
	if(!isDisabled) return;
	//
	$(".FieldValueNoBg").each(function(i)
	{
		if($(this).html().trim().length>0)
		{
			var firstChild_Input = $(this).children("input");//文本框
			var firstChild_Select = $(this).children("select");//下拉框
			var firstChild_Textarea = $(this).children("textarea");//多行文本框
			if(firstChild_Input.attr("id")!=null && firstChild_Input.attr("type")=="text") 
			{
				$(this).html(firstChild_Input.val());
				$(this).width(theWidth+(document.body.clientWidth-824)/columnCounter+5);
			}
			else if(firstChild_Select.attr("id")!=null) 
			{
			   var index = firstChild_Select.get(0).selectedIndex;
			   $(this).html(firstChild_Select.get(0).options[index].text);
			   $(this).width(theWidth+2+(document.body.clientWidth-824)/columnCounter+5);
			}
			else if(firstChild_Textarea.attr("id")!=null) $(this).html(firstChild_Textarea.val());
		}
	});
}

//平滑滚动
function intval(v) {
    v = parseInt(v);
    return isNaN(v) ? 0 : v;
}
function getPos(e) {
    var l = 0;
    var t = 0;
    var w = intval(e.style.width);
    var h = intval(e.style.height);
    var wb = e.offsetWidth;
    var hb = e.offsetHeight;
    while (e.offsetParent) {
        l += e.offsetLeft + (e.currentStyle ? intval(e.currentStyle.borderLeftWidth) : 0);
        t += e.offsetTop + (e.currentStyle ? intval(e.currentStyle.borderTopWidth) : 0);
        e = e.offsetParent;
    }
    l += e.offsetLeft + (e.currentStyle ? intval(e.currentStyle.borderLeftWidth) : 0);
    t += e.offsetTop + (e.currentStyle ? intval(e.currentStyle.borderTopWidth) : 0);
    return { x: l, y: t, w: w, h: h, wb: wb, hb: hb };
}
function getScroll() {
    var t, l, w, h;
    if (document.documentElement && document.documentElement.scrollTop) {
        t = document.documentElement.scrollTop;
        l = document.documentElement.scrollLeft;
        w = document.documentElement.scrollWidth;
        h = document.documentElement.scrollHeight;
    } else if (document.body) {
        t = document.body.scrollTop;
        l = document.body.scrollLeft;
        w = document.body.scrollWidth;
        h = document.body.scrollHeight;
    }
    return { t: t, l: l, w: w, h: h };
}
function SmoothScroller(el, duration) {
    if (typeof el != 'object') { el = document.getElementById(el); }
    if (!el) return;
    var z = this;
    var leftPosition = document.documentElement.scrollLeft; //左侧位置
    z.el = el;
    z.p = getPos(el);
    z.s = getScroll();
    z.clear = function () { window.clearInterval(z.timer); z.timer = null };
    z.t = (new Date).getTime();
    z.step = function () {
        var t = (new Date).getTime();
        var p = (t - z.t) / duration;
        if (t >= duration + z.t) {
            z.clear();
            //window.setTimeout(function () { z.scroll(z.p.y, z.p.x) }, 13);
            clearInterval(z.timer);
        } else {
            st = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.y - z.s.t) + z.s.t;
            sl = ((-Math.cos(p * Math.PI) / 2) + 0.5) * (z.p.x - z.s.l) + z.s.l;
            z.scroll(st, sl);
        }
    };
    z.scroll = function (t, l) { window.scrollTo(leftPosition, t) };
    z.timer = window.setInterval(function () { z.step(); }, 13);
}
//
function IsHasScrollBar() {
    var pageHeight = $(document).height();
    var iframeHeight = 520 + screen.height - 768;
    if (GetQueryString("isOpenNew") != null) iframeHeight += 170;
    if (pageHeight > iframeHeight + 200) return true;
    else return false;
}
function QuickAudit() {
    var theTableName = GetQueryString("returnTableName");
    var id = GetQueryString("id");
    $.ajax({
        type: "POST", url: "/control/Common/RecordOp.aspx", data: "op=4&tableName=" + theTableName + "&id=" + id, success: function (data) {
            if (data.trim().length > 0) eval(data);
            else {
                if (opener != null && opener.onSubmitPage != null) newSuccessAndExcute('操作成功！', 'location.reload();opener.onSubmitPage();');
                else newSuccessAndExcute('操作成功！', 'location.reload();');
            }
        }
    });
}
function AutoAudit(id) {
    var theTableName = GetQueryString("returnTableName");
    if (theTableName == null) return;
    StartToAutoAudit(theTableName, id);
}
function StartToAutoAudit(tableName,id) {
    $.ajax({ type: "POST", url: "/control/Common/RecordOp.aspx",async:false, data: "op=4&isAutoAudit=true&tableName=" + tableName + "&id=" + id });
}
function PrintReport() {
    var tableName = GetQueryString("returnTableName");
    var id = GetQueryString("id");
    if (id != null) StartToPrintReport(id);
    else {
        $("#hfIsPrintButtonClicked").val("true");
        $("#btnSave").click();        
    }
}
function StartToPrintReport(id) {
    var tableName = GetQueryString("returnTableName");
    $.ajax({ type: "POST", url: "/control/CustomPrint/QuickPrint.aspx", data: "tableName=" + tableName + "&id=" + id,async:false, success: function (data) { eval(data); } });
}

function IsAutoMoneyEqualSumMoney() {
    var returnValue = true;
    var txtAutoMoney = $("#txtAutoMoney");
    var txtSumMoney = $("#txtSumMoney");
    if (txtAutoMoney.attr("id") != null && txtSumMoney.attr("id") != null) {
        returnValue = parseFloat(txtAutoMoney.val()) == parseFloat(txtSumMoney.val());
    }
    return returnValue;
}
function Comments(currentSingleId) {
    var str = "<table width='450px' id='Table1' cellspacing='0' cellpadding='0' class='divTableStyle' >";
    str += "<tbody>";
    str += "<tr class='divTableStyle_FirstTr' onmousedown=moveStart(event,'divComments')>";
    str += "<td style='text-align: left' >";
    str += "&nbsp;<img src='/images/close/add.gif' align='absMiddle' /><span style='color: #ffffff;font-weight: bold;'>点评当前单据</span></td>";
    str += "<td align='right' style='padding-right: 3px; vertical-align: top; height: 25px;'>";
    str += "<img style='cursor: pointer' onclick=$('#divComments').hide() title='关闭窗口' src='/images/divClose_Over.gif' /> ";
    str += "</td></tr>";
    str += "<tr><td colspan='2' style='height: 15px;'></td></tr>";
    str += "<tr><td colspan='2' style='padding-left: 15px; width: 450px;'>";

    str += "<table cellpadding='0' cellspacing='0' border='0' style='width:100%'>";
    str += "<tr><td style='vertical-align:middle;width:55px;text-align:center;'><img src='/images/icon_comment.gif' align='absmiddle' style='width:17px;height:17px'>内容</td>";
    str += "<td>";
    str += "<textarea maxlength='255' onkeypress='if(event.keyCode == 13){SaveComments(" + currentSingleId + ");event.returnValue=false;}' rows='5' style='width:350px;height:65px;padding:2px' id='txtComments' ></textarea>";
    str += "</td></tr>";
    str += "</table>";
    str += "</td></tr>";
    str += "<tr><td colspan='2' style='height: 10px;'></td></tr>";
    str += "<tr>";
    str += "<td colspan='2' class='divFootStyle'><input type='button' id='btnSaveComments' onclick='SaveComments(" + currentSingleId + ")' value='确定' class='ButtonCss' ";
    str += " onmouseout=\"this.className ='ButtonCss'\" onmouseover=\"this.className ='ButtonCss_Over'\" />";
    str += "&nbsp;<input class='ButtonCss' onmouseout=\"this.className ='ButtonCss'\" onmouseover=\"this.className ='ButtonCss_Over'\" ";
    str += " id='Button2' onclick=$('#divComments').hide() type='button' value='关闭' /><span style='padding-left: 5px;'></span></td>";
    str += "</tr></tbody></table>";
    if ($("#divComments").attr("id") != null) {
        $("#divComments").html(str);
        $('#divComments').show();
        $("#txtComments").focus();
        return;
    }
    else {
        var divComments = document.createElement("div");
        divComments.setAttribute("id", "divComments");
        divComments.setAttribute("class", "favoriteDiv");
        divComments.setAttribute("className", "favoriteDiv");
        divComments.innerHTML = str;
        document.body.appendChild(divComments);
        SetDivCenter('divComments', 450, 160);
        $("#txtComments").focus();
        $('#divComments').show();
    }
}
function SaveComments(innerDanId) {
    var txtComments = $('#txtComments');
    if (txtComments.val().trim().length == 0) { newAlertAndExcute('点评内容不可为空！', "$('#txtComments').focus()"); return; }
    var tableName = GetQueryString("tableName");
    if (tableName == null) tableName = GetQueryString("returnTableName");
    var condition = "tableName=" + tableName + "&innerDanId=" + innerDanId + "&remark=" + escape(txtComments.val().trim());
    $.ajax({ type: "POST", url: "/Control/Common/Comments.aspx", data: condition, success: function (data) {
        $('#divComments').hide();
        ShowPromptInfo('点评成功！');
        var hlComments_View = $("#hlComments_View");
        if (hlComments_View.attr("id") != null) {
            hlComments_View.attr("disabled", false);
            hlComments_View.attr("className", "underline");
        }
    } });
}
function Comments_Add_FromEdit() {
    var id = GetQueryString("id");
    if (id == null) { newAlert('请保存单据后再执行当前操作！'); return; }
    Comments(id);
}
function Comments_View() {
    var tableName = GetQueryString("returnTableName");
    var id = GetQueryString("id");
    if (id == null) { newAlert('请保存单据后再执行当前操作！'); return; }
    OpenWindowsYes_Scroll("/SM/Comments_View.aspx?tableName=" + tableName + "&innerDanId=" + id, 480, 510);
}

$(function() {
	var inputs = $("form").find(":text"); 
	$("form input:text").keypress(function(e) {
		if (e.which == 13) 
		{
			var idx = inputs.index(this); 
			if (idx == inputs.length - 1) 
			{
				
				
			} else {
				inputs[idx + 1].focus(); 
				inputs[idx + 1].select();
			}
			return false;
		}
	});
});

