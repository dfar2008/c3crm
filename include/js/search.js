/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
function searchshowhide(argg,argg2)
{
    var x=document.getElementById(argg).style
    var y=document.getElementById(argg2).style
    if (x.display=="none" && y.display=="none")
    {
        x.display="block";
		x.visibility = "visible";
		y.visibility = "hidden";
		y.display = "none";
   
    }
    else {
	    y.display="none";
        x.display="none";
		x.visibility = "hidden";
		y.visibility = "hidden";
    }
}

 function moveMe(arg1) {
    var posx = 0;
    var posy = 0;
    var e=document.getElementById(arg1);
   
    if (!e) var e = window.event;
   
    if (e.pageX || e.pageY)
    {
        posx = e.pageX;
        posy = e.pageY;
    }
    else if (e.clientX || e.clientY)
    {
        posx = e.clientX + document.body.scrollLeft;
        posy = e.clientY + document.body.scrollTop;
    }
 }
