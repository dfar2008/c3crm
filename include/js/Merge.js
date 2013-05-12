/*********************************************************************************

** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/

//to merge a list of acounts with a template
function massMerge(module)
{
        x = document.massdelete.selected_id.length;
	var viewid = document.massdelete.viewname.value;
        idstring = "";

        if ( x == undefined)
        {

                if (document.massdelete.selected_id.checked)
                {
                        document.massdelete.idlist.value=document.massdelete.selected_id.value;
                }
                else
                {
                			
                        alert(alert_arr.SELECT);
                        return false;
                }
        }
        else
        {
                xx = 0;
                for(i = 0; i < x ; i++)
                {
                        if(document.massdelete.selected_id[i].checked)
                        {
                                idstring = document.massdelete.selected_id[i].value +";"+idstring
                        xx++
                        }
                }
                if (xx != 0)
                {
                        document.massdelete.idlist.value=idstring;
                }
               else
                {
                			
                        alert(alert_arr.SELECT);
                        return false;
                }
        }
        
        if(getObj('selectall').checked == true)
	{
		getObj('idlist').value = getObj('allids').value
	}
	
	if(getObj('mergefile').value == '')
	{
	         alert("请选择一个模版");
           	 return false;   
        }
        document.massdelete.action="index.php?module="+module+"&action=Merge&return_module="+module+"&return_action=index";
}
