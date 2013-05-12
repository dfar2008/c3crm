{*<!--
/*********************************************************************************
  ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
  *
 ********************************************************************************/
-->*}
<script language="JAVASCRIPT" type="text/javascript" src="include/js/smoothscroll.js"></script>
<script language="JavaScript" type="text/javascript" src="include/js/menu.js"></script>

<script language="JavaScript" type="text/javascript">
    var allOptions = null;

    function setAllOptions(inputOptions) 
    {ldelim}
        allOptions = inputOptions;
    {rdelim}

    function modifyMergeFieldSelect(cause, effect) 
    {ldelim}
        var selected = cause.options[cause.selectedIndex].value;  id="mergeFieldValue"
        var s = allOptions[cause.selectedIndex];
            
        effect.length = s;
        for (var i = 0; i < s; i++) 
	{ldelim}
            effect.options[i] = s[i];
        {rdelim}
        document.getElementById('mergeFieldValue').value = '';
    {rdelim}
    

   function typeSave()
   {ldelim}
	var value1 = $F("TemplateType");
	if(value1 == 0 || value1 == "") {ldelim}
             alert("请先选择模块和模板");
	     return ;
        {rdelim}
	oEditor=FCKeditorAPI.GetInstance('body');
	//console.log(oEditor);
	var value2= oEditor.GetXHTML(true);
      // alert(value2);
     new Ajax.Request(
		  'index.php',
		  {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
					method: 'post',
					postBody:"module=Settings&action=SettingsAjax&file=savePrintTemplate&type="+encodeURIComponent(value1)+"&content="+encodeURIComponent(value2),
					onComplete: function(response) {ldelim}
							var result = response.responseText;
							alert(result);
							
							
					{rdelim}
			 {rdelim}
    );
       
   {rdelim}

   function typeChoose(value)
   {ldelim}
     if(value == 0 || value == "") {ldelim}
         oEditor=FCKeditorAPI.GetInstance('body');							
         oEditor.SetHTML("") ;
	 return ;
     {rdelim}
     new Ajax.Request(
		  'index.php',
		  {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
					method: 'post',
					postBody:"module=Settings&action=SettingsAjax&file=getPrintTemplate&type="+encodeURIComponent(value),
					onComplete: function(response) {ldelim}
							var result = response.responseText;
							//alert(result);
							oEditor=FCKeditorAPI.GetInstance('body');							
							oEditor.SetHTML(result) ;
                                                        //oEditor=FCKeditorAPI.GetInstance('body');
                                                       // var value3= oFCKeditor.GetXHTML(true);
                                                       // alert(value3);
						       if(value != 0) {ldelim}
						           templatepath = "模板的路径：modules/"+value+".html";
						           $("templatepatch").update(templatepath);
						       {rdelim}
						       else {ldelim}
						           $("templatepatch").update("");
						       {rdelim}
							
					{rdelim}
			 {rdelim}
    );
       
   {rdelim}

   function DefTemplate()
   {ldelim}
        var moduleType = $F('ModuleType');
        var value=$F("TemplateType");
        if(value == 0 || value == "") {ldelim}
             alert("请先选择模块和模板");
	     return ;
        {rdelim}
        new Ajax.Request('index.php',
                          {ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
                          method: 'post',
                          postBody:"module=Settings&action=SettingsAjax&file=DefPrintTemplate&fld_module="+moduleType+"&type="+encodeURIComponent(value),
                          onComplete: function(response)
                          {ldelim}
                            var result = response.responseText;
                            oFCKeditor.SetHTML(result) ;
                          {rdelim}
                        {rdelim}
                        );
   {rdelim}

   function updateTemplateOptions()
   {ldelim}
        var moduleType = $F('ModuleType');
	if(moduleType == 0 || moduleType == "") {ldelim}
		if($('TemplateType')) $('TemplateType').update("<option value=0 selected> {$APP.LBL_NONE} </option>");
	{rdelim}
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
		method: 'post',
		postBody: 'action=SettingsAjax&module=Settings&file=updateTemplateOptions&moduleType='+moduleType,
		onComplete: function(response) {ldelim}
		     var optionval=response.responseText;
		     if($('TemplateType')) $('TemplateType').update(optionval);
		     typeChoose("");
		{rdelim}
	    {rdelim}
	);
 {rdelim}

function CreateTemplate()
{ldelim}
        var moduleType = $F('ModuleType');
	if(moduleType == 0 || moduleType == "") {ldelim}
		alert("请先选择模块");
		return ;
	{rdelim}
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
			method: 'post',
			postBody: 'module=Settings&action=SettingsAjax&file=CreateTemplate&fld_module='+moduleType+'&parenttab=Settings&ajax=true',
			onComplete: function(response) {ldelim}
				$("createtemplate").innerHTML=response.responseText;
				execJS($('blockLayer'));
			{rdelim}
		{rdelim}
	);

{rdelim}

function DeleteTemplate()
{ldelim}
        var templateType = $F('TemplateType');
	var moduleType = $F('ModuleType');
	if(templateType == 0 || templateType == "") {ldelim}
		alert("请先选择模块和模板");
		return ;
	{rdelim}
	if(confirm(alert_arr.ARE_YOU_SURE)) {ldelim}
		new Ajax.Request(
			'index.php',
			{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
				method: 'post',
				postBody: 'module=Settings&action=SettingsAjax&file=DeleteTemplate&fld_module='+moduleType+'&templateType='+templateType+'&parenttab=Settings&ajax=true',
				onComplete: function(response) {ldelim}
					alert("删除成功");
					document.location.href="index.php?module=Settings&action=PrintTemplate&fld_module="+moduleType+"&parenttab=Settings";
				{rdelim}
			{rdelim}
		);
	{rdelim}

{rdelim}

function updateVarOptions()
   {ldelim}
        var ModuleVar = $F('ModuleVar');
	if(ModuleVar == 0 || ModuleVar == "") {ldelim}
		if($('FieldVar')) $('FieldVar').update("<option value=0 selected> {$APP.LBL_NONE} </option>");
	{rdelim}
	new Ajax.Request(
		'index.php',
		{ldelim}queue: {ldelim}position: 'end', scope: 'command'{rdelim},
		method: 'post',
		postBody: 'action=SettingsAjax&module=Settings&file=updateVarOptions&ModuleVar='+ModuleVar,
		onComplete: function(response) {ldelim}
		     var optionval=response.responseText;
		     if($('FieldVar')) $('FieldVar').update(optionval);
		     fieldChoose("");
		{rdelim}
	    {rdelim}
	);
 {rdelim}

 function fieldChoose(value)
 {ldelim}							
	if(value != 0) {ldelim}
	     //value = "打印变量：" + value;
	     $("varfieldinfo").value = value;
	{rdelim}
	else {ldelim}
	     //$("varfieldinfo").update("");
	     $("varfieldinfo").value = "";
	{rdelim}
  {rdelim}       
</script>


  
<div id="createtemplate" style="display:block;position:absolute;width:300px;"></div>
<br>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="98%">
<tbody><tr>
        <td class="showPanelBg" style="padding: 10px;" valign="top" width="100%">
	<div align=center>
	
			{include file='SetMenu.tpl'}
				<!-- DISPLAY -->
				<table border=0 cellspacing=0 cellpadding=5 width=100% class="settingsSelUITopLine">
				<form action="index.php" method="post" name="templatecreate" onsubmit="return check4null();">  
				<input type="hidden" name="action">
				<input type="hidden" name="mode" value="{$EMODE}">
				<input type="hidden" name="module" value="Settings">
				<input type="hidden" name="templateid" value="{$TEMPLATEID}">
				<input type="hidden" name="parenttab" value="PARENTTAB}">
				<tr>
					<td width=50 rowspan=2 valign=top><img src="{$IMAGE_PATH}printtemplate.gif" alt="Users" width="45" height="60" border=0 title="Users"></td>
					<td class=heading2 valign=bottom><b><a href="index.php?module=Settings&action=index&parenttab=Settings">{$MOD.LBL_SETTINGS}</a> > 打印模板定制 </b></td>
				</tr>
				<tr>
					<td valign=top class="small">    </td>
				</tr>
				</table>
				
				<br>
				<table border=0 cellspacing=0 cellpadding=10 width=100% >
				<tr>
				<td>
				
					<table border=0 cellspacing=0 cellpadding=5 width=100% class="tableHeading">
					<tr>
						<td class="small" align=left>
							<input type="button" value="{$APP.LBL_SAVE_BUTTON_LABEL}" class="crmButton small save" onclick="typeSave();" />
                                                        <input type="button" value="恢复默认模板" class="crmButton small save" onclick="DefTemplate();" >
							<input type="button" value="新增模板" class="crmButton small save" onclick="fnvshobj(this,'createtemplate');CreateTemplate();" >
							<input type="button" value="删除模板" class="crmButton small save" onclick="DeleteTemplate();" >
						</td>
					</tr>
					</table>
					
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
					  <td colspan="2" valign=top class="cellText small"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="thickBorder">
                        <tr>
                          <td valign=top><table width="100%"  border="0" cellspacing="0" cellpadding="5" >
                              <tr>
                                <td colspan="3" valign="top" class="small" style="background-color:#cccccc"><strong>打印模板定制</strong></td>
                                </tr>

			    <tr>
			        <td width="10%" valign="top" class="cellLabel small">模板选择</td>
                                <td colspan="3" valign="top" class="small">
				<table width="100%"  border="0" cellspacing="0" cellpadding="5" >

				<tr><td><select id="ModuleType" name="ModuleType" onchange="javascript:updateTemplateOptions();">
                                             <option value=0 selected> {$APP.LBL_NONE} </option>
					     {$PRINTTYPEOPTION}
                                        </select>
					<select id="TemplateType" name="TemplateType" onchange="typeChoose(this.value)">
                                            <option value=0 selected> {$APP.LBL_NONE} </option>					    
                                        </select>					
				     </td>
				     <td><div id="templatepatch"></div></td>
                                  </tr>




                            
                                </table>
                                </td>
                              </tr>


			    
                              <tr>
                                <td valign="top" class="cellLabel small">{$UMOD.LBL_MESSAGE}</td>
                                 <td valign="top" class="cellText small"><p><textarea id="body" name="body" style="width:100%;height:600px" class=small tabindex="5">{$BODY}</textarea></p>
                                    </td>
                                <td valign="top" class="cellText small" style="border-left:2px dotted #cccccc;"></td>
                              </tr>

                          </table></td>
                          
                        </tr>
                      </table></td>
					  </tr>
					</table>


                                        <table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
					  <td colspan="2" valign=top class="cellText small"><table width="100%"  border="0" cellspacing="0" cellpadding="0" class="thickBorder">
                        <tr>
                          <td valign=top><table width="100%"  border="0" cellspacing="0" cellpadding="5" >
                              <tr>
                                <td colspan="10" valign="top" class="small" style="background-color:#cccccc"><strong>模板变量信息</strong></td>
                                </tr>

                        

			

                    


                               <tr>
			        <td width="10%" valign="top" class="cellLabel small">备注</td>
                                <td colspan="3" valign="top" class="small">
				<table width="100%"  border="0" cellspacing="0" cellpadding="5" >
                                     <TR>
                                        <td><a href="http://www.crmone.cn/bbs/viewthread.php?tid=455&extra=page%3D1" target=_black>查询如何定制打印模板</td>
                                     </tr>				     
                                     <tr>
                                        <TD >如果您想调用更多的信息变量，请通过下面的选项选择查看，复制文本框里的打印变量放在打印模板里，打印时将自动替换相应的值。</TD>
                                     </TR>
				     <tr>
				     <td nowrap>
				       模块：
				       <select id="ModuleVar" name="ModuleVar" onchange="javascript:updateVarOptions();">
                                             <option value=0 selected> {$APP.LBL_NONE} </option>
					     <option value="Accounts"> {$APP.Accounts} </option>
					    
					     <option value="Products"> {$APP.Products} </option>
					     {$PRINTTYPEOPTION}
                                        </select>
					<select id="FieldVar" name="FieldVar" onchange="fieldChoose(this.value)">
                                            <option value=0 selected> {$APP.LBL_NONE} </option>					    
                                        </select>
					<input type="text" name="varfieldinfo" id="varfieldinfo" value="" size="50">
				     </td>
				     
                                  </tr>
                                </table>
                                </td>
                               </tr>

                          </table></td>

                        </tr>
                      </table></td>
					  </tr>
					</table>

					<br>
					<table border=0 cellspacing=0 cellpadding=5 width=100% >
					<tr>
					  <td class="small" nowrap align=right><a href="#top">{$MOD.LBL_SCROLL}</a></td>
					</tr>
					</table>
				</td>
				</tr>
				</table>
			
			
			
			</td>
			</tr>
			</table>
		</td>
	</tr>
	</form>
	</table>
		
	</div>

</td>
   </tr>
</tbody>
</table>
<script type="text/javascript" src="include/fckeditor/fckeditor.js"></script>
       <script type="text/javascript" defer="1">
       var oFCKeditor = null;
       oFCKeditor = new FCKeditor( "body","100%","350","Default","Template") ;       
       oFCKeditor.BasePath   = "include/fckeditor/" ;
       oFCKeditor.ReplaceTextarea() ;
       updateTemplateOptions();
</script>
