/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
//added by raju for emails

function eMail(module,oButton)
{
	var select_options  =  document.getElementsByName('selected_id');
	var x = select_options.length;
	var viewid =getviewId();		
	var idstring= new Array();

	xx = 0;
	for(i = 0; i < x ; i++)
	{
		if(select_options[i].checked)
		{
			idstring[xx] = select_options[i].value;
				xx++
		}
	}
	if (xx != 0)
	{
                document.getElementById('idlist').value=idstring.join(':');
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}
	allids = document.getElementById('idlist').value;	
	fnvshobj(oButton,'sendmail_cont');
	sendmail(module,allids);
}


function massMail(module)
{

	var select_options  =  document.getElementsByName('selected_id');
	x = select_options.length;
	var viewid =getviewId();		
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
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}
	document.massdelete.action="index.php?module=CustomView&action=SendMailAction&return_module="+module+"&return_action=index&viewname="+viewid;
}

function massSMS(module)
{
	var select_options  =  document.getElementsByName('selected_id');
	x = select_options.length;
	var viewid =getviewId();		
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
	}
	else
	{
		alert(alert_arr.SELECT);
		return false;
	}
	alert(idstring);
	document.location.href="index.php?module=Messages&action=EditView&return_module="+module+"&return_action=index&viewname="+viewid+"&idstring="+idstring;
}


//added by rdhital for better emails
function set_return_emails(where,parentname,emailadd) {
	if(emailadd != '')
	{
		if(where == '')
		{
			where = "to";
		}
		window.opener.document.form1.elements[where].value = window.opener.document.form1.elements[where].value + parentname+'<'+emailadd+'>; ';
		window.close();
	}else
	{
		alert(alert_arr.DOESNOT_HAVE_AN_MAILID);
		return false;
	}
}	
//added by raju for emails

function validate_sendmail(idlist,module)
{
	var j=0;
	var chk_emails = document.SendMail.elements.length;
	var oFsendmail = document.SendMail.elements
	email_type = new Array();
	for(var i=0 ;i < chk_emails ;i++)
	{
		if(oFsendmail[i].type != 'button')
		{
			if(oFsendmail[i].checked != false)
			{
				email_type [j++]= oFsendmail[i].value;
			}
		}
	}
	if(email_type != '')
	{
		var field_lists = email_type.join(':');
		var url= 'index.php?module=Emails&action=EmailsAjax&pmodule='+module+'&file=EditView&sendmail=true&idlist='+idlist+'&field_lists='+field_lists;
		openPopUp('xComposeEmail',this,url,'createemailWin',820,689,'menubar=no,toolbar=no,location=no,status=no,resizable=no');
		fninvsh('roleLay');
		return true;
	}
	else
	{
		alert(alert_arr.SELECT_MAILID);
	}
}

function sendmail(module,idstrings)
{
        new Ajax.Request(
                'index.php',
                {queue: {position: 'end', scope: 'command'},
                        method: 'post',
                        postBody: "module=Emails&return_module="+module+"&action=EmailsAjax&file=mailSelect&idlist="+idstrings,
                        onComplete: function(response) {
                                        getObj('sendmail_cont').innerHTML=response.responseText;
                        }
                }
        );
}

	
