<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>控制面板 -设置关联下拉框选项- {$APP.LBL_BROWSER_TITLE}</title>
<meta http-equiv="Content-Type" content="text/html; charset="UTF-8">
<link href="themes/softed/style.css" rel="stylesheet" type="text/css"></link>
<script language="JavaScript" type="text/javascript" src="include/js/zh_cn.lang.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/general.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/prototypeall.js"></script>
<script language="javascript" type="text/javascript" src="include/scriptaculous/dom-drag.js"></script>
</head>
<body leftmargin=0 topmargin=0 marginheight=0 marginwidth=0 class=small>	
<style type="text/css">
a.x {ldelim}
		color:black;
		text-align:center;
		text-decoration:none;
		padding:5px;
		font-weight:bold;
{rdelim}
	
a.x:hover {ldelim}
		color:#333333;
		text-decoration:underline;
		font-weight:bold;
{rdelim}

ul {ldelim}color:black;{rdelim}	 
	
.drag_Element{ldelim}
	position:relative;
	left:0px;
	top:0px;
	padding-left:5px;
	padding-right:5px;
	border:0px dashed #CCCCCC;
	visibility:hidden;
{rdelim}

#Drag_content{ldelim}
	position:absolute;
	left:0px;
	top:0px;
	padding-left:5px;
	padding-right:5px;
	background-color:#000066;
	color:#FFFFFF;
	border:1px solid #CCCCCC;
	font-weight:bold;
	display:none;
{rdelim}
</style>
<script>
 
   function displayCoords(event) 
	 {ldelim}
				var move_Element = document.getElementById('Drag_content').style;
				if(!event){ldelim}
						move_Element.left = e.pageX +'px' ;
						move_Element.top = e.pageY+10 + 'px';	
				{rdelim}
				else{ldelim}
						move_Element.left = event.clientX +'px' ;
					    move_Element.top = event.clientY+10 + 'px';	
				{rdelim}
	{rdelim}
  
	  function fnRevert(e)
	  {ldelim}
		  	if(e.button == 2){ldelim}
				document.getElementById('Drag_content').style.display = 'none';
				hideAll = false;
				parentId = "Head";
	    		parentName = "DEPARTMENTS";
			    childId ="NULL";
	    		childName = "NULL";
			{rdelim}
	{rdelim}
    {literal}
        function gotoNextLevel(multifieldid,level,totallevel,parentfieldid)
        {
            var nextlevel=level+1;
            if(nextlevel>totallevel) return;
            window.location.href="index.php?action=PopupMultiFieldTree&module=Settings&multifieldid="+multifieldid+"&level="+nextlevel+"&parentfieldid="+parentfieldid;
        }

        function gotoPreviousLevel(multifieldid,level,parentfieldid)
        {
            var previouslevel=level-1;
            if(previouslevel==0) return;
            window.location.href="index.php?action=PopupMultiFieldTree&module=Settings&multifieldid="+multifieldid+"&level="+previouslevel+"&parentfieldid="+parentfieldid;
        }

        function deleteFieldNode(actualfieldid,multifieldid,level,parentfieldid)
        {
            if(confirm(alert_arr.SURE_TO_DELETE))
            {
                window.location.href="index.php?module=Settings&action=DeleteMultiFieldNode&catalogid="+actualfieldid+"&multifieldid="+multifieldid+"&level="+level+"&parentfieldid="+parentfieldid;
            }
        }
    {/literal}
</script>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopLeft.gif"></td>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	<div align=left>
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<tr>
					<td class=heading2 valign=bottom><b>设置关联下拉框选项</b></td>
				</tr>
				<tr>
					<td valign=top class="small">使用帮助：把鼠标放在某个下拉框选项上，旁边会出现添加下拉框选项,编辑下拉框选项和删除下拉框选项的图标，点击相应图标可以维护关联下拉框选项信息。</td>
				</tr>
				</table>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
					<div id='CatalogTreeFull'  onMouseMove="displayCoords(event)"> 
                			        {include file='Settings/MultiFieldTree.tpl'}
		                	</div>
				</td>
				</tr>
				</table>	
	</div>

</td>
        <td valign="top"><img src="{$IMAGE_PATH}showPanelTopRight.gif"></td>
   </tr>
</tbody>
</table>

<table border=0 cellspacing=0 cellpadding=10 width=100% >
<tr>

<td class="small" align="right">
    <input type="button" name="Edit" value="保存" class="crmButton small create" onclick="window.opener.reloadOptions({$MULTIFIELDID});window.close();">
</td>
<td class="small" width=50%>&nbsp;</td>

</tr>
</table>

<div id="Drag_content">&nbsp;</div>

<script language="javascript" type="text/javascript">
	var hideAll = false;
	var parentId = "";
	var parentName = "";
	var childId ="NULL";
	var childName = "NULL";

		
	
	 function get_parent_ID(obj,currObj)
	 {ldelim}
			var leftSide = findPosX(obj);
    			var topSide = findPosY(obj);
			var move_Element = document.getElementById('Drag_content');
		 	childName  = document.getElementById(currObj).innerHTML;
			childId = currObj;
			move_Element.innerHTML = childName;
			move_Element.style.left = leftSide + 15 + 'px';
			move_Element.style.top = topSide + 15+ 'px';
			move_Element.style.display = 'block';
			hideAll = true;	
	{rdelim}
	
	function put_child_ID(currObj)
	{ldelim}
			var move_Element = $('Drag_content');
	 		parentName  = $(currObj).innerHTML;
			parentId = currObj;
			move_Element.style.display = 'none';
			hideAll = false;	
			if(childId == "NULL")
			{ldelim}
//				alert(alert_arr.SELECT_PARENT_OR_SUBCATALOG);
				parentId = parentId.replace(/user_/gi,'');
				window.location.href="index.php?module=Catalogs&action=CatalogDetailView&parenttab=Product&catalogid="+parentId;
			{rdelim}
			else
			{ldelim}
				childId = childId.replace(/user_/gi,'');
				parentId = parentId.replace(/user_/gi,'');
				new Ajax.Request(
  					'index.php',
				        {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
					        method: 'post',
					        postBody: 'module=Catalogs&action=CatalogsAjax&file=DragDrop&ajax=true&parentId='+parentId+'&childId='+childId,
						onComplete: function(response) {ldelim}
							if(response.responseText != 'You cannot move a Parent Node under a Child Node')
							{ldelim}
						                $('CatalogTreeFull').innerHTML=response.responseText;
						                hideAll = false;
							        parentId = "";
						                parentName = "";
						                childId ="NULL";
								childName = "NULL";
						        {rdelim}
						        else
						                alert(response.responseText);
			                        {rdelim}
				        {rdelim}
				);
			{rdelim}
	{rdelim}

	function fnVisible(Obj)
	{ldelim}
			if(!hideAll)
				document.getElementById(Obj).style.visibility = 'visible';
	{rdelim}

	function fnInVisible(Obj)
	{ldelim}
		document.getElementById(Obj).style.visibility = 'hidden';
	{rdelim}

	


function showhide(argg,imgId)
{ldelim}
	var harray=argg.split(",");
	var harrlen = harray.length;	
	var i;
	for(i=0; i<harrlen; i++)
	{ldelim}
		var x=document.getElementById(harray[i]).style;
        	if (x.display=="none")
        	{ldelim}
           		x.display="block";
			document.getElementById(imgId).src="{$IMAGE_PATH}minus.gif";
         	{rdelim}
        	else
		{ldelim}
			x.display="none";
			document.getElementById(imgId).src="{$IMAGE_PATH}plus.gif";
		{rdelim}
	{rdelim}
{rdelim}



</script>
</body>
</html>